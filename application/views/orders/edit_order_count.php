
	<div class="m-content">
		<div class="row">
			<div class="col-lg-12">
				<!--begin::Portlet-->
				<div class="m-portlet m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Siyahı
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<ul class="m-portlet__nav">
								<li class="m-portlet__nav-item">
									<a href="#"  m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
										<i class="la la-angle-down"></i>
									</a>
								</li>
								<li class="m-portlet__nav-item">
									<a href="#"  m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
										<i class="la la-expand"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="m-portlet__body">
						<!--begin: Datatable -->
						<table class="table table-bordered m-table" width="100%">
							<thead>
								<tr>
									<th>#</th>
									<th><?=$this->langs->name2; ?></th>
                  <th><?=$this->langs->count; ?></th>
                  <th><?=$this->langs->measurement; ?></th>
									<th><?=$this->langs->comment; ?></th>
                  <th><?=$this->langs->edit; ?></th>
								</tr>
							</thead>
							<tbody>
                <?php $i=0; foreach($product_list as $row): $i++; ?>
  								<tr>
  	                <td><?=$i; ?></td>
  									<td><?=$row->name; ?></td>
                    <td>
                      <span class="edit_close" name="count_span"><?=$row->count; ?></span>
                      <input type="text" class="form-control edit_open" name="count" value="<?=$row->count; ?>">
                    </td>
                    <td><?=$row->measure; ?></td>
										<td><?=$row->comment?$row->comment:'---'; ?></td>
                    <td>
                      <div class="flex-justify-center">
                        <button class="edit btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only" name="<?=$row->id; ?>">
                          <i class="fa fa-pencil-alt"></i>
                        </button>
                      </div>
                    </td>
  								</tr>
                <?php endforeach; ?>
							</tbody>
						</table>
						<!--end: Datatable -->
					</div>
				</div>
				<!--end::Portlet-->
			</div>
		</div>
	</div>
  <input type="hidden" id="token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
<style media="screen">
.flex-justify-center{
  position: relative;
  float: left;
  width: 100%;
  display: flex;
  justify-content: center;
}
input:not([type=radio]){
  min-width: 80px;
}
.edit_open{
  display: none;
}
</style>
<script type="text/javascript">

$(document).on('click', '.edit', function(){
  $(this).closest('tr').find('.edit_open').show();
  $(this).closest('tr').find('.edit_close').hide();
  $(this).closest('.flex-justify-center').html('<button class="save btn btn-success btn-sm m-btn m-btn--icon m-btn--icon-only" name="'+ $(this).attr('name') +'"><i class="fa fa-save" aria-hidden="true"></i></button>');
});

token = $('#token').val();
$(document).on('click', '.save', function(){
  var thiss = $(this);
  var closest = $(this).closest('tr');
  $.ajax({
    url: '/orders/update_count',
    type: 'POST',
    data: { tezbazar: token,
            id: thiss.attr('name'),
            count: closest.find('input[name="count"]').val()
    },
    success: function(data){
      var res = $.parseJSON(data);
      token = res.tezbazar;
      if (res.msg)
      {
        closest.find('span[name="count_span"]').text(closest.find('input[name="count"]').val());
        closest.find('.edit_open').hide();
        closest.find('.edit_close').show();
        thiss.closest('.flex-justify-center').html('<button class="edit btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only" name="'+ thiss.attr('name') +'"><i class="fa fa-pencil-alt"></i></button>');

        toastr["success"](res.message, res.title);
      } else {
        toastr["error"](res.message, res.title);
      }
    },
    error: function(){
      toastr["error"]('Xəta baş verdi', 'Xəta');
    }
  });
});

</script>
