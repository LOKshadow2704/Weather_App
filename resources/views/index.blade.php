<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>Weather App</title>
</head>
<body>
    <video id="background-video" autoplay loop muted>
        <source src="video/video_background.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="container">
        <h1>Weather App</h1>
        <form method="GET" action="{{ url('/') }}" class="province">
            <label for="province">Chọn tỉnh:</label>
            <select id="province" name="province" onchange="updateCoordinates(this)">
                <option value="" disabled selected>Chọn tỉnh</option>
                @foreach($provinces as $province)
                    <option value="{{ $province['latitude'] }},{{ $province['longitude'] }}">{{ $province['name'] }}</option>
                @endforeach
            </select>
            <input type="hidden" id="lat" name="lat">
            <input type="hidden" id="lon" name="lon">
            <button type="submit">Xem thời tiết</button>
        </form>
        <div class="weather">
            @if(isset($weather))
                <h2>{{ $weather['name'] }}</h2>
                <p>Trạng thái: {{ $weather['weather'][0]['main'] }}</p>
                <p>Mô tả: {{ $weather['weather'][0]['description'] }}</p>
                <p>Nhiệt độ: {{ $weather['main']['temp'] }} &deg;C</p>
            @endif
            <script>
                function updateCoordinates(select) {
                    var coordinates = select.value.split(',');
                    document.getElementById('lat').value = coordinates[0];
                    document.getElementById('lon').value = coordinates[1];
                }
            </script>
        </div>
        
    </div>
    
</body>
</html>
