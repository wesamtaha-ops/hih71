<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "teachersinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$teachers_delete = NULL; // Initialize page object first

class cteachers_delete extends cteachers {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'teachers';

	// Page object name
	var $PageObjName = 'teachers_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (teachers)
		if (!isset($GLOBALS["teachers"]) || get_class($GLOBALS["teachers"]) == "cteachers") {
			$GLOBALS["teachers"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["teachers"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'teachers', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("teacherslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->user_id->SetVisibility();
		$this->timezone->SetVisibility();
		$this->teacher_language->SetVisibility();
		$this->video->SetVisibility();
		$this->heading_ar->SetVisibility();
		$this->description_ar->SetVisibility();
		$this->heading_en->SetVisibility();
		$this->description_en->SetVisibility();
		$this->allow_express->SetVisibility();
		$this->fees->SetVisibility();
		$this->currency_id->SetVisibility();
		$this->created_at->SetVisibility();
		$this->updated_at->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $teachers;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($teachers);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up master/detail parameters
		$this->SetupMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("teacherslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in teachers class, teachersinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("teacherslist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->id->setDbValue($row['id']);
		$this->user_id->setDbValue($row['user_id']);
		$this->timezone->setDbValue($row['timezone']);
		$this->teacher_language->setDbValue($row['teacher_language']);
		$this->video->setDbValue($row['video']);
		$this->heading_ar->setDbValue($row['heading_ar']);
		$this->description_ar->setDbValue($row['description_ar']);
		$this->heading_en->setDbValue($row['heading_en']);
		$this->description_en->setDbValue($row['description_en']);
		$this->allow_express->setDbValue($row['allow_express']);
		$this->fees->setDbValue($row['fees']);
		$this->currency_id->setDbValue($row['currency_id']);
		$this->created_at->setDbValue($row['created_at']);
		$this->updated_at->setDbValue($row['updated_at']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['user_id'] = NULL;
		$row['timezone'] = NULL;
		$row['teacher_language'] = NULL;
		$row['video'] = NULL;
		$row['heading_ar'] = NULL;
		$row['description_ar'] = NULL;
		$row['heading_en'] = NULL;
		$row['description_en'] = NULL;
		$row['allow_express'] = NULL;
		$row['fees'] = NULL;
		$row['currency_id'] = NULL;
		$row['created_at'] = NULL;
		$row['updated_at'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->user_id->DbValue = $row['user_id'];
		$this->timezone->DbValue = $row['timezone'];
		$this->teacher_language->DbValue = $row['teacher_language'];
		$this->video->DbValue = $row['video'];
		$this->heading_ar->DbValue = $row['heading_ar'];
		$this->description_ar->DbValue = $row['description_ar'];
		$this->heading_en->DbValue = $row['heading_en'];
		$this->description_en->DbValue = $row['description_en'];
		$this->allow_express->DbValue = $row['allow_express'];
		$this->fees->DbValue = $row['fees'];
		$this->currency_id->DbValue = $row['currency_id'];
		$this->created_at->DbValue = $row['created_at'];
		$this->updated_at->DbValue = $row['updated_at'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];

				// Delete old files
				$this->LoadDbValues($row);
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up master/detail based on QueryString
	function SetupMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "users") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["users"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->user_id->setQueryStringValue($GLOBALS["users"]->id->QueryStringValue);
					$this->user_id->setSessionValue($this->user_id->QueryStringValue);
					if (!is_numeric($GLOBALS["users"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "users") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["users"]->id->setFormValue($_POST["fk_id"]);
					$this->user_id->setFormValue($GLOBALS["users"]->id->FormValue);
					$this->user_id->setSessionValue($this->user_id->FormValue);
					if (!is_numeric($GLOBALS["users"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			if (!$this->IsAddOrEdit()) {
				$this->StartRec = 1;
				$this->setStartRecordNumber($this->StartRec);
			}

			// Clear previous master key from Session
			if ($sMasterTblVar <> "users") {
				if ($this->user_id->CurrentValue == "") $this->user_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("teacherslist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($teachers_delete)) $teachers_delete = new cteachers_delete();

// Page init
$teachers_delete->Page_Init();

// Page main
$teachers_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fteachersdelete = new ew_Form("fteachersdelete", "delete");

// Form_CustomValidate event
fteachersdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachersdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $teachers_delete->ShowPageHeader(); ?>
<?php
$teachers_delete->ShowMessage();
?>
<form name="fteachersdelete" id="fteachersdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($teachers_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $teachers_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="teachers">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($teachers_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($teachers->id->Visible) { // id ?>
		<th class="<?php echo $teachers->id->HeaderCellClass() ?>"><span id="elh_teachers_id" class="teachers_id"><?php echo $teachers->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->user_id->Visible) { // user_id ?>
		<th class="<?php echo $teachers->user_id->HeaderCellClass() ?>"><span id="elh_teachers_user_id" class="teachers_user_id"><?php echo $teachers->user_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->timezone->Visible) { // timezone ?>
		<th class="<?php echo $teachers->timezone->HeaderCellClass() ?>"><span id="elh_teachers_timezone" class="teachers_timezone"><?php echo $teachers->timezone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->teacher_language->Visible) { // teacher_language ?>
		<th class="<?php echo $teachers->teacher_language->HeaderCellClass() ?>"><span id="elh_teachers_teacher_language" class="teachers_teacher_language"><?php echo $teachers->teacher_language->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->video->Visible) { // video ?>
		<th class="<?php echo $teachers->video->HeaderCellClass() ?>"><span id="elh_teachers_video" class="teachers_video"><?php echo $teachers->video->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->heading_ar->Visible) { // heading_ar ?>
		<th class="<?php echo $teachers->heading_ar->HeaderCellClass() ?>"><span id="elh_teachers_heading_ar" class="teachers_heading_ar"><?php echo $teachers->heading_ar->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->description_ar->Visible) { // description_ar ?>
		<th class="<?php echo $teachers->description_ar->HeaderCellClass() ?>"><span id="elh_teachers_description_ar" class="teachers_description_ar"><?php echo $teachers->description_ar->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->heading_en->Visible) { // heading_en ?>
		<th class="<?php echo $teachers->heading_en->HeaderCellClass() ?>"><span id="elh_teachers_heading_en" class="teachers_heading_en"><?php echo $teachers->heading_en->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->description_en->Visible) { // description_en ?>
		<th class="<?php echo $teachers->description_en->HeaderCellClass() ?>"><span id="elh_teachers_description_en" class="teachers_description_en"><?php echo $teachers->description_en->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->allow_express->Visible) { // allow_express ?>
		<th class="<?php echo $teachers->allow_express->HeaderCellClass() ?>"><span id="elh_teachers_allow_express" class="teachers_allow_express"><?php echo $teachers->allow_express->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->fees->Visible) { // fees ?>
		<th class="<?php echo $teachers->fees->HeaderCellClass() ?>"><span id="elh_teachers_fees" class="teachers_fees"><?php echo $teachers->fees->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->currency_id->Visible) { // currency_id ?>
		<th class="<?php echo $teachers->currency_id->HeaderCellClass() ?>"><span id="elh_teachers_currency_id" class="teachers_currency_id"><?php echo $teachers->currency_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->created_at->Visible) { // created_at ?>
		<th class="<?php echo $teachers->created_at->HeaderCellClass() ?>"><span id="elh_teachers_created_at" class="teachers_created_at"><?php echo $teachers->created_at->FldCaption() ?></span></th>
<?php } ?>
<?php if ($teachers->updated_at->Visible) { // updated_at ?>
		<th class="<?php echo $teachers->updated_at->HeaderCellClass() ?>"><span id="elh_teachers_updated_at" class="teachers_updated_at"><?php echo $teachers->updated_at->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$teachers_delete->RecCnt = 0;
$i = 0;
while (!$teachers_delete->Recordset->EOF) {
	$teachers_delete->RecCnt++;
	$teachers_delete->RowCnt++;

	// Set row properties
	$teachers->ResetAttrs();
	$teachers->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$teachers_delete->LoadRowValues($teachers_delete->Recordset);

	// Render row
	$teachers_delete->RenderRow();
?>
	<tr<?php echo $teachers->RowAttributes() ?>>
<?php if ($teachers->id->Visible) { // id ?>
		<td<?php echo $teachers->id->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_id" class="teachers_id">
<span<?php echo $teachers->id->ViewAttributes() ?>>
<?php echo $teachers->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->user_id->Visible) { // user_id ?>
		<td<?php echo $teachers->user_id->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_user_id" class="teachers_user_id">
<span<?php echo $teachers->user_id->ViewAttributes() ?>>
<?php echo $teachers->user_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->timezone->Visible) { // timezone ?>
		<td<?php echo $teachers->timezone->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_timezone" class="teachers_timezone">
<span<?php echo $teachers->timezone->ViewAttributes() ?>>
<?php echo $teachers->timezone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->teacher_language->Visible) { // teacher_language ?>
		<td<?php echo $teachers->teacher_language->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_teacher_language" class="teachers_teacher_language">
<span<?php echo $teachers->teacher_language->ViewAttributes() ?>>
<?php echo $teachers->teacher_language->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->video->Visible) { // video ?>
		<td<?php echo $teachers->video->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_video" class="teachers_video">
<span<?php echo $teachers->video->ViewAttributes() ?>>
<?php echo $teachers->video->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->heading_ar->Visible) { // heading_ar ?>
		<td<?php echo $teachers->heading_ar->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_heading_ar" class="teachers_heading_ar">
<span<?php echo $teachers->heading_ar->ViewAttributes() ?>>
<?php echo $teachers->heading_ar->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->description_ar->Visible) { // description_ar ?>
		<td<?php echo $teachers->description_ar->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_description_ar" class="teachers_description_ar">
<span<?php echo $teachers->description_ar->ViewAttributes() ?>>
<?php echo $teachers->description_ar->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->heading_en->Visible) { // heading_en ?>
		<td<?php echo $teachers->heading_en->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_heading_en" class="teachers_heading_en">
<span<?php echo $teachers->heading_en->ViewAttributes() ?>>
<?php echo $teachers->heading_en->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->description_en->Visible) { // description_en ?>
		<td<?php echo $teachers->description_en->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_description_en" class="teachers_description_en">
<span<?php echo $teachers->description_en->ViewAttributes() ?>>
<?php echo $teachers->description_en->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->allow_express->Visible) { // allow_express ?>
		<td<?php echo $teachers->allow_express->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_allow_express" class="teachers_allow_express">
<span<?php echo $teachers->allow_express->ViewAttributes() ?>>
<?php echo $teachers->allow_express->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->fees->Visible) { // fees ?>
		<td<?php echo $teachers->fees->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_fees" class="teachers_fees">
<span<?php echo $teachers->fees->ViewAttributes() ?>>
<?php echo $teachers->fees->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->currency_id->Visible) { // currency_id ?>
		<td<?php echo $teachers->currency_id->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_currency_id" class="teachers_currency_id">
<span<?php echo $teachers->currency_id->ViewAttributes() ?>>
<?php echo $teachers->currency_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->created_at->Visible) { // created_at ?>
		<td<?php echo $teachers->created_at->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_created_at" class="teachers_created_at">
<span<?php echo $teachers->created_at->ViewAttributes() ?>>
<?php echo $teachers->created_at->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($teachers->updated_at->Visible) { // updated_at ?>
		<td<?php echo $teachers->updated_at->CellAttributes() ?>>
<span id="el<?php echo $teachers_delete->RowCnt ?>_teachers_updated_at" class="teachers_updated_at">
<span<?php echo $teachers->updated_at->ViewAttributes() ?>>
<?php echo $teachers->updated_at->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$teachers_delete->Recordset->MoveNext();
}
$teachers_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $teachers_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fteachersdelete.Init();
</script>
<?php
$teachers_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$teachers_delete->Page_Terminate();
?>
