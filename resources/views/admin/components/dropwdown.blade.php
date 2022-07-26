<button id="dropid-{{$idname}}" data-dropdown-toggle="dropidcontent-{{$idname}}" class="transition text-white bg-indigo-700 hover:bg-indigo-800 focus:outline-none font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center " type="button">
    {{$name}}
    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
    </svg>
</button>
<!-- Dropdown menu -->
<div id="dropidcontent-{{$idname}}" class="z-10 hidden  divide-y divide-gray-100 rounded shadow w-44 bg-gray-700">
    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropid-{{$idname}}">
        {{$options}}
    </ul>
</div>