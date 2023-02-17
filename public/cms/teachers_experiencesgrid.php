<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($teachers_experiences_grid)) $teachers_experiences_grid = new cteachers_experiences_grid();

// Page init
$teachers_experiences_grid->Page_Init();

// Page main
$teachers_experiences_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_experiences_grid->Page_Render();
?>
<?php if ($teachers_experiences->Export == "") { ?>
<script type="text/javascript">

// Form object
var fteachers_experiencesgrid = new ew_Form("fteachers_experiencesgrid", "grid");
fteachers_experiencesgrid.FormKeyCountName = '<?php echo $teachers_experiences_grid->FormKeyCountName ?>';

// Validate form
fteachers_experiencesgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_experiences->teacher_id->FldCaption(), $teachers_experiences->teacher_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_experiences->teacher_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_experiences->title->FldCaption(), $teachers_experiences->title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_from_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_experiences->from_date->FldCaption(), $teachers_experiences->from_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_from_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_experiences->from_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_to_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_experiences->to_date->FldCaption(), $teachers_experiences->to_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_to_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_experiences->to_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_company");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_experiences->company->FldCaption(), $teachers_experiences->company->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fteachers_experiencesgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "teacher_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "title", false)) return false;
	if (ew_ValueChanged(fobj, infix, "from_date", false)) return false;
	if (ew_ValueChanged(fobj, infix, "to_date", false)) return false;
	if (ew_ValueChanged(fobj, infix, "company", false)) return false;
	return true;
}

