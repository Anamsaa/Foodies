import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


document.addEventListener('DOMContentLoaded', () => {

    dragAndDrop("drop-area","imagen-perfil");
    const btnHamburguesa = document.getElementById('boton-hamburguesa');
    console.log(btnHamburguesa);
    const sidebar = document.querySelector('.sidebar');

    btnHamburguesa.addEventListener('click', () => {
        sidebar.classList.toggle('visible');
    })
})

// Drag & Drop Formularios 

function dragAndDrop(dropAreaId, inputFileId) {
    const dropArea = document.getElementById(dropAreaId);
    const inputFile = document.getElementById(inputFileId);

    if (!dropArea || !inputFile) return;

    // Guardamos el contenido original para restaurarlo si se elimina la imagen
    const originalContent = dropArea.innerHTML;

    // Crear imagen de vista previa y botón eliminar
    const preview = document.createElement("img");
    preview.style.maxWidth = "100%";
    preview.style.maxHeight = "100%";
    preview.style.objectFit = "cover";
    preview.style.borderRadius = "10px";

    const deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Eliminar";
    deleteBtn.type = "button";
    deleteBtn.style.marginTop = "10px";
    deleteBtn.style.padding = "0.4rem 0.8rem";
    deleteBtn.style.backgroundColor = "#e74c3c";
    deleteBtn.style.color = "white";
    deleteBtn.style.border = "none";
    deleteBtn.style.borderRadius = "5px";
    deleteBtn.style.cursor = "pointer";

    // Restaurar contenido original
    function restoreOriginal() {
        dropArea.innerHTML = originalContent;
        dropArea.classList.remove("highlight");
        inputFile.value = "";
        attachEvents(); // volver a enlazar eventos tras restaurar
    }

    // Mostrar la imagen
    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            dropArea.innerHTML = ''; // limpiar contenido
            dropArea.appendChild(preview);
            dropArea.appendChild(deleteBtn);
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
    deleteBtn.addEventListener("click", restoreOriginal);

    // Iniciar eventos
    attachEvents();
}


// Carga de información en select Anidados 

document.addEventListener('DOMContentLoaded', function() {
        // Cargar provincias según la región seleccionada
        document.getElementById('pais').addEventListener('change', function() {
            var regionId = this.value;
            
            fetch(`/api/provinces/${regionId}`)
                .then(response => response.json())
                .then(provinces => {
                    var provinceSelect = document.getElementById('region');
                    provinceSelect.innerHTML = '<option value=""></option>'; // Limpiar opciones previas
                    provinces.forEach(province => {
                        var option = document.createElement('option');
                        option.value = province.id;
                        option.textContent = province.nombre;
                        provinceSelect.appendChild(option);
                    });
                });
        });

        // Cargar ciudades según la provincia seleccionada
        document.getElementById('region').addEventListener('change', function() {
            var provinceId = this.value;
            
            fetch(`/api/cities/${provinceId}`)
                .then(response => response.json())
                .then(cities => {
                    var citySelect = document.getElementById('ciudad');
                    citySelect.innerHTML = '<option value=""></option>'; // Limpiar opciones previas
                    cities.forEach(city => {
                        var option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.nombre;
                        citySelect.appendChild(option);
                    });
                });
        });
});