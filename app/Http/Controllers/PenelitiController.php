<?php

namespace App\Http\Controllers;

use App\Models\document;
use App\Models\User;
use App\Models\protocols;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\error;

class PenelitiController extends Controller
{
    public function dashboard(){
        $chartData = protocols::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->whereNotNull('tanggal_pengajuan')
        ->get();


        $protocols = protocols::whereNotNull('verified_pembayaran')
            ->whereNotNull('tanggal_pengajuan')
            ->latest()
            ->paginate(15);

        return view('peneliti/dashboard', [
            'title' => 'Dasbor Peneliti',
            'protocols' => $protocols,
            'chartData' => $chartData,
        ]);
    }

    public function penelitian(){
        $protocols = protocols::where('user_id', Auth::user()->id)
            ->whereNotNull('verified_pembayaran')
            ->get();

        return view('peneliti/penelitianSaya', [
            'title' => 'Penelitian Saya',
            'protocols' => $protocols
        ]);
    }

    public function nomorProtokol(){
        $protocols = protocols::where('user_id', Auth::user()->id)
            ->get();

        return view('peneliti/nomorProtokol', [
            'title' => 'Nomor Protokol',
            'protocols' => $protocols
        ]);
    }

    public function pengajuan(){
        $protocols = protocols::where('user_id', Auth::user()->id)
            ->whereNotNull('verified_pembayaran')
            ->whereNotNull('nomor_protokol')
            ->get();

        return view('peneliti/pengajuanPenelitian', [
            'title' => 'Pengajuan Penelitian',
            'protocols' => $protocols
        ]);
    }

    public function profil(){
        $user = Auth::user();

        return view('peneliti/profil', [
            'title' => 'Profil Peneliti',
            'user' => $user
        ]);
    }

    public function storeNomor(Request $request){
        DB::beginTransaction();
        try {
            $request->validate([
                'judul' => 'required',
                'subjek' => 'required',
                'jenis_penelitian' => 'required',
                'jenis_pengajuan' => 'required',
                'biaya_penelitian' => 'required',
                'agreement' => 'required',
            ],[
                'judul' => 'Harap Lengkapi Data',
                'subjek' => 'Harap Lengkapi Data',
                'jenis_penelitian' => 'Harap Lengkapi Data',
                'jenis_pengajuan' => 'Harap Lengkapi Data',
                'biaya_penelitian' => 'Harap Lengkapi Data',
                'agreement' => 'Persetujuan belum dicentang'
            ]);

            $now = Carbon::now();
            $count = protocols::whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->count();

            $noUrut = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
            $bulan = $now->format('m');
            $tahun = $now->format('Y');
            $va_slash = "KEPK/$bulan/$tahun/$noUrut";
            $va = $bulan.$tahun.$noUrut;

            // Validasi input
            $dataNomor = [
                'user_id' => Auth::user()->id,  
                'judul' => $request->judul,
                'subjek' => $request->subjek,
                'jenis_penelitian' => $request->jenis_penelitian,
                'jenis_pengajuan' => $request->jenis_pengajuan,
                'biaya_penelitian' => $request->biaya_penelitian,
                'va_slash' => $va_slash,
                'va' => $va,
            ];

            // Simpan data ke database
            protocols::create($dataNomor);
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Permohonan berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Terjadi kesalahan saat mengajukan permohonan'], 500);
        }

        // Simpan ke database
    }

    public function getDetailProtokol($id){
        $protocol = protocols::with(['peneliti'])->findOrFail($id);
        return response()->json([
            'id' => $protocol->id,
            'nomor_protokol' => $protocol->nomor_protokol_asli,
            'judul' => $protocol->judul,
            'pembayaran' => $protocol->verified_pembayaran,
            'status_pembayaran' => $protocol->status_pembayaran,
            'tarif' => $protocol->tarif,
            'nama' => $protocol->peneliti->name,
            'tanggal_pengajuan' => $protocol->created_at->toDateString(),
            'status' => $protocol->status_penelitian,
            'va' => $protocol->va,
        ]);
    }

    public function uploadBukti(Request $request){
        $validated = $request->validate([
            'protocol_id' => 'required',
            'bukti_pembayaran' => 'required',
        ],[
            'bukti_pembayaran' => 'Upload Bukti Pembayaran'
        ]);

        $protokol = protocols::findOrFail($validated['protocol_id']);

        $path = '/Pembayaran/';
        $file = $validated['bukti_pembayaran'];
        $filename = 'Bukti_Pembayaran_'.time().'.'. $validated['bukti_pembayaran']->getClientOriginalExtension();

        $oldPembayaran = $protokol->path_pembayaran;

        if ($oldPembayaran) {
            Storage::disk('local')->delete($path.'/'.$oldPembayaran);
        }

        Storage::disk('local')->putFileAs($path, $file, $filename);
        
        $protokol->path_pembayaran = $filename;
        $protokol->status_pembayaran = 'Diperiksa';
        $protokol->save();
        
        return redirect()->back()->with('success','Bukti Pembayaran berhasil diperbarui');
    
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

    public function getDetailPenelitian($id){
        $protokol = protocols::with(['peneliti', 'documents'])->findOrFail($id);

        $getFile = function ($jenis) use ($protokol) {
            $doc = $protokol->documents->firstWhere('tipe_file', $jenis);
            return $doc ? asset('private/protokol/'.$protokol->nomor_protokol."/". $doc->nama_file) : null;
        };

        return response()->json([
            'id' => $protokol->id,
            'nomor_protokol_asli' => $protokol->nomor_protokol_asli,
            'nomor_protokol' => $protokol->nomor_protokol,
            'judul_penelitian' => $protokol->judul,
            'peneliti_utama' => $protokol->peneliti->name,
            'tanggal_pengajuan' => $protokol->created_at->toDateString(),
            'status' => $protokol->status_penelitian,
            'klasifikasi' => $protokol->kategori_review,
            'komentar' => $protokol->komentar,

            'surat_permohonan' => $getFile('surat_permohonan'),
            'surat_institusi' => $getFile('surat_institusi'),
            'protokol_etik' => $getFile('protokol_etik'),
            'informed_consent' => $getFile('informed_consent'),
            'proposal_penelitian' => $getFile('proposal_penelitian'),
            'sertifikat_gcp' => $getFile('sertifikat_gcp'),
            'cv' => $getFile('cv'),
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
                    'tanggal' => \Carbon\Carbon::parse($review->created_at)->translatedFormat('d F Y'),
                    'hasil' => $review->hasil,
                    'catatan' => $review->catatan ?? 'Tidak ada catatan',
                ];
            });
    
        return response()->json($reviews);
    }

