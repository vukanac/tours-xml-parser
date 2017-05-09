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
