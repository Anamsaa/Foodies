// const expresiones = {
//     nombre: /(^[a-zA-ZÀ-ÿ]{1,30}$)/,
//     apellido: /(^[a-zA-ZÀ-ÿ]{1,30}$)/,
//     correo: /(^[a-zA-Z][a-zA-Z0-9.-_]+@[a-zA-Z0-9.-_]+\.[a-zA-Z0-9]{2,6}$)/, 
//     telefono: /(^[\d\s+\-]{7,}$)/, 
// }

// document.addEventListener('DOMContentLoaded', () => {

// console.log('entra a las comprobaciones')

//     // Formulario Evento culinario 
//     const formEvento = document.getElementById('form-crear-evento'); 
//     pasarFormulario(formEvento);
//     const titulo = document.getElementById('evento-title');
//     pasarEvento(titulo, validarTitulo);
//     const cupos = document.getElementById('cupos-participacion'); 
//     pasarEvento(cupos, validarCuposMaximos);
//     const restauranteSelect = document.getElementById('restaurant-option'); 
//     pasarEvento(restauranteSelect, validarRestaurante);

// })

// // Evitar el comportamiento por defecto del formulario
// function pasarFormulario(formulario) {
//     formulario.addEventListener('submit', function(e) {
//     e.preventDefault();
//     })
// }

// // Eventos necesarios para la comprobación
// function pasarEvento(campo, funcion) {
//     campo.addEventListener('input', funcion); 
//     campo.addEventListener('blur', funcion); 
// }

// // Estilo de errores 
// function mostrarError(campo, mensaje) {
//     eliminarError(campo); 
//     const error = document.createElement('div');
//     error.className = 'error'; 
//     error.style.color = 'red';
//     error.style.fontSize = '14px';
//     error.textContent = mensaje; 
//     campo.insertAdjacentElement('afterend', error); 
// }

// // Borrar errores 
// function eliminarError(campo) {
//     const error = campo.nextElementSibling; 
//     if (error && error.classList.contains('error')) {
//         error.remove();
//     }
// }

// // Estilo advice
// function mostrarAdvice(campo, mensaje) {
     
//     const next = campo.nextElementSibling;
//     if (next && next.classList.contains('advice')) {
//         eliminarAdvice(campo);
//     };


//     const advice = document.createElement('div');
//     advice.className = 'advice'; 
//     advice.style.color = 'black';
//     advice.style.fontSize = '14px';
//     advice.textContent = mensaje; 
//     campo.insertAdjacentElement('afterend', advice);
// }

// // Borrar errores 
// function eliminarAdvice(campo) {
//     const advice = campo.nextElementSibling; 
//     if (advice && advice.classList.contains('advice')) {
//         advice.remove();
//     }
// }


// // ------------------ Formulario Evento culinario 
// // TITULO
// function validarTitulo() {
//    const titulo = document.getElementById('evento-title');
//    const valor = titulo.value.trim(); 
//    console.log(valor); 

//    if (valor === ''){
//         mostrarError(titulo, 'Este campo no puede estar vacío'); 
//    } else {
//         eliminarError(titulo);
//    }
// }

// // CUPOS MÁXIMOS
// function validarCuposMaximos() {
//     const cupos = document.getElementById('cupos-participacion'); 
//     const valor = cupos.value; 
//     console.log(valor)

//     if (isNaN(valor) || valor === '') {
//         mostrarError(cupos, 'Por favor ponga un número válido.'); 
//     } else {
//         eliminarError(cupos);
//     }
    
//     if (parseInt(valor) > 6) {
//         mostrarAdvice(cupos, 'Comúnicate con el establecimiento para confirmar la capacidad.')
//     } else {
//         eliminarAdvice(cupos);  
//     }
   
// }

// // HORA DE ENCUENTRO

// // FECHA DE ENCUENTRO

// // RESTAURANTE 
// function validarRestaurante() {
//     const restauranteSelect = document.getElementById('restaurant-option'); 
//     const valor = restauranteSelect.value; 

//     if (valor === ''){
//         mostrarError(restauranteSelect, 'Debe seleccionar un restaurante'); 
//         return false;
//     } else {
//         eliminarError(restauranteSelect);
//         return true;
//     }
// }

// // DESCRIPCIÓN DEL EVENTO 
// // -- Validar el número de palabras 



