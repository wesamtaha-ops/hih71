<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "transfersgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$users_edit = NULL; // Initialize page object first

class cusers_edit extends cusers {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_edit';

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

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == "cusers") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'users', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("userslist.php"));
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
		$this->name->SetVisibility();
		$this->_email->SetVisibility();
		$this->email_verified_at->SetVisibility();
		$this->password->SetVisibility();
		$this->phone->SetVisibility();
		$this->gender->SetVisibility();
		$this->birthday->SetVisibility();
		$this->image->SetVisibility();
		$this->country_id->SetVisibility();
		$this->city->SetVisibility();
		$this->currency_id->SetVisibility();
		$this->type->SetVisibility();
		$this->is_verified->SetVisibility();
		$this->is_approved->SetVisibility();
		$this->is_blocked->SetVisibility();
		$this->otp->SetVisibility();
		$this->slug->SetVisibility();
		$this->remember_token->SetVisibility();
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

			// Get the keys for master table
			$sDetailTblVar = $this->getCurrentDetailTable();
			if ($sDetailTblVar <> "") {
				$DetailTblVar = explode(",", $sDetailTblVar);
				if (in_array("transfers", $DetailTblVar)) {

					// Process auto fill for detail table 'transfers'
					if (preg_match('/^ftransfers(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["transfers_grid"])) $GLOBALS["transfers_grid"] = new ctransfers_grid;
						$GLOBALS["transfers_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
			}
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
		global $EW_EXPORT, $users;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($users);
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
					if ($pageName == "usersview.php")
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
			$this->Page_Terminate("userslist.php"); // Return to list page
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

			// Set up detail parameters
			$this->SetupDetailParms();
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
					$this->Page_Terminate("userslist.php"); // Return to list page
				} else {
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "userslist.php")
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

					// Set up detail parameters
					$this->SetupDetailParms();
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
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->email_verified_at->FldIsDetailKey) {
			$this->email_verified_at->setFormValue($objForm->GetValue("x_email_verified_at"));
			$this->email_verified_at->CurrentValue = ew_UnFormatDateTime($this->email_verified_at->CurrentValue, 0);
		}
		if (!$this->password->FldIsDetailKey) {
			$this->password->setFormValue($objForm->GetValue("x_password"));
		}
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		if (!$this->gender->FldIsDetailKey) {
			$this->gender->setFormValue($objForm->GetValue("x_gender"));
		}
		if (!$this->birthday->FldIsDetailKey) {
			$this->birthday->setFormValue($objForm->GetValue("x_birthday"));
			$this->birthday->CurrentValue = ew_UnFormatDateTime($this->birthday->CurrentValue, 0);
		}
		if (!$this->image->FldIsDetailKey) {
			$this->image->setFormValue($objForm->GetValue("x_image"));
		}
		if (!$this->country_id->FldIsDetailKey) {
			$this->country_id->setFormValue($objForm->GetValue("x_country_id"));
		}
		if (!$this->city->FldIsDetailKey) {
			$this->city->setFormValue($objForm->GetValue("x_city"));
		}
		if (!$this->currency_id->FldIsDetailKey) {
			$this->currency_id->setFormValue($objForm->GetValue("x_currency_id"));
		}
		if (!$this->type->FldIsDetailKey) {
			$this->type->setFormValue($objForm->GetValue("x_type"));
		}
		if (!$this->is_verified->FldIsDetailKey) {
			$this->is_verified->setFormValue($objForm->GetValue("x_is_verified"));
		}
		if (!$this->is_approved->FldIsDetailKey) {
			$this->is_approved->setFormValue($objForm->GetValue("x_is_approved"));
		}
		if (!$this->is_blocked->FldIsDetailKey) {
			$this->is_blocked->setFormValue($objForm->GetValue("x_is_blocked"));
		}
		if (!$this->otp->FldIsDetailKey) {
			$this->otp->setFormValue($objForm->GetValue("x_otp"));
		}
		if (!$this->slug->FldIsDetailKey) {
			$this->slug->setFormValue($objForm->GetValue("x_slug"));
		}
		if (!$this->remember_token->FldIsDetailKey) {
			$this->remember_token->setFormValue($objForm->GetValue("x_remember_token"));
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
		$this->name->CurrentValue = $this->name->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->email_verified_at->CurrentValue = $this->email_verified_at->FormValue;
		$this->email_verified_at->CurrentValue = ew_UnFormatDateTime($this->email_verified_at->CurrentValue, 0);
		$this->password->CurrentValue = $this->password->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->gender->CurrentValue = $this->gender->FormValue;
		$this->birthday->CurrentValue = $this->birthday->FormValue;
		$this->birthday->CurrentValue = ew_UnFormatDateTime($this->birthday->CurrentValue, 0);
		$this->image->CurrentValue = $this->image->FormValue;
		$this->country_id->CurrentValue = $this->country_id->FormValue;
		$this->city->CurrentValue = $this->city->FormValue;
		$this->currency_id->CurrentValue = $this->currency_id->FormValue;
		$this->type->CurrentValue = $this->type->FormValue;
		$this->is_verified->CurrentValue = $this->is_verified->FormValue;
		$this->is_approved->CurrentValue = $this->is_approved->FormValue;
		$this->is_blocked->CurrentValue = $this->is_blocked->FormValue;
		$this->otp->CurrentValue = $this->otp->FormValue;
		$this->slug->CurrentValue = $this->slug->FormValue;
		$this->remember_token->CurrentValue = $this->remember_token->FormValue;
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
		$this->name->setDbValue($row['name']);
		$this->_email->setDbValue($row['email']);
		$this->email_verified_at->setDbValue($row['email_verified_at']);
		$this->password->setDbValue($row['password']);
		$this->phone->setDbValue($row['phone']);
		$this->gender->setDbValue($row['gender']);
		$this->birthday->setDbValue($row['birthday']);
		$this->image->setDbValue($row['image']);
		$this->country_id->setDbValue($row['country_id']);
		$this->city->setDbValue($row['city']);
		$this->currency_id->setDbValue($row['currency_id']);
		$this->type->setDbValue($row['type']);
		$this->is_verified->setDbValue($row['is_verified']);
		$this->is_approved->setDbValue($row['is_approved']);
		$this->is_blocked->setDbValue($row['is_blocked']);
		$this->otp->setDbValue($row['otp']);
		$this->slug->setDbValue($row['slug']);
		$this->remember_token->setDbValue($row['remember_token']);
		$this->created_at->setDbValue($row['created_at']);
		$this->updated_at->setDbValue($row['updated_at']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['name'] = NULL;
		$row['email'] = NULL;
		$row['email_verified_at'] = NULL;
		$row['password'] = NULL;
		$row['phone'] = NULL;
		$row['gender'] = NULL;
		$row['birthday'] = NULL;
		$row['image'] = NULL;
		$row['country_id'] = NULL;
		$row['city'] = NULL;
		$row['currency_id'] = NULL;
		$row['type'] = NULL;
		$row['is_verified'] = NULL;
		$row['is_approved'] = NULL;
		$row['is_blocked'] = NULL;
		$row['otp'] = NULL;
		$row['slug'] = NULL;
		$row['remember_token'] = NULL;
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
		$this->name->DbValue = $row['name'];
		$this->_email->DbValue = $row['email'];
		$this->email_verified_at->DbValue = $row['email_verified_at'];
		$this->password->DbValue = $row['password'];
		$this->phone->DbValue = $row['phone'];
		$this->gender->DbValue = $row['gender'];
		$this->birthday->DbValue = $row['birthday'];
		$this->image->DbValue = $row['image'];
		$this->country_id->DbValue = $row['country_id'];
		$this->city->DbValue = $row['city'];
		$this->currency_id->DbValue = $row['currency_id'];
		$this->type->DbValue = $row['type'];
		$this->is_verified->DbValue = $row['is_verified'];
		$this->is_approved->DbValue = $row['is_approved'];
		$this->is_blocked->DbValue = $row['is_blocked'];
		$this->otp->DbValue = $row['otp'];
		$this->slug->DbValue = $row['slug'];
		$this->remember_token->DbValue = $row['remember_token'];
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
		// name
		// email
		// email_verified_at
		// password
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
		// updated_at

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		$this->country_id->ViewValue = $this->country_id->CurrentValue;
		$this->country_id->ViewCustomAttributes = "";

		// city
		$this->city->ViewValue = $this->city->CurrentValue;
		$this->city->ViewCustomAttributes = "";

		// currency_id
		$this->currency_id->ViewValue = $this->currency_id->CurrentValue;
		$this->currency_id->ViewCustomAttributes = "";

		// type
		if (strval($this->type->CurrentValue) <> "") {
			$this->type->ViewValue = $this->type->OptionCaption($this->type->CurrentValue);
		} else {
			$this->type->ViewValue = NULL;
		}
		$this->type->ViewCustomAttributes = "";

		// is_verified
		$this->is_verified->ViewValue = $this->is_verified->CurrentValue;
		$this->is_verified->ViewCustomAttributes = "";

		// is_approved
		$this->is_approved->ViewValue = $this->is_approved->CurrentValue;
		$this->is_approved->ViewCustomAttributes = "";

		// is_blocked
		$this->is_blocked->ViewValue = $this->is_blocked->CurrentValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// name
			$this->name->EditAttrs["class"] = "form-control";
			$this->name->EditCustomAttributes = "";
			$this->name->EditValue = ew_HtmlEncode($this->name->CurrentValue);
			$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// email_verified_at
			$this->email_verified_at->EditAttrs["class"] = "form-control";
			$this->email_verified_at->EditCustomAttributes = "";
			$this->email_verified_at->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->email_verified_at->CurrentValue, 8));
			$this->email_verified_at->PlaceHolder = ew_RemoveHtml($this->email_verified_at->FldCaption());

			// password
			$this->password->EditAttrs["class"] = "form-control";
			$this->password->EditCustomAttributes = "";
			$this->password->EditValue = ew_HtmlEncode($this->password->CurrentValue);
			$this->password->PlaceHolder = ew_RemoveHtml($this->password->FldCaption());

			// phone
			$this->phone->EditAttrs["class"] = "form-control";
			$this->phone->EditCustomAttributes = "";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->CurrentValue);
			$this->phone->PlaceHolder = ew_RemoveHtml($this->phone->FldCaption());

			// gender
			$this->gender->EditCustomAttributes = "";
			$this->gender->EditValue = $this->gender->Options(FALSE);

			// birthday
			$this->birthday->EditAttrs["class"] = "form-control";
			$this->birthday->EditCustomAttributes = "";
			$this->birthday->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->birthday->CurrentValue, 8));
			$this->birthday->PlaceHolder = ew_RemoveHtml($this->birthday->FldCaption());

			// image
			$this->image->EditAttrs["class"] = "form-control";
			$this->image->EditCustomAttributes = "";
			$this->image->EditValue = ew_HtmlEncode($this->image->CurrentValue);
			$this->image->PlaceHolder = ew_RemoveHtml($this->image->FldCaption());

			// country_id
			$this->country_id->EditAttrs["class"] = "form-control";
			$this->country_id->EditCustomAttributes = "";
			$this->country_id->EditValue = ew_HtmlEncode($this->country_id->CurrentValue);
			$this->country_id->PlaceHolder = ew_RemoveHtml($this->country_id->FldCaption());

			// city
			$this->city->EditAttrs["class"] = "form-control";
			$this->city->EditCustomAttributes = "";
			$this->city->EditValue = ew_HtmlEncode($this->city->CurrentValue);
			$this->city->PlaceHolder = ew_RemoveHtml($this->city->FldCaption());

			// currency_id
			$this->currency_id->EditAttrs["class"] = "form-control";
			$this->currency_id->EditCustomAttributes = "";
			$this->currency_id->EditValue = ew_HtmlEncode($this->currency_id->CurrentValue);
			$this->currency_id->PlaceHolder = ew_RemoveHtml($this->currency_id->FldCaption());

			// type
			$this->type->EditCustomAttributes = "";
			$this->type->EditValue = $this->type->Options(FALSE);

			// is_verified
			$this->is_verified->EditAttrs["class"] = "form-control";
			$this->is_verified->EditCustomAttributes = "";
			$this->is_verified->EditValue = ew_HtmlEncode($this->is_verified->CurrentValue);
			$this->is_verified->PlaceHolder = ew_RemoveHtml($this->is_verified->FldCaption());

			// is_approved
			$this->is_approved->EditAttrs["class"] = "form-control";
			$this->is_approved->EditCustomAttributes = "";
			$this->is_approved->EditValue = ew_HtmlEncode($this->is_approved->CurrentValue);
			$this->is_approved->PlaceHolder = ew_RemoveHtml($this->is_approved->FldCaption());

			// is_blocked
			$this->is_blocked->EditAttrs["class"] = "form-control";
			$this->is_blocked->EditCustomAttributes = "";
			$this->is_blocked->EditValue = ew_HtmlEncode($this->is_blocked->CurrentValue);
			$this->is_blocked->PlaceHolder = ew_RemoveHtml($this->is_blocked->FldCaption());

			// otp
			$this->otp->EditAttrs["class"] = "form-control";
			$this->otp->EditCustomAttributes = "";
			$this->otp->EditValue = ew_HtmlEncode($this->otp->CurrentValue);
			$this->otp->PlaceHolder = ew_RemoveHtml($this->otp->FldCaption());

			// slug
			$this->slug->EditAttrs["class"] = "form-control";
			$this->slug->EditCustomAttributes = "";
			$this->slug->EditValue = ew_HtmlEncode($this->slug->CurrentValue);
			$this->slug->PlaceHolder = ew_RemoveHtml($this->slug->FldCaption());

			// remember_token
			$this->remember_token->EditAttrs["class"] = "form-control";
			$this->remember_token->EditCustomAttributes = "";
			$this->remember_token->EditValue = ew_HtmlEncode($this->remember_token->CurrentValue);
			$this->remember_token->PlaceHolder = ew_RemoveHtml($this->remember_token->FldCaption());

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

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// email_verified_at
			$this->email_verified_at->LinkCustomAttributes = "";
			$this->email_verified_at->HrefValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";

			// gender
			$this->gender->LinkCustomAttributes = "";
			$this->gender->HrefValue = "";

			// birthday
			$this->birthday->LinkCustomAttributes = "";
			$this->birthday->HrefValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";

			// country_id
			$this->country_id->LinkCustomAttributes = "";
			$this->country_id->HrefValue = "";

			// city
			$this->city->LinkCustomAttributes = "";
			$this->city->HrefValue = "";

			// currency_id
			$this->currency_id->LinkCustomAttributes = "";
			$this->currency_id->HrefValue = "";

			// type
			$this->type->LinkCustomAttributes = "";
			$this->type->HrefValue = "";

			// is_verified
			$this->is_verified->LinkCustomAttributes = "";
			$this->is_verified->HrefValue = "";

			// is_approved
			$this->is_approved->LinkCustomAttributes = "";
			$this->is_approved->HrefValue = "";

			// is_blocked
			$this->is_blocked->LinkCustomAttributes = "";
			$this->is_blocked->HrefValue = "";

			// otp
			$this->otp->LinkCustomAttributes = "";
			$this->otp->HrefValue = "";

			// slug
			$this->slug->LinkCustomAttributes = "";
			$this->slug->HrefValue = "";

			// remember_token
			$this->remember_token->LinkCustomAttributes = "";
			$this->remember_token->HrefValue = "";

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
		if (!$this->name->FldIsDetailKey && !is_null($this->name->FormValue) && $this->name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->name->FldCaption(), $this->name->ReqErrMsg));
		}
		if (!$this->_email->FldIsDetailKey && !is_null($this->_email->FormValue) && $this->_email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_email->FldCaption(), $this->_email->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->email_verified_at->FormValue)) {
			ew_AddMessage($gsFormError, $this->email_verified_at->FldErrMsg());
		}
		if (!$this->password->FldIsDetailKey && !is_null($this->password->FormValue) && $this->password->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->password->FldCaption(), $this->password->ReqErrMsg));
		}
		if ($this->gender->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->gender->FldCaption(), $this->gender->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->birthday->FormValue)) {
			ew_AddMessage($gsFormError, $this->birthday->FldErrMsg());
		}
		if (!ew_CheckInteger($this->country_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->country_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->currency_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->currency_id->FldErrMsg());
		}
		if ($this->type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->type->FldCaption(), $this->type->ReqErrMsg));
		}
		if (!$this->is_verified->FldIsDetailKey && !is_null($this->is_verified->FormValue) && $this->is_verified->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->is_verified->FldCaption(), $this->is_verified->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->is_verified->FormValue)) {
			ew_AddMessage($gsFormError, $this->is_verified->FldErrMsg());
		}
		if (!$this->is_approved->FldIsDetailKey && !is_null($this->is_approved->FormValue) && $this->is_approved->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->is_approved->FldCaption(), $this->is_approved->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->is_approved->FormValue)) {
			ew_AddMessage($gsFormError, $this->is_approved->FldErrMsg());
		}
		if (!$this->is_blocked->FldIsDetailKey && !is_null($this->is_blocked->FormValue) && $this->is_blocked->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->is_blocked->FldCaption(), $this->is_blocked->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->is_blocked->FormValue)) {
			ew_AddMessage($gsFormError, $this->is_blocked->FldErrMsg());
		}
		if (!$this->otp->FldIsDetailKey && !is_null($this->otp->FormValue) && $this->otp->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->otp->FldCaption(), $this->otp->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->created_at->FormValue)) {
			ew_AddMessage($gsFormError, $this->created_at->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->updated_at->FormValue)) {
			ew_AddMessage($gsFormError, $this->updated_at->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("transfers", $DetailTblVar) && $GLOBALS["transfers"]->DetailEdit) {
			if (!isset($GLOBALS["transfers_grid"])) $GLOBALS["transfers_grid"] = new ctransfers_grid(); // get detail page object
			$GLOBALS["transfers_grid"]->ValidateGridForm();
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
		if ($this->_email->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`email` = '" . ew_AdjustSql($this->_email->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->_email->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->_email->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
		if ($this->otp->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`otp` = '" . ew_AdjustSql($this->otp->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->otp->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->otp->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// name
			$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, "", $this->name->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", $this->_email->ReadOnly);

			// email_verified_at
			$this->email_verified_at->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->email_verified_at->CurrentValue, 0), NULL, $this->email_verified_at->ReadOnly);

			// password
			$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, "", $this->password->ReadOnly);

			// phone
			$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, $this->phone->ReadOnly);

			// gender
			$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, "", $this->gender->ReadOnly);

			// birthday
			$this->birthday->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->birthday->CurrentValue, 0), NULL, $this->birthday->ReadOnly);

			// image
			$this->image->SetDbValueDef($rsnew, $this->image->CurrentValue, NULL, $this->image->ReadOnly);

			// country_id
			$this->country_id->SetDbValueDef($rsnew, $this->country_id->CurrentValue, NULL, $this->country_id->ReadOnly);

			// city
			$this->city->SetDbValueDef($rsnew, $this->city->CurrentValue, NULL, $this->city->ReadOnly);

			// currency_id
			$this->currency_id->SetDbValueDef($rsnew, $this->currency_id->CurrentValue, NULL, $this->currency_id->ReadOnly);

			// type
			$this->type->SetDbValueDef($rsnew, $this->type->CurrentValue, "", $this->type->ReadOnly);

			// is_verified
			$this->is_verified->SetDbValueDef($rsnew, $this->is_verified->CurrentValue, 0, $this->is_verified->ReadOnly);

			// is_approved
			$this->is_approved->SetDbValueDef($rsnew, $this->is_approved->CurrentValue, 0, $this->is_approved->ReadOnly);

			// is_blocked
			$this->is_blocked->SetDbValueDef($rsnew, $this->is_blocked->CurrentValue, 0, $this->is_blocked->ReadOnly);

			// otp
			$this->otp->SetDbValueDef($rsnew, $this->otp->CurrentValue, "", $this->otp->ReadOnly);

			// slug
			$this->slug->SetDbValueDef($rsnew, $this->slug->CurrentValue, NULL, $this->slug->ReadOnly);

			// remember_token
			$this->remember_token->SetDbValueDef($rsnew, $this->remember_token->CurrentValue, NULL, $this->remember_token->ReadOnly);

			// created_at
			$this->created_at->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->created_at->CurrentValue, 0), NULL, $this->created_at->ReadOnly);

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("transfers", $DetailTblVar) && $GLOBALS["transfers"]->DetailEdit) {
						if (!isset($GLOBALS["transfers_grid"])) $GLOBALS["transfers_grid"] = new ctransfers_grid(); // Get detail page object
						$EditRow = $GLOBALS["transfers_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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

	// Set up detail parms based on QueryString
	function SetupDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("transfers", $DetailTblVar)) {
				if (!isset($GLOBALS["transfers_grid"]))
					$GLOBALS["transfers_grid"] = new ctransfers_grid;
				if ($GLOBALS["transfers_grid"]->DetailEdit) {
					$GLOBALS["transfers_grid"]->CurrentMode = "edit";
					$GLOBALS["transfers_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["transfers_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["transfers_grid"]->setStartRecordNumber(1);
					$GLOBALS["transfers_grid"]->user_id->FldIsDetailKey = TRUE;
					$GLOBALS["transfers_grid"]->user_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["transfers_grid"]->user_id->setSessionValue($GLOBALS["transfers_grid"]->user_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("userslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($users_edit)) $users_edit = new cusers_edit();

// Page init
$users_edit->Page_Init();

// Page main
$users_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fusersedit = new ew_Form("fusersedit", "edit");

// Validate form
fusersedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->name->FldCaption(), $users->name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->_email->FldCaption(), $users->_email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_email_verified_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->email_verified_at->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_password");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->password->FldCaption(), $users->password->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_gender");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->gender->FldCaption(), $users->gender->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_birthday");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->birthday->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_country_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->country_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->currency_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->type->FldCaption(), $users->type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_is_verified");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->is_verified->FldCaption(), $users->is_verified->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_is_verified");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->is_verified->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_is_approved");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->is_approved->FldCaption(), $users->is_approved->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_is_approved");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->is_approved->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_is_blocked");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->is_blocked->FldCaption(), $users->is_blocked->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_is_blocked");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->is_blocked->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_otp");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->otp->FldCaption(), $users->otp->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->created_at->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_updated_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->updated_at->FldErrMsg()) ?>");

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
fusersedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fusersedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fusersedit.Lists["x_gender"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_gender"].Options = <?php echo json_encode($users_edit->gender->Options()) ?>;
fusersedit.Lists["x_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersedit.Lists["x_type"].Options = <?php echo json_encode($users_edit->type->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $users_edit->ShowPageHeader(); ?>
<?php
$users_edit->ShowMessage();
?>
<?php if (!$users_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($users_edit->Pager)) $users_edit->Pager = new cPrevNextPager($users_edit->StartRec, $users_edit->DisplayRecs, $users_edit->TotalRecs, $users_edit->AutoHidePager) ?>
<?php if ($users_edit->Pager->RecordCount > 0 && $users_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($users_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($users_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $users_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($users_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($users_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fusersedit" id="fusersedit" class="<?php echo $users_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($users_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $users_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($users_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($users->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_users_id" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->id->FldCaption() ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->id->CellAttributes() ?>>
<span id="el_users_id">
<span<?php echo $users->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $users->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="users" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($users->id->CurrentValue) ?>">
<?php echo $users->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
	<div id="r_name" class="form-group">
		<label id="elh_users_name" for="x_name" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->name->CellAttributes() ?>>
<span id="el_users_name">
<input type="text" data-table="users" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($users->name->getPlaceHolder()) ?>" value="<?php echo $users->name->EditValue ?>"<?php echo $users->name->EditAttributes() ?>>
</span>
<?php echo $users->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_users__email" for="x__email" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->_email->CellAttributes() ?>>
<span id="el_users__email">
<input type="text" data-table="users" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($users->_email->getPlaceHolder()) ?>" value="<?php echo $users->_email->EditValue ?>"<?php echo $users->_email->EditAttributes() ?>>
</span>
<?php echo $users->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->email_verified_at->Visible) { // email_verified_at ?>
	<div id="r_email_verified_at" class="form-group">
		<label id="elh_users_email_verified_at" for="x_email_verified_at" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->email_verified_at->FldCaption() ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->email_verified_at->CellAttributes() ?>>
<span id="el_users_email_verified_at">
<input type="text" data-table="users" data-field="x_email_verified_at" name="x_email_verified_at" id="x_email_verified_at" placeholder="<?php echo ew_HtmlEncode($users->email_verified_at->getPlaceHolder()) ?>" value="<?php echo $users->email_verified_at->EditValue ?>"<?php echo $users->email_verified_at->EditAttributes() ?>>
</span>
<?php echo $users->email_verified_at->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->password->Visible) { // password ?>
	<div id="r_password" class="form-group">
		<label id="elh_users_password" for="x_password" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->password->CellAttributes() ?>>
<span id="el_users_password">
<input type="text" data-table="users" data-field="x_password" name="x_password" id="x_password" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($users->password->getPlaceHolder()) ?>" value="<?php echo $users->password->EditValue ?>"<?php echo $users->password->EditAttributes() ?>>
</span>
<?php echo $users->password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->phone->Visible) { // phone ?>
	<div id="r_phone" class="form-group">
		<label id="elh_users_phone" for="x_phone" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->phone->FldCaption() ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->phone->CellAttributes() ?>>
<span id="el_users_phone">
<textarea data-table="users" data-field="x_phone" name="x_phone" id="x_phone" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($users->phone->getPlaceHolder()) ?>"<?php echo $users->phone->EditAttributes() ?>><?php echo $users->phone->EditValue ?></textarea>
</span>
<?php echo $users->phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->gender->Visible) { // gender ?>
	<div id="r_gender" class="form-group">
		<label id="elh_users_gender" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->gender->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->gender->CellAttributes() ?>>
<span id="el_users_gender">
<div id="tp_x_gender" class="ewTemplate"><input type="radio" data-table="users" data-field="x_gender" data-value-separator="<?php echo $users->gender->DisplayValueSeparatorAttribute() ?>" name="x_gender" id="x_gender" value="{value}"<?php echo $users->gender->EditAttributes() ?>></div>
<div id="dsl_x_gender" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->gender->RadioButtonListHtml(FALSE, "x_gender") ?>
</div></div>
</span>
<?php echo $users->gender->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->birthday->Visible) { // birthday ?>
	<div id="r_birthday" class="form-group">
		<label id="elh_users_birthday" for="x_birthday" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->birthday->FldCaption() ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->birthday->CellAttributes() ?>>
<span id="el_users_birthday">
<input type="text" data-table="users" data-field="x_birthday" name="x_birthday" id="x_birthday" placeholder="<?php echo ew_HtmlEncode($users->birthday->getPlaceHolder()) ?>" value="<?php echo $users->birthday->EditValue ?>"<?php echo $users->birthday->EditAttributes() ?>>
</span>
<?php echo $users->birthday->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->image->Visible) { // image ?>
	<div id="r_image" class="form-group">
		<label id="elh_users_image" for="x_image" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->image->FldCaption() ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->image->CellAttributes() ?>>
<span id="el_users_image">
<textarea data-table="users" data-field="x_image" name="x_image" id="x_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($users->image->getPlaceHolder()) ?>"<?php echo $users->image->EditAttributes() ?>><?php echo $users->image->EditValue ?></textarea>
</span>
<?php echo $users->image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->country_id->Visible) { // country_id ?>
	<div id="r_country_id" class="form-group">
		<label id="elh_users_country_id" for="x_country_id" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->country_id->FldCaption() ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->country_id->CellAttributes() ?>>
<span id="el_users_country_id">
<input type="text" data-table="users" data-field="x_country_id" name="x_country_id" id="x_country_id" size="30" placeholder="<?php echo ew_HtmlEncode($users->country_id->getPlaceHolder()) ?>" value="<?php echo $users->country_id->EditValue ?>"<?php echo $users->country_id->EditAttributes() ?>>
</span>
<?php echo $users->country_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->city->Visible) { // city ?>
	<div id="r_city" class="form-group">
		<label id="elh_users_city" for="x_city" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->city->FldCaption() ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->city->CellAttributes() ?>>
<span id="el_users_city">
<textarea data-table="users" data-field="x_city" name="x_city" id="x_city" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($users->city->getPlaceHolder()) ?>"<?php echo $users->city->EditAttributes() ?>><?php echo $users->city->EditValue ?></textarea>
</span>
<?php echo $users->city->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->currency_id->Visible) { // currency_id ?>
	<div id="r_currency_id" class="form-group">
		<label id="elh_users_currency_id" for="x_currency_id" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->currency_id->FldCaption() ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->currency_id->CellAttributes() ?>>
<span id="el_users_currency_id">
<input type="text" data-table="users" data-field="x_currency_id" name="x_currency_id" id="x_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($users->currency_id->getPlaceHolder()) ?>" value="<?php echo $users->currency_id->EditValue ?>"<?php echo $users->currency_id->EditAttributes() ?>>
</span>
<?php echo $users->currency_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->type->Visible) { // type ?>
	<div id="r_type" class="form-group">
		<label id="elh_users_type" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->type->CellAttributes() ?>>
<span id="el_users_type">
<div id="tp_x_type" class="ewTemplate"><input type="radio" data-table="users" data-field="x_type" data-value-separator="<?php echo $users->type->DisplayValueSeparatorAttribute() ?>" name="x_type" id="x_type" value="{value}"<?php echo $users->type->EditAttributes() ?>></div>
<div id="dsl_x_type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->type->RadioButtonListHtml(FALSE, "x_type") ?>
</div></div>
</span>
<?php echo $users->type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->is_verified->Visible) { // is_verified ?>
	<div id="r_is_verified" class="form-group">
		<label id="elh_users_is_verified" for="x_is_verified" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->is_verified->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->is_verified->CellAttributes() ?>>
<span id="el_users_is_verified">
<input type="text" data-table="users" data-field="x_is_verified" name="x_is_verified" id="x_is_verified" size="30" placeholder="<?php echo ew_HtmlEncode($users->is_verified->getPlaceHolder()) ?>" value="<?php echo $users->is_verified->EditValue ?>"<?php echo $users->is_verified->EditAttributes() ?>>
</span>
<?php echo $users->is_verified->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->is_approved->Visible) { // is_approved ?>
	<div id="r_is_approved" class="form-group">
		<label id="elh_users_is_approved" for="x_is_approved" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->is_approved->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->is_approved->CellAttributes() ?>>
<span id="el_users_is_approved">
<input type="text" data-table="users" data-field="x_is_approved" name="x_is_approved" id="x_is_approved" size="30" placeholder="<?php echo ew_HtmlEncode($users->is_approved->getPlaceHolder()) ?>" value="<?php echo $users->is_approved->EditValue ?>"<?php echo $users->is_approved->EditAttributes() ?>>
</span>
<?php echo $users->is_approved->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->is_blocked->Visible) { // is_blocked ?>
	<div id="r_is_blocked" class="form-group">
		<label id="elh_users_is_blocked" for="x_is_blocked" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->is_blocked->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->is_blocked->CellAttributes() ?>>
<span id="el_users_is_blocked">
<input type="text" data-table="users" data-field="x_is_blocked" name="x_is_blocked" id="x_is_blocked" size="30" placeholder="<?php echo ew_HtmlEncode($users->is_blocked->getPlaceHolder()) ?>" value="<?php echo $users->is_blocked->EditValue ?>"<?php echo $users->is_blocked->EditAttributes() ?>>
</span>
<?php echo $users->is_blocked->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->otp->Visible) { // otp ?>
	<div id="r_otp" class="form-group">
		<label id="elh_users_otp" for="x_otp" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->otp->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->otp->CellAttributes() ?>>
<span id="el_users_otp">
<textarea data-table="users" data-field="x_otp" name="x_otp" id="x_otp" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($users->otp->getPlaceHolder()) ?>"<?php echo $users->otp->EditAttributes() ?>><?php echo $users->otp->EditValue ?></textarea>
</span>
<?php echo $users->otp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->slug->Visible) { // slug ?>
	<div id="r_slug" class="form-group">
		<label id="elh_users_slug" for="x_slug" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->slug->FldCaption() ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->slug->CellAttributes() ?>>
<span id="el_users_slug">
<textarea data-table="users" data-field="x_slug" name="x_slug" id="x_slug" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($users->slug->getPlaceHolder()) ?>"<?php echo $users->slug->EditAttributes() ?>><?php echo $users->slug->EditValue ?></textarea>
</span>
<?php echo $users->slug->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->remember_token->Visible) { // remember_token ?>
	<div id="r_remember_token" class="form-group">
		<label id="elh_users_remember_token" for="x_remember_token" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->remember_token->FldCaption() ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->remember_token->CellAttributes() ?>>
<span id="el_users_remember_token">
<input type="text" data-table="users" data-field="x_remember_token" name="x_remember_token" id="x_remember_token" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($users->remember_token->getPlaceHolder()) ?>" value="<?php echo $users->remember_token->EditValue ?>"<?php echo $users->remember_token->EditAttributes() ?>>
</span>
<?php echo $users->remember_token->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->created_at->Visible) { // created_at ?>
	<div id="r_created_at" class="form-group">
		<label id="elh_users_created_at" for="x_created_at" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->created_at->FldCaption() ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->created_at->CellAttributes() ?>>
<span id="el_users_created_at">
<input type="text" data-table="users" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?php echo ew_HtmlEncode($users->created_at->getPlaceHolder()) ?>" value="<?php echo $users->created_at->EditValue ?>"<?php echo $users->created_at->EditAttributes() ?>>
</span>
<?php echo $users->created_at->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->updated_at->Visible) { // updated_at ?>
	<div id="r_updated_at" class="form-group">
		<label id="elh_users_updated_at" for="x_updated_at" class="<?php echo $users_edit->LeftColumnClass ?>"><?php echo $users->updated_at->FldCaption() ?></label>
		<div class="<?php echo $users_edit->RightColumnClass ?>"><div<?php echo $users->updated_at->CellAttributes() ?>>
<span id="el_users_updated_at">
<input type="text" data-table="users" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?php echo ew_HtmlEncode($users->updated_at->getPlaceHolder()) ?>" value="<?php echo $users->updated_at->EditValue ?>"<?php echo $users->updated_at->EditAttributes() ?>>
</span>
<?php echo $users->updated_at->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("transfers", explode(",", $users->getCurrentDetailTable())) && $transfers->DetailEdit) {
?>
<?php if ($users->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("transfers", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "transfersgrid.php" ?>
<?php } ?>
<?php if (!$users_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $users_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $users_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$users_edit->IsModal) { ?>
<?php if (!isset($users_edit->Pager)) $users_edit->Pager = new cPrevNextPager($users_edit->StartRec, $users_edit->DisplayRecs, $users_edit->TotalRecs, $users_edit->AutoHidePager) ?>
<?php if ($users_edit->Pager->RecordCount > 0 && $users_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($users_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($users_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $users_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($users_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($users_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_edit->PageUrl() ?>start=<?php echo $users_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fusersedit.Init();
</script>
<?php
$users_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_edit->Page_Terminate();
?>
