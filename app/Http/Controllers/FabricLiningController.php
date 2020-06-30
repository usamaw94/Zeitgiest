<?php

namespace App\Http\Controllers;

use App\Fabric;
use App\Lining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FabricLiningController extends Controller
{
    public function index(){
        $fabrics = DB::select('SELECT * FROM fabrics');
        $linings = DB::select('SELECT * FROM linings');

        $results = array(
            'fabrics' => $fabrics,
            'linings' => $linings,
        );

        return view('fabric_lining')->with($results);
    }

    public function addFabric(Request $request){
        $dbName = 'zeitgiest';
        $tableName = 'fabrics';

        $threePiece = $request->threePieceSuit;
        if($threePiece == null){
            $threePiece = 'no';
        }
        $twoPiece = $request->twoPieceSuit;
        if($twoPiece == null){
            $twoPiece = 'no';
        }
        $jacket = $request->jacket;
        if($jacket == null){
            $jacket = 'no';
        }
        $waistCoat = $request->waist_coat;
        if($waistCoat == null){
            $waistCoat = 'no';
        }
        $pant = $request->pant;
        if($pant == null){
            $pant = 'no';
        }
        $shirt = $request->shirt;
        if($shirt == null){
            $shirt = 'no';
        }

        $info = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableName]);

        $autoInc = $info[0]->AUTO_INCREMENT;

        $num = $request->fabricNum;

        $imgName = "fabric_img_".$autoInc."_".$num;

        $extension = $request->fabricImg->extension();

        $storeImg = $request->fabricImg->storeAs( '' , $imgName.".".$extension , 'upload');

        $imgPath  = '/uploads/'.$storeImg;

        $f =new Fabric;
        $f->itm_num = $num;
        $f->itm_img = $imgName;
        $f->itm_img_src = $imgPath;
        $f->stock = $request->fabricStock;
        $f->three_piece_suit = $threePiece;
        $f->two_piece_suit = $twoPiece;
        $f->jacket = $jacket;
        $f->waist_coat = $waistCoat;
        $f->pant = $pant;
        $f->shirt = $shirt;
        $saved = $f->save();

        if($saved) {
            $msg = 'Fabric added';
        } else{
            $msg = 'Fabric not added';
        }

        $msgs = array(
            'msg'  => $msg,
        );

        return back()->with($msgs);
    }

    public function editFabric(Request $request){
        $fId = $request->fabricId;
        $fNum = $request->fabricNum;
        $fImgName = $request->fabricImgName;
        $fStock = $request->fabricStock;
        $fChangedImg = $request->fabricChangedImg;


        $threePiece = $request->threePieceSuit;
        if($threePiece == null){
            $threePiece = 'no';
        }
        $twoPiece = $request->twoPieceSuit;
        if($twoPiece == null){
            $twoPiece = 'no';
        }
        $jacket = $request->jacket;
        if($jacket == null){
            $jacket = 'no';
        }
        $waistCoat = $request->waist_coat;
        if($waistCoat == null){
            $waistCoat = 'no';
        }
        $pant = $request->pant;
        if($pant == null){
            $pant = 'no';
        }
        $shirt = $request->shirt;
        if($shirt == null){
            $shirt = 'no';
        }

        if($fChangedImg != null && $fChangedImg != ''){

            $extension = $fChangedImg->extension();

            $storeImg = $fChangedImg->storeAs( '' , $fImgName.".".$extension , 'upload');

            $imgPath  = '/uploads/'.$storeImg;

            $update = DB::update("UPDATE fabrics SET itm_num = '".$fNum."', itm_img_src = '".$imgPath."', stock = '".$fStock."',
            three_piece_suit = '".$threePiece."', two_piece_suit = '".$twoPiece."', jacket = '".$jacket."', waist_coat = '".$waistCoat."', pant = '".$pant."', shirt = '".$shirt."'
            where itm_id = ?", [$fId]);

        } else {
            $update = DB::update("UPDATE fabrics SET itm_num = '".$fNum."' , stock = '".$fStock."',
            three_piece_suit = '".$threePiece."', two_piece_suit = '".$twoPiece."', jacket = '".$jacket."', waist_coat = '".$waistCoat."', pant = '".$pant."', shirt = '".$shirt."'
            where itm_id = ?", [$fId]);
        }

        $msg = 'Fabric updated';

        $msgs = array(
            'msg'  => $msg,
        );

        return back()->with($msgs);
    }

    public function deleteFabric($id){

        $item = DB::select('SELECT itm_img_src FROM fabrics WHERE itm_id = :id',['id' => $id]);

        $imgPath = $item[0]->itm_img_src;

        $image_path = public_path() . $imgPath;
        unlink($image_path);

        $delete = DB::delete("DELETE FROM fabrics WHERE itm_id=?",[$id]);
    }

    public function addLining(Request $request){
        $dbName = 'zeitgiest';
        $tableName = 'linings';

        $threePiece = $request->threePieceSuit;
        if($threePiece == null){
            $threePiece = 'no';
        }
        $twoPiece = $request->twoPieceSuit;
        if($twoPiece == null){
            $twoPiece = 'no';
        }
        $jacket = $request->jacket;
        if($jacket == null){
            $jacket = 'no';
        }
        $waistCoat = $request->waist_coat;
        if($waistCoat == null){
            $waistCoat = 'no';
        }
        $pant = $request->pant;
        if($pant == null){
            $pant = 'no';
        }
        $shirt = $request->shirt;
        if($shirt == null){
            $shirt = 'no';
        }

        $info = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableName]);

        $autoInc = $info[0]->AUTO_INCREMENT;

        $num = $request->liningNum;

        $imgName = "lining_img_".$autoInc."_".$num;

        $extension = $request->liningImg->extension();

        $storeImg = $request->liningImg->storeAs( '' , $imgName.".".$extension , 'upload');

        $imgPath  = '/uploads/'.$storeImg;

        $l =new Lining;
        $l->itm_num = $num;
        $l->itm_img = $imgName;
        $l->itm_img_src = $imgPath;
        $l->stock = $request->liningStock;
        $l->three_piece_suit = $threePiece;
        $l->two_piece_suit = $twoPiece;
        $l->jacket = $jacket;
        $l->waist_coat = $waistCoat;
        $l->pant = $pant;
        $l->shirt = $shirt;
        $saved = $l->save();

        if($saved) {
            $msg = 'Lining added';
        } else{
            $msg = 'Lining not added';
        }

        $msgs = array(
            'msg'  => $msg,
        );

        return back()->with($msgs);
    }

    public function editLining(Request $request){
        $lId = $request->liningId;
        $lNum = $request->liningNum;
        $lImgName = $request->liningImgName;
        $lStock = $request->liningStock;
        $lChangedImg = $request->liningChangedImg;

        $threePiece = $request->threePieceSuit;
        if($threePiece == null){
            $threePiece = 'no';
        }
        $twoPiece = $request->twoPieceSuit;
        if($twoPiece == null){
            $twoPiece = 'no';
        }
        $jacket = $request->jacket;
        if($jacket == null){
            $jacket = 'no';
        }
        $waistCoat = $request->waist_coat;
        if($waistCoat == null){
            $waistCoat = 'no';
        }
        $pant = $request->pant;
        if($pant == null){
            $pant = 'no';
        }
        $shirt = $request->shirt;
        if($shirt == null){
            $shirt = 'no';
        }

        if($lChangedImg != null && $lChangedImg != ''){

            $extension = $lChangedImg->extension();

            $storeImg = $lChangedImg->storeAs( '' , $lImgName.".".$extension , 'upload');

            $imgPath  = '/uploads/'.$storeImg;

            $update = DB::update("UPDATE linings SET itm_num = '".$lNum."', itm_img_src = '".$imgPath."', stock = '".$lStock."',
            three_piece_suit = '".$threePiece."', two_piece_suit = '".$twoPiece."', jacket = '".$jacket."', waist_coat = '".$waistCoat."', pant = '".$pant."', shirt = '".$shirt."'
            where itm_id = ?", [$lId]);

        } else {
            $update = DB::update("UPDATE linings SET itm_num = '".$lNum."' , stock = '".$lStock."',
            three_piece_suit = '".$threePiece."', two_piece_suit = '".$twoPiece."', jacket = '".$jacket."', waist_coat = '".$waistCoat."', pant = '".$pant."', shirt = '".$shirt."'
            where itm_id = ?", [$lId]);
        }

        $msg = 'Lining updated';

        $msgs = array(
            'msg'  => $msg,
        );

        return back()->with($msgs);
    }

    public function deleteLining($id){

        $item = DB::select('SELECT itm_img_src FROM linings WHERE itm_id = :id',['id' => $id]);

        $imgPath = $item[0]->itm_img_src;

        $image_path = public_path() . $imgPath;
        unlink($image_path);

        $delete = DB::delete("DELETE FROM linings WHERE itm_id=?",[$id]);
    }

}