<!DOCTYPE html>
<html x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BoomTickets: Admin - {{$pageTitle}}</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.10.3/dist/cdn.min.js"></script>
    <script src="{{asset('js/init-alpine.js')}}"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.1/dist/flowbite.min.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"
    />
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
      defer
    ></script>
    <script src="./assets/js/charts-lines.js" defer></script>
    <script src="./assets/js/charts-pie.js" defer></script>
  </head>
  <body class="h-screen w-screen fixed">
    <div
      class="flex h-screen bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen }"
    >
      <!-- Desktop sidebar -->
      <aside
        class="z-20 hidden w-64 overflow-y-auto  bg-gray-800 md:block flex-shrink-0"
      >
        <div class="py-4 text-gray-400">
          <a
            class="ml-6 h-10 text-lg font-medium text-gray-200 flex "
            href="{{url('admin/dashboard')}}"
          >
          <img class="w-10 align-top" src="{{asset('images/logo BT sq.png')}}"> BoomTickets Admin
          </a>
          <ul class="mt-6">
            <li class="relative px-6 py-3">
                {!! (request()->is('admin/event*')) ? '<span
                class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>' : '' !!}
                
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150   {{ (request()->is('admin/event*')) ? 'text-gray-100' : 'hover:text-gray-200' }}"
                href="{{url('admin/events')}}"
              >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
                <span class="ml-4">Gestión de Eventos</span>
              </a>
            </li>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
                {!! (request()->is('admin/analytic*')) ? '<span
                class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>' : '' !!}
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ (request()->is('admin/analytic*')) ? 'text-gray-100' : 'hover:text-gray-200' }}"
                    href="{{url('admin/analytics')}}"
              >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
              </svg>
                <span class="ml-4">Analíticas</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
                {!! (request()->is('admin/organization*')) ? '<span
                class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>' : '' !!}
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ (request()->is('admin/organization*')) ? 'text-gray-100' : 'hover:text-gray-200' }}"
                href="{{url('admin/organization')}}"
              >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
                <span class="ml-4">Sobre mi organización</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
                {!! (request()->is('admin/venue*')) ? '<span
                class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>' : '' !!}
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ (request()->is('admin/venue*')) ? 'text-gray-100' : 'hover:text-gray-200' }}"
                href="{{url('admin/venues')}}"
              >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
                <span class="ml-4">Mis lugares</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
                {!! (request()->is('admin/finance*')) ? '<span
                class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>' : '' !!}
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  {{ (request()->is('admin/fincance*')) ? 'text-gray-100' : 'hover:text-gray-200' }}"
                href="{{url('admin/finance')}}"
              >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
              </svg>
                <span class="ml-4">Finanzas</span>
              </a>
            </li>
          </ul>
          <div class="px-6 my-6">
            <button
              class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-indigo-600 border border-transparent rounded-lg active:bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:shadow-outline-indigo"
            >
              Nuevo evento
              <span class="ml-2" aria-hidden="true">+</span>
            </button>
          </div>
        </div>
      </aside>
      <!-- Mobile sidebar -->
      <!-- Backdrop -->
      <div
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
      ></div>
      <aside
        class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto  bg-gray-800 md:hidden"
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0 transform -translate-x-20"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 transform -translate-x-20"
        @click.away="closeSideMenu"
        @keydown.escape="closeSideMenu"
      >
        <div class="py-4  text-gray-400">
          <a
            class="ml-6 text-lg font-medium text-gray-200 flex"
            href="#"
          >
            <img class="w-12 h-12" src="{{asset('images/logo BT sq.png')}}"><span class="my-auto">BoomTickets Admin</span>
          </a>
          <ul class="mt-6">
            <li class="relative px-6 py-3">
                {!! (request()->is('admin/event*')) ? '<span
                class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>' : '' !!}
                
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150   {{ (request()->is('admin/event*')) ? 'text-gray-100' : 'hover:text-gray-200' }}"
                href="{{url('admin/events')}}"
              >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
                <span class="ml-4">Gestión de Eventos</span>
              </a>
            </li>
          </ul>
          <ul>
            <li class="relative px-6 py-3">
                {!! (request()->is('admin/analytic*')) ? '<span
                class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>' : '' !!}
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ (request()->is('admin/analytic*')) ? 'text-gray-100' : 'hover:text-gray-200' }}"
                    href="{{url('admin/analytics')}}"
              >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
              </svg>
                <span class="ml-4">Analíticas</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
                {!! (request()->is('admin/organization*')) ? '<span
                class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>' : '' !!}
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ (request()->is('admin/organization*')) ? 'text-gray-100' : 'hover:text-gray-200' }}"
                href="{{url('admin/organization')}}"
              >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
                <span class="ml-4">Sobre mi organización</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
                {!! (request()->is('admin/venue*')) ? '<span
                class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>' : '' !!}
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ (request()->is('admin/venue*')) ? 'text-gray-100' : 'hover:text-gray-200' }}"
                href="{{url('admin/venues')}}"
              >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
                <span class="ml-4">Mis lugares</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
                {!! (request()->is('admin/finance*')) ? '<span
                class="absolute inset-y-0 left-0 w-1 bg-indigo-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              ></span>' : '' !!}
              <a
                class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  {{ (request()->is('admin/fincance*')) ? 'text-gray-100' : 'hover:text-gray-200' }}"
                href="{{url('admin/finance')}}"
              >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
              </svg>
                <span class="ml-4">Finanzas</span>
              </a>
            </li>
          </ul>
          <div class="px-6 my-6">
            <button
              class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-indigo-600 border border-transparent rounded-lg active:bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:shadow-outline-indigo"
            >
              Nuevo evento
              <span class="ml-2" aria-hidden="true">+</span>
            </button>
          </div>
        </div>
      </aside>
      <div class="flex flex-col flex-1 w-full">
        <header class="py-4 shadow-md bg-gray-800 z-20">
          <div
            class="container flex items-center justify-between h-full px-6 mx-auto text-indigo-300"
          >
            <!-- Mobile hamburger -->
            <button
              class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-indigo"
              @click="toggleSideMenu"
              aria-label="Menu"
            >
              <svg
                class="w-6 h-6"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </button>
            <!-- Search input -->
            <div class="flex justify-center flex-1 lg:mr-32">
              <div
                class="relative w-full max-w-xl mr-6 focus-within:text-indigo-500"
              >
                <div class="absolute inset-y-0 flex items-center pl-2">
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <input
                  class="w-full pl-8 pr-2 text-sm    border-0 rounded-md placeholder-gray-500 focus:shadow-outline-gray focus: bg-gray-700 text-gray-200 focus:placeholder-gray-500 focus:focus:border-indigo-300 focus:outline-none focus:shadow-outline-indigo form-input"
                  type="text"
                  placeholder="Search for projects"
                  aria-label="Search"
                />
              </div>
            </div>
            <ul class="flex items-center flex-shrink-0 space-x-6">
              <!-- Profile menu -->
              <li class="relative">
                <a
                href="{{url('admin/logout')}}"
                  class="align-middle rounded-full focus:shadow-outline-indigo focus:outline-none"
                  @click="toggleProfileMenu"
                  @keydown.escape="closeProfileMenu"
                  aria-label="Account"
                  aria-haspopup="true"
                >
                  Salir
              </a>
              </li>
            </ul>
          </div>
        </header>
        <main class="h-full overflow-y-auto">
          @if(\Session::get('error'))
            <livewire:error-alert :error="Session::get('error')">
            {{Session::forget('error')}}
          @endif 
          @if(\Session::get('success'))
            <livewire:success-alert :success="Session::get('success')">
            {{Session::forget('success')}}
          @endif
          <div id="overlay" class="fixed h-screen w-screen top-0 flex left-0 bg-gray-900 z-10 text-center">
            <svg class="inline w-16 h-16 mx-auto my-auto text-gray-600 animate-spin fill-lime-400" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
          </div>
          @yield('content')
        </main>
      </div>
    </div>
    <script>
      $(window).on('load', function () {
         $('#overlay').addClass('hidden');
      });
    </script>
    <script src="https://unpkg.com/flowbite@1.5.1/dist/flowbite.js"></script>
  </body>
</html>
