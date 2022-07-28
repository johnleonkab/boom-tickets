<div id="toast-default" class="fixed md:top-24 md:right-4 top-24 right-1/2 translate-x-1/2 md:translate-x-0 flex items-center p-4 w-11/12 md:max-w-xs rounded-lg shadow text-gray-400 bg-gray-800 z-40" role="alert">
    <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 rounded-lg ">
        <img src="{{asset('images/logo BT sq.png')}}" alt="">
    </div>
    <div class="ml-3 text-sm font-normal flex">{!!$message!!}</div>
</div>

<script>
    $(document).ready(function(){
        setTimeout(() => {
            const targetEl = document.getElementById('toast-default');
            const options = {
                transition: 'transition-opacity',
                duration: 1000,
                timing: 'ease-out'
            }
            const dismiss = new Dismiss(targetEl, options);
            dismiss.hide()
        }, 3000);
    })
</script>