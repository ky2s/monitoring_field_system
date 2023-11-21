<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class Formdetailmodel extends Model
{
	protected $table = 'form_detail';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';

	public $timestamps = false;

	public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
	public function form()
    {
        return $this->hasOne('App\models\Formmodel', 'id', 'form_id');
    }
	public function tipe()
    {
        return $this->hasOne('App\models\Formtipemodel', 'id', 'tipe_id');
    }

	public function group()
    {
        return $this->hasMany('App\models\Formdetailmodel', 'group_id', 'id')->orderBy('position');
    }

	public function kondisi()
    {
        return $this->hasMany('App\models\Formkondisimodel', 'idDetail', 'id');
    }
	public static function listAll()
	{
		$row = Formdetailmodel::all();
		return $row;
	}

	public static function getData($id)
	{
		$row = Formdetailmodel::find($id);
		return $row;
	}
	public static function getDataKondisi($idh, $id)
	{
		$row = Formdetailmodel::whereIn("tipe_id", [1, 6])
							  ->where("id", "!=", $id)
							  ->whereNull("group_id")
							  ->where("form_id", "=", $idh)->get();
		return $row;
	}
	public static function getDataKondisiGroup($idh, $id)
	{
		$row = Formdetailmodel::whereIn("tipe_id", [1, 6])->where("id", "!=", $id)->where("group_id", "=", $idh)->get();
		return $row;
	}

	public static function getDataByGroup($detailID)
	{
		$row = Formdetailmodel::where("group_id", "=", $detailID)->get();
		return $row;
	}

	public static function getDataKondisi2($idh)
	{
		$row = Formdetailmodel::whereIn("tipe_id", [1, 6])->where("form_id", "=", $idh)->get();
		return $row;
	}
	public static function getDataKondisi3($idh)
	{
		$row = Formdetailmodel::where("form_id", "=", $idh)->orderBy('group_id', 'desc')->get();
		return $row;
	}

	public static function getDataKondisi4($idh)
	{
		$row = Formdetailmodel::where("form_id", "=", $idh)->whereNotNull('group_id')->get();
		return $row;
	}

	public static function getDataByGroupID($idh)
	{
		$row = Formdetailmodel::where("form_id", "=", $idh)->whereNull('group_id')->get();
		return $row;
	}

	public static function getDataByPosition($idh, $tipe_id, $position)
	{
		$row = Formdetailmodel::where("form_id", "=", $idh)->where("tipe_id","=", $tipe_id)->where("position","=", $position)->whereNull('group_id')->get();
		return $row;
	}

	public static function updateKondisi($id, $data, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$fdetail = Formdetailmodel::find($id);
			$fdetail->andor = $data;
			$return = $fdetail->save();
		}
		else{
            $sql = "UPDATE form_detail SET
                    andor = '".$data."'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);
		}

		return $return;
	}
	
	public static function updatePosition($id, $p, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$fdetail = Formdetailmodel::find($id);
			$fdetail->position = $p;
			$return = $fdetail->save();
		}
		else{
            $sql = "UPDATE form_detail SET
                    position = '".$p."'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);
		}
		return $return;
	}
	public static function updateData($id, $data, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			$fdetail = Formdetailmodel::find($id);
			
			$fdetail->position = $data['position'];
			$fdetail->label = $data['label'];
			$fdetail->keterangan = $data['keterangan'];
			$fdetail->tipe_id = $data['tipe'];
			
			if($fdetail->tipe_id == 1 || $fdetail->tipe_id == 6 || $fdetail->tipe_id == 10){
				if($fdetail->tipe_id == 1){
					$fdetail->option = $data['option'];
					$fdetail->ismultiple = $data['ismultiple'];
				}
				$fdetail->maximum = $data['maximum'];
			}
			if($fdetail->tipe_id == 9 || $fdetail->tipe_id == 10){
				$fdetail->tipetulisan = $data['tipetulisan'];
			}
			$fdetail->mandatory = $data['mandatory'];

			$return = $fdetail->save();
		}
		else{
			$fdetail = Formdetailmodel::find($id);
			$max = "";
			if($fdetail->maximum)
				$max = "maximum = '".$fdetail->maximum."',";
            $sql = "UPDATE form_detail SET
                    position = '".$fdetail->position."',
                    label = '".$fdetail->label."',
                    keterangan = '".$fdetail->keterangan."',
                    option = '".$fdetail->option."',
                    ismultiple = '".$fdetail->ismultiple."',
                    ".$max."
                    tipetulisan = '".$fdetail->tipetulisan."',
                    mandatory = '".$fdetail->mandatory."'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);
		}

		return $return;
	}

	// delete quest row
	public static function destroyData($id, $fid, $conn = 'pgsql')
	{
		if($conn == 'pgsql'){
			
			$data = Formdetailmodel::find($id);
			
			if($data){

				// delete detail group
				$getGroup = Formdetailmodel::getDataByGroup($id);	
				
				if(count($getGroup) > 0){			
					foreach($getGroup as $v){
						if(!empty($v['id'])){
							Formdetailmodel::destroyData($v['id'], $v['form_id']);
						}
					}
				}
				
				// delete detail ID
				$data->delete();

				// delete detail form
				if($data->tipe->cfield == "Y"){
					$tname = "inputform".$data->form_id;
					$fname = "f".$data->id;
					$sql ="ALTER TABLE ".$tname."	DROP COLUMN ".$fname.";";
					DB::statement($sql);
				}

				
			}
		}
		else{
            $sql = "DELETE FROM form_detail
                    WHERE id =".$id;
            $data = DB::connection('pgsqle')->update($sql);

			$tname = "inputform".$fid;
			$fname = "f".$id;
			$sql ="ALTER TABLE ".$tname."	DROP COLUMN ".$fname.";";
			DB::connection($conn)->statement($sql);
		}

		return $data;
	}
	public static function storeData($form_id, $data, $group_id = '-', $conn = 'pgsql')
	{
		$fdetail = new Formdetailmodel;
		$fdetail->setConnection($conn);
		
		$fdetail->form_id = $form_id;
		$fdetail->tipe_id = $data['tipe'];
		$fdetail->position = $data['position'];
		$fdetail->label = $data['label'];
		$fdetail->keterangan = $data['keterangan'];
		
		if($data['tipe'] == 1 || $data['tipe'] == 6 || $data['tipe'] == 10){
			if($data['tipe'] == 1){
				$fdetail->option = $data['option'];
				$fdetail->ismultiple = $data['ismultiple'];
			}
			$fdetail->maximum = $data['maximum'];
		}
		if($fdetail->tipe_id == 9 || $fdetail->tipe_id == 10){
			$fdetail->tipetulisan = $data['tipetulisan'];
		}
		if(!empty($group_id) && $group_id != '-')
			$fdetail->group_id = $group_id;

		$fdetail->mandatory = $data['mandatory'];
		
		// $fdetail->iCreatedid = Auth::user()->id;
		
		$simpan = $fdetail->save();
		
		if($fdetail->tipe->cfield == 'Y'){
			$null  = "NULL";
			$fname = "f".$fdetail->id;
			$tname = "inputform".$form_id;
			$var   = $fdetail->tipe->fvar;

			$sql = "ALTER TABLE ".$tname." ADD COLUMN ".$fname." ".$var." ".$null.";";
			
			if($conn == 'pgsqle')
				DB::connection($conn)->statement($sql);
			else
				DB::statement($sql);
		}
		return $fdetail->id;
	}

}