<?php foreach($list as $item){
    //print_r($item)
    $this->load->view("site/product_item", $item);
} ?>
