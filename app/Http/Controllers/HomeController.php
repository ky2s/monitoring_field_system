<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use Auth;
use App\models\Formmodel;
use App\User;

class HomeController extends Controller
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
    public function index(Request $request)
    {
        if(Auth::user()->tipe == 'member'){
            Session::flash('status', 'Anda Tidak Memiliki akses!');
            Auth::logout();
            return Redirect::route('home');
        }
        else{
            // return view('home');
            $data['formlist'] = Formmodel::listAll();
            return view('report/index', $data);
        }
    }
}
