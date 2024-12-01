# Laravel + Vue.js Project Setup



This guide will walk you through setting up the Laravel + Vue.js application on your local machine, including database setup, running migrations, seeding data, and serving the application.

# Prerequisites
Make sure you have the following installed:

PHP 8.x+
Composer
Node.js
npm
MySQL
Git

# Step 1: Clone the Repository
First, clone the repository to your local machine:

https://github.com/Ochegbinu/Assessment.git

cd Assessment

# Step 2: Install Backend Dependencies (Laravel)

Install Composer Dependencies

Navigate to the Laravel backend folder and install PHP dependencies using Composer:


# composer install


Configure .env File

# Copy the .env.example file to .env:

# cp .env.example .env


Open the .env file and configure your database and other environment variables (like app name, app URL, etc.). Here’s an example configuration for MySQL:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password


## Generate the Application Key

Run the following command to generate an application key:

## php artisan key:generate


# Step 3: Run Migrations and Seed Database

## Run Migrations

Migrations will create the necessary tables in the database. Run the following command to execute the migrations:


# php artisan migrate


## Seed Database

run the code below to seed the products on the DB

## php artisan db:seed


# Step 4: Install Frontend Dependencies (Vue.js)

Install Node Dependencies

Next, install the frontend dependencies using npm (from the root of the project):

## npm install


Compile Frontend Assets
Once the dependencies are installed, you can compile the frontend assets using Laravel Mix (which uses Webpack under the hood):

## npm run dev


For production, you can compile the assets as follows:


## npm run production


This will compile the assets and place them in the public directory.


# Step 5: Serve the Application

Run Laravel Development Server

You can now run the Laravel development server:


# php artisan serve


This will start the backend server at http://127.0.0.1:8000.

# Run Vue.js Development Server

You may also want to run the Vue.js development server, especially if you're using hot module reloading:

## npm run dev


## By default, Vue.js will run at http://localhost:8080.

# Test User Login Details:

## Email : mkirlin@example.org
## password: password

If your Vue.js components are built as part of the Laravel app, running php artisan serve will serve the full application, including Vue.js assets.

Step 6: Access the Application

Once everything is up and running, open your browser and navigate to http://127.0.0.1:8000 to access your application.

