<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;

class Formauditormodel extends Model
{
	protected $table = 'form_auditor';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';

	public $timestamps = false;

	public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
	public function form()
    {
        return $this->hasOne('App\model\formmodel', 'id', 'form_id');
    }

	public static function listAll()
	{
		$row = Formauditormodel::all();
		return $row;
	}

	public static function getData($id)
	{
		$row = Formauditormodel::find($id);
		return $row;
	}
	public static function updateData($id, $user_id, $form_id, $conn='pgsql')
	{
		if($conn == 'pgsql'){
			$team = Formauditormodel::find($id);
			
			$team->user_id = $user_id;
			$team->form_id = $form_id;
			$return = $team->save();
		}
		else{
            $sql = "UPDATE form_auditor SET
                    user_id = ".$user_id.", 
                    form_id = ".$form_id."
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);
		}
		return $return;
	}
	public static function destroyDataForm($id, $conn='pgsql')
	{
		if($conn == 'pgsql'){
			$data = Formauditormodel::where('form_id', '=', $id);
			if($data)
				$data->delete();
		}
		else{
            $sql = "DELETE FROM form_auditor
                    WHERE form_id =".$id;
            $data = DB::connection('pgsqle')->update($sql);
		}

		return $data;
	}
	public static function storeData($form_id, $user_id, $conn='pgsql')
	{
		$team = new Formauditormodel;
		$team->setConnection($conn);

		$team->user_id = $user_id;
		$team->form_id = $form_id;

		// $team->iCreatedid = Auth::user()->id;

		$simpan = $team->save();

		return $team->id;
	}

	public static function getByFormId($form_id, $conn='pgsql')
	{
		if($conn == 'pgsql'){
			
			$row = Formauditormodel::select('*')->where('form_id', $form_id )->get();

			// $sql = "SELECT * FROM public.form_auditor WHERE form_id = ". $form_id;
            // $row = DB::select($sql);
		}
		return $row;
	}
}