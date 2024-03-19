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