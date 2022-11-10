import './bootstrap';
import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/inertia-vue3'
import {InertiaProgress} from '@inertiajs/progress'
import SlideUpDown from 'vue3-slide-up-down'
import store from "./Pages/Store";

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .component('SlideUpDown', SlideUpDown)
            .use(plugin)
            .mount(el)
    },
})

InertiaProgress.init({
    showSpinner: true,
})
