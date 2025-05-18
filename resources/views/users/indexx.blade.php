<!DOCTYPE html>
<html lang="en" id="ajax_pagination">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">User List</h2>
        <br>
        <div id="alert-message" class="alert alert-success" style="display: none">

        </div>
        <input type="text" id="searchInput" class="form-control" placeholder="Search Here ... ">
        <br>
        <div class="ajax-table">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Governorate</th>
                        <th>City</th>
                        <th>
                            Image
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $user)
                        <tr class="user-row-{{ $user->id }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->governorate->name }}</td>
                            <td>{{ $user->city->name }}</td>
                            <td>
                                <img src="{{ asset('storage/'.$user->image ) }} " class="img-fluid" width="70px" alt="User Image">
                            </td>
                            <td>
                                <button id="deleteUser" user-id="{{ $user->id }}"
                                    class="btn btn-danger">Delete</button>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div id="pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <script>
        // delete by ajax
        $(document).on('click', '#deleteUser', function(e) {
            e.preventDefault();

            var user_id = $(this).attr('user-id');
            $.ajax({
                url: '{{ route('users.delete') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: user_id,
                },

                success: function(response) {
                    $('.user-row-' + response.id).remove();
                    $('#alert-message').text(response.message).show();
                    $('#alert-message').fadeOut(8000);
                    // $('#alert-message').on('click', function() {
                    //    $(this).hide(); 
                    // });
                },
                error: function(reject) {
                    console.log(reject);
                }

            });
        });

        // live search by ajax
        let debounce;
        $(document).on('input', '#searchInput', function(e) {
            e.preventDefault();
            var search = $(this).val();
            clearTimeout(debounce);
            debounce = setTimeout(() => {
                $.ajax({
                    url: '{{ route('users.search') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        search: search,
                    },
                    success: function(response) {
                        $('.ajax-table').html(response);
                    },
                });
            }, 2000);

        });

        // pagination by ajax
        $(document).on('click', '#pagination a', function(e) {
            e.preventDefault();
            var link = $(this).attr('href');

            $.ajax({
                url: link,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    $('#ajax_pagination').html(response);
                },
            });


        });

        // pagination search by ajax
         $(document).on('click', '#pagination_search  a', function(e) {
            e.preventDefault();
            var search = $('#searchInput').val();

            var page = $(this).attr('href').split('page=')[1];
            // var link = $(this).attr('href');

            $.ajax({
                url: '/users/search',
                type: 'POST',
                dataType: 'html',
                data: {
                    _token: '{{ csrf_token() }}',
                    search: search,  
                    page: page,
                },
                success: function(response) {
                    $('.ajax-table').html(response);
                },
            });


        });



    </script>



</body>

</html>
