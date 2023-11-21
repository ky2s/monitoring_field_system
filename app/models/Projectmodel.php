<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class Projectmodel extends Model
{
	protected $table = 'project';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';

	public $timestamps = false;

	public static $messages =array(
		'name.unique'=>'Nama Project Sudah ada..'
	);
	public static function validate($data){
		$rules =array(
			'name'=>'required|unique:project,nama'
		);
		return Validator::make($data, $rules, static::$messages);
	}
	public static function validateEdit($data, $id){
		$rulesEdit =array(
			'name'=>'required|unique:project,nama,'.$id.',id'

		);
		return Validator::make($data, $rulesEdit, static::$messages);
	}
	public function admin()
    {
        return $this->hasMany('App\models\Projectadminmodel', 'project_id', 'id');
    }

	public function form()
    {
        return $this->hasMany('App\models\Formmodel', 'project_id', 'id');
    }
	
	public function formr() {
        return $this->form()->where('deleted','=', 'Tidak')->orderBy('id', 'ASC');
    }
	public static function listAll()
	{
		if(Auth::user()->tipe=='manager')
			$row = Projectmodel::where('project.deleted','=', 'Tidak')
					->where('project_admin.user_id', '=', Auth::user()->id)
					->join('project_admin','project_admin.project_id','=','project.id')
					->select('project.*')
					->get();
		else
			$row = Projectmodel::where('deleted','=', 'Tidak')->get();

		return $row;
	}

	public static function getData($id)
	{
		$row = Projectmodel::find($id);
		return $row;
	}
	public static function updateData($id, $data, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$project = Projectmodel::find($id);
			$project->name = $data['name'];
			$project->description = $data['description'];

			$return = $project->save();
	    }
        else{
            $sql = "UPDATE project SET
                    name = '".$data['name']."', 
                    description = '".$data['description']."'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);        	
        }

		return $return;
	}
	public static function destroyData($id, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$project = Projectmodel::find($id);
			$project->deleted = 'Ya';

			$return = $project->save();
	    }
        else{
            $sql = "UPDATE project SET
                    deleted = 'Ya'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);        	
        }

		return $return;
	}
	public static function publishData($id, $p, $conn = 'pgsql')
	{
		$Projectmodel = new Projectmodel;
		$Projectmodel->setConnection($conn);

		$project = $Projectmodel::find($id);
		$project->publish = $p;

		// $project->iUpdatedid = Auth::user()->id;
		// $project->tUpdated = date('Y-m-d h:i:s');

		$return = $project->save();
		return $return;
	}
	public static function storeData($data, $conn = 'pgsql')
	{
		$project = new Projectmodel;
		$project->setConnection($conn);

		$project->name = $data['name'];
		$project->description = $data['description'];

		// $project->iCreatedid = Auth::user()->id;

		$simpan = $project->save();

		return $project->id;
	}

}