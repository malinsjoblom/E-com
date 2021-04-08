# E-com REST API


<h3>Individual assignment in System development </h3>
Doing an API for an e-commerce platform, you can administrate products, get products, sort products and user administration for customers
<br />
<h3> Built with PHP 8 </h3>
<br />
<h4> Requirements </h4>
* PHP 8 or older
* Apache such as XXAMP or MAMP 
* Database tool such as phpmyadmin or mysql workbench
<h4> Installation</h4>

1. Create a database called 'webshop' in your database tool
2. Unzip the zip file called database.sql and go to import in your db tool
3. Import the db file called database.sql
4. Start Apache (ex. XXAMP) 
5. Go to localhost in your URL field and start by v1, users, createUser.php
6. Then login with your username and password at v1, users, login.php
7. Continue with the tasks that you want to try.


<h3> ERROR CODES - <br /> </h3>

'statusCode': 0001 = The user does not exist, you need to register

'statusCode': 0002 = A token is needed to proceed 

'statusCode': 0003 = This Token is invalid

'statusCode': 0004 = You need an ID to specifiy a user

'statusCode': 0005 = Could not execute this query   

'statusCode': 0006 = The product has the same values as an already existing product

'statusCode': 0007 = All fields needs to be filled

'statusCode': 0009 = The product already exists in the cart

'statusCode': 0010 = The product id does not exist 

'statusCode': 0011 = The id for the product or user is not specified

'statusCode': 0012 = The product dosen't match the user's cart


