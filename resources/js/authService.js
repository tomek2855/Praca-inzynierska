class AuthService {

    basePath() {
        return "/api/"
    }

    path(name) {
        return this.basePath() + name + "/"
    }

    login(params = null) {
        return window.axios.post(this.path("login"), params)
    }

    logout() {
        if (localStorage.getItem("token")) {
            window.axios.interceptors.request.use(
                (config) => {
                    config.headers['Authorization'] = `Bearer ${ localStorage.token }`
                    return config
                }, (error) => {console.log(error)}
            )

            return window.axios.post(this.path("logout"))
        }
    }

}

export default AuthService