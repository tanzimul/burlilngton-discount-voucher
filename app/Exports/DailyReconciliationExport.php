<?php

namespace App\Exports;

use App\Models\DiscountProgram;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DailyReconciliationExport implements FromView
{
    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function view(): View
    {
        $discounts = DiscountProgram::with('memberData')
            ->where(['is_used' => 1, 'used_at' => $this->date])
            // ->whereBetween('used_at', array($this->from, $this->to))
            ->get();
        $paperRegular = array();
        $phoneRegular = array();
        $paperSenior = array();
        $phoneSenior = array();
        $flyer = array();
        $adminDiscount = array();

        //dd(count($discounts->device));
        foreach ($discounts as $key => $discount) {
            if($discount->membership_type == 'regular'){
                if( $discount->device == 'paper'){
                    $paperRegular[$key] = $discount->device;
                }else {
                    $phoneRegular[$key] = $discount->device;
                }
            }else if($discount->membership_type == 'senior'){
                if( $discount->device == 'paper'){
                    $paperSenior[$key] = $discount->device;
                }else {
                    $phoneSenior[$key] = $discount->device;
                }
            }else if($discount->membership_type == 'flyer'){
                $flyer[$key] = $discount->id;
            }else if($discount->discount_id == 9999){
                $adminDiscount[$key] = $discount->id;
            }
            
            
        }
        $paperRegularCount = count($paperRegular);
        $phoneRegularCount = count($phoneRegular);
        $paperSeniorCount = count($paperSenior);
        $phoneSeniorCount = count($phoneSenior);
        $flyerCount = count($flyer);
        $adminDiscountCount = count($adminDiscount);

        $sumOfRegular = $paperRegularCount+$phoneRegularCount;
        $sumOfSenior = $paperSeniorCount+$phoneSeniorCount;
        $sumOfFlyer = $flyerCount;
        $sumOfAdminDiscount = $adminDiscountCount;

        $totalPaper = $paperRegularCount+$paperSeniorCount;
        $totalPhone = $phoneRegularCount+$phoneSeniorCount;
        $subTotal = $sumOfRegular+$sumOfSenior+$sumOfFlyer+$sumOfAdminDiscount;


        //dd($paperRegularCount);
        return view(
            'pdfs.reconciliation',
            [
                'date' => $this->date,
                'paperRegularCount' => $paperRegularCount,
                'phoneRegularCount' => $phoneRegularCount,
                'paperSeniorCount' => $paperSeniorCount,
                'phoneSeniorCount' => $phoneSeniorCount,
                'flyerCount' => $flyerCount,
                'adminDiscountCount' => $adminDiscountCount,
                'sumOfRegular' => $sumOfRegular,
                'sumOfSenior' => $sumOfSenior,
                'sumOfFlyer' => $sumOfFlyer,
                'sumOfAdminDiscount' => $sumOfAdminDiscount,
                'totalPaper' => $totalPaper,
                'totalPhone' => $totalPhone,
                'subTotal' => $subTotal,
            ]
        );
    }
}
