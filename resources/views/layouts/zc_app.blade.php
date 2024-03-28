<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZC Mayoristas: @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="body-loader">
        <div class="loader-box">
            <span class="loader"></span>
        </div>
    </div>
    <header class="fixed-top backdrop-blur-sm shadow-sm" id="header">
        <div class="navbar-top">
            <div class="container border-lg-bottom">    <!-- d-none -->
                <div class="d-flex justify-content-between align-items-center">
                    <!-- navbar top left -->
                    <div class="d-flex align-items-center">
                        <a class="navbar-brand text-center d-flex align-items-center my-3">
                            @include('components.atoms.logo.zc_mayoristas')
                        </a>
                    </div>
                    <!-- navbar top right -->
                    <div class="d-flex gap-3 align-items-center">
                        <div class="icon-top-right">
                            <a href="https://goo.gl/maps/Vb8boD2zWEnneXTZ8" target="_blank"><i class="bi bi-geo-alt-fill"></i></a>
                        </div>
                        <div class="icon-top-right">
                            <a href=""><i class="bi bi-envelope-fill"></i></a>
                        </div>
                        <div class="dropdown text-end">
                            <a class="d-flex align-items-end gap-1 link-body-emphasis text-decoration-none dropdown-toggle dropdown-toggle-avatar cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle d-none" id="user-img-navbar">
                                    <div class="d-none d-lg-flex flex-column lh-1">
                                        <span class="text-start fs-sm">Hola</span>
                                        <span class="text-start fs-xs fw-bold" id="user-name-navbar">Nombre del usuario</span>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start text-small">
                                <li><a class="dropdown-item" href="#">New project...</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main id="top" class="main">
        @yield('content')
    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{asset('assets/js/helper.js')}}"></script>
    @stack('script-app')
</body>
</html>