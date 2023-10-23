<?php

namespace App\Http\Controllers;
use DB;
use App\Model\Prescriptions_m;
use App\Model\Inquiry;
use App\Model\Frequency;
use App\Model\Diagnostic_m;
use App\Model\Patient;
use App\Model\Customer;
use App\User;
use App\Model\trans_m;
use App\Model\trans_d;
use App\Model\Basket;
use App\Model\Basket_detail;
use Illuminate\Http\Request;


class PrescriptionController extends Controller
{
    public function store(Request $request,$selectedMethod,$pspat,$diagnosis_id)
    {
        # $selectedMethod 1 = meal
        # $selectedMethod 2 = frequency
        date_default_timezone_set('Asia/Manila');
        $getUser = User::where(['id'=>$request->dctr])->first();
        $request['created_by'] =  $request->dctr;
        $request['created_at'] = date("Y-m-d");
        $request['pspat'] = $pspat;
        $request['doctor'] = $getUser->name;
        $request['diagnosis_id'] = $diagnosis_id;
        $request['medecine_desc'] = $request->item_description?$request->item_description:$request->not_bn; 
        $request['generic_name'] = $request->item_generic_name?$request->item_generic_name:$request->not_gn;
        $request['dosage'] = $request->not_dsg?$request->not_dsg:0;
        $request['bf_time'] = is_array($request->breakFast)?$request->breakFast['hh'].':'.$request->breakFast['mm'].' '.$request->breakFast['A']:$request->breakFast;
        $request['sp_time'] = is_array($request->supper)?$request->supper['hh'].':'.$request->supper['mm'].' '.$request->supper['A']:$request->supper;
        $request['ln_time'] = is_array($request->lunch)?$request->lunch['hh'].':'.$request->lunch['mm'].' '.$request->lunch['A']:$request->lunch;
        $request['bbt_time'] = is_array($request->bbt_time)?$request->bbt_time['hh'].':'.$request->bbt_time['mm'].' '.$request->bbt_time['A']:$request->bbt_time;
        $request['quantity'] = $request->qty;
        $request['price'] = $request->reg_p;
        $request['dc_price'] = $request->dsc_p;
        $request['sc_price'] = $request->src_p;
        //$ff_duedate = date_format(date_create($request->dueDateF),'Y-m-d');
        $request['due'] = $selectedMethod == 1?date_format(date_create($request->dueDate),'Y-m-d'):date_format(date_create($request->dueDateF),'Y-m-d');
        //$request['due'] = $selectedMethod == 1?date_format(date_create($request->dueDate),'Y-m-d'):date('Y-m-d', strtotime($ff_duedate. ' + '.$request['days'].' days'));
        if($selectedMethod == 2){
            $getF = Frequency::where(['id'=>$request->frequency])->first();
            $request['time'] = $getF->timing_dosage;
            $request['frequency_txt'] = $getF->frequency;
            $request['quantity'] = $request->qtyF;
            $request['days'] = $request->daysF;
        }
        $data = Prescriptions_m::create($request->except('_token'));
        $Inquiry = new Inquiry;
        $reg_p = $request->notCarried?0:$request->reg_p;
        $dsc_p = $request->notCarried?0:$request->dsc_p;
        $sc_p =  $request->notCarried?0:$request->src_p;
        $reg_p = $request->reg_p;
        $dsc_p = $request->dsc_p;
        $sc_p = $request->src_p;
        $getQty = 0;
        if($selectedMethod == 1){
            $qty = floatval($request->qty);// * floatval($request->days);
            /* if($request->iscustom){
                $qty = 0;
            } */
            $getQty = $qty;
        }else if($selectedMethod == 2){
            $qty = floatval($request->qtyF);// * floatval($request->days);//SUBJECT TO CHANGE DUE TO NOT APPLICABLE TO SOME CASES
            /* if($request->iscustom){
                $qty = 0;
            } */
            $getQty = $qty;
        }
        $Inquiry->pk_iwitems = $request->notCarried?0:$request->pk_iwitems;
        $Inquiry->item_description =$request->item_description?$request->item_description:$request->not_bn; // $request->item_description;
        $Inquiry->item_generic_name = $request->item_generic_name?$request->item_generic_name:$request->not_gn;//$request->item_generic_name;
        $Inquiry->item_reg_price = $reg_p;
        $Inquiry->item_discounted_price = $dsc_p;
        $Inquiry->item_sc_price = $sc_p;
        $Inquiry->doctor = trim($getUser->name);
        $Inquiry->item_qty =  floatval($getQty);
        $total_amt_reg = number_format((float)$reg_p, 2, '.', '') * floatval($getQty);//floatval($reg_p) * floatval($qty);
        $total_amt_dsc = number_format((float)$dsc_p, 2, '.', '') * floatval($getQty);//floatval($total_amt_reg) * floatval(0.80);
        $total_amt_sc = number_format((float)$sc_p, 2, '.', '') * floatval($getQty);//floatval($total_amt_dsc) / floatval(1.12);
        $Inquiry->item_total_amt_reg = $total_amt_reg;
        $Inquiry->item_total_amt_disc = $total_amt_dsc;
        $Inquiry->item_total_amt_sc_disc = $total_amt_sc;
        $Inquiry->transaction_id = $diagnosis_id;
        $Inquiry->prescription_id = $data->prescription_id;
        $Inquiry->ancillary_location = 1;
        $Inquiry->pspat = $pspat;
        $Inquiry->created_at = date('Y-m-d H:i');
        $Inquiry->inserted_by = $request->dctr;
        
        $Inquiry->save();
        echo $selectedMethod ;//$data->prescription_id;
    }

