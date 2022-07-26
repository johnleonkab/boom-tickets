@extends('admin.layouts.app')
@slot('pageTitle', $pageTitle)
@section('content')
<script src="https://unpkg.com/flowbite@1.4.7/dist/datepicker.js"></script>

<style>
    .red:hover{
        border-color:#BA274A; 
        background-color:#420816;
        box-shadow: #BA274A 0px 0px 10px;
    }
    .green:hover{
        border-color:#2da86b; 
        background-color:#00361b;
        box-shadow: #2da86b 0px 0px 10px
    }
    .blue:hover{
        border-color:#2f83b5; 
        background-color:#00304d;
        box-shadow: #2f83b5 0px 0px 10px
    }
    .purple:hover{
        border-color:#8d4aba; 
        background-color:#2a0047;
        box-shadow: #8d4aba 0px 0px 10px
    }
    .pink:hover{
        border-color:#db2abb; 
        background-color:#6e005a;
        box-shadow: #db2abb 0px 0px 10px
    }
</style>
<div class="text-white w-full md:w-5/6 lg:w-3/4 mx-auto">
    <div class="text-4xl font-lato font-light">@if($event->slug == '') Nuevo @endif  Evento: {{$event->name}}</div>
    <hr>
    
    <!-- Event card -->
    <div class="bg-black my-5 p-10">
        <form action="{{$postUrl}}" id="event-form" method="POST">
            @csrf
            <fieldset >
                <input type="hidden" name="slug" value="{{$event->slug}}">
                <div>
                    <input name="name" placeholder="Nombre del evento (100 caracteres máximo)" required 
                     type="text" value="{{$event->name}}" max="100"
                    class="w-full font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black text-2xl focus:border-transparent 
                    focus:border-b-indigo-600 focus:ring-0 transition">
                </div>
                <div class="mt-5">
                    <textarea name="description" id="" class="w-full bg-transparent focus:border-transparent h-32
                    focus:border-indigo-600 focus:ring-0 transition">{{$event->description}}</textarea>
                </div>

            <div class="flex">
                <div class="w-1/2">
                    <livewire:color-picker defaultValue="{{$event->color}}" defaultValueName="{{__('colors.'.$event->color)}}">
                </div>
                <div class="w-1/2">
                    <div class="font-medium mb-2">Póster</div>
                    @if ($event->poster_url != "" || $event->poster_url != null)
                        <a href="">Ver póster</a>
                    @else
                        <a href="" class="bg-transparent border border-white p-2 my-2 transition duration-200 hover:bg-white hover:text-black active:bg-indigo-200">Subir póster (pdf)</a>
                    @endif
                </div>
            </div>
               
            @if ($event->visible)
            <div class="font-medium mt-10">
                Los siguientes campos no son editables cuando un evento es público.
            </div>
            @endif
                <div class="lg:flex w-full">
                    <div class="w-full mt-10">
                        <div class="font-medium">Fecha y hora de inicio del evento:</div>
                        <div class="flex w-full">
                                <input @if($event->visible) readonly @endif name="start_date_time" type="datetime-local" class="w-full  bg-transparent border-transparent border-b-gray-600 focus:outline-black focus:border-transparent 
                                focus:border-b-indigo-600 focus:ring-0 transition"
                                value="{{$event->start_datetime}}">
                        </div>
                    </div>
                    <div class="w-full mt-10">
                        <div class="font-medium">Fecha y hora de finaliación del evento:</div>
                        <div class="flex w-full">
                                <input @if($event->visible) readonly @endif name="end_date_time" type="datetime-local" class="w-full  bg-transparent border-transparent border-b-gray-600 focus:outline-black focus:border-transparent 
                                focus:border-b-indigo-600 focus:ring-0 transition"
                                value="{{$event->end_datetime}}">
                        </div>
                    </div>

                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="mt-10">
                        <div class="font-medium">Aforo máximo</div>
                        <input @if($event->visible) readonly @endif type="number" name="max_capacity" class="w-full lg:w-auto font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black text-2xl focus:border-transparent 
                        focus:border-b-indigo-600 focus:ring-0 transition" value="{{$event->max_capacity}}">
                    </div>
                    <div class="mt-10">
                        <div class="font-medium">Lugar</div>
                        <select name="venue_slug" id="" class="w-full lg:w-auto  font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black text-2xl focus:border-transparent 
                        focus:border-b-indigo-600 focus:ring-0 transition">
                           @foreach (App\Models\Organization::find(auth()->guard('admin')->user()->organization_id)->venues as $venue)
                           @if($venue->visible)
                               @if ($event->venue_id == $venue->id) 
                                   <option selected value="{{$venue->slug}}" class="bg-gray-900 font-light" >{{$venue->name}}</option>
                               @else
                               <option  @if($event->visible) disabled @endif value="{{$venue->slug}}" class="bg-gray-900 font-light">{{$venue->name}}</option>
                               @endif
                           @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-10">
                    <div class="font-medium">Visible</div>
                    <input type="hidden" name="visible" value="0" />

                    <livewire:toggle-switch :checked="$event->visible" :disabled="$event->visible"  ident="event_visible" name="visible" value="1">

                </div>
            </fieldset>
            <div class="text-right my-10">
                <button type="submit" id="save-button" class="@if($event->slug != '') invisible @endif font-medium bg-indigo-500 py-2 px-5  hover:bg-indigo-600 active:bg-indigo-700 transition ">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>

    <!-- Tickets card -->
    @if($event->slug != '')
    <div class="bg-black my-5 p-10">
        <div class="text-2xl font-light">Entradas</div>
        <hr>
        <div class="overflow-x-auto">
            <table class="w-full ">
                <tr class="font-medium text-lg">
                    <td>Nombre</td>
                    <td>Condiciones</td>
                    <td>Precio</td>
                    <td>Cantidad</td>
                    <td>Hora máxima de entrada</td>
                    <td>DNI requerido</td>
                    <td>Visibilidad</td>
                    <td></td>
                </tr>
                @foreach ($event->tickets as $ticket)
                <form action="{{url('admin/ticket/update')}}" id="ticketform-{{$ticket->slug}}">
                    <input type="hidden" name="slug" value="{{$ticket->slug}}">
                    <tr class="border-b border-gray-700">
                        <td class="py-4">
                            <input name="name" @if($ticket->visible) readonly @endif placeholder="Nombre de la entrada (100 caracteres máximo)" required 
                             type="text" value="{{$ticket->name}}" max="100"
                            class=" bg-transparent border-transparent border-b-gray-600 focus:outline-black  focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition">
                        </td>
                        <td class="py-4">
                            <input name="conditions" @if($ticket->visible) readonly @endif placeholder="Condiciones de la entrada separados por ; (2 consumiciones; camisa).  máx:100 caracteres. " required 
                             type="text" value="{{$ticket->conditions}}" max="100"
                            class=" bg-transparent border-transparent border-b-gray-600 focus:outline-black  focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition">
                        </td>
                        <td class="py-4">
                            <input  @if($ticket->visible) readonly @endif type="number" name="price" 
                            class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black w-20 focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition" value="{{$ticket->price}}">
                        </td>
                        <td class="py-4">
                            <input  @if($ticket->visible) readonly @endif type="number" name="number" 
                            class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black w-20 focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition" value="{{$ticket->number}}">
                        </td>
                        <td class="py-4">
                            <input type="hidden" name="time_limit" value="0">
                            <livewire:toggle-switch :checked="$ticket->max_datetime" :disabled="$ticket->visible" ident="{{$ticket->slug}}_maxdt" name="time_limit" value="1">
                            <input type="datetime-local" name="max_datetime" value="{{ \Carbon\Carbon::parse($ticket->max_datetime)->format('Y-m-d H:i') }}" class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition">
                        </td>
                        <td class="py-4">
                            <input type="hidden" name="id_number_required" value="0">
                            <livewire:toggle-switch :checked="$ticket->id_number_required" :disabled="$ticket->visible" ident="{{$ticket->slug}}_idreq" name="id_number_required" value="1">
                        </td>
                        <td class="py-4">
                            <input type="hidden" name="visible" value="0">
                            @php
                            $disabled = false;
                                if($ticket->visible && $event->visible){
                                    $disabled = true;
                                }
                            @endphp
                            <livewire:toggle-switch :checked="$ticket->visible" :disabled="$disabled"  ident="{{$ticket->slug}}_visible" name="visible" value="1">
                        </td>
                    </form>
                        <td>
                            @if ($ticket->visible && $event->visible)
                                @component('admin.components.dropwdown')
                                    @slot('idname', $ticket->slug)
                                    @slot('name', 'Opciones')
                                    @slot('options')
                                    <li>
                                        <a href="#" class="block px-4 py-2  hover:bg-gray-600 text-white transition">Analiticas</a>
                                    </li>
                                    @endslot
                                @endcomponent                        
                            
                            @else

                                @component('admin.components.dropwdown')
                                    @slot('idname', $ticket->slug)
                                    @slot('name', 'Opciones')
                                    @slot('options')
                                    <li>
                                        <button type="submit" class="block px-4 py-2  hover:bg-gray-600 text-white transition w-full text-justify"
                                        onclick="document.getElementById('ticketform-{{$ticket->slug}}').submit()">Guardar</button>
                                    </li>
                                    <li>
                                        <form action="{{url('admin/ticket/delete')}}">
                                            <input type="hidden" name="slug" value="{{$ticket->slug}}">
                                            <button type="submit" class="block px-4 py-2  bg-red-600 hover:bg-red-700 text-white transition w-full text-justify">Eliminar</button>
                                        </form>
                                    </li>
                                    @endslot
                                @endcomponent
                            @endif
                        </td>
        
                    </tr>
                
                
                @endforeach
                <form action="{{url('admin/ticket/new')}}">
                    <input type="hidden" name="event_slug" value="{{$event->slug}}">
                    <tr class="border-b border-gray-700">
                        <td class="py-4">
                            <input name="name" placeholder="Nombre de la entrada (100 caracteres máximo)" required 
                             type="text" value="" max="100"
                            class=" bg-transparent border-transparent border-b-gray-600 focus:outline-black  focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition">
                        </td>
                        <td class="py-4">
                            <input name="conditions" placeholder="Condiciones de la entrada separados por ; (2 consumiciones; camisa).  máx:100 caracteres. " required 
                             type="text"  max="100"
                            class=" bg-transparent border-transparent border-b-gray-600 focus:outline-black  focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition">
                        </td>
                        <td class="py-4">
                            <input  type="number" name="price" 
                            class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black w-20 focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition" >
                        </td>
                        <td class="py-4">
                            <input  type="number" name="number" 
                            class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black w-20 focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition" >
                        </td>
                        <td class="py-4">
                            <input type="hidden" name="time_limit" value="0">
                            <livewire:toggle-switch   ident="maxdt" name="time_limit" value="1">
                            <input type="datetime-local" name="max_datetime"  class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition">
                        </td>
                        <td class="py-4">
                            <input type="hidden" name="id_number_required" value="0">
                            <livewire:toggle-switch ident="idreq" name="id_number_required" value="1">
                        </td>
                        <td class="py-4">
                            <input type="hidden" name="visible" value="0">
                            <livewire:toggle-switch ident="visible" name="visible" value="1">
                        </td>
                        <td>
                            <button type="submit" class="transition text-white bg-indigo-700 hover:bg-indigo-800 focus:outline-none font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center " type="button">
                                Guardar
                            </button>
                        </td>
        
                    </tr>
                </form>
            </table>
        </div>
    </div>
    @endif

</div>
  <script>

function showSaveButton(){
    $('#save-button').removeClass('invisible')
}
$('input', '#event-form').change(function() {
    showSaveButton()
})
$('input', '#event-form').keyup(function() {
    showSaveButton()
})
$('textarea', '#event-form').keyup(function() {
    showSaveButton()
})
function colorEdited(){
    showSaveButton()
}
  </script>

@endsection