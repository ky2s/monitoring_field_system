<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Intervention\Image\Facades\Image as Image;

class Formmodel___ extends Model
{
	protected $table = 'form';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';
	public $timestamps = false;

	public static $messages =array(
		'name.unique'=>'Nama Form Sudah ada..'
	);
	public static function validate($data){
		$rules =array(
			'name'=>'required|unique:form,nama'
		);
		return Validator::make($data, $rules, static::$messages);
	}
	public static function validateEdit($data, $id){
		$rulesEdit =array(
			'name'=>'required|unique:form,nama,'.$id.',id'

		);
		return Validator::make($data, $rulesEdit, static::$messages);
	}

	public function project(){
		return $this->belongsTo('App\models\Projectmodel','project_id');
	}

	public function auditor()
    {
        return $this->hasMany('App\models\Formauditormodel', 'form_id', 'id');
    }
	public function detail()
    {
        return $this->hasMany('App\models\Formdetailmodel', 'form_id', 'id')
        		->orderBy('group_id', 'desc')->orderBy('position');
    }

	public function team()
    {
        return $this->hasMany('App\models\Formteammodel', 'form_id', 'id');
    }

	public static function listMember($id)
	{
		$row = Formmodel::select('form.*')
						  ->join('form_team','form_team.form_id','=','form.id')
						  ->join('team','form_team.team_id','=','team.id')
						  ->join('team_member','team_member.team_id','=','team.id')
						  ->where('form.deleted', '=', 'Tidak')
						  ->where('form.publish', '=', 'Y')
						  ->where('form_team.deleted', '=', 'Tidak')
						  ->where('team.deleted', '=', 'Tidak')
						  ->where('team_member.deleted', '=', 'Tidak')
						  ->where('team_member.user_id', '=', $id)->get();
						
		return $row;
		

	}
	public static function getReportUser($id){
		$table = "inputform".$id;
		// $sql = "SELECT users.name, ".$table.".* FROM ".$table;
		// $sql .=" INNER JOIN users ON users.id = ".$table.'.user_id';
		// $query = DB::select($sql);
		$sql = "SELECT users.id, users.name FROM ".$table.
			   " INNER JOIN users ON users.id=".$table.".user_id 
			   GROUP BY users.id, users.name";
		$query = DB::select($sql);
		return $query;

	}
	public static function getReport($id, $start, $end, $users=null)
	{
		$table = "inputform".$id;
		// $sql = "SELECT users.name, ".$table.".* FROM ".$table;
		// $sql .=" INNER JOIN users ON users.id = ".$table.'.user_id';
		// $query = DB::select($sql);

		$select = array('users.name', 'users.phone', $table.'.*');
		$query = DB::table($table)
				->join('users', 'users.id', '=', $table.'.user_id')
				->orderBy('id', 'desc')
				->select($select);
		if(trim($start) !='19700101'){
			$query = $query->whereBetween(DB::raw("to_char(waktuisi, 'YYYYMMDD')"), [$start, $end]);
		}
		if(!empty($users)){
			$query = $query->whereIn($table.'.user_id', $users);	
		}
		// $sql2 = "INSERT INTO aaa (ket) VALUES ('".json_encode($pertanyaanID)."');";
		// $query2 = DB::insert($sql2);


		return $query;
	}
	public static function getReportExport($id, $start, $end)
	{
		$form = Formmodel::getData($id);
		$table = "inputform".$id;
		// $sql = "SELECT * FROM ".$table;
		// $query = DB::select($sql);
		$select = array( $table.'.uid', 'users.name as user', 'users.phone as phone',
						$table.'.latitude', $table.'.longitude', $table.'.waktuisi as waktu submit');

		foreach ($form->detail as $d) {
			if(($d->tipe->cfield == 'Y' || $d->tipe->isgroup == 'Y') && $d->group_id ==''){
				if($d->tipe->isgroup == 'Y'){
					foreach($d->group as $f){
						$select[] = $table.".f".$f->id." as ".$f->label;
					}
				}
				else{
					$select[] = $table.".f".$d->id." as ".$d->label;
				}
			}
		}


		$query = DB::table($table)
				->join('users', 'users.id', '=', $table.'.user_id')
				->select($select);

		if(trim($start) !='19700101'){
			$query = $query->whereBetween(DB::raw("to_char(waktuisi, 'YYYYMMDD')"), [$start, $end]);
		}
		// $sql2 = "INSERT INTO aaa (ket) VALUES ('".json_encode($pertanyaanID)."');";
		// $query2 = DB::insert($sql2);


		return $query;
	}

