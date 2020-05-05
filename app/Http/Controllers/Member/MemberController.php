<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\NewLetter;
use App\Rules\ConfirmEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDF;
use Mail;
use env;
use Illuminate\Support\Facades\Auth;
use File;
use Illuminate\Support\Facades\File as FacadesFile;
use Intervention\Image\Facades\Image;

class MemberController extends Controller
{

    public function index()
    {
        return view('member.main');
    }


    public function reprint()
    {
        return view('member.reprint');
    }


    public function reprintVoucher(Request $request)
    {
        if($request->has('discount') && $request['discount'] != null){
            $validator = Validator::make($request->all(), [
                'discount' => ['numeric', 'digits:4'],
            ]);
    
            if (!($validator->fails())) {
                $memberSearchByDiscountID = Member::where('discount_id', $request['discount'])->with('discountListLogs')->first();
                if ($memberSearchByDiscountID != null) {
                    
                    $sendEmail = $this->resendEmailWithAttachment($memberSearchByDiscountID);
                    $memberSearchByDiscountID->print_count = $memberSearchByDiscountID->print_count+1;
                    $memberSearchByDiscountID->save();
                    
                    return response()->json([
                        'message' => 'An email with your personalized Daily Discount Vouchers has been sent to you.',
                        'status' => true,
                        'data' => null
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Discount # is not enrolled. Please go to the Daily Discount Program page to enroll.',
                        'status' => false,
                        'data' => null
                    ], 200);
                }
            } else {
                return response()->json([
                    'message' => 'The discount must be 4 digits.',
                    'status' => false,
                    'data' => $validator->messages()
                ], 200);
            }
        } else if ($request->has('email') && $request['email'] != null){
            $validator = Validator::make($request->all(), [
                'email' => ['string', 'email', 'regex:/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'],
            ]);
    
            if (!($validator->fails())) {
                $memberSearchByDiscountID = Member::where('email', $request['email'])->with('discountListLogs')->first();
                if ($memberSearchByDiscountID != null) {
                    
                    $sendEmail = $this->resendEmailWithAttachment($memberSearchByDiscountID);
                    if($sendEmail == 'email sent'){
                        $memberSearchByDiscountID->print_count = $memberSearchByDiscountID->print_count+1;
                        $memberSearchByDiscountID->save();
                        return response()->json([
                            'message' => 'An email with your personalized Daily Discount Vouchers has been sent to you.',
                            'status' => true,
                            'data' => null
                        ], 200);
                    } else {
                        return response()->json([
                            'message' => $sendEmail,
                            'status' => false,
                            'data' => null
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'message' => 'Email address is not enrolled. Please go to the Daily Discount Program page to enroll.',
                        'status' => false,
                        'data' => null
                    ], 200);
                }
            } else {
                return response()->json([
                    'message' => 'The email must be a valid email address.',
                    'status' => false,
                    'data' => $validator->messages()
                ], 200);
            }
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package' => ['required', 'string'],
            'first_name' => ['required', 'string', 'min:2', 'max:100'],
            'last_name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:members', 'regex:/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'],
            'confirm_email' => ['required', new ConfirmEmail($request['email'])],
        ]);

