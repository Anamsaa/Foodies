document.addEventListener('DOMContentLoaded', function() {

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelector('input[name="cover_photo"]').addEventListener('change', function () {
        uploadImage(this.files[0], 'cover_photo');
    });

    document.querySelector('input[name="profile_photo"]').addEventListener('change', function () {
        uploadImage(this.files[0], 'profile_photo');
    });


    function uploadImage(file, type) {
        if (!file) return; 

        const formData = new FormData(); 
        formData.append(type, file); 

        fetch('/profile/update-photos', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }, 
            body: formData
        })

        .then(response => response.json())
        .then(data => {
            if (type === 'profile_photo' && data.profile_photo_url) {
                document.getElementById('profileImage').src = data.profile_photo_url;
            }
            if (type === 'cover_photo' && data.cover_photo_url) {
                document.querySelector('.header-profile').style.backgroundImage = `url('${data.cover_photo_url}')`;
            }
        })
        .catch(error => console.error('Error al subir imagen: ', error));
    }
})