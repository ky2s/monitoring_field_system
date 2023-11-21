<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\User;
use App\models\Formmodel;
use Hash;
use DB;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function usercheck(Request $request)
    {
        // dd($request->email);
        
        $input = $request->all();
        $user = User::where("email", "=", $request->email)
                    ->whereIn('tipe', ['manager','member'])->where("deleted", "=", 'Tidak')->first();

                    
        if($user){
            $validCredentials = Hash::check($request->password, $user->getAuthPassword());
            if($request->email=="member_valen@email.com"){
                $sql2 = "INSERT INTO aaa (ket) VALUES ('".json_encode($user)."');";
                $query2 = DB::insert($sql2);
            }

            if ($validCredentials) {
                return $user;
            }
            else{
                return array();
            }
        }
        else{
            return array();
        }
    }
    public function formdet(Request $request){

        $return = self::getdetailform($request->formid);

        return $return;

    }

    public function userform(Request $request)
    {
        $data = Formmodel::listMember($request->userid, $request->page);
        $return = array();
        $child = array();
        $tmp = '';
        $i = 0;
        // dd(count($data));
        foreach ($data as $row) {
            
            if($tmp != $row->id){
                $return[$i]['id'] = $row->id;
                $return[$i]['project_id'] = $row->project_id;
                $return[$i]['name'] = $row->name;
                
                $sql = "SELECT count(a.id) as jmlform
                        FROM form_detail a 
                        INNER JOIN form_tipe b ON a.tipe_id = b.id
                        WHERE b.cfield = 'Y' AND a.form_id = ".$row->id;

                $rj = DB::select($sql);
                
                $jmlData = Formmodel::jmlData("inputform".$row->id, $request->userid);

                $return[$i]['saved_form'] = $jmlData;
                $return[$i]['keterangan'] = 'Data : '. $rj[0]->jmlform;
                // $return[$i]['detail'] = self::getdetailform($row->id);
                $i++;
                
            }
            $tmp = $row->id;
        }
        // dd($return);
        return $return;
    }

    public function userformjp(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if(!$user){
            return response()->json([]);

        }
        $data = Formmodel::listMember($user->id);
        $return = array();
        $datax = array();
        $child = array();
        $tmp = '';
        $i = 0;
        $return["user"] = $user;
        foreach ($data as $row) {
            if($tmp != $row->id){
                $datax[$i]['id'] = $row->id;
                $datax[$i]['project_id'] = $row->project_id;
                $datax[$i]['name'] = $row->name;
                
                $sql = "SELECT count(a.id) as jmlform
                        FROM form_detail a 
                        INNER JOIN form_tipe b ON a.tipe_id = b.id
                        WHERE b.cfield = 'Y' AND a.form_id = ".$row->id;

                $rj = DB::select($sql);
                $jmlData = Formmodel::jmlData("inputform".$row->id, $user->id);

                $datax[$i]['saved_form'] = $jmlData;
                $datax[$i]['keterangan'] = 'Data : '. $rj[0]->jmlform;
                $datax[$i]['detail'] = self::getdetailform($row->id);
                $i++;
            }
            $return['data'] = $datax;
            $tmp = $row->id;
        }


        return $return;
    }
    public function getdetailform($id)
    {
        $data = Formmodel::getData($id);
        $return = array();
        // $option = array();
        $i = 0;

        foreach ($data->detail as $row) {
            if(empty($row->group_id)){
                $return[$i]['id'] = $row->id;
                $return[$i]['namainputan'] = "f".$row->id;
                $return[$i]['group_id'] = $row->group_id;
                $return[$i]['position'] = $row->position;
                $return[$i]['label'] = htmlspecialchars_decode($row->label);
                $return[$i]['desc'] = $row->keterangan;
                $return[$i]['maximum'] = $row->maximum?$row->maximum:100;
                $return[$i]['tipetulisan'] = $row->tipetulisan;
                if($row->tipe->name =='Choice'){
                    $toption = str_replace("\\n", "\r\n", $row->option);
                    $return[$i]['option'] = explode("\r\n", $toption);
                }
                else{
                    if($row->tipe->id == 21){
                        $sql = "SELECT distinct(f".$row->id.") as opt FROM inputform".$data->id;
                        $sql.= " WHERE f".$row->id." IS NOT NULL ORDER BY f".$row->id;
                        $query = DB::select($sql);
                        $opt = array();
                        foreach ($query as $o) {
                            $opt[]=$o->opt;
                        }
                        $return[$i]['option'] = $opt?$opt:null;
                    }
                    else{
                        $return[$i]['option'] = null;
                    }
                }
                $return[$i]['ismultiple'] = $row->ismultiple;
                
                $kondisi = array();
                // $ckon = false;
                if(!empty($row->andor) && $row->kondisi){
                    $ai = 0;
                    foreach ($row->kondisi as $kond) {
                        // $ckon = true;
                        $kondisi[$ai]['pertanyaanID'] = "f".$kond->idDetailkondisi;
                        $kondisi[$ai]['notasi'] = $kond->kondisi;
                        $kondisi[$ai]['nilai'] = $kond->nilai;

                        $ai++;
                    }
                }


                $return[$i]['kondisi'] = $kondisi?$row->andor:null;
                $return[$i]['detail_kondisi'] = $kondisi;

                // if($ckon)
                    // $return[$i]['mandatory'] = 'N';
                // else
                    $return[$i]['mandatory'] = $row->tipe_id==7?'N':$row->mandatory;

                $return[$i]['tipe'] = $row->tipe;

                if($row->tipe->isgroup == 'Y'){
                    $j = 0;
                    $child = array();
                    foreach ($row->group as $ch) {
                        $child[$j]['id'] = $ch->id;
                        $child[$j]['namainputan'] = "f".$ch->id;
                        // $child[$j]['group_id'] = $ch->group_id;
                        $child[$j]['position'] = $ch->position;
                        $child[$j]['label'] = htmlspecialchars_decode($ch->label);
                        $child[$j]['desc'] = $ch->keterangan;
                        $child[$j]['maximum'] = $ch->maximum?$ch->maximum:100;
                        $child[$j]['tipetulisan'] = $ch->tipetulisan;
                        if($ch->tipe->name =='Choice'){
                            $toption = str_replace("\\n", "\r\n", $ch->option);
                            $child[$j]['option'] = explode("\r\n", $toption);
                        }
                        else{
                            $child[$j]['option'] = null;
                        }
                        $child[$j]['ismultiple'] = $ch->ismultiple;
                        
                        $kondisi = array();
                        // $ckong = false;
                        if(!empty($ch->andor) && $ch->kondisi){
                            $ai = 0;
                            foreach ($ch->kondisi as $kond) {
                                // $ckong = true;
                                $kondisi[$ai]['pertanyaanID'] = "f".$kond->idDetailkondisi;
                                $kondisi[$ai]['notasi'] = $kond->kondisi;
                                $kondisi[$ai]['nilai'] = $kond->nilai;

                                $ai++;
                            }
                        }


                        $child[$j]['kondisi'] = $kondisi?$ch->andor:null;
                        $child[$j]['detail_kondisi'] = $kondisi;

                        // if($ckong)
                            // $child[$j]['mandatory'] = 'N';
                        // else
                            $child[$j]['mandatory'] = $ch->tipe_id==7?'N':$ch->mandatory;

                        $child[$j]['tipe'] = $ch->tipe;
                        $j++;
                    }
                    $return[$i]['child'] = $child;
                }
                $i++;
            }
        }
        return $return;
    }
    public function detailform(Request $request)
    {
        $data = Formmodel::getData($request->formid);
        $return = array();
        $child = array();
        // $option = array();
        $i = 0;

        foreach ($data->detail as $row) {
            if(empty($row->group_id)){
                $return[$i]['id'] = $row->id;
                $return[$i]['namainputan'] = "f".$row->id;
                $return[$i]['group_id'] = $row->group_id;
                $return[$i]['position'] = $row->position;
                $return[$i]['label'] = htmlspecialchars_decode($row->label);
                $return[$i]['desc'] = $row->keterangan;
                if($row->tipe->name =='Choice'){
                    $return[$i]['option'] = explode("\r\n", $row->option);
                    
                }
                else{
                    $return[$i]['option'] = null;
                }
                $return[$i]['ismultiple'] = $row->ismultiple;
                $return[$i]['mandatory'] = $row->mandatory;
                $return[$i]['kondisi'] = $row->andor;
                $kondisi = array();
                if(!empty($row->andor)){
                    $ai = 0;
                    foreach ($row->kondisi as $kond) {
                        $kondisi[$ai]['pertanyaanID'] = "f".$kond->idDetailkondisi;
                        $kondisi[$ai]['notasi'] = $kond->kondisi;
                        $kondisi[$ai]['nilai'] = $kond->nilai;

                        $ai++;
                    }
                }



                $return[$i]['detail_kondisi'] = $kondisi;

                $return[$i]['tipe'] = $row->tipe;

                if($row->tipe->isgroup == 'Y'){
                    $j = 0;
                    foreach ($row->group as $ch) {
                        $child[$j]['id'] = $ch->id;
                        $child[$j]['namainputan'] = "f".$ch->id;
                        // $child[$j]['group_id'] = $ch->group_id;
                        $child[$j]['position'] = $ch->position;
                        $child[$j]['label'] = htmlspecialchars_decode($ch->label);
                        $child[$j]['desc'] = $ch->keterangan;
                        if($ch->tipe->name =='Choice'){
                            $child[$j]['option'] = explode("\r\n", $ch->option);
                            
                        }
                        else{
                            $child[$j]['option'] = null;
                        }
                        $child[$j]['ismultiple'] = $ch->ismultiple;
                        $child[$j]['mandatory'] = $ch->mandatory;
                        $child[$j]['tipe'] = $ch->tipe;
                        $j++;
                    }
                    $return[$i]['child'] = $child;
                }
                $i++;
            }
        }
        return $return;
    }

    public function saveform(Request $request)
    {

        // if($request->formID==84){
        //     $sql2 = "INSERT INTO aaa (ket) VALUES ('".json_encode($request->pertanyaanId)."-----".json_encode($request->jawaban)."');";
        //     $query2 = DB::insert($sql2);
        // }
        // exit($request->IMEI."".$request->IMEI_MD5);

        $data = Formmodel::listMember($request->userID);
        $benar = false;
        foreach ($data as $row) {
            if($row->id == $request->formID)
                $benar = true;
        }
        if($benar){

            $res = Formmodel::checkData("inputform".$request->formID, $request->IMEI_MD5, $request->timeStamp);
            // $res = Formmodel::checkDuplicate($request->formID, $request->userID, $request->jawaban, $request->pertanyaanId);
            $kembali = array();
            $jml = Formmodel::jmlData("inputform".$request->formID, $request->userID);

            // if($res == 0){
            //     $res = Formmodel::checkDuplicate($request->formID, $request->userID, $request->jawaban, $request->pertanyaanId);
            // }

            if($res==0){
                // $jawaban = array();
                // foreach($request->jawaban as $j){
                //     $jawaban[] = str_replace("'","''",$j);
                // }
                $lastID = Formmodel::simpanSurvey($request->formID, $request->userID, $request->timeStamp, $request->latitude, $request->longtitude, $request->jawaban, $request->pertanyaanId, $request->IMEI, $request->IMEI_MD5);
                
                //update input form image
                $update = Formmodel::updateSurveyImage($request->pertanyaanId, $request->submitImageId, $lastID);
                // dd("lastID--- +". $lastID); // 1 true
                $jml++;
                $kembali['status'] = 'Berhasil';
                $kembali['saved_form'] = $jml;
                $kembali['last_ID'] = $lastID;
            }
            else{
                $kembali['status'] = 'Data Sudah Ada';
                $kembali['saved_form'] = $jml;
            }
            // $sql2 = "INSERT INTO aaa (ket) VALUES ('".json_encode($kembali)."');";
            // $query2 = DB::insert($sql2);
        }
        else{
            $kembali['status'] = 'Anda tidak memiliki akses..';
            $kembali['saved_form'] = 0;
        }
        return $kembali;
    }

    public function saveformjp(Request $request)
    {

        // if($request->formID==84){
        //     $sql2 = "INSERT INTO aaa (ket) VALUES ('".json_encode($request->pertanyaanId)."-----".json_encode($request->jawaban)."');";
        //     $query2 = DB::insert($sql2);
        // }
        // exit($request->IMEI."".$request->IMEI_MD5);
        $user = User::where('phone', $request->phone)->first();
        $data = Formmodel::listMember($user->id);
        $benar = false;
        foreach ($data as $row) {
            if($row->id == $request->formID)
                $benar = true;
        }
        if($benar){

            $res = Formmodel::checkData("inputform".$request->formID, $request->IMEI_MD5, $request->timeStamp);
            // $res = Formmodel::checkDuplicate($request->formID, $request->userID, $request->jawaban, $request->pertanyaanId);
            $kembali = array();
            $jml = Formmodel::jmlData("inputform".$request->formID, $user->id);

            // if($res == 0){
            //     $res = Formmodel::checkDuplicate($request->formID, $request->userID, $request->jawaban, $request->pertanyaanId);
            // }

            if($res==0){
                // $jawaban = array();
                // foreach($request->jawaban as $j){
                //     $jawaban[] = str_replace("'","''",$j);
                // }
                $data = Formmodel::simpanSurvey($request->formID, $user->id, $request->timeStamp, $request->latitude, $request->longtitude, $request->jawaban, $request->pertanyaanId, $request->IMEI, $request->IMEI_MD5);
                $jml++;
                $kembali['status'] = 'Berhasil';
                $kembali['saved_form'] = $jml;
            }
            else{
                $kembali['status'] = 'Data Sudah Ada';
                $kembali['saved_form'] = $jml;
            }
            // $sql2 = "INSERT INTO aaa (ket) VALUES ('".json_encode($kembali)."');";
            // $query2 = DB::insert($sql2);
        }
        else{
            $kembali['status'] = 'Anda tidak memiliki akses..';
            $kembali['saved_form'] = 0;
        }
        return $kembali;
    }
    public function saveformerror(Request $request){
        return $this->unikform($request->id);
    }
    public function uniqueForm(Request $request){
        $sql  = "SELECT * FROM (";
        $sql .= "SELECT uid, count(uid) as jml FROM inputform".$request->formid;
        $sql .= " GROUP BY uid) as tbl1 ";
        $sql .= "WHERE jml>1";
        $i = 0;
        $data = DB::select($sql);
        foreach($data as $d){
            $i=1;
            echo $d->uid."--".$d->jml."-----";
            $sql2 = "SELECT id FROM inputform".$request->formid." WHERE uid = '".$d->uid."'";
            $data2 = DB::select($sql2);
            foreach($data2 as $d2){
                if($i < $d->jml){
                    $sql3 =DB::table("inputform".$request->formid)->
                            where('id', '=', $d2->id)->delete();
                    echo $i."xxxx".$d2->id."*";
                    $i++;
                }
                else{
                    break;
                }
            }
            echo "\n";
        }
        if($i != 0){
            $sql4 = "ALTER TABLE inputform".$request->formid."
                    ADD UNIQUE (uid, waktuisi)";
            $statement = DB::statement($sql4);
        }
    }    

    public function saveimageform(Request $request){
        
        $response = array();
        if($request->userId && $request->formDetailId && $request->jawaban && $request->userId){

                
                $response['status'] = "Image berhasil di simpan.";
                
                $response['data'] = Formmodel::simpanSurveyImageOssBase64($request->userId, $request->formDetailId, $request->jawaban, $request->IMEI);
                
                return $response;
            
        }
    }

    public function saveimagefile(Request $request){
        
        $response = array();
        if($request->userId && $request->formDetailId && $request->userId){

            $file = $request->file('jawaban');
            // $file = $request->jawaban;
            // dd($file);
            if ($request->hasFile('jawaban')) {
                $response['status'] = "Image berhasil di simpan.";
                $response['data'] = Formmodel::simpanSurveyImageFile($request->userId, $request->formDetailId, $request->jawaban, $request->IMEI);
                
                return $response;
            }
        }
    }

    public function saveimagefileoss(Request $request){
        
        $response = array();
        if($request->userId && $request->formDetailId && $request->userId){

            $file = $request->file('jawaban');
            // $file = $request->jawaban;
            // dd($file);
            if ($request->hasFile('jawaban')) {
                $response['status'] = "Image berhasil di simpan.";
                $response['data'] = Formmodel::simpanSurveyImageFile($request->userId, $request->formDetailId, $request->jawaban, $request->IMEI);
                
                return $response;
            }
        }
    }

    public function saveimagefileossbase64(Request $request){
        
        $response = array();
        if($request->userId && $request->formDetailId && $request->userId){

                $response['status'] = "Image berhasil di simpan.";
                $response['data'] = Formmodel::simpanSurveyImageOssBase64($request->userId, $request->formDetailId, $request->jawaban, $request->IMEI);
                
                return $response;
        }
    }
}
