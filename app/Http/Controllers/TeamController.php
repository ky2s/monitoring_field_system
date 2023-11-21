<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\models\Teammodel;

class TeamController extends Controller
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
        $data['teamlist'] = Teammodel::listAll();
        return view('team/index', $data);
    }
    public function create()
    {
        return view('team/create');
    }
    public function update($id, Request $request)
    {
        $input = $request->all();
        $header = Teammodel::updateData($id, $input);
        // $header2 = Teammodel::updateData($id, $input, 'pgsqle');
        return Redirect::route('teamlist');

    }
    public function edit($id)
    {
        $data['team']  = Teammodel::getData($id);
        return view('team/edit', $data);
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $header = Teammodel::storeData($input);
        // $header2 = Teammodel::storeData($input, 'pgsqle');
        return Redirect::route('teamlist');
    }
    public function destroy($id)
    {
        Teammodel::destroyData($id);
        // Teammodel::destroyData($id, 'pgsqle');
        return Redirect::route('teamlist');
    }
}
