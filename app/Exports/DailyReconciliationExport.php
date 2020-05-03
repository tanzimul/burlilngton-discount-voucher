<?php

namespace App\Exports;

use App\Models\DiscountProgramLog;
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
        $discounts = DiscountProgramLog::with('memberData')
            ->where('last_used_at', $this->date)
            ->get();
        $paperRegular = array();
        $phoneRegular = array();
        $paperSenior = array();
        $phoneSenior = array();
        $flyer = array();
        // $adminDiscount = array();

        //dd(count($discounts->device));
        foreach ($discounts as $key => $discount) {
            if($discount->memberData->membership_type == 'regular'){
                if( $discount->memberData->device == 'paper'){
                    $paperRegular[$key] = $discount->memberData->device;
                }else {
                    $phoneRegular[$key] = $discount->memberData->device;
                }
            }else if($discount->memberData->membership_type == 'senior'){
                if( $discount->memberData->device == 'paper'){
                    $paperSenior[$key] = $discount->memberData->device;
                }else {
                    $phoneSenior[$key] = $discount->memberData->device;
                }
            }else if($discount->memberData->membership_type == 'flyer'){
                $flyer[$key] = $discount->memberData->id;
            }
            // else if($discount->discount_id == 9999){
            //     $adminDiscount[$key] = $discount->id;
            // }
            
            
        }
        $paperRegularCount = count($paperRegular);
        $phoneRegularCount = count($phoneRegular);
        $paperSeniorCount = count($paperSenior);
        $phoneSeniorCount = count($phoneSenior);
        $flyerCount = count($flyer);
        // $adminDiscountCount = count($adminDiscount);

        $sumOfRegular = $paperRegularCount+$phoneRegularCount;
        $sumOfSenior = $paperSeniorCount+$phoneSeniorCount;
        $sumOfFlyer = $flyerCount;
        // $sumOfAdminDiscount = $adminDiscountCount;

        $totalPaper = $paperRegularCount+$paperSeniorCount;
        $totalPhone = $phoneRegularCount+$phoneSeniorCount;
        // $subTotal = $sumOfRegular+$sumOfSenior+$sumOfFlyer+$sumOfAdminDiscount;
        $subTotal = $sumOfRegular+$sumOfSenior+$sumOfFlyer;


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
                // 'adminDiscountCount' => $adminDiscountCount,
                'sumOfRegular' => $sumOfRegular,
                'sumOfSenior' => $sumOfSenior,
                'sumOfFlyer' => $sumOfFlyer,
                // 'sumOfAdminDiscount' => $sumOfAdminDiscount,
                'totalPaper' => $totalPaper,
                'totalPhone' => $totalPhone,
                'subTotal' => $subTotal,
            ]
        );
    }
}
