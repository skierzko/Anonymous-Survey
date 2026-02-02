import axios from 'axios';

export const login = axios.create({
  baseURL: '/login',
  withCredentials: true,
});