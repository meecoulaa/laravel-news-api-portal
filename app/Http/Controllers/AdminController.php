<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Services\OptionsMapper;
use App\Models\Comments;
use App\Models\UserFavorite;
use App\Models\UserLogs;



class AdminController extends Controller
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
        return view('admin', [
            'users' => (new User())->allUsers(),
        ]);
    }

    public function getComments(Request $request){
        $user = User::find($request['id']);
        return view('admin.getComments', [
            'comments' => (new Comments())->specificUserComments($request['id']),
            'user' => $user->name,
        ]);
    }

    public function getFavorites(Request $request){
        $user = User::find($request['id']);
        return view('admin.getFavorites', [
            'favorites' => (new UserFavorite())->specificUserFavorites($request['id']),
            'user' => $user->name,
        ]);
    }

    public function getProfile(Request $request){
        $optionMapper = new OptionsMapper();
        $data = [
            'categories' => $optionMapper->categories,            
            'countries' => $optionMapper->countries,
            'languages' => $optionMapper->languages,
            'isAdmin' => $optionMapper->isAdmin,
        ];
        
        $userData = User::where('id', $request['id'])->first();

        $user = User::find($request['id']);
        return view('admin.getProfile', [
            'data' => $data,
            'user' => $userData
        ]);
    }

    public function getUserLogs(Request $request){
        return view('admin.getUserLogs', [
            'userLogs' => (new UserLogs())->allUserLogs(),
        ]);
    }
}


