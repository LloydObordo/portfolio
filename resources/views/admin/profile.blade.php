@extends('layouts.master')

@section('links')
<!-- Toastr -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/toastr/toastr.min.css')}}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.css')}}">
<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
@endsection

@section('css')

@endsection

@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
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
            <div class="col-md-4">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ Auth::user()->profile_picture ? asset('storage/profile/' . Auth::user()->profile_picture) : asset('images/profile-hero.jpg') }}"
                            alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $user->name ?? 'Lloyd Obordo'}}</h3>

                        <p class="text-muted text-center">{{ ucfirst($user->role) ?? 'Superadmin'}}</p>

                        <a href="#" class="btn btn-light btn-sm btn-block" data-toggle="modal" data-target="#changePictureModal">
                            <i class="fas fa-camera mr-2"></i>Change Picture
                        </a>  
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-8">
                <!-- Profile Details Section -->
                <div class="profile-details">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title font-weight-bold">Profile Information</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="editUserForm" action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name ?? '' }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email ?? '' }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary float-right" id="confirmUpdate"><i class="fas fa-save mr-2"></i>Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Section -->
                    <div class="card card-primary card-outline mt-4">
                        <div class="card-header">
                            <h5 class="card-title font-weight-bold">Change Password</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="changePasswordForm" action="{{ route('profile.change.password') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    {{-- <label for="current_password">Current Password</label> --}}
                                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password" required>
                                </div>
                                <div class="form-group">
                                    {{-- <label for="new_password">New Password</label> --}}
                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" required>
                                    <!-- Password Generator Button -->
                                    <button type="button" class="btn btn-dark btn-sm mt-3 float-right" id="generatePasswordBtn">
                                        <i class="fas fa-cog mr-2"></i>Generate Strong Password
                                    </button>
                                    <div id="passwordIndicators" class="password-indicators">
                                        <small><span id="lengthIndicator" class="indicator">The password length must be greater than or equal to 12</span></small><br>
                                        <small><span id="uppercaseIndicator" class="indicator">The password must contain one or more uppercase characters</span></small><br>
                                        <small><span id="lowercaseIndicator" class="indicator">The password must contain one or more lowercase characters</span></small><br>
                                        <small><span id="numericIndicator" class="indicator">The password must contain one or more numeric values</span></small><br>
                                        <small><span id="specialCharIndicator" class="indicator">The password must contain one or more special characters (! @ # $ _ %)</span></small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{-- <label for="confirm_password">Confirm Password</label> --}}
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                                    <div class="password-indicators">
                                        <small><span id="confirmPasswordMismatch" class="indicator" style="color: red; display: none;">New password and confirm password did not match.</span></small>
                                        <small><span id="confirmPasswordMatch" class="indicator" style="color: green; display: none;">New password and confirm password did match.</span></small>
                                    </div>
                                </div>
                            </form>
                            <div class="form-group">
                                <div class="clearfix">
                                    <div class="float-left">
                                        <input type="checkbox" id="show_password" onclick="togglePasswords()">
                                        <label for="show_password">Show Password</label>
                                    </div>
                                    <div class="float-right">
                                        <button type="button" class="btn btn-sm btn-primary" id="confirmChangePasswordBtn">
                                            <i class="fas fa-key mr-2"></i>Change Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

<!-- Change Picture Modal -->
<div class="modal fade" id="changePictureModal" tabindex="-1" aria-labelledby="changePictureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePictureModalLabel">Change Profile Picture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadPictureForm" action="{{ route('profile.change.picture') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="profile_picture">Upload New Picture (JPG/PNG only)</label>
                        <input type="file" class="form-control-file" id="profile_picture" name="profile_picture" accept="image/jpeg, image/png" required>
                    </div>
                    <!-- Image Preview and Cropping Area -->
                    <div class="text-center">
                        <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 100%; max-height: 300px; display: none;">
                    </div>
                    <!-- Cropped Image Data (Hidden Input) -->
                    <input type="hidden" id="croppedImageData" name="cropped_image">
                    <!-- Zoom and Rotate Buttons -->
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-secondary btn-sm" id="zoomInBtn" style="display: none;">
                            <i class="fas fa-search-plus"></i> Zoom In
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" id="zoomOutBtn" style="display: none;">
                            <i class="fas fa-search-minus"></i> Zoom Out
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" id="rotateBtn" style="display: none;">
                            <i class="fas fa-undo"></i> Rotate
                        </button>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary mt-3 float-right">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Toastr -->
<script src="{{ asset('adminlte/plugins/toastr/toastr.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Cropper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
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
    // Handle update form submission
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = $('#confirmUpdate');

        clearErrors();
        disableSubmitButton();

        // Show confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to update your profile.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showLoaderOnConfirm: true,
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX request
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: handleSuccess,
                    error: handleError,
                    complete: enableSubmitButton
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
            // Show success message
            toastr.success(response.message || 'Item added successfully!', 'Success', {
                timeOut: 3000,
                progressBar: true,
                closeButton: true,
                newestOnTop: true
            });
            enableSubmitButton();
            // Reset form
            form[0].reset();
            clearErrors();
            // Reload the page to reflect changes after 1seconds
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
    });
</script>
<script>
    // VALIDATE PASSWORD  
    function validatePasswords() {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const lengthIndicator = document.getElementById('lengthIndicator');
        const uppercaseIndicator = document.getElementById('uppercaseIndicator');
        const lowercaseIndicator = document.getElementById('lowercaseIndicator');
        const numericIndicator = document.getElementById('numericIndicator');
        const specialCharIndicator = document.getElementById('specialCharIndicator');
        const confirmPasswordMismatch = document.getElementById('confirmPasswordMismatch');
        const confirmPasswordMatch = document.getElementById('confirmPasswordMatch');
        const confirmChangePasswordBtn = document.getElementById('confirmChangePasswordBtn');

        // Check password length
        const isLengthValid = newPassword.length >= 12;

        // Check for uppercase character
        const isUppercaseValid = /[A-Z]/.test(newPassword);

        // Check for lowercase character
        const isLowercaseValid = /[a-z]/.test(newPassword);

        // Check for numeric values
        const isNumericValid = /\d/.test(newPassword);

        // Check for special characters
        const isSpecialCharValid = /[!@#$_%]/.test(newPassword);

        // Update indicators
        lengthIndicator.classList.toggle('text-success', isLengthValid);
        uppercaseIndicator.classList.toggle('text-success', isUppercaseValid);
        lowercaseIndicator.classList.toggle('text-success', isLowercaseValid);
        numericIndicator.classList.toggle('text-success', isNumericValid);
        specialCharIndicator.classList.toggle('text-success', isSpecialCharValid);

        // Check if new password and confirm password match
        const doPasswordsMatch = newPassword === confirmPassword;

        // Show/hide mismatch indicator
        if (newPassword.trim() !== "" || confirmPassword.trim() !== "") {
            confirmPasswordMismatch.style.display = doPasswordsMatch ? 'none' : 'block';
            confirmPasswordMatch.style.display = doPasswordsMatch ? 'block' : 'none';
        } else {
            // If both fields are empty, hide both indicators
            confirmPasswordMismatch.style.display = 'none';
            confirmPasswordMatch.style.display = 'none';
        }
        
        // Enable/disable button based on all criteria
        const isFormValid = isLengthValid && isUppercaseValid && isLowercaseValid && isNumericValid && isSpecialCharValid && doPasswordsMatch;
        confirmChangePasswordBtn.disabled = !isFormValid;
    }

    // Attach event listeners to new password and confirm password
    document.getElementById('new_password').addEventListener('input', validatePasswords);
    document.getElementById('confirm_password').addEventListener('input', validatePasswords);

    // Handle paste event for password fields
    document.getElementById('new_password').addEventListener('paste', validatePasswords);
    document.getElementById('confirm_password').addEventListener('paste', validatePasswords);

    // Call validatePasswords on page load to set initial state
    document.addEventListener('DOMContentLoaded', validatePasswords);

    // Toggle password visibility
    function togglePasswords() {
        const passwordFields = ['current_password', 'new_password', 'confirm_password'];
        passwordFields.forEach(function(field) {
            const passwordInput = document.getElementById(field);
            passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
        });
    }

    // Function to generate a strong password
    function generateStrongPassword() {
        const uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
        const numericChars = '0123456789';
        const specialChars = '!@#$%';

        let password = '';
        let allChars = uppercaseChars + lowercaseChars + numericChars + specialChars;

        // Ensure at least one character from each set
        password += uppercaseChars[Math.floor(Math.random() * uppercaseChars.length)];
        password += lowercaseChars[Math.floor(Math.random() * lowercaseChars.length)];
        password += numericChars[Math.floor(Math.random() * numericChars.length)];
        password += specialChars[Math.floor(Math.random() * specialChars.length)];

        // Fill the rest of the password with random characters
        for (let i = 0; i < 8; i++) { // 12 characters total (4 already added)
            password += allChars[Math.floor(Math.random() * allChars.length)];
        }

        // Shuffle the password to randomize the order
        password = password.split('').sort(() => Math.random() - 0.5).join('');

        return password;
    }

    // Attach event listener to the Generate Password button
    document.getElementById('generatePasswordBtn').addEventListener('click', function() {
        const newPassword = generateStrongPassword();
        document.getElementById('new_password').value = newPassword;
        document.getElementById('confirm_password').value = newPassword;

        // Trigger validation to update indicators
        validatePasswords();
    });

    // SweetAlert2 Confirmation for Password Change
    document.getElementById('confirmChangePasswordBtn').addEventListener('click', function() {
        // Validate passwords again before showing the confirmation dialog
        validatePasswords();

        // Check if the button is disabled (form is invalid)
        if (document.getElementById('confirmChangePasswordBtn').disabled) {
            Swal.fire({
                title: 'Error',
                text: 'Please ensure all password criteria are met and the passwords match.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return; // Stop further execution
        }

        // Show confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to change your password.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showLoaderOnConfirm: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $('#changePasswordForm').attr('action'),
                    method: 'POST',
                    data: $('#changePasswordForm').serialize(),
                    success: function(response) {
                        // Show success message
                        toastr.success(response.message || 'Item added successfully!', 'Success', {
                            timeOut: 3000,
                            progressBar: true,
                            closeButton: true,
                            newestOnTop: true
                        });
                        // Reload the page to reflect changes
                        location.reload();
                    },
                    error: function(xhr) {
                        let errorMessage = 'Something went wrong. Please try again.';

                        if (xhr.status === 422) {
                            // Handle validation errors or incorrect password error
                            if (xhr.responseJSON.errors) {
                                // Validation errors
                                let errors = xhr.responseJSON.errors;
                                let errorMessages = '';
                                for (let field in errors) {
                                    errorMessages += `<div>${errors[field][0]}</div>`; // Display the first error for each field
                                }
                                errorMessage = `<div class="text-center">${errorMessages}</div>`;
                            } else if (xhr.responseJSON.error) {
                                // Incorrect password error
                                errorMessage = xhr.responseJSON.error;
                            }
                        }

                        // Display the error message in SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorMessage
                        });
                    }
                });
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let cropper;
        const profilePictureInput = document.getElementById('profile_picture');
        const imagePreview = document.getElementById('imagePreview');
        const croppedImageData = document.getElementById('croppedImageData');
        const uploadPictureForm = document.getElementById('uploadPictureForm');
        const changePictureModal = $('#changePictureModal');

        // Listen for file input change
        profilePictureInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                // Check if the file is an image
                if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File Type',
                        text: 'Please upload a JPG or PNG image.',
                    });
                    return;
                }

                // Read the file and display the preview
                const reader = new FileReader();
                reader.onload = function(event) {
                    imagePreview.src = event.target.result;
                    imagePreview.style.display = 'block';

                    // Initialize Cropper.js
                    if (cropper) {
                        cropper.destroy(); // Destroy existing cropper instance
                    }
                    cropper = new Cropper(imagePreview, {
                        aspectRatio: 1, // Square aspect ratio
                        viewMode: 1, // Restrict the crop box to the image size
                        autoCropArea: 1, // Automatically crop the entire image
                        responsive: true,
                    });

                    // Show zoom and rotate buttons
                    document.getElementById('zoomInBtn').style.display = 'inline-block';
                    document.getElementById('zoomOutBtn').style.display = 'inline-block';
                    document.getElementById('rotateBtn').style.display = 'inline-block';

                };
                reader.readAsDataURL(file);
            }
        });

        // Handle form submission with AJAX
        uploadPictureForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!cropper) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please select and crop an image before uploading.',
                });
                return;
            }

            // Get the cropped image as base64
            const croppedCanvas = cropper.getCroppedCanvas({ width: 300, height: 300 });

            if (!croppedCanvas) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please crop the image before uploading.',
                });
                return;
            }

            const croppedImageBase64 = croppedCanvas.toDataURL('image/jpeg');

            $.ajax({
                url: "{{ route('profile.change.picture') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cropped_image: croppedImageBase64,
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            changePictureModal.modal('hide'); // Close modal
                            location.reload(); // Reload to update the profile picture
                        }
                    });
                },
                error: function (xhr) {
                    let errorMessage = 'An error occurred while updating the profile picture.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Zoom In
        document.getElementById('zoomInBtn').addEventListener('click', function() {
            if (cropper) {
                cropper.zoom(0.1); // Zoom in by 10%
            }
        });

        // Zoom Out
        document.getElementById('zoomOutBtn').addEventListener('click', function() {
            if (cropper) {
                cropper.zoom(-0.1); // Zoom out by 10%
            }
        });

        // Rotate
        document.getElementById('rotateBtn').addEventListener('click', function() {
            if (cropper) {
                cropper.rotate(90); // Rotate 90 degrees clockwise
            }
        });

        // Reset modal content when closed
        changePictureModal.on('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy(); // Destroy the cropper instance
                cropper = null;
            }
            imagePreview.src = '#';
            imagePreview.style.display = 'none';
            profilePictureInput.value = ''; // Clear the file input
            document.getElementById('zoomInBtn').style.display = 'none';
            document.getElementById('zoomOutBtn').style.display = 'none';
            document.getElementById('rotateBtn').style.display = 'none';
        });
    });
</script>
@endsection