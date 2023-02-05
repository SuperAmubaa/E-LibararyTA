<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PerpustakaanController extends Controller
{
    public function getAllBuku () 
    {
        $data = Buku::all();

        $response = [
            'message' => 'Menampilkan Seluruh Data Buku',
            'data' => $data,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function getBukuById($id)
    {
        $buku = Buku::find($id);
        if ($buku) {
            $response = [
                'message' => 'Menampilkan Data Buku Dengan Id ' . $id,
                'data' => $buku
            ];
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response = [
                'message' => 'Data Buku Dengan Id ' . $id . 'tidak ditemukan!',
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }
    public function getBukuByKategori($name)
    {
        $buku = Buku::all()->where('nm_kategori', $name);
        if ($buku) {
            $response = [
                'message' => 'Menampilkan Data Buku Dengan Kategori ' . $name,
                'data' => $buku
            ];
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response = [
                'message' => 'Data Buku Dengan Kategori ' . $name . 'tidak ditemukan!',
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }
    public function getBukuByPenerbit($name)
    {
        $buku = Buku::all()->where('nm_penerbit', $name);
        if ($buku) {
            $response = [
                'message' => 'Menampilkan Data Buku Dengan Penerbit ' . $name,
                'data' => $buku
            ];
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response = [
                'message' => 'Data Buku Dengan Penerbit ' . $name . 'tidak ditemukan!',
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }
    public function getBukuByPengarang($name)
    {
        $buku = Buku::all()->where('nm_pengarang', $name);
        if ($buku) {
            $response = [
                'message' => 'Menampilkan Data Buku Dengan Pengarang ' . $name,
                'data' => $buku
            ];
            return response()->json($response, Response::HTTP_OK);
        } else {
            $response = [
                'message' => 'Data Buku Dengan Pengarang ' . $name . 'tidak ditemukan!',
            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
    }
}
