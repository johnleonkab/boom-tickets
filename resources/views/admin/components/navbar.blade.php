<nav class="fixed border-gray-200 px-2 sm:px-4 py-4 bg-black top-0 w-full left-0 z-50" style="z-index: 99999">
    <div class="container flex flex-wrap justify-between items-center mx-auto ">
      <a href="{{url('admin/')}}" class="flex items-center">
          <img src="{{asset('images/logo BT sq.png')}}" class="mr-3 h-6 sm:h-9" alt=" Logo" />
          <span class="self-center text-xl font-semibold whitespace-nowrap text-white">BoomTickets <span class="font-light">Admin</span></span>
      </a>
      <button data-collapse-toggle="mobile-menu" type="button" class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
        <svg class="hidden w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
      </button>
      <div class="hidden w-full md:block md:w-auto" id="mobile-menu">
        <ul class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium">
            @if (Auth::guard('admin')->guest())
            <li>
                <a href="{{url('admin/login')}}" class="block py-2 pr-4 pl-3  border-b   md:border-0 transition md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700">
                    Iniciar Sesión
                </a>
            </li>
            @else
            <li>
                <a href="{{url('admin/dashboard')}}" class="block py-2 pr-4 pl-3  border-b   md:border-0 transition md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{url('admin/events')}}" class="block py-2 pr-4 pl-3  border-b   md:border-0 transition md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700">
                    Eventos
                </a>
            </li>
            <li>
                <a href="{{url('admin/analytics')}}" class="block py-2 pr-4 pl-3  border-b   md:border-0 transition md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700">
                    Analíticas
                </a>
            </li>
            <li>
                <a href="{{url('admin/organization')}}" class="block py-2 pr-4 pl-3  border-b   md:border-0 transition md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700">
                    Mi Organización
                </a>
            </li>
            <li>
                <a href="{{url('admin/payments')}}" class="block py-2 pr-4 pl-3  border-b   md:border-0 transition md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700">
                    Balance y pagos
                </a>
            </li>
            <li>
                <a href="{{url('admin/logout')}}" class="block py-2 pr-4 pl-3  border-b   md:border-0 transition md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700">
                    Cerrar Sesión
                </a>
            </li>
            @endif

        </ul>
      </div>
    </div>
  </nav>