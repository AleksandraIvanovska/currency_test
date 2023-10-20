# Laravel Currency Conversion app

This repo contains Laravel Currency Conversion app

## Dev Environment using Docker

- First you need to clone the laravel repository.
- Now you can pull the latest changes from master, after this  you are ready to start the containers
- Start the services by running these command:
  - sudo docker-compose up --build (this will start all of the containers)
    - *This will start 3 services* - currency-php, mylocaldb, pgadmin-container
- For stopping the services you can use these commands:
  - sudo docker-compose stop (this will stop the services but keep them in cache)
  - sudo docker-compose down (this will tear down the services, after this command you have to rebuild them )



Now you can run commands directly on the laravel container after you run this command:
- sudo docker exec -it currency-php sh

After that you can run 
- php artisan migrate (this will create tables in the db and populate some of them)

If you wish to add an existing database to the docker you should run the command
- sudo docker exec -i mylocaldb /bin/bash -c "PGPASSWORD=aleksandra psql --username postgres postgres" < dump/currency_db.sql
