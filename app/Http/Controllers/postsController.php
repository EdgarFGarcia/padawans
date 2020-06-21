<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Model\Post;
use App\Model\User;
use App\Model\Comment;
use Hash;
use Validator;

class postsController extends Controller
{
    //
    public function getPosts(){
        // DB QUERY
        $query = DB::connection('mysql')
        ->table('posts as a')
        ->select(
            'id as id',
            'posts as posts'
        )
        ->whereNull('deleted_at')
        ->get();

        $data = [];

        foreach($query as $out){
            $data[] = [
                'postId'                => $out->id,
                'users_info'            => User::get([
                                            DB::raw("CONCAT(first_name, ' ', last_name) as name")
                                        ]),
                'get_comments'          => Comment::where('posts_id', $out->id)->get([
                                            'comments as comments'
                                        ]),
                'posts'                 => [[
                    'posts'             => $out->posts
                ]]
                
            ];
        }

        if(sizeof($data) > 0){
            return response()->json([
                'haspassed'         => true,
                'output'            => $data
            ], 200);
        }else{
            return response()->json([
                'haspassed'         => false,
                'output'            => array()
            ], 500);
        }
    }

    public function insertPosts(Request $request){

        $validation = Validator::make($request->all(), [
            'posts'     => 'required|string'
        ]);

        if($validation->fails()){
            $error = $validation->messages()->first();
            return response()->json([
                'haspassed'         => false,
                'message'           => $error
            ], 500);
        }else{
            // validation passed
            try{

                DB::beginTransaction();

                $insertPosts = Post::insert([
                    'posts'         => $request->posts,
                    'users_id'      => 1,
                    'created_at'    => DB::raw("NOW()")
                ]);

                DB::commit();

                if($insertPosts){
                    return response()->json([
                        'haspassed'     => true,
                        'message'       => "Thank you for using the system"
                    ], 200);
                }

            }catch(\Exception $e){
                DB::rollBack();
                return response()->json([
                    'haspassed'         => false,
                    'message'           => $e
                ], 500);
            }
        }
    }

    public function deletethis(Request $request){

        $query = DB::connection('mysql')
                ->table('posts')
                ->where('id', $request->id)
                ->update([
                    'deleted_at'        => DB::raw("NOW()")
                ]);
        if($query){
            return response()->json([
                'haspassed'         => true
            ], 200);
        }else{
            return response()->json([
                'haspassed'         => false
            ], 500);
        }
    }

    public function addcomment(Request $request){
        $validation = Validator::make($request[0], [
            'comment'     => 'required'
        ]);

        if($validation->fails()){
            $error = $validation->messages()->first();
            return response()->json([
                'haspassed'         => false,
                'message'           => $error
            ], 500);
        }else{
            // insert comment
            try{
                DB::beginTransaction();

                $insertRecordComment = DB::connection('mysql')
                                        ->table('comments')
                                        ->insert([
                                            'comments'      => $request[0]['comment'],
                                            'posts_id'      => $request[0]['id'],
                                            'created_at'    => DB::raw("NOW()")
                                        ]);
                DB::commit();
                if($insertRecordComment){
                    return response()->json([
                        'haspassed'     => true
                    ]);
                }
            }catch(\Exception $e){
                DB::rollBack();
                return response()->json([
                    'haspassed'         => false
                ]);
            }
        }
    }
}
