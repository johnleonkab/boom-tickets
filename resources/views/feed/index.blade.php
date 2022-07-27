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
<script>
    numberOfNotifications = 0;
    $(document).ready(function(){
        $.post('{{url('notifications/show')}}', {
        _token: '{{csrf_token()}}',
        limit: numberOfNotifications
    }, function(html){
          $("#notifications-container").append(html); //<---append the html here.
      }, "html");
    })
$(window).scroll(function() {
    
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
    numberOfNotifications = numberOfNotifications+5
    $.post('{{url('notifications/show')}}', {
        _token: '{{csrf_token()}}',
        limit: numberOfNotifications
    }, function(html){
          $("#notifications-container").append(html); //<---append the html here.
      }, "html");

       
   }
});


</script>
<div class="h-48"></div>
<section id="feed-section" class="text-white">
    <div class="w-full md:w-5/6 lg:w-2/3 bg-gray-800 mx-auto rounded-xl p-3">
    <h1 class="text-3xl font-roboto font-medium m-2">Mi feed</h1>
    <input type="text" id="feed-search" placeholder="Búsqueda" class="bg-gray-800 rounded-xl w-full focus:ring-0 my-2 transition focus:bg-gray-900 font-roboto focus:border-indigo-500">    
    
    <div id="notifications-container" role="list">
        <div role="status" id="search-spinner" class="mx-auto text-center hidden">
            <svg class="inline mr-2 w-14 h-14 animate-spin text-gray-600 fill-lime-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
        </div>
        <livewire:spinner>
    </div>

</section>
<script>
        var previousQuery ;
    var contador = 0;
    $('#feed-search').on('keyup', function(){
      contador++;
      $('#search-spinner').removeClass('hidden');
    })
    function search(){
      if(previousQuery != $('#feed-search').val() || contador == 9){
        $('#notifications-container').load('{{url('feed/search')}}', {
          _token: '{{csrf_token()}}',
          search_query: $('#feed-search').val()
        })
        contador = 0;
      }
      previousQuery = $('#feed-search').val();
    }
    setInterval(search, 1200);
</script>
@endsection