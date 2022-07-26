<input name="{{$name}}" placeholder="{{$placeholder}}" @if($required) required @endif @if($readonly) readonly @endif 
    type="{{$type}}" 
    value="{{$value}}" 
    {{$properties}}
    class="w-full font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black text-2xl focus:border-transparent 
                    focus:border-b-indigo-600 focus:ring-0 transition">