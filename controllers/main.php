<?php
/**
* Topical - Topical is a Simple PHP Application to Plan your day-to-day activity. 
*
* PHP Version 5.3
*
* Copyright (C) 2011 by Claus Beerta <claus@beerta.de>
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*
* @category Todo
* @package  Topical
* @author   Claus Beerta <claus@beerta.de>
* @license  http://www.opensource.org/licenses/mit-license.php MIT License
* @link     http://claus.beerta.de/
**/


/**
* Main Controller
*
* @category Todo
* @package  Topical
* @author   Claus Beerta <claus@beerta.de>
* @license  http://www.opensource.org/licenses/mit-license.php MIT License
* @link     http://claus.beerta.de/
**/
class Main
{
    /**
    * Builds the main index page from the initial load.
    *
    * @param string $day Day to load
    *
    * @return html
    **/
    public static function index( $day )
    {
        $day = $day ? $day : date('Y-m-d');
        set('day', $day);

        set('todolist', Task::index($day));
        set('calendar', Calendar::index($day));

        return html('main.html.php');
    }

     /**
    * Help Dropdown
    *
    * @return html
    **/
    public static function help()
    {
        return partial("snippets/help.html.php");
    }

}
