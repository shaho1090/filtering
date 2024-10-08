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

```cmd
$ docker compose up -d
``` 
After completing previous steps ,Go to tech-api container by running this command:
```cmd
$ docker exec -it tech-api bash
```
And, run:
```cmd
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
