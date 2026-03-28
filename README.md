# 🏃 University Athletics Management System — UCDB

> **Full-stack web application for managing university athletics association members.** Handles role-based authentication, member registration with photo upload, and automates the generation of digital membership cards exported directly as PDF.
<img width="525" height="905" alt="Captura de tela 2026-02-04 202457" src="https://github.com/user-attachments/assets/5ff7fc6a-522d-4458-ac87-1a8f2a5d80f8" />

[![PHP](https://img.shields.io/badge/PHP-7.0+-777BB4?style=flat&logo=php&logoColor=white)](https://php.net)
[![MVC](https://img.shields.io/badge/Architecture-MVC-gray?style=flat)]()
[![FPDF](https://img.shields.io/badge/PDF-FPDF_1.8-red?style=flat)]()
[![MySQL](https://img.shields.io/badge/Database-MySQL-4479A1?style=flat&logo=mysql&logoColor=white)]()

---

## The problem this solves

University athletics associations manage dozens to hundreds of members — athletes, board members, collaborators — and need to issue membership cards that verify each person's affiliation. Doing this manually (typing data, attaching a photo, exporting) is time-consuming and error-prone.

This system automates the full workflow: an administrator registers a member with a photo, and the system dynamically generates a ready-to-use PDF membership card with the member's data and photo embedded in the document — no manual steps required.

---

## Features

- **Role-based authentication** — distinct profiles (admin, member) with scoped access to features
- **Member management** — full CRUD for association members with photo upload
- **Automated PDF card generation** — dynamic membership cards generated via FPDF, with photo inserted directly in the document
- **Responsive web interface** — HTML, CSS, and vanilla JavaScript
- **Custom MVC architecture** — clean separation of concerns with a lightweight PHP mini-framework and centralized routing via `App\Route`

---

## Architecture

```
index.php (entry point)
    │
    └── App\Route (custom router)
            │
            ├── Controllers/     ← module logic
            ├── Models/          ← database access
            └── Views/           ← HTML/PHP templates
                    │
                    └── FPDF     ← PDF membership card generation
```

**Pattern:** MVC implemented on top of a custom PHP mini-framework with PSR-4 autoloading. No external frameworks — the routing and rendering layer is hand-built.

---

## Tech stack

| Layer | Technology |
|---|---|
| Backend | PHP 7.0+ (custom MVC) |
| Routing | Custom mini-framework (`App\Route`) |
| PDF generation | FPDF `^1.8` (setasign/fpdf) |
| Frontend | HTML, CSS, vanilla JavaScript |
| Database | MySQL |
| Autoloading | Composer PSR-4 |

---

## Project structure

```
atletica_fisioterapia_ucdb/
├── App/                    # Application code (MVC)
│   ├── Route.php           # Main router
│   ├── Controllers/        # Module controllers
│   ├── Models/             # Models and database access
│   └── Views/              # HTML/PHP templates
├── css/                    # Global styles
├── javascript/             # Frontend scripts
├── img/                    # Images and static assets
├── vendor/                 # Composer dependencies + MF mini-framework
├── index.php               # Application entry point
└── composer.json
```

---

## Getting started

### Prerequisites

- PHP 7.0+
- Composer
- MySQL
- Local web server (Apache/Nginx) or PHP built-in server

### Installation

```bash
git clone https://github.com/samuel-Mdcosta/atletica_fisioterapia_ucdb.git
cd atletica_fisioterapia_ucdb

# Install PHP dependencies
composer install
```

### Database

Create a MySQL database and import the schema. Configure the connection in the `App/` config file to match your local environment.

### Running

Point Apache/Nginx to the project root, or use PHP's built-in server:

```bash
php -S localhost:8080
```

Open `http://localhost:8080` in your browser.

---

## Context

Built as a freelance project for the **Physical Therapy Athletics Association at UCDB** (A.A.F.C.), replacing a fully manual membership card issuance process. The goal was to give non-technical administrators a simple tool: register a member, upload a photo, and get a PDF card generated instantly — no design tools, no manual data entry.

---

## Author

**Samuel M. Costa** — Full Stack Developer | PHP · Python · JavaScript · AI & LLMs

- LinkedIn: [linkedin.com/in/samuelmdcosta](https://linkedin.com/in/samuelmdcosta)
- Email: costadev19@gmail.com
- GitHub: [github.com/samuel-Mdcosta](https://github.com/samuel-Mdcosta)
