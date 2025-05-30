<template>
  <div class="product-list-container">
    <h2 class="title">Product List</h2>

    <div class="top-buttons">
      <router-link to="/products/create" class="btn-add-product">
        Add Product
      </router-link>

      <!-- Nút login mới -->
      <router-link to="/login" class="btn-login">
        Login
      </router-link>
    </div>

    <ul class="product-list">
      <li v-for="product in products" :key="product.id" class="product-item">
        <strong>{{ product.name }}</strong>
        <div class="product-actions">
          <router-link :to="`/products/${product.id}`" class="btn-view">View</router-link>
          <router-link :to="`/products/${product.id}/edit`" class="btn-edit">Edit</router-link>
          <button @click="deleteProduct(product.id)" class="btn-delete">Delete</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
// giữ nguyên
import api from '../axios';

export default {
  data() {
    return {
      products: [],
    };
  },
  async mounted() {
    await this.fetchProducts();
  },
  methods: {
    async fetchProducts() {
      try {
        const res = await api.get('/products');
        this.products = res.data.data || res.data;
      } catch (error) {
        console.error('Fetch products error:', error.response || error);
      }
    },
    async deleteProduct(id) {
      if (confirm('Are you sure you want to delete this product?')) {
        try {
          await api.delete(`/products/${id}`);
          this.products = this.products.filter(p => p.id !== id);
        } catch (err) {
          alert('Failed to delete product.');
        }
      }
    },
  },
};
</script>

<style scoped>
.product-list-container {
  max-width: 700px;
  margin: 30px auto;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.title {
  margin-bottom: 20px;
  text-align: center;
  color: #333;
}

/* Bao quanh 2 nút phía trên */
.top-buttons {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
  justify-content: center;
}

/* Nút add product giữ nguyên */
.btn-add-product {
  display: inline-block;
  padding: 10px 16px;
  background-color: #28a745;
  color: white;
  font-weight: 600;
  border-radius: 4px;
  text-decoration: none;
}

.btn-add-product:hover {
  background-color: #218838;
}

/* Nút login mới */
.btn-login {
  display: inline-block;
  padding: 10px 16px;
  background-color: #007bff;
  color: white;
  font-weight: 600;
  border-radius: 4px;
  text-decoration: none;
}

.btn-login:hover {
  background-color: #0056b3;
}

.product-list {
  list-style-type: none;
  padding: 0;
}

.product-item {
  padding: 12px 15px;
  background: white;
  margin-bottom: 12px;
  border-radius: 4px;
  border: 1px solid #ddd;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.product-actions > * {
  margin-left: 8px;
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  font-size: 14px;
  text-decoration: none;
  cursor: pointer;
  color: white;
}

.btn-view {
  background-color: #17a2b8;
}

.btn-view:hover {
  background-color: #138496;
}

.btn-edit {
  background-color: #007bff;
}

.btn-edit:hover {
  background-color: #0056b3;
}

.btn-delete {
  background-color: #dc3545;
}

.btn-delete:hover {
  background-color: #c82333;
}
</style>
