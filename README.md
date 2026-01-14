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


## ⚠️ Problems Faced & Solutions

This project involved several real-world issues commonly encountered when working with containerized, multi-service applications. Below are the key problems faced during development and how they were resolved.
---
### 1. Database Connection Failed on Application Startup

**Problem:**  
The backend service frequently failed to connect to the MySQL database during startup, returning errors such as:

#### Database unavailable
Although Docker Compose was configured with `depends_on`, the backend still attempted to connect before MySQL finished initializing.

**Root Cause:**  
`depends_on` only controls container startup order; it does **not** wait for a service to become ready. MySQL requires additional time to initialize the database, users, and schemas.

**Solution:**  
Retry logic was implemented in `db.php` to attempt database connections multiple times with delays between retries. This allows the backend to wait until the database becomes available.

**Result:**  
The backend now reliably connects to MySQL even when the database initializes
slowly.

---

### 2. Incorrect Use of `localhost` Inside Containers

**Problem:**  
Initial database connection attempts used `localhost` as the database host, resulting in connection failures.

**Root Cause:**  
Inside Docker containers, `localhost` refers to the container itself, not other services. Containers communicate using Docker’s internal DNS and service names.

**Solution:**  
The database host was changed to the Docker Compose service name (`db`), and environment variables were used to inject the correct hostname at runtime.

**Result:**  
The backend and phpMyAdmin services successfully connected to MySQL using Docker
service discovery.

---

### 3. Broken API Responses Due to Mixed Output

**Problem:**  
API responses contained unexpected output such as: 

**Database connection failed{"status":"ok","message":"Backend API is running"}**

**Root Cause:**  
The database connection file (`db.php`) was echoing output, while the API entry  point (`index.php`) was also returning JSON. This caused mixed and invalid API responses.

**Solution:**  
The database connection logic was refactored so that `db.php` performs no output. It now either silently succeeds or returns a structured JSON error and exits.
All API responses are handled exclusively in `index.php`.

**Result:**  
The backend now returns clean, valid JSON responses suitable for frontend and API consumers.

---

### 4. Reverse Proxy Misconfiguration in Nginx

**Problem:**  
Frontend requests to `/api` returned 404 errors even though the backend was
running correctly.

**Root Cause:**  
The frontend was attempting to call `/api`, but Nginx was not configured to
forward these requests to the backend service.

**Solution:**  
An Nginx reverse proxy configuration was added to route `/api` requests to the
backend container using its Docker service name.

**Result:**  
Frontend requests to `/api` are now correctly proxied to the backend service.

---

### 5. YAML Formatting and Indentation Errors

**Problem:**  
Docker Compose behaved unpredictably, with some services failing to connect to
the Docker network or being ignored entirely.

**Root Cause:**  
Incorrect YAML indentation (especially in the `phpMyAdmin` service definition)
caused Docker Compose to misinterpret the configuration.

**Solution:**  
The Compose file was reformatted and validated to ensure correct indentation and
service hierarchy.

**Result:**  
All services now start correctly and join the same Docker network.

---

### 6. Persistent Database State Causing Credential Mismatch

**Problem:**  
Changing database credentials in `.env` had no effect, and MySQL continued to
reject connections.

**Root Cause:**  
MySQL initialization environment variables are applied only on the first run.
Existing Docker volumes preserved old credentials.

**Solution:**  
All containers and volumes were removed using `docker compose down -v`, allowing
MySQL to reinitialize with the updated credentials.

**Result:**  
Database credentials are now consistent across services.

---


## 🧠 DevOps Concepts Demonstrated

- Multi-container orchestration with Docker Compose

- Service-to-service communication via Docker networks

- Environment variable configuration with .env

- Reverse proxy configuration using Nginx

- Handling service startup dependencies

- Persistent data using Docker volumes
