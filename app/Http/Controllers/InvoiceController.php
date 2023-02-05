<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Pengembalian;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index($id)
    {
        $user = Auth::user();
        $jmlPeminjaman = Peminjaman::where(['anggota_id' => $user->id])->count();
        $jmlWishlist = Wishlist::where(['anggota_id' => $user->id])->count();
        $jmlNotif = Notifikasi::where(['users_id' => $user->id, 'status' => 'unread'])->count();
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();
        $pengarang = Pengarang::all();
        $hal = 'Invoice';
        $data = Pengembalian::all()->where('peminjaman_id', $id)->first();
        return view('anggota.invoice.page', compact('data', 'jmlPeminjaman', 'jmlWishlist', 'jmlNotif', 'kategori', 'penerbit', 'pengarang', 'hal'));
    }
}
