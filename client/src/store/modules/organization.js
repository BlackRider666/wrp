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
            axios.get('structure-units?organization_id='+payload)
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
    editOrganization({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.get('organizations/'+payload+'/edit')
                .then(res => {
                    commit("UPDATE_ORGANIZATION", res.data.organization);
                    resolve(res.data.organization)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    updateOrganization({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('organizations/'+payload.organization_id+'/update', payload)
                .then(res => {
                    commit("UPDATE_ORGANIZATION", res.data.organization);
                    resolve(res.data.organization)
                })
                .catch(errors => {
                    reject(errors.response.data)
                })
        }))
    },
    createStructureUnit({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('structure-units/',payload)
                .then(res => {
                    commit("ADD_STRUCTURE_UNIT", res.data.unit);
                    resolve(res.data.unit)
                })
                .catch(errors => {
                    reject(errors)
                })
        }))
    },
    updateStructureUnit({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.post('structure-units/'+payload.id,payload)
                .then(res => {
                    commit("UPDATE_STRUCTURE_UNIT", res.data.unit);
                    resolve(res.data.unit)
                })
                .catch(errors => {
                    reject(errors)
                })
        }))
    },
    deleteStructureUnit({commit}, payload) {
        return new Promise(((resolve, reject) => {
            axios.delete('structure-units/'+payload.id)
                .then(res => {
                    commit("REMOVE_STRUCTURE_UNIT", payload);
                    resolve(res.data.unit)
                })
                .catch(errors => {
                    reject(errors)
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
    },
    ADD_STRUCTURE_UNIT(state, unit) {
        state.structureUnits.push(unit);
        let units = state.organization.units;
        if (unit.parent_id) {
            units = addUnitItem(units, unit);
        } else {
            units.push(unit);
        }
        state.organization.units = units;
    },
    UPDATE_STRUCTURE_UNIT(state, unit) {
        state.structureUnits = [...state.structureUnits.filter((i) => i.id !== unit.id), unit];
        let units = state.organization.units;
        if (unit.parent_id) {
            units = updateUnitItem(units, unit);
        } else {
            units = [...units.filter((i) => i.id !== unit.id), unit];
        }
        state.organization.units = units;
    },
    REMOVE_STRUCTURE_UNIT(state, unit) {
        state.structureUnits.filter((i) => i.id !== unit.id);
        let units = state.organization.units;
        if (unit.parent_id) {
            units = removeUnitItem(units, unit);
        } else {
            units = units.filter((i) => i.id !== unit.id);
        }
        state.organization.units = units;
    }
};

function addUnitItem(arr,item) {
    arr.forEach(i => {
        if(i.id === item.parent_id) {
            i.child = [...i.child, item]
        } else {
            addUnitItem(i.child,item)
        }
    });
    return arr;
}

function updateUnitItem(arr,item) {
    arr.forEach(i => {
        if(i.id === item.parent_id) {
            i.child = [...i.child.filter((i) => i.id !== item.id), item]
        } else {
            updateUnitItem(i.child,item)
        }
    });
    return arr;
}

function removeUnitItem(arr, item) {
    arr.forEach(i => {
        if(i.id === item.parent_id) {
            i.child = i.child.filter((it) => it.id !== item.id);
        } else {
            removeUnitItem(i.child,item)
        }
    });
    return arr;
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
