@extends('layouts.zc_app')
@section('title', 'Pago Digital')
@section('content')


<header class=" p-3 mb-2 border-bottom">
    <nav id="navbar-example2" class="navbar bg-body-tertiary px-3 mb-3">
        <a class="navbar-brand" href="#">@include('components.atoms.logo.zc_mayoristas')</a>
        <ul class="nav nav-pills">
            <li class="nav-item dropdown">
                <img src="{{ asset('assets/imagenes/icono.png')}}" class="dropdown-toggle icono"
                    data-bs-toggle="dropdown" alt="Dropdown" role="button" aria-expanded="false">
                <ul class="dropdown-menu"
                    style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 34px);">
                    <li><a class="dropdown-item" href="#scrollspyHeading3">Third</a></li>
                    <li><a class="dropdown-item" href="#scrollspyHeading4">Fourth</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#scrollspyHeading5">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<section>
    <div class="container ">
        <div class="row flex min-vh-100 py-5 ">
            <div class="container text-center ">
                <div class="row ">
                    <div class="card shadow p-3 mb-5 bg-body-tertiary rounded" style="width: 18rem;">
                        <img src="{{ asset('assets/imagenes/PDF_file_icon.svg.png')}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Fecha: </li>
                                <li class="list-group-item">Num. Pedido:</li>
                                <li class="list-group-item">Valor a Pagar</li>
                            </ul>
                        </div>
                        <div class="container text-center mx-auto">
                            <button id="infoButton" class="btn btn-primary" type="button">información</button>
                            <button id="pagarButton" class="btn btn-primary" type="button">Pagar</button>
                        </div>
                    </div>
                    <div class="col">
                        Column
                    </div>
                    <div class="col">
                        Column
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal 1-->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3">
                    <div class="col-md-6 border-bottom">
                        <label for="inputEmail4" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputEmail4">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Password</label>
                        <input type="password" class="form-control" id="inputPassword4">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress2" class="form-label">Address 2</label>
                        <input type="text" class="form-control" id="inputAddress2"
                            placeholder="Apartment, studio, or floor">
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">City</label>
                        <input type="text" class="form-control" id="inputCity">
                    </div>
                    <div class="col-md-4">
                        <label for="inputState" class="form-label">State</label>
                        <select id="inputState" class="form-select">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="inputZip" class="form-label">Zip</label>
                        <input type="text" class="form-control" id="inputZip">
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Check me out
                            </label>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal 2 -->

<div class="modal" id="pagarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            
                <h5 class="modal-title">Método de pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container text-center">
                <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
                    <div class="list-group list-group-radio d-grid gap-2 border-0">
                    <img src="{{ asset('assets/imagenes/descarga.png')}}" style="width: 400px; height: auto;">

                        <!-- <p class="chakra-text react-shadow-w0axkt">Método de pago</p> -->
                        <div class="position-relative">
                            <input class="form-check-input position-absolute top-50 end-0 me-3 fs-5" type="radio"
                                name="listGroupRadioGrid" id="listGroupRadioGrid1" value="" checked="">
                            <label class="list-group-item py-3 pe-5" for="listGroupRadioGrid1">
                            <strong class="fw-semibold">
                            <i class="bi bi-credit-card" style="color: black;"></i> Payphone</strong>
                                <span class="d-block small opacity-75">With support text underneath to add more
                                    detail</span>
                            </label>
                        </div>
                        <div class="position-relative">
                            <input class="form-check-input position-absolute top-50 end-0 me-3 fs-5" type="radio"
                                name="listGroupRadioGrid" id="listGroupRadioGrid2" value="">
                            <label class="list-group-item py-3 pe-5" for="listGroupRadioGrid2">
                                <strong class="fw-semibold">
                                <i class="bi bi-credit-card" style="color: black;"></i> Datafast</strong>
                                <span class="d-block small opacity-75">Some other text goes here</span>
                            </label>
                        </div>

                        <div class="position-relative">
                            <input class="form-check-input position-absolute top-50 end-0 me-3 fs-5" type="radio"
                                name="listGroupRadioGrid" id="listGroupRadioGrid3" value="">
                            <label class="list-group-item py-3 pe-5" for="listGroupRadioGrid3">
                                <strong class="fw-semibold">Third radio</strong>
                                <span class="d-block small opacity-75">And we end with another snippet of text</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('script-app')

<script src="{{asset('assets/js/helper.js')}}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('infoButton').addEventListener('click', function() {
        var modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
        modal.show();
    });

    document.getElementById('pagarButton').addEventListener('click', function() {
        var modal = new bootstrap.Modal(document.getElementById('pagarModal'));
        modal.show();
    });
});
</script>
@endpush