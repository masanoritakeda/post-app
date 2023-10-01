<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

class PostPolicy
{
    public function edit(User $user, Post $post)
    {
        if($user->id === $post->user_id){
            return true;
        }  else {
            return false;
        }
        // return $user->id === $post->user_id; 
    }
}
