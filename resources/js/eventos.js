document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('.form-unirse-evento');

    forms.forEach(form => {
        const button = form.querySelector('.btn-unirse');
        const eventId = form.dataset.eventId;
        let isJoined = form.dataset.isJoined === 'true';

        button.addEventListener('click', () => {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = isJoined
                ? `/user/eventos/${eventId}/cancelar`
                : `/user/eventos/${eventId}/unirse`;

            const method = isJoined ? 'DELETE' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Error en la solicitud');
                return response.json().catch(() => ({})); // Si no hay JSON
            })
            .then(data => {
                // Alternar estado
                isJoined = !isJoined;
                form.dataset.isJoined = isJoined.toString();
                button.textContent = isJoined ? 'Descartar' : 'Unirse';

                // Opcional: actualizar visualmente los cupos
                const cupoTexto = form.closest('.evento-card').querySelector('.evento-detalles p strong');
                if (cupoTexto) {
                    let currentText = cupoTexto.parentElement.textContent;
                    const match = currentText.match(/\d+/);
                    if (match) {
                        let current = parseInt(match[0], 10);
                        let nuevo = isJoined ? current - 1 : current + 1;
                        cupoTexto.parentElement.innerHTML = `<strong>Cupos disponibles:</strong> ${nuevo}`;
                    }
                }
            })
            .catch(err => {
                console.error(err);
                alert('No se pudo completar la acción.');
            });
        });
    });
});
