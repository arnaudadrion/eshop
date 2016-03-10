<?php 
class CategoryManager extends Manager {
	public function getCategories(){
		$requete='SELECT Categories.name, Categories.id, count(Products.idCategory) as nombre 
				FROM Categories
				INNER JOIN Products ON Categories.id=Products.idCategory  
				GROUP BY Products.idCategory 
				HAVING count(Products.idCategory)>0
				ORDER BY Categories.id';
		$result=$this->getDataBaseConnection()->query($requete);
		$categories=$result->fetchAll();
		return $categories;
	}
}