@extends('layouts.zc_app')
@section('title','Pago Digital')
@section('content')
<!-- Importar el componente Modal -->
@component('components.organisms.modal_mesaje', [
    'modalId' => 'mensajeModal', // ID único para la modal
    'modalDialogClass' => 'modal-dialog-centered modal-dialog-scrollable modal-sm', // Tamaño de la modal
    'modalHeaderClass' => 'justify-content-center',
    'modalTitle' => 'Título de la Modal 1', // Título de la modal
    'showCloseButton' => false, // Mostrar el botón de cierre
    'modalBodyClass' => 'py-0 text-center', // Justificar el texto
    'modalFooter' => '<button type="button" class="btn btn-lg btn-dark-zc fw-bold w-100"
        data-bs-dismiss="modal">Aceptar</button>'
    ])
    <!-- Contenido de la modal -->
    <p>Contenido de la Modal 1 aquí...</p>
@endcomponent

@component('components.organisms.modal_error', [
    'modalId' => 'errorModal', // ID único para la modal
    'modalDialogClass' => 'modal-dialog-centered modal-dialog-scrollable modal-sm', // Tamaño de la modal
    'modalHeaderClass' => 'justify-content-center',
    'modalTitle' => 'Título de la Modal 1', // Título de la modal
    'showCloseButton' => false, // Mostrar el botón de cierre
    'modalBodyClass' => 'py-0 text-center', // Justificar el texto
    'modalFooter' => '<a href="/" class="btn btn-lg btn-dark-zc fw-bold w-100">Aceptar</a>'
    ])
    <!-- Contenido de la modal -->
@endcomponent

@component('components.organisms.modal_detalleOrden', [
    'modalId' => 'detalleOrdenModal',
    'modalDialogClass' => 'modal-dialog-centered modal-dialog-scrollable',
    'modalHeaderClass' => 'flex-column justify-content-between border-0 bg-alabaster-50 px-0',
    'modalTitle' => 'Orden:',
    'showCloseButton' => false,
    'modalBodyClass' => 'p-0 text-center bg-alabaster-50',
    'modalFooter' => '
        <div class="placeholder-glow w-100">
            <span class="placeholder col-12"></span>
        </div>
        <div class="placeholder-glow w-100">
            <span class="placeholder col-12"></span>
        </div>
        <div class="placeholder-glow w-100">
            <span class="placeholder col-12"></span>
        </div>
        <ul class="list-group list-group-flush w-100" id="listOrderSummary">
            <li class="list-group-item d-flex justify-content-between align-items-center fs-xs fw-bold">
                Subtotal <span id="detalleSubtotal"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center fs-xs fw-bold">
                Descuento <span id="detalleDescuento"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center fs-xs fw-bold">
                Impuesto <span id="detalleImpuesto"></span>
            </li>
            <li class="list-group-item list-group-item-primary d-flex justify-content-between align-items-center fs-xs fw-bold">
                Total a pagar <span id="detalleTotalPagar"></span>
            </li>
        </ul>
        <button type="button" class="btn btn-lg btn-dark-zc fw-bold w-100"data-bs-dismiss="modal">Aceptar</button>
    '
    ])
    <!-- Contenido de la modal -->
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-resume" role="tabpanel" aria-labelledby="pills-resume-tab" tabindex="0">
            <div class="d-flex flex-column gap-3 align-items-center justify-content-center px-3">
                <div class="placeholder-glow w-100 h-13p">
                    <span class="placeholder col-12 h-100"></span>
                </div>
                <div class="list-group list-group-flush w-100" id="listItemsOrden">
                </div>
            </div>
        </div>
    </div>
@endcomponent

@component('components.organisms.modal_mesaje', [
    'modalId' => 'metodoPagoModal', // ID único para la modal
    'modalDialogClass' => 'modal-dialog-centered modal-dialog-scrollable modal-sm', // Tamaño de la modal
    'modalHeaderClass' => 'justify-content-center',
    'modalTitle' => 'Shipping Details', // Título de la modal
    'showCloseButton' => false, // Mostrar el botón de cierre
    'modalBodyClass' => 'text-center', // Justificar el texto
    'modalFooter' => ''
    ])
    <!-- Contenido de la modal -->
    <div>
        <p>Choose your preferred shipping</p>
        <div class="row">
            <div class="col-12 col-md-6">
                <a href="" class="btn d-flex gap-3">
                    <img src="https://escueladeempresas.ec/wp-content/uploads/2019/05/Logo_PlacetoPay.png" alt="twbs" width="62" height="62" class="border bg-white rounded-3 flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div class="text-start">
                            <p>text-card</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-6">
                <a href="" class="btn d-flex gap-3">
                    <img src="https://escueladeempresas.ec/wp-content/uploads/2019/05/Logo_PlacetoPay.png" alt="twbs" width="62" height="62" class="border bg-white rounded-3 flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div class="text-start">
                            <p>text-card</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-6">
                <a href="" class="btn d-flex gap-3">
                    <img src="https://escueladeempresas.ec/wp-content/uploads/2019/05/Logo_PlacetoPay.png" alt="twbs" width="62" height="62" class="border bg-white rounded-3 flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div class="text-start">
                            <p>text-card</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endcomponent
