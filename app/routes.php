<?php

$routes[] = ['/', 'ProductController@index'];

// Cadastro dos produtos;
$routes[] = ['/products', 'ProductController@index'];
$routes[] = ['/product/{id}/show', 'ProductController@show'];
$routes[] = ['/product/create', 'ProductController@create'];
$routes[] = ['/product/save', 'ProductController@save'];
$routes[] = ['/product/{id}/edit', 'ProductController@edit'];
$routes[] = ['/product/{id}/update', 'ProductController@update'];
$routes[] = ['/product/{id}/delete', 'ProductController@delete'];

// Cadastro dos tipos de cada produto;
$routes[] = ['/product-types', 'ProductTypeController@index'];
$routes[] = ['/product-type/{id}/show', 'ProductTypeController@show'];
$routes[] = ['/product-type/create', 'ProductTypeController@create'];
$routes[] = ['/product-type/save', 'ProductTypeController@save'];
$routes[] = ['/product-type/{id}/edit', 'ProductTypeController@edit'];
$routes[] = ['/product-type/{id}/update', 'ProductTypeController@update'];
$routes[] = ['/product-type/{id}/delete', 'ProductTypeController@delete'];


// Cadastro dos valores percentuais de imposto dos tipos de produtos;
$routes[] = ['/tax-percentages', 'TaxPercentageController@index'];
$routes[] = ['/tax-percentage/{id}/show', 'TaxPercentageController@show'];
$routes[] = ['/tax-percentage/create', 'TaxPercentageController@create'];
$routes[] = ['/tax-percentage/save', 'TaxPercentageController@save'];
$routes[] = ['/tax-percentage/{id}/edit', 'TaxPercentageController@edit'];
$routes[] = ['/tax-percentage/{id}/update', 'TaxPercentageController@update'];
$routes[] = ['/tax-percentage/{id}/delete', 'TaxPercentageController@delete'];

// Venda
$routes[] = ['/sales', 'SaleController@index'];
$routes[] = ['/sale/{id}/show', 'SaleController@show'];
$routes[] = ['/sale/create', 'SaleController@create'];
$routes[] = ['/sale/save', 'SaleController@save'];
$routes[] = ['/sale/{id}/edit', 'SaleController@edit'];
$routes[] = ['/sale/{id}/update', 'SaleController@update'];
$routes[] = ['/sale/{id}/delete', 'SaleController@delete'];

return $routes;