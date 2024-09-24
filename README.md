# Logistics
System which handles fleet sets, their orders, drivers management. Built in Symfony 7.1.
## Functionality 
1. User can see driver list and view single item
2. User can see fleet sets list (trailer and trucks) and and view single item
3. User can see orders which are made by fleet sets and single preview.
## Installation instructions. For both enviromentns
-  Clone the repository with ```git clone```
### Docker
* Run ```docker-compose up```. For the first time it took some time to install project's containers.
* Run ```docker-compose exec workspace bash```
* Copy ```.env``` file to ``.env.local`` and edit database credentials docker compose file there with ```cp .env.example .env.local```
* * Copy ```.env``` file to ``.env.test.local`` and edit database credentials from docker compose file there with ```cp .env.example .env.test.local```
* In ```.env``` file. Do changes in these lines: 
- DB host is ```logistics-database-1:5432```
* Run ```composer install```
* Loading seeders in respective envs ```php bin/console doctrine:fixtures:load``` & ```php bin/console --env=test doctrine:fixtures:load```
## Final step
- That's it: launch the main URL (Docker: localhost or localhost:80 )
