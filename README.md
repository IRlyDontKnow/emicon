Manual installation
------------
**1)**
Create a .env from the .env.dist file. Adapt it according to your symfony application
```bash
cp .env.dist env
```
**2)**
Install php dependencies
```bash
composer install --optimize-autoloader
```
**3)**
Create database & load fixtures
```bash
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:schema:update -f
php bin/console app:fixtures:load 
```
**4)**
Run application
```bash
php bin/console server:run
```
**5)**
Open browser and enter http://localhost:8080

Docker deployment
------------
**1)**
Run the app with compose
```bash
docker-compose up -d
```

**2)**
Enter docker interactive mode with command 
```bash
docker-compose exec php bash
```
**3)**
Execute these commands
```bash
composer install --optimize-autoloader
php bin/console doctrine:database:create -e prod --if-not-exists
php bin/console doctrine:schema:update -f -e prod
php bin/console app:fixtures:load -e prod
```
**4)**
Open browser and enter http://localhost:8080
