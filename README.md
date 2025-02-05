# SoloTracker Backend

This is the **PHP** backend for the **SoloTracker** app, which provides the necessary **API** for managing user authentication, expenses, and task management. The backend is designed to work seamlessly with the **Flutter** frontend, offering an efficient and secure data handling process.

## 🚀 Features

- 🔐 **User Authentication** – Secure login and registration endpoints.
- 💸 **Expense Tracking** – API endpoints for adding, updating, and retrieving expenses.
- ✅ **Task Management** – API endpoints for creating, updating, and managing tasks.
- 🛠 **RESTful API** – RESTful architecture for easy interaction with the frontend.

## 🛠 Tech Stack

- **Backend Language:** PHP
- **Database:** MySQL
- **API Format:** REST
- **Web Server:** Apache (via XAMPP)

## 🌐 API Endpoints

### Authentication

- **POST** `/api/register` - Register a new user.
- **POST** `/api/login` - Log in.
- **POST** `/api/logout` - Log out the user.

### Expenses

- **GET** `/api/expenses` - Get all expenses.
- **POST** `/api/expenses` - Add a new expense.
- **PUT** `/api/expenses/{id}` - Update an expense.
- **DELETE** `/api/expenses/{id}` - Delete an expense.

### Tasks

- **GET** `/api/tasks` - Get all tasks.
- **POST** `/api/tasks` - Create a new task.
- **PUT** `/api/tasks/{id}` - Update an existing task.
- **DELETE** `/api/tasks/{id}` - Delete a task.

## 🔧 Setup Instructions

### Prerequisites

1. Install **XAMPP** (which includes PHP, MySQL, and Apache).
2. Set up **MySQL** and **Apache** using XAMPP.

### Installation

1. Clone this repository:
   ```sh
   git clone https://github.com/yourusername/solo-tracker-backend.git
   cd solo-tracker-backend
