## 🌾 **Agronomix**  
A web-based agricultural management application developed as part of the **PIDEV 3A** course at **Esprit School of Engineering**. Agronomix connects farmers, investors, product managers, and users to manage agricultural activities, sell products, monitor lab analyses, participate in events, view offers and schedules, and handle complaints.  

---

## 📌 **Description**  
Agronomix is an innovative **Symfony web application** designed to centralize agricultural management and facilitate interaction between various actors. Developed for the **PIDEV 3A** course at **Esprit School of Engineering**, the platform targets not only farmers and clients but also investors, product managers, and users. Its features include product sales, lab analysis management, event participation, and a dedicated complaint space. Agronomix provides a responsive and collaborative interface tailored to all its users.  

---

## 📑 **Table of Contents**  

- [🚀 Installation](#installation)  
- [💡 Usage](#usage)  
- [✨ Features](#features)  
- [🛠 Technologies Used](#technologies-used)  
- [👥 Contributors](#contributors)  
- [📜 License](#license)  
- [🙏 Acknowledgements](#acknowledgements)  

---

## 🚀 **Installation**  

To install Agronomix locally on your machine:  

1️⃣ **Clone the repository:**  
```bash
git clone https://github.com/useroussama/prjt_java.git
cd agronomix-web
2️⃣ Install dependencies:
Make sure you have Composer installed, then run:

bash
Copier
Modifier
composer install
3️⃣ Configure the database:

Ensure MySQL is installed and running.

Update the .env file with your database credentials:

env
Copier
Modifier
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/agronomix"
4️⃣ Create and initialize the database:

bash
Copier
Modifier
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
5️⃣ Run migrations (if any):

bash
Copier
Modifier
php bin/console doctrine:migrations:migrate
6️⃣ Run the application:

bash
Copier
Modifier
symfony server:start
Access the application at http://127.0.0.1:8000

💡 Usage
Once installed, launch the application from your browser. Main actions include:

Sign up / Log in ➡️ Register or log in as a farmer, investor, product manager, or user.

Manage agricultural activities ➡️ Farmers can schedule and manage interventions.

Sell products ➡️ Integrated store for buying agricultural items and services.

Monitor lab analyses ➡️ View and manage laboratory analysis results.

Join events ➡️ Sign up for agricultural events and workshops.

Browse ➡️ View available offers, schedules, and products.

Submit complaints ➡️ Use the dedicated complaints section.

✨ Features
✅ Secure authentication: Registration and login for multiple user types.

✅ Activity management: Plan and book agricultural interventions.

✅ Product sales: Buy agricultural gear and services.

✅ Lab analysis management: Monitor results and schedules.

✅ Events: Participate in thematic agricultural events.

✅ Offer browsing: Farmers' schedules, services, and products.

✅ Complaints: Submit and manage user complaints.

✅ Responsive interface: Designed for web and mobile devices.

🛠 Technologies Used
Frontend
🎨 Twig: Template engine for views

📐 Bootstrap: Responsive and mobile-first design

🎨 CSS & JavaScript: UI customization

Backend
☕ Symfony 6: PHP framework for robust application logic

💾 MySQL: Relational database

🔗 Doctrine ORM: Database abstraction layer

Tools
🔧 Composer: Dependency and project management

🌐 Symfony CLI: Local web server and utilities

🖌 PHPUnit: Testing framework

👥 Contributors
The following developers contributed to Agronomix:

Ouerghi Oussama – User management features

Chabani Ahmed – Lab analysis management

Maaouia Melek – Product management and sales

📜 License
This project currently does not have an official license. Contact the authors for more information.

🙏 Acknowledgements
This project was developed under the supervision of Mohamed Ridha Boulares at Esprit School of Engineering for the PIDEV 3A course. Many thanks to our classmates and mentors for their support.
