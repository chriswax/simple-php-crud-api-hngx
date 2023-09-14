# simple-php-crud-api-hngx
Simple Rest API Capable of CRUD Operation on a resource e.g person using Native PHP/MYSQL

## How to Run Application
1. Download application from github and uzip
2. Install Xampp or Wamp on your local Machine
3. Run xampp and place the application "simple-php-crud-api-hngx" the unzipped folder inside htdocs of xampp folder
4. Create Database called "hngx" and import the "person.sql" into the created Database of phpMyAdmin
5. Download and install postman to test the endpoints
6. check below the sample request and endpoint, also you can use the "HNGX_Stage2.postman_collection.json" to test the endpoints

## Postman sample Test collection
This file "HNGX_Stage2.postman_collection.json" located in the root folder is a postman test collection which is used in testing all the endpoints of the API with its sample test data.

## Request/response format of the APIs


GET: http://www.waxworks.name.ng/api.php?slack_name=chriswax&track=backend

GET: http://www.waxworks.name.ng/api
GET: http://www.waxworks.name.ng/api/user_id

Create: Adding a new person
POST: http://www.waxworks.name.ng/api
{
    "name":"name of person e.g Uzoigwe Christian"
}
PUT: http://www.waxworks.name.ng/api/user_id
{
    "name":"name of person e.g Uzoigwe Christian"
}
DELETE: http://www.waxworks.name.ng/api/user_id
