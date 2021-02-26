<?php

namespace App\Http\Controllers;

use App\Models\Pass;
use Illuminate\Http\Request;

class PassController extends Controller
{
    public function regPass(Request $req)
    {
        $path = $req->file('image')->store('uploads', 'public');
        if($req->input('type') == 'Временный (для посещения)'){
            return view('regpass1', ['req' => $req], ['path' => $path]);
        } else {
            $pass = new Pass();
            $pass->name = $req->input('name');
            $pass->email = $req->input('email');
            $pass->type = $req->input('type');
            $pass->image = $path;
            $pas = md5(rand(-999999999999999999, 999999999999999999));
            $token = md5(rand(-999999999999999999, 999999999999999999)*rand(-999999999999999999, 999999999999999999)*rand(-999999999999999999, 999999999999999999));
            $pass->token = $token;
            $pass->pass = $pas;
            $pass->status = 'Ожидание';
            $pass->save();
            return view('youNewPass', ['token' => $token]);
        }
    }
    public function regPassTimed(Request $req){
        $pass = new Pass();
        $pass->name = $req->input('name');
        $pass->email = $req->input('email');
        $pass->type = $req->input('type');
        $pass->date1 = $req->input('date1');
        $pass->date2 = $req->input('date2');
        $pass->comm = $req->input('comm');
        $pass->image = $req->input('image');
        $pas = md5(rand(-999999999999999999, 999999999999999999));
        $token = md5(rand(-999999999999999999, 999999999999999999)*rand(-999999999999999999, 999999999999999999)*rand(-999999999999999999, 999999999999999999));
        $pass->token = $token;
        $pass->pass = $pas;
        $pass->status = 'Ожидание';
        $pass->save();
        return view('youNewPass', ['token' => $token]);
    }
    public function getPass(Request $req){
        $pass = new Pass();
        $pass = $pass->where('token', '=', $req->input('token'))->where('status', '=', 'Одобрено')->get();
        
        return view('youPass', ['pass' => $pass]);
    }
}
