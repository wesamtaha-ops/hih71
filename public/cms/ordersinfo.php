<?php

// Global variable for table object
$orders = NULL;

//
// Table class for orders
//
class corders extends cTable {
	var $id;
	var $student_id;
	var $teacher_id;
	var $topic_id;
	var $date;
	var $time;
	var $fees;
	var $currency_id;
	var $status;
	var $meeting_id;
	var $created_at;
	var $updated_at;
	var $package_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'orders';
		$this->TableName = 'orders';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`orders`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('orders', 'orders', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// student_id
		$this->student_id = new cField('orders', 'orders', 'x_student_id', 'student_id', '`student_id`', '`student_id`', 19, -1, FALSE, '`student_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->student_id->Sortable = TRUE; // Allow sort
		$this->student_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->student_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->student_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['student_id'] = &$this->student_id;

		// teacher_id
		$this->teacher_id = new cField('orders', 'orders', 'x_teacher_id', 'teacher_id', '`teacher_id`', '`teacher_id`', 19, -1, FALSE, '`teacher_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->teacher_id->Sortable = TRUE; // Allow sort
		$this->teacher_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->teacher_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->teacher_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['teacher_id'] = &$this->teacher_id;

		// topic_id
		$this->topic_id = new cField('orders', 'orders', 'x_topic_id', 'topic_id', '`topic_id`', '`topic_id`', 19, -1, FALSE, '`topic_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->topic_id->Sortable = TRUE; // Allow sort
		$this->topic_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->topic_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->topic_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['topic_id'] = &$this->topic_id;

		// date
		$this->date = new cField('orders', 'orders', 'x_date', 'date', '`date`', ew_CastDateFieldForLike('`date`', 0, "DB"), 133, 0, FALSE, '`date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->date->Sortable = TRUE; // Allow sort
		$this->date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['date'] = &$this->date;

		// time
		$this->time = new cField('orders', 'orders', 'x_time', 'time', '`time`', '`time`', 201, -1, FALSE, '`time`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->time->Sortable = TRUE; // Allow sort
		$this->fields['time'] = &$this->time;

		// fees
		$this->fees = new cField('orders', 'orders', 'x_fees', 'fees', '`fees`', '`fees`', 3, -1, FALSE, '`fees`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fees->Sortable = TRUE; // Allow sort
		$this->fees->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fees'] = &$this->fees;

		// currency_id
		$this->currency_id = new cField('orders', 'orders', 'x_currency_id', 'currency_id', '`currency_id`', '`currency_id`', 19, -1, FALSE, '`currency_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->currency_id->Sortable = TRUE; // Allow sort
		$this->currency_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->currency_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->currency_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['currency_id'] = &$this->currency_id;

		// status
		$this->status = new cField('orders', 'orders', 'x_status', 'status', '`status`', '`status`', 202, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->status->Sortable = TRUE; // Allow sort
		$this->status->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->status->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->status->OptionCount = 3;
		$this->fields['status'] = &$this->status;

		// meeting_id
		$this->meeting_id = new cField('orders', 'orders', 'x_meeting_id', 'meeting_id', '`meeting_id`', '`meeting_id`', 201, -1, FALSE, '`meeting_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->meeting_id->Sortable = TRUE; // Allow sort
		$this->fields['meeting_id'] = &$this->meeting_id;

		// created_at
		$this->created_at = new cField('orders', 'orders', 'x_created_at', 'created_at', '`created_at`', ew_CastDateFieldForLike('`created_at`', 0, "DB"), 135, 0, FALSE, '`created_at`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->created_at->Sortable = FALSE; // Allow sort
		$this->created_at->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['created_at'] = &$this->created_at;

		// updated_at
		$this->updated_at = new cField('orders', 'orders', 'x_updated_at', 'updated_at', '`updated_at`', ew_CastDateFieldForLike('`updated_at`', 0, "DB"), 135, 0, FALSE, '`updated_at`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->updated_at->Sortable = FALSE; // Allow sort
		$this->updated_at->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['updated_at'] = &$this->updated_at;

		// package_id
		$this->package_id = new cField('orders', 'orders', 'x_package_id', 'package_id', '`package_id`', '`package_id`', 19, -1, FALSE, '`package_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->package_id->Sortable = TRUE; // Allow sort
		$this->package_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['package_id'] = &$this->package_id;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`orders`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "orderslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "ordersview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "ordersedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "ordersadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "orderslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ordersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ordersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ordersadd.php?" . $this->UrlParm($parm);
		else
			$url = "ordersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("ordersedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("ordersadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ordersdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = $_POST["id"];
			elseif (isset($_GET["id"]))
				$arKeys[] = $_GET["id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->student_id->setDbValue($rs->fields('student_id'));
		$this->teacher_id->setDbValue($rs->fields('teacher_id'));
		$this->topic_id->setDbValue($rs->fields('topic_id'));
		$this->date->setDbValue($rs->fields('date'));
		$this->time->setDbValue($rs->fields('time'));
		$this->fees->setDbValue($rs->fields('fees'));
		$this->currency_id->setDbValue($rs->fields('currency_id'));
		$this->status->setDbValue($rs->fields('status'));
		$this->meeting_id->setDbValue($rs->fields('meeting_id'));
		$this->created_at->setDbValue($rs->fields('created_at'));
		$this->updated_at->setDbValue($rs->fields('updated_at'));
		$this->package_id->setDbValue($rs->fields('package_id'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// student_id
		// teacher_id
		// topic_id
		// date
		// time
		// fees
		// currency_id
		// status
		// meeting_id
		// created_at

		$this->created_at->CellCssStyle = "white-space: nowrap;";

		// updated_at
		$this->updated_at->CellCssStyle = "white-space: nowrap;";

		// package_id
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// student_id
		if (strval($this->student_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->student_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `users`";
		$sWhereWrk = "";
		$this->student_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->student_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->student_id->ViewValue = $this->student_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->student_id->ViewValue = $this->student_id->CurrentValue;
			}
		} else {
			$this->student_id->ViewValue = NULL;
		}
		$this->student_id->ViewCustomAttributes = "";

		// teacher_id
		if (strval($this->teacher_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->teacher_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `users`";
		$sWhereWrk = "";
		$this->teacher_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->teacher_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->teacher_id->ViewValue = $this->teacher_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->teacher_id->ViewValue = $this->teacher_id->CurrentValue;
			}
		} else {
			$this->teacher_id->ViewValue = NULL;
		}
		$this->teacher_id->ViewCustomAttributes = "";

		// topic_id
		if (strval($this->topic_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->topic_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `name_ar` AS `DispFld`, `name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `topics`";
		$sWhereWrk = "";
		$this->topic_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->topic_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->topic_id->ViewValue = $this->topic_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->topic_id->ViewValue = $this->topic_id->CurrentValue;
			}
		} else {
			$this->topic_id->ViewValue = NULL;
		}
		$this->topic_id->ViewCustomAttributes = "";

		// date
		$this->date->ViewValue = $this->date->CurrentValue;
		$this->date->ViewValue = ew_FormatDateTime($this->date->ViewValue, 0);
		$this->date->ViewCustomAttributes = "";

		// time
		$this->time->ViewValue = $this->time->CurrentValue;
		$this->time->ViewCustomAttributes = "";

		// fees
		$this->fees->ViewValue = $this->fees->CurrentValue;
		$this->fees->ViewCustomAttributes = "";

		// currency_id
		if (strval($this->currency_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->currency_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `name_ar` AS `DispFld`, `name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `currencies`";
		$sWhereWrk = "";
		$this->currency_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->currency_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->currency_id->ViewValue = $this->currency_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->currency_id->ViewValue = $this->currency_id->CurrentValue;
			}
		} else {
			$this->currency_id->ViewValue = NULL;
		}
		$this->currency_id->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

		// meeting_id
		$this->meeting_id->ViewValue = $this->meeting_id->CurrentValue;
		$this->meeting_id->ViewCustomAttributes = "";

		// created_at
		$this->created_at->ViewValue = $this->created_at->CurrentValue;
		$this->created_at->ViewValue = ew_FormatDateTime($this->created_at->ViewValue, 0);
		$this->created_at->ViewCustomAttributes = "";

		// updated_at
		$this->updated_at->ViewValue = $this->updated_at->CurrentValue;
		$this->updated_at->ViewValue = ew_FormatDateTime($this->updated_at->ViewValue, 0);
		$this->updated_at->ViewCustomAttributes = "";

		// package_id
		$this->package_id->ViewValue = $this->package_id->CurrentValue;
		$this->package_id->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// student_id
		$this->student_id->LinkCustomAttributes = "";
		$this->student_id->HrefValue = "";
		$this->student_id->TooltipValue = "";

		// teacher_id
		$this->teacher_id->LinkCustomAttributes = "";
		$this->teacher_id->HrefValue = "";
		$this->teacher_id->TooltipValue = "";

		// topic_id
		$this->topic_id->LinkCustomAttributes = "";
		$this->topic_id->HrefValue = "";
		$this->topic_id->TooltipValue = "";

		// date
		$this->date->LinkCustomAttributes = "";
		$this->date->HrefValue = "";
		$this->date->TooltipValue = "";

		// time
		$this->time->LinkCustomAttributes = "";
		$this->time->HrefValue = "";
		$this->time->TooltipValue = "";

		// fees
		$this->fees->LinkCustomAttributes = "";
		$this->fees->HrefValue = "";
		$this->fees->TooltipValue = "";

		// currency_id
		$this->currency_id->LinkCustomAttributes = "";
		$this->currency_id->HrefValue = "";
		$this->currency_id->TooltipValue = "";

		// status
		$this->status->LinkCustomAttributes = "";
		$this->status->HrefValue = "";
		$this->status->TooltipValue = "";

		// meeting_id
		$this->meeting_id->LinkCustomAttributes = "";
		$this->meeting_id->HrefValue = "";
		$this->meeting_id->TooltipValue = "";

		// created_at
		$this->created_at->LinkCustomAttributes = "";
		$this->created_at->HrefValue = "";
		$this->created_at->TooltipValue = "";

		// updated_at
		$this->updated_at->LinkCustomAttributes = "";
		$this->updated_at->HrefValue = "";
		$this->updated_at->TooltipValue = "";

		// package_id
		$this->package_id->LinkCustomAttributes = "";
		$this->package_id->HrefValue = "";
		$this->package_id->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// student_id
		$this->student_id->EditAttrs["class"] = "form-control";
		$this->student_id->EditCustomAttributes = "";

		// teacher_id
		$this->teacher_id->EditAttrs["class"] = "form-control";
		$this->teacher_id->EditCustomAttributes = "";

		// topic_id
		$this->topic_id->EditAttrs["class"] = "form-control";
		$this->topic_id->EditCustomAttributes = "";

		// date
		$this->date->EditAttrs["class"] = "form-control";
		$this->date->EditCustomAttributes = "";
		$this->date->EditValue = ew_FormatDateTime($this->date->CurrentValue, 8);
		$this->date->PlaceHolder = ew_RemoveHtml($this->date->FldCaption());

		// time
		$this->time->EditAttrs["class"] = "form-control";
		$this->time->EditCustomAttributes = "";
		$this->time->EditValue = $this->time->CurrentValue;
		$this->time->PlaceHolder = ew_RemoveHtml($this->time->FldCaption());

		// fees
		$this->fees->EditAttrs["class"] = "form-control";
		$this->fees->EditCustomAttributes = "";
		$this->fees->EditValue = $this->fees->CurrentValue;
		$this->fees->PlaceHolder = ew_RemoveHtml($this->fees->FldCaption());

		// currency_id
		$this->currency_id->EditAttrs["class"] = "form-control";
		$this->currency_id->EditCustomAttributes = "";

		// status
		$this->status->EditAttrs["class"] = "form-control";
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->Options(TRUE);

		// meeting_id
		$this->meeting_id->EditAttrs["class"] = "form-control";
		$this->meeting_id->EditCustomAttributes = "";
		$this->meeting_id->EditValue = $this->meeting_id->CurrentValue;
		$this->meeting_id->PlaceHolder = ew_RemoveHtml($this->meeting_id->FldCaption());

		// created_at
		$this->created_at->EditAttrs["class"] = "form-control";
		$this->created_at->EditCustomAttributes = "";
		$this->created_at->EditValue = ew_FormatDateTime($this->created_at->CurrentValue, 8);
		$this->created_at->PlaceHolder = ew_RemoveHtml($this->created_at->FldCaption());

		// updated_at
		$this->updated_at->EditAttrs["class"] = "form-control";
		$this->updated_at->EditCustomAttributes = "";
		$this->updated_at->EditValue = ew_FormatDateTime($this->updated_at->CurrentValue, 8);
		$this->updated_at->PlaceHolder = ew_RemoveHtml($this->updated_at->FldCaption());

		// package_id
		$this->package_id->EditAttrs["class"] = "form-control";
		$this->package_id->EditCustomAttributes = "";
		$this->package_id->EditValue = $this->package_id->CurrentValue;
		$this->package_id->PlaceHolder = ew_RemoveHtml($this->package_id->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->student_id->Exportable) $Doc->ExportCaption($this->student_id);
					if ($this->teacher_id->Exportable) $Doc->ExportCaption($this->teacher_id);
					if ($this->topic_id->Exportable) $Doc->ExportCaption($this->topic_id);
					if ($this->date->Exportable) $Doc->ExportCaption($this->date);
					if ($this->time->Exportable) $Doc->ExportCaption($this->time);
					if ($this->fees->Exportable) $Doc->ExportCaption($this->fees);
					if ($this->currency_id->Exportable) $Doc->ExportCaption($this->currency_id);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->meeting_id->Exportable) $Doc->ExportCaption($this->meeting_id);
					if ($this->package_id->Exportable) $Doc->ExportCaption($this->package_id);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->student_id->Exportable) $Doc->ExportCaption($this->student_id);
					if ($this->teacher_id->Exportable) $Doc->ExportCaption($this->teacher_id);
					if ($this->topic_id->Exportable) $Doc->ExportCaption($this->topic_id);
					if ($this->date->Exportable) $Doc->ExportCaption($this->date);
					if ($this->fees->Exportable) $Doc->ExportCaption($this->fees);
					if ($this->currency_id->Exportable) $Doc->ExportCaption($this->currency_id);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->package_id->Exportable) $Doc->ExportCaption($this->package_id);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->student_id->Exportable) $Doc->ExportField($this->student_id);
						if ($this->teacher_id->Exportable) $Doc->ExportField($this->teacher_id);
						if ($this->topic_id->Exportable) $Doc->ExportField($this->topic_id);
						if ($this->date->Exportable) $Doc->ExportField($this->date);
						if ($this->time->Exportable) $Doc->ExportField($this->time);
						if ($this->fees->Exportable) $Doc->ExportField($this->fees);
						if ($this->currency_id->Exportable) $Doc->ExportField($this->currency_id);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->meeting_id->Exportable) $Doc->ExportField($this->meeting_id);
						if ($this->package_id->Exportable) $Doc->ExportField($this->package_id);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->student_id->Exportable) $Doc->ExportField($this->student_id);
						if ($this->teacher_id->Exportable) $Doc->ExportField($this->teacher_id);
						if ($this->topic_id->Exportable) $Doc->ExportField($this->topic_id);
						if ($this->date->Exportable) $Doc->ExportField($this->date);
						if ($this->fees->Exportable) $Doc->ExportField($this->fees);
						if ($this->currency_id->Exportable) $Doc->ExportField($this->currency_id);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->package_id->Exportable) $Doc->ExportField($this->package_id);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
