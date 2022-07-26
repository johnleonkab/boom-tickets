


  <nav id="navbar" class="fixed border-gray-200 px-2 sm:px-4 py-6 top-0 w-full left-0 shadow-xl transition z-50 bg-opacity-90">
    <div class="container flex flex-wrap justify-between items-center mx-auto">
    <a href="{{asset('/')}}" class="flex items-center">
        <img src="{{asset('images/logo BT sq.png')}}" class="mr-3 h-6 sm:h-9" alt=" Logo" />
          <span class="self-center text-xl font-semibold whitespace-nowrap text-white">BoomTickets </span>
    </a>
    <div class="flex items-center md:order-2">
        @if (Auth::guard('web')->guest())
            
        <button type="button" onclick="window.location.href='{{asset('login')}}'" class="font-medium flex mr-3 text-sm text-white rounded-full md:mr-0 " id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown" data-dropdown-placement="bottom">
            Iniciar sesión
          </button>
            
            @else
        <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown" data-dropdown-placement="bottom">
          <span class="sr-only">Open user menu</span>
          <img class="w-8 h-8 rounded-full" src="{{Auth::guard('web')->user()->profile_photo_path}}" alt="user photo">
        </button>
        <!-- Dropdown menu -->
        <div class="hidden z-50 my-4 text-base list-none rounded divide-y shadow bg-gray-700 divide-gray-600" id="dropdown">
          <div class="py-3 px-4">
            <span class="block text-sm text-white">{{Auth::guard('web')->user()->name}}</span>
            <span class="block text-sm font-medium  truncate text-gray-400">{{Auth::guard('web')->user()->email}}</span>
          </div>
          <ul class="py-1" aria-labelledby="dropdown">
            <li>
              <a href="{{asset('/')}}" class="block py-2 px-4 text-sm  hover:bg-gray-600 text-gray-200 hover:text-white transition">Perfil</a>
            </li>
            <li>
              <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-600 text-gray-200 hover:text-white transition">Ajustes</a>
            </li>
            <li>
              <a href="#" class="block py-2 px-4 text-sm hover:bg-gray-600 text-gray-200 hover:text-white transition">Mis compras</a>
            </li>
            <li>
              <form action="{{asset('/logout')}}" method="POST">
                @csrf
                <button type="submit" class="block py-2 px-4 text-sm hover:bg-gray-600 text-gray-200 hover:text-white transition w-full text-justify">Cerrar sesión</button>
              </form>
            </li>
          </ul>
        </div>
        @endif
        <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm  rounded-lg md:hidden focus:outline-none focus:ring-2  text-gray-400 hover:bg-gray-700 focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
        <svg class="hidden w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
      </button>
    </div>
    <div class="hidden justify-between items-center w-full md:flex md:w-auto md:order-1" id="mobile-menu-2">
      <ul class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium">
        <li>
          <a href="{{asset('/')}}"       class="{{ (request()->is('index/*')) ? 'md:text-white text-white' : 'text-gray-400' }} block py-2 pr-4 pl-3  bg-indigo-500 rounded md:bg-transparent  md:p-0 " aria-current="page">Inicio</a>
        </li>
        <li>
          <a href="{{asset('/events')}}" class="{{ (request()->is('event*')) ? 'md:text-white text-white' : 'text-gray-400' }} transition block py-2 pr-4 pl-3 border-b  md:border-0  md:p-0  md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700">Eventos</a>
        </li>
        <li>
          <a href="{{asset('/venues')}}" class="{{ (request()->is('venue*')) ? 'md:text-white text-white' : 'text-gray-400' }} transition block py-2 pr-4 pl-3 border-b  md:border-0  md:p-0  md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700">Clubs</a>
        </li>
        <li>
          <a href="{{asset('/feed')}}"   class="{{ (request()->is('feed/*')) ? 'md:text-white text-white' : 'text-gray-400' }} transition block py-2 pr-4 pl-3 border-b  md:border-0  md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700">Feed</a>
        </li>
        <li>
          <a href="{{asset('/settings')}}" class="transition block py-2 pr-4 pl-3 border-b  md:border-0  md:p-0 text-gray-400 md:hover:text-white hover:bg-gray-700 hover:text-white md:hover:bg-transparent border-gray-700">Ajustes</a>
        </li>

      </ul>
    </div>
    </div>
  </nav>

  <script>
    $(document).ready(function() {
  $(window).scroll(function(){
      if ($(this).scrollTop() > 10) {
         $('#navbar').addClass('bg-black');
      } else {
         $('#navbar').removeClass('bg-black');
      }
  });
});
  </script>