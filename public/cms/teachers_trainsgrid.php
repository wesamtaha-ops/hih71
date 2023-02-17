<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($teachers_trains_grid)) $teachers_trains_grid = new cteachers_trains_grid();

// Page init
$teachers_trains_grid->Page_Init();

// Page main
$teachers_trains_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_trains_grid->Page_Render();
?>
<?php if ($teachers_trains->Export == "") { ?>
<script type="text/javascript">

// Form object
var fteachers_trainsgrid = new ew_Form("fteachers_trainsgrid", "grid");
fteachers_trainsgrid.FormKeyCountName = '<?php echo $teachers_trains_grid->FormKeyCountName ?>';

// Validate form
fteachers_trainsgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_trains->teacher_id->FldCaption(), $teachers_trains->teacher_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_trains->teacher_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_instituation");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_trains->instituation->FldCaption(), $teachers_trains->instituation->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_subject");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_trains->subject->FldCaption(), $teachers_trains->subject->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_from_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_trains->from_date->FldCaption(), $teachers_trains->from_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_from_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_trains->from_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_to_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_trains->to_date->FldCaption(), $teachers_trains->to_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_to_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_trains->to_date->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fteachers_trainsgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "teacher_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "instituation", false)) return false;
	if (ew_ValueChanged(fobj, infix, "subject", false)) return false;
	if (ew_ValueChanged(fobj, infix, "from_date", false)) return false;
	if (ew_ValueChanged(fobj, infix, "to_date", false)) return false;
	return true;
}

