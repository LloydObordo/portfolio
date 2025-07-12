<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use Carbon\Carbon;


class ProjectsController extends Controller
{
    public function index()
    {
        return view('admin.projects');
    }

    public function showProjectsData(Request $request)
    {
        try{
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'titleFilter' => 'nullable|string',
                'descriptionFilter' => 'nullable|string',
                'technologyFilter' => 'nullable|string',
                'featuredFilter' => 'nullable|string',
                'orderFilter' => 'nullable|string',
                'start' => 'integer|min:0',
                'length' => 'integer|min:1|max:500',
                'draw' => 'required|integer',
                'order' => 'nullable|array',
                'order.0.column' => 'nullable|integer',
                'order.0.dir' => 'nullable|in:asc,desc'
            ]);

            // Handle validation errors
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get the validated data
            $validated = $validator->validated();

            // Set a reasonable timeout for database queries
            DB::statement('SET SESSION wait_timeout=120');

            // Query the database for projects
            $query = Project::query();

            // // Apply Filter
            // if ($request->filled('titleFilter')) {
            //     $query->where('title', 'like', '%' . $request->input('titleFilter') . '%');
            // }
            // if ($request->filled('descriptionFilter')) {
            //     $query->where('description', 'like', '%' . $request->input('descriptionFilter') . '%');
            // }
            // if ($request->filled('technologyFilter')) {
            //     $query->where('technology', 'like', '%' . $request->input('technologyFilter') . '%');
            // }
            // if ($request->filled('featuredFilter')) {
            //     $query->where('featured', $request->input('featuredFilter'));
            // }
            // if ($request->filled('orderFilter')) {
            //     $query->orderBy('order', $request->input('orderFilter'));
            // }

            // Sorting
            $orderableColumns = ['id', 'title', 'description', 'technologies', 'featured', 'order', 'created_at'];

            if ($request->has('order') && count($request->input('order'))) {
                $order = $request->input('order.0');
                if (isset($orderableColumns[$order['column']])) {
                    $query->orderBy($orderableColumns[$order['column']], $order['dir']);
                }
            } else {
                $query->orderBy('id', 'desc')->orderBy('created_at', 'desc');
            }

            // Count the total number of experiences
            $totalData = $query->count();

            // Get the requested page data
            $start = $request->input('start', 0);
            $length = $request->input('length', 20);
            $data = $query->skip($start)->take($length)->withTrashed()->get();

            // Check if current page has exactly one result
            $isSingleResult = ($data->count() === 1 OR $data->count() === 2);

