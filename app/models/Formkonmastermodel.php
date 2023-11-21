<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;

class Formkonmastermodel extends Model
{
	protected $table = 'form_kondisi_master';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';

	public $timestamps = false;

	public static function listAll()
	{
		$row = Formkonmastermodel::all();
		return $row;
	}

	public static function listAllForm($id)
	{
		$row = Formkonmastermodel::where('form_id', '=', $id)->get();
		return $row;
	}
	public function detail()
    {
        return $this->hasMany('App\models\Formkondisimodel', 'master_id', 'id');
    }
	public static function getData($id)
	{
		$row = Formkonmastermodel::find($id);
		return $row;
	}
	public static function updateData($id, $data)
	{
		$project = Formkonmastermodel::find($id);
		
		$project->name = $data['andor'];
		
		// $project->iUpdatedid = Auth::user()->id;
		// $project->tUpdated = date('Y-m-d h:i:s');

		$return = $project->save();
		return $return;
	}
	public static function destroyData($id)
	{
		$project = Formkonmastermodel::find($id);
		$project->delete();

		// $project->iUpdatedid = Auth::user()->id;
		// $project->tUpdated = date('Y-m-d h:i:s');

		return $project;
	}
	public static function storeData($f, $k)
	{
		$project = new Formkonmastermodel;

		$project->form_id = $f;
		$project->andor = $k;
	
		// $project->iCreatedid = Auth::user()->id;

		$simpan = $project->save();

		return $project->id;
	}

}