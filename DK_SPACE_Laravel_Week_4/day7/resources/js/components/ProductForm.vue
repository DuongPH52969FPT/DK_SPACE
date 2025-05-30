<template>
  <div class="form-container">
    <h2>{{ isEdit ? 'Edit Product' : 'Create Product' }}</h2>
    <form @submit.prevent="submitForm" class="product-form" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name">Name *</label>
        <input id="name" v-model="form.name" type="text" placeholder="Enter product name" required />
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea
          id="description"
          v-model="form.description"
          placeholder="Enter product description"
          rows="4"
        ></textarea>
      </div>

      <div class="form-group">
        <label for="price">Price *</label>
        <input
          id="price"
          v-model.number="form.price"
          type="number"
          min="0"
          placeholder="Enter product price"
          required
        />
      </div>

      <div class="form-group">
        <label for="image">Product Image</label>
        <input id="image" type="file" accept="image/*" @change="handleFileChange" />
        <div v-if="previewImage" class="image-preview">
          <img :src="previewImage" alt="Preview Image" />
        </div>
      </div>

      <button type="submit" class="btn-submit">
        {{ isEdit ? 'Update' : 'Create' }}
      </button>

      <p v-if="error" class="error-message">{{ error }}</p>
    </form>
  </div>
</template>

<script>
import api from '../axios';

export default {
  data() {
    return {
      form: {
        id: null,
        name: '',
        description: '',
        price: 0,
      },
      imageFile: null,
      previewImage: null,
      error: null,
      isEdit: false,
    };
  },
  async created() {
    const id = this.$route.params.id;
    if (id) {
      this.isEdit = true;
      try {
        const res = await api.get(`/products/${id}`);
        this.form = res.data.data || res.data;
        this.previewImage = this.form.image_url || null;
      } catch (err) {
        this.error = 'Không tìm thấy sản phẩm!';
      }
    }
  },
  methods: {
    handleFileChange(event) {
      const file = event.target.files[0];
      if (file) {
        this.imageFile = file;
        this.previewImage = URL.createObjectURL(file);
      } else {
        this.imageFile = null;
        this.previewImage = this.form.image_url || null;
      }
    },
async submitForm() {
  try {
    this.error = null;

    const formData = new FormData();
    formData.append('name', this.form.name);
    formData.append('description', this.form.description);
    formData.append('price', this.form.price);
    if (this.imageFile) {
      formData.append('image', this.imageFile);
    }

    if (this.isEdit) {
      formData.append('_method', 'PUT');
      await api.post(`/products/${this.form.id}`, formData);
    } else {
      await api.post('/products', formData);
    }

    this.$router.push('/');
  } catch (err) {
    if (err.response?.status === 422) {
      const errors = err.response.data.errors;
      this.error = Object.values(errors).flat().join(', ');
    } else {
      this.error = err.response?.data?.message || 'Lỗi khi lưu sản phẩm.';
    }
  }
}
,
  },
};
</script>

<style scoped>
.form-container {
  max-width: 480px;
  margin: 30px auto;
  padding: 20px 25px;
  background: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

h2 {
  text-align: center;
  color: #333;
  margin-bottom: 25px;
}

.product-form .form-group {
  margin-bottom: 18px;
  display: flex;
  flex-direction: column;
}

.product-form label {
  font-weight: 600;
  margin-bottom: 6px;
  color: #555;
}

.product-form input,
.product-form textarea {
  padding: 10px 12px;
  font-size: 16px;
  border: 1.8px solid #ccc;
  border-radius: 6px;
  transition: border-color 0.3s ease;
  font-family: inherit;
}

.product-form input:focus,
.product-form textarea:focus {
  outline: none;
  border-color: #3f51b5;
  box-shadow: 0 0 6px rgba(63, 81, 181, 0.4);
}

.product-form textarea {
  resize: vertical;
  min-height: 80px;
}

.btn-submit {
  width: 100%;
  background-color: #3f51b5;
  color: white;
  font-weight: 600;
  font-size: 18px;
  padding: 12px 0;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-submit:hover {
  background-color: #303f9f;
}

.error-message {
  margin-top: 15px;
  color: #d32f2f;
  font-weight: 600;
  text-align: center;
}

.image-preview {
  margin-top: 10px;
}

.image-preview img {
  max-width: 100%;
  max-height: 200px;
  border-radius: 6px;
  object-fit: contain;
}
</style>
