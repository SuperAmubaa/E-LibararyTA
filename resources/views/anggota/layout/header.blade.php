<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-LIBRARY | {{ $hal }}</title>

    <link rel="stylesheet" href="https://jambroong.github.io/assets/mazer/css/main/app.css">
    <link rel="stylesheet" href="https://jambroong.github.io/assets/mazer/css/main/app-dark.css">
    <link rel="stylesheet"
        href="https://jambroong.github.io/assets/mazer/extensions/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="shortcut icon" href="https://jambroong.github.io/assets/mazer/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="https://jambroong.github.io/assets/mazer/images/logo/favicon.png" type="image/png">

    <link rel="stylesheet" href="https://jambroong.github.io/assets/mazer/css/shared/iconly.css">
    <link rel="stylesheet" href="https://jambroong.github.io/assets/mazer/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="https://jambroong.github.io/assets/mazer/css/pages/simple-datatables.css">
    <link rel="stylesheet" href="https://jambroong.github.io/assets/mazer/extensions/toastify-js/src/toastify.css">
    <script src="https://jambroong.github.io/assets/mazer/extensions/toastify-js/src/toastify.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/jquery/jquery.min.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/jszip/jszip.min.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="https://jambroong.github.io/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        async function like(e) {
            const id = e.getAttribute('data-id');
            const url = '<?= url('/rating/like') ?>/' + id;
            const getAction = await fetch(url);
            const response = await getAction.json();
            const btnDislike = document.getElementById('dislike' + id);
            e.children[0].className = response.ths;
            btnDislike.children[0].className = response.other;
            likeVal.innerHTML = response.likeVal;
            dislikeVal.innerHTML = response.dislikeVal;
        }
    
        async function dislike(e) {
            const id = e.getAttribute('data-id');
            const url = '<?= url('/rating/dislike') ?>/' + id;
            const getAction = await fetch(url);
            const response = await getAction.json();
            const btnLike = document.getElementById('like' + id);
            e.children[0].className = response.ths;
            btnLike.children[0].className = response.other;
            likeVal.innerHTML = response.likeVal;
            dislikeVal.innerHTML = response.dislikeVal;
        }

        async function wishlist(e) {
            const id = e.getAttribute('data-id');
            const url = '<?= url('/wishlist/add') ?>/' + id;
            const getAction = await fetch(url);
            const response = await getAction.json();
            const jmlWishlist = document.getElementById('menuWishlist');
            const jmlTransaksi = document.getElementById('menuTransaksi');
            e.children[0].className = response.ths;
            jmlWishlist.innerHTML = 'Wishlist (' + response.jmlWishlist + ')' ;
            Toastify({
                text: response.message,
                duration: 5000,
                close: true,
                gravity: "top",
                position: "center",
                style: {
                    background: "#4fbe87"
                },
            }).showToast()
        }

        function togleSetting (e) {
            const f_prof = document.getElementById('f_prof');
            const f_pass = document.getElementById('f_pass');
            if (e.innerHTML ==
                '<i class="bi-shield-lock"></i> Change Password') {
                e.value == 'changeProf';
                e.innerHTML =
                `<i class="bi-person-fill"></i> Change Profile`;
                f_prof.style.display = 'none';
                f_pass.style.display = 'block';
            } else {
                e.value == 'changePw'
                e.innerHTML =
                    `<i class="bi-shield-lock"></i> Change Password`;
                f_prof.style.display = 'block';
                f_pass.style.display = 'none';
            }
        } 
    </script>
    <style>
        .submenu-group-wrapper{
            max-height: 250px;
            overflow-y: scroll;
        }
    </style>
</head>

