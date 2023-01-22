<?php


class Paginator{

	private const STYLE_LINKS = "page-link";
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

		if($number == $this->numberPages){

			$this->numberLinks = $this->numberPages;
		}

		$this->numberLinks = $number;
	}


	public function links(){

		$linksAround = floor($this->numberLinks/2);

		$start = $this->currentPage-$linksAround;
		$end = $this->currentPage+$linksAround;

		if($start <= 1){

			$start = 1;
			$end = $start + ($linksAround*2);
		}

		if($end > $this->numberPages){

			$start = $this->numberPages -($linksAround*2);
			$end = $this->numberPages;
		}


		$templateLinks = '';

		$templateLinks.= "<a class=\"".self::STYLE_LINKS."\" href=\"{$this->url}/?page={$this->previousPage()}\"><<</a>";

		for($i=$start; $i<=$end; $i++){

			if($i == $this->currentPage){

				$templateLinks.= "<span class=\"".self::STYLE_LINKS." active \" href=\"{$this->url}/?page={$i}\">{$i}</span>";
			}
			else{

				if($i >= 1 && $i <= $end ){

					$templateLinks.= "<a class=\"".self::STYLE_LINKS."\" href=\"{$this->url}/?page={$i}\">{$i}</a>";

				}	
			}
			
		}

		$templateLinks.= "<a class=\"".self::STYLE_LINKS."\" href=\"{$this->url}/?page={$this->nextPage()}\">>></a>";

		return $templateLinks;
	}


	public function setCurrentPage(){


		$currentPage = filter_input(INPUT_GET, 'page');

		$this->currentPage = $currentPage ?? 1;
	}

	public function nextPage(){

		if($this->currentPage >= $this->numberPages){

			return $this->currentPage;
		}

		return ($this->currentPage+1);

	}

	public function previousPage(){

		if($this->currentPage <= 1){

			return $this->currentPage;
		}

		return ($this->currentPage-1);

	}


	public function resultFromPage(){

		foreach($this->data as $key => $value){

			if(
				$key < (($this->currentPage*$this->limit)) 
				&&
				$key >= (($this->currentPage*$this->limit)-$this->limit) 
			){

				yield $value;
			}
		}
	}

}




