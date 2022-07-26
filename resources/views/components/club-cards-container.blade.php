<h1 class="text-3xl mt-10 font-poppins font-light  mx-auto my-5">{!!$title!!}</h1>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    @foreach ($venues as $venue)
    <div class="flex border border-white group h-60">
        <div class="w-1/2" ><img class="object-scale-down transition scale-100 group-hover:scale-90" style="height: 100%" src="{{ $venue->logo_url }}" alt=""></div>
        <div class="w-1/2 text-center flex align-middle">
            <div class="my-auto text-center w-full">
                <h3 class="text-2xl mx-auto">{{$venue->name}}</h3>
                <button onclick="window.location.href='{{url('venue/'.$venue->slug)}}'" class="follow-button mx-auto bg-lime-500">Descubrir</button>
            </div>
        </div>
    </div>
    @endforeach
</div>
