<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\protocols;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request, $protokol)
    {
        $validated = $request->validate([
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
            'lampiran' => 'required|file|mimes:pdf,doc,docx,txt|max:5120', // max 5MB
        ]);

        // Cegah review ganda oleh user yang sama
        if (Review::where('user_id', Auth::id())->where('protokol_id', $protokol)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk protokol ini.');
        }

        $protocol = protocols::findOrFail($protokol);
        $filename = "Review_".$protocol->kategori_review."_".Auth::id()."_".time().".".$validated['lampiran']->getClientOriginalExtension();
        $file = $validated['lampiran'];
        $path = 'lampiran/' . $protocol->nomor_protokol;

        Storage::disk('local')->putFileAs($path, $file, $filename);

        $pathLampiran = $filename;

        // Simpan review baru
        Review::create([
            'user_id' => Auth::id(),
            'protokol_id' => $protokol,
            'hasil' => $request->hasil,
            'catatan' => $request->catatan,
            'lampiran' => $pathLampiran, 
        ]);

        $jumlahReviewer = Review::where('protokol_id', $protokol)
            ->distinct('user_id')
            ->count('user_id');

        if ($jumlahReviewer >= 3) {
            protocols::where('id', $protokol)->update([
                'status_telaah' => 'Telaah Akhir',
            ]);
        }

        return redirect()->back()->with('success', 'Review berhasil disimpan.');
    }
}
