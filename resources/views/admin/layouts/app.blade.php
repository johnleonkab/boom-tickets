<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>BoomTickets Admin 
    @if($pageTitle)
    - {{$pageTitle}}
    @endif
</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.7/dist/flowbite.min.css" />
<link rel="icon" type="image/x-icon" href="{{asset('images/logo BT sq.png')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>

@vite('resources/css/app.css')
</head>

<body class="bg-black">

    @component('admin.components.navbar')  
    @endcomponent
    @if(\Session::get('error'))
        <livewire:error-alert :error="Session::get('error')">
        {{Session::forget('error')}}
    @endif 
    @if(\Session::get('success'))
        <livewire:success-alert :success="Session::get('success')">
        {{Session::forget('success')}}
    @endif 
<div class="mt-32">
    @yield('content')
</div>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>
</html>