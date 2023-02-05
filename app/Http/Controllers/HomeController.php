<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index($page = 1)
    {
        $jmlPeminjaman = null;
        $jmlWishlist = null;
        $jmlNotif = null;
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();
        $pengarang = Pengarang::all();
        $title = 'Semua Koleksi';
        $hal = 'Home';
        if (Auth::check()) {
            $user = Auth::user();
            $jmlPeminjaman = Peminjaman::where(['anggota_id' => $user->id])->count();
            $jmlWishlist = Wishlist::where(['anggota_id' => $user->id])->count();
            $jmlNotif = Notifikasi::where(['users_id' => $user->id, 'status' => 'unread'])->count();
        }
        $limit = 20;
        $ofset = ($page * $limit) - $limit;
        $data = Buku::all()->skip($ofset)->take($limit);
        $allRow = Buku::all()->count();
        $sisa = ($allRow % 20) > 0 ? 1 : 0;
        // $jmlPage = 10; 
        $jmlPage = (int)floor($allRow / 20) + $sisa;
        return view('anggota.home.page', compact('data', 'jmlPeminjaman', 'jmlWishlist', 'jmlNotif', 'page', 'jmlPage', 'kategori', 'penerbit', 'pengarang', 'title', 'hal'));
    }

    public function filter($filter = null, $name = null, $page = 1)
    {
        $jmlPeminjaman = null;
        $jmlWishlist = null;
        $jmlNotif = null;
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();
        $pengarang = Pengarang::all();
        $hal = 'Home';
        if (Auth::check()) {
            $user = Auth::user();
            $jmlPeminjaman = Peminjaman::where(['anggota_id' => $user->id])->count();
            $jmlWishlist = Wishlist::where(['anggota_id' => $user->id])->count();
            $jmlNotif = Notifikasi::where(['users_id' => $user->id, 'status' => 'unread'])->count();
        }
        $limit = 20;
        $ofset = ($page * $limit) - $limit;
        if (!$filter) {
            $data = Buku::all()->skip($ofset)->take($limit);
            $title = 'Semua Koleksi';
        } elseif ($filter == 'kategori') {
            $getKategori = Kategori::all()->where('nm_kategori', $name)->first();
            $data = Buku::all()->where('kategori_id', $getKategori->id)->skip($ofset)->take($limit);
            $title = 'Kategori ' . $name;
        } elseif ($filter == 'penerbit') {
            $getPenerbit = Penerbit::all()->where('nm_penerbit', $name)->first();
            $data = Buku::all()->where('penerbit_id', $getPenerbit->id)->skip($ofset)->take($limit);
            $title = 'Koleksi Penerbit ' . $name;
        } elseif ($filter == 'pengarang') {
            $getPengarang = Pengarang::all()->where('nm_pengarang', $name)->first();
            $data = Buku::all()->where('pengarang_id', $getPengarang->id)->skip($ofset)->take($limit);
            $title = 'Koleksi Pengarang ' . $name;
        }
        $allRow = Buku::all()->count();
        $sisa = ($allRow % 20) > 0 ? 1 : 0;
        // $jmlPage = 10; 
        $jmlPage = (int)floor($allRow / 20) + $sisa;
        return view('anggota.home.page', compact('data', 'jmlPeminjaman', 'jmlWishlist', 'jmlNotif', 'page', 'jmlPage', 'kategori', 'penerbit', 'pengarang', 'title', 'filter', 'name', 'hal'));
    }

    public function about()
    {
        $jmlPeminjaman = null;
        $jmlWishlist = null;
        $jmlNotif = null;
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();
        $pengarang = Pengarang::all();
        $title = 'Tentang Kami';
        $hal = 'Home';
        if (Auth::check()) {
            $user = Auth::user();
            $jmlPeminjaman = Peminjaman::where(['anggota_id' => $user->id])->count();
            $jmlWishlist = Wishlist::where(['anggota_id' => $user->id])->count();
            $jmlNotif = Notifikasi::where(['users_id' => $user->id, 'status' => 'unread'])->count();
        }
        return view('anggota.aboutus', compact('jmlPeminjaman', 'jmlWishlist', 'jmlNotif', 'kategori', 'penerbit', 'pengarang', 'title', 'hal'));
    }
}
