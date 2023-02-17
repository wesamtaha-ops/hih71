<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($teachers_certificates_grid)) $teachers_certificates_grid = new cteachers_certificates_grid();

// Page init
$teachers_certificates_grid->Page_Init();

// Page main
$teachers_certificates_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_certificates_grid->Page_Render();
?>
<?php if ($teachers_certificates->Export == "") { ?>
<script type="text/javascript">

// Form object
var fteachers_certificatesgrid = new ew_Form("fteachers_certificatesgrid", "grid");
fteachers_certificatesgrid.FormKeyCountName = '<?php echo $teachers_certificates_grid->FormKeyCountName ?>';

// Validate form
fteachers_certificatesgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_certificates->teacher_id->FldCaption(), $teachers_certificates->teacher_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_certificates->teacher_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_university");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_certificates->university->FldCaption(), $teachers_certificates->university->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_degree");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_certificates->degree->FldCaption(), $teachers_certificates->degree->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_image");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_certificates->image->FldCaption(), $teachers_certificates->image->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_from_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_certificates->from_date->FldCaption(), $teachers_certificates->from_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_from_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_certificates->from_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_to_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_certificates->to_date->FldCaption(), $teachers_certificates->to_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_to_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_certificates->to_date->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fteachers_certificatesgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "teacher_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "university", false)) return false;
	if (ew_ValueChanged(fobj, infix, "degree", false)) return false;
	if (ew_ValueChanged(fobj, infix, "image", false)) return false;
	if (ew_ValueChanged(fobj, infix, "from_date", false)) return false;
	if (ew_ValueChanged(fobj, infix, "to_date", false)) return false;
	return true;
}

