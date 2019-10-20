import DataService from '../../dataService'

class Service extends DataService {

    name() {
        return 'issues'
    }

    getProjectIssues(projectId, params = null) {
        return window.axios.get(this.basePath() + "projects/" + projectId + "/" + this.name(), params)
    }

    addProjectIssue(projectId, params = null) {
        return window.axios.post(this.basePath() + "projects/" + projectId + "/" + this.name(), params)
    }

}

export default new Service()