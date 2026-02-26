window.addEventListener('scroll', function () {
    const img = document.querySelector('.hero-parallax-img');
    const hero = document.querySelector('.modern-hero');

    if (img && hero) {
        const scrollValue = window.scrollY;

        if (hero.offsetHeight <= 150) {
            let position = -20 + (scrollValue * 0.1);
            img.style.transform = `translate3d(0, ${position}px, 0)`;
        } else {
            let position = -50 + (scrollValue * 0.2);
            img.style.transform = `translate3d(0, ${position}px, 0)`;
        }
    }

});