<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;


class DashboardAdministratorExport implements FromView, WithCustomStartCell
{
    use Exportable;
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function view(): View
    {
        return view('administrator/exports.dashboard-exports', [
            'data' => $this->data
        ]);
    }

    public function startCell(): string
    {
        return 'B3';
    }
}
