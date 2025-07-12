@extends('layouts.master')

@section('links')
<!-- Toastr -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/toastr/toastr.min.css')}}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.css')}}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('css')
<style>
    .loading-spinner {
        display: none;
        position: absolute;
        align-items: center;
    }
    #loader {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .dropdown-menu {
        z-index: 9999 !important;
        left: -100px;
    }
    .btn-group-sm .btn {
        margin-right: 4px;
        border-radius: 4px !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .btn-group-sm .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }
    .custom-hover:hover {
        background-color: #a8e5ee;
        cursor: pointer;
    }
</style>
@endsection

@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Experiences</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item active">Experiences</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline mb-4">
        <div class="card-header">
          <h3 class="card-title mb-0"><i class="fas fa-user-graduate mr-2"></i>Experience Records</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
          <div class="float-right">
            <a href="#" data-toggle="modal" data-target="#add_item_modal" class="btn btn-sm btn-primary">
              <i class="fas fa-plus mr-2"></i>Add Record
            </a>
          </div>
        </div>
        <div class="card-body">
          <table id="experienceTable" class="table table-sm table-hover text-center">
            <thead>
                <tr>
                    <th class="hidden">ID</th>
                    <th>Job Title</th>
                    <th>Job Description</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Is Current?</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be automatically loaded here -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="add_item_modal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addItemModalLabel">Add Experience</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addItemForm" method="POST" action="{{ route('experiences.store') }}" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="job_title">Job Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="job_title" name="job_title" value="{{ old('job_title') }}" placeholder="--Job Title--">
                                <div class="invalid-feedback">Please provide the job title name.</div>
                            </div>
                            <div class="form-group">
                                <label for="company">Company <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="company" name="company" value="{{ old('company') }}" placeholder="--Company--">
                                <div class="invalid-feedback">Please provide the company earned.</div>
                            </div>
                            <div class="form-group">
                                <label for="location">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" placeholder="--Location--">
                                <div class="invalid-feedback">Please provide the location.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                                        <div class="invalid-feedback">Please provide a valid start date.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                                        <div class="invalid-feedback">Please provide a valid end date.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="is_current">Current Experience? <span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="is_current" name="is_current">
                                    <option value="" selected disabled>--Select--</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                                <div class="invalid-feedback">Please select your current status.</div>
                            </div>
                            <div class="form-group">
                                <label for="order">Display Order <span class="text-danger">*</span></label>
                                <input type="number" min="1" class="form-control" id="order" name="order" value="{{ old('order') }}" placeholder="--Order of experience in the list--">
                                <div class="invalid-feedback">Please provide a valid order number.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="achievements">Achievements</label>
                          <textarea class="form-control" id="achievements" name="achievements" rows="3" required>{{ old('achievements') }}</textarea>
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="description">Job Description</label>
                          <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveItemBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="edit_item_modal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editItemModalLabel">Edit Experience</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editItemForm" method="POST" action="{{ route('experiences.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="itemID_edit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="job_title">Job Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="itemJobTitle_edit" name="job_title" placeholder="--Job Title--">
                                <div class="invalid-feedback">Please provide the job title.</div>
                            </div>
                            <div class="form-group">
                                <label for="company">Company <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="itemCompany_edit" name="company" placeholder="--Company Name--">
                                <div class="invalid-feedback">Please provide the company name.</div>
                            </div>
                            <div class="form-group">
                                <label for="location">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="itemLocation_edit" name="location" placeholder="--Location--">
                                <div class="invalid-feedback">Please provide the location.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="itemStartDate_edit" name="start_date">
                                        <div class="invalid-feedback">Please provide a valid start date.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" id="itemEndDate_edit" name="end_date">
                                        <div class="invalid-feedback">Please provide a valid end date.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="is_current">Current Experience? <span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="itemIsCurrent_edit" name="is_current">
                                    <option value="" selected disabled>--Select--</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                                <div class="invalid-feedback">Please select your current status.</div>
                            </div>
                            <div class="form-group">
                                <label for="order">Display Order <span class="text-danger">*</span></label>
                                <input type="number" min="1" class="form-control" id="itemOrder_edit" name="order" placeholder="--Order of experience in the list--">
                                <div class="invalid-feedback">Please provide a valid order number.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="achievements">Achievements</label>
                          <textarea class="form-control" id="itemAchievements_edit" name="achievements" rows="3"></textarea>
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="description">Description</label>
                          <textarea class="form-control" id="itemDescription_edit" name="description" rows="3"></textarea>
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updateItemBtn">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Item Modal -->
<div class="modal fade" id="delete_item_modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteUserForm" method="POST" action="{{ route('experiences.delete') }}">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="itemID_delete" value="">
                    <p class="text-center">Are you sure you want to delete this item? <br><strong id="itemDetails_delete"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Restore Item Modal -->
<div class="modal fade" id="restore_item_modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="restoreUserForm" method="POST" action="{{ route('experiences.restore') }}">
                @csrf
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="restoreModalLabel">Restore Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="itemID_restore" value="">
                    <p class="text-center">Are you sure you want to restore this item? <br><strong id="itemDetails_restore"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning" id="confirmRestore">Restore</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Toastr -->
<script src="{{ asset('adminlte/plugins/toastr/toastr.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- DataTables & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
    @if(Session::has('error'))
        toastr.error('{{ Session::get('error')}}', 'Administrator', {timeOut: 3000, progressBar: true});
    @elseif(Session::has('success'))
        toastr.success('{{ Session::get('success')}}', 'Administrator', {timeOut: 3000, progressBar: true});
    @endif

    // Handle Validation Error Messages
    @if($errors->any())
      @foreach ($errors->all() as $error)
        toastr.error('{{ $error }}', 'Administrator', {timeOut: 3000, progressBar: true});
      @endforeach
    @endif
</script>
<script>
    $(document).on('shown.bs.modal', function (e) {
        const $modal = $(e.target);

        $modal.find('.select2bs4').each(function() {
            $(this).select2('destroy'); // Always destroy first
            $(this).select2({
                theme: 'bootstrap4',
                dropdownParent: $modal
            });
        });
    });
</script>
<script>
    // Use Ajax to fetch data from the server based on filter options
    $(document).ready(function() {
       var table = $('#experienceTable').DataTable({
            dom: '<"d-flex justify-content-between"lBf>t<"d-flex justify-content-between"ip>',
            buttons: [
                { 
                    extend: 'excel', 
                    title: 'Experience List',
                    className: 'btn-default',
                    exportOptions: {
                        columns: ':visible:not(.hidden)'
                    }
                },
                { 
                    extend: 'print', 
                    title: 'Experience List',
                    className: 'btn-default',
                    exportOptions: {
                        columns: ':visible:not(.hidden)'
                    }
                }
            ],
            serverSide: true,
            processing: true,
            searching: false,
            destroy: true,
            autoWidth: false,
            responsive: false, // Keep this false when using scrollX
            scrollX: true,     // This enables horizontal scrolling
            scrollCollapse: true, // Add this to properly handle scrolling
            lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
            fixedColumns: true, // Helps with column width management
            ajax: {
                url: "{{ route('experiences.show.data') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function (d) {
                    d._token = "{{ csrf_token() }}";
                    d.jobTitleFilter = $('#jobTitleFilter').val();
                    d.discriptionFilter = $('#discriptionFilter').val();
                    d.companyFilter = $('#companyFilter').val();
                    d.locationFilter = $('#locationFilter').val();
                    d.startDateFilter = $('#startDateFilter').val();
                    d.endDateFilter = $('#endDateFilter').val();
                    d.isCurrentFilter = $('#isCurrentFilter').val();
                    d.orderFilter = $('#orderFilter').val();
                },
                error: function (xhr, error, thrown) {                   
                    // Add retry logic instead of just reloading
                    var retryCount = parseInt(localStorage.getItem('dtRetryCount') || '0');
                    
                    if (retryCount < 3) {
                        // Increment retry counter
                        localStorage.setItem('dtRetryCount', retryCount + 1);
                        
                        // Show message
                        toastr.info('Retrying data request...', 'Please wait', {
                            timeOut: 1500,
                            progressBar: true
                        });
                        
                        // Retry after a short delay
                        setTimeout(function() {
                            table.ajax.reload();
                        }, 1500);
                    } else {
                        // Reset counter and show reload message
                        localStorage.setItem('dtRetryCount', '0');
                        toastr.info('Having trouble loading data. Refreshing the page...', 'Please wait', {
                            timeOut: 2000,
                            progressBar: true
                        });
                        
                        // Reload after giving user time to see message
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                }
            },
            columns: [
                { data: 'id', name: 'id', class: 'hidden' },
                { data: 'job_title', name: 'job_title' },
                { data: 'description', name: 'description' },
                { data: 'company', name: 'company' },
                { data: 'location', name: 'location' },
                { data: 'start_date', name: 'start_date' },
                { data: 'end_date', name: 'end_date' },
                { data: 'is_current', name: 'is_current' },
                { data: 'order', name: 'order' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            order: [[0, 'desc']],
       });
        // Filter event handlers
        $('#jobTitleFilter, #discriptionFilter, #companyFilter, #locationFilter, #startDateFilter, #endDateFilter, #isCurrentFilter, #orderFilter').on('change keyup', function() {
            table.ajax.reload();
        });

        // Reset filters button
        $('#resetFilters').click(function () {
            // Get current filter values
            const currentFilters = {
                job_title: $('#jobTitleFilter').val(),
                description: $('#discriptionFilter').val(),
                company: $('#companyFilter').val(),
                location: $('#locationFilter').val(),
                start_date: $('#startDateFilter').val(),
                end_date: $('#endDateFilter').val(),
                is_current: $('#isCurrentFilter').val(),
                order: $('#orderFilter').val(),
            };

            // Check if any filter is not at its default value
            const needsReset = currentFilters.job_title !== 'all' ||
                currentFilters.description !== 'all' ||
                currentFilters.company !== 'all' ||
                currentFilters.location !== 'all' ||
                currentFilters.start_date !== '' ||
                currentFilters.end_date !== '' ||
                currentFilters.is_current !== 'all' ||
                currentFilters.order !== '';

            // Only reset if needed
            if (needsReset) {
                // Clear input fields
                $('#jobTitleFilter').val('all');
                $('#discriptionFilter').val('all');
                $('#companyFilter').val('all');
                $('#locationFilter').val('all');
                $('#startDateFilter').val('');
                $('#endDateFilter').val('');
                $('#isCurrentFilter').val('all');
                $('#orderFilter').val('');
                // Reload DataTable
                $('#experienceTable').DataTable().ajax.reload();
            }
        });
    });
</script>
<script>
    // Handle add item form submission
    $('#addItemForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = $('#saveItemBtn');
        const originalBtnText = submitBtn.html();

        clearErrors();
        disableSubmitButton();
               
        // AJAX request
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: handleSuccess,
            error: handleError,
            complete: enableSubmitButton
        });

        // Handle clearing of previous errors
        function clearErrors() {
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();
        }

        // Handle submit button state
        function enableSubmitButton() {
            submitBtn.prop('disabled', false).html('Save');
        }
        
        function disableSubmitButton() {
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        }

        function handleSuccess(response) {
            toastr.success(response.message || 'Record added successfully!', 'Success', {
                timeOut: 3000,
                progressBar: true,
                closeButton: true,
                newestOnTop: true
            });
            enableSubmitButton();
            // Reset form
            form[0].reset();
            clearErrors();
            // Hide modal
            $('#add_item_modal').modal('hide');
            // Reload DataTable
            $('#experienceTable').DataTable().ajax.reload();
        }

        function handleError(xhr) {
            if (xhr.status === 422) {
                enableSubmitButton();
                // Validation errors
                const errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    const input = form.find('[name="' + key + '"]');
                    const feedback = input.next('.invalid-feedback');
                    
                    input.addClass('is-invalid');
                    if (feedback.length) {
                        feedback.text(value[0]);
                    } else {
                        input.closest('.form-group').append('<div class="invalid-feedback">' + value[0] + '</div>');
                    }
                });
            } else {
                toastr.error(xhr.responseJSON.message || 'An error occurred. Please try again.', 'Error', {
                    timeOut: 3000,
                    progressBar: true,
                    closeButton: true,
                    newestOnTop: true
                });
            }
        }

        // Event listener for modal close
        $('#add_item_modal').on('hidden.bs.modal', function() {
            clearErrors();
            enableSubmitButton();
            // Reset form fields if needed
            form[0].reset();
        });
    });
