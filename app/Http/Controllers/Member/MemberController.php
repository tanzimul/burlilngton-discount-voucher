<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\DiscountProgram;
use App\Models\Member;
use App\Models\NewLetter;
use App\Rules\ConfirmEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\PDF;
use Mail;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reprintVoucher(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount' => ['required', 'numeric', 'digits_between:2,4'],
            'email' => ['required', 'string', 'email'],
        ]);

        if (!($validator->fails())) {
            // $memberSearchByDiscountID = DiscountProgram::where('discount_id', $request['discount'])->with('memberData')->first();
            // if($memberSearchByDiscountID != null){
            //     if($memberSearchByDiscountID->memberData->email == $request['email']){
            //         return redirect()->route('reprint')->with('success','An email with your personalized Daily Discount Vouchers has been sent to you.');
            //     }else{
            //         return redirect()->route('reprint')->with('error','Discount # or email address is not enrolled. Please go to the Daily Discount Program page to enroll.');
            //     }
            // }else{
            //     return redirect()->route('reprint')->with('error','Discount # or email address is not enrolled. Please go to the Daily Discount Program page to enroll.');
            // }

            
            $memberSearchByDiscountID = DiscountProgram::with(['memberData' => function ($q) use ($request) {
                $q->where('email', $request['email']);
            }])
                ->where('discount_id', $request['discount'])
                ->first();
                //dd($memberSearchByDiscountID);
            if($memberSearchByDiscountID != null){
                if ($memberSearchByDiscountID->memberData != null) {
                    $printCount = $memberSearchByDiscountID->print_count;
                    $memberSearchByDiscountID->update([
                        'print_count' => $printCount+1,
                    ]);
                    return redirect()->route('reprint')->with('success','An email with your personalized Daily Discount Vouchers has been sent to you.');
                }else{
                    return redirect()->back()->with('error','Discount # or email address is not enrolled. Please go to the Daily Discount Program page to enroll.');
                }
            }else{
                return redirect()->back()->with('error','Discount # or email address is not enrolled. Please go to the Daily Discount Program page to enroll.');
            }

        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
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
            'email' => ['required', 'string', 'email', 'max:100', 'unique:members'],
            'confirm_email' => ['required', new ConfirmEmail($request['email'])],
        ]);

        if (!($validator->fails())) {

            if ($request['package'] == 'regular') {

                $maxDiscountProgram = DiscountProgram::where('membership_type', 'regular')->max('discount_id');
                //dd($maxDiscountProgram);
                if($maxDiscountProgram == null){
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($request,$member);
                                       
                    for ($i = 1000; $i <= 1007; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                    }
                    
                } else if($maxDiscountProgram < 6999){
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($request,$member);
                    
                    for ($i = $maxDiscountProgram+1; $i <= $maxDiscountProgram+8 && $i <= 6999; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                    }
                }else {
                    return redirect()->back()->with('error','Sorry, our discount quota has been filled up. We cannot enroll your email.');
                }

            } else if ($request['package'] == 'senior') {

                $maxDiscountProgram = DiscountProgram::where('membership_type', 'senior')->max('discount_id');
                //dd($maxDiscountProgram);
                if($maxDiscountProgram == null){
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($request,$member);

                    for ($i = 7000; $i <= 7007; $i++) { 
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                    }
                    
                } else if($maxDiscountProgram < 9998){
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($request,$member);

                    for ($i = $maxDiscountProgram+1; $i <= $maxDiscountProgram+8 && $i <= 9998; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                    }

                } else {
                    return redirect()->back()->with('error','Sorry, our discount quota has been filled up. We cannot enroll your email.');
                }
            } else if ($request['package'] == 'flyer') {

                $maxDiscountProgram = DiscountProgram::where('membership_type', 'flyer')->max('discount_id');
                //dd($maxDiscountProgram);
                if($maxDiscountProgram == null){
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($request,$member);

                    for ($i = 100; $i <= 107; $i++) { 
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                    }
                    
                } else if($maxDiscountProgram < 999){
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($request,$member);

                    for ($i = $maxDiscountProgram+1; $i <= $maxDiscountProgram+8 && $i <= 999; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                    }

                } else {
                    return redirect()->back()->with('error','Sorry, our discount quota has been filled up. We cannot enroll your email.');
                }
            }



            return redirect()->back()->with('success','Thank your for registering for our Daily Discount Program. An email with your personalized Daily Discount Vouchers has been sent to you.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
            //dd($validator->messages());
        }
    }




    private function createMember($request)
    {
        return Member::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
        ]);
    }


    private function createNewsLetter($request,$member)
    {
        if($request->has('newsletter')){
            if($request['newsletter'] = 'news'){
                return NewLetter::create([
                    'membership_id' => $member->id,
                    'email' => $member->email,
                    'is_email_sent' => 0
                ]);
            }
        }
        return null;
        
    }


    private function createDiscountProgram($request, $member, $i)
    {
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

    
    // private function sendEmailWithAttachment($request)
    // {
    //     $data = $request->all();

    //     $data['replyTo'] = env('MAIL_FROM_ADDRESS');
    //     $data['replyToName'] = env('MAIL_FROM_NAME');

    //     dd($data);
        
    //     $pdf = PDF::loadView('pdfs.format1', compact('data'));
    //     try {
    //         Mail::send('mails.mail', compact('data'), function ($message) use ($data, $pdf) {
    //             $message
    //                 ->to($data['email'], $data['name'])
    //                 ->replyTo($data['replyTo'], $data['replyToName'])
    //                 ->subject($data['subject'])
    //                 ->attachData($pdf->output(), "attachment.pdf");
    //         });
    //     } catch (JWTException $exception) {
    //         return redirect()->back()->with('error', $exception->getMessage());
    //     }
    //     if (Mail::failures()) {
    //         return redirect()->back()->with('error', 'Error sending mail');
    //     } else {
    //         return redirect()->back()->with('success', 'Email sent successfully');
    //     }
    // }

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
