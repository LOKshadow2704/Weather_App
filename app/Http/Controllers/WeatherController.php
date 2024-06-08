<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;


class WeatherController extends Controller
{
    private $apiKey;
    private $client;
    private $translator ;
    public function __construct() {
        $this->apiKey = env('OPENWEATHERMAP_API_KEY'); 
        $this->client = new Client();
        $this->translator = new GoogleTranslate(); 
        $this->translator->setSource('en'); // Thiết lập ngôn ngữ nguồn là tiếng Anh
        $this->translator->setTarget('vi');
    }

    public function getWeather(Request $request){
        $latitude = $request->input('lat', '10.762622');
        $longitude = $request->input('lon', '106.660172');

        try{
            $response = $this->client->get("https://api.openweathermap.org/data/2.5/weather", [
                'query' => [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'appid' => $this->apiKey,
                    'units' => 'metric', // Đơn vị nhiệt độ là độ C
                    'lang' => 'vi'
                ]
            ]);
            $weather = json_decode($response->getBody(), true);
            $weather['weather'][0]['main'] = $this->translator->translate($weather['weather'][0]['main'] );
            $weather['weather'][0]['description'] = $this->translator->translate($weather['weather'][0]['description']);
            $provinces = $this->getProvinces();
            return view("index", compact('weather', 'provinces'));
        }catch (\Exception $e) {
            return response()->json(['error' => 'Unable to retrieve weather data'], 500);
        }
    }

    public function getProvinces() {
        try {
            $response = $this->client->get("https://esgoo.net/api-tinhthanh/1/0.htm");
            $provinces = json_decode($response->getBody(), true)['data'];
            return $provinces;
        } catch (\Exception $e) {
            return false;
        }
    }
}
