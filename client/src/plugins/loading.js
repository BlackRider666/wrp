import {useMainStore} from "@/stores";

const LoadingPlugin = {
    install(app) {
        const store = useMainStore();
        app.config.globalProperties.$loading = function () {
            store.setShowLoading(true);
        };

        app.config.globalProperties.$loadingClose = function () {
            store.setShowLoading(false);
        };
    }
};
 export default LoadingPlugin;
