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
 * Class NewsController
 * @package App\Http\Controllers
 */

class NewsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/news",
     *     summary="Get news for registered users",
     *     tags={"News"},
     *     @OA\Response(response="200", description="List of news for registered users"),
     * )
     */

    /**
     * @OA\Post(
     *     path="/news",
     *     summary="Search for news articles",
     *     tags={"News"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="category", type="string"),
     *             @OA\Property(property="country", type="string"),
     *             @OA\Property(property="sources", type="string"),
     *             @OA\Property(property="q", type="string"),
     *             @OA\Property(property="pageSize", type="integer"),
     *             @OA\Property(property="page", type="integer"),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="List of search results"),
     *     @OA\Response(response="500", description="Internal Server Error"),
     * )
     */


    public function index(Request $request){
        $user = Auth::user();
        $endPoint = 'everything';
        $favorites = (new UserFavorite())->favoritesUrlId();
        $comments = [];

        $options = [ 
            'q' => '*',
            'from' => null,
            'to' => null,
            'language' => $user->language,
            'sortBy' => null,
            'pageSize' => '10',
            'page' => 1,
        ];
        
        if(extract($request->all())) {
            $options = $request->all();
            if($options['q'] == null){
                $options['q'] = '*'; 
            }
        }
        
        $response = NewsApiService::getNewsArticles($endPoint, $options); 

        foreach($response['articles'] as $article){
            $specificComments = Comments::where('url', $article['url'])->get();
            $comments[$article['url']] = $specificComments ? $specificComments : [];
        }

        $numOfPages = $response['totalResults'] < 100 ? ceil($response['totalResults'] / $options['pageSize']) : ceil(100 / $options['pageSize']);

        $optionMapper = new OptionsMapper();

        return view('news', [ 
            'articles' => $response['articles'],
            'data' => ['languages' => $optionMapper->languages],
            'options' => $options, 
            'favorites' => $favorites,      
            'numOfPages' => $numOfPages,   
            'comments' => $comments,
        ]);
    }
}


