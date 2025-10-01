import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import PrimeVue from 'primevue/config'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import Card from 'primevue/card'
import { createPinia } from 'pinia';
import ConfirmationService from 'primevue/confirmationservice'
import { library, config } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faBookmark } from '@fortawesome/free-solid-svg-icons'
import 'primeicons/primeicons.css';
import Tooltip from 'primevue/tooltip';


config.autoAddCss = false
library.add(faBookmark)

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
    const page = pages[`./pages/${name}.vue`]
    return page
  },
  setup({ el, App, props, plugin }) {
    const pinia = createPinia();
    createApp({ render: () => h(App, props) })
      .use(pinia)
      .use(plugin)
      .use(PrimeVue, {
        unstyled: true  // ← Esto desactiva los estilos de PrimeVue
      })
      .use(ConfirmationService)
      .directive('tooltip', Tooltip)
      .component('font-awesome-icon', FontAwesomeIcon)
      .mount(el)
  },
});