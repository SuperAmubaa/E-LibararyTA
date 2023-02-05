<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
//tambhan
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Pengembalian;
use App\Models\Rating;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModalContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buku($get, $id)
    {
        $dataKategori = Kategori::all();
        $dataPenerbit = Penerbit::all();
        $dataPengarang = Pengarang::all();
        $dataBuku = Buku::all();
        if (is_numeric($id)) $dataBuku = Buku::findOrFail($id);
        return view('petugas.buku.modal', compact('get', 'dataKategori', 'dataPenerbit', 'dataPengarang', 'dataBuku'));
    }

    public function kategori($get, $id)
    {
        $data = null;
        if(is_numeric($id)) $data = Kategori::findOrFail($id);
        return view('petugas.kategori.modal', compact('get', 'data'));
    }

    public function penerbit($get, $id)
    {
        $data = null;
        if(is_numeric($id)) $data = Penerbit::findOrFail($id);
        return view('petugas.penerbit.modal', compact('get', 'data'));
    }

    public function pengarang($get, $id)
    {
        $data = null;
        if(is_numeric($id)) $data = Pengarang::findOrFail($id);
        return view('petugas.pengarang.modal', compact('get', 'data'));
    }

    public function jenisDenda($get, $id)
    {
        $data = null;
        if(is_numeric($id)) $data = Denda::findOrFail($id);
        return view('petugas.jenisDenda.modal', compact('get', 'data'));
    }

    public function user($get, $id)
    {
        $dataUser = User::all();
        if (is_numeric($id)) $dataUser = User::findOrFail($id);
        return view('admin.user.modal', compact('get', 'dataUser'));
    }

    public function profile($get, $id)
    {
        $dataUser = User::findOrFail($id);
        return view('profile.modal', compact('get', 'dataUser'));
    }

    public function home($get, $id)
    {
        $dataBuku = Buku::findOrFail($id);
        $dataRating = null;
        $dataWishlist = null;
        $dataTransaksiPending = null;
        $dataTransaksiAcc = null;
        if (Auth::check()) {
            $user = Auth::user();
            $dataRating = Rating::where(['anggota_id'=> $user->id, 'buku_id' => $id])->get()->first();
            $dataTransaksiPending = Peminjaman::where(['anggota_id'=> $user->id, 'buku_id' => $id, 'status' => 'pending'])->get()->first();
            $dataTransaksiAcc = Peminjaman::where(['anggota_id'=> $user->id, 'buku_id' => $id, 'status' => 'accepted'])->get()->first();
            $dataWishlist = Wishlist::where(['anggota_id'=> $user->id, 'buku_id' => $id])->get()->first();
        }
        return view('anggota.home.modal', compact('get', 'dataBuku', 'dataRating', 'dataWishlist', 'dataTransaksiPending', 'dataTransaksiAcc'));
    }

    public function wishlist($get, $id)
    {
        $dataBuku = Buku::findOrFail($id);
        $user = Auth::user();
        $dataRating = Rating::where(['anggota_id'=> $user->id, 'buku_id' => $id])->get()->first();
        $dataTransaksiPending = Peminjaman::where(['anggota_id'=> $user->id, 'buku_id' => $id, 'status' => 'pending'])->get()->first();
        $dataTransaksiAcc = Peminjaman::where(['anggota_id'=> $user->id, 'buku_id' => $id, 'status' => 'accepted'])->get()->first();
        $dataWishlist = Wishlist::where(['anggota_id'=> $user->id, 'buku_id' => $id])->get()->first();
        return view('anggota.wishlist.modal', compact('get', 'dataBuku', 'dataRating', 'dataWishlist', 'dataTransaksiPending', 'dataTransaksiAcc'));
    }

    public function transaksi($get, $id)
    {
        $dataTransaksi = Peminjaman::with('buku')->where(['id' => $id])->get()->first();
        return view('anggota.transaksi.modal', compact('get', 'dataTransaksi'));
    }

    public function peminjaman($get, $id)
    {
        $data = Peminjaman::all()->sortByDesc('id');
        if (is_numeric($id)) $data = Peminjaman::all()->where('id', $id)->first();
        return view('petugas.peminjaman.modal', compact('get', 'data'));
    }
    
    public function pengembalian($get, $id)
    {
        $data = Pengembalian::all()->sortByDesc('id');
        $peminjaman = Peminjaman::all()->where('status', 'accepted');
        $denda = Denda::all();
        return view('petugas.pengembalian.modal', compact('get', 'peminjaman', 'denda', 'data'));
    }
}