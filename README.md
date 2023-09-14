# simple-php-crud-api-hngx
Simple API CRUD Operation using PHP/MYSQL

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
