{{$text}}
@php
    $element_id = Str::uuid();
@endphp
<div class="flex" id="survey-{{$element_id}}">
    <div class="grid grid-cols-10 w-1/2">
        <div class="col-span-10 px-3">
            <input id="default-range" type="range" value="6" min="1" max="10" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
        </div>
        <div> <img src="{{asset('svg/1F92E.svg')}}" alt=""> </div>
        <div> <img src="{{asset('svg/1F624.svg')}}" alt=""> </div>
        <div> <img src="{{asset('svg/1F614.svg')}}" alt=""> </div>
        <div> <img src="{{asset('svg/1F641.svg')}}" alt=""> </div>
        <div> <img src="{{asset('svg/1F610.svg')}}" alt=""> </div>
        <div> <img src="{{asset('svg/1F642.svg')}}" alt=""> </div>
        <div> <img src="{{asset('svg/1F600.svg')}}" alt=""> </div>
        <div> <img src="{{asset('svg/1F92A.svg')}}" alt=""> </div>
        <div> <img src="{{asset('svg/1F929.svg')}}" alt=""> </div>
        <div> <img src="{{asset('svg/1F60D.svg')}}" alt=""> </div>
    </div>
    <div class="w-1/2">
        <button onclick="submitSurvey('{{$survey_slug}}')" class="border-2 border-indigo-500 px-2 py-1 my-auto rounded font-medium hover:bg-indigo-500 transition align-middle">Enviar</button>
    </div>
</div>

<script>
</script>

