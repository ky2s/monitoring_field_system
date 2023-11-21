<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class Formteammodel extends Model
{
	protected $table = 'form_team';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';

	public $timestamps = false;

	public function team()
    {
        return $this->hasOne('App\models\teammodel', 'id', 'team_id');
    }
	public function form()
    {
        return $this->hasOne('App\models\formmodel', 'id', 'form_id');
    }

	public static function listAll()
	{
		$row = Formteammodel::all();
		return $row;
	}

	public static function getData($id)
	{
		$row = Formteammodel::find($id);
		return $row;
	}
	public static function updateData($id, $team_id, $form_id, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$team = Formteammodel::find($id);
			
			$team->team_id = $team_id;
			$team->form_id = $form_id;
		}
		else{
            $sql = "UPDATE form_team SET
                    team_id = ".$team_id.", 
                    form_id = ".$form_id."
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);
		}
		return $return;
	}
	public static function destroyDataForm($id, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$data = Formteammodel::where('form_id', '=', $id);
			if($data)
				$data->delete();
		}
		else{
            $sql = "DELETE FROM form_team
                    WHERE form_id =".$id;
            $data = DB::connection('pgsqle')->update($sql);
		}
		return $data;
	}
	public static function storeData($form_id, $team_id, $conn = 'pgsql')
	{
		$team = new Formteammodel;
		$team->setConnection($conn);

		$team->team_id = $team_id;
		$team->form_id = $form_id;

		// $team->iCreatedid = Auth::team()->id;

		$simpan = $team->save();

		return $team->id;
	}

	public static function getByFormId($form_id, $conn='pgsql')
	{
		if($conn == 'pgsql'){
			$row = Formteammodel::select('*')->where('form_id', $form_id )->get();
			// $sql = "SELECT * FROM public.form_team WHERE form_id = ". $form_id;
            // $row = DB::select($sql);
		}
		
		return $row;
	}

}