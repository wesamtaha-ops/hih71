<?php

// Global variable for table object
$users = NULL;

//
// Table class for users
//
class cusers extends cTable {
	var $id;
	var $name;
	var $_email;
	var $email_verified_at;
	var $password;
	var $phone;
	var $gender;
	var $birthday;
	var $image;
	var $country_id;
	var $city;
	var $currency_id;
	var $type;
	var $is_verified;
	var $is_approved;
	var $is_blocked;
	var $otp;
	var $slug;
	var $remember_token;
	var $created_at;
	var $updated_at;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'users';
		$this->TableName = 'users';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`users`";
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
		$this->id = new cField('users', 'users', 'x_id', 'id', '`id`', '`id`', 19, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// name
		$this->name = new cField('users', 'users', 'x_name', 'name', '`name`', '`name`', 200, -1, FALSE, '`name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->name->Sortable = TRUE; // Allow sort
		$this->fields['name'] = &$this->name;

		// email
		$this->_email = new cField('users', 'users', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_email->Sortable = TRUE; // Allow sort
		$this->fields['email'] = &$this->_email;

		// email_verified_at
		$this->email_verified_at = new cField('users', 'users', 'x_email_verified_at', 'email_verified_at', '`email_verified_at`', ew_CastDateFieldForLike('`email_verified_at`', 0, "DB"), 135, 0, FALSE, '`email_verified_at`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->email_verified_at->Sortable = FALSE; // Allow sort
		$this->email_verified_at->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['email_verified_at'] = &$this->email_verified_at;

		// password
		$this->password = new cField('users', 'users', 'x_password', 'password', '`password`', '`password`', 200, -1, FALSE, '`password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->password->Sortable = TRUE; // Allow sort
		$this->fields['password'] = &$this->password;

		// phone
		$this->phone = new cField('users', 'users', 'x_phone', 'phone', '`phone`', '`phone`', 201, -1, FALSE, '`phone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->phone->Sortable = TRUE; // Allow sort
		$this->fields['phone'] = &$this->phone;

		// gender
		$this->gender = new cField('users', 'users', 'x_gender', 'gender', '`gender`', '`gender`', 202, -1, FALSE, '`gender`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->gender->Sortable = TRUE; // Allow sort
		$this->gender->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->gender->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->gender->OptionCount = 2;
		$this->fields['gender'] = &$this->gender;

		// birthday
		$this->birthday = new cField('users', 'users', 'x_birthday', 'birthday', '`birthday`', ew_CastDateFieldForLike('`birthday`', 0, "DB"), 133, 0, FALSE, '`birthday`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->birthday->Sortable = TRUE; // Allow sort
		$this->birthday->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['birthday'] = &$this->birthday;

		// image
		$this->image = new cField('users', 'users', 'x_image', 'image', '`image`', '`image`', 201, -1, FALSE, '`image`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->image->Sortable = TRUE; // Allow sort
		$this->fields['image'] = &$this->image;

		// country_id
		$this->country_id = new cField('users', 'users', 'x_country_id', 'country_id', '`country_id`', '`country_id`', 19, -1, FALSE, '`country_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->country_id->Sortable = TRUE; // Allow sort
		$this->country_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->country_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->country_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['country_id'] = &$this->country_id;

		// city
		$this->city = new cField('users', 'users', 'x_city', 'city', '`city`', '`city`', 201, -1, FALSE, '`city`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->city->Sortable = TRUE; // Allow sort
		$this->fields['city'] = &$this->city;

		// currency_id
		$this->currency_id = new cField('users', 'users', 'x_currency_id', 'currency_id', '`currency_id`', '`currency_id`', 19, -1, FALSE, '`currency_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->currency_id->Sortable = TRUE; // Allow sort
		$this->currency_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->currency_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->currency_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['currency_id'] = &$this->currency_id;

		// type
		$this->type = new cField('users', 'users', 'x_type', 'type', '`type`', '`type`', 202, -1, FALSE, '`type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->type->Sortable = TRUE; // Allow sort
		$this->type->OptionCount = 3;
		$this->fields['type'] = &$this->type;

		// is_verified
		$this->is_verified = new cField('users', 'users', 'x_is_verified', 'is_verified', '`is_verified`', '`is_verified`', 16, -1, FALSE, '`is_verified`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->is_verified->Sortable = TRUE; // Allow sort
		$this->is_verified->OptionCount = 2;
		$this->is_verified->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['is_verified'] = &$this->is_verified;

		// is_approved
		$this->is_approved = new cField('users', 'users', 'x_is_approved', 'is_approved', '`is_approved`', '`is_approved`', 16, -1, FALSE, '`is_approved`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->is_approved->Sortable = TRUE; // Allow sort
		$this->is_approved->OptionCount = 2;
		$this->is_approved->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['is_approved'] = &$this->is_approved;

		// is_blocked
		$this->is_blocked = new cField('users', 'users', 'x_is_blocked', 'is_blocked', '`is_blocked`', '`is_blocked`', 16, -1, FALSE, '`is_blocked`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->is_blocked->Sortable = TRUE; // Allow sort
		$this->is_blocked->OptionCount = 2;
		$this->is_blocked->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['is_blocked'] = &$this->is_blocked;

		// otp
		$this->otp = new cField('users', 'users', 'x_otp', 'otp', '`otp`', '`otp`', 201, -1, FALSE, '`otp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->otp->Sortable = TRUE; // Allow sort
		$this->fields['otp'] = &$this->otp;

		// slug
		$this->slug = new cField('users', 'users', 'x_slug', 'slug', '`slug`', '`slug`', 201, -1, FALSE, '`slug`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->slug->Sortable = TRUE; // Allow sort
		$this->fields['slug'] = &$this->slug;

		// remember_token
		$this->remember_token = new cField('users', 'users', 'x_remember_token', 'remember_token', '`remember_token`', '`remember_token`', 200, -1, FALSE, '`remember_token`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->remember_token->Sortable = TRUE; // Allow sort
		$this->fields['remember_token'] = &$this->remember_token;

		// created_at
		$this->created_at = new cField('users', 'users', 'x_created_at', 'created_at', '`created_at`', ew_CastDateFieldForLike('`created_at`', 0, "DB"), 135, 0, FALSE, '`created_at`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->created_at->Sortable = FALSE; // Allow sort
		$this->created_at->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['created_at'] = &$this->created_at;

		// updated_at
		$this->updated_at = new cField('users', 'users', 'x_updated_at', 'updated_at', '`updated_at`', ew_CastDateFieldForLike('`updated_at`', 0, "DB"), 135, 0, FALSE, '`updated_at`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->updated_at->Sortable = FALSE; // Allow sort
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
		if ($this->getCurrentDetailTable() == "transfers") {
			$sDetailUrl = $GLOBALS["transfers"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "userslist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`users`";
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
			return "userslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "usersview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "usersedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "usersadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "userslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("usersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("usersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "usersadd.php?" . $this->UrlParm($parm);
		else
			$url = "usersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("usersedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("usersedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("usersadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("usersadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("usersdelete.php", $this->UrlParm());
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
		$this->name->setDbValue($rs->fields('name'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->email_verified_at->setDbValue($rs->fields('email_verified_at'));
		$this->password->setDbValue($rs->fields('password'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->gender->setDbValue($rs->fields('gender'));
		$this->birthday->setDbValue($rs->fields('birthday'));
		$this->image->setDbValue($rs->fields('image'));
		$this->country_id->setDbValue($rs->fields('country_id'));
		$this->city->setDbValue($rs->fields('city'));
		$this->currency_id->setDbValue($rs->fields('currency_id'));
		$this->type->setDbValue($rs->fields('type'));
		$this->is_verified->setDbValue($rs->fields('is_verified'));
		$this->is_approved->setDbValue($rs->fields('is_approved'));
		$this->is_blocked->setDbValue($rs->fields('is_blocked'));
		$this->otp->setDbValue($rs->fields('otp'));
		$this->slug->setDbValue($rs->fields('slug'));
		$this->remember_token->setDbValue($rs->fields('remember_token'));
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
		// name
		// email
		// email_verified_at

		$this->email_verified_at->CellCssStyle = "white-space: nowrap;";

		// password
		$this->password->CellCssStyle = "white-space: nowrap;";

		// phone
		// gender
		// birthday
		// image
		// country_id
		// city
		// currency_id
		// type
		// is_verified
		// is_approved
		// is_blocked
		// otp
		// slug
		// remember_token
		// created_at

		$this->created_at->CellCssStyle = "white-space: nowrap;";

		// updated_at
		$this->updated_at->CellCssStyle = "white-space: nowrap;";

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// email_verified_at
		$this->email_verified_at->ViewValue = $this->email_verified_at->CurrentValue;
		$this->email_verified_at->ViewValue = ew_FormatDateTime($this->email_verified_at->ViewValue, 0);
		$this->email_verified_at->ViewCustomAttributes = "";

		// password
		$this->password->ViewValue = $this->password->CurrentValue;
		$this->password->ViewCustomAttributes = "";

		// phone
		$this->phone->ViewValue = $this->phone->CurrentValue;
		$this->phone->ViewCustomAttributes = "";

		// gender
		if (strval($this->gender->CurrentValue) <> "") {
			$this->gender->ViewValue = $this->gender->OptionCaption($this->gender->CurrentValue);
		} else {
			$this->gender->ViewValue = NULL;
		}
		$this->gender->ViewCustomAttributes = "";

		// birthday
		$this->birthday->ViewValue = $this->birthday->CurrentValue;
		$this->birthday->ViewValue = ew_FormatDateTime($this->birthday->ViewValue, 0);
		$this->birthday->ViewCustomAttributes = "";

		// image
		$this->image->ViewValue = $this->image->CurrentValue;
		$this->image->ViewCustomAttributes = "";

		// country_id
		if (strval($this->country_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->country_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `name_ar` AS `DispFld`, `name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `countries`";
		$sWhereWrk = "";
		$this->country_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->country_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->country_id->ViewValue = $this->country_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->country_id->ViewValue = $this->country_id->CurrentValue;
			}
		} else {
			$this->country_id->ViewValue = NULL;
		}
		$this->country_id->ViewCustomAttributes = "";

		// city
		$this->city->ViewValue = $this->city->CurrentValue;
		$this->city->ViewCustomAttributes = "";

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

		// type
		if (strval($this->type->CurrentValue) <> "") {
			$this->type->ViewValue = $this->type->OptionCaption($this->type->CurrentValue);
		} else {
			$this->type->ViewValue = NULL;
		}
		$this->type->ViewCustomAttributes = "";

		// is_verified
		if (strval($this->is_verified->CurrentValue) <> "") {
			$this->is_verified->ViewValue = $this->is_verified->OptionCaption($this->is_verified->CurrentValue);
		} else {
			$this->is_verified->ViewValue = NULL;
		}
		$this->is_verified->ViewCustomAttributes = "";

		// is_approved
		if (strval($this->is_approved->CurrentValue) <> "") {
			$this->is_approved->ViewValue = $this->is_approved->OptionCaption($this->is_approved->CurrentValue);
		} else {
			$this->is_approved->ViewValue = NULL;
		}
		$this->is_approved->ViewCustomAttributes = "";

		// is_blocked
		if (strval($this->is_blocked->CurrentValue) <> "") {
			$this->is_blocked->ViewValue = $this->is_blocked->OptionCaption($this->is_blocked->CurrentValue);
		} else {
			$this->is_blocked->ViewValue = NULL;
		}
		$this->is_blocked->ViewCustomAttributes = "";

		// otp
		$this->otp->ViewValue = $this->otp->CurrentValue;
		$this->otp->ViewCustomAttributes = "";

		// slug
		$this->slug->ViewValue = $this->slug->CurrentValue;
		$this->slug->ViewCustomAttributes = "";

		// remember_token
		$this->remember_token->ViewValue = $this->remember_token->CurrentValue;
		$this->remember_token->ViewCustomAttributes = "";

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

		// name
		$this->name->LinkCustomAttributes = "";
		$this->name->HrefValue = "";
		$this->name->TooltipValue = "";

		// email
		$this->_email->LinkCustomAttributes = "";
		$this->_email->HrefValue = "";
		$this->_email->TooltipValue = "";

		// email_verified_at
		$this->email_verified_at->LinkCustomAttributes = "";
		$this->email_verified_at->HrefValue = "";
		$this->email_verified_at->TooltipValue = "";

		// password
		$this->password->LinkCustomAttributes = "";
		$this->password->HrefValue = "";
		$this->password->TooltipValue = "";

		// phone
		$this->phone->LinkCustomAttributes = "";
		$this->phone->HrefValue = "";
		$this->phone->TooltipValue = "";

		// gender
		$this->gender->LinkCustomAttributes = "";
		$this->gender->HrefValue = "";
		$this->gender->TooltipValue = "";

		// birthday
		$this->birthday->LinkCustomAttributes = "";
		$this->birthday->HrefValue = "";
		$this->birthday->TooltipValue = "";

		// image
		$this->image->LinkCustomAttributes = "";
		$this->image->HrefValue = "";
		$this->image->TooltipValue = "";

		// country_id
		$this->country_id->LinkCustomAttributes = "";
		$this->country_id->HrefValue = "";
		$this->country_id->TooltipValue = "";

		// city
		$this->city->LinkCustomAttributes = "";
		$this->city->HrefValue = "";
		$this->city->TooltipValue = "";

		// currency_id
		$this->currency_id->LinkCustomAttributes = "";
		$this->currency_id->HrefValue = "";
		$this->currency_id->TooltipValue = "";

		// type
		$this->type->LinkCustomAttributes = "";
		$this->type->HrefValue = "";
		$this->type->TooltipValue = "";

		// is_verified
		$this->is_verified->LinkCustomAttributes = "";
		$this->is_verified->HrefValue = "";
		$this->is_verified->TooltipValue = "";

		// is_approved
		$this->is_approved->LinkCustomAttributes = "";
		$this->is_approved->HrefValue = "";
		$this->is_approved->TooltipValue = "";

		// is_blocked
		$this->is_blocked->LinkCustomAttributes = "";
		$this->is_blocked->HrefValue = "";
		$this->is_blocked->TooltipValue = "";

		// otp
		$this->otp->LinkCustomAttributes = "";
		$this->otp->HrefValue = "";
		$this->otp->TooltipValue = "";

		// slug
		$this->slug->LinkCustomAttributes = "";
		$this->slug->HrefValue = "";
		$this->slug->TooltipValue = "";

		// remember_token
		$this->remember_token->LinkCustomAttributes = "";
		$this->remember_token->HrefValue = "";
		$this->remember_token->TooltipValue = "";

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

		// name
		$this->name->EditAttrs["class"] = "form-control";
		$this->name->EditCustomAttributes = "";
		$this->name->EditValue = $this->name->CurrentValue;
		$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

		// email
		$this->_email->EditAttrs["class"] = "form-control";
		$this->_email->EditCustomAttributes = "";
		$this->_email->EditValue = $this->_email->CurrentValue;
		$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

		// email_verified_at
		$this->email_verified_at->EditAttrs["class"] = "form-control";
		$this->email_verified_at->EditCustomAttributes = "";
		$this->email_verified_at->EditValue = ew_FormatDateTime($this->email_verified_at->CurrentValue, 8);
		$this->email_verified_at->PlaceHolder = ew_RemoveHtml($this->email_verified_at->FldCaption());

		// password
		$this->password->EditAttrs["class"] = "form-control";
		$this->password->EditCustomAttributes = "";
		$this->password->EditValue = $this->password->CurrentValue;
		$this->password->PlaceHolder = ew_RemoveHtml($this->password->FldCaption());

		// phone
		$this->phone->EditAttrs["class"] = "form-control";
		$this->phone->EditCustomAttributes = "";
		$this->phone->EditValue = $this->phone->CurrentValue;
		$this->phone->PlaceHolder = ew_RemoveHtml($this->phone->FldCaption());

		// gender
		$this->gender->EditAttrs["class"] = "form-control";
		$this->gender->EditCustomAttributes = "";
		$this->gender->EditValue = $this->gender->Options(TRUE);

		// birthday
		$this->birthday->EditAttrs["class"] = "form-control";
		$this->birthday->EditCustomAttributes = "";
		$this->birthday->EditValue = ew_FormatDateTime($this->birthday->CurrentValue, 8);
		$this->birthday->PlaceHolder = ew_RemoveHtml($this->birthday->FldCaption());

		// image
		$this->image->EditAttrs["class"] = "form-control";
		$this->image->EditCustomAttributes = "";
		$this->image->EditValue = $this->image->CurrentValue;
		$this->image->PlaceHolder = ew_RemoveHtml($this->image->FldCaption());

		// country_id
		$this->country_id->EditAttrs["class"] = "form-control";
		$this->country_id->EditCustomAttributes = "";

		// city
		$this->city->EditAttrs["class"] = "form-control";
		$this->city->EditCustomAttributes = "";
		$this->city->EditValue = $this->city->CurrentValue;
		$this->city->PlaceHolder = ew_RemoveHtml($this->city->FldCaption());

		// currency_id
		$this->currency_id->EditAttrs["class"] = "form-control";
		$this->currency_id->EditCustomAttributes = "";

		// type
		$this->type->EditCustomAttributes = "";
		$this->type->EditValue = $this->type->Options(FALSE);

		// is_verified
		$this->is_verified->EditCustomAttributes = "";
		$this->is_verified->EditValue = $this->is_verified->Options(FALSE);

		// is_approved
		$this->is_approved->EditCustomAttributes = "";
		$this->is_approved->EditValue = $this->is_approved->Options(FALSE);

		// is_blocked
		$this->is_blocked->EditCustomAttributes = "";
		$this->is_blocked->EditValue = $this->is_blocked->Options(FALSE);

		// otp
		$this->otp->EditAttrs["class"] = "form-control";
		$this->otp->EditCustomAttributes = "";
		$this->otp->EditValue = $this->otp->CurrentValue;
		$this->otp->PlaceHolder = ew_RemoveHtml($this->otp->FldCaption());

		// slug
		$this->slug->EditAttrs["class"] = "form-control";
		$this->slug->EditCustomAttributes = "";
		$this->slug->EditValue = $this->slug->CurrentValue;
		$this->slug->PlaceHolder = ew_RemoveHtml($this->slug->FldCaption());

		// remember_token
		$this->remember_token->EditAttrs["class"] = "form-control";
		$this->remember_token->EditCustomAttributes = "";
		$this->remember_token->EditValue = $this->remember_token->CurrentValue;
		$this->remember_token->PlaceHolder = ew_RemoveHtml($this->remember_token->FldCaption());

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
					if ($this->name->Exportable) $Doc->ExportCaption($this->name);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->phone->Exportable) $Doc->ExportCaption($this->phone);
					if ($this->gender->Exportable) $Doc->ExportCaption($this->gender);
					if ($this->birthday->Exportable) $Doc->ExportCaption($this->birthday);
					if ($this->image->Exportable) $Doc->ExportCaption($this->image);
					if ($this->country_id->Exportable) $Doc->ExportCaption($this->country_id);
					if ($this->city->Exportable) $Doc->ExportCaption($this->city);
					if ($this->currency_id->Exportable) $Doc->ExportCaption($this->currency_id);
					if ($this->type->Exportable) $Doc->ExportCaption($this->type);
					if ($this->is_verified->Exportable) $Doc->ExportCaption($this->is_verified);
					if ($this->is_approved->Exportable) $Doc->ExportCaption($this->is_approved);
					if ($this->is_blocked->Exportable) $Doc->ExportCaption($this->is_blocked);
					if ($this->otp->Exportable) $Doc->ExportCaption($this->otp);
					if ($this->slug->Exportable) $Doc->ExportCaption($this->slug);
					if ($this->remember_token->Exportable) $Doc->ExportCaption($this->remember_token);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->name->Exportable) $Doc->ExportCaption($this->name);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->phone->Exportable) $Doc->ExportCaption($this->phone);
					if ($this->gender->Exportable) $Doc->ExportCaption($this->gender);
					if ($this->birthday->Exportable) $Doc->ExportCaption($this->birthday);
					if ($this->image->Exportable) $Doc->ExportCaption($this->image);
					if ($this->country_id->Exportable) $Doc->ExportCaption($this->country_id);
					if ($this->city->Exportable) $Doc->ExportCaption($this->city);
					if ($this->currency_id->Exportable) $Doc->ExportCaption($this->currency_id);
					if ($this->type->Exportable) $Doc->ExportCaption($this->type);
					if ($this->is_verified->Exportable) $Doc->ExportCaption($this->is_verified);
					if ($this->is_approved->Exportable) $Doc->ExportCaption($this->is_approved);
					if ($this->is_blocked->Exportable) $Doc->ExportCaption($this->is_blocked);
					if ($this->otp->Exportable) $Doc->ExportCaption($this->otp);
					if ($this->slug->Exportable) $Doc->ExportCaption($this->slug);
					if ($this->remember_token->Exportable) $Doc->ExportCaption($this->remember_token);
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
						if ($this->name->Exportable) $Doc->ExportField($this->name);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->phone->Exportable) $Doc->ExportField($this->phone);
						if ($this->gender->Exportable) $Doc->ExportField($this->gender);
						if ($this->birthday->Exportable) $Doc->ExportField($this->birthday);
						if ($this->image->Exportable) $Doc->ExportField($this->image);
						if ($this->country_id->Exportable) $Doc->ExportField($this->country_id);
						if ($this->city->Exportable) $Doc->ExportField($this->city);
						if ($this->currency_id->Exportable) $Doc->ExportField($this->currency_id);
						if ($this->type->Exportable) $Doc->ExportField($this->type);
						if ($this->is_verified->Exportable) $Doc->ExportField($this->is_verified);
						if ($this->is_approved->Exportable) $Doc->ExportField($this->is_approved);
						if ($this->is_blocked->Exportable) $Doc->ExportField($this->is_blocked);
						if ($this->otp->Exportable) $Doc->ExportField($this->otp);
						if ($this->slug->Exportable) $Doc->ExportField($this->slug);
						if ($this->remember_token->Exportable) $Doc->ExportField($this->remember_token);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->name->Exportable) $Doc->ExportField($this->name);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->phone->Exportable) $Doc->ExportField($this->phone);
						if ($this->gender->Exportable) $Doc->ExportField($this->gender);
						if ($this->birthday->Exportable) $Doc->ExportField($this->birthday);
						if ($this->image->Exportable) $Doc->ExportField($this->image);
						if ($this->country_id->Exportable) $Doc->ExportField($this->country_id);
						if ($this->city->Exportable) $Doc->ExportField($this->city);
						if ($this->currency_id->Exportable) $Doc->ExportField($this->currency_id);
						if ($this->type->Exportable) $Doc->ExportField($this->type);
						if ($this->is_verified->Exportable) $Doc->ExportField($this->is_verified);
						if ($this->is_approved->Exportable) $Doc->ExportField($this->is_approved);
						if ($this->is_blocked->Exportable) $Doc->ExportField($this->is_blocked);
						if ($this->otp->Exportable) $Doc->ExportField($this->otp);
						if ($this->slug->Exportable) $Doc->ExportField($this->slug);
						if ($this->remember_token->Exportable) $Doc->ExportField($this->remember_token);
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
