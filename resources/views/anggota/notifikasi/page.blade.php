@extends('anggota.index')
@inject('carbon', 'Carbon\Carbon')
@section('content')
    <div class="page-heading d-flex" style="justify-content: space-between">
        <h3>Notifikasi</h3>
        @if (count($data) > 0)
        <a href="{{ route('clearNotifikasi') }}" class="text-right">Bersihkan</a>
        @endif
    </div>
    <div class="page-content">
        @foreach ($data as $row)
            <a href="{{ $row->redirect }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <p>{{ $carbon::parse($row->tgl_notif)->diffForHumans() }}</p>
                                <h5>{{ $row->pesan }}</h5>
                            </div>
                            <div class="col-md-2">
                                <span class="badge bg-danger my-auto">{{ $row->status == 'unread' ? 'New' : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
        @if (count($data) == 0)
        <div class="card">
            <div class="card-body">
                <h5 class="text-muted">Belum Ada Notifikasi</h5>
            </div>
        </div>
        @endif
    </div>
@endsection
