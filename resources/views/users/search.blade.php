<table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Governorate</th>
                    <th>City</th>
                    <th>Image</th>
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
                            <button id="deleteUser" user-id="{{ $user->id }}" class="btn btn-danger">Delete</button>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                        </td>
                    </tr>
                  @endforeach
                
            </tbody>
        </table>
<div id="pagination_search">
        {{ $users->links() }}

</div>