<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ProfessionalSummary;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Education;
use Auth;
use DateTime;

class PortfolioController extends Controller
{
    public function index()
    {
        $experiences = Experience::ordered()->get();

        // Calculate total experience in years with decimal
        $totalExperienceDecimal = 0;
        foreach ($experiences as $experience) {
            $start = new DateTime($experience->start_date);
            $end = $experience->end_date ? new DateTime($experience->end_date) : new DateTime();
            
            $interval = $start->diff($end);
            $totalExperienceDecimal += $interval->y; // Add years
            $totalExperienceDecimal += $interval->m / 12; // Add months as fraction of year
        }
        
        // Format the experience for display
        $totalYears = floor($totalExperienceDecimal);
        $totalExperience = $totalYears . '+ Years';
        
        // Keep the decimal value in case you need it for calculations elsewhere
        $rawTotalExperience = round($totalExperienceDecimal, 1);

        $featuredProjects = Project::featured()->ordered()->limit(6)->get();
        $skills = Skill::orderBy('category')->orderBy('order', 'asc')->get()->groupBy('category');
        $professionalSummary = ProfessionalSummary::first();
        $education = Education::where('active', true)->where('is_current', 1)->first();

        if ($education) {
            $education->abbreviation; // Will automatically use the accessor
        }

        $projectCount = Project::count();

        return view('portfolio.index', compact(
            'experiences', 'featuredProjects', 'skills', 'professionalSummary', 'education', 'totalExperience', 'rawTotalExperience', 'projectCount'
        ));
    }

    public function projects(Request $request)
    {
        $query = Project::ordered();
        
        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        $projects = $query->paginate(12);
        $categories = Project::distinct('category')->pluck('category');

        return view('portfolio.projects', compact('projects', 'categories'));
    }

    public function project($id)
    {
        $project = Project::findOrFail($id);
        $relatedProjects = Project::where('category', $project->category)
                                ->where('id', '!=', $project->id)
                                ->limit(3)->get();

        return view('portfolio.project-detail', compact('project', 'relatedProjects'));
    }

    public function downloadResume()
    {
        // Get the resume record
        $professionalSummary = ProfessionalSummary::first();
        
        if (!$professionalSummary || !$professionalSummary->resume) {
            abort(404, 'Resume not found');
        }

        // Get the full path to the file
        $filePath = storage_path('app/public/' . $professionalSummary->resume);
        
        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        // Extract the original filename from the stored path if needed
        // $originalName = basename($professionalSummary->resume);
        
        // Or use a custom filename
        $downloadName = $professionalSummary->shortname . '_resume.pdf'; // Change this to whatever you want
        
        return response()->download($filePath, $downloadName, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
