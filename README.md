# Event Booking System

## Overview

A simple event booking management system that reads booking data from a JSON file, stores it in a MySQL/MariaDB database, and displays the data on a web page with filtering options. Includes features for filtering by employee name, event name, and date, and calculates the total participation fee for filtered entries.


## Requirements

- PHP 7
- MySQL / MariaDB
- Web server (e.g., Apache, Nginx)

## Setup Instructions

### 1. Database Setup

Before running the project, you **must** create a database and configure the connection settings.

1. **Create the Database:**
   - Log in to your MySQL/MariaDB server and create a new database:

2. **Configure Database Connection:**
   - Update the `connection.php` file with your database credentials:


### 2. Project Setup

1. **Clone the Repository:**
   - Clone the repository to your local machine:
     ```bash
     git clone https://github.com/jatinkumarnakrani/event-booking-system.git
     cd event-booking-system
     ```

2. **Run the Setup Script:**
   - The `setup.php` script will create the necessary tables and populate them with data from the JSON file:
     ```bash
     php setup.php
     ```

   **Note:** The database tables will be created automatically when you run the setup script.

### 3. Running the Project

1. **Place Files in Web Server Root:**
   - Ensure all project files are in your web server's root directory.

2. **Access the Application:**
   - Open your web browser and navigate to the `index.php` file, e.g., `http://localhost/event-booking-system/index.php`.

## File Descriptions

- `connection.php`: Contains database connection settings.
- `setup.php`: Script to create the database tables and insert data from the JSON file.
- `index.php`: Main script to display the data with filtering options.
- `Code Challenge (Events).json`: JSON file containing event booking data.

## Database Schema

The database consists of three tables: `employees`, `events`, and `participations`.

### Table: employees

| Column        | Type         | Constraints          |
|---------------|--------------|----------------------|
| employee_id   | INT          | AUTO_INCREMENT PRIMARY KEY |
| employee_name | VARCHAR(255) | NOT NULL             |
| employee_mail | VARCHAR(255) | UNIQUE NOT NULL      |

### Table: events

| Column     | Type         | Constraints          |
|------------|--------------|----------------------|
| event_id   | INT          | AUTO_INCREMENT PRIMARY KEY |
| event_name | VARCHAR(255) | NOT NULL             |

### Table: participations

| Column            | Type         | Constraints                              |
|-------------------|--------------|------------------------------------------|
| participation_id  | INT          | AUTO_INCREMENT PRIMARY KEY               |
| employee_id       | INT          | FOREIGN KEY (employee_id) REFERENCES employees(employee_id) |
| event_id          | INT          | FOREIGN KEY (event_id) REFERENCES events(event_id) |
| participation_fee | DECIMAL(10, 2) |                                      |
| version           | VARCHAR(255) |                                          |
| event_date        | DATETIME     |                                          |
