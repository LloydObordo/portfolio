<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Education;
use Carbon\Carbon;

class EducationsController extends Controller
{
    public function index()
    {
        // Get all education values
        $educations = Education::getEnumValues('degree');
        return view('admin.educations', compact('educations'));
    }

    public function showEducationsData(Request $request)
    {
        try{
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'institutionFilter' => 'nullable|string',
                'degreeFilter' => 'nullable|string',
                'fieldFilter' => 'nullable|string',
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

            // Query the database
            $query = Education::query();

            // Apply Filters
            if (($validated['institutionFilter'] ?? 'all') != 'all') {
                $query->where('institution', $validated['institutionFilter']);
            }

            if (($validated['degreeFilter'] ?? 'all') != 'all') {
                $query->where('degree', $validated['degreeFilter']);
            }

            if (($validated['fieldFilter'] ?? 'all') != 'all') {
                $query->where('field', $validated['fieldFilter']);
            }

            if ($request->has('startDateFilter') && $request->has('endDateFilter') && $validated['startDateFilter'] != null && $validated['endDateFilter'] != null) {
                $startDate = Carbon::createFromFormat('Y-m-d', $validated['startDateFilter'])->startOfDay();
                $endDate = Carbon::createFromFormat('Y-m-d', $validated['endDateFilter'])->endOfDay();
                $query->whereBetween('date_issued', [$startDate, $endDate]);
            }

            if (($validated['isCurrentFilter'] ?? 'all') != 'all') {
                $query->where('is_current', $validated['isCurrentFilter']);
            }

            if (($validated['orderFilter'] ?? 'all') != 'all') {
                $query->where('order', $validated['orderFilter']);
            }

            // Sorting
            $orderableColumns = ['id', 'institution', 'degree', 'field', 'start_date', 'end_date', 'is_current', 'order'];

            if ($request->has('order') && count($request->input('order'))) {
                $order = $request->input('order.0');
                if (isset($orderableColumns[$order['column']])) {
                    $query->orderBy($orderableColumns[$order['column']], $order['dir']);
                }
            } else {
                $query->orderBy('id', 'desc')->orderBy('created_at', 'desc');
            }

            // Pagination and response
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
                'data' => $data->map(function ($item) use ($isSingleResult){
                    // Determine remarks with HTML badges
                    $remarks = "";
                    $status = "";

                    if ($item->is_current == 0) {
                        $remarks = '<span class="badge badge-dark">No</span>';
                    } else {
                        $remarks = '<span class="badge badge-success">Yes</span>';
                    }

                    if ($item->active == 0) {
                        $status = '<span class="badge badge-danger">Inactive</span>';
                    } else {
                        $status = '<span class="badge badge-success">Active</span>';
                    }

                    $itemData = [
                        'id' => $item->id,
                        'institution' => $item->institution,
                        'degree' => $item->degree,
                        'field_of_study' => $item->field_of_study,
                        'start_date' => $item->start_date ? Carbon::parse($item->start_date)->format('Y-m-d') : null,
                        'end_date' => $item->end_date ? Carbon::parse($item->end_date)->format('Y-m-d') : null,
                        'is_current' => $item->is_current,
                        'order' => $item->order,
                        'description' => $item->description,
                        'details' => $item->degree ? $item->abbreviation . ' - ' . $item->field_of_study : $item->field_of_study
                    ];

                    $jsonItemData = htmlspecialchars(json_encode($itemData), ENT_QUOTES, 'UTF-8');

                    // Action HTML - different depending on if we have a single result
                    $action = '';
                    
                    if ($isSingleResult) {
                        // For single result, show buttons in a row
                        $action = '<div class="btn-group btn-group-sm">';
                        
                        // Edit button - only show if active = 1
                        if ($item->active == 1) {
                            $action .= '<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_item_modal" 
                                    data-item="' . $jsonItemData . '">
                                    <i class="fas fa-edit"></i> Edit
                                    </button>';
                        }
                        
                        // Delete button - only show if active = 1
                        if ($item->active == 1) {
                            $action .= '<button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#delete_item_modal" 
                                    data-item="' . $jsonItemData . '">
                                    <i class="fas fa-trash-alt"></i> Delete
                                    </button>';
                        }
                        
                        // Restore button - only show if active = 0
                        if ($item->active == 0) {
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
                        if ($item->active == 1) {
                            $action .= '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_item_modal" 
                                        data-item="' . $jsonItemData . '">
                                        <i class="fas fa-edit mr-2"></i>Edit
                                        </a>';
                        }

                        // Delete Mobility button - only show if active = 1
                        if ($item->active == 1) {
                            $action .= '<a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#delete_item_modal" 
                                        data-item="' . $jsonItemData . '">
                                        <i class="fas fa-trash-alt mr-2"></i>Delete
                                        </a>';
                        }

                        // Restore Mobility button - only show if active = 0
                        if ($item->active == 0) {
                            $action .= '<a class="dropdown-item text-warning" href="#" data-toggle="modal" data-target="#restore_item_modal" 
                                        data-item="' . $jsonItemData . '">
                                        <i class="fas fa-undo mr-2"></i>Restore
                                        </a>';
                        }

                        $action .= '</div></div>';
                    }

                    // Return the formatted data
                    return [
                        'id' => $item->id ? $item->id : '',
                        'institution' => $item->institution ? $item->institution : '',
                        'degree' => $item->degree ? $item->degree_description : '',
                        'field' => $item->field_of_study ? $item->field_of_study : '',
                        'start_date' => $item->start_date ? $item->start_date->format('F j, Y') : '-',
                        'end_date' => $item->end_date ? $item->end_date->format('F j, Y') : '-',
                        'is_current' => $remarks,
                        'order' => $item->order ? $item->order : '',
                        'status' => $status,
                        'action' => $action
                    ];
                })
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in postMobilityData: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return response()->json([
                'message' => 'An error occurred while processing the request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request) {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'institution' => 'required|string|max:255',
                'degree' => 'required|string|max:255',
                'field_of_study' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_current' => 'required|boolean|in:0,1',
                'order' => 'required|integer',
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

            // Create the record
            $education = Education::create($validated);

            return response()->json([
                'message' => 'Education added successfully',
                'education' => $education
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error occurred while storing: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while processing the request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request) {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:educations,id',
                'institution' => 'required|string|max:255',
                'degree' => 'required|string|max:255',
                'field_of_study' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_current' => 'required|boolean|in:0,1',
                'order' => 'required|integer',
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

            // Update the record
            $education = Education::findOrFail($validated['id']);
            $education->update($validated);

            return response()->json([
                'message' => 'Education updated successfully',
                'education' => $education
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error occurred while updating: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while processing the request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request) {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:educations,id',
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
            $education = Education::withTrashed()->findOrFail($validated['id']);
            $education->update(['active' => 0]);
            $education->delete();

            return response()->json([
                'message' => 'Education deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error occurred while deleting: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while processing the request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function restore(Request $request) {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:educations,id',
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
            $education = Education::withTrashed()->findOrFail($validated['id']);
            $education->restore();
            $education->update(['active' => 1]);

            return response()->json([
                'message' => 'Education restored successfully'
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error occurred while restoring: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while processing the request: ' . $e->getMessage()
            ], 500);
        }
    }
}
