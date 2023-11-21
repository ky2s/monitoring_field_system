<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;

class Projectadminmodel extends Model
{
	protected $table = 'project_admin';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';

	public $timestamps = false;

	public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
	public function project()
    {
        return $this->hasOne('App\model\Projectmodel', 'id', 'project_id');
    }

	public static function listAll()
	{
		$row = Projectadminmodel::all();
		return $row;
	}

	public static function getData($id)
	{
		$row = Projectadminmodel::find($id);
		return $row;
	}
	public static function updateData($id, $user_id, $project_id, $conn = 'pgsql')
	{

		if($conn == 'pgsql'){
			$admin = Projectadminmodel::find($id);
	        
			$admin->user_id = $user_id;
			$admin->project_id = $project_id;
			$return = $admin->save();
	    }
        else{
            $sql = "UPDATE project_admin SET
                    user_id = ".$user_id.", 
                    project_id = ".$project_id."
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);        	
        }
		return $return;
	}
	public static function destroyDataProject($id, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$data = Projectadminmodel::where('project_id', '=', $id);
			if($data)
				$data->delete();
	    }
        else{
            $sql = "DELETE FROM project_admin
                    WHERE project_id =".$id;
            $data = DB::connection('pgsqle')->update($sql);        	
        }

		return $data;
	}
	public static function storeData($project_id, $user_id, $conn = 'pgsql')
	{
		$admin = new Projectadminmodel;
		$admin->setConnection($conn);

		$admin->user_id = $user_id;
		$admin->project_id = $project_id;

		// $admin->iCreatedid = Auth::user()->id;

		$simpan = $admin->save();

		return $admin->id;
	}

}