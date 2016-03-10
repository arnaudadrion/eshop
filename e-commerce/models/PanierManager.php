<?php
class PanierManager extends Manager{

	public function __construct(){		
		if(session_status() !== PHP_SESSION_ACTIVE)
			{
				//	Démarrage de la session
				session_start();
			}
			//	Génération d'un nouvel identifiant de session
			session_regenerate_id();
	}

	public function getIds(){
		foreach ($_SESSION['panier'] as $key => $value) {
				$ids[]=$value['id'];				
			}
		return $ids;
	}

	public function getQuantity(){
		foreach ($_SESSION['panier'] as $key => $value) {
				$quantity[]=$value['quantite'];				
			}
		return $quantity;
	}

	public function ajouter($id, $quantite){		
		$_SESSION['panier'][]=['id'=>$id,'quantite'=>$quantite];
	}

	public function remove($id){
		foreach ($_SESSION['panier'] as $key=>$value) {
			if ($_SESSION['panier'][$key]['id']==$id){
				array_splice($_SESSION['panier'], $key,1);
				
			}
		}		
	}

	public function delete(){
		unset($_SESSION['panier']);
	}

	public function modify(array $quantity){
		foreach ($quantity as $key=>$value) {
			$_SESSION['panier'][$key]['quantite']=$quantity[$key];
		}	
	}

	public function setUser($user){
		$_SESSION['user']=$user;
	}

	public function getUser(){
		if(array_key_exists('user', $_SESSION)){
			$user=$_SESSION['user'];
		}
		else{
			$user=[];
		}
		return $user;
	}

	
}