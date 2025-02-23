@foreach($notifications as $notification)
    <div class="alert alert-info">
        {{ $notification->data['message'] }}
    </div>
@endforeach