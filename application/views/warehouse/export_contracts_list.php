<div class="m-subheader ">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
				<li class="m-nav__item m-nav__item--home">
					<a href="/slides/get_view_main/" class="m-nav__link m-nav__link--icon">
						<i class="m-nav__link-icon la la-home"></i>
					</a>
				</li>
			</ul>
			<h3 class="m-subheader__title m-subheader__title--separator">
				<?=$page_title; ?>
			</h3>
		</div>
	</div>
</div>
<!-- END: Subheader -->
	<div class="m-content">
		<div class="row">
			<div class="col-lg-12">
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
				<!--begin::Portlet-->
				<div class="m-portlet m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									<?=$this->langs->new_export_contract; ?>
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">
                <form action="/warehouse/export_contracts_list" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="<?=$this->security->get_csrf_token_name(); ?>" value="<?=$this->security->get_csrf_hash(); ?>">

                  <div class="form-group m-form__group row">
                    <div class="col-md-4 col-lg-3">
                      <div class="form-group">
                        <label><?=$this->langs->contract_number; ?></label>
                        <input class="form-control m-input" placeholder="" required value="<?=$contract_number; ?>" disabled/>
                      </div>
                    </div>

										<div class="col-md-4 col-lg-3">
                      <div class="form-group">
                        <label for="buyer"><?=$this->langs->buyer; ?></label>
												<select id="buyer" name="buyer" class="form-control" required>
													<option value=""></option>
													<?php foreach ($buyers as $row): ?>
														<option value="<?=$row->user_id; ?>"><?=$row->company_name; ?></option>
													<?php endforeach; ?>>
												</select>
                      </div>
                    </div>

										<div class="col-md-4 col-lg-3">
                      <div class="form-group">
                        <label for="voen">Voen</label>
      									<input id="voen" name="voen" class="form-control m-input" placeholder="" required/>
                      </div>
                    </div>

										<div class="col-md-4 col-lg-3">
                      <div class="form-group">
                        <label for="address"><?=$this->langs->delivery_address; ?></label>
      									<input id="address" name="address" class="form-control m-input" placeholder="" required/>
                      </div>
                    </div>

										<div class="col-md-4 col-lg-3">
                      <div class="form-group">
                        <label for="deliveryman"><?=$this->langs->receiver; ?></label>
      									<input id="deliveryman" name="deliveryman" class="form-control m-input" placeholder="" required/>
                      </div>
                    </div>

										<div class="col-md-4 col-lg-3">
                      <div class="form-group">
                        <label for="description"><?=$this->langs->comment2; ?></label>
      									<input id="description" name="description" class="form-control m-input" placeholder="" required/>
                      </div>
                    </div>

										<div class="col-md-4 col-lg-3">
                      <div class="form-group">
                        <label><?=$this->langs->contract; ?> (pdf)</label>
      									<input type="file" name="pdf_upload" class="form-control m-input" required/>
                      </div>
                    </div>

                  </div>

                  <div class="col-lg-12 m--align-left">
                    <button type="submit_ru" class="btn btn-success"><i class="fa fa-plus"></i> <?=$this->langs->add; ?></button>
                  </div>

                </form>

							</div>
						</div>

					</div>
				</div>

        <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon m--hide">
                  <i class="la la-gear"></i>
                </span>
                <h3 class="m-portlet__head-text">
                  <?=$this->langs->export_contracts_list; ?>
                </h3>
              </div>
            </div>
          </div>
          <div class="m-portlet__body">
            <table delete_url="/warehouse/delete_export_contract/" class="table table-bordered m-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?=$this->langs->contract_number; ?></th>
									<th><?=$this->langs->buyer; ?></th>
                  <th>Voen</th>
                  <th><?=$this->langs->delivery_address; ?></th>
                  <th><?=$this->langs->receiver; ?></th>
                  <th><?=$this->langs->comment2; ?></th>
									<th><?=$this->langs->created; ?></th>
                  <th><?=$this->langs->delete; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0; foreach($export_contracts_list as $row): $i++; ?>
                  <tr>
                    <td><?=$i; ?></td>
                    <td><a style="text-decoration: none; color: inherit;" target="_blank" href="<?=$row->pdf_path?$row->pdf_path:'#'; ?>"><u>#<?=$row->contract_number; ?></u></a></td>
										<td><?=$row->company_name; ?></td>
                    <td><?=$row->voen; ?></td>
                    <td><?=$row->address; ?></td>
                    <td><?=$row->deliveryman; ?></td>
                    <td><?=$row->description; ?></td>
										<td><?=$row->created; ?></td>
                    <td>
                      <button
                        class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete"
                        rel="<?=$row->id; ?>"
                      >
  											<i class="fa fa-trash"></i>
  										</button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
			</div>
		</div>
    <div class="row">
      <div class="col-lg-12">
        <div class="text-center">
           <ul class="pagination pagination-lg text-center" style="display: inline-flex;">
              <?=@$pagination;?>
           </ul>
        </div>
      </div>
    </div>
	</div>
