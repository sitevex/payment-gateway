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
const logoutLink = document.getElementById('logout');

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

// ------------------ Logout ------------------
if (logoutLink) {
    logoutLink.addEventListener('click', function (event) {
        event.preventDefault();
        logoutSAPLayer();
    })
}

// ------------------ Realizar compra ------------------


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
            console.log('Obtener pedidos..');
        break;
        case 2:
            console.log('Metodo de pago');
            // datosFactura();
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
    let firstName = document.getElementById('user-first-name');
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
            // console.log(data); // Aquí puedes hacer algo con los datos, como mostrarlos en la página
            let userName = data.value[0].CardName
            navAvatar.style.display = 'block';
            userNameNavbar.textContent = userName;
            cardCode = data.value[0].FederalTaxID
            firstName.textContent = userName.charAt(0).toUpperCase();
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

// Step Pedido
async function obtenerPedido(customerCode) {
    showLoader();
    let contentMsjNoOrders = document.querySelector('.msj-noOrders');
    contentMsjNoOrders.hidden=true;

    let contentOrders = document.querySelector('.content-orders');
    contentOrders.innerHTML = '';

    const url = `/lista-pedido?customerCode=${customerCode}`;
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        hideLoader();
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
                            <p class="fs-sm text-start mb-0">${item.NO_PEDIDO}</p>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="badge text-bg-sail">Fecha y Hora</span>
                            <p class="fs-xxs text-end mb-0">${formatearFecha(item.FECHA)}</p>
                            <p class="fs-xs fw-bold text-end mb-0 d-none" >10:20 AM</p>
                        </div>
                    </div>
                    <p class="fw-bold mb-0 d-none">ZC - Guayaquil</p>
                    <p class="fs-sm mb-0">${capitalizarPrimeraLetraCadaPalabra(item.NOMBRE_CLIENTE)}</p>
                    <p class="fs-sm mb-0">${item.EMAIL}</p>
                    <div class="card border-0 rounded-4 mt-3" style="background-color: rgb(159,178,205, 0.3);">
                        <div class="card-body position-relative">
                            <div class="round-circle-left"></div>
                            <div class="round-circle-right"></div>
                            <ul class="list-unstyled fs-sm pb-2 border-dashed">
                                <li class="d-flex justify-content-between align-items-center">
                                    <span class="me-2">Subtotal:</span>
                                    <span class="text-end">$ ${item.SUBTOTAL}</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <span class="me-2">Descuento:</span>
                                    <span class="text-end">${item.DESCUENTO}</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                <span class="me-2">Impuesto:</span>
                                <span class="text-end">$ ${item.IMPUESTO}</span>
                            </li>
                            </ul>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small>Precio a pagar</small>
                                    <h5 class="total-price fw-bold">$ ${item.TOTAL}<small>USD</small></h5>
                                </div>
                                <div>
                                    <i class="fa-solid fa-file-invoice fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0 bg-transparent row g-2 flex-column mx-0 pb-3">
                    <button type="button" class="btn btn-lg btn-dark-zc btn-look-detail fw-bold" data-bs-toggle="modal" data-bs-target="#detalleOrdenModal" data-modo="datalle" data-id="${item.NO_PEDIDO}" data-subtotal="${item.SUBTOTAL}" data-descuento="${item.DESCUENTO}" data-impuesto="${item.IMPUESTO}" data-totalPagar="${item.TOTAL}">
                        Ver detalle
                    </button>
                    <button type="button" class="btn btn-lg btn-dark-zc btn-make-purchase fw-bold" data-item-id="${item.NO_PEDIDO}" data-pedido='${JSON.stringify(item)}'>
                        Realizar compra
                    </button>
                </div>
            </div>
        </div>
        `;
        contentOrders.innerHTML += elemento;
    });
    
    const btnsMakePurchase = document.querySelectorAll(".btn-make-purchase");
    btnsMakePurchase.forEach(btn => {
        btn.addEventListener('click', function () {
            let itemId = btn.getAttribute('data-item-id');
            let pedido = JSON.parse(btn.getAttribute('data-pedido'));

            _nextStep[itemId] = true;
            checkAndContinue(itemId);

            datosFactura(pedido);
        });
    });

    const btnsLookDetail = document.querySelectorAll(".btn-look-detail");
    btnsLookDetail.forEach(btn => {
        btn.addEventListener('click', function () {
            let itemId = btn.getAttribute('data-id');
            let dataSubtotal = btn.getAttribute('data-subtotal');
            let dataDescuento = btn.getAttribute('data-descuento');
            let dataImpuesto = btn.getAttribute('data-impuesto');
            let dataTotalPagar = btn.getAttribute('data-totalPagar');

            let numberOrden = document.getElementById('numberOrden');
            let detalleSubtotal = document.getElementById('detalleSubtotal');
            let detalleDescuento = document.getElementById('detalleDescuento');
            let detalleImpuesto = document.getElementById('detalleImpuesto');
            let detalleTotalPagar = document.getElementById('detalleTotalPagar');
            
            numberOrden.textContent = itemId;
            detalleSubtotal.textContent = dataSubtotal;
            detalleDescuento.textContent = dataDescuento;
            detalleImpuesto.textContent = dataImpuesto;
            detalleTotalPagar.textContent = dataTotalPagar;
            
            //console.log(itemId);
            obtenerDetallePedido(itemId);
        });
    });
}

async function obtenerDetallePedido(noPedido){
    showLoader();
    
    let contentItemsOrden = document.getElementById('list-items-orden');
    let listOrderSummary = document.getElementById('list-orderSummary');
    let placeholderGlow = document.querySelectorAll(".placeholder-glow");
    
    contentItemsOrden.innerHTML = '';
    listOrderSummary.hidden=true;

    placeholderGlow.forEach(element => {
        element.style.display = 'block'; // O puedes usar element.classList.add('hidden');
    });

    const url = `/detalle-ordenes?noPedido=${noPedido}`;
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        
        hideLoader();
        if (data.value.length === 0) {
            mostrarNoExistenOrdenes();
        } else {
            listOrderSummary.hidden=false;
            placeholderGlow.forEach(element => {
                element.style.display = 'none'; // O puedes usar element.classList.add('hidden');
            });
            mostrarItemsDetalle(data);
        }
    } catch (error) {
        mostrarErrorModal('Error', 'Se produjo un error al obtener el detalle del pedido. Por favor, inténtalo de nuevo más tarde o regresa a la página de inicio.');
        console.error('Error fetching data:', error);
    }
}

function mostrarItemsDetalle(data) {
    let contentItemsOrden = document.getElementById('list-items-orden');

    data.value.forEach(itemsDetalle => {
        // Dividir el nombre del item en palabras
        let nombreMarca = itemsDetalle.NAME_ITEM.split(' ');
        let elemento = `
        <div class="list-group-item list-group-item-action list-group-items-details gap-3 px-0 bg-transparent" aria-current="true">
            <div class="my-auto text-start w-auto">
                <span class="badge text-bg-sail">${itemsDetalle.COD_ITEM}</span>
                <h6 class="fs-sm fw-medium line-clamp-2 mb-0">${capitalizarPrimeraLetraCadaPalabra(itemsDetalle.NAME_ITEM)}</h6>
                <p class="fs-xxs line-clamp-1 mb-0 opacity-75">${nombreMarca[0].toUpperCase()}</p>
            </div>
            <div class="d-flex flex-column w-auto justify-content-between lh-sm text-end">
                <small class="fs-xs text-nowrap">Cant: ${itemsDetalle.CANTIDAD}</small>
                <small class="fs-xs fw-medium text-nowrap">Desc: ${itemsDetalle.DESCUENTO_LIN}</small>
                <small class="fs-xs fw-medium text-nowrap">Prec tras/desc: $ ${itemsDetalle.PRECIO_DESCUENTO}</small>
                <small class="fs-xs fw-medium text-nowrap">Iva: ${itemsDetalle.IMPUESTO_LIN}</small>
                <small class="fs-xs fw-medium text-nowrap">SubTotal: $ ${itemsDetalle.TOTAL_ARTICULO}</small>
            </div>
        </div>
        `;
        contentItemsOrden.innerHTML += elemento;
    });
}

// Step Método de pago
function datosFactura(pedido) {
    let totalPagarLabel = document.getElementById('totalPagarLabel');
    totalPagarLabel.innerHTML = '';

    document.getElementById('numeroIdentificacionFact').value = pedido.RUC;
    document.getElementById('nombreFact').value = pedido.NOMBRE_CLIENTE;
    document.getElementById('emailFact').value = pedido.EMAIL;
    document.getElementById('telefonoFact').value = pedido.TELEFONO;
    document.getElementById('noPedidoFact').value = pedido.NO_PEDIDO;
    document.getElementById('referenceFact').value = pedido.VENDEDOR;
    document.getElementById('unicoFact').value = pedido.UNICO;
    document.getElementById('impuestoFact').value = pedido.IMPUESTO;
    document.getElementById('totalPagarFact').value = pedido.TOTAL;
    totalPagarLabel.textContent = '$ ' + pedido.TOTAL;
    // console.log(pedido.NO_PEDIDO);
    // console.log(pedido.TOTAL);
}

// Pay
document.querySelector('#btnPayphone').addEventListener('click', function () {
    console.log('test pagar');
    procesoPago();
});

function procesoPago() {
    let valorPagar = totalPagarFact.value;
    let inpuesto = impuestoFact.value;
    let transactionId = unicoFact.value;
    let reference = referenceFact.value;
    let documentId = noPedidoFact.value;
    inpuesto = Math.round(inpuesto*100);
    valorPagar = Math.round(valorPagar*100);

    let parametros = {
        amount: valorPagar,
        // tax: inpuesto,
        // currency: "USD",
        clientTransactionId: transactionId,
        reference: reference,
        documentId: documentId,
        responseUrl: "https://pagodigital.zcmayoristas.com/response",
        cancellationUrl: "https://pagodigital.zcmayoristas.com/response"
    };

    console.log(parametros);
    parametros['Referer'] = document.referrer;

    fetch('https://pay.payphonetodoesposible.com/api/button/Prepare', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': "Bearer oyDuDjdVeaFun4bXHuCcTuj4QDUCeduArGriIlgbNxOeURWpKP4e-K2XM0h9PXEQ7ktg0qAA7weVE_tFnoRG1vEZHm5-hsNjoBJqcqPjeXmWj1mOkFM5f7PeZx6aZ3fX5-9wrVMO1-LEvqCMzpvVwSyE0QfLap_chx7CnkoCBKNMep1sfZZ9waQVWMQkXDBAVHrm84_s1T2BySj29uXJohNnV38U1HMmrdH3swUXovpzQU4c_EF7qygUf8baIF-4ZJWRqARUjE63_IHmyXio5P744NwJLzL4SDf3fCYyfsHSYHZ72J4M16EwqONzwBSGC0IDYw",
            'Referer': document.referrer
        },
        body: JSON.stringify(parametros)
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(function(respuesta) {
        location.href = respuesta.payWithCard;
    })
    .catch(function(error) {
        alert("Error en la llamada:" + error.message);
    });
}


function mostrarNoExistenOrdenes() {
    let contentOrders = document.querySelector('.content-orders');
    contentOrders.hidden=true

    let contentMsjNoOrders = document.querySelector('.msj-noOrders');
    contentMsjNoOrders.hidden=false

    let elemento = `
        <div class="card circle-outer" style="background: #1D2E51;">
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
                    </div>
                </div>
            </div>
        </div>
    `;

    contentMsjNoOrders.innerHTML = elemento;
}

async function logoutSAPLayer() {
    showLoader();
    // const url = '';
    try {
        const response = await fetch('/logout-sap', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        if (!response.ok) {
            throw new Error('Error al cerrar sesión. Por favor, inténtelo de nuevo.');
        }
        hideLoader();
        // Recargar la página actual después de cerrar sesión
        window.location.reload();
    } catch (error) {
        console.error(error.message);
        // Manejar el error apropiadamente, por ejemplo, mostrar un mensaje al usuario
    }
}