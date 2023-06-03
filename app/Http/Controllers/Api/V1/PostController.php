<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Services\ImageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\StoreUpdatePostRequest;

class PostController extends Controller
{
    /**
     * 
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $postsPerPage = 1;
            $post = Post::with('user')
                   ->orderBy('updated_at','desc')
                   ->simplePaginate($postsPerPage);
            $pageCount = count(Post::all()) / $postsPerPage;


            return response()->json([
                                      'paginate'=>$post,
                                      'page_count'=> ceil($pageCount) 
                                     ], 200);

        } catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in the PostController.index',
                'error' => $e->getMessage()
            ],400);
        }
    }
   
    /**
     * @param App\Http\Requests\Post\StorePostRequest $request
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        try{

            if($request->hasFile('image')===false){
                return response()->json(['error'=>'No Image to upload'], 400);
            }

            $post = new Post;
            
            (new ImageService)->updateImage( $post, $request, '/images/posts/', 'store');

            $post ->title= $request->get('title');
            $post ->location= $request->get('location');
            $post ->description= $request->get('description');

            $post->save();

            return response()->json('New Post Created Successfuly', 200);

        } catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in the PostController.store',
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * @param int $id
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try{
            $post = Post::with('user')->findOrFail($id);

            return response()->json( $post, 200);

        } catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in the PostController.show',
                'error' => $e->getMessage()
            ],400);
        }
    }


     /**
     * @param App\Http\Requests\Post\StoreUpdatePostRequest $request
     * @param int $id
     * update the specified resource.
     */
   
    public function update(StoreUpdatePostRequest $request, int $id)
    {
        try{
            
            $post = Post::findOrFail($id);
            if($request->hasFile('image')){
                (new ImageService)->updateImage( $post, $request, '/images/posts/', 'update');
            }

           
            $post ->title= $request->get('title');
            $post ->location= $request->get('location');
            $post ->description= $request->get('description');

            $post->save();

            return response()->json('Post with id ' . $id . ' was updated!', 200);

        } catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in the PostController.update',
                'error' => $e->getMessage()
            ],400);
        }
    }

     /**
     * @param App\Http\Requests\Post\StoreUpdatePostRequest $request
     * @param int $id
     * destroy the specified resource.
     */

    public function destroy(int $id){
        try{
            $post = Post::findOrFail($id);
            if(!empty($post->image)){
                $currentImage = public_path().'/images/posts/'.$post->image;
                if($currentImage){
                    unlink($currentImage);
                }
            }
            $post->delete();
         
            return response()->json('New Post delated Successfuly', 201);

        } catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in the PostController.destroy',
                'error' => $e->getMessage()
            ],400);
        }

    }
}
