import DataService from '../../dataService'

class Service extends DataService {

    name() {
        return 'comments'
    }

    getIssueComments(issueId, params = null) {
        return window.axios.get(this.basePath() + "issues/" + issueId + "/" + this.name(), params)
    }

    addIssueComment(issueId, params = null) {
        return window.axios.post(this.basePath() + "issues/" + issueId + "/" + this.name(), params)
    }

}

export default new Service()