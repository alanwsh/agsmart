<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>Images</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/a8d6e8c507.js"crossorigin="anonymous"></script>
<style>
    body{
        background:#f0f0f0;
    }
    .card-img-top {
        width: 100%;
        height: 15vw;
        object-fit: cover;
    }

    @media only screen and (max-width: 768px) {
        .card-img-top {
            height: 50vh;
        }
        p #desc{
            font-size:0.5em;
        }
    }
    .glow {
        font-size: 80px;
        color: #fff;
        text-align: start;
        -webkit-animation: glow 1s ease-in-out infinite alternate;
        -moz-animation: glow 1s ease-in-out infinite alternate;
        animation: glow 1s ease-in-out infinite alternate;
    }

@-webkit-keyframes glow {
  from {
    text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #3d85c6, 0 0 40px #3d85c6, 0 0 50px #3d85c6, 0 0 60px #3d85c6, 0 0 70px #3d85c6;
  }
  to {
    text-shadow: 0 0 20px #fff, 0 0 30px #6fa8dc, 0 0 40px #6fa8dc, 0 0 50px #6fa8dc, 0 0 60px #6fa8dc, 0 0 70px #6fa8dc, 0 0 80px #6fa8dc;
  }
}
</style>
<body>
    <div id="app">
        <popular-image></popular-image>
    </div>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>