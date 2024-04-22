<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(Request $request)
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
            if ($request->hasFile('foto')) {
                $nombreImagen = time() . '_' . $request->file('foto')->getClientOriginalName();
                $request->file('foto')->move(public_path('image'), $nombreImagen);
            }
            
            $usuario = User::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'foto' => $nombreImagen,
            ]);
    
            Auth::login($usuario);

            return redirect()->route('home');
    }
}
