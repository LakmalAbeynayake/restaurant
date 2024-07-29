<?php
/**
* Sky Print seamless printing companion class
* Author: Lakmal Abeynayake
*/
class Sky_Print
{
	var $_key        = "";
    var $_domain     = "";
    var $_protocol   = "http";
    
    var $_offset     = 20;
    var $_font       = "Courier New";
    var $_font_size  = 12;
    var $_font_style = "bold";
    
    var $ar_col_catch       = array();
    var $ar_settings_catch       = array();
    
    var $ar_row       = array();
    
    public function key($__key = ""){
        if($__key){
            if (is_string($__key))
    		{
    			$this->_key = $__key;
    		}  
        }else{
		    return $this->_key;
		}
    }
    public function domain($__domain = ""){
        if($__domain){
            if (is_string($__domain))
    		{
    			$this->_domain = $__domain;
    		}  
        }else{
		    return $this->_domain;
		}
    }
    
    public function query(){
        $columns           = array();
        $columns[]         = "BILL NO:" . $sale_info->sale_id;
        $row['columns']    = $columns;
        $row['offset']     = 20;
        $row['font']       = "Courier New";
        $row['font_size']  = $default_size;
        $row['font_style'] = "bold";
    }

    public function row($data = array(),$settings = array(),$_trim = TRUE){
        if(empty($data)){
            return $this->ar_row;
        }
        if(is_string($data)){
            $data = explode(',',$data);
        }
        foreach($data as $val){
            if($_trim)
                $val = trim($val);
            
            if($val != ''){
                $this->ar_col_catch[] = $val;
            }
        }
        if(!empty($settings)){
            if(isset($settings['offset'])){
                if(is_int($settings['offset'])){
                    $this->ar_settings_catch['offset'] = $settings['offset'];
                }else{
                    $this->ar_settings_catch['offset'] = $this->_offset;
                }
            }else{
                $this->ar_settings_catch['offset'] = $this->_offset;
            }
            if(isset($settings['font'])){
                if(is_int($settings['font'])){
                    $this->ar_settings_catch['font'] = $settings['font'];
                }else{
                    $this->ar_settings_catch['font'] = $this->_font;
                }
            }else{
                $this->ar_settings_catch['font'] = $this->_font;
            }
            if(isset($settings['font_size'])){
                if(is_int($settings['font_size'])){
                    $this->ar_settings_catch['font_size'] = $settings['font_size'];
                }else{
                    $this->ar_settings_catch['font_size'] = $this->_font_size;
                }
            }else{
                $this->ar_settings_catch['font_size'] = $this->_font_size;
            }
            if(isset($settings['font_style'])){
                if(is_int($settings['font_style'])){
                    $this->ar_settings_catch['font_style'] = $settings['font_style'];
                }else{
                    $this->ar_settings_catch['font_style'] = $this->_font_style;
                }
            }else{
                $this->ar_settings_catch['font_style'] = $this->_font_style;
            }
        }else{
                    $this->ar_settings_catch['offset'] = $this->_offset;
                    $this->ar_settings_catch['font'] = $this->_font;
                    $this->ar_settings_catch['font_size'] = $this->_font_size;
                    $this->ar_settings_catch['font_style'] = $this->_font_style;
        }
        
        $row_data = array();
        $row_data['columns'] = $this->ar_col_catch;
        foreach($this->ar_settings_catch as $key=>$_row){
            $row_data[$key] = $_row;
        }
        $this->ar_row[] = $row_data;
        $this->ar_col_catch = array();
    }
}
?>