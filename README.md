# Travel Group Social System With Chat - PHO & MYSQL

A fully functional social networking web application built with **PHP** and **MySQL** that allows users to create accounts, login, and interact with others via **WhatsApp-like chat**, including **private and public group chats**.

---

## 🚀 Features

- ✅ User registration (Sign Up) and login system with session management  
- ✅ Real-time-like chat interface resembling WhatsApp  
- ✅ Private one-to-one chats between users  
- ✅ Public and private group chats  
- ✅ User profiles and group management  
- ✅ Responsive UI for smooth user experience  

---

## 🛠️ Technologies Used

- PHP (backend logic)  
- MySQL (database)  
- HTML, CSS, JavaScript (frontend)  
- AJAX for chat message updates  
- XAMPP or any local server environment for testing  

---

## 💾 Database

- Database name: `travel-group-social-system`  
- The SQL dump file `travel_system.sql` is included in the project folder.  
- It contains all tables and seed data required for the application to run.

---

## 📥 Installation & Setup Guide (Using XAMPP)

### Step 1: Download & Install XAMPP
- Download XAMPP from [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)  
- Install it on your machine and start **Apache** and **MySQL** modules via the XAMPP Control Panel.

### Step 2: Place Project Files
- Copy the entire project folder (`travel_group_social_system`) into the `htdocs` directory of your XAMPP installation.  
  - Example path: `C:\xampp\htdocs\travel_group_social_system`

### Step 3: Import Database
- Open your browser and go to `http://localhost/phpmyadmin`  
- Create a new database named: `travel_group_social_system`  
- Select the newly created database, then click **Import** tab.  
- Choose the `travel_system.sql` file from your project folder and import it.

### Step 4: Configure Database Connection
- Open the project folder and find the database configuration file (usually named `config.php` or similar).  
- Make sure the database credentials are correct:
```
  $servername = "localhost";
  $username = "root";          // default XAMPP username
  $password = "";              // default XAMPP password is empty
  $dbname = "travel-group-social-system";
```

- Save the file.

### Step 5: Run the Application
In your browser, open:
```
http://localhost/travel_group_social_system/
```
- You should see the login/sign up page.

- Register a new account or login with existing credentials.

### 🧩 How To Use
- After login, you can start private chats with other users.

- Create or join public and private groups for group chats.

- Messages update dynamically like WhatsApp chat.

### Troubleshooting
- Make sure Apache and MySQL services are running in XAMPP.

- Check database connection settings if login doesn’t work.

- Import the database correctly using phpMyAdmin.

- Clear browser cache or try different browser if UI issues occur.

### 📞 Support
If you face any issues or want to contribute, feel free to contact me or open an issue in this repo.


### 📃 License


This project is proprietary and closed-source.  
All rights reserved © khdxsohee 2025.  
You may not copy, modify, distribute, or use this project without explicit written permission from the author.


### 👨‍💻 Author
Created by khdxsohee
