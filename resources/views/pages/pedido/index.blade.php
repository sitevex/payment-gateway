@extends('layouts.zc_app')
@section('title', 'Pago Digital')
@section('content')

<header class="p-3 mb-2 border-bottom">
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
    <div class="container">
        <div class="row justify-content-center gx-4">
            <div class="col-md-4 mb-4 d-flex">
                <div class="card shadow p-3 mb-5 bg-body-tertiary rounded" style="width: 100%;">
                    <a href="ruta_del_archivo.pdf" download="nombre_del_archivo.pdf">
                        <img src="assets/imagenes/PDF_file_icon.svg.png" class="card-img-top"
                            alt="Icono de archivo PDF">
                    </a>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Fecha: </li>
                            <li class="list-group-item">Num. Pedido:</li>
                            <li class="list-group-item">Valor a Pagar</li>
                        </ul>
                    </div>
                    <div class="container text-center">
                        <button id="infoButton" class="btn btn-primary" type="button">Información</button>
                        <button id="pagarButton" class="btn btn-primary" type="button">Pagar</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 d-flex">
                <div class="card shadow p-3 mb-5 bg-body-tertiary rounded" style="width: 100%;">
                    <a href="ruta_del_archivo.pdf" download="nombre_del_archivo.pdf">
                        <img src="assets/imagenes/PDF_file_icon.svg.png" class="card-img-top"
                            alt="Icono de archivo PDF">
                    </a>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Fecha: </li>
                            <li class="list-group-item">Num. Pedido:</li>
                            <li class="list-group-item">Valor a Pagar</li>
                        </ul>
                    </div>
                    <div class="container text-center">
                        <button id="infoButton" class="btn btn-primary" type="button">Información</button>
                        <button id="pagarButton" class="btn btn-primary" type="button">Pagar</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 ">
                <div class="card shadow p-3 mb-5 bg-body-tertiary rounded" style="width: 100%;">
                <!--agregar contenido de la card-->
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detalle</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container text-center">
                    <div class="row ">
                        <div class="col-md-4 ">
                            <a class="navbar-brand" href="#">@include('components.atoms.logo.zc_mayoristas')</a>
                        </div>
                        <div class="col-md-4 offset-md-4 text-center">Fecha</div>
                    </div>
                </div>
                <div class="row justify-content-around">
                    <div class="col-md-6">
                        <p class="fw-bold">Nombres:</p>
                    </div>
                    <div class="col-md-6">
                        <p class="fw-bold">Apellidos:</p>
                    </div>
                    <div class="col-md-12">
                        <p class="fw-bold">Ruc:</p>
                    </div>
                </div>
                <table>
                    <tr>
                        <td class="negrita">Producto</td>
                        <td class="negrita">Cantidad</td>
                        <td class="negrita">Precio</td>
                    </tr>
                    <tr>
                        <td>Producto 1</td>
                        <td>6</td>
                        <td>$7.00</td>
                    </tr>
                    <tr>
                        <td>Producto 2</td>
                        <td>10</td>
                        <td>$11.00</td>
                    </tr>
                    <tr>
                        <td>Producto 3</td>
                        <td>14</td>
                        <td>$15.00</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="table-active negrita">Subtotal</td>
                        <td>$0.00</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="table-active negrita">IVA</td>
                        <td>$0.00</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="table-active negrita">TOTAL</td>
                        <td>$0.00</td>
                    </tr>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Understood</button>-->
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