<body>
    <script src="https://jambroong.github.io/assets/mazer/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div class="header-top">
                    <div class="container">
                        <div class="logo">
                            <a href="{{ route('home') }}"><h4>E-LIBRARY</h4></a>
                        </div>
                        <div class="header-top-right">
                            <div class="theme-toggle d-flex gap-2  align-items-center">
                                <i class="fas fa-sun" style="font-size: 22px;"></i>
                                <div class="form-check form-switch fs-6">
                                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                        style="cursor: pointer">
                                    <label class="form-check-label"></label>
                                </div>
                                <i class="fas fa-moon" style="font-size: 20px;"></i>
                            </div>
                            @if (Auth::check())
                            <a href="{{ route('notifikasi') }}" type="button" class="btn btn-default btn-sm">
                                <i class='bi bi-bell bi-sub fs-4'></i> 
                                @if ($jmlNotif > 0)
                                <span class="badge bg-danger">{{ $jmlNotif }}</span>
                                @endif
                            </a>
                            <div class="dropdown">
                                <a href="#" id="topbarUserDropdown"
                                    class="user-dropdown d-flex align-items-center dropend dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar avatar-md2">
                                        <img src="{{ url('public/storage/' . Auth::user()->foto) }}" alt="Avatar">
                                    </div>
                                    <div class="text">
                                        <h6 class="user-dropdown-name">{{ Auth::user()->nama }}</h6>
                                        <p class="user-dropdown-status text-sm text-muted">
                                            {{ Str::ucfirst(Auth::user()->role) }}
                                        </p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg"
                                    aria-labelledby="topbarUserDropdown">
                                    <li><a class="dropdown-item" id="menuWishlist" data-jml="{{ $jmlWishlist }}" href="{{ route('wishlist') }}">Wishlist ({{ $jmlWishlist }})</a></li>
                                    <li><a class="dropdown-item" id="menuTransaksi" data-jml="{{ $jmlPeminjaman }}" href="{{ route('transaksi') }}">Transaksi ({{ $jmlPeminjaman }})</a></li>
                                    <li>
                                        <button value="profile" data-id="{{ Auth::user()->id }}" class="dropdown-item actionProfile" ><i class="icon-mid bi bi-person me-2"></i> My
                                        Profile</button>
                                    </li>
                                    <li>
                                        <button value="edit" data-id="{{ Auth::user()->id }}" class="dropdown-item actionProfile" ><i class="icon-mid bi bi-gear me-2"></i> 
                                        Settings</button>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                                    </li>
                                </ul>
                            </div>
                            @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login/Register</a> @endif

                            <!-- Burger button responsive -->
                            <a href="#"
        class="burger-btn d-block d-xl-none">
    <i class="bi bi-justify fs-3"></i>
    </a>
    </div>
    </div>
    </div>
    <nav class="main-navbar">
        <div class="container">
            <ul>
                <li class="menu-item">
                    <a href="{{ route('home') }}" class="menu-link">
                        <span><i class="bi bi-house-fill"></i> Home</span>
                    </a>
                </li>

                <li class="menu-item has-sub">
                    <a href="#" class="menu-link">
                        <span><i class="fas fa-tags"></i> Kategori</span>
                    </a>
                    <div class="submenu">
                        <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                @foreach ($kategori as $row)
                                <li class="submenu-item">
                                    <a href="{{ route('homeFilter', ['kategori', $row->nm_kategori]) }}" class="submenu-link">{{ $row->nm_kategori }}</a>
                                </li> @endforeach
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="menu-item
        active has-sub">
    <a href="#" class="menu-link">
        <span><i class="fas fa-building"></i> Penerbit</span>
    </a>
    <div class="submenu">
        <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
        <div class="submenu-group-wrapper">
            <ul class="submenu-group">
                @foreach ($penerbit as $row)
                    <li class="submenu-item">
                        <a href="{{ route('homeFilter', ['penerbit', $row->nm_penerbit]) }}"
                            class="submenu-link">{{ $row->nm_penerbit }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    </li>

    <li class="menu-item has-sub">
        <a href="#" class="menu-link">
            <span><i class="fas fa-pencil-alt"></i> Pengarang</span>
        </a>
        <div class="submenu">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    @foreach ($pengarang as $row)
                        <li class="submenu-item">
                            <a href="{{ route('homeFilter', ['pengarang', $row->nm_pengarang]) }}"
                                class="submenu-link">{{ $row->nm_pengarang }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </li>

    <li class="menu-item">
        <a href="{{ route('about') }}" class="menu-link">
            <span><i class="fas fa-question-circle"></i> Tentang Kami</span>
        </a>
    </li>
    </ul>
    </div>
    </nav>
    </header>
    {{-- <div class="row">
                <div class="col-12">
                    <div class="p-5 mb-4 bg-light rounded-3">
                        <div class="container-fluid py-5 jumbotron">
                        </div>
                    </div>
                </div>
            </div> --}}
    <div class="content-wrapper container">
