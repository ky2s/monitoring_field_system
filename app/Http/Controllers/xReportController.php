<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\models\Formmodel;
use App\User;

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
    public function detail($id)
    {
        $data['id']     = $id;
        $data['data']   = Formmodel::getReport($id);
        $data['form']   = Formmodel::getData($id);

        return view('report/detail', $data);
    }
    public function maps($id)
    {
        $data['id']     = $id;
        $form = Formmodel::getData($id);
        $ismap = false;
        $v = "f";
        foreach ($form->detail as $d) {
            if($d->tipe_id == 14){
                $v .= $d->id;
                $ismap = true;
            }
        }
        // $data['data']   = Formmodel::getReport($id);
        // $data['form']   = Formmodel::getData($id);

        if($ismap){
            $ndata = Formmodel::getReport($id);
            $peta = array();
            foreach ($ndata as $dt) {
                if($dt->{$v} !=''){
                    $tloc = explode('(', $dt->{$v});
                    $loc = explode(',', $tloc[1]);
                    // exit(print_r($loc));
                    $peta[$dt->id]['lat'] = $loc[0];
                    $peta[$dt->id]['lng'] = substr($loc[1], 0, -1);
                    $peta[$dt->id]['id'] = $dt->id;
                    $peta[$dt->id]['uid'] = $dt->uid;
                }

            }
            $data['lat'] = $loc[0];
            $data['lng'] = substr($loc[1], 0, -1);
            $data['peta'] = $peta;
            return view('report/maps', $data);
        }
        else{
            return Redirect::route('reportdetail', $id);
        }
    }
    public function stats($id)
    {
        $data['id']     = $id;
        $data['data']   = Formmodel::getReportStat($id);
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
