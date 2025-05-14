import './bootstrap';
import './elements/turbo-echo-stream-tag';
import './libs';
// import * as Turbo from '@hotwired/turbo';
// window.Turbo = Turbo;
// Turbo.start();

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {

    dragAndDrop("drop-area","imagen-perfil");
    const btnHamburguesa = document.getElementById('boton-hamburguesa');
    console.log(btnHamburguesa);
    const sidebar = document.querySelector('.sidebar');

    if (btnHamburguesa && sidebar) {
        btnHamburguesa.addEventListener('click', () => {
            sidebar.classList.toggle('visible');
        });
    }
    
});

// Drag & Drop Formularios 

function dragAndDrop(dropAreaId, inputFileId) {
    const dropArea = document.getElementById(dropAreaId);
    const inputFile = document.getElementById(inputFileId);

    // Si no existe ninguno, se sale de la función
    if (!dropArea || !inputFile) return;

    // Guardamos el contenido original para restaurarlo si se elimina la imagen
    const originalContent = dropArea.innerHTML;

    // Crear botón eliminar
    const deleteBtn = document.createElement("button");
    deleteBtn.textContent = "X";
    deleteBtn.type = "button";
    deleteBtn.style.position = "absolute";
    deleteBtn.style.top = "5px";
    deleteBtn.style.right = "5px";
    deleteBtn.style.borderRadius = "30px";
    deleteBtn.style.padding = "5px 8px";
    deleteBtn.style.backgroundColor = "#4e515a";
    deleteBtn.style.color = "white";
    deleteBtn.style.border = "none";
    deleteBtn.style.cursor = "pointer";
    deleteBtn.style.zIndex = "10";

    // Restaurar contenido original
    function restoreOriginal() {
        dropArea.style.backgroundImage = "";
        dropArea.innerHTML = originalContent;
        dropArea.classList.remove("highlight");
        inputFile.value = "";
        attachEvents(); // Volver a enlazar eventos tras restaurar
    }

    // Mostrar la imagen
    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            dropArea.style.backgroundImage = `url(${e.target.result})`;
            dropArea.style.backgroundSize = "cover";
            dropArea.style.position = "relative";
            dropArea.style.backgroundPosition = "center";
            dropArea.style.backgroundRepeat = "no-repeat";
            dropArea.innerHTML = ""; // Limpiar contenido anterior
            dropArea.appendChild(deleteBtn); // Agregar botón eliminar
        };
        reader.readAsDataURL(file);
    }

    // Eventos visuales de drag
    function attachEvents() {
        ['dragenter', 'dragover'].forEach(event => {
            dropArea.addEventListener(event, e => {
                e.preventDefault();
                dropArea.classList.add("highlight");
            });
        });

        ['dragleave', 'drop'].forEach(event => {
            dropArea.addEventListener(event, e => {
                e.preventDefault();
                dropArea.classList.remove("highlight");
            });
        });

        // Drop de imagen
        dropArea.addEventListener("drop", e => {
            e.preventDefault();
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith("image/")) {
                inputFile.files = e.dataTransfer.files;
                showPreview(file);
            }
        });

        // Click para seleccionar imagen
        dropArea.addEventListener("click", () => inputFile.click());
    }

    // Input de archivo manual
    inputFile.addEventListener("change", () => {
        const file = inputFile.files[0];
        if (file && file.type.startsWith("image/")) {
            showPreview(file);
        }
    });

    // Botón eliminar
    deleteBtn.addEventListener("click", e => {
         e.preventDefault();
        restoreOriginal()
    });

    // Iniciar eventos
    attachEvents();
}



document.addEventListener('DOMContentLoaded', function() {
    // Aquí va tu lógica de cargar provincias y ciudades
    const comunidadSelect = document.getElementById('comunidad-autonoma');
    const provinciaSelect = document.getElementById('provincia');
    const ciudadSelect = document.getElementById('ciudad');

    if (!comunidadSelect || !provinciaSelect || !ciudadSelect) return;

    comunidadSelect.addEventListener('change', function () {
        const regionId = this.value;
        console.log(regionId);

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
});


// Tipos de restaurantes 

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
    "Restaurante asiático (chino, japonés, coreano, tailandés, etc.)",
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