import {createRouter, createWebHistory} from 'vue-router'
import Auth from "@/auth/Auth";
import CarList from "@/views/CarList";
import CarForm from "@/views/CarForm";
import Dashboard from "@/views/Dashboard";
import History from "@/views/History";

const routes = [
    {
        path: '/auth',
        name: 'Auth',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: Auth
    },
    {
        path: '/car-list',
        name: 'CarList',
        component: CarList
    },
    {
        path: '/car-form',
        name: 'CarForm',
        component: CarForm
    },
    {
        path: '/car-form/:id?',
        name: 'CarForm',
        component: CarForm
    },
    {
        path: '/',
        name: 'Dashboard',
        component: Dashboard
    },
    {
        path: '/history',
        name: 'History',
        component: History
    }
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

export default router
