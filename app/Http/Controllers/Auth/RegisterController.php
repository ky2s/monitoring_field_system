<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\models\Userformsmodel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $return = User::create([
            'name' => $data['name'],
            'tipe' => $data['tipe'],
            'apps' => $data['apps'],
            'phone' => $data['phone'],
            'email' => strtolower($data['email']),
            'password' => bcrypt($data['password']),
        ]);
        if(isset($data['form'])){
            foreach ($data['form'] as $form) {
                Userformsmodel::storeData($return->id, $form);
                Userformsmodel::storeData($return->id, $form, 'pgsqle');
            }
        }

        $user = User::find($return->id);
        $sql = "INSERT INTO users (name, tipe, phone, email, password, created_at, updated_at, apps) VALUES ('".$user->name."', '".$user->tipe."', '".$user->phone."', '".$user->email."', 
        '".$user->password."', '".$user->created_at."', '".$user->updated_at."', '".$user->apps."')";
        DB::connection('pgsqle')->insert($sql);
        // echo $user->id."<br>";
        // echo $user->name."<br>";
        // echo $user->tipe."<br>";
        // echo $user->phone."<br>";
        // echo $user->email."<br>";
        // echo $user->password."<br>";
        // echo $user->remember_token."<br>";
        // echo $user->created_at."<br>";
        // echo $user->updated_at."<br>";
        // echo $user->deleted."<br>";
        // echo $user->apps."<br>";

        return $return;
    }
}
