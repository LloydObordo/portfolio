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
@endsection

@section('css')
<style>
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
    .social-input-group .input-group-text {
        min-width: 100px;
    }
    .tab-content {
        padding: 20px 0;
    }
    .form-section {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    /* .section-title {
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
        color: #3c8dbc;
    } */
     /* Modal styling */
    #filePreviewModal .modal-xl {
        max-width: 90%;
    }

    /* Iframe styling */
    #filePreviewFrame {
        min-height: 70vh;
    }

    /* Unsupported file message styling */
    #unsupportedFileMessage {
        min-height: 70vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Professional Summary</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
              <li class="breadcrumb-item active">Professional Summary</li>
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
            <form id="professionalSummaryForm" method="POST" action="{{ route('summary.update') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Personal Information Section -->
                <div class="card card-primary card-outline mb-4">
                  <div class="card-header">
                    <h3 class="card-title mb-0"><i class="fas fa-user mr-2"></i>Personal Information</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="firstname">Firstname <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname', $summary->firstname ?? '') }}">
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="middlename">Middlename</label>
                          <input type="text" class="form-control" id="middlename" name="middlename" value="{{ old('middlename', $summary->middlename ?? '') }}">
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="lastname">Lastname <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname', $summary->lastname ?? '') }}">
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group">
                          <label for="qualifier">Qlf</label>
                          <input type="text" class="form-control" id="qualifier" name="qualifier" value="{{ old('qualifier', $summary->qualifier ?? '') }}">
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="shortname">Shortname</label>
                          <input type="text" class="form-control" id="shortname" name="shortname" value="{{ old('shortname', $summary->shortname ?? '') }}">
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Profile Images Section -->
                <div class="card card-primary card-outline mb-4">
                  <div class="card-header">
                    <h3 class="card-title mb-0"><i class="fas fa-images mr-2"></i>Profile Images</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Profile Image</label>
                          <div class="d-block">
                            <a href="{{ isset($summary->profile_image) ? asset('storage/'.$summary->profile_image) : asset('images/default.jpg') }}" data-fancybox="photos" data-caption="Profile Image">
                              <img id="profileImagePreview" src="{{ isset($summary->profile_image) ? asset('storage/'.$summary->profile_image) : asset('images/default.jpg') }}" class="image-preview">
                            </a>
                            <br>
                            <div class="file-input-wrapper">
                              <button type="button" class="btn btn-sm btn-primary">
                                <i class="fas fa-upload mr-2"></i>Upload Profile Image
                              </button>
                              <input type="file" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(this, 'profileImagePreview')">
                            </div>
                            <small class="form-text text-muted">Recommended size: 500x500 pixels</small>
                          </div>
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Cover Image</label>
                          <div class="d-block">
                            <a href="{{ isset($summary->cover_image) ? asset('storage/'.$summary->cover_image) : asset('images/default.jpg') }}" data-fancybox="photos" data-caption="Cover Image">
                              <img id="coverImagePreview" src="{{ isset($summary->cover_image) ? asset('storage/'.$summary->cover_image) : asset('images/default.jpg') }}" class="image-preview">
                            </a>
                            <br>
                            <div class="file-input-wrapper">
                              <button type="button" class="btn btn-sm btn-primary">
                                <i class="fas fa-upload mr-2"></i>Upload Cover Image
                              </button>
                              <input type="file" id="cover_image" name="cover_image" accept="image/*" onchange="previewImage(this, 'coverImagePreview')">
                            </div>
                            <small class="form-text text-muted">Recommended size: 1500x500 pixels</small>
                          </div>
                          <div class="invalid-feedback"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Professional Content Section -->
                <div class="card card-primary card-outline mb-4">
                  <div class="card-header">
                    <h3 class="card-title mb-0"><i class="fas fa-file-alt mr-2"></i>Professional Content</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="biography">Biography</label>
                      <textarea class="form-control" id="biography" name="biography" rows="5">{{ old('biography', $summary->biography ?? '') }}</textarea>
                      <small class="form-text text-muted">A detailed description about yourself (500-1000 words).</small>
                      <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                      <label for="summary">Professional Summary</label>
                      <textarea class="form-control" id="summary" name="summary" rows="5">{{ old('summary', $summary->summary ?? '') }}</textarea>
                      <small class="form-text text-muted">A concise summary of your professional background (100-200 words).</small>
                      <div class="invalid-feedback"></div>
                    </div>
                  </div>
                </div>

                <!-- Documents Section -->
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fas fa-file-pdf mr-2"></i>Documents</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="resume">Resume</label>
                                    @if(isset($summary->resume))
                                    <div class="mb-2">
                                        <button type="button" class="btn btn-sm btn-info view-file-btn" 
                                                data-url="{{ asset('storage/'.$summary->resume) }}"
                                                data-title="Resume">
                                            <i class="fas fa-eye mr-2"></i>View Current Resume
                                        </button>
                                    </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="resume" name="resume" accept=".pdf,.doc,.docx">
                                        <label class="custom-file-label" for="resume">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted">PDF or Word document (Max 5MB)</small>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cv">CV</label>
                                    @if(isset($summary->cv))
                                    <div class="mb-2">
                                        <button type="button" class="btn btn-sm btn-info view-file-btn" 
                                                data-url="{{ asset('storage/'.$summary->cv) }}"
                                                data-title="CV">
                                            <i class="fas fa-eye mr-2"></i>View Current CV
                                        </button>
                                    </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="cv" name="cv" accept=".pdf,.doc,.docx">
                                        <label class="custom-file-label" for="cv">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted">PDF or Word document (Max 5MB)</small>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Information Section -->
                <div class="card card-primary card-outline mb-4">
                  <div class="card-header">
                  <h3 class="card-title mb-0"><i class="fas fa-address-book mr-2"></i>Contact Information</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                  </div>
                  </div>
                  <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                      <label for="address">Address</label>
                      <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $summary->address ?? '') }}">
                      <div class="invalid-feedback"></div>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone">Phone</label>
                      <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $summary->phone ?? '') }}">
                      <div class="invalid-feedback"></div>
                    </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email <span class="text-danger">*</span></label>
                      <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $summary->email ?? '') }}">
                      <div class="invalid-feedback"></div>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                      <label for="website">Website</label>
                      <input type="url" class="form-control" id="website" name="website" value="{{ old('website', $summary->website ?? '') }}">
                      <div class="invalid-feedback"></div>
                    </div>
                    </div>
                  </div>
                  </div>
                </div>
                
                <!-- Social Media Section -->
                <div class="card card-primary card-outline mb-4">
                  <div class="card-header">
                  <h3 class="card-title mb-0"><i class="fas fa-share-alt mr-2"></i>Social Media</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                  </div>
                  </div>
                  <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                      <label for="linkedin">LinkedIn</label>
                      <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                      </div>
                      <input type="url" class="form-control" id="linkedin" name="linkedin" placeholder="https://linkedin.com/in/username" value="{{ old('linkedin', $summary->linkedin ?? '') }}">
                      </div>
                      <div class="invalid-feedback"></div>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                      <label for="github">GitHub</label>
                      <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fab fa-github"></i></span>
                      </div>
                      <input type="url" class="form-control" id="github" name="github" placeholder="https://github.com/username" value="{{ old('github', $summary->github ?? '') }}">
                      </div>
                      <div class="invalid-feedback"></div>
                    </div>
                    </div>
                  </div>
                  </div>
                </div>
                
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary btn-md" id="saveChangesBtn">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<!-- File Preview Modal -->
<div class="modal fade" id="filePreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="filePreviewModalTitle">File Preview</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe id="filePreviewFrame" class="embed-responsive-item" 
                            style="width:100%; height:100%; border:none;"></iframe>
                </div>
                <div id="unsupportedFileMessage" class="text-center py-4" style="display:none;">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h4>File preview not available</h4>
                    <p>This file type cannot be previewed in the browser.</p>
                    <a href="#" id="downloadFileLink" class="btn btn-primary">
                        <i class="fas fa-download mr-2"></i>Download File
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
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
    $(document).ready(function() {
        // Initialize custom file input
        bsCustomFileInput.init();
        
        // Image preview function
        window.previewImage = function(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Form submission with confirmation
        $('#professionalSummaryForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const submitBtn = $('#saveChangesBtn');

            clearErrors();
            disableSubmitButton();
            
            // Show confirmation dialog
            Swal.fire({
                title: 'Save Changes?',
                text: 'Are you sure you want to update your professional summary?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save changes!',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form via AJAX
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: new FormData(form[0]),
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            // Show loading indicator only when the request is about to be sent
                            Swal.fire({
                                title: 'Saving...',
                                html: 'Please wait while we save your information.',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            });
                        },
                        success: handleSuccess,
                        error: handleError,
                        complete: function() {
                            enableSubmitButton();
                            Swal.close(); // Ensure loader is closed
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    enableSubmitButton();
                }
            });

            // Handle clearing of previous errors
            function clearErrors() {
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();
            }

            // Handle submit button state
            function enableSubmitButton() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save mr-2"></i>Save Changes');
            }
            
            function disableSubmitButton() {
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
            }

            function handleSuccess(response) {
                // Close any open Swal dialogs
                Swal.close();
                
                // Show success message
                toastr.success(response.message || 'Data updated successfully!', 'Success', {
                    timeOut: 3000,
                    progressBar: true,
                    closeButton: true,
                    newestOnTop: true
                });
                
                // Reload the page to reflect changes after 1 second
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }

            function handleError(xhr) {
                // Close the loading dialog immediately when error occurs
                Swal.close();
                
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
</script>
<script>
  $(document).ready(function() {
    // Handle file preview button clicks
    $(document).on('click', '.view-file-btn', function(e) {
        e.preventDefault();
        const fileUrl = $(this).data('url');
        const title = $(this).data('title');
        
        // Set modal title
        $('#filePreviewModalTitle').text('Viewing ' + title);
        
        // Check file type
        const fileExt = fileUrl.split('.').pop().toLowerCase();
        const isPdf = fileExt === 'pdf';
        const isImage = ['jpg', 'jpeg', 'png', 'gif'].includes(fileExt);
        const isDoc = ['doc', 'docx'].includes(fileExt);
        
        // Show appropriate content based on file type
        if (isPdf || isImage) {
            // For PDFs and images, show in iframe
            $('#filePreviewFrame').attr('src', 
                isPdf ? fileUrl : 
                'https://docs.google.com/viewer?url=' + encodeURIComponent(fileUrl) + '&embedded=true');
            $('#filePreviewFrame').show();
            $('#unsupportedFileMessage').hide();
        } else if (isDoc) {
            // For Word docs, use Google Docs viewer
            $('#filePreviewFrame').attr('src', 
                'https://docs.google.com/viewer?url=' + encodeURIComponent(fileUrl) + '&embedded=true');
            $('#filePreviewFrame').show();
            $('#unsupportedFileMessage').hide();
        } else {
            // For unsupported types, show download option
            $('#filePreviewFrame').hide();
            $('#unsupportedFileMessage').show();
            $('#downloadFileLink').attr('href', fileUrl);
        }
        
        // Show the modal
        $('#filePreviewModal').modal('show');
    });
    
    // Reset modal when closed
    $('#filePreviewModal').on('hidden.bs.modal', function () {
        $('#filePreviewFrame').attr('src', '');
    });
});
</script>
@endsection