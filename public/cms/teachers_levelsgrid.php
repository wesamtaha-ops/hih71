<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($teachers_levels_grid)) $teachers_levels_grid = new cteachers_levels_grid();

// Page init
$teachers_levels_grid->Page_Init();

// Page main
$teachers_levels_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_levels_grid->Page_Render();
?>
<?php if ($teachers_levels->Export == "") { ?>
<script type="text/javascript">

// Form object
var fteachers_levelsgrid = new ew_Form("fteachers_levelsgrid", "grid");
fteachers_levelsgrid.FormKeyCountName = '<?php echo $teachers_levels_grid->FormKeyCountName ?>';

// Validate form
fteachers_levelsgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_levels->teacher_id->FldCaption(), $teachers_levels->teacher_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_levels->teacher_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_level_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_levels->level_id->FldCaption(), $teachers_levels->level_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_level_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_levels->level_id->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fteachers_levelsgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "teacher_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "level_id", false)) return false;
	return true;
}

// Form_CustomValidate event
fteachers_levelsgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachers_levelsgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($teachers_levels->CurrentAction == "gridadd") {
	if ($teachers_levels->CurrentMode == "copy") {
		$bSelectLimit = $teachers_levels_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$teachers_levels_grid->TotalRecs = $teachers_levels->ListRecordCount();
			$teachers_levels_grid->Recordset = $teachers_levels_grid->LoadRecordset($teachers_levels_grid->StartRec-1, $teachers_levels_grid->DisplayRecs);
		} else {
			if ($teachers_levels_grid->Recordset = $teachers_levels_grid->LoadRecordset())
				$teachers_levels_grid->TotalRecs = $teachers_levels_grid->Recordset->RecordCount();
		}
		$teachers_levels_grid->StartRec = 1;
		$teachers_levels_grid->DisplayRecs = $teachers_levels_grid->TotalRecs;
	} else {
		$teachers_levels->CurrentFilter = "0=1";
		$teachers_levels_grid->StartRec = 1;
		$teachers_levels_grid->DisplayRecs = $teachers_levels->GridAddRowCount;
	}
	$teachers_levels_grid->TotalRecs = $teachers_levels_grid->DisplayRecs;
	$teachers_levels_grid->StopRec = $teachers_levels_grid->DisplayRecs;
} else {
	$bSelectLimit = $teachers_levels_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($teachers_levels_grid->TotalRecs <= 0)
			$teachers_levels_grid->TotalRecs = $teachers_levels->ListRecordCount();
	} else {
		if (!$teachers_levels_grid->Recordset && ($teachers_levels_grid->Recordset = $teachers_levels_grid->LoadRecordset()))
			$teachers_levels_grid->TotalRecs = $teachers_levels_grid->Recordset->RecordCount();
	}
	$teachers_levels_grid->StartRec = 1;
	$teachers_levels_grid->DisplayRecs = $teachers_levels_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$teachers_levels_grid->Recordset = $teachers_levels_grid->LoadRecordset($teachers_levels_grid->StartRec-1, $teachers_levels_grid->DisplayRecs);

	// Set no record found message
	if ($teachers_levels->CurrentAction == "" && $teachers_levels_grid->TotalRecs == 0) {
		if ($teachers_levels_grid->SearchWhere == "0=101")
			$teachers_levels_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$teachers_levels_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$teachers_levels_grid->RenderOtherOptions();
?>
<?php $teachers_levels_grid->ShowPageHeader(); ?>
<?php
$teachers_levels_grid->ShowMessage();
?>
<?php if ($teachers_levels_grid->TotalRecs > 0 || $teachers_levels->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($teachers_levels_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> teachers_levels">
<div id="fteachers_levelsgrid" class="ewForm ewListForm form-inline">
<?php if ($teachers_levels_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($teachers_levels_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_teachers_levels" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_teachers_levelsgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$teachers_levels_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$teachers_levels_grid->RenderListOptions();

// Render list options (header, left)
$teachers_levels_grid->ListOptions->Render("header", "left");
?>
<?php if ($teachers_levels->teacher_id->Visible) { // teacher_id ?>
	<?php if ($teachers_levels->SortUrl($teachers_levels->teacher_id) == "") { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_levels->teacher_id->HeaderCellClass() ?>"><div id="elh_teachers_levels_teacher_id" class="teachers_levels_teacher_id"><div class="ewTableHeaderCaption"><?php echo $teachers_levels->teacher_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_levels->teacher_id->HeaderCellClass() ?>"><div><div id="elh_teachers_levels_teacher_id" class="teachers_levels_teacher_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_levels->teacher_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_levels->teacher_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_levels->teacher_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_levels->level_id->Visible) { // level_id ?>
	<?php if ($teachers_levels->SortUrl($teachers_levels->level_id) == "") { ?>
		<th data-name="level_id" class="<?php echo $teachers_levels->level_id->HeaderCellClass() ?>"><div id="elh_teachers_levels_level_id" class="teachers_levels_level_id"><div class="ewTableHeaderCaption"><?php echo $teachers_levels->level_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="level_id" class="<?php echo $teachers_levels->level_id->HeaderCellClass() ?>"><div><div id="elh_teachers_levels_level_id" class="teachers_levels_level_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_levels->level_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_levels->level_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_levels->level_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$teachers_levels_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$teachers_levels_grid->StartRec = 1;
$teachers_levels_grid->StopRec = $teachers_levels_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($teachers_levels_grid->FormKeyCountName) && ($teachers_levels->CurrentAction == "gridadd" || $teachers_levels->CurrentAction == "gridedit" || $teachers_levels->CurrentAction == "F")) {
		$teachers_levels_grid->KeyCount = $objForm->GetValue($teachers_levels_grid->FormKeyCountName);
		$teachers_levels_grid->StopRec = $teachers_levels_grid->StartRec + $teachers_levels_grid->KeyCount - 1;
	}
}
$teachers_levels_grid->RecCnt = $teachers_levels_grid->StartRec - 1;
if ($teachers_levels_grid->Recordset && !$teachers_levels_grid->Recordset->EOF) {
	$teachers_levels_grid->Recordset->MoveFirst();
	$bSelectLimit = $teachers_levels_grid->UseSelectLimit;
	if (!$bSelectLimit && $teachers_levels_grid->StartRec > 1)
		$teachers_levels_grid->Recordset->Move($teachers_levels_grid->StartRec - 1);
} elseif (!$teachers_levels->AllowAddDeleteRow && $teachers_levels_grid->StopRec == 0) {
	$teachers_levels_grid->StopRec = $teachers_levels->GridAddRowCount;
}

// Initialize aggregate
$teachers_levels->RowType = EW_ROWTYPE_AGGREGATEINIT;
$teachers_levels->ResetAttrs();
$teachers_levels_grid->RenderRow();
if ($teachers_levels->CurrentAction == "gridadd")
	$teachers_levels_grid->RowIndex = 0;
if ($teachers_levels->CurrentAction == "gridedit")
	$teachers_levels_grid->RowIndex = 0;
while ($teachers_levels_grid->RecCnt < $teachers_levels_grid->StopRec) {
	$teachers_levels_grid->RecCnt++;
	if (intval($teachers_levels_grid->RecCnt) >= intval($teachers_levels_grid->StartRec)) {
		$teachers_levels_grid->RowCnt++;
		if ($teachers_levels->CurrentAction == "gridadd" || $teachers_levels->CurrentAction == "gridedit" || $teachers_levels->CurrentAction == "F") {
			$teachers_levels_grid->RowIndex++;
			$objForm->Index = $teachers_levels_grid->RowIndex;
			if ($objForm->HasValue($teachers_levels_grid->FormActionName))
				$teachers_levels_grid->RowAction = strval($objForm->GetValue($teachers_levels_grid->FormActionName));
			elseif ($teachers_levels->CurrentAction == "gridadd")
				$teachers_levels_grid->RowAction = "insert";
			else
				$teachers_levels_grid->RowAction = "";
		}

		// Set up key count
		$teachers_levels_grid->KeyCount = $teachers_levels_grid->RowIndex;

		// Init row class and style
		$teachers_levels->ResetAttrs();
		$teachers_levels->CssClass = "";
		if ($teachers_levels->CurrentAction == "gridadd") {
			if ($teachers_levels->CurrentMode == "copy") {
				$teachers_levels_grid->LoadRowValues($teachers_levels_grid->Recordset); // Load row values
				$teachers_levels_grid->SetRecordKey($teachers_levels_grid->RowOldKey, $teachers_levels_grid->Recordset); // Set old record key
			} else {
				$teachers_levels_grid->LoadRowValues(); // Load default values
				$teachers_levels_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$teachers_levels_grid->LoadRowValues($teachers_levels_grid->Recordset); // Load row values
		}
		$teachers_levels->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($teachers_levels->CurrentAction == "gridadd") // Grid add
			$teachers_levels->RowType = EW_ROWTYPE_ADD; // Render add
		if ($teachers_levels->CurrentAction == "gridadd" && $teachers_levels->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$teachers_levels_grid->RestoreCurrentRowFormValues($teachers_levels_grid->RowIndex); // Restore form values
		if ($teachers_levels->CurrentAction == "gridedit") { // Grid edit
			if ($teachers_levels->EventCancelled) {
				$teachers_levels_grid->RestoreCurrentRowFormValues($teachers_levels_grid->RowIndex); // Restore form values
			}
			if ($teachers_levels_grid->RowAction == "insert")
				$teachers_levels->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$teachers_levels->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($teachers_levels->CurrentAction == "gridedit" && ($teachers_levels->RowType == EW_ROWTYPE_EDIT || $teachers_levels->RowType == EW_ROWTYPE_ADD) && $teachers_levels->EventCancelled) // Update failed
			$teachers_levels_grid->RestoreCurrentRowFormValues($teachers_levels_grid->RowIndex); // Restore form values
		if ($teachers_levels->RowType == EW_ROWTYPE_EDIT) // Edit row
			$teachers_levels_grid->EditRowCnt++;
		if ($teachers_levels->CurrentAction == "F") // Confirm row
			$teachers_levels_grid->RestoreCurrentRowFormValues($teachers_levels_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$teachers_levels->RowAttrs = array_merge($teachers_levels->RowAttrs, array('data-rowindex'=>$teachers_levels_grid->RowCnt, 'id'=>'r' . $teachers_levels_grid->RowCnt . '_teachers_levels', 'data-rowtype'=>$teachers_levels->RowType));

		// Render row
		$teachers_levels_grid->RenderRow();

		// Render list options
		$teachers_levels_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($teachers_levels_grid->RowAction <> "delete" && $teachers_levels_grid->RowAction <> "insertdelete" && !($teachers_levels_grid->RowAction == "insert" && $teachers_levels->CurrentAction == "F" && $teachers_levels_grid->EmptyRow())) {
?>
	<tr<?php echo $teachers_levels->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_levels_grid->ListOptions->Render("body", "left", $teachers_levels_grid->RowCnt);
?>
	<?php if ($teachers_levels->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id"<?php echo $teachers_levels->teacher_id->CellAttributes() ?>>
<?php if ($teachers_levels->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($teachers_levels->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_levels_grid->RowCnt ?>_teachers_levels_teacher_id" class="form-group teachers_levels_teacher_id">
<span<?php echo $teachers_levels->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_levels->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_levels_grid->RowCnt ?>_teachers_levels_teacher_id" class="form-group teachers_levels_teacher_id">
<input type="text" data-table="teachers_levels" data-field="x_teacher_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_levels->teacher_id->EditValue ?>"<?php echo $teachers_levels->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="teachers_levels" data-field="x_teacher_id" name="o<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_levels->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($teachers_levels->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_levels_grid->RowCnt ?>_teachers_levels_teacher_id" class="form-group teachers_levels_teacher_id">
<span<?php echo $teachers_levels->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_levels->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_levels_grid->RowCnt ?>_teachers_levels_teacher_id" class="form-group teachers_levels_teacher_id">
<input type="text" data-table="teachers_levels" data-field="x_teacher_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_levels->teacher_id->EditValue ?>"<?php echo $teachers_levels->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($teachers_levels->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_levels_grid->RowCnt ?>_teachers_levels_teacher_id" class="teachers_levels_teacher_id">
<span<?php echo $teachers_levels->teacher_id->ViewAttributes() ?>>
<?php echo $teachers_levels->teacher_id->ListViewValue() ?></span>
</span>
<?php if ($teachers_levels->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_levels" data-field="x_teacher_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_levels" data-field="x_teacher_id" name="o<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_levels" data-field="x_teacher_id" name="fteachers_levelsgrid$x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" id="fteachers_levelsgrid$x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_levels" data-field="x_teacher_id" name="fteachers_levelsgrid$o<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" id="fteachers_levelsgrid$o<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_levels->level_id->Visible) { // level_id ?>
		<td data-name="level_id"<?php echo $teachers_levels->level_id->CellAttributes() ?>>
<?php if ($teachers_levels->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_levels_grid->RowCnt ?>_teachers_levels_level_id" class="form-group teachers_levels_level_id">
<input type="text" data-table="teachers_levels" data-field="x_level_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_level_id" id="x<?php echo $teachers_levels_grid->RowIndex ?>_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_levels->level_id->getPlaceHolder()) ?>" value="<?php echo $teachers_levels->level_id->EditValue ?>"<?php echo $teachers_levels->level_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_levels" data-field="x_level_id" name="o<?php echo $teachers_levels_grid->RowIndex ?>_level_id" id="o<?php echo $teachers_levels_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($teachers_levels->level_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_levels->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_levels_grid->RowCnt ?>_teachers_levels_level_id" class="form-group teachers_levels_level_id">
<input type="text" data-table="teachers_levels" data-field="x_level_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_level_id" id="x<?php echo $teachers_levels_grid->RowIndex ?>_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_levels->level_id->getPlaceHolder()) ?>" value="<?php echo $teachers_levels->level_id->EditValue ?>"<?php echo $teachers_levels->level_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_levels->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_levels_grid->RowCnt ?>_teachers_levels_level_id" class="teachers_levels_level_id">
<span<?php echo $teachers_levels->level_id->ViewAttributes() ?>>
<?php echo $teachers_levels->level_id->ListViewValue() ?></span>
</span>
<?php if ($teachers_levels->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_levels" data-field="x_level_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_level_id" id="x<?php echo $teachers_levels_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($teachers_levels->level_id->FormValue) ?>">
<input type="hidden" data-table="teachers_levels" data-field="x_level_id" name="o<?php echo $teachers_levels_grid->RowIndex ?>_level_id" id="o<?php echo $teachers_levels_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($teachers_levels->level_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_levels" data-field="x_level_id" name="fteachers_levelsgrid$x<?php echo $teachers_levels_grid->RowIndex ?>_level_id" id="fteachers_levelsgrid$x<?php echo $teachers_levels_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($teachers_levels->level_id->FormValue) ?>">
<input type="hidden" data-table="teachers_levels" data-field="x_level_id" name="fteachers_levelsgrid$o<?php echo $teachers_levels_grid->RowIndex ?>_level_id" id="fteachers_levelsgrid$o<?php echo $teachers_levels_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($teachers_levels->level_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_levels_grid->ListOptions->Render("body", "right", $teachers_levels_grid->RowCnt);
?>
	</tr>
<?php if ($teachers_levels->RowType == EW_ROWTYPE_ADD || $teachers_levels->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fteachers_levelsgrid.UpdateOpts(<?php echo $teachers_levels_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($teachers_levels->CurrentAction <> "gridadd" || $teachers_levels->CurrentMode == "copy")
		if (!$teachers_levels_grid->Recordset->EOF) $teachers_levels_grid->Recordset->MoveNext();
}
?>
<?php
	if ($teachers_levels->CurrentMode == "add" || $teachers_levels->CurrentMode == "copy" || $teachers_levels->CurrentMode == "edit") {
		$teachers_levels_grid->RowIndex = '$rowindex$';
		$teachers_levels_grid->LoadRowValues();

		// Set row properties
		$teachers_levels->ResetAttrs();
		$teachers_levels->RowAttrs = array_merge($teachers_levels->RowAttrs, array('data-rowindex'=>$teachers_levels_grid->RowIndex, 'id'=>'r0_teachers_levels', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($teachers_levels->RowAttrs["class"], "ewTemplate");
		$teachers_levels->RowType = EW_ROWTYPE_ADD;

		// Render row
		$teachers_levels_grid->RenderRow();

		// Render list options
		$teachers_levels_grid->RenderListOptions();
		$teachers_levels_grid->StartRowCnt = 0;
?>
	<tr<?php echo $teachers_levels->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_levels_grid->ListOptions->Render("body", "left", $teachers_levels_grid->RowIndex);
?>
	<?php if ($teachers_levels->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id">
<?php if ($teachers_levels->CurrentAction <> "F") { ?>
<?php if ($teachers_levels->teacher_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_teachers_levels_teacher_id" class="form-group teachers_levels_teacher_id">
<span<?php echo $teachers_levels->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_levels->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_teachers_levels_teacher_id" class="form-group teachers_levels_teacher_id">
<input type="text" data-table="teachers_levels" data-field="x_teacher_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_levels->teacher_id->EditValue ?>"<?php echo $teachers_levels->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_levels_teacher_id" class="form-group teachers_levels_teacher_id">
<span<?php echo $teachers_levels->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_levels->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_levels" data-field="x_teacher_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_levels" data-field="x_teacher_id" name="o<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_levels_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_levels->teacher_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_levels->level_id->Visible) { // level_id ?>
		<td data-name="level_id">
<?php if ($teachers_levels->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_levels_level_id" class="form-group teachers_levels_level_id">
<input type="text" data-table="teachers_levels" data-field="x_level_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_level_id" id="x<?php echo $teachers_levels_grid->RowIndex ?>_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_levels->level_id->getPlaceHolder()) ?>" value="<?php echo $teachers_levels->level_id->EditValue ?>"<?php echo $teachers_levels->level_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_levels_level_id" class="form-group teachers_levels_level_id">
<span<?php echo $teachers_levels->level_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_levels->level_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_levels" data-field="x_level_id" name="x<?php echo $teachers_levels_grid->RowIndex ?>_level_id" id="x<?php echo $teachers_levels_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($teachers_levels->level_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_levels" data-field="x_level_id" name="o<?php echo $teachers_levels_grid->RowIndex ?>_level_id" id="o<?php echo $teachers_levels_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($teachers_levels->level_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_levels_grid->ListOptions->Render("body", "right", $teachers_levels_grid->RowIndex);
?>
<script type="text/javascript">
fteachers_levelsgrid.UpdateOpts(<?php echo $teachers_levels_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($teachers_levels->CurrentMode == "add" || $teachers_levels->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $teachers_levels_grid->FormKeyCountName ?>" id="<?php echo $teachers_levels_grid->FormKeyCountName ?>" value="<?php echo $teachers_levels_grid->KeyCount ?>">
<?php echo $teachers_levels_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_levels->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $teachers_levels_grid->FormKeyCountName ?>" id="<?php echo $teachers_levels_grid->FormKeyCountName ?>" value="<?php echo $teachers_levels_grid->KeyCount ?>">
<?php echo $teachers_levels_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_levels->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fteachers_levelsgrid">
</div>
<?php

// Close recordset
if ($teachers_levels_grid->Recordset)
	$teachers_levels_grid->Recordset->Close();
?>
<?php if ($teachers_levels_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($teachers_levels_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($teachers_levels_grid->TotalRecs == 0 && $teachers_levels->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_levels_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($teachers_levels->Export == "") { ?>
<script type="text/javascript">
fteachers_levelsgrid.Init();
</script>
<?php } ?>
<?php
$teachers_levels_grid->Page_Terminate();
?>
