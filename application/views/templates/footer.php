    <?php if($title=='main-page' || $title=='product'){ ?>
      <div id="footer">
        <div class="footerContent" id="description">
          <div class="footerContentTitle">
            <img src="/assets/img/logo_part1.png">
            <img src="/assets/img/logo_part2.png">
          </div>
          <span class="footerContentContent" id="descr"><?=$description->description; ?></span>
        </div>
        <div class="footerContent" id="kataloq">
          <span class="footerContentTitle"><?=$this->langs->catalog; ?></span>
          <?php foreach($footer_catalog as $row): ?>
            <a href="/goods/category/<?=$row->cat_id; ?>" style="text-decoration: none;" class="footerContentContent"><?=$row->name; ?></a>
          <?php endforeach; ?>
        </div>
        <div class="footerContent" id="haqqimizda">
          <span class="footerContentTitle"><?=$this->langs->about_us; ?></span>
          <span id='elaqe_click' class="footerContentContent">Əlaqə</span>
        </div>
        <div class="footerContent" id="sosial">
          <span class="footerContentTitle"><?=$this->langs->social_network; ?></span>
          <?php foreach($social_icons as $row): ?>
            <a target="_blank" href="<?=$row->link; ?>" style="text-decoration: none" class="footerContentContent">
              <i class="fa fa-<?=$row->icon; ?>" aria-hidden="true"></i>
              <?=$row->name; ?>
            </a>
          <?php endforeach; ?>
        </div>
        <div id="arrTB">
          <span>All rights reserved © Tez Bazar</span>
          <span>2020</span>
        </div>
      </div>
    <?php } ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="/assets/js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="/assets/js/toastr.min.js"></script>
    <script type="text/javascript" src="/assets/js/header.js"></script>
    <?php if($title == 'main-page'){ ?>
      <script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
      <script type="text/javascript" src="/assets/js/jquery.validate.unobtrusive.min.js"></script>
      <script type="text/javascript" src="/assets/js/main-page.js"></script>
    <?php } else if($title == 'orders' || $title == 'documents' || $title == 'order-history'){ ?>
      <script type="text/javascript" src="/plugins/bootstrap/js/bootstrap-datepicker.min.js"></script>
      <script type="text/javascript" src="/assets/js/personal-area.js"></script>
    <?php } else if($title == 'statistika'){ ?>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" charset="utf-8"></script>
      <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
      <script type="text/javascript" src="/plugins/bootstrap/js/bootstrap-datepicker.min.js"></script>
      <script type="text/javascript" src="/assets/js/statistika.js"></script>
    <?php } else if($title == 'statistics'){ ?>
      <script type="text/javascript" src="/plugins/bootstrap/js/bootstrap-datepicker.min.js"></script>
      <script type="text/javascript" src="/assets/js/statistika.js"></script>
    <?php } else if($title == 'product'){ ?>
      <script type="text/javascript" src="/assets/js/product.js"></script>
      <script src="/site/js/cloudzoom.core.min.js" type="text/javascript"></script>
      <script src="/site/js/cloudzoom.min.js" type="text/javascript"></script>
    <?php } else if($title == 'category' || $title=="new_order" || $title=="search") { ?>
      <script type="text/javascript" src="/assets/js/category.js"></script>
    <?php } else if($title == 'korzina1' || $title == 'korzina2') { ?>
      <script type="text/javascript" src="/assets/js/korzina.js"></script>
    <?php } else if($title == 'edit_order') { ?>
      <script type="text/javascript" src="/assets/js/edit_order.js"></script>
    <?php }?>
  </body>
</html>
