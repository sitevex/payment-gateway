let _nextStep;
let currentStep = 0;
let errorMessage = "";
let checkoutId = '';

let numeroIdentificacion = document.getElementById('numeroIdentificacion');
let cardFact = document.getElementById('cardFact');
let requiredFields = cardFact.querySelectorAll('.form-control[required]');

// ------------------ MUlti step ------------------ 
const multiStepForm = document.querySelector("[data-multi-step]");
const formSteps  = [...multiStepForm.querySelectorAll("[data-step]")]
const navItemSteps  = document.querySelectorAll(".navbar-step .navbar-nav li a.nav-link")
const progressSteps = document.querySelectorAll(".nav-step");

// ------------------ Login ------------------
document.querySelector("#btnGetInto").addEventListener('click', async function (e) {
    let rucInput = numeroIdentificacion.value;
    if (rucInput !== '') {
        let rucValida = validarRuc(rucInput);
        if (rucValida) {
            let userData = await obtenerUsuario(rucInput);
            // console.log(userData);
            if (userData) {
                _nextStep = true;
            } else {
                _nextStep = false;
                mostrarMensajeModal('Información no encontrada', 'Revisar tú número de identificación, o comunícate con tú vendedor.');
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

// ------------------ PayPhone ------------------
document.querySelector('#btnPayphone').addEventListener('click', function () {
    procesoPagoPayPhone();
});

// ------------------ modal detalleOrden ------------------
detalleOrdenModal.addEventListener('shown.bs.modal', function (event) {
    const button = event.relatedTarget;
    const modo = button.getAttribute('data-modo');

    if (modo === 'datalle') {
        const id = button.getAttribute('data-id');
    }
});

// ------------------ Atrás ------------------
document.querySelectorAll('[data-previous]').forEach(prevBtn => {
    prevBtn.addEventListener('click', function () {
        currentStep = getCurrentStep();
        currentStep--;
        doActionStep(currentStep);
        showCurrentStep();
        updateProgressbar();
        scrollTop();
    });
});

function checkAndContinue() {
    if (_nextStep) {
        currentStep = getCurrentStep();
        currentStep++;
        doActionStep(currentStep);
        showCurrentStep();
        updateProgressbar();
        scrollTop();
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
        formSteps[currentStep].classList.remove("hide")
        e.target.classList.toggle("hide", e.target.classList.contains("active"))
    })
});

function showCurrentStep(){
    formSteps.forEach((step,index) =>{
        step.classList.toggle ("active", index===currentStep)
        if (index === currentStep){
            step.classList.remove("hide")
        }
    });
}

function updateProgressbar() {
    progressSteps.forEach((progressStep, idx) => {
        if (idx < currentStep) {
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
            // console.log('Obtener pedidos..');
        break;
        case 2:
            // console.log('Metodo de pago');
        break;
        case 3:
            // console.log('Comprobante');
        break;
    }
}

// ------------------ Flujo ------------------
// Step Login
async function obtenerUsuario(numeroIdentificacion) {
    showLoader();
    let navAvatar = document.querySelector('.nav-avatar');
    navAvatar.innerHTML = '';

    const url = `/businessPartners?ruc=${numeroIdentificacion}`;
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
            let userName = data.value[0].CardName
            let elemento = `
                <a class="d-flex align-items-end gap-1 link-body-emphasis text-decoration-none dropdown-toggle dropdown-toggle-avatar cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-online d-lg-none">
                            <span class="avatar-initial rounded-circle bg-avatar" id="user-first-name">${userName.charAt(0).toUpperCase()}</span>
                        </div>
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle d-none" id="user-img-navbar">
                        <div class="d-none d-lg-flex flex-column lh-1">
                            <span class="text-start text-white fs-sm">Hola</span>
                            <span class="text-start text-white fs-xs fw-bold" id="user-name-navbar">${userName}</span>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start text-small">
                    <li><a class="dropdown-item cursor-pointer" id="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar sesión</a></li>
                </ul>
            `;
            navAvatar.innerHTML += elemento;
            
            cardCode = data.value[0].FederalTaxID
            obtenerPedido(cardCode);

            // ------------------ Logout ------------------
            if (navAvatar) {
                navAvatar.addEventListener('click', function (event) {
                    const target = event.target;
                    if (target.matches('#logout')) {
                        event.preventDefault();
                        logoutSAPLayer();
                    }
                });
            }

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
    
    // ------------------ Realizar compra ------------------
    const btnsMakePurchase = document.querySelectorAll(".btn-make-purchase");
    btnsMakePurchase.forEach(btn => {
        btn.addEventListener('click', function () {
            let itemId = btn.getAttribute('data-item-id');
            let pedido = JSON.parse(btn.getAttribute('data-pedido'));

            _nextStep[itemId] = true;
            checkAndContinue(itemId);
            datosFactura(pedido);
            // processDatafast(pedido);
            obtenerItemsPedido(itemId, pedido);
        });
    });
    // ------------------ Ver detalle ------------------
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
            detalleSubtotal.textContent = dataSubtotal !== null && parseFloat(dataSubtotal) !== 0 ? `$ ${dataSubtotal}` : '-';
            detalleDescuento.textContent = dataDescuento !== null && parseFloat(dataDescuento) !== 0 ? `$ ${dataDescuento}` : '-';
            detalleImpuesto.textContent = dataImpuesto !== null && parseFloat(dataImpuesto) !== 0 ? `$ ${dataImpuesto}` : '-';
            detalleTotalPagar.textContent = dataTotalPagar !== null && parseFloat(dataTotalPagar) !== 0 ? `$ ${dataTotalPagar}` : '-';
            
            obtenerDetallePedido(itemId);
        });
    });
}

async function obtenerDetallePedido(noPedido){
    showLoader();
    
    let contentItemsOrden = document.getElementById('listItemsOrden');
    let listOrderSummary = document.getElementById('listOrderSummary');
    let placeholderGlow = document.querySelectorAll(".placeholder-glow");
    
    contentItemsOrden.innerHTML = '';
    listOrderSummary.hidden=true;

    placeholderGlow.forEach(element => {
        element.style.display = 'block';
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
                element.style.display = 'none';
            });
            mostrarItemsDetalle(data);
        }
    } catch (error) {
        mostrarErrorModal('Error', 'Se produjo un error al obtener el detalle del pedido. Por favor, inténtalo de nuevo más tarde o regresa a la página de inicio.');
        console.error('Error fetching data:', error);
    }
}

