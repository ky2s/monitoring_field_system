<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\models\Formmodel;
use App\User;
use Excel;
use DB;
use URL;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['formlist'] = Formmodel::listAll();
        return view('report/index', $data);
    }
    public function fixing()
    {
        $formlist = Formmodel::listAll();
        foreach ($formlist as $f) {
            $tbl = "inputform".$f->id;
            foreach ($f->detail as $d) {
                if($d->tipe->id == 2){
                    $field = "f".$d->id;
                    $sql = "UPDATE ".$tbl." SET ".$field."=CONCAT('https://adshouse-sgsrv-spc-1.sgp1.digitaloceanspaces.com/".$f->id."/', ".$field.") WHERE ".$field." NOT LIKE 'https://adshouse-sgsrv-spc-1.sgp1.digitaloceanspaces.com/".$f->id."/%';";


                    // $sql = "UPDATE ".$tbl." SET ".$field."=REPLACE(".$field.", 'https://adshouse-sgsrv-spc-1.sgp1.digitaloceanspaces.com/25/', '') WHERE ".$field." LIKE 'https://adshouse-sgsrv-spc-1.sgp1.digitaloceanspaces.com/25/%';";

                    $query = DB::update($sql);
                    echo $sql."<br>";

                }
            }
        }
        exit;
        // return view('report/index', $data);
    }
    public function detail($id)
    {
        $data['id']     = $id;
        $rdate = isset($_GET['rangedate'])?$_GET['rangedate']:'- - -';
        $rdate = trim($rdate)!=''?$rdate:'- - -';
        $rusers = isset($_GET['users'])?$_GET['users']:array();
        
        $tmp = explode(' - ', $rdate);

        $start = date("Ymd", strtotime($tmp[0]));
        $end = date("Ymd", strtotime($tmp[1]));
        $data['listusers'] = Formmodel::getReportUser($id);
        // exit();
        $data['data']   = Formmodel::getReport($id, $start, $end, $rusers)->paginate(20); //->paginate(20)
        $data['form']   = Formmodel::getData($id);
        $data['url_map'] = URL::route('reportmaps', [$id, 'users' => isset($_GET['users'])?$_GET['users']:'','rangedate' => isset($_GET['rangedate'])?$_GET['rangedate']:'']);
        
        return view('report/detail', $data);
    }
    public function detailbug($id)
    {
        $data['id']     = $id;
        $rdate = isset($_GET['rangedate'])?$_GET['rangedate']:'- - -';
        $rdate = trim($rdate)!=''?$rdate:'- - -';
        $rusers = isset($_GET['users'])?$_GET['users']:array();
        
        $tmp = explode(' - ', $rdate);

        $start = date("Ymd", strtotime($tmp[0]));
        $end = date("Ymd", strtotime($tmp[1]));
        $data['listusers'] = Formmodel::getReportUser($id);
        // exit();
        // dd($id);
        $data['data']   = Formmodel::getReport($id, $start, $end, $rusers)->paginate(20); //->paginate(20)
        $data['form']   = Formmodel::getData($id);
        $data['url_map'] = URL::route('reportmaps', [$id, 'users' => isset($_GET['users'])?$_GET['users']:'','rangedate' => isset($_GET['rangedate'])?$_GET['rangedate']:'']);
        // dd($data['data']);

        $var = array();
        foreach($data['form']->detail as $i=>$r){

            // $var[$i] = $r['id'];
            $var[$i] = $r->group;
        }
        dd($var);
        foreach($data['data'] as $d){
			foreach($data['form']->detail as $i=>$r){

                // $var[$i] = $r['id'];
                $var[$i] = $r->group;
				// if(($r->tipe->cfield == 'Y' || $r->tipe->isgroup == 'Y') && $r->group_id ==''){
				// 	if($r->tipe->isgroup == 'Y'){
                       
				// 		// foreach($r->group as $j=>$v){
                //         //     $namefield = "f".$v->id;
                //         //     $var[$j] = $namefield;
                //         // }
                //     }
                // }
            }
	  	
	  	$i++;
        }

        
        // foreach($data['form']->detail as $i=>$d){
        //     //   ;
        //     if(($d->tipe->cfield == 'Y' || $d->tipe->isgroup == 'Y') && $d->group_id ==''){
		// 		if($d->tipe->isgroup == 'Y'){
		// 			foreach($d->group as $i=>$f){
		// 				if($f->tipe->cfield == 'Y'){
        //                 $var[$i] = $f->label;
        //                 }
        //             }
        //         }
        //     }
        // }
        dd($var);
        // dd($data['form']->detail );
        return view('report/detail', $data);
    }
    public function detailexcel($id)
    {
        $form = Formmodel::getData($id);
        
        $rdate = isset($_GET['rangedate'])?$_GET['rangedate']:'- - -';
        $tmp = explode(' - ', $rdate);

        $start = isset($tmp[0])?date("Ymd", strtotime($tmp[0])):'1970-01-01';
        $end = isset($tmp[1])?date("Ymd", strtotime($tmp[1])):'1970-01-01';

        $data   = Formmodel::getReportExport($id, $start, $end)->get();
        // dd($data);
        $data = $data->map(function ($data){
            return get_object_vars($data);
        });
        // print_r($data);
        // exit;
        Excel::create('data '.$form->name." ".date("U"), function($excel) use($data) {
            $excel->sheet('Sheet 1', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->export('xlsx');
    }
    public function detailcsv($id)
    {
        $form = Formmodel::getData($id);
        
        $rdate = isset($_GET['rangedate'])?$_GET['rangedate']:'- - -';
        $tmp = explode(' - ', $rdate);

        $start = isset($tmp[0])?date("Ymd", strtotime($tmp[0])):'1970-01-01';
        $end = isset($tmp[1])?date("Ymd", strtotime($tmp[1])):'1970-01-01';

        $data   = Formmodel::getReportExport($id, $start, $end)->get();
        $data = $data->map(function ($data){
            return get_object_vars($data);
        });
        Excel::create('data '.$form->name." ".date("U"), function($excel) use($data) {
            $excel->sheet('Sheet 1', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        })->export('csv');


    }
    public function maps($id)
    {
        // dd($_GET['rangedate']);
        $data['id']     = $id;
        $form = Formmodel::getData($id);
        $ismap = false;

        $tagloc = array();
        foreach ($form->detail as $i => $d) {
            if($d->tipe_id == 14){
                $v = "f".$d->id;

                $tagloc[$i] = $v;
                $ismap = true;
            }
        }
        // dd($tagloc);
        // $data['data']   = Formmodel::getReport($id);
        // $data['form']   = Formmodel::getData($id);

        if($ismap){
            $rdate = !empty($_GET['rangedate'])?$_GET['rangedate']:'- - -';
            $tmp = explode(' - ', $rdate);
            $start = date("Ymd", strtotime($tmp[0]));
            $end = date("Ymd", strtotime($tmp[1]));

            $rusers = isset($_GET['users'])?$_GET['users']:array();
            
            $ndata   = Formmodel::getReport($id, $start, $end, $rusers)->get();
            
            $peta = array();
            
            foreach ($ndata as $dt) {

                foreach($tagloc as $tag){
                    
                    if($dt->{$tag}){
                        if($dt->{$tag} !=''){
                            if(strpos($dt->{$tag}, '(') !== false){
                                $tloc = explode('(', $dt->{$tag});
                                $loc = explode(',', $tloc[1]);
                                // exit(print_r($loc));
                                $peta[$dt->id]['lat'] = $loc[0];
                                $peta[$dt->id]['lng'] = substr($loc[1], 0, -1);
                                $peta[$dt->id]['id'] = $dt->id;
                                $peta[$dt->id]['uid'] = $dt->uid;
                                $peta[$dt->id]['name'] = $dt->name." - ".$dt->waktuisi;
                            }
                        }
                    }
                }

            }
            $data['lat'] = $loc[0];
            $data['lng'] = substr($loc[1], 0, -1);
            // dd($peta);
            $data['peta'] = $peta;
            return view('report/maps', $data);
        }
        else{
            return Redirect::route('reportdetail', $id);
        }
    }
    public function stats($id)
    {
        $period = isset($_GET['reportperiod'])?$_GET['reportperiod']:'daily';
        if(!empty($_GET['tanggal']))
            $tanggal = $_GET['tanggal'];
        else
            $tanggal = date('Y-m-d');
        $data['id']     = $id;
        // exit($tanggal);
        $data['data']   = Formmodel::getReportStat($id, $period, $tanggal);
        $data['datauser']   = Formmodel::getReportStatUser($id, $period, $tanggal);
        $form   = Formmodel::getData($id);
        $data['formname'] = $form->name;

        return view('report/stats', $data);
    }
    public function data($id, $uid)
    {
        $data['id']     = $id;
        $data['data']   = Formmodel::getReportData($id, $uid);
        $data['form']   = Formmodel::getData($id);

        return view('report/data', $data);
    }
}
