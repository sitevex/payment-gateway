let _nextStep = false; // Declarar _nextStep como variable global
let isValid = true;
let errorMessage = "";
let header = document.getElementById('header');
header.style.display = 'none';

// ------------------ Login ------------------
document.querySelector("#btnGetInto").addEventListener('click', async function (event) {
    let rucInput = document.getElementById('numeroIdentificacion').value.trim();
    event.preventDefault();
    let isValid = true;
    let errorMessage = "";

    if (rucInput === '') {
        mostrarMensajeModal('Campo requerido', 'Por favor, ingresa tu número de identificación (RUC).');
        isValid = false;
        errorMessage = 'Por favor, ingresa tu número de identificación (RUC).';
    }

    else if (!(/^\d+$/.test(rucInput))) {
        mostrarMensajeModal('Formato Incorrecto', 'El número de identificación debe contener solo números.');
        isValid =  false;
        errorMessage = 'El número de identificación debe contener solo números';
    }

    else if (!validarRuc(rucInput)) {
        mostrarMensajeModal('RUC Incorrecto', 'El número de identificación (RUC) ingresado es inválido.');
        isValid = false;
        errorMessage = 'El número de identificación (RUC) ingresado es inválido.';
    }

    if (!isValid) {
        console.log(isValid);
        let errorDiv = document.getElementById('numeroIdentificacion').closest('.col-md-12').querySelector('.invalid-feedback');
        errorDiv.textContent = errorMessage;
        errorDiv.style.display = 'block';
        return;
    }
    _nextStep = true; // Solo si todas las validaciones pasan
    
});

// ------------------ MUlti step ------------------ 
const multiStepForm = document.querySelector("[data-multi-step]");
const formSteps  = [...multiStepForm.querySelectorAll("[data-step]")]

let currentStep = formSteps.findIndex(step =>{
    return step.classList.contains("active")
    // console.log(step.classList.contains("active"))
});

if (currentStep < 0){
    currentStep = 0
    // showCurrentStep()
    // formSteps[currentStep].classList.add ("active")
    // console.log('r' +currentStep);
    // updateProgressbar()
    console.log('hola mundo');
}

multiStepForm.addEventListener("click", e =>{
    let incrementor;
    if(e.target.matches("[data-next]")){
        incrementor = 1
    }
    else if(e.target.matches("[data-previous]")){
        incrementor = -1
    }
    if(incrementor == null) return
    const inputs = [...formSteps[currentStep].querySelectorAll("input")]
    const allValid = inputs.every(input=>input.reportValidity())
    console.log(allValid);
    // no lee esta variable
    _nextStep
    console.log('Valor de nextStep: ' +_nextStep);
    if(allValid && _nextStep){
        console.log('Validar los inputs: ' +allValid);
        currentStep +=incrementor
        console.log('currentStep: ' +currentStep);
        // updateProgressbar()
    }
    doActionStep(currentStep);
    console.log('Incremento: ' +incrementor);
    showCurrentStep()
    // updateProgressbar()
    
});

formSteps.forEach(step =>{
    step.addEventListener("animationend", (e) =>{
        // remove hide una vez completado la info
        formSteps[currentStep].classList.remove("hide")
        // console.log('datos selecionado y completado');

        // agrega y quita el hide[adelante] cuando click data-previous atras linea clave 
        e.target.classList.toggle("hide", e.target.classList.contains("active"))
    })
});

// hide and show the current step by toggleing the class "active"
function showCurrentStep(){
    formSteps.forEach((step,index) =>{
        // console.log('------------------------------ data-step -----------------------------------');
        // console.log('data-step' +step);
        step.classList.toggle ("active", index===currentStep)
        // console.log('Index ' +index);

        // navItemSteps.classList.toggle ("active", index===currentStep)
        // navItemSteps[currentStep].classList.add("active");

        if (index === currentStep){
            // click btn con data-next
            step.classList.remove("hide")
            // console.log('click btn data-next');
        }

        // if (index != currentStep) {
        //     navItemSteps[currentStep].classList.remove("active");
        // }
    });
}

function doActionStep(currentStep) {
    switch (currentStep) {
        case 1:
            console.log('Tipo y numero de indetificacion fuero ingresado....');
            obtenerUsuario();
            console.log('Obtener todas las especialidades....');
            // obtenerEspecialidad();
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
async function obtenerUsuario() {
    showLoader();
    console.log('usuario');
    let userNameNavbar = document.getElementById('user-name-navbar');
    let rucInput = document.getElementById('numeroIdentificacion').value.trim();
    // Aquí puedes enviar el formulario si todo está correcto
    const url = `/businessPartnerstwo?ruc=${rucInput}`;

    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        hideLoader();
        
        if (data.value.length === 0) {
            header.style.display = 'none';
            // Si no hay datos, mostrar mensaje y evitar avanzar
            mostrarMensajeModal('Información no encontrada', 'No se encuentra información del usuario.');
            return;
        }
        header.style.display = 'block';
        console.log(data); // Aquí puedes hacer algo con los datos, como mostrarlos en la página
        userNameNavbar.textContent = data.value[0].CardName;
        // Si hay datos, permitir avanzar al siguiente 'step'
        // _nextStep = true;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

