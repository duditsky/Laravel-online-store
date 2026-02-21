window.addEventListener('scroll', function() {
    const img = document.querySelector('.hero-parallax-img');
    const hero = document.querySelector('.modern-hero');
    
    if (img && hero) {
        const scrollValue = window.scrollY;
        
        // Якщо блок маленький (height <= 150), зменшуємо інтенсивність руху
        if (hero.offsetHeight <= 150) {
            // Для маленького блоку: стартуємо з 0 (без -50) і рухаємо повільніше (0.1)
            let position =-20 + (scrollValue * 0.1); 
            img.style.transform = `translate3d(0, ${position}px, 0)`;
        } else {
            // Для головної сторінки залишаємо як було
            let position = -50 + (scrollValue * 0.2); 
            img.style.transform = `translate3d(0, ${position}px, 0)`;
        }
    }
});