// Form_CustomValidate event
fteachers_certificatesgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachers_certificatesgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($teachers_certificates->CurrentAction == "gridadd") {
	if ($teachers_certificates->CurrentMode == "copy") {
		$bSelectLimit = $teachers_certificates_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$teachers_certificates_grid->TotalRecs = $teachers_certificates->ListRecordCount();
			$teachers_certificates_grid->Recordset = $teachers_certificates_grid->LoadRecordset($teachers_certificates_grid->StartRec-1, $teachers_certificates_grid->DisplayRecs);
		} else {
			if ($teachers_certificates_grid->Recordset = $teachers_certificates_grid->LoadRecordset())
				$teachers_certificates_grid->TotalRecs = $teachers_certificates_grid->Recordset->RecordCount();
		}
		$teachers_certificates_grid->StartRec = 1;
		$teachers_certificates_grid->DisplayRecs = $teachers_certificates_grid->TotalRecs;
	} else {
		$teachers_certificates->CurrentFilter = "0=1";
		$teachers_certificates_grid->StartRec = 1;
		$teachers_certificates_grid->DisplayRecs = $teachers_certificates->GridAddRowCount;
	}
	$teachers_certificates_grid->TotalRecs = $teachers_certificates_grid->DisplayRecs;
	$teachers_certificates_grid->StopRec = $teachers_certificates_grid->DisplayRecs;
} else {
	$bSelectLimit = $teachers_certificates_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($teachers_certificates_grid->TotalRecs <= 0)
			$teachers_certificates_grid->TotalRecs = $teachers_certificates->ListRecordCount();
	} else {
		if (!$teachers_certificates_grid->Recordset && ($teachers_certificates_grid->Recordset = $teachers_certificates_grid->LoadRecordset()))
			$teachers_certificates_grid->TotalRecs = $teachers_certificates_grid->Recordset->RecordCount();
	}
	$teachers_certificates_grid->StartRec = 1;
	$teachers_certificates_grid->DisplayRecs = $teachers_certificates_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$teachers_certificates_grid->Recordset = $teachers_certificates_grid->LoadRecordset($teachers_certificates_grid->StartRec-1, $teachers_certificates_grid->DisplayRecs);

	// Set no record found message
	if ($teachers_certificates->CurrentAction == "" && $teachers_certificates_grid->TotalRecs == 0) {
		if ($teachers_certificates_grid->SearchWhere == "0=101")
			$teachers_certificates_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$teachers_certificates_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$teachers_certificates_grid->RenderOtherOptions();
?>
<?php $teachers_certificates_grid->ShowPageHeader(); ?>
<?php
$teachers_certificates_grid->ShowMessage();
?>
<?php if ($teachers_certificates_grid->TotalRecs > 0 || $teachers_certificates->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($teachers_certificates_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> teachers_certificates">
<div id="fteachers_certificatesgrid" class="ewForm ewListForm form-inline">
<?php if ($teachers_certificates_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($teachers_certificates_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_teachers_certificates" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_teachers_certificatesgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$teachers_certificates_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$teachers_certificates_grid->RenderListOptions();

// Render list options (header, left)
$teachers_certificates_grid->ListOptions->Render("header", "left");
?>
<?php if ($teachers_certificates->id->Visible) { // id ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->id) == "") { ?>
		<th data-name="id" class="<?php echo $teachers_certificates->id->HeaderCellClass() ?>"><div id="elh_teachers_certificates_id" class="teachers_certificates_id"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $teachers_certificates->id->HeaderCellClass() ?>"><div><div id="elh_teachers_certificates_id" class="teachers_certificates_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->teacher_id->Visible) { // teacher_id ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->teacher_id) == "") { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_certificates->teacher_id->HeaderCellClass() ?>"><div id="elh_teachers_certificates_teacher_id" class="teachers_certificates_teacher_id"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->teacher_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_certificates->teacher_id->HeaderCellClass() ?>"><div><div id="elh_teachers_certificates_teacher_id" class="teachers_certificates_teacher_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->teacher_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->teacher_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->teacher_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->university->Visible) { // university ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->university) == "") { ?>
		<th data-name="university" class="<?php echo $teachers_certificates->university->HeaderCellClass() ?>"><div id="elh_teachers_certificates_university" class="teachers_certificates_university"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->university->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="university" class="<?php echo $teachers_certificates->university->HeaderCellClass() ?>"><div><div id="elh_teachers_certificates_university" class="teachers_certificates_university">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->university->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->university->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->university->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->degree->Visible) { // degree ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->degree) == "") { ?>
		<th data-name="degree" class="<?php echo $teachers_certificates->degree->HeaderCellClass() ?>"><div id="elh_teachers_certificates_degree" class="teachers_certificates_degree"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->degree->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="degree" class="<?php echo $teachers_certificates->degree->HeaderCellClass() ?>"><div><div id="elh_teachers_certificates_degree" class="teachers_certificates_degree">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->degree->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->degree->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->degree->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->image->Visible) { // image ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->image) == "") { ?>
		<th data-name="image" class="<?php echo $teachers_certificates->image->HeaderCellClass() ?>"><div id="elh_teachers_certificates_image" class="teachers_certificates_image"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="image" class="<?php echo $teachers_certificates->image->HeaderCellClass() ?>"><div><div id="elh_teachers_certificates_image" class="teachers_certificates_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->image->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->from_date->Visible) { // from_date ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->from_date) == "") { ?>
		<th data-name="from_date" class="<?php echo $teachers_certificates->from_date->HeaderCellClass() ?>"><div id="elh_teachers_certificates_from_date" class="teachers_certificates_from_date"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->from_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="from_date" class="<?php echo $teachers_certificates->from_date->HeaderCellClass() ?>"><div><div id="elh_teachers_certificates_from_date" class="teachers_certificates_from_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->from_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->from_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->from_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->to_date->Visible) { // to_date ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->to_date) == "") { ?>
		<th data-name="to_date" class="<?php echo $teachers_certificates->to_date->HeaderCellClass() ?>"><div id="elh_teachers_certificates_to_date" class="teachers_certificates_to_date"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->to_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="to_date" class="<?php echo $teachers_certificates->to_date->HeaderCellClass() ?>"><div><div id="elh_teachers_certificates_to_date" class="teachers_certificates_to_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->to_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->to_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->to_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$teachers_certificates_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$teachers_certificates_grid->StartRec = 1;
$teachers_certificates_grid->StopRec = $teachers_certificates_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($teachers_certificates_grid->FormKeyCountName) && ($teachers_certificates->CurrentAction == "gridadd" || $teachers_certificates->CurrentAction == "gridedit" || $teachers_certificates->CurrentAction == "F")) {
		$teachers_certificates_grid->KeyCount = $objForm->GetValue($teachers_certificates_grid->FormKeyCountName);
		$teachers_certificates_grid->StopRec = $teachers_certificates_grid->StartRec + $teachers_certificates_grid->KeyCount - 1;
	}
}
$teachers_certificates_grid->RecCnt = $teachers_certificates_grid->StartRec - 1;
if ($teachers_certificates_grid->Recordset && !$teachers_certificates_grid->Recordset->EOF) {
	$teachers_certificates_grid->Recordset->MoveFirst();
	$bSelectLimit = $teachers_certificates_grid->UseSelectLimit;
	if (!$bSelectLimit && $teachers_certificates_grid->StartRec > 1)
		$teachers_certificates_grid->Recordset->Move($teachers_certificates_grid->StartRec - 1);
} elseif (!$teachers_certificates->AllowAddDeleteRow && $teachers_certificates_grid->StopRec == 0) {
	$teachers_certificates_grid->StopRec = $teachers_certificates->GridAddRowCount;
}

// Initialize aggregate
$teachers_certificates->RowType = EW_ROWTYPE_AGGREGATEINIT;
$teachers_certificates->ResetAttrs();
$teachers_certificates_grid->RenderRow();
if ($teachers_certificates->CurrentAction == "gridadd")
	$teachers_certificates_grid->RowIndex = 0;
if ($teachers_certificates->CurrentAction == "gridedit")
	$teachers_certificates_grid->RowIndex = 0;
while ($teachers_certificates_grid->RecCnt < $teachers_certificates_grid->StopRec) {
	$teachers_certificates_grid->RecCnt++;
	if (intval($teachers_certificates_grid->RecCnt) >= intval($teachers_certificates_grid->StartRec)) {
		$teachers_certificates_grid->RowCnt++;
		if ($teachers_certificates->CurrentAction == "gridadd" || $teachers_certificates->CurrentAction == "gridedit" || $teachers_certificates->CurrentAction == "F") {
			$teachers_certificates_grid->RowIndex++;
			$objForm->Index = $teachers_certificates_grid->RowIndex;
			if ($objForm->HasValue($teachers_certificates_grid->FormActionName))
				$teachers_certificates_grid->RowAction = strval($objForm->GetValue($teachers_certificates_grid->FormActionName));
			elseif ($teachers_certificates->CurrentAction == "gridadd")
				$teachers_certificates_grid->RowAction = "insert";
			else
				$teachers_certificates_grid->RowAction = "";
		}

		// Set up key count
		$teachers_certificates_grid->KeyCount = $teachers_certificates_grid->RowIndex;

		// Init row class and style
		$teachers_certificates->ResetAttrs();
		$teachers_certificates->CssClass = "";
		if ($teachers_certificates->CurrentAction == "gridadd") {
			if ($teachers_certificates->CurrentMode == "copy") {
				$teachers_certificates_grid->LoadRowValues($teachers_certificates_grid->Recordset); // Load row values
				$teachers_certificates_grid->SetRecordKey($teachers_certificates_grid->RowOldKey, $teachers_certificates_grid->Recordset); // Set old record key
			} else {
				$teachers_certificates_grid->LoadRowValues(); // Load default values
				$teachers_certificates_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$teachers_certificates_grid->LoadRowValues($teachers_certificates_grid->Recordset); // Load row values
		}
		$teachers_certificates->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($teachers_certificates->CurrentAction == "gridadd") // Grid add
			$teachers_certificates->RowType = EW_ROWTYPE_ADD; // Render add
		if ($teachers_certificates->CurrentAction == "gridadd" && $teachers_certificates->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$teachers_certificates_grid->RestoreCurrentRowFormValues($teachers_certificates_grid->RowIndex); // Restore form values
		if ($teachers_certificates->CurrentAction == "gridedit") { // Grid edit
			if ($teachers_certificates->EventCancelled) {
				$teachers_certificates_grid->RestoreCurrentRowFormValues($teachers_certificates_grid->RowIndex); // Restore form values
			}
			if ($teachers_certificates_grid->RowAction == "insert")
				$teachers_certificates->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$teachers_certificates->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($teachers_certificates->CurrentAction == "gridedit" && ($teachers_certificates->RowType == EW_ROWTYPE_EDIT || $teachers_certificates->RowType == EW_ROWTYPE_ADD) && $teachers_certificates->EventCancelled) // Update failed
			$teachers_certificates_grid->RestoreCurrentRowFormValues($teachers_certificates_grid->RowIndex); // Restore form values
		if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) // Edit row
			$teachers_certificates_grid->EditRowCnt++;
		if ($teachers_certificates->CurrentAction == "F") // Confirm row
			$teachers_certificates_grid->RestoreCurrentRowFormValues($teachers_certificates_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$teachers_certificates->RowAttrs = array_merge($teachers_certificates->RowAttrs, array('data-rowindex'=>$teachers_certificates_grid->RowCnt, 'id'=>'r' . $teachers_certificates_grid->RowCnt . '_teachers_certificates', 'data-rowtype'=>$teachers_certificates->RowType));

		// Render row
		$teachers_certificates_grid->RenderRow();

		// Render list options
		$teachers_certificates_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($teachers_certificates_grid->RowAction <> "delete" && $teachers_certificates_grid->RowAction <> "insertdelete" && !($teachers_certificates_grid->RowAction == "insert" && $teachers_certificates->CurrentAction == "F" && $teachers_certificates_grid->EmptyRow())) {
?>
	<tr<?php echo $teachers_certificates->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_certificates_grid->ListOptions->Render("body", "left", $teachers_certificates_grid->RowCnt);
?>
	<?php if ($teachers_certificates->id->Visible) { // id ?>
		<td data-name="id"<?php echo $teachers_certificates->id->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_id" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_id" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_certificates->id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_id" class="form-group teachers_certificates_id">
<span<?php echo $teachers_certificates->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_id" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_id" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_certificates->id->CurrentValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_id" class="teachers_certificates_id">
<span<?php echo $teachers_certificates->id->ViewAttributes() ?>>
<?php echo $teachers_certificates->id->ListViewValue() ?></span>
</span>
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_id" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_id" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_certificates->id->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_id" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_id" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_certificates->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_id" name="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_id" id="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_certificates->id->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_id" name="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_id" id="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_certificates->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_certificates->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id"<?php echo $teachers_certificates->teacher_id->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($teachers_certificates->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<span<?php echo $teachers_certificates->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<input type="text" data-table="teachers_certificates" data-field="x_teacher_id" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->teacher_id->EditValue ?>"<?php echo $teachers_certificates->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_teacher_id" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($teachers_certificates->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<span<?php echo $teachers_certificates->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<input type="text" data-table="teachers_certificates" data-field="x_teacher_id" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->teacher_id->EditValue ?>"<?php echo $teachers_certificates->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_teacher_id" class="teachers_certificates_teacher_id">
<span<?php echo $teachers_certificates->teacher_id->ViewAttributes() ?>>
<?php echo $teachers_certificates->teacher_id->ListViewValue() ?></span>
</span>
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_teacher_id" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_teacher_id" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_teacher_id" name="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" id="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_teacher_id" name="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" id="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_certificates->university->Visible) { // university ?>
		<td data-name="university"<?php echo $teachers_certificates->university->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_university" class="form-group teachers_certificates_university">
<textarea data-table="teachers_certificates" data-field="x_university" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_university" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_university" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->university->getPlaceHolder()) ?>"<?php echo $teachers_certificates->university->EditAttributes() ?>><?php echo $teachers_certificates->university->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_university" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_university" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_university" value="<?php echo ew_HtmlEncode($teachers_certificates->university->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_university" class="form-group teachers_certificates_university">
<textarea data-table="teachers_certificates" data-field="x_university" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_university" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_university" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->university->getPlaceHolder()) ?>"<?php echo $teachers_certificates->university->EditAttributes() ?>><?php echo $teachers_certificates->university->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_university" class="teachers_certificates_university">
<span<?php echo $teachers_certificates->university->ViewAttributes() ?>>
<?php echo $teachers_certificates->university->ListViewValue() ?></span>
</span>
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_university" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_university" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_university" value="<?php echo ew_HtmlEncode($teachers_certificates->university->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_university" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_university" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_university" value="<?php echo ew_HtmlEncode($teachers_certificates->university->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_university" name="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_university" id="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_university" value="<?php echo ew_HtmlEncode($teachers_certificates->university->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_university" name="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_university" id="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_university" value="<?php echo ew_HtmlEncode($teachers_certificates->university->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_certificates->degree->Visible) { // degree ?>
		<td data-name="degree"<?php echo $teachers_certificates->degree->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_degree" class="form-group teachers_certificates_degree">
<textarea data-table="teachers_certificates" data-field="x_degree" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_degree" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_degree" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->degree->getPlaceHolder()) ?>"<?php echo $teachers_certificates->degree->EditAttributes() ?>><?php echo $teachers_certificates->degree->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_degree" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_degree" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_degree" value="<?php echo ew_HtmlEncode($teachers_certificates->degree->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_degree" class="form-group teachers_certificates_degree">
<textarea data-table="teachers_certificates" data-field="x_degree" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_degree" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_degree" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->degree->getPlaceHolder()) ?>"<?php echo $teachers_certificates->degree->EditAttributes() ?>><?php echo $teachers_certificates->degree->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_degree" class="teachers_certificates_degree">
<span<?php echo $teachers_certificates->degree->ViewAttributes() ?>>
<?php echo $teachers_certificates->degree->ListViewValue() ?></span>
</span>
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_degree" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_degree" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_degree" value="<?php echo ew_HtmlEncode($teachers_certificates->degree->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_degree" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_degree" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_degree" value="<?php echo ew_HtmlEncode($teachers_certificates->degree->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_degree" name="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_degree" id="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_degree" value="<?php echo ew_HtmlEncode($teachers_certificates->degree->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_degree" name="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_degree" id="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_degree" value="<?php echo ew_HtmlEncode($teachers_certificates->degree->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_certificates->image->Visible) { // image ?>
		<td data-name="image"<?php echo $teachers_certificates->image->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_image" class="form-group teachers_certificates_image">
<textarea data-table="teachers_certificates" data-field="x_image" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_image" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->image->getPlaceHolder()) ?>"<?php echo $teachers_certificates->image->EditAttributes() ?>><?php echo $teachers_certificates->image->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_image" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_image" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_certificates->image->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_image" class="form-group teachers_certificates_image">
<textarea data-table="teachers_certificates" data-field="x_image" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_image" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->image->getPlaceHolder()) ?>"<?php echo $teachers_certificates->image->EditAttributes() ?>><?php echo $teachers_certificates->image->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_image" class="teachers_certificates_image">
<span<?php echo $teachers_certificates->image->ViewAttributes() ?>>
<?php echo $teachers_certificates->image->ListViewValue() ?></span>
</span>
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_image" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_image" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_certificates->image->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_image" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_image" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_certificates->image->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_image" name="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_image" id="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_certificates->image->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_image" name="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_image" id="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_certificates->image->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_certificates->from_date->Visible) { // from_date ?>
		<td data-name="from_date"<?php echo $teachers_certificates->from_date->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_from_date" class="form-group teachers_certificates_from_date">
<input type="text" data-table="teachers_certificates" data-field="x_from_date" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->from_date->EditValue ?>"<?php echo $teachers_certificates->from_date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_from_date" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_certificates->from_date->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_from_date" class="form-group teachers_certificates_from_date">
<input type="text" data-table="teachers_certificates" data-field="x_from_date" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->from_date->EditValue ?>"<?php echo $teachers_certificates->from_date->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_from_date" class="teachers_certificates_from_date">
<span<?php echo $teachers_certificates->from_date->ViewAttributes() ?>>
<?php echo $teachers_certificates->from_date->ListViewValue() ?></span>
</span>
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_from_date" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_certificates->from_date->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_from_date" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_certificates->from_date->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_from_date" name="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" id="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_certificates->from_date->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_from_date" name="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" id="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_certificates->from_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_certificates->to_date->Visible) { // to_date ?>
		<td data-name="to_date"<?php echo $teachers_certificates->to_date->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_to_date" class="form-group teachers_certificates_to_date">
<input type="text" data-table="teachers_certificates" data-field="x_to_date" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->to_date->EditValue ?>"<?php echo $teachers_certificates->to_date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_to_date" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_certificates->to_date->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_to_date" class="form-group teachers_certificates_to_date">
<input type="text" data-table="teachers_certificates" data-field="x_to_date" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->to_date->EditValue ?>"<?php echo $teachers_certificates->to_date->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_grid->RowCnt ?>_teachers_certificates_to_date" class="teachers_certificates_to_date">
<span<?php echo $teachers_certificates->to_date->ViewAttributes() ?>>
<?php echo $teachers_certificates->to_date->ListViewValue() ?></span>
</span>
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_to_date" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_certificates->to_date->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_to_date" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_certificates->to_date->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_to_date" name="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" id="fteachers_certificatesgrid$x<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_certificates->to_date->FormValue) ?>">
<input type="hidden" data-table="teachers_certificates" data-field="x_to_date" name="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" id="fteachers_certificatesgrid$o<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_certificates->to_date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_certificates_grid->ListOptions->Render("body", "right", $teachers_certificates_grid->RowCnt);
?>
	</tr>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD || $teachers_certificates->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fteachers_certificatesgrid.UpdateOpts(<?php echo $teachers_certificates_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($teachers_certificates->CurrentAction <> "gridadd" || $teachers_certificates->CurrentMode == "copy")
		if (!$teachers_certificates_grid->Recordset->EOF) $teachers_certificates_grid->Recordset->MoveNext();
}
?>
<?php
	if ($teachers_certificates->CurrentMode == "add" || $teachers_certificates->CurrentMode == "copy" || $teachers_certificates->CurrentMode == "edit") {
		$teachers_certificates_grid->RowIndex = '$rowindex$';
		$teachers_certificates_grid->LoadRowValues();

		// Set row properties
		$teachers_certificates->ResetAttrs();
		$teachers_certificates->RowAttrs = array_merge($teachers_certificates->RowAttrs, array('data-rowindex'=>$teachers_certificates_grid->RowIndex, 'id'=>'r0_teachers_certificates', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($teachers_certificates->RowAttrs["class"], "ewTemplate");
		$teachers_certificates->RowType = EW_ROWTYPE_ADD;

		// Render row
		$teachers_certificates_grid->RenderRow();

		// Render list options
		$teachers_certificates_grid->RenderListOptions();
		$teachers_certificates_grid->StartRowCnt = 0;
?>
	<tr<?php echo $teachers_certificates->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_certificates_grid->ListOptions->Render("body", "left", $teachers_certificates_grid->RowIndex);
?>
	<?php if ($teachers_certificates->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_certificates_id" class="form-group teachers_certificates_id">
<span<?php echo $teachers_certificates->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_id" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_id" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_certificates->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_id" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_id" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_certificates->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_certificates->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id">
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<?php if ($teachers_certificates->teacher_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<span<?php echo $teachers_certificates->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<input type="text" data-table="teachers_certificates" data-field="x_teacher_id" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->teacher_id->EditValue ?>"<?php echo $teachers_certificates->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<span<?php echo $teachers_certificates->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_teacher_id" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_teacher_id" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_certificates->university->Visible) { // university ?>
		<td data-name="university">
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_certificates_university" class="form-group teachers_certificates_university">
<textarea data-table="teachers_certificates" data-field="x_university" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_university" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_university" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->university->getPlaceHolder()) ?>"<?php echo $teachers_certificates->university->EditAttributes() ?>><?php echo $teachers_certificates->university->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_certificates_university" class="form-group teachers_certificates_university">
<span<?php echo $teachers_certificates->university->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->university->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_university" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_university" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_university" value="<?php echo ew_HtmlEncode($teachers_certificates->university->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_university" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_university" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_university" value="<?php echo ew_HtmlEncode($teachers_certificates->university->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_certificates->degree->Visible) { // degree ?>
		<td data-name="degree">
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_certificates_degree" class="form-group teachers_certificates_degree">
<textarea data-table="teachers_certificates" data-field="x_degree" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_degree" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_degree" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->degree->getPlaceHolder()) ?>"<?php echo $teachers_certificates->degree->EditAttributes() ?>><?php echo $teachers_certificates->degree->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_certificates_degree" class="form-group teachers_certificates_degree">
<span<?php echo $teachers_certificates->degree->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->degree->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_degree" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_degree" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_degree" value="<?php echo ew_HtmlEncode($teachers_certificates->degree->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_degree" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_degree" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_degree" value="<?php echo ew_HtmlEncode($teachers_certificates->degree->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_certificates->image->Visible) { // image ?>
		<td data-name="image">
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_certificates_image" class="form-group teachers_certificates_image">
<textarea data-table="teachers_certificates" data-field="x_image" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_image" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->image->getPlaceHolder()) ?>"<?php echo $teachers_certificates->image->EditAttributes() ?>><?php echo $teachers_certificates->image->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_certificates_image" class="form-group teachers_certificates_image">
<span<?php echo $teachers_certificates->image->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->image->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_image" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_image" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_certificates->image->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_image" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_image" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_certificates->image->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_certificates->from_date->Visible) { // from_date ?>
		<td data-name="from_date">
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_certificates_from_date" class="form-group teachers_certificates_from_date">
<input type="text" data-table="teachers_certificates" data-field="x_from_date" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->from_date->EditValue ?>"<?php echo $teachers_certificates->from_date->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_certificates_from_date" class="form-group teachers_certificates_from_date">
<span<?php echo $teachers_certificates->from_date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->from_date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_from_date" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_certificates->from_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_from_date" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_certificates->from_date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_certificates->to_date->Visible) { // to_date ?>
		<td data-name="to_date">
<?php if ($teachers_certificates->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_certificates_to_date" class="form-group teachers_certificates_to_date">
<input type="text" data-table="teachers_certificates" data-field="x_to_date" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->to_date->EditValue ?>"<?php echo $teachers_certificates->to_date->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_certificates_to_date" class="form-group teachers_certificates_to_date">
<span<?php echo $teachers_certificates->to_date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->to_date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_to_date" name="x<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" id="x<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_certificates->to_date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_to_date" name="o<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" id="o<?php echo $teachers_certificates_grid->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_certificates->to_date->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_certificates_grid->ListOptions->Render("body", "right", $teachers_certificates_grid->RowIndex);
?>
<script type="text/javascript">
fteachers_certificatesgrid.UpdateOpts(<?php echo $teachers_certificates_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($teachers_certificates->CurrentMode == "add" || $teachers_certificates->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $teachers_certificates_grid->FormKeyCountName ?>" id="<?php echo $teachers_certificates_grid->FormKeyCountName ?>" value="<?php echo $teachers_certificates_grid->KeyCount ?>">
<?php echo $teachers_certificates_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_certificates->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $teachers_certificates_grid->FormKeyCountName ?>" id="<?php echo $teachers_certificates_grid->FormKeyCountName ?>" value="<?php echo $teachers_certificates_grid->KeyCount ?>">
<?php echo $teachers_certificates_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_certificates->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fteachers_certificatesgrid">
</div>
<?php

// Close recordset
if ($teachers_certificates_grid->Recordset)
	$teachers_certificates_grid->Recordset->Close();
?>
<?php if ($teachers_certificates_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($teachers_certificates_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($teachers_certificates_grid->TotalRecs == 0 && $teachers_certificates->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_certificates_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($teachers_certificates->Export == "") { ?>
<script type="text/javascript">
fteachers_certificatesgrid.Init();
</script>
<?php } ?>
<?php
$teachers_certificates_grid->Page_Terminate();
?>
