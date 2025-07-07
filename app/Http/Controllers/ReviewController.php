<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\protocols;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $protokol)
    {
        $request->validate([
            'hasil' => [
                'required',
                Rule::in([
                    'Diterima, Tanpa revisi',
                    'Diterima, Revisi mayor',
                    'Diterima, Revisi minor',
                    'Tidak dapat ditelaah',
                ])
            ],
            'catatan' => 'nullable|string',
        ]);

        // Cegah review ganda oleh user yang sama
        if (Review::where('user_id', Auth::id())->where('protokol_id', $protokol)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk protokol ini.');
        }

        // Simpan review baru
        Review::create([
            'user_id' => Auth::id(),
            'protokol_id' => $protokol,
            'hasil' => $request->hasil,
            'catatan' => $request->catatan,
        ]);

        // Hitung jumlah reviewer unik untuk protokol ini
        $jumlahReviewer = Review::where('protokol_id', $protokol)
            ->distinct('user_id')
            ->count('user_id');

        // Jika sudah 3 reviewer, ubah status_telaah jadi "Telaah Akhir"
        if ($jumlahReviewer >= 3) {
            protocols::where('id', $protokol)->update([
                'status_telaah' => 'Telaah Akhir',
            ]);
        }

        return redirect()->back()->with('success', 'Review berhasil disimpan.');
    }
}
