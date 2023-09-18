<?php

namespace App\Services;

use App\Models\EmployeeHeadcount;
use Illuminate\Support\Facades\Http;

class SyncUserHeadcount
{
    public function users()
    {
        $xml = Http::get('https://touchstone.smarthcm.com/ws/SmartHCMWS.asmx/GetEmployeeDetailList_SecurityCode?SecurityKey=admin@123&langCode=en_US')->body();
        $result = str_replace('diffgr:', 'DiffID', $xml);
        $xmlObject = simplexml_load_string($result);
        $result = json_decode(json_encode($xmlObject));
        $hcm_users = $result->DiffIDdiffgram->NewDataSet->EmpTable;
        foreach ($hcm_users as $hcm_user) {
            if ($hcm_user->EMPLOYEE_ID > 0) {
                $user = EmployeeHeadcount::where('hrms_id', $hcm_user->EMPLOYEE_ID)->first();
                if (!$user) {
                    $user = new EmployeeHeadcount();
                }
                $user->hrms_id = $hcm_user->EMPLOYEE_ID;
                $user->auto_hrms_id = $this->convertCnicToHrmsId(@$hcm_user->CNIC);
                $user->reporting_to = $hcm_user->REPORTING_TO_ID ?? 0;
                $user->first_name = $hcm_user->FIRST_NAME ?? '-';
                $user->middle_name = $hcm_user->MIDDLE_NAME ?? '-';
                $user->last_name = $hcm_user->LAST_NAME ?? '-';
                $user->email = $hcm_user->EMAIL_ADDRESS ?? '-';
                $user->status = $hcm_user->EMPLOYEE_STATUS ?? '';
                $user->campaign = $hcm_user->COMPAIGN ?? '-';
                $user->designation = $hcm_user->DESIGNATION ?? '-';
                $user->reporting_name = $hcm_user->REPORTING_TO_NAME ?? '-';
                $user->birth_date = date('Y-m-d', strtotime($hcm_user->BIRTH_DATE)) ?? '';
                $user->cnic = $hcm_user->CNIC ?? 0;
                $user->pseudo_name = $hcm_user->PSEUDO_NAME ?? '-';
                $user->joining_date = date('Y-m-d', strtotime($hcm_user->JOINING_DATE)) ?? '';
                $user->retirement_date = date('Y-m-d', strtotime($hcm_user->RETIREMENT_DATE)) ?? '';
                $user->save();
            }
        }
    }

    public function convertCnicToHrmsId($cnic)
    {
        if ($cnic > 0) {
            $user_cnic = str_replace('-', '', $cnic);
            $hrms_id = substr($user_cnic, 7, 6);
            return $hrms_id;
        } else {
            $hrms_id = 0;
            return $hrms_id;
        }
    }
}
