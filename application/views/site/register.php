<div class=master-wrapper-content>
	<div class=master-column-wrapper>
		<div class=center-1>
			<div class="page registration-page">
				<div class=page-title>
					<h1><?=$this->langs->register;?></h1>
				</div>
        <?php if (isset($status)){?>
        <div class="alert alert-<?=$status["status"];?>">
          <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
          <h4 class="alert-heading"><?=$status["title"];?></h4>
          <?=$status["msg"];?>
        </div>
			<?php }  if(!$this->session->userdata("user_id")){ ?>
        <br >
				<div class=page-body>
					<?=$register_form;?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
