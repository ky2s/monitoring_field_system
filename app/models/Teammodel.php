<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Users;
use App\models\Teammembermodel;
use DB;

class Teammodel extends Model
{
	protected $table = 'team';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';

	public $timestamps = false;

	public static $messages =array(
		'name.unique'=>'Nama Team Sudah ada..'
	);
	public static function validate($data){
		$rules =array(
			'name'=>'required|unique:team,nama'
		);
		return Validator::make($data, $rules, static::$messages);
	}
	public static function validateEdit($data, $id){
		$rulesEdit =array(
			'name'=>'required|unique:team,nama,'.$id.',id'

		);
		return Validator::make($data, $rulesEdit, static::$messages);
	}
	public function users()
	{
        return $this->belongsTo('App\Models\Teammembermodel', 'team_id', 'id');
	}
	public function countmember($id)
    {
    	$count = Teammembermodel::join('users', 'users.id', '=', 'team_member.user_id')
    			 ->where('users.tipe', 'member')->where('team_member.team_id', $id)
    			 ->where('users.deleted', '=', 'Tidak')->where('team_member.deleted', '=', 'Tidak')->get()->count();
        return $count;
    }
	public function countmanager($id)
    {
    	$count = Teammembermodel::join('users', 'users.id', '=', 'team_member.user_id')
    			 ->where('users.tipe', 'manager')->where('team_member.team_id', $id)
    			 ->where('users.deleted', '=', 'Tidak')->where('team_member.deleted', '=', 'Tidak')->get()->count();
        return $count;
    }

	public function member()
    {
        return $this->hasMany('App\models\Teammembermodel', 'team_id', 'id');
    }

	public static function listAll()
	{
		if(Auth::user()->tipe=='admin'){
			$row = Teammodel::where('deleted', '=', 'Tidak')->get();
		}
		else{
    		$row = Teammodel::join('team_member', 'team.id', '=', 'team_member.team_id')
    			 ->select('team.*')
    			 ->where('team_member.deleted', '=', 'Tidak')->where('team.deleted', '=', 'Tidak')
    			 ->where('team_member.deleted', '=', 'Tidak')->where('team_member.user_id', Auth::user()->id)->get();
    	}
		return $row;
	}

	public static function getData($id)
	{
		$row = Teammodel::find($id);
		return $row;
	}
	public static function updateData($id, $data, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$team = Teammodel::find($id);
			
			$team->name = $data['name'];
			$team->description = $data['description'];
			$return = $team->save();
		}
		else{
            $sql = "UPDATE team SET
                    name = '".$data['name']."', 
                    description = '".$data['description']."'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);

		}
		// $team->iUpdatedid = Auth::user()->id;
		// $team->tUpdated = date('Y-m-d h:i:s');

		return $return;
	}
	public static function destroyData($id, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$team = Teammodel::find($id);
	        
	        $team->deleted = 'Ya';
	        $return = $team->save();
	    }
        else{
            $sql = "UPDATE team SET
                    deleted = 'Ya'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);        	
        }
        return $return;
	}
	public static function storeData($data, $conn = 'pgsql')
	{
		$team = new Teammodel;
		$team->setConnection($conn);

		$team->name = $data['name'];
		$team->description = $data['description'];

		// $team->iCreatedid = Auth::user()->id;

		$simpan = $team->save();

		return $team->id;
	}
}