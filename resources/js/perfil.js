document.addEventListener('DOMContentLoaded', function() {

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const coverInput = document.querySelector('input[name="cover_photo"]');

    // Detectar el tipo de usuario
    const esRestaurante = window.location.pathname.startsWith('/restaurant');
    const subirURL = esRestaurante ? '/restaurant/profile/update-photos' : '/user/profile/update-photos'; 

    // Se hace un selector alt de todos estos inputs, ya que se repite el bloque para mejor adaptación responsive 
    document.querySelectorAll('input[name="profile_photo"]').forEach(input => {
        input.addEventListener('change', function () {
            uploadImage(this.files[0], 'profile_photo');
        });
    });

    if(coverInput) {
        coverInput.addEventListener('change', function() {
            uploadImage(this.files[0], 'cover_photo');
        });
    }


    function uploadImage(file, type) {
        if (!file) return; 

        const formData = new FormData(); 
        formData.append(type, file); 

        fetch(subirURL, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }, 
            body: formData
        })

        .then(response => {
            if(!response.ok) throw new Error("Error en la respuesta del servidor");
            return response.json();
        })
           
        .then(data => {
            console.log(data);
            if (type === 'profile_photo' && data.profile_photo_url) {
                document.getElementById('profileImage').src = data.profile_photo_url;
                document.getElementById('profileImageMobile').src = data.profile_photo_url;
            }
            if (type === 'cover_photo' && data.cover_photo_url) {
                document.querySelector('.header-profile').style.backgroundImage = `url('${data.cover_photo_url}')`;
            }
        })
        .catch(error => console.error('Error al subir imagen: ', error));
    }
})