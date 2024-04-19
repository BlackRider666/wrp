import { defineStore } from "pinia";

export const useMainStore = defineStore('main',{
    state: () => ({
        showLoading: false,
    }),
    actions: {
        setShowLoading(val) {
            this.showLoading = val;
        },
    }
});
