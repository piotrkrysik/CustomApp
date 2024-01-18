<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Weather App</title>
</head>
<body>
    <div id="main">
        <h1>Weather App</h1>
    <form method="POST" action="/weather">
        @csrf
        <input type="text" name="city" required placeholder="Enter City">
        <button type="submit">Get Weather</button>
    </form>
    @error('city')
            <p>{{ $message }}</p>
        @enderror
    @if(isset($weatherData))
        <h2>Weather in {{ $weatherData['name'] }}, {{ $weatherData['sys']['country'] }}</h2>
        <p><img src="css/temperature.png" alt="temperature"><br> {{ round($weatherData['main']['temp']) }} &deg;C</p>
        <p><img src="{{ asset('icons/' . $weatherIcon) }}" alt="Weather Icon"> <br>{{ $weatherData['weather'][0]['description'] }}</p>
        <p><img src="css/humidity.png"> <br>{{ $weatherData['main']['humidity'] }}%</p>
        <p><img src="css/wind-speed.png"> <br>{{ round($weatherData['wind']['speed']) }} m/s</p>
    @endif
    </div>
</body>
</html>