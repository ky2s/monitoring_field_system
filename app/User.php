<?php

namespace App;


use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'tipe', 'apps'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $dateFormat = 'Y-m-d H:i:sO';
    protected $connection = 'pgsql';

    public function adminproject()
    {
        return $this->hasMany('App\models\Projectadminmodel', 'user_id', 'id');
    }
    public function form(){
        return $this->hasMany('App\models\Userformsmodel','id_user', 'id');
    }

    public static function listAll()
    {
        if(Auth::user()->tipe == 'sa')
            $row = User::where('deleted', '=', 'Tidak')->whereIn('tipe', ['sa', 'admin'])->get();
        elseif(Auth::user()->tipe == 'manager')
            $row = User::where('deleted', '=', 'Tidak')->whereIn('tipe', ['member', 'auditor'])->get();
        elseif (Auth::user()->tipe == 'admin')
            $row = User::where('deleted', '=', 'Tidak')->whereIn('tipe', ['manager', 'member', 'auditor'])->get();

        return $row;
    }

    public static function getData($id)
    {
        $row = User::find($id);
        return $row;
    }
    public static function qteam($tipe)
    {
        $row = User::where('deleted', '=', 'Tidak')->where('tipe', '=', $tipe)->get();

        return $row;
    }

    public static function getAuditor()
    {
        $row = User::where('deleted', '=', 'Tidak')->where('tipe', '=', 'auditor')->get();

        return $row;
    }
    public static function getManager()
    {
        $row = User::where('deleted', '=', 'Tidak')->where('tipe', '=', 'manager')->get();

        return $row;
    }
    public static function updateData($id, $data, $conn = 'pgsql')
    {
        if($conn == 'pgsql'){
            $user = User::find($id);
            $user->name = $data['name'];
            $user->phone = $data['phone'];
            $user->tipe = $data['tipe'];
            $user->email = $data['email'];
            $user->apps = $data['apps'];
            if(strlen($data['password'])>4 )
                $user->password = bcrypt($data['password']);

            $return = $user->save();
        }
        else{
            $pass = "";
            if(strlen($data['password'])>4 )
                $pass = "password = '".bcrypt($data['password'])."',";

            $sql = "UPDATE users SET
                    name = '".$data['name']."', 
                    phone = '".$data['phone']."', 
                    tipe = '".$data['tipe']."', 
                    apps = '".$data['apps']."', 
                    ".$pass."
                    email = '".$data['email']."'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);

        }
        return $return;
    }
    public static function destroyData($id, $conn = 'pgsql')
    {
        if($conn == 'pgsql'){
            $user = User::find($id);
            
            $user->deleted = 'Ya';

            $return = $user->save();
        }
        else{
            $sql = "UPDATE users SET
                    deleted = 'Ya'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);
        }
        return $return;
    }
}
