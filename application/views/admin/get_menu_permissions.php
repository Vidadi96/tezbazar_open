<table class="m-datatable inline_edit" id="html_table" width="100%" delete_url="/adm/delete_admin_menu/" inline_save_url="/adm/update_menu/">
	<thead>
	<tr>
		<th style="width:8px;" class="no-sort">
			#
		</th>
		<th>
			 Menyu adı
		</th>
		<th>
			 Menyu tipi
		</th>
		<th width="30">
			 redaktə
		</th>
		<th width="30">
			 Sil
		</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($menus as $menu): ?>
	<tr class="<?=$menu["permission"] ? 'selected_tr' : "";?>">
		<td>
			<input type="checkbox" class="checkboxes"  value="<?=$menu['menu_id'];?>" <?=$menu["permission"] ? 'checked="checked" class="checked"' : "";?>/>
		</td>
		<td><?=$menu['full_name'];?></td>
		<td><?=$menu['menu_type_id']== 1 ? "<b>Menyu</b>" : "Metod";?></td>
    <td>
      <a href="/adm/edit_admin_menu/<?=$menu['menu_id'];?>" class="btn btn-primary btn-sm m-btn m-btn--icon m-btn--icon-only">
        <i class="fa fa-pencil-alt"></i>
      </button>
    </td>
    <td>
      <button href="#" class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--icon-only delete" rel="<?=$menu['menu_id'];?>">
        <i class="fa fa-trash"></i>
      </button>
    </td>

	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<br />
<button class="btn btn-success pull-right save_menu_permission" type="button"><i class="fa fa-save"></i> Yadda saxla</button>
<br />
<br />
<br />
<br />
