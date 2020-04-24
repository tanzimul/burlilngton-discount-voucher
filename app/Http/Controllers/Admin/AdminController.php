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
            'password' => ['required', 'string', 'min:5', 'confirmed'],
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'report' => ['required'],
            'from' => [Rule::requiredIf($request->report == 'redemption_transactions')],
            'to' => [Rule::requiredIf($request->report == 'redemption_transactions')],
            'date' => [Rule::requiredIf($request->report == 'daily_reconciliation')],
        ]);

        if (!($validator->fails())) {
            if($request->report == 'customer_record'){
                return Excel::download(new MembersExport(), 'Customer List.xlsx');
            }else if($request->report == 'redemption_transactions'){
                return Excel::download(new RedemptionTransactionsExport($request->from, $request->to), 'Redemption Transactions List.xlsx');
            }else if($request->report == 'daily_reconciliation'){
                return Excel::download(new DailyReconciliationExport($request->date), 'Daily Reconciliation List.xlsx');
            }
        } else {
            dd($validator->messages());
            return redirect()->back()->withErrors($validator)->withInput();
        }


        return view('admin.report');
    }

    public function pdfTest()
    {
        $customers = Member::with('discountList')->get();
        return view('pdfs.format3', compact('customers'));
    }

    public function pdfView()
    {
        //$data = $request->all();

        // $data['replyTo'] = env('MAIL_FROM_ADDRESS');
        // $data['replyToName'] = env('MAIL_FROM_NAME');

        $data['replyTo'] = 'quizstarmobile@gmail.com';
        $data['replyToName'] = 'QuizKing';
        $data['imageLogo'] = asset('images/BSG-Logo-2020.png');
        $data['imageButton'] = asset('/images/discount-btn.png');

        //dd($data);
        
        $pdf = PDF::loadView('pdfs.format3', compact('data'));
        return $pdf->download('test_'. rand() . '_lab.pdf');
    }

}
