<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/** Document
 * Call link button : echo $this->xpagination->pageNumbers();
 * Call option select item : echo $this->xpagination->itemsPerPage();
 **/
class xpagination {

public $itemsPerPage;
public $range;
public $currentPage;
public $total;
public $textNav;
private $_navigation;		
public $_link;
private $_pageNumHtml;
private $_itemHtml;

public function __construct()
{
	//set default values
	$this->itemsPerPage = 5;
	$this->range        = 3;
	$this->currentPage  = 1;		
	$this->total		= 0;
    $this->_link         = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING);
	$this->textNav 		= true;
	$this->itemSelect   = array(5,25,50,100,'All');	
    $this->_navigation  = array(
			'next'=>'&raquo;',
			'pre' =>'&laquo;',
			'ipp' =>'Item per page'
	);			
	$this->_pageNumHtml  = '';
	$this->_itemHtml 	 = '';
}

/**
 * paginate main function
 * @access              public
 * @return              type
 */
public function paginate($param="page")
{
	//get current page
	if(isset($_GET[$param])){
		$this->currentPage  = $_GET[$param];		
	}			
	//get item per page
	if(isset($_GET['item'])){
		$this->itemsPerPage = $_GET['item'];
	}			
	//get page numbers
	$this->_pageNumHtml = $this->_getPageNumbers($param);			
	//get item per page select box
	$this->_itemHtml	= $this->_getItemSelect();	
}
		
/**
 * return pagination numbers in a format of UL list
 * 
 * @author              ntson1009
 * @access              public
 * @param               type $parameter
 * @return              string
 */
public function pageNumbers()
{
	if(empty($this->_pageNumHtml)){
		exit('Please call function paginate() first.');
	}
	return $this->_pageNumHtml;
}

/**
 * return jump menu in a format of select box
 *
 * @author              ntson1009
 * @access              public
 * @return              string
 */
public function itemsPerPage()
{          
	if(empty($this->_itemHtml)){
		exit('Please call function paginate() first.');
	}
	return $this->_itemHtml;	
} 

/**
 * return page numbers html formats
 *
 * @author              ntson1009
 * @access              public
 * @return              string
 */
private function  _getPageNumbers($param="current")
{
	$link = $this->_link;
    if(strpos($link,"?"))
        $pattern = "&";
    else
        $pattern = "?";    
    $html  = '<ul>'; 
	//previous link button
	if($this->textNav&&($this->currentPage>1)){
		$html .= '<li><a href="'.$this->_link .$pattern.$param.'='.($this->currentPage-1).'"';
		$html .= '>'.$this->_navigation['pre'].'</a></li>';
	}        	
	//do ranged pagination only when total pages is greater than the range
    $total_page = ceil($this->total / $this->itemsPerPage);
	if($total_page > $this->range){				
		$start = ($this->currentPage <= $this->range)?1:($this->currentPage - $this->range);
		$end   = ($total_page - $this->currentPage >= $this->range)?($this->currentPage+$this->range): $total_page;
	}else{
		$start = 1;
		$end   = $total_page;
	}    
	//loop through page numbers
	for($i = $start; $i <= $end; $i++){
	       if($i==$this->currentPage)
                $html .= '<li><a class="current">'.$i.'</a></li>';
           else{
                $html .= '<li><a href="'.$this->_link .$pattern.$param.'='.$i.'"';
    			$html .= '>'.$i.'</a></li>';
           }     			
	}        	
	//next link button
	if($this->textNav&&($this->currentPage<$total_page)){
		$html .= '<li><a href="'.$this->_link .$pattern.$param.'='.($this->currentPage+1).'"';
		$html .= '>'.$this->_navigation['next'].'</a></li>';
	}
	$html .= '</ul>';
	return $html;
}

/**
 * return item select box
 *
 * @author              ntson1009
 * @access              public
 * @return              string
 */
private function  _getItemSelect()
{
	$items = '';
	$ippArray = $this->itemSelect;   			
	foreach($ippArray as $ippOpt){   
    	$items .= ($ippOpt == $this->itemsPerPage) ? "<option selected value=\"$ippOpt\">$ippOpt</option>\n":"<option value=\"$ippOpt\">$ippOpt</option>\n";
	}   			
	return "<span class=\"paginate\">".$this->_navigation['ipp']."</span>
	<select class=\"paginate\" onchange=\"window.location='$this->_link?current=1&item='+this[this.selectedIndex].value;return false\">$items</select>\n";   	
}

}
?>