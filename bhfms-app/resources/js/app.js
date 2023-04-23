import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { GoogleAutocompletePlugin } from "vue-google-autocomplete";
createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(GoogleAutocompletePlugin, {
        apiKey: 'AIzaSyA2jQ6h9LFcb7VMwDAiCAyCRKez0ucwwwI',
        version: '3.42', // optional API version
        language: 'en', // optional language
      })
      .mount(el)
  },
})
