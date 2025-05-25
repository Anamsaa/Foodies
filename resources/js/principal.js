 document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('simulador-input');
    if (btn) {
        const url = btn.dataset.url;
        btn.addEventListener('click', () => {
            if (url) {
                window.location.href = url;
            }
        });
    }
});