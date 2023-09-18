<?php

namespace App\Exports;

use App\Models\CRU;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CRUExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;
        $query = new CRU;
        if ($request->has('start_date')) {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query = $query->whereDate('created_at', '>=', $request->start_date);
                $query = $query->whereDate('created_at', '<=', $request->end_date);
            } elseif (!empty($request->start_date)) {
                $query = $query->whereDate('created_at', $request->start_date);
            }
            $cru = $query->select('id','agent_name','record_id','created_at')->selectRaw('min(created_at) as date')->groupby('record_id')
            ->whereDate('created_at',">=",$request->start_date)->whereDate('created_at',"<=",$request->end_date)->get();
        }
        if ($request->has('record_id')) {
            if (!empty($request->record_id)) {
                $query = $query->where('record_id', 'LIKE', "%{$request->record_id}%");
            }
            $cru = $query->select('id','agent_name','record_id','created_at')->selectRaw('min(created_at) as date')->groupby('record_id')->get();
        }
        $cru = $query->select('id','agent_name','record_id','created_at')->selectRaw('min(created_at) as date')->groupby('record_id')->get();

        return view('admin.CRU.sales-report-cru', [
            'cru' => $cru
        ]);
    }
}
