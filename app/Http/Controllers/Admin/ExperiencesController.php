<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Experience;
use Carbon\Carbon;

class ExperiencesController extends Controller
{
    public function index()
    {
        return view('admin.experiences');
    }

    public function showExperiencesData(Request $request)
    {
        try{
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'jobTitleFilter' => 'nullable|string',
                'descriptionFilter' => 'nullable|string',
                'companyFilter' => 'nullable|string',
                'locationFilter' => 'nullable|string',
                'startDateFilter' => 'nullable|date',
                'endDateFilter' => 'nullable|date',
                'isCurrentFilter' => 'nullable|string',
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

            // Query the database for experiences
            $query = Experience::query();

            // // Apply Filter
            // if ($validated['jobTitleFilter']) {
            //     $query->where('job_title', 'like', '%' . $validated['jobTitleFilter'] . '%');
            // }
            // if ($validated['descriptionFilter']) {
            //     $query->where('description', 'like', '%' . $validated['descriptionFilter'] . '%');
            // }
            // if ($validated['companyFilter']) {
            //     $query->where('company', 'like', '%' . $validated['companyFilter'] . '%');
            // }
            // if ($validated['locationFilter']) {
            //     $query->where('location', 'like', '%' . $validated['locationFilter'] . '%');
            // }
            // if ($request->has('startDateFilter') && $request->has('endDateFilter') && $validated['startDateFilter'] != null && $validated['endDateFilter'] != null) {
            //     $startDate = Carbon::createFromFormat('Y-m-d', $validated['startDateFilter'])->startOfDay();
            //     $endDate = Carbon::createFromFormat('Y-m-d', $validated['endDateFilter'])->endOfDay();
            //     $query->whereBetween('date_issued', [$startDate, $endDate]);
            // }
            // if ($validated['isCurrentFilter']) {
            //     $query->where('is_current', $validated['isCurrentFilter']);
            // }
            // if (($validated['orderFilter'] ?? 'all') != 'all') {
            //     $query->where('order', $validated['orderFilter']);
            // }

            // Sorting
            $orderableColumns = ['id', 'job_title', 'description', 'company', 'location', 'start_date', 'end_date', 'is_current', 'order'];

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

                    if ($item->is_current == 0) {
                        $remarks = '<span class="badge badge-dark">No</span>';
                    } else {
                        $remarks = '<span class="badge badge-success">Yes</span>';
                    }

                    if ($item->deleted_at) {
                        $status = '<span class="badge badge-dark">Inactive</span>';
                    } else {
                        $status = '<span class="badge badge-success">Active</span>';
                    }

                    $achievements = $item->achievements ?? [];

                    // $item->achievements = is_array($achievements) ? implode(', ', array_filter($achievements)) : '';

                    $itemData = [
                        'id' => $item->id,
                        'job_title' => $item->job_title,
                        'company' => $item->company,
                        'location' => $item->location,
                        'start_date' => $item->start_date ? Carbon::parse($item->start_date)->format('Y-m-d') : null,
                        'end_date' => $item->end_date ? Carbon::parse($item->end_date)->format('Y-m-d') : null,
                        'is_current' => $item->is_current,
                        'description' => $item->description,
                        'achievements' => is_array($achievements) 
                                        ? implode("\n", $achievements) 
                                        : $achievements,
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
                        'job_title' => $item->job_title ? $item->job_title : '-',
                        'company' => $item->company ? $item->company : '-',
                        'location' => $item->location ? $item->location : '-',
                        'start_date' => $item->start_date ? $item->start_date->format('F j, Y') : '-',
                        'end_date' => $item->end_date ? $item->end_date->format('F j, Y') : '-',
                        'is_current' => $remarks,
                        'description' => $item->description ? $item->description : '-',
                        'achievements' => $item->achievements,
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
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'job_title' => 'required|string|max:255',
                'company' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_current' => 'required|boolean|in:0,1',
                'order' => 'required|integer',
                'achievements' => 'nullable|string',
                'description' => 'nullable|string',
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

            // Ensure achievements is properly formatted
            if (isset($validated['achievements']) && is_string($validated['achievements'])) {
                $validated['achievements'] = array_filter(
                    array_map('trim', explode("\n", $validated['achievements'])),
                    fn($item) => !empty($item)
                );
            }

            // Create the record
            $experience = Experience::create($validated);

            return response()->json([
                'message' => 'Experience created successfully',
                'data' => $experience
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Error occurred while creating experience: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error occurred while creating experience'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:experiences,id',
                'job_title' => 'required|string|max:255',
                'company' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_current' => 'required|boolean|in:0,1',
                'order' => 'required|integer',
                'achievements' => 'nullable|string',
                'description' => 'nullable|string',
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

            // Ensure achievements is properly formatted
            if (isset($validated['achievements']) && is_string($validated['achievements'])) {
                $validated['achievements'] = array_filter(
                    array_map('trim', explode("\n", $validated['achievements'])),
                    fn($item) => !empty($item)
                );
            }

            // Update the record
            $experience = Experience::findOrFail($validated['id']);
            $experience->update($validated);

            return response()->json([
                'message' => 'Experience updated successfully',
                'data' => $experience
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error occurred while updating experience: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error occurred while updating experience'
            ], 500);
        }
    }

    public function delete(Request $request) {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:experiences,id',
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
            $experience = Experience::withTrashed()->findOrFail($validated['id']);
            $experience->delete();

            return response()->json([
                'message' => 'Experience deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error occurred while deleting: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error occurred while deleting experience'
            ], 500);
        }
    }

    public function restore(Request $request) {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:experiences,id',
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
            $experience = Experience::withTrashed()->findOrFail($validated['id']);
            $experience->restore();

            return response()->json([
                'message' => 'Experience restored successfully'
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error occurred while restoring: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error occurred while restoring experience'
            ], 500);
        }
    }
}
