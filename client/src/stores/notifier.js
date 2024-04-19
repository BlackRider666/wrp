import { defineStore } from 'pinia';

export const useNotifierStore = defineStore('notifier', {
    state: () => ({
        content: '',
        contentTKey: '',
        color: '',
        options: {},
        show: false
    }),
    actions: {
        showMessage(payload) {
            this.content = payload.content;
            this.contentTKey = payload.contentTKey;
            this.color = payload.color;
            this.options = payload.options;
            this.show = true;
        },
        closeMessage() {
            this.content = '';
            this.contentTKey = '';
            this.color = '';
            this.options = {};
            this.show = false;
        }
    }
});
