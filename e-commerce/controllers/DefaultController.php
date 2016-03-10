<?php
	class DefaultController extends Controller
	{
		public function defaultAction()
		{
			header('Location:'.CLIENT_ROOT.'/afficher/all/');
			
		}
	}