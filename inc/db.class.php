<?php
/*
Tested:   Yes
Version:  2
*/
class Database{
////////////////Configuration variables////////////////
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;
	private $db_link;
////////////////Operations variables////////////////
	public $txt;
	public $tbl;
	public $idf;
	public $ids;
	public $vals;
	public $flds;
	public $sortby;
	public $cond;
	public $lim;
////////////////Temporary variables////////////////
	private $TMP1;
	private $TMP2;
	private $TMP3;
	private $TMP4;
////////////////Functions////////////////	
	function Database($host, $user, $pass, $name){
		$this->db_host = $host;
		$this->db_user = $user;
		$this->db_pass = $pass;
		$this->db_name = $name;
		$this->Con();
	}
	
	function Con(){
		$this->db_link = mysqli_connect($this->db_host, $this->db_user, $this->db_pass) or die("Can't connect to database server!");
		mysqli_select_db($this->db_link, $this->db_name) or die("The database ".$this->db_name." not found!");
	}
	
	function Sel(){									
		if(!isset($this->flds)){ $this->flds = "*"; }
		if(!isset($this->tbl)){ die("No Table Selected!"); }
		$this->TMP1 = "SELECT ".$this->flds." FROM `".$this->tbl."`";
		if(isset($this->cond)){ $this->TMP1 .= " WHERE ".$this->cond; }
		if(isset($this->sortby)){ $this->TMP1 .= " ORDER BY ".$this->sortby; }
		if(isset($this->lim)){ $this->TMP1 .= " LIMIT ".$this->lim; }
		//die($this->TMP1);
		$this->TMP2 = mysqli_query($this->db_link, $this->TMP1) or die("Error ".mysqli_errno().": ".mysqli_error());
		if(isset($this->flds)){ unset($this->flds); }
		if(isset($this->tbl)){ unset($this->tbl); }
		if(isset($this->cond)){ unset($this->cond); }
		if(isset($this->sortby)){ unset($this->sortby); }
		if(isset($this->lim)){ unset($this->lim); }
		if(isset($this->TMP1)){ unset($this->TMP1); }
		$this->TMP1 = 0;
		$this->TMP3 = array();
		while($this->TMP4 = mysqli_fetch_array($this->TMP2,MYSQL_ASSOC)){
			$this->TMP3[$this->TMP1] = $this->TMP4;
			$this->TMP1++;
		}
		return $this->TMP3;			
	}
	
	function query($txt){
		$this->txt = $txt;
		$out = $this->Sql();
		return $out;
	}
	
	function simple($txt){
		$this->txt = $txt;
		if($this->doSql()) return true;
		return false;
	}
	
	function insertedId(){
		return mysqli_insert_id($this->db_link);
	}
	
	function Sql(){									
		if(!isset($this->txt)){ die("No Text To Execute!"); }
		$this->TMP2 = mysqli_query($this->db_link, $this->txt) or die("Error ".mysqli_errno($this->db_link).": ".mysqli_error($this->db_link));
		if(isset($this->txt)){ unset($this->txt); }
		$this->TMP1 = 0;
		$this->TMP3 = array();
		while($this->TMP4 = mysqli_fetch_assoc($this->TMP2)){
			$this->TMP3[$this->TMP1] = $this->TMP4;
			$this->TMP1++;
		}
		return $this->TMP3;			
	}
	
	function doSql(){									
		if(!isset($this->txt)){ die("No Text To Execute!"); }
		//die($this->txt);
		if(mysqli_query($this->db_link, $this->txt)){
			$this->TMP1 = true;
		}else{
			$this->TMP1 = false;
		}
		if(isset($this->txt)){ unset($this->txt); }			
		return $this->TMP1;
	}
	
	function NumRows(){								
		if(!isset($this->tbl)){ die("No Table Selected!"); }
		$this->TMP1 = "SELECT * FROM `".$this->tbl."`";
		if(isset($this->cond)){ $this->TMP1 .= " WHERE ".$this->cond; }
		//die($this->TMP1);
		$this->TMP2 = mysqli_query($this->db_link, $this->TMP1) or die("Error ".mysqli_errno().": ".mysqli_error());
		$this->TMP3 = mysqli_num_rows($this->TMP2);
		if(isset($this->tbl)){ unset($this->tbl); }
		if(isset($this->cond)){ unset($this->cond); }
		if(isset($this->TMP1)){ unset($this->TMP1); }
		if(isset($this->TMP2)){ unset($this->TMP2); }
		return $this->TMP3;			
	}
	
