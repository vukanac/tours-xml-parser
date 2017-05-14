XML Parser
==========


In the following task you are given an XML text representing set of tours, and you have to convert it into the text in required format.

Write a function `xmlToCSV($text)` that parses an input text in **XML** format (presented below) and converts it to the text in delimited format (also presented below).

* **Input XML** text contains the elements representing set of tours.
* **Output text** represents compressed and simpler form of XML.


Output comments:

* "Title" is a string, with html entities (like '&amp;') converted back to symbols
* "Code" is a string
* "Duration" is an integer
* "Inclusions" is a string (just simple text: without html tags, double or triple spaces; with html entities converted back to symbols)
* "MinPrice" is a float with 2 digits after the decimal point; it's the minimal EUR value among all tour departures, taking into account the discount, if presented (for example, if the price is 1724 and the discount is "15%", then the departure price evaluates to 1465.40).


Output format:

	Title|Code|Duration|Inclusions|MinPrice|
	Tour title|AE-19|18|The tour price cover all services|2121.20


Instalation
-----------

Download or clone repository:

    $ git clone https://github.com/vukanac/tours-xml-parser.git

Install required libraries:

    $ composer install


Example of use
--------------

Project have samle file with a tours `data/tours.xml`. In process, the complex data stracture will be converted to a simpler, pipe (`|`) separated fields in file `data/tours.csv`.

    $ php index.php

For php memory limit of 128MB it is possible to convert 20.000 tours in xml structure.

    $ php test_20k.php
