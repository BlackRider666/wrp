import axios from "axios";

const state = {
    conferences: [],
    conference:null,
    total:0,
};

const getters = {
    getConferences: (state) => state.conferences,
    getConference: (state) => state.conference,
};

const actions = {
    downloadConferences({commit}, payload) {
        return new Promise(((resolve, reject) => {
            let perPage = payload.itemsPerPage?payload.itemsPerPage:10;
            let page = payload.page?payload.page:1;
            let byUser = payload.user_id?`&user_id=${payload.user_id}`:''
            let byTitle = payload.title?`&title=${payload.title}`:''
            let country = payload.country_id?`&country_id=${payload.country_id}`:'';
            let city = payload.city_id?`&city_id=${payload.city_id}`:'';
            let search = `perPage=${perPage}&page=${page}&sortBy=${payload.sortBy}&sortDesc=${payload.sortDesc}`;
            axios.get('conference?'+search+byUser+byTitle+country+city)
                .then(res => {
                    commit("UPDATE_CONFERENCES", res.data.data);
                    commit("UPDATE_TOTAL", res.data.total);
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    createConference({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('conference', payload)
                .then(res => {
                    commit("ADD_CONFERENCE", res.data.conference);
                    resolve(res.data.conference)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    updateConference({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('conference/'+payload.id, payload)
                .then(res => {
                    commit("UPDATE_CONFERENCE", res.data.conference);
                    resolve(res.data.conference)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    deleteConference({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.delete('conference/'+payload)
                .then(res => {
                    commit("REMOVE_CONFERENCE", payload);
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    getConference({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.get('conference/'+payload)
                .then(res => {
                    commit("CHOOSE_CONFERENCE", res.data.conference);
                    resolve(res.data.conference)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    addArticle({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('conference/add-article/'+payload.id, payload)
                .then(res => {
                    commit("CHOOSE_CONFERENCE", res.data.conference);
                    resolve(res.data.conference)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    addOrgCommittee({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('conference/add-org-committee/'+payload.id, payload)
                .then(res => {
                    commit("CHOOSE_CONFERENCE", res.data.conference);
                    resolve(res.data.conference)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    deleteOrgCommittee({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('conference/remove-org-committee/'+payload.id, payload)
                .then(res => {
                    commit("CHOOSE_CONFERENCE", res.data.conference);
                    resolve(res.data.conference)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    addEditors({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('conference/add-editors/'+payload.id, payload)
                .then(res => {
                    commit("CHOOSE_CONFERENCE", res.data.conference);
                    resolve(res.data.conference)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    deleteEditors({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('conference/remove-editors/'+payload.id, payload)
                .then(res => {
                    commit("CHOOSE_CONFERENCE", res.data.conference);
                    resolve(res.data.conference)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    ADD_CONFERENCE (state, conference) {
        state.conferences.push(conference);
        state.total += 1;
    },
    UPDATE_CONFERENCES (state, conferences) {
        state.conferences = conferences
    },
    UPDATE_TOTAL (state, total) {
        state.total = total;
    },
    UPDATE_CONFERENCE (state, conference) {
        let item = state.conferences.find((i) => i.id === conference.id)
        item = conference;
        state.conferences = [...state.conferences.filter( (i) => i.id !== conference.id), item];
    },
    REMOVE_CONFERENCE (state, conference) {
        state.conferences = state.conferences.filter( (i) => i.id !== conference);
        state.total -= 1;
    },
    CHOOSE_CONFERENCE (state, conference) {
        state.conference = conference;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
