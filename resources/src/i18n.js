import Vue from 'vue';
import VueI18n from 'vue-i18n';

Vue.use(VueI18n);

// Importar los archivos de traducción
import englishMessages from './locales/en.json';
import spanishMessages from './locales/es.json';

export default new VueI18n({
  locale: 'es',
  messages: {
    en: englishMessages,
    es: spanishMessages,
  },
});