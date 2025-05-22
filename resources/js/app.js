// import './bootstrap';
// import './elements/turbo-echo-stream-tag';
// import './libs';
// import * as Turbo from '@hotwired/turbo';
// window.Turbo = Turbo;
// Turbo.start();



import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();



import './perfil';

document.addEventListener('DOMContentLoaded', () => {
    console.log('entra a la función');
    incializarMenuLanding();
    const btnHamburguesa = document.getElementById('boton-hamburguesa');
    console.log(btnHamburguesa);
    const sidebar = document.querySelector('.sidebar');

    if (btnHamburguesa && sidebar) {
        btnHamburguesa.addEventListener('click', () => {
            sidebar.classList.toggle('visible');
        });
    }
    
    // Cargar tipos de restaurantes en formulario de creación de perfil
    const tiposDeRestaurantes = [
        "Restaurante de comida rápida",
        "Restaurante casual",
        "Restaurante de lujo",
        "Buffet",
        "Bistro",
        "Brasserie",
        "Cafetería",
        "Diner americano",
        "Restaurante temático",
        "Steakhouse",
        "Restaurante vegetariano/vegano",
        "Restaurante gourmet",
        "Restaurante de alta cocina",
        "Trattoria (italiano)",
        "Restaurante asiático",
        "Restaurante mexicano",
        "Restaurante mediterráneo",
        "Restaurante fusión",
        "Restaurante de tapas",
        "Restaurante de mariscos",
        "Churrasquería",
        "Restaurante de cocina molecular",
        "Restaurante de barbacoa",
        "Gastropub",
        "Restaurante de sushi",
        "Restaurante de comida casera",
        "Food truck",
        "Restaurante de comida saludable",
        "Restaurante buffet libre",
        "Restaurante de autoservicio",
        "Restaurante familiar",
        "Restaurante de cocina experimental",
        "Restaurante con espectáculo",
        "Restaurante de cocina regional",
        "Cervezería con restaurante",
        "Restaurante de desayuno y brunch"
    ];

    const tipoSelect = document.getElementById('tipo-restaurante');

    if(!tipoSelect) return; 

    tiposDeRestaurantes.forEach(tipo => {
        const option = document.createElement('option');
        option.value = tipo; 
        option.textContent = tipo; 
        tipoSelect.appendChild(option);
    })

    const valorElegido = tipoSelect.getAttribute('data-old-value');
    if (valorElegido) {
        tipoSelect.value = valorElegido;
    }

    // Inicialización de carga de foto de perfil y portada en formularios
    const inputPerfil = document.getElementById('imagen-perfil');
    if (inputPerfil) {
        inputPerfil.addEventListener('change', function () {
            mostrarPreview(this, 'box-perfil', 'preview-perfil');
        });
    }

    const inputPortada = document.getElementById('imagen-portada');
    if (inputPortada) {
        inputPortada.addEventListener('change', function () {
            mostrarPreview(this, 'box-portada', 'preview-portada');
        });
    }

});

function incializarMenuLanding() {
    // Menu lateral del landing 
    const hamburguesaLanding = document.getElementById("boton-hamburguesa-landing");
    const botonCerrarLanding = document.getElementById("boton-cerrar-landing"); 
    const menuLateralLanding = document.getElementById("menu-lateral-landing");

    if (hamburguesaLanding && botonCerrarLanding && menuLateralLanding) {
        hamburguesaLanding.addEventListener('click', () => {
            //console.log('Doy click');
            menuLateralLanding.classList.remove("oculto");
            menuLateralLanding.classList.add("visible");
        });

        botonCerrarLanding.addEventListener('click', () => {
            menuLateralLanding.classList.remove("visible");
            menuLateralLanding.classList.add("oculto");
        });
        //console.log('Entra a la función');
    }  
}

// function mostrarPreview(input, contenedorId, previewId) {
//     const file = input.files[0];
//     const contenedor = document.getElementById(contenedorId);

//     if(!file || !contenedor) return; 

//     const lector = new FileReader(); 
//     lector.onload = function (e) {
//         const previewDiv = document.createElement('div'); 
//         previewDiv.className = 'preview-imagen';
//         previewDiv.id = previewId;

//         const img = document.createElement('img');
//         img.src = e.target.result;

//         const btn = document.createElement('button');
//         btn.type = 'button';
//         btn.className = 'btn-eliminar';
//         btn.textContent = 'X';
//         btn.onclick = function (event) {
//             // Detener el comportamiento por defecto del input 
//             event.preventDefault();
//             eliminarImagen(input.id, contenedorId, previewId);
//         };

//         previewDiv.appendChild(img);
//         previewDiv.appendChild(btn);

//         // Limpiar y agregar
//         contenedor.innerHTML = '';
//         contenedor.appendChild(previewDiv);
//     };

//     lector.readAsDataURL(file);
// }

// function eliminarImagen(inputId, contenedorId, previewId) {
//     const contenedor = document.getElementById(contenedorId);

//     // Recrear manualmente todo el HTML original
//     const nuevoLabel = document.createElement('label');
//     nuevoLabel.setAttribute('for', inputId);
//     nuevoLabel.className = 'upload-box';
//     nuevoLabel.id = contenedorId;

//     nuevoLabel.innerHTML = `
//         <i class="fa-solid fa-plus"></i>
//         <span>Haz click para seleccionar una imagen</span>
//     `;

//     const nuevoInput = document.createElement('input');
//     nuevoInput.type = 'file';
//     nuevoInput.name = inputId.replace('imagen-', 'imagen-'); // usa mismo nombre
//     nuevoInput.id = inputId;
//     nuevoInput.accept = '.jpg, .jpeg, .png, .webp';

