<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;
use App\Http\Requests\ShopCheck;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(){
        $shops = DB::select('SELECT * FROM shops');
        $results = array(
            'shops' => $shops,
        );
        return view('shops')->with($results);
    }

    public function add(ShopCheck $request){

        $dbName = 'zeitgiest';
        $tableName = 'shops';

        $info = DB::select('SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND   TABLE_NAME   = ?',[$dbName,$tableName]);

        $autoInc = $info[0]->AUTO_INCREMENT;

        $s_id = "zgs".$autoInc;

        $s =new Shop;
        $s->shop_id = $s_id;
        $s->s_address = $request->address;
        $s->s_password = $request->password;
        $saved = $s->save();

        if($saved) {
            $msg = 'Shop created';
        } else{
            $msg = 'Data not saved';
        }

        $msgs = array(
            'msg'  => $msg,
        );

        return back()->with($msgs);
    }

    public function edit($id){

        $shop = DB::select('SELECT * FROM shops WHERE shop_id = :id',['id' => $id]);

        $result = array(
            'shop'  => $shop,
        );


        return view('edit_shop')->with($result);
    }

    public function update(Request $request){

        $update = DB::update("UPDATE shops SET s_address = '".$request->address."' , s_password = '".$request->password."'
           where shop_id = ?", [$request->Id]);

        if($update) {
            $msg = 'Shop updated';
        } else{
            $msg = 'Data not saved';
        }

        $msgs = array(
            'msg'  => $msg,
        );

        return redirect('/shops')->with($msgs);

    }

    public function delete($id){

        $delete = DB::delete("DELETE FROM shops WHERE shop_id=?",[$id]);

    }
}
