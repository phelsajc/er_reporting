<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Diagnosis;
use App\Model\Patient;
use App\User;
use App\Model\Prescriptions_m;
use Intervention\Image\ImageManagerStatic as Image;
use DB;

class PatientController extends Controller
{
    
    public function filterEmployee_test(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $length = 10;
        $start = $request->start?$request->start:0;
        $val = $request->searchTerm2;
        $dd=1;
        if($val!=''||$start>0){   
            $dd =  "select * from patients_1 where patientname ilike '%".$val."%' and cast(registrydate as date) >= '".date('Y-m-d', strtotime('-3 days'))."' LIMIT $length offset $start";
            $data =  DB::connection('pgsql')->select("select * from patients_1 where patientname ilike '%".$val."%' and cast(registrydate as date) >= '".date('Y-m-d', strtotime('-3 days'))."' LIMIT $length offset $start");
            $count =  DB::connection('pgsql')->select("select * from patients_1 where patientname ilike '%".$val."%' and cast(registrydate as date) >= '".date('Y-m-d', strtotime('-3 days'))."' ");
        }else{
            $data =  DB::connection('pgsql')->select("select * from patients_1 where cast(registrydate as date) >= '".date('Y-m-d', strtotime('-3 days'))."' LIMIT $length");
            $count =  DB::connection('pgsql')->select("select * from patients_1 where cast(registrydate as date) >= '".date('Y-m-d', strtotime('-3 days'))."'");
        }
        
        $count_all_record =  DB::connection('pgsql')->select("select count(*) as count from patients_1 where cast(registrydate as date) >= '".date('Y-m-d', strtotime('-3 days'))."'");

        $data_array = array();

        foreach ($data as $key => $value) {
            $arr = array();
            $checkDetails = Diagnosis::where(['ps_patregisgter'=>$value->pk_pspatregisters])->first();
            $arr['patientname'] =  $value->patientname;
            if($value->attending_phy){
                $physicians = DB::connection('bizbox_uk')->select("select dbo.udf_ConcatAllPatientsDoctor($value->pk_pspatregisters) as d"); 
                $arr['attending_phy'] =  $physicians[0]->d;
            }else{
                $arr['attending_phy'] =  "";
            }
            $arr['chiefcomplaint'] =  $value->chiefcomplaint;
            $arr['pk_pspatregisters'] =  $value->pk_pspatregisters;
            $arr['patientid'] =  $value->patientid;
            $arr['sex'] =  $value->sex;
            $arr['hasdetails'] =  $checkDetails?true:false;

            $data_array[] = $arr;
        }
        /* if($val!=''||$start>0){   
            $data = DB::connection('bizbox_uk')->select("SELECT PK_psPatRegisters,
            CAST(a.registrydate as varchar(30)) as registrydate,
            a.chiefcomplaint,
            CAST(dischdate as varchar(30)) as dischdate,
            a.registrystatus,
            dbo.udf_GetFullName(a.FK_emdPatients) PatientName,
            dbo.udf_GetPatID(a.FK_emdPatients) HospitalNo,
            d.gender,
            d.civilstatus,
            CAST(d.birthdate as varchar(30)) as birthdate,
            eg.FK_mscICD10Mstr as icd10Code, eg.description as icd10Description,
            (select
                top 1
                cc.PK_emdDoctors
                from emdDoctors cc
                inner join psDctrLedgers dd
                on   dd.FK_emdDoctors = cc.PK_emdDoctors
                where dd.fk_emdConsultantTypes = 1002
                and   dd.FK_psPatRegisters  = a.PK_psPatRegisters) AS AttendingDoctor,
            (select top 1 cc.PK_psDatacenter
                from emddoctors aa
                    inner join psdctrledgers bb
                    on aa.pk_emddoctors = bb.fk_emddoctors
                    inner join psdatacenter cc
                    on aa.pk_emddoctors = cc.pk_psdatacenter
                    where bb.fk_pspatregisters = a.PK_psPatRegisters and bb.fk_emdconsultanttypes = 1002) as dr_id
            FROM psPatRegisters a
            left join psPersonaldata d
            on d.PK_psPersonalData = a.FK_emdPatients
            left join psPatFinalDXDtls eg
            on eg.FK_psPatRegisters = a.PK_psPatRegisters
            WHERE a.pattrantype = 'O'
            AND   (registrystatus <> 'D' and registrystatus <> 'X')
            AND     dbo.udf_GetFullName(a.FK_emdPatients) like '%$val%'
            AND registrydate between cast(convert(char(30), getdate(), 112) + ' 00:00:00' as datetime) and cast(convert(char(30), getdate(), 112) + ' 23:59:59' as datetime)
            ORDER BY PatientName OFFSET $start ROWS FETCH NEXT $length ROWS ONLY
            ");

            $count =  DB::connection('bizbox_uk')->select("SELECT  PK_psPatRegisters,
            CAST(a.registrydate as varchar(30)) as registrydate,
            CAST(dischdate as varchar(30)) as dischdate,
            a.registrystatus,
            dbo.udf_GetFullName(a.FK_emdPatients) PatientName,
            dbo.udf_GetPatID(a.FK_emdPatients) HospitalNo,
            d.gender,
            d.civilstatus,
            CAST(d.birthdate as varchar(30)) as birthdate,
            eg.FK_mscICD10Mstr as icd10Code, eg.description as icd10Description,
            (select
                top 1
                cc.PK_emdDoctors
                from emdDoctors cc
                inner join psDctrLedgers dd
                on   dd.FK_emdDoctors = cc.PK_emdDoctors
                where dd.fk_emdConsultantTypes = 1002
                and   dd.FK_psPatRegisters  = a.PK_psPatRegisters) AS AttendingDoctor,
            (select top 1 cc.PK_psDatacenter
                from emddoctors aa
                    inner join psdctrledgers bb
                    on aa.pk_emddoctors = bb.fk_emddoctors
                    inner join psdatacenter cc
                    on aa.pk_emddoctors = cc.pk_psdatacenter
                    where bb.fk_pspatregisters = a.PK_psPatRegisters and bb.fk_emdconsultanttypes = 1002) as dr_id
            FROM psPatRegisters a
            left join psPersonaldata d
            on d.PK_psPersonalData = a.FK_emdPatients
            left join psPatFinalDXDtls eg
            on eg.FK_psPatRegisters = a.PK_psPatRegisters
            WHERE a.pattrantype = 'O'
            AND   (registrystatus <> 'D' and registrystatus <> 'X')
            AND     dbo.udf_GetFullName(a.FK_emdPatients) like '%$val%'
            AND registrydate between cast(convert(char(30), getdate(), 112) + ' 00:00:00' as datetime) and cast(convert(char(30), getdate(), 112) + ' 23:59:59' as datetime)
            ORDER BY PatientName");

        }else{
                $data = DB::connection('bizbox_uk')->select("SELECT TOP $length PK_psPatRegisters,
                CAST(a.registrydate as varchar(30)) as registrydate,
                a.chiefcomplaint,
                CAST(dischdate as varchar(30)) as dischdate,
                a.registrystatus,
                dbo.udf_GetFullName(a.FK_emdPatients) PatientName,
                dbo.udf_GetPatID(a.FK_emdPatients) HospitalNo,
                d.gender,
                d.civilstatus,
                CAST(d.birthdate as varchar(30)) as birthdate,
                eg.FK_mscICD10Mstr as icd10Code, eg.description as icd10Description,
                (select
                    top 1
                    cc.PK_emdDoctors
                    from emdDoctors cc
                    inner join psDctrLedgers dd
                    on   dd.FK_emdDoctors = cc.PK_emdDoctors
                    where dd.fk_emdConsultantTypes = 1002
                    and   dd.FK_psPatRegisters  = a.PK_psPatRegisters) AS AttendingDoctor,
                (select top 1 cc.PK_psDatacenter
                    from emddoctors aa
                        inner join psdctrledgers bb
                        on aa.pk_emddoctors = bb.fk_emddoctors
                        inner join psdatacenter cc
                        on aa.pk_emddoctors = cc.pk_psdatacenter
                        where bb.fk_pspatregisters = a.PK_psPatRegisters and bb.fk_emdconsultanttypes = 1002) as dr_id
                FROM psPatRegisters a
                left join psPersonaldata d
                on d.PK_psPersonalData = a.FK_emdPatients
                left join psPatFinalDXDtls eg
                on eg.FK_psPatRegisters = a.PK_psPatRegisters
                WHERE a.pattrantype = 'O'
                AND   (registrystatus <> 'D' and registrystatus <> 'X')
                AND     dbo.udf_GetFullName(a.FK_emdPatients) like '%$val%'
                AND registrydate between cast(convert(char(30), getdate(), 112) + ' 00:00:00' as datetime) and cast(convert(char(30), getdate(), 112) + ' 23:59:59' as datetime)
                ORDER BY PatientName 
                ");

            $count =  DB::connection('bizbox_uk')->select("SELECT  PK_psPatRegisters,
            CAST(a.registrydate as varchar(30)) as registrydate,
            CAST(dischdate as varchar(30)) as dischdate,
            a.registrystatus,
            dbo.udf_GetFullName(a.FK_emdPatients) PatientName,
            dbo.udf_GetPatID(a.FK_emdPatients) HospitalNo,
            d.gender,
            d.civilstatus,
            CAST(d.birthdate as varchar(30)) as birthdate,
            eg.FK_mscICD10Mstr as icd10Code, eg.description as icd10Description,
            (select
                  top 1
                  cc.PK_emdDoctors
                from emdDoctors cc
                  inner join psDctrLedgers dd
                   on   dd.FK_emdDoctors = cc.PK_emdDoctors
                where dd.fk_emdConsultantTypes = 1002
                  and   dd.FK_psPatRegisters  = a.PK_psPatRegisters) AS AttendingDoctor,
            (select top 1 cc.PK_psDatacenter
                from emddoctors aa
                    inner join psdctrledgers bb
                    on aa.pk_emddoctors = bb.fk_emddoctors
                    inner join psdatacenter cc
                    on aa.pk_emddoctors = cc.pk_psdatacenter
                    where bb.fk_pspatregisters = a.PK_psPatRegisters and bb.fk_emdconsultanttypes = 1002) as dr_id
            FROM psPatRegisters a
            left join psPersonaldata d
            on d.PK_psPersonalData = a.FK_emdPatients
            left join psPatFinalDXDtls eg
            on eg.FK_psPatRegisters = a.PK_psPatRegisters
            WHERE a.pattrantype = 'O'
            AND   (registrystatus <> 'D' and registrystatus <> 'X')
            AND     dbo.udf_GetFullName(a.FK_emdPatients) like '%$val%'
            AND registrydate between cast(convert(char(30), getdate(), 112) + ' 00:00:00' as datetime) and cast(convert(char(30), getdate(), 112) + ' 23:59:59' as datetime)
            ORDER BY PatientName");
        } */
        $page = sizeof($count)/$length;
        $getDecimal =  explode(".",$page);
        $page_count = round(sizeof($count)/$length);
        if(sizeof($getDecimal)==2){            
            if($getDecimal[1]<5){
                $page_count = $getDecimal[0] + 1;
            }
        }
        $datasets = array(["ddd"=>$data,"md"=>date('Y-m-d', strtotime('-4 days')),"data"=>$data_array,"count"=>$page_count,"showing"=>"Showing ".(($start+10)-9)." to ".($start+10>$count_all_record[0]->count?$count_all_record[0]->count:$start+10)." of ".$count_all_record[0]->count, "patient"=>$data_array]);
        return response()->json($datasets);
    }

