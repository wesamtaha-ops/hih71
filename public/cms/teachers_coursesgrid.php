<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($teachers_courses_grid)) $teachers_courses_grid = new cteachers_courses_grid();

// Page init
$teachers_courses_grid->Page_Init();

// Page main
$teachers_courses_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_courses_grid->Page_Render();
?>
<?php if ($teachers_courses->Export == "") { ?>
<script type="text/javascript">

// Form object
var fteachers_coursesgrid = new ew_Form("fteachers_coursesgrid", "grid");
fteachers_coursesgrid.FormKeyCountName = '<?php echo $teachers_courses_grid->FormKeyCountName ?>';

// Validate form
fteachers_coursesgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_courses->teacher_id->FldCaption(), $teachers_courses->teacher_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_courses->teacher_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_course_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_courses->course_id->FldCaption(), $teachers_courses->course_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_course_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_courses->course_id->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fteachers_coursesgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "teacher_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "course_id", false)) return false;
	return true;
}

// Form_CustomValidate event
fteachers_coursesgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachers_coursesgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($teachers_courses->CurrentAction == "gridadd") {
	if ($teachers_courses->CurrentMode == "copy") {
		$bSelectLimit = $teachers_courses_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$teachers_courses_grid->TotalRecs = $teachers_courses->ListRecordCount();
			$teachers_courses_grid->Recordset = $teachers_courses_grid->LoadRecordset($teachers_courses_grid->StartRec-1, $teachers_courses_grid->DisplayRecs);
		} else {
			if ($teachers_courses_grid->Recordset = $teachers_courses_grid->LoadRecordset())
				$teachers_courses_grid->TotalRecs = $teachers_courses_grid->Recordset->RecordCount();
		}
		$teachers_courses_grid->StartRec = 1;
		$teachers_courses_grid->DisplayRecs = $teachers_courses_grid->TotalRecs;
	} else {
		$teachers_courses->CurrentFilter = "0=1";
		$teachers_courses_grid->StartRec = 1;
		$teachers_courses_grid->DisplayRecs = $teachers_courses->GridAddRowCount;
	}
	$teachers_courses_grid->TotalRecs = $teachers_courses_grid->DisplayRecs;
	$teachers_courses_grid->StopRec = $teachers_courses_grid->DisplayRecs;
} else {
	$bSelectLimit = $teachers_courses_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($teachers_courses_grid->TotalRecs <= 0)
			$teachers_courses_grid->TotalRecs = $teachers_courses->ListRecordCount();
	} else {
		if (!$teachers_courses_grid->Recordset && ($teachers_courses_grid->Recordset = $teachers_courses_grid->LoadRecordset()))
			$teachers_courses_grid->TotalRecs = $teachers_courses_grid->Recordset->RecordCount();
	}
	$teachers_courses_grid->StartRec = 1;
	$teachers_courses_grid->DisplayRecs = $teachers_courses_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$teachers_courses_grid->Recordset = $teachers_courses_grid->LoadRecordset($teachers_courses_grid->StartRec-1, $teachers_courses_grid->DisplayRecs);

	// Set no record found message
	if ($teachers_courses->CurrentAction == "" && $teachers_courses_grid->TotalRecs == 0) {
		if ($teachers_courses_grid->SearchWhere == "0=101")
			$teachers_courses_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$teachers_courses_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$teachers_courses_grid->RenderOtherOptions();
?>
<?php $teachers_courses_grid->ShowPageHeader(); ?>
<?php
$teachers_courses_grid->ShowMessage();
?>
<?php if ($teachers_courses_grid->TotalRecs > 0 || $teachers_courses->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($teachers_courses_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> teachers_courses">
<div id="fteachers_coursesgrid" class="ewForm ewListForm form-inline">
<?php if ($teachers_courses_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($teachers_courses_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_teachers_courses" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_teachers_coursesgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$teachers_courses_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$teachers_courses_grid->RenderListOptions();

// Render list options (header, left)
$teachers_courses_grid->ListOptions->Render("header", "left");
?>
<?php if ($teachers_courses->teacher_id->Visible) { // teacher_id ?>
	<?php if ($teachers_courses->SortUrl($teachers_courses->teacher_id) == "") { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_courses->teacher_id->HeaderCellClass() ?>"><div id="elh_teachers_courses_teacher_id" class="teachers_courses_teacher_id"><div class="ewTableHeaderCaption"><?php echo $teachers_courses->teacher_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_courses->teacher_id->HeaderCellClass() ?>"><div><div id="elh_teachers_courses_teacher_id" class="teachers_courses_teacher_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_courses->teacher_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_courses->teacher_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_courses->teacher_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_courses->course_id->Visible) { // course_id ?>
	<?php if ($teachers_courses->SortUrl($teachers_courses->course_id) == "") { ?>
		<th data-name="course_id" class="<?php echo $teachers_courses->course_id->HeaderCellClass() ?>"><div id="elh_teachers_courses_course_id" class="teachers_courses_course_id"><div class="ewTableHeaderCaption"><?php echo $teachers_courses->course_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="course_id" class="<?php echo $teachers_courses->course_id->HeaderCellClass() ?>"><div><div id="elh_teachers_courses_course_id" class="teachers_courses_course_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_courses->course_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_courses->course_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_courses->course_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$teachers_courses_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$teachers_courses_grid->StartRec = 1;
$teachers_courses_grid->StopRec = $teachers_courses_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($teachers_courses_grid->FormKeyCountName) && ($teachers_courses->CurrentAction == "gridadd" || $teachers_courses->CurrentAction == "gridedit" || $teachers_courses->CurrentAction == "F")) {
		$teachers_courses_grid->KeyCount = $objForm->GetValue($teachers_courses_grid->FormKeyCountName);
		$teachers_courses_grid->StopRec = $teachers_courses_grid->StartRec + $teachers_courses_grid->KeyCount - 1;
	}
}
$teachers_courses_grid->RecCnt = $teachers_courses_grid->StartRec - 1;
if ($teachers_courses_grid->Recordset && !$teachers_courses_grid->Recordset->EOF) {
	$teachers_courses_grid->Recordset->MoveFirst();
	$bSelectLimit = $teachers_courses_grid->UseSelectLimit;
	if (!$bSelectLimit && $teachers_courses_grid->StartRec > 1)
		$teachers_courses_grid->Recordset->Move($teachers_courses_grid->StartRec - 1);
} elseif (!$teachers_courses->AllowAddDeleteRow && $teachers_courses_grid->StopRec == 0) {
	$teachers_courses_grid->StopRec = $teachers_courses->GridAddRowCount;
}

// Initialize aggregate
$teachers_courses->RowType = EW_ROWTYPE_AGGREGATEINIT;
$teachers_courses->ResetAttrs();
$teachers_courses_grid->RenderRow();
if ($teachers_courses->CurrentAction == "gridadd")
	$teachers_courses_grid->RowIndex = 0;
if ($teachers_courses->CurrentAction == "gridedit")
	$teachers_courses_grid->RowIndex = 0;
while ($teachers_courses_grid->RecCnt < $teachers_courses_grid->StopRec) {
	$teachers_courses_grid->RecCnt++;
	if (intval($teachers_courses_grid->RecCnt) >= intval($teachers_courses_grid->StartRec)) {
		$teachers_courses_grid->RowCnt++;
		if ($teachers_courses->CurrentAction == "gridadd" || $teachers_courses->CurrentAction == "gridedit" || $teachers_courses->CurrentAction == "F") {
			$teachers_courses_grid->RowIndex++;
			$objForm->Index = $teachers_courses_grid->RowIndex;
			if ($objForm->HasValue($teachers_courses_grid->FormActionName))
				$teachers_courses_grid->RowAction = strval($objForm->GetValue($teachers_courses_grid->FormActionName));
			elseif ($teachers_courses->CurrentAction == "gridadd")
				$teachers_courses_grid->RowAction = "insert";
			else
				$teachers_courses_grid->RowAction = "";
		}

		// Set up key count
		$teachers_courses_grid->KeyCount = $teachers_courses_grid->RowIndex;

		// Init row class and style
		$teachers_courses->ResetAttrs();
		$teachers_courses->CssClass = "";
		if ($teachers_courses->CurrentAction == "gridadd") {
			if ($teachers_courses->CurrentMode == "copy") {
				$teachers_courses_grid->LoadRowValues($teachers_courses_grid->Recordset); // Load row values
				$teachers_courses_grid->SetRecordKey($teachers_courses_grid->RowOldKey, $teachers_courses_grid->Recordset); // Set old record key
			} else {
				$teachers_courses_grid->LoadRowValues(); // Load default values
				$teachers_courses_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$teachers_courses_grid->LoadRowValues($teachers_courses_grid->Recordset); // Load row values
		}
		$teachers_courses->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($teachers_courses->CurrentAction == "gridadd") // Grid add
			$teachers_courses->RowType = EW_ROWTYPE_ADD; // Render add
		if ($teachers_courses->CurrentAction == "gridadd" && $teachers_courses->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$teachers_courses_grid->RestoreCurrentRowFormValues($teachers_courses_grid->RowIndex); // Restore form values
		if ($teachers_courses->CurrentAction == "gridedit") { // Grid edit
			if ($teachers_courses->EventCancelled) {
				$teachers_courses_grid->RestoreCurrentRowFormValues($teachers_courses_grid->RowIndex); // Restore form values
			}
			if ($teachers_courses_grid->RowAction == "insert")
				$teachers_courses->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$teachers_courses->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($teachers_courses->CurrentAction == "gridedit" && ($teachers_courses->RowType == EW_ROWTYPE_EDIT || $teachers_courses->RowType == EW_ROWTYPE_ADD) && $teachers_courses->EventCancelled) // Update failed
			$teachers_courses_grid->RestoreCurrentRowFormValues($teachers_courses_grid->RowIndex); // Restore form values
		if ($teachers_courses->RowType == EW_ROWTYPE_EDIT) // Edit row
			$teachers_courses_grid->EditRowCnt++;
		if ($teachers_courses->CurrentAction == "F") // Confirm row
			$teachers_courses_grid->RestoreCurrentRowFormValues($teachers_courses_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$teachers_courses->RowAttrs = array_merge($teachers_courses->RowAttrs, array('data-rowindex'=>$teachers_courses_grid->RowCnt, 'id'=>'r' . $teachers_courses_grid->RowCnt . '_teachers_courses', 'data-rowtype'=>$teachers_courses->RowType));

		// Render row
		$teachers_courses_grid->RenderRow();

		// Render list options
		$teachers_courses_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($teachers_courses_grid->RowAction <> "delete" && $teachers_courses_grid->RowAction <> "insertdelete" && !($teachers_courses_grid->RowAction == "insert" && $teachers_courses->CurrentAction == "F" && $teachers_courses_grid->EmptyRow())) {
?>
	<tr<?php echo $teachers_courses->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_courses_grid->ListOptions->Render("body", "left", $teachers_courses_grid->RowCnt);
?>
	<?php if ($teachers_courses->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id"<?php echo $teachers_courses->teacher_id->CellAttributes() ?>>
<?php if ($teachers_courses->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($teachers_courses->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_courses_grid->RowCnt ?>_teachers_courses_teacher_id" class="form-group teachers_courses_teacher_id">
<span<?php echo $teachers_courses->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_courses->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_courses_grid->RowCnt ?>_teachers_courses_teacher_id" class="form-group teachers_courses_teacher_id">
<input type="text" data-table="teachers_courses" data-field="x_teacher_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_courses->teacher_id->EditValue ?>"<?php echo $teachers_courses->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="teachers_courses" data-field="x_teacher_id" name="o<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_courses->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($teachers_courses->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_courses_grid->RowCnt ?>_teachers_courses_teacher_id" class="form-group teachers_courses_teacher_id">
<span<?php echo $teachers_courses->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_courses->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_courses_grid->RowCnt ?>_teachers_courses_teacher_id" class="form-group teachers_courses_teacher_id">
<input type="text" data-table="teachers_courses" data-field="x_teacher_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_courses->teacher_id->EditValue ?>"<?php echo $teachers_courses->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($teachers_courses->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_courses_grid->RowCnt ?>_teachers_courses_teacher_id" class="teachers_courses_teacher_id">
<span<?php echo $teachers_courses->teacher_id->ViewAttributes() ?>>
<?php echo $teachers_courses->teacher_id->ListViewValue() ?></span>
</span>
<?php if ($teachers_courses->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_courses" data-field="x_teacher_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_courses" data-field="x_teacher_id" name="o<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_courses" data-field="x_teacher_id" name="fteachers_coursesgrid$x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" id="fteachers_coursesgrid$x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_courses" data-field="x_teacher_id" name="fteachers_coursesgrid$o<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" id="fteachers_coursesgrid$o<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_courses->course_id->Visible) { // course_id ?>
		<td data-name="course_id"<?php echo $teachers_courses->course_id->CellAttributes() ?>>
<?php if ($teachers_courses->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_courses_grid->RowCnt ?>_teachers_courses_course_id" class="form-group teachers_courses_course_id">
<input type="text" data-table="teachers_courses" data-field="x_course_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_course_id" id="x<?php echo $teachers_courses_grid->RowIndex ?>_course_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_courses->course_id->getPlaceHolder()) ?>" value="<?php echo $teachers_courses->course_id->EditValue ?>"<?php echo $teachers_courses->course_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_courses" data-field="x_course_id" name="o<?php echo $teachers_courses_grid->RowIndex ?>_course_id" id="o<?php echo $teachers_courses_grid->RowIndex ?>_course_id" value="<?php echo ew_HtmlEncode($teachers_courses->course_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_courses->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_courses_grid->RowCnt ?>_teachers_courses_course_id" class="form-group teachers_courses_course_id">
<input type="text" data-table="teachers_courses" data-field="x_course_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_course_id" id="x<?php echo $teachers_courses_grid->RowIndex ?>_course_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_courses->course_id->getPlaceHolder()) ?>" value="<?php echo $teachers_courses->course_id->EditValue ?>"<?php echo $teachers_courses->course_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_courses->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_courses_grid->RowCnt ?>_teachers_courses_course_id" class="teachers_courses_course_id">
<span<?php echo $teachers_courses->course_id->ViewAttributes() ?>>
<?php echo $teachers_courses->course_id->ListViewValue() ?></span>
</span>
<?php if ($teachers_courses->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_courses" data-field="x_course_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_course_id" id="x<?php echo $teachers_courses_grid->RowIndex ?>_course_id" value="<?php echo ew_HtmlEncode($teachers_courses->course_id->FormValue) ?>">
<input type="hidden" data-table="teachers_courses" data-field="x_course_id" name="o<?php echo $teachers_courses_grid->RowIndex ?>_course_id" id="o<?php echo $teachers_courses_grid->RowIndex ?>_course_id" value="<?php echo ew_HtmlEncode($teachers_courses->course_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_courses" data-field="x_course_id" name="fteachers_coursesgrid$x<?php echo $teachers_courses_grid->RowIndex ?>_course_id" id="fteachers_coursesgrid$x<?php echo $teachers_courses_grid->RowIndex ?>_course_id" value="<?php echo ew_HtmlEncode($teachers_courses->course_id->FormValue) ?>">
<input type="hidden" data-table="teachers_courses" data-field="x_course_id" name="fteachers_coursesgrid$o<?php echo $teachers_courses_grid->RowIndex ?>_course_id" id="fteachers_coursesgrid$o<?php echo $teachers_courses_grid->RowIndex ?>_course_id" value="<?php echo ew_HtmlEncode($teachers_courses->course_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_courses_grid->ListOptions->Render("body", "right", $teachers_courses_grid->RowCnt);
?>
	</tr>
<?php if ($teachers_courses->RowType == EW_ROWTYPE_ADD || $teachers_courses->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fteachers_coursesgrid.UpdateOpts(<?php echo $teachers_courses_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($teachers_courses->CurrentAction <> "gridadd" || $teachers_courses->CurrentMode == "copy")
		if (!$teachers_courses_grid->Recordset->EOF) $teachers_courses_grid->Recordset->MoveNext();
}
?>
<?php
	if ($teachers_courses->CurrentMode == "add" || $teachers_courses->CurrentMode == "copy" || $teachers_courses->CurrentMode == "edit") {
		$teachers_courses_grid->RowIndex = '$rowindex$';
		$teachers_courses_grid->LoadRowValues();

		// Set row properties
		$teachers_courses->ResetAttrs();
		$teachers_courses->RowAttrs = array_merge($teachers_courses->RowAttrs, array('data-rowindex'=>$teachers_courses_grid->RowIndex, 'id'=>'r0_teachers_courses', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($teachers_courses->RowAttrs["class"], "ewTemplate");
		$teachers_courses->RowType = EW_ROWTYPE_ADD;

		// Render row
		$teachers_courses_grid->RenderRow();

		// Render list options
		$teachers_courses_grid->RenderListOptions();
		$teachers_courses_grid->StartRowCnt = 0;
?>
	<tr<?php echo $teachers_courses->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_courses_grid->ListOptions->Render("body", "left", $teachers_courses_grid->RowIndex);
?>
	<?php if ($teachers_courses->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id">
<?php if ($teachers_courses->CurrentAction <> "F") { ?>
<?php if ($teachers_courses->teacher_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_teachers_courses_teacher_id" class="form-group teachers_courses_teacher_id">
<span<?php echo $teachers_courses->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_courses->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_teachers_courses_teacher_id" class="form-group teachers_courses_teacher_id">
<input type="text" data-table="teachers_courses" data-field="x_teacher_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_courses->teacher_id->EditValue ?>"<?php echo $teachers_courses->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_courses_teacher_id" class="form-group teachers_courses_teacher_id">
<span<?php echo $teachers_courses->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_courses->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_courses" data-field="x_teacher_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_courses" data-field="x_teacher_id" name="o<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_courses_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_courses->teacher_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_courses->course_id->Visible) { // course_id ?>
		<td data-name="course_id">
<?php if ($teachers_courses->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_courses_course_id" class="form-group teachers_courses_course_id">
<input type="text" data-table="teachers_courses" data-field="x_course_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_course_id" id="x<?php echo $teachers_courses_grid->RowIndex ?>_course_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_courses->course_id->getPlaceHolder()) ?>" value="<?php echo $teachers_courses->course_id->EditValue ?>"<?php echo $teachers_courses->course_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_courses_course_id" class="form-group teachers_courses_course_id">
<span<?php echo $teachers_courses->course_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_courses->course_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_courses" data-field="x_course_id" name="x<?php echo $teachers_courses_grid->RowIndex ?>_course_id" id="x<?php echo $teachers_courses_grid->RowIndex ?>_course_id" value="<?php echo ew_HtmlEncode($teachers_courses->course_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_courses" data-field="x_course_id" name="o<?php echo $teachers_courses_grid->RowIndex ?>_course_id" id="o<?php echo $teachers_courses_grid->RowIndex ?>_course_id" value="<?php echo ew_HtmlEncode($teachers_courses->course_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_courses_grid->ListOptions->Render("body", "right", $teachers_courses_grid->RowIndex);
?>
<script type="text/javascript">
fteachers_coursesgrid.UpdateOpts(<?php echo $teachers_courses_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($teachers_courses->CurrentMode == "add" || $teachers_courses->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $teachers_courses_grid->FormKeyCountName ?>" id="<?php echo $teachers_courses_grid->FormKeyCountName ?>" value="<?php echo $teachers_courses_grid->KeyCount ?>">
<?php echo $teachers_courses_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_courses->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $teachers_courses_grid->FormKeyCountName ?>" id="<?php echo $teachers_courses_grid->FormKeyCountName ?>" value="<?php echo $teachers_courses_grid->KeyCount ?>">
<?php echo $teachers_courses_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_courses->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fteachers_coursesgrid">
</div>
<?php

// Close recordset
if ($teachers_courses_grid->Recordset)
	$teachers_courses_grid->Recordset->Close();
?>
<?php if ($teachers_courses_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($teachers_courses_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($teachers_courses_grid->TotalRecs == 0 && $teachers_courses->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_courses_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($teachers_courses->Export == "") { ?>
<script type="text/javascript">
fteachers_coursesgrid.Init();
</script>
<?php } ?>
<?php
$teachers_courses_grid->Page_Terminate();
?>
