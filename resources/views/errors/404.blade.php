@extends('layouts.main')
@section('content')
@php
    $pageTitle = 'Error 404'
@endphp
<section class="my-auto text-white align-middle flex w-11/12 md:w-3/4 mx-auto h-screen">
    <div class="my-auto text-center">
        <div class="text-center flex my-5">
            <h2 class="text-8xl ml-auto my-auto">404</h2>
            <img src="{{asset('images/logo BT sq green.png')}}" class="w-1/6  animate-bounce" alt="">
            <h2 class="text-8xl my-auto mr-auto"> Ups...</h2>
        </div>

        <h4 class="text-2xl font-light text-center underline decoration-lime-500">
            @if(isset($message) && $message != '') 
                {{$message}} 
            @else
            Esta página no ha sido encontrada, puede que sea un error nuestro. Pero que no pare la fiesta.
            Sigue navegando y encuentra la fiesta de tus sueños.
            @endif
            
        </h4>
    </div>
</section>
@endsection