import './index.sass'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import colors from 'vuetify/lib/util/colors'

const vuetify = createVuetify({
    components: {
        ...components,
    },
    directives,
    icons: {
        defaultSet: 'mdi',
    },
    theme: {
        themes: {
            light: {
                colors: {
                    primary: colors.blue.darken2,
                    secondary: colors.grey.darken3,
                    accent: colors.blue.accent1,
                    error: colors.red.accent2,
                    info: colors.blue.base,
                    success: colors.green.base,
                    warning: colors.orange.darken1,
                },
            },
            dark: {
                colors: {
                    primary: colors.blue.base,
                    secondary: colors.grey.darken3,
                    accent: colors.pink.accent1,
                    error: colors.red.accent2,
                    info: colors.blue.base,
                    success: colors.green.base,
                    warning: colors.orange.darken1,
                },
            },
        },
    }
})

export default vuetify;
