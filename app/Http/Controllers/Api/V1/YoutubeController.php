<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Youtube;
use App\Http\Controllers\Controller;
use App\Http\Requests\Youtube\StoreYouTubeRequest;

class YoutubeController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreYouTubeRequest $request)
    {
        try{
            $yt = new Youtube;
            $yt -> user_id = $request-> get('user_id');
            $yt -> title = $request-> get('title');
            $yt -> url = env('YT_EMBED_URL').$request-> get('url') . "?autoplay=0";
            
            $yt->save();

            return response()->json('New Video created successfully', 200);


        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in the YoutubeController.store',
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * @param int $user_id
     * Display the specified resource.
     */
    public function show( int $user_id)
    {
        try{
            $videosByUser = Youtube::where('user_id',$user_id)->get();

            return response()->json(['videoby_user' => $videosByUser],200);


        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in the YoutubeController.show',
                'error' => $e->getMessage()
            ],400);
        }
    }


    /**
     * @param int $id
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try{
            $yt = Youtube::findorFail($id);
            $yt->delete();

            return response()->json('Video deleted successfuly', 200);


        }catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in the YoutubeController.destroy',
                'error' => $e->getMessage()
            ],400);
        }
    }
}
