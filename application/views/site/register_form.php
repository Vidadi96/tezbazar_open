<form method=post action="/profile/register/">
  <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
  <div class=fieldset>
    <div class=titles><strong><?=$this->langs->personal_info;?></strong>
    </div>
    <div class=form-fields>
      <div class=inputs>
        <label for=lastname><?=$this->langs->lastname;?>:</label>
        <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=lastname name="lastname"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=lastname data-valmsg-replace=true></span>
      </div>
      <div class=inputs>
        <label for=firstname><?=$this->langs->firstname;?>:</label>
        <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=firstname name="firstname"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=firstname data-valmsg-replace=true></span>
      </div>
      <div class=inputs>
        <label for=middlename><?=$this->langs->middlename;?>:</label>
        <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=middlename name="middlename"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=middlename data-valmsg-replace=true></span>
      </div>
      <div class=inputs>
        <label><?=$this->langs->gender;?>:</label>
        <div class=gender><span class=male> <input type=radio value="0" id=gender-male name="gender"> <label class=forcheckbox for=gender-male><?=$this->langs->male;?></label> </span>  <span class=female> <input type=radio value="1" id=gender-female name="gender"> <label class=forcheckbox for=gender-female><?=$this->langs->female;?></label> </span>
        </div>
      </div>
      <div class="inputs date-of-birth">
        <label><?=$this->langs->birth_day;?>:</label>
        <div asp-localize-labels=true class=date-picker-wrapper>
          <select asp-localize-labels=true name="day">
            <option value=0><?=$this->langs->day;?></option>
            <option value=1>1</option>
            <option value=2>2</option>
            <option value=3>3</option>
            <option value=4>4</option>
            <option value=5>5</option>
            <option value=6>6</option>
            <option value=7>7</option>
            <option value=8>8</option>
            <option value=9>9</option>
            <option value=10>10</option>
            <option value=11>11</option>
            <option value=12>12</option>
            <option value=13>13</option>
            <option value=14>14</option>
            <option value=15>15</option>
            <option value=16>16</option>
            <option value=17>17</option>
            <option value=18>18</option>
            <option value=19>19</option>
            <option value=20>20</option>
            <option value=21>21</option>
            <option value=22>22</option>
            <option value=23>23</option>
            <option value=24>24</option>
            <option value=25>25</option>
            <option value=26>26</option>
            <option value=27>27</option>
            <option value=28>28</option>
            <option value=29>29</option>
            <option value=30>30</option>
            <option value=31>31</option>
          </select>
          <select asp-localize-labels=true name="month">
            <option value=0><?=$this->langs->month;?></option>
            <?php
            for ($i=1; $i <= 12; $i++) {
              $current_month = strtolower(date("F", mktime(0, 0, 0, $i, 10)));
              echo '<option value="'.$i.'">'.$this->langs->{$current_month}.'</option>';
            }
             ?>
          </select>
          <select asp-localize-labels=true name="year">
            <option value=0><?=$this->langs->year;?></option>
            <?php
            for ($i=1950; $i <= date("Y"); $i++) {
              echo '<option value="'.$i.'">'.$i.'</option>';
            }
             ?>
          </select>
        </div><span class=field-validation-valid data-valmsg-for=DateOfBirthDay data-valmsg-replace=true></span>  <span class=field-validation-valid data-valmsg-for=DateOfBirthMonth data-valmsg-replace=true></span>  <span class=field-validation-valid data-valmsg-for=DateOfBirthYear data-valmsg-replace=true></span>
      </div>
      <div class=inputs>
        <label for=email><?=$this->langs->email;?>:</label>
        <input type=text id=email name="email"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=email data-valmsg-replace=true></span>
      </div>
      <div class=inputs>
        <label for=phone><?=$this->langs->phone;?>:</label>
        <input type=text id=phone name="phone"> <span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=phone data-valmsg-replace=true></span>
      </div>
      <div class=inputs>
        <label for=address><?=$this->langs->delivery_address;?>:</label>
        <textarea rows=3 data-val=true data-val-required="<?=$this->langs->required;?>" type=text id=address name="address"><?=trim((isset($user->address)?$user->address:$this->input->get("address")));?></textarea><span class=required>*</span>  <span class=field-validation-valid data-valmsg-for=address data-valmsg-replace=true></span>
      </div>
      <div class=inputs><label for=zip_code><?=$this->langs->zip_code;?>:</label> <input type=text data-val=true data-val-required="<?=$this->langs->required;?>" id=zip_code name="zip_code" value="<?=isset($user->zip_code)?$user->zip_code:$this->input->get("zip_code");?>"> <span class=required>*</span> <span class=field-validation-valid data-valmsg-for="zip_code" data-valmsg-replace="true"></span>
      </div>

    </div>
  </div>
  <div class=fieldset>
    <div class=titles><strong><?=$this->langs->company_details;?></strong>
    </div>
    <div class=form-fields>
      <div class=inputs>
        <label for=company_name><?=$this->langs->company_name;?>:</label>
        <input type=text id=company_name name=company_name> <span class=field-validation-valid data-valmsg-for=company_name data-valmsg-replace=true></span>
      </div>
    </div>
  </div>

  <div class=fieldset>
    <div class=titles><strong><?=$this->langs->your_pass;?></strong>
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
  <div class=fieldset>
    <div class=titles><strong><?=$this->langs->subscribe;?></strong>
    </div>
    <div class="form-fields gender">
      <div class=inputs>
        <span class=female> <input type=checkbox checked value="1" id=subscribe name="subscribe"> <label class=forcheckbox for=subscribe><?=$this->langs->news_notif;?></label> </span>
      </div>
    </div>
  </div>
  <div class=form-fields>
    <div class=captcha-box>
      <?=$this->load->view("site/captcha", "", true);?>
    </div>
  </div>
  <div class=buttons>
    <input type=submit id=register-button class="button-1 register-next-step-button" value="<?=$this->langs->submit;?>" name=register-button>
  </div>
  <input name=__RequestVerificationToken type=hidden value=CfDJ8BZg4PhImT5Hp-usOReKji5ngDlruxDQ7B6WvWudg2BbG6HKfnAUCn-cIhzxE_vuk9Kk4qDjOWDBEznAXtIi2bYixYzg8k6aImfQM0n1SL9VnWviVG2Tv55g22B3WdsNekER0jUaJaYzWW7jQuTIjr8>
  <input name=Newsletter type=hidden value=false>
</form>
