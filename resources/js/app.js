require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import { showNotification } from "./Utils/helpers";
import { store } from './Store';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ElementPlus)
            .use(store)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

window.showNotification = showNotification;

InertiaProgress.init({ color: '#4B5563' });
