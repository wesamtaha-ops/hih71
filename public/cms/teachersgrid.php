<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($teachers_grid)) $teachers_grid = new cteachers_grid();

// Page init
$teachers_grid->Page_Init();

// Page main
$teachers_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_grid->Page_Render();
?>
<?php if ($teachers->Export == "") { ?>
<script type="text/javascript">

// Form object
var fteachersgrid = new ew_Form("fteachersgrid", "grid");
fteachersgrid.FormKeyCountName = '<?php echo $teachers_grid->FormKeyCountName ?>';

// Validate form
fteachersgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers->user_id->FldCaption(), $teachers->user_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_user_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers->user_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_allow_express");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers->allow_express->FldCaption(), $teachers->allow_express->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_allow_express");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers->allow_express->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fees");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers->fees->FldCaption(), $teachers->fees->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fees");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers->fees->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers->currency_id->FldCaption(), $teachers->currency_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers->currency_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers->created_at->FldCaption(), $teachers->created_at->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers->created_at->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_updated_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers->updated_at->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fteachersgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "user_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "timezone", false)) return false;
	if (ew_ValueChanged(fobj, infix, "teacher_language", false)) return false;
	if (ew_ValueChanged(fobj, infix, "video", false)) return false;
	if (ew_ValueChanged(fobj, infix, "heading_ar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "description_ar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "heading_en", false)) return false;
	if (ew_ValueChanged(fobj, infix, "description_en", false)) return false;
	if (ew_ValueChanged(fobj, infix, "allow_express", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fees", false)) return false;
	if (ew_ValueChanged(fobj, infix, "currency_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "created_at", false)) return false;
	if (ew_ValueChanged(fobj, infix, "updated_at", false)) return false;
	return true;
}

// Form_CustomValidate event
fteachersgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachersgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($teachers->CurrentAction == "gridadd") {
	if ($teachers->CurrentMode == "copy") {
		$bSelectLimit = $teachers_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$teachers_grid->TotalRecs = $teachers->ListRecordCount();
			$teachers_grid->Recordset = $teachers_grid->LoadRecordset($teachers_grid->StartRec-1, $teachers_grid->DisplayRecs);
		} else {
			if ($teachers_grid->Recordset = $teachers_grid->LoadRecordset())
				$teachers_grid->TotalRecs = $teachers_grid->Recordset->RecordCount();
		}
		$teachers_grid->StartRec = 1;
		$teachers_grid->DisplayRecs = $teachers_grid->TotalRecs;
	} else {
		$teachers->CurrentFilter = "0=1";
		$teachers_grid->StartRec = 1;
		$teachers_grid->DisplayRecs = $teachers->GridAddRowCount;
	}
	$teachers_grid->TotalRecs = $teachers_grid->DisplayRecs;
	$teachers_grid->StopRec = $teachers_grid->DisplayRecs;
} else {
	$bSelectLimit = $teachers_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($teachers_grid->TotalRecs <= 0)
			$teachers_grid->TotalRecs = $teachers->ListRecordCount();
	} else {
		if (!$teachers_grid->Recordset && ($teachers_grid->Recordset = $teachers_grid->LoadRecordset()))
			$teachers_grid->TotalRecs = $teachers_grid->Recordset->RecordCount();
	}
	$teachers_grid->StartRec = 1;
	$teachers_grid->DisplayRecs = $teachers_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$teachers_grid->Recordset = $teachers_grid->LoadRecordset($teachers_grid->StartRec-1, $teachers_grid->DisplayRecs);

	// Set no record found message
	if ($teachers->CurrentAction == "" && $teachers_grid->TotalRecs == 0) {
		if ($teachers_grid->SearchWhere == "0=101")
			$teachers_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$teachers_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$teachers_grid->RenderOtherOptions();
?>
<?php $teachers_grid->ShowPageHeader(); ?>
<?php
$teachers_grid->ShowMessage();
?>
<?php if ($teachers_grid->TotalRecs > 0 || $teachers->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($teachers_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> teachers">
<div id="fteachersgrid" class="ewForm ewListForm form-inline">
<?php if ($teachers_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($teachers_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_teachers" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_teachersgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$teachers_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$teachers_grid->RenderListOptions();

// Render list options (header, left)
$teachers_grid->ListOptions->Render("header", "left");
?>
<?php if ($teachers->id->Visible) { // id ?>
	<?php if ($teachers->SortUrl($teachers->id) == "") { ?>
		<th data-name="id" class="<?php echo $teachers->id->HeaderCellClass() ?>"><div id="elh_teachers_id" class="teachers_id"><div class="ewTableHeaderCaption"><?php echo $teachers->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $teachers->id->HeaderCellClass() ?>"><div><div id="elh_teachers_id" class="teachers_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->user_id->Visible) { // user_id ?>
	<?php if ($teachers->SortUrl($teachers->user_id) == "") { ?>
		<th data-name="user_id" class="<?php echo $teachers->user_id->HeaderCellClass() ?>"><div id="elh_teachers_user_id" class="teachers_user_id"><div class="ewTableHeaderCaption"><?php echo $teachers->user_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user_id" class="<?php echo $teachers->user_id->HeaderCellClass() ?>"><div><div id="elh_teachers_user_id" class="teachers_user_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->user_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->user_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->user_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->timezone->Visible) { // timezone ?>
	<?php if ($teachers->SortUrl($teachers->timezone) == "") { ?>
		<th data-name="timezone" class="<?php echo $teachers->timezone->HeaderCellClass() ?>"><div id="elh_teachers_timezone" class="teachers_timezone"><div class="ewTableHeaderCaption"><?php echo $teachers->timezone->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="timezone" class="<?php echo $teachers->timezone->HeaderCellClass() ?>"><div><div id="elh_teachers_timezone" class="teachers_timezone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->timezone->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->timezone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->timezone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->teacher_language->Visible) { // teacher_language ?>
	<?php if ($teachers->SortUrl($teachers->teacher_language) == "") { ?>
		<th data-name="teacher_language" class="<?php echo $teachers->teacher_language->HeaderCellClass() ?>"><div id="elh_teachers_teacher_language" class="teachers_teacher_language"><div class="ewTableHeaderCaption"><?php echo $teachers->teacher_language->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="teacher_language" class="<?php echo $teachers->teacher_language->HeaderCellClass() ?>"><div><div id="elh_teachers_teacher_language" class="teachers_teacher_language">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->teacher_language->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->teacher_language->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->teacher_language->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->video->Visible) { // video ?>
	<?php if ($teachers->SortUrl($teachers->video) == "") { ?>
		<th data-name="video" class="<?php echo $teachers->video->HeaderCellClass() ?>"><div id="elh_teachers_video" class="teachers_video"><div class="ewTableHeaderCaption"><?php echo $teachers->video->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="video" class="<?php echo $teachers->video->HeaderCellClass() ?>"><div><div id="elh_teachers_video" class="teachers_video">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->video->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->video->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->video->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->heading_ar->Visible) { // heading_ar ?>
	<?php if ($teachers->SortUrl($teachers->heading_ar) == "") { ?>
		<th data-name="heading_ar" class="<?php echo $teachers->heading_ar->HeaderCellClass() ?>"><div id="elh_teachers_heading_ar" class="teachers_heading_ar"><div class="ewTableHeaderCaption"><?php echo $teachers->heading_ar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="heading_ar" class="<?php echo $teachers->heading_ar->HeaderCellClass() ?>"><div><div id="elh_teachers_heading_ar" class="teachers_heading_ar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->heading_ar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->heading_ar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->heading_ar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->description_ar->Visible) { // description_ar ?>
	<?php if ($teachers->SortUrl($teachers->description_ar) == "") { ?>
		<th data-name="description_ar" class="<?php echo $teachers->description_ar->HeaderCellClass() ?>"><div id="elh_teachers_description_ar" class="teachers_description_ar"><div class="ewTableHeaderCaption"><?php echo $teachers->description_ar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description_ar" class="<?php echo $teachers->description_ar->HeaderCellClass() ?>"><div><div id="elh_teachers_description_ar" class="teachers_description_ar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->description_ar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->description_ar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->description_ar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->heading_en->Visible) { // heading_en ?>
	<?php if ($teachers->SortUrl($teachers->heading_en) == "") { ?>
		<th data-name="heading_en" class="<?php echo $teachers->heading_en->HeaderCellClass() ?>"><div id="elh_teachers_heading_en" class="teachers_heading_en"><div class="ewTableHeaderCaption"><?php echo $teachers->heading_en->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="heading_en" class="<?php echo $teachers->heading_en->HeaderCellClass() ?>"><div><div id="elh_teachers_heading_en" class="teachers_heading_en">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->heading_en->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->heading_en->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->heading_en->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->description_en->Visible) { // description_en ?>
	<?php if ($teachers->SortUrl($teachers->description_en) == "") { ?>
		<th data-name="description_en" class="<?php echo $teachers->description_en->HeaderCellClass() ?>"><div id="elh_teachers_description_en" class="teachers_description_en"><div class="ewTableHeaderCaption"><?php echo $teachers->description_en->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description_en" class="<?php echo $teachers->description_en->HeaderCellClass() ?>"><div><div id="elh_teachers_description_en" class="teachers_description_en">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->description_en->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->description_en->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->description_en->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->allow_express->Visible) { // allow_express ?>
	<?php if ($teachers->SortUrl($teachers->allow_express) == "") { ?>
		<th data-name="allow_express" class="<?php echo $teachers->allow_express->HeaderCellClass() ?>"><div id="elh_teachers_allow_express" class="teachers_allow_express"><div class="ewTableHeaderCaption"><?php echo $teachers->allow_express->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="allow_express" class="<?php echo $teachers->allow_express->HeaderCellClass() ?>"><div><div id="elh_teachers_allow_express" class="teachers_allow_express">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->allow_express->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->allow_express->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->allow_express->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->fees->Visible) { // fees ?>
	<?php if ($teachers->SortUrl($teachers->fees) == "") { ?>
		<th data-name="fees" class="<?php echo $teachers->fees->HeaderCellClass() ?>"><div id="elh_teachers_fees" class="teachers_fees"><div class="ewTableHeaderCaption"><?php echo $teachers->fees->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fees" class="<?php echo $teachers->fees->HeaderCellClass() ?>"><div><div id="elh_teachers_fees" class="teachers_fees">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->fees->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->fees->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->fees->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->currency_id->Visible) { // currency_id ?>
	<?php if ($teachers->SortUrl($teachers->currency_id) == "") { ?>
		<th data-name="currency_id" class="<?php echo $teachers->currency_id->HeaderCellClass() ?>"><div id="elh_teachers_currency_id" class="teachers_currency_id"><div class="ewTableHeaderCaption"><?php echo $teachers->currency_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency_id" class="<?php echo $teachers->currency_id->HeaderCellClass() ?>"><div><div id="elh_teachers_currency_id" class="teachers_currency_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->currency_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->currency_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->currency_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->created_at->Visible) { // created_at ?>
	<?php if ($teachers->SortUrl($teachers->created_at) == "") { ?>
		<th data-name="created_at" class="<?php echo $teachers->created_at->HeaderCellClass() ?>"><div id="elh_teachers_created_at" class="teachers_created_at"><div class="ewTableHeaderCaption"><?php echo $teachers->created_at->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="created_at" class="<?php echo $teachers->created_at->HeaderCellClass() ?>"><div><div id="elh_teachers_created_at" class="teachers_created_at">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->created_at->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->created_at->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->created_at->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers->updated_at->Visible) { // updated_at ?>
	<?php if ($teachers->SortUrl($teachers->updated_at) == "") { ?>
		<th data-name="updated_at" class="<?php echo $teachers->updated_at->HeaderCellClass() ?>"><div id="elh_teachers_updated_at" class="teachers_updated_at"><div class="ewTableHeaderCaption"><?php echo $teachers->updated_at->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="updated_at" class="<?php echo $teachers->updated_at->HeaderCellClass() ?>"><div><div id="elh_teachers_updated_at" class="teachers_updated_at">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers->updated_at->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers->updated_at->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers->updated_at->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$teachers_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$teachers_grid->StartRec = 1;
$teachers_grid->StopRec = $teachers_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($teachers_grid->FormKeyCountName) && ($teachers->CurrentAction == "gridadd" || $teachers->CurrentAction == "gridedit" || $teachers->CurrentAction == "F")) {
		$teachers_grid->KeyCount = $objForm->GetValue($teachers_grid->FormKeyCountName);
		$teachers_grid->StopRec = $teachers_grid->StartRec + $teachers_grid->KeyCount - 1;
	}
}
$teachers_grid->RecCnt = $teachers_grid->StartRec - 1;
if ($teachers_grid->Recordset && !$teachers_grid->Recordset->EOF) {
	$teachers_grid->Recordset->MoveFirst();
	$bSelectLimit = $teachers_grid->UseSelectLimit;
	if (!$bSelectLimit && $teachers_grid->StartRec > 1)
		$teachers_grid->Recordset->Move($teachers_grid->StartRec - 1);
} elseif (!$teachers->AllowAddDeleteRow && $teachers_grid->StopRec == 0) {
	$teachers_grid->StopRec = $teachers->GridAddRowCount;
}

// Initialize aggregate
$teachers->RowType = EW_ROWTYPE_AGGREGATEINIT;
$teachers->ResetAttrs();
$teachers_grid->RenderRow();
if ($teachers->CurrentAction == "gridadd")
	$teachers_grid->RowIndex = 0;
if ($teachers->CurrentAction == "gridedit")
	$teachers_grid->RowIndex = 0;
while ($teachers_grid->RecCnt < $teachers_grid->StopRec) {
	$teachers_grid->RecCnt++;
	if (intval($teachers_grid->RecCnt) >= intval($teachers_grid->StartRec)) {
		$teachers_grid->RowCnt++;
		if ($teachers->CurrentAction == "gridadd" || $teachers->CurrentAction == "gridedit" || $teachers->CurrentAction == "F") {
			$teachers_grid->RowIndex++;
			$objForm->Index = $teachers_grid->RowIndex;
			if ($objForm->HasValue($teachers_grid->FormActionName))
				$teachers_grid->RowAction = strval($objForm->GetValue($teachers_grid->FormActionName));
			elseif ($teachers->CurrentAction == "gridadd")
				$teachers_grid->RowAction = "insert";
			else
				$teachers_grid->RowAction = "";
		}

		// Set up key count
		$teachers_grid->KeyCount = $teachers_grid->RowIndex;

		// Init row class and style
		$teachers->ResetAttrs();
		$teachers->CssClass = "";
		if ($teachers->CurrentAction == "gridadd") {
			if ($teachers->CurrentMode == "copy") {
				$teachers_grid->LoadRowValues($teachers_grid->Recordset); // Load row values
				$teachers_grid->SetRecordKey($teachers_grid->RowOldKey, $teachers_grid->Recordset); // Set old record key
			} else {
				$teachers_grid->LoadRowValues(); // Load default values
				$teachers_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$teachers_grid->LoadRowValues($teachers_grid->Recordset); // Load row values
		}
		$teachers->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($teachers->CurrentAction == "gridadd") // Grid add
			$teachers->RowType = EW_ROWTYPE_ADD; // Render add
		if ($teachers->CurrentAction == "gridadd" && $teachers->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$teachers_grid->RestoreCurrentRowFormValues($teachers_grid->RowIndex); // Restore form values
		if ($teachers->CurrentAction == "gridedit") { // Grid edit
			if ($teachers->EventCancelled) {
				$teachers_grid->RestoreCurrentRowFormValues($teachers_grid->RowIndex); // Restore form values
			}
			if ($teachers_grid->RowAction == "insert")
				$teachers->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$teachers->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($teachers->CurrentAction == "gridedit" && ($teachers->RowType == EW_ROWTYPE_EDIT || $teachers->RowType == EW_ROWTYPE_ADD) && $teachers->EventCancelled) // Update failed
			$teachers_grid->RestoreCurrentRowFormValues($teachers_grid->RowIndex); // Restore form values
		if ($teachers->RowType == EW_ROWTYPE_EDIT) // Edit row
			$teachers_grid->EditRowCnt++;
		if ($teachers->CurrentAction == "F") // Confirm row
			$teachers_grid->RestoreCurrentRowFormValues($teachers_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$teachers->RowAttrs = array_merge($teachers->RowAttrs, array('data-rowindex'=>$teachers_grid->RowCnt, 'id'=>'r' . $teachers_grid->RowCnt . '_teachers', 'data-rowtype'=>$teachers->RowType));

		// Render row
		$teachers_grid->RenderRow();

		// Render list options
		$teachers_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($teachers_grid->RowAction <> "delete" && $teachers_grid->RowAction <> "insertdelete" && !($teachers_grid->RowAction == "insert" && $teachers->CurrentAction == "F" && $teachers_grid->EmptyRow())) {
?>
	<tr<?php echo $teachers->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_grid->ListOptions->Render("body", "left", $teachers_grid->RowCnt);
?>
	<?php if ($teachers->id->Visible) { // id ?>
		<td data-name="id"<?php echo $teachers->id->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="teachers" data-field="x_id" name="o<?php echo $teachers_grid->RowIndex ?>_id" id="o<?php echo $teachers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers->id->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_id" class="form-group teachers_id">
<span<?php echo $teachers->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_id" name="x<?php echo $teachers_grid->RowIndex ?>_id" id="x<?php echo $teachers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers->id->CurrentValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_id" class="teachers_id">
<span<?php echo $teachers->id->ViewAttributes() ?>>
<?php echo $teachers->id->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_id" name="x<?php echo $teachers_grid->RowIndex ?>_id" id="x<?php echo $teachers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers->id->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_id" name="o<?php echo $teachers_grid->RowIndex ?>_id" id="o<?php echo $teachers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_id" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_id" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers->id->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_id" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_id" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->user_id->Visible) { // user_id ?>
		<td data-name="user_id"<?php echo $teachers->user_id->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($teachers->user_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_user_id" class="form-group teachers_user_id">
<span<?php echo $teachers->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_grid->RowIndex ?>_user_id" name="x<?php echo $teachers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($teachers->user_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_user_id" class="form-group teachers_user_id">
<input type="text" data-table="teachers" data-field="x_user_id" name="x<?php echo $teachers_grid->RowIndex ?>_user_id" id="x<?php echo $teachers_grid->RowIndex ?>_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->user_id->getPlaceHolder()) ?>" value="<?php echo $teachers->user_id->EditValue ?>"<?php echo $teachers->user_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_user_id" name="o<?php echo $teachers_grid->RowIndex ?>_user_id" id="o<?php echo $teachers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($teachers->user_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($teachers->user_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_user_id" class="form-group teachers_user_id">
<span<?php echo $teachers->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_grid->RowIndex ?>_user_id" name="x<?php echo $teachers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($teachers->user_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_user_id" class="form-group teachers_user_id">
<input type="text" data-table="teachers" data-field="x_user_id" name="x<?php echo $teachers_grid->RowIndex ?>_user_id" id="x<?php echo $teachers_grid->RowIndex ?>_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->user_id->getPlaceHolder()) ?>" value="<?php echo $teachers->user_id->EditValue ?>"<?php echo $teachers->user_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_user_id" class="teachers_user_id">
<span<?php echo $teachers->user_id->ViewAttributes() ?>>
<?php echo $teachers->user_id->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_user_id" name="x<?php echo $teachers_grid->RowIndex ?>_user_id" id="x<?php echo $teachers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($teachers->user_id->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_user_id" name="o<?php echo $teachers_grid->RowIndex ?>_user_id" id="o<?php echo $teachers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($teachers->user_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_user_id" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_user_id" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($teachers->user_id->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_user_id" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_user_id" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($teachers->user_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->timezone->Visible) { // timezone ?>
		<td data-name="timezone"<?php echo $teachers->timezone->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_timezone" class="form-group teachers_timezone">
<textarea data-table="teachers" data-field="x_timezone" name="x<?php echo $teachers_grid->RowIndex ?>_timezone" id="x<?php echo $teachers_grid->RowIndex ?>_timezone" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->timezone->getPlaceHolder()) ?>"<?php echo $teachers->timezone->EditAttributes() ?>><?php echo $teachers->timezone->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers" data-field="x_timezone" name="o<?php echo $teachers_grid->RowIndex ?>_timezone" id="o<?php echo $teachers_grid->RowIndex ?>_timezone" value="<?php echo ew_HtmlEncode($teachers->timezone->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_timezone" class="form-group teachers_timezone">
<textarea data-table="teachers" data-field="x_timezone" name="x<?php echo $teachers_grid->RowIndex ?>_timezone" id="x<?php echo $teachers_grid->RowIndex ?>_timezone" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->timezone->getPlaceHolder()) ?>"<?php echo $teachers->timezone->EditAttributes() ?>><?php echo $teachers->timezone->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_timezone" class="teachers_timezone">
<span<?php echo $teachers->timezone->ViewAttributes() ?>>
<?php echo $teachers->timezone->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_timezone" name="x<?php echo $teachers_grid->RowIndex ?>_timezone" id="x<?php echo $teachers_grid->RowIndex ?>_timezone" value="<?php echo ew_HtmlEncode($teachers->timezone->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_timezone" name="o<?php echo $teachers_grid->RowIndex ?>_timezone" id="o<?php echo $teachers_grid->RowIndex ?>_timezone" value="<?php echo ew_HtmlEncode($teachers->timezone->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_timezone" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_timezone" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_timezone" value="<?php echo ew_HtmlEncode($teachers->timezone->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_timezone" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_timezone" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_timezone" value="<?php echo ew_HtmlEncode($teachers->timezone->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->teacher_language->Visible) { // teacher_language ?>
		<td data-name="teacher_language"<?php echo $teachers->teacher_language->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_teacher_language" class="form-group teachers_teacher_language">
<textarea data-table="teachers" data-field="x_teacher_language" name="x<?php echo $teachers_grid->RowIndex ?>_teacher_language" id="x<?php echo $teachers_grid->RowIndex ?>_teacher_language" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->teacher_language->getPlaceHolder()) ?>"<?php echo $teachers->teacher_language->EditAttributes() ?>><?php echo $teachers->teacher_language->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers" data-field="x_teacher_language" name="o<?php echo $teachers_grid->RowIndex ?>_teacher_language" id="o<?php echo $teachers_grid->RowIndex ?>_teacher_language" value="<?php echo ew_HtmlEncode($teachers->teacher_language->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_teacher_language" class="form-group teachers_teacher_language">
<textarea data-table="teachers" data-field="x_teacher_language" name="x<?php echo $teachers_grid->RowIndex ?>_teacher_language" id="x<?php echo $teachers_grid->RowIndex ?>_teacher_language" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->teacher_language->getPlaceHolder()) ?>"<?php echo $teachers->teacher_language->EditAttributes() ?>><?php echo $teachers->teacher_language->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_teacher_language" class="teachers_teacher_language">
<span<?php echo $teachers->teacher_language->ViewAttributes() ?>>
<?php echo $teachers->teacher_language->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_teacher_language" name="x<?php echo $teachers_grid->RowIndex ?>_teacher_language" id="x<?php echo $teachers_grid->RowIndex ?>_teacher_language" value="<?php echo ew_HtmlEncode($teachers->teacher_language->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_teacher_language" name="o<?php echo $teachers_grid->RowIndex ?>_teacher_language" id="o<?php echo $teachers_grid->RowIndex ?>_teacher_language" value="<?php echo ew_HtmlEncode($teachers->teacher_language->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_teacher_language" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_teacher_language" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_teacher_language" value="<?php echo ew_HtmlEncode($teachers->teacher_language->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_teacher_language" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_teacher_language" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_teacher_language" value="<?php echo ew_HtmlEncode($teachers->teacher_language->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->video->Visible) { // video ?>
		<td data-name="video"<?php echo $teachers->video->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_video" class="form-group teachers_video">
<textarea data-table="teachers" data-field="x_video" name="x<?php echo $teachers_grid->RowIndex ?>_video" id="x<?php echo $teachers_grid->RowIndex ?>_video" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->video->getPlaceHolder()) ?>"<?php echo $teachers->video->EditAttributes() ?>><?php echo $teachers->video->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers" data-field="x_video" name="o<?php echo $teachers_grid->RowIndex ?>_video" id="o<?php echo $teachers_grid->RowIndex ?>_video" value="<?php echo ew_HtmlEncode($teachers->video->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_video" class="form-group teachers_video">
<textarea data-table="teachers" data-field="x_video" name="x<?php echo $teachers_grid->RowIndex ?>_video" id="x<?php echo $teachers_grid->RowIndex ?>_video" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->video->getPlaceHolder()) ?>"<?php echo $teachers->video->EditAttributes() ?>><?php echo $teachers->video->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_video" class="teachers_video">
<span<?php echo $teachers->video->ViewAttributes() ?>>
<?php echo $teachers->video->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_video" name="x<?php echo $teachers_grid->RowIndex ?>_video" id="x<?php echo $teachers_grid->RowIndex ?>_video" value="<?php echo ew_HtmlEncode($teachers->video->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_video" name="o<?php echo $teachers_grid->RowIndex ?>_video" id="o<?php echo $teachers_grid->RowIndex ?>_video" value="<?php echo ew_HtmlEncode($teachers->video->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_video" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_video" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_video" value="<?php echo ew_HtmlEncode($teachers->video->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_video" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_video" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_video" value="<?php echo ew_HtmlEncode($teachers->video->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->heading_ar->Visible) { // heading_ar ?>
		<td data-name="heading_ar"<?php echo $teachers->heading_ar->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_heading_ar" class="form-group teachers_heading_ar">
<textarea data-table="teachers" data-field="x_heading_ar" name="x<?php echo $teachers_grid->RowIndex ?>_heading_ar" id="x<?php echo $teachers_grid->RowIndex ?>_heading_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->heading_ar->getPlaceHolder()) ?>"<?php echo $teachers->heading_ar->EditAttributes() ?>><?php echo $teachers->heading_ar->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers" data-field="x_heading_ar" name="o<?php echo $teachers_grid->RowIndex ?>_heading_ar" id="o<?php echo $teachers_grid->RowIndex ?>_heading_ar" value="<?php echo ew_HtmlEncode($teachers->heading_ar->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_heading_ar" class="form-group teachers_heading_ar">
<textarea data-table="teachers" data-field="x_heading_ar" name="x<?php echo $teachers_grid->RowIndex ?>_heading_ar" id="x<?php echo $teachers_grid->RowIndex ?>_heading_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->heading_ar->getPlaceHolder()) ?>"<?php echo $teachers->heading_ar->EditAttributes() ?>><?php echo $teachers->heading_ar->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_heading_ar" class="teachers_heading_ar">
<span<?php echo $teachers->heading_ar->ViewAttributes() ?>>
<?php echo $teachers->heading_ar->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_heading_ar" name="x<?php echo $teachers_grid->RowIndex ?>_heading_ar" id="x<?php echo $teachers_grid->RowIndex ?>_heading_ar" value="<?php echo ew_HtmlEncode($teachers->heading_ar->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_heading_ar" name="o<?php echo $teachers_grid->RowIndex ?>_heading_ar" id="o<?php echo $teachers_grid->RowIndex ?>_heading_ar" value="<?php echo ew_HtmlEncode($teachers->heading_ar->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_heading_ar" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_heading_ar" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_heading_ar" value="<?php echo ew_HtmlEncode($teachers->heading_ar->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_heading_ar" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_heading_ar" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_heading_ar" value="<?php echo ew_HtmlEncode($teachers->heading_ar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->description_ar->Visible) { // description_ar ?>
		<td data-name="description_ar"<?php echo $teachers->description_ar->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_description_ar" class="form-group teachers_description_ar">
<textarea data-table="teachers" data-field="x_description_ar" name="x<?php echo $teachers_grid->RowIndex ?>_description_ar" id="x<?php echo $teachers_grid->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->description_ar->getPlaceHolder()) ?>"<?php echo $teachers->description_ar->EditAttributes() ?>><?php echo $teachers->description_ar->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers" data-field="x_description_ar" name="o<?php echo $teachers_grid->RowIndex ?>_description_ar" id="o<?php echo $teachers_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers->description_ar->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_description_ar" class="form-group teachers_description_ar">
<textarea data-table="teachers" data-field="x_description_ar" name="x<?php echo $teachers_grid->RowIndex ?>_description_ar" id="x<?php echo $teachers_grid->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->description_ar->getPlaceHolder()) ?>"<?php echo $teachers->description_ar->EditAttributes() ?>><?php echo $teachers->description_ar->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_description_ar" class="teachers_description_ar">
<span<?php echo $teachers->description_ar->ViewAttributes() ?>>
<?php echo $teachers->description_ar->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_description_ar" name="x<?php echo $teachers_grid->RowIndex ?>_description_ar" id="x<?php echo $teachers_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers->description_ar->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_description_ar" name="o<?php echo $teachers_grid->RowIndex ?>_description_ar" id="o<?php echo $teachers_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers->description_ar->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_description_ar" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_description_ar" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers->description_ar->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_description_ar" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_description_ar" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers->description_ar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->heading_en->Visible) { // heading_en ?>
		<td data-name="heading_en"<?php echo $teachers->heading_en->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_heading_en" class="form-group teachers_heading_en">
<textarea data-table="teachers" data-field="x_heading_en" name="x<?php echo $teachers_grid->RowIndex ?>_heading_en" id="x<?php echo $teachers_grid->RowIndex ?>_heading_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->heading_en->getPlaceHolder()) ?>"<?php echo $teachers->heading_en->EditAttributes() ?>><?php echo $teachers->heading_en->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers" data-field="x_heading_en" name="o<?php echo $teachers_grid->RowIndex ?>_heading_en" id="o<?php echo $teachers_grid->RowIndex ?>_heading_en" value="<?php echo ew_HtmlEncode($teachers->heading_en->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_heading_en" class="form-group teachers_heading_en">
<textarea data-table="teachers" data-field="x_heading_en" name="x<?php echo $teachers_grid->RowIndex ?>_heading_en" id="x<?php echo $teachers_grid->RowIndex ?>_heading_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->heading_en->getPlaceHolder()) ?>"<?php echo $teachers->heading_en->EditAttributes() ?>><?php echo $teachers->heading_en->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_heading_en" class="teachers_heading_en">
<span<?php echo $teachers->heading_en->ViewAttributes() ?>>
<?php echo $teachers->heading_en->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_heading_en" name="x<?php echo $teachers_grid->RowIndex ?>_heading_en" id="x<?php echo $teachers_grid->RowIndex ?>_heading_en" value="<?php echo ew_HtmlEncode($teachers->heading_en->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_heading_en" name="o<?php echo $teachers_grid->RowIndex ?>_heading_en" id="o<?php echo $teachers_grid->RowIndex ?>_heading_en" value="<?php echo ew_HtmlEncode($teachers->heading_en->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_heading_en" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_heading_en" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_heading_en" value="<?php echo ew_HtmlEncode($teachers->heading_en->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_heading_en" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_heading_en" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_heading_en" value="<?php echo ew_HtmlEncode($teachers->heading_en->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->description_en->Visible) { // description_en ?>
		<td data-name="description_en"<?php echo $teachers->description_en->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_description_en" class="form-group teachers_description_en">
<textarea data-table="teachers" data-field="x_description_en" name="x<?php echo $teachers_grid->RowIndex ?>_description_en" id="x<?php echo $teachers_grid->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->description_en->getPlaceHolder()) ?>"<?php echo $teachers->description_en->EditAttributes() ?>><?php echo $teachers->description_en->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers" data-field="x_description_en" name="o<?php echo $teachers_grid->RowIndex ?>_description_en" id="o<?php echo $teachers_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers->description_en->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_description_en" class="form-group teachers_description_en">
<textarea data-table="teachers" data-field="x_description_en" name="x<?php echo $teachers_grid->RowIndex ?>_description_en" id="x<?php echo $teachers_grid->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->description_en->getPlaceHolder()) ?>"<?php echo $teachers->description_en->EditAttributes() ?>><?php echo $teachers->description_en->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_description_en" class="teachers_description_en">
<span<?php echo $teachers->description_en->ViewAttributes() ?>>
<?php echo $teachers->description_en->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_description_en" name="x<?php echo $teachers_grid->RowIndex ?>_description_en" id="x<?php echo $teachers_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers->description_en->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_description_en" name="o<?php echo $teachers_grid->RowIndex ?>_description_en" id="o<?php echo $teachers_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers->description_en->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_description_en" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_description_en" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers->description_en->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_description_en" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_description_en" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers->description_en->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->allow_express->Visible) { // allow_express ?>
		<td data-name="allow_express"<?php echo $teachers->allow_express->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_allow_express" class="form-group teachers_allow_express">
<input type="text" data-table="teachers" data-field="x_allow_express" name="x<?php echo $teachers_grid->RowIndex ?>_allow_express" id="x<?php echo $teachers_grid->RowIndex ?>_allow_express" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->allow_express->getPlaceHolder()) ?>" value="<?php echo $teachers->allow_express->EditValue ?>"<?php echo $teachers->allow_express->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers" data-field="x_allow_express" name="o<?php echo $teachers_grid->RowIndex ?>_allow_express" id="o<?php echo $teachers_grid->RowIndex ?>_allow_express" value="<?php echo ew_HtmlEncode($teachers->allow_express->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_allow_express" class="form-group teachers_allow_express">
<input type="text" data-table="teachers" data-field="x_allow_express" name="x<?php echo $teachers_grid->RowIndex ?>_allow_express" id="x<?php echo $teachers_grid->RowIndex ?>_allow_express" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->allow_express->getPlaceHolder()) ?>" value="<?php echo $teachers->allow_express->EditValue ?>"<?php echo $teachers->allow_express->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_allow_express" class="teachers_allow_express">
<span<?php echo $teachers->allow_express->ViewAttributes() ?>>
<?php echo $teachers->allow_express->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_allow_express" name="x<?php echo $teachers_grid->RowIndex ?>_allow_express" id="x<?php echo $teachers_grid->RowIndex ?>_allow_express" value="<?php echo ew_HtmlEncode($teachers->allow_express->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_allow_express" name="o<?php echo $teachers_grid->RowIndex ?>_allow_express" id="o<?php echo $teachers_grid->RowIndex ?>_allow_express" value="<?php echo ew_HtmlEncode($teachers->allow_express->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_allow_express" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_allow_express" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_allow_express" value="<?php echo ew_HtmlEncode($teachers->allow_express->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_allow_express" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_allow_express" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_allow_express" value="<?php echo ew_HtmlEncode($teachers->allow_express->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->fees->Visible) { // fees ?>
		<td data-name="fees"<?php echo $teachers->fees->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_fees" class="form-group teachers_fees">
<input type="text" data-table="teachers" data-field="x_fees" name="x<?php echo $teachers_grid->RowIndex ?>_fees" id="x<?php echo $teachers_grid->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->fees->getPlaceHolder()) ?>" value="<?php echo $teachers->fees->EditValue ?>"<?php echo $teachers->fees->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers" data-field="x_fees" name="o<?php echo $teachers_grid->RowIndex ?>_fees" id="o<?php echo $teachers_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers->fees->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_fees" class="form-group teachers_fees">
<input type="text" data-table="teachers" data-field="x_fees" name="x<?php echo $teachers_grid->RowIndex ?>_fees" id="x<?php echo $teachers_grid->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->fees->getPlaceHolder()) ?>" value="<?php echo $teachers->fees->EditValue ?>"<?php echo $teachers->fees->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_fees" class="teachers_fees">
<span<?php echo $teachers->fees->ViewAttributes() ?>>
<?php echo $teachers->fees->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_fees" name="x<?php echo $teachers_grid->RowIndex ?>_fees" id="x<?php echo $teachers_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers->fees->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_fees" name="o<?php echo $teachers_grid->RowIndex ?>_fees" id="o<?php echo $teachers_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers->fees->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_fees" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_fees" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers->fees->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_fees" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_fees" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers->fees->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id"<?php echo $teachers->currency_id->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_currency_id" class="form-group teachers_currency_id">
<input type="text" data-table="teachers" data-field="x_currency_id" name="x<?php echo $teachers_grid->RowIndex ?>_currency_id" id="x<?php echo $teachers_grid->RowIndex ?>_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->currency_id->getPlaceHolder()) ?>" value="<?php echo $teachers->currency_id->EditValue ?>"<?php echo $teachers->currency_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers" data-field="x_currency_id" name="o<?php echo $teachers_grid->RowIndex ?>_currency_id" id="o<?php echo $teachers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers->currency_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_currency_id" class="form-group teachers_currency_id">
<input type="text" data-table="teachers" data-field="x_currency_id" name="x<?php echo $teachers_grid->RowIndex ?>_currency_id" id="x<?php echo $teachers_grid->RowIndex ?>_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->currency_id->getPlaceHolder()) ?>" value="<?php echo $teachers->currency_id->EditValue ?>"<?php echo $teachers->currency_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_currency_id" class="teachers_currency_id">
<span<?php echo $teachers->currency_id->ViewAttributes() ?>>
<?php echo $teachers->currency_id->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_currency_id" name="x<?php echo $teachers_grid->RowIndex ?>_currency_id" id="x<?php echo $teachers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers->currency_id->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_currency_id" name="o<?php echo $teachers_grid->RowIndex ?>_currency_id" id="o<?php echo $teachers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers->currency_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_currency_id" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_currency_id" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers->currency_id->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_currency_id" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_currency_id" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers->currency_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->created_at->Visible) { // created_at ?>
		<td data-name="created_at"<?php echo $teachers->created_at->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_created_at" class="form-group teachers_created_at">
<input type="text" data-table="teachers" data-field="x_created_at" name="x<?php echo $teachers_grid->RowIndex ?>_created_at" id="x<?php echo $teachers_grid->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($teachers->created_at->getPlaceHolder()) ?>" value="<?php echo $teachers->created_at->EditValue ?>"<?php echo $teachers->created_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers" data-field="x_created_at" name="o<?php echo $teachers_grid->RowIndex ?>_created_at" id="o<?php echo $teachers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers->created_at->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_created_at" class="form-group teachers_created_at">
<input type="text" data-table="teachers" data-field="x_created_at" name="x<?php echo $teachers_grid->RowIndex ?>_created_at" id="x<?php echo $teachers_grid->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($teachers->created_at->getPlaceHolder()) ?>" value="<?php echo $teachers->created_at->EditValue ?>"<?php echo $teachers->created_at->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_created_at" class="teachers_created_at">
<span<?php echo $teachers->created_at->ViewAttributes() ?>>
<?php echo $teachers->created_at->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_created_at" name="x<?php echo $teachers_grid->RowIndex ?>_created_at" id="x<?php echo $teachers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers->created_at->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_created_at" name="o<?php echo $teachers_grid->RowIndex ?>_created_at" id="o<?php echo $teachers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers->created_at->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_created_at" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_created_at" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers->created_at->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_created_at" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_created_at" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers->created_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers->updated_at->Visible) { // updated_at ?>
		<td data-name="updated_at"<?php echo $teachers->updated_at->CellAttributes() ?>>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_updated_at" class="form-group teachers_updated_at">
<input type="text" data-table="teachers" data-field="x_updated_at" name="x<?php echo $teachers_grid->RowIndex ?>_updated_at" id="x<?php echo $teachers_grid->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($teachers->updated_at->getPlaceHolder()) ?>" value="<?php echo $teachers->updated_at->EditValue ?>"<?php echo $teachers->updated_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers" data-field="x_updated_at" name="o<?php echo $teachers_grid->RowIndex ?>_updated_at" id="o<?php echo $teachers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers->updated_at->OldValue) ?>">
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_updated_at" class="form-group teachers_updated_at">
<input type="text" data-table="teachers" data-field="x_updated_at" name="x<?php echo $teachers_grid->RowIndex ?>_updated_at" id="x<?php echo $teachers_grid->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($teachers->updated_at->getPlaceHolder()) ?>" value="<?php echo $teachers->updated_at->EditValue ?>"<?php echo $teachers->updated_at->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_grid->RowCnt ?>_teachers_updated_at" class="teachers_updated_at">
<span<?php echo $teachers->updated_at->ViewAttributes() ?>>
<?php echo $teachers->updated_at->ListViewValue() ?></span>
</span>
<?php if ($teachers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers" data-field="x_updated_at" name="x<?php echo $teachers_grid->RowIndex ?>_updated_at" id="x<?php echo $teachers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers->updated_at->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_updated_at" name="o<?php echo $teachers_grid->RowIndex ?>_updated_at" id="o<?php echo $teachers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers->updated_at->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers" data-field="x_updated_at" name="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_updated_at" id="fteachersgrid$x<?php echo $teachers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers->updated_at->FormValue) ?>">
<input type="hidden" data-table="teachers" data-field="x_updated_at" name="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_updated_at" id="fteachersgrid$o<?php echo $teachers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers->updated_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_grid->ListOptions->Render("body", "right", $teachers_grid->RowCnt);
?>
	</tr>
<?php if ($teachers->RowType == EW_ROWTYPE_ADD || $teachers->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fteachersgrid.UpdateOpts(<?php echo $teachers_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($teachers->CurrentAction <> "gridadd" || $teachers->CurrentMode == "copy")
		if (!$teachers_grid->Recordset->EOF) $teachers_grid->Recordset->MoveNext();
}
?>
<?php
	if ($teachers->CurrentMode == "add" || $teachers->CurrentMode == "copy" || $teachers->CurrentMode == "edit") {
		$teachers_grid->RowIndex = '$rowindex$';
		$teachers_grid->LoadRowValues();

		// Set row properties
		$teachers->ResetAttrs();
		$teachers->RowAttrs = array_merge($teachers->RowAttrs, array('data-rowindex'=>$teachers_grid->RowIndex, 'id'=>'r0_teachers', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($teachers->RowAttrs["class"], "ewTemplate");
		$teachers->RowType = EW_ROWTYPE_ADD;

		// Render row
		$teachers_grid->RenderRow();

		// Render list options
		$teachers_grid->RenderListOptions();
		$teachers_grid->StartRowCnt = 0;
?>
	<tr<?php echo $teachers->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_grid->ListOptions->Render("body", "left", $teachers_grid->RowIndex);
?>
	<?php if ($teachers->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($teachers->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_id" class="form-group teachers_id">
<span<?php echo $teachers->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_id" name="x<?php echo $teachers_grid->RowIndex ?>_id" id="x<?php echo $teachers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_id" name="o<?php echo $teachers_grid->RowIndex ?>_id" id="o<?php echo $teachers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->user_id->Visible) { // user_id ?>
		<td data-name="user_id">
<?php if ($teachers->CurrentAction <> "F") { ?>
<?php if ($teachers->user_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_teachers_user_id" class="form-group teachers_user_id">
<span<?php echo $teachers->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_grid->RowIndex ?>_user_id" name="x<?php echo $teachers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($teachers->user_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_teachers_user_id" class="form-group teachers_user_id">
<input type="text" data-table="teachers" data-field="x_user_id" name="x<?php echo $teachers_grid->RowIndex ?>_user_id" id="x<?php echo $teachers_grid->RowIndex ?>_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->user_id->getPlaceHolder()) ?>" value="<?php echo $teachers->user_id->EditValue ?>"<?php echo $teachers->user_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_user_id" class="form-group teachers_user_id">
<span<?php echo $teachers->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_user_id" name="x<?php echo $teachers_grid->RowIndex ?>_user_id" id="x<?php echo $teachers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($teachers->user_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_user_id" name="o<?php echo $teachers_grid->RowIndex ?>_user_id" id="o<?php echo $teachers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($teachers->user_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->timezone->Visible) { // timezone ?>
		<td data-name="timezone">
<?php if ($teachers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_timezone" class="form-group teachers_timezone">
<textarea data-table="teachers" data-field="x_timezone" name="x<?php echo $teachers_grid->RowIndex ?>_timezone" id="x<?php echo $teachers_grid->RowIndex ?>_timezone" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->timezone->getPlaceHolder()) ?>"<?php echo $teachers->timezone->EditAttributes() ?>><?php echo $teachers->timezone->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_timezone" class="form-group teachers_timezone">
<span<?php echo $teachers->timezone->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->timezone->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_timezone" name="x<?php echo $teachers_grid->RowIndex ?>_timezone" id="x<?php echo $teachers_grid->RowIndex ?>_timezone" value="<?php echo ew_HtmlEncode($teachers->timezone->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_timezone" name="o<?php echo $teachers_grid->RowIndex ?>_timezone" id="o<?php echo $teachers_grid->RowIndex ?>_timezone" value="<?php echo ew_HtmlEncode($teachers->timezone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->teacher_language->Visible) { // teacher_language ?>
		<td data-name="teacher_language">
<?php if ($teachers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_teacher_language" class="form-group teachers_teacher_language">
<textarea data-table="teachers" data-field="x_teacher_language" name="x<?php echo $teachers_grid->RowIndex ?>_teacher_language" id="x<?php echo $teachers_grid->RowIndex ?>_teacher_language" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->teacher_language->getPlaceHolder()) ?>"<?php echo $teachers->teacher_language->EditAttributes() ?>><?php echo $teachers->teacher_language->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_teacher_language" class="form-group teachers_teacher_language">
<span<?php echo $teachers->teacher_language->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->teacher_language->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_teacher_language" name="x<?php echo $teachers_grid->RowIndex ?>_teacher_language" id="x<?php echo $teachers_grid->RowIndex ?>_teacher_language" value="<?php echo ew_HtmlEncode($teachers->teacher_language->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_teacher_language" name="o<?php echo $teachers_grid->RowIndex ?>_teacher_language" id="o<?php echo $teachers_grid->RowIndex ?>_teacher_language" value="<?php echo ew_HtmlEncode($teachers->teacher_language->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->video->Visible) { // video ?>
		<td data-name="video">
<?php if ($teachers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_video" class="form-group teachers_video">
<textarea data-table="teachers" data-field="x_video" name="x<?php echo $teachers_grid->RowIndex ?>_video" id="x<?php echo $teachers_grid->RowIndex ?>_video" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->video->getPlaceHolder()) ?>"<?php echo $teachers->video->EditAttributes() ?>><?php echo $teachers->video->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_video" class="form-group teachers_video">
<span<?php echo $teachers->video->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->video->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_video" name="x<?php echo $teachers_grid->RowIndex ?>_video" id="x<?php echo $teachers_grid->RowIndex ?>_video" value="<?php echo ew_HtmlEncode($teachers->video->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_video" name="o<?php echo $teachers_grid->RowIndex ?>_video" id="o<?php echo $teachers_grid->RowIndex ?>_video" value="<?php echo ew_HtmlEncode($teachers->video->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->heading_ar->Visible) { // heading_ar ?>
		<td data-name="heading_ar">
<?php if ($teachers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_heading_ar" class="form-group teachers_heading_ar">
<textarea data-table="teachers" data-field="x_heading_ar" name="x<?php echo $teachers_grid->RowIndex ?>_heading_ar" id="x<?php echo $teachers_grid->RowIndex ?>_heading_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->heading_ar->getPlaceHolder()) ?>"<?php echo $teachers->heading_ar->EditAttributes() ?>><?php echo $teachers->heading_ar->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_heading_ar" class="form-group teachers_heading_ar">
<span<?php echo $teachers->heading_ar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->heading_ar->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_heading_ar" name="x<?php echo $teachers_grid->RowIndex ?>_heading_ar" id="x<?php echo $teachers_grid->RowIndex ?>_heading_ar" value="<?php echo ew_HtmlEncode($teachers->heading_ar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_heading_ar" name="o<?php echo $teachers_grid->RowIndex ?>_heading_ar" id="o<?php echo $teachers_grid->RowIndex ?>_heading_ar" value="<?php echo ew_HtmlEncode($teachers->heading_ar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->description_ar->Visible) { // description_ar ?>
		<td data-name="description_ar">
<?php if ($teachers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_description_ar" class="form-group teachers_description_ar">
<textarea data-table="teachers" data-field="x_description_ar" name="x<?php echo $teachers_grid->RowIndex ?>_description_ar" id="x<?php echo $teachers_grid->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->description_ar->getPlaceHolder()) ?>"<?php echo $teachers->description_ar->EditAttributes() ?>><?php echo $teachers->description_ar->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_description_ar" class="form-group teachers_description_ar">
<span<?php echo $teachers->description_ar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->description_ar->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_description_ar" name="x<?php echo $teachers_grid->RowIndex ?>_description_ar" id="x<?php echo $teachers_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers->description_ar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_description_ar" name="o<?php echo $teachers_grid->RowIndex ?>_description_ar" id="o<?php echo $teachers_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers->description_ar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->heading_en->Visible) { // heading_en ?>
		<td data-name="heading_en">
<?php if ($teachers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_heading_en" class="form-group teachers_heading_en">
<textarea data-table="teachers" data-field="x_heading_en" name="x<?php echo $teachers_grid->RowIndex ?>_heading_en" id="x<?php echo $teachers_grid->RowIndex ?>_heading_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->heading_en->getPlaceHolder()) ?>"<?php echo $teachers->heading_en->EditAttributes() ?>><?php echo $teachers->heading_en->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_heading_en" class="form-group teachers_heading_en">
<span<?php echo $teachers->heading_en->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->heading_en->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_heading_en" name="x<?php echo $teachers_grid->RowIndex ?>_heading_en" id="x<?php echo $teachers_grid->RowIndex ?>_heading_en" value="<?php echo ew_HtmlEncode($teachers->heading_en->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_heading_en" name="o<?php echo $teachers_grid->RowIndex ?>_heading_en" id="o<?php echo $teachers_grid->RowIndex ?>_heading_en" value="<?php echo ew_HtmlEncode($teachers->heading_en->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->description_en->Visible) { // description_en ?>
		<td data-name="description_en">
<?php if ($teachers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_description_en" class="form-group teachers_description_en">
<textarea data-table="teachers" data-field="x_description_en" name="x<?php echo $teachers_grid->RowIndex ?>_description_en" id="x<?php echo $teachers_grid->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->description_en->getPlaceHolder()) ?>"<?php echo $teachers->description_en->EditAttributes() ?>><?php echo $teachers->description_en->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_description_en" class="form-group teachers_description_en">
<span<?php echo $teachers->description_en->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->description_en->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_description_en" name="x<?php echo $teachers_grid->RowIndex ?>_description_en" id="x<?php echo $teachers_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers->description_en->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_description_en" name="o<?php echo $teachers_grid->RowIndex ?>_description_en" id="o<?php echo $teachers_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers->description_en->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->allow_express->Visible) { // allow_express ?>
		<td data-name="allow_express">
<?php if ($teachers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_allow_express" class="form-group teachers_allow_express">
<input type="text" data-table="teachers" data-field="x_allow_express" name="x<?php echo $teachers_grid->RowIndex ?>_allow_express" id="x<?php echo $teachers_grid->RowIndex ?>_allow_express" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->allow_express->getPlaceHolder()) ?>" value="<?php echo $teachers->allow_express->EditValue ?>"<?php echo $teachers->allow_express->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_allow_express" class="form-group teachers_allow_express">
<span<?php echo $teachers->allow_express->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->allow_express->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_allow_express" name="x<?php echo $teachers_grid->RowIndex ?>_allow_express" id="x<?php echo $teachers_grid->RowIndex ?>_allow_express" value="<?php echo ew_HtmlEncode($teachers->allow_express->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_allow_express" name="o<?php echo $teachers_grid->RowIndex ?>_allow_express" id="o<?php echo $teachers_grid->RowIndex ?>_allow_express" value="<?php echo ew_HtmlEncode($teachers->allow_express->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->fees->Visible) { // fees ?>
		<td data-name="fees">
<?php if ($teachers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_fees" class="form-group teachers_fees">
<input type="text" data-table="teachers" data-field="x_fees" name="x<?php echo $teachers_grid->RowIndex ?>_fees" id="x<?php echo $teachers_grid->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->fees->getPlaceHolder()) ?>" value="<?php echo $teachers->fees->EditValue ?>"<?php echo $teachers->fees->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_fees" class="form-group teachers_fees">
<span<?php echo $teachers->fees->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->fees->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_fees" name="x<?php echo $teachers_grid->RowIndex ?>_fees" id="x<?php echo $teachers_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers->fees->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_fees" name="o<?php echo $teachers_grid->RowIndex ?>_fees" id="o<?php echo $teachers_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers->fees->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id">
<?php if ($teachers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_currency_id" class="form-group teachers_currency_id">
<input type="text" data-table="teachers" data-field="x_currency_id" name="x<?php echo $teachers_grid->RowIndex ?>_currency_id" id="x<?php echo $teachers_grid->RowIndex ?>_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->currency_id->getPlaceHolder()) ?>" value="<?php echo $teachers->currency_id->EditValue ?>"<?php echo $teachers->currency_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_currency_id" class="form-group teachers_currency_id">
<span<?php echo $teachers->currency_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->currency_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_currency_id" name="x<?php echo $teachers_grid->RowIndex ?>_currency_id" id="x<?php echo $teachers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers->currency_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_currency_id" name="o<?php echo $teachers_grid->RowIndex ?>_currency_id" id="o<?php echo $teachers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers->currency_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->created_at->Visible) { // created_at ?>
		<td data-name="created_at">
<?php if ($teachers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_created_at" class="form-group teachers_created_at">
<input type="text" data-table="teachers" data-field="x_created_at" name="x<?php echo $teachers_grid->RowIndex ?>_created_at" id="x<?php echo $teachers_grid->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($teachers->created_at->getPlaceHolder()) ?>" value="<?php echo $teachers->created_at->EditValue ?>"<?php echo $teachers->created_at->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_created_at" class="form-group teachers_created_at">
<span<?php echo $teachers->created_at->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->created_at->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_created_at" name="x<?php echo $teachers_grid->RowIndex ?>_created_at" id="x<?php echo $teachers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers->created_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_created_at" name="o<?php echo $teachers_grid->RowIndex ?>_created_at" id="o<?php echo $teachers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers->created_at->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers->updated_at->Visible) { // updated_at ?>
		<td data-name="updated_at">
<?php if ($teachers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_updated_at" class="form-group teachers_updated_at">
<input type="text" data-table="teachers" data-field="x_updated_at" name="x<?php echo $teachers_grid->RowIndex ?>_updated_at" id="x<?php echo $teachers_grid->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($teachers->updated_at->getPlaceHolder()) ?>" value="<?php echo $teachers->updated_at->EditValue ?>"<?php echo $teachers->updated_at->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_updated_at" class="form-group teachers_updated_at">
<span<?php echo $teachers->updated_at->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->updated_at->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_updated_at" name="x<?php echo $teachers_grid->RowIndex ?>_updated_at" id="x<?php echo $teachers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers->updated_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers" data-field="x_updated_at" name="o<?php echo $teachers_grid->RowIndex ?>_updated_at" id="o<?php echo $teachers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers->updated_at->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_grid->ListOptions->Render("body", "right", $teachers_grid->RowIndex);
?>
<script type="text/javascript">
fteachersgrid.UpdateOpts(<?php echo $teachers_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($teachers->CurrentMode == "add" || $teachers->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $teachers_grid->FormKeyCountName ?>" id="<?php echo $teachers_grid->FormKeyCountName ?>" value="<?php echo $teachers_grid->KeyCount ?>">
<?php echo $teachers_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $teachers_grid->FormKeyCountName ?>" id="<?php echo $teachers_grid->FormKeyCountName ?>" value="<?php echo $teachers_grid->KeyCount ?>">
<?php echo $teachers_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fteachersgrid">
</div>
<?php

// Close recordset
if ($teachers_grid->Recordset)
	$teachers_grid->Recordset->Close();
?>
<?php if ($teachers_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($teachers_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($teachers_grid->TotalRecs == 0 && $teachers->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($teachers->Export == "") { ?>
<script type="text/javascript">
fteachersgrid.Init();
</script>
<?php } ?>
<?php
$teachers_grid->Page_Terminate();
?>
