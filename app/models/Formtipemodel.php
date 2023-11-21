<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;

class Formtipemodel extends Model
{
	protected $table = 'form_tipe';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';

	public $timestamps = false;

	public static function listAll()
	{
		$row = Formtipemodel::where('deleted', '=', 'Tidak')->get();
		return $row;
	}

	public static function getData($id)
	{
		$row = Formtipemodel::find($id);
		return $row;
	}
	public static function updateData($id, $data)
	{
		$project = Formtipemodel::find($id);
		
		$project->name = $data['name'];
		
		// $project->iUpdatedid = Auth::user()->id;
		// $project->tUpdated = date('Y-m-d h:i:s');

		$return = $project->save();
		return $return;
	}
	public static function destroyData($id)
	{
		$project = Formtipemodel::find($id);
		$project->delete();

		// $project->iUpdatedid = Auth::user()->id;
		// $project->tUpdated = date('Y-m-d h:i:s');

		return $project;
	}
	public static function storeData($data)
	{
		$project = new Formtipemodel;

		$project->name = $data['name'];
	
		// $project->iCreatedid = Auth::user()->id;

		$simpan = $project->save();

		return $project->id;
	}

}