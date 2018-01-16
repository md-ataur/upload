<?php
	/**
	* Database.php
	*/
	class Database{
		private $host   = DB_HOST;
		private $user   = DB_USER;
		private $pass   = DB_PASS;
		private $dbname = DB_NAME;

		public $link;
		public $error;

		function __construct(){
			$this->connectDB();
		}

		public function connectDB(){
			$this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
			if(!$this->link){
				$this->error = "DB Connection failed".$this->link->connect_error;
				return false;
			}
		}

		// Data insert
		public function insert($data){
			$getData = $this->link->query($data) or die($this->link->error.__LINE__);
			if($getData){
				return $getData;
			} else{
				return false;
			}
		}

		// Data select
		public function select($data){
			$getData = $this->link->query($data) or die($this->link->error.__LINE__);
			if($getData->num_rows > 0){
				return $getData;
			} else{
				return false;
			}
		}

		// Data Delete
		public function delete($data){
			$getData = $this->link->query($data) or die($this->link->error.__LINE__);
			if($getData){
				return $getData;
			} else{
				return false;
			}
		}
	}
?>