document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('.form-unirse-evento');

    forms.forEach(form => {
        const button = form.querySelector('.btn-unirse');
        const eventId = form.dataset.eventId;
        let isJoined = form.dataset.isJoined === 'true';

        if (!eventId) {
            console.error('Falta el ID del evento en el formulario');
            return;
        }

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
                return response.json().catch(() => ({}));
            })
            .then(data => {
                isJoined = !isJoined;
                form.dataset.isJoined = isJoined.toString();
                button.textContent = isJoined ? 'Descartar' : 'Unirse';

                const card = form.closest('.evento-card');
                const destino = isJoined
                    ? document.getElementById('contenedor-mis-eventos')
                    : document.getElementById('contenedor-eventos-disponibles');

                if (card && destino) destino.appendChild(card);
                location.reload();

                const detalles = card.querySelectorAll('.evento-detalles p');
                let cupoElement = null;

                detalles.forEach(p => {
                    if (p.textContent.includes('Cupos disponibles')) {
                        cupoElement = p;
                    }
                });

                if (cupoElement) {
                    const match = cupoElement.textContent.match(/\d+/);
                    if (match) {
                        let current = parseInt(match[0], 10);
                        let nuevo = isJoined ? current - 1 : current + 1;
                        cupoElement.innerHTML = `<strong>Cupos disponibles:</strong> ${nuevo}`;
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
