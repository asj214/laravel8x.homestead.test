import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter)

const routes = [
    {
        name: 'home',
        path: '/',
        component: () => import('./views/Home')
    },
    {
        name: 'login',
        path: '/login',
        component: () => import('./views/Login')
    },
]

const router = new VueRouter({
    hashbang: false,
    mode: 'history',
    // base: process.env.BASE_URL,
    routes
  })
  
export default router
