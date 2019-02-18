<?php
	class CreateFunction 
	{
		protected $apiPathURL;
		
		public function __construct($apiPathURL)
		{

			$this->apiPathURL = $apiPathURL;

		}

		public function GetEndPoint()
		{
			if($this->apiPathURL){
				$this->requestinfo = explode('/',$this->apiPathURL);
				$this->requestinfoCount = count($this->requestinfo) - 2;
				$this->endpoint = $this->requestinfo[$this->requestinfoCount];
				return $this->endpoint;
			}
		}
	}