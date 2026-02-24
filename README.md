# Notification Center API

A Symfony-based API that provides user-specific notifications based on configurable business rules. The API evaluates user data and device information to determine which notifications should be displayed.

## 📋 Table of Contents
- [Technologies Used](#technologies-used)
- [Prerequisites](#prerequisites)
- [Project Setup](#project-setup)
- [Database Configuration](#database-configuration)
- [Running the Application](#running-the-application)
- [API Usage](#api-usage)
- [Project Structure](#project-structure)
- [Adding New Notification Rules](#adding-new-notification-rules)
- [Troubleshooting](#troubleshooting)
- [Development Commands](#development-commands)

## 🛠 Technologies Used

- **PHP 8.4.18** - Core programming language
- **Symfony 8.0.5** - PHP framework
- **MySQL 8.0.45** - Database
- **Docker** & **Docker Compose** - Containerization
- **Doctrine ORM** - Database abstraction
- **Nginx** - Web server

## 📋 Prerequisites

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/downloads)
- Ports 8080 and 3306 available on your machine

## 🚀 Project Setup

### 1. Clone the Repository

```bash
git clone <your-repository-url>
cd notification-center
```


### 2. Environment Configuration
Create a .env file (or copy from .env.example):
```bash
cp .env .env.local
```

### 3. Start Docker Containers
Create a .env file (or copy from .env.example):
```bash
# Build and start containers
docker-compose up -d

# Verify containers are running
docker-compose ps
```

Expected output:

```text
    Name                   Command               State          Ports        
-----------------------------------------------------------------------------
notification_db    docker-entrypoint.sh mysqld      Up      0.0.0.0:3306->3306/tcp
notification_nginx  /docker-entrypoint.sh ngin ...   Up      0.0.0.0:8080->80/tcp
notification_php    docker-php-entrypoint php-fpm    Up      9000/tcp
```

### 4. Install PHP Dependencies
```bash
# Install Composer dependencies
docker exec -it notification_php composer install
```

### 5. Set Up Database
```bash
# Create database if not exists
docker exec -it notification_php php bin/console doctrine:database:create --if-not-exists

# Run migrations or update schema
docker exec -it notification_php php bin/console doctrine:schema:update --force

# Load fixture data (if you have the dump file)
cat dump.sql | docker exec -i notification_db mysql -u root -proot notification
```

### 6. Clear Cache
```bash
docker exec -it notification_php php bin/console cache:clear
```

## Database Configuration

Database Schema
The application uses two main tables:

### users

id - Primary key

email - User email

country_code - 2-letter country code (e.g., 'ES' for Spain)

is_premium - Premium status (boolean)

last_active_at - Last activity timestamp

created_at - Account creation timestamp

status - User status


### devices

id - Primary key

user_id - Foreign key to users

platform - Device platform (android/ios/windows)

label - Device label/name

created_at - Device registration timestamp

## Fix Orphaned Records (if needed)
```bash
# Delete orphaned device records
docker exec -it notification_db mysql -u root -proot -e "USE notification; DELETE FROM devices WHERE user_id NOT IN (SELECT id FROM users);"
```

## 🏃 Running the Application
### Start the Application
```bash
docker-compose up -d
```
The API will be available at: http://localhost:8080

### To also remove volumes (database data):
```bash
docker-compose down -v
```

## 📡 API Usage
### Endpoint
```text
GET /notifications?user_id={userId}
```

Parameters
```text
user_id is required
```

## 📁 Project Structure
```text
notification-center/
├── docker/
│   ├── nginx/
│   │   └── default.conf          # Nginx configuration
│   └── php/
│       └── Dockerfile             # PHP-FPM Dockerfile
├── src/
│   ├── Controller/
│   │   └── NotificationController.php  # API endpoint
│   ├── Domain/
│   │   └── Notification.php            # Notification DTO
│   ├── Entity/
│   │   ├── User.php                     # User entity
│   │   └── Device.php                    # Device entity
│   ├── Notification/
│   │   ├── NotificationRuleInterface.php # Rule interface
│   │   └── AndroidDeviceNotificationRule.php # Android rule
│   ├── Repository/
│   │   ├── UserRepository.php
│   │   └── DeviceRepository.php
│   └── Service/
│       └── NotificationService.php       # Main service
├── config/
│   └── services.yaml                     # Service configuration
├── docker-compose.yml                     # Docker services
├── dump.sql                               # Database dump
└── README.md                              # This file
```