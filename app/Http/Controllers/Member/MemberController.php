<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\DiscountProgram;
use App\Models\Member;
use App\Models\NewLetter;
use App\Rules\ConfirmEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDF;
use Mail;
use env;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VoucherEmailAttachmentRegular;


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
        $validator = Validator::make($request->all(), [
            'discount' => ['required', 'numeric', 'digits_between:2,4'],
            'email' => ['required', 'string', 'email'],
        ]);

        if (!($validator->fails())) {
            $memberSearchByDiscountID = DiscountProgram::with(['memberData' => function ($q) use ($request) {
                    $q->where('email', $request['email']);
                }])->where('discount_id', $request['discount'])->first();
            if ($memberSearchByDiscountID != null) {
                if ($memberSearchByDiscountID->memberData != null) {
                    if ($memberSearchByDiscountID->is_used == false) {
                        $printCount = $memberSearchByDiscountID->print_count;
                        $memberSearchByDiscountID->update([
                            'print_count' => $printCount + 1,
                        ]);

                        $sendEmail = $this->sendEmailWithAttachmentWhileReprintVoucher($request, $memberSearchByDiscountID);
                        return redirect()->back()->with('success', 'An email with your personalized Daily Discount Vouchers has been sent to you.');
                    } else {
                        return redirect()->back()->with('error', 'Sorry this Discount # has already been used.');
                    }
                } else {
                    return redirect()->back()->with('error', 'Discount # or email address is not enrolled. Please go to the Daily Discount Program page to enroll.');
                }
            } else {
                return redirect()->back()->with('error', 'Discount # or email address is not enrolled. Please go to the Daily Discount Program page to enroll.');
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package' => ['required', 'string'],
            'first_name' => ['required', 'string', 'min:2', 'max:100'],
            'last_name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:members'],
            'confirm_email' => ['required', new ConfirmEmail($request['email'])],
        ]);

        if (!($validator->fails())) {
            $discountCodes = array();
            if ($request['package'] == 'regular') {

                $maxDiscountProgram = DiscountProgram::where('membership_type', 'regular')->where('discount_id','<',6999)->max('discount_id');
                //dd($maxDiscountProgram);
                if ($maxDiscountProgram == null) {
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($request, $member);
                    for ($i = 1000; $i <= 1007; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                        array_push($discountCodes, $i);
                    }
                    $sendEmail = $this->sendEmailWithAttachment($request, $discountCodes);
                } else if ($maxDiscountProgram < 6999) {
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($request, $member);


                    for ($i = $maxDiscountProgram + 1; $i <= $maxDiscountProgram + 8 && $i < 6999; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                        array_push($discountCodes, $i);
                    }
                    $sendEmail = $this->sendEmailWithAttachment($request, $discountCodes);
                } else {
                    return redirect()->back()->with('error', 'Sorry, our discount quota has been filled up. We cannot enroll your email.');
                }
            } else if ($request['package'] == 'senior') {

                $maxDiscountProgram = DiscountProgram::where('membership_type', 'senior')->where('discount_id','<',9998)->max('discount_id');
                //dd($maxDiscountProgram);
                if ($maxDiscountProgram == null) {
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($request, $member);

                    for ($i = 7000; $i <= 7007; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                        array_push($discountCodes, $i);
                    }
                    $sendEmail = $this->sendEmailWithAttachment($request, $discountCodes);
                } else if ($maxDiscountProgram < 9998) {
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($request, $member);

                    for ($i = $maxDiscountProgram + 1; $i <= $maxDiscountProgram + 8 && $i <= 9998; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                        array_push($discountCodes, $i);
                    }
                    $sendEmail = $this->sendEmailWithAttachment($request, $discountCodes);
                } else {
                    return redirect()->back()->with('error', 'Sorry, our discount quota has been filled up. We cannot enroll your email.');
                }
            } else if ($request['package'] == 'flyer') {

                $maxDiscountProgram = DiscountProgram::where('membership_type', 'flyer')->where('discount_id','<',999)->max('discount_id');
                //dd($maxDiscountProgram);
                if ($maxDiscountProgram == null) {
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($request, $member);

                    for ($i = 100; $i <= 107; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                        array_push($discountCodes, $i);
                    }
                    $sendEmail = $this->sendEmailWithAttachment($request, $discountCodes);
                } else if ($maxDiscountProgram < 999) {
                    $member = $this->createMember($request);
                    $newsLetter = $this->createNewsLetter($request, $member);

                    for ($i = $maxDiscountProgram + 1; $i <= $maxDiscountProgram + 8 && $i < 999; $i++) {
                        $discountProgram = $this->createDiscountProgram($request, $member, $i);
                        array_push($discountCodes, $i);
                    }
                    $sendEmail = $this->sendEmailWithAttachment($request, $discountCodes);
                } else {
                    return redirect()->back()->with('error', 'Sorry, our discount quota has been filled up. We cannot enroll your email.');
                }
            }
            return redirect()->back()->with('success', 'Thank your for registering for our Daily Discount Program. An email with your personalized Daily Discount Vouchers has been sent to you.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
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


    private function createNewsLetter($request, $member)
    {
        if ($request->has('newsletter')) {
            if ($request['newsletter'] = 'news') {
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
            'device' => 'paper',
            'print_count' => 1,
            'is_used' => 0,
            'is_admin' => 0,
            'used_at' => NULL,
        ]);
    }


    private function sendEmailWithAttachment($request, $discountCodes)
    {
        $data = $request->all();

        // $data['replyTo'] = env('MAIL_FROM_ADDRESS');
        // $data['replyToName'] = env('MAIL_FROM_NAME');

        $data['replyTo'] = 'quizstarmobile@gmail.com';
        $data['replyToName'] = 'Burlington Springs Team';
        $data['discountCodes'] = $discountCodes;

        $message = '';
        try {
            if ($request['package'] == 'regular' || $request['package'] == 'senior') {

                $pdf = PDF::loadView('pdfs.' . $request['package'], compact('data'))
                    ->setOptions(['dpi' => 96, 'defaultFont' => 'Calibri'])
                    ->setPaper('a4', 'potrait');
                //return $pdf->download('lukuluku.pdf');
                Mail::send('mails.' . $request['package'], compact('data'), function ($message) use ($data, $pdf) {
                    $message
                        ->to($data['email'], $data['first_name'])
                        ->replyTo($data['replyTo'], $data['replyToName'])
                        ->subject('Burlington Springs Daily Discount Program')
                        ->attachData($pdf->output(), 'burlington-springs-daily-discount-program.pdf');
                });
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

    private function sendEmailWithAttachmentWhileReprintVoucher($request, $memberData)
    {
        $data['replyTo'] = 'quizstarmobile@gmail.com';
        $data['replyToName'] = 'Burlington Springs Team';
        $data['discountCode'] = $request['discount'];
        $data['email'] = $memberData->memberData->email;
        $data['first_name'] = $memberData->memberData->first_name;
        $data['last_name'] = $memberData->memberData->last_name;
        $data['package'] = $memberData->membership_type;

        $message = '';
        try {
            if ($data['package'] == 'regular' || $data['package'] == 'senior') {

                $pdf = PDF::loadView('pdfs.single-' . $data['package'], compact('data'))
                    ->setOptions(['dpi' => 96, 'defaultFont' => 'Calibri'])
                    ->setPaper('a4', 'potrait');
                //return $pdf->download('lukuluku.pdf');
                Mail::send('mails.single-' . $data['package'], compact('data'), function ($message) use ($data, $pdf) {
                    $message
                        ->to($data['email'], $data['first_name'])
                        ->replyTo($data['replyTo'], $data['replyToName'])
                        ->subject('Burlington Springs Daily Discount Program')
                        ->attachData($pdf->output(), 'burlington-springs-daily-discount-program.pdf');
                });
            } else {
                Mail::send('mails.single-flyer', compact('data'), function ($message) use ($data) {
                    $message
                        ->to($data['email'], $data['first_name'])
                        ->replyTo($data['replyTo'], $data['replyToName'])
                        ->subject('Burlington Springs Daily Discount Program');
                });
            }

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
}
