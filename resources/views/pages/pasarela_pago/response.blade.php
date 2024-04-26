<script>
    // Función para enviar la solicitud a la API de PayPhone en segundo plano
    window.addEventListener('load', function () {
        let responseData = {!! json_encode($response) !!};
        let data = {
            // Datos que necesitas enviar a la API de PayPhone para Confirm
            id: responseData.id,
            clientTxId: responseData.clientTransactionId
        };
        console.log(data);
        // Realizar la solicitud a la API de PayPhone en segundo plano utilizando Fetch API o Axios
        fetch('https://pay.payphonetodoesposible.com/api/button/V2/Confirm', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer oyDuDjdVeaFun4bXHuCcTuj4QDUCeduArGriIlgbNxOeURWpKP4e-K2XM0h9PXEQ7ktg0qAA7weVE_tFnoRG1vEZHm5-hsNjoBJqcqPjeXmWj1mOkFM5f7PeZx6aZ3fX5-9wrVMO1-LEvqCMzpvVwSyE0QfLap_chx7CnkoCBKNMep1sfZZ9waQVWMQkXDBAVHrm84_s1T2BySj29uXJohNnV38U1HMmrdH3swUXovpzQU4c_EF7qygUf8baIF-4ZJWRqARUjE63_IHmyXio5P744NwJLzL4SDf3fCYyfsHSYHZ72J4M16EwqONzwBSGC0IDYw',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            // Manejar la respuesta de la API de PayPhone según sea necesario
            if (result.success) {
                console.log(result);
                console.log(result.success);
                // Obtener los datos del resultado para enviar a guarda en base de datos
            } else {
                // Mostrar un mensaje de error o realizar otra acción según sea necesario
                console.error('Error: ', result.message);
            }
        })
        .catch(error => {
            console.error('Error: ', error);
        });

        /* fetch('https://pay.payphonetodoesposible.com/api/button/V2/Confirm', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer oyDuDjdVeaFun4bXHuCcTuj4QDUCeduArGriIlgbNxOeURWpKP4e-K2XM0h9PXEQ7ktg0qAA7weVE_tFnoRG1vEZHm5-hsNjoBJqcqPjeXmWj1mOkFM5f7PeZx6aZ3fX5-9wrVMO1-LEvqCMzpvVwSyE0QfLap_chx7CnkoCBKNMep1sfZZ9waQVWMQkXDBAVHrm84_s1T2BySj29uXJohNnV38U1HMmrdH3swUXovpzQU4c_EF7qygUf8baIF-4ZJWRqARUjE63_IHmyXio5P744NwJLzL4SDf3fCYyfsHSYHZ72J4M16EwqONzwBSGC0IDYw'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(confirmacion => {
            console.log(confirmacion);
            let estado = confirmacion.transactionStatus;
            console.log(estado);
        })
        .catch(error => {
            console.error('Error:', error);
        }); */
    });
</script>