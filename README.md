# 💬 Chat Application - CodeIgniter 4 + PostgreSQL

A simple chat application built with **CodeIgniter 4** and **PostgreSQL**. The application should allow users to sign up, log in, view a list of other registered users, and exchange messages with them.

Tech Stack:
- Backend: PHP with CodeIgniter framework 
- Database: PostgreSQL 
- Frontend: HTML, CSS, JavaScript (vanilla JS; no libraries like jQuery unless necessary 
for AJAX) 
- SQL: For database queries 

For chat functionality, implemented a polling mechanism using 
AJAX to fetch new messages periodically (e.g., every 5-10 seconds). 
---

## 📋 Table of Contents
- [Install Dependencies](#install-dependencies)
- [Database Setup](#database-setup)
- [Environment Configuration](#environment-configuration)
- [Running the Application](#running-the-application)
- [Assumptions](#assumptions)
- [Project Structure](#project-structure)
- [Git Setup](#git-setup)

---

## ⚙️ Install Dependencies

1. **Clone the repository**
```
git clone <repo-url>
cd chit-chat
```

2. **Install PHP dependencies via Composer**
```composer install```

👉 Ensure you have **PHP >= 8.1** and **Composer** installed.  

---

## 🗄️ Database Setup

1. **Create a PostgreSQL database**
```
psql -U postgres
CREATE DATABASE chit_chat;
\q
```

2. **Import the database schema**
```
psql -U postgres -d chit_chat -f sql/create_schema.sql
```

---

## ⚡ Environment Configuration

1. Copy environment template
```
cp env .env
```

2. Update your database credentials in `.env`:
```
database.default.hostname = localhost
database.default.database = chit_chat
database.default.username = postgres
database.default.password = your_password
database.default.DBDriver = Postgre
database.default.port = 5432
```
> ✅ Note: `.env` is ignored by Git to keep sensitive credentials private.

---

## ▶️ Running the Application

1. **Using PHP built-in server**
```
php spark serve
```
For Testing the Chatting Functionality:
- Run Application on two separate browsers or one browser with two different windows (normal and incognito).
- Login with different users in both cases.

---

Open in browser: [http://localhost:8080]
---

## 🔐 Assumptions

- Passwords should be stored **hashed (bcrypt)** in production.
- Database credentials are loaded via `.env`.
- The app runs on **localhost:8080** by default.
- Update `.env` when deploying to production.
- Frontend assets (HTML/CSS/JS) are placed inside `public/`.
- Default **CodeIgniter 4 structure** is used.

---

## 📂 Project Structure
```
chit-chat/
├── app/ # CodeIgniter controllers, models, views
├── public/ # Frontend assets, index.php
├── writable/ # Logs, cache, session files
├── env # Environment template (rename to .env)
├── sql/
│ ├── create_schema.sql # PostgreSQL schema
├── composer.json
├── README.md
├── .gitignore
└── vendor/ # Composer dependencies (ignored in git)
```
---

## 🌱 Git Setup

1. Initialize git repository:

```
git init
```

2. Add and commit files:

```
git add .
git commit -m "Initial commit: CodeIgniter4 chat app setup"
```

3. Add remote and push:

```
git branch -M main
git remote add origin <repo-url>
git push -u origin main
```
