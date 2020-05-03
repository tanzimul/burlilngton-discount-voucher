<?php

namespace App\Exports;

use App\Models\Member;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MembersExport implements FromView
{
    public function view(): View
    {
        return view('pdfs.customer', ['customers' => Member::all()]);
    }
}