        if (!($validator->fails())) {
            $discountCode = null;
            if ($request['package'] == 'regular') {

                $maxDiscountProgram = Member::where('membership_type', 'regular')->where('discount_id','>',999)->where('discount_id','<',6999)->max('discount_id');
                if ($maxDiscountProgram == null) {
                    $discountCode = 1000;
                    
                    
                    $sendEmail = $this->sendEmailWithAttachment($request, $discountCode);

                    // return response()->json([
                    //     'message' => $sendEmail,
                    //     'status' => true,
                    //     'data' => null
                    // ], 200);


                    if($sendEmail == 'email sent'){
                        //$member = $this->createMember($request, $discountCode);
                        //$newsLetter = $this->createNewsLetter($request, $member);

                        if(Auth::user()){
                            return response()->json([
                                'message' => 'Player is now registered for our Daily Discounts Program. An email has been sent with personalized Discount Vouchers and/or Discount #.',
                                'status' => true,
                                'data' => null
                            ], 200);
                        }

                        return response()->json([
                            'message' => 'Thank your for registering for our Daily Discount Program. An email with your personalized Daily Discount Vouchers has been sent to you.',
                            'status' => true,
                            'data' => null
                        ], 200);

                    } else {
                        return response()->json([
                            'message' => $sendEmail,
                            'status' => false,
                            'data' => null
                        ], 200);
                    }
                } else if ($maxDiscountProgram < 6999) {
                    $discountCode = $maxDiscountProgram+1;
                    
                    $sendEmail = $this->sendEmailWithAttachment($request, $discountCode);
                    if($sendEmail == 'email sent'){
                        //$member = $this->createMember($request, $discountCode);
                        //$newsLetter = $this->createNewsLetter($request, $member);

                        if(Auth::user()){
                            return response()->json([
                                'message' => 'Player is now registered for our Daily Discounts Program. An email has been sent with personalized Discount Vouchers and/or Discount #.',
                                'status' => true,
                                'data' => null
                            ], 200);
                        }

                        return response()->json([
                            'message' => 'Thank your for registering for our Daily Discount Program. An email with your personalized Daily Discount Vouchers has been sent to you.',
                            'status' => true,
                            'data' => null
                        ], 200);

                    } else {
                        return response()->json([
                            'message' => $sendEmail,
                            'status' => false,
                            'data' => null
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'message' => 'Sorry, our discount quota has been filled up. We cannot enroll your email.',
                        'status' => false,
                        'data' => null
                    ], 200);
                }
            } else if ($request['package'] == 'senior') {

                $maxDiscountProgram = Member::where('membership_type', 'senior')->where('discount_id','>',6999)->where('discount_id','<',9999)->max('discount_id');
                if ($maxDiscountProgram == null) {
                    $discountCode = 7000;
                    
                    $sendEmail = $this->sendEmailWithAttachment($request, $discountCode);
                    if($sendEmail == 'email sent'){
                        //$member = $this->createMember($request, $discountCode);
                        //$newsLetter = $this->createNewsLetter($request, $member);

                        if(Auth::user()){
                            return response()->json([
                                'message' => 'Player is now registered for our Daily Discounts Program. An email has been sent with personalized Discount Vouchers and/or Discount #.',
                                'status' => true,
                                'data' => null
                            ], 200);
                        }

                        return response()->json([
                            'message' => 'Thank your for registering for our Daily Discount Program. An email with your personalized Daily Discount Vouchers has been sent to you.',
                            'status' => true,
                            'data' => null
                        ], 200);

                    } else {
                        return response()->json([
                            'message' => $sendEmail,
                            'status' => false,
                            'data' => null
                        ], 200);
                    }
                } else if ($maxDiscountProgram < 9999) {
                    $discountCode = $maxDiscountProgram+1;
                    
                    $sendEmail = $this->sendEmailWithAttachment($request, $discountCode);
                    if($sendEmail == 'email sent'){
                        //$member = $this->createMember($request, $discountCode);
                        //$newsLetter = $this->createNewsLetter($request, $member);

                        if(Auth::user()){
                            return response()->json([
                                'message' => 'Player is now registered for our Daily Discounts Program. An email has been sent with personalized Discount Vouchers and/or Discount #.',
                                'status' => true,
                                'data' => null
                            ], 200);
                        }

                        return response()->json([
                            'message' => 'Thank your for registering for our Daily Discount Program. An email with your personalized Daily Discount Vouchers has been sent to you.',
                            'status' => true,
                            'data' => null
                        ], 200);

                    } else {
                        return response()->json([
                            'message' => $sendEmail,
                            'status' => false,
                            'data' => null
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'message' => 'Sorry, our discount quota has been filled up. We cannot enroll your email.',
                        'status' => false,
                        'data' => null
                    ], 200);
                }
            } else if ($request['package'] == 'flyer') {

                $maxDiscountProgram = Member::where('membership_type', 'flyer')->where('discount_id','>',99)->where('discount_id','<',999)->max('discount_id');
                if ($maxDiscountProgram == null) {
                    $discountCode = 100;
                    
                    $sendEmail = $this->sendEmailWithAttachment($request, $discountCode);
                    if($sendEmail == 'email sent'){
                        //$member = $this->createMember($request, $discountCode);
                        //$newsLetter = $this->createNewsLetter($request, $member);

                        if(Auth::user()){
                            return response()->json([
                                'message' => 'Player is now registered for our Daily Discounts Program. An email has been sent with personalized Discount Vouchers and/or Discount #.',
                                'status' => true,
                                'data' => null
                            ], 200);
                        }

                        return response()->json([
                            'message' => 'Thank your for registering for our Daily Discount Program. An email with your personalized Daily Discount Vouchers has been sent to you.',
                            'status' => true,
                            'data' => null
                        ], 200);

                    } else {
                        return response()->json([
                            'message' => $sendEmail,
                            'status' => false,
                            'data' => null
                        ], 200);
                    }
                } else if ($maxDiscountProgram < 999) {
                    $discountCode = $maxDiscountProgram+1;
                    
                    $sendEmail = $this->sendEmailWithAttachment($request, $discountCode);
                    if($sendEmail == 'email sent'){
                        //$member = $this->createMember($request, $discountCode);
                        //$newsLetter = $this->createNewsLetter($request, $member);

                        if(Auth::user()){
                            return response()->json([
                                'message' => 'Player is now registered for our Daily Discounts Program. An email has been sent with personalized Discount Vouchers and/or Discount #.',
                                'status' => true,
                                'data' => null
                            ], 200);
                        }

                        return response()->json([
                            'message' => 'Thank your for registering for our Daily Discount Program. An email with your personalized Daily Discount Vouchers has been sent to you.',
                            'status' => true,
                            'data' => null
                        ], 200);

                    } else {
                        return response()->json([
                            'message' => $sendEmail,
                            'status' => false,
                            'data' => null
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'message' => 'Sorry, our discount quota has been filled up. We cannot enroll your email.',
                        'status' => false,
                        'data' => null
                    ], 200);
                }
            }
        } else {
            return response()->json([
                'message' => 'Validation error',
                'status' => false,
                'data' => $validator->messages()
            ], 200);
        }
    }




    private function createMember($request, $discountCode)
    {
        return Member::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'membership_type' => $request['package'],
            'discount_id' => $discountCode,
            'device' => 'paper',
            'print_count' => 1,
            'is_admin' => 0,
        ]);
    }


