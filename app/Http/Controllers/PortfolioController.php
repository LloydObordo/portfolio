<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\ProfessionalSummary;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Education;
use App\Models\Inbox;
use App\Mail\ContactNotification;
use Illuminate\Support\Facades\Http;
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
        $skills = Skill::orderBy('category')->ordered()->get()->groupBy('category');
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

    public function sendContact(Request $request)
    {
        // dd($request->all());
        // Begin a database transaction
        DB::beginTransaction();

        try {
            // Validate input with custom error messages
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:150',
                'subject' => 'nullable|string|max:255',
                'message' => 'required|string',
                // 'g-recaptcha-response' => 'required'
            ], [
                'name.required' => 'Name is required.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please provide a valid email address.',
                'message.required' => 'Message content is required.',
                // 'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // // Validate reCAPTCHA response with Google
            // $recaptchaResponse = $request->input('g-recaptcha-response');
            // $recaptchaSecret = config('services.recaptcha.secret');

            // $googleResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            //     'secret' => $recaptchaSecret,
            //     'response' => $recaptchaResponse,
            //     'remoteip' => $request->ip(),
            // ]);

            // $responseBody = $googleResponse->json();

            // if (!isset($responseBody['success']) || !$responseBody['success']) {
            //     return redirect()->back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.'])->withInput();
            // }

            // Retrieve validated data
            $validated = $validator->validated();

            // Save the Contact Us record
            $inbox = Inbox::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'] ?? null,
                'message' => $validated['message'],
                'is_read' => false,
            ]);

            // Prepare details for email
            $details = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'] ?? '',
                'message' => $validated['message']
            ];

            // Attempt to send the email within a nested try-catch block
            try {
                // Pass the details array to the constructor
                Mail::to('joedhellloydobordo@gmail.com')->send(new ContactNotification($details));
            } catch (\Exception $mailException) {
                \Log::error('Failed to send email notification: ' . $mailException->getMessage());
                return redirect()->back()->with('error', 'Your message was saved, but there was an error sending the notification email. Please contact support.');
            }

            // Commit transaction after successful save
            DB::commit();

            // Redirect with success message and anchor to #contact
            return redirect()->back()->with([
                'success' => 'Your message has been sent successfully!',
            ])->withFragment('contact');

        } catch (\Exception $e) {
            // Catch other exceptions, rollback and log the error
            DB::rollBack();
            \Log::error('Failed to send contact message: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while sending your message. Please try again.');
        }
    }
}
