 document.addEventListener('DOMContentLoaded', () => {

    // Redirección al input simulado en la página de navegación principal 
    const btn = document.getElementById('simulador-input');
    if (btn) {
        const url = btn.dataset.url;
        btn.addEventListener('click', () => {
            if (url) {
                window.location.href = url;
            }
        });
    }

    // Botón de seguidos
    const followButtons = document.querySelectorAll('.follow-button');

    followButtons.forEach(button => {
        button.addEventListener('click', function () {
            const profileId = this.dataset.profileId;
            const isFollowing = this.dataset.following === 'true';
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = isFollowing
                ? `/user/unfollow/${profileId}`
                : `/user/follow/${profileId}`;
            const method = isFollowing ? 'DELETE' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                this.dataset.following = (!isFollowing).toString();
                this.textContent = isFollowing ? 'Seguir' : 'Siguiendo';

                // Actualizar el contador de seguidos
                const contador = document.getElementById('seguidores-contador');
                if (contador) {
                    let valorActual = parseInt(contador.textContent);
                    contador.textContent = isFollowing ? valorActual - 1 : valorActual + 1;
                }
                
                // Eliminar la tarjeta del usuario que se deja de seguir
                if (isFollowing) {
                    this.closest('.usuario-card')?.remove();
                }

            })
            .catch(err => {
                console.error(err);
                alert('Ocurrió un error al procesar la solicitud.');
            });
        });
    });
});