#  trippi-ubc-cs304-project/README.md


Notes for Nam the CPSC 304 TA marking our project


HOW TO RUN PROJECT

We used composer for php to install all libraries that we used, these libraries all live in the  vendor folder. Normally with version control we keep the Vendor folder in the .gitIgnore and everyone runs:

php composer.phar install

And this would get all necessary libraries intalled be referencing the composer.json.. Since we are submitting the vendor folder techniqually should not have to run the command to get the libraries. However if issue arise you could remove the vendor folder and run:

php composer.phar install

to get all necessary libries.. For this you will need to have php5.6 at least..

The libraries that we have currently running on are project include:

1). "slim/slim": "^3.0",
2). "slim/twig-view": "^2.1",
3). "php-di/slim-bridge": "^1.0",


to run once all libraries are installed or available.. We used XAMPP to run the application on local host so not sure how other servers will work..

to get XAMPP simply go to: https://www.apachefriends.org/index.html  and download.

Using XAMPP place the project folder in the htdocs in XAMPP so ---> XAMPP/htdocs

once the project is here and XAMPP apache and mysql is running you can run the localhost with:

http://localhost/<name of project folder>/public/


However you will need to add the tables to the database to be able to login and stuff.. So to get the database set up simply go to

http://localhost

and then click on phpMyAdmin on the right hand corner..

create a database called DB_trippi

and import trippi.sql found in the project folder.


Notes for The Others, our CS304 group:

- Make sure you pull or place the project to XAMPP/htdocs

- Make sure you have intalled composer https://getcomposer.org into the project folder

- You might need to update PHP to 5.6 for composer to work properly when building certain libraries

- Once you have composer working, run php composer.phar install on the terminal

- Once you have XAMPP running with Apache, and MySQL running, you can run the app with http://localhost/<*name of project folder*>/public/