// Form_CustomValidate event
fteachers_trainsgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachers_trainsgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($teachers_trains->CurrentAction == "gridadd") {
	if ($teachers_trains->CurrentMode == "copy") {
		$bSelectLimit = $teachers_trains_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$teachers_trains_grid->TotalRecs = $teachers_trains->ListRecordCount();
			$teachers_trains_grid->Recordset = $teachers_trains_grid->LoadRecordset($teachers_trains_grid->StartRec-1, $teachers_trains_grid->DisplayRecs);
		} else {
			if ($teachers_trains_grid->Recordset = $teachers_trains_grid->LoadRecordset())
				$teachers_trains_grid->TotalRecs = $teachers_trains_grid->Recordset->RecordCount();
		}
		$teachers_trains_grid->StartRec = 1;
		$teachers_trains_grid->DisplayRecs = $teachers_trains_grid->TotalRecs;
	} else {
		$teachers_trains->CurrentFilter = "0=1";
		$teachers_trains_grid->StartRec = 1;
		$teachers_trains_grid->DisplayRecs = $teachers_trains->GridAddRowCount;
	}
	$teachers_trains_grid->TotalRecs = $teachers_trains_grid->DisplayRecs;
	$teachers_trains_grid->StopRec = $teachers_trains_grid->DisplayRecs;
} else {
	$bSelectLimit = $teachers_trains_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($teachers_trains_grid->TotalRecs <= 0)
			$teachers_trains_grid->TotalRecs = $teachers_trains->ListRecordCount();
	} else {
		if (!$teachers_trains_grid->Recordset && ($teachers_trains_grid->Recordset = $teachers_trains_grid->LoadRecordset()))
			$teachers_trains_grid->TotalRecs = $teachers_trains_grid->Recordset->RecordCount();
	}
	$teachers_trains_grid->StartRec = 1;
	$teachers_trains_grid->DisplayRecs = $teachers_trains_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$teachers_trains_grid->Recordset = $teachers_trains_grid->LoadRecordset($teachers_trains_grid->StartRec-1, $teachers_trains_grid->DisplayRecs);

	// Set no record found message
	if ($teachers_trains->CurrentAction == "" && $teachers_trains_grid->TotalRecs == 0) {
		if ($teachers_trains_grid->SearchWhere == "0=101")
			$teachers_trains_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$teachers_trains_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$teachers_trains_grid->RenderOtherOptions();
?>
<?php $teachers_trains_grid->ShowPageHeader(); ?>
<?php
$teachers_trains_grid->ShowMessage();
?>
<?php if ($teachers_trains_grid->TotalRecs > 0 || $teachers_trains->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($teachers_trains_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> teachers_trains">
<div id="fteachers_trainsgrid" class="ewForm ewListForm form-inline">
<?php if ($teachers_trains_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($teachers_trains_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_teachers_trains" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_teachers_trainsgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$teachers_trains_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$teachers_trains_grid->RenderListOptions();

// Render list options (header, left)
$teachers_trains_grid->ListOptions->Render("header", "left");
?>
<?php if ($teachers_trains->id->Visible) { // id ?>
	<?php if ($teachers_trains->SortUrl($teachers_trains->id) == "") { ?>
		<th data-name="id" class="<?php echo $teachers_trains->id->HeaderCellClass() ?>"><div id="elh_teachers_trains_id" class="teachers_trains_id"><div class="ewTableHeaderCaption"><?php echo $teachers_trains->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $teachers_trains->id->HeaderCellClass() ?>"><div><div id="elh_teachers_trains_id" class="teachers_trains_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_trains->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_trains->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_trains->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_trains->teacher_id->Visible) { // teacher_id ?>
	<?php if ($teachers_trains->SortUrl($teachers_trains->teacher_id) == "") { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_trains->teacher_id->HeaderCellClass() ?>"><div id="elh_teachers_trains_teacher_id" class="teachers_trains_teacher_id"><div class="ewTableHeaderCaption"><?php echo $teachers_trains->teacher_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_trains->teacher_id->HeaderCellClass() ?>"><div><div id="elh_teachers_trains_teacher_id" class="teachers_trains_teacher_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_trains->teacher_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_trains->teacher_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_trains->teacher_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_trains->instituation->Visible) { // instituation ?>
	<?php if ($teachers_trains->SortUrl($teachers_trains->instituation) == "") { ?>
		<th data-name="instituation" class="<?php echo $teachers_trains->instituation->HeaderCellClass() ?>"><div id="elh_teachers_trains_instituation" class="teachers_trains_instituation"><div class="ewTableHeaderCaption"><?php echo $teachers_trains->instituation->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="instituation" class="<?php echo $teachers_trains->instituation->HeaderCellClass() ?>"><div><div id="elh_teachers_trains_instituation" class="teachers_trains_instituation">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_trains->instituation->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_trains->instituation->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_trains->instituation->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_trains->subject->Visible) { // subject ?>
	<?php if ($teachers_trains->SortUrl($teachers_trains->subject) == "") { ?>
		<th data-name="subject" class="<?php echo $teachers_trains->subject->HeaderCellClass() ?>"><div id="elh_teachers_trains_subject" class="teachers_trains_subject"><div class="ewTableHeaderCaption"><?php echo $teachers_trains->subject->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="subject" class="<?php echo $teachers_trains->subject->HeaderCellClass() ?>"><div><div id="elh_teachers_trains_subject" class="teachers_trains_subject">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_trains->subject->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_trains->subject->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_trains->subject->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_trains->from_date->Visible) { // from_date ?>
	<?php if ($teachers_trains->SortUrl($teachers_trains->from_date) == "") { ?>
		<th data-name="from_date" class="<?php echo $teachers_trains->from_date->HeaderCellClass() ?>"><div id="elh_teachers_trains_from_date" class="teachers_trains_from_date"><div class="ewTableHeaderCaption"><?php echo $teachers_trains->from_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="from_date" class="<?php echo $teachers_trains->from_date->HeaderCellClass() ?>"><div><div id="elh_teachers_trains_from_date" class="teachers_trains_from_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_trains->from_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_trains->from_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_trains->from_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_trains->to_date->Visible) { // to_date ?>
	<?php if ($teachers_trains->SortUrl($teachers_trains->to_date) == "") { ?>
		<th data-name="to_date" class="<?php echo $teachers_trains->to_date->HeaderCellClass() ?>"><div id="elh_teachers_trains_to_date" class="teachers_trains_to_date"><div class="ewTableHeaderCaption"><?php echo $teachers_trains->to_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="to_date" class="<?php echo $teachers_trains->to_date->HeaderCellClass() ?>"><div><div id="elh_teachers_trains_to_date" class="teachers_trains_to_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_trains->to_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_trains->to_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_trains->to_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$teachers_trains_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$teachers_trains_grid->StartRec = 1;
$teachers_trains_grid->StopRec = $teachers_trains_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($teachers_trains_grid->FormKeyCountName) && ($teachers_trains->CurrentAction == "gridadd" || $teachers_trains->CurrentAction == "gridedit" || $teachers_trains->CurrentAction == "F")) {
		$teachers_trains_grid->KeyCount = $objForm->GetValue($teachers_trains_grid->FormKeyCountName);
		$teachers_trains_grid->StopRec = $teachers_trains_grid->StartRec + $teachers_trains_grid->KeyCount - 1;
	}
}
$teachers_trains_grid->RecCnt = $teachers_trains_grid->StartRec - 1;
if ($teachers_trains_grid->Recordset && !$teachers_trains_grid->Recordset->EOF) {
	$teachers_trains_grid->Recordset->MoveFirst();
	$bSelectLimit = $teachers_trains_grid->UseSelectLimit;
	if (!$bSelectLimit && $teachers_trains_grid->StartRec > 1)
		$teachers_trains_grid->Recordset->Move($teachers_trains_grid->StartRec - 1);
} elseif (!$teachers_trains->AllowAddDeleteRow && $teachers_trains_grid->StopRec == 0) {
	$teachers_trains_grid->StopRec = $teachers_trains->GridAddRowCount;
}

// Initialize aggregate
$teachers_trains->RowType = EW_ROWTYPE_AGGREGATEINIT;
$teachers_trains->ResetAttrs();
$teachers_trains_grid->RenderRow();
if ($teachers_trains->CurrentAction == "gridadd")
	$teachers_trains_grid->RowIndex = 0;
if ($teachers_trains->CurrentAction == "gridedit")
	$teachers_trains_grid->RowIndex = 0;
while ($teachers_trains_grid->RecCnt < $teachers_trains_grid->StopRec) {
	$teachers_trains_grid->RecCnt++;
	if (intval($teachers_trains_grid->RecCnt) >= intval($teachers_trains_grid->StartRec)) {
		$teachers_trains_grid->RowCnt++;
		if ($teachers_trains->CurrentAction == "gridadd" || $teachers_trains->CurrentAction == "gridedit" || $teachers_trains->CurrentAction == "F") {
			$teachers_trains_grid->RowIndex++;
			$objForm->Index = $teachers_trains_grid->RowIndex;
			if ($objForm->HasValue($teachers_trains_grid->FormActionName))
				$teachers_trains_grid->RowAction = strval($objForm->GetValue($teachers_trains_grid->FormActionName));
			elseif ($teachers_trains->CurrentAction == "gridadd")
				$teachers_trains_grid->RowAction = "insert";
			else
				$teachers_trains_grid->RowAction = "";
		}

		// Set up key count
		$teachers_trains_grid->KeyCount = $teachers_trains_grid->RowIndex;

		// Init row class and style
		$teachers_trains->ResetAttrs();
		$teachers_trains->CssClass = "";
		if ($teachers_trains->CurrentAction == "gridadd") {
			if ($teachers_trains->CurrentMode == "copy") {
				$teachers_trains_grid->LoadRowValues($teachers_trains_grid->Recordset); // Load row values
				$teachers_trains_grid->SetRecordKey($teachers_trains_grid->RowOldKey, $teachers_trains_grid->Recordset); // Set old record key
			} else {
				$teachers_trains_grid->LoadRowValues(); // Load default values
				$teachers_trains_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$teachers_trains_grid->LoadRowValues($teachers_trains_grid->Recordset); // Load row values
		}
		$teachers_trains->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($teachers_trains->CurrentAction == "gridadd") // Grid add
			$teachers_trains->RowType = EW_ROWTYPE_ADD; // Render add
		if ($teachers_trains->CurrentAction == "gridadd" && $teachers_trains->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$teachers_trains_grid->RestoreCurrentRowFormValues($teachers_trains_grid->RowIndex); // Restore form values
		if ($teachers_trains->CurrentAction == "gridedit") { // Grid edit
			if ($teachers_trains->EventCancelled) {
				$teachers_trains_grid->RestoreCurrentRowFormValues($teachers_trains_grid->RowIndex); // Restore form values
			}
			if ($teachers_trains_grid->RowAction == "insert")
				$teachers_trains->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$teachers_trains->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($teachers_trains->CurrentAction == "gridedit" && ($teachers_trains->RowType == EW_ROWTYPE_EDIT || $teachers_trains->RowType == EW_ROWTYPE_ADD) && $teachers_trains->EventCancelled) // Update failed
			$teachers_trains_grid->RestoreCurrentRowFormValues($teachers_trains_grid->RowIndex); // Restore form values
		if ($teachers_trains->RowType == EW_ROWTYPE_EDIT) // Edit row
			$teachers_trains_grid->EditRowCnt++;
		if ($teachers_trains->CurrentAction == "F") // Confirm row
			$teachers_trains_grid->RestoreCurrentRowFormValues($teachers_trains_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$teachers_trains->RowAttrs = array_merge($teachers_trains->RowAttrs, array('data-rowindex'=>$teachers_trains_grid->RowCnt, 'id'=>'r' . $teachers_trains_grid->RowCnt . '_teachers_trains', 'data-rowtype'=>$teachers_trains->RowType));

		// Render row
		$teachers_trains_grid->RenderRow();

		// Render list options
		$teachers_trains_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($teachers_trains_grid->RowAction <> "delete" && $teachers_trains_grid->RowAction <> "insertdelete" && !($teachers_trains_grid->RowAction == "insert" && $teachers_trains->CurrentAction == "F" && $teachers_trains_grid->EmptyRow())) {
?>
	<tr<?php echo $teachers_trains->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_trains_grid->ListOptions->Render("body", "left", $teachers_trains_grid->RowCnt);
?>
	<?php if ($teachers_trains->id->Visible) { // id ?>
		<td data-name="id"<?php echo $teachers_trains->id->CellAttributes() ?>>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="teachers_trains" data-field="x_id" name="o<?php echo $teachers_trains_grid->RowIndex ?>_id" id="o<?php echo $teachers_trains_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_trains->id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_id" class="form-group teachers_trains_id">
<span<?php echo $teachers_trains->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_trains->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_trains" data-field="x_id" name="x<?php echo $teachers_trains_grid->RowIndex ?>_id" id="x<?php echo $teachers_trains_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_trains->id->CurrentValue) ?>">
<?php } ?>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_id" class="teachers_trains_id">
<span<?php echo $teachers_trains->id->ViewAttributes() ?>>
<?php echo $teachers_trains->id->ListViewValue() ?></span>
</span>
<?php if ($teachers_trains->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_trains" data-field="x_id" name="x<?php echo $teachers_trains_grid->RowIndex ?>_id" id="x<?php echo $teachers_trains_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_trains->id->FormValue) ?>">
<input type="hidden" data-table="teachers_trains" data-field="x_id" name="o<?php echo $teachers_trains_grid->RowIndex ?>_id" id="o<?php echo $teachers_trains_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_trains->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_trains" data-field="x_id" name="fteachers_trainsgrid$x<?php echo $teachers_trains_grid->RowIndex ?>_id" id="fteachers_trainsgrid$x<?php echo $teachers_trains_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_trains->id->FormValue) ?>">
<input type="hidden" data-table="teachers_trains" data-field="x_id" name="fteachers_trainsgrid$o<?php echo $teachers_trains_grid->RowIndex ?>_id" id="fteachers_trainsgrid$o<?php echo $teachers_trains_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_trains->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_trains->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id"<?php echo $teachers_trains->teacher_id->CellAttributes() ?>>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($teachers_trains->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_teacher_id" class="form-group teachers_trains_teacher_id">
<span<?php echo $teachers_trains->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_trains->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_teacher_id" class="form-group teachers_trains_teacher_id">
<input type="text" data-table="teachers_trains" data-field="x_teacher_id" name="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_trains->teacher_id->EditValue ?>"<?php echo $teachers_trains->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="teachers_trains" data-field="x_teacher_id" name="o<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($teachers_trains->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_teacher_id" class="form-group teachers_trains_teacher_id">
<span<?php echo $teachers_trains->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_trains->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_teacher_id" class="form-group teachers_trains_teacher_id">
<input type="text" data-table="teachers_trains" data-field="x_teacher_id" name="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_trains->teacher_id->EditValue ?>"<?php echo $teachers_trains->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_teacher_id" class="teachers_trains_teacher_id">
<span<?php echo $teachers_trains->teacher_id->ViewAttributes() ?>>
<?php echo $teachers_trains->teacher_id->ListViewValue() ?></span>
</span>
<?php if ($teachers_trains->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_trains" data-field="x_teacher_id" name="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_trains" data-field="x_teacher_id" name="o<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_trains" data-field="x_teacher_id" name="fteachers_trainsgrid$x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" id="fteachers_trainsgrid$x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_trains" data-field="x_teacher_id" name="fteachers_trainsgrid$o<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" id="fteachers_trainsgrid$o<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_trains->instituation->Visible) { // instituation ?>
		<td data-name="instituation"<?php echo $teachers_trains->instituation->CellAttributes() ?>>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_instituation" class="form-group teachers_trains_instituation">
<textarea data-table="teachers_trains" data-field="x_instituation" name="x<?php echo $teachers_trains_grid->RowIndex ?>_instituation" id="x<?php echo $teachers_trains_grid->RowIndex ?>_instituation" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_trains->instituation->getPlaceHolder()) ?>"<?php echo $teachers_trains->instituation->EditAttributes() ?>><?php echo $teachers_trains->instituation->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_trains" data-field="x_instituation" name="o<?php echo $teachers_trains_grid->RowIndex ?>_instituation" id="o<?php echo $teachers_trains_grid->RowIndex ?>_instituation" value="<?php echo ew_HtmlEncode($teachers_trains->instituation->OldValue) ?>">
<?php } ?>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_instituation" class="form-group teachers_trains_instituation">
<textarea data-table="teachers_trains" data-field="x_instituation" name="x<?php echo $teachers_trains_grid->RowIndex ?>_instituation" id="x<?php echo $teachers_trains_grid->RowIndex ?>_instituation" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_trains->instituation->getPlaceHolder()) ?>"<?php echo $teachers_trains->instituation->EditAttributes() ?>><?php echo $teachers_trains->instituation->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_instituation" class="teachers_trains_instituation">
<span<?php echo $teachers_trains->instituation->ViewAttributes() ?>>
<?php echo $teachers_trains->instituation->ListViewValue() ?></span>
</span>
<?php if ($teachers_trains->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_trains" data-field="x_instituation" name="x<?php echo $teachers_trains_grid->RowIndex ?>_instituation" id="x<?php echo $teachers_trains_grid->RowIndex ?>_instituation" value="<?php echo ew_HtmlEncode($teachers_trains->instituation->FormValue) ?>">
<input type="hidden" data-table="teachers_trains" data-field="x_instituation" name="o<?php echo $teachers_trains_grid->RowIndex ?>_instituation" id="o<?php echo $teachers_trains_grid->RowIndex ?>_instituation" value="<?php echo ew_HtmlEncode($teachers_trains->instituation->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_trains" data-field="x_instituation" name="fteachers_trainsgrid$x<?php echo $teachers_trains_grid->RowIndex ?>_instituation" id="fteachers_trainsgrid$x<?php echo $teachers_trains_grid->RowIndex ?>_instituation" value="<?php echo ew_HtmlEncode($teachers_trains->instituation->FormValue) ?>">
<input type="hidden" data-table="teachers_trains" data-field="x_instituation" name="fteachers_trainsgrid$o<?php echo $teachers_trains_grid->RowIndex ?>_instituation" id="fteachers_trainsgrid$o<?php echo $teachers_trains_grid->RowIndex ?>_instituation" value="<?php echo ew_HtmlEncode($teachers_trains->instituation->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_trains->subject->Visible) { // subject ?>
		<td data-name="subject"<?php echo $teachers_trains->subject->CellAttributes() ?>>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_subject" class="form-group teachers_trains_subject">
<textarea data-table="teachers_trains" data-field="x_subject" name="x<?php echo $teachers_trains_grid->RowIndex ?>_subject" id="x<?php echo $teachers_trains_grid->RowIndex ?>_subject" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_trains->subject->getPlaceHolder()) ?>"<?php echo $teachers_trains->subject->EditAttributes() ?>><?php echo $teachers_trains->subject->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_trains" data-field="x_subject" name="o<?php echo $teachers_trains_grid->RowIndex ?>_subject" id="o<?php echo $teachers_trains_grid->RowIndex ?>_subject" value="<?php echo ew_HtmlEncode($teachers_trains->subject->OldValue) ?>">
<?php } ?>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_subject" class="form-group teachers_trains_subject">
<textarea data-table="teachers_trains" data-field="x_subject" name="x<?php echo $teachers_trains_grid->RowIndex ?>_subject" id="x<?php echo $teachers_trains_grid->RowIndex ?>_subject" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_trains->subject->getPlaceHolder()) ?>"<?php echo $teachers_trains->subject->EditAttributes() ?>><?php echo $teachers_trains->subject->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_subject" class="teachers_trains_subject">
<span<?php echo $teachers_trains->subject->ViewAttributes() ?>>
<?php echo $teachers_trains->subject->ListViewValue() ?></span>
</span>
<?php if ($teachers_trains->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_trains" data-field="x_subject" name="x<?php echo $teachers_trains_grid->RowIndex ?>_subject" id="x<?php echo $teachers_trains_grid->RowIndex ?>_subject" value="<?php echo ew_HtmlEncode($teachers_trains->subject->FormValue) ?>">
<input type="hidden" data-table="teachers_trains" data-field="x_subject" name="o<?php echo $teachers_trains_grid->RowIndex ?>_subject" id="o<?php echo $teachers_trains_grid->RowIndex ?>_subject" value="<?php echo ew_HtmlEncode($teachers_trains->subject->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_trains" data-field="x_subject" name="fteachers_trainsgrid$x<?php echo $teachers_trains_grid->RowIndex ?>_subject" id="fteachers_trainsgrid$x<?php echo $teachers_trains_grid->RowIndex ?>_subject" value="<?php echo ew_HtmlEncode($teachers_trains->subject->FormValue) ?>">
<input type="hidden" data-table="teachers_trains" data-field="x_subject" name="fteachers_trainsgrid$o<?php echo $teachers_trains_grid->RowIndex ?>_subject" id="fteachers_trainsgrid$o<?php echo $teachers_trains_grid->RowIndex ?>_subject" value="<?php echo ew_HtmlEncode($teachers_trains->subject->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_trains->from_date->Visible) { // from_date ?>
		<td data-name="from_date"<?php echo $teachers_trains->from_date->CellAttributes() ?>>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_from_date" class="form-group teachers_trains_from_date">
<input type="text" data-table="teachers_trains" data-field="x_from_date" name="x<?php echo $teachers_trains_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_trains_grid->RowIndex ?>_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_trains->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_trains->from_date->EditValue ?>"<?php echo $teachers_trains->from_date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_trains" data-field="x_from_date" name="o<?php echo $teachers_trains_grid->RowIndex ?>_from_date" id="o<?php echo $teachers_trains_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_trains->from_date->OldValue) ?>">
<?php } ?>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_from_date" class="form-group teachers_trains_from_date">
<input type="text" data-table="teachers_trains" data-field="x_from_date" name="x<?php echo $teachers_trains_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_trains_grid->RowIndex ?>_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_trains->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_trains->from_date->EditValue ?>"<?php echo $teachers_trains->from_date->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_from_date" class="teachers_trains_from_date">
<span<?php echo $teachers_trains->from_date->ViewAttributes() ?>>
<?php echo $teachers_trains->from_date->ListViewValue() ?></span>
</span>
<?php if ($teachers_trains->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_trains" data-field="x_from_date" name="x<?php echo $teachers_trains_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_trains_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_trains->from_date->FormValue) ?>">
<input type="hidden" data-table="teachers_trains" data-field="x_from_date" name="o<?php echo $teachers_trains_grid->RowIndex ?>_from_date" id="o<?php echo $teachers_trains_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_trains->from_date->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_trains" data-field="x_from_date" name="fteachers_trainsgrid$x<?php echo $teachers_trains_grid->RowIndex ?>_from_date" id="fteachers_trainsgrid$x<?php echo $teachers_trains_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_trains->from_date->FormValue) ?>">
<input type="hidden" data-table="teachers_trains" data-field="x_from_date" name="fteachers_trainsgrid$o<?php echo $teachers_trains_grid->RowIndex ?>_from_date" id="fteachers_trainsgrid$o<?php echo $teachers_trains_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_trains->from_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_trains->to_date->Visible) { // to_date ?>
		<td data-name="to_date"<?php echo $teachers_trains->to_date->CellAttributes() ?>>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_to_date" class="form-group teachers_trains_to_date">
<input type="text" data-table="teachers_trains" data-field="x_to_date" name="x<?php echo $teachers_trains_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_trains_grid->RowIndex ?>_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_trains->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_trains->to_date->EditValue ?>"<?php echo $teachers_trains->to_date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_trains" data-field="x_to_date" name="o<?php echo $teachers_trains_grid->RowIndex ?>_to_date" id="o<?php echo $teachers_trains_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_trains->to_date->OldValue) ?>">
<?php } ?>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_to_date" class="form-group teachers_trains_to_date">
<input type="text" data-table="teachers_trains" data-field="x_to_date" name="x<?php echo $teachers_trains_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_trains_grid->RowIndex ?>_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_trains->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_trains->to_date->EditValue ?>"<?php echo $teachers_trains->to_date->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_trains_grid->RowCnt ?>_teachers_trains_to_date" class="teachers_trains_to_date">
<span<?php echo $teachers_trains->to_date->ViewAttributes() ?>>
<?php echo $teachers_trains->to_date->ListViewValue() ?></span>
</span>
<?php if ($teachers_trains->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_trains" data-field="x_to_date" name="x<?php echo $teachers_trains_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_trains_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_trains->to_date->FormValue) ?>">
<input type="hidden" data-table="teachers_trains" data-field="x_to_date" name="o<?php echo $teachers_trains_grid->RowIndex ?>_to_date" id="o<?php echo $teachers_trains_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_trains->to_date->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_trains" data-field="x_to_date" name="fteachers_trainsgrid$x<?php echo $teachers_trains_grid->RowIndex ?>_to_date" id="fteachers_trainsgrid$x<?php echo $teachers_trains_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_trains->to_date->FormValue) ?>">
<input type="hidden" data-table="teachers_trains" data-field="x_to_date" name="fteachers_trainsgrid$o<?php echo $teachers_trains_grid->RowIndex ?>_to_date" id="fteachers_trainsgrid$o<?php echo $teachers_trains_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_trains->to_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_trains_grid->ListOptions->Render("body", "right", $teachers_trains_grid->RowCnt);
?>
	</tr>
<?php if ($teachers_trains->RowType == EW_ROWTYPE_ADD || $teachers_trains->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fteachers_trainsgrid.UpdateOpts(<?php echo $teachers_trains_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($teachers_trains->CurrentAction <> "gridadd" || $teachers_trains->CurrentMode == "copy")
		if (!$teachers_trains_grid->Recordset->EOF) $teachers_trains_grid->Recordset->MoveNext();
}
?>
<?php
	if ($teachers_trains->CurrentMode == "add" || $teachers_trains->CurrentMode == "copy" || $teachers_trains->CurrentMode == "edit") {
		$teachers_trains_grid->RowIndex = '$rowindex$';
		$teachers_trains_grid->LoadRowValues();

		// Set row properties
		$teachers_trains->ResetAttrs();
		$teachers_trains->RowAttrs = array_merge($teachers_trains->RowAttrs, array('data-rowindex'=>$teachers_trains_grid->RowIndex, 'id'=>'r0_teachers_trains', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($teachers_trains->RowAttrs["class"], "ewTemplate");
		$teachers_trains->RowType = EW_ROWTYPE_ADD;

		// Render row
		$teachers_trains_grid->RenderRow();

		// Render list options
		$teachers_trains_grid->RenderListOptions();
		$teachers_trains_grid->StartRowCnt = 0;
?>
	<tr<?php echo $teachers_trains->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_trains_grid->ListOptions->Render("body", "left", $teachers_trains_grid->RowIndex);
?>
	<?php if ($teachers_trains->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($teachers_trains->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_trains_id" class="form-group teachers_trains_id">
<span<?php echo $teachers_trains->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_trains->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_trains" data-field="x_id" name="x<?php echo $teachers_trains_grid->RowIndex ?>_id" id="x<?php echo $teachers_trains_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_trains->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_trains" data-field="x_id" name="o<?php echo $teachers_trains_grid->RowIndex ?>_id" id="o<?php echo $teachers_trains_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_trains->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_trains->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id">
<?php if ($teachers_trains->CurrentAction <> "F") { ?>
<?php if ($teachers_trains->teacher_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_teachers_trains_teacher_id" class="form-group teachers_trains_teacher_id">
<span<?php echo $teachers_trains->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_trains->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_teachers_trains_teacher_id" class="form-group teachers_trains_teacher_id">
<input type="text" data-table="teachers_trains" data-field="x_teacher_id" name="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_trains->teacher_id->EditValue ?>"<?php echo $teachers_trains->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_trains_teacher_id" class="form-group teachers_trains_teacher_id">
<span<?php echo $teachers_trains->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_trains->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_trains" data-field="x_teacher_id" name="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_trains" data-field="x_teacher_id" name="o<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_trains_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_trains->instituation->Visible) { // instituation ?>
		<td data-name="instituation">
<?php if ($teachers_trains->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_trains_instituation" class="form-group teachers_trains_instituation">
<textarea data-table="teachers_trains" data-field="x_instituation" name="x<?php echo $teachers_trains_grid->RowIndex ?>_instituation" id="x<?php echo $teachers_trains_grid->RowIndex ?>_instituation" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_trains->instituation->getPlaceHolder()) ?>"<?php echo $teachers_trains->instituation->EditAttributes() ?>><?php echo $teachers_trains->instituation->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_trains_instituation" class="form-group teachers_trains_instituation">
<span<?php echo $teachers_trains->instituation->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_trains->instituation->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_trains" data-field="x_instituation" name="x<?php echo $teachers_trains_grid->RowIndex ?>_instituation" id="x<?php echo $teachers_trains_grid->RowIndex ?>_instituation" value="<?php echo ew_HtmlEncode($teachers_trains->instituation->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_trains" data-field="x_instituation" name="o<?php echo $teachers_trains_grid->RowIndex ?>_instituation" id="o<?php echo $teachers_trains_grid->RowIndex ?>_instituation" value="<?php echo ew_HtmlEncode($teachers_trains->instituation->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_trains->subject->Visible) { // subject ?>
		<td data-name="subject">
<?php if ($teachers_trains->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_trains_subject" class="form-group teachers_trains_subject">
<textarea data-table="teachers_trains" data-field="x_subject" name="x<?php echo $teachers_trains_grid->RowIndex ?>_subject" id="x<?php echo $teachers_trains_grid->RowIndex ?>_subject" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_trains->subject->getPlaceHolder()) ?>"<?php echo $teachers_trains->subject->EditAttributes() ?>><?php echo $teachers_trains->subject->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_trains_subject" class="form-group teachers_trains_subject">
<span<?php echo $teachers_trains->subject->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_trains->subject->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_trains" data-field="x_subject" name="x<?php echo $teachers_trains_grid->RowIndex ?>_subject" id="x<?php echo $teachers_trains_grid->RowIndex ?>_subject" value="<?php echo ew_HtmlEncode($teachers_trains->subject->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_trains" data-field="x_subject" name="o<?php echo $teachers_trains_grid->RowIndex ?>_subject" id="o<?php echo $teachers_trains_grid->RowIndex ?>_subject" value="<?php echo ew_HtmlEncode($teachers_trains->subject->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_trains->from_date->Visible) { // from_date ?>
		<td data-name="from_date">
<?php if ($teachers_trains->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_trains_from_date" class="form-group teachers_trains_from_date">
<input type="text" data-table="teachers_trains" data-field="x_from_date" name="x<?php echo $teachers_trains_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_trains_grid->RowIndex ?>_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_trains->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_trains->from_date->EditValue ?>"<?php echo $teachers_trains->from_date->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_trains_from_date" class="form-group teachers_trains_from_date">
<span<?php echo $teachers_trains->from_date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_trains->from_date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_trains" data-field="x_from_date" name="x<?php echo $teachers_trains_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_trains_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_trains->from_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_trains" data-field="x_from_date" name="o<?php echo $teachers_trains_grid->RowIndex ?>_from_date" id="o<?php echo $teachers_trains_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_trains->from_date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_trains->to_date->Visible) { // to_date ?>
		<td data-name="to_date">
<?php if ($teachers_trains->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_trains_to_date" class="form-group teachers_trains_to_date">
<input type="text" data-table="teachers_trains" data-field="x_to_date" name="x<?php echo $teachers_trains_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_trains_grid->RowIndex ?>_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_trains->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_trains->to_date->EditValue ?>"<?php echo $teachers_trains->to_date->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_trains_to_date" class="form-group teachers_trains_to_date">
<span<?php echo $teachers_trains->to_date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_trains->to_date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_trains" data-field="x_to_date" name="x<?php echo $teachers_trains_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_trains_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_trains->to_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_trains" data-field="x_to_date" name="o<?php echo $teachers_trains_grid->RowIndex ?>_to_date" id="o<?php echo $teachers_trains_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_trains->to_date->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_trains_grid->ListOptions->Render("body", "right", $teachers_trains_grid->RowIndex);
?>
<script type="text/javascript">
fteachers_trainsgrid.UpdateOpts(<?php echo $teachers_trains_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($teachers_trains->CurrentMode == "add" || $teachers_trains->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $teachers_trains_grid->FormKeyCountName ?>" id="<?php echo $teachers_trains_grid->FormKeyCountName ?>" value="<?php echo $teachers_trains_grid->KeyCount ?>">
<?php echo $teachers_trains_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_trains->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $teachers_trains_grid->FormKeyCountName ?>" id="<?php echo $teachers_trains_grid->FormKeyCountName ?>" value="<?php echo $teachers_trains_grid->KeyCount ?>">
<?php echo $teachers_trains_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_trains->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fteachers_trainsgrid">
</div>
<?php

// Close recordset
if ($teachers_trains_grid->Recordset)
	$teachers_trains_grid->Recordset->Close();
?>
<?php if ($teachers_trains_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($teachers_trains_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($teachers_trains_grid->TotalRecs == 0 && $teachers_trains->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_trains_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($teachers_trains->Export == "") { ?>
<script type="text/javascript">
fteachers_trainsgrid.Init();
</script>
<?php } ?>
<?php
$teachers_trains_grid->Page_Terminate();
?>
