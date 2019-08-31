import marketproductRoutes from './marketproduct'

const routes = [
  {
    path: '/',
    component: () => import('layouts/Main.vue'),
    children: [
      { name: 'dashboard', path: '/', component: () => import('pages/Dashboard.vue') },
      { name: 'actualPrices', path: '/aktualne-ceny', component: () => import('pages/ActualPrices.vue') }
    ]
  },
  ...marketproductRoutes
]

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue')
  })
}

export default routes
