document.addEventListener('DOMContentLoaded', () => {

    // Selección de imágenes para subir en publicaciones
    const inputImagen = document.getElementById('imagen-post-regular');
    const labelTexto = document.getElementById('file-label-text');

    // Comprobar si las variables existen para que no lance error la consola.
    if (inputImagen && labelTexto) {
        inputImagen.addEventListener('change', function (e) {
            const contenido = e.target.files[0]?.name || "Haz click para seleccionar una imagen";
            labelTexto.textContent = contenido;
        });
    }

    // Lógica de funcionamiento botón de seguimiento 
    document.querySelectorAll('.btn-like').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.dataset.postId;
            const liked = this.dataset.liked === 'true';
            const token = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/post/${postId}/like`, {
                method: liked ? 'DELETE' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.likes_count !== undefined) {
                    this.dataset.liked = (!liked).toString();
                    this.querySelector('i').classList.toggle('liked');
                    this.querySelector('.like-count').textContent = data.likes_count;
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Ocurrió un error al procesar el like');
            });
        });
    });
});
