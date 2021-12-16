# 1.0 SETUP

### 1.1 Prerequisite

To setup this app you will need to have the following programs listed 
below installed on your computer.
- Docker
- Docker Compose

You can conveniently use git to clone into this repository from
your local machine, or just download as zip and unzip in a
folder of your choice.

### 1.2 Services

The docker-compose.yml file essentially contains 4 services
- composerinstall: This service installs dependencies via the composer package manager
- keygen: This service will generate the APP_KEY environment variable required by Laravel to perform hashes e.t.c
- appservice: This is the Main application service that runs the Laravel application. It exposes port 8020 to the host machine.
- database: This is the MySQL database service that persists the data for the Laravel application. It exposes port 3306 to the host machine.


### 1.3 Procedure

##### Step 1:
Now that you have the source code, docker and docker-compose installed on
your computer, navigate to the folder root of the source code you unzipped or
cloned from github. You should see a docker-compose.yml file among
the files in the directory.

##### Step 2: 
Create a .env file from the .env.example sample file located 
in the root directory of this source code. Docker Compose relies
on this file to properly launch the defined services. Most of the environmental
variables have been defined with some values, you can make updates to 
them but take not of the following
- DB_HOST=database (This is mandatory, if you change this you must also 
change the definition in the docker-compose service name for the MySQL db)

##### Step 3: 
Start up all the services by running this command: 
- docker-compose up -d

##### Step 4: 
Create tables from predefined schemas by running the migration command.
- docker-compose exec appservice php artisan:migrate


##### Step 5: 
Setup is complete, you can navigate to you browser and type in this url
- http://localhost:8020

You should be able to see a page served showing details of the endpoints like below.

### 1.4 Endpoints
This app contains 2 endpoints
- Endpoint to create a User
    - cURL - http://localhost:8020/api/v1/user.
    - H -  "Content-Type: application/json"
    - d -
        - first_name
        - last_name
        - email
        - password
    - X - POST    

- Endpoint to retrieve a User.
    - cURL -  http://localhost:8020/api/v1/user/:id
    - X - GET
        



