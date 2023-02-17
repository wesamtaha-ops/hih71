<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($students_grid)) $students_grid = new cstudents_grid();

// Page init
$students_grid->Page_Init();

// Page main
$students_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$students_grid->Page_Render();
?>
<?php if ($students->Export == "") { ?>
<script type="text/javascript">

// Form object
var fstudentsgrid = new ew_Form("fstudentsgrid", "grid");
fstudentsgrid.FormKeyCountName = '<?php echo $students_grid->FormKeyCountName ?>';

// Validate form
fstudentsgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_user_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $students->user_id->FldCaption(), $students->user_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_user_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->user_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_is_parent");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $students->is_parent->FldCaption(), $students->is_parent->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_is_parent");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->is_parent->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_level_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->level_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_language_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->language_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_langauge_level_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->langauge_level_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $students->created_at->FldCaption(), $students->created_at->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->created_at->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_updated_at");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $students->updated_at->FldCaption(), $students->updated_at->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_updated_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->updated_at->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fstudentsgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "user_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "is_parent", false)) return false;
	if (ew_ValueChanged(fobj, infix, "level_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "study_year", false)) return false;
	if (ew_ValueChanged(fobj, infix, "language_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "langauge_level_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "created_at", false)) return false;
	if (ew_ValueChanged(fobj, infix, "updated_at", false)) return false;
	return true;
}

// Form_CustomValidate event
fstudentsgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fstudentsgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fstudentsgrid.Lists["x_study_year"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fstudentsgrid.Lists["x_study_year"].Options = <?php echo json_encode($students_grid->study_year->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($students->CurrentAction == "gridadd") {
	if ($students->CurrentMode == "copy") {
		$bSelectLimit = $students_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$students_grid->TotalRecs = $students->ListRecordCount();
			$students_grid->Recordset = $students_grid->LoadRecordset($students_grid->StartRec-1, $students_grid->DisplayRecs);
		} else {
			if ($students_grid->Recordset = $students_grid->LoadRecordset())
				$students_grid->TotalRecs = $students_grid->Recordset->RecordCount();
		}
		$students_grid->StartRec = 1;
		$students_grid->DisplayRecs = $students_grid->TotalRecs;
	} else {
		$students->CurrentFilter = "0=1";
		$students_grid->StartRec = 1;
		$students_grid->DisplayRecs = $students->GridAddRowCount;
	}
	$students_grid->TotalRecs = $students_grid->DisplayRecs;
	$students_grid->StopRec = $students_grid->DisplayRecs;
} else {
	$bSelectLimit = $students_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($students_grid->TotalRecs <= 0)
			$students_grid->TotalRecs = $students->ListRecordCount();
	} else {
		if (!$students_grid->Recordset && ($students_grid->Recordset = $students_grid->LoadRecordset()))
			$students_grid->TotalRecs = $students_grid->Recordset->RecordCount();
	}
	$students_grid->StartRec = 1;
	$students_grid->DisplayRecs = $students_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$students_grid->Recordset = $students_grid->LoadRecordset($students_grid->StartRec-1, $students_grid->DisplayRecs);

	// Set no record found message
	if ($students->CurrentAction == "" && $students_grid->TotalRecs == 0) {
		if ($students_grid->SearchWhere == "0=101")
			$students_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$students_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$students_grid->RenderOtherOptions();
?>
<?php $students_grid->ShowPageHeader(); ?>
<?php
$students_grid->ShowMessage();
?>
<?php if ($students_grid->TotalRecs > 0 || $students->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($students_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> students">
<div id="fstudentsgrid" class="ewForm ewListForm form-inline">
<?php if ($students_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($students_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_students" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_studentsgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$students_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$students_grid->RenderListOptions();

// Render list options (header, left)
$students_grid->ListOptions->Render("header", "left");
?>
<?php if ($students->user_id->Visible) { // user_id ?>
	<?php if ($students->SortUrl($students->user_id) == "") { ?>
		<th data-name="user_id" class="<?php echo $students->user_id->HeaderCellClass() ?>"><div id="elh_students_user_id" class="students_user_id"><div class="ewTableHeaderCaption"><?php echo $students->user_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user_id" class="<?php echo $students->user_id->HeaderCellClass() ?>"><div><div id="elh_students_user_id" class="students_user_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->user_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->user_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->user_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->is_parent->Visible) { // is_parent ?>
	<?php if ($students->SortUrl($students->is_parent) == "") { ?>
		<th data-name="is_parent" class="<?php echo $students->is_parent->HeaderCellClass() ?>"><div id="elh_students_is_parent" class="students_is_parent"><div class="ewTableHeaderCaption"><?php echo $students->is_parent->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="is_parent" class="<?php echo $students->is_parent->HeaderCellClass() ?>"><div><div id="elh_students_is_parent" class="students_is_parent">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->is_parent->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->is_parent->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->is_parent->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->level_id->Visible) { // level_id ?>
	<?php if ($students->SortUrl($students->level_id) == "") { ?>
		<th data-name="level_id" class="<?php echo $students->level_id->HeaderCellClass() ?>"><div id="elh_students_level_id" class="students_level_id"><div class="ewTableHeaderCaption"><?php echo $students->level_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="level_id" class="<?php echo $students->level_id->HeaderCellClass() ?>"><div><div id="elh_students_level_id" class="students_level_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->level_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->level_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->level_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->study_year->Visible) { // study_year ?>
	<?php if ($students->SortUrl($students->study_year) == "") { ?>
		<th data-name="study_year" class="<?php echo $students->study_year->HeaderCellClass() ?>"><div id="elh_students_study_year" class="students_study_year"><div class="ewTableHeaderCaption"><?php echo $students->study_year->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="study_year" class="<?php echo $students->study_year->HeaderCellClass() ?>"><div><div id="elh_students_study_year" class="students_study_year">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->study_year->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->study_year->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->study_year->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->language_id->Visible) { // language_id ?>
	<?php if ($students->SortUrl($students->language_id) == "") { ?>
		<th data-name="language_id" class="<?php echo $students->language_id->HeaderCellClass() ?>"><div id="elh_students_language_id" class="students_language_id"><div class="ewTableHeaderCaption"><?php echo $students->language_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="language_id" class="<?php echo $students->language_id->HeaderCellClass() ?>"><div><div id="elh_students_language_id" class="students_language_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->language_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->language_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->language_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->langauge_level_id->Visible) { // langauge_level_id ?>
	<?php if ($students->SortUrl($students->langauge_level_id) == "") { ?>
		<th data-name="langauge_level_id" class="<?php echo $students->langauge_level_id->HeaderCellClass() ?>"><div id="elh_students_langauge_level_id" class="students_langauge_level_id"><div class="ewTableHeaderCaption"><?php echo $students->langauge_level_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="langauge_level_id" class="<?php echo $students->langauge_level_id->HeaderCellClass() ?>"><div><div id="elh_students_langauge_level_id" class="students_langauge_level_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->langauge_level_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->langauge_level_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->langauge_level_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->created_at->Visible) { // created_at ?>
	<?php if ($students->SortUrl($students->created_at) == "") { ?>
		<th data-name="created_at" class="<?php echo $students->created_at->HeaderCellClass() ?>"><div id="elh_students_created_at" class="students_created_at"><div class="ewTableHeaderCaption"><?php echo $students->created_at->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="created_at" class="<?php echo $students->created_at->HeaderCellClass() ?>"><div><div id="elh_students_created_at" class="students_created_at">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->created_at->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->created_at->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->created_at->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->updated_at->Visible) { // updated_at ?>
	<?php if ($students->SortUrl($students->updated_at) == "") { ?>
		<th data-name="updated_at" class="<?php echo $students->updated_at->HeaderCellClass() ?>"><div id="elh_students_updated_at" class="students_updated_at"><div class="ewTableHeaderCaption"><?php echo $students->updated_at->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="updated_at" class="<?php echo $students->updated_at->HeaderCellClass() ?>"><div><div id="elh_students_updated_at" class="students_updated_at">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->updated_at->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->updated_at->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->updated_at->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$students_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$students_grid->StartRec = 1;
$students_grid->StopRec = $students_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($students_grid->FormKeyCountName) && ($students->CurrentAction == "gridadd" || $students->CurrentAction == "gridedit" || $students->CurrentAction == "F")) {
		$students_grid->KeyCount = $objForm->GetValue($students_grid->FormKeyCountName);
		$students_grid->StopRec = $students_grid->StartRec + $students_grid->KeyCount - 1;
	}
}
$students_grid->RecCnt = $students_grid->StartRec - 1;
if ($students_grid->Recordset && !$students_grid->Recordset->EOF) {
	$students_grid->Recordset->MoveFirst();
	$bSelectLimit = $students_grid->UseSelectLimit;
	if (!$bSelectLimit && $students_grid->StartRec > 1)
		$students_grid->Recordset->Move($students_grid->StartRec - 1);
} elseif (!$students->AllowAddDeleteRow && $students_grid->StopRec == 0) {
	$students_grid->StopRec = $students->GridAddRowCount;
}

// Initialize aggregate
$students->RowType = EW_ROWTYPE_AGGREGATEINIT;
$students->ResetAttrs();
$students_grid->RenderRow();
if ($students->CurrentAction == "gridadd")
	$students_grid->RowIndex = 0;
if ($students->CurrentAction == "gridedit")
	$students_grid->RowIndex = 0;
while ($students_grid->RecCnt < $students_grid->StopRec) {
	$students_grid->RecCnt++;
	if (intval($students_grid->RecCnt) >= intval($students_grid->StartRec)) {
		$students_grid->RowCnt++;
		if ($students->CurrentAction == "gridadd" || $students->CurrentAction == "gridedit" || $students->CurrentAction == "F") {
			$students_grid->RowIndex++;
			$objForm->Index = $students_grid->RowIndex;
			if ($objForm->HasValue($students_grid->FormActionName))
				$students_grid->RowAction = strval($objForm->GetValue($students_grid->FormActionName));
			elseif ($students->CurrentAction == "gridadd")
				$students_grid->RowAction = "insert";
			else
				$students_grid->RowAction = "";
		}

		// Set up key count
		$students_grid->KeyCount = $students_grid->RowIndex;

		// Init row class and style
		$students->ResetAttrs();
		$students->CssClass = "";
		if ($students->CurrentAction == "gridadd") {
			if ($students->CurrentMode == "copy") {
				$students_grid->LoadRowValues($students_grid->Recordset); // Load row values
				$students_grid->SetRecordKey($students_grid->RowOldKey, $students_grid->Recordset); // Set old record key
			} else {
				$students_grid->LoadRowValues(); // Load default values
				$students_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$students_grid->LoadRowValues($students_grid->Recordset); // Load row values
		}
		$students->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($students->CurrentAction == "gridadd") // Grid add
			$students->RowType = EW_ROWTYPE_ADD; // Render add
		if ($students->CurrentAction == "gridadd" && $students->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$students_grid->RestoreCurrentRowFormValues($students_grid->RowIndex); // Restore form values
		if ($students->CurrentAction == "gridedit") { // Grid edit
			if ($students->EventCancelled) {
				$students_grid->RestoreCurrentRowFormValues($students_grid->RowIndex); // Restore form values
			}
			if ($students_grid->RowAction == "insert")
				$students->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$students->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($students->CurrentAction == "gridedit" && ($students->RowType == EW_ROWTYPE_EDIT || $students->RowType == EW_ROWTYPE_ADD) && $students->EventCancelled) // Update failed
			$students_grid->RestoreCurrentRowFormValues($students_grid->RowIndex); // Restore form values
		if ($students->RowType == EW_ROWTYPE_EDIT) // Edit row
			$students_grid->EditRowCnt++;
		if ($students->CurrentAction == "F") // Confirm row
			$students_grid->RestoreCurrentRowFormValues($students_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$students->RowAttrs = array_merge($students->RowAttrs, array('data-rowindex'=>$students_grid->RowCnt, 'id'=>'r' . $students_grid->RowCnt . '_students', 'data-rowtype'=>$students->RowType));

		// Render row
		$students_grid->RenderRow();

		// Render list options
		$students_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($students_grid->RowAction <> "delete" && $students_grid->RowAction <> "insertdelete" && !($students_grid->RowAction == "insert" && $students->CurrentAction == "F" && $students_grid->EmptyRow())) {
?>
	<tr<?php echo $students->RowAttributes() ?>>
<?php

// Render list options (body, left)
$students_grid->ListOptions->Render("body", "left", $students_grid->RowCnt);
?>
	<?php if ($students->user_id->Visible) { // user_id ?>
		<td data-name="user_id"<?php echo $students->user_id->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($students->user_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_user_id" class="form-group students_user_id">
<span<?php echo $students->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $students_grid->RowIndex ?>_user_id" name="x<?php echo $students_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_user_id" class="form-group students_user_id">
<input type="text" data-table="students" data-field="x_user_id" name="x<?php echo $students_grid->RowIndex ?>_user_id" id="x<?php echo $students_grid->RowIndex ?>_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->user_id->getPlaceHolder()) ?>" value="<?php echo $students->user_id->EditValue ?>"<?php echo $students->user_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="students" data-field="x_user_id" name="o<?php echo $students_grid->RowIndex ?>_user_id" id="o<?php echo $students_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($students->user_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_user_id" class="form-group students_user_id">
<span<?php echo $students->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $students_grid->RowIndex ?>_user_id" name="x<?php echo $students_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_user_id" class="form-group students_user_id">
<input type="text" data-table="students" data-field="x_user_id" name="x<?php echo $students_grid->RowIndex ?>_user_id" id="x<?php echo $students_grid->RowIndex ?>_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->user_id->getPlaceHolder()) ?>" value="<?php echo $students->user_id->EditValue ?>"<?php echo $students->user_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_user_id" class="students_user_id">
<span<?php echo $students->user_id->ViewAttributes() ?>>
<?php echo $students->user_id->ListViewValue() ?></span>
</span>
<?php if ($students->CurrentAction <> "F") { ?>
<input type="hidden" data-table="students" data-field="x_user_id" name="x<?php echo $students_grid->RowIndex ?>_user_id" id="x<?php echo $students_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_user_id" name="o<?php echo $students_grid->RowIndex ?>_user_id" id="o<?php echo $students_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="students" data-field="x_user_id" name="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_user_id" id="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_user_id" name="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_user_id" id="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->is_parent->Visible) { // is_parent ?>
		<td data-name="is_parent"<?php echo $students->is_parent->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_is_parent" class="form-group students_is_parent">
<input type="text" data-table="students" data-field="x_is_parent" name="x<?php echo $students_grid->RowIndex ?>_is_parent" id="x<?php echo $students_grid->RowIndex ?>_is_parent" size="30" placeholder="<?php echo ew_HtmlEncode($students->is_parent->getPlaceHolder()) ?>" value="<?php echo $students->is_parent->EditValue ?>"<?php echo $students->is_parent->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_is_parent" name="o<?php echo $students_grid->RowIndex ?>_is_parent" id="o<?php echo $students_grid->RowIndex ?>_is_parent" value="<?php echo ew_HtmlEncode($students->is_parent->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_is_parent" class="form-group students_is_parent">
<input type="text" data-table="students" data-field="x_is_parent" name="x<?php echo $students_grid->RowIndex ?>_is_parent" id="x<?php echo $students_grid->RowIndex ?>_is_parent" size="30" placeholder="<?php echo ew_HtmlEncode($students->is_parent->getPlaceHolder()) ?>" value="<?php echo $students->is_parent->EditValue ?>"<?php echo $students->is_parent->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_is_parent" class="students_is_parent">
<span<?php echo $students->is_parent->ViewAttributes() ?>>
<?php echo $students->is_parent->ListViewValue() ?></span>
</span>
<?php if ($students->CurrentAction <> "F") { ?>
<input type="hidden" data-table="students" data-field="x_is_parent" name="x<?php echo $students_grid->RowIndex ?>_is_parent" id="x<?php echo $students_grid->RowIndex ?>_is_parent" value="<?php echo ew_HtmlEncode($students->is_parent->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_is_parent" name="o<?php echo $students_grid->RowIndex ?>_is_parent" id="o<?php echo $students_grid->RowIndex ?>_is_parent" value="<?php echo ew_HtmlEncode($students->is_parent->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="students" data-field="x_is_parent" name="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_is_parent" id="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_is_parent" value="<?php echo ew_HtmlEncode($students->is_parent->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_is_parent" name="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_is_parent" id="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_is_parent" value="<?php echo ew_HtmlEncode($students->is_parent->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->level_id->Visible) { // level_id ?>
		<td data-name="level_id"<?php echo $students->level_id->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_level_id" class="form-group students_level_id">
<input type="text" data-table="students" data-field="x_level_id" name="x<?php echo $students_grid->RowIndex ?>_level_id" id="x<?php echo $students_grid->RowIndex ?>_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->level_id->getPlaceHolder()) ?>" value="<?php echo $students->level_id->EditValue ?>"<?php echo $students->level_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_level_id" name="o<?php echo $students_grid->RowIndex ?>_level_id" id="o<?php echo $students_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($students->level_id->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_level_id" class="form-group students_level_id">
<input type="text" data-table="students" data-field="x_level_id" name="x<?php echo $students_grid->RowIndex ?>_level_id" id="x<?php echo $students_grid->RowIndex ?>_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->level_id->getPlaceHolder()) ?>" value="<?php echo $students->level_id->EditValue ?>"<?php echo $students->level_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_level_id" class="students_level_id">
<span<?php echo $students->level_id->ViewAttributes() ?>>
<?php echo $students->level_id->ListViewValue() ?></span>
</span>
<?php if ($students->CurrentAction <> "F") { ?>
<input type="hidden" data-table="students" data-field="x_level_id" name="x<?php echo $students_grid->RowIndex ?>_level_id" id="x<?php echo $students_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($students->level_id->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_level_id" name="o<?php echo $students_grid->RowIndex ?>_level_id" id="o<?php echo $students_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($students->level_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="students" data-field="x_level_id" name="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_level_id" id="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($students->level_id->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_level_id" name="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_level_id" id="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($students->level_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->study_year->Visible) { // study_year ?>
		<td data-name="study_year"<?php echo $students->study_year->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_study_year" class="form-group students_study_year">
<div id="tp_x<?php echo $students_grid->RowIndex ?>_study_year" class="ewTemplate"><input type="radio" data-table="students" data-field="x_study_year" data-value-separator="<?php echo $students->study_year->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $students_grid->RowIndex ?>_study_year" id="x<?php echo $students_grid->RowIndex ?>_study_year" value="{value}"<?php echo $students->study_year->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $students_grid->RowIndex ?>_study_year" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $students->study_year->RadioButtonListHtml(FALSE, "x{$students_grid->RowIndex}_study_year") ?>
</div></div>
</span>
<input type="hidden" data-table="students" data-field="x_study_year" name="o<?php echo $students_grid->RowIndex ?>_study_year" id="o<?php echo $students_grid->RowIndex ?>_study_year" value="<?php echo ew_HtmlEncode($students->study_year->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_study_year" class="form-group students_study_year">
<div id="tp_x<?php echo $students_grid->RowIndex ?>_study_year" class="ewTemplate"><input type="radio" data-table="students" data-field="x_study_year" data-value-separator="<?php echo $students->study_year->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $students_grid->RowIndex ?>_study_year" id="x<?php echo $students_grid->RowIndex ?>_study_year" value="{value}"<?php echo $students->study_year->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $students_grid->RowIndex ?>_study_year" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $students->study_year->RadioButtonListHtml(FALSE, "x{$students_grid->RowIndex}_study_year") ?>
</div></div>
</span>
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_study_year" class="students_study_year">
<span<?php echo $students->study_year->ViewAttributes() ?>>
<?php echo $students->study_year->ListViewValue() ?></span>
</span>
<?php if ($students->CurrentAction <> "F") { ?>
<input type="hidden" data-table="students" data-field="x_study_year" name="x<?php echo $students_grid->RowIndex ?>_study_year" id="x<?php echo $students_grid->RowIndex ?>_study_year" value="<?php echo ew_HtmlEncode($students->study_year->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_study_year" name="o<?php echo $students_grid->RowIndex ?>_study_year" id="o<?php echo $students_grid->RowIndex ?>_study_year" value="<?php echo ew_HtmlEncode($students->study_year->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="students" data-field="x_study_year" name="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_study_year" id="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_study_year" value="<?php echo ew_HtmlEncode($students->study_year->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_study_year" name="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_study_year" id="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_study_year" value="<?php echo ew_HtmlEncode($students->study_year->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->language_id->Visible) { // language_id ?>
		<td data-name="language_id"<?php echo $students->language_id->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_language_id" class="form-group students_language_id">
<input type="text" data-table="students" data-field="x_language_id" name="x<?php echo $students_grid->RowIndex ?>_language_id" id="x<?php echo $students_grid->RowIndex ?>_language_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->language_id->getPlaceHolder()) ?>" value="<?php echo $students->language_id->EditValue ?>"<?php echo $students->language_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_language_id" name="o<?php echo $students_grid->RowIndex ?>_language_id" id="o<?php echo $students_grid->RowIndex ?>_language_id" value="<?php echo ew_HtmlEncode($students->language_id->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_language_id" class="form-group students_language_id">
<input type="text" data-table="students" data-field="x_language_id" name="x<?php echo $students_grid->RowIndex ?>_language_id" id="x<?php echo $students_grid->RowIndex ?>_language_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->language_id->getPlaceHolder()) ?>" value="<?php echo $students->language_id->EditValue ?>"<?php echo $students->language_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_language_id" class="students_language_id">
<span<?php echo $students->language_id->ViewAttributes() ?>>
<?php echo $students->language_id->ListViewValue() ?></span>
</span>
<?php if ($students->CurrentAction <> "F") { ?>
<input type="hidden" data-table="students" data-field="x_language_id" name="x<?php echo $students_grid->RowIndex ?>_language_id" id="x<?php echo $students_grid->RowIndex ?>_language_id" value="<?php echo ew_HtmlEncode($students->language_id->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_language_id" name="o<?php echo $students_grid->RowIndex ?>_language_id" id="o<?php echo $students_grid->RowIndex ?>_language_id" value="<?php echo ew_HtmlEncode($students->language_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="students" data-field="x_language_id" name="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_language_id" id="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_language_id" value="<?php echo ew_HtmlEncode($students->language_id->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_language_id" name="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_language_id" id="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_language_id" value="<?php echo ew_HtmlEncode($students->language_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->langauge_level_id->Visible) { // langauge_level_id ?>
		<td data-name="langauge_level_id"<?php echo $students->langauge_level_id->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_langauge_level_id" class="form-group students_langauge_level_id">
<input type="text" data-table="students" data-field="x_langauge_level_id" name="x<?php echo $students_grid->RowIndex ?>_langauge_level_id" id="x<?php echo $students_grid->RowIndex ?>_langauge_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->langauge_level_id->getPlaceHolder()) ?>" value="<?php echo $students->langauge_level_id->EditValue ?>"<?php echo $students->langauge_level_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_langauge_level_id" name="o<?php echo $students_grid->RowIndex ?>_langauge_level_id" id="o<?php echo $students_grid->RowIndex ?>_langauge_level_id" value="<?php echo ew_HtmlEncode($students->langauge_level_id->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_langauge_level_id" class="form-group students_langauge_level_id">
<input type="text" data-table="students" data-field="x_langauge_level_id" name="x<?php echo $students_grid->RowIndex ?>_langauge_level_id" id="x<?php echo $students_grid->RowIndex ?>_langauge_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->langauge_level_id->getPlaceHolder()) ?>" value="<?php echo $students->langauge_level_id->EditValue ?>"<?php echo $students->langauge_level_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_langauge_level_id" class="students_langauge_level_id">
<span<?php echo $students->langauge_level_id->ViewAttributes() ?>>
<?php echo $students->langauge_level_id->ListViewValue() ?></span>
</span>
<?php if ($students->CurrentAction <> "F") { ?>
<input type="hidden" data-table="students" data-field="x_langauge_level_id" name="x<?php echo $students_grid->RowIndex ?>_langauge_level_id" id="x<?php echo $students_grid->RowIndex ?>_langauge_level_id" value="<?php echo ew_HtmlEncode($students->langauge_level_id->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_langauge_level_id" name="o<?php echo $students_grid->RowIndex ?>_langauge_level_id" id="o<?php echo $students_grid->RowIndex ?>_langauge_level_id" value="<?php echo ew_HtmlEncode($students->langauge_level_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="students" data-field="x_langauge_level_id" name="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_langauge_level_id" id="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_langauge_level_id" value="<?php echo ew_HtmlEncode($students->langauge_level_id->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_langauge_level_id" name="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_langauge_level_id" id="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_langauge_level_id" value="<?php echo ew_HtmlEncode($students->langauge_level_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->created_at->Visible) { // created_at ?>
		<td data-name="created_at"<?php echo $students->created_at->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_created_at" class="form-group students_created_at">
<input type="text" data-table="students" data-field="x_created_at" name="x<?php echo $students_grid->RowIndex ?>_created_at" id="x<?php echo $students_grid->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($students->created_at->getPlaceHolder()) ?>" value="<?php echo $students->created_at->EditValue ?>"<?php echo $students->created_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_created_at" name="o<?php echo $students_grid->RowIndex ?>_created_at" id="o<?php echo $students_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($students->created_at->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_created_at" class="form-group students_created_at">
<input type="text" data-table="students" data-field="x_created_at" name="x<?php echo $students_grid->RowIndex ?>_created_at" id="x<?php echo $students_grid->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($students->created_at->getPlaceHolder()) ?>" value="<?php echo $students->created_at->EditValue ?>"<?php echo $students->created_at->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_created_at" class="students_created_at">
<span<?php echo $students->created_at->ViewAttributes() ?>>
<?php echo $students->created_at->ListViewValue() ?></span>
</span>
<?php if ($students->CurrentAction <> "F") { ?>
<input type="hidden" data-table="students" data-field="x_created_at" name="x<?php echo $students_grid->RowIndex ?>_created_at" id="x<?php echo $students_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($students->created_at->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_created_at" name="o<?php echo $students_grid->RowIndex ?>_created_at" id="o<?php echo $students_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($students->created_at->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="students" data-field="x_created_at" name="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_created_at" id="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($students->created_at->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_created_at" name="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_created_at" id="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($students->created_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->updated_at->Visible) { // updated_at ?>
		<td data-name="updated_at"<?php echo $students->updated_at->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_updated_at" class="form-group students_updated_at">
<input type="text" data-table="students" data-field="x_updated_at" name="x<?php echo $students_grid->RowIndex ?>_updated_at" id="x<?php echo $students_grid->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($students->updated_at->getPlaceHolder()) ?>" value="<?php echo $students->updated_at->EditValue ?>"<?php echo $students->updated_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_updated_at" name="o<?php echo $students_grid->RowIndex ?>_updated_at" id="o<?php echo $students_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($students->updated_at->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_updated_at" class="form-group students_updated_at">
<input type="text" data-table="students" data-field="x_updated_at" name="x<?php echo $students_grid->RowIndex ?>_updated_at" id="x<?php echo $students_grid->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($students->updated_at->getPlaceHolder()) ?>" value="<?php echo $students->updated_at->EditValue ?>"<?php echo $students->updated_at->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_grid->RowCnt ?>_students_updated_at" class="students_updated_at">
<span<?php echo $students->updated_at->ViewAttributes() ?>>
<?php echo $students->updated_at->ListViewValue() ?></span>
</span>
<?php if ($students->CurrentAction <> "F") { ?>
<input type="hidden" data-table="students" data-field="x_updated_at" name="x<?php echo $students_grid->RowIndex ?>_updated_at" id="x<?php echo $students_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($students->updated_at->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_updated_at" name="o<?php echo $students_grid->RowIndex ?>_updated_at" id="o<?php echo $students_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($students->updated_at->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="students" data-field="x_updated_at" name="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_updated_at" id="fstudentsgrid$x<?php echo $students_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($students->updated_at->FormValue) ?>">
<input type="hidden" data-table="students" data-field="x_updated_at" name="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_updated_at" id="fstudentsgrid$o<?php echo $students_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($students->updated_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$students_grid->ListOptions->Render("body", "right", $students_grid->RowCnt);
?>
	</tr>
<?php if ($students->RowType == EW_ROWTYPE_ADD || $students->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fstudentsgrid.UpdateOpts(<?php echo $students_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($students->CurrentAction <> "gridadd" || $students->CurrentMode == "copy")
		if (!$students_grid->Recordset->EOF) $students_grid->Recordset->MoveNext();
}
?>
<?php
	if ($students->CurrentMode == "add" || $students->CurrentMode == "copy" || $students->CurrentMode == "edit") {
		$students_grid->RowIndex = '$rowindex$';
		$students_grid->LoadRowValues();

		// Set row properties
		$students->ResetAttrs();
		$students->RowAttrs = array_merge($students->RowAttrs, array('data-rowindex'=>$students_grid->RowIndex, 'id'=>'r0_students', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($students->RowAttrs["class"], "ewTemplate");
		$students->RowType = EW_ROWTYPE_ADD;

		// Render row
		$students_grid->RenderRow();

		// Render list options
		$students_grid->RenderListOptions();
		$students_grid->StartRowCnt = 0;
?>
	<tr<?php echo $students->RowAttributes() ?>>
<?php

// Render list options (body, left)
$students_grid->ListOptions->Render("body", "left", $students_grid->RowIndex);
?>
	<?php if ($students->user_id->Visible) { // user_id ?>
		<td data-name="user_id">
<?php if ($students->CurrentAction <> "F") { ?>
<?php if ($students->user_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_students_user_id" class="form-group students_user_id">
<span<?php echo $students->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $students_grid->RowIndex ?>_user_id" name="x<?php echo $students_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_students_user_id" class="form-group students_user_id">
<input type="text" data-table="students" data-field="x_user_id" name="x<?php echo $students_grid->RowIndex ?>_user_id" id="x<?php echo $students_grid->RowIndex ?>_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->user_id->getPlaceHolder()) ?>" value="<?php echo $students->user_id->EditValue ?>"<?php echo $students->user_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_students_user_id" class="form-group students_user_id">
<span<?php echo $students->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="students" data-field="x_user_id" name="x<?php echo $students_grid->RowIndex ?>_user_id" id="x<?php echo $students_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="students" data-field="x_user_id" name="o<?php echo $students_grid->RowIndex ?>_user_id" id="o<?php echo $students_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->is_parent->Visible) { // is_parent ?>
		<td data-name="is_parent">
<?php if ($students->CurrentAction <> "F") { ?>
<span id="el$rowindex$_students_is_parent" class="form-group students_is_parent">
<input type="text" data-table="students" data-field="x_is_parent" name="x<?php echo $students_grid->RowIndex ?>_is_parent" id="x<?php echo $students_grid->RowIndex ?>_is_parent" size="30" placeholder="<?php echo ew_HtmlEncode($students->is_parent->getPlaceHolder()) ?>" value="<?php echo $students->is_parent->EditValue ?>"<?php echo $students->is_parent->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_students_is_parent" class="form-group students_is_parent">
<span<?php echo $students->is_parent->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->is_parent->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="students" data-field="x_is_parent" name="x<?php echo $students_grid->RowIndex ?>_is_parent" id="x<?php echo $students_grid->RowIndex ?>_is_parent" value="<?php echo ew_HtmlEncode($students->is_parent->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="students" data-field="x_is_parent" name="o<?php echo $students_grid->RowIndex ?>_is_parent" id="o<?php echo $students_grid->RowIndex ?>_is_parent" value="<?php echo ew_HtmlEncode($students->is_parent->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->level_id->Visible) { // level_id ?>
		<td data-name="level_id">
<?php if ($students->CurrentAction <> "F") { ?>
<span id="el$rowindex$_students_level_id" class="form-group students_level_id">
<input type="text" data-table="students" data-field="x_level_id" name="x<?php echo $students_grid->RowIndex ?>_level_id" id="x<?php echo $students_grid->RowIndex ?>_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->level_id->getPlaceHolder()) ?>" value="<?php echo $students->level_id->EditValue ?>"<?php echo $students->level_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_students_level_id" class="form-group students_level_id">
<span<?php echo $students->level_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->level_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="students" data-field="x_level_id" name="x<?php echo $students_grid->RowIndex ?>_level_id" id="x<?php echo $students_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($students->level_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="students" data-field="x_level_id" name="o<?php echo $students_grid->RowIndex ?>_level_id" id="o<?php echo $students_grid->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($students->level_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->study_year->Visible) { // study_year ?>
		<td data-name="study_year">
<?php if ($students->CurrentAction <> "F") { ?>
<span id="el$rowindex$_students_study_year" class="form-group students_study_year">
<div id="tp_x<?php echo $students_grid->RowIndex ?>_study_year" class="ewTemplate"><input type="radio" data-table="students" data-field="x_study_year" data-value-separator="<?php echo $students->study_year->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $students_grid->RowIndex ?>_study_year" id="x<?php echo $students_grid->RowIndex ?>_study_year" value="{value}"<?php echo $students->study_year->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $students_grid->RowIndex ?>_study_year" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $students->study_year->RadioButtonListHtml(FALSE, "x{$students_grid->RowIndex}_study_year") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_students_study_year" class="form-group students_study_year">
<span<?php echo $students->study_year->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->study_year->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="students" data-field="x_study_year" name="x<?php echo $students_grid->RowIndex ?>_study_year" id="x<?php echo $students_grid->RowIndex ?>_study_year" value="<?php echo ew_HtmlEncode($students->study_year->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="students" data-field="x_study_year" name="o<?php echo $students_grid->RowIndex ?>_study_year" id="o<?php echo $students_grid->RowIndex ?>_study_year" value="<?php echo ew_HtmlEncode($students->study_year->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->language_id->Visible) { // language_id ?>
		<td data-name="language_id">
<?php if ($students->CurrentAction <> "F") { ?>
<span id="el$rowindex$_students_language_id" class="form-group students_language_id">
<input type="text" data-table="students" data-field="x_language_id" name="x<?php echo $students_grid->RowIndex ?>_language_id" id="x<?php echo $students_grid->RowIndex ?>_language_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->language_id->getPlaceHolder()) ?>" value="<?php echo $students->language_id->EditValue ?>"<?php echo $students->language_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_students_language_id" class="form-group students_language_id">
<span<?php echo $students->language_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->language_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="students" data-field="x_language_id" name="x<?php echo $students_grid->RowIndex ?>_language_id" id="x<?php echo $students_grid->RowIndex ?>_language_id" value="<?php echo ew_HtmlEncode($students->language_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="students" data-field="x_language_id" name="o<?php echo $students_grid->RowIndex ?>_language_id" id="o<?php echo $students_grid->RowIndex ?>_language_id" value="<?php echo ew_HtmlEncode($students->language_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->langauge_level_id->Visible) { // langauge_level_id ?>
		<td data-name="langauge_level_id">
<?php if ($students->CurrentAction <> "F") { ?>
<span id="el$rowindex$_students_langauge_level_id" class="form-group students_langauge_level_id">
<input type="text" data-table="students" data-field="x_langauge_level_id" name="x<?php echo $students_grid->RowIndex ?>_langauge_level_id" id="x<?php echo $students_grid->RowIndex ?>_langauge_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->langauge_level_id->getPlaceHolder()) ?>" value="<?php echo $students->langauge_level_id->EditValue ?>"<?php echo $students->langauge_level_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_students_langauge_level_id" class="form-group students_langauge_level_id">
<span<?php echo $students->langauge_level_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->langauge_level_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="students" data-field="x_langauge_level_id" name="x<?php echo $students_grid->RowIndex ?>_langauge_level_id" id="x<?php echo $students_grid->RowIndex ?>_langauge_level_id" value="<?php echo ew_HtmlEncode($students->langauge_level_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="students" data-field="x_langauge_level_id" name="o<?php echo $students_grid->RowIndex ?>_langauge_level_id" id="o<?php echo $students_grid->RowIndex ?>_langauge_level_id" value="<?php echo ew_HtmlEncode($students->langauge_level_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->created_at->Visible) { // created_at ?>
		<td data-name="created_at">
<?php if ($students->CurrentAction <> "F") { ?>
<span id="el$rowindex$_students_created_at" class="form-group students_created_at">
<input type="text" data-table="students" data-field="x_created_at" name="x<?php echo $students_grid->RowIndex ?>_created_at" id="x<?php echo $students_grid->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($students->created_at->getPlaceHolder()) ?>" value="<?php echo $students->created_at->EditValue ?>"<?php echo $students->created_at->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_students_created_at" class="form-group students_created_at">
<span<?php echo $students->created_at->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->created_at->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="students" data-field="x_created_at" name="x<?php echo $students_grid->RowIndex ?>_created_at" id="x<?php echo $students_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($students->created_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="students" data-field="x_created_at" name="o<?php echo $students_grid->RowIndex ?>_created_at" id="o<?php echo $students_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($students->created_at->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->updated_at->Visible) { // updated_at ?>
		<td data-name="updated_at">
<?php if ($students->CurrentAction <> "F") { ?>
<span id="el$rowindex$_students_updated_at" class="form-group students_updated_at">
<input type="text" data-table="students" data-field="x_updated_at" name="x<?php echo $students_grid->RowIndex ?>_updated_at" id="x<?php echo $students_grid->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($students->updated_at->getPlaceHolder()) ?>" value="<?php echo $students->updated_at->EditValue ?>"<?php echo $students->updated_at->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_students_updated_at" class="form-group students_updated_at">
<span<?php echo $students->updated_at->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->updated_at->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="students" data-field="x_updated_at" name="x<?php echo $students_grid->RowIndex ?>_updated_at" id="x<?php echo $students_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($students->updated_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="students" data-field="x_updated_at" name="o<?php echo $students_grid->RowIndex ?>_updated_at" id="o<?php echo $students_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($students->updated_at->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$students_grid->ListOptions->Render("body", "right", $students_grid->RowIndex);
?>
<script type="text/javascript">
fstudentsgrid.UpdateOpts(<?php echo $students_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($students->CurrentMode == "add" || $students->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $students_grid->FormKeyCountName ?>" id="<?php echo $students_grid->FormKeyCountName ?>" value="<?php echo $students_grid->KeyCount ?>">
<?php echo $students_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($students->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $students_grid->FormKeyCountName ?>" id="<?php echo $students_grid->FormKeyCountName ?>" value="<?php echo $students_grid->KeyCount ?>">
<?php echo $students_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($students->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fstudentsgrid">
</div>
<?php

// Close recordset
if ($students_grid->Recordset)
	$students_grid->Recordset->Close();
?>
<?php if ($students_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($students_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($students_grid->TotalRecs == 0 && $students->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($students_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($students->Export == "") { ?>
<script type="text/javascript">
fstudentsgrid.Init();
</script>
<?php } ?>
<?php
$students_grid->Page_Terminate();
?>
