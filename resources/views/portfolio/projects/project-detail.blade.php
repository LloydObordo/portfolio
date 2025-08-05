@extends('partials.master')

<style>
    .accordion-button:not(.collapsed) {
        color: var(--primary-color);
        background-color: rgba(59, 130, 246, 0.1);
    }
    
    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
    }
    
    .project-image {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .project-image img {
        transition: transform 0.5s ease;
    }
    
    .project-image:hover img {
        transform: scale(1.03);
    }

    .project-gallery {
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .carousel-indicators button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.5) !important;
        border: none;
        margin: 0 5px;
    }
    
    .carousel-indicators button.active {
        background-color: var(--primary-color) !important;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
        opacity: 0.8;
    }
    
    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
    }
    
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 2rem;
        height: 2rem;
    }
    
    /* Animation for slide transition */
    .carousel-item {
        transition: transform 0.6s ease-in-out;
    }
</style>

@section('content')
<!-- Project Detail Section -->
<section id="project-detail" class="project-detail-section section-padding bg-dark-custom" style="position: relative; min-height: 100vh; padding-top: 80px;">
    <div id="particles-js"></div>
    <div class="container">
        <!-- Project Header -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold">{{ $project->title }}</h1>
                <p class="lead text-light mb-4">{{ $project->description }}</p>
                <div class="d-flex justify-content-center gap-3 d-none">
                    @if($project->live_url)
                    <a href="{{ $project->live_url }}" class="btn btn-primary-custom" target="_blank">
                        <i class="fas fa-external-link-alt me-1 text-light"></i><span class="text-light">Live Demo</span>
                    </a>
                    @endif
                    @if($project->github_url)
                    <a href="{{ $project->github_url }}" class="btn btn-outline-light" target="_blank">
                        <i class="fab fa-github me-1 text-light"></i> View Code
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Project Content -->
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8" data-aos="fade-up">
                @if(is_array($project->gallery) && count($project->gallery) > 0)
                <div class="project-gallery mb-5 rounded-3 overflow-hidden shadow-lg">
                    <div id="projectGallery" class="carousel slide" data-bs-ride="carousel">
                        <!-- Indicators -->
                        <div class="carousel-indicators">
                            @foreach($project->gallery as $key => $image)
                            <button type="button" data-bs-target="#projectGallery" data-bs-slide-to="{{ $key }}" 
                                    class="{{ $key === 0 ? 'active' : '' }}" aria-current="{{ $key === 0 ? 'true' : '' }}" 
                                    aria-label="Slide {{ $key + 1 }}"></button>
                            @endforeach
                        </div>
                        
                        <!-- Slides -->
                        <div class="carousel-inner">
                            @foreach($project->gallery as $key => $image)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                <a href="{{ asset('storage/' . $image) }}" data-fancybox="project-gallery" data-caption="{{ $project->title }} - Image {{ $key + 1 }}">
                                    <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" 
                                        alt="{{ $project->title }} - Image {{ $key + 1 }}" 
                                        style="max-height: 500px; object-fit: cover;">
                                </a>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#projectGallery" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#projectGallery" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                @elseif($project->image)
                <!-- Fallback to single image if no gallery -->
                <div class="project-image mb-5 rounded-3 overflow-hidden shadow-lg">
                    <a href="{{ asset('storage/' . $project->image) }}" data-fancybox="project-gallery" data-caption="{{ $project->title }}">
                        <img src="{{ asset('storage/' . $project->image) }}" class="img-fluid w-100" 
                            alt="{{ $project->title }}" style="max-height: 500px; object-fit: cover;">
                    </a>
                </div>
                @endif

                <div class="card project-card bg-transparent border-0">
                    <div class="card-body">
                        <h3 class="fw-bold mb-4">Project Overview</h3>
                        <div class="project-description mb-5 text-justify">
                            {!! nl2br(e($project->detailed_description)) !!}
                        </div>

                        @if($project->features && count($project->features) > 0)
                        <div class="project-features mb-5">
                            <h4 class="fw-bold mb-3">Key Features</h4>
                            <ul class="list-unstyled">
                                @foreach($project->features as $feature)
                                <li class="mb-2 d-flex">
                                    <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                    <span>{{ $feature }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if($project->challenges && count($project->challenges) > 0)
                        <div class="project-challenges mb-5">
                            <h4 class="fw-bold mb-3">Challenges & Solutions</h4>
                            <div class="accordion" id="challengesAccordion">
                                @foreach($project->challenges as $index => $challenge)
                                <div class="accordion-item bg-transparent border-light mb-2">
                                    <h2 class="accordion-header" id="heading{{ $index }}">
                                        <button class="accordion-button bg-transparent text-light collapsed" type="button" 
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" 
                                                aria-expanded="false" aria-controls="collapse{{ $index }}">
                                            Challenge #{{ $index + 1 }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $index }}" class="accordion-collapse collapse" 
                                        aria-labelledby="heading{{ $index }}" data-bs-parent="#challengesAccordion">
                                        <div class="accordion-body">
                                            {!! nl2br(e($challenge)) !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Project Meta -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card project-card bg-transparent border-light mb-4">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Project Details</h4>
                        
                        <div class="mb-4">
                            <h5 class="fw-bold mb-2">Category</h5>
                            <p class="mb-0">{{ $project->category }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <h5 class="fw-bold mb-2">Date</h5>
                            <p class="mb-0">{{ $project->created_at->format('F Y') }}</p>
                        </div>
                        
                        @if($project->client)
                        <div class="mb-4">
                            <h5 class="fw-bold mb-2">Client</h5>
                            <p class="mb-0">{{ $project->client }}</p>
                        </div>
                        @endif
                        
                        @if($project->duration)
                        <div class="mb-4">
                            <h5 class="fw-bold mb-2">Duration</h5>
                            <p class="mb-0">{{ $project->duration }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                @if(count($project->technologies) > 0)
                <div class="card project-card bg-transparent border-light mb-4">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Technologies Used</h4>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($project->technologies as $tech)
                            <span class="badge bg-primary">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Related Projects -->
        @if($relatedProjects->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="fw-bold mb-4">Related Projects</h3>
                <div class="row g-4">
                    @foreach($relatedProjects as $relatedProject)
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <a href="{{ route('project.show', ['id' => $relatedProject->id, 'title' => Str::slug($relatedProject->title)]) }}" class="text-decoration-none">
                        <div class="card project-card h-100 border-0 shadow-sm">
                            @if($relatedProject->image)
                            <img src="{{ asset('storage/' . $relatedProject->image) }}" class="card-img-top" alt="{{ $relatedProject->title }}" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">{{ $relatedProject->title }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($relatedProject->description, 100) }}</p>
                            </div>
                        </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection