<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Http\Controllers\Controller;

class PostsByUserController extends Controller
{
    /**
     * @param int $user_id
     * Display a listing of the resource.
     */
    public function show(int $user_id)
    {
        {
            try{
                $posts = Post::where('user_id',$user_id)->get();
    
                return response()->json(['posts_by_user'=>$posts], 200);
    
            } catch(\Exception $e){
                return response()->json([
                    'message'=>'Something went wrong in the PostsByUserController.show',
                    'error' => $e->getMessage()
                ],400);
            }
        }
    
    
    }

   
}