</script>
<script>
    // Populate edit modal with data
    $('#edit_item_modal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        var item = button.data('item');

        console.log("Data:", item);

        // Convert achievements array to newline-separated string
        const achievements = Array.isArray(item.achievements) 
                ? item.achievements.join('\n') 
                : item.achievements;

        // Populate form fields
        $('#itemID_edit').val(item.id);
        $('#itemJobTitle_edit').val(item.job_title);
        $('#itemCompany_edit').val(item.company);
        $('#itemLocation_edit').val(item.location);
        $('#itemStartDate_edit').val(item.start_date);
        $('#itemEndDate_edit').val(item.end_date);
        $('#itemIsCurrent_edit').val(item.is_current ? '1' : '0').trigger('change');
        $('#itemOrder_edit').val(item.order);
        $('#itemDescription_edit').val(item.description);
        $('#itemAchievements_edit').val(achievements);
    });
    // Handle edit item form submission
    $('#editItemForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = $('#updateItemBtn');
        const modal = $('#edit_item_modal');
        const table = $('#experienceTable').DataTable();
        const originalBtnText = submitBtn.html();

        clearErrors();
        disableSubmitButton();
               
        // AJAX request
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: handleSuccess,
            error: handleError,
            complete: enableSubmitButton
        });

        // Handle clearing of previous errors
        function clearErrors() {
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();
        }

        // Handle submit button state
        function enableSubmitButton() {
            submitBtn.prop('disabled', false).html('Save');
        }
        
        function disableSubmitButton() {
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        }

        function handleSuccess(response) {
            toastr.success(response.message || 'Record updated successfully!', 'Success', {
                timeOut: 3000,
                progressBar: true,
                closeButton: true,
                newestOnTop: true
            });
            enableSubmitButton();
            // Reset form
            form[0].reset();
            clearErrors();
            // Hide modal
            modal.modal('hide');
            // Reload DataTable
            table.ajax.reload();
            // Reload the page to reflect changes after 1s
            setTimeout(function() {
                location.reload();
            }, 1000);
        }

        function handleError(xhr) {
            if (xhr.status === 422) {
                enableSubmitButton();
                // Validation errors
                const errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    const input = form.find('[name="' + key + '"]');
                    const feedback = input.next('.invalid-feedback');
                    
                    input.addClass('is-invalid');
                    if (feedback.length) {
                        feedback.text(value[0]);
                    } else {
                        input.closest('.form-group').append('<div class="invalid-feedback">' + value[0] + '</div>');
                    }
                });
            } else {
                toastr.error(xhr.responseJSON.message || 'An error occurred. Please try again.', 'Error', {
                    timeOut: 3000,
                    progressBar: true,
                    closeButton: true,
                    newestOnTop: true
                });
            }
        }

        // Event listener for modal close
        modal.on('hidden.bs.modal', function() {
            clearErrors();
            enableSubmitButton();
            // Reset form fields if needed
            form[0].reset();
        });
    });

    // Handle delete item
    $('#delete_item_modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var item = button.data('item');
        var itemID = item.id;

        $('#itemID_delete').val(itemID);
        $('#itemDetails_delete').text(item.details);

        // Detach previous click handlers to avoid multiple triggers
        $('#confirmDelete').off('click').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: $('#deleteUserForm').attr('action'),
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: itemID
                },
                success: function(response) {
                    $('#delete_item_modal').modal('hide');
                    try {
                        $('#experienceTable').DataTable().ajax.reload(null, false);
                    } catch (e) {
                        console.error('DataTable reload error:', e);
                    }
                    toastr.success(response.message || 'Record deleted successfully!', 'Success', {
                        timeOut: 3000,
                        progressBar: true,
                        closeButton: true,
                        newestOnTop: true
                    });
                },
                error: function(xhr) {
                    toastr.error(
                        xhr.responseJSON?.message || 'An error occurred while deleting the record. Please try again.',
                        'Error',
                        { timeOut: 3000, progressBar: true }
                    );
                }
            });
        });
    });

    // Handle restore item
    $('#restore_item_modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var item = button.data('item');
        var itemID = item.id;

        $('#itemID_restore').val(itemID);
        $('#itemDetails_restore').text(item.details);

        // Detach previous click handlers to avoid multiple triggers
        $('#confirmRestore').off('click').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: $('#restoreUserForm').attr('action'),
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: itemID
                },
                success: function(response) {
                    $('#restore_item_modal').modal('hide');
                    try {
                        $('#experienceTable').DataTable().ajax.reload(null, false);
                    } catch (e) {
                        console.error('DataTable reload error:', e);
                    }
                    toastr.success(response.message || 'Record restored successfully!', 'Success', {
                        timeOut: 3000,
                        progressBar: true,
                        closeButton: true,
                        newestOnTop: true
                    });
                },
                error: function(xhr) {
                    toastr.error(
                        xhr.responseJSON?.message || 'An error occurred while restoring the record. Please try again.',
                        'Error',
                        { timeOut: 3000, progressBar: true }
                    );
                }
            });
        });
    });
</script>
@endsection