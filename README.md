# Multi-Container-Web-Application
## Project Overview 
The project demonstrates the use of containerization technology ( Docker and Docker compose) in the deplopyment of a simple web application contain mutiple containers , i.e The forntend , backend , phpmyadmin, and SQL . 
The main focus of this project is to practice real-world DevOps concepts  such as service orchestration, container networking, environment configuration, and dependency management.

## Architecture Diagram
The application is composed of multiple Docker containers running on a custom Docker network. The frontend serves static content and proxies API requests to the backend, which communicates with a MySQL database . 

![Alt docker](https://github.com/Adegbenga-111/Multi-Container-Web-Application/blob/main/Screenshot%20(476).png)

Image 1 : Architecture Diagram showing the network flow between container 


## 🛠 Tech Stack

- **Docker**  
  Used to containerize each component of the application, ensuring consistency
  across development and deployment environments.

- **Docker Compose**  
  Used to orchestrate multiple containers, define service dependencies,
  manage networking, and inject environment variables.

- **Nginx**  
  Serves static frontend assets and acts as a reverse proxy to route `/api`
  requests to the backend service.

- **PHP 8.2 (Apache)**  
  Implements the backend API and handles database interactions using PDO.

- **MySQL 8.0**  
  Provides persistent relational data storage, initialized using SQL scripts
  and backed by Docker volumes.

- **phpMyAdmin**  
  Provides a browser-based interface for managing the MySQL database.

- **HTML & CSS**  
  Used to build a lightweight frontend interface for interacting with the backend API.
