let formularioReservas = document.getElementById("formReservaServicio");

function reservarServicio(source ,valor) {
    let inputId = document.getElementById("idServicioReserva");
    inputId.value = source.id;
    let inputNombre = document.getElementById("servicioReserva");
    inputNombre.value = valor;

    let btn = document.getElementById("btnReservarReserva");

    let requeridos = formularioReservas.querySelectorAll("[required]");

    if (source.id !== null && valor !== null) {
        btn.classList.remove("disabled");
        requeridos.forEach((campo) => campo.disabled = false);
    } else {
        btn.classList.add("disabled");
        requeridos.forEach((campo) => campo.disabled = true);
    }
}