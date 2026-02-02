import axios from 'axios';

export const logout = axios.create({
  baseURL: '/logout',
  withCredentials: true,
});