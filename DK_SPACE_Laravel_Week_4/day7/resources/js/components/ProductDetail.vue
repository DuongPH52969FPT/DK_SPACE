<template>
  <div class="product-detail-wrapper">
    <div class="product-card" v-if="product">
      <button class="back-button" @click="$router.push('/')">
        ← Quay lại danh sách
      </button>

      <h2 class="product-name">{{ product.name }}</h2>

      <div class="image-section" v-if="product.image_url">
        <img :src="product.image_url" alt="Product image" />
      </div>

      <p class="description">
        <strong>Mô tả:</strong> {{ product.description || 'Không có mô tả.' }}
      </p>

      <p class="price">
        <strong>Giá:</strong> {{ formatPrice(product.price) }} ₫
      </p>
    </div>

    <div v-else-if="error" class="error-message">
      {{ error }}
    </div>

    <div v-else class="loading">Đang tải chi tiết sản phẩm...</div>
  </div>
</template>

<script>
import api from '../axios';

export default {
  data() {
    return {
      product: null,
      loading: true,
      error: null,
    };
  },
  async created() {
    const id = this.$route.params.id;
    try {
      const res = await api.get(`/products/${id}`);
      this.product = res.data;
    } catch (err) {
      this.error = err.response?.data?.message || 'Không thể tải sản phẩm.';
    } finally {
      this.loading = false;
    }
  },
  methods: {
    formatPrice(value) {
      return parseFloat(value).toLocaleString('vi-VN');
    },
  },
};
</script>

<style scoped>
.product-detail-wrapper {
  max-width: 700px;
  margin: 40px auto;
  padding: 20px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #333;
}

.back-button {
  background-color: #e0e0e0;
  color: #333;
  border: none;
  padding: 10px 16px;
  font-size: 16px;
  margin-bottom: 20px;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.back-button:hover {
  background-color: #cfcfcf;
}

.product-card {
  background-color: #fff;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.product-name {
  font-size: 28px;
  margin-bottom: 16px;
  color: #222;
}

.image-section img {
  max-width: 100%;
  max-height: 350px;
  object-fit: contain;
  border-radius: 8px;
  box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
  margin-bottom: 20px;
}

.description,
.price {
  font-size: 18px;
  margin: 10px 0;
  color: #555;
}

.error-message {
  color: #d32f2f;
  text-align: center;
  font-size: 18px;
  font-weight: bold;
}

.loading {
  text-align: center;
  font-size: 18px;
  color: #777;
}
</style>
