<?php
/**
 * Tato třída je pouze vzorová.
 * V MVC by toto byl Controller a před Model by se dotazoval do DB buďto na jeden konkrétní produkt nebo všechny produkty.
 * Pro vzorové účely jsem naplnil produkty jednoduše do pole $products a mají jen ID a název. V reálném případě by se vracelo pole hodnot z DB dle vybraného SELECTu.
 * Pokud by se tedy tabulka v DB rozšířila, tak by se jen upravil SELECT v modelu.
 * V MVC bych volání API řešil tak, že by zde byl např. listAction, který by se volal na URL https://..../list a ten by volal getAllProducts - vrátí všechny produkty.
 * Následně pro jeden vybraný produkt bych mohl volat URL https://..../list/5 a listAction by dle uvedeného parametru (5) volal getProduct(5) - vrátí produkt s ID = 5.
 */
Class Products {
	
    //pro vzorové účely naplněno pole. V reálném případě by se zde mohly načíst produkty z DB
    private $products = array(
		1 => 'Product 1',  
		2 => 'Product 2',  
		3 => 'Product 3',  			
		4 => 'Product 4',  			
		5 => 'Product 5',  
		6 => 'Product 6');
		
	
    //vrátí všechny produkty
    public function getAllProducts(){
        $request = $_SERVER['HTTP_ACCEPT'];
        $this->setHttpHeaders($request, 200);

		return $this->encodeJson($this->products);
    }
    
	
    //vrátí produkt podle jeho ID
    public function getProduct($id){
		
        $product = array($id => ($this->products[$id]) ? $this->products[$id] : $this->products[1]);
        
        if (empty($product)) {
            $status = 404;
            $product = array('error' => 'Nenalezen žádný produkt!')
        } else {
            $status = 200
        }

        $request = $_SERVER['HTTP_ACCEPT'];
        $this->setHttpHeaders($request, $status);
    
		return $this->encodeJson($product);
    }

    
    public function setHttpHeaders($contentType, $statusCode){
		
		header("HTTP/1.1 ". $statusCode ." ". $this->getStatusMessage(statusCode));		
		header("Content-Type:". $contentType);
    }

    
    public function getStatusMessage($statusCode)
    {
        //pouze příklad - měly by tu být asi všechny možné stavy
        $httpStatus = array(
			200 => 'OK',  
            404 => 'Not Found',
            500 => 'Internal Server Error'  
        );

        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];
    }
}