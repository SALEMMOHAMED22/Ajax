<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\CreatePostNotification;

class PostController extends Controller
{
    public function index(){

        $posts = Post::paginate(2);
        return view('posts.index' , compact('posts'));
    }


    public function store(Request $request){

        $request->validate([
            'title' => 'required|max:255|min:3',
            'body' => 'required|max:255|min:3',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->user()->id
        ]);

        $users = User::where('id' , '!=' , auth()->user()->id)->get();

        foreach($users as $user){
            $user->notify(new CreatePostNotification($post));
        }

        if($post){
            return redirect()->route('posts.index')->with('success' , 'Post created successfully');
        }


        

    }


    public function show(Post $post){
        return view('posts.show' , compact('post'));
    }
}
