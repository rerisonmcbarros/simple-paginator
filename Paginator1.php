<?php


class Paginator{

	private $url;
	private $limit;
	private $ofsset;

	private $numberPages;
	private $numberLinks;

	private $currentPage;

	private $data;

	public function __construct(string $url, $limit, $offset = 0){

		$this->url = $url;
		$this->limit = $limit;
		$this->offset = $offset;
		$this->setCurrentPage();
	}


	public function setData(array $data){

		foreach($data as $value){

			$this->data[] = $value;
		}

		$this->setNumberPages();

	}

	public function setNumberPages(){

		if(count($this->data) <= $this->limit){

			$this->numberPages = 1;
		}

		$this->numberPages = ceil(count($this->data)/$this->limit);
	}


	public function setNumberLinks($number){

		$this->numberLinks = $number;
	}


	public function links(){

		$linksAround = floor($this->numberLinks/2);

		$start = $this->currentPage-$linksAround;
		$end = $this->currentPage+$linksAround;

		if($start < 1){

			$start = 1;
			$end = $start + ($linksAround*2);
		}

		if($end > $this->numberPages){

			$start = $this->numberPages -($linksAround*2);
			$end = $this->numberPages;
		}


		$templateLinks = '';

		for($i=$start; $i<=$end; $i++){

			if($i == $this->currentPage){

				$templateLinks.= "<span href=\"{$this->url}/?page={$i}\">{$i}</span>";
			}
			else{

				$templateLinks.= "<a href=\"{$this->url}/?page={$i}\">{$i}</a>";
			}
			
		}

		return $templateLinks;
	}


	public function setCurrentPage(){

		$currentPage = filter_input(INPUT_GET, 'page');

		$this->currentPage = $currentPage;
	}

}



// TESTES //


$pdo = new \PDO("mysql:host=localhost;port=3306;dbname=users", "root", "");

$stmt = $pdo->prepare("select * from users");

$stmt->execute();

$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

$paginator = new Paginator("/Paginator/Paginator1.php", 5, 1);

$paginator->setData($result);

$paginator->setNumberLinks(5);

echo $paginator->links();


echo "<pre>", var_dump($paginator), "</pre>";