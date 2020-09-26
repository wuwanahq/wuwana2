<?php
/**
 * Controller for the home page.
 * @link http://wuwana.com/
 */

require 'Model/Company.php';
$companies = [];

for ($i=rand(7,20); $i > 0; --$i)
{ $companies[] = Company::getRandomCompany(); }

require 'homepage/view.php';