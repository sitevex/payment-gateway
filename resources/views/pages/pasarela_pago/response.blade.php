@extends('layouts.zc_app')
@section('title','Pago Digital')
@section('content')
<div class="row">
    <section class="bg-white">
        <div class="row mb-3">
            <div class="col-12">
                <h2 class="fw-bold text-blue-dark text-center">Transacción aprobada exitosamente.</h2>
                <p>valor de 'storeName'</p>
                <p>numero de 'document'</p>
                <!-- los otro valores -->
            </div>
            <div class="col-12">
                <h2 class="fw-bold text-blue-dark text-center">The transaction does not exist, verify that the submitted ID is correct.</h2>
            </div>
        </div>
    </section>
</div>
@endsection
<script>
    // Función para enviar la solicitud a la API de PayPhone en segundo plano
    window.addEventListener('load', function () {
        let responseData = {!! json_encode($response) !!};
        let data = {
            // Datos que necesitas enviar a la API de PayPhone para Confirm
            id: responseData.id,
            clientTxId: responseData.clientTransactionId
        };
        // console.log(data);

        fetch('https://pay.payphonetodoesposible.com/api/button/V2/Confirm', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer oyDuDjdVeaFun4bXHuCcTuj4QDUCeduArGriIlgbNxOeURWpKP4e-K2XM0h9PXEQ7ktg0qAA7weVE_tFnoRG1vEZHm5-hsNjoBJqcqPjeXmWj1mOkFM5f7PeZx6aZ3fX5-9wrVMO1-LEvqCMzpvVwSyE0QfLap_chx7CnkoCBKNMep1sfZZ9waQVWMQkXDBAVHrm84_s1T2BySj29uXJohNnV38U1HMmrdH3swUXovpzQU4c_EF7qygUf8baIF-4ZJWRqARUjE63_IHmyXio5P744NwJLzL4SDf3fCYyfsHSYHZ72J4M16EwqONzwBSGC0IDYw'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(confirmacion => {
            if (confirmacion.statusCode === 2) {
                console.log("Transacción Cancelada: ", confirmacion.message);
            } else if (confirmacion.statusCode === 3) {
                console.log("Transacción Aprobada: ", confirmacion.authorizationCode);
            } else {
                console.log("Error: ", confirmacion.message);
            }
            console.log(confirmacion);
            let estado = confirmacion.transactionStatus;
            console.log(estado);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>