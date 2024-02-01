<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comments;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Models\UserLogs;

class CommentsController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/comments",
     *      operationId="getComments",
     *      tags={"Comments"},
     *      summary="Get list of comments",
     *      description="Returns list of comments",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Comment")
     *      ),
     * )
     */

    public function index(Request $request){
        return view('comments', [
            'comments' => (new Comments())->allComments(),
        ]);
    }

    /**
     * @OA\Post(
     *      path="/api/comments",
     *      operationId="storeComment",
     *      tags={"Comments"},
     *      summary="Store a new comment",
     *      description="Stores a new comment",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="comment", type="string"),
     *              @OA\Property(property="url", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Comment stored successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Comment")
     *      ),
     * )
     */

    public function store(Request $request){
        $user = Auth::user();

        $request->validate([
            'comment' => ['required', 'string'],
            'url' => ['required', 'string'],
        ]);
    
        $comments = Comments::create([
            'user_id' => $user->id,
            'url' => $request->input('url'),
            'comment' => $request->input('comment'),
        ]);

        $log['action']='create';
        $log['description']=$request->input('comment') .' - article commented';
        $log['user_id']=auth()->user()->id;
        UserLogs::create($log);

        return redirect()->back()->with('success', 'Comment saved successfully.');
    }

    /**
     * @OA\Patch(
     *      path="/api/comments/{comment_id}",
     *      operationId="updateComment",
     *      tags={"Comments"},
     *      summary="Update a comment",
     *      description="Update a comment by ID",
     *      @OA\Parameter(
     *          name="comment_id",
     *          in="path",
     *          required=true,
     *          description="ID of the comment to be updated",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="comment", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Comment updated successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Comment")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Comment not found",
     *      ),
     * )
     */

    public function update($comment_id, Request $request): RedirectResponse
    {
        $request->validate([
            'comment' => ['required', 'string'],
        ]);

        $comment = Comments::find($comment_id);

        if(!$comment){
            return redirect()->back()->with('failed', 'Comment not found.');
        }

        $log['action']='update';
        $log['description']='Updated comment "'.$comment['comment']. '" to "'. $request['comment']. '"';
        $log['user_id']=auth()->user()->id;
        UserLogs::create($log);

        $comment->update(['comment' => $request['comment']]);

        return redirect()->back()->with('success', 'Comment updated.');
    }

    /**
     * @OA\Delete(
     *      path="/api/comments/{comment_id}",
     *      operationId="deleteComment",
     *      tags={"Comments"},
     *      summary="Delete a comment",
     *      description="Delete a comment by ID",
     *      @OA\Parameter(
     *          name="comment_id",
     *          in="path",
     *          required=true,
     *          description="ID of the comment to be deleted",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Comment deleted successfully",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Comment not found",
     *      ),
     * )
     */

    public function destroy($comment_id){
        $log['action']='delete';
        $log['description']=Comments::where('id' , $comment_id)->first()->comment. ' - comment deleted';
        $log['user_id']=auth()->user()->id;
        UserLogs::create($log);

        return Comments::destroy($comment_id) === 0 ? redirect()->back()->with('failed', 'Comment not found.') 
            : redirect()->back()->with('success', 'Comment successfully deleted!');
    }
}
