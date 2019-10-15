import VueRouter from "vue-router";

import HomeComponent from './components/HomeComponent'
import LoginComponent from './components/auth/LoginComponent'
import LogoutComponent from './components/auth/LogoutComponent'
import ProjectsListComponent from './components/projects/ProjectsListComponent'
import ProjectComponent from './components/projects/ProjectComponent'
import ProjectAddComponent from './components/projects/ProjectAddComponent'
import IssuesListComponent from './components/issues/IssuesListComponent'
import IssueComponent from './components/issues/IssueComponent'

import AuthService from './components/auth/service'
import ProjectsService from './components/projects/service'
import IssuesService from './components/issues/service'

window.router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: HomeComponent
        },
        {
            path: "/login",
            name: "login",
            component: LoginComponent,
            props: {
                service: AuthService
            }
        },
        {
            path: "/logout",
            name: "logout",
            component: LogoutComponent,
            props: {
                service: AuthService
            }
        },
        {
            path: "/projects",
            name: "projects.index",
            component: ProjectsListComponent,
            props: {
                service: ProjectsService
            }
        },
        {
            path: "/projects/:id",
            name: "projects.show",
            component: ProjectComponent,
            props: {
                service: ProjectsService
            }
        },
        {
            path: "/projects/add",
            name: "projects.add",
            component: ProjectAddComponent,
            props: {
                service: ProjectsService
            }
        }
    ]
})