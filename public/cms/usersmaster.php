<?php

// id
// name
// email
// phone
// gender
// birthday
// image
// country_id
// city
// currency_id
// type
// is_verified
// is_approved
// is_blocked
// otp
// slug

?>
<?php if ($users->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_usersmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($users->id->Visible) { // id ?>
		<tr id="r_id">
			<td class="col-sm-2"><?php echo $users->id->FldCaption() ?></td>
			<td<?php echo $users->id->CellAttributes() ?>>
<span id="el_users_id">
<span<?php echo $users->id->ViewAttributes() ?>>
<?php echo $users->id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
		<tr id="r_name">
			<td class="col-sm-2"><?php echo $users->name->FldCaption() ?></td>
			<td<?php echo $users->name->CellAttributes() ?>>
<span id="el_users_name">
<span<?php echo $users->name->ViewAttributes() ?>>
<?php echo $users->name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->_email->Visible) { // email ?>
		<tr id="r__email">
			<td class="col-sm-2"><?php echo $users->_email->FldCaption() ?></td>
			<td<?php echo $users->_email->CellAttributes() ?>>
<span id="el_users__email">
<span<?php echo $users->_email->ViewAttributes() ?>>
<?php echo $users->_email->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->phone->Visible) { // phone ?>
		<tr id="r_phone">
			<td class="col-sm-2"><?php echo $users->phone->FldCaption() ?></td>
			<td<?php echo $users->phone->CellAttributes() ?>>
<span id="el_users_phone">
<span<?php echo $users->phone->ViewAttributes() ?>>
<?php echo $users->phone->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->gender->Visible) { // gender ?>
		<tr id="r_gender">
			<td class="col-sm-2"><?php echo $users->gender->FldCaption() ?></td>
			<td<?php echo $users->gender->CellAttributes() ?>>
<span id="el_users_gender">
<span<?php echo $users->gender->ViewAttributes() ?>>
<?php echo $users->gender->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->birthday->Visible) { // birthday ?>
		<tr id="r_birthday">
			<td class="col-sm-2"><?php echo $users->birthday->FldCaption() ?></td>
			<td<?php echo $users->birthday->CellAttributes() ?>>
<span id="el_users_birthday">
<span<?php echo $users->birthday->ViewAttributes() ?>>
<?php echo $users->birthday->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->image->Visible) { // image ?>
		<tr id="r_image">
			<td class="col-sm-2"><?php echo $users->image->FldCaption() ?></td>
			<td<?php echo $users->image->CellAttributes() ?>>
<span id="el_users_image">
<span<?php echo $users->image->ViewAttributes() ?>>
<?php echo $users->image->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->country_id->Visible) { // country_id ?>
		<tr id="r_country_id">
			<td class="col-sm-2"><?php echo $users->country_id->FldCaption() ?></td>
			<td<?php echo $users->country_id->CellAttributes() ?>>
<span id="el_users_country_id">
<span<?php echo $users->country_id->ViewAttributes() ?>>
<?php echo $users->country_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->city->Visible) { // city ?>
		<tr id="r_city">
			<td class="col-sm-2"><?php echo $users->city->FldCaption() ?></td>
			<td<?php echo $users->city->CellAttributes() ?>>
<span id="el_users_city">
<span<?php echo $users->city->ViewAttributes() ?>>
<?php echo $users->city->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->currency_id->Visible) { // currency_id ?>
		<tr id="r_currency_id">
			<td class="col-sm-2"><?php echo $users->currency_id->FldCaption() ?></td>
			<td<?php echo $users->currency_id->CellAttributes() ?>>
<span id="el_users_currency_id">
<span<?php echo $users->currency_id->ViewAttributes() ?>>
<?php echo $users->currency_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->type->Visible) { // type ?>
		<tr id="r_type">
			<td class="col-sm-2"><?php echo $users->type->FldCaption() ?></td>
			<td<?php echo $users->type->CellAttributes() ?>>
<span id="el_users_type">
<span<?php echo $users->type->ViewAttributes() ?>>
<?php echo $users->type->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->is_verified->Visible) { // is_verified ?>
		<tr id="r_is_verified">
			<td class="col-sm-2"><?php echo $users->is_verified->FldCaption() ?></td>
			<td<?php echo $users->is_verified->CellAttributes() ?>>
<span id="el_users_is_verified">
<span<?php echo $users->is_verified->ViewAttributes() ?>>
<?php echo $users->is_verified->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->is_approved->Visible) { // is_approved ?>
		<tr id="r_is_approved">
			<td class="col-sm-2"><?php echo $users->is_approved->FldCaption() ?></td>
			<td<?php echo $users->is_approved->CellAttributes() ?>>
<span id="el_users_is_approved">
<span<?php echo $users->is_approved->ViewAttributes() ?>>
<?php echo $users->is_approved->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->is_blocked->Visible) { // is_blocked ?>
		<tr id="r_is_blocked">
			<td class="col-sm-2"><?php echo $users->is_blocked->FldCaption() ?></td>
			<td<?php echo $users->is_blocked->CellAttributes() ?>>
<span id="el_users_is_blocked">
<span<?php echo $users->is_blocked->ViewAttributes() ?>>
<?php echo $users->is_blocked->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->otp->Visible) { // otp ?>
		<tr id="r_otp">
			<td class="col-sm-2"><?php echo $users->otp->FldCaption() ?></td>
			<td<?php echo $users->otp->CellAttributes() ?>>
<span id="el_users_otp">
<span<?php echo $users->otp->ViewAttributes() ?>>
<?php echo $users->otp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($users->slug->Visible) { // slug ?>
		<tr id="r_slug">
			<td class="col-sm-2"><?php echo $users->slug->FldCaption() ?></td>
			<td<?php echo $users->slug->CellAttributes() ?>>
<span id="el_users_slug">
<span<?php echo $users->slug->ViewAttributes() ?>>
<?php echo $users->slug->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
