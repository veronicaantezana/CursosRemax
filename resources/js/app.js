import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import PrimeVue from 'primevue/config'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import Card from 'primevue/card'
import ConfirmationService from 'primevue/confirmationservice'
import { library, config } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faBookmark } from '@fortawesome/free-solid-svg-icons'
import 'primeicons/primeicons.css';


config.autoAddCss = false
library.add(faBookmark)

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
    const page = pages[`./pages/${name}.vue`]
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(PrimeVue, {
    unstyled: true  // ← Esto desactiva los estilos de PrimeVue
  })
      .use(plugin)
      .use(PrimeVue)
      .use(ConfirmationService)
      .component('font-awesome-icon', FontAwesomeIcon)
      .mount(el)
  },
});