<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\models\Formmodel;
use App\models\Formdetailmodel;
use App\models\Formtipemodel;
use App\models\Formkondisimodel;
use App\models\Formkonmastermodel;
use App\models\Formdetailimagemodel;

use App\User;

class FormdetailController extends Controller
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
        $data['form'] = Formmodel::getData($id);
        $data['tipes'] = Formtipemodel::listAll();
        return view('formdetail/index', $data);
    }
    public function create($id)
    {
        $data['form'] = Formmodel::getData($id);
        $data['tipes'] = Formtipemodel::listAll();
        $data['formid'] = $id;
        return view('formdetail/create', $data);
    }
    public function edit($idh, $id)
    {
        $data['detail']  = Formdetailmodel::getData($id);

        $data['form'] = Formmodel::getData($idh);
        $data['tipes'] = Formtipemodel::listAll();

        $data['formid'] = $idh;
        $data['detailid'] = $id;
        return view('formdetail/edit', $data);
    }
    public function rule($idh, $id)
    {
        $data['detail']  = Formdetailmodel::getData($id);
        $data['form'] = Formmodel::getData($idh);
        // exit($data['form']->project->name);
        $data['tipes'] = Formtipemodel::listAll();
        $data['detlist'] = Formdetailmodel::getDataKondisi($idh, $id);

        $data['formid'] = $idh;
        $data['detailid'] = $id;
        // exit(print_r($data['detlist']));

        $view = 'formdetail/rule';
        
        return view($view, $data);
    }
    public function rule2($id)
    {
        $form = Formmodel::getData($id);

        $data['detlist'] = Formdetailmodel::getDataKondisi2($id);
        $data['konlist'] = Formdetailmodel::getDataKondisi3($id);
        $data['masterlist'] = Formkonmastermodel::listAllForm($id);
        $kondisilist = array();
        foreach ($data['konlist'] as $dd) {
            if(count($dd->kondisi)>0){
                $kondisilist = $dd->kondisi;
                break;
            }
        }
        $data['kondisilist'] = $kondisilist;
        // exit;

        $data['form'] = $form;
        $data['formid'] = $form->id;

        $view = 'formdetail/rule2';
        return view($view, $data);
    }
    public function update($id, $idh, Request $request)
    {
        $input = $request->all();
        $input['option'] = str_replace(',', '\n', $input['option']);
        $input['mandatory'] = $request->has('mandatory')?'Y':'N';
        
        $header = Formdetailmodel::updateData($id, $input);
        // $header2 = Formdetailmodel::updateData($id, $input, 'pgsqle');
        return Redirect::route('formdetaillist', $idh);

    }
    public function reposition(Request $request)
    {

        Formdetailmodel::updatePosition($request->id, $request->position);
        // Formdetailmodel::updatePosition($request->id, $request->position, 'pgsqle');
        echo 1;
        // return Redirect::route('formdetaillist', $idh);

    }
    public function updaterule($id, $idh, Request $request)
    {
        // exit($id);
        $input = $request->all();
        // exit(print_r($input["nilai"]));
        $header = Formdetailmodel::updateKondisi($id, $request->andor);
        // $header2 = Formdetailmodel::updateKondisi($id, $request->andor, 'pgsqle');
        Formkondisimodel::destroyDataForm($id);
        // Formkondisimodel::destroyDataForm($id, 'pgsqle');

        $i = 0;
        foreach ($input["logika"] as $l) {
            if((!empty($input["detail"][$i]) && trim($input["detail"][$i]) !="") && (!empty($input["nilai"][$i]) && trim($input["nilai"][$i]) != "")){
                Formkondisimodel::storeData($id, $input["detail"][$i], $l, $input["nilai"][$i]);
                // Formkondisimodel::storeData($id, $input["detail"][$i], $l, $input["nilai"][$i], 'pgsqle');
            }
            $i++;
        }
        // Formkondisimodel::storeData($id, $input);
        return Redirect::route('formdetailrule', [$idh, $id]);

    }
    public function updaterule2($id, Request $request)
    {
        $input = $request->all();
        // $det = Formdetailmodel::getData($id);
        
        // exit($request->masterid);
        if($request->masterid=='-')
            $master = Formkonmastermodel::storeData($id, $request->andor);
        else
            $master = $request->masterid;
        // print_r($input["kondisi"]);
        // exit;
        foreach ($request->detail as $d) {
            $header = Formdetailmodel::updateKondisi($d, $request->andor);
            // $header2 = Formdetailmodel::updateKondisi($d, $request->andor, 'pgsqle');
            if($request->masterid!='-'){
                Formkondisimodel::destroyDataForm($d, $master);
                // Formkondisimodel::destroyDataForm($d, $master, 'pgsqle');
            }
            $i = 0;
            foreach ($input["logika"] as $l) {
                if((!empty($input["kondisi"][$i]) && trim($input["kondisi"][$i]) !="") && (!empty($input["nilai"][$i]) && trim($input["nilai"][$i]) != "")){
                    // exit($input["kondisi"][$i]);
                    Formkondisimodel::storeData($d, $input["kondisi"][$i], $l, $input["nilai"][$i], $master);
                    // Formkondisimodel::storeData($d, $input["kondisi"][$i], $l, $input["nilai"][$i], $master, 'pgsqle');
                }
                $i++;
            }
        }
        return Redirect::route('formdetaillist', $id);

    }
    public function store($id, Request $request)
    {
        $input = $request->all();
        $input['option'] = str_replace(',', '\n', $input['option']);
        $input['mandatory'] = $request->has('mandatory')?'Y':'N';
        // print_r($input);
        // exit($request->mandatory);

        $header = Formdetailmodel::storeData($id, $input);
        // $header2 = Formdetailmodel::storeData($id, $input,'-', 'pgsqle');
        return Redirect::route('formdetaillist', $id);
    }
    public function destroy($id, $idh)
    {
        // delete image detail
        Formdetailimagemodel::destroyDataImage($idh);

        // delete data form
        Formkondisimodel::destroyDataForm($idh);
        
        // Formkondisimodel::destroyDataForm($idh, 'pgsqle'); // no

        Formdetailmodel::destroyData($idh, $id);
        // Formdetailmodel::destroyData($idh, $id, 'pgsqle');
        return Redirect::route('formdetaillist', $id);
    }
    public function destroyrule($id, $idh, Request $request)
    {
        Formkondisimodel::destroyData($request->idkondisi);
        // Formkondisimodel::destroyData($request->idkondisi, 'pgsqle');
        return Redirect::route('formdetailrule', [$idh, $id]);
    }
}
