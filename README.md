# Title: The pokemon challenge - PHP style

- Repository: `challenge-pokemon-php`
- Type of Challenge: `Learning`
- Duration: `3 days`
- Deployment strategy : NA
	
- Team challenge : `solo`

## Learning objectives
- Starting with PHP
    * To be able to write a simple condition and a simple loop
    * To know how to access external resources (API)
- To know where to search for PHP documentation
- To find out how much easier it is to learn a second programming language

## The Mission
Remember the Pokemon challenge we did in Javascript?
Today we are going to re-create this challenge in PHP!

You will be surprised how easy it is to pick a new  language, once you know your first programming language (Javascript).

Take a deep breath, and remember: you can do this!

![Timeline](youcandoit.jpg)

## Tips
Here are a few functions you will need to help you on your way.

- [file_get_contents()](http://php.net/file_get_contents) 
- [json_decode()](http://php.net/json_decode) 
- [var_dump() - to help you debug](http://php.net/var_dump) 

Be careful to get an array, not an object, back from `json_decode()`. Read the documentation how to do this.
You could do it with objects, but it will be more difficult.

## How to search for PHP documentation
PHP has very good documentation available on www.php.net. There is a nice trick you can use to quickly get documentation on any php function. Just type in the browser php.net/FUNCTION_NAME and you will arrive at the correct documentation page. Also spend some time clicking on the "See Also" section at the bottom of each page, this will quickly get you a good overview of what is possible with PHP.

## PHP the right way
Another interesting read is https://phptherightway.com. This is not so much documentation over each separate function, but gives you more an overview of best practices and how different components work together.

### In the branch flow this guidnce
# Title: The Extreme pokemon challenge
- Repository: `challenge-pokemon-php` (You should already have this repo, just make a branch on it.)
- Type of Challenge: `Learning Challenge`
- Duration: `3 days`
- Deployment strategy : `Heroku`
- Team challenge : `solo`

## Javascript or PHP?
This challenge can be done in PHP or Javascript.

## Learning Objectives
- To be able to solve frontend problems in PHP
- To be able to process a form in PHP

## Mission
We are going to use the PHP implementation of the Pokemon challenge you made before, but we are going to expand on it in various steps:

- Make a "category" page where you show 20 pokemon at the time in a grid. Display their picture and name, a make it clickable to go to their overview page.
- At the top and bottom of that "category" page, add a [pagination component](https://getbootstrap.com/docs/4.0/components/pagination/).
- At the top of the page, create a dropdown with all the types (fire, water, ...). When the user selects one, the interface only shows pokemon of that specific type.
- Add a dropdown that changes the amount of pokemon you can see on the category page.
- Make it possible to "favorite" a Pokemon. When you "favor" a pokemon, it shows up at the top of the category page in a separate section labeled "Favorite pokemon". (You can save this in a Cookie.)
- Once a pokemon is favored, add the possibility to mail a friend the url of a favored pokemon with the text "Look at this pokemon, it is so cool!"

