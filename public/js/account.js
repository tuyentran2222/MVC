
window.onload = function() {
    const closeUpdateButton = document.querySelector('.profile__edit-btn');
    const returnUpdateButton = document.querySelector('.profile__button-return');
    const overlay = document.querySelector('.overlay');
    const openUpdateButton  = document.querySelector('.edit-profile-btn');
    const logoutButton  = document.querySelector('.logout-btn');
    const uploadAvatarInput = document.querySelector('#avatar');
    const avatarImage = document.querySelector('.avatarImage')

    if (closeUpdateButton) closeUpdateButton.addEventListener('click', closeUpdateDialog);
    if (returnUpdateButton) returnUpdateButton.addEventListener('click',(e)=> closeUpdateDialog(e));
    if (openUpdateButton) openUpdateButton.addEventListener('click', openDialog);
    
    if (logoutButton) {
        logoutButton.addEventListener('click', function() {
            window.location.href = '/logout'
        });
    }
    
    if (uploadAvatarInput) {
        uploadAvatarInput.addEventListener('change', () => {
            const [file] = uploadAvatarInput.files
            if (file) {
                avatarImage.src = URL.createObjectURL(file);
            }
            const fileSize = uploadAvatarInput.files[0].size / 1024 / 1024;
            if (fileSize > 2) {
                alert('File size exceeds 2 MiB');
            } else {
                uploadAvatarInput.closest('form').submit();
            }
        })
    }
    
    function closeUpdateDialog(e){
        e.preventDefault();
        overlay.classList.remove('active');
    }
    function openDialog() {
        overlay.classList.add('active');
    }
}