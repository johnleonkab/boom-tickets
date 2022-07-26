@extends('layouts.main')
@section('content')

<style>
    #hero {
  width: 100%;
  background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{asset('images/concert.jpg')}}');
  background-position: center top;
  height: 350px;
  color: white;
}


</style>
    <div id="hero" class="h-96 text-center">
        <div class="absolute top-48 text-center block w-full">
            <h1 class="font-lato font-semibold text-5xl text-white tracking-wider  ">Let's BOOM</h1>
            <h2 class=" font-medium text-3xl text-white tracking-wide  ">La mejor forma de comprar entradas.</h2>
        </div>
    </div>
    <div class="text-center py-10 bg-indigo-500 px-2">
        <h1 class="font-lato font-semibold text-3xl md:text-4xl text-white tracking-widest uppercase"> Próximos Eventos </h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10 mt-10 text-white">
        
    </div>
    <section class="">
        {{ App\Http\Controllers\User\EventsController::SoonEvents() }}

    </section>
    <style>
        
        .icon-rotate:hover span{
            transform: rotateY(360deg);
        }
    </style>
    <section id="why-us-section">
        <div class="grid grid-cols-1 md:grid-cols-2 my-10">
            <div>
                <img class="w-full h-96 object-cover" src="https://static.wixstatic.com/media/5eb6d0_b754709e587d4f71a0dd4b600bc44560~mv2.jpg/v1/fill/w_537,h_644,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/5eb6d0_b754709e587d4f71a0dd4b600bc44560~mv2.jpg" alt="">
            </div>
            <div class="bg-indigo-500 p-20 text-white text-center">
                <h2 class="text-3xl font-semibold my-5">¿Por qué BoomTickets es mejor?</h2>
                <div class="icon-rotate flex mx-auto text-2xl align-middle font-medium w-1/2 my-2">
                    <span class="material-symbols-outlined transition duration-500 text-3xl mr-5">
                        lock
                    </span>
                    Compra verificada
                </div>
                <div class="icon-rotate flex mx-auto text-2xl align-middle font-medium w-1/2 my-2">
                    <span class="material-symbols-outlined transition duration-500 text-3xl mr-5">
                        route
                    </span>
                    Vuelta segura
                </div>
                <div class="icon-rotate flex mx-auto text-2xl align-middle font-medium w-1/2 my-2">
                    <span class="material-symbols-outlined transition duration-500 text-3xl mr-5">
                        diversity_2
                        </span>
                    Tendencias de amigos
                </div>
            </div>
        </div>
    </section>

    <section class="">
        <div class="flex w-11/12 m-auto bg-indigo-500 p-10 text-white">
            <div>
                <h2 class="text-3xl font-semibold">¿Qué necesitas para ser la bomba?</h2>
                <div class="px-10 py-5 text-2xl font-semibold">
                    <span class="border-white mr-5">1.</span>
                    Crea una cuenta.
                </div>
                <div class="px-10 py-5 text-2xl font-semibold">
                    <span class="border-white mr-5">2.</span>
                    Sigue a todos tus amigos.
                </div>
                <div class="px-10 py-5 text-2xl font-semibold">
                    <span class="border-white mr-5">2.</span>
                    Compra entradas como nunca antes.
                </div>
            </div>
        </div>
    </section>

    

@endsection