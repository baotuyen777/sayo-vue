<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script>
        window.configValues = {
            APP_URL: "{{ env('APP_URL') }}",
            API_URL: "{{ env('API_URL') }}",
            MEDIA_URL: "{{ env('MEDIA_URL') }}",
            // Add more configuration keys as needed
        };
    </script>

    @vite(['resources/scss/app.scss','resources/css/app.css','resources/js/app.js'])
</head>
<body>
<div id="app"></div>
</body>
</html>
