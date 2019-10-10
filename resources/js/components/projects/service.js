import DataService from '../../dataService'

class Service extends DataService {

    name() {
        return 'projects'
    }

}

export default new Service()