//     // Adjuntar evento para volver a mostrar preview
//     nuevoInput.addEventListener('change', function () {
//         mostrarPreview(this, contenedorId, previewId);
//     });

//     nuevoLabel.appendChild(nuevoInput);
//     contenedor.innerHTML = ''; // limpiar el contenedor
//     contenedor.appendChild(nuevoLabel);
// }



//Cargar datos de ubicación 

// document.addEventListener('DOMContentLoaded', function () {
//     const comunidadSelect = document.getElementById('comunidad-autonoma');
//     const provinciaSelect = document.getElementById('provincia');
//     const ciudadSelect = document.getElementById('ciudad');

//     if (!comunidadSelect || !provinciaSelect || !ciudadSelect) return;

//     const comunidadSelected = comunidadSelect.dataset.selected;
//     const provinciaSelected = provinciaSelect.dataset.selected;
//     const ciudadSelected = ciudadSelect.dataset.selected;

//     // Lógica de carga de provincias
//     if (comunidadSelected) {
//         comunidadSelect.value = comunidadSelected;

//         fetch(`/api/provinces/${comunidadSelected}`)
//             .then(res => res.json())
//             .then(provinces => {
//                 provinciaSelect.innerHTML = '<option value="">Seleccione su Provincia</option>';
//                 provinces.forEach(province => {
//                     const option = document.createElement('option');
//                     option.value = province.id;
//                     option.textContent = province.nombre;
//                     provinciaSelect.appendChild(option);
//                 });

//                 if (provinciaSelected) {
//                     provinciaSelect.value = provinciaSelected;

//                     fetch(`/api/cities/${provinciaSelected}`)
//                         .then(res => res.json())
//                         .then(cities => {
//                             ciudadSelect.innerHTML = '<option value="">Seleccione su Ciudad</option>';
//                             cities.forEach(city => {
//                                 const option = document.createElement('option');
//                                 option.value = city.id;
//                                 option.textContent = city.nombre;
//                                 ciudadSelect.appendChild(option);
//                             });

//                             if (ciudadSelected) {
//                                 ciudadSelect.value = ciudadSelected;
//                             }
//                         });
//                 }
//             });
//     }

//     // Eventos para cambios manuales
//     comunidadSelect.addEventListener('change', function () {
//         const regionId = this.value;
//         provinciaSelect.innerHTML = '<option value=""></option>';
//         ciudadSelect.innerHTML = '<option value=""></option>';

//         if (!regionId) return;

//         fetch(`/api/provinces/${regionId}`)
//             .then(res => res.json())
//             .then(provinces => {
//                 provinces.forEach(province => {
//                     const option = document.createElement('option');
//                     option.value = province.id;
//                     option.textContent = province.nombre;
//                     provinciaSelect.appendChild(option);
//                 });
//             });
//     });

//     provinciaSelect.addEventListener('change', function () {
//         const provinceId = this.value;
//         ciudadSelect.innerHTML = '<option value=""></option>';

//         if (!provinceId) return;

//         fetch(`/api/cities/${provinceId}`)
//             .then(res => res.json())
//             .then(cities => {
//                 cities.forEach(city => {
//                     const option = document.createElement('option');
//                     option.value = city.id;
//                     option.textContent = city.nombre;
//                     ciudadSelect.appendChild(option);
//                 });
//             });
//     });
// });



document.addEventListener('DOMContentLoaded', function() {
    
    const comunidadSelect = document.getElementById('comunidad-autonoma');
    //console.log(comunidadSelect);
    const provinciaSelect = document.getElementById('provincia');
    const ciudadSelect = document.getElementById('ciudad');

    if (!comunidadSelect || !provinciaSelect || !ciudadSelect) return;

    comunidadSelect.addEventListener('change', function () {
        const regionId = this.value;
        //console.log(regionId);

        provinciaSelect.innerHTML = '<option value=""></option>';
        ciudadSelect.innerHTML = '<option value=""></option>';

        if (!regionId) return;

        fetch(`/api/provinces/${regionId}`)
            .then(res => res.json())
            .then(provinces => {
                console.log(provinces);
                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.id;
                    option.textContent = province.nombre;
                    provinciaSelect.appendChild(option);
                });
            });
    });

    provinciaSelect.addEventListener('change', function () {
        const provinceId = this.value;
        ciudadSelect.innerHTML = '<option value=""></option>';

        if (!provinceId) return;

        fetch(`/api/cities/${provinceId}`)
            .then(res => res.json())
            .then(cities => {
                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.id;
                    option.textContent = city.nombre;
                    ciudadSelect.appendChild(option);
            });
        });
    });


    // Persistencia de datos en formularios 
    if (comunidadSelect.dataset.selected) {
        comunidadSelect.value = comunidadSelect.dataset.selected;
        const regionId = comunidadSelect.value;

        fetch(`/api/provinces/${regionId}`)
            .then(res => res.json())
            .then(provinces => {
                provinciaSelect.innerHTML = '<option value="">Seleccione su Provincia</option>';
                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.id;
                    option.textContent = province.nombre;
                    provinciaSelect.appendChild(option);
                });

                if (provinciaSelect.dataset.selected) {
                    provinciaSelect.value = provinciaSelect.dataset.selected;
                    fetch(`/api/cities/${provinciaSelect.value}`)
                        .then(res => res.json())
                        .then(cities => {
                            ciudadSelect.innerHTML = '<option value="">Seleccione su Ciudad</option>';
                            cities.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.id;
                                option.textContent = city.nombre;
                                ciudadSelect.appendChild(option);
                            });
                            if (ciudadSelect.dataset.selected) {
                                ciudadSelect.value = ciudadSelect.dataset.selected;
                            }
                        });
                }
            });
    }
});

