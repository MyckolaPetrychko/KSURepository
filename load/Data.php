<?php
	class Data {
		public $author = array();
		public $title = array();
		public $speciality = array();
		public $year = array();
		public $info = array();
		public $download = array();
		public $type = array();

		public function __construct($author, $title, $speciality, $year, $info, $download, $type){
			$this->author = $author;
			$this->title = $title;
			$this->speciality = $speciality;
			$this->year = $year;
			$this->info = $info;
			$this->download = $download;
			$this->type = $type;
		}

	}
