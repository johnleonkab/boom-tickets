<div id="alert-2" class="flex p-4 mb-4 bg-indigo-500 fixed top-20 md:right-10 w-full md:w-1/3 xl:w-1/6" role="alert" style="z-index: 999999">
    <div class="ml-3 text-sm font-medium text-white">
        {{$success}}
    </div>
    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-indigo-300 transition text-indigo-500 rounded-lg focus:ring-2 focus:ring-indigo-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-green-200 dark:text-green-600 dark:hover:bg-green-300" data-dismiss-target="#alert-2" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </button>
</div>

<script>
  targetEl = document.getElementById('alert-2');
  const dismiss = new Dismiss(targetEl, '');
  setTimeout(function(){
    dismiss.hide();
  }, 3000);

</script>