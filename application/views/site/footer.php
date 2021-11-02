
        <div class="footer">
            <!-- <div class="footer-upper">
                <div class="center">
                    <div class="newsletter">
                        <div class="title">
                            <strong><?=$this->langs->subscribe;?></strong>
                        </div>
                        <div class="newsletter-subscribe" id="newsletter-subscribe-block">
                            <div class="newsletter-email">
                                <input class="newsletter-subscribe-text" id="newsletter-email" name="NewsletterEmail" placeholder="<?=$this->langs->enter_email;?>..." type="text" value="" />
                                <input type="button" value="<?=$this->langs->send;?>" id="newsletter-subscribe-button" class="button-1 newsletter-subscribe-button" />
                            </div>
                            <div class="newsletter-validation">
                                <span id="subscribe-loading-progress" style="display: none;" class="please-wait">Чекај ...</span>
                                <span class="field-validation-valid" data-valmsg-for="NewsletterEmail" data-valmsg-replace="true"></span>
                            </div>
                        </div>
                        <div class="newsletter-result" id="newsletter-result-block"></div>
                        <script type="text/javascript">
                            function newsletter_subscribe(subscribe) {
                                var subscribeProgress = $("#subscribe-loading-progress");
                                subscribeProgress.show();
                                var postData = {
                                    subscribe: subscribe,
                                    email: $("#newsletter-email").val()
                                };
                                $.ajax({
                                    cache: false,
                                    type: "POST",
                                    url: "/subscribenewsletter",
                                    data: postData,
                                    success: function(data) {
                                        subscribeProgress.hide();
                                        $("#newsletter-result-block").html(data.Result);
                                        if (data.Success) {
                                            $('#newsletter-subscribe-block').hide();
                                            $('#newsletter-result-block').show();
                                        } else {
                                            $('#newsletter-result-block').fadeIn("slow").delay(2000).fadeOut("slow");
                                        }
                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                        alert('Failed to subscribe.');
                                        subscribeProgress.hide();
                                    }
                                });
                            }

                            $(document).ready(function() {
                                $('#newsletter-subscribe-button').click(function() {
                                    newsletter_subscribe('true');
                                });
                                $("#newsletter-email").keydown(function(event) {
                                    if (event.keyCode == 13) {
                                        $("#newsletter-subscribe-button").click();
                                        return false;
                                    }
                                });
                            });
                        </script>
                    </div>

                    <ul class="social-sharing">
                        <li class="facebook">
                            <a target="_blank" href="https://www.facebook.com/OfficePlus.mk/"></a>
                        </li>
                        <li class="rss">
                            <a target="_blank" href="/news/rss/2"></a>
                        </li>
                    </ul>
                </div>
            </div> -->
            <div class="footer-middle">
                <div class="center">
                  <div class="footer-block">
                      <img src="/site/img/logo.png" class="footer_logo"/>
                      <ul class="list address_list" >
                          <li><i class="fa fa-map-marker"></i> <?=$this->langs->addres_details;?></li>
                          <li><i class="fa fa-phone"></i> <?=$this->langs->phone_numbers;?></li>
                          <li><i class="fa fa-envelope-o"></i> <?=$this->langs->mails;?></li>
                      </ul>
                  </div>

                    <div class="footer-block" >
                        <div class="title">
                            <strong><?=$this->langs->information;?></strong>
                        </div>
                        <br />
                        <ul class="list">

                            <li><a href="/about">- <?=$this->langs->about_us;?></a></li>
                            <li><a href="/carier">- <?=$this->langs->carier;?></a></li>
                            <li><a href="/korporativ">- <?=$this->langs->coporative;?></a></li>
                            <li><a href="/blog/blog/12">- <?=$this->langs->social;?></a></li>
                            <li><a href="/reklam">- <?=$this->langs->ads;?></a></li>
                        </ul>
                    </div>
                    <div class="footer-block" >
                        <div class="title">
                            <strong><?=$this->langs->my_profile;?></strong>
                            <i class="fa fa-navicon" aria-hidden="true" style="float: right; font-size: 16px; color: #d62027;"></i>
                        </div>
                        <br />
                        <ul class="list">
                            <?php if(!$this->session->userdata("user_id")){?>
                            <li><a href="/profile/login/">- <?=$this->langs->login;?></a></li>
                            <?php }else{ ?>
                            <li><a href="/profile/my_profile/">- <?=$this->langs->personal_info;?></a></li>
                            <?php } ?>
                            <li><a href="/profile/wishlist/">- <?=$this->langs->whishlist;?></a></li>
                            <li><a href="/profile/cart/">- <?=$this->langs->basket;?></a></li>
                        </ul>
                    </div>
                    <div class="footer-block">
                        <div class="title">
                            <strong><?=$this->langs->subscribe;?></strong>
                        </div>
                        <br />
                        <div class="newsletter-email">
                            <input class="newsletter-subscribe-text" id="newsletter-email" name="NewsletterEmail" placeholder="<?=$this->langs->enter_email;?>..." type="text" value="" />
                            <input type="button" value="<?=$this->langs->send;?>" id="newsletter-subscribe-button" class="button-1 newsletter-subscribe-button" />
                        </div>
                        <br />
                        <ul class="social_icons">
                          <?php foreach ($social_icons as $item) {
                            echo '<li><a target="_blank" href="'.$item->link.'" title="'.$item->name.'"><i class="fa fa-'.$item->icon.'"></i></a></li>';
                          }?>
                        </ul>
                    </div>

                    <!--
                    <div class="footer-block">
                        <div class="title">
                            <strong><?=$this->langs->my_profile;?></strong>
                            <i class="fa fa-navicon" aria-hidden="true" style="float: right; font-size: 16px; color: #d62027;"></i>
                        </div>
                        <ul class="list">
                            <li><a href=""><?=$this->langs->user_info;?></a></li>
                            <li><a href=""><?=$this->langs->orders;?></a></li>
                            <li><a href=""><?=$this->langs->basket;?></a></li>
                            <li><a href=""><?=$this->langs->wishlist;?></a></li>
                            <li><a href=""><?=$this->langs->compare_list;?></a></li>
                        </ul>
                    </div> -->
                    <!-- <div class="footer-block quick-contact">
                        <div class="title">
                            <strong><?=$this->langs->contact;?></strong>
                            <i class="fa fa-navicon" aria-hidden="true" style="float: right; font-size: 16px; color: #d62027;"></i>
                        </div>
                        <ul class="list">

                            <li class="phone">
                                <div>
                                    <i class="fa fa-phone" aria-hidden="true" style="color: #d62027;margin-right: 10px;margin-top: 3px;font-size: 37px;"></i>
                                    <div class="footer-text">
                                        <span><b><?=$this->langs->phone_numbers;?></b></span>
                                        <br />
                                        <span><?=$this->langs->phone_letter;?></span>
                                    </div>
                                </div>
                            </li>
                            <li class="fax" style="margin-bottom: 20px; margin-top: -5px;">
                                <div>
                                    <i class="fa fa-fax" aria-hidden="true" style="color: #d62027;margin-right: 10px;margin-top: 3px;font-size: 30px;"></i>
                                    <div class="footer-text mob-fax-text">
                                        <span><b><?=$this->langs->fax;?></b></span>
                                        <br />
                                        <span style="font-size: 13px;"><a href="/Content/files/ExportImport/kupon_za_naracka.xls"> <?=$this->langs->fax_number;?> </a></span>
                                    </div>
                                </div>
                            </li>
                            <li class="email">
                                <div>
                                    <i class="fa fa-envelope" aria-hidden="true" style="color: #d62027;margin-right: 10px;font-size: 30px;"></i>
                                    <div class="footer-text mob-mail-text">
                                        <span><b><?=$this->langs->email;?></b></span>
                                        <br />
                                        <span><?=$this->langs->mails;?></a></span>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div> -->
                </div>
            </div>
            <div class="footer-lower">
                <div class="center">

                    <div class="footer-disclaimer">
                        <?=$this->langs->copyright;?>
                    </div>
                    <ul class="accepted-payments">
                        <li class="method2"></li>
                        <li class="method4"></li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

    <div id="goToTop"></div>
  
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5f046dcf760b2b560e6fe612/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>

</html>
