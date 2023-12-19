import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue';
import CarsView from '../views/CarsView.vue';
import CustomersView from '../views/CustomersView.vue';
import RentalsView from '../views/RentalsView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: HomeView
    },
    {
      path: '/cars',
      name: 'Cars',
      component: CarsView
    },
    {
      path: '/customers',
      name: 'Customers',
      component: CustomersView
    },
    {
      path: '/rentals',
      name: 'Rentals',
      component: RentalsView
    },
    {
      path: '/car/carcreate',
      name: 'carcreate',
      component: () => import("../components/car/carcreate.vue"),
    },
    {
      path: '/customer/customercreate',
      name: 'customercreate',
      component: () => import("../components/customer/customercreate.vue"),
    },
    {
      path: '/rental/rentalcreate',
      name: 'rentalcreate',
      component: () => import("../components/rental/rentalcreate.vue"),
    },


  ]
})

export default router
