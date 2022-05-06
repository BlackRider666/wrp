process.env.VUE_APP_VERSION = require('./package.json').version

module.exports = {
    transpileDependencies: [
        'vuetify'
    ],
    css: {
        extract: { ignoreOrder: true },
    },
    devServer: {
        compress: true,
        public: 'wrp.org.ua',
    }
}
