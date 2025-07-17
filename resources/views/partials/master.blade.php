<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portfolio')</title>
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    @stack('styles')
    
    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #1e40af;
            --accent-color: #f59e0b;
            --text-dark: #1f2937;
            /* --text-light: #6b7280; */
            --text-light: #ffffff;
            --bg-light: #f8fafc;
            --bg-dark: #121212;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-light);
            padding-top: 80px;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            margin-top: -80px;
        }

        .hero-section .container {
            position: relative;
            z-index: 1;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="25" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="25" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grain)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .about-section {
            position: relative;
            min-height: 100vh;
        }

        .about-section .container {
            position: relative;
            z-index: 1;
        }

        #particles-js-about {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .experience-section {
            position: relative;
            min-height: 100vh;
        }

        .experience-section .container {
            position: relative;
            z-index: 1;
        }

        @media (prefers-color-scheme: dark) {
    .card-body {
        /* Surface color with 01dp elevation (5% white overlay) */
        background: rgba(30, 30, 30, 0.95); /* #1E1E1E with 5% white overlay */
        
        /* Text color */
        color: rgba(255, 255, 255, 0.87);
        
        /* 01dp elevation shadow (more subtle than form) */
        box-shadow: 
            0 1px 1px rgba(0, 0, 0, 0.12),
            0 1px 2px rgba(0, 0, 0, 0.1);
            
        /* Border for depth */
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
}

        #particles-js-experience {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .projects-section {
            position: relative;
            min-height: 100vh;
        }

        .projects-section .container {
            position: relative;
            z-index: 1;
        }

        #particles-js-projects {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .skills-section {
            position: relative;
            min-height: 100vh;
        }

        .skills-section .container {
            position: relative;
            z-index: 1;
        }

        #particles-js-skills {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .contact-section {
            position: relative;
            min-height: 100vh;
        }

        .contact-section .container {
            position: relative;
            z-index: 1;
        }

        #particles-js-contact {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .profile-image {
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-image:hover {
            transform: scale(1.05);
        }

        .professional-photo {
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .professional-photo:hover {
            transform: scale(1.05);
        }
        
        .section-padding {
            padding: 80px 0;
        }
        
        .bg-light-custom {
            background-color: var(--bg-light);
        }

        .bg-dark-custom {
            background-color: var(--bg-dark);
        }
        
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 6px 15px;
            font-weight: 250;
            border-radius: 50px;
        }
        
        .btn-primary-custom:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-primary-custom {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-primary-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.5s ease;
        }

        .btn-primary-custom:hover::before {
            left: 100%;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .project-card {
            transform-style: preserve-3d;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 10px;
            overflow: hidden;
        }

        .project-card:hover {
            transform: translateY(-10px) rotateX(5deg) rotateY(5deg);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .skill-progress {
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .skill-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 10px;
            transition: width 2s ease;
        }
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--primary-color);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -23px;
            top: 5px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--primary-color);
            border: 3px solid white;
            box-shadow: 0 0 0 3px var(--primary-color);
        }
        
        .navbar-custom {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            /* z-index: 1030; */
            z-index: 10000;
        }
        
        .navbar-custom.scrolled {
            box-shadow: 0 4px 30px rgba(0,0,0,0.15);
        }
        
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-left: 4px solid var(--primary-color);
        }
        
        /* .contact-form {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        } */

        /* Light mode (original) */
.contact-form {
    background: white;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    color: #333; /* Default text color for light mode */
}

