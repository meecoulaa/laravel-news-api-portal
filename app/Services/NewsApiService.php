<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use App\Services\OptionsMapper;

class NewsApiService
{
    /**
     * Get news articles from the News API.
     *
     * @param string $endpoint The API endpoint (e.g., 'everything', 'top-headlines').
     * @param array $options Additional options for the API request.
     * @return array The JSON response from the API.
     * @throws \Exception If an error occurs during the API request.
     */
    public static function getNewsArticles($endpoint, $options = []){
        $noNullOptions = array_filter($options, function($value){
            return $value !==null;
        });

        $defaultOptions = ['apiKey' => $_ENV['NEWS_API_KEY']];

        $options = array_merge($options, $defaultOptions);

        $url = 'https://newsapi.org/v2/' . $endpoint . '?' . http_build_query($options);
        error_log($url);
        $response = Http::get($url);

        if ($response->failed()) {
            // Extract error information from the response JSON
            $errorData = $response->json();

            // Throw an exception with error details
            throw new \Exception("News API Error: {$errorData['code']} - {$errorData['message']}");
        }     
        return $response->json();            
    }
}