let _nextStep;
let currentStep = 0;
let errorMessage = "";
let navAvatar = document.querySelector('.nav-avatar');
let numeroIdentificacion = document.getElementById('numeroIdentificacion');
// ------------------ MUlti step ------------------ 
const multiStepForm = document.querySelector("[data-multi-step]");
const formSteps  = [...multiStepForm.querySelectorAll("[data-step]")]
const navItemSteps  = document.querySelectorAll(".navbar-step .navbar-nav li a.nav-link")
const progressSteps = document.querySelectorAll(".nav-step");

navAvatar.style.display = 'none';

// ------------------ Login ------------------
document.querySelector("#btnGetInto").addEventListener('click', async function (e) {
    let rucInput = numeroIdentificacion.value;
    // console.log(rucInput);
    if (rucInput !== '') {
        let rucValida = validarRuc(rucInput);
        if (rucValida) {
            let userData = await obtenerUsuario(rucInput);
            console.log(userData);
            if (userData) {
                _nextStep = true;
            } else {
                _nextStep = false;
                mostrarMensajeModal('Información no encontrada', 'No existe usuario, debe registrarlo.');
            }
        } else {
            mostrarMensajeModal('RUC Incorrecto', 'El número de identificación (RUC) ingresado es inválido.');
            _nextStep = false;
        }
    } else {
        mostrarMensajeModal('Campo requerido', 'Por favor, ingresa tu número de identificación (RUC).');
        _nextStep = false;
    }
    checkAndContinue();
});

// ------------------ Atrás ------------------
document.querySelectorAll('[data-previous]').forEach(prevBtn => {
    prevBtn.addEventListener('click', function () {
        currentStep = getCurrentStep();
        currentStep--;
        doActionStep(currentStep);
        showCurrentStep();
        updateProgressbar();
    });
});

function checkAndContinue() {
    if (_nextStep) {
        currentStep = getCurrentStep();
        currentStep++;
        doActionStep(currentStep);
        showCurrentStep();
        updateProgressbar();
    }
}

function getCurrentStep() {
    let currentStep = formSteps.findIndex(step => {
        return step.classList.contains("active");
    });
    if (currentStep < 0) {
        currentStep = 0;
    }
    return currentStep;
}

formSteps.forEach(step =>{
    step.addEventListener("animationend", (e) =>{
        // remove hide una vez completado la info
        formSteps[currentStep].classList.remove("hide")
        // agrega y quita el hide[adelante] cuando click data-previous atras linea clave 
        e.target.classList.toggle("hide", e.target.classList.contains("active"))
    })
});

// hide and show the current step by toggleing the class "active"
function showCurrentStep(){
    formSteps.forEach((step,index) =>{
        // console.log('------------------------------ data-step -----------------------------------');
        step.classList.toggle ("active", index===currentStep)
        if (index === currentStep){
            // click btn con data-next
            step.classList.remove("hide")
        }
    });
}

function updateProgressbar() {
    progressSteps.forEach((progressStep, idx) => {
        if (idx < currentStep) {    // idx < currentStep + 1
            progressStep.classList.add("done");
        } else {
            progressStep.classList.remove("done");
        }
        progressStep.classList.toggle ("active", idx===currentStep)
    });
}

function doActionStep(currentStep) {
    switch (currentStep) {
        case 1:
            // obtenerUsuario(numeroIdentificacion.value);
            console.log('Obtener pedidos..');
        break;
        case 2:
            console.log('ha eligido una especialidad');
            console.log('Obtener todas las centrales medicas....');
            obtenerCentroMedico();
        break;
        case 3:
            console.log('ha eligido un centro medico');
            obtenerFechasDisponibles();
        break;
        case 4:
            console.log('ha Seleccionado fecha y doctor');
            mostrarInfoCita();
        break;
        case 5:
            console.log('Su cita fue agenada con exito.');
            confirmarCita();
        break;
    }
}

