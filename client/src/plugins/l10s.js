import { useLocalesStore } from "@/stores/l10s";
import debounce from 'lodash.debounce';

export const debouncer = (timeout) => debounce((f) => f(), timeout, { leading: false });

const debounceRequest = debouncer(5000);

const L10s = {
    untranslatedKeys: [],
    install(app) {
        const localesStore = useLocalesStore();

        app.config.globalProperties.$t = (key, value) => {
            const translations = localesStore.translations;
            if (translations[key] !== undefined && translations[key].length > 0) {
                return translations[key];
            }
            if (this.untranslatedKeys.length >= 100) {
                debounceRequest.cancel();
                const arr = [...this.untranslatedKeys];
                this.untranslatedKeys = [];
                localesStore.createNewTranslationKey(arr);
            } else {
                debounceRequest(() => {
                    const arr = [...this.untranslatedKeys];
                    this.untranslatedKeys = [];
                    if (arr.length > 0) {
                        localesStore.createNewTranslationKey(arr);
                    }
                });
            }

            const i = this.untranslatedKeys.findIndex(element => element.key === key);
            if (i > -1) {
                this.untranslatedKeys[i] = { key, value };
            } else {
                this.untranslatedKeys.push({ key, value });
            }
            return value;
        };
    },
};

export default L10s;
