// window.onload = function() {
    console.log("Index");
    const alertElement = document.querySelector('.alert');
    if (alertElement) {
        setTimeout(hideFlashMessage, 3000);
    }

    function hideFlashMessage() {
        alertElement.style.display = 'none';
    }
// }