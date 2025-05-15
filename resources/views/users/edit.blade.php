
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
        <h2 class="mb-4 text-center">User Registration</h2>
        <div class="alert alert-success" id="alert-message" style="display: none">

        </div>
        <form>
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" value="{{ $user->name }}" placeholder="Enter your name">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" value="{{ $user->email }}" id="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" value="{{ $user->password }}" class="form-control" id="password" placeholder="Enter your password">
            </div>
            <div class="form-group">
                <label for="governorate">Governorate</label>
                <select class="form-control" id="governorate_id">
                    <option value="">Select Governorate</option>
                   @foreach ($governorates as $governorate)
                        <option value="{{ $governorate->id }}" @selected($user->governorate_id == $governorate->id)>{{ $governorate->name }}</option>
                   @endforeach
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <select class="form-control" id="city_id">
                    <option value="">Select City</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" @selected($user->city_id == $city->id)>{{ $city->name }}</option>
                    @endforeach
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="text-center">
                <button user-id="{{ $user->id }}" id="submitForm" type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
       <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


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
                        $('#alert-message').text(response.message).show().fadeOut(8000);
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



