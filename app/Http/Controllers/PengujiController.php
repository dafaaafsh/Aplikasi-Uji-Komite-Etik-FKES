<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\protocols;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengujiController extends Controller
{
    public function dashboard(){
        $pengujiId = Auth::id();
        $protocol = protocols::whereIn('kategori_review', ['Expedited','Fullboard'])
            ->latest()
            ->get();

        $reviewProtokolIds = Review::where('user_id', $pengujiId)
            ->pluck('protokol_id')
            ->toArray();

        $review = Review::where('user_id', $pengujiId);

        return view('penguji.dashboard', [
            'title' => 'Dasbor Penguji',
            'protokol' => $protocol,
            'reviewProtokolIds' => $reviewProtokolIds,
            'review' => $review,

        ]);
    }

    public function dataPenelitian(Request $request){
        $query = protocols::with('peneliti')
            ->whereIn('status_telaah', ['Telaah Lanjutan', 'Telaah Akhir', 'Selesai'])->latest();

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
                ->orWhere('nomor_protokol_asli', 'like', '%' . $search . '%')
                ->orWhereHas('peneliti', function ($sub) use ($search) {
                    $sub->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $data = $query->paginate(15)->withQueryString();

        return view('penguji.dataPenelitian', [
            'title' => 'Data Penelitian',
            'data' => $data,
        ]);
    }

    public function getDetailData($id){
        $protocol = protocols::with('peneliti', 'documents')->findOrFail($id);
        $peneliti = $protocol->peneliti;

        $getFile = function ($jenis) use ($protocol) {
            $doc = $protocol->documents->firstWhere('tipe_file', $jenis);
            return $doc ? asset('private/protokol/'.$protocol->nomor_protokol."/". $doc->nama_file) : null;
        };

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

            'surat_permohonan' => $getFile('surat_permohonan'),
            'surat_institusi' => $getFile('surat_institusi'),
            'protokol_etik' => $getFile('protokol_etik'),
            'informed_consent' => $getFile('informed_consent'),
            'proposal_penelitian' => $getFile('proposal_penelitian'),
            'sertifikat_gcp' => $getFile('sertifikat_gcp'),
            'cv' => $getFile('cv'),
        ]);
    }

    public function telaahPenelitian(Request $request){
        $userId = Auth::id();
    
        $query = protocols::with(['peneliti', 'review'])
            ->where('status_telaah', 'Telaah Lanjutan')
            ->whereIn('kategori_review', ['Expedited', 'Fullboard']) 
            ->whereDoesntHave('review', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where(function ($q) {
                $q->whereHas('review', function ($sub) {
                    $sub->select('protokol_id')
                        ->groupBy('protokol_id')
                        ->havingRaw('COUNT(DISTINCT user_id) < 3');
                })
                ->orWhereDoesntHave('review');
            })
            ->latest();
        
        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('nomor_protokol_asli', 'like', '%' . $search . '%')
                    ->orWhereHas('peneliti', function ($sub) use ($search) {
                        $sub->where('name', 'like', '%' . $search . '%');
                    });
            });
        }
    
        $data = $query->paginate(15)->withQueryString();
    
        return view('penguji.telaahPenelitian', [
            'title' => 'Telaah Penelitian',
            'data' => $data,
        ]);
    }

    public function profil(){
        $user = Auth::user();

        return view('penguji.profil',[
            'title' => 'Profil Penguji',
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
}
