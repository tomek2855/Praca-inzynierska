import VueRouter from "vue-router";

import HomeComponent from './components/HomeComponent'
import LoginComponent from './components/auth/LoginComponent'
import LogoutComponent from './components/auth/LogoutComponent'
import ProjectsListComponent from './components/projects/ProjectsListComponent'
import ProjectComponent from './components/projects/ProjectComponent'
import ProjectAddComponent from './components/projects/ProjectAddComponent'
import IssuesListComponent from './components/issues/IssuesListComponent'
import IssueComponent from './components/issues/IssueComponent'
import ProjectIssuesListComponent from './components/issues/ProjectIssuesListComponent'
import IssueAddComponent from './components/issues/IssueAddComponent'
import ProjectEditComponent from './components/projects/ProjectEditComponent'
import UsersListComponent from './components/admin/UsersListComponent'
import UserComponent from './components/admin/UserComponent'
import UserAddComponent from './components/admin/UserAddComponent'
import IssueFilesComponent from './components/issues/IssueFilesComponent'
import FilesListComponent from './components/FilesListComponent'

import AuthService from './components/auth/service'
import ProjectsService from './components/projects/service'
import IssuesService from './components/issues/service'
import CommentsService from './components/comments/service'
import AdminService from './components/admin/service'

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
            path: "/projects/add",
            name: "projects.add",
            component: ProjectAddComponent,
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
            path: "/issues",
            name: "issues.user",
            component: IssuesListComponent,
            props: {
                service: IssuesService
            }
        },
        {
            path: "/projects/:projectId/issues",
            name: "projects.issues",
            component: ProjectIssuesListComponent,
            props: {
                service: IssuesService
            }
        },
        {
            path: "/projects/:projectId/issues/add",
            name: "projects.issues.add",
            component: IssueAddComponent,
            props: {
                service: IssuesService
            }
        },
        {
            path: "/projects/:projectId/edit",
            name: "projects.edit",
            component: ProjectEditComponent,
            props: {
                service: ProjectsService
            }
        },
        {
            path: "/projects/:projectId/issues/edit/:id",
            name: "projects.issues.edit",
            component: IssueAddComponent,
            props: {
                service: IssuesService
            }
        },
        {
            path: "/projects/:projectId/issues/:id",
            name: "issues.show",
            component: IssueComponent,
            props: {
                service: IssuesService,
                projectService: ProjectsService,
                commentsService: CommentsService,
            }
        },
        {
            path: "/issues/:issueId/files",
            name: "issues.files",
            component: IssueFilesComponent,
            props: {
                service: IssuesService,
            }
        },
        {
            path: "/admin/users",
            name: "admin.users",
            component: UsersListComponent,
            props: {
                service: AdminService
            }
        },
        {
            path: "/admin/users/add",
            name: "admin.users.add",
            component: UserAddComponent,
            props: {
                service: AdminService
            }
        },
        {
            path: "/admin/users/:id",
            name: "admin.users.show",
            component: UserComponent,
            props: {
                service: AdminService
            }
        },
        {
            path: "/admin/users/:id/edit",
            name: "admin.users.edit",
            component: UserAddComponent,
            props: {
                service: AdminService
            }
        }
    ]
})
