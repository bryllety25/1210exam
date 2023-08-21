import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', redirect: '/login' },
    {
      path: '/',
      component: () => import('../layouts/default.vue'),
      children: [
        {
          path: 'task',
          component: () => import('../pages/task/task.vue'), 
          meta: {
            requiresAuth: true
          }
        },
      ],
    },
    {
      path: '/',
      component: () => import('../layouts/blank.vue'),
      
      children: [
        {
          path: 'login',
          component: () => import('../pages/login.vue'),
        },
        {
          path: 'register',
          component: () => import('../pages/register.vue'),
        },
        {
          path: '/:pathMatch(.*)*',
          component: () => import('../pages/[...all].vue'),
        },
      ],
    },
  ],
})

router.beforeEach((to, from, next) => {
  const $cookies = inject('$cookies');
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!$cookies.get('authorization')) {
      next({ path: '/login' })
    } else {
      next() 
    }
  } else {

    if ($cookies.get('authorization')) {
      next({ path: '/task' })
    } else {
      next() 
    }
  }
})

export default router
