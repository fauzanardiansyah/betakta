<?php

namespace App\Http\Controllers\Backend\Dpp\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ReportTrait;

class DppReportController extends Controller
{
    use ReportTrait;

    protected $results;

    public function index()
    {
        return view('backend/dpp/content-pages/reports.dpp-report');
    }

    public function generateReport(Request $request)
    {
        $data = [
            'id_dp'        => $request->id_dp,
            'jenis_report' => $request->jenis_report,
            'time_report'  => $request->time_report,
            'start_date'   => $request->start_date,
            'to_date'      => $request->to_date
        ];

        if($data['jenis_report'] == 1) {
            $this->results = $this->getMembersOfProvinceActiveTrait($data);
        } else if($data['jenis_report'] == 2) {
            $this->results = $this->getMembersOfProvinceNotActiveTrait($data);
        } else if($data['jenis_report'] == 3) {
            $this->results = $this->getMembersOfProvincePasiveTrait($data);
        }  else if($data['jenis_report'] == 4) {
            $this->results = $this->getPaymentsOfMembersProvinceTrait($data);
        } 
        
        if(!empty($this->results)) {
            return $this->results;
        } 
        
    }
}
