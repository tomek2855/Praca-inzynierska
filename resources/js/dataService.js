class DataService {

    basePath() {
        this.checkForToken()
        return "/api/"
    }

    name() {
        return ""
    }

    path() {
        return this.basePath() + this.name() + "/"
    }

    get(params = null) {
        return window.axios.get(this.path(), params)
    }

    show(id, params) {
        return window.axios.get(this.path() + id, params)
    }

    save(elem) {
        if (elem.id) {
            return window.axios.put(this.path() + elem.id, elem)
        } else {
            return window.axios.post(this.path(), elem)
        }
    }

    delete(elem) {
        return window.axios.delete(this.path() + elem.id)
    }

    checkForToken() {
        if (localStorage.getItem("token")) {
            window.axios.interceptors.request.use(
                (config) => {
                    config.headers['Authorization'] = `Bearer ${ localStorage.token }`
                    return config
                }, (error) => {console.log(error)}
            )
        }
    }

    getUser() {
        return window.axios.get(this.basePath() + "user")
    }

    uploadFile(file, params) {
        let formData = new FormData()
        formData.append('file', file)
        formData.append('isPublic', params.isPublic)

        return window.axios.post(this.basePath() + "files", formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        })
    }

    downloadFile(fileId) {
        this.checkForToken()

        return window.axios.get('/files/' + fileId).then(response => {
            const blob = new Blob([response.data], { type: response.headers['content-type'] })
            let link = document.createElement('a')
            link.href = window.URL.createObjectURL(blob)
            link.download = response.headers.filename
            link.click()
        })
    }
}

export default DataService