<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\models\Teammembermodel;
use App\models\Teammodel;
use App\User;

class TmemberController extends Controller
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
        return view('teammember/index', $data);
    }
    public function create($id)
    {
        $data['users'] = User::qteam('member');
        $data['team'] = Teammodel::getData($id);
        $data['teamid'] = $id;
        return view('teammember/create', $data);
    }
    public function update($id, $idh, Request $request)
    {
        $input = $request->all();
        $header = Teammembermodel::updateData($id, $input['user_id'], $idh);
        // $header2 = Teammembermodel::updateData($id, $input['user_id'], $idh, 'pgsqle');
        return Redirect::route('tmemberlist', $idh);

    }
    public function edit($id, $idh)
    {
        // exit($id."xxxx".$idh);
        $data['tmember']  = Teammembermodel::getData($id);
        $data['users'] = User::qteam('member');
        $data['team'] = Teammodel::getData($idh);
        $data['teamid'] = $idh;
        $data['memberid'] = $id;
        return view('teammember/edit', $data);
    }
    public function store($id, Request $request)
    {
        $input = $request->all();

        $header = Teammembermodel::storeData($input['user_id'], $id);
        // $header2 = Teammembermodel::storeData($input['user_id'], $id, 'pgsqle');
        return Redirect::route('tmemberlist', $id);
    }
    public function destroy($id, $idh)
    {
        Teammembermodel::destroyData($id);
        // Teammembermodel::destroyData($id, 'pgsqle');
        return Redirect::route('tmemberlist', $idh);
    }
}
