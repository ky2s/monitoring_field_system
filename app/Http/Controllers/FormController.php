<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\models\Formmodel;
use App\models\Formdetailmodel;
use App\models\Formmodele;
use App\models\Formteammodel;
use App\models\Formauditormodel;
use App\models\Projectmodel;
use App\models\Teammodel;
use App\User;

class FormController extends Controller
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
    public function index($id)
    {
        $data['project'] = Projectmodel::getData($id);
        return view('form/index', $data);
    }
    public function create($id)
    {
        $data['project'] = Projectmodel::getData($id);
        $data['auditors']  = User::getAuditor();
        $data['teams']  = Teammodel::listAll();
        $data['projectid'] = $id;
        return view('form/create', $data);
    }
    public function edit($id, $idh)
    {
        $data['project'] = Projectmodel::getData($idh);
        $data['auditors']  = User::getAuditor();
        $data['teams']  = Teammodel::listAll();
        $data['form']  = Formmodel::getData($id);
        $data['projectid'] = $idh;
        $data['formid'] = $id;
        return view('form/edit', $data);
    }
    public function store($id, Request $request)
    {
        $input = $request->all();

        $header = Formmodel::storeData($input, $id);
        // $header2 = Formmodel::storeData($input, $id, 'pgsqle');

        if(!empty($input['auditor'])){
            foreach ($input['auditor'] as $a) {
                Formauditormodel::storeData($header, $a);
                // Formauditormodel::storeData($header, $a, 'pgsqle');
            }
        }
        if(!empty($input['team'])){
            foreach ($input['team'] as $a) {
                Formteammodel::storeData($header, $a);
                // Formteammodel::storeData($header, $a, 'pgsqle');
            }
        }
        return Redirect::route('formlist', $id);
    }
    public function update($id, $idh, Request $request)
    {
        $input = $request->all();
        $header = Formmodel::updateData($id, $input);
        // $header2 = Formmodel::updateData($id, $input, 'pgsqle');

        Formauditormodel::destroyDataForm($id);
        // Formauditormodel::destroyDataForm($id, 'pgsqle');
        if(!empty($input['auditor'])){
            foreach ($input['auditor'] as $a) {
                Formauditormodel::storeData($id, $a);
                // Formauditormodel::storeData($id, $a, 'pgsqle');
            }
        }
        Formteammodel::destroyDataForm($id);
        // Formteammodel::destroyDataForm($id, 'pgsqle');
        if(!empty($input['team'])){
            foreach ($input['team'] as $a) {
                // exit($a);
                Formteammodel::storeData($id, $a);
                // Formteammodel::storeData($id, $a, 'pgsqle');
            }
        }
        return Redirect::route('formlist', $idh);

    }
    public function destroy($id, $idh)
    {
        // Formauditormodel::destroyDataForm($id);
        // Formteammodel::destroyDataForm($id);
        Formmodel::destroyData($id);
        // Formmodel::destroyData($id, 'pgsqle');
        return Redirect::route('formlist', $idh);
    }
    public function publish($id, $idh)
    {
        // Formauditormodel::destroyDataForm($id);
        // Formteammodel::destroyDataForm($id);
        Formmodel::publishData($id);
        // Formmodel::publishData($id, 'pgsqle');
        return Redirect::route('formlist', $idh);
    }
    public function lock($id, $idh)
    {
        // Formauditormodel::destroyDataForm($id);
        // Formteammodel::destroyDataForm($id);
        Formmodel::lockData($id);
        // Formmodel::lockData($id, 'pgsqle');
        return Redirect::route('formlist', $idh);
    }

    public function duplicate($id, $projectID)
    {   
        //get form existing
        $formData = Formmodel::getData($id);

        $data['name'] = $formData->name."-copy";
        $data['keterangan'] = $formData->keterangan;
        $formID = Formmodel::storeData($data, $projectID);

        $getAuthor = Formauditormodel::getByFormId($id);
        foreach($getAuthor as $v){
            Formauditormodel::storeData($formID, $v->user_id);
        }

        $getTeam = Formteammodel::getByFormId($id);
        foreach($getTeam as $v){
            Formteammodel::storeData($formID, $v->team_id);
        }
        
        // store form detail first lavel
        $detailFormData = Formdetailmodel::getDataKondisi3($id);
        // dd($detailFormData);
        if(count($detailFormData) > 0){
            foreach($detailFormData as $input){
                
                $input['tipe'] = $input['tipe_id'];		
                $input['option'] = str_replace(',', '\n', $input['option']);;

                $groupID = null;
                if(!empty($input['group_id'])){
                    // foreach($detailFormData as $j=>$notGroup){
                        $getParent = Formdetailmodel::getData($input['group_id']);
                        
                        $getDataDetailGroup = Formdetailmodel::getDataByPosition($formID, $getParent->tipe_id, $getParent->position);
                    // }
                    // dd($getDataDetailGroup[0]->id);
                    if (count($getDataDetailGroup) > 0){
                        $groupID = $getDataDetailGroup[0]->id;
                    }
                }

                $header = Formdetailmodel::storeData($formID, $input, $groupID);
            }
        }
        
        // insert child ada GROUP ID
        // $detailFormDataChild = Formdetailmodel::getDataKondisi4($id);
        // // dd($detailFormDataChild);
        // if(count($detailFormDataChild) > 0){
        //     $var = array();
        //     $groupChildID = null;
        //     foreach($detailFormDataChild as $i=> $input){
                    
        //         $input['tipe'] = $input['tipe_id'];		
        //         $input['option'] = str_replace(',', '\n', $input['option']);;

        //         if(!empty($input['group_id'])){
        //             // $group_id = $input['group_id'];
                    
        //             // $groupChildID = array();
        //             $var2 = array();
                    
        //             // get parent
        //             foreach($detailFormData as $j=>$notGroup){
                        
        //                 if($notGroup['tipe_id'] == 15){
        //                     $getDataDetailGroup = Formdetailmodel::getDataByPosition($formID, $notGroup['position']);
                            
        //                     if (count($getDataDetailGroup) > 0) {
        //                         $groupChildID = $getDataDetailGroup[0]->id;
        //                     }
        //                     $var2[$j] = $groupChildID;
        //                 }
        //                 // $groupChildID = $groupChildID;
        //             }
        //             $var[$i] = $groupChildID;
        //             $var[$i] = $var2;
        //             // dd($getDataDetailGroup);
        //             $header = Formdetailmodel::storeData($formID, $input, $groupChildID);
        //             $groupChildID = null;
        //         }
        //     }
        //     dd($var);
        // }

        return Redirect::route('formlist', $projectID);
    }
}
