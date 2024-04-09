<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZC Mayoristas: @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet"> -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
</head>
<body>
    <div class="body-loader">
        <div class="loader-box">
            <span class="loader"></span>
        </div>
    </div>
    <header class="position-sticky backdrop-blur-sm" id="header">
        <div class="navbar-top bg-body-tertiary">
            <div class="d-flex justify-content-between align-items-center">
                <!-- navbar top left -->
                <div class="d-flex align-items-center"></div>
                <!-- navbar top right -->
                <div class="d-flex gap-3 align-items-center"></div>
            </div>
        </div>
        <nav class="navbar navbar-expand-xl" style="background-color: #112860;">
            <div class="container">
                <a class="navbar-brand text-center d-flex align-items-center">
                    @include('components.atoms.logo.zc_mayoristas_white')
                </a>
                <ul class="nav align-items-center ms-sm-2">
                    <li class="nav-item">
                    </li>
                    <li class="nav-item nav-avatar dropdown text-end">
                        <a class="d-flex align-items-end gap-1 link-body-emphasis text-decoration-none dropdown-toggle dropdown-toggle-avatar cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle d-none" id="user-img-navbar">
                                <div class="d-none d-lg-flex flex-column lh-1">
                                    <span class="text-start text-white fs-sm">Hola</span>
                                    <span class="text-start text-white fs-xs fw-bold" id="user-name-navbar">Nombre del usuario</span>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start text-small d-none">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                    </li>
                </ul>
            </div>
        </nav>
        <nav class="navbar navbar-step navbar-expand-lg bg-transparent py-3">
            <div class="container px-0 px-md-3">
                <div class="d-flex justify-content-center align-items-center w-100">
                    <ul class="navbar-nav flex-row mx-auto" nav-multi-step>
                        <li class="nav-item">
                            <a class="nav-link nav-step cursor-auto active" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Inicio" nav-step="1">
                                <div class="icon">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div class="nav-link-text lh-1">
                                    <small class="fs-xs">Step 1/3</small>
                                    <p class="fs-sm fw-bold mb-0">Inicio</p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-step cursor-auto" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Mis pedidos" nav-step="2">
                                <div class="icon">
                                    <i class="fa-solid fa-gifts"></i>
                                </div>
                                <div class="nav-link-text lh-1">
                                    <small class="fs-xs">Step 2/3</small>
                                    <p class="fs-sm fw-bold mb-0">Mis pedidos</p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-step cursor-auto" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Pago" nav-step="3">
                                <div class="icon">
                                    <i class="fa-solid fa-credit-card"></i>
                                </div>
                                <div class="nav-link-text lh-1">
                                    <small class="fs-xs">Step 3/3</small>
                                    <p class="fs-sm fw-bold mb-0">Pago</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main id="top" class="main">
        <div class="container">
            @yield('content')
        </div>
    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{asset('assets/js/helper.js')}}"></script>
    @stack('script-app')
</body>
</html>