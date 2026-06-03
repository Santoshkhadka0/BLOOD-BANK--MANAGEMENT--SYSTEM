# 🩸 Blood Bank Management System

OOP / Web Programming Final Project — PHP & MySQL Based Blood Bank Management System

---

## 📖 Project Overview

The Blood Bank Management System is a web-based blood donation and inventory management application developed using PHP, MySQL, HTML, CSS, and JavaScript.

The system allows administrators and users to efficiently manage blood donors, receivers, blood stock, and blood requests through a centralized platform.

The application helps improve blood bank operations by maintaining accurate records, monitoring blood inventory, and processing blood requests securely and efficiently.

---

## ✨ Features

➕ Add and manage donors

➕ Add and manage receivers

🩸 Manage blood inventory

📅 Submit blood requests

✅ Approve blood requests

❌ Cancel blood requests

📋 View blood request history

👤 User registration and login

👨‍💼 Admin dashboard and management

🔒 Secure session-based authentication

🔑 Password recovery functionality

💾 Database-driven record management

---

## 🧠 Concepts Used

| Concept               | Implementation                                        |
| --------------------- | ----------------------------------------------------- |
| CRUD Operations       | Create, Read, Update, Delete for donors and receivers |
| Authentication        | Admin and user login system                           |
| Session Management    | Protected admin and user access                       |
| Database Connectivity | PHP MySQL Integration                                 |
| Form Validation       | Input validation and sanitization                     |
| Prepared Statements   | SQL Injection Prevention                              |
| Authorization         | Role-based access control                             |
| Inventory Management  | Blood stock monitoring and updates                    |

---

## 👥 Team Members And Responsibilities

| No. | Name            | Role                               | Main Responsibility                                                                                                               |
| --- | --------------- | ---------------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| 1   | KARKI ABISHEK   | Team Leader                        | Project leadership, GitHub setup, admin authentication, dashboard integration, project coordination, final testing and deployment |
| 2   | SHRESTHA DIWASH | Request Management                 | Blood request creation, approval workflow, request cancellation, request status management and stock integration                  |
| 3   | KHADKA SANTOSH  | Donor, Receiver & Stock Management | Donor CRUD, Receiver CRUD, Blood Stock CRUD, validation, stock update and inventory management                                    |
| 4   | ROSHAN DHUNGEL  | User Management                    | User registration, login/logout, profile management, user dashboard, user authentication and password recovery                    |

---

## 👑 Team Leader Contribution

### KARKI ABISHEK

Responsible for integrating all modules into one fully functional Blood Bank Management System.

### Main Contributions

* GitHub repository management
* Project architecture planning
* Admin login and authentication
* Dashboard development
* Session management
* Project integration
* Testing and debugging
* Final project review
* Documentation verification
* Pull request review and merging

---

## 📂 Project Structure

```text
bloodbank_final/
│
├── css/
│   └── style.css
│
├── donor/
│   ├── add_donor.php
│   ├── edit_donor.php
│   ├── delete_donor.php
│   ├── donor.php
│   └── view_donor.php
│
├── receiver/
│   ├── add_receiver.php
│   ├── edit_receiver.php
│   ├── delete_receiver.php
│   ├── receiver.php
│   └── view_receiver.php
│
├── requests/
│   ├── admin_requests.php
│   ├── approve_request.php
│   ├── cancel_request.php
│   ├── my_requests.php
│   └── user_request.php
│
├── stock/
│   ├── stock.php
│   └── update_stock.php
│
├── user/
│   ├── register.php
│   ├── user_login.php
│   ├── user_logout.php
│   ├── user_dashboard.php
│   └── user_profile.php
│
├── includes/
│
├── password/
│
├── qr/
│
├── bloodbank.sql
├── dashboard.php
├── login.php
├── logout.php
├── change_admin.php
└── README.md
```

---

## ⚙️ Installation And Setup

### Using XAMPP

1. Clone the repository

```bash
git clone https://github.com/Santoshkhadka0/BLOOD-BANK--MANAGEMENT--SYSTEM.git
```

2. Move the project folder to:

```text
xampp/htdocs/
```

3. Create a MySQL database

4. Import:

```text
bloodbank.sql
```

5. Start Apache and MySQL from XAMPP

6. Open:

```text
http://localhost/bloodbank_final
```

---

## 📁 Files To Upload

### Upload These

```text
README.md
bloodbank.sql
css/
donor/
receiver/
requests/
stock/
user/
includes/
password/
qr/
dashboard.php
login.php
logout.php
change_admin.php
```

### Do NOT Upload

```text
node_modules/
vendor/
.cache/
*.log
.env
```

The .gitignore file excludes unnecessary files automatically.

---

## 🌿 Suggested Git Branches

| Team Member     | Branch                       |
| --------------- | ---------------------------- |
| KARKI ABISHEK   | abishek-admin-auth-dashboard |
| SHRESTHA DIWASH | diwash-request-management    |
| KHADKA SANTOSH  | santosh-donor-receiver-stock |
| ROSHAN DHUNGEL  | roshan-user-management       |

---

## 💬 Suggested Commit Messages

### Team Leader

* Set up project structure and GitHub repository
* Add admin authentication and dashboard
* Integrate all project modules
* Finalize project documentation

### Request Management

* Add blood request submission system
* Add request approval workflow
* Add request cancellation functionality
* Connect requests with blood stock

### Donor, Receiver & Stock Management

* Add donor CRUD module
* Add receiver CRUD module
* Add blood stock management
* Add validation and duplicate checking

### User Management

* Add user registration and login
* Add user dashboard
* Add profile management functionality
* Add user password recovery

---

## 📚 Technologies Used

* PHP
* MySQL
* HTML5
* CSS3
* JavaScript
* XAMPP
* Git
* GitHub

---

## 🏁 Final Notes

This project was developed as part of the Web Programming / Database Project and demonstrates practical implementation of:

* Database-Driven Web Applications
* Authentication and Authorization
* CRUD Operations
* Inventory Management Systems
* Session Management
* Secure PHP Development
* Team Collaboration Using GitHub
* Real-World Blood Bank Management Workflows

⭐ If you like this project, give it a star on GitHub!

