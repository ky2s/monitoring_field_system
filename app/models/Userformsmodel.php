<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class Userformsmodel extends Model
{
	protected $table = 'user_forms';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';

	public $timestamps = false;

	public function user()
    {
        return $this->hasOne('App\User', 'id', 'id_user');
    }
	public function form()
    {
        return $this->hasOne('App\models\formmodel', 'id', 'id_form');
    }

	public static function listAll()
	{
		$row = Userformsmodel::where('deleted', '=', 'Tidak')->get();
		return $row;
	}

	public static function getData($id)
	{
		$row = Userformsmodel::find($id);
		return $row;
	}
	public static function updateData($id, $id_user, $id_form, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$form = Userformsmodel::find($id);
	        
			$form->id_user = $id_user;
			$form->id_form = $id_form;
			$return = $form->save();
	    }
        else{
            $sql = "UPDATE user_forms SET
                    id_user = ".$id_user.", 
                    id_form = ".$id_form."
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);        	
        }
		return $return;
	}
	public static function destroyData($id, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$form = Userformsmodel::find($id);
	        
	        $form->deleted = 'Ya';
	        $return = $form->save();
	    }
        else{
            $sql = "UPDATE user_forms SET
                    deleted = 'Ya'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);        	
        }

        return $return;
	}
	public static function destroyDataUser($id, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$form = Userformsmodel::where("id_user", "=", $id);
	        
	        $form->delete();
	        $return = array();
	    }
        else{
            $sql = "DELETE FROM user_forms
                    WHERE id_user =".$id;
            $return = DB::connection('pgsqle')->update($sql);
        }

        return $return;
	}
	public static function storeData($id_user, $id_form, $conn = 'pgsql')
	{
		$form = new Userformsmodel;
		$form->setConnection($conn);

		$form->id_user = $id_user;
		$form->id_form = $id_form;

		// $form->iCreatedid = Auth::user()->id;

		$simpan = $form->save();

		return $form->id;
	}

}