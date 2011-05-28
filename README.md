# Topcial

Topical is a Simple PHP Application to Plan your day-to-day activity. It is not a long term Todo List Management App.

# Quick Install

    % git clone git://github.com/CBeerta/Topical.git
    % cd Topical
    % git submodule sync
    % git submodule update
    
# Requirements

* PHP >= 5.2
* PHP PDO SQLite
* PHP Posix Extensions
* PHP Socket Functions (For the Embedded Server)

    
# Running the Embedded Server

The easiest way to have a quick look at the Application is to use the included Webserver:

    % php app.php
    
Then connect to http://localhost:3001/ and you should be good to go. (Do _NOT_ put this thing on the Internet)

# Installation on a Webserver

Simply put the Application Directory in a Directory on your webserver, and point your browser to it.

# Configuration

There are a few Options you can tweak in the `config.ini`. 

A good idea is to move the `planner.db` Database File outside the document root.

