import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import TinyEmitter from 'tiny-emitter';

const app = createApp({});

const emitter = new TinyEmitter();

Object.entries(import.meta.glob('./**/*.vue', {eager: true})).forEach(([path, definition]) => {
    app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
});

app.config.globalProperties.emitter = emitter;

app.mount('#app');
