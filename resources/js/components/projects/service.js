import DataService from '../../dataService'

class Service extends DataService {

    name() {
        return 'projects'
    }

    getUserList(projectId, params = null) {
        return window.axios.get(this.path() + projectId + "/userList", params)
    }

    getUsersToAdd(projectId, params = null) {
        return window.axios.get(this.path() + projectId + "/assignedUsers", params)
    }

    addUserToProject(projectId, params = null) {
        return window.axios.post(this.path() + projectId + "/assignedUsers", params)
    }

    deleteUserFromProject(projectId, params = null) {
        return window.axios.delete(this.path() + projectId + "/assignedUsers", params);
    }

}

export default new Service()