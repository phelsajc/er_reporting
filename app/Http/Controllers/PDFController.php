<?php

namespace App\Http\Controllers;
use App\Model\Diagnosis;
use App\Model\Diagnostic_m;
use App\Model\Prescriptions_m;
use App\Model\User;
use DB;

class PDFController extends Controller
{
    
    public function pdf()
    {
        $myPdf = new HomeInstructionCovidPdf();
        //$myPdf->Output('I', "HomeInstructionPdf.pdf", true);
        $myPdf->Output("HomeInstructionPdf.pdf", 'I');
            exit;   
    }

    public function printPrescription($pspat,$user_id)
    {
        //$getDoctor = trim($doctor);
        ///$query = Diagnosis::where(['ps_patregisgter'=>$pspat,'doctor'=>$getDoctor])->first();
        $query = Diagnosis::where(['ps_patregisgter'=>$pspat])->first();

        $data = array();
        $query_patient = DB::connection('pgsql')->select("select * from patients_1 where pk_pspatregisters='$pspat'");

       //$query_diagnosis = Diagnostic_m::Where(['pspat'=>$pspat,'doctor'=>$getDoctor])->get();
        $query_diagnosis = Diagnostic_m::Where(['pspat'=>$pspat])->get();


        //$query_prescription = Prescriptions_m::Where(['pspat'=>$pspat,'doctor'=>$getDoctor])->get();
        $query_prescription = Prescriptions_m::Where(['pspat'=>$pspat])->get();

       // $query_prescription_f = Prescriptions_m::Where(['pspat'=>$pspat,'doctor'=>$getDoctor,])->whereNotNull('frequency_txt')->get();
        $query_prescription_f = Prescriptions_m::Where(['pspat'=>$pspat])->whereNotNull('frequency_txt')->get();
       // $query_prescription_m = Prescriptions_m::Where(['pspat'=>$pspat,'doctor'=>$getDoctor,])->whereNull('frequency_txt')->get();
        $query_prescription_m = Prescriptions_m::Where(['pspat'=>$pspat])->whereNull('frequency_txt')->get();

        
        //$query_user = User::where('prcno', '01234')->first();

        
        $dctr_details = User::where(['id'=>$user_id])->first();
  
            /* $dctr_details = DB::connection('bizbox')->select(
                "SELECT PK_emdDoctors, dbo.udf_GetFullName(PK_emdDoctors) AS DoctorName, sp.description AS specialization, costreetbldg1 AS rm_loc, telefax, smsplusmobileno, prcno, ptrno
                FROM emdDoctors AS dc
                LEFT JOIN emdTempSpecializations AS sp
                ON dc.FK_emdTempSpecializations = sp.PK_emdTempSpecializations
                LEFT JOIN psPersonaldata AS dt
                ON dc.PK_emdDoctors = dt.PK_psPersonalData
                LEFT JOIN psDatacenter AS pd
                ON dc.PK_emdDoctors = pd.PK_psDatacenter
                WHERE  dbo.udf_GetFullName(PK_emdDoctors) = :dctr",
                ['dctr' => trim('BERGANTE, ANNILYN ALINCASTRE')]
            ); */


            $data['query_patient'] = $query_patient[0];
           // $data['doctor'] = $doctor;
            $data['dctr_details'] = $dctr_details;
            
        
       $data['query_prescription'] = $query_prescription;
       $data['f_size'] = sizeof($query_prescription_f);
       $data['m_size'] = sizeof($query_prescription_m);
        $data['query_diagnostic'] = $query_diagnosis;
        //$data['query_user'] = $query_user;        
        $data['query_diagnosis'] = $query_diagnosis;
        $data['diagnosis'] = $query;
        $myPdf = new CustomPrescription($data);
        $myPdf->Output('I', time()."-".$query_patient[0]->patientname.".pdf", true);
        //$myPdf->Output('F',"//192.168.70.205/UsersBackup/TEST UIPATH/");
        //$myPdf->Output('yourfilename.pdf','F');
        //$myPdf->Output('C:\Users\carlo\Documents\test\\'."carlo.pdf",'F'); 
        // $myPdf->Output('yourfilename.pdf','I'); 
        exit;   

    }

    
}
