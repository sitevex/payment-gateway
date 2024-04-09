/* function validarRuc(ruc) {
    // Eliminar espacios en blanco y guiones
    ruc = ruc.replace(/\s/g, '').replace(/-/g, '');

    // Verificar longitud
    if (ruc.length !== 13) {
        return false;
    }

    // Verificar tipo de entidad
    var tipoEntidad = parseInt(ruc.substring(2, 3));

    // Validar para sociedades privadas y extranjeros no residentes
    if (tipoEntidad === 9) {
        var provincia = parseInt(ruc.substring(0, 2));
        var tercerDigito = parseInt(ruc.substring(2, 3));
        var secuencia = ruc.substring(3, 10);
        var tresUltimos = ruc.substring(10);

        if ((tercerDigito !== 6 && tercerDigito !== 9) || tresUltimos !== '001' || isNaN(provincia) || isNaN(secuencia)) {
            return false;
        }
    }

    // Validar para sociedades públicas
    if (tipoEntidad === 2) {
        var provincia = parseInt(ruc.substring(0, 2));
        var tercerDigito = parseInt(ruc.substring(2, 3));
        var secuencia = ruc.substring(3, 10);
        var tresUltimos = ruc.substring(10);

        if (tercerDigito !== 9 || tresUltimos !== '001' || isNaN(provincia) || isNaN(secuencia)) {
            return false;
        }
    }

    // RUC válido
    return true;
} */

function validarRuc(ruc) {
    var last3 = ruc.substr(ruc.length - 3);
    if (ruc.length == 13 && last3 == "001") {
        return true;
    } else {
        return false;
    }
}

// Función para mostrar el modal con el mensaje
function mostrarMensajeModal(titulo, mensaje) {
    let modalTitle = document.querySelector('#mensajeModal .modal-title');
    let modalBody = document.querySelector('#mensajeModal .modal-body');

    modalTitle.textContent = titulo;
    modalBody.innerHTML = '<p class="fs-sm">' + mensaje + '</p>';

    let modal = new bootstrap.Modal(document.getElementById('mensajeModal'));
    modal.show();
}

function mostrarErrorModal(titulo, mensaje) {
    let modalTitle = document.querySelector('#errorModal .modal-title');
    let modalBody = document.querySelector('#errorModal .modal-body');

    modalTitle.textContent = titulo;
    modalBody.innerHTML = '<p class="fs-sm">' + mensaje + '</p>';

    let modal = new bootstrap.Modal(document.getElementById('errorModal'));
    modal.show();
}

detalleOrdenModal.addEventListener('shown.bs.modal', function (event) {
    console.log('test detalle');
    const button = event.relatedTarget;
    const modo = button.getAttribute('data-modo');

    if (modo === 'datalle') {
        const id = button.getAttribute('data-id');
        console.log(id);
    }

});
/* function mostrarDetalleModal() {
} */

function showLoader() {
    document.body.style.overflow = 'hidden';
    var loader = document.querySelector('.body-loader');
    if (loader) {
        loader.style.display = 'block';
    }
}

function hideLoader() {
    document.body.style.overflow = 'auto';
    var loader = document.querySelector('.body-loader');
    if (loader) {
        loader.style.display = 'none';
    }
}


// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()
