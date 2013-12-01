<?php

/**
 * Descripcion de la clase Paginator
 *
 * @author darientech
 */

class Paginator {
    var $select_page = 1;
    var $current_page = 1; 
    var $total_pages = 0;
    var $total_elements = 0;
    var $rows_per_page = 10;
    var $data = array();
    var $url = "";

    var $error101 = false;
    var $error102 = false;
    var $error101_message = '<span style="color:#a00205; font-weight:bold;">Error 101: No hay datos que paginar.</span>';
    var $error102_message = '<span style="color:#a00205; font-weight:bold;">Error 102: Error desconocido.</span>';

    function SelectPage($current_page, $data=""){
        if($current_page == "" || !isset($current_page)) $current_page = 1;
        $this->current_page = $current_page;

        if($data != "") $this->data = $data;
        if(count($this->data) == 0){ $this->error101=true; }

        $this->total_elements = count($this->data);
        $this->total_pages = ($this->total_elements / $this->rows_per_page);
        $this->total_pages = ceil($this->total_pages);
        $start = (($this->current_page-1) * $this->rows_per_page)-1;
        $end   = $start+$this->rows_per_page;

        $xCount = 0;
        $page_array = array();
        foreach ($this->data as $key => $value){
            if($xCount > $start){
                $page_array[$key] = $value;
                $start++;   
                if($start == $end) break;
            }
            $xCount++;
        }

        if(count($page_array) == 0 && !$this->error101){ $this->error101=true; }

        return $page_array;
    }

    function ShowControls($url = ""){
        if($url == "") $url = $_SERVER['PHP_SELF'];
        $this->url = $url;

        $res_pag1 = $this->current_page-2;
        $res_pag2 = $this->current_page-1;
        $res_pag3 = $this->current_page+1;
        $res_pag4 = $this->current_page+2;

        echo '<span class="paginator">'."\n";
        echo 'Página '."\n";            

        $union_params = "?";
        if (strpos($this->url, '?') !== false) $union_params = "&";

        if($this->current_page  > 1)  echo '<a id="paginator_first" href="'.$this->url.$union_params.'npg=1"></a>'."\n";    
        if($this->current_page  > 1)  echo '<a id="paginator_before" href="'.$this->url.$union_params.'npg='.($this->current_page-1).'"></a>  ';
        if($res_pag1 >= 1) echo '<a href="'.$this->url.$union_params.'npg='.($res_pag1).'">'.($res_pag1).'</a>  ';
        if($res_pag2 >= 1) echo '<a href="'.$this->url.$union_params.'npg='.($res_pag2).'">'.($res_pag2).'</a>  ';
        echo '<span>'.($this->current_page).'</span> '."\n";
        if($res_pag3 <= $this->total_pages) echo '<a href="'.$this->url.$union_params.'npg='.($res_pag3).'">'.($res_pag3).'</a>  ';
        if($res_pag4 <= $this->total_pages) echo '<a href="'.$this->url.$union_params.'npg='.($res_pag4).'">'.($res_pag4).'</a>  ';
        if($this->current_page  <  $this->total_pages) echo '<a id="paginator_next" href="'.$this->url.$union_params.'npg='.($this->current_page+1).'"></a>  ';
        if($this->current_page  <  $this->total_pages) echo '<a id="paginator_last" href="'.$this->url.$union_params.'npg='.($this->total_pages).'"></a>'."\n";
        echo '</span>'."\n";
    }
}
