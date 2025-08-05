@extends('partials.master')

@section('content')
<!-- Projects Section - Fixed Version -->
<section id="projects" class="projects-section section-padding bg-dark-custom" style="position: relative; min-height: 100vh; padding-top: 80px;">
    <div id="particles-js"></div>
    <div class="container">
        <!-- Title Section - Added pt-5 for extra padding -->
        <div class="row pt-5">
            <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                <h1 class="display-5 fw-bold">All Projects</h1>
                <p class="lead text-muted">Explore my complete portfolio</p>
            </div>
        </div>
        
        <!-- Category Filter -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-lg-12">
                <div class="d-flex justify-content-center flex-wrap">
                    <a href="{{ route('projects') }}" class="btn btn-outline-secondary mx-2 mb-2 @if(!request()->has('category')) active @endif">
                        All Projects
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('projects', ['category' => $category]) }}" 
                       class="btn btn-outline-secondary mx-2 mb-2 @if(request()->input('category') == $category) active @endif">
                        {{ $category }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Projects Grid -->
        @if($projects->count() > 0)
        <div class="row g-4">
            @foreach($projects as $project)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                <a href="{{ route('project.show', ['id' => $project->id, 'title' => Str::slug($project->title)]) }}" class="text-decoration-none">
                    <div class="card project-card h-100 border-0 shadow-sm">
                        @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top" alt="{{ $project->title }}" 
                            style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $project->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($project->description, 100) }}</p>
                            <div class="mb-3">
                                @foreach($project->technologies as $tech)
                                <span class="badge bg-primary me-1 mb-1">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-lg-12 d-flex justify-content-center">
                {{ $projects->links() }}
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="alert alert-info">
                    No projects found in this category.
                </div>
                <a href="{{ route('projects') }}" class="btn btn-primary-custom">
                    View All Projects
                </a>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection