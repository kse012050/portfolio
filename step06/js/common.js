window.addEventListener('scroll', function () {
    var el = document.querySelector('header');
    if (window.pageYOffset >= 110) {
        el.setAttribute('class', 'menuFixed');
    } else {
        el.removeAttribute('class', 'menuFixed');
    }
});