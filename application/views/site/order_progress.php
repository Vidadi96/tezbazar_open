<div class=order-progress>
   <ul>
      <li class="<?=$basket?'active-step':'inactive-step';?>"><a href=/profile/cart><?=$this->langs->basket;?></a></li>
      <li class="<?=$delivery?'active-step':'inactive-step';?>"><a href="/profile/checkout/?<?php $get = $this->input->get();  $url = $get?"&".http_build_query($get):""; echo substr($url, 1);?>"><?=$this->langs->delivery_address;?></a></li>
      <li class="<?=$payment?'active-step':'inactive-step';?>"><a href="/profile/payment/?<?php $get = $this->input->get();  $url = $get?"&".http_build_query($get):""; echo substr($url, 1);?>"><?=$this->langs->payment;?></a></li>
      <li class="<?=$confirm?'active-step':'inactive-step';?>"><a href="/profile/confirm/?<?php $get = $this->input->get();  $url = $get?"&".http_build_query($get):""; echo substr($url, 1);?>"><?=$this->langs->confirm;?></a></li>
      <li class="<?=$complete?'active-step':'inactive-step';?>"><a><?=$this->langs->complete;?></a></li>
   </ul>
</div>
