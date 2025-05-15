<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">انشاء مستخدم جديد</h2>
        <div id="alert-message" class="alert alert-success" style="display: none">

        </div>
        <div id="errors" class="alert alert-danger" style="display: none">

        </div>
        <form id="userForm">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Enter your name">
                <small id="name_error" class="text-danger"></small>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="Enter your email">
                <small id="email_error" class="text-danger"></small>

            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input name="password" type="password" class="form-control" id="password"
                    placeholder="Enter your password">
                <small id="password_error" class="text-danger"></small>

            </div>
            <div class="form-group">
                <label for="governorate">Governorate</label>
                <select name="governorate_id" class="form-control" id="governorate">
                    <option value="">Select Governorate</option>
                    @foreach ($governorates as $governorate)
                        <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                    @endforeach
                    <!-- Add more options as needed -->
                </select>
                <small id="governorate_id_error" class="text-danger"></small>

            </div>
            <div class="form-group">
                <label for="city">City</label>
                <select name="city_id" class="form-control" id="city">
                    <option value="">Select City</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                    <!-- Add more options as needed -->
                </select>
                <small id="city_id_error" class="text-danger"></small>

            </div>
            <div class="text-center">
                <button id="submitForm" class="btn btn-primary ">حفظ مستخدم </button>
            </div>
        </form>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <script>
        // Add User By Ajax 
        $(document).on('click', '#submitForm', function(e) {
            e.preventDefault();
            $('#name_error').text('');
            $('#email_error').text('');
            $('#password_error').text('');
            $('#governorate_id_error').text('');
            $('#city_id_error').text('');
            
            var formData = new FormData($('#userForm')[0]);
            $.ajax({
                url: "{{ route('users.store') }}",
                type: "POST",
                data: formData,
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
                        $('#'+key+'_error').text(value);

                    })
                }
            });

        });
    </script>
</body>

</html>
