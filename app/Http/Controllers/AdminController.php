<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    function index()
    {
        return view('admin');
    }
    function adminRegister()
    {
        return view('admin_register');
    }
    function LoginAdmin(Request $LoginData)
    {
        $email = $LoginData->email;
        $password = $LoginData->password;
        $userData = DB::table('admin')->where([['email','=',$email],['password','=',md5($password)]])->select('name','email','id')->get();
     foreach($userData as $items)
     {
        $data['name'] = $items->name;
        $data['id'] = $items->id;
        $data['email'] = $items->email;
     }
        if(!empty($data) && $data['id']!='')
        {
            session()->put(['user'=>'logedin','username'=>$data['name'],'userid'=>$data['id']]);
            return view('dashboard',['Users'=>$userData]);
        }
    }
    function CreateAdmin(Request $AdminData)
    {
       $name = $AdminData->name;
       $email = $AdminData->email;
       $password = $AdminData->password;

       $setData = DB::table('admin')->insert(['name'=>$name,'email'=>$email,'password'=>md5($password)]);
       if($setData=='1')
       {
         return AdminController::LoginAdmin($AdminData);
       }
    }
    
    
        
}
