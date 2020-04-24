<?php

namespace App\Exports;

use App\Models\DiscountProgram;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RedemptionTransactionsExport implements FromView
{
    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function view(): View
    {
        return view(
            'pdfs.redemption',
            [
                'discounts' => DiscountProgram::with('memberData')
                    ->where(['is_used' => 1])
                    ->whereBetween('used_at', array($this->from, $this->to))
                    ->get(),
                'from' => $this->from,
                'to' => $this->to
            ]
        );
    }
}
