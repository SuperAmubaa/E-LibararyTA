@inject('carbon', 'Carbon\Carbon')
@if ($get == 'acc')
<div class="modal-header bg-success">
    <h5 class="modal-title white" id="myModalLabel120">
        <i class="fas fa-question-circle"></i> Peringatan!
    </h5>
    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>
</div>
<div class="modal-body">
    <h5>Apakah Anda yakin untuk menyetujui permintaan <br> 
        peminjaman buku {{ $data->buku->judul }} oleh {{ $data->anggota->nama }}?</h5>
</div>
<div class="modal-footer">
    <form method="POST" action="{{ route('petugasAccPeminjaman', $data->id) }}" class="d-inline">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
        <button type="button" class="btn btn-light-secondary btn-sm" data-bs-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Cancel</span>
        </button>
    </form>
</div>

@elseif ($get == 'reject')
<div class="modal-header bg-danger">
    <h5 class="modal-title white" id="myModalLabel120">
        <i class="fas fa-question-circle"></i> Peringatan!
    </h5>
    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>
</div>
<div class="modal-body">
    <h5>Apakah Anda yakin untuk menolak permintaan <br> 
        peminjaman buku {{ $data->buku->judul }} oleh {{ $data->anggota->nama }}?</h5>
</div>
<div class="modal-footer">
    <form method="POST" action="{{ route('petugasRejectPeminjaman', $data->id) }}" class="d-inline">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
        <button type="button" class="btn btn-light-secondary btn-sm" data-bs-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Cancel</span>
        </button>
    </form>
</div>

@elseif ($get == 'export')
<div class="modal-header">
    <h1 class="modal-title fs-5" id="exampleModalLabel">Export Data Peminjaman</h1>
    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>
</div>
<div class="modal-body">
    <table class="table table-striped table-bordered table-hover" id="example1">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Peminjam</th>
                <th class="text-center">Judul Buku</th>
                <th class="text-center">Tanggal Pinjam</th>
                <th class="text-center">Status</th>

            </tr>
        </thead>
        <tbody class="text-center">
            @php $no= 1; @endphp
            @foreach ($data as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->anggota->nama }}</td>
                    <td>{{ $row->buku->judul }}</td>
                    <td>{{ $carbon::parse($row->tgl_pinjam)->translatedFormat('l, d F Y') }}</td>
                    <td>{{ $row->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endif