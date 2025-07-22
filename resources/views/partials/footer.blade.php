<footer class="bg-dark text-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5 class="fw-bold mb-3">
                    @php
                        $nameParts = explode(' ', $professionalSummary->shortname ?? 'Lloyd Obordo');
                        $firstName = array_shift($nameParts) ?? '';
                        $lastName = implode(' ', $nameParts);
                    @endphp
                    <img src="{{asset('images/logo.png')}}" alt="Logo" height="30">
                    <span class="text-primary">{{ $firstName }}</span>{{ $lastName }}
                </h5>
                <p class="text-muted text-justify">
                    {{ $professionalSummary->summary ?? 'A passionate full-stack developer with over 5 years of experience creating web applications that solve real-world problems.' }}
                </p>
                <div class="social-links">
                    <a href="{{ $professionalSummary->linkedin ?? '#' }}" class="text-light me-3" target="_blank">
                        <i class="fab fa-linkedin fa-lg"></i>
                    </a>
                    <a href="{{ $professionalSummary->github ?? '#' }}" class="text-light me-3" target="_blank">
                        <i class="fab fa-github fa-lg"></i>
                    </a>
                    <a href="https://www.tiktok.com/@lloydtech24" class="text-light me-3" target="_blank">
                        <i class="fab fa-tiktok fa-lg"></i>
                    </a>
                    <a href="mailto:{{ $professionalSummary->email ?? 'joedhellloydobordo@gmail.com'}}" class="text-light" target="_blank">
                        <i class="fas fa-envelope fa-lg"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="fw-bold mb-3">Navigation</h6>
                <ul class="list-unstyled">
                    <li><a href="#home" class="text-muted text-decoration-none">Home</a></li>
                    <li><a href="#about" class="text-muted text-decoration-none">About</a></li>
                    <li><a href="#experience" class="text-muted text-decoration-none">Experience</a></li>
                    <li><a href="#projects" class="text-muted text-decoration-none">Projects</a></li>
                    <li><a href="#contact" class="text-muted text-decoration-none">Contact</a></li>
                </ul>
            </div>
            {{-- <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="fw-bold mb-3">Services</h6>
                <ul class="list-unstyled text-muted">
                    <li>Web Development</li>
                    <li>Mobile App Development</li>
                    <li>UI/UX Design</li>
                    <li>Consulting</li>
                    <li>Technical Writing</li>
                </ul>
            </div> --}}
            <div class="col-lg-4 mb-4">
                <h6 class="fw-bold mb-3">Contact Info</h6>
                <div class="text-muted">
                    <p><i class="fas fa-envelope me-2"></i> {{ $professionalSummary->email ?? 'joedhellloydobordo@gmail.com'}}</p>
                    <p><i class="fas fa-phone me-2"></i> {{ $professionalSummary->phone ?? '+1 (234) 567-8900' }}</p>
                    <p><i class="fas fa-map-marker-alt me-2"></i> {{ $professionalSummary->address ?? 'Your City, Country' }}</p>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    &copy; {{ date('Y') }} {{ $professionalSummary->shortname ?? 'Lloyd Obordo'}}. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-muted mb-0">
                    Designed and Developed by {{ $professionalSummary->shortname ?? 'Lloyd Obordo'}}
                </p>
            </div>
        </div>
    </div>
</footer>