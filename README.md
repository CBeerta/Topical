# Topcial

Topical is a Simple PHP Application to Plan your day-to-day activity. It is not a long term Todo List Management Application, never will be.

# Quick Install

    % git clone https://github.com/CBeerta/Topical.git
    % cd Topical
    % git submodule init
    % git submodule update
    
# Requirements

* PHP >= 5.3
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

# Keyboard Navigation

* a, n: Add Task
* left, right: Navigate through Time
* Pos1: Go back to Today


