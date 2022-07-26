@extends('layouts.main')    
@section('content')
<style>
    .red{
        border-color:#BA274A; 
        background-color:#420816;
    }
    .green{
        border-color:#2da86b; 
        box-shadow: #2da86b 0px 0px 25px
    }
    .blue{
        border-color:#2f83b5; 
        background-color:#00304d;
    }
    .purple{
        border-color:#8d4aba; 
        box-shadow: #8d4aba 0px 0px 20px
    }
    .pink{
        border-color:#db2abb; 
        box-shadow: #db2abb 0px 0px 25px
    }
</style>
<div class="h-48"></div>
<section id="feed-section" class="text-white">
    <div class="border-4 green w-full md:w-5/6 lg:w-3/4 mx-auto flex rounded-lg my-5  transition">
        <div class="px-5 py-2 w-full">
        <h4 class="text-xl font-medium ">Terraza Alfonso ¡No te la puedes perder!</h4>
        <hr>
        <div class="mt-5">
            Amigos, alcohol, música y buen ambiente, es lo que te espera en la nueva fiesta de Terraza Alfonso este Jueves.
            Trae a tus amigos y disfruta de la noche más larga del año.
        </div>
        <div class="flex w-64 mx-auto">
            <button class="transition border-2 rounded-l border-green-600 p-2 font-medium w-1/2" style="box-shadow:green 0 0 5px">
                Apúntame ya
            </button>
            <button class="transition border-2 rounded-r border-red-600 p-2 font-medium w-1/2 " style="box-shadow:red 0 0 5px">
                Esta vez no
            </button>
        </div>
        <div class="font-medium mt-2">
            Álvaro R, Rodrigo y Lucía van a quieren ir.
        </div>
        <div class="text-right flex">
            <a href="http://google.es" class="my-2 rounded bg-indigo-500 py-2 font-medium px-3 transition ml-auto hover:bg-indigo-600 align-middle">
                <span class="material-symbols-outlined align-middle">
                    confirmation_number    
                </span>         
                Entradas
            </a>
        </div>
        </div>
    </div>
    <div class=" w-full md:w-5/6 lg:w-3/4 mx-auto flex my-5 hover:shadow-xl transition">
        <div class=" bg- border p-5 w-full rounded-lg">
        <h4 class="text-xl font-medium font-lato">¿Qué tal fue la noche en Caramelo Club?</h4>
        <div class="">
            Ayúdanos a mejorar la experiencia respondiendo una pregunta.
            <div class="mt-5">
                <span class="font-medium">1. ¿Cuánto tiempo tuviste que esperar en la cola?</span>
                <div class="flex mt-3">
                    <button class="border border-white bg-indigo-500 hover:bg-indigo-400 transition rounded-l p-2">Menos de 5 minutos</button>
                    <button class="border border-white bg-indigo-500 hover:bg-indigo-400 transition p-2">Entre 5 y 15 minutos</button>
                    <button class="border border-white bg-indigo-500 hover:bg-indigo-400 transition rounded-r p-2">Más de 15 minutos</button>
                </div>
            </div>
            <img src="https://scontent-mad1-1.cdninstagram.com/v/t51.2885-19/243399236_578966676584282_2206961527505432524_n.jpg?stp=dst-jpg_s320x320&_nc_ht=scontent-mad1-1.cdninstagram.com&_nc_cat=102&_nc_ohc=mVYg_d5NeREAX-9y7mn&edm=AOQ1c0wBAAAA&ccb=7-5&oh=00_AT90z8IN-ZkAPkklbaTBOWF3-S8hFAPIMb6DD09dGfkcVg&oe=62D8688F&_nc_sid=8fd12b" alt="">
        </div>
        </div>
    </div>
    <div class="border-4 pink w-full md:w-5/6 lg:w-3/4 mx-auto flex rounded-lg my-5  transition">
        <div class="px-5 py-2 w-full">
        <h4 class="text-xl font-medium font-lato">¿Te apetece ir a Rosso By Anthique?</h4>
        <div class="">
            Porque parece que  <b>@nieves</b> se muere de ganas de ir.
            <div class="mt-5">
                <span class="font-medium">Fiesta de fin de exámenes de Derecho y Ade</span>
                <div class="mt-3">
                    <span class="border border-white rounded p-2 font-medium mx-2 inline-flex m-2">Jueves 21 de Julio</span>
                    <span class="border border-white rounded p-2 font-medium mx-2 inline-flex m-2">Entrada normal: 20 €</span>
                    <span class="border border-white rounded p-2 font-medium mx-2 inline-flex m-2">+21</span>
                    <span class="border border-white rounded p-2 font-medium mx-2 inline-flex m-2">Entrada a las 23:00</span>
                </div>
                <div class="mt-5 flex">
                    <span class="ml-auto hover:bg-white hover:text-black transition px-3 py-2 rounded font-medium border-2 border-white algin-middle">
                        Quiero ver más
                    </span>
                    <span class="ml-5 bg-indigo-500 px-3 py-2 rounded font-medium border-2 border-white algin-middle"><span class="material-symbols-outlined align-middle mr-3">
                        sentiment_very_satisfied
                        </span>Vamos
                    </span>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection