<?php


class Paginator{

	private $url;
	private $limit;
	private $ofsset;

	private $data;

	public function __construct(string $url, $limit, $offset = 0){

		$this->url = $url;
		$this->limit = $limit;
		$this->offset = $offset;
	}


	public function setData(array $data){

		foreach($data as $value){

			$this->data[] = $value;
		}

	}

}



// TESTES //


$pdo = new \PDO("mysql:host=localhost;port=3306;dbname=users", "root", "");

$stmt = $pdo->prepare("select * from users");

$stmt->execute();

$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

$paginator = new Paginator("url", 10, 1);

$paginator->setData($result);

echo "<pre>", var_dump($paginator), "</pre>";