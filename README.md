# Highload Network Deployment Guide

This guide will help you to set up and run the Highload Network project using Docker.

## Prerequisites

- [Docker](https://www.docker.com/get-started) installed on your machine
- [Docker Compose](https://docs.docker.com/compose/install/) installed

## Getting Started

1. Clone the repository:

```bash
    git clone https://github.com/yourusername/highload-network.git
    cd highload-network
```
2. Copy `.env.example` to `.env` and configure it according to your setup:

```bash
   cp .env.example .env
```

3. Add the following entry to your `/etc/hosts` file to map the domain `ha.network.local` to your local machine:

```bash
   sudo -e /etc/hosts
```

   Add the following line:
```text
   127.0.0.1 ha.network.local
```

4. Build and run the Docker containers:

```bash
   docker-compose up --build -d
```

## Accessing the Services

- The application will be available at [http://ha.network.local](http://ha.network.local)
- PostgreSQL database will be available at `localhost:5432`, with the credentials provided in the `docker-compose.yml` file.

## Additional Commands

- To bring the containers down:

```bash
  docker-compose down
```

- To view the logs of a specific container:
```bash
  docker-compose logs <container_name>
```

  Example:
```bash
  docker-compose logs ha-network-nginx
```
## Database Migrations

Before using the application, you will need to run the database migrations:

1. Open a bash shell on the `ha-network-fpm` container:

```bash
   docker-compose exec ha-network-fpm
```

2. Run the migrations:

```bash
   php artisan migrate
```
## Directory Structure

- `./src` - The main application source code
- `./.docker/nginx` - Nginx configuration files and logs
- `./.docker/php-fpm` - PHP-FPM Dockerfile and configurations
- `./.docker/postgres/data` - PostgreSQL data

## Troubleshooting

- If you encounter any issues with file permissions, you may need to adjust the user and group IDs in the `docker-compose.yml` and Dockerfile.
- Ensure that you have the correct environment variables set in your `.env` file.