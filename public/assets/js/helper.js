const csrfToken = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
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

function capitalizarPrimeraLetraCadaPalabra(texto) {
    // Dividir el texto en un array de palabras
    let palabras = texto.split(' ');

    // Capitalizar la primera letra de cada palabra
    let palabrasCapitalizadas = palabras.map(palabra => {
        // Verificar que la palabra no esté vacía
        if (palabra.length > 0) {
            return palabra[0].toUpperCase() + palabra.slice(1).toLowerCase();
        } else {
            return '';
        }
    });

    // Unir las palabras en una cadena nuevamente
    let textoCapitalizado = palabrasCapitalizadas.join(' ');

    return textoCapitalizado;
}

function formatearFecha(fechaString) {
    // Dividir la cadena de fecha en día, mes y año
    const [anio, mes, dia] = fechaString.split('-');

    // Obtener nombre del mes en español
    const meses = [
        "ENE", "FEB", "MAR", "ABR", "MAY", "JUN",
        "JUL", "AGO", "SEP", "OCT", "NOV", "DIC"
    ];
    const nombreMes = meses[parseInt(mes, 10) - 1]; // Restar 1 para obtener el mes correcto del array

    // Formatear la fecha final
    const fechaFormateada = `${nombreMes} ${dia}, ${anio}`;
    
    return fechaFormateada;
}

function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

function generarIdentificadorUnico() {
    let caracteres = 'abcdefghijklmnopqrstuvwxyz0123456789';
    let identificador = '';
    for (let i = 0; i < 10; i++) {
        identificador += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
    }
    // return 'identificadorUnico' + identificador;
    return identificador;
}

// Desplazar hasta la parte superior
function scrollTop() {
    document.body.scrollTop = 0;    // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
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
