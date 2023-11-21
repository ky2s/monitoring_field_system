<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\models\Teammanagermodel;
use App\models\Teammodel;
use App\User;

class TmanagerController extends Controller
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
        $data['team'] = Teammodel::getData($id);
        return view('teammanager/index', $data);
    }
    public function create($id)
    {
        $data['users'] = User::qteam('manager');
        $data['team'] = Teammodel::getData($id);
        $data['teamid'] = $id;
        return view('teammanager/create', $data);
    }
    public function update($id, $idh, Request $request)
    {
        $input = $request->all();
        $header = Teammanagermodel::updateData($id, $input['user_id'], $idh);
        // $header2 = Teammanagermodel::updateData($id, $input['user_id'], $idh, 'pgsqle');
        return Redirect::route('tmanagerlist', $idh);

    }
    public function edit($id, $idh)
    {
        $data['tmanager']  = Teammanagermodel::getData($id);
        $data['users'] = User::qteam('manager');
        $data['team'] = Teammodel::getData($idh);
        $data['teamid'] = $idh;
        $data['managerid'] = $id;
        return view('teammanager/edit', $data);
    }
    public function store($id, Request $request)
    {
        $input = $request->all();

        $header = Teammanagermodel::storeData($input['user_id'], $id);
        // $header2 = Teammanagermodel::storeData($input['user_id'], $id, 'pgsqle');
        return Redirect::route('tmanagerlist', $id);
    }
    public function destroy($id, $idh)
    {
        Teammanagermodel::destroyData($id);
        // Teammanagermodel::destroyData($id, 'pgsqle');
        return Redirect::route('tmanagerlist', $idh);
    }
}
