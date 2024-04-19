import axios from "axios";
import {defineStore} from "pinia";


export const useOrganizationStore = defineStore('organization',{
    state:() =>  ({
        organizations: [],
        structureUnits: [],
        organization: null,
    }),
    getters: {
        getOrganizations: (state) => state.organizations,
        getStructureUnits: (state) => state.structureUnits,
    },
    actions: {
        downloadOrganizations(payload) {
            return new Promise(((resolve, reject) => {
                let perPage = payload && payload.perPage?payload.perPage:10;
                let search = `perPage=${perPage}`;
                axios.get('organizations?'+search)
                    .then(res => {
                        this.UPDATE_ORGANIZATIONS(res.data.data);
                        resolve(res.data.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        downloadStructureUnits(payload) {
            return new Promise(((resolve, reject) => {
                axios.get('structure-units?organization_id='+payload)
                    .then(res => {
                        this.UPDATE_STRUCTURE_UNITS(res.data.data);
                        resolve(res.data.data)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        getOrganization(payload) {
            return new Promise(((resolve, reject) => {
                axios.get('organizations/'+payload)
                    .then(res => {
                        this.UPDATE_ORGANIZATION(res.data.organization);
                        resolve(res.data.organization)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        editOrganization(payload) {
            return new Promise(((resolve, reject) => {
                axios.get('organizations/'+payload+'/edit')
                    .then(res => {
                        this.UPDATE_ORGANIZATION(res.data.organization);
                        resolve(res.data.organization)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        updateOrganization(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('organizations/'+payload.organization_id+'/update', payload)
                    .then(res => {
                        this.UPDATE_ORGANIZATION(res.data.organization);
                        resolve(res.data.organization)
                    })
                    .catch(errors => {
                        reject(errors.response.data)
                    })
            }))
        },
        createStructureUnit(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('structure-units/',payload)
                    .then(res => {
                        this.ADD_STRUCTURE_UNIT(res.data.unit);
                        resolve(res.data.unit)
                    })
                    .catch(errors => {
                        reject(errors)
                    })
            }))
        },
        updateStructureUnit(payload) {
            return new Promise(((resolve, reject) => {
                axios.post('structure-units/'+payload.id,payload)
                    .then(res => {
                        this.UPDATE_STRUCTURE_UNIT(res.data.unit);
                        resolve(res.data.unit)
                    })
                    .catch(errors => {
                        reject(errors)
                    })
            }))
        },
        deleteStructureUnit(payload) {
            return new Promise(((resolve, reject) => {
                axios.delete('structure-units/'+payload.id)
                    .then(res => {
                        this.REMOVE_STRUCTURE_UNIT(payload);
                        resolve(res.data.unit)
                    })
                    .catch(errors => {
                        reject(errors)
                    })
            }))
        },
        clearStructureUnits() {
            this.structureUnits = [];
        },
        UPDATE_ORGANIZATIONS (organizations) {
            this.organizations = organizations
        },
        UPDATE_STRUCTURE_UNITS (structureUnits) {
            this.structureUnits = structureUnits
        },
        UPDATE_ORGANIZATION(organization) {
            this.organization = organization;
        },
        ADD_STRUCTURE_UNIT(unit) {
            this.structureUnits.push(unit);
            let units = this.organization.units;
            if (unit.parent_id) {
                units = addUnitItem(units, unit);
            } else {
                units.push(unit);
            }
            this.organization.units = units;
        },
        UPDATE_STRUCTURE_UNIT(unit) {
            this.structureUnits = [...this.structureUnits.filter((i) => i.id !== unit.id), unit];
            let units = this.organization.units;
            if (unit.parent_id) {
                units = updateUnitItem(units, unit);
            } else {
                units = [...units.filter((i) => i.id !== unit.id), unit];
            }
            this.organization.units = units;
        },
        REMOVE_STRUCTURE_UNIT(unit) {
            this.structureUnits.filter((i) => i.id !== unit.id);
            let units = this.organization.units;
            if (unit.parent_id) {
                units = removeUnitItem(units, unit);
            } else {
                units = units.filter((i) => i.id !== unit.id);
            }
            this.organization.units = units;
        }
    }
})
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
