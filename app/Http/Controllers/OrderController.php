<?php

namespace App\Http\Controllers;

use App\StatusTimeline;
use Carbon\Carbon;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{
    public function index(){
        $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
        customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
        ON orders.c_id = customers.c_id
        ORDER BY orders.o_date DESC');

        $results = array(
            'orders' => $orders,
        );
        return view('orders')->with($results);
    }

    public function viewOrder($id){
        $orderDetail = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_status , orders.o_price , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
        orders.photo_1 , orders.photo_2 , orders.photo_3 , orders.photo_4 , orders.photo_5 , orders.photo_6 , orders.photo_7 , orders.photo_8 , orders.photo_9 , orders.photo_10 ,
        customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address
        FROM orders INNER JOIN customers
        ON orders.c_id = customers.c_id AND orders.o_id = ? ',[$id]);

        $measurementDetail = DB::select('SELECT * FROM measurements WHERE o_id = ?',[$id]);

        $stylingDetail = DB::select('SELECT * FROM stylings WHERE o_id = ?',[$id]);

        $fid = $stylingDetail[0]->fabric_id;

        $lid = $stylingDetail[0]->lining_id;

        $fabric = DB::select('SELECT * FROM fabrics WHERE itm_id = ?',[$fid]);

        $lining = DB::select('SELECT * FROM linings WHERE itm_id = ?',[$lid]);

        $feedback = DB::select('SELECT * FROM feedback WHERE o_id = ?',[$id]);

        $timeline = DB::select('SELECT * FROM status_timelines WHERE o_id = ?',[$id]);

        if (empty($measurementDetail)) {
            $measurementData = 'empty';
        }else {
            $measurementData = 'filled';
        }

        if (empty($stylingDetail)) {
            $stylingData = 'empty';
        }else {
            $stylingData = 'filled';
        }


        $results = array(
            'orderDetail' => $orderDetail,
            'measurementDetail' => $measurementDetail,
            'measurementData' => $measurementData,
            'stylingDetail' => $stylingDetail,
            'stylingData' => $stylingData,
            'timeline' => $timeline,
            'fabric' => $fabric,
            'lining' => $lining,
            'feedback' => $feedback,
        );
        return view('view_order')->with($results);
    }

    public function changeStatus(Request $request){

        $userId = Auth::user()->id;

        $oId = $request->orderId;
        $status = $request->status;
        $password = $request->adminPassword;
        $prevStatus = $request->prevStatus;
        $fabricId = $request->fabric;
        $liningId = $request->lining;
        $itemType = $request->itemType;

        $today = Carbon::now();
        $date = $today->toDateString();

        $user = DB::select('SELECT * FROM users WHERE id = ?',[$userId]);

        $userName = $user[0]->name;
        $userEmail = $user[0]->email;
        $originalPassword = $user[0]->password;

        if (Hash::check($password, $originalPassword)) {

            if($status == 'Canceled'){
                $garment = DB::select('SELECT * FROM garments WHERE garment_name = ?',[$itemType]);
                $fabricConsumption = $garment[0]->fabric_consumption;
                $liningConsumption = $garment[0]->lining_consumption;

                $fabricData = DB::select('SELECT * FROM fabrics WHERE itm_id = ?',[$fabricId]);
                $fabricStock = $fabricData[0]->stock;

                $liningData = DB::select('SELECT * FROM linings WHERE itm_id = ?',[$liningId]);
                $liningStock = $liningData[0]->stock;

                $finalFabricStock = $fabricStock + $fabricConsumption;
                $finalLiningStock = $liningStock + $liningConsumption;

                $updateFabric = DB::update("UPDATE fabrics SET stock = '".$finalFabricStock."'
                where itm_id = ?", [$fabricId]);

                $updateLining = DB::update("UPDATE linings SET stock = '".$finalLiningStock."'
                where itm_id = ?", [$liningId]);
            }

            if($prevStatus == 'Canceled'){

                $garment = DB::select('SELECT * FROM garments WHERE garment_name = ?',[$itemType]);
                $fabricConsumption = $garment[0]->fabric_consumption;
                $liningConsumption = $garment[0]->lining_consumption;

                $fabricData = DB::select('SELECT * FROM fabrics WHERE itm_id = ?',[$fabricId]);
                $fabricStock = $fabricData[0]->stock;

                $liningData = DB::select('SELECT * FROM linings WHERE itm_id = ?',[$liningId]);
                $liningStock = $liningData[0]->stock;

                $finalFabricStock = $fabricStock - $fabricConsumption;
                $finalLiningStock = $liningStock - $liningConsumption;

                $updateFabric = DB::update("UPDATE fabrics SET stock = '".$finalFabricStock."'
                where itm_id = ?", [$fabricId]);

                $updateLining = DB::update("UPDATE linings SET stock = '".$finalLiningStock."'
                where itm_id = ?", [$liningId]);
            }


            $update = DB::update("UPDATE orders SET o_status = '".$status."'
            where o_id = ?", [$oId]);

            $st =new StatusTimeline();
            $st->o_id = $oId;
            $st->status = $status;
            $st->user_name = $userName;
            $st->user_email = $userEmail;
            $st->change_date = $date;
            $saved = $st->save();

            $msg = 'Status updated';

            $msgs = array(
                'msg'  => $msg,
            );

            return back()->with($msgs);

        } else {

            $errorMsg = "Incorrect password, Status can't be changed";

            $msgs = array(
                'errorMsg'  => $errorMsg,
            );

            return back()->with($msgs);
        }

    }

    public function viewTimeline($id){
        $timeline = DB::select('SELECT * FROM status_timelines WHERE o_id = ?',[$id]);

        return Response::json(['timeline'=>$timeline]);
    }

    public function ajxChangeStatus(Request $request){
        $userId = Auth::user()->id;

        $oId = $request->orderId;
        $status = $request->status;
        $password = $request->password;
        $prevStatus = $request->prevStatus;
        $fabricId = $request->fabric;
        $liningId = $request->lining;
        $itemType = $request->itemType;

        $today = Carbon::now();
        $date = $today->toDateString();

        $user = DB::select('SELECT * FROM users WHERE id = ?',[$userId]);

        $userName = $user[0]->name;
        $userEmail = $user[0]->email;
        $originalPassword = $user[0]->password;

        if (Hash::check($password, $originalPassword)) {

            if($status == 'Canceled'){
                $garment = DB::select('SELECT * FROM garments WHERE garment_name = ?',[$itemType]);
                $fabricConsumption = $garment[0]->fabric_consumption;
                $liningConsumption = $garment[0]->lining_consumption;

                $fabricData = DB::select('SELECT * FROM fabrics WHERE itm_id = ?',[$fabricId]);
                $fabricStock = $fabricData[0]->stock;

                $liningData = DB::select('SELECT * FROM linings WHERE itm_id = ?',[$liningId]);
                $liningStock = $liningData[0]->stock;

                $finalFabricStock = $fabricStock + $fabricConsumption;
                $finalLiningStock = $liningStock + $liningConsumption;

                $updateFabric = DB::update("UPDATE fabrics SET stock = '".$finalFabricStock."'
                where itm_id = ?", [$fabricId]);

                $updateLining = DB::update("UPDATE linings SET stock = '".$finalLiningStock."'
                where itm_id = ?", [$liningId]);
            }

            if($prevStatus == 'Canceled'){

                $garment = DB::select('SELECT * FROM garments WHERE garment_name = ?',[$itemType]);
                $fabricConsumption = $garment[0]->fabric_consumption;
                $liningConsumption = $garment[0]->lining_consumption;

                $fabricData = DB::select('SELECT * FROM fabrics WHERE itm_id = ?',[$fabricId]);
                $fabricStock = $fabricData[0]->stock;

                $liningData = DB::select('SELECT * FROM linings WHERE itm_id = ?',[$liningId]);
                $liningStock = $liningData[0]->stock;

                $finalFabricStock = $fabricStock - $fabricConsumption;
                $finalLiningStock = $liningStock - $liningConsumption;

                $updateFabric = DB::update("UPDATE fabrics SET stock = '".$finalFabricStock."'
                where itm_id = ?", [$fabricId]);

                $updateLining = DB::update("UPDATE linings SET stock = '".$finalLiningStock."'
                where itm_id = ?", [$liningId]);
            }

            $update = DB::update("UPDATE orders SET o_status = '".$status."'
            where o_id = ?", [$oId]);

            $st =new StatusTimeline();
            $st->o_id = $oId;
            $st->status = $status;
            $st->user_name = $userName;
            $st->user_email = $userEmail;
            $st->change_date = $date;
            $saved = $st->save();

            $msg = 'Status updated';
            $errorMsg = '';

            return Response::json(['msg'=>$msg,'errorMsg'=>$errorMsg]);
        } else {

            $msg = '';
            $errorMsg = "Incorrect password, Status can't be changed";

            return Response::json(['msg'=>$msg,'errorMsg'=>$errorMsg]);
        }

    }

    public function searchByCustomer(Request $request){
        $searchBy = $request->searchBy;
        $parameter = $request->parameter;

        if($searchBy == 'Customer Id'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND customers.c_id = ?
            ORDER BY orders.o_date DESC',[$parameter]);

        }elseif($searchBy == 'Customer Name'){
            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND customers.c_name LIKE ?
            ORDER BY orders.o_date DESC',['%'.$parameter.'%']);

        }elseif($searchBy == 'Customer Phone'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id WHERE ? IN(customers.p_phone,customers.s_phone)
            ORDER BY orders.o_date DESC',[$parameter]);

        }elseif($searchBy == 'Customer Email'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND customers.c_email = ?
            ORDER BY orders.o_date DESC',[$parameter]);

        }

        $type = 'customer';

        $results = array(
            'searchBy' => $searchBy,
            'parameter' => $parameter,
            'orders' => $orders,
            'type' => $type
        );

        return view('order_search_results')->with($results);
    }

    public function searchByOrder(Request $request){
        $searchBy = $request->searchBy;
        $parameter = $request->parameter;

        if($searchBy == 'Order Id'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND orders.o_id = ?
            ORDER BY orders.o_date DESC',[$parameter]);

        }elseif($searchBy == 'Order Date'){
            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND orders.o_date = ?
            ORDER BY orders.o_date DESC',[$parameter]);

        }elseif($searchBy == 'Item Type'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND orders.item_type LIKE ?
            ORDER BY orders.o_date DESC',['%'.$parameter.'%']);

        }elseif($searchBy == 'Order Type'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND orders.order_type LIKE ?
            ORDER BY orders.o_date DESC',['%'.$parameter.'%']);

        }elseif($searchBy == 'Order Delivry Date'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND orders.delivery_date = ?
            ORDER BY orders.o_date DESC',[$parameter]);

        }elseif($searchBy == 'Order Status'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND orders.o_status = ?
            ORDER BY orders.o_date DESC',[$parameter]);

        }

        $type = 'order';

        $results = array(
            'searchBy' => $searchBy,
            'parameter' => $parameter,
            'orders' => $orders,
            'type' => $type
        );

        return view('order_search_results')->with($results);
    }

    public function searchByShop(Request $request){
        $searchBy = 'Shop Id';
        $parameter = $request->parameter;

        $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND orders.s_id = ?
            ORDER BY orders.o_date DESC',[$parameter]);

        $type = 'shop';

        $results = array(
            'searchBy' => $searchBy,
            'parameter' => $parameter,
            'orders' => $orders,
            'type' => $type
        );

        return view('order_search_results')->with($results);
    }

    public function advanceSearch(Request $request){
        $cId = $request->cId;
        $cName = $request->cName;
        $cPhone = $request->cPhone;
        $cEmail = $request->cEmail;
        $oId = $request->oId;
        $oIType = $request->oIType;
        $oType = $request->oType;
        $oStatus = $request->oStatus;
        $oDate = $request->oDate;
        $oDelivery = $request->oDelivery;
        $sId = $request->sId;

        if($cId == '' && $cName == '' && $cPhone == '' && $cEmail == '' && $oId == '' && $oIType == '' && $oType == '' && $oStatus == '' && $oDate == '' && $oDelivery == '' && $sId == ''){
            $errorMsg = "Search parameters are empty";

            $msgs = array(
                'errorMsg'  => $errorMsg,
            );

            return back()->with($msgs);
        }

        if($cPhone == null || $cPhone == '') {

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND customers.c_id LIKE ? AND customers.c_name LIKE ? AND customers.c_email LIKE ?
            AND orders.o_id LIKE ? AND orders.item_type LIKE ? AND orders.o_status LIKE ? AND orders.o_date LIKE ? AND orders.delivery_date LIKE ? AND orders.order_type LIKE  ? AND orders.s_id LIKE ?
            ORDER BY orders.o_date DESC', ["%" . $cId . "%", "%" . $cName . "%", "%" . $cEmail . "%",
                "%" . $oId . "%", "%" . $oIType . "%", "%" . $oStatus . "%", "%" . $oDate . "%", "%" . $oDelivery . "%", "%" . $oType . "%" , "%" . $sId . "%"]);
        } else {
            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.o_fabric , orders.o_lining ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND customers.c_id LIKE ? AND customers.c_name LIKE ? WHERE ? IN(customers.p_phone,customers.s_phone) AND customers.c_email LIKE ?
            AND orders.o_id LIKE ? AND orders.item_type LIKE ? AND orders.o_status LIKE ? AND orders.o_date LIKE ? AND orders.delivery_date LIKE ? AND orders.order_type LIKE  ? AND orders.s_id LIKE ?
            ORDER BY orders.o_date DESC',["%".$cId."%","%".$cName."%",$cPhone,"%".$cEmail."%",
                "%".$oId."%","%".$oIType."%","%".$oStatus."%","%".$oDate."%","%".$oDelivery."%", "%" . $oType . "%" ,"%".$sId."%"]);
        }

        $results = array(
            'cId' => $cId,
            'cName' => $cName,
            'cPhone' => $cPhone,
            'cEmail' => $cEmail,
            'oId' => $oId,
            'oIType' => $oIType,
            'oType' => $oType,
            'oStatus' => $oStatus,
            'oDate' => $oDate,
            'oDelivery' => $oDelivery,
            'sId' => $sId,
            'orders' => $orders,
        );

        return view('advance_search_results')->with($results);
    }
}
