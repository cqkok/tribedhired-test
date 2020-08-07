<?php

namespace App\TypiCode;

use Illuminate\Support\Collection;

use App\Contract\APIContract;
use App\Comment;

class CommentsAPI implements APIContract {
    protected $base_url;
    protected $comments;

    public function __construct(string $base_url){
        $this->base_url = $base_url;
    }

    public function all(){
        if ($this->comments){
            return $this->comments;
        }
        
        $comments = json_decode(file_get_contents($this->base_url.'/comments'), true);
        
        $this->comments = Comment::hydrate($comments);

        return $this->comments;
    }
}