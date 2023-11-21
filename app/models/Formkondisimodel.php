<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;

class Formkondisimodel extends Model
{
	protected $table = 'form_kondisi';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';

	public $timestamps = false;

	public static function listAll()
	{
		$row = Formkondisimodel::all();
		return $row;
	}

	public static function getData($id)
	{
		$row = Formkondisimodel::find($id);
		return $row;
	}

	public static function getData2($id)
	{
		$row = Formkondisimodel::where('idDetailkondisi', '=', $id)->first();
		
		return $row;
	}
	public static function getSelected($id)
	{
		$row = Formkondisimodel::where('idDetail', '=', $id)->first();
		if($row)
			$ret = ' selected';
		else
			$ret = '';
		return $ret;
	}
	public static function getSelected2($id)
	{
		$row = Formkondisimodel::where('idDetailkondisi', '=', $id)->first();
		if($row)
			$ret = ' selected';
		else
			$ret = '';
		return $ret;
	}
	public static function updateData($id, $user_id, $form_id, $conn = 'pgsql')
	{
		$Formkondisimodel = new Formkondisimodel;
		$Formkondisimodel->setConnection($conn);
		
		$team = $Formkondisimodel::find($id);
		
		$team->user_id = $user_id;
		$team->form_id = $form_id;
		
		// $team->iUpdatedid = Auth::user()->id;
		// $team->tUpdated = date('Y-m-d h:i:s');

		$return = $team->save();
		return $return;
	}
	public static function destroyDataForm($id, $conn = 'pgsql')
	{
		$Formkondisimodel = new Formkondisimodel;
		$Formkondisimodel->setConnection($conn);
		
		$data = $Formkondisimodel::where('idDetail', '=', $id);
		if($data)
			$data->delete();

		return $data;
	}
	public static function destroyData($id, $conn = 'pgsql')
	{
		$Formkondisimodel = new Formkondisimodel;
		$Formkondisimodel->setConnection($conn);

		$data = $Formkondisimodel::find($id);
		$data->delete();

		// $team->iUpdatedid = Auth::user()->id;
		// $team->tUpdated = date('Y-m-d h:i:s');

		return $data;
	}
	public static function storeData($id, $d, $l, $n, $conn = 'pgsql')
	{
		$team = new Formkondisimodel;
		$team->setConnection($conn);

		// $team->master_id = $m;
		$team->idDetail = $id;
		$team->kondisi = $l;
		$team->idDetailkondisi = $d;
		$team->nilai = $n;

		// $team->iCreatedid = Auth::user()->id;

		$simpan = $team->save();

		return $team->id;
	}

}