<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;

class TaskController extends Controller
{
    public function task1(){
        $comments_data = $this->fetchAPI('/comments');
        $comments = Comment::hydrate($comments_data);

        $post_comments = $comments->countBy('postId');

        $posts_data = $this->fetchAPI('/posts');
        $posts = Post::hydrate($posts_data);

        $response = $posts->map(function($item, $key) use ($post_comments){
            return [
                'post_id' => $item->id,
                'post_title' => $item->title,
                'post_body' => $item->body,
                'total_number_of_comments' => $post_comments[$item->id]
            ];
        });

        return $response;
    }

    public function task2(Request $request){
        $comments_data = $this->fetchAPI('/comments');
        $comments = Comment::hydrate($comments_data);

        $queries = $request->query();

        $comments = $comments->filter(function ($comment) use ($queries){
            $result = true;

            foreach($queries as $key => $value){
                switch ($key){
                case "postId":
                case "id":
                    $result &= ($comment[$key] == $value);
                    break;
                default:
                    $result &= strpos($comment[$key], $value);
                }
            }
            
            return $result;
        });

        return $comments;
    }

    private function fetchAPI($api) {
        return json_decode(file_get_contents('https://jsonplaceholder.typicode.com'.$api), true);
    }
}
