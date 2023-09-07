import './bootstrap';
import '../css/app.css';
import 'vue-select/dist/vue-select.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { i18nVue } from 'laravel-vue-i18n'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

import { Link, Head } from '@inertiajs/inertia-vue3';
import BaseLayout from '@/Layouts/BaseLayout.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(i18nVue, {
                resolve: async lang => {
                    const langs = import.meta.glob('../../lang/*.json');
                    return await langs[`../../lang/${lang}.json`]();
                }
             })
            .component('Link', Link)
            .component('Head', Head)
            .component('BaseLayout', BaseLayout)
            .component('AuthenticatedLayout', AuthenticatedLayout)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
