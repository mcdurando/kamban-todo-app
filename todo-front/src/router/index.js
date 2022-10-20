import { createRouter, createWebHistory } from 'vue-router'
import ToDoView from '../views/ToDoView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'


const routes = [
  {
    path: '/to-do',
    name: 'toDo',
    component: ToDoView ,
    meta : {
      requiresAuth : true
    }
  },
  {
    path: '/',
    name: 'login',
    component: LoginView ,
    meta : {
      requiresAuth : false
    }
  },

  {
    path: '/register',
    name: 'register',
    component: RegisterView ,
    meta : {
      requiresAuth : false
    }
  },
  
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
  
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to) => {
  // Credential is KO
  if(to.meta.requiresAuth && !localStorage.getItem('token')){
      return { 
        name : 'login'
      }
  }
  // Credential is OK
  if(to.meta.requiresAuth == false && localStorage.getItem('token')){
     return {
       name : 'toDo'
     }
  }
})

export default router
