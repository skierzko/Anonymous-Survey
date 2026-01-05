# Survey App

A simple survey application built with Symfony 8, Vue 3, and TypeScript. The app allows users to register, create surveys, duplicate them, and make them public. Choice-based surveys are always anonymous, but access can be public or protected with a password.

## Table of Contents

- [Features](#features)
- [Instalation](#instalation)
- [Requirements](#requirements)
- [Setup](#setup)

## Features

- User registration and authentication
- Create and manage surveys
- Duplicate existing surveys
- Public or password-protected access for surveys
- Anonymous choice-based surveys

## Instalation

### Requirements

Make sure you have the following installed on your system:

- PHP >= 8.4
- Composer | v2.8.12:2025
- Node.js | v25.2.1
- NPM | v11.6.2
- SQLite / MySQL / PostgreSQL

### Setup

1. Clone the repository:
    ```bash
    git clone https://github.com/skierzko/Survey
    cd Survey/app
2. Install backend dependencies:
    ```bash
    composer install
3. Install frontend dependencies:
    ```bash
    npm install
4. Create environment file:
    ```bash
    cp .env.dev .env
5. Database
    ```bash
    php bin/console doctrine:database:create

    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
6. Build frontend assets:
    ```bash
    npm run build
    or
    npm run dev
9. Run server:
    ```bash
    docker-compose up --build