	public static function getReportStat($id, $period='daily', $tgl)
	{
		$table = "inputform".$id;
		$tmpDate = explode('-', $tgl);
		// exit(print_r($tmpDate));
		if($period == 'daily'){
			$sql = "SELECT count(id) as jml, to_char(waktuisi,'yyyy-mm-dd') as name 
					FROM ".$table."
					WHERE to_char(waktuisi,'yyyymm') = '".$tmpDate[0].$tmpDate[1]."'
					GROUP BY to_char(waktuisi,'yyyy-mm-dd') 
					ORDER BY name ASC";
		}
		else{
			$sql = "SELECT count(id) as jml, to_char(waktuisi,'yyyy-mm') as name 
					FROM ".$table."
					WHERE to_char(waktuisi,'yyyy') = '".$tmpDate[0]."'
					GROUP BY to_char(waktuisi,'yyyy-mm') 
					ORDER BY name ASC";
		}
		$query = DB::select($sql);

		// $sql2 = "INSERT INTO aaa (ket) VALUES ('".json_encode($pertanyaanID)."');";
		// $query2 = DB::insert($sql2);


		return $query;
	}
	public static function getReportStatUser($id, $period='daily', $tgl)
	{
		$table = "inputform".$id;
		$tmpDate = explode('-', $tgl);

		if($period == 'daily'){
			$sql = "SELECT count(a.id) as jml, b.name
					FROM ".$table." a
					INNER JOIN users b ON a.user_id = b.id
					WHERE to_char(waktuisi,'yyyy-mm-dd') = '".$tgl."'
					GROUP BY b.name
					ORDER BY b.name ASC";
		}
		else{
			$sql = "SELECT count(a.id) as jml, b.name
					FROM ".$table." a
					INNER JOIN users b ON a.user_id = b.id
					WHERE to_char(waktuisi,'yyyy-mm') = '".$tmpDate[0].$tmpDate[1]."'
					GROUP BY b.name
					ORDER BY b.name ASC";

		}
		// exit($sql);
		$query = DB::select($sql);

		// $sql2 = "INSERT INTO aaa (ket) VALUES ('".json_encode($pertanyaanID)."');";
		// $query2 = DB::insert($sql2);


		return $query;
	}
	public static function getCount($id)
	{
		$table = "inputform".$id;

		$sql = "SELECT COALESCE(COUNT(id), 0) as jml
				FROM ".$table;

		$query = DB::select($sql);

		return $query[0]->jml;
	}
	public static function getReportData($id, $uid)
	{
		$table = "inputform".$id;
		$sql = "SELECT * FROM ".$table." WHERE id = ".$uid;
		$query = DB::select($sql);

		// $sql2 = "INSERT INTO aaa (ket) VALUES ('".json_encode($pertanyaanID)."');";
		// $query2 = DB::insert($sql2);


		return $query;
	}
	public static function listAll()
	{
		if(Auth::user()->tipe == 'auditor'){
			$row = Formmodel::select('form.*')->
					join('form_auditor', 'form_auditor.form_id', '=', 'form.id')->
					where('form.deleted', '=', 'Tidak')->
					where(function($query) {
                		return $query->where('form_auditor.user_id', '=', Auth::user()->id)
                    				 ->orWhere('form_auditor.user_id', '=', Auth::user()->id);
            		})->get();
		}
		elseif (Auth::user()->tipe == 'admin') {
			$row = Formmodel::where('deleted', '=', 'Tidak')->get();
		}
		elseif(Auth::user()->tipe == 'manager'){
			$row = Formmodel::select('form.*')
				  ->join('form_team','form_team.form_id','=','form.id')
				  ->join('team','form_team.team_id','=','team.id')
				  ->join('team_member','team_member.team_id','=','team.id')
				  ->where('form.deleted', '=', 'Tidak')
				  ->where('form.publish', '=', 'Y')
				  ->where('form_team.deleted', '=', 'Tidak')
				  ->where('team.deleted', '=', 'Tidak')
				  ->where('team_member.deleted', '=', 'Tidak')
				  ->where('team_member.user_id', '=', Auth::user()->id)->get();
		}
		else{
			$row = array();
		}
		return $row;
	}

