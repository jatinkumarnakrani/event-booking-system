# Event Booking System Integration

## Task Details

**Scenario:**
Imagine an external event booking system exports a simple plain JSON export file of the newest bookings. This data should be presented in our system.

**What You Need to Do:**
- Design a database scheme for optimized storage
- Please note that over time, large amounts of data will accumulate
- Read the JSON data and save it to the database using PHP
- Create a simple page with filters for the employee name, event name, and date
- Output the filtered results in a table below the filters
- Add a last row for the total price of all filtered entries

**Environment:**
PHP 7, MySQL/MariaDB

---

This project involves integrating an external event booking system with our internal system. The integration includes importing booking data from a JSON export file and presenting it on a webpage with filtering functionality. The project is implemented using PHP 7 and MySQL/MariaDB.

## Table of Contents

- [Project Overview](#project-overview)
- [File Structure](#file-structure)
- [Setup Instructions](#setup-instructions)
- [Usage](#usage)

## Project Overview

The integration process consists of the following components:
- **index.php:** The main PHP file responsible for displaying the booking data and providing filtering options.
- **import_data.php:** A script to import data from a JSON file into the database.
- **Database.php:** A PHP class for database connectivity and table creation.
- **Booking.php:** A PHP class for handling booking-related operations.
- **Events.json:** Sample JSON file containing booking data.

## File Structure
event-booking-system/
│
├── index.php
├── import_data.php
├── Database.php
├── Booking.php
└── data/ Events.json

## Setup Instructions

1. **Clone Repository:**

2. **Database Setup:**
- Ensure MySQL/MariaDB is installed.
- Create a new database named `event_booking_system`.
- Update database credentials (`$servername`, `$username`, `$password`, `$database`) in `index.php` and `import_data.php`.

3. **Create Table (if not exists):**
- The application automatically creates the necessary table `event_bookings` in the database if it doesn't exist. The table structure is defined in `Database.php`.

4. **Import Data:**
- If no data is found in the database, the application displays a message with a button to automatically import data from the JSON file.
- Data is imported in chunks to optimize performance, especially for large amounts of data.

5. **Web Server Setup:**
- Configure a web server (e.g., Apache) to serve PHP files.
- Ensure the server has access to the project directory.

6. **Access Application:**
- Open `index.php` in a web browser to access the application.

## Usage

1. **Filtering:**
- Enter employee name, event name, or event date in the respective fields.
- Click the "Filter" button to apply the filter.

2. **Viewing Data:**
- Filtered bookings will be displayed in a table below the filters.
- Total price of filtered entries is shown at the bottom of the table.