/* Dark mode styles */
@media (prefers-color-scheme: dark) {
    .contact-form {
        /* Surface color with 02dp elevation (7% white overlay) */
        background: rgba(28, 28, 28, 0.93); /* #1C1C1C with 7% white overlay */
        
        /* Text color */
        color: rgba(255, 255, 255, 0.87); /* 87% opacity white for high-emphasis text */
        
        /* 02dp elevation shadow */
        box-shadow: 
            0 1px 1px rgba(0, 0, 0, 0.14),
            0 2px 1px rgba(0, 0, 0, 0.12);
            
        /* Border for better surface definition */
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* If you have specific elements inside the form */
    .contact-form input,
    .contact-form textarea,
    .contact-form select {
        background: rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.87);
        border-color: rgba(255, 255, 255, 0.23);
    }

    .contact-form label {
        color: rgba(255, 255, 255, 0.6); /* Medium-emphasis text */
    }
}

        :target {
            scroll-margin-top: 80px;
        }

        .navbar-light .navbar-nav .nav-link {
            color: var(--secondary-color);
        }

        @media (max-width: 992px) {
            .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                padding: 20px;
                border-radius: 10px;
                margin-top: 10px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            }
            
            .navbar-nav {
                gap: 10px;
            }
            
            .nav-link {
                padding: 8px 15px;
                border-radius: 5px;
            }
            
            .nav-link:hover {
                background: rgba(59, 130, 246, 0.1);
            }
            
            .navbar-toggler {
                border: none;
                padding: 0.5rem;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                min-height: 80vh;
                text-align: center;
                padding-top: 80px;
            }
            
            .hero-section h1.display-4 {
                font-size: 2.5rem;
            }
            
            .profile-image {
                width: 200px;
                height: 200px;
                margin: 20px auto;
            }
            
            .hero-section .col-lg-6 {
                padding: 15px;
            }
        }

        .text-justify {
            text-align: justify;
        }

        .icon-image {
            width: 24px;
            height: 24px;
            object-fit: contain;
            margin-right: 10px;
            display: inline-block;
            /* border-radius: 4px;
            background-color: #f8f9fa;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1); */
        }

        .page-transition {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-color);
            z-index: 9999;
            transform: scaleY(0);
            transform-origin: bottom;
            pointer-events: none;
            will-change: transform; /* Improves performance */
        }

            /* .submit-btn {
        width: 100%;
        max-width: 300px;
        padding: 0.75rem;
        background-color: #4D6BFE;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        margin: 1.5rem auto;
        display: block;
        transition: all 0.3s ease;
        position: relative;
        text-align: center;
    }

    .submit-btn:hover {
        background-color: #3d57dd;
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    } */

    .submit-btn:disabled {
        background-color: #95a5a6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .spinner {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        margin-right: 0.5rem;
        display: none;
    }

    .btn-loading .spinner {
        display: inline-block;
    }

    .btn-text {
        display: inline-block;
        text-align: center;
        transition: all 0.3s ease;
    }

    .form-group.text-center .g-recaptcha {
        display: inline-block;
    }
    </style>
