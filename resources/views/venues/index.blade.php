@extends('layouts.main')
@section('content')
<section class="text-white mt-20 w-11/12 lg:w-5/6 mx-auto">
    <h1 class="text-4xl mt-10 font-poppins font-light  mx-auto my-5">Discotecas y clubes</h1>
</section>
<section id="event-header" class="text-white w-11/12 lg:w-5/6 mx-auto mb-20">
    <input type="text" id="search-box" placeholder="Busca una discoteca" class="focusable peer text-xl w-full lg:w-1/2 bg-transparent border-transparent border-b-2 focus:outline-none focus:ring-0 focus:border-transparent transition border-b-gray-600 focus:border-b-indigo-500">
    <div id="suggested-results-box" class="focusable  transition hidden  absolute w-11/12 lg:w-5/12 z-40 rounded " style="backdrop-filter: blur(15px);">
  
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
      $('#search-spinner').removeClass('invisible');
    })
    function search(){
      if(previousQuery != $('#search-box').val() || contador == 9){
        $('#suggested-results-box').load('{{url('venue/search')}}', {
          _token: '{{csrf_token()}}',
          search_query: $('#search-box').val()
        })
        contador = 0;
      }
      previousQuery = $('#search-box').val();
    }
    setInterval(search, 1200);
  
  </script>

<section id="location-based" class="text-white my-20 w-11/12 lg:w-5/6 mx-auto">
    <h1 class="text-3xl mt-10 font-poppins font-light  mx-auto my-5">Discotecas que lo están <span class="font-bebas tracking  highlight-lime p-3">petando</span> cerca de tí</h1>
    <livewire:spinner>
</section>

@if (!Auth::guard('web')->guest())
<section id="following-based" class="text-white my-20 w-11/12 lg:w-5/6 mx-auto">
  {{ App\Http\Controllers\User\VenueController::FollowBased() }}
</section>
@endif


<script>
    
    var options = {
  enableHighAccuracy: true,
  timeout: 5000,
  maximumAge: 0
};

function success(pos) {
  var crd = pos.coords;

  console.log('Your current position is:');
  console.log('Latitude : ' + crd.latitude);
  console.log('Longitude: ' + crd.longitude);
  console.log('More or less ' + crd.accuracy + ' meters.');
  $('#location-based').load("http://127.0.0.1:8000/venue/location?title=Discotecas+que+lo+están+<span+class='font-bebas+tracking+highlight-lime+p-3'>petando</span>+cerca+de+tí&lon="+crd.longitude+"&lat="+crd.latitude)
};

function error(err) {
  console.warn('ERROR(' + err.code + '): ' + err.message);

};

navigator.geolocation.getCurrentPosition(success, error, options);


</script>
@endsection