	function AddNew(){								
		if(!isset($this->tbl)){ die("No table to insert the records in."); }
		if(!isset($this->vals)){ die("No data to insert into the table."); }
		if(is_array($this->vals)){
			$this->TMP1 = implode("', '",$this->vals);
			$this->TMP1 = "'', '".$this->TMP1."' ";
		}else{
			$this->TMP1 = $this->vals;
		}
		$this->TMP1 = str_replace("''","NULL",$this->TMP1);
		$this->TMP2 = "INSERT INTO `".$this->tbl."` VALUES( ".$this->TMP1." )";
		$this->TMP3 = mysqli_query($this->db_link, $this->TMP2) or die("Error ".mysqli_errno().": ".mysqli_error());
		$this->TMP4 = mysqli_insert_id();
		if(isset($this->tbl)){ unset($this->tbl); }
		if(isset($this->vals)){ unset($this->vals); }
		if(isset($this->TMP1)){ unset($this->TMP1); }
		if(isset($this->TMP2)){ unset($this->TMP2); }
		if($this->TMP3 == true){ return $this->TMP4; }else{ return false; }
	}
	
	function Del(){									
		if(!isset($this->tbl)){ die("No table to delete the records from."); }
		if(!isset($this->idf)){ die("The identefier field unknown."); }
		if(!isset($this->ids)){ die("No records identefied ."); }
		if(is_array($this->ids)){
			foreach($this->ids as $this->TMP1){
				mysqli_query($this->db_link, "DELETE FROM `".$this->tbl."` WHERE `".$this->idf."` LIKE '".$this->TMP1."'") or die("Error ".mysqli_errno().": ".mysqli_error());
			}
		}else{
			mysqli_query($this->db_link, "DELETE FROM `".$this->tbl."` WHERE `".$this->idf."` LIKE '".$this->ids."'") or die("Error ".mysqli_errno().": ".mysqli_error());
		}
		if(isset($this->tbl)){ unset($this->tbl); }
		if(isset($this->idf)){ unset($this->idf); }
		if(isset($this->TMP1)){ unset($this->TMP1); }
		if(isset($this->ids)){ unset($this->ids); }
		return true;	
	}
	
	function Ed(){
		if(!isset($this->tbl)){ die("No table to edit it's records."); }
		if(!isset($this->flds)){ die("The fields unknown."); }
		if(!isset($this->vals)){ die("The values unknown."); }
		if(!isset($this->idf)){ die("The identefier field unknown."); }
		if(!isset($this->ids)){ die("The selected record identefier value unknown."); }
		$this->TMP1 = sizeof($this->flds);
		$this->TMP2 = sizeof($this->vals);
		if($this->TMP1 == $this->TMP2 && $this->TMP1 > 0){
			$this->TMP3 = array();
			for($this->TMP2 = 0; $this->TMP2 < $this->TMP1; $this->TMP2++){
				$this->TMP3[$this->TMP2] .= "`".$this->flds[$this->TMP2]."` = '".$this->vals[$this->TMP2]."'"; 
			}
			$this->TMP1 = implode(", ",$this->TMP3);
			$this->TMP1 = str_replace("''","NULL",$this->TMP1);
			//die("UPDATE `".$this->tbl."` SET ".$this->TMP1." WHERE `".$this->idf."` LIKE '".$this->ids."'");
			$this->TMP2 = mysqli_query($this->db_link, "UPDATE `".$this->tbl."` SET ".$this->TMP1." WHERE `".$this->idf."` LIKE '".$this->ids."'") or die("Error ".mysqli_errno().": ".mysqli_error());
			if(isset($this->tbl)){ unset($this->tbl); }
			if(isset($this->flds)){ unset($this->flds); }
			if(isset($this->vals)){ unset($this->vals); }
			if(isset($this->idf)){ unset($this->idf); }
			if(isset($this->ids)){ unset($this->ids); }
			if(isset($this->TMP1)){ unset($this->TMP1); }
			if(isset($this->TMP2)){ unset($this->TMP2); }
			if(isset($this->TMP3)){ unset($this->TMP3); }
			return true;
		}else{
			die("The fields you wanna edit dosn't match with the values you enterd!");	
		}
	}
}
?>