import VueRouter from "vue-router";

import HomeComponent from './components/HomeComponent'
import ProjectsListComponent from './components/projects/ProjectsListComponent'
import ProjectComponent from './components/projects/ProjectComponent'
import ProjectAddComponent from './components/projects/ProjectAddComponent'

import ProjectsService from './components/projects/service'

window.router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: HomeComponent
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