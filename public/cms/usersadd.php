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

$users_add = NULL; // Initialize page object first

class cusers_add extends cusers {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
		$this->name->SetVisibility();
		$this->_email->SetVisibility();
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

		// Set up detail parameters
		$this->SetupDetailParms();

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
					$this->Page_Terminate("userslist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "userslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "usersview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetupDetailParms();
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
		$this->name->CurrentValue = NULL;
		$this->name->OldValue = $this->name->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->email_verified_at->CurrentValue = NULL;
		$this->email_verified_at->OldValue = $this->email_verified_at->CurrentValue;
		$this->password->CurrentValue = NULL;
		$this->password->OldValue = $this->password->CurrentValue;
		$this->phone->CurrentValue = NULL;
		$this->phone->OldValue = $this->phone->CurrentValue;
		$this->gender->CurrentValue = "male";
		$this->birthday->CurrentValue = NULL;
		$this->birthday->OldValue = $this->birthday->CurrentValue;
		$this->image->CurrentValue = NULL;
		$this->image->OldValue = $this->image->CurrentValue;
		$this->country_id->CurrentValue = NULL;
		$this->country_id->OldValue = $this->country_id->CurrentValue;
		$this->city->CurrentValue = NULL;
		$this->city->OldValue = $this->city->CurrentValue;
		$this->currency_id->CurrentValue = NULL;
		$this->currency_id->OldValue = $this->currency_id->CurrentValue;
		$this->type->CurrentValue = "student";
		$this->is_verified->CurrentValue = 0;
		$this->is_approved->CurrentValue = 0;
		$this->is_blocked->CurrentValue = 0;
		$this->otp->CurrentValue = NULL;
		$this->otp->OldValue = $this->otp->CurrentValue;
		$this->slug->CurrentValue = NULL;
		$this->slug->OldValue = $this->slug->CurrentValue;
		$this->remember_token->CurrentValue = NULL;
		$this->remember_token->OldValue = $this->remember_token->CurrentValue;
		$this->created_at->CurrentValue = NULL;
		$this->created_at->OldValue = $this->created_at->CurrentValue;
		$this->updated_at->CurrentValue = NULL;
		$this->updated_at->OldValue = $this->updated_at->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->name->CurrentValue = $this->name->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['name'] = $this->name->CurrentValue;
		$row['email'] = $this->_email->CurrentValue;
		$row['email_verified_at'] = $this->email_verified_at->CurrentValue;
		$row['password'] = $this->password->CurrentValue;
		$row['phone'] = $this->phone->CurrentValue;
		$row['gender'] = $this->gender->CurrentValue;
		$row['birthday'] = $this->birthday->CurrentValue;
		$row['image'] = $this->image->CurrentValue;
		$row['country_id'] = $this->country_id->CurrentValue;
		$row['city'] = $this->city->CurrentValue;
		$row['currency_id'] = $this->currency_id->CurrentValue;
		$row['type'] = $this->type->CurrentValue;
		$row['is_verified'] = $this->is_verified->CurrentValue;
		$row['is_approved'] = $this->is_approved->CurrentValue;
		$row['is_blocked'] = $this->is_blocked->CurrentValue;
		$row['otp'] = $this->otp->CurrentValue;
		$row['slug'] = $this->slug->CurrentValue;
		$row['remember_token'] = $this->remember_token->CurrentValue;
		$row['created_at'] = $this->created_at->CurrentValue;
		$row['updated_at'] = $this->updated_at->CurrentValue;
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

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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
			$this->gender->EditAttrs["class"] = "form-control";
			$this->gender->EditCustomAttributes = "";
			$this->gender->EditValue = $this->gender->Options(TRUE);

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
			if (trim(strval($this->country_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->country_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `name_ar` AS `DispFld`, `name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `countries`";
			$sWhereWrk = "";
			$this->country_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->country_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->country_id->EditValue = $arwrk;

			// city
			$this->city->EditAttrs["class"] = "form-control";
			$this->city->EditCustomAttributes = "";
			$this->city->EditValue = ew_HtmlEncode($this->city->CurrentValue);
			$this->city->PlaceHolder = ew_RemoveHtml($this->city->FldCaption());

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

			// Add refer script
			// name

			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

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
		if (!$this->password->FldIsDetailKey && !is_null($this->password->FormValue) && $this->password->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->password->FldCaption(), $this->password->ReqErrMsg));
		}
		if (!$this->gender->FldIsDetailKey && !is_null($this->gender->FormValue) && $this->gender->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->gender->FldCaption(), $this->gender->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->birthday->FormValue)) {
			ew_AddMessage($gsFormError, $this->birthday->FldErrMsg());
		}
		if ($this->type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->type->FldCaption(), $this->type->ReqErrMsg));
		}
		if ($this->is_verified->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->is_verified->FldCaption(), $this->is_verified->ReqErrMsg));
		}
		if ($this->is_approved->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->is_approved->FldCaption(), $this->is_approved->ReqErrMsg));
		}
		if ($this->is_blocked->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->is_blocked->FldCaption(), $this->is_blocked->ReqErrMsg));
		}
		if (!$this->otp->FldIsDetailKey && !is_null($this->otp->FormValue) && $this->otp->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->otp->FldCaption(), $this->otp->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("transfers", $DetailTblVar) && $GLOBALS["transfers"]->DetailAdd) {
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		if ($this->_email->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(email = '" . ew_AdjustSql($this->_email->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->_email->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->_email->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		if ($this->otp->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(otp = '" . ew_AdjustSql($this->otp->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->otp->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->otp->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// name
		$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, "", FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", FALSE);

		// password
		$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, "", FALSE);

		// phone
		$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, FALSE);

		// gender
		$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, "", strval($this->gender->CurrentValue) == "");

		// birthday
		$this->birthday->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->birthday->CurrentValue, 0), NULL, FALSE);

		// image
		$this->image->SetDbValueDef($rsnew, $this->image->CurrentValue, NULL, FALSE);

		// country_id
		$this->country_id->SetDbValueDef($rsnew, $this->country_id->CurrentValue, NULL, FALSE);

		// city
		$this->city->SetDbValueDef($rsnew, $this->city->CurrentValue, NULL, FALSE);

		// currency_id
		$this->currency_id->SetDbValueDef($rsnew, $this->currency_id->CurrentValue, NULL, FALSE);

		// type
		$this->type->SetDbValueDef($rsnew, $this->type->CurrentValue, "", strval($this->type->CurrentValue) == "");

		// is_verified
		$this->is_verified->SetDbValueDef($rsnew, $this->is_verified->CurrentValue, 0, strval($this->is_verified->CurrentValue) == "");

		// is_approved
		$this->is_approved->SetDbValueDef($rsnew, $this->is_approved->CurrentValue, 0, strval($this->is_approved->CurrentValue) == "");

		// is_blocked
		$this->is_blocked->SetDbValueDef($rsnew, $this->is_blocked->CurrentValue, 0, strval($this->is_blocked->CurrentValue) == "");

		// otp
		$this->otp->SetDbValueDef($rsnew, $this->otp->CurrentValue, "", FALSE);

		// slug
		$this->slug->SetDbValueDef($rsnew, $this->slug->CurrentValue, NULL, FALSE);

		// remember_token
		$this->remember_token->SetDbValueDef($rsnew, $this->remember_token->CurrentValue, NULL, FALSE);

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("transfers", $DetailTblVar) && $GLOBALS["transfers"]->DetailAdd) {
				$GLOBALS["transfers"]->user_id->setSessionValue($this->id->CurrentValue); // Set master key
				if (!isset($GLOBALS["transfers_grid"])) $GLOBALS["transfers_grid"] = new ctransfers_grid(); // Get detail page object
				$AddRow = $GLOBALS["transfers_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["transfers"]->user_id->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
				if ($GLOBALS["transfers_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["transfers_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["transfers_grid"]->CurrentMode = "add";
					$GLOBALS["transfers_grid"]->CurrentAction = "gridadd";

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
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_country_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `name_ar` AS `DispFld`, `name_en` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `countries`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->country_id, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($users_add)) $users_add = new cusers_add();

// Page init
$users_add->Page_Init();

// Page main
$users_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fusersadd = new ew_Form("fusersadd", "add");

// Validate form
fusersadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_password");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->password->FldCaption(), $users->password->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_gender");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->gender->FldCaption(), $users->gender->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_birthday");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->birthday->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->type->FldCaption(), $users->type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_is_verified");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->is_verified->FldCaption(), $users->is_verified->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_is_approved");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->is_approved->FldCaption(), $users->is_approved->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_is_blocked");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->is_blocked->FldCaption(), $users->is_blocked->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_otp");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->otp->FldCaption(), $users->otp->ReqErrMsg)) ?>");

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
fusersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fusersadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fusersadd.Lists["x_gender"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersadd.Lists["x_gender"].Options = <?php echo json_encode($users_add->gender->Options()) ?>;
fusersadd.Lists["x_country_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name_ar","x_name_en","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"countries"};
fusersadd.Lists["x_country_id"].Data = "<?php echo $users_add->country_id->LookupFilterQuery(FALSE, "add") ?>";
fusersadd.Lists["x_currency_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name_ar","x_name_en","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"currencies"};
fusersadd.Lists["x_currency_id"].Data = "<?php echo $users_add->currency_id->LookupFilterQuery(FALSE, "add") ?>";
fusersadd.Lists["x_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersadd.Lists["x_type"].Options = <?php echo json_encode($users_add->type->Options()) ?>;
fusersadd.Lists["x_is_verified"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersadd.Lists["x_is_verified"].Options = <?php echo json_encode($users_add->is_verified->Options()) ?>;
fusersadd.Lists["x_is_approved"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersadd.Lists["x_is_approved"].Options = <?php echo json_encode($users_add->is_approved->Options()) ?>;
fusersadd.Lists["x_is_blocked"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fusersadd.Lists["x_is_blocked"].Options = <?php echo json_encode($users_add->is_blocked->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $users_add->ShowPageHeader(); ?>
<?php
$users_add->ShowMessage();
?>
<form name="fusersadd" id="fusersadd" class="<?php echo $users_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($users_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $users_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($users_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($users->name->Visible) { // name ?>
	<div id="r_name" class="form-group">
		<label id="elh_users_name" for="x_name" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->name->CellAttributes() ?>>
<span id="el_users_name">
<input type="text" data-table="users" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($users->name->getPlaceHolder()) ?>" value="<?php echo $users->name->EditValue ?>"<?php echo $users->name->EditAttributes() ?>>
</span>
<?php echo $users->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_users__email" for="x__email" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->_email->CellAttributes() ?>>
<span id="el_users__email">
<input type="text" data-table="users" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($users->_email->getPlaceHolder()) ?>" value="<?php echo $users->_email->EditValue ?>"<?php echo $users->_email->EditAttributes() ?>>
</span>
<?php echo $users->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->password->Visible) { // password ?>
	<div id="r_password" class="form-group">
		<label id="elh_users_password" for="x_password" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->password->CellAttributes() ?>>
<span id="el_users_password">
<input type="text" data-table="users" data-field="x_password" name="x_password" id="x_password" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($users->password->getPlaceHolder()) ?>" value="<?php echo $users->password->EditValue ?>"<?php echo $users->password->EditAttributes() ?>>
</span>
<?php echo $users->password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->phone->Visible) { // phone ?>
	<div id="r_phone" class="form-group">
		<label id="elh_users_phone" for="x_phone" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->phone->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->phone->CellAttributes() ?>>
<span id="el_users_phone">
<input type="text" data-table="users" data-field="x_phone" name="x_phone" id="x_phone" placeholder="<?php echo ew_HtmlEncode($users->phone->getPlaceHolder()) ?>" value="<?php echo $users->phone->EditValue ?>"<?php echo $users->phone->EditAttributes() ?>>
</span>
<?php echo $users->phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->gender->Visible) { // gender ?>
	<div id="r_gender" class="form-group">
		<label id="elh_users_gender" for="x_gender" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->gender->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->gender->CellAttributes() ?>>
<span id="el_users_gender">
<select data-table="users" data-field="x_gender" data-value-separator="<?php echo $users->gender->DisplayValueSeparatorAttribute() ?>" id="x_gender" name="x_gender"<?php echo $users->gender->EditAttributes() ?>>
<?php echo $users->gender->SelectOptionListHtml("x_gender") ?>
</select>
</span>
<?php echo $users->gender->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->birthday->Visible) { // birthday ?>
	<div id="r_birthday" class="form-group">
		<label id="elh_users_birthday" for="x_birthday" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->birthday->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->birthday->CellAttributes() ?>>
<span id="el_users_birthday">
<input type="text" data-table="users" data-field="x_birthday" name="x_birthday" id="x_birthday" placeholder="<?php echo ew_HtmlEncode($users->birthday->getPlaceHolder()) ?>" value="<?php echo $users->birthday->EditValue ?>"<?php echo $users->birthday->EditAttributes() ?>>
</span>
<?php echo $users->birthday->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->image->Visible) { // image ?>
	<div id="r_image" class="form-group">
		<label id="elh_users_image" for="x_image" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->image->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->image->CellAttributes() ?>>
<span id="el_users_image">
<input type="text" data-table="users" data-field="x_image" name="x_image" id="x_image" placeholder="<?php echo ew_HtmlEncode($users->image->getPlaceHolder()) ?>" value="<?php echo $users->image->EditValue ?>"<?php echo $users->image->EditAttributes() ?>>
</span>
<?php echo $users->image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->country_id->Visible) { // country_id ?>
	<div id="r_country_id" class="form-group">
		<label id="elh_users_country_id" for="x_country_id" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->country_id->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->country_id->CellAttributes() ?>>
<span id="el_users_country_id">
<select data-table="users" data-field="x_country_id" data-value-separator="<?php echo $users->country_id->DisplayValueSeparatorAttribute() ?>" id="x_country_id" name="x_country_id"<?php echo $users->country_id->EditAttributes() ?>>
<?php echo $users->country_id->SelectOptionListHtml("x_country_id") ?>
</select>
</span>
<?php echo $users->country_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->city->Visible) { // city ?>
	<div id="r_city" class="form-group">
		<label id="elh_users_city" for="x_city" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->city->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->city->CellAttributes() ?>>
<span id="el_users_city">
<input type="text" data-table="users" data-field="x_city" name="x_city" id="x_city" placeholder="<?php echo ew_HtmlEncode($users->city->getPlaceHolder()) ?>" value="<?php echo $users->city->EditValue ?>"<?php echo $users->city->EditAttributes() ?>>
</span>
<?php echo $users->city->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->currency_id->Visible) { // currency_id ?>
	<div id="r_currency_id" class="form-group">
		<label id="elh_users_currency_id" for="x_currency_id" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->currency_id->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->currency_id->CellAttributes() ?>>
<span id="el_users_currency_id">
<select data-table="users" data-field="x_currency_id" data-value-separator="<?php echo $users->currency_id->DisplayValueSeparatorAttribute() ?>" id="x_currency_id" name="x_currency_id"<?php echo $users->currency_id->EditAttributes() ?>>
<?php echo $users->currency_id->SelectOptionListHtml("x_currency_id") ?>
</select>
</span>
<?php echo $users->currency_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->type->Visible) { // type ?>
	<div id="r_type" class="form-group">
		<label id="elh_users_type" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->type->CellAttributes() ?>>
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
		<label id="elh_users_is_verified" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->is_verified->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->is_verified->CellAttributes() ?>>
<span id="el_users_is_verified">
<div id="tp_x_is_verified" class="ewTemplate"><input type="radio" data-table="users" data-field="x_is_verified" data-value-separator="<?php echo $users->is_verified->DisplayValueSeparatorAttribute() ?>" name="x_is_verified" id="x_is_verified" value="{value}"<?php echo $users->is_verified->EditAttributes() ?>></div>
<div id="dsl_x_is_verified" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->is_verified->RadioButtonListHtml(FALSE, "x_is_verified") ?>
</div></div>
</span>
<?php echo $users->is_verified->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->is_approved->Visible) { // is_approved ?>
	<div id="r_is_approved" class="form-group">
		<label id="elh_users_is_approved" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->is_approved->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->is_approved->CellAttributes() ?>>
<span id="el_users_is_approved">
<div id="tp_x_is_approved" class="ewTemplate"><input type="radio" data-table="users" data-field="x_is_approved" data-value-separator="<?php echo $users->is_approved->DisplayValueSeparatorAttribute() ?>" name="x_is_approved" id="x_is_approved" value="{value}"<?php echo $users->is_approved->EditAttributes() ?>></div>
<div id="dsl_x_is_approved" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->is_approved->RadioButtonListHtml(FALSE, "x_is_approved") ?>
</div></div>
</span>
<?php echo $users->is_approved->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->is_blocked->Visible) { // is_blocked ?>
	<div id="r_is_blocked" class="form-group">
		<label id="elh_users_is_blocked" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->is_blocked->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->is_blocked->CellAttributes() ?>>
<span id="el_users_is_blocked">
<div id="tp_x_is_blocked" class="ewTemplate"><input type="radio" data-table="users" data-field="x_is_blocked" data-value-separator="<?php echo $users->is_blocked->DisplayValueSeparatorAttribute() ?>" name="x_is_blocked" id="x_is_blocked" value="{value}"<?php echo $users->is_blocked->EditAttributes() ?>></div>
<div id="dsl_x_is_blocked" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->is_blocked->RadioButtonListHtml(FALSE, "x_is_blocked") ?>
</div></div>
</span>
<?php echo $users->is_blocked->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->otp->Visible) { // otp ?>
	<div id="r_otp" class="form-group">
		<label id="elh_users_otp" for="x_otp" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->otp->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->otp->CellAttributes() ?>>
<span id="el_users_otp">
<input type="text" data-table="users" data-field="x_otp" name="x_otp" id="x_otp" placeholder="<?php echo ew_HtmlEncode($users->otp->getPlaceHolder()) ?>" value="<?php echo $users->otp->EditValue ?>"<?php echo $users->otp->EditAttributes() ?>>
</span>
<?php echo $users->otp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->slug->Visible) { // slug ?>
	<div id="r_slug" class="form-group">
		<label id="elh_users_slug" for="x_slug" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->slug->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->slug->CellAttributes() ?>>
<span id="el_users_slug">
<input type="text" data-table="users" data-field="x_slug" name="x_slug" id="x_slug" placeholder="<?php echo ew_HtmlEncode($users->slug->getPlaceHolder()) ?>" value="<?php echo $users->slug->EditValue ?>"<?php echo $users->slug->EditAttributes() ?>>
</span>
<?php echo $users->slug->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->remember_token->Visible) { // remember_token ?>
	<div id="r_remember_token" class="form-group">
		<label id="elh_users_remember_token" for="x_remember_token" class="<?php echo $users_add->LeftColumnClass ?>"><?php echo $users->remember_token->FldCaption() ?></label>
		<div class="<?php echo $users_add->RightColumnClass ?>"><div<?php echo $users->remember_token->CellAttributes() ?>>
<span id="el_users_remember_token">
<input type="text" data-table="users" data-field="x_remember_token" name="x_remember_token" id="x_remember_token" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($users->remember_token->getPlaceHolder()) ?>" value="<?php echo $users->remember_token->EditValue ?>"<?php echo $users->remember_token->EditAttributes() ?>>
</span>
<?php echo $users->remember_token->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("transfers", explode(",", $users->getCurrentDetailTable())) && $transfers->DetailAdd) {
?>
<?php if ($users->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("transfers", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "transfersgrid.php" ?>
<?php } ?>
<?php if (!$users_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $users_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $users_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fusersadd.Init();
</script>
<?php
$users_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_add->Page_Terminate();
?>
