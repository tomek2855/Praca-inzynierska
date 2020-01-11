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

    uploadFile(id, file, params) {
        let formData = new FormData()
        formData.append('file', file)
        formData.append('isPublic', params.isPublic)

        return window.axios.post(this.basePath() + "issues/" + id + "/file", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        })
    }
}

export default new Service()
