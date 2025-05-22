<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">{{ __('words.create_new_user') }}</h2>
        <div id="alert-message" class="alert alert-success" style="display: none">

        </div>
        <div id="errors" class="alert alert-danger" style="display: none">

        </div>
        <form id="userForm">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('words.name_ar') }}</label>
                <input name="name[ar]" type="text" class="form-control" id="name_ar" placeholder="{{ __('words.enter_name') }}">
                <small id="name['ar']_error" class="text-danger"></small>
            </div>
            <div class="form-group">
                <label for="name">{{ __('words.name_en') }}</label>
                <input name="name[en]" type="text" class="form-control" id="name_en" placeholder="{{ __('words.enter_name') }}">
                <small id="name['en']_error" class="text-danger"></small>
            </div>
            <div class="form-group">
                <label for="email">{{ __('words.email') }}</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="Enter your email">
                <small id="email_error" class="text-danger"></small>

            </div>
            <div class="form-group">
                <label for="password">{{ __('words.password') }}</label>
                <input name="password" type="password" class="form-control" id="password"
                    placeholder="Enter your password">
                <small id="password_error" class="text-danger"></small>

            </div>
            <div class="form-group">
                <label for="governorate">{{ __('words.governorate') }}</label>
                <select name="governorate_id" class="form-control" id="governorate">
                    <option value="">{{ __('words.select_governorate') }}</option>
                    @foreach ($governorates as $governorate)
                        <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                    @endforeach
                    <!-- Add more options as needed -->
                </select>
                <small id="governorate_id_error" class="text-danger"></small>

            </div>
            <div class="form-group">
                <label for="city">{{ __('words.city') }}</label>
                <select name="city_id" class="form-control" id="city">
                    <option value="">{{ __('words.select_city') }}</option>
                    {{-- @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach --}}
                    <!-- Add more options as needed -->
                </select>
                <small id="city_id_error" class="text-danger"></small>

            </div>
            <div class="form-group">
                <label for="image">{{ __('words.image') }}</label>
                <input name="image" type="file" class="form-control dropify" id="image">
                <small id="image_error" class="text-danger"></small>

            </div>
            <div class="form-group">
                <img src="" alt="" id="image_preview" class="img-fluid" width="70px">
            </div>

            <div class="text-center">
                <button id="submitForm" class="btn btn-primary "> {{ __('words.save') }} </button>
            </div>
        </form>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script src= "//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    {{-- Image Preview Using Dropify --}}
    <script>
        $('.dropify').dropify();
    </script>

    <script>
        // Image Preview
        $(document).on('change', '#image', function(e) {
            e.preventDefault();

            var file = this.files[0];
            if (file) {
                 reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }

        });

        // Add User By Ajax 
        $(document).on('click', '#submitForm', function(e) {
            e.preventDefault();
            $('#name.ar_error').text('');
            $('#name.en_error').text('');
            $('#email_error').text('');
            $('#password_error').text('');
            $('#governorate_id_error').text('');
            $('#city_id_error').text('');

            var formData = new FormData($('#userForm')[0]);
            $.ajax({
                url: "{{ route('users.store') }}",
                type: "POST",
                data: formData,
                enctype: "multipart/form-data",
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#userForm')[0].reset();
                    $('#alert-message').text(response.message).show();

                    $('#errors').remove();
                },
                error: function(reject) {
                    var response = $.parseJSON(reject.responseText);

                    $.each(response.errors, function(key, value) {
                        // show all errors above form
                        $('#errors').append('<li>' + value + '</li>').show();

                        // show error under form field
                        $('#' + key + '_error').text(value);

                    })
                }
            });

        });


        $(document).on('change', '#governorate', function(e) {
            e.preventDefault();
            var governorate_id = $(this).val();
            $.ajax({
                url: "{{ route('users.cities') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    governorate_id: governorate_id,
                },
                success: function(response) {
                    $('#city').empty();
                    $('#city').append('<option value="">Select City</option>');
                    $.each(response, function(index, city) {
                        $('#city').append('<option value="' + city.id + '">' + city.name +
                            '</option>');
                    });
                },
                error: function(reject) {
                    console.log(reject);
                }


            });
        });
    </script>
</body>

</html>
