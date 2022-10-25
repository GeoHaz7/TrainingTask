<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PostController extends Controller
{
    //ALL Posts
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::order()->paginate(3)
        ]);
    }

    //Delete Post
    public function deletePost($id)
    {

        $user = Post::findorfail($id);


        if (auth()->user()->isAdmin || $user->user_id == auth()->id()) {
            $user->delete();
            return redirect('/')->with('message', 'Post deleted successfully');
        } else

            // Make sure logged in user is owner
            abort(403, 'Unauthorized Action');
    }

    //Posts by User
    public function userPosts($user_id)
    {
        $user = User::find($user_id);
        $posts = Post::author($user_id)->paginate(3);


        // $posts = $user->posts()->get()->paginate(3);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    //Edit Post
    public function editPost($id)
    {
        $post = Post::findorfail($id);

        return view('posts.editPost', ['post' => $post]);
    }

    //Update Post
    public function updatePost(Request $request, $id)
    {
        $post = Post::findorfail($id);

        $formFields = $request->validate([
            'title' => ['required'],
            'categories' => ['required'],
            'content' => ['required']
        ]);

        if (auth()->user()->isAdmin || $post->user_id == auth()->id()) {

            $image = array();
            if ($files = $request->file(('image'))) {
                foreach ($files as $file) {

                    $image_name = md5(rand(1000, 10000));
                    $ext = strtolower($file->getClientOriginalExtension());
                    $image_full_name = $image_name . '.' . $ext;
                    $upload_path = 'storage/images/';
                    $image_url = $upload_path . $image_full_name;
                    $file->move($upload_path, $image_full_name);
                    // $file->store('images', 'public');
                    // dump($file);
                    $image[] = $image_full_name;
                    // $image[] = $image_full_name;
                }
            }

            $formFields['images'] = implode('|', $image);

            $post->update($formFields);

            return redirect('/')->with('message', 'Post Updated successfully');
        } else

            // Make sure logged in user is owner
            abort(403, 'Unauthorized Action');
    }

    //Add Post
    public function addPost()
    {
        return view('posts.addPost');
    }

    //Store Post
    public function storePost(Request $request)
    {

        $formFields = $request->validate([
            'title' => ['required'],
            'categories' => ['required'],
            'content' => ['required']
        ]);

        // if ($request->hasFile('images')) {
        //     $formFields['images'] =
        //         $request->file('images')->store('images', 'public');
        // }

        //
        $image = array();
        if ($files = $request->file(('image'))) {
            foreach ($files as $file) {

                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $upload_path = 'storage/images/';
                $image_url = $upload_path . $image_full_name;
                $file->move($upload_path, $image_full_name);
                // $file->store('images', 'public');
                // dump($file);
                $image[] = $image_full_name;
                // $image[] = $image_full_name;
            }
        }

        $formFields['images'] = implode('|', $image);

        //



        $formFields['user_id'] = auth()->user()->id;
        $formFields['status'] = '1';



        //create post
        $post = Post::create($formFields);


        return redirect('/')->with('message', 'Post created');
    }
}
