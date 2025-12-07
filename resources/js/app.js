import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Smooth scrolling for navigation links
document.addEventListener('DOMContentLoaded', function() {
    console.log('Alpine.js initialized');
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar-container');
        if (navbar) {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    });

    // Debug: Verificar que Alpine.js está funcionando
    const navbarContainer = document.querySelector('[x-data*="mobileMenuOpen"]');
    if (navbarContainer) {
        console.log('Navbar container found with Alpine.js data');
        
        // Verificar el botón hamburguesa
        const mobileToggle = document.querySelector('.mobile-toggle');
        if (mobileToggle) {
            console.log('Mobile toggle button found');
            mobileToggle.addEventListener('click', function(e) {
                console.log('Mobile toggle clicked');
                e.stopPropagation();
            });
        } else {
            console.error('Mobile toggle button NOT found');
        }
    } else {
        console.error('Navbar container with Alpine.js NOT found');
    }

    // Manejar el scroll del body cuando el menú móvil está abierto
    const checkMenuState = () => {
        const mobileMenu = document.querySelector('.mobile-menu');
        if (mobileMenu) {
            const style = window.getComputedStyle(mobileMenu);
            const isVisible = style.display !== 'none' && 
                           style.visibility !== 'hidden';
            
            if (isVisible) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }
    };

    // Verificar periódicamente el estado del menú
    setInterval(checkMenuState, 200);

    // Cerrar menú móvil al redimensionar la ventana si se hace más grande
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
            document.body.style.overflow = '';
        }
    });
});
