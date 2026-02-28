# 🏦 NovaBank

> A modern full-stack banking web application built with Laravel — featuring account management, balance tracking, and transaction handling in a clean, responsive dashboard interface.

---

## ✨ Features

- 🔐 **User Authentication** — Secure login and registration
- 📊 **Dashboard** — Balance overview with account summaries at a glance
- 🏧 **Account Management** — Create and manage multiple bank accounts
- 💸 **Transaction Tracking** — Full deposit, withdrawal, and transfer history
- 📱 **Responsive UI** — Optimized for desktop and mobile
- ⚡ **Modern Asset Building** — Powered by Vite for fast frontend tooling
- 🗄️ **MySQL Integration** — Schema managed via Laravel migrations

---

## 🛠️ Tech Stack

### Backend
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white)

- **Laravel** — PHP web framework
- **PHP** — Server-side logic
- **MySQL** — Relational database

### Frontend
![Blade](https://img.shields.io/badge/Blade-FF2D20?style=flat&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=flat&logo=tailwind-css&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-646CFF?style=flat&logo=vite&logoColor=white)

- **Blade** — Laravel's HTML templating engine
- **Tailwind CSS** — Utility-first CSS framework
- **Vite** — Fast build tool and dev server

### Environment
- **WSL Ubuntu** — Windows Subsystem for Linux
- **Node.js** — JavaScript runtime for frontend tooling
- **Composer** — PHP dependency manager

---

## 🚀 Installation

### Prerequisites

Make sure you have the following installed:

- PHP >= 8.3
- Composer
- Node.js & npm
- MySQL
- Git

### Steps

**1. Clone the repository**

```bash
git clone https://github.com/shaanchristina1442-dev/novabank.git
cd novabank
```

**2. Install PHP dependencies**

```bash
composer install
```

**3. Install Node dependencies**

```bash
npm install
```

**4. Set up your environment file**

```bash
cp .env.example .env
php artisan key:generate
```

**5. Configure your database**

Open `.env` and update the following values:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=novabank
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

**6. Run migrations**

```bash
php artisan migrate
```

**7. Build frontend assets**

```bash
npm run dev
```

**8. Start the development server**

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## 📁 Project Structure

```
novabank/
├── app/
│   ├── Http/Controllers/     # Dashboard, Account, Transaction controllers
│   └── Models/               # User, Account, Transaction models
├── database/
│   └── migrations/           # Laravel schema migrations
├── resources/
│   └── views/
│       ├── layouts/          # Base app layout (app.blade.php)
│       ├── dashboard.blade.php
│       └── accounts/         # Account index and show views
├── routes/
│   └── web.php               # Application routes
├── public/
│   └── css/                  # Compiled stylesheets
└── vite.config.js
```

---

## 📸 Screenshots

> _Coming soon_

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

1. Fork the repository
2. Create your feature branch: `git checkout -b feature/my-feature`
3. Commit your changes: `git commit -m 'Add my feature'`
4. Push to the branch: `git push origin feature/my-feature`
5. Open a pull request

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

---

<p align="center">Built with ❤️ using Laravel</p>


