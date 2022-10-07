const state = {
    show: localStorage.getItem('tutorial') != null ? parseInt(localStorage.getItem('tutorial')): 1,
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
    updateShowState({commit}, payload) {
        commit('UPDATE_SHOW_STATE', payload)
    },
    complete({commit}) {
        commit('NEXT_STEP');
        commit('UPDATE_SHOW', 0);
    }
};

const mutations = {
    UPDATE_SHOW (state, show) {
        state.show = show
        localStorage.setItem('tutorial',show);
    },
    START_TUTORIAL (state) {
        state.step = 1
        localStorage.setItem('tutorial_step', 1);
    },
    NEXT_STEP (state) {
        state.step += 1
        localStorage.setItem('tutorial_step',state.step);
    },
    UPDATE_SHOW_STATE(state, show) {
        state.show = show;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
