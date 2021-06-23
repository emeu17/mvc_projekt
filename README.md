[![Build Status](https://travis-ci.com/emeu17/mvc_projekt.svg?branch=main)](https://travis-ci.com/emeu17/mvc_projekt)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/emeu17/mvc_projekt/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/emeu17/mvc_projekt/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/emeu17/mvc_projekt/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/emeu17/mvc_projekt/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/emeu17/mvc_projekt/badges/build.png?b=main)](https://scrutinizer-ci.com/g/emeu17/mvc_projekt/build-status/main)

MVC Project Spring 2021
==========

![Dices](public/images/dices.png)

Background
-------------

This is the final project in the course MVC. It is mainly built using PHP,
HTML and CSS. Symfony is used as framework. In order to connect to and read/update
in the MySQL database on the student server the Doctrine ORM (Object-Relational Mapping) is used.

The application
-------------
The application can be reached on
[dbwebb studentserver](http://www.student.bth.se/~emeu17/dbwebb-kurser/mvc/me/proj/public/)
or by installing it locally following the guidelines below.

The landing/home-page gives a small introduction to the project. Navigation goes through
the links in the header, at the top of the page. Here you can choose to play
the game twenty one, check out the Highscore for the game or try out rolling
dices or look into my library which is a page connecting to my MYSQL database and
the table *Library*.

The main attraction of the project is the game twenty one. At the landing page
for the game are instructions to how to play the game. Variables and the class
DiceHand are saved in the session during the gameplay. It is possible to reset the
session to start out a fresh game, or save the current game to the Highscore. This
will save current session variables to the Score table in the database.

The Highscore-page shows the top five scores which is calculated as the number of
wins for the player vs the computers number of wins. Each post has a link to statistics.
This shows statistics for the chosen post - the players dice rolls. It is shown
both as numbers (how many of dice faces 1 through 6 the player has rolled) but
also as a histogram which is a more graphical representation of the dice rolls.

Installing the application
-------------
The github repository can be cloned down and used locally. In order to use the
application locally you need to have a web server for running the pages locally (see
for example [XAMPP](https://www.apachefriends.org/download.html)). You then need to
change in the following files:
* .env - uncomment the *DATABASE_URL* for sqlite
* config/packages/doctrine.yaml - uncomment the *url:* and instead comment everything else under the dbal-section.

This way you will use a database that is saved in the file var/data.db. You also need to through the terminal run the *composer install*. After that you can access the application from the folder public/.
