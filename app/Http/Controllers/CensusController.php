<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Model\Census;
use App\Model\BedCapacity;

class CensusController extends Controller
{
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $length = 10;
        $start = $request->start ? $request->start : 0;
        $station = $request->stns;
        $stnArrToStr = '';
        foreach ($station as $key => $value) {
            $stnArrToStr .= "'" . $value . "',";
        }
        $fdate = date_format(date_create($request->fdate), 'Y-m-d');
        $tdate = date_format(date_create($request->tdate), 'Y-m-d');
        $sql_q = substr($stnArrToStr, 0, -1);

        if (count($station) != 0 || ($fdate != '' && $tdate != '')) {
            $data = DB::connection('pgsql')->select("SELECT count(station) as totalstn,station,created_dt from census where station in ($sql_q) and  date(created_dt) between '$fdate' and '$tdate' group by station,created_dt LIMIT $length offset $start");
        } else {
            $data = DB::connection('pgsql')->select("SELECT count(station) as totalstn,station,created_dt from census group by station,created_dt LIMIT $length");
        }

        $data_array = array();
        foreach ($data as $key => $value) {
            $arr = array();
            $arr['date'] =  date_format(date_create($value->created_dt), 'F d Y');
            $arr['station'] =  $value->station;
            $getCapacity = BedCapacity::where(['station' => $value->station])->first();
            $arr['bedCapacity'] = $getCapacity->capacity;
            $arr['occupiedBeds'] = $value->totalstn;
            $occupany_rate =  ($value->totalstn / $getCapacity->capacity) * 100;
            $arr['occupanyRate'] = number_format((float)$occupany_rate, 2, '.', '');
            $subQuery = DB::connection('pgsql')->select("SELECT created_dt,STRING_AGG(cast (registrydate as text), '|') AS reg_dt_list,station 
            from census  where station = '$value->station'
           and date(created_dt) between '$fdate' and '$tdate'
           group by 1,3");

            $getAlos = array();
            $countAlos = 0;
            foreach ($subQuery as $xkey => $xvalue) {
                $explode_dt = explode("|", $xvalue->reg_dt_list);
                foreach ($explode_dt as $skey => $svalue) {
                    if (date_format(date_create($xvalue->created_dt), 'Y-m-d') == date_format(date_create($value->created_dt), 'Y-m-d')) {
                        $now = time();
                        $your_date = strtotime($svalue);
                        $datediff = $now - $your_date;
                        $c = round($datediff / (60 * 60 * 24));
                        $countAlos += $c;
                        $getAlos[] =  $countAlos;
                    }
                }
            }
            $formula = $countAlos / $value->totalstn;
            $arr['alos'] = number_format((float)$formula, 2, '.', '');
            $arr['formula'] = $countAlos;
            $arr['alos2'] = $getAlos;
            $data_array[] = $arr;
        }
        $datasets["data"] = $data_array;
        return response()->json($datasets);
    }

    public function getSDtations()
    {
        $data = DB::connection('pgsql')->select("select station from census group by station");
        $returnStn = array();
        foreach ($data as $key => $value) {
            $arr = array();
            $arr['station'] =  $value->station;
            $returnStn[] = $arr;
        }
        $datasets["data"] = $returnStn;
        return response()->json($datasets);
    }
}
