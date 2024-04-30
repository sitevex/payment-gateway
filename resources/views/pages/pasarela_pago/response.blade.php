@extends('layouts.zc_app')
@section('title','Pago Digital')
@section('content')
<div class="row justify-content-center mb-5">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card border-0 shadow-xs-zc">
            <div class="card-body p-4 px-lg-5 pt-lg-4 pb-lg-0">
                <div class="row g-3" id="contentDetalleTrans"></div>
                <div class="row g-3" id="contentError"></div>
            </div>
            <div class="card-footer bg-transparent border-0 pb-4 text-center">
                <a href="{{ route('index') }}" class="btn btn-lg btn-dark-zc">Voler a inicio</a>
                <a href="#!" class="btn btn-lg btn-dark-zc d-none">Imprimir</a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script-app')
<script>

    let responseData = {!! json_encode($response) !!};

    async function confirmarPayPhone(responseData) {
        showLoader();
        let data = {
            id: responseData.id,
            clientTxId: responseData.clientTransactionId
        };
        // console.log(data);
        try {
            const url = 'https://pay.payphonetodoesposible.com/api/button/V2/Confirm';
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer oyDuDjdVeaFun4bXHuCcTuj4QDUCeduArGriIlgbNxOeURWpKP4e-K2XM0h9PXEQ7ktg0qAA7weVE_tFnoRG1vEZHm5-hsNjoBJqcqPjeXmWj1mOkFM5f7PeZx6aZ3fX5-9wrVMO1-LEvqCMzpvVwSyE0QfLap_chx7CnkoCBKNMep1sfZZ9waQVWMQkXDBAVHrm84_s1T2BySj29uXJohNnV38U1HMmrdH3swUXovpzQU4c_EF7qygUf8baIF-4ZJWRqARUjE63_IHmyXio5P744NwJLzL4SDf3fCYyfsHSYHZ72J4M16EwqONzwBSGC0IDYw'
                },
                body: JSON.stringify(data)
            });
            const confirmacion = await response.json();
            procesarConfirmacion(confirmacion);
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function procesarConfirmacion(confirmacion) {
        const contentDetalleTrans = document.getElementById('contentDetalleTrans');
        const contentError = document.getElementById('contentError');
        contentDetalleTrans.innerHTML = '';
        contentError.innerHTML = '';
        hideLoader();
        console.log(confirmacion);
        if (confirmacion.statusCode === 2 || confirmacion.statusCode === 3) {
            contentError.hidden=true;
            mostrarDetalleTrans(confirmacion);
            await guardarTransacionPayPhone(confirmacion);
        } else {
            console.log("Error: ", confirmacion.message);
            contentError.hidden=false;
            let elemento = `
            <div class="col-12">
                <h2 class="fw-bold text-blue-dark text-center pt-4" id="message">${confirmacion.message}</h2>
            </div>
            `;
            contentError.innerHTML = elemento;
        }
    }

    function mostrarDetalleTrans(confirmacion) {
        const contentDetalleTrans = document.getElementById('contentDetalleTrans');
        let elemento;
        let mensaje = confirmacion.statusCode === 2 ? 'Tu banco canceló la transacción, por favor comunícate con tu banco.' : confirmacion.statusCode === 3 ? 'Transacción aprobada exitosamente.' : confirmacion.message;
        if (confirmacion.statusCode === 2 || confirmacion.statusCode === 3) {
            elemento = `
            <div class="col-12 col-md-6 text-start text-md-end order-md-2">
                <span class="badge text-bg-sail text-label-date">Fecha de Emisión</span>
                <p class="fs-xxs text-lg-end mx-2 mb-0" id="dateOfIssue">${confirmacion.date}</p>
            </div>
            <div class="col-12 col-md-6 order-md-1">
                <p class="fs-sm mb-0" id="transactionId">Comprobante Pago: <span class="fw-bold">${confirmacion.transactionId}</span></p>
                <p class="fs-sm mb-0" id="totalValue">Valor total: <span class="fw-bold">$${Math.round(confirmacion.amount * 100 )}</span></p>
                <p class="fs-sm mb-0" id="username">Cliente: <span class="fw-bold">${confirmacion.optionalParameter4}</span></p>
                <p class="fs-sm mb-0" id="email">Correo electrónico: <span class="fw-bold">${confirmacion.email}</span></p>
            </div>
            <div class="col-12 order-md-3">
                <h2 class="fw-bold text-blue-dark text-center" id="message">${mensaje}</h2>
            </div>
            `;
        } else {
            elemento = `
            <div class="col-12">
                <h2 class="fw-bold text-blue-dark text-center" id="message">${mensaje}</h2>
            </div>
            `;
        }
        contentDetalleTrans.innerHTML = elemento;
    }

    async function guardarTransacionPayPhone(confirmacion) {
        let data = {
            email: confirmacion.email,
            cardType: confirmacion.cardType,
            bin: confirmacion.bin,
            lastDigits: confirmacion.lastDigits,
            deferredCode: confirmacion.deferredCode,
            deferred: confirmacion.deferred,
            cardBrandCode: confirmacion.cardBrandCode,
            cardBrand: confirmacion.cardBrand,
            amount: confirmacion.amount,
            clientTransactionId: confirmacion.clientTransactionId,
            phoneNumber: confirmacion.phoneNumber,
            statusCode: confirmacion.statusCode,
            transactionStatus: confirmacion.transactionStatus,
            authorizationCode: confirmacion.authorizationCode,
            messageCode: confirmacion.messageCode,
            transactionId: confirmacion.transactionId,
            document: confirmacion.document,
            currency: confirmacion.currency,
            optionalParameter1: confirmacion.optionalParameter1,
            optionalParameter2: confirmacion.optionalParameter2,
            optionalParameter3: confirmacion.optionalParameter3,
            optionalParameter4: confirmacion.optionalParameter4,
            storeName: confirmacion.storeName,
            date: confirmacion.date,
            regionIso: confirmacion.regionIso,
            transactionType: confirmacion.transactionType,
            reference: confirmacion.reference,
            tipoPasarela: 'payphone'
        }
        try {
            const url = '/guardar-transaccion';
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            });
            const responseData = await response.json();
            console.log(responseData);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    confirmarPayPhone(responseData);
</script>
@endpush