    private function createNewsLetter($request, $member)
    {
        if ($request->has('newsletter')) {
            if ($request['newsletter'] == 'news') {
                return NewLetter::create([
                    'membership_id' => $member->id,
                    'email' => $member->email,
                    'is_email_sent' => 0
                ]);
            }
        }
        return null;
    }


    private function sendEmailWithAttachment($request, $discountCode)
    {
        $data = $request->all();

        $data['replyTo'] = env('MAIL_FROM_ADDRESS');
        $data['replyToName'] = env('MAIL_FROM_NAME');

        // $data['replyTo'] = 'quizstarmobile@gmail.com';
        // $data['replyToName'] = 'Burlington Springs Team';
        $data['discountCode'] = $discountCode;

        $message = '';
        try {
            if ($request['package'] == 'regular' || $request['package'] == 'senior') {

                $pdf = PDF::loadView('pdfs.' . $request['package'], compact('data'))
                    ->setOptions(['dpi' => 96, 'defaultFont' => 'Calibri'])
                    ->setPaper('a4', 'potrait');

                //$pdf->download('lukuluku.pdf');
                //$content = $pdf->download()->getOriginalContent();
                //FacadesFile::put(public_path('pdfs/regular-voucher.pdf'), $pdf->output());
                // $img = Image::make(public_path('images/regular-voucher.png'))->encode('jpg', 75);

                if($request['package'] == 'regular'){
                    $img = Image::make(public_path('images/regular-voucher.png'));
                } else {
                    $img = Image::make(public_path('images/senior-voucher.png'));
                }
                
                $img->text($data['discountCode'].' '.$data['last_name'].','.$data['first_name'], 320, 90, function ($font) {
                    $font->file(storage_path('fonts/calibrib.ttf'));
                    $font->size(50);
                    $font->color('#000000');
                    $font->align('center');
                    $font->valign('top');
                });

                $img->save(public_path('images/discount-images/'.$data['discountCode'].'.png'));

                Mail::send('mails.' . $request['package'], compact('data'), function ($message) use ($data, $pdf) {
                    $message
                        ->to($data['email'], $data['first_name'])
                        ->replyTo($data['replyTo'], $data['replyToName'])
                        ->subject('Burlington Springs Daily Discount Program')
                        ->attachData($pdf->output(), 'burlington-springs-daily-discount-program.pdf')
                        ->attach(public_path('images/discount-images/'.$data['discountCode'].'.png'));
                });
                //FacadesFile::put(public_path('pdfs/'.$data['discountCode'].'.pdf'), $pdf->output());
                FacadesFile::delete(public_path('images/discount-images/'.$data['discountCode'].'.png'));
            } else {
                Mail::send('mails.flyer', compact('data'), function ($message) use ($data) {
                    $message
                        ->to($data['email'], $data['first_name'])
                        ->replyTo($data['replyTo'], $data['replyToName'])
                        ->subject('Burlington Springs Daily Discount Program');
                });
            }

            return $message = 'email sent';
        } catch (JWTException $exception) {
            return $message = 'email not sent' + $exception->getMessage();
        }
        if (Mail::failures()) {
            return $message = 'email not sent mail failure';
        } else {
            return $message = 'email sent success';
        }
    }