    public function getKeputusan($id)
    {
        $putusan = \App\Models\Keputusan::where('protokol_id', $id)->with('protokol')->first();
        $getFile = null;

        if (!$putusan) {
            return response()->json([]);
        }

        if ($putusan->path) {
            $getFile = asset('private/protokol/'.$putusan->protokol->nomor_protokol.'/'.$putusan->path);
        }

        return response()->json([
            'hasil_akhir' => $putusan->hasil_akhir,
            'catatan' => $putusan->komentar,
            'tanggal' => $putusan->created_at->toDateString(),
            'path' => $getFile
        ]);
    }

    public function storeDocument(Request $request){
        $request->validate([
            'nomor_protokol' => 'required|exists:protocols,nomor_protokol',
            'surat_permohonan' => 'required|mimes:pdf|max:5120',
            'surat_institusi' => 'required|mimes:pdf|max:5120',
            'protokol_etik' => 'required|mimes:pdf|max:5120',
            'informed_consent' => 'required|mimes:pdf|max:5120',
            'proposal_penelitian' => 'required|mimes:pdf|max:5120',
            'cv' => 'required|mimes:pdf|max:5120',
            'sertifikat_gcp' => 'nullable|mimes:pdf|max:5120',
        ],[
            'surat_permohonan' => 'Belum ada surat permohonan', 
            'surat_institusi' => 'Belum ada surat institusi',
            'protokol_etik' => 'Belum ada protokol etik',
            'informed_consent' => 'Belum ada informed consent',
            'proposal_penelitian' => 'Belum ada proposal penelitian',
            'cv' => 'Belum ada cv '
        ]);

        $protocol = protocols::where('nomor_protokol', $request->nomor_protokol)->firstOrFail();
        $protocolId = $protocol->id;
        $nomorProtocol= $protocol->nomor_protokol;

        $fields = [
            'surat_permohonan',
            'surat_institusi',
            'protokol_etik',
            'informed_consent',
            'proposal_penelitian',
            'sertifikat_gcp',
            'cv'
        ];

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
        
                $file = $request->file($field);
                $filename = $field . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = 'protokol/' . $nomorProtocol;
        
                $oldDoc = Document::where('protocol_id', $protocolId)
                                  ->where('tipe_file', $field)
                                  ->first();
        
                if ($oldDoc) {
                    Storage::disk('local')->delete($path . $oldDoc->nama_file);
                    $oldDoc->delete();
                }
        
                Storage::disk('local')->putFileAs($path, $file, $filename);
        
                Document::create([
                    'protocol_id' => $protocolId,
                    'tipe_file' => $field,
                    'nama_file' => $filename,
                ]);
            }
        }
        

        $protocol->update(['tanggal_pengajuan' => now()]);
        $protocol->status_penelitian = 'Diperiksa';
        $protocol->save();

        return back()->with('success', 'Dokumen berhasil diupload dan dicatat di database.');
    }

    public function updateDocument(Request $request){
        $protocol = protocols::where('nomor_protokol', $request->nomor_protokol)->firstOrFail();

        $protocolId = $protocol->id;
        $nomorProtocol= $protocol->nomor_protokol;

        $fields = [
            'surat_permohonan',
            'surat_institusi',
            'protokol_etik',
            'informed_consent',
            'proposal_penelitian',
            'sertifikat_gcp',
            'cv'
        ];

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
        
                $file = $request->file($field);
                $filename = $field . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = 'protokol/' . $nomorProtocol;
        
                $oldDoc = Document::where('protocol_id', $protocolId)
                                  ->where('tipe_file', $field)
                                  ->first();

                if ($oldDoc) {
                    Storage::disk('local')->delete($path.'/'.$oldDoc->nama_file);                    
                    $oldDoc->delete();
                }
        
                Storage::disk('local')->putFileAs($path, $file, $filename);
        
                Document::create([
                    'protocol_id' => $protocolId,
                    'tipe_file' => $field,
                    'nama_file' => $filename,
                ]);
            }
        }
        

        $protocol->update(['tanggal_pengajuan' => now()]);
        $protocol->status_penelitian = 'Diperiksa';
        $protocol->komentar = NULL;
        $protocol->save();

        return back()->with('success', 'Dokumen berhasil diupload dan dicatat di database.');
    }

    
}

?>