<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\ProfessionalSummary;

class ProfessionalSummariesController extends Controller
{
    public function index()
    {
        $summary = ProfessionalSummary::first();
        return view('admin.summary', compact('summary'));
    }

    public function update(Request $request)
    {
        try {
            // Validation rules
            $rules = [
                'firstname' => 'required|string|max:100',
                'middlename' => 'nullable|string|max:100',
                'lastname' => 'required|string|max:100',
                'qualifier' => 'nullable|string|max:50',
                'shortname' => 'nullable|string|max:100',
                'biography' => 'nullable|string|max:5000',
                'summary' => 'nullable|string|max:2000',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'required|email|max:100',
                'website' => 'nullable|url|max:255',
                'linkedin' => 'nullable|url|max:255',
                'github' => 'nullable|url|max:255',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ];

            // Validate the request
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            // Get the first record or create a new one if none exists
            $summary = ProfessionalSummary::firstOrNew();

            // Handle file uploads
            if ($request->hasFile('profile_image')) {
                $validated['profile_image'] = $this->uploadFile($request->file('profile_image'), 'images/profile_image', $summary->profile_image);
            }

            if ($request->hasFile('cover_image')) {
                $validated['cover_image'] = $this->uploadFile($request->file('cover_image'), 'images/cover_image', $summary->cover_image);
            }

            if ($request->hasFile('resume')) {
                $validated['resume'] = $this->uploadFile($request->file('resume'), 'documents/resumes', $summary->resume);
            }

            if ($request->hasFile('cv')) {
                $validated['cv'] = $this->uploadFile($request->file('cv'), 'documents/cvs', $summary->cv);
            }

            // Update the record with validated data
            $summary->fill($validated)->save();

            return response()->json([
                'success' => true,
                'message' => 'Professional summary updated successfully!',
                'data' => $summary
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating your professional summary.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function uploadFile($file, $directory, $oldFilePath = null)
    {
        // Delete old file if exists
        if ($oldFilePath && Storage::exists($oldFilePath)) {
            Storage::delete($oldFilePath);
        }

        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Store the file
        $path = $file->storeAs($directory, $filename, 'public');

        return $path;
    }
}
