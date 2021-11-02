<html>
  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/header.css?v=2">
    <link rel="stylesheet" href="/assets/css/toastr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/plugins/bootstrap/css/bootstrap.min.css">
    <?php if($title == 'main-page'){ ?>
      <link rel="stylesheet" href="/assets/css/main-page.css">
      <link rel="stylesheet" href="/assets/css/footer.css">
    <?php } else if($title == 'orders' || $title == 'documents' || $title == 'order-history'){ ?>
      <link rel="stylesheet" href="/assets/css/personal-area.css?v=3">
    <?php } else if($title == 'statistika' || $title == 'statistics'){ ?>
      <link rel="stylesheet" href="/assets/css/statistika.css">
    <?php } else if($title == 'product'){ ?>
      <link rel="stylesheet" href="/assets/css/product.css">
      <link rel="stylesheet" href="/assets/css/footer.css">
      <link href="/site/css/cloudzoom2.css" rel="stylesheet" type="text/css" />
      <link href="/site/css/cloudzoom.css" rel="stylesheet" type="text/css" />
    <?php } else if($title == 'category' || $title=="new_order" || $title=="search"){ ?>
      <link rel="stylesheet" href="/assets/css/category.css">
      <link rel="stylesheet" href="/assets/css/footer.css">
    <?php } else if($title == 'korzina1' || $title == 'korzina2'){ ?>
      <link rel="stylesheet" href="/assets/css/korzina.css">
    <?php } else if($title == 'edit_order'){ ?>
      <link rel="stylesheet" href="/assets/css/edit_order.css">
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
			Tezbazar
		</title>
  </head>
  <header>
    <div id="header">
      <div class="bar mobile_open">
        <i class="fa fa-bars" aria-hidden="true"></i>
      </div>
      <a id="icon_home" href="/pages/index/main-page"><i class="fa fa-home" aria-hidden="true"></i></a>
      <a id="logo" href="/pages/index/main-page" style="display: flex;align-items: center;"><img src="/assets/img/logo_part1.png" class="cont_left" id="logo_part1">
      <img src="/assets/img/logo_part2.png" class="cont_left" id="logo_part2"></a>
      <?php if($title=='main-page' || $title=='statistika' || $title=='statistics'){ ?>
        <div class="cont_left" id="katalog">
          <img src="/assets/img/list_ico.png" />
          <span><?=$this->langs->categories; ?></span>
          <div id="subKataloq">
            <?php
              foreach ($cats_menu as $cat) {
                if($cat->parent_id==0)
                {
                  echo '<span href="/goods/category/'.$cat->cat_id.'" class="subKataloqContent">'.$cat->name;
                      $sub_count = 0;
                      foreach ($cats_menu as $sub) {
                        if($sub->parent_id==$cat->cat_id)
                        {
                          if($sub_count==0)
                          {
                            echo '<i class="fa fa-chevron-right" aria-hidden="true"></i>
                                  <div class="subCateqory">';
                            $sub_count =1;
                          }
                          echo '<span href="/goods/category/'.$sub->cat_id.'" class="subCategoryContent">'.$sub->name;
                              $sub_sub_count=0;
                              foreach ($cats_menu as $sub_sub) {
                                if($sub_sub->parent_id==$sub->cat_id)
                                {
                                  if($sub_sub_count==0)
                                  {
                                    echo '<div class="subCateqory">';
                                    $sub_sub_count=1;
                                  }

                                  echo '<span href="/goods/category/'.$sub_sub->cat_id.'" class="subCategoryContent">'.$sub_sub->name.'</span>';
                                }
                              }
                              if($sub_sub_count==1)
                              {
                                echo '</div>';
                              }
                              echo '</span>';
                        }
                      }
                      if($sub_count==1)
                      {
                        echo '</div>';
                      }
                  echo'</span>';
                }
              }
              ?>
          </div>
        </div>
      <?php } ?>
      <div id=header_right>
        <?php if(@$_SESSION['user_logged']){ ?>
          <a id="statistics" href="/pages/index/statistika">
            <img src="/assets/img/statistika.png" id="statistika">
          </a>
        <?php } ?>
        <div id="search-holder" class="search-holder">
        	<div class="form">
        		<div class="search-button"></div>
        		<input type="text" id="search_click" class="search-input" placeholder="<?=$this->langs->search; ?> ..." />
        	</div>
        </div>
        <?php if(@$_SESSION['user_logged']){ ?>
          <a href="/pages/index/orders" id="personal"><?=$this->langs->personal_area; ?></a>
        <?php } ?>
        <div id="user_submenu">
          <i class="fa fa-user-o" aria-hidden="true"></i>
          <div id="submenu">
            <?php if(@!$_SESSION['user_logged']){ ?>
              <span class="submenuSpan"><?=$this->langs->register_to_shop; ?>:</span>
              <div class="sign" id="registration"><?=$this->langs->registration; ?></div>
              <span class="submenuSpan"><?=$this->langs->already_registered; ?>:</span>
              <div class="sign" id="signIn"><?=$this->langs->login; ?></div>
            <?php } else { ?>
              <span class="submenuSpan2"><?=$_SESSION['username']; ?></span>
              <a href="/pages/index/personal_data" target="_blank" style="text-decoration:none;" class="submenuSpan3">
                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                <?=$this->langs->personal_data; ?>
              </a>
              <a href="/auth2/logout" class="submenuSpan3">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
                <?=$this->langs->exit; ?>
              </a>
            <?php } ?>
          </div>
        </div>
        <span id="language">
          <img src="/assets/img/language.png" id="language_ico">
          <span><?=$lang[0]->name; ?></span>
          <div id="language_submenu">
          <?php $i=0; foreach ($lang as $row): $i++ ?>
            <a style="color: inherit" href="/pages/change_language/<?=$row->lang_id."?".http_build_query(array('url' => $_SERVER['REQUEST_URI'])); ?>">
              <div>
                <img src="/img/langs/<?=$row->thumb; ?>" style="position: relative; float: left; width: 25px;">
                <span <? echo $i==1?'class="active_language"':''; ?>><?=$row->name; ?></span>
              </div>
            </a>
          <?php endforeach; ?>
          </div>
        </span>
        <a href="/pages/index/korzina1" id="headerKorzina">
          <span id="basket_count"><?=$basket_count[0]->count; ?></span>
        </a>
      </div>
    </div>
    <div class="line_div mobile_open">
      <div class="cont_left" id="katalog_mobile">
        <img src="/assets/img/list_ico.png" />
        <span><?=$this->langs->catalog; ?></span>
        <div id="subKataloq_mobile">
          <?php
            foreach ($cats_menu as $cat) {
              if($cat->parent_id==0)
              {
                echo '<span href="/goods/category/'.$cat->cat_id.'" class="subKataloqContent">'.$cat->name;
                    $sub_count = 0;
                    foreach ($cats_menu as $sub) {
                      if($sub->parent_id==$cat->cat_id)
                      {
                        if($sub_count==0)
                        {
                          echo '<i class="fa fa-chevron-right" aria-hidden="true"></i>
                                <div class="subCateqory">';
                          $sub_count =1;
                        }
                        echo '<span href="/goods/category/'.$sub->cat_id.'" class="subCategoryContent">'.$sub->name;
                            $sub_sub_count=0;
                            foreach ($cats_menu as $sub_sub) {
                              if($sub_sub->parent_id==$sub->cat_id)
                              {
                                if($sub_sub_count==0)
                                {
                                  echo '<div class="subCateqory">';
                                  $sub_sub_count=1;
                                }

                                echo '<span href="/goods/category/'.$sub_sub->cat_id.'" class="subCategoryContent">'.$sub_sub->name.'</span>';
                              }
                            }
                            if($sub_sub_count==1)
                            {
                              echo '</div>';
                            }
                            echo '</span>';
                      }
                    }
                    if($sub_count==1)
                    {
                      echo '</div>';
                    }
                echo'</span>';
              }
            }
            ?>
        </div>
      </div>
    </div>

    <div class="open_bar">
      <div id="search-holder2" class="search-holder active">
        <div class="form">
          <div class="search-button"></div>
          <input type="text" id="search_click2" class="search-input" placeholder="<?=$this->langs->search; ?> ..." />
        </div>
      </div>

      <?php if(@$_SESSION['user_logged']): ?>
        <div class="line_row">
          <a href="/pages/index/orders" id="personal2"><i class="fa fa-user-secret" aria-hidden="true"></i><?=$this->langs->personal_area; ?></a>
        </div>

        <div class="line_row">
          <a href="/pages/index/statistika" id="statistics2"><i class="fa fa-pie-chart" aria-hidden="true"></i><?=$this->langs->statistics; ?></a>
        </div>
      <?php endif;?>

      <?php if(@!$_SESSION['user_logged']){ ?>
        <div class="line_row">
          <span class="submenuSpan"><?=$this->langs->register_to_shop; ?>:</span>
        </div>
        <div class="line_row">
          <div class="sign" id="registration2"><?=$this->langs->registration; ?></div>
        </div>
        <div class="line_row">
          <span class="submenuSpan"><?=$this->langs->already_registered; ?>:</span>
        </div>
        <div class="line_row">
          <div class="sign" id="signIn2"><?=$this->langs->login; ?></div>
        </div>
      <?php } else { ?>
        <div class="line_row">
          <span class="submenuSpan2"><?=$_SESSION['username']; ?></span>
        </div>
        <div class="line_row">
          <a href="/pages/index/personal_data" target="_blank" style="text-decoration:none;" class="submenuSpan3">
            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
            <?=$this->langs->personal_data; ?>
          </a>
        </div>
        <div class="line_row">
          <a href="/auth2/logout" class="submenuSpan3">
            <i class="fa fa-sign-out" aria-hidden="true"></i>
            <?=$this->langs->exit; ?>
          </a>
        </div>
      <?php } ?>
    </div>

    <div class="zanaveska">
      <div class="flexStyle">
        <div id="login_form">
          <div id="title">
            <span class="login"><?=$this->langs->login; ?></span>
            <span class="registration"><?=$this->langs->registration; ?></span>
          </div>
          <span id="close">x</span>
          <form id="loginForm" role="form" method="POST" action="/auth2/login">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <label for="logPhone"><?=$this->langs->phone; ?></label>
            <input type="text" id="logPhone" name="logPhone" class="phone_format"/>
            <label for="password"><?=$this->langs->pass; ?></label>
            <div id="eye" class="eye" onmousedown="view('eye', 'password')" onmouseup="noview('eye', 'password')"></div>
            <input type="password" id="password" name="password" />
            <div class="forExcept">
              <div class="g-recaptcha" data-size="normal"	data-sitekey="6Lfy_LQZAAAAAMB16XdtZBiL6MsLIuv4K8tyeDqZ"></div>
            </div>
            <button type="submit"><?=$this->langs->login; ?></button>
            <!-- <a href="/pages/index/recovery_pass" style="text-decoration: none;">
              <span><?//=$this->langs->forget_pass; ?></span>
            </a> -->
          </form>

          <div id="forRegistrationScroll">
            <form id="registrationForm" role="form" method="POST" action="/auth2/registration">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <label for="corporateName"><?=$this->langs->corporate_name; ?></label>
              <input type="text" name="corporateName" id="corporateName" class="forCorporate">
              <label for="fullname"><?=$this->langs->fullname; ?></label>
              <input type="text" id="fullname" name="fullname"/>
              <!-- <label for="mail"><?=$this->langs->email; ?></label>
              <input type="text" id="mail" name="mail" /> -->
              <label for="phone"><?=$this->langs->contact_number; ?></label>
              <input type="text" id="phone" name="phone" class="phone_format"/>
              <!-- <label for="adress"><?=$this->langs->delivery_address; ?></label>
              <textarea name="adress"></textarea> -->
              <label for="password2"><?=$this->langs->pass; ?>
                <div id="eye2" class="eye eye2" onmousedown="view('eye2', 'password2')" onmouseup="noview('eye2', 'password2')"></div>
              </label>
              <input type="password" id="password2" name="password2" />
              <label for="repeatPassword"><?=$this->langs->re_pass; ?>
                <div id="eye3" class="eye eye2" onmousedown="view('eye3', 'repeatPassword')" onmouseup="noview('eye3', 'repeatPassword')"></div>
              </label>
              <input type="password" id="repeatPassword" name="repeatPassword" />
              <div class="forExcept">
                <div class="g-recaptcha" data-sitekey="6Lfy_LQZAAAAAMB16XdtZBiL6MsLIuv4K8tyeDqZ"></div>
              </div>
              <button type="submit"><?=$this->langs->registration; ?></button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="zanaveska2">
      <div class="flexStyle">
        <div id="elaqe">
          <span id="elaqe_title"><?=$this->langs->contact3; ?></span>
          <span id="close2">x</span>
          <?php $i=0; foreach($contact_map as $row): $i++; ?>
            <div class="elaqe_div">
              <span class="sub_title"><?=$this->langs->address2." ".$i; ?>: </span>
              <span class="elaqe_cont"><?=$row->title; ?></span>
            </div>
          <?php endforeach; ?>
          <div class="elaqe_div">
            <span class="sub_title"><?=$this->langs->number2; ?>: </span>
            <span class="elaqe_cont"><?=$contact_phone->number; ?></span>
          </div>
        </div>
      </div>
    </div>

    <span id="language_js" style="display: none;"><?=$this->langs->language; ?></span>
  </header>
  <body>
