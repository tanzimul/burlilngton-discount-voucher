<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\DiscountProgramLog;
use App\Models\Member;
use App\Models\NewLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function index()
    {
        return view('staff.index');
    }

    public function searchUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount' => ['required', 'numeric', 'digits:4'],
        ]);

        if (!($validator->fails())) {

            $discountLog = DiscountProgramLog::latest('last_used_at')->where('discount_id', $request['discount'])->with('memberData')->first();

            if ($discountLog == null) {
                $memberSearchByDiscountID = Member::where('discount_id', $request['discount'])->first();
                if ($memberSearchByDiscountID != null) {
                    $lastName = $memberSearchByDiscountID->last_name;
                    return response()->json([
                        'message' => 'User found.',
                        'status' => true,
                        'data' => $lastName
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'No user found with this discount.',
                        'status' => false,
                        'data' => null
                    ], 200);
                }
            } else {
                if ($discountLog->memberData->is_admin == true) {
                    $lastName = $discountLog->memberData->last_name;
                    return response()->json([
                        'message' => 'User found.',
                        'status' => true,
                        'data' => $lastName
                    ], 200);
                } else {

                    if ($discountLog->last_used_at != $request['date']) {
                        $lastName = $discountLog->memberData->last_name;
                        return response()->json([
                            'message' => 'User found.',
                            'status' => true,
                            'data' => $lastName
                        ], 200);
                    } else {
                        return response()->json([
                            'message' => 'Sorry this user already used a discount for today.',
                            'status' => false,
                            'data' => null
                        ], 200);
                    }
                }
            }
        } else {
            return response()->json([
                'message' => 'The discount must be 4 digits.',
                'status' => false,
                'data' => $validator->messages()
            ], 200);
        }
    }

    public function submitDiscount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount' => ['required', 'numeric', 'digits:4'],
        ]);

        if (!($validator->fails())) {

            // $latestDiscountLog = DiscountProgramLog::latest('last_used_at') //->where('discount_id', $request['discount'])->with('memberData')->first();
            // //->whereDate('last_used_at','=', $request['today'])
            // ->where('discount_id', $request['discount'])->with('memberData')->first();

            

            // if($latestDiscountLog->last_used_at == $request['today']){
            //     return response()->json([
            //         'message' => 'Issue found.',
            //         'status' => false,
            //         'data' => $latestDiscountLog
            //     ], 200);
            // }

            $latestDiscountLog = DiscountProgramLog::whereDate('last_used_at','=', $request['date'])
            ->where('discount_id', $request['discount'])->with('memberData')->first();

            if($latestDiscountLog == null){
                $memberSearchByDiscountID = Member::where('discount_id', $request['discount'])->first();

                if ($memberSearchByDiscountID != null) {
                    $discountLog = DiscountProgramLog::create([
                        'membership_id' => $memberSearchByDiscountID->id,
                        'discount_id' => $request['discount'],
                        'last_used_at' => $request['date'],
                    ]);
    
                    if ($request->has('phone')) {
                        $memberSearchByDiscountID->device = "phone";
                        $memberSearchByDiscountID->save();
                    }
    
                    return response()->json([
                        'message' => 'Saved to database.',
                        'status' => true,
                        'data' => null
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'No user found with this discount.',
                        'status' => false,
                        'data' => null
                    ], 200);
                }
            } else {

                if($latestDiscountLog->memberData->is_admin == true){
                    $discountLog = DiscountProgramLog::create([
                        'membership_id' => $latestDiscountLog->memberData->id,
                        'discount_id' => $request['discount'],
                        'last_used_at' => $request['date'],
                    ]);
    
                    if ($request->has('phone')) {
                        $latestDiscountLog->memberData->device = "phone";
                        $latestDiscountLog->memberData->save();
                    }
    
                    return response()->json([
                        'message' => 'Saved to database.',
                        'status' => true,
                        'data' => null
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Sorry this user already used a discount for today.',
                        'status' => false,
                        'data' => null
                    ], 200);
                }   
            }
        } else {
            return response()->json([
                'message' => 'The discount must be 4 digits.',
                'status' => false,
                'data' => $validator->messages()
            ], 200);
        }
    }

    public function submitRecord(Request $request)
    {

        // Search Start//

        if ($request['button_type'] == 'search') {

            if($request['discount'] != null){
                $validator = Validator::make($request->all(), [
                    'discount' => ['required', 'numeric', 'digits:4'],
                ]);
    
                if (!($validator->fails())) {
                    $memberSearchByDiscountID = Member::where('discount_id', $request['discount'])
                        ->first();
    
                    if ($memberSearchByDiscountID != null) {
                        return response()->json([
                            'message' => 'User found.',
                            'status' => true,
                            'data' => $memberSearchByDiscountID
                        ], 200);
                    } else {
                        return response()->json([
                            'message' => 'Sorry, did not find any match.',
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
            } else if ($request['email'] != null) {
                $validator = Validator::make($request->all(), [
                    'email' => ['required', 'string', 'email', 'regex:/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'],
                ]);
    
                if (!($validator->fails())) {
                    $memberSearchByDiscountID = Member::where('email', $request['email'])
                        ->first();
    
                    if ($memberSearchByDiscountID != null) {
                        return response()->json([
                            'message' => 'User found.',
                            'status' => true,
                            'data' => $memberSearchByDiscountID
                        ], 200);
                    } else {
                        return response()->json([
                            'message' => 'Sorry, did not find any match.',
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
            } else {
                $validator = Validator::make($request->all(), [
                    'discount' => ['required', 'numeric', 'digits:4'],
                    'email' => ['required', 'string', 'email', 'regex:/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'],
                ]);

                if (!($validator->fails())) {
                    return response()->json([
                        'message' => 'Validation error',
                        'status' => false,
                        'data' => $validator->messages()
                    ], 200);
                }
                else{
                    return response()->json([
                        'message' => 'Validation error',
                        'status' => false,
                        'data' => $validator->messages()
                    ], 200);
                }
            }
        }


        // Search End //


        // Save Start //

        if ($request['button_type'] == 'save') {

            if ($request['member_id'] == 1 || $request['member_id'] == 2 || $request['member_id'] == 3){
                $validator = Validator::make($request->all() , [
                    'member_id' => ['required'],
                    'first_name' => ['required', 'string'],
                    'last_name' => ['required', 'string'],
                    'discount' => ['required', 'numeric', 'digits:4'],
                ]);
    
                if (!($validator->fails())) {
                    $memberUpdateData = Member::find($request['member_id']);
                    
                    $memberUpdateData->first_name = $request['first_name'];
                    $memberUpdateData->last_name = $request['last_name'];
                    $memberUpdateData->save();

                    return response()->json([
                        'message' => 'Customer data updated successfully.',
                        'status' => true,
                        'data' => null
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Validation error',
                        'status' => false,
                        'data' => $validator->messages()
                    ], 200);
                }
            } else {
                $validator = Validator::make($request->all() , [
                    'member_id' => ['required'],
                    'first_name' => ['required', 'string'],
                    'last_name' => ['required', 'string'],
                    'discount' => ['required', 'numeric', 'digits:4'],
                    'email' => ['required', 'email','unique:members,email,'.$request->member_id],
                ],
                ['email.unique' => 'This email is already enrolled.']);
    
                if (!($validator->fails())) {
                    if ($request['member_id'] != null) {
                        $memberUpdateData = Member::find($request['member_id']);
                        
                        if($memberUpdateData->email != $request['email']){
                            $updateNewsLetter = NewLetter::where('email',$memberUpdateData->email)->first();
                            if($updateNewsLetter != null){
                                $updateNewsLetter->email = $request['email'];
                                $updateNewsLetter->save();
                            }
                        }
                        $memberUpdateData->first_name = $request['first_name'];
                        $memberUpdateData->last_name = $request['last_name'];
                        $memberUpdateData->email = $request['email'];
                        $memberUpdateData->save();
    
                        return response()->json([
                            'message' => 'Customer data updated successfully.',
                            'status' => true,
                            'data' => null
                        ], 200);
    
                    } else {
                        return response()->json([
                            'message' => 'You have to search a customer first.',
                            'status' => false,
                            'data' => null
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'message' => 'Validation error',
                        'status' => false,
                        'data' => $validator->messages()
                    ], 200);
                }
            }
        }
      

        // Delete Start //

        if ($request['button_type'] == 'delete') {
            $validator = Validator::make($request->all(), [
                'discount' => ['required', 'numeric', 'digits:4'],
            ]);

            if (!($validator->fails())) {
                if ($request['member_id'] == 1 || $request['member_id'] == 2 || $request['member_id'] == 3){
                    return response()->json([
                        'message' => 'Sorry, you can not delete admin discount.',
                        'status' => false,
                        'data' => null
                    ], 200);
                } else {
                    $memberSearchByDiscountID = Member::where('discount_id',$request['discount'])->first();
                    if ($memberSearchByDiscountID != null) {
                        
                        $deleteDiscountLog = DiscountProgramLog::where('membership_id', $memberSearchByDiscountID->id)->delete();
                        $deleteNewsLetter = NewLetter::where('email', $memberSearchByDiscountID->email)->delete();
                        $deleteMember = $memberSearchByDiscountID->delete();

                        return response()->json([
                            'message' => 'Delete successfully.',
                            'status' => true,
                            'data' => null
                        ], 200);
                    } else {
                        return response()->json([
                            'message' => 'Sorry, did not find any match.',
                            'status' => false,
                            'data' => null
                        ], 200);
                    }
                }
            } else {
                return response()->json([
                    'message' => 'The discount must be 4 digits.',
                    'status' => false,
                    'data' => $validator->messages()
                ], 200);
            }
        }


        // Delete End //
    }
}
