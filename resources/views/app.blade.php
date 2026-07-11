<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Strat</title>

    <link rel="stylesheet" href="{{ asset('vendor/strat/app.css') }}">
</head>
<body>
    <div id="app"></div>

    <script type="module" src="{{ asset('vendor/strat/app.js') }}"></script>
</body>
</html>
