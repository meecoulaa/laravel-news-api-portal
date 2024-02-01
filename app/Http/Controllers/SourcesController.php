<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\ApiController;
use App\Services\NewsApiService;
use App\Services\OptionsMapper;

/**
 * Class SourcesController
 * @package App\Http\Controllers
 */

class SourcesController extends Controller
{

    /**
     * @OA\Get(
     *     path="/sources",
     *     summary="Get news sources",
     *     tags={"News"},
     *     @OA\Parameter(
     *         name="language",
     *         in="query",
     *         description="Selected language for news sources",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         name="country",
     *         in="query",
     *         description="Selected country for news sources",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Selected category for news sources",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response="200", description="List of news sources"),
     * )
     */

    public function index(Request $request){
        $user = Auth::user();
        $endPoint = 'sources';

        //Default options
        $options = [ 
            'language' => $user->language,
            'country' => $user->country,
            'category' => $user->category,
        ];
        if(extract($request->all())) {
            $options = $request->all();
        }
        $response = NewsApiService::getNewsArticles($endPoint, $options);   
        //Getting all select options from options mapper
        $optionMapper = new OptionsMapper();
        $data = [
            'languages' => $optionMapper->languages,
            'countries' => $optionMapper->countries,
            'categories' => $optionMapper->categories,
        ];
        // Return articles data and pass the rest of data to view
        return view('sources', [ 
            'sources' => $response['sources'],
            'data' => $data,
            'options' => $options,          
        ]);
    }
}


