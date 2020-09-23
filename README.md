# yBank
**Setup - API (Laravel)**
1. Install JS packages via composer install
2. Set up database: Create a MySQL Database for the backend.
3. Configure database in .env file (PS: As a security measure, .env files are not shared on git. Rename .env.example to .env create an env locally.)
    1. Update DB_DATABASE with name of database you just created.
    2. Update DB_USERNAME with username of MySQL Server User (User must have access rights to read and write to the above database)
    3. Update DB_PASSWORD to password of user specified above.
4. Run migrations and seeder
5. php artisan key:generate  to generate a key for the application (This does not necessary have to be the last).


**Setup - Web (Nuxt.js/Vue.js)**
1. Install packages using npm install
2. PS - Safest way to ensure all modules are installed well from experience is to clear your cache, delete modules folder and re-install npm.
    1. npm cache clean --force
    2. rm -rf node_modules
    3. npm install --save nuxt


**Environment Set Up**
1. Laravel - Laravel can be served straight out of the box using php artisan serve. For more flexibility, I have used vhosts to host my application.
2. Nuxt.js - npm run dev to serve