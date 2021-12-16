#1.0 SETUP

###1.1 Prerequisite

To setup this app you will need to have the following programs listed 
below installed on your computer.
- Docker
- Docker Compose

You can conveniently use git to clone into this repository from
your local machine, or just download as zip and unzip in a
folder of your choice.

### 1.2 Services

The docker-compose.yml file essentially contains 2 services
- appservice: this refers to the services that runs the Laravel application. It exposes port 8020 to the host machine.
- mysqldb: this is the MySQL database service that persists the data for the Laravel application. It exposes port 3306 to the host machine.


### 1.3 Procedure

#####Step 1:
Now that you have the source code, docker and docker-compose installed on
your computer, navigate to the folder root of the source code you unzipped or
cloned from github. You should see a docker-compose.yml file among
the files in the directory.

#####Step 2: 
Create a .env file from the .env.example sample file located 
in the root directory of this source code. Docker Compose relies
on this file to properly launch the defined services. Most of the environmental
variables have been defined with some values, you can make updates to 
them but take not of the following
- DB_HOST=mysqldb (This is mandatory, if you change this you must also 
change the definition in the docker-compose service name for the MySQL db)
- APP_KEY (this is empty by default, not to worry Laravel 
will automatically generate its value when you initiate php artisan:key generate command in step 4)

#####Step 3: 
Start up all the services by running this command: 
- docker-compose up -d

#####Step 4: 
Install all the dependencies needed to start the app
- docker-compose exec appservice composer install (This installs all the apps dependencies into a vendors folder)
- docker-compose exec appservice php artisan:key generate (This creates a value for APP_KEY env variable)
- docker-compose exec appservice php artisan:migrate (this migrates tables into the database)


#####Step 5: 
Setup is complete, you can navigate to you browser and type in this url
- http://localhost:8020

You should be able to see a page served.

###1.4 Endpoints
This app contains 2 endpoints
- POST - Endpoint to create a User
    - http://localhost:8020/api/v1/user 
        - [param] first_name
        - [param] last_name
        - [param] email
        - [param] password
- GET - Endpoint to retrieve a user
    - http://localhost:8020/api/v1/user/:id
        - [param] id (substitute user id for :id)


