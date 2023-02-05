<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//tambhan
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'username' => 'required',
            'gender' => 'required',
            'tgl_lahir' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'tlp' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:5000',
        ]);

        $user = User::findOrFail($id);
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'gender' => $request->gender,
            'tgl_lahir' => $request->tgl_lahir,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'tlp' => $request->tlp,
            'updated_at' => now(),
        ];
        if (request()->file('foto')) {
            if ($user->foto != 'img/avatar/default.jpg') Storage::disk('public')->delete($user->foto);
            $data['foto'] = request()->file('foto')->store('img/avatar', 'public');
        }

        if ($request->role != $user->role) {
            if ($user->role == 'anggota' && $request->role == 'pustakawan') {
                if ($user->nip == '' || $user->nip == NULL) {
                    $data['nip'] = $id . rand(1000000000, 9999999999);
                }
            } elseif ($user->role == 'pustakawan' && $request->role == 'anggota') {
                if ($user->no_anggota == '' || $user->no_anggota == NULL) {
                    $uniq = uniqid();
                    $uniq = substr($uniq, strlen($uniq) - 4, strlen($uniq));
                    $data['no_anggota'] = Carbon::now()->format('m-y') . '-' . $uniq;
                }
            }
        }
        $user->update($data);
        return redirect()->back()->with('msg', ['type' => 'success', 'message' => 'Data User Berhasil Diubah!']);
    }



    public function changePassword(Request $req, $id)
    {
        $req->validate([
            'oldpass' => 'required',
            'upass' => 'required',
            'reupass' => 'required',
        ]);
        $newpass = Hash::make($req->upass);
        $oldpass = Hash::make($req->oldpass);
        $user = User::findOrFail($id);

        if (Hash::check($oldpass, $user->password)) {
            return redirect()->back()->with('msg', ['type' => 'danger', 'message' => 'Password Lama Anda Salah!']);
        }
        
        $data = [
            'password' => $newpass
        ];

        $user->update($data);
        return redirect()->back()->with('msg', ['type' => 'success', 'message' => 'Password Anda Berhasil Diubah!']);
    }
}