<div class="row justify-content-center">
    <div class="col-12">
        <div class="multi-step-form" data-multi-step>
            <section class="box-step hide active" data-step="1">
                <div class="">
                    <div class="row justify-content-center ">
                        <div class="col-sm-10 col-md-8 col-lg-5 col-xxl-4">
                            <a class="d-flex flex-center text-decoration-none mb-4 d-none">
                                <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block">
                                    @include('components.atoms.logo.zc_mayoristas')
                                </div>
                            </a>
                            <div class="card bg-transparent border-0 mb-5">
                                <div class="card-body">
                                    <div class="text-center mb-5">
                                        <h5 class="fw-bold text-body-highlight">¿Listo para ver tus pedidos?</h5>
                                        <p class="fw-medium text-body-tertiary">Por favor, introduce tu número de identificación para acceder a tus pedidos</p>
                                    </div>
                                    <div class="row g-3 needs-validation" novalidate id="rucForm">
                                        <div class="col-md-12">
                                            <label for="numeroIdentificacion" class="form-label fs-sm d-none">Número de idetificación</label>
                                            <input type="number" class="form-control form-control-lg text-center" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="Ingresa tu número de identificación (ruc)" required data-error="Número de identificación incorrecto. Por favor, inténtalo de nuevo." />
                                            <div class="invalid-feedback">
                                                Número de identificación incorrecto. Por favor, inténtalo de nuevo.
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-lg btn-warning-zc fw-bold w-100" type="button" id="btnGetInto" data-next>Continuar</button>
                                        </div>
                                        <div class="col-md-12 d-none">
                                            <div class="fs-xs">
                                                Al continuar, aceptas las <a href="#">Condiciones de uso</a> y el <a href="#">Aviso de privacidad</a> de ZC Mayoristas
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="divider-inner"></div>
                            <div class="text-center">
                                <a class="fs-xs mx-1 text-body-tertiary text-decoration-none" href="#">Política de Privacidad</a>
                                <a class="fs-xs mx-1 text-body-tertiary text-decoration-none" href="#">Política de Envíos</a>
                                <a class="fs-xs mx-1 text-body-tertiary text-decoration-none" href="#">Términos y Condiciones</a>
                            </div>
                            <div class="text-center">
                                <span class="fs-xs mx-4">Copyright © 2001-2024 zcmayoristas.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="box-step hide" data-step="2">
                <div class="text-center mb-5">
                    <h3 class="fw-bold mb-0">Mis Pedidos</h3>
                    <p>Explora Todas tus Órdenes</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-9 col-xl-8 msj-noOrders mb-5">
                    </div>
                </div>
                <div class="row g-3 justify-content-center content-orders">
                </div>
                <div class="text-end mb-3 mt-5">
                    <button type="button" class="btn btn-light-zc btn-light px-md-5 col-12 col-md-auto" data-previous><i class="fa-solid fa-arrow-left"></i> Atrás</button>
                </div>
            </section>
            <section class="box-step hide" data-step="3">
                <div class="text-center mb-5">
                    <h3 class="fw-bold mb-0">Método de Pago</h3>
                    <p>Elige tu forma de Pago</p>
                </div>
                <div class="row justify-content-center gx-lg-0 gap-lg-3">
                    <div class="col-12 col-md-6 col-lg-4">
                        <h6 class="fw-bold mb-3">
                            <span class="badge f-xs bg-white text-dark shadow-sm-zc rounded-circle me-2">1</span>
                            Datos de Facturación
                        </h6>
                        <div class="card border-0 shadow-zc rounded-4">
                            <div class="card-body p-4" id="cardFact">
                                <div class="row gap-3">
                                    <input type="hidden" name="noPedidoFact" id="noPedidoFact" />
                                    <input type="hidden" name="referenceFact" id="referenceFact" />
                                    <input type="hidden" name="unicoFact" id="unicoFact" />
                                    <input type="hidden" name="subTotalPagarFact" id="subTotalPagarFact" />
                                    <input type="hidden" name="impuestoFact" id="impuestoFact" />
                                    <input type="hidden" name="totalPagarFact" id="totalPagarFact" />
                                    <div class="col-12">
                                        <label for="numeroIdentificacionFact" class="form-label fs-xs fw-bold mb-1">Número de identificación <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control border-white" name="numeroIdentificacionFact" id="numeroIdentificacionFact" required disabled readonly />
                                        <div class="invalid-feedback">Campo requerido</div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="nombreFact" class="form-label fs-xs fw-bold mb-1">Razón Social <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control border-white" name="nombreFact" id="nombreFact" required disabled readonly />
                                        <div class="invalid-feedback">Campo requerido</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="emailFact" class="form-label fs-xs fw-bold mb-1">Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="emailFact" id="emailFact" required />
                                        <div class="invalid-feedback">Campo requerido</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="telefonoFact" class="form-label fs-xs fw-bold mb-1">Teléfono <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="telefonoFact" id="telefonoFact" required />
                                        <div class="invalid-feedback">Campo requerido</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="direccionFact" class="form-label fs-xs fw-bold mb-1">Dirección <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="direccionFact" id="direccionFact" value="sin direccion" required />
                                        <div class="invalid-feedback">Campo requerido</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="fs-xs text-dark px-4 pt-2">(*) Campos obligatorios</p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <h6 class="fw-bold mb-3">
                            <span class="badge f-xs bg-white text-dark shadow-sm-zc rounded-circle me-2">2</span>
                            Pago
                        </h6>
                        <div class="card border-0 shadow-zc rounded-4">
                            <div class="card-body">
                                <div class="col-md-12 mb-3">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-blue-zc fs-sm fw-bold">
                                            Total a pagar:
                                            <span class="text-dark-zc" id="totalPagarLabel"></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-12 mb-1">
                                    <div class="datafastPayment-form">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <h6 class="fs-sm fw-bold mb-3">Puedes realiza tus pagos con:</h6>
                                    <div class="row payment-cart-type d-flex justify-content-center mb-3">
                                        <div class="col-5 text-center">
                                            <button type="button" class="btn btn-payphone form-check" id="btnPayphone">
                                                <img src="{{ asset('assets/img/logo/payphone_white.png')}}" class="card-img" width="128" alt="payphone">
                                            </button>
                                        </div>
                                        <div class="col-5 text-center d-none">
                                            <button type="button" class="btn btn-placetopay form-check" id="btnPlaceToPay">
                                                <img src="{{ asset('assets/img/logo/place_to_play.png')}}" class="card-img" width="128" alt="placetopay">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end mb-3 mt-5">
                    <button type="button" class="btn btn-light-zc btn-light px-md-5 col-12 col-md-auto" data-previous><i class="fa-solid fa-arrow-left"></i> Atrás</button>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
