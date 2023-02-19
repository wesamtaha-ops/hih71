<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($orders_grid)) $orders_grid = new corders_grid();

// Page init
$orders_grid->Page_Init();

// Page main
$orders_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$orders_grid->Page_Render();
?>
<?php if ($orders->Export == "") { ?>
<script type="text/javascript">

// Form object
var fordersgrid = new ew_Form("fordersgrid", "grid");
fordersgrid.FormKeyCountName = '<?php echo $orders_grid->FormKeyCountName ?>';

// Validate form
fordersgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_student_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->student_id->FldCaption(), $orders->student_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->teacher_id->FldCaption(), $orders->teacher_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fees");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->fees->FldCaption(), $orders->fees->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fees");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->fees->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->currency_id->FldCaption(), $orders->currency_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->status->FldCaption(), $orders->status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_package_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->package_id->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fordersgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "student_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "teacher_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "topic_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "date", false)) return false;
	if (ew_ValueChanged(fobj, infix, "time", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fees", false)) return false;
	if (ew_ValueChanged(fobj, infix, "currency_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "meeting_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "package_id", false)) return false;
	return true;
}

// Form_CustomValidate event
fordersgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fordersgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fordersgrid.Lists["x_student_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"users"};
fordersgrid.Lists["x_student_id"].Data = "<?php echo $orders_grid->student_id->LookupFilterQuery(FALSE, "grid") ?>";
fordersgrid.Lists["x_teacher_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"users"};
fordersgrid.Lists["x_teacher_id"].Data = "<?php echo $orders_grid->teacher_id->LookupFilterQuery(FALSE, "grid") ?>";
fordersgrid.Lists["x_topic_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name_ar","x_name_en","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"topics"};
fordersgrid.Lists["x_topic_id"].Data = "<?php echo $orders_grid->topic_id->LookupFilterQuery(FALSE, "grid") ?>";
fordersgrid.Lists["x_currency_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name_ar","x_name_en","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"currencies"};
fordersgrid.Lists["x_currency_id"].Data = "<?php echo $orders_grid->currency_id->LookupFilterQuery(FALSE, "grid") ?>";
fordersgrid.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fordersgrid.Lists["x_status"].Options = <?php echo json_encode($orders_grid->status->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($orders->CurrentAction == "gridadd") {
	if ($orders->CurrentMode == "copy") {
		$bSelectLimit = $orders_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$orders_grid->TotalRecs = $orders->ListRecordCount();
			$orders_grid->Recordset = $orders_grid->LoadRecordset($orders_grid->StartRec-1, $orders_grid->DisplayRecs);
		} else {
			if ($orders_grid->Recordset = $orders_grid->LoadRecordset())
				$orders_grid->TotalRecs = $orders_grid->Recordset->RecordCount();
		}
		$orders_grid->StartRec = 1;
		$orders_grid->DisplayRecs = $orders_grid->TotalRecs;
	} else {
		$orders->CurrentFilter = "0=1";
		$orders_grid->StartRec = 1;
		$orders_grid->DisplayRecs = $orders->GridAddRowCount;
	}
	$orders_grid->TotalRecs = $orders_grid->DisplayRecs;
	$orders_grid->StopRec = $orders_grid->DisplayRecs;
} else {
	$bSelectLimit = $orders_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($orders_grid->TotalRecs <= 0)
			$orders_grid->TotalRecs = $orders->ListRecordCount();
	} else {
		if (!$orders_grid->Recordset && ($orders_grid->Recordset = $orders_grid->LoadRecordset()))
			$orders_grid->TotalRecs = $orders_grid->Recordset->RecordCount();
	}
	$orders_grid->StartRec = 1;
	$orders_grid->DisplayRecs = $orders_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$orders_grid->Recordset = $orders_grid->LoadRecordset($orders_grid->StartRec-1, $orders_grid->DisplayRecs);

	// Set no record found message
	if ($orders->CurrentAction == "" && $orders_grid->TotalRecs == 0) {
		if ($orders_grid->SearchWhere == "0=101")
			$orders_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$orders_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$orders_grid->RenderOtherOptions();
?>
<?php $orders_grid->ShowPageHeader(); ?>
<?php
$orders_grid->ShowMessage();
?>
<?php if ($orders_grid->TotalRecs > 0 || $orders->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($orders_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> orders">
<div id="fordersgrid" class="ewForm ewListForm form-inline">
<?php if ($orders_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($orders_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_orders" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_ordersgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$orders_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$orders_grid->RenderListOptions();

// Render list options (header, left)
$orders_grid->ListOptions->Render("header", "left");
?>
<?php if ($orders->id->Visible) { // id ?>
	<?php if ($orders->SortUrl($orders->id) == "") { ?>
		<th data-name="id" class="<?php echo $orders->id->HeaderCellClass() ?>"><div id="elh_orders_id" class="orders_id"><div class="ewTableHeaderCaption"><?php echo $orders->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $orders->id->HeaderCellClass() ?>"><div><div id="elh_orders_id" class="orders_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->student_id->Visible) { // student_id ?>
	<?php if ($orders->SortUrl($orders->student_id) == "") { ?>
		<th data-name="student_id" class="<?php echo $orders->student_id->HeaderCellClass() ?>"><div id="elh_orders_student_id" class="orders_student_id"><div class="ewTableHeaderCaption"><?php echo $orders->student_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="student_id" class="<?php echo $orders->student_id->HeaderCellClass() ?>"><div><div id="elh_orders_student_id" class="orders_student_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->student_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->student_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->student_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->teacher_id->Visible) { // teacher_id ?>
	<?php if ($orders->SortUrl($orders->teacher_id) == "") { ?>
		<th data-name="teacher_id" class="<?php echo $orders->teacher_id->HeaderCellClass() ?>"><div id="elh_orders_teacher_id" class="orders_teacher_id"><div class="ewTableHeaderCaption"><?php echo $orders->teacher_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="teacher_id" class="<?php echo $orders->teacher_id->HeaderCellClass() ?>"><div><div id="elh_orders_teacher_id" class="orders_teacher_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->teacher_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->teacher_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->teacher_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->topic_id->Visible) { // topic_id ?>
	<?php if ($orders->SortUrl($orders->topic_id) == "") { ?>
		<th data-name="topic_id" class="<?php echo $orders->topic_id->HeaderCellClass() ?>"><div id="elh_orders_topic_id" class="orders_topic_id"><div class="ewTableHeaderCaption"><?php echo $orders->topic_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="topic_id" class="<?php echo $orders->topic_id->HeaderCellClass() ?>"><div><div id="elh_orders_topic_id" class="orders_topic_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->topic_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->topic_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->topic_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->date->Visible) { // date ?>
	<?php if ($orders->SortUrl($orders->date) == "") { ?>
		<th data-name="date" class="<?php echo $orders->date->HeaderCellClass() ?>"><div id="elh_orders_date" class="orders_date"><div class="ewTableHeaderCaption"><?php echo $orders->date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date" class="<?php echo $orders->date->HeaderCellClass() ?>"><div><div id="elh_orders_date" class="orders_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->time->Visible) { // time ?>
	<?php if ($orders->SortUrl($orders->time) == "") { ?>
		<th data-name="time" class="<?php echo $orders->time->HeaderCellClass() ?>"><div id="elh_orders_time" class="orders_time"><div class="ewTableHeaderCaption"><?php echo $orders->time->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="time" class="<?php echo $orders->time->HeaderCellClass() ?>"><div><div id="elh_orders_time" class="orders_time">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->time->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->time->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->time->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->fees->Visible) { // fees ?>
	<?php if ($orders->SortUrl($orders->fees) == "") { ?>
		<th data-name="fees" class="<?php echo $orders->fees->HeaderCellClass() ?>"><div id="elh_orders_fees" class="orders_fees"><div class="ewTableHeaderCaption"><?php echo $orders->fees->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fees" class="<?php echo $orders->fees->HeaderCellClass() ?>"><div><div id="elh_orders_fees" class="orders_fees">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->fees->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->fees->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->fees->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->currency_id->Visible) { // currency_id ?>
	<?php if ($orders->SortUrl($orders->currency_id) == "") { ?>
		<th data-name="currency_id" class="<?php echo $orders->currency_id->HeaderCellClass() ?>"><div id="elh_orders_currency_id" class="orders_currency_id"><div class="ewTableHeaderCaption"><?php echo $orders->currency_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency_id" class="<?php echo $orders->currency_id->HeaderCellClass() ?>"><div><div id="elh_orders_currency_id" class="orders_currency_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->currency_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->currency_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->currency_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->status->Visible) { // status ?>
	<?php if ($orders->SortUrl($orders->status) == "") { ?>
		<th data-name="status" class="<?php echo $orders->status->HeaderCellClass() ?>"><div id="elh_orders_status" class="orders_status"><div class="ewTableHeaderCaption"><?php echo $orders->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $orders->status->HeaderCellClass() ?>"><div><div id="elh_orders_status" class="orders_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->meeting_id->Visible) { // meeting_id ?>
	<?php if ($orders->SortUrl($orders->meeting_id) == "") { ?>
		<th data-name="meeting_id" class="<?php echo $orders->meeting_id->HeaderCellClass() ?>"><div id="elh_orders_meeting_id" class="orders_meeting_id"><div class="ewTableHeaderCaption"><?php echo $orders->meeting_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="meeting_id" class="<?php echo $orders->meeting_id->HeaderCellClass() ?>"><div><div id="elh_orders_meeting_id" class="orders_meeting_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->meeting_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->meeting_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->meeting_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->package_id->Visible) { // package_id ?>
	<?php if ($orders->SortUrl($orders->package_id) == "") { ?>
		<th data-name="package_id" class="<?php echo $orders->package_id->HeaderCellClass() ?>"><div id="elh_orders_package_id" class="orders_package_id"><div class="ewTableHeaderCaption"><?php echo $orders->package_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="package_id" class="<?php echo $orders->package_id->HeaderCellClass() ?>"><div><div id="elh_orders_package_id" class="orders_package_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->package_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->package_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->package_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$orders_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$orders_grid->StartRec = 1;
$orders_grid->StopRec = $orders_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($orders_grid->FormKeyCountName) && ($orders->CurrentAction == "gridadd" || $orders->CurrentAction == "gridedit" || $orders->CurrentAction == "F")) {
		$orders_grid->KeyCount = $objForm->GetValue($orders_grid->FormKeyCountName);
		$orders_grid->StopRec = $orders_grid->StartRec + $orders_grid->KeyCount - 1;
	}
}
$orders_grid->RecCnt = $orders_grid->StartRec - 1;
if ($orders_grid->Recordset && !$orders_grid->Recordset->EOF) {
	$orders_grid->Recordset->MoveFirst();
	$bSelectLimit = $orders_grid->UseSelectLimit;
	if (!$bSelectLimit && $orders_grid->StartRec > 1)
		$orders_grid->Recordset->Move($orders_grid->StartRec - 1);
} elseif (!$orders->AllowAddDeleteRow && $orders_grid->StopRec == 0) {
	$orders_grid->StopRec = $orders->GridAddRowCount;
}

// Initialize aggregate
$orders->RowType = EW_ROWTYPE_AGGREGATEINIT;
$orders->ResetAttrs();
$orders_grid->RenderRow();
if ($orders->CurrentAction == "gridadd")
	$orders_grid->RowIndex = 0;
if ($orders->CurrentAction == "gridedit")
	$orders_grid->RowIndex = 0;
while ($orders_grid->RecCnt < $orders_grid->StopRec) {
	$orders_grid->RecCnt++;
	if (intval($orders_grid->RecCnt) >= intval($orders_grid->StartRec)) {
		$orders_grid->RowCnt++;
		if ($orders->CurrentAction == "gridadd" || $orders->CurrentAction == "gridedit" || $orders->CurrentAction == "F") {
			$orders_grid->RowIndex++;
			$objForm->Index = $orders_grid->RowIndex;
			if ($objForm->HasValue($orders_grid->FormActionName))
				$orders_grid->RowAction = strval($objForm->GetValue($orders_grid->FormActionName));
			elseif ($orders->CurrentAction == "gridadd")
				$orders_grid->RowAction = "insert";
			else
				$orders_grid->RowAction = "";
		}

		// Set up key count
		$orders_grid->KeyCount = $orders_grid->RowIndex;

		// Init row class and style
		$orders->ResetAttrs();
		$orders->CssClass = "";
		if ($orders->CurrentAction == "gridadd") {
			if ($orders->CurrentMode == "copy") {
				$orders_grid->LoadRowValues($orders_grid->Recordset); // Load row values
				$orders_grid->SetRecordKey($orders_grid->RowOldKey, $orders_grid->Recordset); // Set old record key
			} else {
				$orders_grid->LoadRowValues(); // Load default values
				$orders_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$orders_grid->LoadRowValues($orders_grid->Recordset); // Load row values
		}
		$orders->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($orders->CurrentAction == "gridadd") // Grid add
			$orders->RowType = EW_ROWTYPE_ADD; // Render add
		if ($orders->CurrentAction == "gridadd" && $orders->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$orders_grid->RestoreCurrentRowFormValues($orders_grid->RowIndex); // Restore form values
		if ($orders->CurrentAction == "gridedit") { // Grid edit
			if ($orders->EventCancelled) {
				$orders_grid->RestoreCurrentRowFormValues($orders_grid->RowIndex); // Restore form values
			}
			if ($orders_grid->RowAction == "insert")
				$orders->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$orders->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($orders->CurrentAction == "gridedit" && ($orders->RowType == EW_ROWTYPE_EDIT || $orders->RowType == EW_ROWTYPE_ADD) && $orders->EventCancelled) // Update failed
			$orders_grid->RestoreCurrentRowFormValues($orders_grid->RowIndex); // Restore form values
		if ($orders->RowType == EW_ROWTYPE_EDIT) // Edit row
			$orders_grid->EditRowCnt++;
		if ($orders->CurrentAction == "F") // Confirm row
			$orders_grid->RestoreCurrentRowFormValues($orders_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$orders->RowAttrs = array_merge($orders->RowAttrs, array('data-rowindex'=>$orders_grid->RowCnt, 'id'=>'r' . $orders_grid->RowCnt . '_orders', 'data-rowtype'=>$orders->RowType));

		// Render row
		$orders_grid->RenderRow();

		// Render list options
		$orders_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($orders_grid->RowAction <> "delete" && $orders_grid->RowAction <> "insertdelete" && !($orders_grid->RowAction == "insert" && $orders->CurrentAction == "F" && $orders_grid->EmptyRow())) {
?>
	<tr<?php echo $orders->RowAttributes() ?>>
<?php

// Render list options (body, left)
$orders_grid->ListOptions->Render("body", "left", $orders_grid->RowCnt);
?>
	<?php if ($orders->id->Visible) { // id ?>
		<td data-name="id"<?php echo $orders->id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="orders" data-field="x_id" name="o<?php echo $orders_grid->RowIndex ?>_id" id="o<?php echo $orders_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($orders->id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_id" class="form-group orders_id">
<span<?php echo $orders->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_id" name="x<?php echo $orders_grid->RowIndex ?>_id" id="x<?php echo $orders_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($orders->id->CurrentValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_id" class="orders_id">
<span<?php echo $orders->id->ViewAttributes() ?>>
<?php echo $orders->id->ListViewValue() ?></span>
</span>
<?php if ($orders->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orders" data-field="x_id" name="x<?php echo $orders_grid->RowIndex ?>_id" id="x<?php echo $orders_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($orders->id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_id" name="o<?php echo $orders_grid->RowIndex ?>_id" id="o<?php echo $orders_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($orders->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orders" data-field="x_id" name="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_id" id="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($orders->id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_id" name="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_id" id="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($orders->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->student_id->Visible) { // student_id ?>
		<td data-name="student_id"<?php echo $orders->student_id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_student_id" class="form-group orders_student_id">
<select data-table="orders" data-field="x_student_id" data-value-separator="<?php echo $orders->student_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_student_id" name="x<?php echo $orders_grid->RowIndex ?>_student_id"<?php echo $orders->student_id->EditAttributes() ?>>
<?php echo $orders->student_id->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_student_id") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_student_id" name="o<?php echo $orders_grid->RowIndex ?>_student_id" id="o<?php echo $orders_grid->RowIndex ?>_student_id" value="<?php echo ew_HtmlEncode($orders->student_id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_student_id" class="form-group orders_student_id">
<select data-table="orders" data-field="x_student_id" data-value-separator="<?php echo $orders->student_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_student_id" name="x<?php echo $orders_grid->RowIndex ?>_student_id"<?php echo $orders->student_id->EditAttributes() ?>>
<?php echo $orders->student_id->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_student_id") ?>
</select>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_student_id" class="orders_student_id">
<span<?php echo $orders->student_id->ViewAttributes() ?>>
<?php echo $orders->student_id->ListViewValue() ?></span>
</span>
<?php if ($orders->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orders" data-field="x_student_id" name="x<?php echo $orders_grid->RowIndex ?>_student_id" id="x<?php echo $orders_grid->RowIndex ?>_student_id" value="<?php echo ew_HtmlEncode($orders->student_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_student_id" name="o<?php echo $orders_grid->RowIndex ?>_student_id" id="o<?php echo $orders_grid->RowIndex ?>_student_id" value="<?php echo ew_HtmlEncode($orders->student_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orders" data-field="x_student_id" name="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_student_id" id="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_student_id" value="<?php echo ew_HtmlEncode($orders->student_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_student_id" name="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_student_id" id="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_student_id" value="<?php echo ew_HtmlEncode($orders->student_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id"<?php echo $orders->teacher_id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_teacher_id" class="form-group orders_teacher_id">
<select data-table="orders" data-field="x_teacher_id" data-value-separator="<?php echo $orders->teacher_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_teacher_id" name="x<?php echo $orders_grid->RowIndex ?>_teacher_id"<?php echo $orders->teacher_id->EditAttributes() ?>>
<?php echo $orders->teacher_id->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_teacher_id") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_teacher_id" name="o<?php echo $orders_grid->RowIndex ?>_teacher_id" id="o<?php echo $orders_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($orders->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_teacher_id" class="form-group orders_teacher_id">
<select data-table="orders" data-field="x_teacher_id" data-value-separator="<?php echo $orders->teacher_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_teacher_id" name="x<?php echo $orders_grid->RowIndex ?>_teacher_id"<?php echo $orders->teacher_id->EditAttributes() ?>>
<?php echo $orders->teacher_id->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_teacher_id") ?>
</select>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_teacher_id" class="orders_teacher_id">
<span<?php echo $orders->teacher_id->ViewAttributes() ?>>
<?php echo $orders->teacher_id->ListViewValue() ?></span>
</span>
<?php if ($orders->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orders" data-field="x_teacher_id" name="x<?php echo $orders_grid->RowIndex ?>_teacher_id" id="x<?php echo $orders_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($orders->teacher_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_teacher_id" name="o<?php echo $orders_grid->RowIndex ?>_teacher_id" id="o<?php echo $orders_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($orders->teacher_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orders" data-field="x_teacher_id" name="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_teacher_id" id="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($orders->teacher_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_teacher_id" name="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_teacher_id" id="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($orders->teacher_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->topic_id->Visible) { // topic_id ?>
		<td data-name="topic_id"<?php echo $orders->topic_id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_topic_id" class="form-group orders_topic_id">
<select data-table="orders" data-field="x_topic_id" data-value-separator="<?php echo $orders->topic_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_topic_id" name="x<?php echo $orders_grid->RowIndex ?>_topic_id"<?php echo $orders->topic_id->EditAttributes() ?>>
<?php echo $orders->topic_id->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_topic_id") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_topic_id" name="o<?php echo $orders_grid->RowIndex ?>_topic_id" id="o<?php echo $orders_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($orders->topic_id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_topic_id" class="form-group orders_topic_id">
<select data-table="orders" data-field="x_topic_id" data-value-separator="<?php echo $orders->topic_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_topic_id" name="x<?php echo $orders_grid->RowIndex ?>_topic_id"<?php echo $orders->topic_id->EditAttributes() ?>>
<?php echo $orders->topic_id->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_topic_id") ?>
</select>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_topic_id" class="orders_topic_id">
<span<?php echo $orders->topic_id->ViewAttributes() ?>>
<?php echo $orders->topic_id->ListViewValue() ?></span>
</span>
<?php if ($orders->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orders" data-field="x_topic_id" name="x<?php echo $orders_grid->RowIndex ?>_topic_id" id="x<?php echo $orders_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($orders->topic_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_topic_id" name="o<?php echo $orders_grid->RowIndex ?>_topic_id" id="o<?php echo $orders_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($orders->topic_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orders" data-field="x_topic_id" name="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_topic_id" id="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($orders->topic_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_topic_id" name="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_topic_id" id="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($orders->topic_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->date->Visible) { // date ?>
		<td data-name="date"<?php echo $orders->date->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_date" class="form-group orders_date">
<input type="text" data-table="orders" data-field="x_date" name="x<?php echo $orders_grid->RowIndex ?>_date" id="x<?php echo $orders_grid->RowIndex ?>_date" placeholder="<?php echo ew_HtmlEncode($orders->date->getPlaceHolder()) ?>" value="<?php echo $orders->date->EditValue ?>"<?php echo $orders->date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_date" name="o<?php echo $orders_grid->RowIndex ?>_date" id="o<?php echo $orders_grid->RowIndex ?>_date" value="<?php echo ew_HtmlEncode($orders->date->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_date" class="form-group orders_date">
<input type="text" data-table="orders" data-field="x_date" name="x<?php echo $orders_grid->RowIndex ?>_date" id="x<?php echo $orders_grid->RowIndex ?>_date" placeholder="<?php echo ew_HtmlEncode($orders->date->getPlaceHolder()) ?>" value="<?php echo $orders->date->EditValue ?>"<?php echo $orders->date->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_date" class="orders_date">
<span<?php echo $orders->date->ViewAttributes() ?>>
<?php echo $orders->date->ListViewValue() ?></span>
</span>
<?php if ($orders->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orders" data-field="x_date" name="x<?php echo $orders_grid->RowIndex ?>_date" id="x<?php echo $orders_grid->RowIndex ?>_date" value="<?php echo ew_HtmlEncode($orders->date->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_date" name="o<?php echo $orders_grid->RowIndex ?>_date" id="o<?php echo $orders_grid->RowIndex ?>_date" value="<?php echo ew_HtmlEncode($orders->date->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orders" data-field="x_date" name="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_date" id="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_date" value="<?php echo ew_HtmlEncode($orders->date->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_date" name="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_date" id="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_date" value="<?php echo ew_HtmlEncode($orders->date->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->time->Visible) { // time ?>
		<td data-name="time"<?php echo $orders->time->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_time" class="form-group orders_time">
<input type="text" data-table="orders" data-field="x_time" name="x<?php echo $orders_grid->RowIndex ?>_time" id="x<?php echo $orders_grid->RowIndex ?>_time" placeholder="<?php echo ew_HtmlEncode($orders->time->getPlaceHolder()) ?>" value="<?php echo $orders->time->EditValue ?>"<?php echo $orders->time->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_time" name="o<?php echo $orders_grid->RowIndex ?>_time" id="o<?php echo $orders_grid->RowIndex ?>_time" value="<?php echo ew_HtmlEncode($orders->time->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_time" class="form-group orders_time">
<input type="text" data-table="orders" data-field="x_time" name="x<?php echo $orders_grid->RowIndex ?>_time" id="x<?php echo $orders_grid->RowIndex ?>_time" placeholder="<?php echo ew_HtmlEncode($orders->time->getPlaceHolder()) ?>" value="<?php echo $orders->time->EditValue ?>"<?php echo $orders->time->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_time" class="orders_time">
<span<?php echo $orders->time->ViewAttributes() ?>>
<?php echo $orders->time->ListViewValue() ?></span>
</span>
<?php if ($orders->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orders" data-field="x_time" name="x<?php echo $orders_grid->RowIndex ?>_time" id="x<?php echo $orders_grid->RowIndex ?>_time" value="<?php echo ew_HtmlEncode($orders->time->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_time" name="o<?php echo $orders_grid->RowIndex ?>_time" id="o<?php echo $orders_grid->RowIndex ?>_time" value="<?php echo ew_HtmlEncode($orders->time->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orders" data-field="x_time" name="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_time" id="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_time" value="<?php echo ew_HtmlEncode($orders->time->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_time" name="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_time" id="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_time" value="<?php echo ew_HtmlEncode($orders->time->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->fees->Visible) { // fees ?>
		<td data-name="fees"<?php echo $orders->fees->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_fees" class="form-group orders_fees">
<input type="text" data-table="orders" data-field="x_fees" name="x<?php echo $orders_grid->RowIndex ?>_fees" id="x<?php echo $orders_grid->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($orders->fees->getPlaceHolder()) ?>" value="<?php echo $orders->fees->EditValue ?>"<?php echo $orders->fees->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_fees" name="o<?php echo $orders_grid->RowIndex ?>_fees" id="o<?php echo $orders_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($orders->fees->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_fees" class="form-group orders_fees">
<input type="text" data-table="orders" data-field="x_fees" name="x<?php echo $orders_grid->RowIndex ?>_fees" id="x<?php echo $orders_grid->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($orders->fees->getPlaceHolder()) ?>" value="<?php echo $orders->fees->EditValue ?>"<?php echo $orders->fees->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_fees" class="orders_fees">
<span<?php echo $orders->fees->ViewAttributes() ?>>
<?php echo $orders->fees->ListViewValue() ?></span>
</span>
<?php if ($orders->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orders" data-field="x_fees" name="x<?php echo $orders_grid->RowIndex ?>_fees" id="x<?php echo $orders_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($orders->fees->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_fees" name="o<?php echo $orders_grid->RowIndex ?>_fees" id="o<?php echo $orders_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($orders->fees->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orders" data-field="x_fees" name="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_fees" id="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($orders->fees->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_fees" name="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_fees" id="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($orders->fees->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id"<?php echo $orders->currency_id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_currency_id" class="form-group orders_currency_id">
<select data-table="orders" data-field="x_currency_id" data-value-separator="<?php echo $orders->currency_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_currency_id" name="x<?php echo $orders_grid->RowIndex ?>_currency_id"<?php echo $orders->currency_id->EditAttributes() ?>>
<?php echo $orders->currency_id->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_currency_id") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_currency_id" name="o<?php echo $orders_grid->RowIndex ?>_currency_id" id="o<?php echo $orders_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($orders->currency_id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_currency_id" class="form-group orders_currency_id">
<select data-table="orders" data-field="x_currency_id" data-value-separator="<?php echo $orders->currency_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_currency_id" name="x<?php echo $orders_grid->RowIndex ?>_currency_id"<?php echo $orders->currency_id->EditAttributes() ?>>
<?php echo $orders->currency_id->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_currency_id") ?>
</select>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_currency_id" class="orders_currency_id">
<span<?php echo $orders->currency_id->ViewAttributes() ?>>
<?php echo $orders->currency_id->ListViewValue() ?></span>
</span>
<?php if ($orders->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orders" data-field="x_currency_id" name="x<?php echo $orders_grid->RowIndex ?>_currency_id" id="x<?php echo $orders_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($orders->currency_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_currency_id" name="o<?php echo $orders_grid->RowIndex ?>_currency_id" id="o<?php echo $orders_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($orders->currency_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orders" data-field="x_currency_id" name="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_currency_id" id="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($orders->currency_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_currency_id" name="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_currency_id" id="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($orders->currency_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->status->Visible) { // status ?>
		<td data-name="status"<?php echo $orders->status->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_status" class="form-group orders_status">
<select data-table="orders" data-field="x_status" data-value-separator="<?php echo $orders->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_status" name="x<?php echo $orders_grid->RowIndex ?>_status"<?php echo $orders->status->EditAttributes() ?>>
<?php echo $orders->status->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_status") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_status" name="o<?php echo $orders_grid->RowIndex ?>_status" id="o<?php echo $orders_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($orders->status->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_status" class="form-group orders_status">
<select data-table="orders" data-field="x_status" data-value-separator="<?php echo $orders->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_status" name="x<?php echo $orders_grid->RowIndex ?>_status"<?php echo $orders->status->EditAttributes() ?>>
<?php echo $orders->status->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_status") ?>
</select>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_status" class="orders_status">
<span<?php echo $orders->status->ViewAttributes() ?>>
<?php echo $orders->status->ListViewValue() ?></span>
</span>
<?php if ($orders->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orders" data-field="x_status" name="x<?php echo $orders_grid->RowIndex ?>_status" id="x<?php echo $orders_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($orders->status->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_status" name="o<?php echo $orders_grid->RowIndex ?>_status" id="o<?php echo $orders_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($orders->status->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orders" data-field="x_status" name="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_status" id="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($orders->status->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_status" name="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_status" id="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($orders->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->meeting_id->Visible) { // meeting_id ?>
		<td data-name="meeting_id"<?php echo $orders->meeting_id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_meeting_id" class="form-group orders_meeting_id">
<input type="text" data-table="orders" data-field="x_meeting_id" name="x<?php echo $orders_grid->RowIndex ?>_meeting_id" id="x<?php echo $orders_grid->RowIndex ?>_meeting_id" placeholder="<?php echo ew_HtmlEncode($orders->meeting_id->getPlaceHolder()) ?>" value="<?php echo $orders->meeting_id->EditValue ?>"<?php echo $orders->meeting_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_meeting_id" name="o<?php echo $orders_grid->RowIndex ?>_meeting_id" id="o<?php echo $orders_grid->RowIndex ?>_meeting_id" value="<?php echo ew_HtmlEncode($orders->meeting_id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_meeting_id" class="form-group orders_meeting_id">
<input type="text" data-table="orders" data-field="x_meeting_id" name="x<?php echo $orders_grid->RowIndex ?>_meeting_id" id="x<?php echo $orders_grid->RowIndex ?>_meeting_id" placeholder="<?php echo ew_HtmlEncode($orders->meeting_id->getPlaceHolder()) ?>" value="<?php echo $orders->meeting_id->EditValue ?>"<?php echo $orders->meeting_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_meeting_id" class="orders_meeting_id">
<span<?php echo $orders->meeting_id->ViewAttributes() ?>>
<?php echo $orders->meeting_id->ListViewValue() ?></span>
</span>
<?php if ($orders->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orders" data-field="x_meeting_id" name="x<?php echo $orders_grid->RowIndex ?>_meeting_id" id="x<?php echo $orders_grid->RowIndex ?>_meeting_id" value="<?php echo ew_HtmlEncode($orders->meeting_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_meeting_id" name="o<?php echo $orders_grid->RowIndex ?>_meeting_id" id="o<?php echo $orders_grid->RowIndex ?>_meeting_id" value="<?php echo ew_HtmlEncode($orders->meeting_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orders" data-field="x_meeting_id" name="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_meeting_id" id="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_meeting_id" value="<?php echo ew_HtmlEncode($orders->meeting_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_meeting_id" name="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_meeting_id" id="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_meeting_id" value="<?php echo ew_HtmlEncode($orders->meeting_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->package_id->Visible) { // package_id ?>
		<td data-name="package_id"<?php echo $orders->package_id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_package_id" class="form-group orders_package_id">
<input type="text" data-table="orders" data-field="x_package_id" name="x<?php echo $orders_grid->RowIndex ?>_package_id" id="x<?php echo $orders_grid->RowIndex ?>_package_id" size="30" placeholder="<?php echo ew_HtmlEncode($orders->package_id->getPlaceHolder()) ?>" value="<?php echo $orders->package_id->EditValue ?>"<?php echo $orders->package_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_package_id" name="o<?php echo $orders_grid->RowIndex ?>_package_id" id="o<?php echo $orders_grid->RowIndex ?>_package_id" value="<?php echo ew_HtmlEncode($orders->package_id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_package_id" class="form-group orders_package_id">
<input type="text" data-table="orders" data-field="x_package_id" name="x<?php echo $orders_grid->RowIndex ?>_package_id" id="x<?php echo $orders_grid->RowIndex ?>_package_id" size="30" placeholder="<?php echo ew_HtmlEncode($orders->package_id->getPlaceHolder()) ?>" value="<?php echo $orders->package_id->EditValue ?>"<?php echo $orders->package_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_grid->RowCnt ?>_orders_package_id" class="orders_package_id">
<span<?php echo $orders->package_id->ViewAttributes() ?>>
<?php echo $orders->package_id->ListViewValue() ?></span>
</span>
<?php if ($orders->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orders" data-field="x_package_id" name="x<?php echo $orders_grid->RowIndex ?>_package_id" id="x<?php echo $orders_grid->RowIndex ?>_package_id" value="<?php echo ew_HtmlEncode($orders->package_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_package_id" name="o<?php echo $orders_grid->RowIndex ?>_package_id" id="o<?php echo $orders_grid->RowIndex ?>_package_id" value="<?php echo ew_HtmlEncode($orders->package_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orders" data-field="x_package_id" name="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_package_id" id="fordersgrid$x<?php echo $orders_grid->RowIndex ?>_package_id" value="<?php echo ew_HtmlEncode($orders->package_id->FormValue) ?>">
<input type="hidden" data-table="orders" data-field="x_package_id" name="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_package_id" id="fordersgrid$o<?php echo $orders_grid->RowIndex ?>_package_id" value="<?php echo ew_HtmlEncode($orders->package_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$orders_grid->ListOptions->Render("body", "right", $orders_grid->RowCnt);
?>
	</tr>
<?php if ($orders->RowType == EW_ROWTYPE_ADD || $orders->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fordersgrid.UpdateOpts(<?php echo $orders_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($orders->CurrentAction <> "gridadd" || $orders->CurrentMode == "copy")
		if (!$orders_grid->Recordset->EOF) $orders_grid->Recordset->MoveNext();
}
?>
<?php
	if ($orders->CurrentMode == "add" || $orders->CurrentMode == "copy" || $orders->CurrentMode == "edit") {
		$orders_grid->RowIndex = '$rowindex$';
		$orders_grid->LoadRowValues();

		// Set row properties
		$orders->ResetAttrs();
		$orders->RowAttrs = array_merge($orders->RowAttrs, array('data-rowindex'=>$orders_grid->RowIndex, 'id'=>'r0_orders', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($orders->RowAttrs["class"], "ewTemplate");
		$orders->RowType = EW_ROWTYPE_ADD;

		// Render row
		$orders_grid->RenderRow();

		// Render list options
		$orders_grid->RenderListOptions();
		$orders_grid->StartRowCnt = 0;
?>
	<tr<?php echo $orders->RowAttributes() ?>>
<?php

// Render list options (body, left)
$orders_grid->ListOptions->Render("body", "left", $orders_grid->RowIndex);
?>
	<?php if ($orders->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($orders->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_orders_id" class="form-group orders_id">
<span<?php echo $orders->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_id" name="x<?php echo $orders_grid->RowIndex ?>_id" id="x<?php echo $orders_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($orders->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orders" data-field="x_id" name="o<?php echo $orders_grid->RowIndex ?>_id" id="o<?php echo $orders_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($orders->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->student_id->Visible) { // student_id ?>
		<td data-name="student_id">
<?php if ($orders->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orders_student_id" class="form-group orders_student_id">
<select data-table="orders" data-field="x_student_id" data-value-separator="<?php echo $orders->student_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_student_id" name="x<?php echo $orders_grid->RowIndex ?>_student_id"<?php echo $orders->student_id->EditAttributes() ?>>
<?php echo $orders->student_id->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_student_id") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_orders_student_id" class="form-group orders_student_id">
<span<?php echo $orders->student_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->student_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_student_id" name="x<?php echo $orders_grid->RowIndex ?>_student_id" id="x<?php echo $orders_grid->RowIndex ?>_student_id" value="<?php echo ew_HtmlEncode($orders->student_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orders" data-field="x_student_id" name="o<?php echo $orders_grid->RowIndex ?>_student_id" id="o<?php echo $orders_grid->RowIndex ?>_student_id" value="<?php echo ew_HtmlEncode($orders->student_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id">
<?php if ($orders->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orders_teacher_id" class="form-group orders_teacher_id">
<select data-table="orders" data-field="x_teacher_id" data-value-separator="<?php echo $orders->teacher_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_teacher_id" name="x<?php echo $orders_grid->RowIndex ?>_teacher_id"<?php echo $orders->teacher_id->EditAttributes() ?>>
<?php echo $orders->teacher_id->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_teacher_id") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_orders_teacher_id" class="form-group orders_teacher_id">
<span<?php echo $orders->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_teacher_id" name="x<?php echo $orders_grid->RowIndex ?>_teacher_id" id="x<?php echo $orders_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($orders->teacher_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orders" data-field="x_teacher_id" name="o<?php echo $orders_grid->RowIndex ?>_teacher_id" id="o<?php echo $orders_grid->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($orders->teacher_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->topic_id->Visible) { // topic_id ?>
		<td data-name="topic_id">
<?php if ($orders->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orders_topic_id" class="form-group orders_topic_id">
<select data-table="orders" data-field="x_topic_id" data-value-separator="<?php echo $orders->topic_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_topic_id" name="x<?php echo $orders_grid->RowIndex ?>_topic_id"<?php echo $orders->topic_id->EditAttributes() ?>>
<?php echo $orders->topic_id->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_topic_id") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_orders_topic_id" class="form-group orders_topic_id">
<span<?php echo $orders->topic_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->topic_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_topic_id" name="x<?php echo $orders_grid->RowIndex ?>_topic_id" id="x<?php echo $orders_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($orders->topic_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orders" data-field="x_topic_id" name="o<?php echo $orders_grid->RowIndex ?>_topic_id" id="o<?php echo $orders_grid->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($orders->topic_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->date->Visible) { // date ?>
		<td data-name="date">
<?php if ($orders->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orders_date" class="form-group orders_date">
<input type="text" data-table="orders" data-field="x_date" name="x<?php echo $orders_grid->RowIndex ?>_date" id="x<?php echo $orders_grid->RowIndex ?>_date" placeholder="<?php echo ew_HtmlEncode($orders->date->getPlaceHolder()) ?>" value="<?php echo $orders->date->EditValue ?>"<?php echo $orders->date->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_orders_date" class="form-group orders_date">
<span<?php echo $orders->date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->date->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_date" name="x<?php echo $orders_grid->RowIndex ?>_date" id="x<?php echo $orders_grid->RowIndex ?>_date" value="<?php echo ew_HtmlEncode($orders->date->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orders" data-field="x_date" name="o<?php echo $orders_grid->RowIndex ?>_date" id="o<?php echo $orders_grid->RowIndex ?>_date" value="<?php echo ew_HtmlEncode($orders->date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->time->Visible) { // time ?>
		<td data-name="time">
<?php if ($orders->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orders_time" class="form-group orders_time">
<input type="text" data-table="orders" data-field="x_time" name="x<?php echo $orders_grid->RowIndex ?>_time" id="x<?php echo $orders_grid->RowIndex ?>_time" placeholder="<?php echo ew_HtmlEncode($orders->time->getPlaceHolder()) ?>" value="<?php echo $orders->time->EditValue ?>"<?php echo $orders->time->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_orders_time" class="form-group orders_time">
<span<?php echo $orders->time->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->time->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_time" name="x<?php echo $orders_grid->RowIndex ?>_time" id="x<?php echo $orders_grid->RowIndex ?>_time" value="<?php echo ew_HtmlEncode($orders->time->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orders" data-field="x_time" name="o<?php echo $orders_grid->RowIndex ?>_time" id="o<?php echo $orders_grid->RowIndex ?>_time" value="<?php echo ew_HtmlEncode($orders->time->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->fees->Visible) { // fees ?>
		<td data-name="fees">
<?php if ($orders->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orders_fees" class="form-group orders_fees">
<input type="text" data-table="orders" data-field="x_fees" name="x<?php echo $orders_grid->RowIndex ?>_fees" id="x<?php echo $orders_grid->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($orders->fees->getPlaceHolder()) ?>" value="<?php echo $orders->fees->EditValue ?>"<?php echo $orders->fees->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_orders_fees" class="form-group orders_fees">
<span<?php echo $orders->fees->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->fees->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_fees" name="x<?php echo $orders_grid->RowIndex ?>_fees" id="x<?php echo $orders_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($orders->fees->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orders" data-field="x_fees" name="o<?php echo $orders_grid->RowIndex ?>_fees" id="o<?php echo $orders_grid->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($orders->fees->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id">
<?php if ($orders->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orders_currency_id" class="form-group orders_currency_id">
<select data-table="orders" data-field="x_currency_id" data-value-separator="<?php echo $orders->currency_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_currency_id" name="x<?php echo $orders_grid->RowIndex ?>_currency_id"<?php echo $orders->currency_id->EditAttributes() ?>>
<?php echo $orders->currency_id->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_currency_id") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_orders_currency_id" class="form-group orders_currency_id">
<span<?php echo $orders->currency_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->currency_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_currency_id" name="x<?php echo $orders_grid->RowIndex ?>_currency_id" id="x<?php echo $orders_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($orders->currency_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orders" data-field="x_currency_id" name="o<?php echo $orders_grid->RowIndex ?>_currency_id" id="o<?php echo $orders_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($orders->currency_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->status->Visible) { // status ?>
		<td data-name="status">
<?php if ($orders->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orders_status" class="form-group orders_status">
<select data-table="orders" data-field="x_status" data-value-separator="<?php echo $orders->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_grid->RowIndex ?>_status" name="x<?php echo $orders_grid->RowIndex ?>_status"<?php echo $orders->status->EditAttributes() ?>>
<?php echo $orders->status->SelectOptionListHtml("x<?php echo $orders_grid->RowIndex ?>_status") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_orders_status" class="form-group orders_status">
<span<?php echo $orders->status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_status" name="x<?php echo $orders_grid->RowIndex ?>_status" id="x<?php echo $orders_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($orders->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orders" data-field="x_status" name="o<?php echo $orders_grid->RowIndex ?>_status" id="o<?php echo $orders_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($orders->status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->meeting_id->Visible) { // meeting_id ?>
		<td data-name="meeting_id">
<?php if ($orders->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orders_meeting_id" class="form-group orders_meeting_id">
<input type="text" data-table="orders" data-field="x_meeting_id" name="x<?php echo $orders_grid->RowIndex ?>_meeting_id" id="x<?php echo $orders_grid->RowIndex ?>_meeting_id" placeholder="<?php echo ew_HtmlEncode($orders->meeting_id->getPlaceHolder()) ?>" value="<?php echo $orders->meeting_id->EditValue ?>"<?php echo $orders->meeting_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_orders_meeting_id" class="form-group orders_meeting_id">
<span<?php echo $orders->meeting_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->meeting_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_meeting_id" name="x<?php echo $orders_grid->RowIndex ?>_meeting_id" id="x<?php echo $orders_grid->RowIndex ?>_meeting_id" value="<?php echo ew_HtmlEncode($orders->meeting_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orders" data-field="x_meeting_id" name="o<?php echo $orders_grid->RowIndex ?>_meeting_id" id="o<?php echo $orders_grid->RowIndex ?>_meeting_id" value="<?php echo ew_HtmlEncode($orders->meeting_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->package_id->Visible) { // package_id ?>
		<td data-name="package_id">
<?php if ($orders->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orders_package_id" class="form-group orders_package_id">
<input type="text" data-table="orders" data-field="x_package_id" name="x<?php echo $orders_grid->RowIndex ?>_package_id" id="x<?php echo $orders_grid->RowIndex ?>_package_id" size="30" placeholder="<?php echo ew_HtmlEncode($orders->package_id->getPlaceHolder()) ?>" value="<?php echo $orders->package_id->EditValue ?>"<?php echo $orders->package_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_orders_package_id" class="form-group orders_package_id">
<span<?php echo $orders->package_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->package_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_package_id" name="x<?php echo $orders_grid->RowIndex ?>_package_id" id="x<?php echo $orders_grid->RowIndex ?>_package_id" value="<?php echo ew_HtmlEncode($orders->package_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orders" data-field="x_package_id" name="o<?php echo $orders_grid->RowIndex ?>_package_id" id="o<?php echo $orders_grid->RowIndex ?>_package_id" value="<?php echo ew_HtmlEncode($orders->package_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$orders_grid->ListOptions->Render("body", "right", $orders_grid->RowIndex);
?>
<script type="text/javascript">
fordersgrid.UpdateOpts(<?php echo $orders_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($orders->CurrentMode == "add" || $orders->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $orders_grid->FormKeyCountName ?>" id="<?php echo $orders_grid->FormKeyCountName ?>" value="<?php echo $orders_grid->KeyCount ?>">
<?php echo $orders_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($orders->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $orders_grid->FormKeyCountName ?>" id="<?php echo $orders_grid->FormKeyCountName ?>" value="<?php echo $orders_grid->KeyCount ?>">
<?php echo $orders_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($orders->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fordersgrid">
</div>
<?php

// Close recordset
if ($orders_grid->Recordset)
	$orders_grid->Recordset->Close();
?>
<?php if ($orders_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($orders_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($orders_grid->TotalRecs == 0 && $orders->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($orders_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($orders->Export == "") { ?>
<script type="text/javascript">
fordersgrid.Init();
</script>
<?php } ?>
<?php
$orders_grid->Page_Terminate();
?>
