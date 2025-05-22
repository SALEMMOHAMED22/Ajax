<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body {
            background-color: #f0f2f5;
        }
        .card {
            border: none;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
        }
        .btn-primary {
            border-radius: 25px;
            padding: 10px 30px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <h2 class="mb-4 text-center">✏️ Edit User</h2>
            <form>
                <div class="form-group">
                    <label for="name">{{ __('words.name_ar') }}</label>
                    <input type="text" class="form-control" id="name" value="{{ $user->getTranslation('name', 'ar') }}" placeholder="Enter full name">
                </div>
                <div class="form-group">
                    <label for="name">{{ __('words.name_en') }}</label>
                    <input type="text" class="form-control" id="name" value="{{ $user->getTranslation('name', 'en') }}" placeholder="Enter full name">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" placeholder="Enter email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" value="{{ $user->password }}" placeholder="Enter new password">
                </div>

                <div class="form-group">
                    <label for="governorate">Governorate</label>
                    <select class="form-control" id="governorate_id">
                        <option value="">Select Governorate</option>
                        @foreach ($governorates as $governorate)
                            <option value="{{ $governorate->id }}" @selected($user->governorate_id == $governorate->id)>
                                {{ $governorate->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <select class="form-control" id="city_id">
                        <option value="">Select City</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" @selected($user->city_id == $city->id)>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-center mt-4">
                    <button user-id="{{ $user->id }}" id="submitForm" type="submit" class="btn btn-primary">💾 Update User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
          $(document).on('click', '#submitForm', function(e) {
                e.preventDefault();
                var user_id = $(this).attr('user-id');
                $.ajax({
                    url: "{{ route('users.update') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: user_id,
                        name: $('#name').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                        governorate_id: $('#governorate_id').val(),
                        city_id: $('#city_id').val(),

                    } ,

                    success: function(response) {
                        // $('#alert-message').text(response.message).show().fadeOut(8000);
                        toastr.options.closeButton = true;
                        toastr.success(response.message);
                        // $('#alert-message').fadeOut(8000);

                    },
                    error: function(reject) {
                        console.log(reject);
                    }
                });
            });
    </script>
</body>
</html>
