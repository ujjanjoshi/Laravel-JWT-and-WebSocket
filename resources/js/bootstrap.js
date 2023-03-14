/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster:process.env.MIX_PUSHER_APP_CLUSTER ,
    wsHost:window.location.hostname,
    // auth: {
    //     headers: {
    //         Authorization:'Bearer ' +"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2NzcyMjMxMTksImV4cCI6MTY3NzIyNjcxOSwibmJmIjoxNjc3MjIzMTE5LCJqdGkiOiJXNW92b1BuaWVwbGJCTWcyIiwic3ViIjoiNSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.NCMKzsRPYrXId4wkqNIZiH3nNwMzyMyBd8lsYRiFM_8"
    //     },
    // },
     // wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wsPort: 6001,
    encrypted:false,
    forceTLS:false,
    enabledTransports: ['ws', 'wss'],
});
