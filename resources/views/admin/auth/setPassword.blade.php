<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Laravel 8 Admin Auth - laravelcode.com</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.7/dist/flowbite.min.css" />

@vite('resources/css/app.css')
</head>


<body class="" style="background-color:#262626">

@component('admin.components.navbar')  
@endcomponent


    <div class="bg-black w-full md:w-1/2 xl:w-1/4 mx-auto border mt-40 p-2 py-8 text-white shadow-2xl">
        <div>
            <img src="{{asset('images/logo BT sq.png')}}" class="w-1/4 mx-auto" alt="">
        </div>
        <div class="font-light text-center text-2xl font-lato">Establecer una contraseña</div>
        @if(\Session::get('success'))
        <div id="alert-3" class="flex p-4 mb-4 bg-green-100 rounded-lg dark:bg-green-200" role="alert">
            <div class="ml-3 text-sm font-medium text-green-700 dark:text-green-800">
                {{ \Session::get('success') }}
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-green-200 dark:text-green-600 dark:hover:bg-green-300" data-dismiss-target="#alert-3" aria-label="Close">
              <span class="sr-only">Close</span>
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
          </div>

        @endif
        {{ \Session::forget('success') }}
        @if(\Session::get('error'))

        <div id="alert-2" class="flex p-4 mb-4 bg-red-100 rounded-lg dark:bg-red-200" role="alert">
            <div class="ml-3 text-sm font-medium text-red-700 dark:text-red-800">
                {{ \Session::get('error') }}
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-200 dark:text-red-600 dark:hover:bg-red-300" data-dismiss-target="#alert-2" aria-label="Close">
              <span class="sr-only">Close</span>
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
          </div>

        @endif 
            <form action="{{ url('admin/setpassword') }}" method="post" autocomplete="off" class="text-center">
                @csrf
            <div >
                <input type="text" name="username" placeholder="usuario" required="required" autocomplete="off" 
                class="input">
                @if ($errors->has('email'))
                <span class="help-block font-red-mint">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <div >
                <input type="text" name="token" placeholder="Token de un solo uso" required="required" autocomplete="off" 
                class="input">
            </div>

            <div class="mt-2">
                <input type="password"  name="password" placeholder="Nueva contraseña" required="required"
            class="input">
            @if ($errors->has('password'))
            <span class="help-block font-red-mint">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
            </div>
            <div class="mt-2">
                <input type="password"  name="confirm_password" placeholder="Confirmar contraseña" required="required"
            class="input">
            </div>
            <button class="bg-indigo-600 py-2 px-3 font-lato font-semibold mb-3 mt-4 focus:bg-indigo-700 transition focus:outline-none">
                Iniciar sesión
            </button>
            </form>
    </div>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>

</body>
</html>