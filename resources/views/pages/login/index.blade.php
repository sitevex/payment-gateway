@extends('layouts.zc_app')
@section('title','Pago Digital')
@section('content')
<!-- Importar el componente Modal -->
@component('components.organisms.modal_mesaje', [
'modalId' => 'mensajeModal', // ID único para la modal
'modalSize' => 'modal-sm', // Tamaño de la modal
'modalHeaderJustify' => 'justify-content-center',
'modalTitle' => 'Título de la Modal 1', // Título de la modal
'showCloseButton' => false, // Mostrar el botón de cierre
'textAlign' => 'text-center', // Justificar el texto
'modalFooter' => '<button type="button" class="btn btn-lg btn-dark-zc fw-bold w-100"
    data-bs-dismiss="modal">Aceptar</button>'
])
<!-- Contenido de la modal -->
<p>Contenido de la Modal 1 aquí...</p>
@endcomponent
<section>
    <div class="container">
        <div class="row flex-center min-vh-100 py-5">
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
                        <form class="row g-3 needs-validation" novalidate action="#" method="get" id="rucForm">
                            @csrf
                            <div class="col-md-12">
                                <label for="numeroIdentificacion" class="form-label fs-sm d-none">Número de idetificación</label>
                                <input type="number" class="form-control form-control-lg" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="Ingresa tu número de identificación (ruc)" required data-error="Número de identificación incorrecto. Por favor, inténtalo de nuevo." />
                                <div class="invalid-feedback">
                                    Número de identificación incorrecto. Por favor, inténtalo de nuevo.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-lg btn-warning-zc fw-bold w-100" type="submit">Continuar</button>
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
@endsection
@push('script-app')
<script src="{{asset('assets/js/helper.js')}}"></script>
<script>
    let isValid = true;
    let errorMessage = "";

    // Evento para validar el formulario al enviar
    const form = document.getElementById('rucForm');
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        let rucInput = document.getElementById('numeroIdentificacion').value.trim();
        let isValid = true;
        let errorMessage = "";

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
        } catch (error) {
            console.error('Error fetching data:', error);
        }
        
    });

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
    function mostrarMensajeModal(titulo, mensaje) {
        let modalTitle = document.querySelector('#mensajeModal .modal-title');
        let modalBody = document.querySelector('#mensajeModal .modal-body');

        modalTitle.textContent = titulo;
        modalBody.innerHTML = '<p>' + mensaje + '</p>';

        let modal = new bootstrap.Modal(document.getElementById('mensajeModal'));
        modal.show();
    }

</script>
@endpush