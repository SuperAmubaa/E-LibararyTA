@if ($get == 'profile')
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
                        <td>Nama</td>
                        <td> : </td>
                        <td>{{ $dataUser->nama }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> : </td>
                        <td>{{ $dataUser->email }}</td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td> : </td>
                        <td>{{ $dataUser->username }}</td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td> : </td>
                        <td>{{ $dataUser->gender }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td> : </td>
                        <td>{{ $dataUser->tgl_lahir }}</td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td> : </td>
                        <td>{{ $dataUser->agama }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td> : </td>
                        <td>{{ $dataUser->alamat }}</td>
                    </tr>
                    <tr>
                        <td>Telpon</td>
                        <td> : </td>
                        <td>{{ $dataUser->tlp }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
    </div>
@elseif ($get == 'edit')
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Profile</h1>
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="modal-body">
        <h4 class="text-center" id="title"><b>PROFILE</b></h4>
        <div class="row justify-content-center">
            <div class="col-5">
                <img src="{{ asset('public/storage/' . $dataUser->foto) }}" class="img-fluid"
                    alt="Cover {{ $dataUser->nama }}">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 mb-3">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-sm mt-2" onclick="togleSetting(this)"><i
                            class="bi-shield-lock"></i> Change Password</button>
                </div>
            </div>
        </div>
        <form class="needs-validation" id="f_prof" enctype="multipart/form-data" novalidate
            action="{{ route('Profile', $dataUser->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" accept="image/png, image/gif, image/jpeg, image/jpg"
                    id="foto" name="foto">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" required id="nama" name="nama"
                    value="{{ $dataUser->nama }}">
                <div class="invalid-feedback">
                    Kolom Nama Wajib Diisi!
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" required id="email" name="email"
                    value="{{ $dataUser->email }}">
                <div class="invalid-feedback">
                    Kolom email Wajib Diisi!
                </div>
            </div>
            <div class="mb-3">
                <label for="sinopsis">Username</label>
                <input type="text" class="form-control" required id="username" name="username"
                    value="{{ $dataUser->username }}">
                <div class="invalid-feedback">
                    Kolom username Wajib Diisi!
                </div>
            </div>

            <div class="mb-3">
                <label for="stok" class="form-label">Gender</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="L" required
                        {{ $dataUser->gender == 'L' ? 'checked' : '' }} value="L">
                    <label class="form-check-label" for="L">Laki-Laki</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="P" required
                        {{ $dataUser->gender == 'P' ? 'checked' : '' }} value="P">
                    <label class="form-check-label" for="P">Perempuan</label>
                </div>
                <div class="invalid-feedback">
                    Pilih Salah Satu Gender!
                </div>
            </div>
            <div class="mb-3">
                <label for="tgllahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tgl_lahir" value="{{ $dataUser->tgl_lahir }}">
                <div class="invalid-feedback">
                    Kolom Tanggal Lahir Wajib Diisi!
                </div>
            </div>
            <div class="mb-3">
                <label for="agama">Agama</label>
                <select class="form-control choices" name="agama" id="agama" required>
                    <option value="">Pilih Salah Satu Agama</option>
                    <option {{ $dataUser->agama == 'Islam' ? 'selected' : '' }} value="Islam">Islam</option>
                    <option {{ $dataUser->agama == 'Kristen' ? 'selected' : '' }} value="Kristen">Kristen</option>
                    <option {{ $dataUser->agama == 'Hindu' ? 'selected' : '' }} value="Hindu">Hindu</option>
                    <option {{ $dataUser->agama == 'Budha' ? 'selected' : '' }} value="Budha">Budha</option>
                    <option {{ $dataUser->agama == 'Kong Hu Chu' ? 'selected' : '' }} value="Kong Hu Chu">Kong Hu Chu
                    </option>
                </select>
                <span class="invalid-feedback">Harap Pilih Salah Satu Agama!</span>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" rows="4" class="form-control" required>{{ $dataUser->alamat }}</textarea>
                <div class="invalid-feedback">
                    Kolom Alamat Wajib Diisi!
                </div>
            </div>
            <div class="mb-3">
                <label for="tlp" class="form-label">Telpon</label>
                <input type="text" class="form-control" required id="tlp" name="tlp"
                    value="{{ $dataUser->tlp }}">
                <div class="invalid-feedback">
                    Kolom No Telpon Pengarang Wajib Diisi!
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>

        <form class="needs-validation" id="f_pass" novalidate action="{{ route('changePassword', $dataUser->id) }}"
            method="post" style="display: none;">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="oldpass" class="form-label">Password Saat Ini</label>
                <input type="password" pattern=".{8,}" class="form-control" required id="oldpass" name="oldpass">
                <div class="invalid-feedback">
                    Password Minimum 8 Karakter!
                </div>
            </div>
            <div class="mb-3">
                <label for="upass" class="form-label">Password Baru</label>
                <input type="password" pattern=".{8,}" class="form-control" required id="upass" name="upass">
                <div class="invalid-feedback">
                    Password Minimum 8 Karakter!
                </div>
            </div>
            <div class="mb-3">
                <label for="reupass" class="form-label">Ketik Ulang Password Baru</label>
                <input type="password" class="form-control" required id="reupass" name="reupass">
                <div class="invalid-feedback">
                    Password Tidak Cocok!
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
@endif
