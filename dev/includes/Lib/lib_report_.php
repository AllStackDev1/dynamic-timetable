<?php
  @session_start();
  
  include_once('../Lib/_reportstruct_.php');
  include_once('../Lib/_oreport_struct_.php');
  //include_once('fpdf.php');
  include_once('connect.php');
  
  
  class PDF extends MPDF
  {
	
	
	function ConvertReportsDate($curdate="")
	{
		$szparts = split('-',$curdate);
		$mydate = $szparts[2].'/'.$szparts[1].'/'.$szparts[0];
		return $mydate;
	}
	function ConvertReportsDateA($curdate="")
	{
		$szparts = split('/',$curdate);
		$mydate = $szparts[2].'/'.$szparts[1].'/'.$szparts[0];
		return $mydate;
	}
	
  }
  
  class tPDF extends OPDF{
   
   
  }
  
  class newReportingPDF extends MPDF
  {
	
	private $rep_title;
	private $rep_subtitle;
	private $rep_year;
	private $headerCount;
	private $rep_headers;
	private $rep_headers2;
	private $rep_colwidt;
	private $col_or;
	private $studentid;
	private $studentname;
	
	
  
	
	public function get_Title(){ return $this->rep_title; }
	public function set_Title($titles){  $this->rep_title = $titles; }
	
	public function get_Subtitle(){ return $this->rep_subtitle; }
	public function set_Subtitle($subtitles){  $this->rep_subtitle = $subtitles; }
	
	public function get_year(){ return $this->rep_year; }
	public function set_year($_year){  $this->rep_year = $_year; }
	
	public function get_Headers(){ return $this->rep_headers; }
	public function set_Headers($_headers){  $this->rep_headers = $_headers; }
	
	public function get_Headers2(){ return $this->rep_headers2; }
	public function set_Headers2($_headers){  $this->rep_headers2 = $_headers; }
	
	public function get_colwidth(){ return $this->rep_colwidth; }
	public function set_colwidth($_colwidth){  $this->rep_colwidth = $_colwidth; }
	
	public function get_headerCount(){ return $this->headerCount; }
	public function set_headerCount($_headerCount){  $this->headerCount = $_headerCount; }
	
	public function get_orientation(){ return $this->col_or; }
	public function set_orientation($_col_or){  $this->col_or  = $_col_or; }
	
	public function get_studentname(){ return $this->studentname; }
	public function set_studentname($_studentname) { $this->studentname = $_studentname; }
	
	public function get_showdate(){ return $this->studentname; }
	public function set_showdate($_studentname) { $this->studentname = $_studentname; }
	
	/*function Header()
 	{
	         
	   
			   $this->SetFont('courier','B',12);
			   $this->Cell(0,5, $this->rep_title,0,1,'L');
			   $this->Cell(0,5,$this->rep_subtitle,0,1,'L');
		       $this->Ln(2);
	           $this->SetFont('courier','B',11);
			  
			  if($this->headerCount == 1)
			  {
				for($x=0;$x<count($this->rep_headers);$x++)
				{
				   $col = $this->rep_colwidth[$x];
				   if($x == count($this->rep_headers)-1)
				   {
					   $this->Cell($col,5,$this->rep_headers[$x],0,1,$this->col_or[$x]);
				   }else{
					  $this->Cell($col,5,$this->rep_headers[$x],0,0,$this->col_or[$x]);
				   }
				}
				
			  }else if($this->headerCount == 2)
			  {
				 //$c = count($this->rep_headers);
				for($x=0;$x<count($this->rep_headers);$x++)
				{
				  $col = $this->rep_colwidth[$x];
				   if($x == count($this->rep_headers)-1)
				   {
					   $this->Cell($col,5,$this->rep_headers[$x],0,1,$this->col_or[$x]);
				   }else
				   {
					  $this->Cell($col,5,$this->rep_headers[$x],0,0,$this->col_or[$x]);
				   }
				}
				
				for($t=0;$t<count($this->rep_headers2);$t++)
				{
				  $col = $this->rep_colwidth[$t];
				   if($t == count($this->rep_headers2)-1)
				   {
					  $this->Cell($col,5,$this->rep_headers2[$t],0,1,$this->col_or[$t]);
				   }else {
					  $this->Cell($col,5,$this->rep_headers2[$t],0,0,$this->col_or[$t]);
				   }
				}
				
			  }
			  $this->Ln(2);
			 
	}*/
	
	function footer()
	{
	          $this->SetY(-15);
			  $this->SetFont('courier','',7);
	          $this->Cell(100,10,$_SESSION['org'].' ['.$this->studentname.']',0,0,'L');
		      $this->SetFont('courier','',6);
			  $this->Cell(100,10,'Powered by:[iKolilu : www.ikolilu.com ] Printed Date : '.date('d/m/Y'),0,1,'R'); //}else{  $this->Cell(100,10,'Powered by:[iKolilu : www.ikolilu.com ] Printed Date : '.date('d/m/Y').'  ['.$this->PageNo().'/{nb}]',0,1,'R'); }
		     
	}
   
  }
  
   
  
?>