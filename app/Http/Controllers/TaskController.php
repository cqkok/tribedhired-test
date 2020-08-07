<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

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

        $search_critirea = $request->query();

        $comments = $this->advance_search($comments, $search_critirea);

        return $comments;
    }

    private function fetchAPI(string $api) {
        return json_decode(file_get_contents('https://jsonplaceholder.typicode.com'.$api), true);
    }

    private function advance_search(Collection $collection, Array $search_critirea){
        return $collection->filter(function ($item) use ($search_critirea){
            $filter_result = true;

            foreach($search_critirea as $key => $value){
                if (!array_key_exists($key, $item)){
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
