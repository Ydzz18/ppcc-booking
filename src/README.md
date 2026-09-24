# PPCC Booking

## Run with Docker

1. Copy `src/.env.example` to `src/.env`.
2. Generate an application key with `docker compose run --rm app php artisan key:generate`.
3. Start the services with `docker compose up --build`.
4. Open `http://localhost:9090`.

The MySQL container imports the root `booking.sql` dump automatically when its
volume is created for the first time. Existing database volumes are preserved.
