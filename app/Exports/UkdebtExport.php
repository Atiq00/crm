<?php

namespace App\Exports;

use App\Models\UkDebt;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UkdebtExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;
        $query = new UkDebt;
        if ($request->has('start_date')) {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query = $query->whereDate('created_at', '>=', $request->start_date);
                $query = $query->whereDate('created_at', '<=', $request->end_date);
            } elseif (!empty($request->start_date)) {
                $query = $query->whereDate('created_at', $request->start_date);
            }
            $uk = $query->get();
        }
        if ($request->has('phone')) {
            if (!empty($request->phone)) {
                $query = $query->where('phone', 'LIKE', "%{$request->phone}%");
            }
            $uk = $query->get();
        }
        $uk = $query->get();
        return view('admin.ukdebt.sales-report', [
            'uk' => $uk
        ]);
    }
}
