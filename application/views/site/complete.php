<div class="master-wrapper-content">

    <div class="master-column-wrapper">
        <div class="center-1">
            <div class="page checkout-page order-completed-page">
                <?=$order_progress;?>
                <div class="page-title">
                    <h1><?=$this->langs->thanks;?></h1></div>
                <div class="page-body checkout-data">
                    <div class="section order-completed">
                        <div class="title"><strong><?=$this->langs->order_complete;?></strong></div>
                        <div class="details">
                            <div class="order-number"><strong><?=$this->langs->your_order_number;?></strong>: <?=$order_number;?></strong></div>
                            <div class="details-link"><?=$this->langs->order_in_profile;?></div><a href="/profile/my_profile/?page=2">Profil</a></div>
                        </div>
                        <div class="buttons">
                            <input type="button" value="<?=$this->langs->continue_shopping;?>" class="button-1 order-completed-continue-button" onclick="setLocation(&quot;/&quot;)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
