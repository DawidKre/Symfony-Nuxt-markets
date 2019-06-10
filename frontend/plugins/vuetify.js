import Vue from 'vue'
import Vuetify from 'vuetify'
import colors from 'vuetify/es5/util/colors'

Vue.use(Vuetify, {
  theme: {
    primary: '#121212', // a color that is not in the material colors palette
    accent: colors.lightBlue.lighten4,
    secondary: colors.lightBlue.lighten2,
    info: colors.lightBlue.lighten4,
    warning: colors.lightBlue.base,
    error: colors.lightBlue.accent4,
    success: colors.lightBlue.accent3
  }
})
