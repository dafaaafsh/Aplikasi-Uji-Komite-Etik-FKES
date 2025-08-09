<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\protocols;
use App\Models\keputusan;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KepkController extends Controller{

    public function dashboard(){
        $chartData = [
            'Total Penelitian' => protocols::where('status_penelitian', 'Ditelaah')
                            ->orWhere('status_penelitian', 'Selesai ')
                            ->count(),
            'Telaah Awal' => protocols::where('status_telaah', 'Telaah Awal')->count(),
            'Telaah Lanjutan' => protocols::where('status_telaah', 'Telaah Lanjutan')->count(),
            'Telaah Akhir' => protocols::where('status_telaah', 'Telaah Akhir')->count(),
            'Selesai' => protocols::where('status_telaah', 'Selesai')->count(),
        ];
        return view('kepk.dashboard', [
            'title' => 'Dasbor KEPK',
            'chartData' => $chartData
        ]);
    }

    public function dataPenelitian(Request $request){
        $query = Protocols::with('peneliti')
            ->whereIn('status_penelitian', ['Ditelaah', 'Selesai'])
            ->latest();

        if ($request->filled('status')) {
            if ($request->status === 'TelaahAwal') {
                $query->where('status_telaah', 'Telaah Awal');
            } elseif ($request->status === 'TelaahLanjutan') {
                $query->where('status_telaah', 'Telaah Lanjutan');
            } elseif($request->status === 'TelaahAkhir'){
                $query->where('status_telaah', 'Telaah Akhir');
            } elseif($request->status === 'Selesai'){
                $query->where('status_telaah', 'Selesai');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                ->orWhere('nomor_protokol', 'like', '%' . $search . '%')
                ->orWhereHas('peneliti', function ($sub) use ($search) {
                    $sub->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $data = $query->paginate(15)->withQueryString();

        return view('kepk.dataPenelitian', [
            'title' => 'Data Penelitian',
            'data' => $data,
        ]);
    }

    public function telaahAwal(Request $request){

        $query = Protocols::with('peneliti')
                ->where('status_penelitian', 'Ditelaah')
                ->where('status_telaah', 'Telaah Awal')
                ->latest();

        $query1 = Protocols::with('peneliti')
                ->where('status_penelitian', 'Ditelaah')
                ->where('status_telaah', 'Telaah Lanjutan')
                ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                ->orWhere('nomor_protokol', 'like', '%' . $search . '%')
                ->orWhereHas('peneliti', function ($sub) use ($search) {
                    $sub->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        if ($request->filled('search1')) {
            $search1 = $request->search1;
            $query1->where(function ($q) use ($search1) {
                $q->where('judul', 'like', '%' . $search1 . '%')
                ->orWhere('nomor_protokol', 'like', '%' . $search1 . '%')
                ->orWhereHas('peneliti', function ($sub) use ($search1) {
                    $sub->where('name', 'like', '%' . $search1 . '%');
                });
            });
        }

        $data1 = $query1->paginate(15)->withQueryString();
        $data = $query->paginate(15)->withQueryString();

        return view('/kepk/telaahAwal',[
            'title' => 'Telaah Awal',
            'data' => $data,
            'data1' => $data1

        ]);
    }

    public function telaahAkhir(Request $request){

        $query = Protocols::with('peneliti')
                ->where('status_penelitian', 'Ditelaah')
                ->where('status_telaah', 'Telaah Akhir')
                ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                ->orWhere('nomor_protokol', 'like', '%' . $search . '%')
                ->orWhereHas('peneliti', function ($sub) use ($search) {
                    $sub->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $data = $query->paginate(15)->withQueryString();

        return view('/kepk/telaahAkhir',[
            'title' => 'Telaah Akhir',
            'data' => $data

        ]);
    }

    public function profil(){
        $user = Auth::user();

        return view('/kepk/profil',[
            'title' => 'Profil KEPK',
            'user' => $user
        ]);
    }

    public function updateData(Request $request){
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'institusi' => 'nullable|string|max:255',
            'status' => 'nullable|string',
            'asal' => 'nullable|string',
        ]);

        // Ambil data user
        $user = User::findOrFail($request['id']);

        // Update data user
        $user->name = $validated['nama'];
        $user->nomor_hp = $validated['hp'] ?? null;
        $user->alamat = $validated['alamat'] ?? null;
        $user->institusi = $validated['institusi'] ?? null;
        $user->status_peneliti = $validated['status'] ?? null;
        $user->asal_peneliti = $validated['asal'] ?? null;

        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');

    }

    public function uploadAvatar(Request $request){
        $request->validate([
            'avatar' => 'required'
        ],[
            'avatar' => 'Anda belum memilih foto'
        ]);

        $user = Auth::user();
        $file = $request->file('avatar');
        $ext = $file->extension();

        if (empty($user->avatar_path)) {
            $path = Storage::putFileAs('avatars', $file, "avatar_".$user->id."_".time().".".$ext);
            $pengguna = User::find($user->id);
            $pengguna->avatar_path = $path;
            $pengguna->save();
            return redirect()->back()->with('success', 'Data berhasil ditambah.');
        }else if (!empty($user->avatar_path)) {
            $pengguna = User::find($user->id);
            
            Storage::disk('public')->delete($user->avatar_path);            
            $path = Storage::putFileAs('avatars', $file, "avatar_".$user->id."_".time().".".$ext);

            $pengguna->avatar_path = $path;
            $pengguna->save();
            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Data gagal diperbarui.');
    }

    public function getDetailData($id){
        $protocol = protocols::with('peneliti', 'documents')->findOrFail($id);
        $peneliti = $protocol->peneliti;

        $dokumenList = [
            'surat_permohonan',
            'surat_institusi',
            'protokol_etik',
            'informed_consent',
            'proposal_penelitian',
            'sertifikat_gcp',
            'cv'
        ];

        $detailDokumen = [];
        foreach ($dokumenList as $tipe) {
            $doc = $protocol->documents->firstWhere('tipe_file', $tipe);
            if ($doc) {
                if (!empty($doc->gdrive_link)) {
                    $detailDokumen[$tipe] = [
                        'mode' => 'link',
                        'url' => $doc->gdrive_link
                    ];
                } elseif (!empty($doc->nama_file)) {
                    $detailDokumen[$tipe] = [
                        'mode' => 'file',
                        'url' => asset('private/protokol/'.$protocol->nomor_protokol.'/'.$doc->nama_file)
                    ];
                }
            }
        }

        return response()->json([
            'nomor_protokol'     => $protocol->nomor_protokol_asli,
            'judul'              => $protocol->judul,
            'subjek'             => $protocol->subjek_penelitian,
            'jenis_penelitian'   => $protocol->jenis_penelitian,
            'jenis_pengajuan'    => $protocol->jenis_pengajuan,
            'biaya'              => $protocol->biaya_penelitian,
            'tanggal_pengajuan' => $protocol->tanggal_pengajuan,
            'kategori'          => $protocol->kategori_review,

            'nama'      => $peneliti->name ?? '-',
            'email'     => $peneliti->email ?? '-',
            'asal'      => $peneliti->alamat ?? '-',
            'institusi' => $peneliti->institusi ?? '-',
            'hp'        => $peneliti->nomor_hp ?? '-',
            'status'    => $peneliti->status_peneliti ?? '-',

            'detailDokumen' => $detailDokumen,
        ]);
    }

    public function getDetailReview($id){
    
        $reviews = Review::where('protokol_id', $id)
            ->with('reviewer') 
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($review) {
                return [
                    'nama' => $review->reviewer->name ?? 'Reviewer Tidak Diketahui',
                    'tanggal' => \Carbon\Carbon::parse($review->created_at)->translatedFormat('l, d F Y H:i'),
                    'hasil' => $review->hasil,
                    'catatan' => $review->catatan ?? 'Tidak ada catatan',
                    'link' => $review->lampiran ? asset('private/lampiran/'.$review->protokol->nomor_protokol."/". $review->lampiran) : null,
                ];
            });
    
        return response()->json($reviews);
    }

    public function exempted(Request $request){
        $validated = $request->validate([
            'komentar' => 'nullable|string',
            'lampiran' => 'required|mimes:pdf|max:2048', 
            'protokol_id' => 'required|exists:protocols,id', 
        ]);

        $keputusan = new Keputusan();
        $keputusan->protokol_id = $validated['protokol_id'];
        $keputusan->hasil_akhir = 'Diterima';
        $keputusan->komentar = $validated['komentar'] ?? null;
        $keputusan->jenis_penerimaan = 'Tanpa Revisi';

        $protokol = Protocols::findOrFail($validated['protokol_id']);
        $file = $validated['lampiran'];
        $nomorProtokol = $protokol->nomor_protokol;
        $path = 'lampiran/'.$nomorProtokol;
        $filename = 'lampiran_keputusan_'.time().'.'.$file->getClientOriginalExtension();

        Storage::disk('local')->putFileAs($path, $file , $filename);

        $keputusan->lampiran = $filename;

        $protokol->kategori_review = 'Exempted';
        $protokol->status_telaah = 'Selesai';

        $protokol->save();
        $keputusan->save();

        return redirect()->back()->with('success', 'Keputusan berhasil disimpan.');    
    }

    public function expedited(Request $request){
        $validated = $request->validate([
            'id' => 'required|exists:protocols,id'
        ]);

        $protokol = protocols::findOrFail($validated['id']);
        $protokol->kategori_review = 'Expedited';
        $protokol->status_telaah = 'Telaah Lanjutan';
        $protokol->save();

        return redirect()->back()->with('success', 'Penelitian berhasil dilanjutkan ke penguji (Expedited)');
    }

    public function fullboard(Request $request){
        $validated = $request->validate([
            'id' => 'required|exists:protocols,id'
        ]);

        $protokol = protocols::findOrFail($validated['id']);
        $protokol->kategori_review = 'Fullboard';
        $protokol->status_telaah = 'Telaah Lanjutan';
        $protokol->save();

        return redirect()->back()->with('success', 'Penelitian berhasil dilanjutkan ke penguji (Fullboard)');
    }

    

}