	public static function getData($id)
	{
		$row = Formmodel::find($id);
		return $row;
	}
	public static function updateData($id, $data, $conn='pgsql')
	{
		if($conn == 'pgsql'){
			$form = Formmodel::find($id);	        
			
			$form->name = $data['name'];
			$form->keterangan = $data['keterangan'];

			$return = $form->save();
		}
		else{
            $sql = "UPDATE form SET
                    name = '".$data['name']."', 
                    keterangan = '".$data['keterangan']."'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);
		}		
		return $return;
	}
	public static function destroyData($id, $conn='pgsql')
	{
		if($conn == 'pgsql'){
			$form = Formmodel::find($id);	        
	        $form->deleted = 'Ya';

			$return = $form->save();
		}
		else{
            $sql = "UPDATE form SET
                    deleted = 'Ya'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);
		}
		return $return;
	}
	public static function publishData($id, $conn='pgsql')
	{
		if($conn == 'pgsql'){
			$form = Formmodel::find($id);

	        $form->publish = $form->publish=='Y'?'N':'Y';

	        $return = $form->save();
		}
		else{
			$form = Formmodel::find($id);
			$publish = $form->publish;
            $sql = "UPDATE form SET
                    publish = '".$publish."'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);
		}
		return $return;
	}
	public static function lockData($id, $conn='pgsql')
	{
		if($conn == 'pgsql'){
			$form = Formmodel::find($id);

	        $form->elock = $form->elock?false:true;

	        $return = $form->save();
		}
		else{
			$form = Formmodel::find($id);	
			$elock = $form->elock?1:0;
            $sql = "UPDATE form SET
                    elock = '".$elock."'
                    WHERE id =".$id;
            $return = DB::connection('pgsqle')->update($sql);
		}
        $return = $form->save();
	}
	public static function storeData($data, $id, $conn='pgsql')
	{
		$form = new Formmodel;
		$form->setConnection($conn);

		$form->project_id = $id;
		$form->name = $data['name'];
		$form->keterangan = $data['keterangan'];

		// $form->iCreatedid = Auth::user()->id;

		$simpan = $form->save();
		
		// $sql = "CREATE TABLE IF NOT EXISTS inputform".$form->id." (
		//   id int(11) NOT NULL AUTO_INCREMENT,
		//   latitude varchar(11) NOT NULL,
		//   longitude varchar(11) NOT NULL,
		//   waktuisi TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		//   PRIMARY KEY (id)
		// ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";

		$sql = "CREATE TABLE inputform".$form->id."
				(
				  id bigserial NOT NULL,
				  imei character varying(100) NOT NULL,
				  uid character varying(255) NOT NULL,
				  latitude character varying(100) NOT NULL,
				  longitude character varying(100) NOT NULL,
				  waktuisi timestamp with time zone NOT NULL DEFAULT now(),
				  user_id bigint NOT NULL,
				  CONSTRAINT idx_if".$form->id."_primary PRIMARY KEY (id),
				  UNIQUE(uid, waktuisi)
				)
				WITH (
				  OIDS=FALSE
				);";
		if($conn == 'pgsqle')
			DB::connection($conn)->statement($sql);
		else
			DB::statement($sql);

		return $form->id;
	}
	public static function checkData($table, $uid, $waktuisi){
		$sql = "SELECT COUNT(id) as jml FROM ".$table." WHERE uid = '".$uid."' AND waktuisi = '".$waktuisi."'";
		$query = DB::select($sql);
		return $query[0]->jml;
	}
	public static function jmlData($table, $user){
		$sql = "SELECT COUNT(id) as jml FROM ".$table." WHERE user_id = '".$user."'";
		$query = DB::select($sql);
		return $query[0]->jml;
	}
	public static function checkDuplicate($id, $user, $jawaban, $pertanyaanID)
	{
		$tablename = "inputform".$id;
		$form = Formmodel::getData($id);

		$newJawaban = array();
		for($x=0;$x<count($pertanyaanID);$x++) {
			$newJawaban[$pertanyaanID[$x]] = $jawaban[$x];
		}
		$where = "";
		foreach ($form->detail as $row) {
			if($row->tipe->isgroup =='N'){
				$nf = "f".$row->id;
				if (in_array($nf, $pertanyaanID)){
					if($row->tipe->ismedia == 'N'){
						$where .= $nf." = '". $newJawaban[$nf] ."' AND ";
					}
				}
			}
		}
		$where .= " user_id = ".$user;
		$sql = "SELECT count(id) as jml FROM ".$tablename." WHERE ".$where;
		$query = DB::select($sql);
		return $query[0]->jml;
	}	
	public static function simpanSurvey($id, $user, $waktu, $latitude, $longitude, $jawaban, $pertanyaanID, $imei, $uid){
		$form = Formmodel::getData($id);
		$fields = "";
		$vals = "";

		$newJawaban = array();
		for($x=0;$x<count($pertanyaanID);$x++) {
			$jawaban[$x] = str_replace("'", "''", $jawaban[$x]);
			$newJawaban[$pertanyaanID[$x]] = $jawaban[$x];
		}

		foreach ($form->detail as $row) {
			if($row->tipe->isgroup =='N'){
				$nf = "f".$row->id;
				if (in_array($nf, $pertanyaanID)){
					$fields .= $nf.", ";
					if($row->tipe->id == 2 || $row->tipe->id == 18){
						$file = base64_decode($newJawaban[$nf]);
						$jpg_url = "survey".$id."-".time().$imei.$nf.".jpg";
					    $path = $form->id.'/' . $jpg_url;
	
					    // Image::make(file_get_contents($file))->save($path);
					    // file_put_contents($path, $file);
					    \Storage::disk('spaces')->put($path, $file, 'public');
					    // if($id == 25)
					    	$vals .= "'".\Storage::disk('spaces')->url($id.'/'.$jpg_url)."', ";
						// else
					    	// $vals .= "'".$jpg_url."', ";
					}
					else{
						$vals .= "'".$newJawaban[$nf]."', ";
					}
				}
			}
		}
		$nvals = str_replace("'", "#", $vals);
		$sql = "INSERT INTO inputform".$id." (".$fields."latitude, longitude, waktuisi, user_id, imei, uid)
				VALUES(".$vals."'".$latitude."', '".$longitude."', '".$waktu."', '".$user."', '".$imei."', '".$uid."')";
		$query = DB::insert($sql);
		// $query2 = DB::connection('pgsqle')->insert($sql);

		// $sql2 = "INSERT INTO aaa (ket) VALUES ('".$sql."');";
		// $query2 = DB::insert($sql2);

		// $sql3 = "INSERT INTO aaa (ket) VALUES ('".json_encode($pertanyaanID)."');";
		// $query3 = DB::insert($sql3);

		// $sql4 = "INSERT INTO aaa (ket) VALUES ('".json_encode($jawaban)."');";
		// $query4 = DB::insert($sql4);


		return $query;
		// return $query2;
	}

}