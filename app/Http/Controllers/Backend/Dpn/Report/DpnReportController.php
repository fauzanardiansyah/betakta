<?php

namespace App\Http\Controllers\Backend\Dpn\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ReportTraitDpn;

class DpnReportController extends Controller
{
    use ReportTraitDpn;

    protected $results;

    public function index()
    {
        $provinsi = \App\Provinsi::all();
        return view('backend/dpn/content-pages/reports.dpn-report', compact('provinsi'));
    }

    public function generateReport(Request $request)
    {
        
        $data = [
            'id_dp'        => $request->id_dp,
            'jenis_report' => $request->jenis_report,
            'time_report'  => $request->time_report,
            'start_date'   => $request->start_date,
            'to_date'      => $request->to_date,
            'provinsi'     => $request->provinsi,
            'jenis_pengajuan'=>$request->jenis_pengajuan,
            'kualifikasi' =>$request->kualifikasi
        ];

        

        if($data['jenis_report'] == 1) {
            $this->results = $this->getMembersOfProvinceActiveTrait($data);
        } else if($data['jenis_report'] == 2) {
            $this->results = $this->getMembersOfProvinceNotActiveTrait($data);
        } else if($data['jenis_report'] == 3) {
            $this->results = $this->getMembersOfProvincePasiveTrait($data);
        }  else if($data['jenis_report'] == 4) {
            $this->results = $this->getPaymentsOfRoleSharingTrait($data);
        }  else if($data['jenis_report'] == 5) {
            $this->results = $this->getPaymentsOfMembersAffiliationTrait($data);
        } 
        
        if(!empty($this->results)) {
            return $this->results;
        } 
        
    }
}
