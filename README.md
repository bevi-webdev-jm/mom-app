# MOM App (Minutes of Meeting)

<!-- Optional: Add badges here (e.g., build status, code coverage, license) -->
<!-- Example: [![Build Status](https://travis-ci.org/user/repo.svg?branch=master)](https://travis-ci.org/user/repo) -->
<!-- Example: [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT) -->
<!-- Example: [![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-8892BF.svg)](https://php.net/) -->
<!-- Example: [![Laravel Version](https://img.shields.io/badge/laravel-10.x-FF2D20.svg)](https://laravel.com/) -->

## Description

MOM App is a comprehensive solution designed to streamline the process of recording and managing Minutes of Meetings (MOM). It addresses the common challenge of disorganized meeting notes and forgotten action items by providing a centralized platform to document discussions, decisions, and assignable tasks.

The core functionality revolves around creating detailed meeting records, extracting actionable tasks with clear ownership and deadlines, and ensuring accountability through timely email or in-app notifications for target dates.

This application is ideal for teams, project managers, and any professional who needs an efficient way to track meeting outcomes and ensure follow-through on commitments.

---

## Features

List the key features and functionalities of your application.

-   **Meeting Recording:**
    -   Create and manage meeting entries with details like title, date, time, location, and attendees.
    -   Document discussion points, key decisions, and important notes.
    -   Option to attach relevant files or documents to meeting records.
-   **Task Management:**
    -   Create tasks directly from meeting minutes, linking them to specific discussion points or decisions.
    -   Assign tasks to individuals with clear responsibilities.
    -   Set due dates and priorities for each task.
    -   Track task status (e.g., To Do, In Progress, Completed).
-   **Target Date Notifications:**
    -   Receive automated email (and/or in-app) notifications for upcoming task deadlines.
    -   Get alerts for overdue tasks to ensure timely completion.
    -   Users can (potentially) configure their notification preferences.
-   **User Management:** (Assuming standard functionality)
    -   User registration, login, and password reset.
    -   Profile management.
-   **Search & Filtering:** (Potential desirable features)
    -   Easily search for past meetings or tasks.
    -   Filter meetings by date, attendees, or keywords.
    -   Filter tasks by assignee, status, or due date.

<!-- This is a crucial section to showcase your system's capabilities. -->

## Tech Stack

List the major technologies, frameworks, libraries, and tools used to build your application.

-   **Backend:** PHP, Laravel Framework
-   **Frontend:** HTML, CSS, JavaScript (likely using Blade templates, potentially with Vite for asset bundling)
-   **Database:** MySQL
-   **Development Tools:** Composer, Node.js/NPM (for Vite), Vite
-   **Mail:** SMTP (e.g., Mailpit for local development)
-   **Testing:** PHPUnit
-   ...and any other significant tools.

---

## Prerequisites

Before you begin, ensure you have met the following requirements:

-   PHP (e.g., ^8.1 - check your `composer.json`)
-   Composer (latest version recommended)
-   Node.js (e.g., ^18.0 or ^20.0 - check your `package.json`) and npm
-   MySQL (or compatible database server)
-   A web server (like Nginx or Apache), or you can use Laravel's built-in server (`php artisan serve`)

---

## Installation

Provide step-by-step instructions on how to get a development environment running.

1.  Clone the repository: `git clone https://github.com/your_username/your_project_name.git`
2.  Navigate to the project directory: `cd your_project_name`
3.  Install PHP dependencies:
    ```bash
    composer install
    ```
4.  Install JavaScript dependencies:
    ```bash
    npm install
    ```
5.  Create a copy of the `.env.example` file and name it `.env`:
    ```bash
    cp .env.example .env
    ```
6.  Generate an application key:
    ```bash
    php artisan key:generate
    ```
7.  Configure your database and other environment variables in the `.env` file (see Configuration section).
8.  Run database migrations (and optionally, seeders):
    ```bash
    php artisan migrate
    # php artisan db:seed (if you have seeders)
    ```
9.  Build frontend assets:
    ```bash
    npm run dev
    ```

---

Explain any necessary configuration before running the application. This might include environment variables, configuration files, etc.

-   Create a `.env` file by copying `.env.example`: `cp .env.example .env`
-   Update the `.env` file with your specific settings. Key variables include:
    -   `APP_NAME="MOM App"`
    -   `APP_ENV=local`
    -   `APP_DEBUG=true`
    -   `APP_URL=http://localhost:8000` (or your preferred local URL)
    -   `DB_CONNECTION=mysql`
    -   `DB_HOST=127.0.0.1`
    -   `DB_PORT=3306`
    -   `DB_DATABASE=mom_app_db` (replace with your database name)
    -   `DB_USERNAME=root` (replace with your database username)
    -   `DB_PASSWORD=` (replace with your database password)
    -   `MAIL_MAILER=smtp`
    -   `MAIL_HOST=mailpit` (or your SMTP server, e.g., `smtp.mailtrap.io`)
    -   `MAIL_PORT=1025` (Mailpit default)
    -   `MAIL_USERNAME=null`
    -   `MAIL_PASSWORD=null`
    -   `MAIL_FROM_ADDRESS="hello@example.com"`
    -   `MAIL_FROM_NAME="${APP_NAME}"`

---

## Usage

## How do users run and interact with your application? Provide clear instructions and examples.

--->

1.  Start the development server:
    ```bash
    php artisan serve
    ```
2.  In a separate terminal, compile frontend assets and watch for changes (if using Vite):
    ```bash
    npm run dev
    ```
3.  Open your browser and navigate to `http://localhost:8000` (or the `APP_URL` you configured).

**Common Workflows:**

-   **User Registration/Login:** Access the system by creating an account or logging in.
-   **Creating a Meeting:** Navigate to the meetings section, create a new meeting entry, fill in details (title, date, attendees), and add discussion points and decisions.
-   **Assigning Tasks:** From a meeting's details, identify action items and create tasks. Assign these tasks to users and set due dates.
-   **Tracking Tasks:** Users can view their assigned tasks, update their status, and mark them as complete.
-   **Receiving Notifications:** The system will send reminders for upcoming or overdue tasks.

---

Explain how to run any automated tests included with the project.

Ensure your `.env` file has the test database configured (e.g., `DB_DATABASE_TEST`). It's recommended to use a separate database for testing.

```bash
php artisan test
```
