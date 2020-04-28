<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AdminDiscountProgram;
use App\Models\DiscountProgram;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function index()
    {
        return view('staff.index');
    }

    public function submitDiscount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount' => ['required', 'numeric', 'digits_between:2,4'],
            'lastname' => ['required', 'string'],
        ]);
        
        if (!($validator->fails())) {

            $memberSearchByDiscountID = DiscountProgram::with(['memberData' => function ($q) use ($request) {
                $q->where('last_name', $request['lastname']);
            }])->where('discount_id', $request['discount'])->first();

            if ($memberSearchByDiscountID != null) {
                if ($memberSearchByDiscountID->memberData != null) {
                    $memberSearchByDiscountID->is_used = true;
                    $memberSearchByDiscountID->used_at = $request['date'];
                    if ($request->has('phone')) {
                        $memberSearchByDiscountID->device = "phone";
                    }
                    $memberSearchByDiscountID->save();

                    $adminDiscount = AdminDiscountProgram::create([
                        'discount_id' => $request['discount'],
                        'last_used_at' => $request['date'],
                    ]);

                    return response()->json([
                        'message' => 'Success',
                        'status' => true,
                        'data' => $memberSearchByDiscountID
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Did not find any match',
                        'status' => false,
                        'data' => null
                    ], 200);
                }
            } else {
                return response()->json([
                    'message' => 'Did not find any match',
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

    public function submitRecord(Request $request)
    {
        
        // Save Start //

        if ($request['button_type'] == 'save') {
            $validator = Validator::make($request->all(), [
                'member_id' => ['required'],
                'first_name' => ['required', 'string'],
                'last_name' => ['required', 'string'],
                'discount' => ['required', 'numeric', 'digits_between:2,4'],
            ]);
    
            if (!($validator->fails())) {
                if(!empty($request['member_id'])){
                    $memberUpdateData = Member::find($request['member_id'])
                    ->update([
                        'first_name' => $request['first_name'],
                        'last_name' => $request['last_name'],
                        'email' => $request['email']
                    ]);
                    if ($memberUpdateData == true) {
                        return response()->json([
                            'message' => 'Customer data updated successfully',
                            'status' => true,
                            'data' => $memberUpdateData
                        ], 200);
                    } else {
                        return response()->json([
                            'message' => 'May be something wrong happen',
                            'status' => false,
                            'data' => null
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'message' => 'You have to search a Customer first',
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


        // Search Start//

        if ($request['button_type'] == 'search') {

            $validator = Validator::make($request->all(), [
                'discount' => ['required', 'numeric', 'digits_between:2,4'],
            ]);
    
            if (!($validator->fails())) {
                $memberSearchByDiscountID = null;
                if($request['discount'] != null){
                    $memberSearchByDiscountID = DiscountProgram::where('discount_id',$request['discount'])
                        ->with('memberData')
                        ->first();
                }

                if ($memberSearchByDiscountID != null) {
                    return response()->json([
                        'message' => 'User found',
                        'status' => true,
                        'data' => $memberSearchByDiscountID
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Did not find any match',
                        'status' => false,
                        'data' => null
                    ], 200);
                }
            }else{
                return response()->json([
                    'message' => 'Validation error',
                    'status' => false,
                    'data' => $validator->messages()
                ], 200);
            }
        }


        // Search End //


        // Delete Start //

        if ($request['button_type'] == 'delete') {
            $validator = Validator::make($request->all(), [
                'member_id' => ['required'],
                'discount' => ['required', 'numeric', 'digits_between:2,4'],
            ]);
    
            if (!($validator->fails())) {

                $memberSearchByDiscountID = DiscountProgram::where([
                    'discount_id'       =>  $request['discount'],
                ])
                    //->with('memberData')
                    ->first();

                if ($memberSearchByDiscountID != null) {
                    $deleteConfirm = $memberSearchByDiscountID->delete();
                    
                    return response()->json([
                        'message' => 'Delete successfully',
                        'status' => true,
                        'data' => $memberSearchByDiscountID
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Did not find any match',
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


        // Delete End //
    }


    public function searchUser(Request $request)
    {
        $memberSearchByDiscountID = DiscountProgram::where('discount_id',$request['discount'])
            ->with('memberData')
            ->first();
        if($memberSearchByDiscountID != null){
            if($memberSearchByDiscountID->is_admin == true){
                $lastName = $memberSearchByDiscountID->memberData->last_name;
                return response()->json([
                    'message' => 'User Found',
                    'status' => true,
                    'data' => $lastName
                ], 200);
            } else if ($memberSearchByDiscountID->is_used == false){
                if ($memberSearchByDiscountID->memberData != null) {
                    $lastName = $memberSearchByDiscountID->memberData->last_name;
                    return response()->json([
                        'message' => 'User Found',
                        'status' => true,
                        'data' => $lastName
                    ], 200);
                }else{
                    return response()->json([
                        'message' => 'No user found with this discount',
                        'status' => false,
                        'data' => null
                    ], 200);
                }
            } else {
                return response()->json([
                    'message' => 'Sorry this Discount # has already been used.',
                    'status' => false,
                    'data' => null
                ], 200);
            }
        }else{
            return response()->json([
                'message' => 'No discount found',
                'status' => false,
                'data' => null
            ], 200);
        }
    }
}
