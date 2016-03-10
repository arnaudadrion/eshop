<?php

	//	Définition des racines
	define('SERVER_ROOT', __DIR__);
	define('CLIENT_ROOT', str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__));
//var_dump(CLIENT_ROOT, SERVER_ROOT);
	//	Préparation de l'autochargement des classes
	spl_autoload_register(function($className)
	{
		//	Si le fichier correspondant à la classe demandée existe dans le dossier « core »
		if(file_exists(SERVER_ROOT.'/core/'.$className.'.php'))
		{
			//	Inclusion de la classe demandée
			include SERVER_ROOT.'/core/'.$className.'.php';
		}
		//	Sinon, si le fichier correspondant à la classe demandée existe dans le dossier « controllers »
		else if(file_exists(SERVER_ROOT.'/controllers/'.$className.'.php'))
		{
			//var_dump(SERVER_ROOT.'/controllers/'.$className.'.php');
			//	Inclusion de la classe demandée
			include SERVER_ROOT.'/controllers/'.$className.'.php';
		}
		//	Sinon, si le fichier correspondant à la classe demandée existe dans le dossier « models »
		else if(file_exists(SERVER_ROOT.'/models/'.$className.'.php'))
		{
			//	Inclusion de la classe demandée
			include SERVER_ROOT.'/models/'.$className.'.php';
		}
	});

	//	Définition du nom du contrôleur
	$controllerName = ucfirst($_GET['controller']).'Controller';
	//	Définition du nom de l'action
	$actionName = $_GET['action'].'Action';
//var_dump($controllerName, $actionName);
	//	Si le contrôleur demandé existe
	if(class_exists($controllerName))
	{
		//	Instanciation du contrôleur demandé
		$controller = new $controllerName();

		//	Si l'action demandée existe
		if(method_exists($controller, $actionName))
		{
			//	Exécution de l'action demandée
			$controller->$actionName();
		}
		else
		{
			//	Page inexistante
			exit('Page inexistante');
		}
	}
	//	Si le contrôleur demandé n'existe pas
	else
	{
		//	Page inexistante
		exit('Page inexistante');
	}