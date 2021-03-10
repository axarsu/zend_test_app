# BuchhaltungsButler Coding Conventions

Please always code, style, format and name by these conventions!

## IDE Setup and Code Inspections

* working with an IDE like PhpStorm, code inspections are done automatically. As a general rule, please always try to keep them green. Exceptions to that rule are possible, but there should be a good reason for that.
* it will help you a lot to setup your IDE's auto-formatting settings so that they comply with these conventions as specified below

## Argument PHPDoc

* please always annotate your functions as precisely as possible with the expected parameters and their types as well as the return values
* If a certain type of object is mandatory for a function argument, also specify it directly in the function arguments (e.g. write User $user instead of just $user)
* a short description of what the function is doing can be helpful

## Comments

* always comment your code (in English)!
* explain what you are doing, in short notes if clear, but also in plain english sentences if necessary – use common sense regarding the extent, but always make sure another developer not familiar with the task can easily understand what's going on there! 
* clearly state todos (e.g. todo: xx)
* if applicable, advice/make notes in your comments on what implications or consequences to be specifically careful about when maintaining the code
* please also use comments in the javascript code within the *.script.phtml template files; this has not been done so far but shall be picked up from now on as the comments are automatically filtered during minification and won't be visible to the user

## Indentations

* always use spaces instead of tabs
* PHP Code: 4 spaces
* HTML, JavaScript, CSS/LESS Code: 2 spaces

## Braces

* classes and function definitions: brace in next line
* everywhere else (if, loop, ..): brace in same line
* spaces: no leading and trailing spaces within round braces; 1 space before and after &&, || etc; 1 space in between round and curly brace

## General Naming

* please try to keep your class/function/variable names as descriptive as possible so that looking at their names already gives a very good idea of what they are doing. If in doubt, rather use a longer name than shortening it in a way that the context gets lost

## Variable Names

* in general: always use camelCase (starting with a lower case letter)
* within db-table-models: if a variable refers directly to a db column, use the db column name as variable name, e.g. $first_name
* public class variables: no leading underscore; e.g. $myVariable, $this->myVariable
* protected and private class variables: 1 leading underscore; e.g. $_myVariable, $this->_myVariable

## Class Names

* follow ZF conventions, i.e. use CamelCase (starting with a capital letter) matching the filename

## Function Names

* always use camelCase (starting with a lower case letter)
* follow ZF conventions for functions refering to actions accessible by URL, i.e. finish name with "Action"; e.g. indexAction
* for actions that are intended only to be called by ajax, begin name with "ajax", e.g. ajaxShowSomethingAction

## Boolean and NULL types

* always write in lower case – e.g. true, false, null
* note: in contrast to this, NULL in sql statements should be written in all capital letters

## Database Column Names

* only lower case letters, use underscores; e.g. first_name

## Database Collation

* utf8_general_ci

## File Names

* follow ZF conventions, i.e.:
* use CamelCase (starting with a capital letter) for PHP files representing classes
* use hyphens and all lower case letters for view scripts (PHTML) matching actions; e.g. ajax-show-something.phtml
* use all lower case letters for configuration files

## Form Input Field Names

* only lower case letters, use underscores; e.g. first_name

## CSS/LESS

* always encapsulate your styles that are specific for certain sections and elements by wrapping into the class names refering to controller (CamelCase starting with an upper case letter) and action (hyphen-case with lower case letters), e.g. .NewReceipts.just-a-test - those class names are always also to be set in the main view script (xyz.phtml utilizing the layout's content partial)
* keep to the current structure in webapp.less!
* reuse/apply general classes (e.g. in general.less and other includes) when possible, minimze double-styling
* correctly distinguish classes (general) and ids (unique)
* do not hardcode color values, font names etc., always use the appropriate variable names from definitions.less!
* never use !important (there are very very few cases in which it might be acceptable)



This list is not complete and does not cover all areas. Also, there will always be cases that are not quite clear. So if you have any questions or are in doubt, please ask! Also, you will find examples of existing code that does not follow these standards. That can always happen, but still, we are trying to keep to the guidelines. So feel free to point out your findings to the responsible developer.
