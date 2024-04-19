import axios from "axios";
import {defineStore} from "pinia";
import {useAccountStore} from "@/stores/account";

export const useProjectStore = defineStore('project',{
    state:() => ({
        projects: [],
        total: 0,
        project:null,
    }),
    getters: {
        getProjects: (state) => state.projects,
        getProject: (state) => state.project,
    },
    actions: {
        downloadProjects(payload) {
            return new Promise(((resolve, reject) => {
                let perPage = payload.itemsPerPage ? payload.itemsPerPage : 10;
                let page = payload.page ? payload.page : 1;
                let byUser = payload.user_id ? `&user_id=${payload.user_id}` : ''
                let search = `perPage=${perPage}&page=${page}`;
                axios.get('auth/user/project?perPage=10' + search + byUser)
                    .then(res => {
                        this.UPDATE_PROJECTS(res.data.data);
                        this.UPDATE_TOTAL(res.data.total);
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        createProject(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('auth/user/project', payload)
                    .then(res => {
                        this.ADD_PROJECT(res.data.project);
                        useAccountStore().getOccupancyAccount();
                        resolve(res.data.project)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        updateProject(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('auth/user/project/' + payload.id, payload)
                    .then(res => {
                        this.UPDATE_PROJECT(res.data.project);
                        resolve(res.data.project)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        deleteProject(payload) {
            return new Promise(((resolve, reject) => {
                axios.delete('auth/user/project/' + payload)
                    .then(res => {
                        this.REMOVE_PROJECT(payload);
                        useAccountStore().getOccupancyAccount();
                        resolve(res.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        ADD_PROJECT(project) {
            this.projects.push(project);
            this.total += 1;
        },
        UPDATE_PROJECTS(projects) {
            this.projects = projects
        },
        UPDATE_TOTAL(total) {
            this.total = total;
        },
        UPDATE_PROJECT(project) {
            let item = this.projects.find((i) => i.id === project.id)
            item = project;
            this.projects = [...this.projects.filter((i) => i.id !== project.id), item];
        },
        REMOVE_PROJECT(project) {
            this.projects = this.projects.filter((i) => i.id !== project);
            this.total -= 1;
        },
    }
})
