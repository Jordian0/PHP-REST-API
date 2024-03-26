# What is API
Application Program Interface <br>
Contract provided by one piece of software to another <br>
Structure request and response

# What is REST [Representational State Transfer](https://ics.uci.edu/~fielding/pubs/dissertation/rest_arch_style.htm)
Representational State Transfer<br>
Architecture style for designing networked applications<br>
Relies on a stateless, client-server protocol, almost always HTTP, treats server objects as resources that can be 
created or destroyed<br>
Can be used by virtual any programming language.



## HTTP Methods
- GET : retrieve data from a specified resource
- POST : submit data to be processed to a specified resource
- PUT : update a specified resource
- DELETE : delete a specified resource
- HEAD, OPTIONS, PATCH


# PHP PDO
Using PHP PDO to create REST API with JWT


# structure
model will connect with database and is referring to DB modal.<br>
config will have configuration files.<br>
api folder containing requests files.<br>
Headers in PHP help us to view data in a well manner<br>

# SWAGGER UI
[swagger.ui](https://petstore.swagger.io/)<br>
configuring composer and swagger ui<br>
composer require zircote/swagger-php ^3.2.0  (version 3.2.0 is required!)\
required composer for the project \
https://zircote.github.io/swagger-php/guide/ \
change localhost in swagger-initializer.js in the dist directory \
change the directory in api.php accordingly to the server configuration \

