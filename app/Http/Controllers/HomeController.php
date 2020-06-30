<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function changePassword(){
        return view('change_password');
    }

    public function changeRequest(UserPasswordCheck $request){

        $userId = Auth::user()->id;

        $user = DB::select('SELECT * FROM users WHERE id = ?',[$userId]);
        $originalPassword = $user[0]->password;

        $cPass = $request->currentPassword;
        $nPass = $request->newPassword;

        $hNPass = bcrypt($nPass);

        if (Hash::check($cPass, $originalPassword)) {
            $update = DB::update("UPDATE users SET 	password = '".$hNPass."'
            where id = ?", [$userId]);

            $update = DB::update("UPDATE temp_users SET password = '".$hNPass."', org_password = '".$nPass."'
            where id = ?", [$userId]);

            $msg = 'Password Changed';

            $msgs = array(
                'msg'  => $msg,
            );

            return redirect('/home')->with($msgs);
        } else {

            $errorMsg = "Incorrect current password, Password can't be changed";

            $msgs = array(
                'errorMsg'  => $errorMsg,
            );

            return back()->with($msgs);
        }


    }
}
