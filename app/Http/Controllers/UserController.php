<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\models\Userformsmodel;
use Validator;
use app\User;
use App\models\UserModel;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['register']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:191',
            'phone' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
    public function index()
    {
        $data['userlist'] = User::listAll();
        return view('user/index', $data);
    }
    public function create()
    {
        return view('user/create');
    }
    public function edit($id)
    {
        $data['user'] = User::getData($id);
        return view('user/edit', $data);
    }
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        // return Redirect::route('userlist');
    }
    public function update($id, Request $request)
    {
        $input = $request->all();
        $header = User::updateData($id, $input);
        // $header2 = User::updateData($id, $input, 'pgsqle');
        Userformsmodel::destroyDataUser($id);
        // Userformsmodel::destroyDataUser($id, 'pgsqle');
        if(!empty($request->form)){
            foreach ($request->form as $form) {
                Userformsmodel::storeData($id, $form);
                // Userformsmodel::storeData($id, $form, 'pgsqle');
            }
        }
        return Redirect::route('userlist');

    }
    public function destroy($id, Request $request)
    {
        $input = $request->all();
        $header = User::destroyData($id);
        // $header2 = User::destroyData($id, 'pgsqle');
        return Redirect::route('userlist');

    }
    public function register(Request $request){
        $this->validate($request, [
            'name' =>   'required'
        ]);

        $chk = UserModel::where('phone', $request->phone)->exists();
        if($chk){
            return response()->json([
                'message'   => 'Phone Already registered',
            ], 201);
        }
        $user = new UserModel;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = UserModel::where('email', $request->email)->exists()?(time().$request->email):$request->email;
        $user->password = bcrypt($request->phone."qwerty");
        $user->tipe = 'member';
        $user->save();

        return response()->json([
            'message'   => 'success',
            'data'  => $user
        ], 200);

    }
}
