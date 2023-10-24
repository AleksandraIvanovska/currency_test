# Laravel Currency Conversion app

This repo contains Laravel Currency Conversion app

## Dev Environment using Docker

- First you need to clone the laravel repository.
- Now you can pull the latest changes from master, after this  you are ready to start the containers
- Start the services by running these command:
  - sudo docker-compose up --build (this will start all containers)
    - *This will start 3 services* - currency-php, mylocaldb, pgadmin-container
- For stopping the services you can use these commands:
  - sudo docker-compose stop (this will stop the services but keep them in cache)
  - sudo docker-compose down (this will tear down the services, after this command you have to rebuild them )
- To start the services again run:
  -  sudo docker-compose up

Now you can run commands directly on the laravel container after you run this command:
- sudo docker exec -it currency-php sh

After that you can run 
- php artisan migrate (this will create tables in the db and populate some of them)

To see the db go to http://localhost:5051/browser/ and login with credentials
- aleksandra@example.com
- pass:aleksandra
- Create new server with creds from the env:
  - DB_HOST=127.0.0.1
  - DB_PORT=5432
  - DB_DATABASE=postgres
  - DB_USERNAME=postgres
  - DB_PASSWORD=postgres


To run the unit tests run command
- sudo docker exec -it currency-php php artisan config:clear
- sudo docker exec -it currency-php php artisan test --env=testing
- After that to use the local db again

Go to http://127.0.0.1:8000/ to open the view
 - If you are experiencing some issue run the following commands
   - php artisan config:clear
   - php artisan route:clear

Project logic:
  - The GET:'/api/currencies/getAllCurrencies' route should be used to list all currencies in dropdown and choose from it.
  - There should be 2 dropdowns one for converting from and one for converting to currency
  - There should also be a label field to insert the value you want to convert 
  - After selecting the currencies and value input call the route POST:'/api/currencies/covertCurrency'
    - Example request body:
    {
      "source_currency": "GBP",
      "target_currency": "MKD",
      "value": 50
    }

  - The GET:'/api/currencies/conversions' route will return all conversions that have been made
