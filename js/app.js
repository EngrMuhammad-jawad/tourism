document.addEventListener('DOMContentLoaded', () => {
    // AOS and Swiper are loaded from CDN in the layout, same as the original site.
    if (window.AOS) {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
        });
    }

    if (window.Swiper && document.querySelector('.tourSwiper')) {
        new Swiper('.tourSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    }

    // Sticky navbar blur effect
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('glass-dark', 'shadow-lg');
                navbar.classList.remove('bg-transparent');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });
    }
});
