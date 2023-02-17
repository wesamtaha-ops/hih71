<?php

// id
// user_id
// timezone
// teacher_language
// video
// heading_ar
// description_ar
// heading_en
// description_en
// allow_express
// fees
// currency_id
// created_at
// updated_at

?>
<?php if ($teachers->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_teachersmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($teachers->id->Visible) { // id ?>
		<tr id="r_id">
			<td class="col-sm-2"><?php echo $teachers->id->FldCaption() ?></td>
			<td<?php echo $teachers->id->CellAttributes() ?>>
<span id="el_teachers_id">
<span<?php echo $teachers->id->ViewAttributes() ?>>
<?php echo $teachers->id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->user_id->Visible) { // user_id ?>
		<tr id="r_user_id">
			<td class="col-sm-2"><?php echo $teachers->user_id->FldCaption() ?></td>
			<td<?php echo $teachers->user_id->CellAttributes() ?>>
<span id="el_teachers_user_id">
<span<?php echo $teachers->user_id->ViewAttributes() ?>>
<?php echo $teachers->user_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->timezone->Visible) { // timezone ?>
		<tr id="r_timezone">
			<td class="col-sm-2"><?php echo $teachers->timezone->FldCaption() ?></td>
			<td<?php echo $teachers->timezone->CellAttributes() ?>>
<span id="el_teachers_timezone">
<span<?php echo $teachers->timezone->ViewAttributes() ?>>
<?php echo $teachers->timezone->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->teacher_language->Visible) { // teacher_language ?>
		<tr id="r_teacher_language">
			<td class="col-sm-2"><?php echo $teachers->teacher_language->FldCaption() ?></td>
			<td<?php echo $teachers->teacher_language->CellAttributes() ?>>
<span id="el_teachers_teacher_language">
<span<?php echo $teachers->teacher_language->ViewAttributes() ?>>
<?php echo $teachers->teacher_language->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->video->Visible) { // video ?>
		<tr id="r_video">
			<td class="col-sm-2"><?php echo $teachers->video->FldCaption() ?></td>
			<td<?php echo $teachers->video->CellAttributes() ?>>
<span id="el_teachers_video">
<span<?php echo $teachers->video->ViewAttributes() ?>>
<?php echo $teachers->video->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->heading_ar->Visible) { // heading_ar ?>
		<tr id="r_heading_ar">
			<td class="col-sm-2"><?php echo $teachers->heading_ar->FldCaption() ?></td>
			<td<?php echo $teachers->heading_ar->CellAttributes() ?>>
<span id="el_teachers_heading_ar">
<span<?php echo $teachers->heading_ar->ViewAttributes() ?>>
<?php echo $teachers->heading_ar->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->description_ar->Visible) { // description_ar ?>
		<tr id="r_description_ar">
			<td class="col-sm-2"><?php echo $teachers->description_ar->FldCaption() ?></td>
			<td<?php echo $teachers->description_ar->CellAttributes() ?>>
<span id="el_teachers_description_ar">
<span<?php echo $teachers->description_ar->ViewAttributes() ?>>
<?php echo $teachers->description_ar->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->heading_en->Visible) { // heading_en ?>
		<tr id="r_heading_en">
			<td class="col-sm-2"><?php echo $teachers->heading_en->FldCaption() ?></td>
			<td<?php echo $teachers->heading_en->CellAttributes() ?>>
<span id="el_teachers_heading_en">
<span<?php echo $teachers->heading_en->ViewAttributes() ?>>
<?php echo $teachers->heading_en->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->description_en->Visible) { // description_en ?>
		<tr id="r_description_en">
			<td class="col-sm-2"><?php echo $teachers->description_en->FldCaption() ?></td>
			<td<?php echo $teachers->description_en->CellAttributes() ?>>
<span id="el_teachers_description_en">
<span<?php echo $teachers->description_en->ViewAttributes() ?>>
<?php echo $teachers->description_en->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->allow_express->Visible) { // allow_express ?>
		<tr id="r_allow_express">
			<td class="col-sm-2"><?php echo $teachers->allow_express->FldCaption() ?></td>
			<td<?php echo $teachers->allow_express->CellAttributes() ?>>
<span id="el_teachers_allow_express">
<span<?php echo $teachers->allow_express->ViewAttributes() ?>>
<?php echo $teachers->allow_express->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->fees->Visible) { // fees ?>
		<tr id="r_fees">
			<td class="col-sm-2"><?php echo $teachers->fees->FldCaption() ?></td>
			<td<?php echo $teachers->fees->CellAttributes() ?>>
<span id="el_teachers_fees">
<span<?php echo $teachers->fees->ViewAttributes() ?>>
<?php echo $teachers->fees->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->currency_id->Visible) { // currency_id ?>
		<tr id="r_currency_id">
			<td class="col-sm-2"><?php echo $teachers->currency_id->FldCaption() ?></td>
			<td<?php echo $teachers->currency_id->CellAttributes() ?>>
<span id="el_teachers_currency_id">
<span<?php echo $teachers->currency_id->ViewAttributes() ?>>
<?php echo $teachers->currency_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->created_at->Visible) { // created_at ?>
		<tr id="r_created_at">
			<td class="col-sm-2"><?php echo $teachers->created_at->FldCaption() ?></td>
			<td<?php echo $teachers->created_at->CellAttributes() ?>>
<span id="el_teachers_created_at">
<span<?php echo $teachers->created_at->ViewAttributes() ?>>
<?php echo $teachers->created_at->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($teachers->updated_at->Visible) { // updated_at ?>
		<tr id="r_updated_at">
			<td class="col-sm-2"><?php echo $teachers->updated_at->FldCaption() ?></td>
			<td<?php echo $teachers->updated_at->CellAttributes() ?>>
<span id="el_teachers_updated_at">
<span<?php echo $teachers->updated_at->ViewAttributes() ?>>
<?php echo $teachers->updated_at->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
