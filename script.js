document.addEventListener('DOMContentLoaded', function () {
    const toggleMenu = document.getElementById('toggle-menu');
    const mobileMenu = document.querySelector('.mobile-menu');

    toggleMenu.addEventListener('click', () => {
        mobileMenu.style.display = mobileMenu.style.display === 'block' ? 'none' : 'block';
    });
});
