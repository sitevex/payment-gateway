@extends('layouts.zc_app')
@section('title','Pago Digital')
@section('content')
<!-- Importar el componente Modal -->
@component('components.organisms.modal_mesaje', [
    'modalId' => 'mensajeModal', // ID único para la modal
    'modalSize' => 'modal-sm', // Tamaño de la modal
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

@component('components.organisms.modal_mesaje', [
    'modalId' => 'detalleOrdenModal',
    'modalSize' => 'modal-sm',
    'modalHeaderClass' => 'justify-content-center d-none',
    'modalTitle' => 'Título de la Modal 2',
    'showCloseButton' => false,
    'modalBodyClass' => 'p-0 text-center bg-alabaster-50',
    'modalFooter' => '<button type="button" class="btn btn-lg btn-dark-zc fw-bold w-100"
        data-bs-dismiss="modal">Aceptar</button>'
    ])
    <!-- Contenido de la modal -->
    <div class="d-flex p-3">
        <div>
            <h6 class="text-start mb-0">Orden: <b class="text-end">ORD12345</b></h6>
        </div>
    </div>
    <ul class="nav nav-pills nav-detalleOrden gap-3 px-3 bg-white" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link px-0 py-1 rounded-0 active" id="pills-resume-tab" data-bs-toggle="pill" data-bs-target="#pills-resume" type="button" role="tab" aria-controls="pills-resume" aria-selected="true">Resumen</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-resume" role="tabpanel" aria-labelledby="pills-resume-tab" tabindex="0">
            <div class="d-flex flex-column flex-md-row gap-3 align-items-center justify-content-center px-3">
                <div class="list-group">
                    <a class="list-group-item list-group-item-action d-flex gap-3 px-0 border-0 bg-transparent" aria-current="true">
                        <img src="https://zcmayoristas.com/zcwebstore/wp-content/uploads/2024/03/DHI-HY-SAV849HAN-E-1-300x300.jpg" alt="twbs" width="62" height="62" class="border bg-white rounded-3 flex-shrink-0">
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div class="my-auto text-start">
                                <h6 class="fs-sm fw-medium line-clamp-2 mb-0">Dahua Cámara Ip Dhi-hy-sav849han-e Detector De Humo 5MP</h6>
                                <p class="fs-xxs line-clamp-1 mb-0 opacity-75">DAHUA</p>
                            </div>
                            <div class="d-flex flex-column justify-content-center text-end">
                                <small class="fs-sm fw-medium text-nowrap">$339.00</small>
                                <small class="fs-xs text-nowrap">Cant: 15</small>
                            </div>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action d-flex gap-3 px-0 border-0 bg-transparent" aria-current="true">
                        <img src="https://zcmayoristas.com/zcwebstore/wp-content/uploads/2023/11/202211418543988-300x300.png" alt="twbs" width="62" height="62" class="border bg-white rounded-3 flex-shrink-0">
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div class="my-auto text-start">
                                <h6 class="fs-sm fw-medium line-clamp-2 mb-0">Ruijie Reyee Router Gateway Cloud 4 Ptos Poe + 1giga</h6>
                                <p class="fs-xxs line-clamp-1 mb-0 opacity-75">RUIJIE</p>
                            </div>
                            <div class="d-flex flex-column justify-content-center text-end">
                                <small class="fs-sm fw-medium text-nowrap">$250.80</small>
                                <small class="fs-xs text-nowrap">Cant: 17</small>
                            </div>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action d-flex gap-3 px-0 border-0 bg-transparent" aria-current="true">
                        <img src="https://zcmayoristas.com/zcwebstore/wp-content/uploads/2023/06/ZKT0111-300x300.jpg" alt="twbs" width="62" height="62" class="border bg-white rounded-3 flex-shrink-0">
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div class="my-auto text-start">
                                <h6 class="fs-sm fw-medium line-clamp-2 mb-0">Zkteco Tl700w Cerradura Smart Lector Huellas, Taejetas y Clave, Seguro</h6>
                                <p class="fs-xxs line-clamp-1 mb-0 opacity-75">CONTROLES DE ACCESSO</p>
                            </div>
                            <div class="d-flex flex-column justify-content-center text-end">
                                <small class="fs-sm fw-medium text-nowrap">$1592.00</small>
                                <small class="fs-xs text-nowrap">Cant: 8</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center fs-xs fw-bold">
                    Subtotal
                    <span>$2181.80</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center fs-xs fw-bold">
                    Descuento
                    <span>-</span>
                </li>
                <li class="list-group-item list-group-item-primary d-flex justify-content-between align-items-center fs-xs fw-bold">
                    Total
                    <span>$2181.80</span>
                </li>
            </ul>
        </div>
    </div>
@endcomponent

@component('components.organisms.modal_mesaje', [
    'modalId' => 'metodoPagoModal', // ID único para la modal
    'modalSize' => 'modal-sm', // Tamaño de la modal
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
<div class="multi-step-form" data-multi-step>
    <section class="box-step hide active" data-step="1">
        <div class="container">
            <div class="row justify-content-center flex-center min-vh-100 py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xxl-4">
                    <a href="#" class="d-flex flex-center text-decoration-none mb-4">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block">
                            @include('components.atoms.logo.zc_mayoristas')
                        </div>
                    </a>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <h5 class="fw-bold text-body-highlight">¿Listo para ver tus pedidos?</h5>
                                <p class="text-body-tertiary">Por favor, introduce tu número de identificación para acceder
                                    a tus pedidos</p>
                            </div>
                            <form class="row g-3 needs-validation" novalidate id="rucForm">
                                <div class="col-md-12">
                                    <label for="numeroIdentificacion" class="form-label fs-sm d-none">Número de idetificación</label>
                                    <input type="number" class="form-control form-control-lg" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="Ingresa tu número de identificación (ruc)" required data-error="Número de identificación incorrecto. Por favor, inténtalo de nuevo." />
                                    <div class="invalid-feedback">
                                        Número de identificación incorrecto. Por favor, inténtalo de nuevo.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-lg btn-warning-zc fw-bold w-100" type="button" id="btnGetInto" data-next>Continuar</button>
                                </div>
                                <div class="col-md-12 d-none">
                                    <div class="fs-xs">
                                        Al continuar, aceptas las <a href="#">Condiciones de uso</a> y el <a href="#">Aviso
                                            de privacidad</a> de ZC Mayoristas
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="divider-inner"></div>
                    <div class="text-center">
                        <a class="fs-xs mx-1" href="#">Política de Privacidad</a>
                        <a class="fs-xs mx-1" href="#">Política de Envíos</a>
                        <a class="fs-xs mx-1" href="#">Términos y Condiciones</a>
                    </div>
                    <div class="text-center">
                        <span class="fs-xs mx-4">Copyright © 2001-2024 zcmayoristas.com</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="box-step hide" data-step="2">
        <div class="container">
            <div class="row justify-content-center flex-center min-vh-100">
                <div class="col-12 d-none">
                    <div class="content-profile">
                        <div class="row">
                            <!-- card-profile col-xxl-3-->
                            <div class="col-12 col-md-8 col-lg-5 col-xl-3 mb-3">
                                <div class="card card-profile p-2 shadow">
                                    <div class="row g-0">
                                        <div class="col-2 col-md-2 d-flex align-items-center">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-profiles/avatar-1.webp"
                                                alt="Generic placeholder image" class="img-fluid" width="64px"
                                                style="border-radius: 10px;">
                                        </div>
                
                                        <div class="col col-md-10 d-flex align-items-center">
                                            <div class="card-body p-2">
                                                <p class="mb-0 fs-11 fw-bold">Danny Clarke McLoan Jeffery</p>
                                                <p class="mb-0 fs-11" style="color: #2b2a2a;">clark.Jeffery@zmail.com</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6 col-lg-4 col-xxl-3">
                    <div class="card border-0 shadow-sm-zc">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="badge text-bg-sail">Número de orden</span>
                                    <p class="fs-sm text-start mb-0">ORD12345</p>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="badge text-bg-sail">Fecha y Hora</span>
                                    <p class="fs-xxs text-end mb-0">AGO 09, 2024</p>
                                    <p class="fs-xs fw-bold text-end mb-0">10:20 AM</p>
                                </div>
                            </div>
                            <p class="fw-bold mb-0">ZC - Guayaquil</p>
                            <p class="fs-sm mb-0">Cliente Ejemplo S.A.</p>
                            <p class="fs-sm mb-0">clienteejemplosa@hotmail.com</p>
                            <div class="card border-0 rounded-4 mt-3" style="background-color: rgb(159,178,205, 0.3);">
                                <div class="card-body position-relative">
                                    <div class="round-circle-left"></div>
                                    <div class="round-circle-right"></div>
                                    <ul class="list-unstyled fs-sm pb-2 border-dashed">
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span class="me-2">Subtotal:</span>
                                            <span class="text-end">$2181.80</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span class="me-2">Descuento:</span>
                                            <span class="text-end">-</span>
                                        </li>
                                    </ul>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small>Precio a pagar</small>
                                            <h5 class="total-price fw-bold">$2181.80 <small>USD</small></h5>
                                        </div>
                                        <div>
                                            <i class="fa-solid fa-file-invoice fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 bg-transparent row g-2 flex-column mx-0">
                            <button type="button" class="btn btn-lg btn-dark-zc fw-bold" data-bs-toggle="modal" data-bs-target="#detalleOrdenModal">
                                Ver detalle
                            </button>
                            <button type="button" class="btn btn-lg btn-dark-zc fw-bold">
                                Realizar compra
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('script-app')
<!-- <script src="{{asset('assets/js/helper.js')}}"></script> -->
<script>
    // let isValid = true;
    // let errorMessage = "";

    // Evento para validar el formulario al enviar
    /* const form = document.getElementById('rucForm');
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        // let rucInput = document.getElementById('numeroIdentificacion').value.trim();
        // let isValid = true;
        // let errorMessage = "";

        if (rucInput === '') {
            mostrarMensajeModal('Campo requerido', 'Por favor, ingresa tu número de identificación (RUC).');
            isValid = false;
            errorMessage = 'Por favor, ingresa tu número de identificación (RUC).';
            // return;
        }

        else if (!(/^\d+$/.test(rucInput))) {
            mostrarMensajeModal('Formato Incorrecto', 'El número de identificación debe contener solo números.');
            isValid =  false;
            errorMessage = 'El número de identificación debe contener solo números';
            // return;
        }

        else if (!validarRuc(rucInput)) {
            mostrarMensajeModal('RUC Incorrecto', 'El número de identificación (RUC) ingresado es inválido.');
            isValid = false;
            errorMessage = 'El número de identificación (RUC) ingresado es inválido.';
            // return;
        }

        if (!isValid) {
            let errorDiv = document.getElementById('numeroIdentificacion').closest('.col-md-12').querySelector('.invalid-feedback');
            errorDiv.textContent = errorMessage;
            errorDiv.style.display = 'block';
            return;
        }

        // Aquí puedes enviar el formulario si todo está correcto
        const url = `/index?ruc=${rucInput}`;

        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log(data); // Aquí puedes hacer algo con los datos, como mostrarlos en la página
            // Redirigir a la nueva vista con los datos
            // window.location.href = '/vista/businessPartners';
        } catch (error) {
            console.error('Error fetching data:', error);
        }
        
    }); */

    // Evento para cerrar el modal
    /* document.getElementById('mensajeModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('rucForm').reset();
        document.getElementById('numeroIdentificacion').classList.remove('is-valid', 'is-invalid');
    }); */

    // Evento para limpiar clases de validación cuando se escribe en el campo
    /* document.getElementById('numeroIdentificacion').addEventListener('input', function() {
        this.classList.remove('is-valid', 'is-invalid');
    }); */

    // Función para ocultar el mensaje de error al corregir el campo
    /* document.getElementById('numeroIdentificacion').addEventListener('input', function() {
        let errorDiv = this.closest('.col-md-12').querySelector('.invalid-feedback');
        errorDiv.textContent = 'Por favor, ingresa tu número de identificación (RUC).';
        errorDiv.style.display = 'none';
    }); */

    // Función para mostrar el modal con el mensaje
    /* function mostrarMensajeModal(titulo, mensaje) {
        let modalTitle = document.querySelector('#mensajeModal .modal-title');
        let modalBody = document.querySelector('#mensajeModal .modal-body');

        modalTitle.textContent = titulo;
        modalBody.innerHTML = '<p>' + mensaje + '</p>';

        let modal = new bootstrap.Modal(document.getElementById('mensajeModal'));
        modal.show();
    } */

</script>
@endpush