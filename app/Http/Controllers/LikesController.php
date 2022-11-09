<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LikesController extends Controller
{
    public function likePost(Request $request, $id)
    {
        if (!$request->cookie('likes')) {
            $likes = [];
            $disLikes = [];
            $cookieValue = [$likes, $disLikes];
        } else {
            $cookieValue = json_decode($request->cookie('likes'));
        }

        if (in_array($id, $cookieValue[1])) {
            if (($key = array_search($id, $cookieValue[1])) !== false) {
                unset($cookieValue[1][$key]);
            }
        }

        if (in_array($id, $cookieValue[0])) {
            $response = new Response('unlike');

            if (($key = array_search($id, $cookieValue[0])) !== false) {
                unset($cookieValue[0][$key]);
            }

            $response->withCookie(cookie('likes', json_encode($cookieValue), 10));
            return $response;
        } else {
            $response = new Response('like');
            array_push($cookieValue[0], $id);
            $response->withCookie(cookie('likes', json_encode($cookieValue), 10));
            return $response;
        }
    }
    public function getLikes(Request $request)
    {
        $values = json_decode($request->cookie('likes'));
        // $values = explode(',', $values[0]);
        // return ($values);
        foreach ($values[0] as $key => $value) {

            $post = Post::find($value);
            $values[0][$key] = $post;
        }
        return response()->json($values[0]);
    }

    public function dislikePost(Request $request, $id)
    {
        if (!$request->cookie('likes')) {
            $likes = [];
            $disLikes = [];
            $cookieValue = [$likes, $disLikes];
        } else {
            $cookieValue = json_decode($request->cookie('likes'));
        }

        if (in_array($id, $cookieValue[0])) {
            if (($key = array_search($id, $cookieValue[0])) !== false) {
                unset($cookieValue[0][$key]);
            }
        }

        if (in_array($id, $cookieValue[1])) {
            $response = new Response('undislike');

            if (($key = array_search($id, $cookieValue[1])) !== false) {
                unset($cookieValue[1][$key]);
            }

            $response->withCookie(cookie('likes', json_encode($cookieValue), 10));
            return $response;
        } else {
            $response = new Response('dislike');
            array_push($cookieValue[1], $id);
            $response->withCookie(cookie('likes', json_encode($cookieValue), 10));
            return $response;
        }
    }
    public function getDislikes(Request $request)
    {
        $values = json_decode($request->cookie('likes'));
        // $values = explode(',', $values[0]);
        // return ($values);

        foreach ($values[1] as $key => $value) {

            $post = Post::find($value);
            $values[1][$key] = $post;
        }
        return response()->json($values[1]);
    }
}
