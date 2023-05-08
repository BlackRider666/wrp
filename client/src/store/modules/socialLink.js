import axios from "axios";

const state = {
    links: [],
};

const getters = {
    getLinks: (state) => {
        return state.links
    },
};

const actions = {
    downloadLinks({commit}, payload) {
        return new Promise(((resolve, reject) => {
            let perPage = payload && payload.perPage?payload.perPage:10;
            let search = `perPage=${perPage}`;
            axios.get('social-link?'+search)
                .then(res => {
                    commit("UPDATE_LINKS", res.data.data);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    create({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('social-link',payload)
                .then(res => {
                    commit("ADD_LINK", res.data.link);
                    resolve(res.data.link)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    update({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('social-link/'+payload.id,payload)
                .then(res => {
                    commit("UPDATE_LINK", res.data.link);
                    resolve(res.data.link)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    delete({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.delete('social-link/'+payload)
                .then(res => {
                    commit("REMOVE_LINK", payload);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    }
};

const mutations = {
    UPDATE_LINKS(state, links) {
        state.links = links
    },
    ADD_LINK(state, link) {
        state.links.push(link);
    },
    UPDATE_LINK(state, link) {
        let item = state.links.find((i) => i.id === link.id)
        item = link;
        state.links = [...state.links.filter( (i) => i.id !== link.id), item];
    },
    REMOVE_LINK(state, id) {
        state.links = state.links.filter( (i) => i.id !== id);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
