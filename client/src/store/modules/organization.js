import axios from "axios";

const state = {
    organizations: [],
    structureUnits: [],
    organization: null,
};

const getters = {
    getOrganizations: (state) => state.organizations,
    getStructureUnits: (state) => state.structureUnits,
};

const actions = {
    downloadOrganizations({commit},payload) {
        return new Promise(((resolve, reject) => {
            let perPage = payload && payload.perPage?payload.perPage:10;
            let search = `perPage=${perPage}`;
            axios.get('organizations?'+search)
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
            axios.get('organizations/structure-units?organization_id='+payload)
                .then(res => {
                    commit("UPDATE_STRUCTURE_UNITS", res.data.data);
                    resolve(res.data.data)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    getOrganization({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.get('organizations/'+payload)
                .then(res => {
                    commit("UPDATE_ORGANIZATION", res.data.organization);
                    resolve(res.data.organization)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    clearStructureUnits({commit}) {
        commit("CLEAR_STRUCTURE_UNITS")
    },
};

const mutations = {
    UPDATE_ORGANIZATIONS (state, organizations) {
        state.organizations = organizations
    },
    UPDATE_STRUCTURE_UNITS (state, structureUnits) {
        state.structureUnits = structureUnits
    },
    CLEAR_STRUCTURE_UNITS (state) {
        state.structureUnits = [];
    },
    UPDATE_ORGANIZATION(state, organization) {
        state.organization = organization;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
