/* eslint-disable import/order */
import '@/@iconify/icons-bundle'
import App from '@/App.vue'
import layoutsPlugin from '@/plugins/layouts'
import vuetify from '@/plugins/vuetify'
import { loadFonts } from '@/plugins/webfontloader'
import router from '@/router'
import '@core-scss/template/index.scss'
import '@styles/styles.scss'
import { createPinia } from 'pinia'
// import useGlobalStore from '../../stores/globalStore'
import { createApp } from 'vue'
import Echo from 'laravel-echo';
import Pusher from 'pusher-js'

// const globalStore = useGlobalStore()
window.Pusher = Pusher
// Pusher.logToConsole = true;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: "a17c7e5cfb607893fb3c",
    cluster: "us2",
    forceTLS: true,
    encrypted: true
});



// Pusher.logToConsole = true;

// var pusher = new Pusher('a17c7e5cfb607893fb3c', {
//     cluster: 'us2'
// });

// var channel = pusher.subscribe('my-channel');
// channel.bind('MyEvent', function (data) {
//     debugger
//     console.error(data)
// });



loadFonts()


// Create vue app
const app = createApp(App)


// Use plugins
app.use(vuetify)
app.use(createPinia())
app.use(router)
app.use(layoutsPlugin)

// Mount vue app
app.mount('#app')
