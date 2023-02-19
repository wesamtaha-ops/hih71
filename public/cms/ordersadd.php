<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ordersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$orders_add = NULL; // Initialize page object first

class corders_add extends corders {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'orders';

	// Page object name
	var $PageObjName = 'orders_add';

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

		// Table object (orders)
		if (!isset($GLOBALS["orders"]) || get_class($GLOBALS["orders"]) == "corders") {
			$GLOBALS["orders"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["orders"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'orders', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("orderslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->student_id->SetVisibility();
		$this->teacher_id->SetVisibility();
		$this->topic_id->SetVisibility();
		$this->date->SetVisibility();
		$this->time->SetVisibility();
		$this->fees->SetVisibility();
		$this->currency_id->SetVisibility();
		$this->status->SetVisibility();
		$this->meeting_id->SetVisibility();
		$this->package_id->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $orders;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($orders);
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "ordersview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("orderslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "orderslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "ordersview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->student_id->CurrentValue = NULL;
		$this->student_id->OldValue = $this->student_id->CurrentValue;
		$this->teacher_id->CurrentValue = NULL;
		$this->teacher_id->OldValue = $this->teacher_id->CurrentValue;
		$this->topic_id->CurrentValue = NULL;
		$this->topic_id->OldValue = $this->topic_id->CurrentValue;
		$this->date->CurrentValue = NULL;
		$this->date->OldValue = $this->date->CurrentValue;
		$this->time->CurrentValue = NULL;
		$this->time->OldValue = $this->time->CurrentValue;
		$this->fees->CurrentValue = NULL;
		$this->fees->OldValue = $this->fees->CurrentValue;
		$this->currency_id->CurrentValue = NULL;
		$this->currency_id->OldValue = $this->currency_id->CurrentValue;
		$this->status->CurrentValue = "pending";
		$this->meeting_id->CurrentValue = NULL;
		$this->meeting_id->OldValue = $this->meeting_id->CurrentValue;
		$this->created_at->CurrentValue = NULL;
		$this->created_at->OldValue = $this->created_at->CurrentValue;
		$this->updated_at->CurrentValue = NULL;
		$this->updated_at->OldValue = $this->updated_at->CurrentValue;
		$this->package_id->CurrentValue = NULL;
		$this->package_id->OldValue = $this->package_id->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->student_id->FldIsDetailKey) {
			$this->student_id->setFormValue($objForm->GetValue("x_student_id"));
		}
		if (!$this->teacher_id->FldIsDetailKey) {
			$this->teacher_id->setFormValue($objForm->GetValue("x_teacher_id"));
		}
		if (!$this->topic_id->FldIsDetailKey) {
			$this->topic_id->setFormValue($objForm->GetValue("x_topic_id"));
		}
		if (!$this->date->FldIsDetailKey) {
			$this->date->setFormValue($objForm->GetValue("x_date"));
			$this->date->CurrentValue = ew_UnFormatDateTime($this->date->CurrentValue, 0);
		}
		if (!$this->time->FldIsDetailKey) {
			$this->time->setFormValue($objForm->GetValue("x_time"));
		}
		if (!$this->fees->FldIsDetailKey) {
			$this->fees->setFormValue($objForm->GetValue("x_fees"));
		}
		if (!$this->currency_id->FldIsDetailKey) {
			$this->currency_id->setFormValue($objForm->GetValue("x_currency_id"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->meeting_id->FldIsDetailKey) {
			$this->meeting_id->setFormValue($objForm->GetValue("x_meeting_id"));
		}
		if (!$this->package_id->FldIsDetailKey) {
			$this->package_id->setFormValue($objForm->GetValue("x_package_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->student_id->CurrentValue = $this->student_id->FormValue;
		$this->teacher_id->CurrentValue = $this->teacher_id->FormValue;
		$this->topic_id->CurrentValue = $this->topic_id->FormValue;
		$this->date->CurrentValue = $this->date->FormValue;
		$this->date->CurrentValue = ew_UnFormatDateTime($this->date->CurrentValue, 0);
		$this->time->CurrentValue = $this->time->FormValue;
		$this->fees->CurrentValue = $this->fees->FormValue;
		$this->currency_id->CurrentValue = $this->currency_id->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->meeting_id->CurrentValue = $this->meeting_id->FormValue;
		$this->package_id->CurrentValue = $this->package_id->FormValue;
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
		$this->student_id->setDbValue($row['student_id']);
		$this->teacher_id->setDbValue($row['teacher_id']);
		$this->topic_id->setDbValue($row['topic_id']);
		$this->date->setDbValue($row['date']);
		$this->time->setDbValue($row['time']);
		$this->fees->setDbValue($row['fees']);
		$this->currency_id->setDbValue($row['currency_id']);
		$this->status->setDbValue($row['status']);
		$this->meeting_id->setDbValue($row['meeting_id']);
		$this->created_at->setDbValue($row['created_at']);
		$this->updated_at->setDbValue($row['updated_at']);
		$this->package_id->setDbValue($row['package_id']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['student_id'] = $this->student_id->CurrentValue;
		$row['teacher_id'] = $this->teacher_id->CurrentValue;
		$row['topic_id'] = $this->topic_id->CurrentValue;
		$row['date'] = $this->date->CurrentValue;
		$row['time'] = $this->time->CurrentValue;
		$row['fees'] = $this->fees->CurrentValue;
		$row['currency_id'] = $this->currency_id->CurrentValue;
		$row['status'] = $this->status->CurrentValue;
		$row['meeting_id'] = $this->meeting_id->CurrentValue;
		$row['created_at'] = $this->created_at->CurrentValue;
		$row['updated_at'] = $this->updated_at->CurrentValue;
		$row['package_id'] = $this->package_id->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->student_id->DbValue = $row['student_id'];
		$this->teacher_id->DbValue = $row['teacher_id'];
		$this->topic_id->DbValue = $row['topic_id'];
		$this->date->DbValue = $row['date'];
		$this->time->DbValue = $row['time'];
		$this->fees->DbValue = $row['fees'];
		$this->currency_id->DbValue = $row['currency_id'];
		$this->status->DbValue = $row['status'];
		$this->meeting_id->DbValue = $row['meeting_id'];
		$this->created_at->DbValue = $row['created_at'];
		$this->updated_at->DbValue = $row['updated_at'];
		$this->package_id->DbValue = $row['package_id'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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
		// updated_at
		// package_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

		// package_id
		$this->package_id->ViewValue = $this->package_id->CurrentValue;
		$this->package_id->ViewCustomAttributes = "";

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

			// package_id
			$this->package_id->LinkCustomAttributes = "";
			$this->package_id->HrefValue = "";
			$this->package_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// student_id
			$this->student_id->EditAttrs["class"] = "form-control";
			$this->student_id->EditCustomAttributes = "";
			if (trim(strval($this->student_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->student_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `users`";
			$sWhereWrk = "";
			$this->student_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->student_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->student_id->EditValue = $arwrk;

			// teacher_id
			$this->teacher_id->EditAttrs["class"] = "form-control";
			$this->teacher_id->EditCustomAttributes = "";
			if (trim(strval($this->teacher_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->teacher_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `users`";
			$sWhereWrk = "";
			$this->teacher_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->teacher_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->teacher_id->EditValue = $arwrk;

			// topic_id
			$this->topic_id->EditAttrs["class"] = "form-control";
			$this->topic_id->EditCustomAttributes = "";
			if (trim(strval($this->topic_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->topic_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `name_ar` AS `DispFld`, `name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `topics`";
			$sWhereWrk = "";
			$this->topic_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->topic_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->topic_id->EditValue = $arwrk;

			// date
			$this->date->EditAttrs["class"] = "form-control";
			$this->date->EditCustomAttributes = "";
			$this->date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date->CurrentValue, 8));
			$this->date->PlaceHolder = ew_RemoveHtml($this->date->FldCaption());

			// time
			$this->time->EditAttrs["class"] = "form-control";
			$this->time->EditCustomAttributes = "";
			$this->time->EditValue = ew_HtmlEncode($this->time->CurrentValue);
			$this->time->PlaceHolder = ew_RemoveHtml($this->time->FldCaption());

			// fees
			$this->fees->EditAttrs["class"] = "form-control";
			$this->fees->EditCustomAttributes = "";
			$this->fees->EditValue = ew_HtmlEncode($this->fees->CurrentValue);
			$this->fees->PlaceHolder = ew_RemoveHtml($this->fees->FldCaption());

			// currency_id
			$this->currency_id->EditAttrs["class"] = "form-control";
			$this->currency_id->EditCustomAttributes = "";
			if (trim(strval($this->currency_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->currency_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `name_ar` AS `DispFld`, `name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `currencies`";
			$sWhereWrk = "";
			$this->currency_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->currency_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->currency_id->EditValue = $arwrk;

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(TRUE);

			// meeting_id
			$this->meeting_id->EditAttrs["class"] = "form-control";
			$this->meeting_id->EditCustomAttributes = "";
			$this->meeting_id->EditValue = ew_HtmlEncode($this->meeting_id->CurrentValue);
			$this->meeting_id->PlaceHolder = ew_RemoveHtml($this->meeting_id->FldCaption());

			// package_id
			$this->package_id->EditAttrs["class"] = "form-control";
			$this->package_id->EditCustomAttributes = "";
			$this->package_id->EditValue = ew_HtmlEncode($this->package_id->CurrentValue);
			$this->package_id->PlaceHolder = ew_RemoveHtml($this->package_id->FldCaption());

			// Add refer script
			// student_id

			$this->student_id->LinkCustomAttributes = "";
			$this->student_id->HrefValue = "";

			// teacher_id
			$this->teacher_id->LinkCustomAttributes = "";
			$this->teacher_id->HrefValue = "";

			// topic_id
			$this->topic_id->LinkCustomAttributes = "";
			$this->topic_id->HrefValue = "";

			// date
			$this->date->LinkCustomAttributes = "";
			$this->date->HrefValue = "";

			// time
			$this->time->LinkCustomAttributes = "";
			$this->time->HrefValue = "";

			// fees
			$this->fees->LinkCustomAttributes = "";
			$this->fees->HrefValue = "";

			// currency_id
			$this->currency_id->LinkCustomAttributes = "";
			$this->currency_id->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";

			// meeting_id
			$this->meeting_id->LinkCustomAttributes = "";
			$this->meeting_id->HrefValue = "";

			// package_id
			$this->package_id->LinkCustomAttributes = "";
			$this->package_id->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->student_id->FldIsDetailKey && !is_null($this->student_id->FormValue) && $this->student_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->student_id->FldCaption(), $this->student_id->ReqErrMsg));
		}
		if (!$this->teacher_id->FldIsDetailKey && !is_null($this->teacher_id->FormValue) && $this->teacher_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->teacher_id->FldCaption(), $this->teacher_id->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->date->FormValue)) {
			ew_AddMessage($gsFormError, $this->date->FldErrMsg());
		}
		if (!$this->fees->FldIsDetailKey && !is_null($this->fees->FormValue) && $this->fees->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->fees->FldCaption(), $this->fees->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->fees->FormValue)) {
			ew_AddMessage($gsFormError, $this->fees->FldErrMsg());
		}
		if (!$this->currency_id->FldIsDetailKey && !is_null($this->currency_id->FormValue) && $this->currency_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->currency_id->FldCaption(), $this->currency_id->ReqErrMsg));
		}
		if (!$this->status->FldIsDetailKey && !is_null($this->status->FormValue) && $this->status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status->FldCaption(), $this->status->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->package_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->package_id->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// student_id
		$this->student_id->SetDbValueDef($rsnew, $this->student_id->CurrentValue, 0, FALSE);

		// teacher_id
		$this->teacher_id->SetDbValueDef($rsnew, $this->teacher_id->CurrentValue, 0, FALSE);

		// topic_id
		$this->topic_id->SetDbValueDef($rsnew, $this->topic_id->CurrentValue, NULL, FALSE);

		// date
		$this->date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date->CurrentValue, 0), NULL, FALSE);

		// time
		$this->time->SetDbValueDef($rsnew, $this->time->CurrentValue, NULL, FALSE);

		// fees
		$this->fees->SetDbValueDef($rsnew, $this->fees->CurrentValue, 0, FALSE);

		// currency_id
		$this->currency_id->SetDbValueDef($rsnew, $this->currency_id->CurrentValue, 0, FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", strval($this->status->CurrentValue) == "");

		// meeting_id
		$this->meeting_id->SetDbValueDef($rsnew, $this->meeting_id->CurrentValue, NULL, FALSE);

		// package_id
		$this->package_id->SetDbValueDef($rsnew, $this->package_id->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("orderslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_student_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `users`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->student_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_teacher_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `users`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->teacher_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_topic_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `name_ar` AS `DispFld`, `name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `topics`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->topic_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_currency_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `name_ar` AS `DispFld`, `name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `currencies`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->currency_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($orders_add)) $orders_add = new corders_add();

// Page init
$orders_add->Page_Init();

// Page main
$orders_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$orders_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fordersadd = new ew_Form("fordersadd", "add");

// Validate form
fordersadd.Validate = function() {
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
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fordersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fordersadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fordersadd.Lists["x_student_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"users"};
fordersadd.Lists["x_student_id"].Data = "<?php echo $orders_add->student_id->LookupFilterQuery(FALSE, "add") ?>";
fordersadd.Lists["x_teacher_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"users"};
fordersadd.Lists["x_teacher_id"].Data = "<?php echo $orders_add->teacher_id->LookupFilterQuery(FALSE, "add") ?>";
fordersadd.Lists["x_topic_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name_ar","x_name_en","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"topics"};
fordersadd.Lists["x_topic_id"].Data = "<?php echo $orders_add->topic_id->LookupFilterQuery(FALSE, "add") ?>";
fordersadd.Lists["x_currency_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name_ar","x_name_en","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"currencies"};
fordersadd.Lists["x_currency_id"].Data = "<?php echo $orders_add->currency_id->LookupFilterQuery(FALSE, "add") ?>";
fordersadd.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fordersadd.Lists["x_status"].Options = <?php echo json_encode($orders_add->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $orders_add->ShowPageHeader(); ?>
<?php
$orders_add->ShowMessage();
?>
<form name="fordersadd" id="fordersadd" class="<?php echo $orders_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($orders_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $orders_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="orders">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($orders_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($orders->student_id->Visible) { // student_id ?>
	<div id="r_student_id" class="form-group">
		<label id="elh_orders_student_id" for="x_student_id" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->student_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->student_id->CellAttributes() ?>>
<span id="el_orders_student_id">
<select data-table="orders" data-field="x_student_id" data-value-separator="<?php echo $orders->student_id->DisplayValueSeparatorAttribute() ?>" id="x_student_id" name="x_student_id"<?php echo $orders->student_id->EditAttributes() ?>>
<?php echo $orders->student_id->SelectOptionListHtml("x_student_id") ?>
</select>
</span>
<?php echo $orders->student_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->teacher_id->Visible) { // teacher_id ?>
	<div id="r_teacher_id" class="form-group">
		<label id="elh_orders_teacher_id" for="x_teacher_id" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->teacher_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->teacher_id->CellAttributes() ?>>
<span id="el_orders_teacher_id">
<select data-table="orders" data-field="x_teacher_id" data-value-separator="<?php echo $orders->teacher_id->DisplayValueSeparatorAttribute() ?>" id="x_teacher_id" name="x_teacher_id"<?php echo $orders->teacher_id->EditAttributes() ?>>
<?php echo $orders->teacher_id->SelectOptionListHtml("x_teacher_id") ?>
</select>
</span>
<?php echo $orders->teacher_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->topic_id->Visible) { // topic_id ?>
	<div id="r_topic_id" class="form-group">
		<label id="elh_orders_topic_id" for="x_topic_id" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->topic_id->FldCaption() ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->topic_id->CellAttributes() ?>>
<span id="el_orders_topic_id">
<select data-table="orders" data-field="x_topic_id" data-value-separator="<?php echo $orders->topic_id->DisplayValueSeparatorAttribute() ?>" id="x_topic_id" name="x_topic_id"<?php echo $orders->topic_id->EditAttributes() ?>>
<?php echo $orders->topic_id->SelectOptionListHtml("x_topic_id") ?>
</select>
</span>
<?php echo $orders->topic_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->date->Visible) { // date ?>
	<div id="r_date" class="form-group">
		<label id="elh_orders_date" for="x_date" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->date->FldCaption() ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->date->CellAttributes() ?>>
<span id="el_orders_date">
<input type="text" data-table="orders" data-field="x_date" name="x_date" id="x_date" placeholder="<?php echo ew_HtmlEncode($orders->date->getPlaceHolder()) ?>" value="<?php echo $orders->date->EditValue ?>"<?php echo $orders->date->EditAttributes() ?>>
</span>
<?php echo $orders->date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->time->Visible) { // time ?>
	<div id="r_time" class="form-group">
		<label id="elh_orders_time" for="x_time" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->time->FldCaption() ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->time->CellAttributes() ?>>
<span id="el_orders_time">
<input type="text" data-table="orders" data-field="x_time" name="x_time" id="x_time" placeholder="<?php echo ew_HtmlEncode($orders->time->getPlaceHolder()) ?>" value="<?php echo $orders->time->EditValue ?>"<?php echo $orders->time->EditAttributes() ?>>
</span>
<?php echo $orders->time->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->fees->Visible) { // fees ?>
	<div id="r_fees" class="form-group">
		<label id="elh_orders_fees" for="x_fees" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->fees->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->fees->CellAttributes() ?>>
<span id="el_orders_fees">
<input type="text" data-table="orders" data-field="x_fees" name="x_fees" id="x_fees" size="30" placeholder="<?php echo ew_HtmlEncode($orders->fees->getPlaceHolder()) ?>" value="<?php echo $orders->fees->EditValue ?>"<?php echo $orders->fees->EditAttributes() ?>>
</span>
<?php echo $orders->fees->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->currency_id->Visible) { // currency_id ?>
	<div id="r_currency_id" class="form-group">
		<label id="elh_orders_currency_id" for="x_currency_id" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->currency_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->currency_id->CellAttributes() ?>>
<span id="el_orders_currency_id">
<select data-table="orders" data-field="x_currency_id" data-value-separator="<?php echo $orders->currency_id->DisplayValueSeparatorAttribute() ?>" id="x_currency_id" name="x_currency_id"<?php echo $orders->currency_id->EditAttributes() ?>>
<?php echo $orders->currency_id->SelectOptionListHtml("x_currency_id") ?>
</select>
</span>
<?php echo $orders->currency_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_orders_status" for="x_status" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->status->CellAttributes() ?>>
<span id="el_orders_status">
<select data-table="orders" data-field="x_status" data-value-separator="<?php echo $orders->status->DisplayValueSeparatorAttribute() ?>" id="x_status" name="x_status"<?php echo $orders->status->EditAttributes() ?>>
<?php echo $orders->status->SelectOptionListHtml("x_status") ?>
</select>
</span>
<?php echo $orders->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->meeting_id->Visible) { // meeting_id ?>
	<div id="r_meeting_id" class="form-group">
		<label id="elh_orders_meeting_id" for="x_meeting_id" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->meeting_id->FldCaption() ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->meeting_id->CellAttributes() ?>>
<span id="el_orders_meeting_id">
<input type="text" data-table="orders" data-field="x_meeting_id" name="x_meeting_id" id="x_meeting_id" placeholder="<?php echo ew_HtmlEncode($orders->meeting_id->getPlaceHolder()) ?>" value="<?php echo $orders->meeting_id->EditValue ?>"<?php echo $orders->meeting_id->EditAttributes() ?>>
</span>
<?php echo $orders->meeting_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->package_id->Visible) { // package_id ?>
	<div id="r_package_id" class="form-group">
		<label id="elh_orders_package_id" for="x_package_id" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->package_id->FldCaption() ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->package_id->CellAttributes() ?>>
<span id="el_orders_package_id">
<input type="text" data-table="orders" data-field="x_package_id" name="x_package_id" id="x_package_id" size="30" placeholder="<?php echo ew_HtmlEncode($orders->package_id->getPlaceHolder()) ?>" value="<?php echo $orders->package_id->EditValue ?>"<?php echo $orders->package_id->EditAttributes() ?>>
</span>
<?php echo $orders->package_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$orders_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $orders_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $orders_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fordersadd.Init();
</script>
<?php
$orders_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$orders_add->Page_Terminate();
?>
