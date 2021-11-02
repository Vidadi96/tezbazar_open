<div class="master-wrapper-content">
  <div class="master-column-wrapper">
    <div class="center-1">
      <div class="page manufacturer-list-page">
        <div class="page-title">
            <h1>Markalar</h1>
        </div>
        <div class="page-body">
            <div class="manufacturer-grid">
                <div class="item-grid">
                    <?php foreach ($brands as $brand) { ?>
                      <div class="item-box">
                            <div class="manufacturer-item">
                                <h2 class="title">
                                    <a href="/office/brand/<?=$brand->brand_id;?>" title="<?=$brand->name;?>">
                                        <?=$brand->name;?>
                                    </a>
                                </h2>
                                <div class="picture">
                                    <a href="/office/brand/<?=$brand->brand_id;?>" title="<?=$brand->name;?>">
                                        <img alt="<?=$brand->name;?>" src="/img/brands/<?=$brand->thumb;?>" title="<?=$brand->name;?>"/>
                                    </a>
                                </div>
                                <div class="manufacturer-details">
                                    <h2 class="inner-title">
                                        <a href="/office/brand/<?=$brand->brand_id;?>" title="<?=$brand->name;?>">
                                            <?=$brand->name;?>
                                        </a>
                                    </h2>
                                    <a href="/office/brand/<?=$brand->brand_id;?>" title="<?=$brand->name;?>" class="view-all">
                                        <?=$this->langs->view_all;?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