            return response()->json([
                'draw' => intval($validated['draw']),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalData,
                'data' => $data->map(function ($item) use ($isSingleResult) {
                    // Determine remarks with HTML badges
                    $remarks = "";
                    $status = "";

                    if ($item->featured == 0) {
                        $remarks = '<span class="badge badge-dark">No</span>';
                    } else {
                        $remarks = '<span class="badge badge-success">Yes</span>';
                    }

                    if ($item->deleted_at) {
                        $status = '<span class="badge badge-dark">Inactive</span>';
                    } else {
                        $status = '<span class="badge badge-success">Active</span>';
                    }

                    $technologies = $item->technologies ?? [];

                    $item->technologies = is_array($technologies) ? implode(', ', array_filter($technologies)) : '';

                    $image = $item->image
                        ? sprintf(
                            '<a href="%s" data-fancybox="photos" data-caption="%s">
                                <img src="%s" alt="Attachment" style="max-height: 120px;" class="img-fluid img-thumbnail">
                            </a>',
                            asset('storage/' . $item->image),  // Link href
                            basename($item->image), // Caption (using basename to get filename)
                            asset('storage/' . $item->image)  // Image src
                        )
                        : '<span class="badge badge-danger">No Attachment</span>';

                    $itemData = [
                        'id' => $item->id,
                        'title' => $item->title,
                        'description' => $item->description,
                        'detailed_description' => $item->detailed_description,
                        'technologies' => $item->technologies,
                        'image' => $item->image ? asset('storage/' . $item->image) : null,
                        'gallery' => $item->gallery ? array_map(function($image) {
                            return [
                                'id' => $image,
                                'url' => asset('storage/' . $image),
                                'thumbnail' => asset('storage/' . $image)
                            ];
                        }, json_decode($item->gallery, true) ?? []) : [],
                        'live_url' => $item->live_url,
                        'github_url' => $item->github_url,
                        'category' => $item->category,
                        'featured' => $item->featured,
                        'order' => $item->order,
                    ];

                    $jsonItemData = htmlspecialchars(json_encode($itemData), ENT_QUOTES, 'UTF-8');

                    // Action HTML - different depending on if we have a single result
                    $action = '';
                    
                    if ($isSingleResult) {
                        // For single result, show buttons in a row
                        $action = '<div class="btn-group btn-group-sm">';
                        
                        // Edit button - only show if active = 1
                        if ($item->deleted_at == null) {
                            $action .= '<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_item_modal" 
                                    data-item="' . $jsonItemData . '">
                                    <i class="fas fa-edit"></i> Edit
                                    </button>';
                        }
                        
                        // Delete button - only show if active = 1
                        if ($item->deleted_at == null) {
                            $action .= '<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete_item_modal" 
                                    data-item="' . $jsonItemData . '">
                                    <i class="fas fa-trash-alt"></i> Delete
                                    </button>';
                        }
                        
                        // Restore button - only show if active = 0
                        if ($item->deleted_at != null) {
                            $action .= '<button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#restore_item_modal" 
                                    data-item="' . $jsonItemData . '">
                                    <i class="fas fa-undo"></i> Restore
                                    </button>';
                        }
                        
                        $action .= '</div>';
                    } else {
                        // Standard dropdown for multiple results
                        $action = '<div class="dropdown btn-group">
                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown' . $item->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionDropdown' . $item->id . '">';

                        // Edit Mobility button - only show if active = 1
                        if ($item->deleted_at == null) {
                            $action .= '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_item_modal" 
                                        data-item="' . $jsonItemData . '">
                                        <i class="fas fa-edit mr-2"></i>Edit
                                        </a>';
                        }

                        // Delete Mobility button - only show if active = 1
                        if ($item->deleted_at == null) {
                            $action .= '<a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#delete_item_modal" 
                                        data-item="' . $jsonItemData . '">
                                        <i class="fas fa-trash-alt mr-2"></i>Delete
                                        </a>';
                        }

                        // Restore Mobility button - only show if active = 0
                        if ($item->deleted_at != null) {
                            $action .= '<a class="dropdown-item text-warning" href="#" data-toggle="modal" data-target="#restore_item_modal" 
                                        data-item="' . $jsonItemData . '">
                                        <i class="fas fa-undo mr-2"></i>Restore
                                        </a>';
                        }

                        $action .= '</div></div>';
                    }

                    // Return the formatted data
                    return [
                        'id' => $item->id ? $item->id : '-',
                        'title' => $item->title ? $item->title : '-',
                        'description' => $item->description ? $item->description : '-',
                        'technologies' => $item->technologies ? $item->technologies : '-',
                        'image' => $item->image ? $image : '-',
                        'category' => $item->category ? $item->category : '-',
                        'featured' => $item->featured ? $item->featured : '-',
                        'order' => $item->order,
                        'status' => $status,
                        'action' => $action,
                    ];
                })
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error occurred while fetching experiences: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error occurred while fetching experiences'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'description' => 'required|string',
                'detailed_description' => 'required|string',
                'technologies' => 'required|string',
                'live_url' => 'nullable|string',
                'github_url' => 'nullable|string',
                'featured' => 'required|boolean',
                'order' => 'required|integer',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle validation errors
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get the validated data
            $validated = $validator->validated();

            // Set a reasonable timeout for database queries
            DB::statement('SET SESSION wait_timeout=120');

            // convert technologies to array
            if(isset($validated['technologies'])) {
                $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
            } else {
                $validated['technologies'] = [];
            }

            // Create a new project
            $project = Project::create($validated);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $this->uploadFile($request->file('image'), 'projects/images');
                $project->image = $imagePath;
                $project->save();
            }

            // Handle gallery upload
            if ($request->hasFile('gallery')) {
                $galleryPaths = [];

                foreach ($request->file('gallery') as $file) {
                    $path = $this->uploadFile($file, 'projects/gallery');
                    $galleryPaths[] = $path;
                }

                // Save as JSON array
                $project->gallery = json_encode($galleryPaths);
                $project->save();
            }

            return response()->json([
                'message' => 'Project created successfully',
                'data' => $project
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error occurred while creating project: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error occurred while creating project'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            // Validate request data
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                'title' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'description' => 'required|string',
                'detailed_description' => 'required|string',
                'technologies' => 'required|string',
                'live_url' => 'nullable|string',
                'github_url' => 'nullable|string',
                'featured' => 'required|boolean',
                'order' => 'required|integer',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'deleted_gallery_images' => 'nullable|array',
                'deleted_gallery_images.*' => 'string',
                'remove_main_image' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $validated = $validator->validated();

            DB::beginTransaction();

            try {
                // Convert technologies to array
                $validated['technologies'] = isset($validated['technologies']) 
                    ? array_map('trim', explode(',', $validated['technologies'])) 
                    : [];

                $project = Project::findOrFail($validated['id']);

                // Handle main image update/removal
                if ($request->hasFile('image')) {
                    // Delete old image if it exists
                    if ($project->image && Storage::disk('public')->exists($project->image)) {
                        Storage::disk('public')->delete($project->image);
                    }
                    $imagePath = $this->uploadFile($request->file('image'), 'projects/images');
                    $validated['image'] = $imagePath;
                } elseif ($request->has('remove_main_image') && $request->remove_main_image) {
                    // Handle explicit image removal
                    if ($project->image && Storage::disk('public')->exists($project->image)) {
                        Storage::disk('public')->delete($project->image);
                    }
                    $validated['image'] = null;
                }

                // Handle gallery images
                $currentGallery = $project->gallery ? json_decode($project->gallery, true) : [];
                
                // Ensure currentGallery is an array
                if (!is_array($currentGallery)) {
                    $currentGallery = [];
                }

                // Process deleted gallery images
                if ($request->has('deleted_gallery_images') && is_array($request->deleted_gallery_images)) {
                    foreach ($request->deleted_gallery_images as $deletedImage) {
                        // Remove from storage
                        if (Storage::disk('public')->exists($deletedImage)) {
                            Storage::disk('public')->delete($deletedImage);
                        }
                        
                        // Remove from current gallery array
                        $currentGallery = array_filter($currentGallery, function($image) use ($deletedImage) {
                            return $image !== $deletedImage;
                        });
                    }
                }

                // Process new gallery images
                if ($request->hasFile('gallery')) {
                    foreach ($request->file('gallery') as $file) {
                        $path = $this->uploadFile($file, 'projects/gallery');
                        $currentGallery[] = $path;
                    }
                }

                // Re-index array and encode to JSON
                $validated['gallery'] = json_encode(array_values($currentGallery));

                // Update the project
                $project->update($validated);

                DB::commit();

                return response()->json([
                    'message' => 'Project updated successfully',
                    'data' => $project->fresh()
                ], 200);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            \Log::error('Error occurred while updating project: ' . $e->getMessage(), [
                'project_id' => $request->id,
                'error' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'Error occurred while updating project: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request) 
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:projects,id',
            ]);

            // Handle validation errors
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get the validated data
            $validated = $validator->validated();

            // Set a reasonable timeout for database queries
            DB::statement('SET SESSION wait_timeout=120');

            // Delete the record
            $project = Project::withTrashed()->findOrFail($validated['id']);
            $project->delete();

            return response()->json([
                'message' => 'Project deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error occurred while deleting: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error occurred while deleting project'
            ], 500);
        }
    }

    public function restore(Request $request) {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:projects,id',
            ]);

            // Handle validation errors
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get the validated data
            $validated = $validator->validated();

            // Set a reasonable timeout for database queries
            DB::statement('SET SESSION wait_timeout=120');

            // Restore the record
            $project = Project::withTrashed()->findOrFail($validated['id']);
            $project->restore();

            return response()->json([
                'message' => 'Project restored successfully'
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error occurred while restoring: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error occurred while restoring project'
            ], 500);
        }
    }

    private function uploadFile($file, $directory)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Store the file in the public disk
        $path = $file->storeAs($directory, $filename, 'public');

        return $path;
    }
}
