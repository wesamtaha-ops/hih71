<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "teachers_trainsinfo.php" ?>
<?php include_once "teachersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$teachers_trains_add = NULL; // Initialize page object first

class cteachers_trains_add extends cteachers_trains {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'teachers_trains';

	// Page object name
	var $PageObjName = 'teachers_trains_add';

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

		// Table object (teachers_trains)
		if (!isset($GLOBALS["teachers_trains"]) || get_class($GLOBALS["teachers_trains"]) == "cteachers_trains") {
			$GLOBALS["teachers_trains"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["teachers_trains"];
		}

		// Table object (teachers)
		if (!isset($GLOBALS['teachers'])) $GLOBALS['teachers'] = new cteachers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'teachers_trains', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("teachers_trainslist.php"));
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
		$this->teacher_id->SetVisibility();
		$this->instituation->SetVisibility();
		$this->subject->SetVisibility();
		$this->from_date->SetVisibility();
		$this->to_date->SetVisibility();

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
		global $EW_EXPORT, $teachers_trains;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($teachers_trains);
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
					if ($pageName == "teachers_trainsview.php")
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

		// Set up master/detail parameters
		$this->SetupMasterParms();

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
					$this->Page_Terminate("teachers_trainslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "teachers_trainslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "teachers_trainsview.php")
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
		$this->teacher_id->CurrentValue = NULL;
		$this->teacher_id->OldValue = $this->teacher_id->CurrentValue;
		$this->instituation->CurrentValue = NULL;
		$this->instituation->OldValue = $this->instituation->CurrentValue;
		$this->subject->CurrentValue = NULL;
		$this->subject->OldValue = $this->subject->CurrentValue;
		$this->from_date->CurrentValue = NULL;
		$this->from_date->OldValue = $this->from_date->CurrentValue;
		$this->to_date->CurrentValue = NULL;
		$this->to_date->OldValue = $this->to_date->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->teacher_id->FldIsDetailKey) {
			$this->teacher_id->setFormValue($objForm->GetValue("x_teacher_id"));
		}
		if (!$this->instituation->FldIsDetailKey) {
			$this->instituation->setFormValue($objForm->GetValue("x_instituation"));
		}
		if (!$this->subject->FldIsDetailKey) {
			$this->subject->setFormValue($objForm->GetValue("x_subject"));
		}
		if (!$this->from_date->FldIsDetailKey) {
			$this->from_date->setFormValue($objForm->GetValue("x_from_date"));
			$this->from_date->CurrentValue = ew_UnFormatDateTime($this->from_date->CurrentValue, 0);
		}
		if (!$this->to_date->FldIsDetailKey) {
			$this->to_date->setFormValue($objForm->GetValue("x_to_date"));
			$this->to_date->CurrentValue = ew_UnFormatDateTime($this->to_date->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->teacher_id->CurrentValue = $this->teacher_id->FormValue;
		$this->instituation->CurrentValue = $this->instituation->FormValue;
		$this->subject->CurrentValue = $this->subject->FormValue;
		$this->from_date->CurrentValue = $this->from_date->FormValue;
		$this->from_date->CurrentValue = ew_UnFormatDateTime($this->from_date->CurrentValue, 0);
		$this->to_date->CurrentValue = $this->to_date->FormValue;
		$this->to_date->CurrentValue = ew_UnFormatDateTime($this->to_date->CurrentValue, 0);
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
		$this->teacher_id->setDbValue($row['teacher_id']);
		$this->instituation->setDbValue($row['instituation']);
		$this->subject->setDbValue($row['subject']);
		$this->from_date->setDbValue($row['from_date']);
		$this->to_date->setDbValue($row['to_date']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['teacher_id'] = $this->teacher_id->CurrentValue;
		$row['instituation'] = $this->instituation->CurrentValue;
		$row['subject'] = $this->subject->CurrentValue;
		$row['from_date'] = $this->from_date->CurrentValue;
		$row['to_date'] = $this->to_date->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->teacher_id->DbValue = $row['teacher_id'];
		$this->instituation->DbValue = $row['instituation'];
		$this->subject->DbValue = $row['subject'];
		$this->from_date->DbValue = $row['from_date'];
		$this->to_date->DbValue = $row['to_date'];
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
		// teacher_id
		// instituation
		// subject
		// from_date
		// to_date

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// teacher_id
		$this->teacher_id->ViewValue = $this->teacher_id->CurrentValue;
		$this->teacher_id->ViewCustomAttributes = "";

		// instituation
		$this->instituation->ViewValue = $this->instituation->CurrentValue;
		$this->instituation->ViewCustomAttributes = "";

		// subject
		$this->subject->ViewValue = $this->subject->CurrentValue;
		$this->subject->ViewCustomAttributes = "";

		// from_date
		$this->from_date->ViewValue = $this->from_date->CurrentValue;
		$this->from_date->ViewValue = ew_FormatDateTime($this->from_date->ViewValue, 0);
		$this->from_date->ViewCustomAttributes = "";

		// to_date
		$this->to_date->ViewValue = $this->to_date->CurrentValue;
		$this->to_date->ViewValue = ew_FormatDateTime($this->to_date->ViewValue, 0);
		$this->to_date->ViewCustomAttributes = "";

			// teacher_id
			$this->teacher_id->LinkCustomAttributes = "";
			$this->teacher_id->HrefValue = "";
			$this->teacher_id->TooltipValue = "";

			// instituation
			$this->instituation->LinkCustomAttributes = "";
			$this->instituation->HrefValue = "";
			$this->instituation->TooltipValue = "";

			// subject
			$this->subject->LinkCustomAttributes = "";
			$this->subject->HrefValue = "";
			$this->subject->TooltipValue = "";

			// from_date
			$this->from_date->LinkCustomAttributes = "";
			$this->from_date->HrefValue = "";
			$this->from_date->TooltipValue = "";

			// to_date
			$this->to_date->LinkCustomAttributes = "";
			$this->to_date->HrefValue = "";
			$this->to_date->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// teacher_id
			$this->teacher_id->EditAttrs["class"] = "form-control";
			$this->teacher_id->EditCustomAttributes = "";
			if ($this->teacher_id->getSessionValue() <> "") {
				$this->teacher_id->CurrentValue = $this->teacher_id->getSessionValue();
			$this->teacher_id->ViewValue = $this->teacher_id->CurrentValue;
			$this->teacher_id->ViewCustomAttributes = "";
			} else {
			$this->teacher_id->EditValue = ew_HtmlEncode($this->teacher_id->CurrentValue);
			$this->teacher_id->PlaceHolder = ew_RemoveHtml($this->teacher_id->FldCaption());
			}

			// instituation
			$this->instituation->EditAttrs["class"] = "form-control";
			$this->instituation->EditCustomAttributes = "";
			$this->instituation->EditValue = ew_HtmlEncode($this->instituation->CurrentValue);
			$this->instituation->PlaceHolder = ew_RemoveHtml($this->instituation->FldCaption());

			// subject
			$this->subject->EditAttrs["class"] = "form-control";
			$this->subject->EditCustomAttributes = "";
			$this->subject->EditValue = ew_HtmlEncode($this->subject->CurrentValue);
			$this->subject->PlaceHolder = ew_RemoveHtml($this->subject->FldCaption());

			// from_date
			$this->from_date->EditAttrs["class"] = "form-control";
			$this->from_date->EditCustomAttributes = "";
			$this->from_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->from_date->CurrentValue, 8));
			$this->from_date->PlaceHolder = ew_RemoveHtml($this->from_date->FldCaption());

			// to_date
			$this->to_date->EditAttrs["class"] = "form-control";
			$this->to_date->EditCustomAttributes = "";
			$this->to_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->to_date->CurrentValue, 8));
			$this->to_date->PlaceHolder = ew_RemoveHtml($this->to_date->FldCaption());

			// Add refer script
			// teacher_id

			$this->teacher_id->LinkCustomAttributes = "";
			$this->teacher_id->HrefValue = "";

			// instituation
			$this->instituation->LinkCustomAttributes = "";
			$this->instituation->HrefValue = "";

			// subject
			$this->subject->LinkCustomAttributes = "";
			$this->subject->HrefValue = "";

			// from_date
			$this->from_date->LinkCustomAttributes = "";
			$this->from_date->HrefValue = "";

			// to_date
			$this->to_date->LinkCustomAttributes = "";
			$this->to_date->HrefValue = "";
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
		if (!$this->teacher_id->FldIsDetailKey && !is_null($this->teacher_id->FormValue) && $this->teacher_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->teacher_id->FldCaption(), $this->teacher_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->teacher_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->teacher_id->FldErrMsg());
		}
		if (!$this->instituation->FldIsDetailKey && !is_null($this->instituation->FormValue) && $this->instituation->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->instituation->FldCaption(), $this->instituation->ReqErrMsg));
		}
		if (!$this->subject->FldIsDetailKey && !is_null($this->subject->FormValue) && $this->subject->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->subject->FldCaption(), $this->subject->ReqErrMsg));
		}
		if (!$this->from_date->FldIsDetailKey && !is_null($this->from_date->FormValue) && $this->from_date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->from_date->FldCaption(), $this->from_date->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->from_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->from_date->FldErrMsg());
		}
		if (!$this->to_date->FldIsDetailKey && !is_null($this->to_date->FormValue) && $this->to_date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->to_date->FldCaption(), $this->to_date->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->to_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->to_date->FldErrMsg());
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

		// teacher_id
		$this->teacher_id->SetDbValueDef($rsnew, $this->teacher_id->CurrentValue, 0, FALSE);

		// instituation
		$this->instituation->SetDbValueDef($rsnew, $this->instituation->CurrentValue, "", FALSE);

		// subject
		$this->subject->SetDbValueDef($rsnew, $this->subject->CurrentValue, "", FALSE);

		// from_date
		$this->from_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->from_date->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// to_date
		$this->to_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->to_date->CurrentValue, 0), ew_CurrentDate(), FALSE);

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
			if ($sMasterTblVar == "teachers") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["teachers"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->teacher_id->setQueryStringValue($GLOBALS["teachers"]->id->QueryStringValue);
					$this->teacher_id->setSessionValue($this->teacher_id->QueryStringValue);
					if (!is_numeric($GLOBALS["teachers"]->id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "teachers") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["teachers"]->id->setFormValue($_POST["fk_id"]);
					$this->teacher_id->setFormValue($GLOBALS["teachers"]->id->FormValue);
					$this->teacher_id->setSessionValue($this->teacher_id->FormValue);
					if (!is_numeric($GLOBALS["teachers"]->id->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "teachers") {
				if ($this->teacher_id->CurrentValue == "") $this->teacher_id->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("teachers_trainslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($teachers_trains_add)) $teachers_trains_add = new cteachers_trains_add();

// Page init
$teachers_trains_add->Page_Init();

// Page main
$teachers_trains_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_trains_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fteachers_trainsadd = new ew_Form("fteachers_trainsadd", "add");

// Validate form
fteachers_trainsadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_trains->teacher_id->FldCaption(), $teachers_trains->teacher_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_trains->teacher_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_instituation");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_trains->instituation->FldCaption(), $teachers_trains->instituation->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_subject");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_trains->subject->FldCaption(), $teachers_trains->subject->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_from_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_trains->from_date->FldCaption(), $teachers_trains->from_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_from_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_trains->from_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_to_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_trains->to_date->FldCaption(), $teachers_trains->to_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_to_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_trains->to_date->FldErrMsg()) ?>");

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
fteachers_trainsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachers_trainsadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $teachers_trains_add->ShowPageHeader(); ?>
<?php
$teachers_trains_add->ShowMessage();
?>
<form name="fteachers_trainsadd" id="fteachers_trainsadd" class="<?php echo $teachers_trains_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($teachers_trains_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $teachers_trains_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="teachers_trains">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($teachers_trains_add->IsModal) ?>">
<?php if ($teachers_trains->getCurrentMasterTable() == "teachers") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="teachers">
<input type="hidden" name="fk_id" value="<?php echo $teachers_trains->teacher_id->getSessionValue() ?>">
<?php } ?>
<div class="ewAddDiv"><!-- page* -->
<?php if ($teachers_trains->teacher_id->Visible) { // teacher_id ?>
	<div id="r_teacher_id" class="form-group">
		<label id="elh_teachers_trains_teacher_id" for="x_teacher_id" class="<?php echo $teachers_trains_add->LeftColumnClass ?>"><?php echo $teachers_trains->teacher_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $teachers_trains_add->RightColumnClass ?>"><div<?php echo $teachers_trains->teacher_id->CellAttributes() ?>>
<?php if ($teachers_trains->teacher_id->getSessionValue() <> "") { ?>
<span id="el_teachers_trains_teacher_id">
<span<?php echo $teachers_trains->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_trains->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_teacher_id" name="x_teacher_id" value="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_teachers_trains_teacher_id">
<input type="text" data-table="teachers_trains" data-field="x_teacher_id" name="x_teacher_id" id="x_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_trains->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_trains->teacher_id->EditValue ?>"<?php echo $teachers_trains->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $teachers_trains->teacher_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers_trains->instituation->Visible) { // instituation ?>
	<div id="r_instituation" class="form-group">
		<label id="elh_teachers_trains_instituation" for="x_instituation" class="<?php echo $teachers_trains_add->LeftColumnClass ?>"><?php echo $teachers_trains->instituation->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $teachers_trains_add->RightColumnClass ?>"><div<?php echo $teachers_trains->instituation->CellAttributes() ?>>
<span id="el_teachers_trains_instituation">
<textarea data-table="teachers_trains" data-field="x_instituation" name="x_instituation" id="x_instituation" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_trains->instituation->getPlaceHolder()) ?>"<?php echo $teachers_trains->instituation->EditAttributes() ?>><?php echo $teachers_trains->instituation->EditValue ?></textarea>
</span>
<?php echo $teachers_trains->instituation->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers_trains->subject->Visible) { // subject ?>
	<div id="r_subject" class="form-group">
		<label id="elh_teachers_trains_subject" for="x_subject" class="<?php echo $teachers_trains_add->LeftColumnClass ?>"><?php echo $teachers_trains->subject->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $teachers_trains_add->RightColumnClass ?>"><div<?php echo $teachers_trains->subject->CellAttributes() ?>>
<span id="el_teachers_trains_subject">
<textarea data-table="teachers_trains" data-field="x_subject" name="x_subject" id="x_subject" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_trains->subject->getPlaceHolder()) ?>"<?php echo $teachers_trains->subject->EditAttributes() ?>><?php echo $teachers_trains->subject->EditValue ?></textarea>
</span>
<?php echo $teachers_trains->subject->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers_trains->from_date->Visible) { // from_date ?>
	<div id="r_from_date" class="form-group">
		<label id="elh_teachers_trains_from_date" for="x_from_date" class="<?php echo $teachers_trains_add->LeftColumnClass ?>"><?php echo $teachers_trains->from_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $teachers_trains_add->RightColumnClass ?>"><div<?php echo $teachers_trains->from_date->CellAttributes() ?>>
<span id="el_teachers_trains_from_date">
<input type="text" data-table="teachers_trains" data-field="x_from_date" name="x_from_date" id="x_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_trains->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_trains->from_date->EditValue ?>"<?php echo $teachers_trains->from_date->EditAttributes() ?>>
</span>
<?php echo $teachers_trains->from_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers_trains->to_date->Visible) { // to_date ?>
	<div id="r_to_date" class="form-group">
		<label id="elh_teachers_trains_to_date" for="x_to_date" class="<?php echo $teachers_trains_add->LeftColumnClass ?>"><?php echo $teachers_trains->to_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $teachers_trains_add->RightColumnClass ?>"><div<?php echo $teachers_trains->to_date->CellAttributes() ?>>
<span id="el_teachers_trains_to_date">
<input type="text" data-table="teachers_trains" data-field="x_to_date" name="x_to_date" id="x_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_trains->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_trains->to_date->EditValue ?>"<?php echo $teachers_trains->to_date->EditAttributes() ?>>
</span>
<?php echo $teachers_trains->to_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$teachers_trains_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $teachers_trains_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $teachers_trains_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fteachers_trainsadd.Init();
</script>
<?php
$teachers_trains_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$teachers_trains_add->Page_Terminate();
?>
