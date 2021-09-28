const L10s = {
    translations: JSON.parse(localStorage.getItem('l10s')) || {},
    untranslatedKeys: [],
    onUntranslatedKeyFoundCallback: (key, value) => {},
    install(Vue) {
        Vue.prototype.$t = (key, value) => {
            if (this.translations[key] !== undefined && this.translations[key].length > 0) {
                return this.translations[key];
            }
            this.untranslatedKeys.push({key, value});
            this.onUntranslatedKeyFoundCallback(key, value);
            return value;
        };

        Vue.prototype.l10s = {
            onUntranslatedKeyFound: (cb) => {
                this.onUntranslatedKeyFoundCallback = cb.bind(this);
            },
            setAllTranslations: (data) => {
                localStorage.removeItem('l10s');
                for (let i = 0; i < data.length; i++) {
                    this.translations[data[i].key] = data[i].value;
                }
                localStorage.setItem('l10s', JSON.stringify(this.translations));
            },
            getUntranslatedKeys: () => this.untranslatedKeys,
            cleanUntranslatedKeys: () => {
                this.untranslatedKeys = [];
            },
        };
    },
};

export default L10s;