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

    .gallery-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 10px;
    }

    .gallery-preview .image-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 5px;
    }
</style>
@endsection

@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Projects</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item active">Projects</li>
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
          <h3 class="card-title mb-0"><i class="fas fa-user-graduate mr-2"></i>Project Records</h3>
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
          <table id="projectTable" class="table table-sm table-hover text-center">
            <thead>
                <tr>
                    <th class="hidden">ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Technologies</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Featured?</th>
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
                <h5 class="modal-title" id="addItemModalLabel">Add Project</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addItemForm" method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="--Title--">
                                        <div class="invalid-feedback">Please provide the title.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" class="form-control" id="category" name="category" placeholder="--Category--">
                                        <div class="invalid-feedback">Please provide the category.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="1" placeholder="--Description--"></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="detailed_description">Detailed Description</label>
                                        <textarea class="form-control" id="detailed_description" name="detailed_description" rows="1" placeholder="--Detailed Description--"></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="technologies">Technologies</label>
                                        <input type="text" class="form-control" id="technologies" name="technologies" placeholder="--Technologies--">
                                        <div class="invalid-feedback">Please provide the technologies.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="live_url">Live URL</label>
                                        <input type="text" class="form-control" id="live_url" name="live_url" placeholder="--Live URL--">
                                        <div class="invalid-feedback">Please provide the live URL.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="github_url">Github URL</label>
                                        <input type="text" class="form-control" id="github_url" name="github_url" placeholder="--Github URL--">
                                        <div class="invalid-feedback">Please provide the github URL.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="featured">Featured? <span class="text-danger">*</span></label>
                                        <select class="form-control select2bs4" id="featured" name="featured">
                                            <option value="" selected disabled>--Select--</option>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                        <div class="invalid-feedback">Please select your current status.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order">Display Order <span class="text-danger">*</span></label>
                                        <input type="number" min="1" class="form-control" id="order" name="order" placeholder="--Order of experience in the list--">
                                        <div class="invalid-feedback">Please provide a valid order number.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Main Image</label>
                                        <div class="d-block">
                                            <img id="profileImagePreview" src="{{ asset('images/default.jpg') }}" class="image-preview">
                                            <br>
                                            <div class="file-input-wrapper">
                                                <button type="button" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-upload mr-2"></i>Upload Image
                                                </button>
                                                <input type="file" id="image" name="image" accept="image/*" onchange="previewMainImage(this, 'profileImagePreview')">
                                            </div>
                                            <small class="form-text text-muted">Recommended size: 500x500 pixels</small>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Gallery Images</label>
                                        <div class="gallery-preview mb-2" id="galleryPreview">
                                            <!-- Gallery preview images will appear here -->
                                        </div>
                                        <div class="file-input-wrapper">
                                            <button type="button" class="btn btn-sm btn-primary">
                                                <i class="fas fa-upload mr-2"></i>Upload Gallery Images
                                            </button>
                                            <input type="file" id="gallery" name="gallery[]" multiple accept="image/*" onchange="previewGalleryImages(this, 'galleryPreview')">
                                        </div>
                                        <small class="form-text text-muted">Upload multiple images for the project gallery</small>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
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
                <h5 class="modal-title" id="editItemModalLabel">Edit Project</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editItemForm" method="POST" action="{{ route('projects.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="itemID_edit">
                <input type="hidden" name="remove_main_image" id="removeMainImage" value="0">
                <div id="deletedGalleryImagesContainer">
                    <!-- Deleted gallery image IDs will be added here -->
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Form fields remain the same -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="itemTitle_edit" name="title" placeholder="--Title--">
                                        <div class="invalid-feedback">Please provide the title.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" class="form-control" id="itemCategory_edit" name="category" placeholder="--Category--">
                                        <div class="invalid-feedback">Please provide the category.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="itemDescription_edit" name="description" rows="1" placeholder="--Description--"></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="detailed_description">Detailed Description</label>
                                        <textarea class="form-control" id="itemDetailedDescription_edit" name="detailed_description" rows="1" placeholder="--Detailed Description--"></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="technologies">Technologies</label>
                                        <input type="text" class="form-control" id="itemTechnologies_edit" name="technologies" placeholder="--Technologies--">
                                        <div class="invalid-feedback">Please provide the technologies.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="live_url">Live URL</label>
                                        <input type="text" class="form-control" id="itemLiveUrl_edit" name="live_url" placeholder="--Live URL--">
                                        <div class="invalid-feedback">Please provide the live URL.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="github_url">Github URL</label>
                                        <input type="text" class="form-control" id="itemGithubUrl_edit" name="github_url" placeholder="--Github URL--">
                                        <div class="invalid-feedback">Please provide the github URL.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="featured">Featured? <span class="text-danger">*</span></label>
                                        <select class="form-control select2bs4" id="itemFeatured_edit" name="featured">
                                            <option value="" selected disabled>--Select--</option>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                        <div class="invalid-feedback">Please select your current status.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order">Display Order <span class="text-danger">*</span></label>
                                        <input type="number" min="1" class="form-control" id="itemOrder_edit" name="order" placeholder="--Order of experience in the list--">
                                        <div class="invalid-feedback">Please provide a valid order number.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Main Image</label>
                                        <div class="d-block">
                                            <div class="position-relative d-inline-block">
                                                <img id="itemImagePreview_edit" src="{{ asset('images/default.jpg') }}" class="image-preview">
                                                <button type="button" class="btn btn-danger btn-xs position-absolute" style="top: 5px; right: 5px; display: none;" id="removeMainImageBtn" onclick="removeMainImage()">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <br>
                                            <div class="file-input-wrapper">
                                                <button type="button" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-upload mr-2"></i>Upload Image
                                                </button>
                                                <input type="file" id="itemImage_edit" name="image" accept="image/*" onchange="previewMainImage(this, 'itemImagePreview_edit')">
                                            </div>
                                            <small class="form-text text-muted">Recommended size: 500x500 pixels</small>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Gallery Images</label>
                                        <div class="gallery-preview mb-2" id="itemGalleryPreview_edit">
                                            <!-- Existing gallery images will appear here -->
                                        </div>
                                        <div class="file-input-wrapper">
                                            <button type="button" class="btn btn-sm btn-primary">
                                                <i class="fas fa-upload mr-2"></i>Upload More Images
                                            </button>
                                            <input type="file" id="itemGallery_edit" name="gallery[]" multiple accept="image/*" onchange="previewGalleryImages(this, 'itemGalleryPreview_edit')">
                                        </div>
                                        <small class="form-text text-muted">Upload additional images for the project gallery</small>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
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
            <form id="deleteUserForm" method="POST" action="{{ route('projects.delete') }}">
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
            <form id="restoreUserForm" method="POST" action="{{ route('projects.restore') }}">
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
  $(document).ready(function() {
        $('[data-fancybox="photos"]').fancybox({
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
    })
</script>
<script>
    // Use Ajax to fetch data from the server based on filter options
    $(document).ready(function() {
       var table = $('#projectTable').DataTable({
            dom: '<"d-flex justify-content-between"lBf>t<"d-flex justify-content-between"ip>',
            buttons: [
                { 
                    extend: 'excel', 
                    title: 'Project List',
                    className: 'btn-default',
                    exportOptions: {
                        columns: ':visible:not(.hidden)'
                    }
                },
                { 
                    extend: 'print', 
                    title: 'Project List',
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
                url: "{{ route('projects.show.data') }}",
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
                // error: function (xhr, error, thrown) {                   
                //     // Add retry logic instead of just reloading
                //     var retryCount = parseInt(localStorage.getItem('dtRetryCount') || '0');
                    
                //     if (retryCount < 3) {
                //         // Increment retry counter
                //         localStorage.setItem('dtRetryCount', retryCount + 1);
                        
                //         // Show message
                //         toastr.info('Retrying data request...', 'Please wait', {
                //             timeOut: 1500,
                //             progressBar: true
                //         });
                        
                //         // Retry after a short delay
                //         setTimeout(function() {
                //             table.ajax.reload();
                //         }, 1500);
                //     } else {
                //         // Reset counter and show reload message
                //         localStorage.setItem('dtRetryCount', '0');
                //         toastr.info('Having trouble loading data. Refreshing the page...', 'Please wait', {
                //             timeOut: 2000,
                //             progressBar: true
                //         });
                        
                //         // Reload after giving user time to see message
                //         setTimeout(function() {
                //             location.reload();
                //         }, 2000);
                //     }
                // }
            },
            columns: [
                { data: 'id', name: 'id', class: 'hidden' },
                { data: 'title', name: 'title' },
                { data: 'description', name: 'description' },
                { data: 'technologies', name: 'technologies' },
                { data: 'image', name: 'image' },
                { data: 'category', name: 'category' },
                { data: 'featured', name: 'featured' },
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
                $('#projectTable').DataTable().ajax.reload();
            }
        });
    });
</script>
<script>
// Global variables to track images
let deletedGalleryImages = [];
let currentGalleryImages = [];
let hasMainImage = false;
let originalMainImage = null;

// Function to reset the add form completely
function resetAddForm() {
    // Reset form fields
    $('#addItemForm')[0].reset();
    
    // Reset main image preview
    const mainPreview = document.getElementById('profileImagePreview');
    mainPreview.src = "{{ asset('images/default.jpg') }}";
    
    // Remove Fancybox wrapper if exists
    if (mainPreview.parentNode.tagName === 'A') {
        const wrapper = mainPreview.parentNode;
        wrapper.parentNode.insertBefore(mainPreview, wrapper);
        wrapper.remove();
    }
    
    // Clear file inputs
    $('#image').val('');
    $('#gallery').val('');
    
    // Clear gallery preview
    $('#galleryPreview').empty();
    
    // Clear validation errors
    $('#addItemForm').find('.is-invalid').removeClass('is-invalid');
    $('#addItemForm').find('.invalid-feedback').remove();
}

// Preview main image with Fancybox
function previewMainImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const removeBtn = previewId === 'itemImagePreview_edit' ? 
        document.getElementById('removeMainImageBtn') : null;
    
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
            wrapper.setAttribute('data-fancybox', 'main-image');
            wrapper.setAttribute('data-caption', 'Main Project Image');
            
            // Wrap the image with the link
            preview.parentNode.insertBefore(wrapper, preview);
            wrapper.appendChild(preview);
            
            if (removeBtn) {
                removeBtn.style.display = 'block';
            }
            
            hasMainImage = true;
            if (previewId === 'itemImagePreview_edit') {
                document.getElementById('removeMainImage').value = '0';
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Load existing main image with Fancybox
function loadExistingMainImage(imageUrl, previewId) {
    const preview = document.getElementById(previewId);
    
    if (imageUrl) {
        // Update the image source
        preview.src = imageUrl;
        
        // Wrap the image in a Fancybox link
        const wrapper = document.createElement('a');
        wrapper.href = imageUrl;
        wrapper.setAttribute('data-fancybox', 'main-image');
        wrapper.setAttribute('data-caption', 'Main Project Image');
        
        // Wrap the image with the link
        preview.parentNode.insertBefore(wrapper, preview);
        wrapper.appendChild(preview);
        
        // Show remove button if in edit mode
        if (previewId === 'itemImagePreview_edit') {
            document.getElementById('removeMainImageBtn').style.display = 'none';
        }
    }
}

// Remove main image
function removeMainImage() {
    const preview = document.getElementById('itemImagePreview_edit');
    const removeBtn = document.getElementById('removeMainImageBtn');
    const fileInput = document.getElementById('itemImage_edit');
    
    // Remove Fancybox wrapper if exists
    if (preview.parentNode.tagName === 'A') {
        const wrapper = preview.parentNode;
        wrapper.parentNode.insertBefore(preview, wrapper);
        wrapper.remove();
    }
    
    // Reset preview to default
    preview.src = "{{ asset('images/default.jpg') }}";
    removeBtn.style.display = 'none';
    
    // Clear file input
    fileInput.value = '';
    
    // Set flag to remove existing image
    document.getElementById('removeMainImage').value = '1';
    hasMainImage = false;
}

// Preview multiple gallery images
function previewGalleryImages(input, previewId) {
    const previewContainer = document.getElementById(previewId);
    
    if (input.files && input.files.length > 0) {
        // Clear only new image previews, keep existing ones
        const newImagePreviews = previewContainer.querySelectorAll('.new-image-preview');
        newImagePreviews.forEach(preview => preview.remove());
        
        for (let i = 0; i < input.files.length; i++) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'd-inline-block mr-2 mb-2 position-relative new-image-preview';
                previewDiv.innerHTML = `
                    <a href="${e.target.result}" data-fancybox="gallery-${previewId}" data-caption="Gallery Image">
                        <img src="${e.target.result}" class="image-preview" style="width: 100px; height: 100px;">
                    </a>
                    <button type="button" class="btn btn-danger btn-xs position-absolute" style="top: 5px; right: 5px;" onclick="removeNewGalleryImage(this, ${i})">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                previewContainer.appendChild(previewDiv);
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
}

// Remove new gallery image from preview
function removeNewGalleryImage(button, index) {
    const input = document.getElementById(button.closest('.form-group').querySelector('input[type="file"]'));
    
    if (!input || !input.files) {
        console.warn("File input not found or has no files.");
        return;
    }

    const files = Array.from(input.files);
    files.splice(index, 1);

    const dataTransfer = new DataTransfer();
    files.forEach(file => dataTransfer.items.add(file));

    input.files = dataTransfer.files;

    // Remove the preview element
    button.closest('.new-image-preview').remove();
}

// Load existing gallery images
function loadExistingGalleryImages(images, previewId) {
    const previewContainer = document.getElementById(previewId);
    previewContainer.innerHTML = '';
    
    if (images && images.length > 0) {
        images.forEach((image, index) => {
            const previewDiv = document.createElement('div');
            previewDiv.className = 'd-inline-block mr-2 mb-2 position-relative existing-image-preview';
            previewDiv.innerHTML = `
                <a href="${image.url}" data-fancybox="gallery-${previewId}" data-caption="Gallery Image">
                    <img src="${image.thumbnail}" class="image-preview" style="width: 100px; height: 100px;">
                </a>
                <button type="button" class="btn btn-danger btn-xs position-absolute" style="top: 5px; right: 5px;" onclick="removeExistingGalleryImage(this, '${image.id}')">
                    <i class="fas fa-times"></i>
                </button>
                <input type="hidden" name="existing_gallery[]" value="${image.id}">
            `;
            previewContainer.appendChild(previewDiv);
            currentGalleryImages.push(image.id);
        });
    }
}

// Remove existing gallery image
function removeExistingGalleryImage(button, imageId) {
    // Add to deleted images array
    if (!deletedGalleryImages.includes(imageId)) {
        deletedGalleryImages.push(imageId);
    }
    
    // Remove from current images array
    const index = currentGalleryImages.indexOf(imageId);
    if (index > -1) {
        currentGalleryImages.splice(index, 1);
    }
    
    // Remove the preview element
    button.closest('.existing-image-preview').remove();
    
    // Update hidden inputs
    updateDeletedGalleryImagesInput();
}

// Update deleted gallery images hidden input
function updateDeletedGalleryImagesInput() {
    const container = document.getElementById('deletedGalleryImagesContainer');
    container.innerHTML = '';
    
    deletedGalleryImages.forEach(imageId => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'deleted_gallery_images[]';
        input.value = imageId;
        container.appendChild(input);
    });
}

// Reset form state
function resetFormState() {
    deletedGalleryImages = [];
    currentGalleryImages = [];
    hasMainImage = false;
    originalMainImage = null;
    document.getElementById('removeMainImage').value = '0';
    document.getElementById('deletedGalleryImagesContainer').innerHTML = '';
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

        // Clear errors
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();
        
        // Disable submit button
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
                
        // AJAX request
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: new FormData(form[0]),
            processData: false,
            contentType: false,
            success: function(response) {
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
                $('#projectTable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                // Enable submit button
                submitBtn.prop('disabled', false).html('Save');
                
                if (xhr.status === 422) {
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
        });
    });

    // Reset add form when modal is closed
    $('#add_item_modal').on('hidden.bs.modal', function() {
        resetAddForm();
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
        $('#itemTitle_edit').val(item.title);
        $('#itemCategory_edit').val(item.category);
        $('#itemDescription_edit').val(item.description);
        $('#itemDetailedDescription_edit').val(item.detailed_description);
        $('#itemTechnologies_edit').val(item.technologies);
        $('#itemLiveUrl_edit').val(item.live_url);
        $('#itemGithubUrl_edit').val(item.github_url);
        $('#itemFeatured_edit').val(item.featured ? '1' : '0').trigger('change');
        $('#itemOrder_edit').val(item.order);
        
        // Set main image preview
        // if (item.image) {
        //     $('#itemImagePreview_edit').attr('src', item.image);
        // }

        // Set main image preview with Fancybox
        if (item.image) {
            loadExistingMainImage(item.image, 'itemImagePreview_edit');
            originalMainImage = item.image; // Store original image for reference
        }

        // Load existing gallery images - ensure we pass an array
        loadExistingGalleryImages(Array.isArray(item.gallery) ? item.gallery : [], 'itemGalleryPreview_edit');
    });
    // Handle edit item form submission
    $('#editItemForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = $('#updateItemBtn');
        const modal = $('#edit_item_modal');
        const table = $('#projectTable').DataTable();
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
            // Reset form state
            resetFormState();
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
            // Reset form state
            resetFormState();
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
                        $('#projectTable').DataTable().ajax.reload(null, false);
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
                        $('#projectTable').DataTable().ajax.reload(null, false);
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