# ENTER

Веб-приложение для продажи обучающих курсов с элементами геймификации: каталог курсов представлен в виде глав цифровой книги.

Стек: **Laravel 12 + Sanctum** (backend, REST API), **Vue 3 + Vite + Tailwind CSS 4** (frontend), **MySQL** (база данных).

## Структура

- `backend/` — серверная часть (Laravel): регистрация и авторизация по токенам, каталог глав, заказы, панель администратора.
- `src/`, `public/`, `index.html` — клиентская часть (Vue 3 SPA).

## Требования

- PHP 8.2+, Composer
- Node.js 20.19+ (или 22.12+)
- MySQL 8 (или MariaDB)

## Запуск backend

```sh
cd backend
composer install
cp .env.example .env
php artisan key:generate
```

Создайте базу данных `enter` в MySQL и при необходимости поправьте `DB_USERNAME` / `DB_PASSWORD` в `.env`. Затем:

```sh
php artisan migrate --seed
php artisan serve
```

API поднимется на `http://localhost:8000`.

После `--seed` доступны демо-аккаунты:

| Роль | Email | Пароль |
|---|---|---|
| Администратор | `admin@enter.ru` | `admin123` |
| Пользователь | `user@enter.ru` | `user1234` |

## Запуск frontend

В корне репозитория:

```sh
npm install
npm run dev
```

Клиент откроется на `http://localhost:5173`. Адрес API берётся из переменной `VITE_API_URL` (по умолчанию `http://localhost:8000/api`, задаётся в `.env`).

## Основные возможности

- регистрация и авторизация (Laravel Sanctum, токены);
- каталог курсов-глав с поиском;
- карточка главы, корзина (выдвижная панель), оформление заказа;
- личный кабинет: текущие и завершённые заказы;
- панель администратора: модерация заказов (одобрение/отклонение), поиск и фильтрация.
