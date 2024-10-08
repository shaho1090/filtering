## Introduction
This is an example Laravel application built to demonstrate and test advanced query filtering.    
### Installation
You need to have docker and docker compose installed on your local machine.
After cloning and moving into the root directory of the project, run these commands respectively:
```cmd
$ cp .env.example .env
```
Make sure you fill in all required keys in the **.env** file. Check **docker-compose** file to recognize them.
Make sure the ports you are going to define for NGINX_PORT and PHPMYADMN_PORT, have not been used before in your local computer.
```cmd
$ docker compose build
```
The above command may take several minutes to complete. And, of course prepare a proper DNS on your network if you need!   
We have a profile named **local** and its purpose is for separating the testing environment from possible stage or production settings, so when you are setting up your local env you can run this command:
```cmd
$ docker compose --profile local up -d
```
After completing previous steps ,go to tech-api container by running this command:
```cmd
$ docker exec -it tech-api bash
```
And, run:
```cmd
$ composer install
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed UserSeeder
```
To have some orders for testing purpose you may want to run: 
```cmd
$ php artisan db:seed TestingOrderSeeder
```
As you know you can run this command multiple times to have more orders.  

**Please make sure you have defined proper values for these keys:**
```
ADMIN_MOBILE=910000000
ADMIN_EMAIL=admin@admin.ir
SMS_FROM=334000000
```
These values are just examples, you can change them as you wish.
To check and test the received emails you can use [mailtrap](https://mailtrap.io/) website.    

The orders list api is:
```
localhost:<NGINX_PORT>/api/backoffice/orders
```
You can use these examples filters:
```
status=completed
amount[min]=1000
amount[max]=9000
search_customer=9120000000
search_customer=3732222222
```
