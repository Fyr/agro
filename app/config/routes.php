<?php
	Router::connect('/', array('controller' => 'pages', 'action' => 'home'));
	Router::connect('/pages/', array('controller' => 'pages', 'action' => 'home'));

	Router::connect('/sitemap.xml', array(
		'controller' => 'sitemap',
		'action' => 'xml'
	));
	/*
	Router::connect('/product/:category/:subcategory/page/:page', array(
		'controller' => 'products',
		'action' => 'index',
		'category' => '[a-z0-9\-]+',
		'subcategory' => '[a-z0-9\-]+',
		'page' => '[0-9]+',
		'object_type' => 'products'
	));
	Router::connect('/product/:category/:subcategory/:id', array(
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
	*/
	Router::connect('/zapchasti/:category/:subcategory/page/:page', array(
		'controller' => 'products',
		'action' => 'index',
		'category' => '[a-z0-9\-]+',
		'subcategory' => '[a-z0-9\-]+',
		'page' => '[0-9]+',
		'object_type' => 'products'
	));
	Router::connect('/zapchasti/:category/:subcategory/:id', array(
		'controller' => 'products',
		'action' => 'view',
		'category' => '[a-z0-9\-]+',
		'subcategory' => '[a-z0-9\-]+',
		'id' => '[a-z0-9\-]+',
		'object_type' => 'products'
	));
	Router::connect('/zapchasti/:category/page/:page', array(
		'controller' => 'products',
		'action' => 'index',
		'category' => '[a-z0-9\-]+',
		'page' => '[0-9]+',
		'object_type' => 'products'
	));
	Router::connect('/zapchasti/page/:page', array(
		'controller' => 'products',
		'action' => 'index',
		'page' => '[0-9]+',
		'object_type' => 'products'
	));	
	Router::connect('/zapchasti/:category/:subcategory', array(
		'controller' => 'products',
		'action' => 'index',
		'category' => '[a-z0-9\-]+',
		'subcategory' => '[a-z0-9\-]+',
		'object_type' => 'products'
	));
	Router::connect('/zapchasti/:category', array(
		'controller' => 'products',
		'action' => 'index',
		'category' => '[a-z0-9\-]+',
		'object_type' => 'products'
	));
	Router::connect('/zapchasti', array(
		'controller' => 'products',
		'action' => 'index',
		'object_type' => 'products'
	));	
	Router::connect('/brand/page/:page', array(
		'controller' => 'brands',
		'action' => 'index',
		'page' => '[0-9]+'
	));
	Router::connect('/brand/:id', array(
		'controller' => 'brands',
		'action' => 'view',
		'id' => '[a-z0-9\-]+'
	));
	Router::connect('/brand', array(
		'controller' => 'brands',
		'action' => 'index'
	));
	
	Router::connect('/magazini-zapchastei/page/:page', array(
		'controller' => 'dealers',
		'action' => 'index',
		'page' => '[0-9]+'
	));
	Router::connect('/magazini-zapchastei/:id', array(
		'controller' => 'dealers',
		'action' => 'view',
		'id' => '[a-z0-9\-]+'
	));
	Router::connect('/magazini-zapchastei', array(
		'controller' => 'dealers',
		'action' => 'index'
	));
	
	Router::connect('/dealer/page/:page', array(
		'controller' => 'dealers',
		'action' => 'redirect_old',
		'page' => '[0-9]+'
	));
	Router::connect('/dealer/:id', array(
		'controller' => 'dealers',
		'action' => 'redirect_old',
		'id' => '[a-z0-9\-]+'
	));
	Router::connect('/dealer', array(
		'controller' => 'dealers',
		'action' => 'redirect_old'
	));
	
	Router::connect('/news/page/:page', array(
		'controller' => 'news',
		'action' => 'index',
		'page' => '[0-9]+'
	));
	Router::connect('/news/:id', array(
		'controller' => 'news',
		'action' => 'view',
		'id' => '[a-z0-9\-]+'
	));
	
	Router::connect('/offers/page/:page', array(
		'controller' => 'offers',
		'action' => 'index',
		'page' => '[0-9]+'
	));
	Router::connect('/offers/:id', array(
		'controller' => 'offers',
		'action' => 'view',
		'id' => '[a-z0-9\-]+'
	));
	
	Router::connect('/motors/page/:page', array(
		'controller' => 'motors',
		'action' => 'index',
		'page' => '[0-9]+'
	));
	Router::connect('/motors/:id', array(
		'controller' => 'motors',
		'action' => 'view',
		'id' => '[a-z0-9\-]+'
	));
