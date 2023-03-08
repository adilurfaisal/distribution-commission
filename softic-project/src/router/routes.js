
const routes = [
  {
    path: '/auth',
    component: () => import('layouts/AuthLayout.vue'),
    children: [
      {
        path: 'login', name: 'login', component: () => import('pages/LoginPage.vue')
      },
      {
        path: 'register', name: 'register', component: () => import('pages/RegisterPage.vue')
      }
    ]
  },
  {
    path: '/',
    name: `DashboardLayout`,
    component: () => import('layouts/MainLayout.vue'),
    meta: {
      requiresAuth: true
    },
    children: [
      {
        path: '', name: 'menu', component: () => import('pages/Menu.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'create-account', name: 'create-account', component: () => import('src/pages/CreateAccount.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'user-list', name: 'user-list', component: () => import('src/pages/UserList.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'add-money', name: 'add-money', component: () => import('src/pages/AddMoney.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'transactions', name: 'transactions', component: () => import('src/pages/TransactionsHistrory.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'transactions/:id', name: 'admin-transactions', component: () => import('src/pages/TransactionsHistrory.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'commission', name: 'commission', component: () => import('src/pages/Commission.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'commission/:id', name: 'admin-commission', component: () => import('src/pages/Commission.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'profile', name: 'profile', component: () => import('src/pages/Profile.vue'),
        meta: {
          requiresAuth: true
        }
      }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
