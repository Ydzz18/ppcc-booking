# PPCC Booking

## Run with Docker

1. Copy `src/.env.example` to `src/.env`.
2. Generate an application key with `docker compose run --rm app php artisan key:generate`.
3. Start the services with `docker compose up --build`.
4. Apply pending database migrations with `docker compose exec app php artisan migrate --force`.
5. On the Docker host, open `http://localhost:9090`. From another PC on the same LAN, open `http://<docker-host-LAN-IP>:9090` instead; `localhost` on that PC refers to itself. Allow inbound TCP port 9090 through the host firewall if the page cannot be reached.

The MySQL container imports the root `booking.sql` dump automatically when its
volume is created for the first time. Existing database volumes are preserved.
