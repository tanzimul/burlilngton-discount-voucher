<?php

namespace App\Exports;

use App\Models\DiscountProgramLog;
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
                'discounts' => DiscountProgramLog::with('memberData')
                    ->whereBetween('last_used_at', array($this->from, $this->to))
                    ->get(),
                'from' => $this->from,
                'to' => $this->to
            ]
        );
    }
}
