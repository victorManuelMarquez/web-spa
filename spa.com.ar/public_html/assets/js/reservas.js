let formulariosTabla = document.getElementById("tablaReservas").querySelector("tbody").querySelectorAll(":scope > *");

formulariosTabla.forEach((formulario) => {
    let checkboxes = formulario.querySelectorAll('input[type="checkbox"]');
    let botonSubmit = formulario.querySelector('button[type="submit"]');
    let botonReset = formulario.querySelector('button[type="reset"]');
    let hidden = formulario.querySelector('input[type="hidden"]');
    [...checkboxes].forEach((boton) => {
        boton.addEventListener("click", event => {
            [...checkboxes].forEach((checkbox) => {
                if (checkbox.id !== boton.id)
                    checkbox.checked = false;
            });
            botonSubmit.disabled = !event.target.checked;
            botonReset.disabled = false;
        });
    });
    botonReset.addEventListener("click", event => {
        botonSubmit.disabled = true;
    });
});