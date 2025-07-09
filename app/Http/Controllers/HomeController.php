<?php

namespace App\Http\Controllers;

use App\Models\protocols;

class HomeController extends Controller
{
    public function index(){
        $data = protocols::whereNotNull('verified_pembayaran')
            ->whereNotNull('tanggal_pengajuan')
            ->where('status_penelitian', 'Selesai')
            ->whereHas('putusan', function ($query) {
                $query->where('hasil_akhir', 'Diterima');
            })
            ->latest()
            ->get();

        return view('welcome', compact('data'));
    }

    public function login(){

        return view('login', ['title' => 'Masuk Akun']);
    }

    public function signin(){

        return view('signin');
    }

    public function tentang()
    {
        return view('/tentangKami', [
            'title' => 'Tentang Kami',
        ]);
    }

    public function template()
    {
        return view('/template',[
            'title' => 'Template Peneliti'
        ]);
    }

}
?>