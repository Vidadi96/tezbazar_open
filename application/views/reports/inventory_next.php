<form action="/reports/inventory_excel" method="POST">
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
				<li class="m-nav__item m-nav__item--home">
					<a href="/adm/index/" class="m-nav__link m-nav__link--icon">
						<i class="m-nav__link-icon la la-home"></i>
					</a>
				</li>
			</ul>
			<h3 class="m-subheader__title m-subheader__title--separator">
				<?=$page_title;?>
			</h3>
		</div>
	</div>
</div>
<!-- END: Subheader -->
	<div class="m-content">
		<div class="row">
			<div class="col-lg-12">
				<!--begin::Portlet-->
        <?php if(isset($status)): ?>
				<div class="m-alert m-alert--icon m-alert--outline alert alert-<?=$status['status'];?> alert-dismissible fade show" role="alert">
					<div class="m-alert__icon">
						<i class="fa fa-<?=$status['icon'];?>"></i>
					</div>
					<div class="m-alert__text">
						<strong><?=$status['title'];?> </strong> <?=$status['msg'];?>
					</div>
					<div class="m-alert__close">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
					</div>
				</div>
				<?php endif;?>
				<div class="m-portlet m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									<?=$this->langs->list; ?>
								</h3>
                <div class="absolute_right">
                    <input id="token" type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <button type="submit" class="btn btn-success excel_click">
                      <i class="fa fa-file-excel"></i> Export
                    </button>
                </div>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<ul class="m-portlet__nav">
							</ul>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">
    						<div class="row">
    							<div class="col-xl-12" style="overflow: auto;">
    								<table class="table table-bordered m-table">
    									<thead>
    										<tr>
    											<th><?=$this->langs->code_of_product; ?></th>
    											<th><?=$this->langs->product_name; ?></th>
                          <th><?=$this->langs->count; ?></th>
                          <th><?=$this->langs->availability; ?></th>
                          <th><?=$this->langs->difference; ?></th>
    										</tr>
    									</thead>
    									<tbody>
                        <?php $i=0; foreach ($list as $row): ?>
                          <tr>
                            <td>
                              #<?=$row->sku; ?>
                              <input type="hidden" name="sku[]" value="#<?=$row->sku; ?>">
                            </td>
                            <td>
                              <?=$row->product_name; ?>
                              <input type="hidden" name="product_name[]" value="<?=$row->product_name; ?>">
                            </td>
                            <td>
                              <?=$count_arr[$i]; ?>
                              <input type="hidden" name="count[]" value="<?=$count_arr[$i]; ?>">
                            </td>
                            <td>
                              <?=$row->count; ?>
                              <input type="hidden" name="availability[]" value="<?=$row->count; ?>">
                            </td>
                            <td>
                              <?=$row->count - $count_arr[$i]; ?>
                              <input type="hidden" name="difference[]" value="<?=$row->count - $count_arr[$i]; ?>">
                            </td>
                          </tr>
                        <?php $i++; endforeach; ?>
    									</tbody>
    								</table>
    							</div>
    						</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/easyui.css">
<link rel="stylesheet" type="text/css" href="/css/icon.css">
<script type="text/javascript" src="/js/jquery.easyui.min.js"></script>

<style media="screen">
	.absolute_right{
		position: absolute;
		float: left;
		width: calc(100% - 32px);
		display: flex;
		justify-content: flex-end;
	}
</style>

<script type="text/javascript">

$('.excel_click').click(function(){
	event.preventDefault();

  var sku = $("input[name='sku[]']").map(function(){
              return $(this).val();
            }).get();

  var product_name = $("input[name='product_name[]']").map(function(){
              return $(this).val();
            }).get();

  var count = $("input[name='count[]']").map(function(){
              return $(this).val();
            }).get();

  var availability = $("input[name='availability[]']").map(function(){
              return $(this).val();
            }).get();

  var difference = $("input[name='difference[]']").map(function(){
              return $(this).val();
            }).get();

	$.ajax({
    type:'POST',
    url:'/reports/inventory_excel',
    data: {sku: JSON.stringify(sku),
           product_name: JSON.stringify(product_name),
           count: JSON.stringify(count),
           availability: JSON.stringify(availability),
           difference: JSON.stringify(difference),
					 tezbazar: $('#token').val()
				 	},
    dataType:'json'
  }).done(function(data){
      var $a = $("<a>");
      $a.attr("href", data.file);
      $("body").append($a);
      $a.attr("download","Export.xls");
      $a[0].click();
      $a.remove();
  });
});

</script>
