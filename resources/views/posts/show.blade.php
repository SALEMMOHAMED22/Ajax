<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Post Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <a href="index.html" class="btn btn-sm btn-secondary mb-3">← Back</a>
        <div class="card">
            <div class="card-header">
                <h4 id="postTitle">{{ $post->title }}</h4>
            </div>
            <div class="card-body">
                <p id="postBody">{{ $post->body }}.</p>
            </div>
        </div>
    </div>

    {{-- <script>
        // Simulated posts (you can replace this with a backend later)
        const posts = {
            1: {
                title: "Laravel Tips",
                body: "This is a Laravel tips post."
            },
            2: {
                title: "PHP Best Practices",
                body: "Use PSR-4, type hints, and SOLID principles."
            },
            3: {
                title: "Bootstrap 4 UI",
                body: "Bootstrap 4 provides components like modals, navbars, and cards."
            }
        };

        const urlParams = new URLSearchParams(window.location.search);
        const postId = urlParams.get('id');

        if (posts[postId]) {
            document.getElementById('postTitle').textContent = posts[postId].title;
            document.getElementById('postBody').textContent = posts[postId].body;
        } else {
            document.getElementById('postTitle').textContent = 'Post Not Found';
            document.getElementById('postBody').textContent = 'Sorry, this post does not exist.';
        }
    </script> --}}
</body>

</html>
