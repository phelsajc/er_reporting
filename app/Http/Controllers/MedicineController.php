<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function searchMedicine(Request $request)
    {
        $query = DB::connection('peds_uk')->select("select * from bf_items where (itemdesc ILIKE '%$request->val%' OR genericname ILIKE '%$request->val%') and iscontroldrug = '0' and warehouse_id = '1007' limit 5");
        $data = array();
        foreach ($query as $key => $value ) {
            $arr = array();
            $arr['id'] = $value->item_id;
            $arr['pk_iwitems'] = $value->pk_iwitems;
            $arr['itemdesc'] = $value->itemdesc;
            $arr['genericname'] = strtolower($value->genericname);
            $arr['discounted_price'] = $value->discounted_price;
            $arr['sc_price'] = $value->sc_price;
            $arr['price'] = $value->reg_price;
            $arr['itemgroup'] = 'MED';
            $arr['isactive'] = 1;
            $arr['inserted_dt'] = $value->inserted_date;
            $arr['update_dt'] = '';
            $arr['balance_status'] = $value->warehouse_balance>0?'Available':'Unavailable';
            $arr['warehousebalance'] = $value->warehouse_balance;
            $data[] = $arr;
        }
        $output = array("data" => $data,"peds"=>true); 
        return response()->json($data);
    }
    
    public function searchDiagnostic(Request $request){
        $query = DB::connection('peds_uk')->select("select * from bf_items_lab where itemdesc ILIKE '%$request->val%' or shortname ILIKE '%$request->val%'");
        $data = array();
        foreach ($query as $key => $value ) {
            $arr = array();
            $arr['id'] = $value->bf_items_lab_id;
            $arr['pk_iwitems'] = $value->pk_iwitems;
            $arr['itemdesc'] = $value->itemdesc;
            $arr['genericname'] = '';
            $arr['discounted_price'] = 0;
            $arr['sc_price'] = $value->sc_price;
            $arr['reg_price'] = number_format(floatval($value->reg_price),2,'.','');
            $arr['itemgroup'] = 'EXM';
            $arr['isactive'] = 1;
            $arr['inserted_dt'] = '';
            $arr['update_dt'] = '';
            $arr['balance_status'] = 'Available';
            $arr['warehousebalance'] = 0;
            $arr['shortname'] = $value->shortname;
            $arr['is_pckg'] = $value->is_package;
            $arr['rp'] = number_format(floatval($value->reg_price),2,'.','');
            $data_package = array();
            if($value->is_package==1){
                $query_package = DB::connection('peds_uk')->select("select * from package_detail where under_to_pk_iwitems = '$value->itemdesc'");                
                foreach ($query_package as $qp => $qp_value ) {
                    $arr_package = array();
                    $arr_package['description'] = $qp_value->description;
                    $data_package[] = $arr_package;
                }
            }
            $arr['pkg'] = $data_package;
            $arr['val'] = $request->val;
            $data[] = $arr;
        }
        $output = array("data" => $data,"V"=>$request->val);
        return response()->json($data);
    }
    
}
