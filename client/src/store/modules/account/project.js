import axios from "axios";

const state = {
    projects: [],
    project:null,
};

const getters = {
    getProjects: (state) => state.projects,
    getProject: (state) => state.project,
};

const actions = {
    downloadProjects({commit}, payload) {
        return new Promise(((resolve, reject) => {
            let search = `&user_id=${payload.user_id}`;
            axios.get('auth/user/project?perPage=10'+search)
                .then(res => {
                    commit("UPDATE_PROJECTS", res.data.data);
                    resolve(res.data.data)
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
    },
    UPDATE_PROJECTS (state, projects) {
        state.projects = projects
    },
    UPDATE_PROJECT (state, project) {
        let item = state.projects.find((i) => i.id === project.id)
        item = project;
        state.projects = [...state.projects.filter( (i) => i.id !== project.id), item];
    },
    REMOVE_PROJECT (state, project) {
        state.projects = state.projects.filter( (i) => i.id !== project);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}