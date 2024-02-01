<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\ApiController;
use App\Services\NewsApiService;
use App\Services\OptionsMapper;
use App\Models\UserFavorite;
use App\Models\Comments;

/**
 * Class TopHeadlinesController
 * @package App\Http\Controllers
 */

 /**
 * @OA\Info(
 *     title="News API",
 *     version="1.0.0",
 *     description="API endpoints for fetching news articles.",
 *     )
 * )
 */
class TopHeadlinesController extends Controller
{

    /**
     * @OA\Get(
     *     path="/",
     *     summary="Get top headlines for the welcome page",
     *     tags={"News"},
     *     @OA\Response(response="200", description="List of top headlines for the welcome page"),
     * )
     */
    public function welcome(){

        $endPoint = 'top-headlines';
        $options = [ 
            'category' => 'general',
            'country' => 'us',
        ];
        $response = NewsApiService::getNewsArticles($endPoint, $options);
        return view('welcome', ['articles' => $response['articles']]);
    } 
    
     /**
     * @OA\Get(
     *     path="/topHeadlines",
     *     summary="Get top headlines with optional filters",
     *     tags={"News"},
     *     @OA\Parameter(
     *         name="country",
     *         in="query",
     *         description="Selected country",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Selected category",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         name="sources",
     *         in="query",
     *         description="Selected sources",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Search query",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         name="pageSize",
     *         in="query",
     *         description="Number of results per page",
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(response="200", description="List of top headlines with optional filters"),
     * )
     */
    public function index(Request $request){
        $user = Auth::user();
        $endPoint = 'top-headlines';
        //Query for favorite articles where url => id
        $userFavorites = new UserFavorite();
        $favorites = $userFavorites->favoritesUrlId();
        
        //Remember that you dont need user_id in this because you are displaying all comments not only users. But for editing you will need to check the user_id
        $comments = [];

        //Default options
        $options = [ 
            'country' => $user->country,
            'category' => $user->category,
            'sources' => null,
            'q' => null,
            'pageSize' => '10',
            'page' => '1',
        ];
        //If the form has been submited
        if(extract($request->all())) {
            $options = $request->all();
            // Setting country and category parameters to null if sources is set, since they cannot be mixed with each other
            if(!empty($options['sources'])){
                $options['category'] = null;
                $options['country'] = null;
            }
            
            $nullValues=0;
            foreach($options as $option){
                if($option == null){
                    $nullValues+=1;
                }
            }
            //Checking to see if only perPage and Page is set, if they are then set values to default
            if($nullValues == 4){
                $options = [ 
                    'country' => $user->country,
                    'category' => $user->category,
                    'sources' => null,
                    'q' => null,
                    'pageSize' => $options['pageSize'],
                    'page' => $options['page'],
                ];
            }
        }
        $response = NewsApiService::getNewsArticles($endPoint, $options);
        foreach($response['articles'] as $article){
            $specificComments = Comments::where('url', $article['url'])->get();
            $comments[$article['url']] = $specificComments ? $specificComments : [];
        }

        $numOfPages = $response['totalResults'] < 100 ? ceil($response['totalResults'] / $options['pageSize']) : ceil(100 / $options['pageSize']);
        $optionMapper = new OptionsMapper();
        $data = [
            'categories' => $optionMapper->categories,            
            'countries' => $optionMapper->countries,
        ];


        // Return articles data and pass the rest of data to view
        return view('topHeadlines', [ 
            'articles' => $response['articles'],
            'data' => $data,
            'options' => $options,
            'favorites' => $favorites,
            'numOfPages' => $numOfPages,
            'comments' => $comments,
        ]);
    }
}


