<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>BoomTickets 
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
<link
rel="stylesheet"
href="https://unpkg.com/swiper/swiper-bundle.min.css"
/>

 <!-- Swiper JS -->
 <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
@vite('resources/css/app.css')
</head>

<body class="" style="background-color:black">

    @component('components.navbar')  
    @endcomponent
    @if(\Session::get('error'))
        <livewire:error-alert :error="Session::get('error')">
        {{Session::forget('error')}}
    @endif 
    @if(\Session::get('success'))
        <livewire:success-alert :success="Session::get('success')">
        {{Session::forget('success')}}
    @endif 
    <div id="dynamically-loaded-toast">

    </div>
<div class="">
    @yield('content')
</div>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
    <script>
        function ShowToast(message){
        $('#dynamically-loaded-toast').load('{{url('ShowDynamicToast')}}', {
                _token: '{{csrf_token()}}',
                message: message
            })
    }
    </script>
</body>
</html>