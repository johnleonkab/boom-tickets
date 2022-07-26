  <div class="swiper mySwiper ">
    <div class="swiper-wrapper align-middle">
      @foreach ($events as $event)
        <div class="swiper-slide border border-white my-auto" style="background: url('{{$event->poster_url}}') fixed;background-size:cover;background-position:center">
          <div class="h-64">
            @if (!Auth::guard('web')->guest())
              <a href="javascript:loadModalWithData('event_share', '{{$event->slug}}')" class="bg-transparent hover:bg-transparent float-right p-3">
                <span class="material-symbols-outlined"> send </span>
              </a>
            @endif
          </div>
          @php \Carbon\Carbon::setLocale('es'); @endphp
          <div class="bg-black px-10 py-5 text-white text-center bg-opacity-80">
            <div class="text-2xl md:text-xl 2xl:text-2xl font-semibold uppercase text-center">{{$event->name}}</div>
            <div class="text-xl font-semibold uppercase text-center">{{ \Carbon\Carbon::parse($event->start_datetime)->translatedFormat('d \d\e F') }}</div>
            <div class="text- font-semibold uppercase text-center">{{$event->venue->name}}</div>
            <a href="{{url('event/'.$event->slug)}}" class="mx-auto buy-button">
              <span class="mx-auto flex align-middle">
                <span class="material-symbols-outlined"> confirmation_number </span> &nbsp;
                Ver más
              </span>
            </a>
          </div>
        </div>
      @endforeach
    </div>
    <br><br>
    <div class="swiper-pagination"></div>
</div>
       
<livewire:share-modal>
          <!-- Initialize Swiper -->
<script>
  var swiper = new Swiper(".mySwiper", {
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    loop: true, 
    autoplay: {
      delay: 5000,
    },
    breakpoints: {
      // >= 320px
      320: {
      slidesPerView: 1,
      },
      640: {
      slidesPerView: 2,
      spaceBetween: 30
      },
      800: {
      slidesPerView: 3,
      spaceBetween: 30
      },
      1200: {
      slidesPerView: 3,
      spaceBetween: 30
      },
      1920: {
      slidesPerView: 5,
      spaceBetween: 30
      }
    },
    centeredSlides: true,
    spaceBetween: 10,
    grabCursor: false,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });
      </script>