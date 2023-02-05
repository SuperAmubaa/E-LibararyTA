@extends('anggota.index')
@section('content')
    <div class="page-heading">
        <h3>{{ $title }}</h3>
    </div>
    <div class="page-content">
        <section class="row justify-content-center">
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img class="card-img-bottom img-fluid" src="{{ url('/public/assets/image/ammar.jpeg') }}"
                            alt="Card image cap" style="height: 20rem; object-fit: cover;">
                        <div class="card-body">
                            <h4 class="card-title">Ammar Mubarok Robbani</h4>
                            <span>STT Terpadu Nurul fikri</span><br>
                            <span>Teknik Informatika</span><br>
                            <span>Developer</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img class="card-img-bottom img-fluid" src="{{ url('/public/assets/image/lilana.jpeg') }}"
                            alt="Card image cap" style="height: 20rem; object-fit: cover;">
                        <div class="card-body">
                            <h4 class="card-title">Akhmad Lylana</h4>
                            <span>STT Terpadu Nurul fikri</span><br>
                            <span>Teknik Informatika</span><br>
                            <span>Developer</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img class="card-img-bottom img-fluid" src="{{ url('/public/assets/image/roni.jpg') }}"
                            alt="Card image cap" style="height: 20rem; object-fit: cover;">
                        <div class="card-body">
                            <h4 class="card-title">Moh. Arif syahroni</h4>
                            <span>Universitas Nurul Jadid</span><br>
                            <span>Teknik Informatika</span><br>
                            <span>Developer</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-content">
                        <img class="card-img-bottom img-fluid" src="{{ url('/public/assets/image/ika.jpeg') }}" alt="Card image cap"
                            style="height: 20rem; object-fit: cover;">
                        <div class="card-body">
                            <h4 class="card-title">Ika Maria Daniati</h4>
                            <span>Universitas Nusantara PGRI</span><br>
                            <span>Teknik Informatika</span><br>
                            <span>UI/UX Designer</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card" id="ammar">
                    <div class="card-content">
                        <img class="card-img-bottom img-fluid" src="{{ url('/public/assets/image/rafli.jpeg') }}" alt="Card image cap"
                            style="height: 20rem; object-fit: cover;">
                        <div class="card-body">
                            <h4 class="card-title">Muhammad Rafli Edka</h4>
                            <span>STT Terpadu Nurul fikri</span><br>
                            <span>Teknik Informatika</span><br>
                            <span>Project Manager & UI/UX Designer</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
@endsection
