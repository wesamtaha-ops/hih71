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

$orders_edit = NULL; // Initialize page object first

class corders_edit extends corders {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'orders';

	// Page object name
	var $PageObjName = 'orders_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->student_id->SetVisibility();
		$this->teacher_id->SetVisibility();
		$this->topic_id->SetVisibility();
		$this->date->SetVisibility();
		$this->time->SetVisibility();
		$this->fees->SetVisibility();
		$this->currency_id->SetVisibility();
		$this->status->SetVisibility();
		$this->meeting_id->SetVisibility();
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $RecCnt;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";

		// Load record by position
		$loadByPosition = FALSE;
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_id")) {
				$this->id->setFormValue($objForm->GetValue("x_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["id"])) {
				$this->id->setQueryStringValue($_GET["id"]);
				$loadByQuery = TRUE;
			} else {
				$this->id->CurrentValue = NULL;
			}
			if (!$loadByQuery)
				$loadByPosition = TRUE;
		}

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("orderslist.php"); // Return to list page
		} elseif ($loadByPosition) { // Load record by position
			$this->SetupStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$this->Recordset->Move($this->StartRec-1);
				$loaded = TRUE;
			}
		} else { // Match key values
			if (!is_null($this->id->CurrentValue)) {
				while (!$this->Recordset->EOF) {
					if (strval($this->id->CurrentValue) == strval($this->Recordset->fields('id'))) {
						$this->setStartRecordNumber($this->StartRec); // Save record position
						$loaded = TRUE;
						break;
					} else {
						$this->StartRec++;
						$this->Recordset->MoveNext();
					}
				}
			}
		}

		// Load current row values
		if ($loaded)
			$this->LoadRowValues($this->Recordset);

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("orderslist.php"); // Return to list page
				} else {
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "orderslist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
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
		if (!$this->created_at->FldIsDetailKey) {
			$this->created_at->setFormValue($objForm->GetValue("x_created_at"));
			$this->created_at->CurrentValue = ew_UnFormatDateTime($this->created_at->CurrentValue, 0);
		}
		if (!$this->updated_at->FldIsDetailKey) {
			$this->updated_at->setFormValue($objForm->GetValue("x_updated_at"));
			$this->updated_at->CurrentValue = ew_UnFormatDateTime($this->updated_at->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
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
		$this->created_at->CurrentValue = $this->created_at->FormValue;
		$this->created_at->CurrentValue = ew_UnFormatDateTime($this->created_at->CurrentValue, 0);
		$this->updated_at->CurrentValue = $this->updated_at->FormValue;
		$this->updated_at->CurrentValue = ew_UnFormatDateTime($this->updated_at->CurrentValue, 0);
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
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['student_id'] = NULL;
		$row['teacher_id'] = NULL;
		$row['topic_id'] = NULL;
		$row['date'] = NULL;
		$row['time'] = NULL;
		$row['fees'] = NULL;
		$row['currency_id'] = NULL;
		$row['status'] = NULL;
		$row['meeting_id'] = NULL;
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// student_id
		$this->student_id->ViewValue = $this->student_id->CurrentValue;
		$this->student_id->ViewCustomAttributes = "";

		// teacher_id
		$this->teacher_id->ViewValue = $this->teacher_id->CurrentValue;
		$this->teacher_id->ViewCustomAttributes = "";

		// topic_id
		$this->topic_id->ViewValue = $this->topic_id->CurrentValue;
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
		$this->currency_id->ViewValue = $this->currency_id->CurrentValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// student_id
			$this->student_id->EditAttrs["class"] = "form-control";
			$this->student_id->EditCustomAttributes = "";
			$this->student_id->EditValue = ew_HtmlEncode($this->student_id->CurrentValue);
			$this->student_id->PlaceHolder = ew_RemoveHtml($this->student_id->FldCaption());

			// teacher_id
			$this->teacher_id->EditAttrs["class"] = "form-control";
			$this->teacher_id->EditCustomAttributes = "";
			$this->teacher_id->EditValue = ew_HtmlEncode($this->teacher_id->CurrentValue);
			$this->teacher_id->PlaceHolder = ew_RemoveHtml($this->teacher_id->FldCaption());

			// topic_id
			$this->topic_id->EditAttrs["class"] = "form-control";
			$this->topic_id->EditCustomAttributes = "";
			$this->topic_id->EditValue = ew_HtmlEncode($this->topic_id->CurrentValue);
			$this->topic_id->PlaceHolder = ew_RemoveHtml($this->topic_id->FldCaption());

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
			$this->currency_id->EditValue = ew_HtmlEncode($this->currency_id->CurrentValue);
			$this->currency_id->PlaceHolder = ew_RemoveHtml($this->currency_id->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// meeting_id
			$this->meeting_id->EditAttrs["class"] = "form-control";
			$this->meeting_id->EditCustomAttributes = "";
			$this->meeting_id->EditValue = ew_HtmlEncode($this->meeting_id->CurrentValue);
			$this->meeting_id->PlaceHolder = ew_RemoveHtml($this->meeting_id->FldCaption());

			// created_at
			$this->created_at->EditAttrs["class"] = "form-control";
			$this->created_at->EditCustomAttributes = "";
			$this->created_at->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->created_at->CurrentValue, 8));
			$this->created_at->PlaceHolder = ew_RemoveHtml($this->created_at->FldCaption());

			// updated_at
			$this->updated_at->EditAttrs["class"] = "form-control";
			$this->updated_at->EditCustomAttributes = "";
			$this->updated_at->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->updated_at->CurrentValue, 8));
			$this->updated_at->PlaceHolder = ew_RemoveHtml($this->updated_at->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

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

			// created_at
			$this->created_at->LinkCustomAttributes = "";
			$this->created_at->HrefValue = "";

			// updated_at
			$this->updated_at->LinkCustomAttributes = "";
			$this->updated_at->HrefValue = "";
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
		if (!ew_CheckInteger($this->student_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->student_id->FldErrMsg());
		}
		if (!$this->teacher_id->FldIsDetailKey && !is_null($this->teacher_id->FormValue) && $this->teacher_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->teacher_id->FldCaption(), $this->teacher_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->teacher_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->teacher_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->topic_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->topic_id->FldErrMsg());
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
		if (!ew_CheckInteger($this->currency_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->currency_id->FldErrMsg());
		}
		if ($this->status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status->FldCaption(), $this->status->ReqErrMsg));
		}
		if (!$this->created_at->FldIsDetailKey && !is_null($this->created_at->FormValue) && $this->created_at->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->created_at->FldCaption(), $this->created_at->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->created_at->FormValue)) {
			ew_AddMessage($gsFormError, $this->created_at->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->updated_at->FormValue)) {
			ew_AddMessage($gsFormError, $this->updated_at->FldErrMsg());
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// student_id
			$this->student_id->SetDbValueDef($rsnew, $this->student_id->CurrentValue, 0, $this->student_id->ReadOnly);

			// teacher_id
			$this->teacher_id->SetDbValueDef($rsnew, $this->teacher_id->CurrentValue, 0, $this->teacher_id->ReadOnly);

			// topic_id
			$this->topic_id->SetDbValueDef($rsnew, $this->topic_id->CurrentValue, NULL, $this->topic_id->ReadOnly);

			// date
			$this->date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date->CurrentValue, 0), NULL, $this->date->ReadOnly);

			// time
			$this->time->SetDbValueDef($rsnew, $this->time->CurrentValue, NULL, $this->time->ReadOnly);

			// fees
			$this->fees->SetDbValueDef($rsnew, $this->fees->CurrentValue, 0, $this->fees->ReadOnly);

			// currency_id
			$this->currency_id->SetDbValueDef($rsnew, $this->currency_id->CurrentValue, 0, $this->currency_id->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, "", $this->status->ReadOnly);

			// meeting_id
			$this->meeting_id->SetDbValueDef($rsnew, $this->meeting_id->CurrentValue, NULL, $this->meeting_id->ReadOnly);

			// created_at
			$this->created_at->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->created_at->CurrentValue, 0), ew_CurrentDate(), $this->created_at->ReadOnly);

			// updated_at
			$this->updated_at->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->updated_at->CurrentValue, 0), NULL, $this->updated_at->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("orderslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($orders_edit)) $orders_edit = new corders_edit();

// Page init
$orders_edit->Page_Init();

// Page main
$orders_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$orders_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fordersedit = new ew_Form("fordersedit", "edit");

// Validate form
fordersedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_student_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->student_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->teacher_id->FldCaption(), $orders->teacher_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->teacher_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_topic_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->topic_id->FldErrMsg()) ?>");
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
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->currency_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->status->FldCaption(), $orders->status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->created_at->FldCaption(), $orders->created_at->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->created_at->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_updated_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->updated_at->FldErrMsg()) ?>");

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
fordersedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fordersedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fordersedit.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fordersedit.Lists["x_status"].Options = <?php echo json_encode($orders_edit->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $orders_edit->ShowPageHeader(); ?>
<?php
$orders_edit->ShowMessage();
?>
<?php if (!$orders_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($orders_edit->Pager)) $orders_edit->Pager = new cPrevNextPager($orders_edit->StartRec, $orders_edit->DisplayRecs, $orders_edit->TotalRecs, $orders_edit->AutoHidePager) ?>
<?php if ($orders_edit->Pager->RecordCount > 0 && $orders_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($orders_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $orders_edit->PageUrl() ?>start=<?php echo $orders_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($orders_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $orders_edit->PageUrl() ?>start=<?php echo $orders_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $orders_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($orders_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $orders_edit->PageUrl() ?>start=<?php echo $orders_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($orders_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $orders_edit->PageUrl() ?>start=<?php echo $orders_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $orders_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fordersedit" id="fordersedit" class="<?php echo $orders_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($orders_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $orders_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="orders">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($orders_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($orders->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_orders_id" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->id->FldCaption() ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->id->CellAttributes() ?>>
<span id="el_orders_id">
<span<?php echo $orders->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($orders->id->CurrentValue) ?>">
<?php echo $orders->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->student_id->Visible) { // student_id ?>
	<div id="r_student_id" class="form-group">
		<label id="elh_orders_student_id" for="x_student_id" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->student_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->student_id->CellAttributes() ?>>
<span id="el_orders_student_id">
<input type="text" data-table="orders" data-field="x_student_id" name="x_student_id" id="x_student_id" size="30" placeholder="<?php echo ew_HtmlEncode($orders->student_id->getPlaceHolder()) ?>" value="<?php echo $orders->student_id->EditValue ?>"<?php echo $orders->student_id->EditAttributes() ?>>
</span>
<?php echo $orders->student_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->teacher_id->Visible) { // teacher_id ?>
	<div id="r_teacher_id" class="form-group">
		<label id="elh_orders_teacher_id" for="x_teacher_id" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->teacher_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->teacher_id->CellAttributes() ?>>
<span id="el_orders_teacher_id">
<input type="text" data-table="orders" data-field="x_teacher_id" name="x_teacher_id" id="x_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($orders->teacher_id->getPlaceHolder()) ?>" value="<?php echo $orders->teacher_id->EditValue ?>"<?php echo $orders->teacher_id->EditAttributes() ?>>
</span>
<?php echo $orders->teacher_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->topic_id->Visible) { // topic_id ?>
	<div id="r_topic_id" class="form-group">
		<label id="elh_orders_topic_id" for="x_topic_id" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->topic_id->FldCaption() ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->topic_id->CellAttributes() ?>>
<span id="el_orders_topic_id">
<input type="text" data-table="orders" data-field="x_topic_id" name="x_topic_id" id="x_topic_id" size="30" placeholder="<?php echo ew_HtmlEncode($orders->topic_id->getPlaceHolder()) ?>" value="<?php echo $orders->topic_id->EditValue ?>"<?php echo $orders->topic_id->EditAttributes() ?>>
</span>
<?php echo $orders->topic_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->date->Visible) { // date ?>
	<div id="r_date" class="form-group">
		<label id="elh_orders_date" for="x_date" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->date->FldCaption() ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->date->CellAttributes() ?>>
<span id="el_orders_date">
<input type="text" data-table="orders" data-field="x_date" name="x_date" id="x_date" placeholder="<?php echo ew_HtmlEncode($orders->date->getPlaceHolder()) ?>" value="<?php echo $orders->date->EditValue ?>"<?php echo $orders->date->EditAttributes() ?>>
</span>
<?php echo $orders->date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->time->Visible) { // time ?>
	<div id="r_time" class="form-group">
		<label id="elh_orders_time" for="x_time" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->time->FldCaption() ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->time->CellAttributes() ?>>
<span id="el_orders_time">
<textarea data-table="orders" data-field="x_time" name="x_time" id="x_time" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($orders->time->getPlaceHolder()) ?>"<?php echo $orders->time->EditAttributes() ?>><?php echo $orders->time->EditValue ?></textarea>
</span>
<?php echo $orders->time->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->fees->Visible) { // fees ?>
	<div id="r_fees" class="form-group">
		<label id="elh_orders_fees" for="x_fees" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->fees->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->fees->CellAttributes() ?>>
<span id="el_orders_fees">
<input type="text" data-table="orders" data-field="x_fees" name="x_fees" id="x_fees" size="30" placeholder="<?php echo ew_HtmlEncode($orders->fees->getPlaceHolder()) ?>" value="<?php echo $orders->fees->EditValue ?>"<?php echo $orders->fees->EditAttributes() ?>>
</span>
<?php echo $orders->fees->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->currency_id->Visible) { // currency_id ?>
	<div id="r_currency_id" class="form-group">
		<label id="elh_orders_currency_id" for="x_currency_id" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->currency_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->currency_id->CellAttributes() ?>>
<span id="el_orders_currency_id">
<input type="text" data-table="orders" data-field="x_currency_id" name="x_currency_id" id="x_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($orders->currency_id->getPlaceHolder()) ?>" value="<?php echo $orders->currency_id->EditValue ?>"<?php echo $orders->currency_id->EditAttributes() ?>>
</span>
<?php echo $orders->currency_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_orders_status" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->status->CellAttributes() ?>>
<span id="el_orders_status">
<div id="tp_x_status" class="ewTemplate"><input type="radio" data-table="orders" data-field="x_status" data-value-separator="<?php echo $orders->status->DisplayValueSeparatorAttribute() ?>" name="x_status" id="x_status" value="{value}"<?php echo $orders->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $orders->status->RadioButtonListHtml(FALSE, "x_status") ?>
</div></div>
</span>
<?php echo $orders->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->meeting_id->Visible) { // meeting_id ?>
	<div id="r_meeting_id" class="form-group">
		<label id="elh_orders_meeting_id" for="x_meeting_id" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->meeting_id->FldCaption() ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->meeting_id->CellAttributes() ?>>
<span id="el_orders_meeting_id">
<textarea data-table="orders" data-field="x_meeting_id" name="x_meeting_id" id="x_meeting_id" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($orders->meeting_id->getPlaceHolder()) ?>"<?php echo $orders->meeting_id->EditAttributes() ?>><?php echo $orders->meeting_id->EditValue ?></textarea>
</span>
<?php echo $orders->meeting_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->created_at->Visible) { // created_at ?>
	<div id="r_created_at" class="form-group">
		<label id="elh_orders_created_at" for="x_created_at" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->created_at->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->created_at->CellAttributes() ?>>
<span id="el_orders_created_at">
<input type="text" data-table="orders" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?php echo ew_HtmlEncode($orders->created_at->getPlaceHolder()) ?>" value="<?php echo $orders->created_at->EditValue ?>"<?php echo $orders->created_at->EditAttributes() ?>>
</span>
<?php echo $orders->created_at->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->updated_at->Visible) { // updated_at ?>
	<div id="r_updated_at" class="form-group">
		<label id="elh_orders_updated_at" for="x_updated_at" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->updated_at->FldCaption() ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->updated_at->CellAttributes() ?>>
<span id="el_orders_updated_at">
<input type="text" data-table="orders" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?php echo ew_HtmlEncode($orders->updated_at->getPlaceHolder()) ?>" value="<?php echo $orders->updated_at->EditValue ?>"<?php echo $orders->updated_at->EditAttributes() ?>>
</span>
<?php echo $orders->updated_at->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$orders_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $orders_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $orders_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$orders_edit->IsModal) { ?>
<?php if (!isset($orders_edit->Pager)) $orders_edit->Pager = new cPrevNextPager($orders_edit->StartRec, $orders_edit->DisplayRecs, $orders_edit->TotalRecs, $orders_edit->AutoHidePager) ?>
<?php if ($orders_edit->Pager->RecordCount > 0 && $orders_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($orders_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $orders_edit->PageUrl() ?>start=<?php echo $orders_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($orders_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $orders_edit->PageUrl() ?>start=<?php echo $orders_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $orders_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($orders_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $orders_edit->PageUrl() ?>start=<?php echo $orders_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($orders_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $orders_edit->PageUrl() ?>start=<?php echo $orders_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $orders_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fordersedit.Init();
</script>
<?php
$orders_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$orders_edit->Page_Terminate();
?>
