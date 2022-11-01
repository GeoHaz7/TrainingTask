<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

        $post = Post::findorfail($id);
        $image = explode('|', $post->images);


        if (auth()->user()->isAdmin || $post->user_id == auth()->id()) {
            if ($post->images) {
                $dimagesArray = explode('|', $post->images);
                for ($i = 0; $i <= count($dimagesArray) - 1; $i++) {
                    unlink(public_path('storage\images\\' . $dimagesArray[$i]));
                    if (($key = array_search($dimagesArray[$i], $image)) !== false) {
                        unset($image[$key]);
                    }
                }
            }
            $post->delete();
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

        $formFields['dImage'] = $request->deletedImages;





        // $formFields = $request->validate(
        //     [
        //         'title' => ['required'],
        //         'categories' => ['required'],
        //         'image[]' => 'mimes:jpeg,png,bmp,tiff,jpg|max:4096',
        //     ],
        //     $messages = [
        //         'mimes' => 'Only jpeg, png, bmp,tiff,jpg are allowed.'
        //     ]
        // );

        $youtubeLink = $request->embed;

        $pos = strrpos($youtubeLink, '=') + 1;

        $youtubeLink = substr($youtubeLink, $pos);




        $formFields['embed'] = $youtubeLink;

        if ($post->images) {
            $image = explode('|', $post->images);
        }
        // $new_image = array();

        if (auth()->user()->isAdmin || $post->user_id == auth()->id()) {

            if ($files = $request->file(('image'))) {
                foreach ($files as $file) {

                    $image_name = md5(rand(1000, 10000));
                    $ext = strtolower($file->getClientOriginalExtension());
                    $image_full_name = $image_name . '.' . $ext;
                    $upload_path = 'storage/images/';
                    // $image_url = $upload_path . $image_full_name;
                    $file->move($upload_path, $image_full_name);
                    // $file->store('images', 'public');
                    // dump($file);
                    $new_image[] = $image_full_name;
                    $image[] = $image_full_name;
                }
            }


            if ($request->deletedImages) {
                $dimagesArray = explode(',', $request->deletedImages);
                for ($i = 0; $i <= count($dimagesArray) - 1; $i++) {
                    unlink(public_path('storage\images\\' . $dimagesArray[$i]));
                    if (($key = array_search($dimagesArray[$i], $image)) !== false) {
                        unset($image[$key]);
                    }
                }
            }


            $formFields['images'] = implode('|', $image);



            $formFields['status'] = $request->status;
            $formFields['content'] = $request->content;


            $post->update($formFields);

            return redirect('/')->with('message', 'Post Updated');

            // return response()->json(['status' => 200, 'message' => 'Post Updated successfully']);
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

        $formFields = $request->validate(
            [
                'title' => ['required'],
                'categories' => ['required'],
                'content' => ['required'],
                'image[]' => 'mimes:jpeg,png,bmp,tiff,jpg|max:4096',
            ],
            $messages = [
                // 'required' => 'The :attribute field is required.',
                'mimes' => 'Only jpeg, png, bmp,tiff,jpg are allowed.'
            ]
        );

        $youtubeLink = $request->embed;

        $pos = strrpos($youtubeLink, '=') + 1;

        $youtubeLink = substr($youtubeLink, $pos);



        $formFields['embed'] =
            $youtubeLink;

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
