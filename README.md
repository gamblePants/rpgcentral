# RPGcentral

This repository was created to showcase the PHP forum and online shop I created this year for my Diploma in Web Development. It is not currently hosted as I would like to create some more security (and cosmetic) features before I get it live. The site is mostly built with PHP, MySQL, HTML and CSS, but also has some JavaScript and AJAX functionality. 

![forum.PNG](https://gamblepants.github.io/img/forum.PNG)
<br/><br/>

## Diploma Requirements

To pass the PHP component of my Diploma I had to complete the following requirements for my site:

* A functioning multi-topic forum with database connection to store previous topics and posts. Ensure all links within the application to test functionality are working i.e. easily navigate between topics, threads and related posts. 

* A functioning shopping cart that allows users to fill a shopping cart and stores the checkout details of the shopper in the database. 
  * When someone checks out, it should reduce the inventory in the database.
  * If they decide to remove an item from their cart, it should replace the stock.
  * Optional: have the quantity of items in drop down list populated from the database (done)
 
* Include at least one AJAX feature (I chose pagination for the list of threads and posts displayed)
 
* Should work in IE, Chrome, Firefox and mobile devices

 
## Extra stuff I added

I wanted to make my site look a bit more like a real forum so added a few things in:

* Added session login and logout for the user

* Made it compulsory to login in order to create a new thread or post

* Added some validation for the login page, sign-up page, contact form and checkout page

* Deconstructed my jQuery AJAX functions so I could learn how to do them with Vanilla JS
