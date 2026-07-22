(function () {
    // Set background images via the DOM API instead of inline style="" attributes,
    // since a strict CSP (style-src without 'unsafe-inline') blocks inline style
    // attributes/tags but does not block styles set through element.style in JS.
    document.querySelectorAll('[data-bg]').forEach(function (el) {
        var url = el.getAttribute('data-bg');
        if (url) {
            el.style.backgroundImage = 'url(' + url + ')';
        }
    });

    var slides = document.querySelectorAll('.hero-slide');
    var dots = document.querySelectorAll('.hero-dots button');
    var current = 0;
    var timer;

    function show(index) {
        slides.forEach(function (s) { s.classList.remove('active'); });
        dots.forEach(function (d) { d.classList.remove('active'); });
        slides[index].classList.add('active');
        dots[index].classList.add('active');
        current = index;
    }

    function next() {
        show((current + 1) % slides.length);
    }

    function startAuto() {
        timer = setInterval(next, 6000);
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            clearInterval(timer);
            show(parseInt(dot.getAttribute('data-index'), 10));
            startAuto();
        });
    });

    if (slides.length > 1) {
        startAuto();
    }
})();
