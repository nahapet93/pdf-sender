<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $file = File::first();
        return view('users.index', compact('users', 'file'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required_without:telegram_nickname', 'nullable', 'email', 'unique:users'],
            'telegram_nickname' => ['required_without:email', 'nullable', 'unique:users'],
        ]);

        if ($validator->fails()) {
            $request->session()->flash('error', 'Could not create');
        } else {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'telegram_nickname' => $request->telegram_nickname
            ]);

            $request->session()->flash('success', 'Created successfully');
        }

        return redirect(route('users'));
    }
}
