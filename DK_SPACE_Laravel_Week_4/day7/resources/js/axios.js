import axios from 'axios';

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // domain backend + /api prefix
  withCredentials: true,                // gửi cookie để auth
  headers: {
    Accept: 'application/json',
  },
});

export default api;
