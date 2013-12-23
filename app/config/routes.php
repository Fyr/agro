<?php
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'home'));
	Router::connect('/pages/', array('controller' => 'pages', 'action' => 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */

	Router::connect('/sitemap.xml', array(
		'controller' => 'sitemap',
		'action' => 'xml'
	));
	
	Router::connect('/product/:category/:subcategory/page/:page', array(
		'controller' => 'products',
		'action' => 'index',
		'category' => '[a-z0-9\-]+',
		'subcategory' => '[a-z0-9\-]+',
		'page' => '[0-9]+',
		'object_type' => 'products'
	));
	Router::connect('/product/:category/:subcategory/:id.html', array(
		'controller' => 'products',
		'action' => 'view',
		'category' => '[a-z0-9\-]+',
		'subcategory' => '[a-z0-9\-]+',
		'id' => '[a-z0-9\-]+',
		'object_type' => 'products'
	));
	Router::connect('/product/:category/page/:page', array(
		'controller' => 'products',
		'action' => 'index',
		'category' => '[a-z0-9\-]+',
		'page' => '[0-9]+',
		'object_type' => 'products'
	));
	Router::connect('/product/page/:page', array(
		'controller' => 'products',
		'action' => 'index',
		'page' => '[0-9]+',
		'object_type' => 'products'
	));	
	Router::connect('/product/:category/:subcategory', array(
		'controller' => 'products',
		'action' => 'index',
		'category' => '[a-z0-9\-]+',
		'subcategory' => '[a-z0-9\-]+',
		'object_type' => 'products'
	));
	Router::connect('/product/:category', array(
		'controller' => 'products',
		'action' => 'index',
		'category' => '[a-z0-9\-]+',
		'object_type' => 'products'
	));
	Router::connect('/product/', array(
		'controller' => 'products',
		'action' => 'index',
		'object_type' => 'products'
	));	
	
	Router::connect('/brand/page/:page', array(
		'controller' => 'brands',
		'action' => 'index',
		'page' => '[0-9]+'
	));
	Router::connect('/brand/:id.html', array(
		'controller' => 'brands',
		'action' => 'view',
		'id' => '[a-z0-9\-]+'
	));
	Router::connect('/brand/', array(
		'controller' => 'brands',
		'action' => 'index'
	));
?>