import DataService from '../../dataService'

class Service extends DataService {

    name() {
        return 'admin'
    }

    getUsersList(params = null) {
        return window.axios.get(this.path() + "users", params)
    }
    getUser(id) {
        return window.axios.get(this.path() + "users/" + id)
    }
    saveUser(elem) {
        if (elem.id) {
            return window.axios.put(this.path() + "users/" + elem.id, elem)
        } else {
            return window.axios.post(this.path() + "users/", elem)
        }
    }
    deleteUser(id) {
        return window.axios.delete(this.path() + "users/" + id)
    }
    generateNewPass(id) {
        return window.axios.post(this.path() + "users/" + id + "/generateNewPass");
    }

}

export default new Service()
