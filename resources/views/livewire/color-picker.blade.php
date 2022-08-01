<label for="">Color</label>
<div class="flex mt-4">
    <label for="red" class="mx-2">
        <input name="color" @if($defaultValue == 'red') checked @endif value="red" type="radio" id="red" class="peer hidden">
        <div class="w-10 h-10 rounded-full cbg-red peer-checked:border-2 peer-checked:scale-125 transition border-white"></div>
    </label>
    <label for="blue" class="mx-2">
        <input name="color" @if($defaultValue == 'blue') checked @endif value="blue" type="radio" id="blue" class="peer hidden">
        <div class="w-10 h-10 rounded-full cbg-blue peer-checked:border-2 peer-checked:scale-125 transition border-white"></div>
    </label>
    <label for="yellow" class="mx-2">
        <input name="color" @if($defaultValue == 'yellow') checked @endif value="yellow" type="radio" id="yellow" class="peer hidden">
        <div class="w-10 h-10 rounded-full cbg-yellow peer-checked:border-2 peer-checked:scale-125 transition border-white"></div>
    </label>
    <label for="green" class="mx-2">
        <input name="color" @if($defaultValue == 'green') checked @endif value="green" type="radio" id="green" class="peer hidden">
        <div class="w-10 h-10 rounded-full cbg-green peer-checked:border-2 peer-checked:scale-125 transition border-white"></div>
    </label>
    <label for="lime" class="mx-2">
        <input name="color" @if($defaultValue == 'lime') checked @endif value="lime" type="radio" id="lime" class="peer hidden">
        <div class="w-10 h-10 rounded-full cbg-lime peer-checked:border-2 peer-checked:scale-125 transition border-white"></div>
    </label>
</div>
<div class="flex mt-4">
    <label for="violet" class="mx-2">
        <input name="color" @if($defaultValue == 'violet') checked @endif value="violet" type="radio" id="violet" class="peer hidden">
        <div class="w-10 h-10 rounded-full cbg-violet peer-checked:border-2 peer-checked:scale-125 transition border-white"></div>
    </label>
    <label for="purple" class="mx-2">
        <input name="color" @if($defaultValue == 'purple') checked @endif value="purple" type="radio" id="purple" class="peer hidden">
        <div class="w-10 h-10 rounded-full cbg-purple peer-checked:border-2 peer-checked:scale-125 transition border-white"></div>
    </label>
    <label for="orange" class="mx-2">
        <input name="color" @if($defaultValue == 'orange') checked @endif value="orange" type="radio" id="orange" class="peer hidden">
        <div class="w-10 h-10 rounded-full cbg-orange peer-checked:border-2 peer-checked:scale-125 transition border-white"></div>
    </label>
    <label for="cian" class="mx-2">
        <input name="color" @if($defaultValue == 'cian') checked @endif value="cian" type="radio" id="cian" class="peer hidden">
        <div class="w-10 h-10 rounded-full cbg-cian peer-checked:border-2 peer-checked:scale-125 transition border-white"></div>
    </label>
    <label for="aqua" class="mx-2">
        <input name="color" @if($defaultValue == 'aqua') checked @endif value="aqua" type="radio" id="aqua" class="peer hidden">
        <div class="w-10 h-10 rounded-full cbg-aqua peer-checked:border-2 peer-checked:scale-125 transition border-white"></div>
    </label>
</div>