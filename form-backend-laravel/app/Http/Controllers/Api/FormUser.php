<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FormUser extends Controller
{
    public function index(Request $req)
    {
        if (Storage::disk('local')->exists("users.txt") !== true) {
            Storage::disk('local')->put('users.txt','');
        }

        if(empty($req->name) || 
           empty($req->surname) || 
           empty($req->email) || 
           empty($req->password) || 
           empty($req->repeatPassword))
            return response()->json(['message' => 'No required params'], 400);

        if(preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $req->email) === false)
        {
            Log::channel('user-form')->warning('User can`t register. Because incorrect email ' . $req->email);
            return response()->json(['message' => 'Incorrect email'], 400);
        }

        if($req->password !== $req->repeatPassword)
        {
            Log::channel('user-form')->warning('User can`t register. Because this user doesn`t match password ' . $req->email);
            return response()->json(['message' => 'Passwords doesn`t match'], 400);
        }

        $file = Storage::disk('local')->get('users.txt');
        $lines = explode("\n", $file);

        $existUserEmail = false;
        $file = Storage::disk('local')->get('users.txt');
        $lines = explode("\n", $file);
        foreach ($lines as $line) {
            $content = unserialize($line);
                if($content !== false){
                    if($content['email'] === $req->email)
                    {
                        $existUserEmail = true;
                    }
                }
            
        }
        
        if($existUserEmail)
        {
            Log::channel('user-form')->warning('User can`t register. Because this user already exist ' . $req->email);
            return response()->json(['message' => 'User already exist'], 401);
        }

        $data = [
            "name" => $req->name,
            "surname" => $req->surname,
            "email" => $req->email,
            "password" => $req->password
        ];
            
        Storage::disk('local')->append("users.txt", serialize($data));
        Log::channel('user-form')->info('User was created successfully ' . $req->email);
        return $req;
    }
}
