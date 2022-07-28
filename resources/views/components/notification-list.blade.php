@foreach ($notifications as $notification)
<div id="notification_slug" class="py-3 px-2 hover:bg-gray-900 transition duration-500 rounded-xl last:border-none">
    <h2 class="text-lg font-medium">{!!$notification->title !!} <span class="text-gray-500">· {{App\Http\Controllers\DateController::PastTime($notification->created_at)}} </span></h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 m-2">
        @if(isset($notification->image))
            <div class="hidden md:block"><img src="{{ $notification->image }}" class="rounded-lg max-h-48" alt=""></div>
        @endif
        <div class="@if(isset($notification->image)) md:col-span-3 @else md:col-span-4 @endif font-roboto">
            <?php
                switch($notification->type){
                    case 'survey':
                    $json = json_decode($notification->content);
                        ?>
                        <livewire:notification-survey :text="$json->title">
                        <?php
                    break;
                    
                    case 'event_share':
                     ?>
                    {!!$notification->content !!}
                    <?php
                    break;
                    default:
                    return;
                    break;
                }
            ?>
            @if($notification->type == 'survey')
            
            @elseif($notification->type == 'notification')
                
            @endif
        </div>
        <div class="block md:hidden text-center">
            <img src="{{ $notification->image }}" class="rounded-lg" alt="">
        </div>
    </div>
</div>
<hr class="border-gray-700 last:hidden">

@endforeach