<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DailyReconciliationExport;
use App\Exports\MembersExport;
use App\Exports\RedemptionTransactionsExport;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/', 'confirmed'],
            'role' => ['required'],
        ]);

        if (!($validator->fails())) {
            $newUser = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'role' => $request['role'],
                'password' => Hash::make($request['password']),
            ]);
            return redirect()->route('user.management')->with('success','New user created!');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }


    public function delete($id)
    {
        $user = User::find($id)->delete();
        if($user){
            return redirect()->back()->with('success','User deleted !');
        }else{
            return redirect()->back()->with('error','User not deleted !');
        }
    }


    public function report()
    {
        return view('admin.report');
    }

    public function export(Request $request)
    {

        // dd($request->all());

        if($request['report'] == 'customer_record'){
            $validator = Validator::make($request->all(), [
                'report' => ['required'],
            ]);
    
            if (!($validator->fails())) {
                return Excel::download(new MembersExport(), 'Customer List.xlsx');
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        if($request['report'] == 'redemption_transactions'){
            $validator = Validator::make($request->all(), [
                'report' => ['required'],
                'from' => ['required'],
                'to' => ['required']
            ]);
    
            if (!($validator->fails())) {
                return Excel::download(new RedemptionTransactionsExport($request->from, $request->to), 'Redemption Transactions List.xlsx');
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }


        if($request['report'] == 'daily_reconciliation'){
            $validator = Validator::make($request->all(), [
                'date' => ['required'],
            ]);
    
            if (!($validator->fails())) {
                return Excel::download(new DailyReconciliationExport($request->date), 'Daily Reconciliation List.xlsx');
            } else {
                //dd($validator->messages());
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        return view('admin.report');
    }

    public function pdfTest()
    {
        // $customers = Member::with('discountList')->get();
        // return view('pdfs.format5', compact('customers'));

        
        $data['replyTo'] = 'quizstarmobile@gmail.com';
        $data['replyToName'] = 'Burlington Springs Team';
        $data['discountCodes'] = [
            0 => 1199,
            1 => 1200,
            2 => 1201,
            3 => 1202,
            4 => 1203,
            5 => 1204,
            6 => 1205,
            7 => 1206,
        ];
        $data['email'] = 'tanzimul.tanim@gmail.com';
        $data['first_name'] = 'Tanzimul';
        $data['last_name'] = 'Alam';
        $data['package'] = 'senior';
        $data['discountCode'] = 1109;

        //$pdf = PDF::loadView('pdfs.' . $data['package'], compact('data'))
          //  ->setOptions(['dpi' => 96, 'defaultFont' => 'Calibri'])
            //->setPaper('a4', 'potrait');

        // $pdf = PDF::loadView('pdfs.single-' . $data['package'], compact('data'))
        //     ->setOptions(['dpi' => 96, 'defaultFont' => 'Calibri'])
        //     ->setPaper('a4', 'potrait');
        //return $pdf->download('lukuluku.pdf');


        try {
            
                Mail::send('mails.regular', compact('data'), function ($message) use ($data) {
                    $message
                        ->to($data['email'], $data['first_name'])
                        ->replyTo($data['replyTo'], $data['replyToName'])
                        ->subject('Burlington Springs Daily Discount Program');
                });
            

            return $message = 'email sent';
        } catch (JWTException $exception) {
            return $message = 'email not sent' + $exception->getMessage();
            //return redirect()->back()->with('error', $exception->getMessage());
        }
        if (Mail::failures()) {
            return $message = 'email not sent mail failure';
            //return redirect()->back()->with('error', 'Error sending mail');
        } else {
            return $message = 'email sent success';
            //return redirect()->back()->with('success', 'Email sent successfully');
        }

        
    }

    // public function pdfView()
    // {
    //     //$data = $request->all();

    //     // $data['replyTo'] = env('MAIL_FROM_ADDRESS');
    //     // $data['replyToName'] = env('MAIL_FROM_NAME');

    //     $data['replyTo'] = 'quizstarmobile@gmail.com';
    //     $data['replyToName'] = 'QuizKing';
    //     $data['imageLogo'] = asset('images/BSG-Logo-2020.png');
    //     $data['imageButton'] = asset('/images/discount-btn.png');

    //     //dd($data);
        
    //     $pdf = PDF::loadView('pdfs.format3', compact('data'));
    //     return $pdf->download('test_'. rand() . '_lab.pdf');
    // }

}
