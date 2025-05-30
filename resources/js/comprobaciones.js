
// Evitar el comportamiento por defecto del formulario
function pasarFormulario(formulario) {
    formulario.addEventListener('submit', function(e) {
    e.preventDefault();
    })
}

// Eventos necesarios para la comprobación
function pasarEvento(campo, funcion) {
    campo.addEventListener('input', funcion); 
    campo.addEventListener('blur', funcion); 
}

// Estilo de errores 
function mostrarError(campo, mensaje) {
    eliminarError(campo); 
    const error = document.createElement('div');
    error.className = 'error'; 
    error.style.color = 'red';
    error.style.fontSize = '14px';
    error.textContent = mensaje; 
    campo.insertAdjacentElement('afterend', error); 
}

// Borrar errores 
function eliminarError(campo) {
    const error = campo.nextElementSibling; 
    if (error && error.classList.contains('error')) {
        error.remove();
    }
}

// Estilo advice
function mostrarAdvice(campo, mensaje) {
     
    eliminarAdvice(campo);
    const advice = document.createElement('div');
    advice.className = 'advice'; 
    advice.style.color = 'black';
    advice.style.fontSize = '14px';
    advice.textContent = mensaje; 
    campo.insertAdjacentElement('afterend', advice);
}

// Borrar errores 
function eliminarAdvice(campo) {
    let next = campo.nextElementSibling;
    while (next && next.classList.contains('advice')) {
        const toRemove = next;
        next = next.nextElementSibling;
        toRemove.remove();
    }
}


// ------------------ Formulario Evento culinario 
// TITULO
function validarTitulo() {
   const titulo = document.getElementById('evento-title');
   const valor = titulo.value.trim(); 
   console.log(valor); 

   if (valor === ''){
        mostrarError(titulo, 'Este campo no puede estar vacío'); 
        return false;
   } else {
        eliminarError(titulo);
        return true;
   }
}

// CUPOS MÁXIMOS
function validarCuposMaximos() {
    const cupos = document.getElementById('cupos-participacion'); 
    const valor = cupos.value; 
    let valido = true;

    if (isNaN(valor) || valor === '') {
        mostrarError(cupos, 'Por favor ponga un número válido.'); 
        valido = false;
    } else {
        eliminarError(cupos);
    }
    
    if (parseInt(valor) > 6) {
        mostrarAdvice(cupos, 'Comúnicate con el establecimiento para confirmar la capacidad.')
    } else {
        eliminarAdvice(cupos);  
    }

    return valido;
   
}

// FECHA DE ENCUENTRO
// Verificar que sea válida después de hoy
const fechaInput = document.getElementById('fecha-encuentro');

if (fechaInput) {
    const hoy = new Date(); 
    const year = hoy.getFullYear(); 
    const mes = String(hoy.getMonth() + 1).padStart(2, '0'); 
    const dia = String(hoy.getDate()).padStart(2, '0');

    const fechaHoy = `${year}-${mes}-${dia}`;
    fechaInput.setAttribute('min', fechaHoy);
}

// RESTAURANTE - HORA DE ENCUENTRO
function validarRestaurante() {
    const restauranteSelect = document.getElementById('restaurant-option'); 
    const valor = restauranteSelect.value; 
    const campoHora = document.getElementById('hora-encuentro');

    eliminarAdvice(campoHora);

    if (valor === ''){
        mostrarError(restauranteSelect, 'Debe seleccionar un restaurante'); 
        return false;
    } else {
        eliminarError(restauranteSelect);
        eliminarAdvice(campoHora);

        fetch(`/api/restaurantes/${valor}/horarios`)
            .then(response => response.json())
            .then(data => {
                if (data.error) return;

                if (data.horarios && data.horarios.trim() !== '') {
                    mostrarAdvice(campoHora, `Es importante que recuerdes que: ${data.horarios}`);
                }
            })
            .catch(err => {
                console.error('Error al obtener horarios:', err);
            });
        return true;
    }
}

// DESCRIPCIÓN DEL EVENTO 
// -- Validar el número de palabras 
function validarDescripcionEvento() {
    const textarea = document.getElementById('invitacion');
    const valor = textarea.value.trim(); 

    const palabras = valor.split(/\s+/).filter(p => p !== ''); 
    const numPalabras = palabras.length; 

    const minPalabras = 10; 
    const maxPalabras = 25;
    
    if (numPalabras < minPalabras) {
        mostrarError(textarea,`La descripción debe tener al menos ${minPalabras} palabras. Actualmente tiene ${numPalabras}.`)
        return false;
    }

    if (numPalabras > maxPalabras) {
        mostrarError(textarea, `La descripción no debe exceder ${maxPalabras} palabras. Actualmente tiene ${numPalabras}.`);
        return false;
    }

    eliminarError(textarea); 
    return true;
}

// Validación de disponibilidad 

async function validarDisponibilidad() {
    //console.log('entra la validación de disponibilidad');
    const fecha = document.getElementById('fecha-encuentro').value;
    const hora = document.getElementById('hora-encuentro').value;
    const restaurantId = document.getElementById('restaurant-option').value;
    const campoHora = document.getElementById('hora-encuentro');

    //console.log(restaurantId);

    if (fecha && hora && restaurantId) {
        eliminarAdvice(campoHora);
        eliminarError(campoHora);

        try {
            const res = await  fetch(`/api/verificar-evento?fecha=${fecha}&hora=${hora}&restaurante_id=${restaurantId}`);
            const data = await res.json(); 

            if (!data.disponible) { 
                mostrarError(campoHora, 'Ya hay un evento registrado en este restaurante a esa hora.');
                return false;
            } else {
                eliminarError(campoHora);
                return true;
            }

        } catch (error) {
            console.error('Error al verificar disponibilidad:', error);
            return true; 

        }
    }
}

document.addEventListener('DOMContentLoaded', () => {

console.log('entra a las comprobaciones')

    // Formulario Evento culinario 
    const formEvento = document.getElementById('form-crear-evento'); 

    const titulo = document.getElementById('evento-title');
    const cupos = document.getElementById('cupos-participacion');
    const restauranteSelect = document.getElementById('restaurant-option');
    const horaEncuentro = document.getElementById('hora-encuentro');
    const fechaEncuentro = document.getElementById('fecha-encuentro');
    const textarea = document.getElementById('invitacion');

    pasarEvento(titulo, validarTitulo);
    pasarEvento(cupos, validarCuposMaximos);
    pasarEvento(restauranteSelect, validarRestaurante);
    pasarEvento(textarea, validarDescripcionEvento);
    
     restauranteSelect.addEventListener('change', () => {
        validarRestaurante();
        validarDisponibilidad();
    });

    horaEncuentro.addEventListener('blur', validarDisponibilidad);
    fechaEncuentro.addEventListener('blur', validarDisponibilidad);

    formEvento.addEventListener('submit', async (e) => {
        e.preventDefault();

        const esTituloValido = validarTitulo();
        const esCuposValido = validarCuposMaximos();
        const esDescripcionValida = validarDescripcionEvento();
        const esRestauranteValido = validarRestaurante();
        const esDisponible = await validarDisponibilidad();

        if (esTituloValido && esCuposValido && esDescripcionValida && esRestauranteValido && esDisponible) {
            formEvento.submit(); 
        } else {
            console.warn('El formulario tiene errores y no se enviará.');
        }
    });

})
