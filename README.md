# Multi-Tenant Laravel API

Welcome to the Multi-Tenant Laravel API documentation. This API serves as the backend for our multi-tenant web application. It's built using the Laravel framework and provides endpoints for managing tenants, users, and projects.

## Getting Started

### Prerequisites

Before you begin, ensure you have met the following requirements:

- [Docker](https://www.docker.com/get-started) installed on your local machine.
- [Docker Compose](https://docs.docker.com/compose/install/) (usually comes with Docker).

### Installation

1. Clone the repository to your local machine:

   ```bash
   git clone https://github.com/Fabulouscode/multi_tenant_api.git
   cd multi-tenant-api
```
2. Build and start the Docker containers:

```bash
docker-compose build
docker-compose up -d
```
3. Install Laravel dependencies and set up the database:

```bash
docker-compose exec app composer install
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```