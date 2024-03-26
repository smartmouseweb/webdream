1. Get XAMPP or similar. Start Apache and MySQL.
2. Start a symfony server: symfony server:start
3. Create database: symfony console doctrine:database:create
4. Install migrations: symfony console doctrine:migrations:migrate
5. Install data fixtures: symfony console doctrine:fixtures:load
6. Enjoy on localhost.

Sorry for not Dockerizing it!

ToDos: PHPUnit tests. Currently only HTML endpoints are available.
