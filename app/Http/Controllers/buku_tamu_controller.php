<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\bukuTamu;
use Illuminate\Support\Facades\DB;
use App\Models\kategoriModel;
use App\Models\katalog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class buku_tamu_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $mobil = kategoriModel::where('kategori', 'Mobil')->get();
        $motor = kategoriModel::where('kategori', 'Motor')->get();
        $katalogs = katalog::All();
        if (auth()->check()) {
            return view('bukuTamu', compact('mobil', 'motor','katalogs'));
        } else {
            return view('login');
        }
    }


    public function dataKatalog()
    {
        return view('Katalog');
    }


    public function kasir()
    {
        // dd(Auth::User());
        return view('kasir');
    }
    

    

    public function dashboard()
    {
        return view('dashboard');
    }

    
    public function data()
    {
        $data=bukuTamu::paginate(5);
        return view('data_buku_tamu',compact('data'));
    }
    
    // public function tampil_data()
    // {
        
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'gambar' => 'required', // Adjust as needed
    ]);

    // Get the authenticated user's ID
    $userId = auth()->id();

    // Store the uploaded image
    $gambarPath = $request->file('gambar')->store('', 'public');

    // Insert data into the database
    DB::table('buku_tamu')->insert([
        'id_user' => $userId,
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'tipe_mobil' => isset($request->tipe_mobil) ? $request->tipe_mobil : null,
        'tipe_motor' => isset($request->tipe_motor) ? $request->tipe_motor : null,
        'no_hp' => $request->no_hp,
        'paket_salon_motor' => isset($request->paket_salon_motor) ? $request->paket_salon_motor : null,
        'paket_salon_mobil' => isset($request->paket_salon_mobil) ? $request->paket_salon_mobil : null,
        'tanggal' => $request->tanggal,
        'katalog' => $request->katalog,
        'gambar' => $gambarPath,
    ]);

    // Redirect with success message
    return redirect()->route('buku_tamu.index')->with('success', 'Data berhasil disimpan!');
}


    public function upload(Request $request)
    {
        // dd($request);
         DB::table('kategori')->insert([
            'nama' => $request->nama,
            'desk' => $request->desk,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
        ]);
        return redirect()->route('buku_tamu.index')->with('success', 'Data berhasil disimpan!');
    }

    public function kategori()
    {
        $bukuTamus = kategoriModel::all();
        return view('upload', compact('bukuTamus'));
    }

    public function katalog()
    {
        $katalogs = katalog::all();
        return view('katalog', compact('katalogs'));
    }
    public function uploadKatalog(Request $request)
    {
        $gambar = $request->file('gambar')->store('', 'public');
        // $buktiTf = $request->file('bukti_tf')->store('', 'public');

        // $username = Auth::user()->name; // Menyimpan username pengguna yang sedang login

         DB::table('katalogs')->insert([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'desk' => $request->desk,
            'gambar_produk' => $gambar

        ]);

        // dd($username);
        return redirect('/katalogs')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function delete($id)
    {
        $data = buku_tamu::find ($id);
        $data->delete();
        return redirect('/transaksi')->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function updateBuktiPembayaran(Request $request)
{
    // Validasi input
    $request->validate([
        'Bukti_Tf' => 'required', // Validasi file gambar
    ]);

    // Ambil ID pengguna yang sedang login
    $userId = Auth::id();
    Log::info('User ID:', ['userId' => $userId]);

    // Ambil data pengguna berdasarkan id_user
    $bukuTamu = bukuTamu::where('id_user', $userId)->first();
    Log::info('bukuTamu:', ['bukuTamu' => $bukuTamu]);

    if ($bukuTamu) {
        // Proses file gambar
        $file = $request->file('Bukti_Tf');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Simpan file gambar di folder 'public/images/bukti_pembayaran'
        $filePath = $file->storeAs('public/images/bukti_pembayaran', $fileName);
        Log::info('File Path:', ['filePath' => $filePath]);

        // Update kolom upload dengan nama file
        $bukuTamu->Bukti_Tf = $fileName;

        // Simpan perubahan menggunakan query builder untuk memastikan where id_user
        $updateResult = bukuTamu::where('id_user', $userId)->update(['Bukti_Tf' => $fileName]);
        Log::info('Update Result:', ['updateResult' => $updateResult]);

        return redirect()->route('antri.customer');
    } else {
        return response()->json(['message' => 'Pengguna tidak ditemukan.'], 404);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        // $bukuTamu = bukuTamu::where('id_user', $id)->first();
        // dd($bukuTamu);
        // $bukuTamu->delete();

        $delete = DB::table('buku_tamu')->where('id_user', $id)->delete();

        return redirect('/transaksi')->with('success', 'Data berhasil dihapus!');
    }
}
