<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index(UserRequest $request, $id)
    {
        $data = $request->validated();
        $numberOfUsers = $data['num_users'] ?? 5;
        $users = User::getUserRank($id, $numberOfUsers);
//        dd($request->wantsJson());
        if($request->wantsJson()){
            return self::getJsonResponse('success', $users->reverse());
        }
        return view('welcome',['users'=>$users]);
    }
}
