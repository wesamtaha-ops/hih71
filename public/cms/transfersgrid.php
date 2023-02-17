<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($transfers_grid)) $transfers_grid = new ctransfers_grid();

// Page init
$transfers_grid->Page_Init();

// Page main
$transfers_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$transfers_grid->Page_Render();
?>
<?php if ($transfers->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftransfersgrid = new ew_Form("ftransfersgrid", "grid");
ftransfersgrid.FormKeyCountName = '<?php echo $transfers_grid->FormKeyCountName ?>';

// Validate form
ftransfersgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transfers->user_id->FldCaption(), $transfers->user_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_user_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($transfers->user_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_amount");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transfers->amount->FldCaption(), $transfers->amount->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_amount");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($transfers->amount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transfers->currency_id->FldCaption(), $transfers->currency_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($transfers->currency_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transfers->type->FldCaption(), $transfers->type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_order_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($transfers->order_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_approved");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transfers->approved->FldCaption(), $transfers->approved->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_approved");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($transfers->approved->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $transfers->created_at->FldCaption(), $transfers->created_at->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($transfers->created_at->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_updated_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($transfers->updated_at->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftransfersgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "user_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "amount", false)) return false;
	if (ew_ValueChanged(fobj, infix, "currency_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "type", false)) return false;
	if (ew_ValueChanged(fobj, infix, "order_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "approved", false)) return false;
	if (ew_ValueChanged(fobj, infix, "verification_code", false)) return false;
	if (ew_ValueChanged(fobj, infix, "created_at", false)) return false;
	if (ew_ValueChanged(fobj, infix, "updated_at", false)) return false;
	return true;
}

// Form_CustomValidate event
ftransfersgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftransfersgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftransfersgrid.Lists["x_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftransfersgrid.Lists["x_type"].Options = <?php echo json_encode($transfers_grid->type->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($transfers->CurrentAction == "gridadd") {
	if ($transfers->CurrentMode == "copy") {
		$bSelectLimit = $transfers_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$transfers_grid->TotalRecs = $transfers->ListRecordCount();
			$transfers_grid->Recordset = $transfers_grid->LoadRecordset($transfers_grid->StartRec-1, $transfers_grid->DisplayRecs);
		} else {
			if ($transfers_grid->Recordset = $transfers_grid->LoadRecordset())
				$transfers_grid->TotalRecs = $transfers_grid->Recordset->RecordCount();
		}
		$transfers_grid->StartRec = 1;
		$transfers_grid->DisplayRecs = $transfers_grid->TotalRecs;
	} else {
		$transfers->CurrentFilter = "0=1";
		$transfers_grid->StartRec = 1;
		$transfers_grid->DisplayRecs = $transfers->GridAddRowCount;
	}
	$transfers_grid->TotalRecs = $transfers_grid->DisplayRecs;
	$transfers_grid->StopRec = $transfers_grid->DisplayRecs;
} else {
	$bSelectLimit = $transfers_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($transfers_grid->TotalRecs <= 0)
			$transfers_grid->TotalRecs = $transfers->ListRecordCount();
	} else {
		if (!$transfers_grid->Recordset && ($transfers_grid->Recordset = $transfers_grid->LoadRecordset()))
			$transfers_grid->TotalRecs = $transfers_grid->Recordset->RecordCount();
	}
	$transfers_grid->StartRec = 1;
	$transfers_grid->DisplayRecs = $transfers_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$transfers_grid->Recordset = $transfers_grid->LoadRecordset($transfers_grid->StartRec-1, $transfers_grid->DisplayRecs);

	// Set no record found message
	if ($transfers->CurrentAction == "" && $transfers_grid->TotalRecs == 0) {
		if ($transfers_grid->SearchWhere == "0=101")
			$transfers_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$transfers_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$transfers_grid->RenderOtherOptions();
?>
<?php $transfers_grid->ShowPageHeader(); ?>
<?php
$transfers_grid->ShowMessage();
?>
<?php if ($transfers_grid->TotalRecs > 0 || $transfers->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($transfers_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> transfers">
<div id="ftransfersgrid" class="ewForm ewListForm form-inline">
<?php if ($transfers_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($transfers_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_transfers" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_transfersgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$transfers_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$transfers_grid->RenderListOptions();

// Render list options (header, left)
$transfers_grid->ListOptions->Render("header", "left");
?>
<?php if ($transfers->id->Visible) { // id ?>
	<?php if ($transfers->SortUrl($transfers->id) == "") { ?>
		<th data-name="id" class="<?php echo $transfers->id->HeaderCellClass() ?>"><div id="elh_transfers_id" class="transfers_id"><div class="ewTableHeaderCaption"><?php echo $transfers->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $transfers->id->HeaderCellClass() ?>"><div><div id="elh_transfers_id" class="transfers_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transfers->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transfers->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transfers->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($transfers->user_id->Visible) { // user_id ?>
	<?php if ($transfers->SortUrl($transfers->user_id) == "") { ?>
		<th data-name="user_id" class="<?php echo $transfers->user_id->HeaderCellClass() ?>"><div id="elh_transfers_user_id" class="transfers_user_id"><div class="ewTableHeaderCaption"><?php echo $transfers->user_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user_id" class="<?php echo $transfers->user_id->HeaderCellClass() ?>"><div><div id="elh_transfers_user_id" class="transfers_user_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transfers->user_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transfers->user_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transfers->user_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($transfers->amount->Visible) { // amount ?>
	<?php if ($transfers->SortUrl($transfers->amount) == "") { ?>
		<th data-name="amount" class="<?php echo $transfers->amount->HeaderCellClass() ?>"><div id="elh_transfers_amount" class="transfers_amount"><div class="ewTableHeaderCaption"><?php echo $transfers->amount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="amount" class="<?php echo $transfers->amount->HeaderCellClass() ?>"><div><div id="elh_transfers_amount" class="transfers_amount">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transfers->amount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transfers->amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transfers->amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($transfers->currency_id->Visible) { // currency_id ?>
	<?php if ($transfers->SortUrl($transfers->currency_id) == "") { ?>
		<th data-name="currency_id" class="<?php echo $transfers->currency_id->HeaderCellClass() ?>"><div id="elh_transfers_currency_id" class="transfers_currency_id"><div class="ewTableHeaderCaption"><?php echo $transfers->currency_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency_id" class="<?php echo $transfers->currency_id->HeaderCellClass() ?>"><div><div id="elh_transfers_currency_id" class="transfers_currency_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transfers->currency_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transfers->currency_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transfers->currency_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($transfers->type->Visible) { // type ?>
	<?php if ($transfers->SortUrl($transfers->type) == "") { ?>
		<th data-name="type" class="<?php echo $transfers->type->HeaderCellClass() ?>"><div id="elh_transfers_type" class="transfers_type"><div class="ewTableHeaderCaption"><?php echo $transfers->type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="type" class="<?php echo $transfers->type->HeaderCellClass() ?>"><div><div id="elh_transfers_type" class="transfers_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transfers->type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transfers->type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transfers->type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($transfers->order_id->Visible) { // order_id ?>
	<?php if ($transfers->SortUrl($transfers->order_id) == "") { ?>
		<th data-name="order_id" class="<?php echo $transfers->order_id->HeaderCellClass() ?>"><div id="elh_transfers_order_id" class="transfers_order_id"><div class="ewTableHeaderCaption"><?php echo $transfers->order_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="order_id" class="<?php echo $transfers->order_id->HeaderCellClass() ?>"><div><div id="elh_transfers_order_id" class="transfers_order_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transfers->order_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transfers->order_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transfers->order_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($transfers->approved->Visible) { // approved ?>
	<?php if ($transfers->SortUrl($transfers->approved) == "") { ?>
		<th data-name="approved" class="<?php echo $transfers->approved->HeaderCellClass() ?>"><div id="elh_transfers_approved" class="transfers_approved"><div class="ewTableHeaderCaption"><?php echo $transfers->approved->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="approved" class="<?php echo $transfers->approved->HeaderCellClass() ?>"><div><div id="elh_transfers_approved" class="transfers_approved">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transfers->approved->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transfers->approved->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transfers->approved->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($transfers->verification_code->Visible) { // verification_code ?>
	<?php if ($transfers->SortUrl($transfers->verification_code) == "") { ?>
		<th data-name="verification_code" class="<?php echo $transfers->verification_code->HeaderCellClass() ?>"><div id="elh_transfers_verification_code" class="transfers_verification_code"><div class="ewTableHeaderCaption"><?php echo $transfers->verification_code->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="verification_code" class="<?php echo $transfers->verification_code->HeaderCellClass() ?>"><div><div id="elh_transfers_verification_code" class="transfers_verification_code">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transfers->verification_code->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transfers->verification_code->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transfers->verification_code->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($transfers->created_at->Visible) { // created_at ?>
	<?php if ($transfers->SortUrl($transfers->created_at) == "") { ?>
		<th data-name="created_at" class="<?php echo $transfers->created_at->HeaderCellClass() ?>"><div id="elh_transfers_created_at" class="transfers_created_at"><div class="ewTableHeaderCaption"><?php echo $transfers->created_at->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="created_at" class="<?php echo $transfers->created_at->HeaderCellClass() ?>"><div><div id="elh_transfers_created_at" class="transfers_created_at">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transfers->created_at->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transfers->created_at->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transfers->created_at->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($transfers->updated_at->Visible) { // updated_at ?>
	<?php if ($transfers->SortUrl($transfers->updated_at) == "") { ?>
		<th data-name="updated_at" class="<?php echo $transfers->updated_at->HeaderCellClass() ?>"><div id="elh_transfers_updated_at" class="transfers_updated_at"><div class="ewTableHeaderCaption"><?php echo $transfers->updated_at->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="updated_at" class="<?php echo $transfers->updated_at->HeaderCellClass() ?>"><div><div id="elh_transfers_updated_at" class="transfers_updated_at">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $transfers->updated_at->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($transfers->updated_at->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($transfers->updated_at->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$transfers_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$transfers_grid->StartRec = 1;
$transfers_grid->StopRec = $transfers_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($transfers_grid->FormKeyCountName) && ($transfers->CurrentAction == "gridadd" || $transfers->CurrentAction == "gridedit" || $transfers->CurrentAction == "F")) {
		$transfers_grid->KeyCount = $objForm->GetValue($transfers_grid->FormKeyCountName);
		$transfers_grid->StopRec = $transfers_grid->StartRec + $transfers_grid->KeyCount - 1;
	}
}
$transfers_grid->RecCnt = $transfers_grid->StartRec - 1;
if ($transfers_grid->Recordset && !$transfers_grid->Recordset->EOF) {
	$transfers_grid->Recordset->MoveFirst();
	$bSelectLimit = $transfers_grid->UseSelectLimit;
	if (!$bSelectLimit && $transfers_grid->StartRec > 1)
		$transfers_grid->Recordset->Move($transfers_grid->StartRec - 1);
} elseif (!$transfers->AllowAddDeleteRow && $transfers_grid->StopRec == 0) {
	$transfers_grid->StopRec = $transfers->GridAddRowCount;
}

// Initialize aggregate
$transfers->RowType = EW_ROWTYPE_AGGREGATEINIT;
$transfers->ResetAttrs();
$transfers_grid->RenderRow();
if ($transfers->CurrentAction == "gridadd")
	$transfers_grid->RowIndex = 0;
if ($transfers->CurrentAction == "gridedit")
	$transfers_grid->RowIndex = 0;
while ($transfers_grid->RecCnt < $transfers_grid->StopRec) {
	$transfers_grid->RecCnt++;
	if (intval($transfers_grid->RecCnt) >= intval($transfers_grid->StartRec)) {
		$transfers_grid->RowCnt++;
		if ($transfers->CurrentAction == "gridadd" || $transfers->CurrentAction == "gridedit" || $transfers->CurrentAction == "F") {
			$transfers_grid->RowIndex++;
			$objForm->Index = $transfers_grid->RowIndex;
			if ($objForm->HasValue($transfers_grid->FormActionName))
				$transfers_grid->RowAction = strval($objForm->GetValue($transfers_grid->FormActionName));
			elseif ($transfers->CurrentAction == "gridadd")
				$transfers_grid->RowAction = "insert";
			else
				$transfers_grid->RowAction = "";
		}

		// Set up key count
		$transfers_grid->KeyCount = $transfers_grid->RowIndex;

		// Init row class and style
		$transfers->ResetAttrs();
		$transfers->CssClass = "";
		if ($transfers->CurrentAction == "gridadd") {
			if ($transfers->CurrentMode == "copy") {
				$transfers_grid->LoadRowValues($transfers_grid->Recordset); // Load row values
				$transfers_grid->SetRecordKey($transfers_grid->RowOldKey, $transfers_grid->Recordset); // Set old record key
			} else {
				$transfers_grid->LoadRowValues(); // Load default values
				$transfers_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$transfers_grid->LoadRowValues($transfers_grid->Recordset); // Load row values
		}
		$transfers->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($transfers->CurrentAction == "gridadd") // Grid add
			$transfers->RowType = EW_ROWTYPE_ADD; // Render add
		if ($transfers->CurrentAction == "gridadd" && $transfers->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$transfers_grid->RestoreCurrentRowFormValues($transfers_grid->RowIndex); // Restore form values
		if ($transfers->CurrentAction == "gridedit") { // Grid edit
			if ($transfers->EventCancelled) {
				$transfers_grid->RestoreCurrentRowFormValues($transfers_grid->RowIndex); // Restore form values
			}
			if ($transfers_grid->RowAction == "insert")
				$transfers->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$transfers->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($transfers->CurrentAction == "gridedit" && ($transfers->RowType == EW_ROWTYPE_EDIT || $transfers->RowType == EW_ROWTYPE_ADD) && $transfers->EventCancelled) // Update failed
			$transfers_grid->RestoreCurrentRowFormValues($transfers_grid->RowIndex); // Restore form values
		if ($transfers->RowType == EW_ROWTYPE_EDIT) // Edit row
			$transfers_grid->EditRowCnt++;
		if ($transfers->CurrentAction == "F") // Confirm row
			$transfers_grid->RestoreCurrentRowFormValues($transfers_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$transfers->RowAttrs = array_merge($transfers->RowAttrs, array('data-rowindex'=>$transfers_grid->RowCnt, 'id'=>'r' . $transfers_grid->RowCnt . '_transfers', 'data-rowtype'=>$transfers->RowType));

		// Render row
		$transfers_grid->RenderRow();

		// Render list options
		$transfers_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($transfers_grid->RowAction <> "delete" && $transfers_grid->RowAction <> "insertdelete" && !($transfers_grid->RowAction == "insert" && $transfers->CurrentAction == "F" && $transfers_grid->EmptyRow())) {
?>
	<tr<?php echo $transfers->RowAttributes() ?>>
<?php

// Render list options (body, left)
$transfers_grid->ListOptions->Render("body", "left", $transfers_grid->RowCnt);
?>
	<?php if ($transfers->id->Visible) { // id ?>
		<td data-name="id"<?php echo $transfers->id->CellAttributes() ?>>
<?php if ($transfers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="transfers" data-field="x_id" name="o<?php echo $transfers_grid->RowIndex ?>_id" id="o<?php echo $transfers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($transfers->id->OldValue) ?>">
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_id" class="form-group transfers_id">
<span<?php echo $transfers->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="transfers" data-field="x_id" name="x<?php echo $transfers_grid->RowIndex ?>_id" id="x<?php echo $transfers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($transfers->id->CurrentValue) ?>">
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_id" class="transfers_id">
<span<?php echo $transfers->id->ViewAttributes() ?>>
<?php echo $transfers->id->ListViewValue() ?></span>
</span>
<?php if ($transfers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="transfers" data-field="x_id" name="x<?php echo $transfers_grid->RowIndex ?>_id" id="x<?php echo $transfers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($transfers->id->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_id" name="o<?php echo $transfers_grid->RowIndex ?>_id" id="o<?php echo $transfers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($transfers->id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="transfers" data-field="x_id" name="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_id" id="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($transfers->id->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_id" name="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_id" id="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($transfers->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transfers->user_id->Visible) { // user_id ?>
		<td data-name="user_id"<?php echo $transfers->user_id->CellAttributes() ?>>
<?php if ($transfers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($transfers->user_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_user_id" class="form-group transfers_user_id">
<span<?php echo $transfers->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $transfers_grid->RowIndex ?>_user_id" name="x<?php echo $transfers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($transfers->user_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_user_id" class="form-group transfers_user_id">
<input type="text" data-table="transfers" data-field="x_user_id" name="x<?php echo $transfers_grid->RowIndex ?>_user_id" id="x<?php echo $transfers_grid->RowIndex ?>_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->user_id->getPlaceHolder()) ?>" value="<?php echo $transfers->user_id->EditValue ?>"<?php echo $transfers->user_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_user_id" name="o<?php echo $transfers_grid->RowIndex ?>_user_id" id="o<?php echo $transfers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($transfers->user_id->OldValue) ?>">
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($transfers->user_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_user_id" class="form-group transfers_user_id">
<span<?php echo $transfers->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $transfers_grid->RowIndex ?>_user_id" name="x<?php echo $transfers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($transfers->user_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_user_id" class="form-group transfers_user_id">
<input type="text" data-table="transfers" data-field="x_user_id" name="x<?php echo $transfers_grid->RowIndex ?>_user_id" id="x<?php echo $transfers_grid->RowIndex ?>_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->user_id->getPlaceHolder()) ?>" value="<?php echo $transfers->user_id->EditValue ?>"<?php echo $transfers->user_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_user_id" class="transfers_user_id">
<span<?php echo $transfers->user_id->ViewAttributes() ?>>
<?php echo $transfers->user_id->ListViewValue() ?></span>
</span>
<?php if ($transfers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="transfers" data-field="x_user_id" name="x<?php echo $transfers_grid->RowIndex ?>_user_id" id="x<?php echo $transfers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($transfers->user_id->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_user_id" name="o<?php echo $transfers_grid->RowIndex ?>_user_id" id="o<?php echo $transfers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($transfers->user_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="transfers" data-field="x_user_id" name="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_user_id" id="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($transfers->user_id->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_user_id" name="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_user_id" id="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($transfers->user_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transfers->amount->Visible) { // amount ?>
		<td data-name="amount"<?php echo $transfers->amount->CellAttributes() ?>>
<?php if ($transfers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_amount" class="form-group transfers_amount">
<input type="text" data-table="transfers" data-field="x_amount" name="x<?php echo $transfers_grid->RowIndex ?>_amount" id="x<?php echo $transfers_grid->RowIndex ?>_amount" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->amount->getPlaceHolder()) ?>" value="<?php echo $transfers->amount->EditValue ?>"<?php echo $transfers->amount->EditAttributes() ?>>
</span>
<input type="hidden" data-table="transfers" data-field="x_amount" name="o<?php echo $transfers_grid->RowIndex ?>_amount" id="o<?php echo $transfers_grid->RowIndex ?>_amount" value="<?php echo ew_HtmlEncode($transfers->amount->OldValue) ?>">
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_amount" class="form-group transfers_amount">
<input type="text" data-table="transfers" data-field="x_amount" name="x<?php echo $transfers_grid->RowIndex ?>_amount" id="x<?php echo $transfers_grid->RowIndex ?>_amount" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->amount->getPlaceHolder()) ?>" value="<?php echo $transfers->amount->EditValue ?>"<?php echo $transfers->amount->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_amount" class="transfers_amount">
<span<?php echo $transfers->amount->ViewAttributes() ?>>
<?php echo $transfers->amount->ListViewValue() ?></span>
</span>
<?php if ($transfers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="transfers" data-field="x_amount" name="x<?php echo $transfers_grid->RowIndex ?>_amount" id="x<?php echo $transfers_grid->RowIndex ?>_amount" value="<?php echo ew_HtmlEncode($transfers->amount->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_amount" name="o<?php echo $transfers_grid->RowIndex ?>_amount" id="o<?php echo $transfers_grid->RowIndex ?>_amount" value="<?php echo ew_HtmlEncode($transfers->amount->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="transfers" data-field="x_amount" name="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_amount" id="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_amount" value="<?php echo ew_HtmlEncode($transfers->amount->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_amount" name="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_amount" id="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_amount" value="<?php echo ew_HtmlEncode($transfers->amount->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transfers->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id"<?php echo $transfers->currency_id->CellAttributes() ?>>
<?php if ($transfers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_currency_id" class="form-group transfers_currency_id">
<input type="text" data-table="transfers" data-field="x_currency_id" name="x<?php echo $transfers_grid->RowIndex ?>_currency_id" id="x<?php echo $transfers_grid->RowIndex ?>_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->currency_id->getPlaceHolder()) ?>" value="<?php echo $transfers->currency_id->EditValue ?>"<?php echo $transfers->currency_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="transfers" data-field="x_currency_id" name="o<?php echo $transfers_grid->RowIndex ?>_currency_id" id="o<?php echo $transfers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($transfers->currency_id->OldValue) ?>">
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_currency_id" class="form-group transfers_currency_id">
<input type="text" data-table="transfers" data-field="x_currency_id" name="x<?php echo $transfers_grid->RowIndex ?>_currency_id" id="x<?php echo $transfers_grid->RowIndex ?>_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->currency_id->getPlaceHolder()) ?>" value="<?php echo $transfers->currency_id->EditValue ?>"<?php echo $transfers->currency_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_currency_id" class="transfers_currency_id">
<span<?php echo $transfers->currency_id->ViewAttributes() ?>>
<?php echo $transfers->currency_id->ListViewValue() ?></span>
</span>
<?php if ($transfers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="transfers" data-field="x_currency_id" name="x<?php echo $transfers_grid->RowIndex ?>_currency_id" id="x<?php echo $transfers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($transfers->currency_id->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_currency_id" name="o<?php echo $transfers_grid->RowIndex ?>_currency_id" id="o<?php echo $transfers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($transfers->currency_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="transfers" data-field="x_currency_id" name="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_currency_id" id="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($transfers->currency_id->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_currency_id" name="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_currency_id" id="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($transfers->currency_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transfers->type->Visible) { // type ?>
		<td data-name="type"<?php echo $transfers->type->CellAttributes() ?>>
<?php if ($transfers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_type" class="form-group transfers_type">
<div id="tp_x<?php echo $transfers_grid->RowIndex ?>_type" class="ewTemplate"><input type="radio" data-table="transfers" data-field="x_type" data-value-separator="<?php echo $transfers->type->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $transfers_grid->RowIndex ?>_type" id="x<?php echo $transfers_grid->RowIndex ?>_type" value="{value}"<?php echo $transfers->type->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $transfers_grid->RowIndex ?>_type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $transfers->type->RadioButtonListHtml(FALSE, "x{$transfers_grid->RowIndex}_type") ?>
</div></div>
</span>
<input type="hidden" data-table="transfers" data-field="x_type" name="o<?php echo $transfers_grid->RowIndex ?>_type" id="o<?php echo $transfers_grid->RowIndex ?>_type" value="<?php echo ew_HtmlEncode($transfers->type->OldValue) ?>">
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_type" class="form-group transfers_type">
<div id="tp_x<?php echo $transfers_grid->RowIndex ?>_type" class="ewTemplate"><input type="radio" data-table="transfers" data-field="x_type" data-value-separator="<?php echo $transfers->type->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $transfers_grid->RowIndex ?>_type" id="x<?php echo $transfers_grid->RowIndex ?>_type" value="{value}"<?php echo $transfers->type->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $transfers_grid->RowIndex ?>_type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $transfers->type->RadioButtonListHtml(FALSE, "x{$transfers_grid->RowIndex}_type") ?>
</div></div>
</span>
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_type" class="transfers_type">
<span<?php echo $transfers->type->ViewAttributes() ?>>
<?php echo $transfers->type->ListViewValue() ?></span>
</span>
<?php if ($transfers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="transfers" data-field="x_type" name="x<?php echo $transfers_grid->RowIndex ?>_type" id="x<?php echo $transfers_grid->RowIndex ?>_type" value="<?php echo ew_HtmlEncode($transfers->type->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_type" name="o<?php echo $transfers_grid->RowIndex ?>_type" id="o<?php echo $transfers_grid->RowIndex ?>_type" value="<?php echo ew_HtmlEncode($transfers->type->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="transfers" data-field="x_type" name="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_type" id="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_type" value="<?php echo ew_HtmlEncode($transfers->type->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_type" name="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_type" id="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_type" value="<?php echo ew_HtmlEncode($transfers->type->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transfers->order_id->Visible) { // order_id ?>
		<td data-name="order_id"<?php echo $transfers->order_id->CellAttributes() ?>>
<?php if ($transfers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_order_id" class="form-group transfers_order_id">
<input type="text" data-table="transfers" data-field="x_order_id" name="x<?php echo $transfers_grid->RowIndex ?>_order_id" id="x<?php echo $transfers_grid->RowIndex ?>_order_id" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->order_id->getPlaceHolder()) ?>" value="<?php echo $transfers->order_id->EditValue ?>"<?php echo $transfers->order_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="transfers" data-field="x_order_id" name="o<?php echo $transfers_grid->RowIndex ?>_order_id" id="o<?php echo $transfers_grid->RowIndex ?>_order_id" value="<?php echo ew_HtmlEncode($transfers->order_id->OldValue) ?>">
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_order_id" class="form-group transfers_order_id">
<input type="text" data-table="transfers" data-field="x_order_id" name="x<?php echo $transfers_grid->RowIndex ?>_order_id" id="x<?php echo $transfers_grid->RowIndex ?>_order_id" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->order_id->getPlaceHolder()) ?>" value="<?php echo $transfers->order_id->EditValue ?>"<?php echo $transfers->order_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_order_id" class="transfers_order_id">
<span<?php echo $transfers->order_id->ViewAttributes() ?>>
<?php echo $transfers->order_id->ListViewValue() ?></span>
</span>
<?php if ($transfers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="transfers" data-field="x_order_id" name="x<?php echo $transfers_grid->RowIndex ?>_order_id" id="x<?php echo $transfers_grid->RowIndex ?>_order_id" value="<?php echo ew_HtmlEncode($transfers->order_id->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_order_id" name="o<?php echo $transfers_grid->RowIndex ?>_order_id" id="o<?php echo $transfers_grid->RowIndex ?>_order_id" value="<?php echo ew_HtmlEncode($transfers->order_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="transfers" data-field="x_order_id" name="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_order_id" id="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_order_id" value="<?php echo ew_HtmlEncode($transfers->order_id->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_order_id" name="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_order_id" id="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_order_id" value="<?php echo ew_HtmlEncode($transfers->order_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transfers->approved->Visible) { // approved ?>
		<td data-name="approved"<?php echo $transfers->approved->CellAttributes() ?>>
<?php if ($transfers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_approved" class="form-group transfers_approved">
<input type="text" data-table="transfers" data-field="x_approved" name="x<?php echo $transfers_grid->RowIndex ?>_approved" id="x<?php echo $transfers_grid->RowIndex ?>_approved" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->approved->getPlaceHolder()) ?>" value="<?php echo $transfers->approved->EditValue ?>"<?php echo $transfers->approved->EditAttributes() ?>>
</span>
<input type="hidden" data-table="transfers" data-field="x_approved" name="o<?php echo $transfers_grid->RowIndex ?>_approved" id="o<?php echo $transfers_grid->RowIndex ?>_approved" value="<?php echo ew_HtmlEncode($transfers->approved->OldValue) ?>">
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_approved" class="form-group transfers_approved">
<input type="text" data-table="transfers" data-field="x_approved" name="x<?php echo $transfers_grid->RowIndex ?>_approved" id="x<?php echo $transfers_grid->RowIndex ?>_approved" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->approved->getPlaceHolder()) ?>" value="<?php echo $transfers->approved->EditValue ?>"<?php echo $transfers->approved->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_approved" class="transfers_approved">
<span<?php echo $transfers->approved->ViewAttributes() ?>>
<?php echo $transfers->approved->ListViewValue() ?></span>
</span>
<?php if ($transfers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="transfers" data-field="x_approved" name="x<?php echo $transfers_grid->RowIndex ?>_approved" id="x<?php echo $transfers_grid->RowIndex ?>_approved" value="<?php echo ew_HtmlEncode($transfers->approved->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_approved" name="o<?php echo $transfers_grid->RowIndex ?>_approved" id="o<?php echo $transfers_grid->RowIndex ?>_approved" value="<?php echo ew_HtmlEncode($transfers->approved->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="transfers" data-field="x_approved" name="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_approved" id="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_approved" value="<?php echo ew_HtmlEncode($transfers->approved->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_approved" name="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_approved" id="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_approved" value="<?php echo ew_HtmlEncode($transfers->approved->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transfers->verification_code->Visible) { // verification_code ?>
		<td data-name="verification_code"<?php echo $transfers->verification_code->CellAttributes() ?>>
<?php if ($transfers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_verification_code" class="form-group transfers_verification_code">
<input type="text" data-table="transfers" data-field="x_verification_code" name="x<?php echo $transfers_grid->RowIndex ?>_verification_code" id="x<?php echo $transfers_grid->RowIndex ?>_verification_code" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($transfers->verification_code->getPlaceHolder()) ?>" value="<?php echo $transfers->verification_code->EditValue ?>"<?php echo $transfers->verification_code->EditAttributes() ?>>
</span>
<input type="hidden" data-table="transfers" data-field="x_verification_code" name="o<?php echo $transfers_grid->RowIndex ?>_verification_code" id="o<?php echo $transfers_grid->RowIndex ?>_verification_code" value="<?php echo ew_HtmlEncode($transfers->verification_code->OldValue) ?>">
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_verification_code" class="form-group transfers_verification_code">
<input type="text" data-table="transfers" data-field="x_verification_code" name="x<?php echo $transfers_grid->RowIndex ?>_verification_code" id="x<?php echo $transfers_grid->RowIndex ?>_verification_code" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($transfers->verification_code->getPlaceHolder()) ?>" value="<?php echo $transfers->verification_code->EditValue ?>"<?php echo $transfers->verification_code->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_verification_code" class="transfers_verification_code">
<span<?php echo $transfers->verification_code->ViewAttributes() ?>>
<?php echo $transfers->verification_code->ListViewValue() ?></span>
</span>
<?php if ($transfers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="transfers" data-field="x_verification_code" name="x<?php echo $transfers_grid->RowIndex ?>_verification_code" id="x<?php echo $transfers_grid->RowIndex ?>_verification_code" value="<?php echo ew_HtmlEncode($transfers->verification_code->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_verification_code" name="o<?php echo $transfers_grid->RowIndex ?>_verification_code" id="o<?php echo $transfers_grid->RowIndex ?>_verification_code" value="<?php echo ew_HtmlEncode($transfers->verification_code->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="transfers" data-field="x_verification_code" name="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_verification_code" id="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_verification_code" value="<?php echo ew_HtmlEncode($transfers->verification_code->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_verification_code" name="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_verification_code" id="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_verification_code" value="<?php echo ew_HtmlEncode($transfers->verification_code->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transfers->created_at->Visible) { // created_at ?>
		<td data-name="created_at"<?php echo $transfers->created_at->CellAttributes() ?>>
<?php if ($transfers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_created_at" class="form-group transfers_created_at">
<input type="text" data-table="transfers" data-field="x_created_at" name="x<?php echo $transfers_grid->RowIndex ?>_created_at" id="x<?php echo $transfers_grid->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($transfers->created_at->getPlaceHolder()) ?>" value="<?php echo $transfers->created_at->EditValue ?>"<?php echo $transfers->created_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="transfers" data-field="x_created_at" name="o<?php echo $transfers_grid->RowIndex ?>_created_at" id="o<?php echo $transfers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($transfers->created_at->OldValue) ?>">
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_created_at" class="form-group transfers_created_at">
<input type="text" data-table="transfers" data-field="x_created_at" name="x<?php echo $transfers_grid->RowIndex ?>_created_at" id="x<?php echo $transfers_grid->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($transfers->created_at->getPlaceHolder()) ?>" value="<?php echo $transfers->created_at->EditValue ?>"<?php echo $transfers->created_at->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_created_at" class="transfers_created_at">
<span<?php echo $transfers->created_at->ViewAttributes() ?>>
<?php echo $transfers->created_at->ListViewValue() ?></span>
</span>
<?php if ($transfers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="transfers" data-field="x_created_at" name="x<?php echo $transfers_grid->RowIndex ?>_created_at" id="x<?php echo $transfers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($transfers->created_at->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_created_at" name="o<?php echo $transfers_grid->RowIndex ?>_created_at" id="o<?php echo $transfers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($transfers->created_at->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="transfers" data-field="x_created_at" name="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_created_at" id="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($transfers->created_at->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_created_at" name="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_created_at" id="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($transfers->created_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($transfers->updated_at->Visible) { // updated_at ?>
		<td data-name="updated_at"<?php echo $transfers->updated_at->CellAttributes() ?>>
<?php if ($transfers->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_updated_at" class="form-group transfers_updated_at">
<input type="text" data-table="transfers" data-field="x_updated_at" name="x<?php echo $transfers_grid->RowIndex ?>_updated_at" id="x<?php echo $transfers_grid->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($transfers->updated_at->getPlaceHolder()) ?>" value="<?php echo $transfers->updated_at->EditValue ?>"<?php echo $transfers->updated_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="transfers" data-field="x_updated_at" name="o<?php echo $transfers_grid->RowIndex ?>_updated_at" id="o<?php echo $transfers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($transfers->updated_at->OldValue) ?>">
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_updated_at" class="form-group transfers_updated_at">
<input type="text" data-table="transfers" data-field="x_updated_at" name="x<?php echo $transfers_grid->RowIndex ?>_updated_at" id="x<?php echo $transfers_grid->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($transfers->updated_at->getPlaceHolder()) ?>" value="<?php echo $transfers->updated_at->EditValue ?>"<?php echo $transfers->updated_at->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($transfers->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $transfers_grid->RowCnt ?>_transfers_updated_at" class="transfers_updated_at">
<span<?php echo $transfers->updated_at->ViewAttributes() ?>>
<?php echo $transfers->updated_at->ListViewValue() ?></span>
</span>
<?php if ($transfers->CurrentAction <> "F") { ?>
<input type="hidden" data-table="transfers" data-field="x_updated_at" name="x<?php echo $transfers_grid->RowIndex ?>_updated_at" id="x<?php echo $transfers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($transfers->updated_at->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_updated_at" name="o<?php echo $transfers_grid->RowIndex ?>_updated_at" id="o<?php echo $transfers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($transfers->updated_at->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="transfers" data-field="x_updated_at" name="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_updated_at" id="ftransfersgrid$x<?php echo $transfers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($transfers->updated_at->FormValue) ?>">
<input type="hidden" data-table="transfers" data-field="x_updated_at" name="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_updated_at" id="ftransfersgrid$o<?php echo $transfers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($transfers->updated_at->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$transfers_grid->ListOptions->Render("body", "right", $transfers_grid->RowCnt);
?>
	</tr>
<?php if ($transfers->RowType == EW_ROWTYPE_ADD || $transfers->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftransfersgrid.UpdateOpts(<?php echo $transfers_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($transfers->CurrentAction <> "gridadd" || $transfers->CurrentMode == "copy")
		if (!$transfers_grid->Recordset->EOF) $transfers_grid->Recordset->MoveNext();
}
?>
<?php
	if ($transfers->CurrentMode == "add" || $transfers->CurrentMode == "copy" || $transfers->CurrentMode == "edit") {
		$transfers_grid->RowIndex = '$rowindex$';
		$transfers_grid->LoadRowValues();

		// Set row properties
		$transfers->ResetAttrs();
		$transfers->RowAttrs = array_merge($transfers->RowAttrs, array('data-rowindex'=>$transfers_grid->RowIndex, 'id'=>'r0_transfers', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($transfers->RowAttrs["class"], "ewTemplate");
		$transfers->RowType = EW_ROWTYPE_ADD;

		// Render row
		$transfers_grid->RenderRow();

		// Render list options
		$transfers_grid->RenderListOptions();
		$transfers_grid->StartRowCnt = 0;
?>
	<tr<?php echo $transfers->RowAttributes() ?>>
<?php

// Render list options (body, left)
$transfers_grid->ListOptions->Render("body", "left", $transfers_grid->RowIndex);
?>
	<?php if ($transfers->id->Visible) { // id ?>
		<td data-name="id">
<?php if ($transfers->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_transfers_id" class="form-group transfers_id">
<span<?php echo $transfers->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transfers" data-field="x_id" name="x<?php echo $transfers_grid->RowIndex ?>_id" id="x<?php echo $transfers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($transfers->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_id" name="o<?php echo $transfers_grid->RowIndex ?>_id" id="o<?php echo $transfers_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($transfers->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transfers->user_id->Visible) { // user_id ?>
		<td data-name="user_id">
<?php if ($transfers->CurrentAction <> "F") { ?>
<?php if ($transfers->user_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_transfers_user_id" class="form-group transfers_user_id">
<span<?php echo $transfers->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $transfers_grid->RowIndex ?>_user_id" name="x<?php echo $transfers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($transfers->user_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_transfers_user_id" class="form-group transfers_user_id">
<input type="text" data-table="transfers" data-field="x_user_id" name="x<?php echo $transfers_grid->RowIndex ?>_user_id" id="x<?php echo $transfers_grid->RowIndex ?>_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->user_id->getPlaceHolder()) ?>" value="<?php echo $transfers->user_id->EditValue ?>"<?php echo $transfers->user_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_transfers_user_id" class="form-group transfers_user_id">
<span<?php echo $transfers->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transfers" data-field="x_user_id" name="x<?php echo $transfers_grid->RowIndex ?>_user_id" id="x<?php echo $transfers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($transfers->user_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_user_id" name="o<?php echo $transfers_grid->RowIndex ?>_user_id" id="o<?php echo $transfers_grid->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($transfers->user_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transfers->amount->Visible) { // amount ?>
		<td data-name="amount">
<?php if ($transfers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_transfers_amount" class="form-group transfers_amount">
<input type="text" data-table="transfers" data-field="x_amount" name="x<?php echo $transfers_grid->RowIndex ?>_amount" id="x<?php echo $transfers_grid->RowIndex ?>_amount" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->amount->getPlaceHolder()) ?>" value="<?php echo $transfers->amount->EditValue ?>"<?php echo $transfers->amount->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_transfers_amount" class="form-group transfers_amount">
<span<?php echo $transfers->amount->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->amount->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transfers" data-field="x_amount" name="x<?php echo $transfers_grid->RowIndex ?>_amount" id="x<?php echo $transfers_grid->RowIndex ?>_amount" value="<?php echo ew_HtmlEncode($transfers->amount->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_amount" name="o<?php echo $transfers_grid->RowIndex ?>_amount" id="o<?php echo $transfers_grid->RowIndex ?>_amount" value="<?php echo ew_HtmlEncode($transfers->amount->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transfers->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id">
<?php if ($transfers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_transfers_currency_id" class="form-group transfers_currency_id">
<input type="text" data-table="transfers" data-field="x_currency_id" name="x<?php echo $transfers_grid->RowIndex ?>_currency_id" id="x<?php echo $transfers_grid->RowIndex ?>_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->currency_id->getPlaceHolder()) ?>" value="<?php echo $transfers->currency_id->EditValue ?>"<?php echo $transfers->currency_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_transfers_currency_id" class="form-group transfers_currency_id">
<span<?php echo $transfers->currency_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->currency_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transfers" data-field="x_currency_id" name="x<?php echo $transfers_grid->RowIndex ?>_currency_id" id="x<?php echo $transfers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($transfers->currency_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_currency_id" name="o<?php echo $transfers_grid->RowIndex ?>_currency_id" id="o<?php echo $transfers_grid->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($transfers->currency_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transfers->type->Visible) { // type ?>
		<td data-name="type">
<?php if ($transfers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_transfers_type" class="form-group transfers_type">
<div id="tp_x<?php echo $transfers_grid->RowIndex ?>_type" class="ewTemplate"><input type="radio" data-table="transfers" data-field="x_type" data-value-separator="<?php echo $transfers->type->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $transfers_grid->RowIndex ?>_type" id="x<?php echo $transfers_grid->RowIndex ?>_type" value="{value}"<?php echo $transfers->type->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $transfers_grid->RowIndex ?>_type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $transfers->type->RadioButtonListHtml(FALSE, "x{$transfers_grid->RowIndex}_type") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_transfers_type" class="form-group transfers_type">
<span<?php echo $transfers->type->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->type->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transfers" data-field="x_type" name="x<?php echo $transfers_grid->RowIndex ?>_type" id="x<?php echo $transfers_grid->RowIndex ?>_type" value="<?php echo ew_HtmlEncode($transfers->type->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_type" name="o<?php echo $transfers_grid->RowIndex ?>_type" id="o<?php echo $transfers_grid->RowIndex ?>_type" value="<?php echo ew_HtmlEncode($transfers->type->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transfers->order_id->Visible) { // order_id ?>
		<td data-name="order_id">
<?php if ($transfers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_transfers_order_id" class="form-group transfers_order_id">
<input type="text" data-table="transfers" data-field="x_order_id" name="x<?php echo $transfers_grid->RowIndex ?>_order_id" id="x<?php echo $transfers_grid->RowIndex ?>_order_id" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->order_id->getPlaceHolder()) ?>" value="<?php echo $transfers->order_id->EditValue ?>"<?php echo $transfers->order_id->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_transfers_order_id" class="form-group transfers_order_id">
<span<?php echo $transfers->order_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->order_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transfers" data-field="x_order_id" name="x<?php echo $transfers_grid->RowIndex ?>_order_id" id="x<?php echo $transfers_grid->RowIndex ?>_order_id" value="<?php echo ew_HtmlEncode($transfers->order_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_order_id" name="o<?php echo $transfers_grid->RowIndex ?>_order_id" id="o<?php echo $transfers_grid->RowIndex ?>_order_id" value="<?php echo ew_HtmlEncode($transfers->order_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transfers->approved->Visible) { // approved ?>
		<td data-name="approved">
<?php if ($transfers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_transfers_approved" class="form-group transfers_approved">
<input type="text" data-table="transfers" data-field="x_approved" name="x<?php echo $transfers_grid->RowIndex ?>_approved" id="x<?php echo $transfers_grid->RowIndex ?>_approved" size="30" placeholder="<?php echo ew_HtmlEncode($transfers->approved->getPlaceHolder()) ?>" value="<?php echo $transfers->approved->EditValue ?>"<?php echo $transfers->approved->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_transfers_approved" class="form-group transfers_approved">
<span<?php echo $transfers->approved->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->approved->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transfers" data-field="x_approved" name="x<?php echo $transfers_grid->RowIndex ?>_approved" id="x<?php echo $transfers_grid->RowIndex ?>_approved" value="<?php echo ew_HtmlEncode($transfers->approved->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_approved" name="o<?php echo $transfers_grid->RowIndex ?>_approved" id="o<?php echo $transfers_grid->RowIndex ?>_approved" value="<?php echo ew_HtmlEncode($transfers->approved->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transfers->verification_code->Visible) { // verification_code ?>
		<td data-name="verification_code">
<?php if ($transfers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_transfers_verification_code" class="form-group transfers_verification_code">
<input type="text" data-table="transfers" data-field="x_verification_code" name="x<?php echo $transfers_grid->RowIndex ?>_verification_code" id="x<?php echo $transfers_grid->RowIndex ?>_verification_code" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($transfers->verification_code->getPlaceHolder()) ?>" value="<?php echo $transfers->verification_code->EditValue ?>"<?php echo $transfers->verification_code->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_transfers_verification_code" class="form-group transfers_verification_code">
<span<?php echo $transfers->verification_code->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->verification_code->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transfers" data-field="x_verification_code" name="x<?php echo $transfers_grid->RowIndex ?>_verification_code" id="x<?php echo $transfers_grid->RowIndex ?>_verification_code" value="<?php echo ew_HtmlEncode($transfers->verification_code->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_verification_code" name="o<?php echo $transfers_grid->RowIndex ?>_verification_code" id="o<?php echo $transfers_grid->RowIndex ?>_verification_code" value="<?php echo ew_HtmlEncode($transfers->verification_code->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transfers->created_at->Visible) { // created_at ?>
		<td data-name="created_at">
<?php if ($transfers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_transfers_created_at" class="form-group transfers_created_at">
<input type="text" data-table="transfers" data-field="x_created_at" name="x<?php echo $transfers_grid->RowIndex ?>_created_at" id="x<?php echo $transfers_grid->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($transfers->created_at->getPlaceHolder()) ?>" value="<?php echo $transfers->created_at->EditValue ?>"<?php echo $transfers->created_at->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_transfers_created_at" class="form-group transfers_created_at">
<span<?php echo $transfers->created_at->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->created_at->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transfers" data-field="x_created_at" name="x<?php echo $transfers_grid->RowIndex ?>_created_at" id="x<?php echo $transfers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($transfers->created_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_created_at" name="o<?php echo $transfers_grid->RowIndex ?>_created_at" id="o<?php echo $transfers_grid->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($transfers->created_at->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($transfers->updated_at->Visible) { // updated_at ?>
		<td data-name="updated_at">
<?php if ($transfers->CurrentAction <> "F") { ?>
<span id="el$rowindex$_transfers_updated_at" class="form-group transfers_updated_at">
<input type="text" data-table="transfers" data-field="x_updated_at" name="x<?php echo $transfers_grid->RowIndex ?>_updated_at" id="x<?php echo $transfers_grid->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($transfers->updated_at->getPlaceHolder()) ?>" value="<?php echo $transfers->updated_at->EditValue ?>"<?php echo $transfers->updated_at->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_transfers_updated_at" class="form-group transfers_updated_at">
<span<?php echo $transfers->updated_at->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $transfers->updated_at->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="transfers" data-field="x_updated_at" name="x<?php echo $transfers_grid->RowIndex ?>_updated_at" id="x<?php echo $transfers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($transfers->updated_at->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="transfers" data-field="x_updated_at" name="o<?php echo $transfers_grid->RowIndex ?>_updated_at" id="o<?php echo $transfers_grid->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($transfers->updated_at->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$transfers_grid->ListOptions->Render("body", "right", $transfers_grid->RowIndex);
?>
<script type="text/javascript">
ftransfersgrid.UpdateOpts(<?php echo $transfers_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($transfers->CurrentMode == "add" || $transfers->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $transfers_grid->FormKeyCountName ?>" id="<?php echo $transfers_grid->FormKeyCountName ?>" value="<?php echo $transfers_grid->KeyCount ?>">
<?php echo $transfers_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($transfers->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $transfers_grid->FormKeyCountName ?>" id="<?php echo $transfers_grid->FormKeyCountName ?>" value="<?php echo $transfers_grid->KeyCount ?>">
<?php echo $transfers_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($transfers->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftransfersgrid">
</div>
<?php

// Close recordset
if ($transfers_grid->Recordset)
	$transfers_grid->Recordset->Close();
?>
<?php if ($transfers_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($transfers_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($transfers_grid->TotalRecs == 0 && $transfers->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($transfers_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($transfers->Export == "") { ?>
<script type="text/javascript">
ftransfersgrid.Init();
</script>
<?php } ?>
<?php
$transfers_grid->Page_Terminate();
?>
