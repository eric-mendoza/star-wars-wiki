import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import Layout from './Shared/Layout.vue';

import Toast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';


createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        const page = pages[`./Pages/${name}.vue`].default;
        page.layout = page.layout || Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin)
        app.use(Toast, {
            position: 'bottom',
            duration: 4000,
            dismissible: true,
        });
        app.mount(el);
    },
});
