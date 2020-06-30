<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminChangePassword;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin');
    }

    public function adminChangePassword(){
        return view('admin_change_password');
    }

    public function adminChangeRequest(AdminChangePassword $request){

        $adminId = Auth::user()->id;

        $admin = DB::select('SELECT * FROM admins WHERE id = ?',[$adminId]);
        $originalPassword = $admin[0]->password;

        $cPass = $request->currentPassword;
        $nPass = $request->newPassword;

        $hNPass = bcrypt($nPass);

        if (Hash::check($cPass, $originalPassword)) {
            $update = DB::update("UPDATE admins SET password = '".$hNPass."'
            where id = ?", [$adminId]);

            $update = DB::update("UPDATE a_ps SET pw = '".$hNPass."'
            where id = ?", [$adminId]);

            $msg = 'Password Changed';

            $msgs = array(
                'msg'  => $msg,
            );

            return redirect('/admin')->with($msgs);
        } else {

            $errorMsg = "Incorrect current password, Password can't be changed";

            $msgs = array(
                'errorMsg'  => $errorMsg,
            );

            return back()->with($msgs);
        }


    }

    public function userIndex(){

        $users = DB::select('SELECT * FROM temp_users');

        $results = array(
            'users' => $users,
        );
        return view('users')->with($results);
    }

    public function activateUser($id){

        $user = DB::select('SELECT * FROM temp_users WHERE id = :id',['id' => $id]);

        $id = $user[0]->id;
        $name = $user[0]->name;
        $email = $user[0]->email;
        $password = $user[0]->password;
        $status = 'Active';

        $aU = new User;
        $aU->id = $id;
        $aU->name = $name;
        $aU->email = $email;
        $aU->password = $password;
        $aU->save();

        $update = DB::update("UPDATE temp_users SET status = '".$status."'
           where id = ?", [$id]);

    }

    public function deactivateUser($id){

        $status = 'Deactive';

        $delete = DB::delete("DELETE FROM users WHERE id=?",[$id]);

        $update = DB::update("UPDATE temp_users SET status = '".$status."'
           where id = ?", [$id]);
    }

    public function deleteUser($id){
        $user = DB::select('SELECT * FROM temp_users WHERE id = :id',['id' => $id]);

        $status = $user[0]->status;

        if($status == 'Active'){
            $delete = DB::delete("DELETE FROM users WHERE id=?",[$id]);
            $delete = DB::delete("DELETE FROM temp_users WHERE id=?",[$id]);
        }elseif($status == 'Deactive'){
            $delete = DB::delete("DELETE FROM temp_users WHERE id=?",[$id]);
        }
    }

    public function showPassword(Request $request){
        $uId = $request->userId;
        $aPass = $request->adminPass;

        $adminId = Auth::user()->id;

        $admin = DB::select('SELECT * FROM admins WHERE id = ?',[$adminId]);
        $originalPassword = $admin[0]->password;

        if($aPass == '' || $aPass == null){

            $result = 'Enter Admin Password';

            return Response::json(['result'=>$result]);

        } elseif (Hash::check($aPass, $originalPassword)) {
            $user = DB::select('SELECT org_password FROM temp_users WHERE id = ?',[$uId]);
            $result = $user[0]->org_password;

            return Response::json(['result'=>$result]);
        } else {
            $result = 'Incorrect Admin Password';

            return Response::json(['result'=>$result]);
        }
    }



//    ---------------------------------------------------------------------

    public function orders(){
        $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
        customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
        ON orders.c_id = customers.c_id
        ORDER BY orders.o_date DESC');

        $results = array(
            'orders' => $orders,
        );
        return view('admin_orders')->with($results);
    }

    public function adminViewOrder($id){
        $orderDetail = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_status , orders.o_price , orders.delivery_date , orders.order_type ,
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
        return view('admin_view_order')->with($results);
    }

    public function searchByCustomer(Request $request){
        $searchBy = $request->searchBy;
        $parameter = $request->parameter;

        if($searchBy == 'Customer Id'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND customers.c_id = ?
            ORDER BY orders.o_date DESC',[$parameter]);

        }elseif($searchBy == 'Customer Name'){
            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND customers.c_name LIKE ?
            ORDER BY orders.o_date DESC',['%'.$parameter.'%']);

        }elseif($searchBy == 'Customer Phone'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id WHERE ? IN(customers.p_phone,customers.s_phone)
            ORDER BY orders.o_date DESC',[$parameter]);

        }elseif($searchBy == 'Customer Email'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
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

        return view('admin_order_search_results')->with($results);
    }

    public function searchByOrder(Request $request){
        $searchBy = $request->searchBy;
        $parameter = $request->parameter;

        if($searchBy == 'Order Id'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND orders.o_id = ?
            ORDER BY orders.o_date DESC',[$parameter]);

        }elseif($searchBy == 'Order Date'){
            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND orders.o_date = ?
            ORDER BY orders.o_date DESC',[$parameter]);

        }elseif($searchBy == 'Item Type'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND orders.item_type LIKE ?
            ORDER BY orders.o_date DESC',['%'.$parameter.'%']);

        }elseif($searchBy == 'Order Type'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND orders.order_type LIKE ?
            ORDER BY orders.o_date DESC',['%'.$parameter.'%']);

        }elseif($searchBy == 'Order Delivry Date'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND orders.delivery_date = ?
            ORDER BY orders.o_date DESC',[$parameter]);

        }elseif($searchBy == 'Order Status'){

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
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

        return view('admin_order_search_results')->with($results);
    }

    public function searchByShop(Request $request){
        $searchBy = 'Shop Id';
        $parameter = $request->parameter;

        $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
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

        return view('admin_order_search_results')->with($results);
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

            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
            customers.c_id , customers.c_name , customers.p_phone ,  customers.s_phone , customers.c_email , customers.c_city , customers.c_address FROM orders INNER JOIN customers
            ON orders.c_id = customers.c_id AND customers.c_id LIKE ? AND customers.c_name LIKE ? AND customers.c_email LIKE ?
            AND orders.o_id LIKE ? AND orders.item_type LIKE ? AND orders.o_status LIKE ? AND orders.o_date LIKE ? AND orders.delivery_date LIKE ? AND orders.order_type LIKE  ? AND orders.s_id LIKE ?
            ORDER BY orders.o_date DESC', ["%" . $cId . "%", "%" . $cName . "%", "%" . $cEmail . "%",
                "%" . $oId . "%", "%" . $oIType . "%", "%" . $oStatus . "%", "%" . $oDate . "%", "%" . $oDelivery . "%", "%" . $oType . "%" , "%" . $sId . "%"]);
        } else {
            $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type ,
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

        return view('admin_advance_search_results')->with($results);
    }

    public function exportOrders(){
        $orders = DB::select('SELECT orders.o_id , orders.c_id , orders.s_id , orders.o_date , orders.item_type , orders.o_price , orders.o_status , orders.delivery_date , orders.order_type , orders.base_pattern , orders.base_size , customers.c_id , customers.c_name , customers.p_phone , customers.s_phone , customers.c_email , customers.c_city , customers.c_address, measurements.stance , measurements.shoulder,
measurements.chest, measurements.stomach , measurements.hip , measurements.neck, measurements.full_chest , measurements.shoulder_width , measurements.right_sleeve, measurements.left_sleeve, measurements.bicep, measurements.wrist, measurements.waist_stomach, measurements.hip_m, measurements.front_jacket_length, measurements.front_chest_width, measurements.back_width, measurements.half_shoulder_width_left , measurements.half_shoulder_width_right, measurements.full_back_length, measurements.half_back_length, measurements.trouser_waist, measurements.trouser_outseam, measurements.trouser_inseam, measurements.crotch, measurements.thigh, measurements.knee, measurements.right_full_sleeve, measurements.left_full_sleeve , stylings.fabric_num , stylings.lining_num , stylings.fitting , stylings.jacket_style, stylings.front_panel_roundness, stylings.jacket_length, stylings.lapel_style, stylings.lapel_curvature, stylings.lapel_pick_stitch, stylings.shoulder_construction, stylings.vent_style, stylings.breast_pocket, stylings.side_pocket, stylings.ticket_pocket, stylings.breast_pocket, stylings.cuff_button, stylings.functional_cuff, stylings.trouser_pleat, stylings.trouser_back_pocket, stylings.trouser_cuff, stylings.trouser_loop_tab, stylings.waist_coat_type, stylings.waist_coat_pocket_type, stylings.back , stylings.buttons , stylings.lapel_eyelet_color , stylings.cuff_eyelet_color , stylings.piping_color , stylings.melton_undercollar_num , stylings.shoulder_pads FROM orders JOIN customers JOIN measurements JOIN stylings ON orders.c_id = customers.c_id AND orders.o_id = measurements.o_id AND orders.o_id = stylings.o_id');


        $ordersData = "";
        if(count($orders)>0){
            $ordersData.= '<table border="1">
            <tr><th>Order Id</th>
                <th>Customer Id</th>
                <th>Shop Id</th>
                <th>Date Placed</th>
                <th>Item type</th>
                <th>Price</th>
                <th>Status</th>
                <th>Delivery Date</th>
                <th>Order Type</th>
                <th>Base Pattern</th>
                <th>Base Size</th>
                <th>Customer Name</th>
                <th>Customer Primary Phone</th>
                <th>Customer Secondary Phone</th>
                <th>Customer Email</th>
                <th>Customer City</th>
                <th>Customer Address</th>
                <th>Stance</th>
                <th>Shoulder</th>
                <th>Chest</th>
                <th>Stomach</th>
                <th>Hip</th>
                <th>Neck</th>
                <th>Full Chest</th>
                <th>Shoulder Width</th>
                <th>Right Sleeve</th>
                <th>Left Sleeve</th>
                <th>Bicep</th>
                <th>Wrist</th>
                <th>Waist Stomach</th>
                <th>Hip Size</th>
                <th>Front Jacket Length</th>
                <th>Front Chest Width</th>
                <th>Back Widt</th>
                <th>Half Left Shoulder Width</th>
                <th>Half Right Shoulder Width</th>
                <th>Full Back Length</th>
                <th>Half Back Length</th>
                <th>Trouser Waist</th>
                <th>Trouser Outseam</th>
                <th>Trouser Inseam</th>
                <th>Crotch</th>
                <th>Thigh</th>
                <th>Knee</th>
                <th>Right Full Sleeve</th>
                <th>Left Full Sleeve</th>
                <th>Fabric Num</th>
                <th>Lining Num</th>
                <th>Fitting</th>
                <th>Jacket Style</th>
                <th>Front Panel Roundness</th>
                <th>Jacket Length</th>
                <th>Lapel Style</th>
                <th>Lapel Curvature</th>
                <th>Lapel Pick Stitch</th>
                <th>Shoulder Construction</th>
                <th>Vent Style</th>
                <th>Breast Pocket</th>
                <th>Side Pocket</th>
                <th>Ticket Pocket</th>
                <th>Cuff Button</th>
                <th>Functional Cuff</th>
                <th>Trouser Pleat</th>
                <th>Trouser Back Pocket</th>
                <th>Trouser Cuff</th>
                <th>Trouser Loop Tab</th>
                <th>Waist Coat Type</th>
                <th>Waist Coat Pocket Type</th>
                <th>Back</th>
                <th>Buttons</th>
                <th>Lapel Eyelet Color</th>
                <th>Cuff Eyelet Color</th>
                <th>Piping Color</th>
                <th>Melton Undercoller Num</th>
                <th>Shoulder Pads</th></tr>';

            foreach($orders as $o) {
                $ordersData .= '
                <tr><td>'.$o->o_id.'</td>
                <td>'.$o->c_id.'</td>
                <td>'.$o->s_id.'</td>
                <td>'.$o->o_date.'</td>
                <td>'.$o->item_type.'</td>
                <td>'.$o->o_price.'</td>
                <td>'.$o->o_status.'</td>
                <td>'.$o->delivery_date.'</td>
                <td>'.$o->order_type.'</td>
                <td>'.$o->base_pattern.'</td>
                <td>'.$o->base_size.'</td>
                <td>'.$o->c_name.'</td>
                <td>'.$o->p_phone.'</td>
                <td>'.$o->s_phone.'</td>
                <td>'.$o->c_email.'</td>
                <td>'.$o->c_city.'</td>
                <td>'.$o->c_address.'</td>
                <td>'.$o->stance.'</td>
                <td>'.$o->shoulder.'</td>
                <td>'.$o->chest.'</td>
                <td>'.$o->stomach.'</td>
                <td>'.$o->hip.'</td>
                <td>'.$o->neck.'</td>
                <td>'.$o->full_chest.'</td>
                <td>'.$o->shoulder_width.'</td>
                <td>'.$o->right_sleeve.'</td>
                <td>'.$o->left_sleeve.'</td>
                <td>'.$o->bicep.'</td>
                <td>'.$o->wrist.'</td>
                <td>'.$o->waist_stomach.'</td>
                <td>'.$o->hip_m.'</td>
                <td>'.$o->front_jacket_length.'</td>
                <td>'.$o->front_chest_width.'</td>
                <td>'.$o->back_width.'</td>
                <td>'.$o->half_shoulder_width_left.'</td>
                <td>'.$o->half_shoulder_width_right.'</td>
                <td>'.$o->full_back_length.'</td>
                <td>'.$o->half_back_length.'</td>
                <td>'.$o->trouser_waist.'</td>
                <td>'.$o->trouser_outseam.'</td>
                <td>'.$o->trouser_inseam.'</td>
                <td>'.$o->crotch.'</td>
                <td>'.$o->thigh.'</td>
                <td>'.$o->knee.'</td>
                <td>'.$o->right_full_sleeve.'</td>
                <td>'.$o->left_full_sleeve.'</td>
                <td>'.$o->fabric_num.'</td>
                <td>'.$o->lining_num.'</td>
                <td>'.$o->fitting.'</td>
                <td>'.$o->jacket_style.'</td>
                <td>'.$o->front_panel_roundness.'</td>
                <td>'.$o->jacket_length.'</td>
                <td>'.$o->lapel_style.'</td>
                <td>'.$o->lapel_curvature.'</td>
                <td>'.$o->lapel_pick_stitch.'</td>
                <td>'.$o->shoulder_construction.'</td>
                <td>'.$o->vent_style.'</td>
                <td>'.$o->breast_pocket.'</td>
                <td>'.$o->side_pocket.'</td>
                <td>'.$o->ticket_pocket.'</td>
                <td>'.$o->cuff_button.'</td>
                <td>'.$o->functional_cuff.'</td>
                <td>'.$o->trouser_pleat.'</td>
                <td>'.$o->trouser_back_pocket.'</td>
                <td>'.$o->trouser_cuff.'</td>
                <td>'.$o->trouser_loop_tab.'</td>
                <td>'.$o->waist_coat_type.'</td>
                <td>'.$o->waist_coat_pocket_type.'</td>
                <td>'.$o->back.'</td>
                <td>'.$o->buttons.'</td>
                <td>'.$o->lapel_eyelet_color.'</td>
                <td>'.$o->cuff_eyelet_color.'</td>
                <td>'.$o->piping_color.'</td>
                <td>'.$o->melton_undercollar_num.'</td>
                <td>'.$o->shoulder_pads.'</td></tr>';
            }

            $ordersData.='</table>';
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=orders.xls');

        echo $ordersData;
    }

}