async function obtenerItemsPedido(itemId, pedido) {
    showLoader();
    const url = `/detalle-ordenes?noPedido=${itemId}`;
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
            let items = data.value.map(item => ({
                product_name: item.NAME_ITEM,
                product_price: item.PRECIO_DESCUENTO,
                cantidad: item.CANTIDAD
            }));
            processDatafast(pedido, items);
        }
    } catch (error) {
        mostrarErrorModal('Error', 'Se produjo un error al obtener el detalle del pedido. Por favor, inténtalo de nuevo más tarde o regresa a la página de inicio.');
        hideLoader();
        // console.error('Error fetching data:', error);
    }

}

function mostrarItemsDetalle(data) {
    let contentItemsOrden = document.getElementById('listItemsOrden');

    data.value.forEach(itemsDetalle => {
        let nombreMarca = itemsDetalle.NAME_ITEM.split(' ');
        let elemento = `
        <div class="list-group-item list-group-item-action list-group-items-details px-0 bg-transparent" aria-current="true">
            <div class="my-auto text-start col-auto col-md-8">
                <span class="badge text-bg-sail">${itemsDetalle.COD_ITEM}</span>
                <h6 class="fs-sm fw-medium line-clamp-2 mb-0">${capitalizarPrimeraLetraCadaPalabra(itemsDetalle.NAME_ITEM)}</h6>
                <p class="fs-xxs line-clamp-1 mb-0 opacity-75">${nombreMarca[0].toUpperCase()}</p>
            </div>
            <div class="d-flex flex-column col-5 col-md-3 lh-sm ms-auto">
                <small class="fs-xs text-nowrap d-flex justify-content-between">Cant: <b>${itemsDetalle.CANTIDAD}</b></small>
                <small class="fs-xs fw-medium text-nowrap d-flex justify-content-between">Desc: <b>${itemsDetalle.DESCUENTO_LIN}</b></small>
                <small class="fs-xs fw-medium text-nowrap d-flex justify-content-between">Prec tras/desc: <b>$ ${itemsDetalle.PRECIO_DESCUENTO}</b></small>
                <small class="fs-xs fw-medium text-nowrap d-flex justify-content-between">Iva: <b>${itemsDetalle.IMPUESTO_LIN}</b></small>
                <small class="fs-xs fw-medium text-nowrap d-flex justify-content-between">SubTotal: <b>$ ${itemsDetalle.TOTAL_ARTICULO}</b></small>
            </div>
        </div>
        `;
        contentItemsOrden.innerHTML += elemento;
    });
}

