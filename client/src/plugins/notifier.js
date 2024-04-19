import { useNotifierStore } from '@/stores/notifier'; // Шлях до вашого Pinia стору

const Notifier = {
    install(app) {
        app.config.globalProperties.$notify = function (contentTKey = '', color = '', content = '', options = {}) {
            const notifierStore = useNotifierStore();
            notifierStore.showMessage({ contentTKey, color, content, options });
        }
    }
};

export default Notifier;
