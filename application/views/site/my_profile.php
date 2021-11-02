<div class="master-wrapper-content">
	<div class="master-column-wrapper">
		<div class="side-2">
			<div class="block block-account-navigation">

				<div class="listbox">
					<ul class="list">
						<li class="customer-info">	<a class="<?=(($this->input->get("page")==1) || !isset($_GET["page"]))?'active':'inactive';?>" href="/profile/my_profile/?page=1"><?=$this->langs->personal_info;?></a></a>
						</li>
						<li class="customer-orders">	<a class="<?=($this->input->get("page")==2)?'active':'inactive';?>" href="/profile/my_profile/?page=2"><?=$this->langs->my_orders;?></a>
						</li>
						<li class="customer-addresses">	<a class="<?=($this->input->get("page")==3)?'active':'inactive';?>" href="/profile/my_profile/?page=3"><?=$this->langs->my_adresses;?></a>
						</li>
						<!--<li class="downloadable-products">	<a class="inactive" href="/customer/downloadableproducts">Downloadable products</a>
						</li>
						<li class="back-in-stock-subscriptions">	<a class="inactive" href="/backinstocksubscriptions/manage">Back in stock subscriptions</a>
						</li>
						<li class="reward-points">	<a class="inactive" href="/rewardpoints/history">Reward points</a>
						</li>
						<li class="change-password">	<a class="inactive" href="/customer/changepassword">Change password</a>
						</li>
						<li class="customer-reviews">	<a class="inactive" href="/customer/productreviews">My product reviews</a>
						</li> -->
					</ul>
				</div>
			</div>
		</div>
		<div class="center-2">
			<div class="page account-page customer-info-page">
				<div class="page-title">
					<h1><?=$this->langs->my_profile;?></h1>
				</div>
				<div class="page-body">
					<?php	if($this->input->get("page")==3){?>
						<div class="fieldset" style="padding: 20px;">
							<?php if($this->input->get("action")=="address_add"){?>
								<form method=post action="/profile/my_profile/?page=3&action=address_add">
								  <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								  <div class=fieldset>
								    <div class=form-fields>
								      <div class=inputs>
								        <label for=full_name><?=$this->langs->addr_title;?>:</label>
								        <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=title name="title" value="<?=$this->input->post("title");?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=title data-valmsg-replace=true></span>
								      </div>
								      <div class=inputs>
								        <label for=full_name><?=$this->langs->firstname;?>:</label>
								        <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=firstname name="firstname" value="<?=$this->input->post("firstname");?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=firstname data-valmsg-replace=true></span>
								      </div>
								      <div class=inputs>
								        <label for=full_name><?=$this->langs->lastname;?>:</label>
								        <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=lastname name="lastname" value="<?=$this->input->post("lastname");?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=lastname data-valmsg-replace=true></span>
								      </div>
								      <div class=inputs>
								        <label for=full_name><?=$this->langs->middlename;?>:</label>
								        <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=middlename name="middlename" value="<?=$this->input->post("middlename");?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=middlename data-valmsg-replace=true></span>
								      </div>
											<div class=inputs>
								        <label for=full_name><?=$this->langs->phone;?>:</label>
								        <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=phone name="phone" value="<?=$this->input->post("phone");?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=phone data-valmsg-replace=true></span>
								      </div>
											<div class=inputs>
								        <label for=full_name><?=$this->langs->zip_code;?>:</label>
								        <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=zip_code name="zip_code" value="<?=$this->input->post("zip_code");?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=zip_code data-valmsg-replace=true></span>
								      </div>
											<div class=inputs>
								        <label for=full_name><?=$this->langs->address;?>:</label>
								        <textarea data-val=true data-val-required="<?=$this->langs->required;?>" id=address name="address"><?=$this->input->post("address");?></textarea> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=address data-valmsg-replace=true></span>
								      </div>





								    </div>
								  </div>
								  <div class=buttons>
								    <input type=submit id=register-button class="button-1 register-next-step-button" value="<?=$this->langs->submit;?>" name=register-button>
								  </div>
								</form>

							<?php }else if($this->input->get("action")=="address_edit"){ ?>

<form method=post action="/profile/my_profile/?page=3&action=address_edit">
	<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div class=fieldset>
		<div class=form-fields>
			<div class=inputs>
				<label for=full_name><?=$this->langs->addr_title;?>:</label>
				<input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=title name="title" value="<?=$address_item->title;?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=title data-valmsg-replace=true></span>
				<input type="hidden" value="<?=$this->input->get("address_id");?>" name="address_id" />
			</div>
			<div class=inputs>
				<label for=full_name><?=$this->langs->firstname;?>:</label>
				<input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=firstname name="firstname" value="<?=$address_item->firstname;?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=firstname data-valmsg-replace=true></span>
			</div>
			<div class=inputs>
				<label for=full_name><?=$this->langs->lastname;?>:</label>
				<input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=lastname name="lastname" value="<?=$address_item->lastname;?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=lastname data-valmsg-replace=true></span>
			</div>
			<div class=inputs>
				<label for=full_name><?=$this->langs->middlename;?>:</label>
				<input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=middlename name="middlename" value="<?=$address_item->middlename;?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=middlename data-valmsg-replace=true></span>
			</div>
			<div class=inputs>
				<label for=full_name><?=$this->langs->phone;?>:</label>
				<input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=phone name="phone" value="<?=$address_item->phone;?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=phone data-valmsg-replace=true></span>
			</div>
			<div class=inputs>
				<label for=full_name><?=$this->langs->zip_code;?>:</label>
				<input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=zip_code name="zip_code" value="<?=$address_item->zip_code;?>"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=zip_code data-valmsg-replace=true></span>
			</div>
			<div class=inputs>
				<label for=full_name><?=$this->langs->address;?>:</label>
				<textarea data-val=true data-val-required="<?=$this->langs->required;?>" id=address name="address"><?=$address_item->address;?></textarea> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=address data-valmsg-replace=true></span>
			</div>

		</div>
	</div>
	<div class=buttons>
		<input type=submit id=register-button class="button-1 register-next-step-button" value="<?=$this->langs->save;?>">
	</div>
</form>

							<?php }else{?>
							<div class="address-list">
								<?php foreach ($addresses as $address) {
									// code...

								echo '<div class="section address-item">
									<div class="title">
										<strong>'.$address->title.'</strong>
									</div>
									<ul class="info">
										<li class="fullname">'.$address->lastname.' '.$address->firstname.' '.$address->middlename.'</li>
										<li class="phone"><label>'.$this->langs->phone.':</label> '.$address->phone.'</li>
										<li class="city-state-zip"><label>'.$this->langs->zip_code.':</label> '.$address->zip_code.'</li>
										<li class="address"><label>'.$this->langs->address.':</label> '.$address->address.'</li>
									</ul>
									<div class="buttons">
										<input type="button" class="button-2 edit-address-button" onclick="location.href=\'/profile/my_profile/?page=3&action=address_edit&address_id='.$address->address_id.'\'" value="'.$this->langs->edit.'">
										<input type="button" class="button-2 delete-address-button" onclick="deletecustomeraddress('.$address->address_id.')" value="'.$this->langs->delete.'">
									</div>
								</div>';
								}?>
							</div>
							<div class="add-button">
								<input type="button" class="button-1 add-address-button" onclick="location.href='/profile/my_profile/?page=3&action=address_add'" value="<?=$this->langs->new_address;?>">
							</div>
							<?php } ?>
						</div>
					<?php }else	if($this->input->get("page")==2){?>
						<div class="fieldset" style="padding: 20px;">
							<table class="cart">
								<thead>
									<tr class="cart-header-row">
										<th>
											<strong>Məhsul sayı</strong>
										</th>
										<th>
											<strong>Toplam dəyər</strong>
										</th>
										<th>
											<strong>Tarix</strong>
										</th>
										<th>
											<strong>Statusu</strong>
										</th>
										<th>
											<strong>Ətraflı bax</strong>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($orders as $item) {
										$order_class="";
										if($item->order_status_id==7)
										{
											$order_class = "order_waiting";
										}

										echo '
										<tr class="cart-item-row">
											<td>
												'.$item->product_count.'
											</td>
											<td>
												'.round($item->product_price, 2, PHP_ROUND_HALF_UP).'
											</td>
											<td>
												'.$item->date_time.'
											</td>
											<td>
												<span class="'.$order_class.'">'.$item->order_status_title.'</span>
											</td>
											<td>
												<a onclick="displayPopupContentFromUrl(\'/profile/order_list/?order_number='.$item->order_number.'\', \''.$this->langs->my_orders.'\')" href="javascript:;"><img src="/site/img/list.png" /></a>
											</td>
										</tr>
										';
									};?>

								</tbody>
							</table>
						</div>




					<?php }else if(($this->input->get("page")==1) || !isset($_GET["page"])){
					?>
					<form action="/profile/my_profile/?page=1" method="post">
						<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						<div class="fieldset">
							<div class="form-fields">

								<div class="inputs">
									<label for="lastname"><?=$this->langs->lastname;?>:</label>
									<input data-val="true" data-val-required="First name is required." id="lastname" name="lastname" type="text" value="<?=$user->lastname;?>"> <span class="required">*</span>  <span class="field-validation-valid" data-valmsg-for="lastname" data-valmsg-replace="true"></span>
								</div>
								<div class="inputs">
									<label for="firstname"><?=$this->langs->firstname;?>:</label>
									<input data-val="true" data-val-required="First name is required." id="firstname" name="firstname" type="text" value="<?=$user->firstname;?>"> <span class="required">*</span>  <span class="field-validation-valid" data-valmsg-for="firstname" data-valmsg-replace="true"></span>
								</div>
								<div class="inputs">
									<label for="middlename"><?=$this->langs->middlename;?>:</label>
									<input data-val="true" data-val-required="First name is required." id="middlename" name="middlename" type="text" value="<?=$user->middlename;?>"> <span class="required">*</span>  <span class="field-validation-valid" data-valmsg-for="middlename" data-valmsg-replace="true"></span>
								</div>
								<div class="inputs">
									<label><?=$this->langs->gender;?>:</label>
									<div class="gender">	<span class="male">
										<input <?=$user->gender?'':'checked';?> id="gender-male" name="gender" type="radio" value="0"> <label class="forcheckbox" for="gender-male"><?=$this->langs->male;?></label></span>  <span class="female">
										<input id="gender-female" name="gender" type="radio" value="1"> <label class="forcheckbox" for="gender-female"><?=$this->langs->female;?></label></span>
									</div>
								</div>
								<div class="inputs date-of-birth">
									<label><?=$this->langs->birth_day;?>:</label>
									<div class="date-picker-wrapper">
										<select name="day">
											<option value="0"><?=$this->langs->day;?></option>
											<?php
											$timestamp = strtotime($user->birth_date);
											$day = date("d", $timestamp);

											for ($i=1; $i <= 31; $i++) {
												echo '<option '.(($day==$i)?'selected':'').' value="'.$i.'">'.$i.'</option>';
											}
											 ?>

										</select>
										<select name="month">
											<option value="0"><?=$this->langs->month;?></option>
											<?php
											$month = strtolower(date("n", $timestamp));

											for ($i=1; $i <= 12; $i++) {
												$current_month = strtolower(date("F", mktime(0, 0, 0, $i, 10)));
												echo '<option '.(($month==$i)?'selected':'').' value="'.$i.'">'.$this->langs->{$current_month}.'</option>';
											}
											 ?>

										</select>
										<select name="year">
											<option value="0"><?=$this->langs->year;?></option>
											<?php
											$timestamp = strtotime($user->birth_date);
											$year = date("Y", $timestamp);

											for ($i=1950; $i <= date("Y"); $i++) {
												echo '<option '.(($year==$i)?'selected':'').' value="'.$i.'">'.$i.'</option>';
											}
											 ?>

										</select>
									</div><span class="field-validation-valid" data-valmsg-for="DateOfBirthDay" data-valmsg-replace="true"></span>  <span class="field-validation-valid" data-valmsg-for="DateOfBirthMonth" data-valmsg-replace="true"></span>  <span class="field-validation-valid" data-valmsg-for="DateOfBirthYear" data-valmsg-replace="true"></span>
								</div>
								<div class="inputs">
									<label for="Email"><?=$this->langs->email;?>:</label>
									<input data-val="true" data-val-email="Wrong email" data-val-required="Email is required." id="Email" name="Email" type="text" value="<?=$user->email;?>"> <span class="required">*</span>  <span class="field-validation-valid" data-valmsg-for="Email" data-valmsg-replace="true"></span>
								</div>

							</div>
						</div>
						<div class=fieldset>
					    <div class=title><strong><?=$this->langs->new_password;?> (<?=$this->langs->dont_change_set_empty;?>)</strong>
					    </div>

					    <div class=form-fields>
					      <div class=inputs>
					        <label for=Password><?=$this->langs->pass;?>:</label>
					        <input type=password data-val=true data-val-regex="&lt;p>Password must meet the following rules: &lt;/p>&lt;ul>&lt;li>must have at least 6 characters&lt;/li>&lt;/ul>" data-val-regex-pattern=^.{6,}$ data-val-required="Password is required." id=password name=password> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=password data-valmsg-replace=true></span>
					      </div>
					      <div class=inputs>
					        <label for=confirm_password><?=$this->langs->re_pass;?>:</label>
					        <input type=password data-val=true data-val-equalto="The password and confirmation password do not match." data-val-equalto-other=*.Password data-val-required="Password is required." id=confirm_password name=confirm_password> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=confirm_password data-valmsg-replace=true></span>
					      </div>

					    </div>
					  </div>
						<div class="fieldset">
							<div class="title">	<strong><?=$this->langs->company_details;?></strong></div>
							<div class="form-fields">
								<div class="inputs">
									<label for="Company"><?=$this->langs->company_name;?>:</label>
									<input id="Company" name="company_name" type="text" value="<?=$user->company_name;?>"> <span class="field-validation-valid" data-valmsg-for="Company" data-valmsg-replace="true"></span>
								</div>
							</div>
						</div>
						<div class="fieldset">
							<div class="title">	<strong><?=$this->langs->subscribe;?></strong></div>
							<div class="form-fields gender">
					      <div class=inputs>
					        <span class=female> <input type=checkbox <?=$user->subscribe?'checked':'';?> value="1" id=subscribe name="subscribe"> <label class=forcheckbox for=subscribe><?=$this->langs->news_notif;?></label> </span>
					      </div>
					    </div>
						</div>
						<div class="buttons">
							<input class="button-1 save-customer-info-button" id="save-info-button" name="save-info-button" type="submit" value="Save">
						</div>
					</form>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function deletecustomeraddress(n){
		if(confirm("<?=$this->langs->sure_delete;?>")){
			var t={addressId:n};addAntiForgeryToken(t);
			$.ajax({
					cache:!1,
					type:"GET",
					url:"/profile/delete_address/",
					data:t,
					dataType:"json",
					success:function(n){
						location.href='/profile/my_profile/?page=3';
					},
					error:function(){
						alert("Failed to delete")
					}
				})
			}
		}
</script>
