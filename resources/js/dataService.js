class DataService {

    basePath() {
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
            return window.axios.update(this.path() + elem.id, elem)
        } else {
            return window.axios.post(this.path(), elem)
        }
    }

    delete(elem) {
        return window.axios.delete(elem.id)
    }
}

export default DataService