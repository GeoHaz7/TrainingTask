<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //Store Post
    public function storeComment(Request $request)
    {
        if ($request->showName == 1) {
            if (Auth::check()) {
                $formFields['name'] = Auth::user()->name;
            } else {
                $formFields['name'] = $request->name;
            }
        } else {
            $formFields['name'] = 'Anonymous';
        }


        $formFields['content'] =
            $request->content;


        $formFields['post_id'] = $request->post_id;

        $formFields['status'] = false;

        //create post
        Comment::create($formFields);


        return redirect('/')->with('message', 'Post created');
    }

    //ManageComments View 
    public function manageComments()
    {
        return view('comments.manageComments', ['comments' => Comment::order()->paginate(10)]);
    }

    //Delete Comment
    public function deleteComment($id)
    {
        $comment = Comment::findorfail($id);


        if (auth()->user()->isAdmin) {

            $comment->delete();
            return response()->json('success');

            // return redirect('/')->with('message', 'Comment deleted successfully');
        } else {

            // Make sure logged in user is owner
            abort(403, 'Unauthorized Action');
        }
    }

    //toggle comment
    public function toggleComment($id)
    {
        $comment = Comment::findorfail($id);

        if (auth()->user()->isAdmin) {

            $comment->status = !$comment->status;

            $comment->save();

            return response()->json($comment->status);

            // return redirect('/')->with('message', 'Comment deleted successfully');
        } else {

            // Make sure logged in user is owner
            abort(403, 'Unauthorized Action');
        }
    }
}
