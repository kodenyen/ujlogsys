# Student Clinical Posting Log System - Installation Guide

This guide provides instructions for setting up the Student Clinical Posting Log System on a local development environment and deploying it to Hostinger shared hosting.

## Prerequisites
- PHP 7.4 or higher
- MySQL / MariaDB
- Apache Web Server (with `mod_rewrite` enabled)

## Local Installation (XAMPP/WAMP)

1. **Clone or Download the Project:**
   Place the project folder (e.g., `ujlogsys`) into your `htdocs` (XAMPP) or `www` (WAMP) directory.

2. **Database Setup:**
   - Open **phpMyAdmin**.
   - Create a new database named `ujlogsys`.
   - Import the `database/schema.sql` file provided in the project.

3. **Configure Database Connection:**
   - Open `config/config.php`.
   - Update the `DB_USER`, `DB_PASS`, and `DB_NAME` constants to match your local MySQL credentials.
   - Update `BASE_URL` to match your local path (e.g., `http://localhost/ujlogsys/public`).

4. **Access the Application:**
   Point your browser to `http://localhost/ujlogsys/public`.

5. **Initial Login:**
   - **Username:** `admin`
   - **Password:** `password`

---

## Deployment to Hostinger (cPanel)

1. **Upload Files:**
   - Compress all project files into a `.zip` file.
   - Use the Hostinger **File Manager** to upload and extract the zip into your `public_html` directory or a subdomain folder.

2. **Database Configuration on Hostinger:**
   - Go to **MySQL Databases** in your Hostinger panel.
   - Create a new database and a database user. Note the **Database Name**, **Username**, and **Password**.
   - Use **phpMyAdmin** on Hostinger to import `database/schema.sql`.

3. **Update `config/config.php`:**
   - Edit the file on the server to use the production database credentials and your live `BASE_URL`.

4. **Public Directory Handling:**
   - For security, it is recommended to point your domain/subdomain directly to the `public/` folder.
   - If you cannot change the document root, you can place a `.htaccess` file in the root directory to redirect traffic to `/public`.

---

## Project Structure (MVC)
- `/app`: Contains Core framework, Controllers, and Models.
- `/views`: Role-based UI components (layouts, admin, student, consultant).
- `/public`: The only folder accessible to the web. Contains `index.php`, CSS, and uploaded assets.
- `/config`: System and database settings.
- `/database`: SQL schema files.

## Admin Setup Checklist
1. Login as Admin.
2. Go to **App Settings** to upload your Organization Logo and set the Name.
3. Go to **Departments** to create your clinical departments.
4. Go to **Sections** to add clinical sections to those departments.
5. Go to **Log Config** to define your dynamic clinical report fields and activity types.
6. Register Students and Consultants under **Users**.
