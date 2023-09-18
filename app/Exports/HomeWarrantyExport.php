<?php

namespace App\Exports;

use App\Models\HomeWarranty;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HomeWarrantyExport implements FromView, ShouldAutoSize, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    public function headings(): array
    {
        return [
			'RecordID',
            'HRMS ID',
            'PSEUDO NAME',
            'FIRST NAME',
            'LAST NAME',
            'PHONE',
            'STATE',
            'CLIENT',
            'CREATED DATE',
            'STATUS'
        ];
    }
    public function view(): View
    {
        $request = $this->request;
        $query = new HomeWarranty;
        if ($request->has('start_date')) {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query = $query->whereDate('created_at', '>=', $request->start_date);
                $query = $query->whereDate('created_at', '<=', $request->end_date);
            } elseif (!empty($request->start_date)) {
                $query = $query->whereDate('created_at', $request->start_date);
            }
            $home_warranties = $query->get();
        }
        if ($request->has('phone')) {
            if (!empty($request->phone)) {
                $query = $query->where('phone', 'LIKE', "$request->phone");
            }
            $home_warranties = $query->get();
        }
        $home_warranties = $query->get();
        return view('admin.home-warranties.sales-report', [
            'home_warranties' => $home_warranties
        ]);
    }
}
