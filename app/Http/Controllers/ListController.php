<?php

namespace App\Http\Controllers;

use App\City;
use App\ListItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    public function index(){

        $lists = DB::select('SELECT * FROM lists');

        $results = array(
            'lists' => $lists,
        );
        return view('lists')->with($results);
    }

    public function listItems($id){

        $list = DB::select('SELECT * FROM lists WHERE li_id = :id',['id' => $id]);

        $listItems = DB::select('SELECT * FROM list_items WHERE lst_id = :id',['id' => $id]);

        $results = array(
            'lst' => $list,
            'listItems' => $listItems,
        );

        return view('list_items')->with($results);
    }

    public function addItem(Request $request){
        $l =new ListItem;
        $l->lst_id = $request->listId;
        $l->itm_name = $request->itemName;
        $l->lst_name = $request->listName;
        $l->itm_img = '--';
        $l->itm_img_src = '--';
        $l->itm_img_status = 'no';
        $saved = $l->save();

        if($saved) {
            $msg = 'Item added';
        } else{
            $msg = 'Item not added';
        }

        $msgs = array(
            'msg'  => $msg,
        );

        return back()->with($msgs);
    }

    public function editItem(Request $request){
        $update = DB::update("UPDATE list_items SET itm_name = '".$request->mItemName."'
        where itm_id = ?", [$request->mItemID]);
    }

    public function deleteItem($id){

        $item = DB::select('SELECT itm_img_src FROM list_items WHERE itm_id = :id',['id' => $id]);

        $imgPath = $item[0]->itm_img_src;

        if($imgPath != '--' && $imgPath != null && $imgPath != '') {
            $image_path = public_path() . $imgPath;
            unlink($image_path);
        }

        $delete = DB::delete("DELETE FROM list_items WHERE itm_id=?",[$id]);
    }

    public function addImgItem(Request $request){
        $dbName = 'zeitgiest';
        $tableName = 'list_items';

        $info = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableName]);

        $autoInc = $info[0]->AUTO_INCREMENT;

        $itemName = $request->itemName;

        $imgName = "itm_img_".$autoInc;

        $img = $request->itemImg;

        if($img != null || $img != ''){

            $extension = $request->itemImg->extension();

            $storeImg = $request->itemImg->storeAs( '' , $imgName.".".$extension , 'upload');

            $imgPath  = '/uploads/'.$storeImg;
        } else {

            $imgPath = '--';
        }

        $l =new ListItem;
        $l->lst_id = $request->listId;
        $l->itm_name = $request->itemName;
        $l->lst_name = $request->listName;
        $l->itm_img = $imgName;
        $l->itm_img_src = $imgPath;
        $l->itm_img_status = 'yes';
        $saved = $l->save();

        if($saved) {
            $msg = 'Item added';
        } else{
            $msg = 'Item not added';
        }

        $msgs = array(
            'msg'  => $msg,
        );

        return back()->with($msgs);
    }

    public function editImgItem(Request $request){

        $itemName = $request->ImgItmName;
        $listId = $request->listId;
        $itemId= $request->itemId;
        $reset = $request->itmImage;
        $del = $request->delStatus;
        $imgName = $request->imgName;

        if($del == 'yes'){

            $delPath = $request->oldImg;

            $del_img = public_path().$delPath;
            unlink($del_img);

            $imgPath = "";

        } elseif($reset == '' || $reset == null && $del == 'no') {

            $imgPath = $request->oldImg;

        }elseif($reset != null || $reset != '' && $del == 'no'){

            $extension = $reset->extension();

            $storeImg = $reset->storeAs( '' , $imgName.".".$extension , 'upload');

            $imgPath  = '/uploads/'.$storeImg;
        }


        $update = DB::update("UPDATE list_items SET itm_name = '".$itemName."', itm_img_src = '".$imgPath."'
        where itm_id = ?", [$itemId]);

        if($update) {
            $msg = 'Item updated';
        } else{
            $msg = 'Item not updated';
        }

        $msgs = array(
            'msg'  => $msg,
        );

        return back()->with($msgs);
    }

    public function cities(){
        $cities = DB::select('SELECT * FROM cities');

        $results = array(
            'cities' => $cities,
        );

        return view('cities')->with($results);
    }

    public function addCity(Request $request){
        $c =new City;
        $c->city_name = $request->cityName;
        $saved = $c->save();

        if($saved) {
            $msg = 'City added';
        } else{
            $msg = 'City not added';
        }

        $msgs = array(
            'msg'  => $msg,
        );

        return back()->with($msgs);
    }

    public function editCity(Request $request){
        $update = DB::update("UPDATE cities SET city_name = '".$request->mItemName."'
        where city_id = ?", [$request->mItemID]);
    }

    public function deleteCity($id){
        $delete = DB::delete("DELETE FROM cities WHERE city_id=?",[$id]);
    }

}
