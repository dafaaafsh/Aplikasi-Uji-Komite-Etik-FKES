<?php

namespace App\Http\Controllers;

use App\Models\keputusan;
use App\Models\protocols;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeputusanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'protokol_id' => 'required|exists:protocols,id',
            'hasil_akhir' => 'required|in:Diterima,Ditolak',
            'komentar' => 'nullable|string|max:1000',
            'jenis_penerimaan' => 'nullable|in:Tanpa Revisi,Revisi Minor,Revisi Mayor',
            'file_keputusan' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $keputusan = new Keputusan();
        $keputusan->protokol_id = $validated['protokol_id'];
        $keputusan->hasil_akhir = $validated['hasil_akhir'];
        $keputusan->komentar = $validated['komentar'] ?? null;

        $protokol = Protocols::findOrFail($validated['protokol_id']);

        if ($validated['hasil_akhir'] === 'Diterima') {
            $file = $validated['file_keputusan'];
            $nomorProtokol = $protokol->nomor_protokol;
            $path = 'lampiran/'.$nomorProtokol;
            $keputusan->jenis_penerimaan = $validated['jenis_penerimaan'];
            $filename = 'lampiran_keputusan_'.time().'.'.$file->getClientOriginalExtension();
            
            Storage::disk('local')->putFileAs($path, $file , $filename);
            $keputusan->lampiran = $filename;            
        }

        $protokol->status_telaah = 'Selesai';

        $protokol->save();
        $keputusan->save();

        return redirect()->back()->with('success', 'Keputusan berhasil disimpan.');
    }

}
