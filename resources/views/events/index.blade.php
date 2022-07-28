@extends('layouts.main')
@section('content')

<div class="h-32"></div>
<section id="event-header" class="text-white w-11/12 lg:w-5/6 mx-auto mb-20">
  <input type="text" id="search-box" placeholder="Busca un evento" class="focusable peer text-xl w-full lg:w-1/2 bg-transparent border-transparent border-b-2 focus:outline-none focus:ring-0 focus:border-transparent transition border-b-gray-600 focus:border-b-indigo-500">
  <div id="suggested-results-box" class="focusable bg-black bg-opacity-60 transition hidden  absolute w-11/12 lg:w-5/12 z-40 rounded " style="backdrop-filter: blur(15px);">
    
  </div>
</section>
<script>
  $('#search-box').focus(function(){
    $('#suggested-results-box').removeClass('hidden');
  })
  $('#search-box').focusout(function(){
    $(document).mouseup(function(e) 
{
    var container = $(".focusable");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        $('#suggested-results-box').addClass('hidden')
    }
});
  })
  

  var previousQuery ;
  var contador = 0;
  $('#search-box').on('keyup', function(){
    contador++;
  })
  function search(){
    if(previousQuery != $('#search-box').val() || contador == 9){
      $('#suggested-results-box').load('{{url('event/search')}}', {
        _token: '{{csrf_token()}}',
        search_query: $('#search-box').val()
      })
      contador = 0;
    }
    previousQuery = $('#search-box').val();
  }
  setInterval(search, 1200);

</script>
<section class="text-white w-11/12 md:w-5/6 mx-auto">
  <h2 class="text-3xl mt-10 font-poppins font-light  mx-auto my-5">Próximos eventos esta semana</h2>
  {{ App\Http\Controllers\User\EventsController::SoonEvents() }}
</section>

@if (!Auth::guard('web')->guest())

<section class="text-white w-11/12 md:w-5/6 mx-auto">
  <h2 class="text-3xl mt-10 font-poppins font-light  mx-auto my-5">Eventos que sigues</h2>
  {{ App\Http\Controllers\User\EventsController::FollowingEvents() }}
</section>
@endif




<section class="text-white w-11/12 md:w-5/6 mx-auto">
  <h2 class="text-3xl mt-10 font-poppins font-light  mx-auto my-5">Las entradas se están <span class="font-bebas tracking-widest highlight-red p-3">AGOTANDO</span></h2>
  {{ App\Http\Controllers\User\EventsController::SoonEvents() }}
</section>
@endsection