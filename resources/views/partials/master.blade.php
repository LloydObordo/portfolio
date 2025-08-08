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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox/dist/jquery.fancybox.min.css" />

    @stack('styles')

    <style>
        /* ========== ROOT VARIABLES ========== */
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #1e40af;
            --accent-color: #041d8b;
            --text-dark: #1f2937;
            /* --text-light: #6b7280; */
            --text-light: #ffffff;
            --bg-light: #f8fafc;
            --bg-dark: #121212;
        }

        /* ========== BASE STYLES ========== */
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-light);
            padding-top: 80px;
            margin: 0;
        }

        .text-justify {
            text-align: justify;
        }

        :target {
            scroll-margin-top: 80px;
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

        /* ========== NAVIGATION ========== */
        .navbar-custom {
            background: var(--text-dark);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            z-index: 10000;
            height: 80px;
            box-sizing: border-box;
            border-bottom: 1px solid transparent;
        }

        .navbar-custom a {
            color: var(--text-dark);
            font-size: 20px;
            transition: color 0.3s ease;
            text-decoration: none;
        }

        .navbar-custom.scrolled {
            box-shadow: 0 4px 30px rgba(0,0,0,0.15);
        }

        .navbar-light .navbar-nav .nav-link {
            font-weight: 400;
            color: var(--text-light);
        }

        .navbar-nav .nav-link.active {
            font-weight: bold;
            color: var(--primary-color) !important;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            color: var(--primary-color);
        }

        /* ========== BUTTONS ========== */
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 6px 15px;
            font-weight: 250;
            border-radius: 50px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
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

        /* ========== HERO SECTION ========== */
        .hero-section {
            background-color: var(--bg-dark);
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

        /* ========== IMAGES ========== */
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
            /* border: 4px solid rgba(255, 255, 255, 0.2); */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .professional-photo:hover {
            transform: scale(1.05);
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

        /* ========== SECTIONS COMMON STYLES ========== */
        .about-section,
        .experience-section,
        .projects-section,
        .skills-section,
        .contact-section {
            position: relative;
            min-height: 100vh;
        }

        .about-section .container,
        .experience-section .container,
        .projects-section .container,
        .skills-section .container,
        .contact-section .container {
            position: relative;
            z-index: 1;
        }

        /* ========== PARTICLES ========== */
        #particles-js,
        #particles-js-about,
        #particles-js-experience,
        #particles-js-projects,
        #particles-js-skills,
        #particles-js-contact {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        /* ========== EXPERIENCE SECTION ========== */
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

        /* Experience Section - Glass Timeline */
        .timeline-item .card {
            transform-style: preserve-3d;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 8px;
            overflow: hidden;
            
            /* Glass border effect */
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            backdrop-filter: blur(12px);
            background: rgba(30, 30, 30, 0.6) !important;
            box-shadow: 
                0 4px 6px rgba(0, 0, 0, 0.1),
                0 1px 3px rgba(0, 0, 0, 0.08),
                inset 0 0 0 1px rgba(255, 255, 255, 0.05);
            
            /* Inner glow effect */
            position: relative;
        }

        .timeline-item .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 10px;
            pointer-events: none;
            box-shadow: inset 0 0 15px rgba(255, 255, 255, 0.03);
        }

        .timeline-item .card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 12px 40px rgba(0, 0, 0, 0.15),
                inset 0 0 0 1px rgba(255, 255, 255, 0.1);
            background: rgba(40, 40, 40, 0.7) !important;
        }

        .timeline-item .card-body {
            background: transparent !important;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Timeline Connector Enhancement */
        .timeline::before {
            background: linear-gradient(
                to bottom,
                transparent,
                var(--primary-color),
                transparent
            );
            width: 3px;
            left: 14px;
        }

        .timeline-item::before {
            border: 3px solid var(--bg-dark);
            box-shadow: 
                0 0 0 2px var(--primary-color),
                0 0 20px rgba(59, 130, 246, 0.5);
            z-index: 1;
        }

        /* Company Logo Enhancement */
        .timeline-item .rounded {
            border-radius: 10px !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }

        .timeline-item:hover .rounded {
            transform: scale(1.1);
        }

        /* Text Contrast Improvements */
        .timeline-item h5.fw-bold {
            color: white !important;
        }

        .timeline-item .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .timeline-item .achievements strong {
            color: rgba(255, 255, 255, 0.9);
        }

        .timeline-item .achievements ul {
            color: rgba(255, 255, 255, 0.8);
        }

        /* ========== PROJECTS SECTION ========== */
        .project-card {
            transform-style: preserve-3d;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 8px;
            overflow: hidden;
            
            /* Glass border effect */
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            backdrop-filter: blur(12px);
            background: rgba(30, 30, 30, 0.6) !important;
            box-shadow: 
                0 4px 6px rgba(0, 0, 0, 0.1),
                0 1px 3px rgba(0, 0, 0, 0.08),
                inset 0 0 0 1px rgba(255, 255, 255, 0.05);
            
            /* Inner glow effect */
            position: relative;
        }

        .project-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 10px;
            pointer-events: none;
            box-shadow: inset 0 0 15px rgba(255, 255, 255, 0.03);
        }

        .project-card:hover {
            transform: translateY(-8px) rotateX(5deg) rotateY(5deg);
            box-shadow: 
                0 15px 30px rgba(0, 0, 0, 0.2),
                0 5px 15px rgba(0, 0, 0, 0.15),
                inset 0 0 0 1px rgba(255, 255, 255, 0.1);
            background: rgba(40, 40, 40, 0.7) !important;
        }

        /* ========== SKILLS SECTION ========== */
        /* Skills Section - Glass Cards */
        .skills-section .card {
            background: rgba(30, 30, 30, 0.6) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 0 0 1px rgba(255, 255, 255, 0.05);
            position: relative;
        }

        .skills-section .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.03) 0%,
                rgba(255, 255, 255, 0) 100%
            );
            pointer-events: none;
        }

        .skills-section .card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 12px 40px rgba(0, 0, 0, 0.15),
                inset 0 0 0 1px rgba(255, 255, 255, 0.1);
            background: rgba(40, 40, 40, 0.7) !important;
        }

        .skills-section .card-body {
            background: transparent !important;
            padding: 2rem;
        }

        /* Skill Progress Bar Enhancements */
        .skill-progress {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .skill-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, 
                var(--primary-color), 
                var(--accent-color));
            border-radius: 10px;
            transition: width 1.5s cubic-bezier(0.22, 0.61, 0.36, 1);
            position: relative;
            overflow: hidden;
        }

        .skill-progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(255, 255, 255, 0.3) 50%,
                rgba(255, 255, 255, 0.1) 100%
            );
            animation: shine 2.5s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Skill Icons and Text */
        .skills-section .icon-image {
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
            transition: transform 0.3s ease;
        }

        .skills-section .card:hover .icon-image {
            transform: scale(1.1) rotate(5deg);
        }

        .skills-section .text-light {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .skills-section .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        /* Card Title Styling */
        .skills-section .card-title {
            position: relative;
            width: 100%;
            text-align: center;
            padding-bottom: 12px;
            color: white;
            margin-bottom: 1.5rem;
        }

        .skills-section .card-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            margin: 0 auto;
            width: 50px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        /* ========== CONTACT SECTION ========== */
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-left: 4px solid var(--primary-color);
        }

        /* Light mode - Enhanced Glass Form */
        .contact-form {
            background: rgba(255, 255, 255, 0.85); /* Semi-transparent white */
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px); /* Safari support */
            padding: 40px;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 0 0 1px rgba(255, 255, 255, 0.3),
                inset 0 0 16px rgba(255, 255, 255, 0.1);
            color: #222;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        /* Optional: Gradient border effect */
        .contact-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 16px;
            padding: 1px;
            background: linear-gradient(135deg, 
                        rgba(255,255,255,0.4), 
                        rgba(255,255,255,0.1));
            -webkit-mask: 
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* Form elements - Light mode */
        .contact-form input,
        .contact-form textarea,
        .contact-form select {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #333;
            transition: all 0.3s ease;
        }

        .contact-form input:focus,
        .contact-form textarea:focus,
        .contact-form select:focus {
            background: rgba(255, 255, 255, 0.95);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .contact-form label {
            color: #555;
            font-weight: 500;
        }

        .form-group.text-center .g-recaptcha {
            display: inline-block;
        }

        /* ========== DARK MODE STYLES ========== */
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

            /* Dark Mode - Skills Section */
            .skills-section .card {
                background: rgba(20, 20, 20, 0.7) !important;
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.3),
                    inset 0 0 0 1px rgba(255, 255, 255, 0.08);
            }
            
            .skills-section .card:hover {
                background: rgba(30, 30, 30, 0.8) !important;
            }
            
            .skill-progress {
                background: rgba(0, 0, 0, 0.3);
            }

            /* Dark Mode - Timeline */
            .timeline-item .card {
                background: rgba(20, 20, 20, 0.7) !important;
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.3),
                    inset 0 0 0 1px rgba(255, 255, 255, 0.08);
            }
            
            .timeline-item .card:hover {
                background: rgba(30, 30, 30, 0.8) !important;
            }
            
            .timeline::before {
                background: linear-gradient(
                    to bottom,
                    transparent,
                    rgba(59, 130, 246, 0.7),
                    transparent
                );
            }

            /* Dark Mode - Project Cards */
            .project-card {
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
                background: rgba(20, 20, 20, 0.7) !important;
                box-shadow: 
                    0 4px 6px rgba(0, 0, 0, 0.3),
                    0 1px 3px rgba(0, 0, 0, 0.25),
                    inset 0 0 0 1px rgba(255, 255, 255, 0.08);
            }
            
            .project-card:hover {
                background: rgba(30, 30, 30, 0.8) !important;
            }

            /* Dark Mode - Contact Form */
            .contact-form {
                background: rgba(28, 28, 28, 0.7);
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.3),
                    inset 0 0 0 1px rgba(255, 255, 255, 0.05),
                    inset 0 0 16px rgba(255, 255, 255, 0.03);
                color: rgba(255, 255, 255, 0.9);
            }

            /* Gradient border adjustment for dark mode */
            .contact-form::before {
                background: linear-gradient(135deg, 
                            rgba(255,255,255,0.15), 
                            rgba(255,255,255,0.05));
            }

            /* Form elements - Dark mode */
            .contact-form input,
            .contact-form textarea,
            .contact-form select {
                background: rgba(255, 255, 255, 0.08);
                border: 1px solid rgba(255, 255, 255, 0.15);
                color: rgba(255, 255, 255, 0.9) !important;
            }

            .contact-form input:focus,
            .contact-form textarea:focus,
            .contact-form select:focus {
                background: rgba(255, 255, 255, 0.12);
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
            }

            .contact-form label {
                color: rgba(255, 255, 255, 0.7);
            }
        }

        /* ========== PAGE TRANSITIONS ========== */
        .page-transition {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-dark);
            z-index: 9999;
            transform: scaleY(0);
            transform-origin: bottom;
            pointer-events: none;
            will-change: transform;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .transition-content {
            text-align: center;
        }

        .transition-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            opacity: 0;
            transform: scale(0.8);
            position: relative;
            z-index: 10000;
            animation: pulse 2s infinite ease-in-out;
        }

        .loading-text {
            color: white;
            font-family: 'Inter', sans-serif;
            margin-top: 20px;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* Show elements when transition is active */
        .page-transition.active .transition-logo,
        .page-transition.active .loading-text {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        /* Pulse animation */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        /* Loading text animation */
        @keyframes dot-pulse {
            0%, 100% {
                opacity: 0.5;
            }
            50% {
                opacity: 1;
            }
        }

        .loading-text::after {
            content: '...';
            display: inline-block;
            width: 20px;
            text-align: left;
        }

        .loading-text span {
            animation: dot-pulse 1.4s infinite both;
        }

        .loading-text span:nth-child(1) {
            animation-delay: 0s;
        }

        .loading-text span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .loading-text span:nth-child(3) {
            animation-delay: 0.4s;
        }

        /* ========== RESPONSIVE STYLES ========== */
        @media (max-width: 992px) {
            .navbar-collapse {
                /* background: rgba(255, 255, 255, 0.98); */
                background: rgba(65, 65, 65, 0.98);
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
    </style>
</head>
<body>
    <div class="page-transition">
        <div class="transition-content">
            <img src="{{asset('images/logo.png')}}" alt="Logo" class="transition-logo">
            <div class="loading-text">Loading...</div>
        </div>
    </div>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <!-- Fancybox JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox/dist/jquery.fancybox.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize fancybox
            $('[data-fancybox="project-gallery"]').fancybox({
                loop: true,
                buttons: [
                    "zoom",
                    "slideShow",
                    "thumbs",
                    "close"
                ],
                animationEffect: "zoom-in-out",
                transitionEffect: "circular",
                transitionDuration: 500
            });

            // Prevent default anchor behavior
            $('[data-fancybox]').on('click', function(e) {
                e.preventDefault();
            });
        });
    </script>
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
        document.addEventListener("DOMContentLoaded", function () {
            var typedElement = document.getElementById('typed-text');
            if (typedElement) {
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
            }
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
        // Helper function to initialize particles if container exists
        function initParticlesIfExists(id, config) {
            const container = document.getElementById(id);
            if (container) {
                particlesJS(id, config);
            }
        }

        const particlesConfig = {
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
        };

        // Initialize particles only for existing containers
        initParticlesIfExists('particles-js', particlesConfig);
        initParticlesIfExists('particles-js-about', particlesConfig);
        initParticlesIfExists('particles-js-experience', particlesConfig);
        initParticlesIfExists('particles-js-projects', particlesConfig);
        initParticlesIfExists('particles-js-skills', particlesConfig);
        initParticlesIfExists('particles-js-contact', particlesConfig);
    });
    </script>
    <script>
        const pageTransition = document.querySelector('.page-transition');
        const transitionLogo = document.querySelector('.transition-logo');
        const loadingText = document.querySelector('.loading-text');

        // Create animated dots for loading text
        loadingText.innerHTML = 'Loading<span>.</span><span>.</span><span>.</span>';

        // On page load
        window.addEventListener('load', () => {
            gsap.to(pageTransition, {
                scaleY: 0,
                duration: 0.8,
                ease: "power3.inOut",
                transformOrigin: "top",
                onStart: () => {
                    pageTransition.classList.remove('active');
                }
            });
        });

        // On link click
        document.querySelectorAll('a').forEach(link => {
            if (link.href && 
                !link.href.includes('#') && 
                !link.href.includes('mailto:') && 
                !link.href.includes('tel:') && 
                !link.href.includes('javascript:') &&
                link.hostname === window.location.hostname) {
                
                link.addEventListener('click', (e) => {
                    if (link.target === '_blank') return;
                    if (link.classList.contains('nav-link') && link.getAttribute('href').startsWith('#')) {
                        return;
                    }
                    
                    e.preventDefault();
                    const destination = link.href;
                    
                    // Show transition elements
                    pageTransition.classList.add('active');
                    
                    // Animate the transition
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sections = document.querySelectorAll("section[id]");
            const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

            function onScroll() {
                let scrollPos = window.scrollY + 90; // offset for navbar
                sections.forEach((section) => {
                    if (scrollPos >= section.offsetTop && scrollPos < section.offsetTop + section.offsetHeight) {
                        const id = section.getAttribute("id");
                        navLinks.forEach((link) => {
                            link.classList.remove("active");
                            if (link.getAttribute("href").includes("#" + id)) {
                                link.classList.add("active");
                            }
                        });
                    }
                });
            }

            window.addEventListener("scroll", onScroll);
        });
    </script>
    @yield('scripts')
</body>
</html>