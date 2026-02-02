import axios from 'axios';

export const register = axios.create({
  baseURL: '/register',
  withCredentials: true,
});