// Form_CustomValidate event
fteachers_experiencesgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachers_experiencesgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($teachers_experiences->CurrentAction == "gridadd") {
	if ($teachers_experiences->CurrentMode == "copy") {
		$bSelectLimit = $teachers_experiences_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$teachers_experiences_grid->TotalRecs = $teachers_experiences->ListRecordCount();
			$teachers_experiences_grid->Recordset = $teachers_experiences_grid->LoadRecordset($teachers_experiences_grid->StartRec-1, $teachers_experiences_grid->DisplayRecs);
		} else {
			if ($teachers_experiences_grid->Recordset = $teachers_experiences_grid->LoadRecordset())
				$teachers_experiences_grid->TotalRecs = $teachers_experiences_grid->Recordset->RecordCount();
		}
		$teachers_experiences_grid->StartRec = 1;
		$teachers_experiences_grid->DisplayRecs = $teachers_experiences_grid->TotalRecs;
	} else {
		$teachers_experiences->CurrentFilter = "0=1";
		$teachers_experiences_grid->StartRec = 1;
		$teachers_experiences_grid->DisplayRecs = $teachers_experiences->GridAddRowCount;
	}
	$teachers_experiences_grid->TotalRecs = $teachers_experiences_grid->DisplayRecs;
	$teachers_experiences_grid->StopRec = $teachers_experiences_grid->DisplayRecs;
} else {
	$bSelectLimit = $teachers_experiences_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($teachers_experiences_grid->TotalRecs <= 0)
			$teachers_experiences_grid->TotalRecs = $teachers_experiences->ListRecordCount();
	} else {
		if (!$teachers_experiences_grid->Recordset && ($teachers_experiences_grid->Recordset = $teachers_experiences_grid->LoadRecordset()))
			$teachers_experiences_grid->TotalRecs = $teachers_experiences_grid->Recordset->RecordCount();
	}
	$teachers_experiences_grid->StartRec = 1;
	$teachers_experiences_grid->DisplayRecs = $teachers_experiences_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$teachers_experiences_grid->Recordset = $teachers_experiences_grid->LoadRecordset($teachers_experiences_grid->StartRec-1, $teachers_experiences_grid->DisplayRecs);

	// Set no record found message
	if ($teachers_experiences->CurrentAction == "" && $teachers_experiences_grid->TotalRecs == 0) {
		if ($teachers_experiences_grid->SearchWhere == "0=101")
			$teachers_experiences_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$teachers_experiences_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$teachers_experiences_grid->RenderOtherOptions();
?>
<?php $teachers_experiences_grid->ShowPageHeader(); ?>
<?php
$teachers_experiences_grid->ShowMessage();
?>
<?php if ($teachers_experiences_grid->TotalRecs > 0 || $teachers_experiences->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($teachers_experiences_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> teachers_experiences">
<div id="fteachers_experiencesgrid" class="ewForm ewListForm form-inline">
<?php if ($teachers_experiences_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($teachers_experiences_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_teachers_experiences" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_teachers_experiencesgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$teachers_experiences_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$teachers_experiences_grid->RenderListOptions();

// Render list options (header, left)
$teachers_experiences_grid->ListOptions->Render("header", "left");
?>
<?php if ($teachers_experiences->id->Visible) { // id ?>
	<?php if ($teachers_experiences->SortUrl($teachers_experiences->id) == "") { ?>
		<th data-name="id" class="<?php echo $teachers_experiences->id->HeaderCellClass() ?>"><div id="elh_teachers_experiences_id" class="teachers_experiences_id"><div class="ewTableHeaderCaption"><?php echo $teachers_experiences->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $teachers_experiences->id->HeaderCellClass() ?>"><div><div id="elh_teachers_experiences_id" class="teachers_experiences_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_experiences->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_experiences->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_experiences->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_experiences->teacher_id->Visible) { // teacher_id ?>
	<?php if ($teachers_experiences->SortUrl($teachers_experiences->teacher_id) == "") { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_experiences->teacher_id->HeaderCellClass() ?>"><div id="elh_teachers_experiences_teacher_id" class="teachers_experiences_teacher_id"><div class="ewTableHeaderCaption"><?php echo $teachers_experiences->teacher_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_experiences->teacher_id->HeaderCellClass() ?>"><div><div id="elh_teachers_experiences_teacher_id" class="teachers_experiences_teacher_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_experiences->teacher_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_experiences->teacher_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_experiences->teacher_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_experiences->title->Visible) { // title ?>
	<?php if ($teachers_experiences->SortUrl($teachers_experiences->title) == "") { ?>
		<th data-name="title" class="<?php echo $teachers_experiences->title->HeaderCellClass() ?>"><div id="elh_teachers_experiences_title" class="teachers_experiences_title"><div class="ewTableHeaderCaption"><?php echo $teachers_experiences->title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title" class="<?php echo $teachers_experiences->title->HeaderCellClass() ?>"><div><div id="elh_teachers_experiences_title" class="teachers_experiences_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_experiences->title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_experiences->title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_experiences->title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_experiences->from_date->Visible) { // from_date ?>
	<?php if ($teachers_experiences->SortUrl($teachers_experiences->from_date) == "") { ?>
		<th data-name="from_date" class="<?php echo $teachers_experiences->from_date->HeaderCellClass() ?>"><div id="elh_teachers_experiences_from_date" class="teachers_experiences_from_date"><div class="ewTableHeaderCaption"><?php echo $teachers_experiences->from_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="from_date" class="<?php echo $teachers_experiences->from_date->HeaderCellClass() ?>"><div><div id="elh_teachers_experiences_from_date" class="teachers_experiences_from_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_experiences->from_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_experiences->from_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_experiences->from_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_experiences->to_date->Visible) { // to_date ?>
	<?php if ($teachers_experiences->SortUrl($teachers_experiences->to_date) == "") { ?>
		<th data-name="to_date" class="<?php echo $teachers_experiences->to_date->HeaderCellClass() ?>"><div id="elh_teachers_experiences_to_date" class="teachers_experiences_to_date"><div class="ewTableHeaderCaption"><?php echo $teachers_experiences->to_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="to_date" class="<?php echo $teachers_experiences->to_date->HeaderCellClass() ?>"><div><div id="elh_teachers_experiences_to_date" class="teachers_experiences_to_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_experiences->to_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_experiences->to_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_experiences->to_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_experiences->company->Visible) { // company ?>
	<?php if ($teachers_experiences->SortUrl($teachers_experiences->company) == "") { ?>
		<th data-name="company" class="<?php echo $teachers_experiences->company->HeaderCellClass() ?>"><div id="elh_teachers_experiences_company" class="teachers_experiences_company"><div class="ewTableHeaderCaption"><?php echo $teachers_experiences->company->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="company" class="<?php echo $teachers_experiences->company->HeaderCellClass() ?>"><div><div id="elh_teachers_experiences_company" class="teachers_experiences_company">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_experiences->company->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_experiences->company->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_experiences->company->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$teachers_experiences_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$teachers_experiences_grid->StartRec = 1;
$teachers_experiences_grid->StopRec = $teachers_experiences_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($teachers_experiences_grid->FormKeyCountName) && ($teachers_experiences->CurrentAction == "gridadd" || $teachers_experiences->CurrentAction == "gridedit" || $teachers_experiences->CurrentAction == "F")) {
		$teachers_experiences_grid->KeyCount = $objForm->GetValue($teachers_experiences_grid->FormKeyCountName);
		$teachers_experiences_grid->StopRec = $teachers_experiences_grid->StartRec + $teachers_experiences_grid->KeyCount - 1;
	}
}
$teachers_experiences_grid->RecCnt = $teachers_experiences_grid->StartRec - 1;
if ($teachers_experiences_grid->Recordset && !$teachers_experiences_grid->Recordset->EOF) {
	$teachers_experiences_grid->Recordset->MoveFirst();
	$bSelectLimit = $teachers_experiences_grid->UseSelectLimit;
	if (!$bSelectLimit && $teachers_experiences_grid->StartRec > 1)
		$teachers_experiences_grid->Recordset->Move($teachers_experiences_grid->StartRec - 1);
} elseif (!$teachers_experiences->AllowAddDeleteRow && $teachers_experiences_grid->StopRec == 0) {
	$teachers_experiences_grid->StopRec = $teachers_experiences->GridAddRowCount;
}

// Initialize aggregate
$teachers_experiences->RowType = EW_ROWTYPE_AGGREGATEINIT;
$teachers_experiences->ResetAttrs();
$teachers_experiences_grid->RenderRow();
if ($teachers_experiences->CurrentAction == "gridadd")
	$teachers_experiences_grid->RowIndex = 0;
if ($teachers_experiences->CurrentAction == "gridedit")
	$teachers_experiences_grid->RowIndex = 0;
while ($teachers_experiences_grid->RecCnt < $teachers_experiences_grid->StopRec) {
	$teachers_experiences_grid->RecCnt++;
	if (intval($teachers_experiences_grid->RecCnt) >= intval($teachers_experiences_grid->StartRec)) {
		$teachers_experiences_grid->RowCnt++;
		if ($teachers_experiences->CurrentAction == "gridadd" || $teachers_experiences->CurrentAction == "gridedit" || $teachers_experiences->CurrentAction == "F") {
			$teachers_experiences_grid->RowIndex++;
			$objForm->Index = $teachers_experiences_grid->RowIndex;
			if ($objForm->HasValue($teachers_experiences_grid->FormActionName))
				$teachers_experiences_grid->RowAction = strval($objForm->GetValue($teachers_experiences_grid->FormActionName));
			elseif ($teachers_experiences->CurrentAction == "gridadd")
				$teachers_experiences_grid->RowAction = "insert";
			else
				$teachers_experiences_grid->RowAction = "";
		}

		// Set up key count
		$teachers_experiences_grid->KeyCount = $teachers_experiences_grid->RowIndex;

		// Init row class and style
		$teachers_experiences->ResetAttrs();
		$teachers_experiences->CssClass = "";
		if ($teachers_experiences->CurrentAction == "gridadd") {
			if ($teachers_experiences->CurrentMode == "copy") {
				$teachers_experiences_grid->LoadRowValues($teachers_experiences_grid->Recordset); // Load row values
				$teachers_experiences_grid->SetRecordKey($teachers_experiences_grid->RowOldKey, $teachers_experiences_grid->Recordset); // Set old record key
			} else {
				$teachers_experiences_grid->LoadRowValues(); // Load default values
				$teachers_experiences_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$teachers_experiences_grid->LoadRowValues($teachers_experiences_grid->Recordset); // Load row values
		}
		$teachers_experiences->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($teachers_experiences->CurrentAction == "gridadd") // Grid add
			$teachers_experiences->RowType = EW_ROWTYPE_ADD; // Render add
		if ($teachers_experiences->CurrentAction == "gridadd" && $teachers_experiences->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$teachers_experiences_grid->RestoreCurrentRowFormValues($teachers_experiences_grid->RowIndex); // Restore form values
		if ($teachers_experiences->CurrentAction == "gridedit") { // Grid edit
			if ($teachers_experiences->EventCancelled) {
				$teachers_experiences_grid->RestoreCurrentRowFormValues($teachers_experiences_grid->RowIndex); // Restore form values
			}
			if ($teachers_experiences_grid->RowAction == "insert")
				$teachers_experiences->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$teachers_experiences->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($teachers_experiences->CurrentAction == "gridedit" && ($teachers_experiences->RowType == EW_ROWTYPE_EDIT || $teachers_experiences->RowType == EW_ROWTYPE_ADD) && $teachers_experiences->EventCancelled) // Update failed
			$teachers_experiences_grid->RestoreCurrentRowFormValues($teachers_experiences_grid->RowIndex); // Restore form values
		if ($teachers_experiences->RowType == EW_ROWTYPE_EDIT) // Edit row
			$teachers_experiences_grid->EditRowCnt++;
		if ($teachers_experiences->CurrentAction == "F") // Confirm row
			$teachers_experiences_grid->RestoreCurrentRowFormValues($teachers_experiences_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$teachers_experiences->RowAttrs = array_merge($teachers_experiences->RowAttrs, array('data-rowindex'=>$teachers_experiences_grid->RowCnt, 'id'=>'r' . $teachers_experiences_grid->RowCnt . '_teachers_experiences', 'data-rowtype'=>$teachers_experiences->RowType));

		// Render row
		$teachers_experiences_grid->RenderRow();

		// Render list options
		$teachers_experiences_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($teachers_experiences_grid->RowAction <> "delete" && $teachers_experiences_grid->RowAction <> "insertdelete" && !($teachers_experiences_grid->RowAction == "insert" && $teachers_experiences->CurrentAction == "F" && $teachers_experiences_grid->EmptyRow())) {
?>
	<tr<?php echo $teachers_experiences->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_experiences_grid->ListOptions->Render("body", "left", $teachers_experiences_grid->RowCnt);
?>
	<?php if ($teachers_experiences->id->Visible) { // id ?>
		<td data-name="id"<?php echo $teachers_experiences->id->CellAttributes() ?>>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_id" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_id" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_experiences->id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_id" class="form-group teachers_experiences_id">
<span<?php echo $teachers_experiences->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_experiences->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_experiences" data-field="x_id" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_id" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_experiences->id->CurrentValue) ?>">
<?php } ?>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_id" class="teachers_experiences_id">
<span<?php echo $teachers_experiences->id->ViewAttributes() ?>>
<?php echo $teachers_experiences->id->ListViewValue() ?></span>
</span>
<?php if ($teachers_experiences->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_id" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_id" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_experiences->id->FormValue) ?>">
<input type="hidden" data-table="teachers_experiences" data-field="x_id" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_id" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_experiences->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_id" name="fteachers_experiencesgrid$x<?php echo $teachers_experiences_grid->RowIndex ?>_id" id="fteachers_experiencesgrid$x<?php echo $teachers_experiences_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_experiences->id->FormValue) ?>">
<input type="hidden" data-table="teachers_experiences" data-field="x_id" name="fteachers_experiencesgrid$o<?php echo $teachers_experiences_grid->RowIndex ?>_id" id="fteachers_experiencesgrid$o<?php echo $teachers_experiences_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_experiences->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_experiences->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id"<?php echo $teachers_experiences->teacher_id->CellAttributes() ?>>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($teachers_experiences->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_teacher_id" class="form-group teachers_experiences_teacher_id">
<span<?php echo $teachers_experiences->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_experiences->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_teacher_id" class="form-group teachers_experiences_teacher_id">
<input type="text" data-table="teachers_experiences" data-field="x_teacher_id" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_experiences->teacher_id->EditValue ?>"<?php echo $teachers_experiences->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_teacher_id" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($teachers_experiences->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_teacher_id" class="form-group teachers_experiences_teacher_id">
<span<?php echo $teachers_experiences->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_experiences->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_teacher_id" class="form-group teachers_experiences_teacher_id">
<input type="text" data-table="teachers_experiences" data-field="x_teacher_id" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_experiences->teacher_id->EditValue ?>"<?php echo $teachers_experiences->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_teacher_id" class="teachers_experiences_teacher_id">
<span<?php echo $teachers_experiences->teacher_id->ViewAttributes() ?>>
<?php echo $teachers_experiences->teacher_id->ListViewValue() ?></span>
</span>
<?php if ($teachers_experiences->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_teacher_id" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_experiences" data-field="x_teacher_id" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_teacher_id" name="fteachers_experiencesgrid$x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" id="fteachers_experiencesgrid$x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_experiences" data-field="x_teacher_id" name="fteachers_experiencesgrid$o<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" id="fteachers_experiencesgrid$o<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_experiences->title->Visible) { // title ?>
		<td data-name="title"<?php echo $teachers_experiences->title->CellAttributes() ?>>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_title" class="form-group teachers_experiences_title">
<textarea data-table="teachers_experiences" data-field="x_title" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_title" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_title" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->title->getPlaceHolder()) ?>"<?php echo $teachers_experiences->title->EditAttributes() ?>><?php echo $teachers_experiences->title->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_experiences" data-field="x_title" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_title" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($teachers_experiences->title->OldValue) ?>">
<?php } ?>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_title" class="form-group teachers_experiences_title">
<textarea data-table="teachers_experiences" data-field="x_title" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_title" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_title" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->title->getPlaceHolder()) ?>"<?php echo $teachers_experiences->title->EditAttributes() ?>><?php echo $teachers_experiences->title->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_title" class="teachers_experiences_title">
<span<?php echo $teachers_experiences->title->ViewAttributes() ?>>
<?php echo $teachers_experiences->title->ListViewValue() ?></span>
</span>
<?php if ($teachers_experiences->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_title" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_title" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($teachers_experiences->title->FormValue) ?>">
<input type="hidden" data-table="teachers_experiences" data-field="x_title" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_title" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($teachers_experiences->title->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_title" name="fteachers_experiencesgrid$x<?php echo $teachers_experiences_grid->RowIndex ?>_title" id="fteachers_experiencesgrid$x<?php echo $teachers_experiences_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($teachers_experiences->title->FormValue) ?>">
<input type="hidden" data-table="teachers_experiences" data-field="x_title" name="fteachers_experiencesgrid$o<?php echo $teachers_experiences_grid->RowIndex ?>_title" id="fteachers_experiencesgrid$o<?php echo $teachers_experiences_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($teachers_experiences->title->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_experiences->from_date->Visible) { // from_date ?>
		<td data-name="from_date"<?php echo $teachers_experiences->from_date->CellAttributes() ?>>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_from_date" class="form-group teachers_experiences_from_date">
<input type="text" data-table="teachers_experiences" data-field="x_from_date" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_experiences->from_date->EditValue ?>"<?php echo $teachers_experiences->from_date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_experiences" data-field="x_from_date" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_experiences->from_date->OldValue) ?>">
<?php } ?>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_from_date" class="form-group teachers_experiences_from_date">
<input type="text" data-table="teachers_experiences" data-field="x_from_date" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_experiences->from_date->EditValue ?>"<?php echo $teachers_experiences->from_date->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_from_date" class="teachers_experiences_from_date">
<span<?php echo $teachers_experiences->from_date->ViewAttributes() ?>>
<?php echo $teachers_experiences->from_date->ListViewValue() ?></span>
</span>
<?php if ($teachers_experiences->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_from_date" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_experiences->from_date->FormValue) ?>">
<input type="hidden" data-table="teachers_experiences" data-field="x_from_date" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_experiences->from_date->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_from_date" name="fteachers_experiencesgrid$x<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" id="fteachers_experiencesgrid$x<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_experiences->from_date->FormValue) ?>">
<input type="hidden" data-table="teachers_experiences" data-field="x_from_date" name="fteachers_experiencesgrid$o<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" id="fteachers_experiencesgrid$o<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_experiences->from_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_experiences->to_date->Visible) { // to_date ?>
		<td data-name="to_date"<?php echo $teachers_experiences->to_date->CellAttributes() ?>>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_to_date" class="form-group teachers_experiences_to_date">
<input type="text" data-table="teachers_experiences" data-field="x_to_date" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_experiences->to_date->EditValue ?>"<?php echo $teachers_experiences->to_date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_experiences" data-field="x_to_date" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_experiences->to_date->OldValue) ?>">
<?php } ?>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_to_date" class="form-group teachers_experiences_to_date">
<input type="text" data-table="teachers_experiences" data-field="x_to_date" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_experiences->to_date->EditValue ?>"<?php echo $teachers_experiences->to_date->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_to_date" class="teachers_experiences_to_date">
<span<?php echo $teachers_experiences->to_date->ViewAttributes() ?>>
<?php echo $teachers_experiences->to_date->ListViewValue() ?></span>
</span>
<?php if ($teachers_experiences->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_to_date" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_experiences->to_date->FormValue) ?>">
<input type="hidden" data-table="teachers_experiences" data-field="x_to_date" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_experiences->to_date->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_to_date" name="fteachers_experiencesgrid$x<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" id="fteachers_experiencesgrid$x<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_experiences->to_date->FormValue) ?>">
<input type="hidden" data-table="teachers_experiences" data-field="x_to_date" name="fteachers_experiencesgrid$o<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" id="fteachers_experiencesgrid$o<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_experiences->to_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_experiences->company->Visible) { // company ?>
		<td data-name="company"<?php echo $teachers_experiences->company->CellAttributes() ?>>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_company" class="form-group teachers_experiences_company">
<textarea data-table="teachers_experiences" data-field="x_company" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_company" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_company" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->company->getPlaceHolder()) ?>"<?php echo $teachers_experiences->company->EditAttributes() ?>><?php echo $teachers_experiences->company->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_experiences" data-field="x_company" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_company" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_company" value="<?php echo ew_HtmlEncode($teachers_experiences->company->OldValue) ?>">
<?php } ?>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_company" class="form-group teachers_experiences_company">
<textarea data-table="teachers_experiences" data-field="x_company" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_company" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_company" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->company->getPlaceHolder()) ?>"<?php echo $teachers_experiences->company->EditAttributes() ?>><?php echo $teachers_experiences->company->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_experiences_grid->RowCnt ?>_teachers_experiences_company" class="teachers_experiences_company">
<span<?php echo $teachers_experiences->company->ViewAttributes() ?>>
<?php echo $teachers_experiences->company->ListViewValue() ?></span>
</span>
<?php if ($teachers_experiences->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_company" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_company" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_company" value="<?php echo ew_HtmlEncode($teachers_experiences->company->FormValue) ?>">
<input type="hidden" data-table="teachers_experiences" data-field="x_company" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_company" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_company" value="<?php echo ew_HtmlEncode($teachers_experiences->company->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_company" name="fteachers_experiencesgrid$x<?php echo $teachers_experiences_grid->RowIndex ?>_company" id="fteachers_experiencesgrid$x<?php echo $teachers_experiences_grid->RowIndex ?>_company" value="<?php echo ew_HtmlEncode($teachers_experiences->company->FormValue) ?>">
<input type="hidden" data-table="teachers_experiences" data-field="x_company" name="fteachers_experiencesgrid$o<?php echo $teachers_experiences_grid->RowIndex ?>_company" id="fteachers_experiencesgrid$o<?php echo $teachers_experiences_grid->RowIndex ?>_company" value="<?php echo ew_HtmlEncode($teachers_experiences->company->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_experiences_grid->ListOptions->Render("body", "right", $teachers_experiences_grid->RowCnt);
?>
	</tr>
<?php if ($teachers_experiences->RowType == EW_ROWTYPE_ADD || $teachers_experiences->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fteachers_experiencesgrid.UpdateOpts(<?php echo $teachers_experiences_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($teachers_experiences->CurrentAction <> "gridadd" || $teachers_experiences->CurrentMode == "copy")
		if (!$teachers_experiences_grid->Recordset->EOF) $teachers_experiences_grid->Recordset->MoveNext();
}
?>
<?php
	if ($teachers_experiences->CurrentMode == "add" || $teachers_experiences->CurrentMode == "copy" || $teachers_experiences->CurrentMode == "edit") {
		$teachers_experiences_grid->RowIndex = '$rowindex$';
		$teachers_experiences_grid->LoadRowValues();

		// Set row properties
		$teachers_experiences->ResetAttrs();
		$teachers_experiences->RowAttrs = array_merge($teachers_experiences->RowAttrs, array('data-rowindex'=>$teachers_experiences_grid->RowIndex, 'id'=>'r0_teachers_experiences', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($teachers_experiences->RowAttrs["class"], "ewTemplate");
		$teachers_experiences->RowType = EW_ROWTYPE_ADD;

		// Render row
		$teachers_experiences_grid->RenderRow();

		// Render list options
		$teachers_experiences_grid->RenderListOptions();
		$teachers_experiences_grid->StartRowCnt = 0;
?>
	<tr<?php echo $teachers_experiences->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_experiences_grid->ListOptions->Render("body", "left", $teachers_experiences_grid->RowIndex);
?>
	<?php if ($teachers_experiences->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($teachers_experiences->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_experiences_id" class="form-group teachers_experiences_id">
<span<?php echo $teachers_experiences->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_experiences->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_experiences" data-field="x_id" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_id" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_experiences->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_id" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_id" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_experiences->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_experiences->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id">
<?php if ($teachers_experiences->CurrentAction <> "F") { ?>
<?php if ($teachers_experiences->teacher_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_teachers_experiences_teacher_id" class="form-group teachers_experiences_teacher_id">
<span<?php echo $teachers_experiences->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_experiences->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_teachers_experiences_teacher_id" class="form-group teachers_experiences_teacher_id">
<input type="text" data-table="teachers_experiences" data-field="x_teacher_id" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_experiences->teacher_id->EditValue ?>"<?php echo $teachers_experiences->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_experiences_teacher_id" class="form-group teachers_experiences_teacher_id">
<span<?php echo $teachers_experiences->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_experiences->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_experiences" data-field="x_teacher_id" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_teacher_id" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_experiences->teacher_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_experiences->title->Visible) { // title ?>
		<td data-name="title">
<?php if ($teachers_experiences->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_experiences_title" class="form-group teachers_experiences_title">
<textarea data-table="teachers_experiences" data-field="x_title" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_title" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_title" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->title->getPlaceHolder()) ?>"<?php echo $teachers_experiences->title->EditAttributes() ?>><?php echo $teachers_experiences->title->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_experiences_title" class="form-group teachers_experiences_title">
<span<?php echo $teachers_experiences->title->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_experiences->title->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_experiences" data-field="x_title" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_title" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($teachers_experiences->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_title" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_title" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($teachers_experiences->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_experiences->from_date->Visible) { // from_date ?>
		<td data-name="from_date">
<?php if ($teachers_experiences->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_experiences_from_date" class="form-group teachers_experiences_from_date">
<input type="text" data-table="teachers_experiences" data-field="x_from_date" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_experiences->from_date->EditValue ?>"<?php echo $teachers_experiences->from_date->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_experiences_from_date" class="form-group teachers_experiences_from_date">
<span<?php echo $teachers_experiences->from_date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_experiences->from_date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_experiences" data-field="x_from_date" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_experiences->from_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_from_date" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_experiences->from_date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_experiences->to_date->Visible) { // to_date ?>
		<td data-name="to_date">
<?php if ($teachers_experiences->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_experiences_to_date" class="form-group teachers_experiences_to_date">
<input type="text" data-table="teachers_experiences" data-field="x_to_date" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_experiences->to_date->EditValue ?>"<?php echo $teachers_experiences->to_date->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_experiences_to_date" class="form-group teachers_experiences_to_date">
<span<?php echo $teachers_experiences->to_date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_experiences->to_date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_experiences" data-field="x_to_date" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_experiences->to_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_to_date" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_experiences->to_date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_experiences->company->Visible) { // company ?>
		<td data-name="company">
<?php if ($teachers_experiences->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_experiences_company" class="form-group teachers_experiences_company">
<textarea data-table="teachers_experiences" data-field="x_company" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_company" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_company" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_experiences->company->getPlaceHolder()) ?>"<?php echo $teachers_experiences->company->EditAttributes() ?>><?php echo $teachers_experiences->company->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_experiences_company" class="form-group teachers_experiences_company">
<span<?php echo $teachers_experiences->company->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_experiences->company->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_experiences" data-field="x_company" name="x<?php echo $teachers_experiences_grid->RowIndex ?>_company" id="x<?php echo $teachers_experiences_grid->RowIndex ?>_company" value="<?php echo ew_HtmlEncode($teachers_experiences->company->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_experiences" data-field="x_company" name="o<?php echo $teachers_experiences_grid->RowIndex ?>_company" id="o<?php echo $teachers_experiences_grid->RowIndex ?>_company" value="<?php echo ew_HtmlEncode($teachers_experiences->company->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_experiences_grid->ListOptions->Render("body", "right", $teachers_experiences_grid->RowIndex);
?>
<script type="text/javascript">
fteachers_experiencesgrid.UpdateOpts(<?php echo $teachers_experiences_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($teachers_experiences->CurrentMode == "add" || $teachers_experiences->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $teachers_experiences_grid->FormKeyCountName ?>" id="<?php echo $teachers_experiences_grid->FormKeyCountName ?>" value="<?php echo $teachers_experiences_grid->KeyCount ?>">
<?php echo $teachers_experiences_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_experiences->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $teachers_experiences_grid->FormKeyCountName ?>" id="<?php echo $teachers_experiences_grid->FormKeyCountName ?>" value="<?php echo $teachers_experiences_grid->KeyCount ?>">
<?php echo $teachers_experiences_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_experiences->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fteachers_experiencesgrid">
</div>
<?php

// Close recordset
if ($teachers_experiences_grid->Recordset)
	$teachers_experiences_grid->Recordset->Close();
?>
<?php if ($teachers_experiences_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($teachers_experiences_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($teachers_experiences_grid->TotalRecs == 0 && $teachers_experiences->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_experiences_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($teachers_experiences->Export == "") { ?>
<script type="text/javascript">
fteachers_experiencesgrid.Init();
</script>
<?php } ?>
<?php
$teachers_experiences_grid->Page_Terminate();
?>