    private function resendEmailWithAttachment($memberData)
    {
        // dd('from mail',$memberData);
        // $data['replyTo'] = 'quizstarmobile@gmail.com';
        // $data['replyToName'] = 'Burlington Springs Team';
        $data['replyTo'] = env('MAIL_FROM_ADDRESS');
        $data['replyToName'] = env('MAIL_FROM_NAME');
        $data['discountCode'] = $memberData->discount_id;
        $data['email'] = $memberData->email;
        $data['first_name'] = $memberData->first_name;
        $data['last_name'] = $memberData->last_name;
        $data['package'] = $memberData->membership_type;

        $message = '';
        try {
            if ($data['package'] == 'regular' || $data['package'] == 'senior') {

                $pdf = PDF::loadView('pdfs.' . $data['package'], compact('data'))
                    ->setOptions(['dpi' => 96, 'defaultFont' => 'Calibri'])
                    ->setPaper('a4', 'potrait');
                //return $pdf->download('lukuluku.pdf');


                if($data['package'] == 'regular'){
                    $img = Image::make(public_path('images/regular-voucher.png'));
                } else {
                    $img = Image::make(public_path('images/senior-voucher.png'));
                }
                
                $img->text($data['discountCode'].' '.$data['last_name'].','.$data['first_name'], 320, 90, function ($font) {
                    $font->file(storage_path('fonts/calibrib.ttf'));
                    $font->size(50);
                    $font->color('#000000');
                    $font->align('center');
                    $font->valign('top');
                });

                $img->save(public_path('images/discount-images/'.$data['discountCode'].'.png'));


                Mail::send('mails.' . $data['package'], compact('data'), function ($message) use ($data, $pdf) {
                    $message
                        ->to($data['email'], $data['first_name'])
                        ->replyTo($data['replyTo'], $data['replyToName'])
                        ->subject('Burlington Springs Daily Discount Program')
                        ->attachData($pdf->output(), 'burlington-springs-daily-discount-program.pdf')
                        ->attach(public_path('images/discount-images/'.$data['discountCode'].'.png'));
                });
                FacadesFile::delete(public_path('images/discount-images/'.$data['discountCode'].'.png'));
            } else {
                Mail::send('mails.flyer', compact('data'), function ($message) use ($data) {
                    $message
                        ->to($data['email'], $data['first_name'])
                        ->replyTo($data['replyTo'], $data['replyToName'])
                        ->subject('Burlington Springs Daily Discount Program');
                });
            }

            return $message = 'email sent';
        } catch (JWTException $exception) {
            return $message = 'email not sent' + $exception->getMessage();
        }
        if (Mail::failures()) {
            return $message = 'email not sent mail failure';
        } else {
            return $message = 'email sent success';
        }
    }
}
