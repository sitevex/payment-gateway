@extends('layouts.zc_app')
@section('title','Pago Digital')
@section('content')
    {{-- @if(isset($errorMessage)) --}}
        <section class="bg-white">
            <div class="container table-responsive">
                <div class="row mb-3">
                    <div class="col-12">
                        <h2 class="fw-bold text-blue-dark text-center"> {{-- $errorMessage --}}</h2>
                    </div>
                </div>
                <div class="row">

                </div>
            </div>
        </section>
    {{-- @else --}}
        {{-- @if(isset($pasarelaPago)) --}}
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-blue">
                                <th scope="col">Cod. Principal</th>
                                <th scope="col">Cod. Auxiliar</th>
                                <th scope="col">Cant.</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Precio unitario</th>
                                <th scope="col">Precio total</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">

                            <tr class="border border-1">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                </div>
            </div>

            <div class="row mb-2 align-items-center">
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <img src="" alt="">
                </div>
                <div class="col-sm-12 col-md-6 offset-md-2 col-lg-7 offset-lg-2 text-start">
                    <p class="mb-1"><span class="fw-bold"></span></p>
                    <p class="mb-1"><small>RUC: <span class="fw-bold"></span></small></p>
                    <p class="mb-1"><small>Dirección matriz: <span class="fw-bold"></span></small></p>
                    <p class="mb-1"><small>Contribuyente especial Nro.: <span class="fw-bold"></span></small></p>
                    <p class="mb-1"><small>Obligado a llevar contabilidad: <span class="fw-bold"></span></small></p>
                </div>
            </div>
            <div class="row mt-2 mb-3">
                <div class="col-12">
                    <hr class="border border-3 shadow">
                </div>
            </div>
            <div class="row mb-2 align-items-center">
                <div class="col-sm-12 col-md-6">
                    <p class="mb-1">Comprobante Pago: <span class="fw-bold"></span></p>
                    <p class="mb-1">Cliente: <span class="fw-bold">{{-- $pasarelaPago->optionalParameter4 --}}</span></p>
                    <p class="mb-1">Convenio: <span class="fw-bold"></span></p>
                </div>
                <div class="col-sm-12 col-md-6 text-start text-md-end">
                    <p class="mb-1">Fecha de Emisión: <span class="fw-bold"></span></p>
                    <p class="mb-1">Cédula/RUC: <span class="fw-bold"></span></p>
                </div>
            </div>
            <div class="row mt-2 mb-3">
                <div class="col-12">
                    <hr class="border border-3 shadow">
                </div>
            </div>

            <table class="table table-bordered" cellspacing="0" cellpadding="8">
                <tbody>
                    <tr class="border-top-0 bg-blue">
                        <td class="cel" width="53%" colspan="2">
                            <span class="cubre">Cubre empresa: </span>
                        </td>
                        <td class="text-end" width="16%">Base 12</td>
                        <td class="text-end" width="13%"></td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="5"></td>
                        <td class="text-end" width="15%">Base 12</td>
                        <td class="text-end"></td>
                    </tr>
                    <tr>
                        <td class="text-end" width="15%">Base 0</td>
                        <td class="text-end"></td>
                    </tr>
                    <tr>
                        <td class="text-end" width="15%">Descuento</td>
                        <td class="text-end"></td>
                    </tr>
                    <tr>
                        <td class="text-end" width="15%">I.V.A</td>
                        <td class="text-end"></td>
                    </tr>
                    <tr>
                        <td class="text-end" width="15%">Valor total</td>
                        <td class="text-end"></td>
                    </tr>
                </tbody>
            </table>

            <section class="bg-white">
                <div class="container table-responsive">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h2 class="fw-bold text-blue-dark text-center">Transacción aprobada exitosamente.</h2>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                </div>
            </section>
        {{-- @else --}}
            <p>No hay datos de pasarela de pago disponibles.</p>
        {{-- @endif --}}
    {{-- @endif --}}
@endsection