const state = {
    tutorialCategory: localStorage.getItem('tutorial_category'),
    show: 1,
    step: localStorage.getItem('tutorial_step') != null ? parseInt(localStorage.getItem('tutorial_step')):0,
};

const getters = {
};

const actions = {
    updateShow({commit}, payload) {
        commit('UPDATE_SHOW', payload)
    },
    start({commit}) {
        commit('START_TUTORIAL')
    },
    nextStep({commit}) {
        commit('NEXT_STEP')
    },
    complete({commit}) {
        commit('CLEAR_STEP');
        commit('CLEAR_TUTORIAL_CATEGORY');
    },
    selectTutorial({commit}, tutorial) {
        commit('UPDATE_TUTORIAL_CATEGORY', tutorial);
    },
};

const mutations = {
    UPDATE_SHOW (state, show) {
        state.show = show
    },
    START_TUTORIAL (state) {
        state.step = 1
        localStorage.setItem('tutorial_step', 1);
    },
    NEXT_STEP (state) {
        state.step += 1
        localStorage.setItem('tutorial_step',state.step);
    },
    UPDATE_TUTORIAL_CATEGORY(state, category) {
        state.tutorialCategory = category;
        localStorage.setItem('tutorial_category',state.tutorialCategory);
    },
    CLEAR_STEP(state) {
        state.step = 0;
        localStorage.removeItem('tutorial_step');
    },
    CLEAR_TUTORIAL_CATEGORY(state) {
        state.tutorialCategory = null;
        localStorage.removeItem('tutorial_category');
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
