@inject('carbon', 'Carbon\Carbon')
@extends('anggota.index')
@section('content')
    <div class="page-heading d-flex" style="justify-content: space-between">
        <h3>Invoice</h3>
    </div>
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <table cellpadding="5" cellspacing="0" id="example1">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Peminjam</td>
                                    <td> &nbsp; &nbsp; : &nbsp; &nbsp; </td>
                                    <td>{{ $data->peminjaman->anggota->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Kode Buku</td>
                                    <td> &nbsp; &nbsp; : &nbsp; &nbsp; </td>
                                    <td>{{ $data->peminjaman->buku->kode }}</td>
                                </tr>
                                <tr>
                                    <td>Judul Buku</td>
                                    <td> &nbsp; &nbsp; : &nbsp; &nbsp; </td>
                                    <td>{{ $data->peminjaman->buku->judul }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pinjam</td>
                                    <td> &nbsp; &nbsp; : &nbsp; &nbsp; </td>
                                    <td>{{ $carbon::parse($data->peminjaman->tgl_pinjam)->translatedFormat('l, d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Kembali</td>
                                    <td> &nbsp; &nbsp; : &nbsp; &nbsp; </td>
                                    <td>{{ $carbon::parse($data->tgl_kembali)->translatedFormat('l, d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Denda</td>
                                    <td> &nbsp; &nbsp; : &nbsp; &nbsp; </td>
                                    <td>{{ $data->denda->jenis }}</td>
                                </tr>
                                <tr>
                                    <td>Tarif</td>
                                    <td> &nbsp; &nbsp; : &nbsp; &nbsp; </td>
                                    <td>@rupiah($data->tarif)</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#example1").DataTable({
            "retrieve": true,
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": false,
            "searching": false,
            "ordering": false,
            "bInfo" : false,
            "buttons": ["csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    </script>
@endsection
