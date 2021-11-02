
<div class="overlayOffCanvas"></div>
<div class="master-wrapper-content">




        <div class="master-column-wrapper">



<div class="center-1">



<div class="page category-page">
<div class="page-title">
    <h1><?=$this->langs->search;?>: <?=$search;?></h1>
</div>
<div class="page-body">










        <div class="product-grid">
            <div class="item-grid search_grid">
              <?php foreach($list as $item){
                  $this->load->view("site/product_item", $item);
              } ?>
            </div>
        </div>

        <div class="pagination">
          <ul>
            <?=$pagination;?>
            </ul>
        </div>

</div>
</div>



</div>



    </div>

</div>
