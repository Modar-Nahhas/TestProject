<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
    public function index($id)
    {
        $users = User::getUserRankBetween($id);
        return self::getJsonResponse('success', $users);
    }
}
