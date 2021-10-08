# Solution For Case Study: Financial Website

## Introduction

This is 'Alabbas Alhaj Ali' Solution for this case study provided from 
Solvians company. As part of the evaluation to join the company as a PHP 
Developer.

## Notes:

1. I have used doctrine ORM for object mapping, also it is possible to use 
Zend_Db as an alternative. but I prefer doctrine, beacouse it seems to provide 
more compatible code using Annotation instead of PHP configuration.

2. I have divided the solution into multiple modules. that is how I saw the 
connection between the classes and depending on making the solution more 
usable in future extension.

3. I didn't complete the addAction, editAction and deleteAction. or even 
considered to complete other action related to display other objects. 
that is beacouse I didn't see this as part of the case study. put it is obvious 
how this going to be.

4. to solve the inheritance problem of the classes Certificate, BonusCertificate
 and GuaranteeCertificate we have have 3 ways to implement inheritance here:
    
    - Single Table per Class Hierarchy Strategy:
        using one table for the entire class hierarchy tree and use 
        discriminator column to distinguish between classes . 
        Pros: It is fast in terms of query time. 
        Cons: Not normalized and there is no clear separation.
    - Table per Concrete Class Strategy:
        Uses dedicated table for each concrete class.
        Pros: Fast in terms of query time.
        cons: Not completely normalized. shared properties occur in all tables.
    - Joined Subclass Strategy
        Table for parent class and separated tables for each concrete class.
        Pros: More normalized solution
        Cons: slow query (need to do join with the parent table in order to 
        load the required properties)

The chose of the way depends on the access patterns. I have chose to implement 
Joined Subclass Strategy, i see this Strategy is the best is this case.

5. I have included a Class Diagram for the solution, so pleas take a look at 
file './data/ClassDiagram.png'.


## Run the Solution :

1. Please make sour to run - composer install 
2. Run the command 
    > php -S 0.0.0.0:8080 -t public public/index.php 
    and then open the browser to http://localhost:8080 should appear the home page.
3. Please make sour to request the URL  http://localhost:8080/initialize
    ones to create a Mock database and insert Mock data for testing purpose. 
    the page will redirect to index page after a wail.
4. Run the tests in next section to mack sour everything going fine.
5. Test the Solution from index page.

-- the file ./data/schema.sql includes the database schema and Mock data 
in case you need to change the connection configuration to use MySQL DB 
instade of Sqlite DB.

## Run The Test Cases :

I have implement some test cases to make sour that my code is working fine, So 
in each Module the are Tests for the controllers ,the model and the database 
connection. Some of test cases will be failures will the code are not fully 
implemented. 
To run the tests , please run the command 
    "vendor/bin/phpunit" --testsuite [ModuleName]
in the root folder of the project.

Have Fun :)
