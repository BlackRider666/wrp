import store from "@/store";
import debounce from 'lodash.debounce'

export const debouncer = (timeout) => debounce((f) => f(), timeout, { leading: false });

const debounceRequest = debouncer(5000)

const L10s = {
    translations: store.getters['l10s/translations'] || {},
    untranslatedKeys: [],
    install(Vue) {
        Vue.prototype.$t = (key, value) => {
            const translations =  store.getters['l10s/translations']
            if (translations[key] !== undefined && translations[key].length > 0) {
                return translations[key];
            }
            if(this.untranslatedKeys.length >=100) {
                debounceRequest.cancel()
                const arr = [...this.untranslatedKeys]
                this.untranslatedKeys = []
                store.dispatch('l10s/createNewTranslationKey', arr)
            } else {
                debounceRequest(()=>{
                    const arr = [...this.untranslatedKeys]
                    this.untranslatedKeys = []
                    if(arr.length>0) {
                        store.dispatch('l10s/createNewTranslationKey', arr)
                    }
                })
            }

            const i = this.untranslatedKeys.findIndex(_element => _element.key === key);
            if (i > -1) this.untranslatedKeys[i] = {key,value};
            else this.untranslatedKeys.push({key, value});
            return value;
        };
    },
};

export default L10s;