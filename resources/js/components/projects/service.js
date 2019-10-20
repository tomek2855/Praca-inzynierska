import DataService from '../../dataService'

class Service extends DataService {

    name() {
        return 'projects'
    }

    getUserList(projectId, params = null) {
        return window.axios(this.path() + projectId + "/userList", params);
    }

}

export default new Service()