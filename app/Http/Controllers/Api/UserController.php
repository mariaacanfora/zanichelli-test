<?php

namespace App\Http\Controllers\Api;

use App\DatabaseJson\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DataStoreRequest;

class UserController extends Controller
{
    public function store(DataStoreRequest $request){

        $user = new User;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        $user->save();       

        return "Success";
    }
}
