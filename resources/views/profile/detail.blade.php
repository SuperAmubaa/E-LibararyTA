@if($get == 'profile')
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail User "{{ $dataUser->nama }}"</h1>
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-6">
                <img class="img-fluid mx-auto" src="{{ asset('public/storage/' . $dataUser->foto) }}"
                    alt="Cover {{ $dataUser->nama }}">
            </div>
            <div class="col-6">
                <table cellpadding="5" cellspacing="0">
                    <tr>
                        <td>nama</td>
                        <td> : </td>
                        <td>{{ $dataUser->nama }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> : </td>
                        <td>{{ $dataUser->email }}</td>
                    </tr>
                    <tr>
                        <td>username</td>
                        <td> : </td>
                        <td>{{ $dataUser->username }}</td>
                    </tr>
                    <tr>
                        <td>gender</td>
                        <td> : </td>
                        <td>{{ $dataUser->gender}}</td>
                    </tr>
                    <tr>
                        <td>tgl lahir</td>
                        <td> : </td>
                        <td>{{ $dataUser->tgl_lahir}}</td>
                    </tr>
                    <tr>
                        <td>agama</td>
                        <td> : </td>
                        <td>{{ $dataUser->agama }}</td>
                    </tr>
                    <tr>
                        <td>alamat</td>
                        <td> : </td>
                        <td>{{ $dataUser->alamat }}</td>
                    </tr>
                    <tr>
                        <td>telpon</td>
                        <td> : </td>
                        <td>{{ $dataUser->tlp }}</td>
                    </tr>
                    <tr>
                        <td>Role</td>
                        <td> : </td>
                        <td>{{ $dataUser->role }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
    </div>
@elseif ($get == 'delete')
    <div class="modal-header bg-danger">
        <h5 class="modal-title white" id="myModalLabel120">
            <i class="fas fa-exclamation-triangle"></i> Peringatan!
        </h5>
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="modal-body">
        <h5>Apakah Anda yakin untuk menghapus profile {{ $dataUser->nama }}?</h5>
    </div>
    <div class="modal-footer">
        <form method="POST" action="{{ route('DestroyProfile', $dataUser->id) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            <button type="button" class="btn btn-light-secondary btn-sm" data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Cancel</span>
            </button>
        </form>
    </div>
@endif