<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;


class OptionsMapper
{

    // Array mapping country names to country codes
    public $countries;

    // Array mapping language names to language codes
    public $languages;

    // Array mapping language names to language codes
    public $categories;

    // Constructor to initialize country and language code arrays
    public function __construct() {
        // Mapping of country names to country codes
        $this->countries = [
            '' => '',
            'Argentina' => 'ar',
            'Australia' => 'au',
            'Austria' => 'at',
            'Belgium' => 'be',
            'Brazil' => 'br',
            'Bulgaria' => 'bg',
            'Canada' => 'ca',
            'China' => 'cn',
            'Colombia' => 'co',
            'Cuba' => 'cu',
            'Czech Republic' => 'cz',
            'Egypt' => 'eg',
            'France' => 'fr',
            'Germany' => 'de',
            'Greece' => 'gr',
            'Hong Kong' => 'hk',
            'Hungary' => 'hu',
            'Indonesia' => 'id',
            'Ireland' => 'ie',
            'Israel' => 'il',
            'India' => 'in',
            'Italy' => 'it',
            'Japan' => 'jp',
            'Latvia' => 'lv',
            'Lithuania' => 'lt',
            'Malaysia' => 'my',
            'Mexico' => 'mx',
            'Morocco' => 'ma',
            'Netherlands' => 'nl',
            'New Zealand' => 'nz',
            'Nigeria' => 'ng',
            'Norway' => 'no',
            'Philippines' => 'ph',
            'Poland' => 'pl',
            'Portugal' => 'pt',
            'Romania' => 'ro',
            'Serbia' => 'rs',
            'Singapore' => 'sg',
            'Slovakia' => 'sk',
            'Slovenia' => 'si',
            'South Africa' => 'za',
            'South Korea' => 'kr',
            'Spain' => 'es',
            'Sweden' => 'se',
            'Switzerland' => 'ch',
            'Taiwan' => 'tw',
            'Thailand' => 'th',
            'Turkey' => 'tr',
            'Ukraine' => 'ua',
            'United Arab Emirates' => 'ae',
            'United Kingdom' => 'gb',
            'United States' => 'us',
            'Venezuela' => 've',
        ]; 

        $this->languages= [
            '' => '',
            'Arabic' => 'ar',
            'German' => 'de',
            'English' => 'en',
            'Spanish' => 'es',
            'French' => 'fr',
            'Hebrew' => 'he',
            'Italian' => 'it',
            'Dutch' => 'nl',
            'Norwegian' => 'no',
            'Portuguese' => 'pt',
            'Russian' => 'ru',
            'Swedish' => 'sv',
            'Chinese' => 'zh'
        ];

        $this->categories = [
            "" => "",
            "General" => "general",
            "Business" => "business",
            "Entertainment" => "entertainment",
            "Health" => "health",
            "Science" => "science",
            "Sports" => "sports",
            "Technology" => "technology"
        ];

        $this->isAdmin = [
            "True" => "true",
            "False" => "false",
        ];
    }
}