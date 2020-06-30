<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCheck;
use App\TempUser;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showForm(){
        return view('auth.m_register');
    }

    public function reg(UserCheck $request){

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $status = 'Deactive';

        $u =new TempUser;
        $u->name = $name;
        $u->email = $email;
        $u->password = bcrypt($password);
        $u->org_password = $password;
        $u->status = $status;
        $saved = $u->save();

        if($saved){
            return view('regSubmit');
        }
    }
}
