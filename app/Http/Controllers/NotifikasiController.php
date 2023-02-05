<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = Notifikasi::all()->where('users_id', $user->id)->sortByDesc('tgl_notif');
        $jmlPeminjaman = Peminjaman::where(['anggota_id' => $user->id])->count();
        $jmlWishlist = Wishlist::where(['anggota_id' => $user->id])->count();
        $jmlNotif = Notifikasi::where(['users_id' => $user->id, 'status' => 'unread'])->count();
        $kategori = Kategori::all();
        $penerbit = Penerbit::all();
        $pengarang = Pengarang::all();
        $hal = 'Notifikasi';
        foreach ($data as $row) {
            DB::table('notifikasi')->where('id', $row->id)->update(['status' => 'read']);
        }
        $jmlNotif = Notifikasi::where(['users_id' => $user->id, 'status' => 'unread'])->count();
        return view('anggota.notifikasi.page', compact('data', 'jmlPeminjaman', 'jmlWishlist', 'jmlNotif', 'kategori', 'penerbit', 'pengarang', 'hal'));
    }

    public function clear()
    {
        $user = Auth::user();
        Notifikasi::where('users_id', $user->id)->delete();
        return redirect()->route('notifikasi')->with('msg', ['type' => 'success', 'message' => 'Notifikasi Berhasil Dibersihkan!']);

    }
}
