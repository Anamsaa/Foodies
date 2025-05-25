 document.addEventListener('DOMContentLoaded', () => {
    
    //?console.log('pasa por aquí');
    // Subir imágenes en publicaciones
    document.getElementById('imagen-post-regular').addEventListener('change', function(e) {
        const contenido = e.target.files[0]?.name || "Haz click para seleccionar una imagen";
        console.log(contenido);
        document.getElementById('file-label-text').textContent = contenido;
    });  
});