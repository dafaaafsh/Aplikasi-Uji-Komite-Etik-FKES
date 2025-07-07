<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SesiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ],[
            'email.required' => 'Email tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        $infoLogin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($infoLogin)){
            $role = auth::user()->role;
            if ($role === 'Peneliti') {
                return redirect('/peneliti/dashboard');
            }elseif ($role === 'Admin') {
                return redirect('/admin/dashboard');
            }elseif ($role === 'Kepk'){
                return redirect ('/kepk/dashboard');
            }elseif ($role === 'Penguji'){
                return redirect('/penguji/dashboard');
            }
        }else{
            return redirect('/login')->withErrors('Email dan Password tidak sesuai')->withInput();
        }

    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ],[
            'name' => 'Nama Lengkap belum diisi',
            'email' => 'Email belum diisi',
            'password' => 'Password belum diisi',
            'password_confirmation' => 'konfirmasi Password belum diisi'
        ]);

        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if ($user) {
            return redirect()->back()->with('error', 'Email sudah terdaftar.');
        }


        if ($request->password === $request->password_confirmation) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'Peneliti';
            $user->save();

            Auth::login($user);

            event(new Registered($user));
            return redirect()->to('/peneliti/dashboard')->with('Akun anda telah terdaftar, Silahkan cek email untuk verifikasi akun.');
        }else{
            return redirect()->back()->with(['error' => 'Password tidak cocok']);
        }
    
    }
        

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
