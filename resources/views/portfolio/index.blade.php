@extends('partials.master')

@section('content')
<!-- Hero Section -->
<section id="home" class="hero-section pb-3">
    <div id="particles-js"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-4 fw-bold">
                    Hi, I'm <span class="text-primary">{{ $professionalSummary->shortname ?? 'Lloyd Obordo' }}</span>
                </h1>
                <h2 class="h3 mb-4 text-light">
                    <span id="typed-text"></span>
                </h2>
                <p class="lead text-justify mb-5">
                    {{ $professionalSummary->summary ?? 'A passionate full-stack developer with over 5 years of experience creating web applications that solve real-world problems.' }}
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#projects" class="btn btn-primary-custom btn-md">
                        <i class="fas fa-eye fa-lg text-light me-2"></i><span class="text-light">View My Work</span>
                    </a>
                    <a href="#contact" class="btn btn-primary-custom btn-md">
                        <i class="fas fa-envelope fa-lg text-light me-2"></i><span class="text-light">Get In Touch</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <img src="{{ isset($professionalSummary->profile_image) ? asset('storage/'.$professionalSummary->profile_image): asset('images/icon.jpg') }}" alt="Profile" 
                     class="img-fluid rounded-circle shadow-lg profile-image" style="max-width: 400px;">
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="about-section section-padding bg-dark-custom">
    <div id="particles-js-about"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold">About Me</h2>
                <p class="lead text-muted">Get to know me better</p>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-4 text-center mb-4" data-aos="fade-right">
                <img src="{{ isset($professionalSummary->cover_image) ? asset('storage/'.$professionalSummary->cover_image) : asset('images/default.jpg') }}" alt="About Me" class="img-fluid professional-photo rounded-3 shadow">
            </div>
            <div class="col-lg-8" data-aos="fade-left">
                <h3 class="h4 fw-bold mb-3">Professional Summary</h3>
                <p class="lead text-justify mb-4">
                    {{ $professionalSummary->summary ?? 'A passionate full-stack developer with over 5 years of experience creating web applications that solve real-world problems.' }}
                </p>
                <p class="lead text-justify mb-4">
                    {{ $professionalSummary->biography ?? 'I am a skilled and motivated full-stack developer with a passion for building web applications that deliver exceptional user experiences.' }}
                </p>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt text-primary me-3"></i>
                            <div>
                                <strong>Experience:</strong> {{ $totalExperience ?? '5+ Years' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-project-diagram text-primary me-3"></i>
                            <div>
                                <strong>Projects:</strong> {{ $projectCount ?? '10+' }} Completed
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-graduation-cap text-primary me-3"></i>
                            <div>
                                <strong>Education:</strong> {{ $education->abbreviation ?? '' }} {{ $education->field_of_study ?? 'BS Computer Engineering' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-primary me-3"></i>
                            <div>
                                <strong>Location:</strong> {{ $professionalSummary->address ?? 'Manila, Philippines' }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    @if ( isset($professionalSummary->resume) && file_exists(public_path('storage/' . $professionalSummary->resume)) )
                    <a href="{{ route('resume.download') }}" class="btn btn-primary-custom" download>
                        <i class="fas fa-cloud-download-alt fa-lg text-light me-2"></i><span class="text-light">Download Resume</span>
                    </a>
                    @else
                    <a href="#contact" class="btn btn-primary-custom">
                        <i class="fas fa-envelope fa-lg text-light me-2"></i><span class="text-light">Request Resume</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Experience Section -->
<section id="experience" class="experience-section section-padding bg-dark-custom">
    <div id="particles-js-experience"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold">Experience</h2>
                <p class="lead text-muted">My professional journey</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="timeline">
                    @foreach($experiences as $experience)
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    @if($experience->company_logo)
                                    <div class="col-auto">
                                        <img src="{{ asset($experience->company_logo) }}" 
                                             alt="{{ $experience->company }}" 
                                             class="rounded" style="width: 50px; height: 50px;">
                                    </div>
                                    @endif
                                    <div class="col">
                                        <h5 class="fw-bold mb-1">{{ $experience->job_title }}</h5>
                                        <h6 class="text-muted mb-2">{{ $experience->company }}</h6>
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $experience->formatted_date_range }}
                                            <span class="ms-3">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $experience->duration }}
                                            </span>
                                        </p>
                                        <p class="text-muted mb-2">{{ $experience->description }}</p>
                                        @if($experience->achievements)
                                        <div class="achievements">
                                            <strong>Key Achievements:</strong>
                                            <ul class="text-justify mt-2">
                                                @foreach($experience->achievements as $achievement)
                                                <li>{{ $achievement }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Projects Section -->
<section id="projects" class="projects-section section-padding bg-dark-custom">
    <div id="particles-js-projects"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold">Featured Projects</h2>
                <p class="lead text-muted">Some of my best work</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($featuredProjects as $project)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card project-card h-100 border-0 shadow-sm">
                    @if($project->image)
                    <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top" alt="{{ $project->title }}" 
                         style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $project->title }}</h5>
                        <p class="card-text text-muted">{{ $project->description }}</p>
                        <div class="mb-3">
                            @foreach($project->technologies as $tech)
                            <span class="badge bg-primary me-1 mb-1">{{ $tech }}</span>
                            @endforeach
                        </div>
                        <div class="mt-auto d-flex 
                            @if($project->live_url && $project->github_url) 
                                justify-content-between 
                            @else 
                                justify-content-center 
                            @endif 
                            align-items-center">
                            
                            @if($project->live_url)
                            <a href="{{ $project->live_url }}" class="btn btn-primary-custom btn-sm" target="_blank">
                                <i class="fas fa-external-link-alt text-light me-1"></i><span class="text-light">Live</span>
                            </a>
                            @endif
                            
                            @if($project->github_url)
                            <a href="{{ $project->github_url }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                                <i class="fab fa-github text-light me-1"></i><span class="text-light">Code</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5 d-none" data-aos="fade-up">
            <a href="{{ route('projects') }}" class="btn btn-primary-custom btn-lg">
                <i class="fas fa-eye fa-sm text-light me-2"></i><span class="text-light">View All Projects</span>
            </a>
        </div>
    </div>
