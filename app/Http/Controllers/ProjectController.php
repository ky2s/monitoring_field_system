<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\User;
use App\models\Projectmodel;
use App\models\Projectadminmodel;

class ProjectController extends Controller
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
        $data['projectlist'] = Projectmodel::listAll();
        return view('project/index', $data);
    }
    public function create()
    {
        $data['admins']  = User::getManager();
        return view('project/create', $data);
    }
    public function update($id, Request $request)
    {
        $input = $request->all();
        $header = Projectmodel::updateData($id, $input);
        // $header2 = Projectmodel::updateData($id, $input, 'pgsqle');
        Projectadminmodel::destroyDataProject($id);
        // Projectadminmodel::destroyDataProject($id, 'pgsqle');
        if(!empty($input['admin'])){
            foreach ($input['admin'] as $a) {
                Projectadminmodel::storeData($id, $a);
                // Projectadminmodel::storeData($id, $a, 'pgsqle');
            }
        }
        return Redirect::route('projectlist');

    }
    public function edit($id)
    {
        $data['project']  = Projectmodel::getData($id);
        $data['admins']  = User::getManager();
        return view('project/edit', $data);
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $header = Projectmodel::storeData($input);
        // $header2 = Projectmodel::storeData($input, 'pgsqle');
        if(!empty($input['admin'])){
            foreach ($input['admin'] as $a) {
                Projectadminmodel::storeData($header, $a);
                // Projectadminmodel::storeData($header, $a, 'pgsqle');
            }
        }
        return Redirect::route('projectlist');
    }
    public function destroy($id)
    {
        Projectmodel::destroyData($id);
        // Projectmodel::destroyData($id, 'pgsqle');
        return Redirect::route('projectlist');
    }
    public function publish($id, Request $request)
    {
        // Formauditormodel::destroyDataForm($id);
        // Formteammodel::destroyDataForm($id);
        Projectmodel::publishData($id, $request->publish);
        // Projectmodel::publishData($id, $request->publish, 'pgsqle');
        return Redirect::route('formlist', $id);
    }
}