    public function getrequency()
    {
        $data = Frequency::all();
        return response()->json($data);
    }
    
    public function show_frequency($id)
    {
        $data = Frequency::where(["id"=>$id])->first();
        return response()->json($data);
    }

    public function getPrescribeMedicine($id)
    {
        //$query = Prescriptions_m::where('pspat', $id)->where('doctor',trim($request->getDoctor))->get();
        $query = Prescriptions_m::where('pspat', $id)->get();
        $data = array();
        foreach ($query as $key ) {
            $arr = array();
            $arr['id'] = $key->prescription_id;
            $arr['med_id'] = $key->medecine_id;
            $arr['med_desc'] = $key->medecine_desc;
            $arr['med_gen_name'] = "(".strtolower($key->generic_name).")";
            $arr['dosage'] = $key->dosage;
            $arr['instruction'] = $key->instruction;
            $arr['frequency_txt'] = $key->frequency_txt;
            $arr['quantity'] = $q = $key->quantity;
            $arr['days'] = $key->days;
            $arr['method'] = $key->frequency_txt? 2:1;
            $button = '';
            $button = $button.'<button class="btn  btn-sm btn-primary" title="Edit Prescriptions" onclick="edit_med('."'".$key->prescription_id."'".')"><i class="fa fa-edit" ></i></button>  ';
            $button = $button.'<button type="button" class="btn btn-sm  btn-danger" id="openModalMedicine" title="Remove Prescriptions" onclick="remove_med('."'".$key->prescription_id."'".')"><i class="fa fa-times" ></i> </button> ';
            $arr['actions'] = $button;
            $data[] = $arr;

        }
        return response()->json($data);
    }

    public function getPrecriptionDetail($id)
    {
        $query = Prescriptions_m::where('prescription_id', $id)->first();
        return response()->json($query);
    }

