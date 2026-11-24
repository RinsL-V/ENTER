// Базовый URL API сервера.
// Можно переопределить через переменную окружения VITE_API_URL (файл .env).
export const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'

// Заголовки авторизации для защищённых запросов
export function authHeaders() {
  const token = localStorage.getItem('auth_token')
  return {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    ...(token ? { 'Authorization': `Bearer ${token}` } : {}),
  }
}
