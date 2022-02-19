import {createRouter, createWebHistory} from 'vue-router'
import Home from '../views/Home.vue'
import Auth from "@/auth/Auth";
import CarList from "@/views/CarList";
import CarForm from "@/views/CarForm";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/about',
        name: 'About',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
    },
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
    }
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

export default router
