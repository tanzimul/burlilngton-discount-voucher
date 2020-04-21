<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\DiscountProgram;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff.index');
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
        //
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


    public function submitDiscount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount' => ['required', 'numeric', 'digits_between:2,4'],
            'lastname' => ['required', 'string'],
        ]);

        if (!($validator->fails())) {

            $memberSearchByDiscountID = DiscountProgram::with(['memberData' => function ($q) use ($request) {
                $q->where('last_name', $request['lastname']);
            }])
                ->where('discount_id', $request['discount'])
                ->first();

            if ($memberSearchByDiscountID != null) {
                if ($memberSearchByDiscountID->memberData != null) {
                    $memberSearchByDiscountID->is_used = true;
                    $memberSearchByDiscountID->used_at = $request['date'];
                    if ($request->has('phone')) {
                        $memberSearchByDiscountID->device = "phone";
                    }
                    $memberSearchByDiscountID->save();
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
                if(empty($request['member_id'])){
                    $memberUpdateData = Member::find($request['member_id'])
                    ->update([
                        'first_name' => $request['first_name'],
                        'last_name' => $request['last_name'],
                        'email' => $request['email']
                    ]);
                    //dd($memberUpdateData);
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
                'type' => ['required', 'string', 'min:1', 'max:1'],
                'discount' => ['required', 'numeric', 'digits_between:2,4'],
            ]);
    
            if (!($validator->fails())) {
                $membership_type = '';

                if ($request['type'] == 'r' || $request['type'] == 'R') {
                    $membership_type = 'Regular';
                } else if ($request['type'] == 's' || $request['type'] == 'S') {
                    $membership_type = 'Senior';
                } else if ($request['type'] == 'f' || $request['type'] == 'F') {
                    $membership_type = 'Flyer';
                } else {
                    return response()->json([
                        'message' => 'Please enter a valid customer type',
                        'status' => false,
                        'data' => null
                    ], 200);
                }

                $memberSearchByDiscountID = DiscountProgram::where([
                    'discount_id'       =>  $request['discount'],
                    'membership_type'   =>  $membership_type
                ])
                    ->with('memberData')
                    ->first();

                if ($memberSearchByDiscountID != null) {
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
                    //dd($deleteConfirm);
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
}
