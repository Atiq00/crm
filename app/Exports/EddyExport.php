<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EddyExport implements FromView,ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;
        $eddy = DB::table('eddy_sales');
        if ($request->agent_id)
            {$eddy = $eddy->where('agent_id', $request->agent_id);}
        if ($request->date)
            {$eddy = $eddy->whereDate('sale_date', $request->date);}
        if ($request->type)
            {$eddy = $eddy->where('type', $request->type);}
            $eddy = $eddy->get();
        return view('admin.eddy-sales.eddy-export', [
            'eddy' => $eddy,
        ]);
    }
}
