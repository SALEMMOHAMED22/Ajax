<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Simple Post Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    {{-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        {{-- <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> --}}

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('posts.index') }}">Posts</a>
                </li>

                <li class="nav-item dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="notificationDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="badge badge-danger">{{ Auth::user()->unreadNotifications()->count() }}</span>
                    </button>
                   
                    <div class="dropdown-menu" aria-labelledby="notificationDropdown" style="min-width: 250px;">
                         <div>
                        <a class="dropdown-item" href="{{ route('notifications.deleteAll') }}">Delete All</a>
                    </div>
                        @forelse (Auth::user()->unreadNotifications as $notification)
                            <a class="dropdown-item"
                                href="{{ $notification->data['link'] }}?notify_id={{ $notification->id }}">🔔
                                {{ $notification->data['user_name'] }}:{{ $notification->data['title'] }}</a>
                                <a href="{{ route('notifications.delete' , $notification->id) }}">Delete</a>
                        @empty
                            <div>
                                <p class="dropdown-item">No notifications</p>
                            </div>
                        @endforelse
                        <div>
                            <a class="dropdown-item" href="{{ route('notifications.markAsRead') }}">All As Read</a>
                        </div>

                    </div>

                </li>


            </ul>
        </div>
    </nav>

    <!-- Navbar -->
    {{-- <div class="dropdown ml-auto">
        <button class="btn btn-light dropdown-toggle" type="button" id="notificationDropdown" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell"></i>
            <span class="badge badge-danger">3</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown" style="min-width: 250px;">
            <a class="dropdown-item" href="post-show.html?id=1">🔔 New post: Laravel Tips</a>
            <a class="dropdown-item" href="post-show.html?id=2">🔔 New post: PHP Best Practices</a>
            <a class="dropdown-item" href="post-show.html?id=3">🔔 New post: Bootstrap 4 UI</a>
        </div>
    </div> --}}

    <!-- Main Container -->
    <div class="container mt-4">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Post Form -->
        <div class="card mb-4">
            <div class="card-header">Create a Post</div>
            <div class="card-body">
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="post_title">Post Title</label>
                        <input name="title" type="text" class="form-control" id="post_title"
                            placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="post_body">Post Body</label>
                        <textarea name="body" class="form-control" id="post_body" rows="4" placeholder="Write your post..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>

        <!-- Posts List -->
        <h4>All Posts</h4>

        @forelse ($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->body }}</p>
                    <small>Create By : {{ $post->user->name }}</small><br>
                    <small>Created At : {{ $post->created_at->diffForHumans() }}</small><br>
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">View</a>
                </div>
            </div>

        @empty
            <p>No posts found.</p>
        @endforelse
        {{ $posts->links() }}


    </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

</html>
