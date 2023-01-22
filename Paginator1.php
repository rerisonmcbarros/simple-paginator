<?php


class Paginator{

	private $url;
	private $limit;
	private $ofsset;


	public function __construct(string $url, $limit, $offset = 0){

		$this->url = $url;
		$this->limit = $limit;
		$this->offset = $offset;
	}



}
