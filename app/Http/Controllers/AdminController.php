<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\protocols;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(){
        $protocols = protocols::all();

        $tujuhHariLalu = Carbon::now()->subDays(7);
        $protocolsBaru = Protocols::where('created_at', '>=', $tujuhHariLalu)
            ->with('peneliti')
            ->latest()
            ->take(5)
            ->get();

        $data = [
            'protokol' => protocols::count(), 
            'penelitian' => protocols::whereNotNull('tanggal_pengajuan')->count(),
            'verified_pembayaran' => protocols::whereNotNull('verified_pembayaran')->count()
        ];

        return view('admin/dashboard', [
            'title' => 'Dashboard Admin',
            'protocols' => $protocols,
            'data' => $data,
            'baru' => $protocolsBaru,
        ]);
    }

    public function profil(){
        $user = Auth::user();

        return view('admin/profil', [
            'title' => 'Profil Admin',
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

    public function kelolaUser(){

        $role = request('role');

        $pengguna = User::when($role, function ($query, $role) {
            return $query->where('role', $role);
        })->get();

        return view('admin/kelolaUser',[
            'title' => 'Kelola User',
            'pengguna' => $pengguna
        ]);
    }

    public function nomorProtokol(Request $request){
        $query = protocols::latest();

        if ($request->filled('status')) {
            if ($request->status == 'Telah Dibayar') {
                $query->whereNotNull('verified_pembayaran');
            } elseif ($request->status == 'Belum Dibayar') {
                $query->whereNull('verified_pembayaran');
            }
        }
        if ($request->filled('nomor')) {
            if ($request->nomor == 'Ada') {
                $query->whereNotNull('nomor_protokol');
            } elseif ($request->nomor == 'Belum Ada') {
                $query->whereNull('nomor_protokol');
            }
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                ->orWhereHas('peneliti', function ($sub) use ($request) {
                    $sub->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }

        $protokol = $query->paginate(15)->withQueryString();

        return view('admin.nomorProtokol', [
            'title' => 'Nomor Protokol',
            'protokol' => $protokol
        ]);
    }

    public function pengajuanPenelitian(Request $request){

        $query = protocols::latest()
                ->WhereNotNull('tanggal_pengajuan');

        if ($request->filled('status')) {
            if ($request->status == 'Telah Diperiksa') {
                $query->where('status_penelitian', ['Ditelaah','Selesai']);
            } elseif ($request->status == 'Perlu Diperiksa') {
                $query->where('status_penelitian', ['Diperiksa','Dikembalikan']);
            }
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_protokol', 'like', '%' . $request->search . '%') // Tambahan ini
                  ->orWhereHas('peneliti', function ($sub) use ($request) {
                      $sub->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }        

        $needConfirmed = protocols::where('status_penelitian','Diperiksa')
                ->WhereNotNull('tanggal_pengajuan')
                ->latest()
                ->orderBy('created_at', 'desc')
                ->paginate(10);

        $protokol = $query->paginate(15)->withQueryString();

        return view('admin/pengajuanPenelitian',[
            'title' => 'Data Pengajuan',
            'protokol' => $protokol,
            'needConfirmed' => $needConfirmed
        ]);
    }

    public function getBukti($id){
        $protocol = protocols::findOrFail($id);
        $path_pembayaran = null;

        if ($protocol->path_pembayaran) {
            $path_pembayaran = '../private/pembayaran/'.$protocol->path_pembayaran;
        }

        return response()->json([
            'status_pembayaran' => $protocol->status_pembayaran,
            'path_pembayaran' => $path_pembayaran,
            'verified_pembayaran' => $protocol->verified_pembayaran,
        ]);
    }

    public function tolakBukti($id)
    {
        $protocol = Protocols::findOrFail($id);
        $protocol->status_pembayaran = 'Dikembalikan';
        $protocol->save();

        return response()->json(['error' => 'Bukti pembayaran ditolak']);
    }

    public function terimaBukti($id)
    {
        DB::beginTransaction();
        try {
            $protocol = Protocols::findOrFail($id);
            $protocol->status_pembayaran = 'Diterima';
            $protocol->verified_pembayaran = now();
            $protocol->save();

            $protocol->nomor_protokol = "KEPK".$protocol->va;
            $protocol->nomor_protokol_asli = $protocol->va_slash;
            $protocol->save();

            $folder = "protokol/{$protocol->nomor_protokol}";
            if (!Storage::disk('local')->exists($folder)) {
                Storage::disk('local')->makeDirectory($folder);
            }

            DB::commit();

            return response()->json(['success' => 'Bukti pembayaran diterima']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Terjadi kesalahan saat memproses bukti pembayaran'], 500);
        }
    }

    public function getDetail($id){
        $protocol = protocols::with('peneliti')->findOrFail($id);

        return response()->json([
            'id' => $protocol->id,
            'nomor_protokol' => $protocol->nomor_protokol_asli,
            'judul' => $protocol->judul,
            'peneliti' => $protocol->peneliti->name ?? '-',

            'subjek' => $protocol->subjek_penelitian ?? '-',
            'jenis_penelitian' => $protocol->jenis_penelitian ?? '-',
            'jenis_pengajuan' => $protocol->jenis_pengajuan ?? '-',
            'biaya' => $protocol->biaya_penelitian ?? '-', 

            'verified_pembayaran' => $protocol->verified_pembayaran ? 'Telah Dibayar' : 'Belum Dibayar',
            'created_at' => $protocol->created_at->format('d-m-Y H:i'),
            'updated_at' => $protocol->updated_at->format('d-m-Y H:i'),
        ]);
    }

    public function storeNomor(Request $request){
        $validated = $request->validate([
            'id' => 'required|exists:protocols,id',
            'nomor_protokol' => 'required|string|max:100|unique:protocols,nomor_protokol,' . $request->id,
        ]);
    
        $protocol = Protocols::findOrFail($validated['id']);
        $protocol->nomor_protokol = Str::slug($validated['nomor_protokol']);
        $protocol->nomor_protokol_asli = $validated['nomor_protokol'];
        $protocol->save();

        $folder = "protokol/{$protocol->nomor_protokol}";
        if (!Storage::disk('local')->exists($folder)) {
            Storage::disk('local')->makeDirectory($folder);
        }
    
        return redirect()->route('admin.nomorProtokol')->with('success', 'Nomor protokol berhasil disimpan.');
    }

    public function storeUser(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:Admin,Penguji,Kepk,Peneliti',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'email_verified_at' => now(), // optional: langsung verified
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function detailUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.detailUser', [
            'title' => 'Detail Pengguna',
            'user' => $user
        ]);
    }
    
    public function updateUser(Request $request){
        $validated = $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'role' => 'required|in:Admin,Penguji,Kepk,Peneliti',
        ]);

        $user = User::findOrFail($validated['id']);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        // Jika email berubah, reset verifikasi
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Verifikasi KTP
        if ($request->has('verif_ktp')) {
            $user->ktp_verified_at = now();
            $user->ktp_status = 'Terverifikasi';
            $user->ktp_reject_reason = null;
            $user->save();
            return redirect()->route('admin.users.detail', $user->id)->with('success', 'KTP berhasil diverifikasi.');
        }

        // Kembalikan KTP
        if ($request->has('kembalikan_ktp')) {
            $user->ktp_verified_at = null;
            $user->ktp_status = 'Ditolak';
            $user->ktp_reject_reason = $request->input('alasan');
            if ($user->ktp_path) {
                Storage::disk('local')->delete( $user->ktp_path);
                $user->ktp_path = null;
            }
            $user->save();
            return redirect()->route('admin.users.detail', $user->id)->with('success', 'KTP berhasil dikembalikan ke user.');
        }

        $user->save();
        return redirect()->route('admin.users.detail', $user->id)->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroyUser(Request $request){
        $validated = $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($validated['id']);
        $user->delete();

        return redirect()->route('admin.kelolaUser')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function getDetailPengajuan($id){
        $protocol = protocols::with('peneliti', 'documents')->findOrFail($id);
        $peneliti = $protocol->peneliti;

        $getFile = function ($jenis) use ($protocol) {
            $doc = $protocol->documents->firstWhere('tipe_file', $jenis);
            return $doc ? asset('private/protokol/'.$protocol->nomor_protokol."/". $doc->nama_file) : null;
        };

        return response()->json([
            'nomor_protokol'     => $protocol->nomor_protokol,
            'nomor_protokol_asli'     => $protocol->nomor_protokol_asli,
            'judul'              => $protocol->judul,
            'subjek'             => $protocol->subjek_penelitian,
            'jenis_penelitian'   => $protocol->jenis_penelitian,
            'jenis_pengajuan'    => $protocol->jenis_pengajuan,
            'biaya'              => $protocol->biaya_penelitian,
            'tanggal_pengajuan' => $protocol->tanggal_pengajuan,

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

            'hasil_akhir' => optional($protocol->putusan)->hasil_akhir ?? '-',
            'tanggal_keputusan' => optional($protocol->putusan)?->created_at?->format('d-M-Y') ?? '-',
            'penerimaan' => optional($protocol->putusan)->jenis_penerimaan ?? '-',
            'komentar' => optional($protocol->putusan)->komentar ?? '-',
            'lampiran_keputusan' => optional($protocol->putusan)->lampiran 
                ? asset('private/lampiran/'.$protocol->nomor_protokol."/". $protocol->putusan->lampiran)
                : null,
                    ]);
    }

    public function updateTarif(Request $request){
        $validated = $request->validate([
            'id' => 'required|exists:protocols,id',
            'tarif' => 'required|numeric|min:0',
        ], [
            'tarif.required' => 'Tarif belum diisi',
            'tarif.numeric' => 'Tarif harus berupa angka',
            'tarif.min' => 'Tarif tidak boleh kurang dari 0',
        ]);

        $protokol = protocols::findOrFail($validated['id']);
        $protokol->tarif = $validated['tarif'];
        $protokol->save();

        return redirect()->back()->with('success', 'Tarif berhasil diperbarui');
    }

    public function kembalikan(Request $request){
        $validated = $request->validate([
            'id' => 'required|exists:protocols,id',
            'komentar' => 'required'
        ],[
            'komentar' => 'Komentar belum diisi'
        ]);

        $protokol = protocols::findOrFail($validated['id']);
        $protokol->status_penelitian = 'Dikembalikan';
        $protokol->komentar = $validated['komentar'];
        $protokol->save();

        return redirect()->back()->with('success', 'Penelitian berhasil dikembalikan ke peneliti');
    }

    public function Lanjutkan(Request $request){
        $validated = $request->validate([
            'id' => 'required|exists:protocols,id'
        ]);

        $protokol = protocols::findOrFail($validated['id']);
        $protokol->status_penelitian = 'Ditelaah';
        $protokol->status_telaah = 'Telaah Awal';
        $protokol->save();

        return redirect()->back()->with('success', 'Penelitian berhasil dilanjutkan ke Sekretaris/KEPK');
    }

    public function dataPenelitian(Request $request){
        $query = protocols::latest()
                ->where('status_telaah', 'Selesai');

        if ($request->filled('search')) {   
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_protokol', 'like', '%' . $request->search . '%')
                  ->orWhereHas('peneliti', function ($sub) use ($request) {
                      $sub->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $protocols = $query->paginate(15)->withQueryString();

        return view('admin.dataPenelitian', [
            'title' => 'Data Penelitian',
            'protocols' => $protocols
        ]);
    }

    public function suratLulus(){
        $protocols = protocols::whereNotNull('tanggal_pengajuan')
            ->whereNotNull('nomor_protokol')
            ->where('status_telaah', 'Selesai')
            ->latest()
            ->get();

        $protocolWithoutSurat = protocols::whereHas('putusan', function ($query) {
            $query->whereNull('path');
        })->latest()->get();
   
        return view('admin.suratLulus', [
            'title' => 'Buat Surat Lulus',
            'protokols' => $protocols,
            'protocolWithoutSurat' => $protocolWithoutSurat
        ]);
    }    

    public function getDataProtokol($id){
        $protocol = protocols::with('peneliti')->findOrFail($id);
        
        return response()->json([
            'id' => $protocol->id,
            'nomor_protokol' => $protocol->nomor_protokol_asli,
            'judul_penelitian' => $protocol->judul,
            'nama_peneliti' => optional($protocol->peneliti)->name ?? '-',
            'institusi' => optional($protocol->peneliti)->institusi ?? '-',
            'tanggal_persetujuan' => optional($protocol->tanggal_pengajuan)?->format('Y-m-d'),
        ]);
    }

    public function storeSurat(Request $request)
    {
        $data = $request->validate([
            'nomor_surat' => 'required|string',
            'protokol_id' => 'required|exists:protocols,id',
            'nama_peneliti' => 'required|string',
            'institusi' => 'required|string',
            'judul_penelitian' => 'required|string',
            'nomor_protokol' => 'required|string',
            'tanggal_persetujuan' => 'required|date',
        ]);

        $data['tanggal'] = Carbon::parse($data['tanggal_persetujuan'])->translatedFormat('d F Y');

        $pdf = Pdf::loadView('template.suratLulus', $data);

        $safeNomor = str_replace(['/', '\\'], '-', $data['nomor_surat']);

        return $pdf->download('Surat-Layak-Etik-' . $safeNomor . '.pdf');
    }

    public function uploadSuratLulus(Request $request, $id){
        $request->validate([
            'surat_lulus' => 'required|file|mimes:pdf|max:2048',
        ], [
            'surat_lulus.required' => 'Surat lulus belum dipilih.'
        ]);

        $protocol = protocols::findOrFail($id);

        // Simpan file surat lulus
        $file = $request->file('surat_lulus');
        $filename = "surat_lulus_". $protocol->nomor_protokol .'_'. time() . '.pdf';
        Storage::disk('local')->putFileAs('protokol/'.$protocol->nomor_protokol, $file, $filename);


        // Update path surat lulus di database
        $protocol->putusan->path = $filename;
        $protocol->status_penelitian = 'Selesai';
        $protocol->save();

        // Simpan path surat lulus di database
        $protocol->putusan->save();

        return redirect()->back()->with('success', 'Surat lulus berhasil diunggah.');
        
    }

    
}
