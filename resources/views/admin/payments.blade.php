@extends('admin.layouts.app')
@slot('pageTitle', $pageTitle)
@section('content')
<section class="text-white">
    <div class="w-full md:w-3/4 mx-auto">
        <h2 class="text-3xl">Balance y pagos</h2>
        <div class="bg-gray-800 rounded p-3">
            <div id="accordion-collapse" data-accordion="collapse">
                <h2 id="accordion-collapse-heading-1">
                  <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left border border-b-0 rounded-t-xl focus:ring-4 focus:ring-gray-800 border-gray-700 text-gray-400 bg-gray-800" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
                    <span>Estado de la cuenta de pago.</span>
                    <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                  </button>
                </h2>
                <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                  <div class="p-5 font-light border border-b-0  border-gray-700 bg-gray-900">
                    @if(Auth::guard('admin')->user()->organization->stripe_user_id == '')
                    <div class="w-full text-center my-3">
                        No has conectado una cuenta para realizar los pagos.
                    </div>
                    <button onclick="window.location.href='{{url('admin/stripe/create')}}'" 
                        class="bg-indigo-500 px-2 py-2 rounded transition hover:bg-indigo-600 font-medium
                        focus:ring-4 focus:ring-indigo-300">Conectar cuenta</button>
                    @endif
                @if($payouts_enabled)
                Conectada: 
                <button onclick="window.location.href='{{url('admin/stripe/create')}}'" 
                class="bg-indigo-500 px-2 py-2 rounded transition hover:bg-indigo-600 font-medium
                focus:ring-4 focus:ring-indigo-300">Gestionar</button>
                @else
                Información necesaria: 
                <button onclick="window.location.href='{{url('admin/stripe/create')}}'" 
                class="bg-red-500 px-2 py-2 rounded transition hover:bg-red-600 font-medium
                focus:ring-4 focus:ring-red-300">Completar</button>
                @endif
                </div>
                </div>
                <h2 id="accordion-collapse-heading-2">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left  border border-b-0  focus:ring-4  focus:ring-gray-800 border-gray-700 text-gray-400 bg-gray-800" data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
                      <span>Is there a Figma file available?</span>
                      <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                  </h2>
                  <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                    <div class="p-5 font-light border border-b-0 border-gray-700">
                    </div>
                  </div>
                  <h2 id="accordion-collapse-heading-3">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left  border  focus:ring-4 focus:ring-gray-800 border-gray-700 text-gray-400 bg-gray-800" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                      <span>What are the differences between Flowbite and Tailwind UI?</span>
                      <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                  </h2>
                  <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <div class="p-5 font-light border border-t-0 border-gray-700">
                    </div>
                  </div>
              </div>

        </div>
    </div>
</section>
@endsection