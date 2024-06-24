@extends('layouts.zc_app')
@section('title','Comprobante')
@section('content')
    <div class="row justify-content-center mb-5">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card border-0 shadow-xs-zc">
                <div class="card-body p-4 px-lg-5 pt-lg-4 pb-lg-0">
                    @if(isset($transactionDetails))
                    <div class="row g-3" id="contentDetalleTrans">
                        <div class="col-12 col-md-6 text-start text-md-end order-md-2">
                            <span class="badge text-bg-sail text-label-date">Fecha de Emisión {{$transactionDetails.resultDetails.AcquirerTimestamp}}</span>
                            <p class="fs-xxs text-lg-end mx-2 mb-0" id="dateOfIssue"></p>
                        </div>
                        <div class="col-12 col-md-6 order-md-1">
                            <p class="fs-sm mb-0" id="transactionId">Comprobante Pago: <span class="fw-bold">{{$transactionDetails.customer.merchantCustomerId}}</span></p>
                            <p class="fs-sm mb-0" id="totalValue">Valor total: <span class="fw-bold">{{$transactionDetails.resultDetails.TotalAmount}}</span></p>
                            <p class="fs-sm mb-0" id="username">Cliente: <span class="fw-bold">{{$transactionDetails.customer.givenName}}</span></p>
                            <p class="fs-sm mb-0" id="email">Correo electrónico: <span class="fw-bold">{{$transactionDetails.customer.email}}</span></p>
                        </div>
                        <div class="col-12 order-md-3">
                            <h2 class="fw-bold text-blue-dark text-center" id="message"></h2>
                        </div>
                    </div>
                    @endif
                    @if(isset($error))
                    <div class="row g-3" id="contentError">{{ $error }}</div>
                    @endif
                    <input type="hidden" name="messageb1s" id="messageb1s" />
                </div>
                <div class="card-footer bg-transparent border-0 pb-4 text-center">
                    <a href="{{ route('index') }}" class="btn btn-lg btn-dark-zc">Voler a inicio</a>
                </div>
            </div>
        </div>
    </div>
    <pre>{{ json_encode($transactionDetails, JSON_PRETTY_PRINT) }}</pre>
@endsection
@push('script-app')
<script>
    let responseData = {!! json_encode($transactionDetails) !!};
    // console.log(responseData);

    async function registerTransConfirmB1S(responseData) {
        let messageb1s = document.getElementById('messageb1s');
        showLoader();
        let data = {
            email: responseData.customer.email,
            cardType: responseData.resultDetails.CardType,
            bin: responseData.card.bin,
            lastDigits: responseData.card.last4Digits,
            deferredCode: responseData.resultDetails.ReferenceNbr,
            deferred: '',
            cardBrandCode: '',
            cardBrand: responseData.paymentBrand,
            amount: responseData.amount,
            clientTransactionId: responseData.merchantTransactionId,
            phoneNumber: '',
            statusCode: responseData.resultDetails.RiskStatusCode,
            transactionStatus: responseData.resultDetails.ExtendedDescription,
            authorizationCode: responseData.resultDetails.AuthCode,
            messageCode: '',
            transactionId: responseData.customer.identificationDocId,
            document: responseData.customer.merchantCustomerId,
            currency: responseData.currency,
            optionalParameter1: '',
            optionalParameter2: responseData.resultDetails.BatchNo,
            optionalParameter3: responseData.card.givenName,
            optionalParameter4: responseData.card.holder,
            storeName: responseData.risk.parameters.USER_DATA2,
            date: responseData.timestamp,
            regionIso: '',
            transactionType: responseData.paymentType,
            reference: '',
            tipoPasarela: 'datafast'
        }
        try {
            const url = '/registro-confirmacion';
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            });
            if (!response.ok) {
                throw new Error('Error al procesar la transacción. Por favor, inténtelo de nuevo.');
            }
            const responseData = await response.json();
            console.log(responseData);
            if (responseData.error) {
                messageb1s.value = JSON.stringify({ code: responseData.error.code, value: responseData.error.message.value });
            } else {
                messageb1s.value = 'sin mensaje de sap';
            }
            hideLoader();
        } catch (error) {
            console.error('Error al enviar la solicitud:', error);
        }
    }
    
    async function registrarDatafast(responseData) {
        let messageb1s = document.getElementById('messageb1s');
        showLoader();
        let data = {
            email: responseData.customer.email,
            cardType: responseData.resultDetails.CardType,
            bin: responseData.card.bin,
            lastDigits: responseData.card.last4Digits,
            deferredCode: responseData.resultDetails.ReferenceNbr,
            deferred: '',
            cardBrandCode: '',
            cardBrand: responseData.paymentBrand,
            amount: responseData.amount,
            clientTransactionId: responseData.merchantTransactionId,
            phoneNumber: '',
            statusCode: responseData.resultDetails.RiskStatusCode,
            transactionStatus: responseData.resultDetails.ExtendedDescription,
            authorizationCode: responseData.resultDetails.RiskStatusCode,
            messageCode: '',
            transactionId: responseData.customer.identificationDocId,
            document: responseData.customer.merchantCustomerId,
            currency: responseData.currency,
            optionalParameter1: '',
            optionalParameter2: responseData.resultDetails.BatchNo,
            optionalParameter3: responseData.card.givenName,
            optionalParameter4: responseData.card.holder,
            storeName: responseData.risk.parameters.USER_DATA2,
            date: responseData.timestamp,
            regionIso: '',
            transactionType: responseData.paymentType,
            reference: '',
            codigoSap: messageb1s.value,
            tipoPasarela: 'datafast'
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
            hideLoader();
        } catch (error) {
            console.error('Error al enviar la solicitud:', error);
        }
    }

    registerTransConfirmB1S(responseData);
    registrarDatafast(responseData);
</script>
@endpush