    public function filterEmployee(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $length = 10;
        $start = $request->start?$request->start:0;
        $val = $request->searchTerm2;
        $dd=1;
        if($val!=''||$start>0){   
            $dd =  "select * from patients_1 where patientname ilike '%".$val."%' and cast(registrydate as date) >= '".date("Y-m-d")."' LIMIT $length offset $start";
            //$data =  DB::connection('pgsql')->select("select * from patients_1 where patientname ilike '%".$val."%' and cast(registrydate as date) >= '".date("Y-m-d")."' LIMIT $length offset $start"); 
            $data =  DB::connection('pgsql')->select("select p.* from patients_1 p left join diagnose d on p.pk_pspatregisters = d.ps_patregisgter 
            where p.patientname ilike '%".$val."%' and cast(p.registrydate as date) >= '".date("Y-m-d")."' order by d.id asc LIMIT $length offset $start");
            
            //$count =  DB::connection('pgsql')->select("select * from patients_1 where patientname ilike '%".$val."%' and cast(registrydate as date) >= '".date("Y-m-d")."' ");
            $count =  DB::connection('pgsql')->select("select p.* from patients_1 p left join diagnose d on p.pk_pspatregisters = d.ps_patregisgter 
            where p.patientname ilike '%".$val."%' and cast(p.registrydate as date) >= '".date("Y-m-d")."' order by d.id asc");
        }else{
            /* $data =  DB::connection('pgsql')->select("select * from patients_1 where cast(registrydate as date) >= '".date("Y-m-d")."' LIMIT $length");
            $count =  DB::connection('pgsql')->select("select * from patients_1 where cast(registrydate as date) >= '".date("Y-m-d")."'"); */
            $data =  DB::connection('pgsql')->select("select p.* from patients_1 p left join diagnose d on p.pk_pspatregisters = d.ps_patregisgter 
            where p.patientname ilike '%".$val."%' and cast(p.registrydate as date) >= '".date("Y-m-d")."' order by d.id asc LIMIT $length");
            $count =  DB::connection('pgsql')->select("select p.* from patients_1 p left join diagnose d on p.pk_pspatregisters = d.ps_patregisgter 
            where p.patientname ilike '%".$val."%' and cast(p.registrydate as date) >= '".date("Y-m-d")."' order by d.id asc");
        }
        
        $count_all_record =  DB::connection('pgsql')->select("select count(*) as count from patients_1 where cast(registrydate as date) >= '".date("Y-m-d")."'");

        $data_array = array();

        foreach ($data as $key => $value) {
            $arr = array();
            $checkDetails = Diagnosis::where(['ps_patregisgter'=>$value->pk_pspatregisters])->first();

            
            $check_medicines = Prescriptions_m::where(['pspat'=>$value->pk_pspatregisters])->get();
            $arr['patientname'] =  $value->patientname;
            /* if($value->attending_phy){
                $physicians = DB::connection('bizbox_uk')->select("select dbo.udf_ConcatAllPatientsDoctor($value->pk_pspatregisters) as d"); 
                $arr['attending_phy'] =  $physicians[0]->d;
            }else{
                $arr['attending_phy'] =  "";
            } */
            $arr['attending_phy'] =  "";
            $arr['chiefcomplaint'] =  $value->chiefcomplaint;
            $arr['pk_pspatregisters'] =  $value->pk_pspatregisters;
            $arr['patientid'] =  $value->patientid;
            $arr['sex'] =  $value->sex;
            $arr['hasdetails'] =  $checkDetails?true:false;
            $arr['cnt_meds'] =  sizeof($check_medicines);
            $arr['dctr'] =  sizeof($check_medicines)>0?$check_medicines[0]->created_by:0;
            

            $data_array[] = $arr;
        }
        $page = sizeof($count)/$length;
        $getDecimal =  explode(".",$page);
        $page_count = round(sizeof($count)/$length);
        if(sizeof($getDecimal)==2){            
            if($getDecimal[1]<5){
                $page_count = $getDecimal[0] + 1;
            }
        }
        $datasets = array(["data"=>$data_array,"count"=>$page_count,"showing"=>"Showing ".(($start+10)-9)." to ".($start+10>$count_all_record[0]->count?$count_all_record[0]->count:$start+10)." of ".$count_all_record[0]->count, "patient"=>$data_array]);
        return response()->json($datasets);
    }
    
    public function check_doctors_detail($id)
    { 
        $physicians = DB::connection('bizbox_uk')->select("select dbo.udf_ConcatAllPatientsDoctor($id) as d"); 
        return response()->json($physicians[0]->d);
    }

    public function saveInitialData(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $checkDetails = Diagnosis::where(['ps_patregisgter'=>$request->pspat])->first();
        if(!$checkDetails){
            $diagnosis = new Diagnosis;
            $diagnosis->o2_stat = $request->o2_stat;
            $diagnosis->temp = $request->temp;
            $diagnosis->bp = $request->bp;
            $diagnosis->weight = $request->weight;
            $diagnosis->height = $request->height;
            $diagnosis->chiefcomplaints = $request->chiefcomplaints;
            $diagnosis->pulse_rate = $request->pulse_rate;
            $diagnosis->patientid = $request->patientid;
            $diagnosis->rr = $request->rr;
            $diagnosis->ps_patregisgter = $request->pspat;
            $diagnosis->inserted_initial_data_dt = date("Y-m-d H:i");
            $diagnosis->inserted_initial_data_by = $request->user_id;   
            $diagnosis->save();    
        }else{
            Diagnosis::where(['ps_patregisgter'=>$request->pspat])->update([
                'o2_stat'=> $request->o2_stat,
                'temp'=> $request->temp,
                'bp'=> $request->bp,
                'weight'=>  $request->weight,
                'height'=> $request->height,
                'chiefcomplaints'=> $request->chiefcomplaints,
                'pulse_rate'=> $request->pulse_rate,
                'rr'=> $request->rr,
            ]);
        }
        
        return true;
    }

    public function getPxInfo($pspat)
    {
        $data = Patient::where(['pk_pspatregisters'=>$pspat])->first();
        return response()->json($data);
    }

    public function EditInitialData($id)
    {
        $data = Diagnosis::where(['ps_patregisgter'=>$id])->first();
        return response()->json($data);
    }
    
    public function upDateHPE(Request $request)
    {
        $getUser = User::where(['id'=>$request->user_id])->first();
        Diagnosis::where(['ps_patregisgter'=>$request->pspat])->update([
            'history'=> $request->historyPe,
            'diagosis'=> $request->diagnosis,
            'pe'=> $request->pe,
            'remarks'=> $request->remarks,
            'doctor'=>  $getUser->name,
            'followup'=>  $request->followup,
            'followup_place'=>  $request->followup_place,
        ]);
        return 123;// $request->pspat;
    }

    public function getDiagnosisInfo($pspat)
    {
        $data = Diagnosis::where(['ps_patregisgter'=>$pspat])->first();
        return response()->json($data);
    }

   
}
