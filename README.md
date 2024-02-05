## Getting Started

These instructions will cover usage information and for the docker container.

### Prerequisities

In order to run this container you'll need docker installed.

- [Windows](https://docs.docker.com/windows/started)
- [OS X](https://docs.docker.com/mac/started/)
- [Linux](https://docs.docker.com/linux/started/)

### Usage

#### Container Parameters

```shell
docker-compose up -d --build

This will start all services specified in your docker-compose.yml file.

Environment Variables
    - MYSQL_DATABASE - db
    - MYSQL_USER - joyjet
    - MYSQL_PASSWORD - joyjet123
    - MYSQL_ROOT_PASSWORD - joyjet123
Volumes
    - /var/lib/mysql - MySQL data

# REQUEST EXAMPLES

To fetch a single user by ID:
curl -X GET http://localhost/users/1

To create a new user:
curl -X POST http://localhost/users \
     -H 'Content-Type: application/json' \
     -d '{"username": "newuser", "email": "newuser@example.com"}'

To update a user with ID 1:
curl -X PUT http://localhost/users/1 \
     -H 'Content-Type: application/json' \
     -d '{"username": "updateduser", "email": "updateduser@example.com"}'






