<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\DiscountProgram;
use App\Models\Member;
use App\Models\NewLetter;
use App\Rules\ConfirmEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('member.main');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reprint()
    {
        return view('member.reprint');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'package' => ['required', 'string'],
            'first_name' => ['required', 'string', 'min:2', 'max:100'],
            'last_name' => ['required', 'string', 'min:2', 'max:100'],
            // 'email' => ['required', 'string', 'email', 'max:100', 'unique:members'],
            // 'confirm_email' => ['required', new ConfirmEmail],
        ]);

        if (!($validator->fails())) {

            if ($request['package'] == 'regular') {

                $maxDiscountProgram = DiscountProgram::where('membership_type', 'regular')->max('discount_id');
                //dd($maxDiscountProgram);
                if($maxDiscountProgram == null){
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($member);

                    for ($i = 1000; $i <= 1007; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                    }
                    
                } else if($maxDiscountProgram < 6999){
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($member);
                    
                    for ($i = $maxDiscountProgram+1; $i <= $maxDiscountProgram+8 && $i <= 6999; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                    }
                }else {
                    return redirect()->route('main')->with('error','Sorry, our discount quota has been filled up. We cannot enroll your email.');
                }

            } else if ($request['package'] == 'senior') {

                $maxDiscountProgram = DiscountProgram::where('membership_type', 'senior')->max('discount_id');
                //dd($maxDiscountProgram);
                if($maxDiscountProgram == null){
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($member);

                    for ($i = 7000; $i <= 7007; $i++) { 
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                    }
                    
                } else if($maxDiscountProgram < 9998){
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($member);

                    for ($i = $maxDiscountProgram+1; $i <= $maxDiscountProgram+8 && $i <= 9998; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                    }

                } else {
                    return redirect()->route('main')->with('error','Sorry, our discount quota has been filled up. We cannot enroll your email.');
                }
            } else if ($request['package'] == 'flyer') {
                
                $maxDiscountProgram = DiscountProgram::where('membership_type', 'flyer')->max('discount_id');
                //dd($maxDiscountProgram);
                if($maxDiscountProgram == null){
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($member);

                    for ($i = 100; $i <= 107; $i++) { 
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                    }
                    
                } else if($maxDiscountProgram < 999){
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($member);

                    for ($i = $maxDiscountProgram+1; $i <= $maxDiscountProgram+8 && $i <= 999; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                    }

                } else {
                    return redirect()->route('main')->with('error','Sorry, our discount quota has been filled up. We cannot enroll your email.');
                }
            }
            // else if($request['package'] == 'a'){

            // }



            return redirect()->route('main')->with('success','Thank your for registering for our Daily Discount Program. An email with your personalized Daily Discount Vouchers has been sent to you.');
        } else {
            dd($validator->messages());
        }
    }




    private function createMember($request){
        return Member::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
        ]);
    }


    private function createNewsLetter($member){
        return NewLetter::create([
            'membership_id' => $member->id,
            'email' => $member->email,
            'is_email_sent' => 0
        ]);
    }


    private function createDiscountProgram($request, $member, $i){
        return DiscountProgram::create([
            'membership_id' => $member->id,
            'membership_type' => $request['package'],
            'discount_id' => $i,
            'device' => 'web',
            'print_count' => 1,
            'is_used' => 0,
            'is_admin' => 0,
            'used_at' => NULL,
        ]);
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
    public function destroy($id)
    {
        //
    }
}