</head>
<body>
    <div class="page-transition"></div>

    <!-- Navigation -->
    @include('partials.navbar')
    
    <!-- Main Content -->
    @yield('content')
    
    <!-- Footer -->
    @include('partials.footer')

    <!-- Back to top button -->
    <button id="backToTop" class="btn btn-primary rounded-circle shadow" style="position: fixed; bottom: 30px; right: 30px; width: 50px; height: 50px; display: none; z-index: 1000;" title="Back to Top">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out-quad',
            once: false, // Allow animations to trigger again
            mirror: true, // Elements animate out while scrolling up
            anchorPlacement: 'top-bottom'
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Initialize navbar state on load
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            }
            
            // Close mobile menu when clicking a link
            document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                            toggle: false
                        });
                        bsCollapse.hide();
                    }
                });
            });
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Typed.js for hero section
        var typed = new Typed('#typed-text', {
            strings: [
                'Information Technology Officer',
                'Full-Stack Developer',
                'Laravel Expert',
                'Problem Solver',
                'Tech Innovator'
            ],
            typeSpeed: 100,
            backSpeed: 100,
            backDelay: 100,
            loop: true
        });

        // Animate skill progress bars when they come into view
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const progressBars = entry.target.querySelectorAll('.skill-progress-bar');
                    progressBars.forEach(bar => {
                        const width = bar.style.width;
                        bar.style.width = '0%';
                        setTimeout(() => {
                            bar.style.width = width;
                        }, 100);
                    });
                }
            });
        }, observerOptions);

        document.querySelectorAll('#skills .card').forEach(card => {
            observer.observe(card);
        });

        // Back to top button
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.style.display = 'flex';
                backToTopButton.style.alignItems = 'center';
                backToTopButton.style.justifyContent = 'center';
            } else {
                backToTopButton.style.display = 'none';
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Particles for hero section
            particlesJS('particles-js', {
                particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#ffffff" },
                shape: { type: "circle" },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
                move: { enable: true, speed: 2, direction: "none", random: true, straight: false, out_mode: "out" }
                },
                interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    onclick: { enable: true, mode: "push" }
                }
                }
            });

            // Particles for about sections
            particlesJS('particles-js-about', {
                particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#ffffff" },
                shape: { type: "circle" },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
                move: { enable: true, speed: 2, direction: "none", random: true, straight: false, out_mode: "out" }
                },
                interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    onclick: { enable: true, mode: "push" }
                }
                }
            });

            // Particles for experience section
            particlesJS('particles-js-experience', {
                particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#ffffff" },
                shape: { type: "circle" },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
                move: { enable: true, speed: 2, direction: "none", random: true, straight: false, out_mode: "out" }
                },
                interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    onclick: { enable: true, mode: "push" }
                }
                }
            });

            // Particles for projects section
            particlesJS('particles-js-projects', {
                particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#ffffff" },
                shape: { type: "circle" },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
                move: { enable: true, speed: 2, direction: "none", random: true, straight: false, out_mode: "out" }
                },
                interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    onclick: { enable: true, mode: "push" }
                }
                }
            });
            
            // Particles for skills section
            particlesJS('particles-js-skills', {
                particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#ffffff" },
                shape: { type: "circle" },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
                move: { enable: true, speed: 2, direction: "none", random: true, straight: false, out_mode: "out" }
                },
                interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    onclick: { enable: true, mode: "push" }
                }
                }
            });

            // Particles for contact section
            particlesJS('particles-js-contact', {
                particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#ffffff" },
                shape: { type: "circle" },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
                move: { enable: true, speed: 2, direction: "none", random: true, straight: false, out_mode: "out" }
                },
                interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    onclick: { enable: true, mode: "push" }
                }
                }
            });
        });
    </script>
    <script>
        const pageTransition = document.querySelector('.page-transition');
        
        // On page load
        window.addEventListener('load', () => {
            gsap.to(pageTransition, {
                scaleY: 0,
                duration: 0.8,
                ease: "power3.inOut",
                transformOrigin: "top"
            });
        });
        
        // On link click - modified for your portfolio
        document.querySelectorAll('a').forEach(link => {
            // Skip special links
            if (link.href && 
                !link.href.includes('#') && 
                !link.href.includes('mailto:') && 
                !link.href.includes('tel:') && 
                !link.href.includes('javascript:') &&
                link.hostname === window.location.hostname) {
                
                link.addEventListener('click', (e) => {
                    // Skip if target is blank (external links)
                    if (link.target === '_blank') return;
                    
                    // Skip if it's a nav-link that should trigger smooth scroll
                    if (link.classList.contains('nav-link') && link.getAttribute('href').startsWith('#')) {
                        return;
                    }
                    
                    e.preventDefault();
                    const destination = link.href;
                    
                    gsap.to(pageTransition, {
                        scaleY: 1,
                        duration: 0.8,
                        ease: "power3.inOut",
                        transformOrigin: "bottom",
                        onComplete: () => {
                            window.location.href = destination;
                        }
                    });
                });
            }
        });

        // Handle browser back/forward navigation
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                gsap.set(pageTransition, { scaleY: 0 });
            }
        });

        // Modified smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                // Skip if it's not a nav-link (allow other # links to use transitions)
                if (!this.classList.contains('nav-link')) return;
                
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    // Close mobile menu if open
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                            toggle: false
                        });
                        bsCollapse.hide();
                    }
                    
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>