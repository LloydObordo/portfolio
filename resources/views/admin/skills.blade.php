@extends('layouts.master')

@section('links')
<!-- Dropzone -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/dropzone/min/dropzone.min.css') }}">
<!-- Toastr -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/toastr/toastr.min.css')}}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.css')}}">
<!-- FancyBox -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox/dist/jquery.fancybox.min.css">
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

    .image-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 5px;
        margin-bottom: 10px;
    }
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    .file-input-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
</style>
@endsection

@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Skills</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item active">Skills</li>
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
          <h3 class="card-title mb-0"><i class="fas fa-user-graduate mr-2"></i>Skills Records</h3>
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
          <table id="skillsTable" class="table table-sm table-hover text-center">
            <thead>
                <tr>
                    <th class="hidden">ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Proficiency</th>
                    <th class="hidden">Icon</th>
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
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addItemModalLabel">Add Skill</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addItemForm" method="POST" action="{{ route('skills.store') }}" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="name">Name <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="--Skill Name--">
                          <div class="invalid-feedback">Please provide the skill name.</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="category">Category <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="category" name="category" value="{{ old('category') }}" placeholder="--Category--">
                          <div class="invalid-feedback">Please provide the category.</div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="proficiency">Proficiency <span class="text-danger">*</span></label>
                          <input type="number" class="form-control" id="proficiency" name="proficiency" value="{{ old('profiency') }}" placeholder="--Profiency--">
                          <div class="invalid-feedback">Please provide the profiency.</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="order">Order <span class="text-danger">*</span></label>
                          <input type="number" class="form-control" id="order" name="order" value="{{ old('order') }}" placeholder="--Order--">
                          <div class="invalid-feedback">Please provide the order.</div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Icon</label>
                          <div class="d-block">
                              <img id="iconPreview" src="{{ asset('images/default.jpg') }}" class="image-preview">
                              <br>
                              <div class="file-input-wrapper">
                                  <button type="button" class="btn btn-sm btn-primary">
                                      <i class="fas fa-upload mr-2"></i>Upload Icon
                                  </button>
                                  <input type="file" id="icon" name="icon" accept="icon/*" onchange="previewIcon(this, 'iconPreview')">
                              </div>
                              <small class="form-text text-muted">Recommended size: 500x500 pixels</small>
                          </div>
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
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editItemModalLabel">Edit Skill</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editItemForm" method="POST" action="{{ route('skills.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="itemID_edit">
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="name">Name <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="itemName_edit" name="name" placeholder="--Skill Name--">
                          <div class="invalid-feedback">Please provide the skill name.</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="category">Category <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="itemCategory_edit" name="category" placeholder="--Category--">
                          <div class="invalid-feedback">Please provide the category.</div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="proficiency">Proficiency <span class="text-danger">*</span></label>
                          <input type="number" class="form-control" id="itemProficiency_edit" name="proficiency" placeholder="--Profiency--">
                          <div class="invalid-feedback">Please provide the profiency.</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="order">Order <span class="text-danger">*</span></label>
                          <input type="number" class="form-control" id="itemOrder_edit" name="order" placeholder="--Order--">
                          <div class="invalid-feedback">Please provide the order.</div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Icon</label>
                          <div class="d-block">
                              <img id="itemIconPreview_edit" src="{{ asset('images/default.jpg') }}" class="image-preview">
                              <br>
                              <div class="file-input-wrapper">
                                  <button type="button" class="btn btn-sm btn-primary">
                                      <i class="fas fa-upload mr-2"></i>Upload Icon
                                  </button>
                                  <input type="file" id="itemIcon_edit" name="icon" accept="icon/*" onchange="previewIcon(this, 'itemIconPreview_edit')">
                              </div>
                              <small class="form-text text-muted">Recommended size: 500x500 pixels</small>
                          </div>
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
            <form id="deleteUserForm" method="POST" action="{{ route('skills.delete') }}">
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
            <form id="restoreUserForm" method="POST" action="{{ route('skills.restore') }}">
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
<!-- bs-custom-file-input -->
<script src="{{ asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- Dropzone -->
<script src="{{ asset('adminlte/plugins/dropzone/min/dropzone.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('adminlte/plugins/toastr/toastr.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Fancybox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox/dist/jquery.fancybox.min.js"></script>
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
       var table = $('#skillsTable').DataTable({
            dom: '<"d-flex justify-content-between"lBf>t<"d-flex justify-content-between"ip>',
            buttons: [
                { 
                    extend: 'excel', 
                    title: 'Skills List',
                    className: 'btn-default',
                    exportOptions: {
                        columns: ':visible:not(.hidden)'
                    }
                },
                { 
                    extend: 'print', 
                    title: 'Skills List',
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
                url: "{{ route('skills.show.data') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function (d) {
                    d._token = "{{ csrf_token() }}";
                    d.nameFilter = $('#nameFilter').val();
                    d.categoryFilter = $('#categoryFilter').val();
                    d.proficiencyFilter = $('#proficiencyFilter').val();
                    d.orderFilter = $('#orderFilter').val();
                    d.statusFilter = $('#statusFilter').val();
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
                { data: 'name', name: 'name' },
                { data: 'category', name: 'category' },
                { data: 'proficiency', name: 'proficiency' },
                { data: 'icon', name: 'icon', class: 'hidden' },
                { data: 'order', name: 'order' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            order: [[0, 'desc']],
       });
        // Filter event handlers
        $('#nameFilter, #categoryFilter, #proficiencyFilter, #orderFilter, #statusFilter').on('change keyup', function() {
            table.ajax.reload();
        });

        // Reset filters button
        $('#resetFilters').click(function () {
            // Get current filter values
            const currentFilters = {
                name: $('#nameFilter').val(),
                category: $('#categoryFilter').val(),
                proficiency: $('#proficiencyFilter').val(),
                order: $('#orderFilter').val(),
                status: $('#statusFilter').val(),
            };

            // Check if any filter is not at its default value
            const needsReset = currentFilters.name !== 'all' ||
                currentFilters.category !== 'all' ||
                currentFilters.proficiency !== 'all' ||
                currentFilters.order !== '' ||
                currentFilters.status !== 'all';

            // Only reset if needed
            if (needsReset) {
                // Clear input fields
                $('#nameFilter').val('all');
                $('#categoryFilter').val('all');
                $('#proficiencyFilter').val('all');
                $('#orderFilter').val('');
                $('#statusFilter').val('all');
                // Reload DataTable
                $('#skillsTable').DataTable().ajax.reload();
            }
        });
    });
</script>
<script>
    let originalIconImage = null;
    // Function to reset the add form completely
    function resetAddForm() {
        // Reset form fields
        $('#addItemForm')[0].reset();
        
        // Reset icon image preview
        const iconPreview = document.getElementById('iconPreview');
        iconPreview.src = "{{ asset('images/default.jpg') }}";
        
        // Remove Fancybox wrapper if exists
        if (iconPreview.parentNode.tagName === 'A') {
            const wrapper = iconPreview.parentNode;
            wrapper.parentNode.insertBefore(iconPreview, wrapper);
            wrapper.remove();
        }
        
        // Clear file inputs
        $('#image').val('');
        
        // Clear validation errors
        $('#addItemForm').find('.is-invalid').removeClass('is-invalid');
        $('#addItemForm').find('.invalid-feedback').remove();
    }

    // Preview icon with Fancybox
    function previewIcon(input, previewId) {
        const preview = document.getElementById(previewId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Remove any existing Fancybox wrapper
                if (preview.parentNode.tagName === 'A') {
                    const wrapper = preview.parentNode;
                    wrapper.parentNode.insertBefore(preview, wrapper);
                    wrapper.remove();
                }
                
                preview.src = e.target.result;
                
                // Create new Fancybox wrapper
                const wrapper = document.createElement('a');
                wrapper.href = e.target.result;
                wrapper.setAttribute('data-fancybox', 'icon-image');
                wrapper.setAttribute('data-caption', 'Skill Icon');
                
                // Wrap the image with the link
                preview.parentNode.insertBefore(wrapper, preview);
                wrapper.appendChild(preview);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Load existing icon image with Fancybox
    function loadExistingIconImage(imageUrl, previewId) {
        const preview = document.getElementById(previewId);
        
        if (imageUrl) {
            // Update the image source
            preview.src = imageUrl;
            
            // Wrap the image in a Fancybox link
            const wrapper = document.createElement('a');
            wrapper.href = imageUrl;
            wrapper.setAttribute('data-fancybox', 'icon-image');
            wrapper.setAttribute('data-caption', 'Skill Icon');
            
            // Wrap the image with the link
            preview.parentNode.insertBefore(wrapper, preview);
            wrapper.appendChild(preview);
        }
    }

    // Reset form state
    function resetFormState() {
        originalIconImage = null;
    }

  $(document).ready(function() {
    // Initialize custom file input
    bsCustomFileInput.init();
    
    // Initialize Fancybox
    $('[data-fancybox]').fancybox({
        buttons: [
            "zoom",
            "share",
            "slideShow",
            "fullScreen",
            "download",
            "thumbs",
            "close"
        ],
        arrows: false
    });

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
              data: new FormData(form[0]),
              processData: false,
              contentType: false,
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

                // Reset form and enable button
                resetAddForm();

                // Clear validation errors
                clearErrors();

                //enable Submit button
                enableSubmitButton();
                
                // Hide modal
                $('#add_item_modal').modal('hide');
                
                // Reload DataTable
                $('#skillsTable').DataTable().ajax.reload();
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

          // Reset add form when modal is closed
          $('#add_item_modal').on('hidden.bs.modal', function() {
              resetAddForm();
          });
      });
  });
</script>
<script>
    // Populate edit modal with data
    $('#edit_item_modal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        var item = button.data('item');

        // Reset form state
        resetFormState();

        // Populate form fields
        $('#itemID_edit').val(item.id);
        $('#itemName_edit').val(item.name);
        $('#itemCategory_edit').val(item.category);
        $('#itemProficiency_edit').val(item.proficiency);
        $('#itemOrder_edit').val(item.order);

        // Set icon image preview with Fancybox
        if (item.icon) {
            loadExistingIconImage(item.icon, 'itemIconPreview_edit');
            originalIconImage = item.icon; // Store original image for reference
        }
    });
    // Handle edit item form submission
    $('#editItemForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = $('#updateItemBtn');
        const modal = $('#edit_item_modal');
        const table = $('#skillsTable').DataTable();
        const originalBtnText = submitBtn.html();

        clearErrors();
        disableSubmitButton();
               
        // AJAX request
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: new FormData(form[0]),
            processData: false,
            contentType: false,
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
                        $('#skillsTable').DataTable().ajax.reload(null, false);
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
                        $('#skillsTable').DataTable().ajax.reload(null, false);
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