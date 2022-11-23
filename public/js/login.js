const forgetButton = document.querySelector('.forget-btn');
if (forgetButton) {
    forgetButton.addEventListener('click', () => {
        window.location.href="/forgetPassword";
    })
}