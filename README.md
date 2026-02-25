Petspal Connect is a full-stack web application designed to facilitate pet adoption and exchange. The platform allows users to register, log in, and manage pet listings through a secure session-based system.

Tech Stack

PHP (Backend)

MySQL (Database)

HTML5

CSS3

JavaScript

Core Features

User Registration & Login

Session-based authentication

Create, View, Update, Delete (CRUD) operations for pet listings

Relational database schema design

Responsive frontend interface

System Design
Authentication Flow

User registers → Data stored in MySQL

Login validation → Credentials verified

Session initiated for authenticated access

Restricted actions allowed only for logged-in users

Database Structure

Users Table

Pets Table

Foreign key relationships for user-specific listings

How to Run

Clone repository

Import SQL file into MySQL

Configure database credentials in config file

Run using local PHP server