    public function updateMedicine(Request $request,$selectedMethod,$prescription_id)
    {
        if($selectedMethod == 1){
            $qty = floatval($request->qty);
        }else if($selectedMethod == 2){
            $qty = floatval($request->qtyF);// * floatval($request->days);//SUBJECT TO CHANGE DUE TO NOT APPLICABLE TO SOME CASES
        }
        $book = Prescriptions_m::where(['prescription_id'=>$prescription_id])->update([
            'medecine_desc'=>$request->item_description,
            'medecine_id'=>$request->notCarried?0:$request->medecine_id,
            'generic_name'=>$request->item_generic_name,
            'dosage'=>$request->dosage,
            'instruction'=>$request->instruction,
            'bf_time'=>$request->breakFast,
            'ln_time'=>$request->lunch,
            'sp_time'=>$request->supper,
            'bbt_time'=>$request->bbt,
            'frequency'=>$request->selectedMethod == 2 ?$request->frequency:null,
            'frequency_txt'=>$request->selectedMethod == 2 ?$request->frequency_txt:null,
            'days'=>$request->selectedMethod == 2 ?$request->daysF:$request->days,
            'quantity'=>$request->selectedMethod == 2 ?$request->qtyF:$request->qty,
            'ispc'=>$request->ispc,
            'time'=>$request->time,
            'due'=>$request->selectedMethod == 2 ?$request->dueDateF:$request->dueDate,
            ]
        );
        $total_amt_reg = $request->notCarried?0:number_format((float)$request->price, 2, '.', '') * floatval($qty);
        $total_amt_dsc = $request->notCarried?0:number_format((float)$request->dc_price, 2, '.', '') * floatval($qty);
        $total_amt_sc = $request->notCarried?0:number_format((float)$request->sc_price, 2, '.', '') * floatval($qty);

        $inq = Inquiry::where(['prescription_id'=>$request->prescription_id])->update([
            'item_reg_price'=>$request->notCarried?0:floatval($request->price),
            'item_discounted_price'=>$request->notCarried?0:floatval($request->dc_price),
            'item_sc_price'=>$request->notCarried?0:floatval($request->sc_price),
            'item_qty'=>floatval($qty),
            'item_total_amt_reg'=>$total_amt_reg,
            'item_total_amt_disc'=>$total_amt_dsc,
            'item_total_amt_sc_disc'=>$total_amt_sc,
            'item_description'=>$request->medecine_desc,
            'item_generic_name'=>$request->generic_name,
            ]
        );
        $output = array("data" => $book,"inq"=>$inq);
		return true;
    }
    
    /* public function store_diagnostic(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = Diagnostic_m::create($request->except('_token'));
        $Inquiry = new Inquiry;
        $reg_p = $request->price;
        $dsc_p = $request->dc_price;//floatval($request->price) * floatval(0.80);
        $sc_p = $request->sc_price;//floatval($dsc_p) / floatval(1.12);
        if($request->selectedMethod == 'byMeal'){
            $qty = (floatval($request->bf_b) + floatval($request->bf_a) + floatval($request->ln_b) + floatval($request->ln_a) + floatval($request->sp_b) + floatval($request->sp_a) + floatval($request->bbt)) * floatval($request->days);
        }else if($request->selectedMethod == 'byfrequency'){
            $qty = floatval($request->quantity);// * floatval($request->days);//SUBJECT TO CHANGE DUE TO NOT APPLICABLE TO SOME CASES
        }

        $Inquiry->pk_iwitems = $request->diagnostic_code;//medecine_id;
        $Inquiry->item_description = $request->diagnostic;//medecine_desc;
        $Inquiry->item_generic_name = '';//generic_name;
        $Inquiry->item_reg_price = $reg_p;
        $Inquiry->item_discounted_price = 0.00;//$dsc_p;
        $Inquiry->item_sc_price = $sc_p;
        $Inquiry->doctor = trim($request->doctor);
        $Inquiry->item_qty = 1;// floatval($request->quantity);
        $total_amt_reg = $request->price;//number_format((float)$reg_p, 2, '.', '') * floatval($qty);//floatval($reg_p) * floatval($qty);
        $total_amt_dsc = 0.00;//number_format((float)$dsc_p, 2, '.', '') * floatval($qty);//floatval($total_amt_reg) * floatval(0.80);
        $total_amt_sc = $request->sc_price;//number_format((float)$sc_p, 2, '.', '') * floatval($qty);//floatval($total_amt_dsc) / floatval(1.12);
        $Inquiry->item_total_amt_reg = $total_amt_reg;
        $Inquiry->item_total_amt_disc = $total_amt_dsc;
        $Inquiry->item_total_amt_sc_disc = $total_amt_sc;
        $Inquiry->transaction_id = $request->diagnosis_id;
        $Inquiry->prescription_id = $data->diagnostic_id;
        $Inquiry->batch = $data->batch;
        $Inquiry->ancillary_location = 2;
        $Inquiry->pspat = $request->pspat;
        $Inquiry->save();
        echo $data;
    } */

