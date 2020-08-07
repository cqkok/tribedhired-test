<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use App\Post;
use App\TypiCode\CommentsAPI;
use App\TypiCode\PostsAPI;
use App\Contract\APIContract;

class TaskController extends Controller
{
    public function task1(CommentsAPI $comments_api, PostsAPI $post_api){
        $comments = $comments_api->all();

        $post_comments = $comments->countBy('postId');

        $posts = $post_api->all();

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

    public function task2(Request $request, CommentsAPI $comments_api){
        $search_critirea = $request->query();

        $comments = $this->advance_search($comments_api, $search_critirea);

        return $comments;
    }

    private function advance_search(APIContract $api, Array $search_critirea){
        $collection = $api->all();

        return $collection->filter(function ($item) use ($search_critirea){
            $filter_result = true;

            foreach($search_critirea as $key => $value){
                if (!isset($item[$key])){
                    continue;
                }

                switch ($key){
                case "postId":
                case "id":
                    $filter_result &= ($item[$key] == $value);
                    break;
                default:
                    $filter_result &= strpos($item[$key], $value);
                }
            }
            
            return $filter_result;
        });
    }
}
