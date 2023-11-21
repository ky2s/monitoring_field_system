<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class Teammanagermodel extends Model
{
	protected $table = 'team_member';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';

	public $timestamps = false;

	public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
	public function team()
    {
        return $this->hasOne('App\models\teammodel', 'id', 'team_id');
    }

	public static function listAll()
	{
		$row = Teammanagermodel::where('deleted', '=', 'Tidak')->get();
		return $row;
	}

	public static function getData($id)
	{
		$row = Teammanagermodel::find($id);
		return $row;
	}
	public static function updateData($id, $user_id, $team_id, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$team = Teammanagermodel::find($id);
	        
			$team->user_id = $user_id;
			$team->team_id = $team_id;
			$return = $team->save();
	    }
        else{
            $sql = "UPDATE team_member SET
                    user_id = ".$user_id.", 
                    team_id = ".$team_id."
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);        	
        }

		return $return;
	}
	public static function destroyData($id, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$team = Teammanagermodel::find($id);
	        
	        $team->deleted = 'Ya';
	        $return = $team->save();
	    }
        else{
            $sql = "UPDATE team_member SET
                    deleted = 'Ya'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);        	
        }
        return $return;
	}
	public static function storeData($user_id, $team_id, $conn = 'pgsql')
	{
		$team = new Teammanagermodel;
		$team->setConnection($conn);

		$team->user_id = $user_id;
		$team->team_id = $team_id;

		// $team->iCreatedid = Auth::user()->id;

		$simpan = $team->save();

		return $team->id;
	}

}