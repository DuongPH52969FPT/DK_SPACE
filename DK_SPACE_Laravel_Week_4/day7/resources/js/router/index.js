import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import ProductList from '../components/ProductList.vue';
import ProductDetail from '../components/ProductDetail.vue';
import ProductForm from '../components/ProductForm.vue';

const routes = [
  { path: '/login', component: Login },
  { path: '/', component: ProductList },
  { path: '/products/create', component: ProductForm },
  { path: '/products/:id', component: ProductDetail },
  { path: '/products/:id/edit', component: ProductForm },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
