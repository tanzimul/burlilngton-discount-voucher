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
use Illuminate\Support\Facades\Auth;
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
        if(Auth::user()->role == 1){
            $users = User::all();
            return view('admin.user', compact('users'));
        } else {
            return abort(401);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == 1){
            return view('admin.create');
        } else {
            return abort(401);
        }
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
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        return view('admin.report');
    }

}
