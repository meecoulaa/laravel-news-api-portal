<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFavorite;
use App\Models\UserLogs;

/**
 * Class UserFavoritesController
 * @package App\Http\Controllers
 */

class UserFavoritesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/favorites",
     *     summary="Get user favorites",
     *     tags={"Favorites"},
     *     security={{"BearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of user favorites",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="url", type="string"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="urlToImage", type="string"),
     *                 @OA\Property(property="publishedAt", type="string"),
     *                 @OA\Property(property="author", type="string"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */

    public function index(){
        $userFavorites = (new UserFavorite())->allFavorites();

        return view('favorites', [
            'favorites' => $userFavorites,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/favorites",
     *     summary="Add an article to favorites",
     *     tags={"Favorites"},
     *     security={{"BearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"url", "title", "description", "urlToImage", "publishedAt", "author"},
     *             @OA\Property(property="url", type="string"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="urlToImage", type="string"),
     *             @OA\Property(property="publishedAt", type="string"),
     *             @OA\Property(property="author", type="string"),
     *         ),
     *     ),
     *     @OA\Response(response=201, description="Article added successfully"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=422, description="Validation error"),
     * )
     */
    public function store(Request $request){
        $user = Auth::user();

        $request->validate([
            'url' => ['required', 'string'],
            'title' => ['required', 'string'],
            'urlToImage' => ['string'],
            'publishedAt' => ['string'],
        ]);

        $favorites = UserFavorite::create([
            'user_id' => $user->id,
            'url' => $request->input('url'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'urlToImage' => $request->input('urlToImage'),
            'publishedAt' => $request->input('publishedAt'),
            'author' => $request->input('author'),
        ]);

        $log['action']='create';
        $log['description']=$request->input('title') .' - article favourited';
        $log['user_id']=auth()->user()->id;
        UserLogs::create($log);

        return redirect()->back()->with('success', 'Article saved successfully to favorites.');
    }
    
    /**
     * @OA\Delete(
     *     path="/favorites/{id}",
     *     summary="Remove an article from favorites",
     *     tags={"Favorites"},
     *     security={{"BearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the article to delete",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=204, description="Article deleted successfully"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Article not found"),
     * )
     */
    public function destroy($favorite_id){
        $log['action']='delete';
        $log['description']=UserFavorite::where('id' , $favorite_id)->first()->title. ' - favorite article deleted';
        $log['user_id']=auth()->user()->id;
        UserLogs::create($log);

        return UserFavorite::destroy($favorite_id) === 0 ? redirect()->back()->with('failed', 'Favorite not found.') 
            : redirect()->back()->with('success', 'Favorite successfully deleted!');

        

    }
}
