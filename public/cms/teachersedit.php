<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "teachersinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "teachers_certificatesgridcls.php" ?>
<?php include_once "teachers_coursesgridcls.php" ?>
<?php include_once "teachers_experiencesgridcls.php" ?>
<?php include_once "teachers_levelsgridcls.php" ?>
<?php include_once "teachers_packagesgridcls.php" ?>
<?php include_once "teachers_topicsgridcls.php" ?>
<?php include_once "teachers_trainsgridcls.php" ?>
<?php include_once "ordersgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$teachers_edit = NULL; // Initialize page object first

class cteachers_edit extends cteachers {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'teachers';

	// Page object name
	var $PageObjName = 'teachers_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("teacherslist.php"));
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {

			// Get the keys for master table
			$sDetailTblVar = $this->getCurrentDetailTable();
			if ($sDetailTblVar <> "") {
				$DetailTblVar = explode(",", $sDetailTblVar);
				if (in_array("teachers_certificates", $DetailTblVar)) {

					// Process auto fill for detail table 'teachers_certificates'
					if (preg_match('/^fteachers_certificates(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["teachers_certificates_grid"])) $GLOBALS["teachers_certificates_grid"] = new cteachers_certificates_grid;
						$GLOBALS["teachers_certificates_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
				if (in_array("teachers_courses", $DetailTblVar)) {

					// Process auto fill for detail table 'teachers_courses'
					if (preg_match('/^fteachers_courses(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["teachers_courses_grid"])) $GLOBALS["teachers_courses_grid"] = new cteachers_courses_grid;
						$GLOBALS["teachers_courses_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
				if (in_array("teachers_experiences", $DetailTblVar)) {

					// Process auto fill for detail table 'teachers_experiences'
					if (preg_match('/^fteachers_experiences(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["teachers_experiences_grid"])) $GLOBALS["teachers_experiences_grid"] = new cteachers_experiences_grid;
						$GLOBALS["teachers_experiences_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
				if (in_array("teachers_levels", $DetailTblVar)) {

					// Process auto fill for detail table 'teachers_levels'
					if (preg_match('/^fteachers_levels(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["teachers_levels_grid"])) $GLOBALS["teachers_levels_grid"] = new cteachers_levels_grid;
						$GLOBALS["teachers_levels_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
				if (in_array("teachers_packages", $DetailTblVar)) {

					// Process auto fill for detail table 'teachers_packages'
					if (preg_match('/^fteachers_packages(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["teachers_packages_grid"])) $GLOBALS["teachers_packages_grid"] = new cteachers_packages_grid;
						$GLOBALS["teachers_packages_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
				if (in_array("teachers_topics", $DetailTblVar)) {

					// Process auto fill for detail table 'teachers_topics'
					if (preg_match('/^fteachers_topics(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["teachers_topics_grid"])) $GLOBALS["teachers_topics_grid"] = new cteachers_topics_grid;
						$GLOBALS["teachers_topics_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
				if (in_array("teachers_trains", $DetailTblVar)) {

					// Process auto fill for detail table 'teachers_trains'
					if (preg_match('/^fteachers_trains(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["teachers_trains_grid"])) $GLOBALS["teachers_trains_grid"] = new cteachers_trains_grid;
						$GLOBALS["teachers_trains_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
				if (in_array("orders", $DetailTblVar)) {

					// Process auto fill for detail table 'orders'
					if (preg_match('/^forders(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["orders_grid"])) $GLOBALS["orders_grid"] = new corders_grid;
						$GLOBALS["orders_grid"]->Page_Init();
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "teachersview.php")
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

		// Set up master detail parameters
		$this->SetupMasterParms();

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("teacherslist.php"); // Return to list page
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
					$this->Page_Terminate("teacherslist.php"); // Return to list page
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
				if (ew_GetPageName($sReturnUrl) == "teacherslist.php")
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
		if (!$this->user_id->FldIsDetailKey) {
			$this->user_id->setFormValue($objForm->GetValue("x_user_id"));
		}
		if (!$this->timezone->FldIsDetailKey) {
			$this->timezone->setFormValue($objForm->GetValue("x_timezone"));
		}
		if (!$this->teacher_language->FldIsDetailKey) {
			$this->teacher_language->setFormValue($objForm->GetValue("x_teacher_language"));
		}
		if (!$this->video->FldIsDetailKey) {
			$this->video->setFormValue($objForm->GetValue("x_video"));
		}
		if (!$this->heading_ar->FldIsDetailKey) {
			$this->heading_ar->setFormValue($objForm->GetValue("x_heading_ar"));
		}
		if (!$this->description_ar->FldIsDetailKey) {
			$this->description_ar->setFormValue($objForm->GetValue("x_description_ar"));
		}
		if (!$this->heading_en->FldIsDetailKey) {
			$this->heading_en->setFormValue($objForm->GetValue("x_heading_en"));
		}
		if (!$this->description_en->FldIsDetailKey) {
			$this->description_en->setFormValue($objForm->GetValue("x_description_en"));
		}
		if (!$this->allow_express->FldIsDetailKey) {
			$this->allow_express->setFormValue($objForm->GetValue("x_allow_express"));
		}
		if (!$this->fees->FldIsDetailKey) {
			$this->fees->setFormValue($objForm->GetValue("x_fees"));
		}
		if (!$this->currency_id->FldIsDetailKey) {
			$this->currency_id->setFormValue($objForm->GetValue("x_currency_id"));
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
		$this->user_id->CurrentValue = $this->user_id->FormValue;
		$this->timezone->CurrentValue = $this->timezone->FormValue;
		$this->teacher_language->CurrentValue = $this->teacher_language->FormValue;
		$this->video->CurrentValue = $this->video->FormValue;
		$this->heading_ar->CurrentValue = $this->heading_ar->FormValue;
		$this->description_ar->CurrentValue = $this->description_ar->FormValue;
		$this->heading_en->CurrentValue = $this->heading_en->FormValue;
		$this->description_en->CurrentValue = $this->description_en->FormValue;
		$this->allow_express->CurrentValue = $this->allow_express->FormValue;
		$this->fees->CurrentValue = $this->fees->FormValue;
		$this->currency_id->CurrentValue = $this->currency_id->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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
			$this->user_id->EditValue = ew_HtmlEncode($this->user_id->CurrentValue);
			$this->user_id->PlaceHolder = ew_RemoveHtml($this->user_id->FldCaption());
			}

			// timezone
			$this->timezone->EditAttrs["class"] = "form-control";
			$this->timezone->EditCustomAttributes = "";
			$this->timezone->EditValue = ew_HtmlEncode($this->timezone->CurrentValue);
			$this->timezone->PlaceHolder = ew_RemoveHtml($this->timezone->FldCaption());

			// teacher_language
			$this->teacher_language->EditAttrs["class"] = "form-control";
			$this->teacher_language->EditCustomAttributes = "";
			$this->teacher_language->EditValue = ew_HtmlEncode($this->teacher_language->CurrentValue);
			$this->teacher_language->PlaceHolder = ew_RemoveHtml($this->teacher_language->FldCaption());

			// video
			$this->video->EditAttrs["class"] = "form-control";
			$this->video->EditCustomAttributes = "";
			$this->video->EditValue = ew_HtmlEncode($this->video->CurrentValue);
			$this->video->PlaceHolder = ew_RemoveHtml($this->video->FldCaption());

			// heading_ar
			$this->heading_ar->EditAttrs["class"] = "form-control";
			$this->heading_ar->EditCustomAttributes = "";
			$this->heading_ar->EditValue = ew_HtmlEncode($this->heading_ar->CurrentValue);
			$this->heading_ar->PlaceHolder = ew_RemoveHtml($this->heading_ar->FldCaption());

			// description_ar
			$this->description_ar->EditAttrs["class"] = "form-control";
			$this->description_ar->EditCustomAttributes = "";
			$this->description_ar->EditValue = ew_HtmlEncode($this->description_ar->CurrentValue);
			$this->description_ar->PlaceHolder = ew_RemoveHtml($this->description_ar->FldCaption());

			// heading_en
			$this->heading_en->EditAttrs["class"] = "form-control";
			$this->heading_en->EditCustomAttributes = "";
			$this->heading_en->EditValue = ew_HtmlEncode($this->heading_en->CurrentValue);
			$this->heading_en->PlaceHolder = ew_RemoveHtml($this->heading_en->FldCaption());

			// description_en
			$this->description_en->EditAttrs["class"] = "form-control";
			$this->description_en->EditCustomAttributes = "";
			$this->description_en->EditValue = ew_HtmlEncode($this->description_en->CurrentValue);
			$this->description_en->PlaceHolder = ew_RemoveHtml($this->description_en->FldCaption());

			// allow_express
			$this->allow_express->EditAttrs["class"] = "form-control";
			$this->allow_express->EditCustomAttributes = "";
			$this->allow_express->EditValue = ew_HtmlEncode($this->allow_express->CurrentValue);
			$this->allow_express->PlaceHolder = ew_RemoveHtml($this->allow_express->FldCaption());

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

			// user_id
			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";

			// timezone
			$this->timezone->LinkCustomAttributes = "";
			$this->timezone->HrefValue = "";

			// teacher_language
			$this->teacher_language->LinkCustomAttributes = "";
			$this->teacher_language->HrefValue = "";

			// video
			$this->video->LinkCustomAttributes = "";
			$this->video->HrefValue = "";

			// heading_ar
			$this->heading_ar->LinkCustomAttributes = "";
			$this->heading_ar->HrefValue = "";

			// description_ar
			$this->description_ar->LinkCustomAttributes = "";
			$this->description_ar->HrefValue = "";

			// heading_en
			$this->heading_en->LinkCustomAttributes = "";
			$this->heading_en->HrefValue = "";

			// description_en
			$this->description_en->LinkCustomAttributes = "";
			$this->description_en->HrefValue = "";

			// allow_express
			$this->allow_express->LinkCustomAttributes = "";
			$this->allow_express->HrefValue = "";

			// fees
			$this->fees->LinkCustomAttributes = "";
			$this->fees->HrefValue = "";

			// currency_id
			$this->currency_id->LinkCustomAttributes = "";
			$this->currency_id->HrefValue = "";

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
		if (!$this->user_id->FldIsDetailKey && !is_null($this->user_id->FormValue) && $this->user_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->user_id->FldCaption(), $this->user_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->user_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->user_id->FldErrMsg());
		}
		if (!$this->allow_express->FldIsDetailKey && !is_null($this->allow_express->FormValue) && $this->allow_express->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->allow_express->FldCaption(), $this->allow_express->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->allow_express->FormValue)) {
			ew_AddMessage($gsFormError, $this->allow_express->FldErrMsg());
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
		if (!$this->created_at->FldIsDetailKey && !is_null($this->created_at->FormValue) && $this->created_at->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->created_at->FldCaption(), $this->created_at->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->created_at->FormValue)) {
			ew_AddMessage($gsFormError, $this->created_at->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->updated_at->FormValue)) {
			ew_AddMessage($gsFormError, $this->updated_at->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("teachers_certificates", $DetailTblVar) && $GLOBALS["teachers_certificates"]->DetailEdit) {
			if (!isset($GLOBALS["teachers_certificates_grid"])) $GLOBALS["teachers_certificates_grid"] = new cteachers_certificates_grid(); // get detail page object
			$GLOBALS["teachers_certificates_grid"]->ValidateGridForm();
		}
		if (in_array("teachers_courses", $DetailTblVar) && $GLOBALS["teachers_courses"]->DetailEdit) {
			if (!isset($GLOBALS["teachers_courses_grid"])) $GLOBALS["teachers_courses_grid"] = new cteachers_courses_grid(); // get detail page object
			$GLOBALS["teachers_courses_grid"]->ValidateGridForm();
		}
		if (in_array("teachers_experiences", $DetailTblVar) && $GLOBALS["teachers_experiences"]->DetailEdit) {
			if (!isset($GLOBALS["teachers_experiences_grid"])) $GLOBALS["teachers_experiences_grid"] = new cteachers_experiences_grid(); // get detail page object
			$GLOBALS["teachers_experiences_grid"]->ValidateGridForm();
		}
		if (in_array("teachers_levels", $DetailTblVar) && $GLOBALS["teachers_levels"]->DetailEdit) {
			if (!isset($GLOBALS["teachers_levels_grid"])) $GLOBALS["teachers_levels_grid"] = new cteachers_levels_grid(); // get detail page object
			$GLOBALS["teachers_levels_grid"]->ValidateGridForm();
		}
		if (in_array("teachers_packages", $DetailTblVar) && $GLOBALS["teachers_packages"]->DetailEdit) {
			if (!isset($GLOBALS["teachers_packages_grid"])) $GLOBALS["teachers_packages_grid"] = new cteachers_packages_grid(); // get detail page object
			$GLOBALS["teachers_packages_grid"]->ValidateGridForm();
		}
		if (in_array("teachers_topics", $DetailTblVar) && $GLOBALS["teachers_topics"]->DetailEdit) {
			if (!isset($GLOBALS["teachers_topics_grid"])) $GLOBALS["teachers_topics_grid"] = new cteachers_topics_grid(); // get detail page object
			$GLOBALS["teachers_topics_grid"]->ValidateGridForm();
		}
		if (in_array("teachers_trains", $DetailTblVar) && $GLOBALS["teachers_trains"]->DetailEdit) {
			if (!isset($GLOBALS["teachers_trains_grid"])) $GLOBALS["teachers_trains_grid"] = new cteachers_trains_grid(); // get detail page object
			$GLOBALS["teachers_trains_grid"]->ValidateGridForm();
		}
		if (in_array("orders", $DetailTblVar) && $GLOBALS["orders"]->DetailEdit) {
			if (!isset($GLOBALS["orders_grid"])) $GLOBALS["orders_grid"] = new corders_grid(); // get detail page object
			$GLOBALS["orders_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// user_id
			$this->user_id->SetDbValueDef($rsnew, $this->user_id->CurrentValue, 0, $this->user_id->ReadOnly);

			// timezone
			$this->timezone->SetDbValueDef($rsnew, $this->timezone->CurrentValue, NULL, $this->timezone->ReadOnly);

			// teacher_language
			$this->teacher_language->SetDbValueDef($rsnew, $this->teacher_language->CurrentValue, NULL, $this->teacher_language->ReadOnly);

			// video
			$this->video->SetDbValueDef($rsnew, $this->video->CurrentValue, NULL, $this->video->ReadOnly);

			// heading_ar
			$this->heading_ar->SetDbValueDef($rsnew, $this->heading_ar->CurrentValue, NULL, $this->heading_ar->ReadOnly);

			// description_ar
			$this->description_ar->SetDbValueDef($rsnew, $this->description_ar->CurrentValue, NULL, $this->description_ar->ReadOnly);

			// heading_en
			$this->heading_en->SetDbValueDef($rsnew, $this->heading_en->CurrentValue, NULL, $this->heading_en->ReadOnly);

			// description_en
			$this->description_en->SetDbValueDef($rsnew, $this->description_en->CurrentValue, NULL, $this->description_en->ReadOnly);

			// allow_express
			$this->allow_express->SetDbValueDef($rsnew, $this->allow_express->CurrentValue, 0, $this->allow_express->ReadOnly);

			// fees
			$this->fees->SetDbValueDef($rsnew, $this->fees->CurrentValue, 0, $this->fees->ReadOnly);

			// currency_id
			$this->currency_id->SetDbValueDef($rsnew, $this->currency_id->CurrentValue, 0, $this->currency_id->ReadOnly);

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("teachers_certificates", $DetailTblVar) && $GLOBALS["teachers_certificates"]->DetailEdit) {
						if (!isset($GLOBALS["teachers_certificates_grid"])) $GLOBALS["teachers_certificates_grid"] = new cteachers_certificates_grid(); // Get detail page object
						$EditRow = $GLOBALS["teachers_certificates_grid"]->GridUpdate();
					}
				}
				if ($EditRow) {
					if (in_array("teachers_courses", $DetailTblVar) && $GLOBALS["teachers_courses"]->DetailEdit) {
						if (!isset($GLOBALS["teachers_courses_grid"])) $GLOBALS["teachers_courses_grid"] = new cteachers_courses_grid(); // Get detail page object
						$EditRow = $GLOBALS["teachers_courses_grid"]->GridUpdate();
					}
				}
				if ($EditRow) {
					if (in_array("teachers_experiences", $DetailTblVar) && $GLOBALS["teachers_experiences"]->DetailEdit) {
						if (!isset($GLOBALS["teachers_experiences_grid"])) $GLOBALS["teachers_experiences_grid"] = new cteachers_experiences_grid(); // Get detail page object
						$EditRow = $GLOBALS["teachers_experiences_grid"]->GridUpdate();
					}
				}
				if ($EditRow) {
					if (in_array("teachers_levels", $DetailTblVar) && $GLOBALS["teachers_levels"]->DetailEdit) {
						if (!isset($GLOBALS["teachers_levels_grid"])) $GLOBALS["teachers_levels_grid"] = new cteachers_levels_grid(); // Get detail page object
						$EditRow = $GLOBALS["teachers_levels_grid"]->GridUpdate();
					}
				}
				if ($EditRow) {
					if (in_array("teachers_packages", $DetailTblVar) && $GLOBALS["teachers_packages"]->DetailEdit) {
						if (!isset($GLOBALS["teachers_packages_grid"])) $GLOBALS["teachers_packages_grid"] = new cteachers_packages_grid(); // Get detail page object
						$EditRow = $GLOBALS["teachers_packages_grid"]->GridUpdate();
					}
				}
				if ($EditRow) {
					if (in_array("teachers_topics", $DetailTblVar) && $GLOBALS["teachers_topics"]->DetailEdit) {
						if (!isset($GLOBALS["teachers_topics_grid"])) $GLOBALS["teachers_topics_grid"] = new cteachers_topics_grid(); // Get detail page object
						$EditRow = $GLOBALS["teachers_topics_grid"]->GridUpdate();
					}
				}
				if ($EditRow) {
					if (in_array("teachers_trains", $DetailTblVar) && $GLOBALS["teachers_trains"]->DetailEdit) {
						if (!isset($GLOBALS["teachers_trains_grid"])) $GLOBALS["teachers_trains_grid"] = new cteachers_trains_grid(); // Get detail page object
						$EditRow = $GLOBALS["teachers_trains_grid"]->GridUpdate();
					}
				}
				if ($EditRow) {
					if (in_array("orders", $DetailTblVar) && $GLOBALS["orders"]->DetailEdit) {
						if (!isset($GLOBALS["orders_grid"])) $GLOBALS["orders_grid"] = new corders_grid(); // Get detail page object
						$EditRow = $GLOBALS["orders_grid"]->GridUpdate();
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
			$this->setSessionWhere($this->GetDetailFilter());

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
			if (in_array("teachers_certificates", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_certificates_grid"]))
					$GLOBALS["teachers_certificates_grid"] = new cteachers_certificates_grid;
				if ($GLOBALS["teachers_certificates_grid"]->DetailEdit) {
					$GLOBALS["teachers_certificates_grid"]->CurrentMode = "edit";
					$GLOBALS["teachers_certificates_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["teachers_certificates_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_certificates_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_certificates_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_certificates_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_certificates_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_certificates_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("teachers_courses", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_courses_grid"]))
					$GLOBALS["teachers_courses_grid"] = new cteachers_courses_grid;
				if ($GLOBALS["teachers_courses_grid"]->DetailEdit) {
					$GLOBALS["teachers_courses_grid"]->CurrentMode = "edit";
					$GLOBALS["teachers_courses_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["teachers_courses_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_courses_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_courses_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_courses_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_courses_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_courses_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("teachers_experiences", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_experiences_grid"]))
					$GLOBALS["teachers_experiences_grid"] = new cteachers_experiences_grid;
				if ($GLOBALS["teachers_experiences_grid"]->DetailEdit) {
					$GLOBALS["teachers_experiences_grid"]->CurrentMode = "edit";
					$GLOBALS["teachers_experiences_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["teachers_experiences_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_experiences_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_experiences_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_experiences_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_experiences_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_experiences_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("teachers_levels", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_levels_grid"]))
					$GLOBALS["teachers_levels_grid"] = new cteachers_levels_grid;
				if ($GLOBALS["teachers_levels_grid"]->DetailEdit) {
					$GLOBALS["teachers_levels_grid"]->CurrentMode = "edit";
					$GLOBALS["teachers_levels_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["teachers_levels_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_levels_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_levels_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_levels_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_levels_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_levels_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("teachers_packages", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_packages_grid"]))
					$GLOBALS["teachers_packages_grid"] = new cteachers_packages_grid;
				if ($GLOBALS["teachers_packages_grid"]->DetailEdit) {
					$GLOBALS["teachers_packages_grid"]->CurrentMode = "edit";
					$GLOBALS["teachers_packages_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["teachers_packages_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_packages_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_packages_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_packages_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_packages_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_packages_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("teachers_topics", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_topics_grid"]))
					$GLOBALS["teachers_topics_grid"] = new cteachers_topics_grid;
				if ($GLOBALS["teachers_topics_grid"]->DetailEdit) {
					$GLOBALS["teachers_topics_grid"]->CurrentMode = "edit";
					$GLOBALS["teachers_topics_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["teachers_topics_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_topics_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_topics_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_topics_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_topics_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_topics_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("teachers_trains", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_trains_grid"]))
					$GLOBALS["teachers_trains_grid"] = new cteachers_trains_grid;
				if ($GLOBALS["teachers_trains_grid"]->DetailEdit) {
					$GLOBALS["teachers_trains_grid"]->CurrentMode = "edit";
					$GLOBALS["teachers_trains_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["teachers_trains_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_trains_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_trains_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_trains_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_trains_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_trains_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("orders", $DetailTblVar)) {
				if (!isset($GLOBALS["orders_grid"]))
					$GLOBALS["orders_grid"] = new corders_grid;
				if ($GLOBALS["orders_grid"]->DetailEdit) {
					$GLOBALS["orders_grid"]->CurrentMode = "edit";
					$GLOBALS["orders_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["orders_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["orders_grid"]->setStartRecordNumber(1);
					$GLOBALS["orders_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["orders_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["orders_grid"]->teacher_id->setSessionValue($GLOBALS["orders_grid"]->teacher_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("teacherslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($teachers_edit)) $teachers_edit = new cteachers_edit();

// Page init
$teachers_edit->Page_Init();

// Page main
$teachers_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fteachersedit = new ew_Form("fteachersedit", "edit");

// Validate form
fteachersedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_user_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers->user_id->FldCaption(), $teachers->user_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_user_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers->user_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_allow_express");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers->allow_express->FldCaption(), $teachers->allow_express->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_allow_express");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers->allow_express->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fees");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers->fees->FldCaption(), $teachers->fees->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fees");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers->fees->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers->currency_id->FldCaption(), $teachers->currency_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers->currency_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers->created_at->FldCaption(), $teachers->created_at->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers->created_at->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_updated_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers->updated_at->FldErrMsg()) ?>");

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
fteachersedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachersedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $teachers_edit->ShowPageHeader(); ?>
<?php
$teachers_edit->ShowMessage();
?>
<?php if (!$teachers_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($teachers_edit->Pager)) $teachers_edit->Pager = new cPrevNextPager($teachers_edit->StartRec, $teachers_edit->DisplayRecs, $teachers_edit->TotalRecs, $teachers_edit->AutoHidePager) ?>
<?php if ($teachers_edit->Pager->RecordCount > 0 && $teachers_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($teachers_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $teachers_edit->PageUrl() ?>start=<?php echo $teachers_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($teachers_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $teachers_edit->PageUrl() ?>start=<?php echo $teachers_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $teachers_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($teachers_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $teachers_edit->PageUrl() ?>start=<?php echo $teachers_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($teachers_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $teachers_edit->PageUrl() ?>start=<?php echo $teachers_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $teachers_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fteachersedit" id="fteachersedit" class="<?php echo $teachers_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($teachers_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $teachers_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="teachers">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($teachers_edit->IsModal) ?>">
<?php if ($teachers->getCurrentMasterTable() == "users") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="users">
<input type="hidden" name="fk_id" value="<?php echo $teachers->user_id->getSessionValue() ?>">
<?php } ?>
<div class="ewEditDiv"><!-- page* -->
<?php if ($teachers->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_teachers_id" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->id->FldCaption() ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->id->CellAttributes() ?>>
<span id="el_teachers_id">
<span<?php echo $teachers->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="teachers" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($teachers->id->CurrentValue) ?>">
<?php echo $teachers->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->user_id->Visible) { // user_id ?>
	<div id="r_user_id" class="form-group">
		<label id="elh_teachers_user_id" for="x_user_id" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->user_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->user_id->CellAttributes() ?>>
<?php if ($teachers->user_id->getSessionValue() <> "") { ?>
<span id="el_teachers_user_id">
<span<?php echo $teachers->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_user_id" name="x_user_id" value="<?php echo ew_HtmlEncode($teachers->user_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_teachers_user_id">
<input type="text" data-table="teachers" data-field="x_user_id" name="x_user_id" id="x_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->user_id->getPlaceHolder()) ?>" value="<?php echo $teachers->user_id->EditValue ?>"<?php echo $teachers->user_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $teachers->user_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->timezone->Visible) { // timezone ?>
	<div id="r_timezone" class="form-group">
		<label id="elh_teachers_timezone" for="x_timezone" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->timezone->FldCaption() ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->timezone->CellAttributes() ?>>
<span id="el_teachers_timezone">
<textarea data-table="teachers" data-field="x_timezone" name="x_timezone" id="x_timezone" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->timezone->getPlaceHolder()) ?>"<?php echo $teachers->timezone->EditAttributes() ?>><?php echo $teachers->timezone->EditValue ?></textarea>
</span>
<?php echo $teachers->timezone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->teacher_language->Visible) { // teacher_language ?>
	<div id="r_teacher_language" class="form-group">
		<label id="elh_teachers_teacher_language" for="x_teacher_language" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->teacher_language->FldCaption() ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->teacher_language->CellAttributes() ?>>
<span id="el_teachers_teacher_language">
<textarea data-table="teachers" data-field="x_teacher_language" name="x_teacher_language" id="x_teacher_language" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->teacher_language->getPlaceHolder()) ?>"<?php echo $teachers->teacher_language->EditAttributes() ?>><?php echo $teachers->teacher_language->EditValue ?></textarea>
</span>
<?php echo $teachers->teacher_language->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->video->Visible) { // video ?>
	<div id="r_video" class="form-group">
		<label id="elh_teachers_video" for="x_video" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->video->FldCaption() ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->video->CellAttributes() ?>>
<span id="el_teachers_video">
<textarea data-table="teachers" data-field="x_video" name="x_video" id="x_video" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->video->getPlaceHolder()) ?>"<?php echo $teachers->video->EditAttributes() ?>><?php echo $teachers->video->EditValue ?></textarea>
</span>
<?php echo $teachers->video->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->heading_ar->Visible) { // heading_ar ?>
	<div id="r_heading_ar" class="form-group">
		<label id="elh_teachers_heading_ar" for="x_heading_ar" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->heading_ar->FldCaption() ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->heading_ar->CellAttributes() ?>>
<span id="el_teachers_heading_ar">
<textarea data-table="teachers" data-field="x_heading_ar" name="x_heading_ar" id="x_heading_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->heading_ar->getPlaceHolder()) ?>"<?php echo $teachers->heading_ar->EditAttributes() ?>><?php echo $teachers->heading_ar->EditValue ?></textarea>
</span>
<?php echo $teachers->heading_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->description_ar->Visible) { // description_ar ?>
	<div id="r_description_ar" class="form-group">
		<label id="elh_teachers_description_ar" for="x_description_ar" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->description_ar->FldCaption() ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->description_ar->CellAttributes() ?>>
<span id="el_teachers_description_ar">
<textarea data-table="teachers" data-field="x_description_ar" name="x_description_ar" id="x_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->description_ar->getPlaceHolder()) ?>"<?php echo $teachers->description_ar->EditAttributes() ?>><?php echo $teachers->description_ar->EditValue ?></textarea>
</span>
<?php echo $teachers->description_ar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->heading_en->Visible) { // heading_en ?>
	<div id="r_heading_en" class="form-group">
		<label id="elh_teachers_heading_en" for="x_heading_en" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->heading_en->FldCaption() ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->heading_en->CellAttributes() ?>>
<span id="el_teachers_heading_en">
<textarea data-table="teachers" data-field="x_heading_en" name="x_heading_en" id="x_heading_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->heading_en->getPlaceHolder()) ?>"<?php echo $teachers->heading_en->EditAttributes() ?>><?php echo $teachers->heading_en->EditValue ?></textarea>
</span>
<?php echo $teachers->heading_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->description_en->Visible) { // description_en ?>
	<div id="r_description_en" class="form-group">
		<label id="elh_teachers_description_en" for="x_description_en" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->description_en->FldCaption() ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->description_en->CellAttributes() ?>>
<span id="el_teachers_description_en">
<textarea data-table="teachers" data-field="x_description_en" name="x_description_en" id="x_description_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers->description_en->getPlaceHolder()) ?>"<?php echo $teachers->description_en->EditAttributes() ?>><?php echo $teachers->description_en->EditValue ?></textarea>
</span>
<?php echo $teachers->description_en->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->allow_express->Visible) { // allow_express ?>
	<div id="r_allow_express" class="form-group">
		<label id="elh_teachers_allow_express" for="x_allow_express" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->allow_express->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->allow_express->CellAttributes() ?>>
<span id="el_teachers_allow_express">
<input type="text" data-table="teachers" data-field="x_allow_express" name="x_allow_express" id="x_allow_express" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->allow_express->getPlaceHolder()) ?>" value="<?php echo $teachers->allow_express->EditValue ?>"<?php echo $teachers->allow_express->EditAttributes() ?>>
</span>
<?php echo $teachers->allow_express->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->fees->Visible) { // fees ?>
	<div id="r_fees" class="form-group">
		<label id="elh_teachers_fees" for="x_fees" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->fees->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->fees->CellAttributes() ?>>
<span id="el_teachers_fees">
<input type="text" data-table="teachers" data-field="x_fees" name="x_fees" id="x_fees" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->fees->getPlaceHolder()) ?>" value="<?php echo $teachers->fees->EditValue ?>"<?php echo $teachers->fees->EditAttributes() ?>>
</span>
<?php echo $teachers->fees->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->currency_id->Visible) { // currency_id ?>
	<div id="r_currency_id" class="form-group">
		<label id="elh_teachers_currency_id" for="x_currency_id" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->currency_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->currency_id->CellAttributes() ?>>
<span id="el_teachers_currency_id">
<input type="text" data-table="teachers" data-field="x_currency_id" name="x_currency_id" id="x_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers->currency_id->getPlaceHolder()) ?>" value="<?php echo $teachers->currency_id->EditValue ?>"<?php echo $teachers->currency_id->EditAttributes() ?>>
</span>
<?php echo $teachers->currency_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->created_at->Visible) { // created_at ?>
	<div id="r_created_at" class="form-group">
		<label id="elh_teachers_created_at" for="x_created_at" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->created_at->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->created_at->CellAttributes() ?>>
<span id="el_teachers_created_at">
<input type="text" data-table="teachers" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?php echo ew_HtmlEncode($teachers->created_at->getPlaceHolder()) ?>" value="<?php echo $teachers->created_at->EditValue ?>"<?php echo $teachers->created_at->EditAttributes() ?>>
</span>
<?php echo $teachers->created_at->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($teachers->updated_at->Visible) { // updated_at ?>
	<div id="r_updated_at" class="form-group">
		<label id="elh_teachers_updated_at" for="x_updated_at" class="<?php echo $teachers_edit->LeftColumnClass ?>"><?php echo $teachers->updated_at->FldCaption() ?></label>
		<div class="<?php echo $teachers_edit->RightColumnClass ?>"><div<?php echo $teachers->updated_at->CellAttributes() ?>>
<span id="el_teachers_updated_at">
<input type="text" data-table="teachers" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?php echo ew_HtmlEncode($teachers->updated_at->getPlaceHolder()) ?>" value="<?php echo $teachers->updated_at->EditValue ?>"<?php echo $teachers->updated_at->EditAttributes() ?>>
</span>
<?php echo $teachers->updated_at->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("teachers_certificates", explode(",", $teachers->getCurrentDetailTable())) && $teachers_certificates->DetailEdit) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_certificates", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_certificatesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("teachers_courses", explode(",", $teachers->getCurrentDetailTable())) && $teachers_courses->DetailEdit) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_courses", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_coursesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("teachers_experiences", explode(",", $teachers->getCurrentDetailTable())) && $teachers_experiences->DetailEdit) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_experiences", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_experiencesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("teachers_levels", explode(",", $teachers->getCurrentDetailTable())) && $teachers_levels->DetailEdit) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_levels", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_levelsgrid.php" ?>
<?php } ?>
<?php
	if (in_array("teachers_packages", explode(",", $teachers->getCurrentDetailTable())) && $teachers_packages->DetailEdit) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_packages", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_packagesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("teachers_topics", explode(",", $teachers->getCurrentDetailTable())) && $teachers_topics->DetailEdit) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_topics", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_topicsgrid.php" ?>
<?php } ?>
<?php
	if (in_array("teachers_trains", explode(",", $teachers->getCurrentDetailTable())) && $teachers_trains->DetailEdit) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_trains", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_trainsgrid.php" ?>
<?php } ?>
<?php
	if (in_array("orders", explode(",", $teachers->getCurrentDetailTable())) && $orders->DetailEdit) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("orders", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ordersgrid.php" ?>
<?php } ?>
<?php if (!$teachers_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $teachers_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $teachers_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$teachers_edit->IsModal) { ?>
<?php if (!isset($teachers_edit->Pager)) $teachers_edit->Pager = new cPrevNextPager($teachers_edit->StartRec, $teachers_edit->DisplayRecs, $teachers_edit->TotalRecs, $teachers_edit->AutoHidePager) ?>
<?php if ($teachers_edit->Pager->RecordCount > 0 && $teachers_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($teachers_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $teachers_edit->PageUrl() ?>start=<?php echo $teachers_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($teachers_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $teachers_edit->PageUrl() ?>start=<?php echo $teachers_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $teachers_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($teachers_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $teachers_edit->PageUrl() ?>start=<?php echo $teachers_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($teachers_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $teachers_edit->PageUrl() ?>start=<?php echo $teachers_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $teachers_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fteachersedit.Init();
</script>
<?php
$teachers_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$teachers_edit->Page_Terminate();
?>
