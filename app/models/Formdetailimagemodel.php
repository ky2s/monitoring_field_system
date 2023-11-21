<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Formdetailimagemodel extends Model
{
    protected $table = 'form_detail_inputform_images';
	protected $primaryKey = 'id';
	protected $connection = 'pgsql';

	public $timestamps = false;


    public static function destroyDataImage($groupID, $conn = 'pgsql')
	{
		
		if($conn == 'pgsql'){
			
			$dataImage = Formdetailmodel::where('group_id',$groupID)->get();
            
			if(count($dataImage) > 0){
                
				// delete detail group
                foreach($dataImage as $v){
                    if(!empty($v['id'])){
                        $img = Formdetailimagemodel::where('form_detail_id', $v['id']);
                        $img->delete();
                    }
                }
			}
		}
		
		return $dataImage;
	}

}
