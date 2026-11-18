# Blog Test Task

## How to Build the Project

This project uses docker containers.

1. Create the environment file:

    ```bash
    cp .env.example .env
    ```

2. Build and start the containers:

    ```bash
    docker compose up -d --build
    ```

3. Open the application at [http://localhost:8080](http://localhost:8080).

The application container serves the project on port `8080` by default, and the MySQL
container applies `database/schema.sql` and `database/seed.sql` automatically on first start.

To stop the containers:

```bash
docker compose down
```

To rebuild the image after changing the `Dockerfile` or dependencies:

```bash
docker compose up -d --build
```
