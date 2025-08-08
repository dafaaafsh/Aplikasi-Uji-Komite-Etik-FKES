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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'nomor_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'institusi' => 'nullable|string|max:100',
            'status_peneliti' => 'nullable|in:Mahasiswa (S1),Mahasiswa (S2),Mahasiswa (S3),Dosen,Peneliti Umum',
            'asal_peneliti' => 'nullable|in:UNUJA,Eksternal',
            'ktp' => 'nullable|image|max:2048'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'Peneliti';

        $user->nomor_hp = $request->nohp;
        $user->alamat = $request->alamat;
        $user->institusi = $request->institusi;
        $user->status_peneliti = $request->status;
        $user->asal_peneliti = $request->asal;
        $user->ktp_status = 'Belum diverifikasi';

        if ($request->hasFile('ktp')) {
            $user->ktp_path = $request->file('ktp')->storeAs('ktp', 'ktp_user_'.time().'.jpg', 'local');
        }

        $user->save();
        Auth::login($user);
        event(new Registered($user));
        return redirect('/peneliti/dashboard')->with('success', 'Registrasi berhasil, selamat datang!');    
    }
        

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
