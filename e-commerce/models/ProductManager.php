<?php
class ProductManager extends Manager{
	public function getAllProducts ($page=1){
		$requete='SELECT id, name, imagePath,ROUND(priceHT * (1 + VATRate / 100), 2) AS priceTTC, idCategory FROM Products LIMIT ?,?';
		
		$resultset=$this->getDataBaseConnection()->prepare($requete);
		
		$resultset->bindValue(1, ($page-1)*AfficherController::NUMBER_PER_PAGE, PDO::PARAM_INT);
		
		$resultset->bindValue(2, AfficherController::NUMBER_PER_PAGE, PDO::PARAM_INT);
		
		$resultset->execute();
		
		$products=$resultset->fetchAll();
		return $products;
	}

	public function getAllCount(){
		$requete='SELECT COUNT(id) as numbers FROM Products';
		
		$resultset=$this->getDataBaseConnection()->query($requete);
		
		$number=$resultset->fetch();
		return $number;
	}

	public function getProductsByCategory($id, $page=1){
		$requete='SELECT Products.id, Products.name, imagePath, ROUND(priceHT * (1 + VATRate / 100), 2) AS priceTTC, Products.idCategory 
				FROM Products 
				INNER JOIN Categories ON Products.idCategory=Categories.id 
				WHERE Categories.id=?
				LIMIT ?,?';
		
		$resultset=$this->getDataBaseConnection()->prepare($requete);
		
		$resultset->bindValue(1, $id, PDO::PARAM_INT);
		
		$resultset->bindValue(2, ($page-1)*AfficherController::NUMBER_PER_PAGE, PDO::PARAM_INT);
		
		$resultset->bindValue(3, AfficherController::NUMBER_PER_PAGE, PDO::PARAM_INT);
		
		$resultset->execute();
		
		$products=$resultset->fetchAll();
		return $products;
	}
	/*
	public function getProductsByCategory($id){
		$requete='SELECT Products.id, Products.name, imagePath, priceHT, Products.id_category 
				FROM Products 
				INNER JOIN Categories ON Products.id_category=Categories.id 
				WHERE Categories.id=?';
		$resultset=$this->getDataBaseConnection()->prepare($requete);
		$resultset->execute($id);
		$products=$resultset->fetchAll();
		return $products;
	}
*/
	public function getByCategoryCount($id){
		$requete='SELECT COUNT(Products.id) as numbers FROM Products 
				INNER JOIN Categories ON Products.idCategory=Categories.id 
				WHERE Categories.id=?';
		$resultset=$this->getDataBaseConnection()->prepare($requete);
		
		$resultset->execute($id);
		
		$number=$resultset->fetch();
		return $number;
	}

	public function getOneProduct($id){
		$requete='SELECT id, name,description, imagePath,ROUND(priceHT * (1 + VATRate / 100), 2) AS priceTTC, idCategory FROM Products WHERE id=?';
		
		$resultset=$this->getDataBaseConnection()->prepare($requete);
		
		$resultset->execute($id);
		
		$product=$resultset->fetch();
		return $product;
	}
	
	public function getResearch($id, $page=1){
		$requete='SELECT id, name, imagePath,ROUND(priceHT * (1 + VATRate / 100), 2) AS priceTTC, idCategory 
				FROM Products
				WHERE Products.name LIKE ?
				LIMIT ?,?';
		
		$resultset=$this->getDataBaseConnection()->prepare($requete);
		
		$resultset->bindValue(1, '%'.$id.'%', PDO::PARAM_STR);
		
		$resultset->bindValue(2, ($page-1)*AfficherController::NUMBER_PER_PAGE, PDO::PARAM_INT);
		
		$resultset->bindValue(3, AfficherController::NUMBER_PER_PAGE, PDO::PARAM_INT);
		
		$resultset->execute();
		
		$products=$resultset->fetchAll();
		return $products;
	}
	/*
	public function getResearch($id){
		$requete='SELECT Products.id, Products.name, imagePath, priceHT 
				FROM Products
				WHERE Products.name LIKE ?';
		$resultset=$this->getDataBaseConnection()->prepare($requete);
		$resultset->execute(['%'.$id.'%']);
		$products=$resultset->fetchAll();
		return $products;
	}
*/
	public function getResearchCount($id){
		$requete='SELECT COUNT(Products.id) as numbers FROM Products
		WHERE Products.name LIKE ?';
		
		$resultset=$this->getDataBaseConnection()->prepare($requete);
		
		$resultset->execute(['%'.$id.'%']);
		
		$number=$resultset->fetch();
		return $number;
	}

	public function getDetail (array $id){
		$requete='SELECT id, name,ROUND(priceHT * (1 + VATRate / 100), 2) AS priceTTC FROM Products WHERE id IN ('.implode(',',array_fill(0, count($id), '?')).')';

		$resultset=$this->getDataBaseConnection()->prepare($requete);
		
		foreach ($id as $key => $value) {
			$resultset->bindValue($key+1, $value, PDO::PARAM_INT);
		}

		$resultset->execute();
		
		$products=$resultset->fetchAll();
		return $products;
	}

}