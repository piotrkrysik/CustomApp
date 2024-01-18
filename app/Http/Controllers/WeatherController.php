<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        return view('weather.index');
    }

    public function getWeather(Request $request)
    {
        try {
            $request->validate([
                'city' => 'required',
            ]);
    
            $city = $request->input('city');
            
        
        $apiKey = config('services.openweathermap.api_key');

        $response = Http::get("http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric");
        //dd($response->body());
        $weatherData = $response->json();

        if (isset($weatherData['message']) && $weatherData['message'] === 'city not found') {

            return redirect()->back()->withErrors(['city' => 'The specified city does not exist.']);
        }

    } catch (ValidationException $e) {
    
        return redirect()->back()->withErrors($e->errors());
    }
        $weatherIcon = $this->mapWeatherToIcon($weatherData['weather'][0]['main']);

        return view('weather.index', compact('weatherData', 'weatherIcon'));
    }
    private function mapWeatherToIcon($weather)
    {
    $weatherIcons = [
        'Clear' => 'sunny.png',
        'Clouds' => 'cloudy.png',
        'Rain' => 'rainy.png',
        'Snow'=> 'snowy.png',
        'Storm'=>'lighting.png'
    ];

    return $weatherIcons[$weather] ?? 'default.png';
    }
}
