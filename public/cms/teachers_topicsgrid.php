<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($teachers_topics_grid)) $teachers_topics_grid = new cteachers_topics_grid();

// Page init
$teachers_topics_grid->Page_Init();

// Page main
$teachers_topics_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_topics_grid->Page_Render();
?>
<?php if ($teachers_topics->Export == "") { ?>
<script type="text/javascript">

// Form object
var fteachers_topicsgrid = new ew_Form("fteachers_topicsgrid", "grid");
fteachers_topicsgrid.FormKeyCountName = '<?php echo $teachers_topics_grid->FormKeyCountName ?>';

// Validate form
fteachers_topicsgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_topics->teacher_id->FldCaption(), $teachers_topics->teacher_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_topics->teacher_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_topic_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_topics->topic_id->FldCaption(), $teachers_topics->topic_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_topic_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_topics->topic_id->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fteachers_topicsgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "teacher_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "topic_id", false)) return false;
	return true;
}

// Form_CustomValidate event
fteachers_topicsgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachers_topicsgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($teachers_topics->CurrentAction == "gridadd") {
	if ($teachers_topics->CurrentMode == "copy") {
		$bSelectLimit = $teachers_topics_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$teachers_topics_grid->TotalRecs = $teachers_topics->ListRecordCount();
			$teachers_topics_grid->Recordset = $teachers_topics_grid->LoadRecordset($teachers_topics_grid->StartRec-1, $teachers_topics_grid->DisplayRecs);
		} else {
			if ($teachers_topics_grid->Recordset = $teachers_topics_grid->LoadRecordset())
				$teachers_topics_grid->TotalRecs = $teachers_topics_grid->Recordset->RecordCount();
		}
		$teachers_topics_grid->StartRec = 1;
		$teachers_topics_grid->DisplayRecs = $teachers_topics_grid->TotalRecs;
	} else {
		$teachers_topics->CurrentFilter = "0=1";
		$teachers_topics_grid->StartRec = 1;
		$teachers_topics_grid->DisplayRecs = $teachers_topics->GridAddRowCount;
	}
	$teachers_topics_grid->TotalRecs = $teachers_topics_grid->DisplayRecs;
	$teachers_topics_grid->StopRec = $teachers_topics_grid->DisplayRecs;
} else {
	$bSelectLimit = $teachers_topics_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($teachers_topics_grid->TotalRecs <= 0)
			$teachers_topics_grid->TotalRecs = $teachers_topics->ListRecordCount();
	} else {
		if (!$teachers_topics_grid->Recordset && ($teachers_topics_grid->Recordset = $teachers_topics_grid->LoadRecordset()))
			$teachers_topics_grid->TotalRecs = $teachers_topics_grid->Recordset->RecordCount();
	}
	$teachers_topics_grid->StartRec = 1;
	$teachers_topics_grid->DisplayRecs = $teachers_topics_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$teachers_topics_grid->Recordset = $teachers_topics_grid->LoadRecordset($teachers_topics_grid->StartRec-1, $teachers_topics_grid->DisplayRecs);

	// Set no record found message
	if ($teachers_topics->CurrentAction == "" && $teachers_topics_grid->TotalRecs == 0) {
		if ($teachers_topics_grid->SearchWhere == "0=101")
			$teachers_topics_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$teachers_topics_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$teachers_topics_grid->RenderOtherOptions();
?>
<?php $teachers_topics_grid->ShowPageHeader(); ?>
<?php
$teachers_topics_grid->ShowMessage();
?>
<?php if ($teachers_topics_grid->TotalRecs > 0 || $teachers_topics->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($teachers_topics_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> teachers_topics">
<div id="fteachers_topicsgrid" class="ewForm ewListForm form-inline">
<?php if ($teachers_topics_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($teachers_topics_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_teachers_topics" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_teachers_topicsgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$teachers_topics_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$teachers_topics_grid->RenderListOptions();

// Render list options (header, left)
$teachers_topics_grid->ListOptions->Render("header", "left");
?>
<?php if ($teachers_topics->teacher_id->Visible) { // teacher_id ?>
	<?php if ($teachers_topics->SortUrl($teachers_topics->teacher_id) == "") { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_topics->teacher_id->HeaderCellClass() ?>"><div id="elh_teachers_topics_teacher_id" class="teachers_topics_teacher_id"><div class="ewTableHeaderCaption"><?php echo $teachers_topics->teacher_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_topics->teacher_id->HeaderCellClass() ?>"><div><div id="elh_teachers_topics_teacher_id" class="teachers_topics_teacher_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_topics->teacher_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_topics->teacher_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_topics->teacher_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_topics->topic_id->Visible) { // topic_id ?>
	<?php if ($teachers_topics->SortUrl($teachers_topics->topic_id) == "") { ?>
		<th data-name="topic_id" class="<?php echo $teachers_topics->topic_id->HeaderCellClass() ?>"><div id="elh_teachers_topics_topic_id" class="teachers_topics_topic_id"><div class="ewTableHeaderCaption"><?php echo $teachers_topics->topic_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="topic_id" class="<?php echo $teachers_topics->topic_id->HeaderCellClass() ?>"><div><div id="elh_teachers_topics_topic_id" class="teachers_topics_topic_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_topics->topic_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_topics->topic_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_topics->topic_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$teachers_topics_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$teachers_topics_grid->StartRec = 1;
$teachers_topics_grid->StopRec = $teachers_topics_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($teachers_topics_grid->FormKeyCountName) && ($teachers_topics->CurrentAction == "gridadd" || $teachers_topics->CurrentAction == "gridedit" || $teachers_topics->CurrentAction == "F")) {
		$teachers_topics_grid->KeyCount = $objForm->GetValue($teachers_topics_grid->FormKeyCountName);
		$teachers_topics_grid->StopRec = $teachers_topics_grid->StartRec + $teachers_topics_grid->KeyCount - 1;
	}
}
$teachers_topics_grid->RecCnt = $teachers_topics_grid->StartRec - 1;
if ($teachers_topics_grid->Recordset && !$teachers_topics_grid->Recordset->EOF) {
	$teachers_topics_grid->Recordset->MoveFirst();
	$bSelectLimit = $teachers_topics_grid->UseSelectLimit;
	if (!$bSelectLimit && $teachers_topics_grid->StartRec > 1)
		$teachers_topics_grid->Recordset->Move($teachers_topics_grid->StartRec - 1);
} elseif (!$teachers_topics->AllowAddDeleteRow && $teachers_topics_grid->StopRec == 0) {
	$teachers_topics_grid->StopRec = $teachers_topics->GridAddRowCount;
}

// Initialize aggregate
$teachers_topics->RowType = EW_ROWTYPE_AGGREGATEINIT;
$teachers_topics->ResetAttrs();
$teachers_topics_grid->RenderRow();
if ($teachers_topics->CurrentAction == "gridadd")
	$teachers_topics_grid->RowIndex = 0;
if ($teachers_topics->CurrentAction == "gridedit")
	$teachers_topics_grid->RowIndex = 0;
while ($teachers_topics_grid->RecCnt < $teachers_topics_grid->StopRec) {
	$teachers_topics_grid->RecCnt++;
	if (intval($teachers_topics_grid->RecCnt) >= intval($teachers_topics_grid->StartRec)) {
		$teachers_topics_grid->RowCnt++;
		if ($teachers_topics->CurrentAction == "gridadd" || $teachers_topics->CurrentAction == "gridedit" || $teachers_topics->CurrentAction == "F") {
			$teachers_topics_grid->RowIndex++;
			$objForm->Index = $teachers_topics_grid->RowIndex;
			if ($objForm->HasValue($teachers_topics_grid->FormActionName))
				$teachers_topics_grid->RowAction = strval($objForm->GetValue($teachers_topics_grid->FormActionName));
			elseif ($teachers_topics->CurrentAction == "gridadd")
				$teachers_topics_grid->RowAction = "insert";
			else
				$teachers_topics_grid->RowAction = "";
		}

		// Set up key count
		$teachers_topics_grid->KeyCount = $teachers_topics_grid->RowIndex;

		// Init row class and style
		$teachers_topics->ResetAttrs();
		$teachers_topics->CssClass = "";
		if ($teachers_topics->CurrentAction == "gridadd") {
			if ($teachers_topics->CurrentMode == "copy") {
				$teachers_topics_grid->LoadRowValues($teachers_topics_grid->Recordset); // Load row values
				$teachers_topics_grid->SetRecordKey($teachers_topics_grid->RowOldKey, $teachers_topics_grid->Recordset); // Set old record key
			} else {
				$teachers_topics_grid->LoadRowValues(); // Load default values
				$teachers_topics_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$teachers_topics_grid->LoadRowValues($teachers_topics_grid->Recordset); // Load row values
		}
		$teachers_topics->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($teachers_topics->CurrentAction == "gridadd") // Grid add
			$teachers_topics->RowType = EW_ROWTYPE_ADD; // Render add
		if ($teachers_topics->CurrentAction == "gridadd" && $teachers_topics->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$teachers_topics_grid->RestoreCurrentRowFormValues($teachers_topics_grid->RowIndex); // Restore form values
		if ($teachers_topics->CurrentAction == "gridedit") { // Grid edit
			if ($teachers_topics->EventCancelled) {
				$teachers_topics_grid->RestoreCurrentRowFormValues($teachers_topics_grid->RowIndex); // Restore form values
			}
			if ($teachers_topics_grid->RowAction == "insert")
				$teachers_topics->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$teachers_topics->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($teachers_topics->CurrentAction == "gridedit" && ($teachers_topics->RowType == EW_ROWTYPE_EDIT || $teachers_topics->RowType == EW_ROWTYPE_ADD) && $teachers_topics->EventCancelled) // Update failed
			$teachers_topics_grid->RestoreCurrentRowFormValues($teachers_topics_grid->RowIndex); // Restore form values
		if ($teachers_topics->RowType == EW_ROWTYPE_EDIT) // Edit row
			$teachers_topics_grid->EditRowCnt++;
		if ($teachers_topics->CurrentAction == "F") // Confirm row
			$teachers_topics_grid->RestoreCurrentRowFormValues($teachers_topics_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$teachers_topics->RowAttrs = array_merge($teachers_topics->RowAttrs, array('data-rowindex'=>$teachers_topics_grid->RowCnt, 'id'=>'r' . $teachers_topics_grid->RowCnt . '_teachers_topics', 'data-rowtype'=>$teachers_topics->RowType));

		// Render row
		$teachers_topics_grid->RenderRow();

		// Render list options
		$teachers_topics_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($teachers_topics_grid->RowAction <> "delete" && $teachers_topics_grid->RowAction <> "insertdelete" && !($teachers_topics_grid->RowAction == "insert" && $teachers_topics->CurrentAction == "F" && $teachers_topics_grid->EmptyRow())) {
?>
	<tr<?php echo $teachers_topics->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_topics_grid->ListOptions->Render("body", "left", $teachers_topics_grid->RowCnt);
?>
	<?php if ($teachers_topics->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id"<?php echo $teachers_topics->teacher_id->CellAttributes() ?>>
<?php if ($teachers_topics->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($teachers_topics->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_topics_grid->RowCnt ?>_teachers_topics_teacher_id" class="form-group teachers_topics_teacher_id">
<span<?php echo $teachers_topics->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_topics->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_topics_grid->RowCnt ?>_teachers_topics_teacher_id" class="form-group teachers_topics_teacher_id">
<input type="text" data-table="teachers_topics" data-field="x_teacher_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_topics->teacher_id->EditValue ?>"<?php echo $teachers_topics->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="teachers_topics" data-field="x_teacher_id" name="o<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_topics->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($teachers_topics->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_topics_grid->RowCnt ?>_teachers_topics_teacher_id" class="form-group teachers_topics_teacher_id">
<span<?php echo $teachers_topics->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_topics->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_topics_grid->RowCnt ?>_teachers_topics_teacher_id" class="form-group teachers_topics_teacher_id">
<input type="text" data-table="teachers_topics" data-field="x_teacher_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_topics->teacher_id->EditValue ?>"<?php echo $teachers_topics->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($teachers_topics->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_topics_grid->RowCnt ?>_teachers_topics_teacher_id" class="teachers_topics_teacher_id">
<span<?php echo $teachers_topics->teacher_id->ViewAttributes() ?>>
<?php echo $teachers_topics->teacher_id->ListViewValue() ?></span>
</span>
<?php if ($teachers_topics->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_topics" data-field="x_teacher_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_topics" data-field="x_teacher_id" name="o<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_topics" data-field="x_teacher_id" name="fteachers_topicsgrid$x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" id="fteachers_topicsgrid$x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_topics" data-field="x_teacher_id" name="fteachers_topicsgrid$o<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" id="fteachers_topicsgrid$o<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_topics->topic_id->Visible) { // topic_id ?>
		<td data-name="topic_id"<?php echo $teachers_topics->topic_id->CellAttributes() ?>>
<?php if ($teachers_topics->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_topics_grid->RowCnt ?>_teachers_topics_topic_id" class="form-group teachers_topics_topic_id">
<input type="text" data-table="teachers_topics" data-field="x_topic_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" id="x<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_topics->topic_id->getPlaceHolder()) ?>" value="<?php echo $teachers_topics->topic_id->EditValue ?>"<?php echo $teachers_topics->topic_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_topics" data-field="x_topic_id" name="o<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" id="o<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($teachers_topics->topic_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_topics->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_topics_grid->RowCnt ?>_teachers_topics_topic_id" class="form-group teachers_topics_topic_id">
<input type="text" data-table="teachers_topics" data-field="x_topic_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" id="x<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_topics->topic_id->getPlaceHolder()) ?>" value="<?php echo $teachers_topics->topic_id->EditValue ?>"<?php echo $teachers_topics->topic_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_topics->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_topics_grid->RowCnt ?>_teachers_topics_topic_id" class="teachers_topics_topic_id">
<span<?php echo $teachers_topics->topic_id->ViewAttributes() ?>>
<?php echo $teachers_topics->topic_id->ListViewValue() ?></span>
</span>
<?php if ($teachers_topics->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_topics" data-field="x_topic_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" id="x<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($teachers_topics->topic_id->FormValue) ?>">
<input type="hidden" data-table="teachers_topics" data-field="x_topic_id" name="o<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" id="o<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($teachers_topics->topic_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_topics" data-field="x_topic_id" name="fteachers_topicsgrid$x<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" id="fteachers_topicsgrid$x<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($teachers_topics->topic_id->FormValue) ?>">
<input type="hidden" data-table="teachers_topics" data-field="x_topic_id" name="fteachers_topicsgrid$o<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" id="fteachers_topicsgrid$o<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($teachers_topics->topic_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_topics_grid->ListOptions->Render("body", "right", $teachers_topics_grid->RowCnt);
?>
	</tr>
<?php if ($teachers_topics->RowType == EW_ROWTYPE_ADD || $teachers_topics->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fteachers_topicsgrid.UpdateOpts(<?php echo $teachers_topics_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($teachers_topics->CurrentAction <> "gridadd" || $teachers_topics->CurrentMode == "copy")
		if (!$teachers_topics_grid->Recordset->EOF) $teachers_topics_grid->Recordset->MoveNext();
}
?>
<?php
	if ($teachers_topics->CurrentMode == "add" || $teachers_topics->CurrentMode == "copy" || $teachers_topics->CurrentMode == "edit") {
		$teachers_topics_grid->RowIndex = '$rowindex$';
		$teachers_topics_grid->LoadRowValues();

		// Set row properties
		$teachers_topics->ResetAttrs();
		$teachers_topics->RowAttrs = array_merge($teachers_topics->RowAttrs, array('data-rowindex'=>$teachers_topics_grid->RowIndex, 'id'=>'r0_teachers_topics', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($teachers_topics->RowAttrs["class"], "ewTemplate");
		$teachers_topics->RowType = EW_ROWTYPE_ADD;

		// Render row
		$teachers_topics_grid->RenderRow();

		// Render list options
		$teachers_topics_grid->RenderListOptions();
		$teachers_topics_grid->StartRowCnt = 0;
?>
	<tr<?php echo $teachers_topics->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_topics_grid->ListOptions->Render("body", "left", $teachers_topics_grid->RowIndex);
?>
	<?php if ($teachers_topics->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id">
<?php if ($teachers_topics->CurrentAction <> "F") { ?>
<?php if ($teachers_topics->teacher_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_teachers_topics_teacher_id" class="form-group teachers_topics_teacher_id">
<span<?php echo $teachers_topics->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_topics->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_teachers_topics_teacher_id" class="form-group teachers_topics_teacher_id">
<input type="text" data-table="teachers_topics" data-field="x_teacher_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_topics->teacher_id->EditValue ?>"<?php echo $teachers_topics->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_topics_teacher_id" class="form-group teachers_topics_teacher_id">
<span<?php echo $teachers_topics->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_topics->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_topics" data-field="x_teacher_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_topics" data-field="x_teacher_id" name="o<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_topics_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_topics->teacher_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_topics->topic_id->Visible) { // topic_id ?>
		<td data-name="topic_id">
<?php if ($teachers_topics->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_topics_topic_id" class="form-group teachers_topics_topic_id">
<input type="text" data-table="teachers_topics" data-field="x_topic_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" id="x<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_topics->topic_id->getPlaceHolder()) ?>" value="<?php echo $teachers_topics->topic_id->EditValue ?>"<?php echo $teachers_topics->topic_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_topics_topic_id" class="form-group teachers_topics_topic_id">
<span<?php echo $teachers_topics->topic_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_topics->topic_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_topics" data-field="x_topic_id" name="x<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" id="x<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($teachers_topics->topic_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_topics" data-field="x_topic_id" name="o<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" id="o<?php echo $teachers_topics_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($teachers_topics->topic_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_topics_grid->ListOptions->Render("body", "right", $teachers_topics_grid->RowIndex);
?>
<script type="text/javascript">
fteachers_topicsgrid.UpdateOpts(<?php echo $teachers_topics_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($teachers_topics->CurrentMode == "add" || $teachers_topics->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $teachers_topics_grid->FormKeyCountName ?>" id="<?php echo $teachers_topics_grid->FormKeyCountName ?>" value="<?php echo $teachers_topics_grid->KeyCount ?>">
<?php echo $teachers_topics_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_topics->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $teachers_topics_grid->FormKeyCountName ?>" id="<?php echo $teachers_topics_grid->FormKeyCountName ?>" value="<?php echo $teachers_topics_grid->KeyCount ?>">
<?php echo $teachers_topics_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_topics->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fteachers_topicsgrid">
</div>
<?php

// Close recordset
if ($teachers_topics_grid->Recordset)
	$teachers_topics_grid->Recordset->Close();
?>
<?php if ($teachers_topics_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($teachers_topics_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($teachers_topics_grid->TotalRecs == 0 && $teachers_topics->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_topics_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($teachers_topics->Export == "") { ?>
<script type="text/javascript">
fteachers_topicsgrid.Init();
</script>
<?php } ?>
<?php
$teachers_topics_grid->Page_Terminate();
?>
