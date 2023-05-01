<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Song;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Song\StoreSongRequest;

class SongController extends Controller
{
   
    public function store(StoreSongRequest $request)
    {
        try{
            $file = $request->file;
            if(empty($file)){
                return response()->json('No Song Uploaded', 400);
            }
            $user = User::findOrFail($request->get('user_id'));
            $song = $file->getClientOriginalName();
            $file->move('songs/'.$user->id,$song);

            Song::create([
                'user_id'=> $request->get('user_id'),
                'title'=> $request->get('title'),
                'song'=> $song,
            ]);

        } catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in the SongController.store',
                'error' => $e->getMessage()
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id,int $user_id)
    {
        try{
           $song = Song::findOrFail($id);
           $currentSong = public_path() . "/songs/" . $user_id. "/". $song->song;
           if(file_exists($currentSong)){ unlink($currentSong); }

           $song->delete();

           return response()->json('Song Deleted Successfully', 400);

        } catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong in the SongController.destroy',
                'error' => $e->getMessage()
            ],400);
        }
    }
}