// ------------------ Flujo ------------------
// Step Login
async function obtenerUsuario(numeroIdentificacion) {
    showLoader();
    let userNameNavbar = document.getElementById('user-name-navbar');
    // let rucInput = document.getElementById('numeroIdentificacion').value.trim();
    // Aquí puedes enviar el formulario si todo está correcto
    const url = `/businessPartnerstwo?ruc=${numeroIdentificacion}`;

    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        hideLoader();
        
        if (data.value.length === 0) {
            return false;
        } else {
            console.log(data); // Aquí puedes hacer algo con los datos, como mostrarlos en la página
            navAvatar.style.display = 'block';
            userNameNavbar.textContent = data.value[0].CardName;
            cardCode = data.value[0].CardCode
            obtenerPedido(cardCode);
            return true;
        }
    } catch (error) {
        hideLoader();
        mostrarErrorModal('Error', 'Se produjo un error al obtener la información del usuario. Por favor, inténtalo de nuevo más tarde o regresa a la página de inicio.');
        console.error('Error fetching data:', error);
        _nextStep = false;
    }
}

async function obtenerPedido(customerCode) {
    let contentMsjNoOrders = document.querySelector('.msj-noOrders');
    contentMsjNoOrders.hidden=true;

    let contentOrders = document.querySelector('.content-orders');
    contentOrders.innerHTML = '';

    const url = `/lista-solicitud?customerCode=${customerCode}`;
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        if (data.value.length === 0) {
            mostrarNoExistenOrdenes();
        } else {
            mostrarOrdenes(data);
        }
    } catch (error) {
        mostrarErrorModal('Error', 'Se produjo un error al obtener los pedidos. Por favor, inténtalo de nuevo más tarde o regresa a la página de inicio.');
        console.error('Error fetching data:', error);
    }
}

function mostrarOrdenes(data) {
    let contentMsjNoOrders = document.querySelector('.msj-noOrders');
    contentMsjNoOrders.innerHTML = '';

    let contentOrders = document.querySelector('.content-orders');
    contentOrders.hidden=false;

    // Recorrer cada ítem en data.value y crear una card para cada uno
    // console.log(data);
    data.value.forEach(item  => {
        let elemento = `
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
                <div class="card-footer border-0 bg-transparent row g-2 flex-column mx-0 pb-3">
                    <button type="button" class="btn btn-lg btn-dark-zc fw-bold" data-bs-toggle="modal" data-bs-target="#detalleOrdenModal" data-modo="datalle" data-id="${item.SERVICECALLID}">
                        Ver detalle
                    </button>
                    <button type="button" class="btn btn-lg btn-dark-zc fw-bold">
                        Realizar compra
                    </button>
                </div>
            </div>
        </div>
        `;
        contentOrders.innerHTML += elemento;
    });
}

function mostrarNoExistenOrdenes() {
    let contentOrders = document.querySelector('.content-orders');
    contentOrders.hidden=true

    let contentMsjNoOrders = document.querySelector('.msj-noOrders');
    contentMsjNoOrders.hidden=false

    let elemento = `
        <div class="card" style="background: #1D2E51;">
            <div class="card-body p-4 py-md-4 px-md-5">
                <div class="row g-0 align-items-center">
                    <div class="col-12 col-md-7 z-1">
                        <h4 class="fw-bold text-white">No Tienes  <span class="gradient-text">Productos </span></h4>
                        <h1 class="fw-black text-white">PARA COMPRAR</h1>
                        <p class="fs-sm mb-4 text-white">En ZCMayoristas tenemos todo lo que necesitas <br> para tus proyectos de tecnología y seguridad.</p>
                        <a class="btn btn-lg button-33 banner-button" href="#!">Compra ahora</a>
                    </div>
                    <div class="col-12 col-md-5">
                        <img src="assets/img/banner/producto_3.png" class="img-fluid d-block overflow-hidden position-sticky z-1" width="512" alt="producto_zc" />
                        <div class="circle-outer top">
                            <!-- Circulo interno superior -->
                            <div class="circle-inner"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    contentMsjNoOrders.innerHTML = elemento;
}
