<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\models\Formmodel;
use App\models\Formdetailmodel;
use App\models\Formtipemodel;
use App\models\Formkondisimodel;
use App\models\Formdetailimagemodel ;
use App\User;

class FormgroupController extends Controller
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
        $data['form'] = Formdetailmodel::getData($id);
        $data['tipes'] = Formtipemodel::listAll();
        return view('formgroup/index', $data);
    }
    public function create($id)
    {
        $data['form'] = Formdetailmodel::getData($id);

        $data['tipes'] = Formtipemodel::listAll();
        $data['formid'] = $id;
        return view('formgroup/create', $data);
    }
    public function edit($id, $idh)
    {
        $data['detail']  = Formdetailmodel::getData($id);
        $data['form'] = Formdetailmodel::getData($id);

        $data['tipes'] = Formtipemodel::listAll();
        $data['formid'] = $id;
        $data['hformid'] = $idh;
        return view('formgroup/edit', $data);
    }
    public function update($id, $idh, Request $request)
    {
        $input = $request->all();
        $input['option'] = str_replace(',', '\n', $input['option']);
        $input['mandatory'] = $request->has('mandatory')?'Y':'N';

        $header = Formdetailmodel::updateData($id, $input);
        // $header2 = Formdetailmodel::updateData($id, $input, 'pgsqle');
        return Redirect::route('formgrouplist', $idh);

    }
    public function store($id, Request $request)
    {
        $d = Formdetailmodel::getData($id);
        $input = $request->all();
        
        $input['option'] = str_replace(',', '\n', $input['option']);
        $input['mandatory'] = $request->has('mandatory')?'Y':'N';

        $header = Formdetailmodel::storeData($d->form_id, $input, $id);
        // $header2 = Formdetailmodel::storeData($d->form_id, $input, $id, 'pgsqle');
        return Redirect::route('formgrouplist', $id);
    }
    public function destroy($id, $idh)
    {
        // delet image detail
        Formdetailimagemodel::destroyDataImage($id);

        $detail = Formdetailmodel::getData($id);
        Formdetailmodel::destroyData($id, $detail->form_id);
        // Formdetailmodel::destroyData($id, $detail->form_id, 'pgsqle');
        return Redirect::route('formgrouplist', $idh);
    }
    public function rule($id, $idh)
    {
        $data['detail']  = Formdetailmodel::getData($id);
        $data['form'] = Formdetailmodel::getData($idh);
        $data['tipes'] = Formtipemodel::listAll();
        $data['detlist'] = Formdetailmodel::getDataKondisiGroup($idh, $id);

        $data['formid'] = $idh;
        $data['detailid'] = $id;
        // exit(print_r($data['detlist']));

        $view = 'formdetail/rulegroup';
        
        return view($view, $data);
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
        return Redirect::route('formgrouprule', [$id, $idh]);

    }
    public function destroyrule($id, $idh, Request $request)
    {
        Formkondisimodel::destroyData($request->idkondisi);
        // Formkondisimodel::destroyData($request->idkondisi, 'pgsqle');
        return Redirect::route('formgrouprule', [$id, $idh]);
    }
    public function clone($id)
    {
        $detail = Formdetailmodel::getData($id);
        $newdetail['tipe'] = $detail->tipe_id;
        $newdetail['position'] = $detail->position;
        $newdetail['label'] = $detail->label;
        $newdetail['keterangan'] = $detail->keterangan;
        $newdetail['ismultiple'] = $detail->ismultiple;
        $newdetail['maximum'] = $detail->maximum;
        $newdetail['tipetulisan'] = $detail->tipetulisan;
        $newdetail['option'] = $detail->option;
        $newdetail['mandatory'] = $detail->mandatory;

        $header = Formdetailmodel::storeData($detail->form_id, $newdetail);
        // $header2 = Formdetailmodel::storeData($detail->form_id, $newdetail,'-', 'pgsqle');
        foreach ($detail->group as $g) {
            $newgroup['tipe'] = $g->tipe_id;
            $newgroup['position'] = $g->position;
            $newgroup['label'] = $g->label;
            $newgroup['keterangan'] = $g->keterangan;
            $newgroup['ismultiple'] = $g->ismultiple;
            $newgroup['maximum'] = $g->maximum;
            $newgroup['tipetulisan'] = $g->tipetulisan;
            $newgroup['option'] = $g->option;
            $newgroup['mandatory'] = $g->mandatory;

            $group = Formdetailmodel::storeData($g->form_id, $newgroup, $header);
            // $group2 = Formdetailmodel::storeData($g->form_id, $newgroup,$header2, 'pgsqle');
        }
        // print_r($detail->group);
        // exit;
        return Redirect::route('formdetaillist', $detail->form_id);
    }
}
