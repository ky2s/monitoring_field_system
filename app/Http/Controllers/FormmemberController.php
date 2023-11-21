<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\models\Formmodel;
use App\models\Formteammodel;
use App\models\Formauditormodel;
use App\models\Formdmodel;
use App\models\Teammodel;
use App\User;
use Auth;
class FormmemberController extends Controller
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
        $data['form'] = Formmodel::listMember(Auth::user()->id);
        return view('memberform/index', $data);
    }
    public function create($id)
    {
        
        $data['formid'] = $id;
        $data['form'] = Formmodel::getData($id);
        return view('memberform/create', $data);
    }
    public function edit($id, $idh)
    {
        $data['auditors']  = User::getAuditor();
        $data['teams']  = Teammodel::listAll();
        $data['form']  = Formmembermodel::getData($id);
        $data['projectid'] = $idh;
        $data['formid'] = $id;
        return view('memberform/edit', $data);
    }
    public function store($id, Request $request)
    {
        $input = $request->all();

        $header = Formmembermodel::storeData($input, $id);
        if(!empty($input['auditor'])){
            foreach ($input['auditor'] as $a) {
                Formmemberauditormodel::storeData($header, $a);
            }
        }
        if(!empty($input['team'])){
            foreach ($input['team'] as $a) {
                Formmemberteammodel::storeData($header, $a);
            }
        }
        return Redirect::route('formlist', $id);
    }
    public function update($id, $idh, Request $request)
    {
        $input = $request->all();
        $header = Formmembermodel::updateData($id, $input);
        Formmemberauditormodel::destroyDataFormmember($id);
        if(!empty($input['auditor'])){
            foreach ($input['auditor'] as $a) {
                Formmemberauditormodel::storeData($id, $a);
            }
        }
        Formmemberteammodel::destroyDataFormmember($id);
        if(!empty($input['team'])){
            foreach ($input['team'] as $a) {
                Formmemberteammodel::storeData($header, $a);
            }
        }
        return Redirect::route('formlist', $idh);

    }
    public function destroy($id, $idh)
    {
        Formmembermodel::destroyData($id);
        return Redirect::route('formlist', $idh);
    }
}
