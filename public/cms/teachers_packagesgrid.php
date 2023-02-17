<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($teachers_packages_grid)) $teachers_packages_grid = new cteachers_packages_grid();

// Page init
$teachers_packages_grid->Page_Init();

// Page main
$teachers_packages_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_packages_grid->Page_Render();
?>
<?php if ($teachers_packages->Export == "") { ?>
<script type="text/javascript">

// Form object
var fteachers_packagesgrid = new ew_Form("fteachers_packagesgrid", "grid");
fteachers_packagesgrid.FormKeyCountName = '<?php echo $teachers_packages_grid->FormKeyCountName ?>';

// Validate form
fteachers_packagesgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->teacher_id->FldCaption(), $teachers_packages->teacher_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_packages->teacher_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_title_en");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->title_en->FldCaption(), $teachers_packages->title_en->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_title_ar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->title_ar->FldCaption(), $teachers_packages->title_ar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_description_en");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->description_en->FldCaption(), $teachers_packages->description_en->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_description_ar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->description_ar->FldCaption(), $teachers_packages->description_ar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_image");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->image->FldCaption(), $teachers_packages->image->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fees");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->fees->FldCaption(), $teachers_packages->fees->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fees");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_packages->fees->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->currency_id->FldCaption(), $teachers_packages->currency_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_packages->currency_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->created_at->FldCaption(), $teachers_packages->created_at->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_packages->created_at->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_updated_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_packages->updated_at->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fteachers_packagesgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "teacher_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "title_en", false)) return false;
	if (ew_ValueChanged(fobj, infix, "title_ar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "description_en", false)) return false;
	if (ew_ValueChanged(fobj, infix, "description_ar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "image", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fees", false)) return false;
	if (ew_ValueChanged(fobj, infix, "currency_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "created_at", false)) return false;
	if (ew_ValueChanged(fobj, infix, "updated_at", false)) return false;
	return true;
}

// Form_CustomValidate event
fteachers_packagesgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachers_packagesgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($teachers_packages->CurrentAction == "gridadd") {
	if ($teachers_packages->CurrentMode == "copy") {
		$bSelectLimit = $teachers_packages_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$teachers_packages_grid->TotalRecs = $teachers_packages->ListRecordCount();
			$teachers_packages_grid->Recordset = $teachers_packages_grid->LoadRecordset($teachers_packages_grid->StartRec-1, $teachers_packages_grid->DisplayRecs);
		} else {
			if ($teachers_packages_grid->Recordset = $teachers_packages_grid->LoadRecordset())
				$teachers_packages_grid->TotalRecs = $teachers_packages_grid->Recordset->RecordCount();
		}
		$teachers_packages_grid->StartRec = 1;
		$teachers_packages_grid->DisplayRecs = $teachers_packages_grid->TotalRecs;
	} else {
		$teachers_packages->CurrentFilter = "0=1";
		$teachers_packages_grid->StartRec = 1;
		$teachers_packages_grid->DisplayRecs = $teachers_packages->GridAddRowCount;
	}
	$teachers_packages_grid->TotalRecs = $teachers_packages_grid->DisplayRecs;
	$teachers_packages_grid->StopRec = $teachers_packages_grid->DisplayRecs;
} else {
	$bSelectLimit = $teachers_packages_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($teachers_packages_grid->TotalRecs <= 0)
			$teachers_packages_grid->TotalRecs = $teachers_packages->ListRecordCount();
	} else {
		if (!$teachers_packages_grid->Recordset && ($teachers_packages_grid->Recordset = $teachers_packages_grid->LoadRecordset()))
			$teachers_packages_grid->TotalRecs = $teachers_packages_grid->Recordset->RecordCount();
	}
	$teachers_packages_grid->StartRec = 1;
	$teachers_packages_grid->DisplayRecs = $teachers_packages_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$teachers_packages_grid->Recordset = $teachers_packages_grid->LoadRecordset($teachers_packages_grid->StartRec-1, $teachers_packages_grid->DisplayRecs);

	// Set no record found message
	if ($teachers_packages->CurrentAction == "" && $teachers_packages_grid->TotalRecs == 0) {
		if ($teachers_packages_grid->SearchWhere == "0=101")
			$teachers_packages_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$teachers_packages_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$teachers_packages_grid->RenderOtherOptions();
?>
<?php $teachers_packages_grid->ShowPageHeader(); ?>
<?php
$teachers_packages_grid->ShowMessage();
?>
<?php if ($teachers_packages_grid->TotalRecs > 0 || $teachers_packages->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($teachers_packages_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> teachers_packages">
<div id="fteachers_packagesgrid" class="ewForm ewListForm form-inline">
<?php if ($teachers_packages_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($teachers_packages_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_teachers_packages" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_teachers_packagesgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$teachers_packages_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$teachers_packages_grid->RenderListOptions();

// Render list options (header, left)
$teachers_packages_grid->ListOptions->Render("header", "left");
?>
<?php if ($teachers_packages->id->Visible) { // id ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->id) == "") { ?>
		<th data-name="id" class="<?php echo $teachers_packages->id->HeaderCellClass() ?>"><div id="elh_teachers_packages_id" class="teachers_packages_id"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $teachers_packages->id->HeaderCellClass() ?>"><div><div id="elh_teachers_packages_id" class="teachers_packages_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->teacher_id->Visible) { // teacher_id ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->teacher_id) == "") { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_packages->teacher_id->HeaderCellClass() ?>"><div id="elh_teachers_packages_teacher_id" class="teachers_packages_teacher_id"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->teacher_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_packages->teacher_id->HeaderCellClass() ?>"><div><div id="elh_teachers_packages_teacher_id" class="teachers_packages_teacher_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->teacher_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->teacher_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->teacher_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->title_en->Visible) { // title_en ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->title_en) == "") { ?>
		<th data-name="title_en" class="<?php echo $teachers_packages->title_en->HeaderCellClass() ?>"><div id="elh_teachers_packages_title_en" class="teachers_packages_title_en"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->title_en->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title_en" class="<?php echo $teachers_packages->title_en->HeaderCellClass() ?>"><div><div id="elh_teachers_packages_title_en" class="teachers_packages_title_en">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->title_en->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->title_en->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->title_en->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->title_ar->Visible) { // title_ar ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->title_ar) == "") { ?>
		<th data-name="title_ar" class="<?php echo $teachers_packages->title_ar->HeaderCellClass() ?>"><div id="elh_teachers_packages_title_ar" class="teachers_packages_title_ar"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->title_ar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title_ar" class="<?php echo $teachers_packages->title_ar->HeaderCellClass() ?>"><div><div id="elh_teachers_packages_title_ar" class="teachers_packages_title_ar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->title_ar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->title_ar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->title_ar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->description_en->Visible) { // description_en ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->description_en) == "") { ?>
		<th data-name="description_en" class="<?php echo $teachers_packages->description_en->HeaderCellClass() ?>"><div id="elh_teachers_packages_description_en" class="teachers_packages_description_en"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->description_en->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description_en" class="<?php echo $teachers_packages->description_en->HeaderCellClass() ?>"><div><div id="elh_teachers_packages_description_en" class="teachers_packages_description_en">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->description_en->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->description_en->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->description_en->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->description_ar->Visible) { // description_ar ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->description_ar) == "") { ?>
		<th data-name="description_ar" class="<?php echo $teachers_packages->description_ar->HeaderCellClass() ?>"><div id="elh_teachers_packages_description_ar" class="teachers_packages_description_ar"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->description_ar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description_ar" class="<?php echo $teachers_packages->description_ar->HeaderCellClass() ?>"><div><div id="elh_teachers_packages_description_ar" class="teachers_packages_description_ar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->description_ar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->description_ar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->description_ar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->image->Visible) { // image ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->image) == "") { ?>
		<th data-name="image" class="<?php echo $teachers_packages->image->HeaderCellClass() ?>"><div id="elh_teachers_packages_image" class="teachers_packages_image"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="image" class="<?php echo $teachers_packages->image->HeaderCellClass() ?>"><div><div id="elh_teachers_packages_image" class="teachers_packages_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->image->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->fees->Visible) { // fees ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->fees) == "") { ?>
		<th data-name="fees" class="<?php echo $teachers_packages->fees->HeaderCellClass() ?>"><div id="elh_teachers_packages_fees" class="teachers_packages_fees"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->fees->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fees" class="<?php echo $teachers_packages->fees->HeaderCellClass() ?>"><div><div id="elh_teachers_packages_fees" class="teachers_packages_fees">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->fees->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->fees->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->fees->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->currency_id->Visible) { // currency_id ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->currency_id) == "") { ?>
		<th data-name="currency_id" class="<?php echo $teachers_packages->currency_id->HeaderCellClass() ?>"><div id="elh_teachers_packages_currency_id" class="teachers_packages_currency_id"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->currency_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency_id" class="<?php echo $teachers_packages->currency_id->HeaderCellClass() ?>"><div><div id="elh_teachers_packages_currency_id" class="teachers_packages_currency_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->currency_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->currency_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->currency_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->created_at->Visible) { // created_at ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->created_at) == "") { ?>
		<th data-name="created_at" class="<?php echo $teachers_packages->created_at->HeaderCellClass() ?>"><div id="elh_teachers_packages_created_at" class="teachers_packages_created_at"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->created_at->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="created_at" class="<?php echo $teachers_packages->created_at->HeaderCellClass() ?>"><div><div id="elh_teachers_packages_created_at" class="teachers_packages_created_at">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->created_at->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->created_at->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->created_at->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->updated_at->Visible) { // updated_at ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->updated_at) == "") { ?>
		<th data-name="updated_at" class="<?php echo $teachers_packages->updated_at->HeaderCellClass() ?>"><div id="elh_teachers_packages_updated_at" class="teachers_packages_updated_at"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->updated_at->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="updated_at" class="<?php echo $teachers_packages->updated_at->HeaderCellClass() ?>"><div><div id="elh_teachers_packages_updated_at" class="teachers_packages_updated_at">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->updated_at->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->updated_at->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->updated_at->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$teachers_packages_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$teachers_packages_grid->StartRec = 1;
$teachers_packages_grid->StopRec = $teachers_packages_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($teachers_packages_grid->FormKeyCountName) && ($teachers_packages->CurrentAction == "gridadd" || $teachers_packages->CurrentAction == "gridedit" || $teachers_packages->CurrentAction == "F")) {
		$teachers_packages_grid->KeyCount = $objForm->GetValue($teachers_packages_grid->FormKeyCountName);
		$teachers_packages_grid->StopRec = $teachers_packages_grid->StartRec + $teachers_packages_grid->KeyCount - 1;
	}
}
$teachers_packages_grid->RecCnt = $teachers_packages_grid->StartRec - 1;
if ($teachers_packages_grid->Recordset && !$teachers_packages_grid->Recordset->EOF) {
	$teachers_packages_grid->Recordset->MoveFirst();
	$bSelectLimit = $teachers_packages_grid->UseSelectLimit;
	if (!$bSelectLimit && $teachers_packages_grid->StartRec > 1)
		$teachers_packages_grid->Recordset->Move($teachers_packages_grid->StartRec - 1);
} elseif (!$teachers_packages->AllowAddDeleteRow && $teachers_packages_grid->StopRec == 0) {
	$teachers_packages_grid->StopRec = $teachers_packages->GridAddRowCount;
}

// Initialize aggregate
$teachers_packages->RowType = EW_ROWTYPE_AGGREGATEINIT;
$teachers_packages->ResetAttrs();
$teachers_packages_grid->RenderRow();
if ($teachers_packages->CurrentAction == "gridadd")
	$teachers_packages_grid->RowIndex = 0;
if ($teachers_packages->CurrentAction == "gridedit")
	$teachers_packages_grid->RowIndex = 0;
while ($teachers_packages_grid->RecCnt < $teachers_packages_grid->StopRec) {
	$teachers_packages_grid->RecCnt++;
	if (intval($teachers_packages_grid->RecCnt) >= intval($teachers_packages_grid->StartRec)) {
		$teachers_packages_grid->RowCnt++;
		if ($teachers_packages->CurrentAction == "gridadd" || $teachers_packages->CurrentAction == "gridedit" || $teachers_packages->CurrentAction == "F") {
			$teachers_packages_grid->RowIndex++;
			$objForm->Index = $teachers_packages_grid->RowIndex;
			if ($objForm->HasValue($teachers_packages_grid->FormActionName))
				$teachers_packages_grid->RowAction = strval($objForm->GetValue($teachers_packages_grid->FormActionName));
			elseif ($teachers_packages->CurrentAction == "gridadd")
				$teachers_packages_grid->RowAction = "insert";
			else
				$teachers_packages_grid->RowAction = "";
		}

		// Set up key count
		$teachers_packages_grid->KeyCount = $teachers_packages_grid->RowIndex;

		// Init row class and style
		$teachers_packages->ResetAttrs();
		$teachers_packages->CssClass = "";
		if ($teachers_packages->CurrentAction == "gridadd") {
			if ($teachers_packages->CurrentMode == "copy") {
				$teachers_packages_grid->LoadRowValues($teachers_packages_grid->Recordset); // Load row values
				$teachers_packages_grid->SetRecordKey($teachers_packages_grid->RowOldKey, $teachers_packages_grid->Recordset); // Set old record key
			} else {
				$teachers_packages_grid->LoadRowValues(); // Load default values
				$teachers_packages_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$teachers_packages_grid->LoadRowValues($teachers_packages_grid->Recordset); // Load row values
		}
		$teachers_packages->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($teachers_packages->CurrentAction == "gridadd") // Grid add
			$teachers_packages->RowType = EW_ROWTYPE_ADD; // Render add
		if ($teachers_packages->CurrentAction == "gridadd" && $teachers_packages->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$teachers_packages_grid->RestoreCurrentRowFormValues($teachers_packages_grid->RowIndex); // Restore form values
		if ($teachers_packages->CurrentAction == "gridedit") { // Grid edit
			if ($teachers_packages->EventCancelled) {
				$teachers_packages_grid->RestoreCurrentRowFormValues($teachers_packages_grid->RowIndex); // Restore form values
			}
			if ($teachers_packages_grid->RowAction == "insert")
				$teachers_packages->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$teachers_packages->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($teachers_packages->CurrentAction == "gridedit" && ($teachers_packages->RowType == EW_ROWTYPE_EDIT || $teachers_packages->RowType == EW_ROWTYPE_ADD) && $teachers_packages->EventCancelled) // Update failed
			$teachers_packages_grid->RestoreCurrentRowFormValues($teachers_packages_grid->RowIndex); // Restore form values
		if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) // Edit row
			$teachers_packages_grid->EditRowCnt++;
		if ($teachers_packages->CurrentAction == "F") // Confirm row
			$teachers_packages_grid->RestoreCurrentRowFormValues($teachers_packages_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$teachers_packages->RowAttrs = array_merge($teachers_packages->RowAttrs, array('data-rowindex'=>$teachers_packages_grid->RowCnt, 'id'=>'r' . $teachers_packages_grid->RowCnt . '_teachers_packages', 'data-rowtype'=>$teachers_packages->RowType));

		// Render row
		$teachers_packages_grid->RenderRow();

		// Render list options
		$teachers_packages_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($teachers_packages_grid->RowAction <> "delete" && $teachers_packages_grid->RowAction <> "insertdelete" && !($teachers_packages_grid->RowAction == "insert" && $teachers_packages->CurrentAction == "F" && $teachers_packages_grid->EmptyRow())) {
?>
	<tr<?php echo $teachers_packages->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_packages_grid->ListOptions->Render("body", "left", $teachers_packages_grid->RowCnt);
?>
	<?php if ($teachers_packages->id->Visible) { // id ?>
		<td data-name="id"<?php echo $teachers_packages->id->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="teachers_packages" data-field="x_id" name="o<?php echo $teachers_packages_grid->RowIndex ?>_id" id="o<?php echo $teachers_packages_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_packages->id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_id" class="form-group teachers_packages_id">
<span<?php echo $teachers_packages->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_packages->id->CurrentValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_id" class="teachers_packages_id">
<span<?php echo $teachers_packages->id->ViewAttributes() ?>>
<?php echo $teachers_packages->id->ListViewValue() ?></span>
</span>
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_packages->id->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_id" name="o<?php echo $teachers_packages_grid->RowIndex ?>_id" id="o<?php echo $teachers_packages_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_packages->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_id" name="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_id" id="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_packages->id->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_id" name="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_id" id="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_packages->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id"<?php echo $teachers_packages->teacher_id->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($teachers_packages->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<span<?php echo $teachers_packages->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<input type="text" data-table="teachers_packages" data-field="x_teacher_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->teacher_id->EditValue ?>"<?php echo $teachers_packages->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" name="o<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($teachers_packages->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<span<?php echo $teachers_packages->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<input type="text" data-table="teachers_packages" data-field="x_teacher_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->teacher_id->EditValue ?>"<?php echo $teachers_packages->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_teacher_id" class="teachers_packages_teacher_id">
<span<?php echo $teachers_packages->teacher_id->ViewAttributes() ?>>
<?php echo $teachers_packages->teacher_id->ListViewValue() ?></span>
</span>
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" name="o<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" name="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" id="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" name="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" id="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->title_en->Visible) { // title_en ?>
		<td data-name="title_en"<?php echo $teachers_packages->title_en->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_title_en" class="form-group teachers_packages_title_en">
<textarea data-table="teachers_packages" data-field="x_title_en" name="x<?php echo $teachers_packages_grid->RowIndex ?>_title_en" id="x<?php echo $teachers_packages_grid->RowIndex ?>_title_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->title_en->getPlaceHolder()) ?>"<?php echo $teachers_packages->title_en->EditAttributes() ?>><?php echo $teachers_packages->title_en->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" name="o<?php echo $teachers_packages_grid->RowIndex ?>_title_en" id="o<?php echo $teachers_packages_grid->RowIndex ?>_title_en" value="<?php echo ew_HtmlEncode($teachers_packages->title_en->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_title_en" class="form-group teachers_packages_title_en">
<textarea data-table="teachers_packages" data-field="x_title_en" name="x<?php echo $teachers_packages_grid->RowIndex ?>_title_en" id="x<?php echo $teachers_packages_grid->RowIndex ?>_title_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->title_en->getPlaceHolder()) ?>"<?php echo $teachers_packages->title_en->EditAttributes() ?>><?php echo $teachers_packages->title_en->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_title_en" class="teachers_packages_title_en">
<span<?php echo $teachers_packages->title_en->ViewAttributes() ?>>
<?php echo $teachers_packages->title_en->ListViewValue() ?></span>
</span>
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" name="x<?php echo $teachers_packages_grid->RowIndex ?>_title_en" id="x<?php echo $teachers_packages_grid->RowIndex ?>_title_en" value="<?php echo ew_HtmlEncode($teachers_packages->title_en->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" name="o<?php echo $teachers_packages_grid->RowIndex ?>_title_en" id="o<?php echo $teachers_packages_grid->RowIndex ?>_title_en" value="<?php echo ew_HtmlEncode($teachers_packages->title_en->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" name="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_title_en" id="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_title_en" value="<?php echo ew_HtmlEncode($teachers_packages->title_en->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" name="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_title_en" id="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_title_en" value="<?php echo ew_HtmlEncode($teachers_packages->title_en->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->title_ar->Visible) { // title_ar ?>
		<td data-name="title_ar"<?php echo $teachers_packages->title_ar->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_title_ar" class="form-group teachers_packages_title_ar">
<textarea data-table="teachers_packages" data-field="x_title_ar" name="x<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" id="x<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->title_ar->getPlaceHolder()) ?>"<?php echo $teachers_packages->title_ar->EditAttributes() ?>><?php echo $teachers_packages->title_ar->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" name="o<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" id="o<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" value="<?php echo ew_HtmlEncode($teachers_packages->title_ar->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_title_ar" class="form-group teachers_packages_title_ar">
<textarea data-table="teachers_packages" data-field="x_title_ar" name="x<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" id="x<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->title_ar->getPlaceHolder()) ?>"<?php echo $teachers_packages->title_ar->EditAttributes() ?>><?php echo $teachers_packages->title_ar->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_title_ar" class="teachers_packages_title_ar">
<span<?php echo $teachers_packages->title_ar->ViewAttributes() ?>>
<?php echo $teachers_packages->title_ar->ListViewValue() ?></span>
</span>
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" name="x<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" id="x<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" value="<?php echo ew_HtmlEncode($teachers_packages->title_ar->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" name="o<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" id="o<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" value="<?php echo ew_HtmlEncode($teachers_packages->title_ar->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" name="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" id="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" value="<?php echo ew_HtmlEncode($teachers_packages->title_ar->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" name="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" id="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" value="<?php echo ew_HtmlEncode($teachers_packages->title_ar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->description_en->Visible) { // description_en ?>
		<td data-name="description_en"<?php echo $teachers_packages->description_en->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_description_en" class="form-group teachers_packages_description_en">
<textarea data-table="teachers_packages" data-field="x_description_en" name="x<?php echo $teachers_packages_grid->RowIndex ?>_description_en" id="x<?php echo $teachers_packages_grid->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->description_en->getPlaceHolder()) ?>"<?php echo $teachers_packages->description_en->EditAttributes() ?>><?php echo $teachers_packages->description_en->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" name="o<?php echo $teachers_packages_grid->RowIndex ?>_description_en" id="o<?php echo $teachers_packages_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers_packages->description_en->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_description_en" class="form-group teachers_packages_description_en">
<textarea data-table="teachers_packages" data-field="x_description_en" name="x<?php echo $teachers_packages_grid->RowIndex ?>_description_en" id="x<?php echo $teachers_packages_grid->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->description_en->getPlaceHolder()) ?>"<?php echo $teachers_packages->description_en->EditAttributes() ?>><?php echo $teachers_packages->description_en->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_description_en" class="teachers_packages_description_en">
<span<?php echo $teachers_packages->description_en->ViewAttributes() ?>>
<?php echo $teachers_packages->description_en->ListViewValue() ?></span>
</span>
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" name="x<?php echo $teachers_packages_grid->RowIndex ?>_description_en" id="x<?php echo $teachers_packages_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers_packages->description_en->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" name="o<?php echo $teachers_packages_grid->RowIndex ?>_description_en" id="o<?php echo $teachers_packages_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers_packages->description_en->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" name="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_description_en" id="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers_packages->description_en->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" name="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_description_en" id="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers_packages->description_en->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->description_ar->Visible) { // description_ar ?>
		<td data-name="description_ar"<?php echo $teachers_packages->description_ar->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_description_ar" class="form-group teachers_packages_description_ar">
<textarea data-table="teachers_packages" data-field="x_description_ar" name="x<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" id="x<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->description_ar->getPlaceHolder()) ?>"<?php echo $teachers_packages->description_ar->EditAttributes() ?>><?php echo $teachers_packages->description_ar->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" name="o<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" id="o<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers_packages->description_ar->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_description_ar" class="form-group teachers_packages_description_ar">
<textarea data-table="teachers_packages" data-field="x_description_ar" name="x<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" id="x<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->description_ar->getPlaceHolder()) ?>"<?php echo $teachers_packages->description_ar->EditAttributes() ?>><?php echo $teachers_packages->description_ar->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_description_ar" class="teachers_packages_description_ar">
<span<?php echo $teachers_packages->description_ar->ViewAttributes() ?>>
<?php echo $teachers_packages->description_ar->ListViewValue() ?></span>
</span>
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" name="x<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" id="x<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers_packages->description_ar->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" name="o<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" id="o<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers_packages->description_ar->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" name="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" id="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers_packages->description_ar->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" name="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" id="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers_packages->description_ar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->image->Visible) { // image ?>
		<td data-name="image"<?php echo $teachers_packages->image->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_image" class="form-group teachers_packages_image">
<textarea data-table="teachers_packages" data-field="x_image" name="x<?php echo $teachers_packages_grid->RowIndex ?>_image" id="x<?php echo $teachers_packages_grid->RowIndex ?>_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->image->getPlaceHolder()) ?>"<?php echo $teachers_packages->image->EditAttributes() ?>><?php echo $teachers_packages->image->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_image" name="o<?php echo $teachers_packages_grid->RowIndex ?>_image" id="o<?php echo $teachers_packages_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_packages->image->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_image" class="form-group teachers_packages_image">
<textarea data-table="teachers_packages" data-field="x_image" name="x<?php echo $teachers_packages_grid->RowIndex ?>_image" id="x<?php echo $teachers_packages_grid->RowIndex ?>_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->image->getPlaceHolder()) ?>"<?php echo $teachers_packages->image->EditAttributes() ?>><?php echo $teachers_packages->image->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_image" class="teachers_packages_image">
<span<?php echo $teachers_packages->image->ViewAttributes() ?>>
<?php echo $teachers_packages->image->ListViewValue() ?></span>
</span>
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_image" name="x<?php echo $teachers_packages_grid->RowIndex ?>_image" id="x<?php echo $teachers_packages_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_packages->image->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_image" name="o<?php echo $teachers_packages_grid->RowIndex ?>_image" id="o<?php echo $teachers_packages_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_packages->image->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_image" name="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_image" id="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_packages->image->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_image" name="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_image" id="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_packages->image->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->fees->Visible) { // fees ?>
		<td data-name="fees"<?php echo $teachers_packages->fees->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_fees" class="form-group teachers_packages_fees">
<input type="text" data-table="teachers_packages" data-field="x_fees" name="x<?php echo $teachers_packages_grid->RowIndex ?>_fees" id="x<?php echo $teachers_packages_grid->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->fees->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->fees->EditValue ?>"<?php echo $teachers_packages->fees->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_fees" name="o<?php echo $teachers_packages_grid->RowIndex ?>_fees" id="o<?php echo $teachers_packages_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers_packages->fees->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_fees" class="form-group teachers_packages_fees">
<input type="text" data-table="teachers_packages" data-field="x_fees" name="x<?php echo $teachers_packages_grid->RowIndex ?>_fees" id="x<?php echo $teachers_packages_grid->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->fees->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->fees->EditValue ?>"<?php echo $teachers_packages->fees->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_fees" class="teachers_packages_fees">
<span<?php echo $teachers_packages->fees->ViewAttributes() ?>>
<?php echo $teachers_packages->fees->ListViewValue() ?></span>
</span>
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_fees" name="x<?php echo $teachers_packages_grid->RowIndex ?>_fees" id="x<?php echo $teachers_packages_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers_packages->fees->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_fees" name="o<?php echo $teachers_packages_grid->RowIndex ?>_fees" id="o<?php echo $teachers_packages_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers_packages->fees->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_fees" name="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_fees" id="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers_packages->fees->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_fees" name="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_fees" id="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers_packages->fees->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id"<?php echo $teachers_packages->currency_id->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_currency_id" class="form-group teachers_packages_currency_id">
<input type="text" data-table="teachers_packages" data-field="x_currency_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->currency_id->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->currency_id->EditValue ?>"<?php echo $teachers_packages->currency_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" name="o<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" id="o<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers_packages->currency_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_currency_id" class="form-group teachers_packages_currency_id">
<input type="text" data-table="teachers_packages" data-field="x_currency_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->currency_id->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->currency_id->EditValue ?>"<?php echo $teachers_packages->currency_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_currency_id" class="teachers_packages_currency_id">
<span<?php echo $teachers_packages->currency_id->ViewAttributes() ?>>
<?php echo $teachers_packages->currency_id->ListViewValue() ?></span>
</span>
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers_packages->currency_id->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" name="o<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" id="o<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers_packages->currency_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" name="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" id="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers_packages->currency_id->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" name="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" id="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers_packages->currency_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->created_at->Visible) { // created_at ?>
		<td data-name="created_at"<?php echo $teachers_packages->created_at->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_created_at" class="form-group teachers_packages_created_at">
<input type="text" data-table="teachers_packages" data-field="x_created_at" name="x<?php echo $teachers_packages_grid->RowIndex ?>_created_at" id="x<?php echo $teachers_packages_grid->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($teachers_packages->created_at->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->created_at->EditValue ?>"<?php echo $teachers_packages->created_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" name="o<?php echo $teachers_packages_grid->RowIndex ?>_created_at" id="o<?php echo $teachers_packages_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers_packages->created_at->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_created_at" class="form-group teachers_packages_created_at">
<input type="text" data-table="teachers_packages" data-field="x_created_at" name="x<?php echo $teachers_packages_grid->RowIndex ?>_created_at" id="x<?php echo $teachers_packages_grid->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($teachers_packages->created_at->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->created_at->EditValue ?>"<?php echo $teachers_packages->created_at->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_created_at" class="teachers_packages_created_at">
<span<?php echo $teachers_packages->created_at->ViewAttributes() ?>>
<?php echo $teachers_packages->created_at->ListViewValue() ?></span>
</span>
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" name="x<?php echo $teachers_packages_grid->RowIndex ?>_created_at" id="x<?php echo $teachers_packages_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers_packages->created_at->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" name="o<?php echo $teachers_packages_grid->RowIndex ?>_created_at" id="o<?php echo $teachers_packages_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers_packages->created_at->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" name="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_created_at" id="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers_packages->created_at->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" name="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_created_at" id="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers_packages->created_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->updated_at->Visible) { // updated_at ?>
		<td data-name="updated_at"<?php echo $teachers_packages->updated_at->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_updated_at" class="form-group teachers_packages_updated_at">
<input type="text" data-table="teachers_packages" data-field="x_updated_at" name="x<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" id="x<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($teachers_packages->updated_at->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->updated_at->EditValue ?>"<?php echo $teachers_packages->updated_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_updated_at" name="o<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" id="o<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers_packages->updated_at->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_updated_at" class="form-group teachers_packages_updated_at">
<input type="text" data-table="teachers_packages" data-field="x_updated_at" name="x<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" id="x<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($teachers_packages->updated_at->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->updated_at->EditValue ?>"<?php echo $teachers_packages->updated_at->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_grid->RowCnt ?>_teachers_packages_updated_at" class="teachers_packages_updated_at">
<span<?php echo $teachers_packages->updated_at->ViewAttributes() ?>>
<?php echo $teachers_packages->updated_at->ListViewValue() ?></span>
</span>
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_updated_at" name="x<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" id="x<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers_packages->updated_at->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_updated_at" name="o<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" id="o<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers_packages->updated_at->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="teachers_packages" data-field="x_updated_at" name="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" id="fteachers_packagesgrid$x<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers_packages->updated_at->FormValue) ?>">
<input type="hidden" data-table="teachers_packages" data-field="x_updated_at" name="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" id="fteachers_packagesgrid$o<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers_packages->updated_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_packages_grid->ListOptions->Render("body", "right", $teachers_packages_grid->RowCnt);
?>
	</tr>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD || $teachers_packages->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fteachers_packagesgrid.UpdateOpts(<?php echo $teachers_packages_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($teachers_packages->CurrentAction <> "gridadd" || $teachers_packages->CurrentMode == "copy")
		if (!$teachers_packages_grid->Recordset->EOF) $teachers_packages_grid->Recordset->MoveNext();
}
?>
<?php
	if ($teachers_packages->CurrentMode == "add" || $teachers_packages->CurrentMode == "copy" || $teachers_packages->CurrentMode == "edit") {
		$teachers_packages_grid->RowIndex = '$rowindex$';
		$teachers_packages_grid->LoadRowValues();

		// Set row properties
		$teachers_packages->ResetAttrs();
		$teachers_packages->RowAttrs = array_merge($teachers_packages->RowAttrs, array('data-rowindex'=>$teachers_packages_grid->RowIndex, 'id'=>'r0_teachers_packages', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($teachers_packages->RowAttrs["class"], "ewTemplate");
		$teachers_packages->RowType = EW_ROWTYPE_ADD;

		// Render row
		$teachers_packages_grid->RenderRow();

		// Render list options
		$teachers_packages_grid->RenderListOptions();
		$teachers_packages_grid->StartRowCnt = 0;
?>
	<tr<?php echo $teachers_packages->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_packages_grid->ListOptions->Render("body", "left", $teachers_packages_grid->RowIndex);
?>
	<?php if ($teachers_packages->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_id" class="form-group teachers_packages_id">
<span<?php echo $teachers_packages->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_packages->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_id" name="o<?php echo $teachers_packages_grid->RowIndex ?>_id" id="o<?php echo $teachers_packages_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_packages->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id">
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<?php if ($teachers_packages->teacher_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<span<?php echo $teachers_packages->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<input type="text" data-table="teachers_packages" data-field="x_teacher_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->teacher_id->EditValue ?>"<?php echo $teachers_packages->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<span<?php echo $teachers_packages->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" name="o<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" id="o<?php echo $teachers_packages_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->title_en->Visible) { // title_en ?>
		<td data-name="title_en">
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_packages_title_en" class="form-group teachers_packages_title_en">
<textarea data-table="teachers_packages" data-field="x_title_en" name="x<?php echo $teachers_packages_grid->RowIndex ?>_title_en" id="x<?php echo $teachers_packages_grid->RowIndex ?>_title_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->title_en->getPlaceHolder()) ?>"<?php echo $teachers_packages->title_en->EditAttributes() ?>><?php echo $teachers_packages->title_en->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_title_en" class="form-group teachers_packages_title_en">
<span<?php echo $teachers_packages->title_en->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->title_en->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" name="x<?php echo $teachers_packages_grid->RowIndex ?>_title_en" id="x<?php echo $teachers_packages_grid->RowIndex ?>_title_en" value="<?php echo ew_HtmlEncode($teachers_packages->title_en->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" name="o<?php echo $teachers_packages_grid->RowIndex ?>_title_en" id="o<?php echo $teachers_packages_grid->RowIndex ?>_title_en" value="<?php echo ew_HtmlEncode($teachers_packages->title_en->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->title_ar->Visible) { // title_ar ?>
		<td data-name="title_ar">
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_packages_title_ar" class="form-group teachers_packages_title_ar">
<textarea data-table="teachers_packages" data-field="x_title_ar" name="x<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" id="x<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->title_ar->getPlaceHolder()) ?>"<?php echo $teachers_packages->title_ar->EditAttributes() ?>><?php echo $teachers_packages->title_ar->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_title_ar" class="form-group teachers_packages_title_ar">
<span<?php echo $teachers_packages->title_ar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->title_ar->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" name="x<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" id="x<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" value="<?php echo ew_HtmlEncode($teachers_packages->title_ar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" name="o<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" id="o<?php echo $teachers_packages_grid->RowIndex ?>_title_ar" value="<?php echo ew_HtmlEncode($teachers_packages->title_ar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->description_en->Visible) { // description_en ?>
		<td data-name="description_en">
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_packages_description_en" class="form-group teachers_packages_description_en">
<textarea data-table="teachers_packages" data-field="x_description_en" name="x<?php echo $teachers_packages_grid->RowIndex ?>_description_en" id="x<?php echo $teachers_packages_grid->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->description_en->getPlaceHolder()) ?>"<?php echo $teachers_packages->description_en->EditAttributes() ?>><?php echo $teachers_packages->description_en->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_description_en" class="form-group teachers_packages_description_en">
<span<?php echo $teachers_packages->description_en->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->description_en->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" name="x<?php echo $teachers_packages_grid->RowIndex ?>_description_en" id="x<?php echo $teachers_packages_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers_packages->description_en->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" name="o<?php echo $teachers_packages_grid->RowIndex ?>_description_en" id="o<?php echo $teachers_packages_grid->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers_packages->description_en->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->description_ar->Visible) { // description_ar ?>
		<td data-name="description_ar">
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_packages_description_ar" class="form-group teachers_packages_description_ar">
<textarea data-table="teachers_packages" data-field="x_description_ar" name="x<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" id="x<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->description_ar->getPlaceHolder()) ?>"<?php echo $teachers_packages->description_ar->EditAttributes() ?>><?php echo $teachers_packages->description_ar->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_description_ar" class="form-group teachers_packages_description_ar">
<span<?php echo $teachers_packages->description_ar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->description_ar->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" name="x<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" id="x<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers_packages->description_ar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" name="o<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" id="o<?php echo $teachers_packages_grid->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers_packages->description_ar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->image->Visible) { // image ?>
		<td data-name="image">
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_packages_image" class="form-group teachers_packages_image">
<textarea data-table="teachers_packages" data-field="x_image" name="x<?php echo $teachers_packages_grid->RowIndex ?>_image" id="x<?php echo $teachers_packages_grid->RowIndex ?>_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->image->getPlaceHolder()) ?>"<?php echo $teachers_packages->image->EditAttributes() ?>><?php echo $teachers_packages->image->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_image" class="form-group teachers_packages_image">
<span<?php echo $teachers_packages->image->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->image->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_image" name="x<?php echo $teachers_packages_grid->RowIndex ?>_image" id="x<?php echo $teachers_packages_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_packages->image->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_image" name="o<?php echo $teachers_packages_grid->RowIndex ?>_image" id="o<?php echo $teachers_packages_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_packages->image->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->fees->Visible) { // fees ?>
		<td data-name="fees">
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_packages_fees" class="form-group teachers_packages_fees">
<input type="text" data-table="teachers_packages" data-field="x_fees" name="x<?php echo $teachers_packages_grid->RowIndex ?>_fees" id="x<?php echo $teachers_packages_grid->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->fees->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->fees->EditValue ?>"<?php echo $teachers_packages->fees->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_fees" class="form-group teachers_packages_fees">
<span<?php echo $teachers_packages->fees->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->fees->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_fees" name="x<?php echo $teachers_packages_grid->RowIndex ?>_fees" id="x<?php echo $teachers_packages_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers_packages->fees->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_fees" name="o<?php echo $teachers_packages_grid->RowIndex ?>_fees" id="o<?php echo $teachers_packages_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers_packages->fees->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id">
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_packages_currency_id" class="form-group teachers_packages_currency_id">
<input type="text" data-table="teachers_packages" data-field="x_currency_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->currency_id->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->currency_id->EditValue ?>"<?php echo $teachers_packages->currency_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_currency_id" class="form-group teachers_packages_currency_id">
<span<?php echo $teachers_packages->currency_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->currency_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" name="x<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" id="x<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers_packages->currency_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" name="o<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" id="o<?php echo $teachers_packages_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers_packages->currency_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->created_at->Visible) { // created_at ?>
		<td data-name="created_at">
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_packages_created_at" class="form-group teachers_packages_created_at">
<input type="text" data-table="teachers_packages" data-field="x_created_at" name="x<?php echo $teachers_packages_grid->RowIndex ?>_created_at" id="x<?php echo $teachers_packages_grid->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($teachers_packages->created_at->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->created_at->EditValue ?>"<?php echo $teachers_packages->created_at->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_created_at" class="form-group teachers_packages_created_at">
<span<?php echo $teachers_packages->created_at->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->created_at->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" name="x<?php echo $teachers_packages_grid->RowIndex ?>_created_at" id="x<?php echo $teachers_packages_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers_packages->created_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" name="o<?php echo $teachers_packages_grid->RowIndex ?>_created_at" id="o<?php echo $teachers_packages_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers_packages->created_at->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->updated_at->Visible) { // updated_at ?>
		<td data-name="updated_at">
<?php if ($teachers_packages->CurrentAction <> "F") { ?>
<span id="el$rowindex$_teachers_packages_updated_at" class="form-group teachers_packages_updated_at">
<input type="text" data-table="teachers_packages" data-field="x_updated_at" name="x<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" id="x<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($teachers_packages->updated_at->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->updated_at->EditValue ?>"<?php echo $teachers_packages->updated_at->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_updated_at" class="form-group teachers_packages_updated_at">
<span<?php echo $teachers_packages->updated_at->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->updated_at->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_updated_at" name="x<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" id="x<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers_packages->updated_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_updated_at" name="o<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" id="o<?php echo $teachers_packages_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers_packages->updated_at->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_packages_grid->ListOptions->Render("body", "right", $teachers_packages_grid->RowIndex);
?>
<script type="text/javascript">
fteachers_packagesgrid.UpdateOpts(<?php echo $teachers_packages_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($teachers_packages->CurrentMode == "add" || $teachers_packages->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $teachers_packages_grid->FormKeyCountName ?>" id="<?php echo $teachers_packages_grid->FormKeyCountName ?>" value="<?php echo $teachers_packages_grid->KeyCount ?>">
<?php echo $teachers_packages_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_packages->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $teachers_packages_grid->FormKeyCountName ?>" id="<?php echo $teachers_packages_grid->FormKeyCountName ?>" value="<?php echo $teachers_packages_grid->KeyCount ?>">
<?php echo $teachers_packages_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_packages->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fteachers_packagesgrid">
</div>
<?php

// Close recordset
if ($teachers_packages_grid->Recordset)
	$teachers_packages_grid->Recordset->Close();
?>
<?php if ($teachers_packages_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($teachers_packages_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($teachers_packages_grid->TotalRecs == 0 && $teachers_packages->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_packages_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($teachers_packages->Export == "") { ?>
<script type="text/javascript">
fteachers_packagesgrid.Init();
</script>
<?php } ?>
<?php
$teachers_packages_grid->Page_Terminate();
?>
