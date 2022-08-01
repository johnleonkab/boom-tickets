@extends('admin.layouts.main')
@slot('pageTitle', $pageTitle)
@section('content')
<div class="text-white w-5/6 pt-5 mx-auto">
    <div class="text-3xl font-lato font-light">Próximos eventos: {{$events->count()}}</div>
    <hr>
    <table class="w-full my-5">
        <tr class="font-medium text-lg">
            <td>Nombre</td>
            <td>Empieza</td>
            <td>Termina</td>
            <td class="text-center">Visible</td>
            <td>Lugar</td>
            <td>Ver</td>
            <td class="text-center">Estado</td>
        </tr>
        <tr>
            <td colspan="7" class="py-2 ">
                <button onclick="window.location.href='{{url('admin/event/new')}}'" class="font-medium w-full bg-indigo-600 rounded hover:bg-indigo-700 transition focus:ring-2 focus:ring-indigo-300 py-2">Nuevo evento</button>
            </td>
        </tr>
        @foreach ($events as $event)
            <tr class="border-b border-gray-700  hover:bg-gray-800  transition">
                <td class="py-4">{{ $event->name }}</td>
                <td>{{ \Carbon\Carbon::parse($event->start_datetime)->format('d/m/Y H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($event->end_datetime)->format('d/m/Y H:i') }}</td>
                <td class="text-center">@if($event->visible)
                    <span class="material-symbols-outlined text-green-500">
                    done
                    </span>
                    @else
                    <span class="material-symbols-outlined text-red-500">
                        close
                        </span>
                    @endif
                </td>
                <td>
                    {{ App\Models\Event::find($event->id)->venue->name }}
                </td>
                <td>
                    @component('admin.components.dropwdown')
                                    @slot('idname', $event->slug)
                                    @slot('name', 'Opciones')
                                    @slot('options')
                                    <li>
                                        <a href="{{url('admin/event/'.$event->slug)}}" class="block px-4 py-2  hover:bg-gray-600 text-white transition w-full text-justify">Gestionar</a>
                                    </li>
                                    <li>
                                        <a href="{{url('admin/analytics/event/'.$event->slug)}}" class="block px-4 py-2  hover:bg-gray-600 text-white transition w-full text-justify">Analíticas</a>
                                    </li>
                                    @endslot
                                @endcomponent
                </td>
                <td class="text-center">
                    <button data-tooltip-target="tooltip-default-{{$event->slug}}" type="button" class="focus:outline-none font-medium text-sm px-5 py-2.5 text-center">
                        <span class="material-symbols-outlined text-yellow-600">
                            error
                            </span>
                    </button>
                    <div id="tooltip-default-{{$event->slug}}" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                        Hay entradas sin publicar
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    
                </td>
            </tr>
        @endforeach
    </table>
</div>
  
<div class="text-white w-full md:w-5/6 lg:w-3/4 mx-auto">
    <div class="text-4xl font-lato font-light">Gestiona eventos pasados</div>
</div>
@endsection