import axios from "axios";

const state = {
    projects: [],
    total: 0,
    project:null,
};

const getters = {
    getProjects: (state) => state.projects,
    getProject: (state) => state.project,
};

const actions = {
    downloadProjects({commit}, payload) {
        return new Promise(((resolve, reject) => {
            let perPage = payload.itemsPerPage?payload.itemsPerPage:10;
            let page = payload.page?payload.page:1;
            let byUser = payload.user_id?`&user_id=${payload.user_id}`:''
            let search = `perPage=${perPage}&page=${page}`;
            axios.get('auth/user/project?perPage=10'+search+byUser)
                .then(res => {
                    commit("UPDATE_PROJECTS", res.data.data);
                    commit("UPDATE_TOTAL", res.data.total);
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    createProject({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('auth/user/project', payload)
                .then(res => {
                    commit("ADD_PROJECT", res.data.project);
                    resolve(res.data.project)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    updateProject({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('auth/user/project/'+payload.id, payload)
                .then(res => {
                    commit("UPDATE_PROJECT", res.data.project);
                    resolve(res.data.project)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    deleteProject({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.delete('auth/user/project/'+payload)
                .then(res => {
                    commit("REMOVE_PROJECT", payload);
                    resolve(res.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    ADD_PROJECT (state, project) {
        state.projects.push(project);
        state.total += 1;
    },
    UPDATE_PROJECTS (state, projects) {
        state.projects = projects
    },
    UPDATE_TOTAL (state, total) {
        state.total = total;
    },
    UPDATE_PROJECT (state, project) {
        let item = state.projects.find((i) => i.id === project.id)
        item = project;
        state.projects = [...state.projects.filter( (i) => i.id !== project.id), item];
    },
    REMOVE_PROJECT (state, project) {
        state.projects = state.projects.filter( (i) => i.id !== project);
        state.total -= 1;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}