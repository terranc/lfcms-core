@foreach ((array) session('flash_notification') as $message)
    @php
        switch ($message['level']) {
            case 'danger':
                $className = 'error';
                break;
            default:
                $className = $message['level'];
                break;
        }
    @endphp
    @if ($message['overlay'])
        <script>
            Vue.$modal["{{ $className }}"]({
                iconType: 'frown',
                title: '"{{ $message[' title'] }}"',
                content: '"{{ $message['message'] }}"',
                okText: '知道了',
                cancelText: '',
                width: 300,
            });
        </script>
    @else
        <v-alert type="{{ $className }}" message="{{ $message['title'] }}"
                 description="{{ $message['message'] }}" show-icon
                 {{ $message['important'] ? 'closable' : '' }}></v-alert>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