// Step Método de pago
function datosFactura(pedido) {
    let emails = pedido.EMAIL;
    let emailArray = emails.split(';');
    let email = emailArray[0].trim();

    let totalPagarLabel = document.getElementById('totalPagarLabel');
    totalPagarLabel.innerHTML = '';
    document.getElementById('numeroIdentificacionFact').value = pedido.RUC;
    document.getElementById('nombreFact').value = pedido.NOMBRE_CLIENTE;
    document.getElementById('emailFact').value = email;
    document.getElementById('telefonoFact').value = pedido.TELEFONO;
    document.getElementById('noPedidoFact').value = pedido.NO_PEDIDO;
    document.getElementById('referenceFact').value = pedido.VENDEDOR;
    document.getElementById('unicoFact').value = pedido.UNICO;
    document.getElementById('subTotalPagarFact').value = pedido.SUBTOTAL;
    document.getElementById('impuestoFact').value = pedido.IMPUESTO;
    document.getElementById('totalPagarFact').value = pedido.TOTAL;
    totalPagarLabel.textContent = '$ ' + pedido.TOTAL;
    // obtenerDetallePedido(pedido.NO_PEDIDO);
}

function procesoPagoPayPhone() {
    let documentId = noPedidoFact.value;
    let subtotal = subTotalPagarFact.value;
    let impuesto = impuestoFact.value;
    let valorPagar = totalPagarFact.value;
    let identificadorUnico = generarIdentificadorUnico();
    let transactionId = unicoFact.value;
    let reference = referenceFact.value;
    subtotal = Math.round(subtotal*100);
    impuesto = Math.round(impuesto*100);
    valorPagar = Math.round(valorPagar*100);
    let parametros = {
        amountWithoutTax: valorPagar,
        amount: valorPagar,
        currency: "USD",
        clientTransactionId: transactionId + identificadorUnico,
        reference: reference,
        documentId: documentId,
        responseUrl: "https://pagodigital.zcmayoristas.com/response",
        cancellationUrl: "https://pagodigital.zcmayoristas.com/response"
    };

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

async function processDatafast(pedido, items) {
    showLoader();
    let primerNombre = nombreFact.value;
    let segundoNomnre = nombreFact.value;
    let apellido = nombreFact.value;
    let mail = emailFact.value;
    let nui = numeroIdentificacionFact.value;
    let telefono = telefonoFact.value;
    let direccion = direccionFact.value;
    let transactionId = unicoFact.value;
    let documentId = noPedidoFact.value;
    let subtotal = subTotalPagarFact.value;
    let impuesto = impuestoFact.value;

    let data = {
        amount: pedido.TOTAL,
        primer_nombre: primerNombre,
        segundo_nombre: segundoNomnre,
        apellido: apellido,
        email: mail,
        cedula: nui,
        telefono: telefono,
        direccion_entrega: direccion,
        trx: transactionId,
        merchantCustomerId: documentId,
        baseImp: subtotal,
        valorIva: impuesto,
        items: items
    };
    
    const url = '/process-payment-datafast';
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        });
        if (!response.ok) {
            throw new Error('La repuesta de la red no fue correcta.');
        }
        const responseData = await response.json();
        hideLoader();
        // console.log(responseData);
        datafastForm(responseData);
    } catch (error) {
        hideLoader();
        console.error('Error:', error);
    }

}

function datafastForm(responseData) {
    const datafastPaymentForm = document.querySelector('.datafastPayment-form');
    const checkoutIdDatafast = responseData.id;
    
    const scriptElement = document.createElement('script');
    scriptElement.src = `https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId=${checkoutIdDatafast}`;

    const formElement = document.createElement('form'); 
    formElement.action = `${urlBase}/v1/checkouts`;
    formElement.classList.add('paymentWidgets'); 
    formElement.dataset.brands = 'VISA MASTER DINERS DISCOVER AMEX';

    datafastPaymentForm.innerHTML = '';
    datafastPaymentForm.appendChild(scriptElement);
    datafastPaymentForm.appendChild(formElement);

    validateFieldsFact();
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
                        <p class="fs-sm mb-4 text-white">Comunicate con tú vendedor.</p>
                        <a class="btn btn-lg button-33 banner-button d-none" href="https://zcmayoristas.com/zcwebstore/">Compra ahora</a>
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

function validateFieldsFact() {
    let allValid = true;
    const datafastForm = document.querySelector('.datafastPayment-form');
    requiredFields.forEach(field => {
        const feedback = field.nextElementSibling;
        if (!field.value.trim()) {
            field.classList.add('warning_input');
            feedback.style.display = 'block';
            allValid = false;
        } else {
            field.classList.remove('warning_input');
            feedback.style.display = 'none';
        }
    });
    // submitButton.disabled = !allValid;
    datafastForm.style.pointerEvents = allValid ? 'auto' : 'none';
}

requiredFields.forEach(field => {
    field.addEventListener('input', validateFieldsFact);
});



async function logoutSAPLayer() {
    showLoader();
    const url = '/logout-sap';
    try {
        const response = await fetch(url, {
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
        window.location.reload();
    } catch (error) {
        console.error(error.message);
    }
}