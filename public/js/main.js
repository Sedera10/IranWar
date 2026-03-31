/**
 * IranWar - Main JavaScript
 * OPTIMISÉ: Chargement asynchrone et priorité aux blocs visibles
 */

document.addEventListener('DOMContentLoaded', function() {
    // Priorité 1: Éléments visibles (above-the-fold)
    initCriticalFeatures();
    
    // Priorité 2: Éléments différés (below-the-fold)
    if ('requestIdleCallback' in window) {
        requestIdleCallback(initDeferredFeatures);
    } else {
        setTimeout(initDeferredFeatures, 200);
    }
});

/**
 * Fonctionnalités critiques (chargées immédiatement)
 */
function initCriticalFeatures() {
    // Mobile menu toggle
    initMobileMenu();
    
    // Lazy loading images (critique pour performance)
    initLazyLoading();
}

/**
 * Fonctionnalités différées (chargées après le rendu initial)
 */
function initDeferredFeatures() {
    // Smooth scroll
    initSmoothScroll();
    
    // Form validation
    initFormValidation();
    
    // Back to top button
    initBackToTop();
    
    // Préchargement des liens au survol
    initLinkPrefetch();
}

/**
 * Mobile Menu
 */
function initMobileMenu() {
    const menuToggle = document.querySelector('.menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    
    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
        });
    }
}

/**
 * Smooth Scroll
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Form Validation
 */
function initFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                    showFieldError(field, 'Ce champ est requis');
                } else {
                    field.classList.remove('error');
                    removeFieldError(field);
                }
            });
            
            // Email validation
            const emailFields = form.querySelectorAll('input[type="email"]');
            emailFields.forEach(field => {
                if (field.value && !isValidEmail(field.value)) {
                    isValid = false;
                    field.classList.add('error');
                    showFieldError(field, 'Email invalide');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
}

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function showFieldError(field, message) {
    removeFieldError(field);
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#ef4444';
    errorDiv.style.fontSize = '0.85rem';
    errorDiv.style.marginTop = '5px';
    field.parentNode.appendChild(errorDiv);
}

function removeFieldError(field) {
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

/**
 * Lazy Loading Images
 */
function initLazyLoading() {
    if ('IntersectionObserver' in window) {
        const lazyImages = document.querySelectorAll('img[data-src]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(img => imageObserver.observe(img));
    }
}

/**
 * Share functions
 */
function shareOnFacebook(url) {
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url), '_blank', 'width=600,height=400');
}

function shareOnTwitter(url, text) {
    window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(text), '_blank', 'width=600,height=400');
}

/**
 * Back to top button
 */
function initBackToTop() {
    const backToTop = document.createElement('button');
    backToTop.id = 'back-to-top';
    backToTop.innerHTML = '↑';
    backToTop.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #c41e3a;
        color: white;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        display: none;
        z-index: 999;
        transition: opacity 0.3s ease;
    `;
    document.body.appendChild(backToTop);
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTop.style.display = 'block';
        } else {
            backToTop.style.display = 'none';
        }
    });
    
    backToTop.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// Initialize back to top
// Déjà appelé dans initDeferredFeatures()

/**
 * Préchargement des liens au survol (optimisation navigation)
 */
function initLinkPrefetch() {
    // Ne précharger que sur les connexions rapides
    if ('connection' in navigator) {
        const conn = navigator.connection;
        if (conn.saveData || conn.effectiveType === '2g' || conn.effectiveType === 'slow-2g') {
            return; // Ne pas précharger sur connexions lentes
        }
    }
    
    const links = document.querySelectorAll('a[href^="/"], a[href^="' + window.location.origin + '"]');
    
    links.forEach(link => {
        let prefetched = false;
        
        link.addEventListener('mouseenter', function() {
            if (!prefetched && this.href) {
                const prefetchLink = document.createElement('link');
                prefetchLink.rel = 'prefetch';
                prefetchLink.href = this.href;
                document.head.appendChild(prefetchLink);
                prefetched = true;
            }
        }, { once: true });
    });
}

/**
 * Intersection Observer pour charger les sections au scroll
 */
function initSectionObserver() {
    const sections = document.querySelectorAll('.lazy-section');
    
    if ('IntersectionObserver' in window && sections.length > 0) {
        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('loaded');
                    sectionObserver.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.1
        });
        
        sections.forEach(section => sectionObserver.observe(section));
    }
}
