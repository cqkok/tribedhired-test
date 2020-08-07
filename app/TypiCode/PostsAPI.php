<?php

namespace App\TypiCode;

use Illuminate\Database\Eloquent\Collection;

use App\Contract\APIContract;
use App\Post;

class PostsAPI implements APIContract {
    protected $base_url;
    protected $posts;

    public function __construct(string $base_url){
        $this->base_url = $base_url;
    }

    public function all() : Collection{
        if ($this->posts){
            return $this->posts;
        }
        
        $posts = json_decode(file_get_contents($this->base_url.'/posts'), true);
        
        $this->posts = Post::hydrate($posts);

        return $this->posts;
    }
}