@push('script-app')
<script src="{{ asset('assets/js/app.js') }}"></script>

<script type="text/javascript">
    var wpwlOptions = {
        onReady: function() {
            /* var numberOfInstallmentsHtml ='<div class="wpwl-label wpwl-label-custom" style="display:inline-block">Diferidos:</div>' +
            '<div class="wpwl-wrapper wpwl-wrapper-custom" style="display:inline-block">' +
            '<select name="recurring.numberOfInstallments"><option value="0">0</option><option value="3">3</option><option value="6">6</option><option value="9">9</option></select>' +
            '</div>';
            $('form.wpwl-form-card').find('.wpwl-button').before(numberOfInstallmentsHtml); */
            var tipocredito =
            '<div class="wpwl-wrapper wpwl-wrapper-custom w-100" style="display:inline-block">'+ 'Tipo de crédito: <select class="form-select form-select-sm" name="customParameters[SHOPPER_TIPOCREDITO]"><option value="00">Corriente</option>'+
            '<option value="02">Diferido con Interés 3</option>'+
            '<option value="02">Diferido con Interés 6</option>'+
            '<option value="02">Diferido con Interés 12</option>'+
            '<option value="03">Diferido sin Interés 3</option>'+
            '<option value="03">Diferido sin Interés 6</option>'+
            '<option value="03">Diferido sin Interés 12</option>'+
            '</div>'
            $('form.wpwl-form-card').find('.wpwl-button').before(tipocredito);

            var datafast= '<br/><br><img src='+'"https://www.datafast.com.ec/images/verified.png" style='+'"display:block;margin:0 auto; width:100%;">';
            $('form.wpwl-form-card').find('.wpwl-button').before(datafast);

        },
        style: "card",
        locale: "es",
        maskCvv: true,
        brandDetection: true,
        labels: {cvv: "CVV", cardHolder: "Nombre(Igual que en la tarjeta)", insertCode:"Ingrese el codigo"},
        onBeforeSubmitCard: function(e){
            const holder = $('.wpwl-control-cardHolder').val();
            if(holder.trim().length < 2){
                $(".wpwl-control-cardHolder").addClass("wpwl-has-error");
                $(".wpwl-button-CardHolder").after("<div class='wpwl-hint-cardHolderError'>Campo requerido</div>");
                $(".wpwl-button-pay").addClass("wpwl-button-error").attr("disabled", "disabled");
                return false;
            }
            return true;
        }

    }
</script>
@endpush