<!DOCTYPE html>
<html lang="en" id="ajax_pagination">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional custom styles -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table img {
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        #searchInput {
            border-radius: 10px;
            padding: 10px 15px;
        }

        #alert-message {
            text-align: center;
        }

        .btn {
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <ul>
            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li class="nav-item"
                    @if (config('app.locale') == $localeCode) style="background-color: rgb(208, 182, 182) ; width: 50px " @endif>
                    <a rel="alternate" hreflang="{{ $localeCode }}"
                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        {{ $properties['native'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <h2 class="mb-4 text-center text-primary">{{ __('words.user_list') }}</h2>

        <div id="alert-message" class="alert alert-success d-none"></div>

        <div class="input-group mb-4">
            <input type="text" id="searchInput" class="form-control"
                placeholder="Search by name, email, city or governorate...">
            <span class="input-group-text bg-primary text-white">
                <i class="bi bi-search"></i>
            </span>
        </div>

        <div class="ajax-table">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('words.name') }}</th>
                        <th>{{ __('words.email') }}</th>
                        <th>{{ __('words.governorate') }}</th>
                        <th>{{ __('words.city') }}</th>
                        <th>{{ __('words.image') }}</th>
                        <th>{{ __('words.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="user-row-{{ $user->id }}">
                            <td>{{ $user->getTranslation('name', app()->getLocale()) }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->governorate->name }}</td>
                            <td>{{ $user->city->name }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $user->image) }}" width="70" class="img-thumbnail">
                            </td>
                            <td>
                                <button id="deleteUser" user-id="{{ $user->id }}"
                                    class="btn btn-sm btn-danger">{{ __('words.delete') }}</button>
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="btn btn-sm btn-primary">{{ __('words.edit') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div id="pagination_search">
                {{ $users->links() }}
            </div>

            <div class="text-center">
                <a href="{{ route('users.create') }}" class="btn btn-primary mt-3">{{ __('words.add_user') }}</a>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 + jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX Script -->
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
                    $('#alert-message').removeClass('d-none').text(response.message).fadeOut(6000);
                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        });

        // live search by ajax with debounce
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
            }, 800);
        });

        // pagination search by ajax
        $(document).on('click', '#pagination_search a', function(e) {
            e.preventDefault();
            var search = $('#searchInput').val();
            var page = $(this).attr('href').split('page=')[1];

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
