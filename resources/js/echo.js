import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.EchoFactory = Echo;

// We still keep a manual Echo instance for non-Filament pages if needed, 
// but Filament will use the Factory!
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'w5blyrbctqcwxl0k87sr',
    cluster: 'mt1',
    wsHost: window.location.hostname,
    wsPort: 8080,
    wssPort: 8080,
    forceTLS: false,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});

window.dispatchEvent(new CustomEvent('EchoLoaded'));
