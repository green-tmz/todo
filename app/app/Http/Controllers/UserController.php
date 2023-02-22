<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users', [
            'users' => $users
        ]);
    }

    public function block(Request $request)
    {
        $user = User::find($request['id']);
        $user->block = !$request['status'];
        if ($user->save()) {
            return Redirect::back()->with(['success' => 'Информация сохранена']);
        } else {
            return Redirect::back()->withErrors(['msg' => 'Упс! Что то пошло не так']);
        }
    }

    public function del($id)
    {
        $user = User::find($id);
        if ($user->delete()) {
            return Redirect::back()->with(['success' => 'Пользователь успешно удален']);
        } else {
            return Redirect::back()->withErrors(['msg' => 'Упс! Что то пошло не так']);
        }
    }
}