    public function addDiagnostics(Request $request)
    {
        //return $request->dctr;
        foreach ($request->q as $key ) {
            $getUser = User::where(['id'=>$request->dctr])->first();

            
            $d = new Diagnostic_m;
            $d->instructions = $request->r;
            $d->diagnostic = $key['item_description'];
            $d->diagnostic_code = $key['pk_iwitems'];
            $d->doctor = trim($getUser->name);            
            $d->diagnosis_id = $request->diagnosisId;
            $d->pspat = $request->pspat;
            $d->created_at = date('Y-m-d H:i');
            $d->created_by = $request->dctr;         
            $d->save();

            
            $Inquiry = new Inquiry;
            $Inquiry->pk_iwitems = $key['pk_iwitems'];
            $Inquiry->item_description = $key['item_description'];
            //$Inquiry->item_generic_name = $key['item_generic_name'];
            $Inquiry->item_reg_price = array_key_exists("item_reg_price",$key)?$key['item_reg_price']:0; # to fix in 
            $Inquiry->item_discounted_price = 0;
            $Inquiry->item_sc_price = $key['item_sc_price'];
            $Inquiry->doctor = trim($getUser->name);
            $Inquiry->item_qty =  1;
            $Inquiry->item_total_amt_reg = array_key_exists("item_reg_price",$key)?$key['item_reg_price']:0; # to fix in vue
            $Inquiry->item_total_amt_disc = 0.00;
            $Inquiry->item_total_amt_sc_disc = $key['item_sc_price'];
            $Inquiry->transaction_id = $d->diagnostic_id;
            $Inquiry->ancillary_location = 2;
            $Inquiry->pspat = $request->pspat;
            $Inquiry->created_at = date('Y-m-d H:i');
            $Inquiry->inserted_by = $request->dctr;         
            $Inquiry->save();
        }
    } 

    public function getPrescribeLabs($id)
    {
        $query = Diagnostic_m::where('pspat', $id)->get();
        $data = array();
        foreach ($query as $key ) {
            $arr = array();
            $arr['id'] = $key->diagnostic_id;
            $arr['code'] = $key->diagnostic_code;
            $arr['diagnostic'] = $key->diagnostic;
            $arr['instruction'] = $key->instructions;
            /* $button = '';
            $button = $button.'<button class="btn  btn-sm btn-primary" title="Edit Prescriptions" onclick="edit_med('."'".$key->prescription_id."'".')"><i class="fa fa-edit" ></i></button>  ';
            $button = $button.'<button type="button" class="btn btn-sm  btn-danger" id="openModalMedicine" title="Remove Prescriptions" onclick="remove_med('."'".$key->prescription_id."'".')"><i class="fa fa-times" ></i> </button> ';
            $arr['actions'] = $button; */
            $data[] = $arr;
        }
        return response()->json($data);
    }

    public function destroyLab($id)
    {
        Diagnostic_m::where('diagnostic_id',$id)->delete();
        Inquiry::where('transaction_id',$id)->delete();
        echo true;
    }

    public function destroyMeds($id)
    {
        Prescriptions_m::where('prescription_id',$id)->delete();
        Inquiry::where('transaction_id',$id)->delete();
        echo true;
    }

