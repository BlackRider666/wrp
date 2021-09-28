import axios from "axios";

const state = {
    organizations: [],
    structureUnits: [],
};

const getters = {
    getOrganizations: (state) => state.organizations,
    getStructureUnits: (state) => state.structureUnits,
};

const actions = {
    downloadOrganizations({commit}) {
        return new Promise(((resolve, reject) => {
            axios.get('organizations')
                .then(res => {
                    commit("UPDATE_ORGANIZATIONS", res.data.data);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    downloadStructureUnits({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.get('organizations/structureUnits?organization_id='+payload.id)
                .then(res => {
                    commit("UPDATE_STRUCTURE_UNITS", res.data.data);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
};

const mutations = {
    UPDATE_ORGANIZATIONS (state, organizations) {
        state.organizations = organizations
    },
    UPDATE_STRUCTURE_UNITS (state, structureUnits) {
        state.structureUnits = structureUnits
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}