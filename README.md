# Exposy Application README

Welcome to the Exposy application! Follow these instructions to set up and run Exposy on your local machine using MAMP/XAMPP and TablePlus.

## Installation Instructions

### Prerequisites

Before you begin, ensure you have the following installed on your machine:

- **MAMP/XAMPP**: A local development environment that includes PHP, Apache, and MySQL.
- **TablePlus**: A database management tool for interacting with your MySQL database.

### Installation Steps

1. **Download and Extract the Application**

   - Download the ZIP file of the Exposy application.
   - Extract the contents to your desired directory on your local machine.

2. **Set Up MAMP/XAMPP**

   - Start MAMP/XAMPP.
   - Ensure that both Apache and MySQL servers are running.

3. **Configure the Application**

   - Copy the sample configuration file (e.g., `config.example.php`) to a new file named `config.php` in the root directory of your project.
   - Open `config.php` and update the database connection settings to match your local MySQL setup. For example:

     ```php
     <?php
     return [
         'db' => [
             'host' => '127.0.0.1',
             'port' => '3306',
             'dbname' => 'your_database_name',
             'user' => 'your_database_user',
             'password' => 'your_database_password',
         ],
     ];
     ```

4. **Set Up the Database**

   - Open TablePlus and connect to your local MySQL server.
   - Create a new database for the Exposy application.
   - If you do not have an SQL schema file, you will need to create tables manually. Refer to the application code or documentation for the required table structure.
   - Ensure that the database credentials in `config.php` match those you used in TablePlus.

5. **Run the Application**

   - Navigate to the `public` directory of your project. This is usually located at `/path/to/Exposy/public`.
   - Open your web browser and go to `http://localhost:8888` (or your configured local domain).
   - You should see the Exposy application running.

## Troubleshooting

- **404 Not Found**: Ensure that the Apache server is running and that you are navigating to the correct directory (`public`) in your browser.
- **Database Connection Issues**: Verify the `config.php` settings and ensure that the database is running and accessible.
- **Table Structure Issues**: If you encounter errors related to missing tables or columns, manually create the necessary tables in TablePlus based on the application’s requirements.

## Support

For further assistance or if you encounter issues not covered here, please contact me at [caramelevaa@gmail.com](mailto:caramelevaa@gmail.com).

Feel free to adjust the details according to your application's specific needs. If you have more questions or need additional assistance, let me know!
