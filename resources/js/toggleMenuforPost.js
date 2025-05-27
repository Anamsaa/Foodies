document.addEventListener('DOMContentLoaded', () => {
    
    //console.log('entra a la función toggle');
    const opciones = document.querySelectorAll('.post-options'); 

    if(!opciones) return; 

    opciones.forEach(opcion => {
        // Seleccionamos icono y menú
        const elipsis = opcion.querySelector('.icon-elipsis'); 
        const menu = opcion.querySelector('.elipsis-menu'); 

        elipsis.addEventListener('click', (e) => {
            e.stopPropagation(); 
            cerrarTodosLosMenus(); 
            menu.classList.toggle('show'); 
        }); 

        // Si el click no fue dentro de post-options removemos show
        document.addEventListener('click', (e) => {
            if (!opcion.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
    });

    // Cerrar todos los menús, para no tener muchos abiertos al mismo tiempo
    function cerrarTodosLosMenus() {
        document.querySelectorAll('elipsis-menu').forEach(menu => {
            menu.classList.remove('show');
        })

    }
})