    public function transfer_peds($user_id,$pspat)
    {
        date_default_timezone_set('Asia/Manila');

        //$query = Inquiry::where(['inserted_by'=>$user_id,'ancillary_location'=>1])->get();
        $query = Inquiry::where(['pspat'=>$pspat,'ancillary_location'=>1])->get();
        //$query = Inquiry::where(['pspat'=>$pspat])->get();
        //$query_lab = Inquiry::where(['inserted_by'=>$user_id,'ancillary_location'=>2])->get();
        $query_lab = Inquiry::where(['pspat'=>$pspat,'ancillary_location'=>2])->get();
        //$get_user_detail = check_user_detail($user_id);
        $Trans_m = new trans_m();
        $basket = new Basket();
        $Trans_m_lab = new trans_m();
        $tm_id=0;
        //return sizeof($query);exit;
        //if(sizeof($query)>=1){
            $check = 1;
            $patient_detail = Patient::where(['pk_pspatregisters'=>$query[0]->pspat])->first();
            if(sizeof($query)>0){
                $check = 2;
                $total_reg_p = 0;
                $total_dsc_p = 0;
                $total_sc_p = 0;
                foreach ($query as $key ) {
                    $total_reg_p+=$key->item_total_amt_reg;
                    $total_dsc_p+=$key->item_total_amt_disc;
                    $total_sc_p+=$key->item_total_amt_sc_disc;
                }
    
                $Trans_m->transaction_date = date('m/d/Y h:i:s');
                $Trans_m->inserted_by = 30;
                $Trans_m->inserted_date = date('m/d/Y h:i:s');
    
                $Trans_m->total_amt_reg_price = round($total_reg_p, 2);
                $Trans_m->total_amt_disc_price = round($total_dsc_p, 2);
                $Trans_m->total_amt_sc_pwd_price = round($total_sc_p, 2);
    
                $Trans_m->row_status = 1;
                $Trans_m->transaction_type = ($patient_detail->oscaid!=null||$patient_detail->oscaid!=""?2:1);
                //$Trans_m->or_number = 12345;
                $Trans_m->osca_id = $patient_detail->patientname.' ('.$patient_detail->patientid.')'.'/'.$patient_detail->oscaid;
                $Trans_m->requested_doctor = trim($query[0]->doctor);//Auth::user()->name;
                $Trans_m->transaction_id = $query[0]->transaction_id;
                $Trans_m->ancillary_location = 1;
                $Trans_m->contact_no = $patient_detail->contactno;
                //$Trans_m->request_location = 2;
                $Trans_m->save();
                $tm_id = $Trans_m->trans_m_id;
                foreach ($query as $key ) {
                    $Trans_d = new trans_d;
                    $Trans_d->trans_m_id = $tm_id;
                    $Trans_d->pk_iwitems = $key->pk_iwitems;
                    $Trans_d->item_description = $key->item_description;
                    $Trans_d->item_generic_name = $key->item_generic_name;
                    $Trans_d->item_reg_price = round($key->item_reg_price, 2);
                    $Trans_d->item_discounted_price = round($key->item_discounted_price, 2);
                    $Trans_d->item_sc_price = round($key->item_sc_price, 2);
                    $Trans_d->item_qty = $key->item_qty;
                    $Trans_d->item_total_amt_reg = round($key->item_total_amt_reg, 2);
                    $Trans_d->item_total_amt_disc = round($key->item_total_amt_disc, 2);
                    $Trans_d->item_total_amt_sc_disc = round($key->item_total_amt_sc_disc, 2);
                    $Trans_d->inserted_by = 30;
                    $Trans_d->inserted_date = date("Y-m-d H:i");
                    $Trans_d->prescription_id = $query[0]->transaction_id;
                    $Trans_d->save();
                }
    
                //send sms to pharmacy
                /* $clean_mobile = preg_replace("/[^A-Za-z0-9\_ -']/", '','+639615101036');
                $emp_cell_no = array($clean_mobile);
                $text_message = "Please check the prescription of ".strtoupper($patient_detail->patientname).' in PEDS. Thank you. Do not reply.';
                foreach ($emp_cell_no as  $value) {
                    $info_txt_msg = DB::connection('infotxt')
                                    ->statement("DECLARE @date DATETIME = GETDATE()
                                                    SET ANSI_NULLS ON; SET ANSI_WARNINGS ON; EXEC [sp_SaveToOutbox] '$value','$text_message',@date,3,'IOD',4,0");
                } */
            }
        //}

        //if($query_lab){
            //$patient_detail = Patient::where(['pk_pspatregisters'=>$query_lab[0]->pspat])->first();
            if(sizeof($query_lab)>0){
                $patient_detail = Patient::where(['pk_pspatregisters'=>$query_lab[0]->pspat])->first();
                $total_reg_p = 0;
                $total_dsc_p = 0;
                $total_sc_p = 0;
                foreach ($query_lab as $key ) {
                    $total_reg_p+=$key->item_total_amt_reg;
                    $total_dsc_p+=$key->item_total_amt_disc;
                    $total_sc_p+=$key->item_total_amt_sc_disc;
                }

                $Trans_m_lab->transaction_date = date('m/d/Y H:i:s');
                $Trans_m_lab->inserted_by = 30;
                $Trans_m_lab->inserted_date = date('m/d/Y H:i:s');

                $Trans_m_lab->total_amt_reg_price = round($total_reg_p, 2);
                $Trans_m_lab->total_amt_disc_price = 0.00;
                $Trans_m_lab->total_amt_sc_pwd_price = round($total_sc_p, 2);

                $Trans_m_lab->row_status = 1;
                $Trans_m_lab->transaction_type = ($patient_detail->oscaid!=null||$patient_detail->oscaid!=""?2:1);
                $Trans_m_lab->osca_id = $patient_detail->patientname.' ('.$patient_detail->patientid.')'.'/'.$patient_detail->oscaid;
                $Trans_m_lab->requested_doctor = trim($query_lab[0]->doctor);//Auth::user()->name;
                $Trans_m_lab->transaction_id = $query_lab[0]->transaction_id;
                $Trans_m_lab->ancillary_location = 2;
                $Trans_m_lab->contact_no = $patient_detail->contactno;
                //$Trans_m->request_location = 2;
                $Trans_m_lab->save();
                $tm_id_lab = $Trans_m_lab->trans_m_id;
                foreach ($query_lab as $key ) {
                    $Trans_d = new trans_d;
                    $Trans_d->trans_m_id = $tm_id_lab;
                    $Trans_d->pk_iwitems = $key->pk_iwitems;
                    $Trans_d->item_description = $key->item_description;
                    $Trans_d->item_generic_name = $key->item_generic_name;
                    $Trans_d->item_reg_price = round($key->item_reg_price, 2);
                    $Trans_d->item_discounted_price = round($key->item_discounted_price, 2);
                    $Trans_d->item_sc_price = round($key->item_sc_price, 2);
                    $Trans_d->item_qty = $key->item_qty;
                    $Trans_d->item_total_amt_reg = round($key->item_total_amt_reg, 2);
                    $Trans_d->item_total_amt_disc = round($key->item_total_amt_disc, 2);
                    $Trans_d->item_total_amt_sc_disc = round($key->item_total_amt_sc_disc, 2);
                    $Trans_d->inserted_by = 30;
                    $Trans_d->inserted_date = date("Y-m-d H:i");
                    $Trans_d->prescription_id = $query_lab[0]->transaction_id;
                    $Trans_d->save();
                }
            }
        //}
        
        //delete inquiry
        Inquiry::where('inserted_by',$user_id)->delete();      
        /* Basket::where(['id'=>$basket_id])->update([
            'online_trans_m_id' => $tm_id,
        ]);  */ 
        return 'Meds: '.sizeof($query).' '.$check;
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function printChart($pid)
    {

        $query_patient = DB::connection('pgsql')->select("select * from patients_1 where patientid='$pid' ");
        $getHistory = DB::connection('pgsql')->select("select * from diagnose where patientid='$pid' order by id desc");
       
        //$query_diagnosis = DB::connection('pgsql')->select("select * from diagnose where transaction_id=$tid");

        /* $query_prescription = array();
        $query_diagnostic = array();
        if($query_diagnosis){
            if($query_diagnosis[0]->done_followup){
                $query_prescription = Prescriptions_m::Where('diagnosis_id', $query_diagnosis[0]->id)->Where('for_followup', true)->get();
                $query_diagnostic = Diagnostic_m::Where('diagnosis_id',$query_diagnosis[0]->id)->Where('for_followup', true)->get();
            }else{
                $query_prescription = Prescriptions_m::Where('diagnosis_id', $query_diagnosis[0]->id)->Where('for_followup', false)->get();
                $query_diagnostic = Diagnostic_m::Where('diagnosis_id',$query_diagnosis[0]->id)->Where('for_followup', false)->get();
            }
        } */

        
        /* $str = '';
        $breaks = array("<br />","<br>","<br/>"); 
        foreach ($query_diagnostic as $key => $value) {
            $str .= $value->diagnostic.', ';
        }
        $data['query_diagnostic'] = substr($str, 0, -1);

        $str2 = '';
        foreach ($query_prescription as $key => $value) {
            $str2 .= $value->medecine_desc.', ';
        }
        $data['query_prescription'] = substr($str2, 0, -1);    */
        
        $data['query_patient'] = $query_patient[0];
        $data['getHistory'] = $getHistory;
        
        $myPdf = new ChartRecordPdf($data);
            $myPdf->Output('I', "ChartRecordPdf.pdf", true);
            exit;   
    }
    
}
