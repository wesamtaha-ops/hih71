<?php

// user_id
// is_parent
// level_id
// study_year
// language_id
// langauge_level_id
// created_at
// updated_at

?>
<?php if ($students->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_studentsmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($students->user_id->Visible) { // user_id ?>
		<tr id="r_user_id">
			<td class="col-sm-2"><?php echo $students->user_id->FldCaption() ?></td>
			<td<?php echo $students->user_id->CellAttributes() ?>>
<span id="el_students_user_id">
<span<?php echo $students->user_id->ViewAttributes() ?>>
<?php echo $students->user_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($students->is_parent->Visible) { // is_parent ?>
		<tr id="r_is_parent">
			<td class="col-sm-2"><?php echo $students->is_parent->FldCaption() ?></td>
			<td<?php echo $students->is_parent->CellAttributes() ?>>
<span id="el_students_is_parent">
<span<?php echo $students->is_parent->ViewAttributes() ?>>
<?php echo $students->is_parent->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($students->level_id->Visible) { // level_id ?>
		<tr id="r_level_id">
			<td class="col-sm-2"><?php echo $students->level_id->FldCaption() ?></td>
			<td<?php echo $students->level_id->CellAttributes() ?>>
<span id="el_students_level_id">
<span<?php echo $students->level_id->ViewAttributes() ?>>
<?php echo $students->level_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($students->study_year->Visible) { // study_year ?>
		<tr id="r_study_year">
			<td class="col-sm-2"><?php echo $students->study_year->FldCaption() ?></td>
			<td<?php echo $students->study_year->CellAttributes() ?>>
<span id="el_students_study_year">
<span<?php echo $students->study_year->ViewAttributes() ?>>
<?php echo $students->study_year->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($students->language_id->Visible) { // language_id ?>
		<tr id="r_language_id">
			<td class="col-sm-2"><?php echo $students->language_id->FldCaption() ?></td>
			<td<?php echo $students->language_id->CellAttributes() ?>>
<span id="el_students_language_id">
<span<?php echo $students->language_id->ViewAttributes() ?>>
<?php echo $students->language_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($students->langauge_level_id->Visible) { // langauge_level_id ?>
		<tr id="r_langauge_level_id">
			<td class="col-sm-2"><?php echo $students->langauge_level_id->FldCaption() ?></td>
			<td<?php echo $students->langauge_level_id->CellAttributes() ?>>
<span id="el_students_langauge_level_id">
<span<?php echo $students->langauge_level_id->ViewAttributes() ?>>
<?php echo $students->langauge_level_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($students->created_at->Visible) { // created_at ?>
		<tr id="r_created_at">
			<td class="col-sm-2"><?php echo $students->created_at->FldCaption() ?></td>
			<td<?php echo $students->created_at->CellAttributes() ?>>
<span id="el_students_created_at">
<span<?php echo $students->created_at->ViewAttributes() ?>>
<?php echo $students->created_at->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($students->updated_at->Visible) { // updated_at ?>
		<tr id="r_updated_at">
			<td class="col-sm-2"><?php echo $students->updated_at->FldCaption() ?></td>
			<td<?php echo $students->updated_at->CellAttributes() ?>>
<span id="el_students_updated_at">
<span<?php echo $students->updated_at->ViewAttributes() ?>>
<?php echo $students->updated_at->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
