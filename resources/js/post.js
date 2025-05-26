 document.addEventListener('DOMContentLoaded', () => {
    
    //?console.log('pasa por aquí');
    // Subir imágenes en publicaciones
    document.getElementById('imagen-post-regular').addEventListener('change', function(e) {
        const contenido = e.target.files[0]?.name || "Haz click para seleccionar una imagen";
        //console.log(contenido);
        document.getElementById('file-label-text').textContent = contenido;
    });  

    // Dar likes a publicaciones
    document.querySelectorAll('.btn-like').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            
            const postId = button.getAttribute('data-post-id');
            const liked = button.getAttribute('data-liked') === 'true';
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = `/user/post/${postId}/like`;

            try {
                const response = await fetch(url, {
                    method: liked ? 'DELETE' : 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                });

                if (response.ok) {
                    const result = await response.json();
                    const countElement = button.querySelector('.like-count');
                    countElement.textContent = result.likes_count;

                    const icon = button.querySelector('i');
                    icon.classList.toggle('liked');
                    button.setAttribute('data-liked', (!liked).toString());
                }
            } catch (err) {
                console.error("Error al actualizar el like:", err);
            }
        });
    });
});