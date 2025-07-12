<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user =Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // dd($request->all());
        try {
            $currentUserId = Auth::user()->id;
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$currentUserId,
            ], [
                'name.required' => 'Please enter your name.',
                'email.required' => 'Please enter your email.',
                'email.unique' => 'This email is already taken.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();
            $validated['id'] = Auth::user()->id;

            // Update user profile
            $user = User::findOrFail($validated['id']);
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            return response()->json([
                'message' => 'Profile updated successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the profile.'], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|string',
                'new_password' => [
                    'required',
                    'string',
                    'min:12',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$_%]).+$/',
                    'different:current_password',
                ],
                'confirm_password' => 'required|same:new_password',
            ], [
                'current_password.required' => 'Please enter your current password.',
                'new_password.required' => 'Please enter a new password.',
                'new_password.min' => 'Password must be at least 12 characters long.',
                'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
                'confirm_password.required' => 'Please confirm your new password.',
                'confirm_password.same' => 'Passwords do not match.',
                'new_password.different' => 'New password must be different from the current password.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();
            $validated['id'] = Auth::user()->id;

            // Update user password
            $user = User::findOrFail($validated['id']);
            if (!Hash::check($validated['current_password'], $user->password)) {
                return response()->json([
                    'errors' => [
                        'current_password' => ['The provided password is incorrect.']
                    ]
                ], 422);
            }
            $user->update([
                'password' => Hash::make($validated['new_password']),
                'default_password' => 0,
                'remember_token' => null,
            ]);

            return response()->json([
                'message' => 'Password changed successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error changing password: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while changing the password.'], 500);
        }
    }

    public function changePicture(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'cropped_image' => 'required|string', // Base64 image as a string
            ]);
    
            // Get the authenticated user
            $user = Auth::user();
    
            // Decode base64 image
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $request->cropped_image);
            $imageData = str_replace(' ', '+', $imageData);
            $decodedImage = base64_decode($imageData);
    
            if (!$decodedImage) {
                return response()->json(['error' => 'Invalid image data.'], 400);
            }
    
            // Generate a unique filename
            $imageName = 'profile_' . $user->id . '_' . time() . '.jpg';
    
            // Delete the previous profile picture if it exists
            if ($user->profile_picture && Storage::disk('public')->exists('profile/' . $user->profile_picture)) {
                Storage::disk('public')->delete('profile/' . $user->profile_picture);
            }
    
            // Store the new file explicitly in the `public` disk
            Storage::disk('public')->put('profile/' . $imageName, $decodedImage);
    
            // Update user's profile picture path
            $user->update([
                'profile_picture' => $imageName,
            ]);
    
            return response()->json([
                'message' => 'Profile picture updated successfully.',
                'profile_picture' => asset('storage/' . $user->profile_picture),
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error changing profile picture: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the profile picture.'], 500);
        }
    }
}