</section>

<!-- Skills Section -->
<section id="skills" class="skills-section section-padding bg-dark-custom">
    <div id="particles-js-skills"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold">Skills & Expertise</h2>
                <p class="lead text-muted">Technologies I work with</p>
            </div>
        </div>
        <div class="row">
            @foreach($skills as $category => $categorySkills)
            <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-center mb-4">
                            {{ ucfirst($category) }} Skills
                        </h5>
                        @foreach($categorySkills as $skill)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="d-flex align-items-center">
                                    @if(!empty($skill->icon))
                                        <img src="{{ asset('storage/' . $skill->icon) }}" alt="{{ $skill->name }}" class="icon-image">
                                    @endif
                                    <span class="fw-medium text-light">{{ $skill->name }}</span>
                                </div>
                                <span class="text-muted">{{ $skill->proficiency }}%</span>
                            </div>
                            <div class="skill-progress">
                                <div class="skill-progress-bar" 
                                     style="width: {{ $skill->proficiency }}%" 
                                     data-aos="fade-right" 
                                     data-aos-delay="{{ $loop->parent->index * 100 + $loop->index * 50 }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section section-padding bg-dark-custom">
    <div id="particles-js-contact"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold">Get In Touch</h2>
                <p class="lead text-muted">Let's work together on your next project</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form" data-aos="fade-up">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    <!-- Header of Contact Form -->
                    <h3 class="h4 fw-bold mb-4">Contact Me</h3>
                    <p class="text-muted mb-4">
                        Have a question or want to work together? Fill out the form below and I'll get back to you as soon as possible.
                    </p>
                    <!-- Contact Form -->
                    <form action="{{ route('contact.send') }}" method="POST" id="contactForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                       id="subject" name="subject" value="{{ old('subject') }}" required>
                                @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                                @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-group text-center">
                                    <div class="g-recaptcha" data-theme="dark" data-sitekey="{{ config('services.recaptcha.site') }}" data-callback="recaptchaSuccess"></div>
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="text-danger d-block mt-2">
                                            {{ $errors->first('g-recaptcha-response') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                                
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary-custom btn-md submit-btn" id="submitBtn" disabled>
                                    <span class="spinner" style="display: none;">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                    <i class="fas fa-paper-plane fa-sm text-light me-2"></i><span class="btn-text text-light">Send Messages</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Contact Info -->
                <div class="row mt-5 text-center">
                    <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="contact-info-item">
                            <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                            <h5>Email</h5>
                            <a href="mailto:{{ $user->email ?? 'joedhellloydobordo@gmail.com'}}" class="text-decoration-none">
                                {{ $user->email ?? 'joedhellloydobordo@gmail.com'}}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="contact-info-item">
                            <i class="fas fa-phone fa-2x text-primary mb-3"></i>
                            <h5>Phone</h5>
                            <a href="tel:{{ $professionalSummary->phone ?? '+1 (234) 567-8900' }}" class="text-decoration-none">
                                {{ $professionalSummary->phone ?? '+1 (234) 567-8900' }}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="300">
                        <div class="contact-info-item">
                            <i class="fas fa-map-marker-alt fa-2x text-primary mb-3"></i>
                            <h5>Location</h5>
                            <p class="mb-0">{{ $professionalSummary->address ?? 'Your City, Country' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="400">
                    <h5 class="mb-3">Follow Me</h5>
                    <div class="social-links">
                        <a href="{{ $professionalSummary->linkedin ?? '#' }}" class="btn btn-outline-primary btn-lg me-2" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="{{ $professionalSummary->github ?? '#' }}" class="btn btn-outline-secondary btn-lg me-2" target="_blank">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://www.tiktok.com/@lloydtech24" class="btn btn-outline-info btn-lg me-2" target="_blank">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="https://instagram.com/yourusername" class="btn btn-outline-danger btn-lg" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- Google reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("contactForm");
        const submitBtn = document.getElementById("submitBtn");
        const spinner = submitBtn.querySelector(".spinner");
        const btnText = submitBtn.querySelector(".btn-text");

        function recaptchaSuccess() {
            submitBtn.disabled = false;
        }

        form.addEventListener("submit", function() {
            spinner.style.display = "inline-block";
            btnText.textContent = "Sending...";
            submitBtn.disabled = true;
        });

        // Make recaptchaSuccess available globally
        window.recaptchaSuccess = recaptchaSuccess;
    });
</script>
@endsection