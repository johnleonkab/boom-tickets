<link href="https://cdn.jsdelivr.net/npm/daisyui@2.20.0/dist/full.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.tailwindcss.com"></script>
@php $str = Str::uuid(); @endphp
@if (!Auth::guard('web')->guest())
  <div class="modal" id="share-event-button">
    <div class="modal-box text-white !bg-gray-800" style="">
      <div class="text-right">
        <a href="#!">
          <span class="material-symbols-outlined">close </span>
        </a>
      </div>
      <h3 class="text-lg font-bold">
        <span class="material-symbols-outlined align-middle mr-3">send</span>
        Compartir
      </h3>
      <p class="py-4">Elige compartir como quieras.</p>
      <input type="hidden" name="target_type" value="">
      <input type="hidden" name="target_slug" value="ev_fiesta_de_ano_nu_3bf703e1">
      <livewire:autocomplete>
      <button id="share-button-{{$str}}" type="submit">Compartir</button>
    </div>
  </div>
  <script>
    function loadModalWithData(target_type, target_slug){
      
      $('input[name=target_type]').val(target_type)
      $('input[name=target_slug]').val(target_slug)
      window.location.href="#share-event-button"
    }
    
    $('#share-button-{{$str}}').click(function(){
      $.ajax({
        type: "POST",
        url: '{{url('notifications/share')}}',
        data: {
            _token: '{{csrf_token()}}',
            target_type: $('input[name=target_type]').val(),
            target_slug: $('input[name=target_slug]').val(),
            users_list_tags: $('#users-list-tags').val()
        },
        success: success
      })
    })
  
    function success(data){
        window.location.href='#!'
        if(data.success){
        ShowToast(data.message)
        }
    }
  </script>
@endif 