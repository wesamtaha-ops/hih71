<?php

// Global variable for table object
$teachers = NULL;

//
// Table class for teachers
//
class cteachers extends cTable {
	var $id;
	var $user_id;
	var $timezone;
	var $teacher_language;
	var $video;
	var $heading_ar;
	var $description_ar;
	var $heading_en;
	var $description_en;
	var $allow_express;
	var $fees;
	var $currency_id;
	var $created_at;
	var $updated_at;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'teachers';
		$this->TableName = 'teachers';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`teachers`";
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
		$this->id = new cField('teachers', 'teachers', 'x_id', 'id', '`id`', '`id`', 19, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// user_id
		$this->user_id = new cField('teachers', 'teachers', 'x_user_id', 'user_id', '`user_id`', '`user_id`', 19, -1, FALSE, '`user_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_id->Sortable = TRUE; // Allow sort
		$this->user_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_id'] = &$this->user_id;

		// timezone
		$this->timezone = new cField('teachers', 'teachers', 'x_timezone', 'timezone', '`timezone`', '`timezone`', 201, -1, FALSE, '`timezone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->timezone->Sortable = TRUE; // Allow sort
		$this->fields['timezone'] = &$this->timezone;

		// teacher_language
		$this->teacher_language = new cField('teachers', 'teachers', 'x_teacher_language', 'teacher_language', '`teacher_language`', '`teacher_language`', 201, -1, FALSE, '`teacher_language`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->teacher_language->Sortable = TRUE; // Allow sort
		$this->fields['teacher_language'] = &$this->teacher_language;

		// video
		$this->video = new cField('teachers', 'teachers', 'x_video', 'video', '`video`', '`video`', 201, -1, FALSE, '`video`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->video->Sortable = TRUE; // Allow sort
		$this->fields['video'] = &$this->video;

		// heading_ar
		$this->heading_ar = new cField('teachers', 'teachers', 'x_heading_ar', 'heading_ar', '`heading_ar`', '`heading_ar`', 201, -1, FALSE, '`heading_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->heading_ar->Sortable = TRUE; // Allow sort
		$this->fields['heading_ar'] = &$this->heading_ar;

		// description_ar
		$this->description_ar = new cField('teachers', 'teachers', 'x_description_ar', 'description_ar', '`description_ar`', '`description_ar`', 201, -1, FALSE, '`description_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description_ar->Sortable = TRUE; // Allow sort
		$this->fields['description_ar'] = &$this->description_ar;

		// heading_en
		$this->heading_en = new cField('teachers', 'teachers', 'x_heading_en', 'heading_en', '`heading_en`', '`heading_en`', 201, -1, FALSE, '`heading_en`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->heading_en->Sortable = TRUE; // Allow sort
		$this->fields['heading_en'] = &$this->heading_en;

		// description_en
		$this->description_en = new cField('teachers', 'teachers', 'x_description_en', 'description_en', '`description_en`', '`description_en`', 201, -1, FALSE, '`description_en`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description_en->Sortable = TRUE; // Allow sort
		$this->fields['description_en'] = &$this->description_en;

		// allow_express
		$this->allow_express = new cField('teachers', 'teachers', 'x_allow_express', 'allow_express', '`allow_express`', '`allow_express`', 16, -1, FALSE, '`allow_express`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->allow_express->Sortable = TRUE; // Allow sort
		$this->allow_express->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['allow_express'] = &$this->allow_express;

		// fees
		$this->fees = new cField('teachers', 'teachers', 'x_fees', 'fees', '`fees`', '`fees`', 3, -1, FALSE, '`fees`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fees->Sortable = TRUE; // Allow sort
		$this->fees->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['fees'] = &$this->fees;

		// currency_id
		$this->currency_id = new cField('teachers', 'teachers', 'x_currency_id', 'currency_id', '`currency_id`', '`currency_id`', 19, -1, FALSE, '`currency_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->currency_id->Sortable = TRUE; // Allow sort
		$this->currency_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['currency_id'] = &$this->currency_id;

		// created_at
		$this->created_at = new cField('teachers', 'teachers', 'x_created_at', 'created_at', '`created_at`', ew_CastDateFieldForLike('`created_at`', 0, "DB"), 135, 0, FALSE, '`created_at`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->created_at->Sortable = TRUE; // Allow sort
		$this->created_at->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['created_at'] = &$this->created_at;

		// updated_at
		$this->updated_at = new cField('teachers', 'teachers', 'x_updated_at', 'updated_at', '`updated_at`', ew_CastDateFieldForLike('`updated_at`', 0, "DB"), 135, 0, FALSE, '`updated_at`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->updated_at->Sortable = TRUE; // Allow sort
		$this->updated_at->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['updated_at'] = &$this->updated_at;
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

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "users") {
			if ($this->user_id->getSessionValue() <> "")
				$sMasterFilter .= "`id`=" . ew_QuotedValue($this->user_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "users") {
			if ($this->user_id->getSessionValue() <> "")
				$sDetailFilter .= "`user_id`=" . ew_QuotedValue($this->user_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_users() {
		return "`id`=@id@";
	}

	// Detail filter
	function SqlDetailFilter_users() {
		return "`user_id`=@user_id@";
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "teachers_certificates") {
			$sDetailUrl = $GLOBALS["teachers_certificates"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "teachers_courses") {
			$sDetailUrl = $GLOBALS["teachers_courses"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "teachers_experiences") {
			$sDetailUrl = $GLOBALS["teachers_experiences"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "teachers_levels") {
			$sDetailUrl = $GLOBALS["teachers_levels"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "teachers_packages") {
			$sDetailUrl = $GLOBALS["teachers_packages"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "teachers_topics") {
			$sDetailUrl = $GLOBALS["teachers_topics"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "teachers_trains") {
			$sDetailUrl = $GLOBALS["teachers_trains"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "orders") {
			$sDetailUrl = $GLOBALS["orders"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "teacherslist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`teachers`";
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
			return "teacherslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "teachersview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "teachersedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "teachersadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "teacherslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("teachersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("teachersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "teachersadd.php?" . $this->UrlParm($parm);
		else
			$url = "teachersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("teachersedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("teachersedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("teachersadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("teachersadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("teachersdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "users" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_id=" . urlencode($this->user_id->CurrentValue);
		}
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
		$this->user_id->setDbValue($rs->fields('user_id'));
		$this->timezone->setDbValue($rs->fields('timezone'));
		$this->teacher_language->setDbValue($rs->fields('teacher_language'));
		$this->video->setDbValue($rs->fields('video'));
		$this->heading_ar->setDbValue($rs->fields('heading_ar'));
		$this->description_ar->setDbValue($rs->fields('description_ar'));
		$this->heading_en->setDbValue($rs->fields('heading_en'));
		$this->description_en->setDbValue($rs->fields('description_en'));
		$this->allow_express->setDbValue($rs->fields('allow_express'));
		$this->fees->setDbValue($rs->fields('fees'));
		$this->currency_id->setDbValue($rs->fields('currency_id'));
		$this->created_at->setDbValue($rs->fields('created_at'));
		$this->updated_at->setDbValue($rs->fields('updated_at'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// user_id
		// timezone
		// teacher_language
		// video
		// heading_ar
		// description_ar
		// heading_en
		// description_en
		// allow_express
		// fees
		// currency_id
		// created_at
		// updated_at
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// user_id
		$this->user_id->ViewValue = $this->user_id->CurrentValue;
		$this->user_id->ViewCustomAttributes = "";

		// timezone
		$this->timezone->ViewValue = $this->timezone->CurrentValue;
		$this->timezone->ViewCustomAttributes = "";

		// teacher_language
		$this->teacher_language->ViewValue = $this->teacher_language->CurrentValue;
		$this->teacher_language->ViewCustomAttributes = "";

		// video
		$this->video->ViewValue = $this->video->CurrentValue;
		$this->video->ViewCustomAttributes = "";

		// heading_ar
		$this->heading_ar->ViewValue = $this->heading_ar->CurrentValue;
		$this->heading_ar->ViewCustomAttributes = "";

		// description_ar
		$this->description_ar->ViewValue = $this->description_ar->CurrentValue;
		$this->description_ar->ViewCustomAttributes = "";

		// heading_en
		$this->heading_en->ViewValue = $this->heading_en->CurrentValue;
		$this->heading_en->ViewCustomAttributes = "";

		// description_en
		$this->description_en->ViewValue = $this->description_en->CurrentValue;
		$this->description_en->ViewCustomAttributes = "";

		// allow_express
		$this->allow_express->ViewValue = $this->allow_express->CurrentValue;
		$this->allow_express->ViewCustomAttributes = "";

		// fees
		$this->fees->ViewValue = $this->fees->CurrentValue;
		$this->fees->ViewCustomAttributes = "";

		// currency_id
		$this->currency_id->ViewValue = $this->currency_id->CurrentValue;
		$this->currency_id->ViewCustomAttributes = "";

		// created_at
		$this->created_at->ViewValue = $this->created_at->CurrentValue;
		$this->created_at->ViewValue = ew_FormatDateTime($this->created_at->ViewValue, 0);
		$this->created_at->ViewCustomAttributes = "";

		// updated_at
		$this->updated_at->ViewValue = $this->updated_at->CurrentValue;
		$this->updated_at->ViewValue = ew_FormatDateTime($this->updated_at->ViewValue, 0);
		$this->updated_at->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// user_id
		$this->user_id->LinkCustomAttributes = "";
		$this->user_id->HrefValue = "";
		$this->user_id->TooltipValue = "";

		// timezone
		$this->timezone->LinkCustomAttributes = "";
		$this->timezone->HrefValue = "";
		$this->timezone->TooltipValue = "";

		// teacher_language
		$this->teacher_language->LinkCustomAttributes = "";
		$this->teacher_language->HrefValue = "";
		$this->teacher_language->TooltipValue = "";

		// video
		$this->video->LinkCustomAttributes = "";
		$this->video->HrefValue = "";
		$this->video->TooltipValue = "";

		// heading_ar
		$this->heading_ar->LinkCustomAttributes = "";
		$this->heading_ar->HrefValue = "";
		$this->heading_ar->TooltipValue = "";

		// description_ar
		$this->description_ar->LinkCustomAttributes = "";
		$this->description_ar->HrefValue = "";
		$this->description_ar->TooltipValue = "";

		// heading_en
		$this->heading_en->LinkCustomAttributes = "";
		$this->heading_en->HrefValue = "";
		$this->heading_en->TooltipValue = "";

		// description_en
		$this->description_en->LinkCustomAttributes = "";
		$this->description_en->HrefValue = "";
		$this->description_en->TooltipValue = "";

		// allow_express
		$this->allow_express->LinkCustomAttributes = "";
		$this->allow_express->HrefValue = "";
		$this->allow_express->TooltipValue = "";

		// fees
		$this->fees->LinkCustomAttributes = "";
		$this->fees->HrefValue = "";
		$this->fees->TooltipValue = "";

		// currency_id
		$this->currency_id->LinkCustomAttributes = "";
		$this->currency_id->HrefValue = "";
		$this->currency_id->TooltipValue = "";

		// created_at
		$this->created_at->LinkCustomAttributes = "";
		$this->created_at->HrefValue = "";
		$this->created_at->TooltipValue = "";

		// updated_at
		$this->updated_at->LinkCustomAttributes = "";
		$this->updated_at->HrefValue = "";
		$this->updated_at->TooltipValue = "";

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

		// user_id
		$this->user_id->EditAttrs["class"] = "form-control";
		$this->user_id->EditCustomAttributes = "";
		if ($this->user_id->getSessionValue() <> "") {
			$this->user_id->CurrentValue = $this->user_id->getSessionValue();
		$this->user_id->ViewValue = $this->user_id->CurrentValue;
		$this->user_id->ViewCustomAttributes = "";
		} else {
		$this->user_id->EditValue = $this->user_id->CurrentValue;
		$this->user_id->PlaceHolder = ew_RemoveHtml($this->user_id->FldCaption());
		}

		// timezone
		$this->timezone->EditAttrs["class"] = "form-control";
		$this->timezone->EditCustomAttributes = "";
		$this->timezone->EditValue = $this->timezone->CurrentValue;
		$this->timezone->PlaceHolder = ew_RemoveHtml($this->timezone->FldCaption());

		// teacher_language
		$this->teacher_language->EditAttrs["class"] = "form-control";
		$this->teacher_language->EditCustomAttributes = "";
		$this->teacher_language->EditValue = $this->teacher_language->CurrentValue;
		$this->teacher_language->PlaceHolder = ew_RemoveHtml($this->teacher_language->FldCaption());

		// video
		$this->video->EditAttrs["class"] = "form-control";
		$this->video->EditCustomAttributes = "";
		$this->video->EditValue = $this->video->CurrentValue;
		$this->video->PlaceHolder = ew_RemoveHtml($this->video->FldCaption());

		// heading_ar
		$this->heading_ar->EditAttrs["class"] = "form-control";
		$this->heading_ar->EditCustomAttributes = "";
		$this->heading_ar->EditValue = $this->heading_ar->CurrentValue;
		$this->heading_ar->PlaceHolder = ew_RemoveHtml($this->heading_ar->FldCaption());

		// description_ar
		$this->description_ar->EditAttrs["class"] = "form-control";
		$this->description_ar->EditCustomAttributes = "";
		$this->description_ar->EditValue = $this->description_ar->CurrentValue;
		$this->description_ar->PlaceHolder = ew_RemoveHtml($this->description_ar->FldCaption());

		// heading_en
		$this->heading_en->EditAttrs["class"] = "form-control";
		$this->heading_en->EditCustomAttributes = "";
		$this->heading_en->EditValue = $this->heading_en->CurrentValue;
		$this->heading_en->PlaceHolder = ew_RemoveHtml($this->heading_en->FldCaption());

		// description_en
		$this->description_en->EditAttrs["class"] = "form-control";
		$this->description_en->EditCustomAttributes = "";
		$this->description_en->EditValue = $this->description_en->CurrentValue;
		$this->description_en->PlaceHolder = ew_RemoveHtml($this->description_en->FldCaption());

		// allow_express
		$this->allow_express->EditAttrs["class"] = "form-control";
		$this->allow_express->EditCustomAttributes = "";
		$this->allow_express->EditValue = $this->allow_express->CurrentValue;
		$this->allow_express->PlaceHolder = ew_RemoveHtml($this->allow_express->FldCaption());

		// fees
		$this->fees->EditAttrs["class"] = "form-control";
		$this->fees->EditCustomAttributes = "";
		$this->fees->EditValue = $this->fees->CurrentValue;
		$this->fees->PlaceHolder = ew_RemoveHtml($this->fees->FldCaption());

		// currency_id
		$this->currency_id->EditAttrs["class"] = "form-control";
		$this->currency_id->EditCustomAttributes = "";
		$this->currency_id->EditValue = $this->currency_id->CurrentValue;
		$this->currency_id->PlaceHolder = ew_RemoveHtml($this->currency_id->FldCaption());

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
					if ($this->user_id->Exportable) $Doc->ExportCaption($this->user_id);
					if ($this->timezone->Exportable) $Doc->ExportCaption($this->timezone);
					if ($this->teacher_language->Exportable) $Doc->ExportCaption($this->teacher_language);
					if ($this->video->Exportable) $Doc->ExportCaption($this->video);
					if ($this->heading_ar->Exportable) $Doc->ExportCaption($this->heading_ar);
					if ($this->description_ar->Exportable) $Doc->ExportCaption($this->description_ar);
					if ($this->heading_en->Exportable) $Doc->ExportCaption($this->heading_en);
					if ($this->description_en->Exportable) $Doc->ExportCaption($this->description_en);
					if ($this->allow_express->Exportable) $Doc->ExportCaption($this->allow_express);
					if ($this->fees->Exportable) $Doc->ExportCaption($this->fees);
					if ($this->currency_id->Exportable) $Doc->ExportCaption($this->currency_id);
					if ($this->created_at->Exportable) $Doc->ExportCaption($this->created_at);
					if ($this->updated_at->Exportable) $Doc->ExportCaption($this->updated_at);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->user_id->Exportable) $Doc->ExportCaption($this->user_id);
					if ($this->allow_express->Exportable) $Doc->ExportCaption($this->allow_express);
					if ($this->fees->Exportable) $Doc->ExportCaption($this->fees);
					if ($this->currency_id->Exportable) $Doc->ExportCaption($this->currency_id);
					if ($this->created_at->Exportable) $Doc->ExportCaption($this->created_at);
					if ($this->updated_at->Exportable) $Doc->ExportCaption($this->updated_at);
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
						if ($this->user_id->Exportable) $Doc->ExportField($this->user_id);
						if ($this->timezone->Exportable) $Doc->ExportField($this->timezone);
						if ($this->teacher_language->Exportable) $Doc->ExportField($this->teacher_language);
						if ($this->video->Exportable) $Doc->ExportField($this->video);
						if ($this->heading_ar->Exportable) $Doc->ExportField($this->heading_ar);
						if ($this->description_ar->Exportable) $Doc->ExportField($this->description_ar);
						if ($this->heading_en->Exportable) $Doc->ExportField($this->heading_en);
						if ($this->description_en->Exportable) $Doc->ExportField($this->description_en);
						if ($this->allow_express->Exportable) $Doc->ExportField($this->allow_express);
						if ($this->fees->Exportable) $Doc->ExportField($this->fees);
						if ($this->currency_id->Exportable) $Doc->ExportField($this->currency_id);
						if ($this->created_at->Exportable) $Doc->ExportField($this->created_at);
						if ($this->updated_at->Exportable) $Doc->ExportField($this->updated_at);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->user_id->Exportable) $Doc->ExportField($this->user_id);
						if ($this->allow_express->Exportable) $Doc->ExportField($this->allow_express);
						if ($this->fees->Exportable) $Doc->ExportField($this->fees);
						if ($this->currency_id->Exportable) $Doc->ExportField($this->currency_id);
						if ($this->created_at->Exportable) $Doc->ExportField($this->created_at);
						if ($this->updated_at->Exportable) $Doc->ExportField($this->updated_at);
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
