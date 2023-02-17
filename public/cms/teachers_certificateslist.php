<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "teachers_certificatesinfo.php" ?>
<?php include_once "teachersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$teachers_certificates_list = NULL; // Initialize page object first

class cteachers_certificates_list extends cteachers_certificates {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'teachers_certificates';

	// Page object name
	var $PageObjName = 'teachers_certificates_list';

	// Grid form hidden field names
	var $FormName = 'fteachers_certificateslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (teachers_certificates)
		if (!isset($GLOBALS["teachers_certificates"]) || get_class($GLOBALS["teachers_certificates"]) == "cteachers_certificates") {
			$GLOBALS["teachers_certificates"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["teachers_certificates"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "teachers_certificatesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "teachers_certificatesdelete.php";
		$this->MultiUpdateUrl = "teachers_certificatesupdate.php";

		// Table object (teachers)
		if (!isset($GLOBALS['teachers'])) $GLOBALS['teachers'] = new cteachers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'teachers_certificates', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fteachers_certificateslistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} elseif (@$_GET["cmd"] == "json") {
			$this->Export = $_GET["cmd"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->teacher_id->SetVisibility();
		$this->university->SetVisibility();
		$this->degree->SetVisibility();
		$this->image->SetVisibility();
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

		// Set up master detail parameters
		$this->SetupMasterParms();

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
		global $EW_EXPORT, $teachers_certificates;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($teachers_certificates);
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "teachers") {
			global $teachers;
			$rsmaster = $teachers->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("teacherslist.php"); // Return to master page
			} else {
				$teachers->LoadListRowValues($rsmaster);
				$teachers->RowType = EW_ROWTYPE_MASTER; // Master row
				$teachers->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array_keys($EW_EXPORT))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Exit inline mode
	function ClearInlineMode() {
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_teacher_id") && $objForm->HasValue("o_teacher_id") && $this->teacher_id->CurrentValue <> $this->teacher_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_university") && $objForm->HasValue("o_university") && $this->university->CurrentValue <> $this->university->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_degree") && $objForm->HasValue("o_degree") && $this->degree->CurrentValue <> $this->degree->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_image") && $objForm->HasValue("o_image") && $this->image->CurrentValue <> $this->image->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_from_date") && $objForm->HasValue("o_from_date") && $this->from_date->CurrentValue <> $this->from_date->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_to_date") && $objForm->HasValue("o_to_date") && $this->to_date->CurrentValue <> $this->to_date->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->teacher_id->AdvancedSearch->ToJson(), ","); // Field teacher_id
		$sFilterList = ew_Concat($sFilterList, $this->university->AdvancedSearch->ToJson(), ","); // Field university
		$sFilterList = ew_Concat($sFilterList, $this->degree->AdvancedSearch->ToJson(), ","); // Field degree
		$sFilterList = ew_Concat($sFilterList, $this->image->AdvancedSearch->ToJson(), ","); // Field image
		$sFilterList = ew_Concat($sFilterList, $this->from_date->AdvancedSearch->ToJson(), ","); // Field from_date
		$sFilterList = ew_Concat($sFilterList, $this->to_date->AdvancedSearch->ToJson(), ","); // Field to_date
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "fteachers_certificateslistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();

		// Field teacher_id
		$this->teacher_id->AdvancedSearch->SearchValue = @$filter["x_teacher_id"];
		$this->teacher_id->AdvancedSearch->SearchOperator = @$filter["z_teacher_id"];
		$this->teacher_id->AdvancedSearch->SearchCondition = @$filter["v_teacher_id"];
		$this->teacher_id->AdvancedSearch->SearchValue2 = @$filter["y_teacher_id"];
		$this->teacher_id->AdvancedSearch->SearchOperator2 = @$filter["w_teacher_id"];
		$this->teacher_id->AdvancedSearch->Save();

		// Field university
		$this->university->AdvancedSearch->SearchValue = @$filter["x_university"];
		$this->university->AdvancedSearch->SearchOperator = @$filter["z_university"];
		$this->university->AdvancedSearch->SearchCondition = @$filter["v_university"];
		$this->university->AdvancedSearch->SearchValue2 = @$filter["y_university"];
		$this->university->AdvancedSearch->SearchOperator2 = @$filter["w_university"];
		$this->university->AdvancedSearch->Save();

		// Field degree
		$this->degree->AdvancedSearch->SearchValue = @$filter["x_degree"];
		$this->degree->AdvancedSearch->SearchOperator = @$filter["z_degree"];
		$this->degree->AdvancedSearch->SearchCondition = @$filter["v_degree"];
		$this->degree->AdvancedSearch->SearchValue2 = @$filter["y_degree"];
		$this->degree->AdvancedSearch->SearchOperator2 = @$filter["w_degree"];
		$this->degree->AdvancedSearch->Save();

		// Field image
		$this->image->AdvancedSearch->SearchValue = @$filter["x_image"];
		$this->image->AdvancedSearch->SearchOperator = @$filter["z_image"];
		$this->image->AdvancedSearch->SearchCondition = @$filter["v_image"];
		$this->image->AdvancedSearch->SearchValue2 = @$filter["y_image"];
		$this->image->AdvancedSearch->SearchOperator2 = @$filter["w_image"];
		$this->image->AdvancedSearch->Save();

		// Field from_date
		$this->from_date->AdvancedSearch->SearchValue = @$filter["x_from_date"];
		$this->from_date->AdvancedSearch->SearchOperator = @$filter["z_from_date"];
		$this->from_date->AdvancedSearch->SearchCondition = @$filter["v_from_date"];
		$this->from_date->AdvancedSearch->SearchValue2 = @$filter["y_from_date"];
		$this->from_date->AdvancedSearch->SearchOperator2 = @$filter["w_from_date"];
		$this->from_date->AdvancedSearch->Save();

		// Field to_date
		$this->to_date->AdvancedSearch->SearchValue = @$filter["x_to_date"];
		$this->to_date->AdvancedSearch->SearchOperator = @$filter["z_to_date"];
		$this->to_date->AdvancedSearch->SearchCondition = @$filter["v_to_date"];
		$this->to_date->AdvancedSearch->SearchValue2 = @$filter["y_to_date"];
		$this->to_date->AdvancedSearch->SearchOperator2 = @$filter["w_to_date"];
		$this->to_date->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->university, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->degree, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->image, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id); // id
			$this->UpdateSort($this->teacher_id); // teacher_id
			$this->UpdateSort($this->university); // university
			$this->UpdateSort($this->degree); // degree
			$this->UpdateSort($this->image); // image
			$this->UpdateSort($this->from_date); // from_date
			$this->UpdateSort($this->to_date); // to_date
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->teacher_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id->setSort("");
				$this->teacher_id->setSort("");
				$this->university->setSort("");
				$this->degree->setSort("");
				$this->image->setSort("");
				$this->from_date->setSort("");
				$this->to_date->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = FALSE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
			}
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->IsLoggedIn());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->IsLoggedIn());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->IsLoggedIn());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fteachers_certificateslist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->IsLoggedIn());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fteachers_certificateslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fteachers_certificateslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fteachers_certificateslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->IsLoggedIn();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->IsLoggedIn();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
		}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fteachers_certificateslistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load default values
	function LoadDefaultValues() {
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->teacher_id->CurrentValue = NULL;
		$this->teacher_id->OldValue = $this->teacher_id->CurrentValue;
		$this->university->CurrentValue = NULL;
		$this->university->OldValue = $this->university->CurrentValue;
		$this->degree->CurrentValue = NULL;
		$this->degree->OldValue = $this->degree->CurrentValue;
		$this->image->CurrentValue = NULL;
		$this->image->OldValue = $this->image->CurrentValue;
		$this->from_date->CurrentValue = NULL;
		$this->from_date->OldValue = $this->from_date->CurrentValue;
		$this->to_date->CurrentValue = NULL;
		$this->to_date->OldValue = $this->to_date->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->teacher_id->FldIsDetailKey) {
			$this->teacher_id->setFormValue($objForm->GetValue("x_teacher_id"));
		}
		$this->teacher_id->setOldValue($objForm->GetValue("o_teacher_id"));
		if (!$this->university->FldIsDetailKey) {
			$this->university->setFormValue($objForm->GetValue("x_university"));
		}
		$this->university->setOldValue($objForm->GetValue("o_university"));
		if (!$this->degree->FldIsDetailKey) {
			$this->degree->setFormValue($objForm->GetValue("x_degree"));
		}
		$this->degree->setOldValue($objForm->GetValue("o_degree"));
		if (!$this->image->FldIsDetailKey) {
			$this->image->setFormValue($objForm->GetValue("x_image"));
		}
		$this->image->setOldValue($objForm->GetValue("o_image"));
		if (!$this->from_date->FldIsDetailKey) {
			$this->from_date->setFormValue($objForm->GetValue("x_from_date"));
			$this->from_date->CurrentValue = ew_UnFormatDateTime($this->from_date->CurrentValue, 0);
		}
		$this->from_date->setOldValue($objForm->GetValue("o_from_date"));
		if (!$this->to_date->FldIsDetailKey) {
			$this->to_date->setFormValue($objForm->GetValue("x_to_date"));
			$this->to_date->CurrentValue = ew_UnFormatDateTime($this->to_date->CurrentValue, 0);
		}
		$this->to_date->setOldValue($objForm->GetValue("o_to_date"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->teacher_id->CurrentValue = $this->teacher_id->FormValue;
		$this->university->CurrentValue = $this->university->FormValue;
		$this->degree->CurrentValue = $this->degree->FormValue;
		$this->image->CurrentValue = $this->image->FormValue;
		$this->from_date->CurrentValue = $this->from_date->FormValue;
		$this->from_date->CurrentValue = ew_UnFormatDateTime($this->from_date->CurrentValue, 0);
		$this->to_date->CurrentValue = $this->to_date->FormValue;
		$this->to_date->CurrentValue = ew_UnFormatDateTime($this->to_date->CurrentValue, 0);
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
		$this->teacher_id->setDbValue($row['teacher_id']);
		$this->university->setDbValue($row['university']);
		$this->degree->setDbValue($row['degree']);
		$this->image->setDbValue($row['image']);
		$this->from_date->setDbValue($row['from_date']);
		$this->to_date->setDbValue($row['to_date']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['teacher_id'] = $this->teacher_id->CurrentValue;
		$row['university'] = $this->university->CurrentValue;
		$row['degree'] = $this->degree->CurrentValue;
		$row['image'] = $this->image->CurrentValue;
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
		$this->university->DbValue = $row['university'];
		$this->degree->DbValue = $row['degree'];
		$this->image->DbValue = $row['image'];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// teacher_id
		// university
		// degree
		// image
		// from_date
		// to_date

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// teacher_id
		$this->teacher_id->ViewValue = $this->teacher_id->CurrentValue;
		$this->teacher_id->ViewCustomAttributes = "";

		// university
		$this->university->ViewValue = $this->university->CurrentValue;
		$this->university->ViewCustomAttributes = "";

		// degree
		$this->degree->ViewValue = $this->degree->CurrentValue;
		$this->degree->ViewCustomAttributes = "";

		// image
		$this->image->ViewValue = $this->image->CurrentValue;
		$this->image->ViewCustomAttributes = "";

		// from_date
		$this->from_date->ViewValue = $this->from_date->CurrentValue;
		$this->from_date->ViewValue = ew_FormatDateTime($this->from_date->ViewValue, 0);
		$this->from_date->ViewCustomAttributes = "";

		// to_date
		$this->to_date->ViewValue = $this->to_date->CurrentValue;
		$this->to_date->ViewValue = ew_FormatDateTime($this->to_date->ViewValue, 0);
		$this->to_date->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// teacher_id
			$this->teacher_id->LinkCustomAttributes = "";
			$this->teacher_id->HrefValue = "";
			$this->teacher_id->TooltipValue = "";

			// university
			$this->university->LinkCustomAttributes = "";
			$this->university->HrefValue = "";
			$this->university->TooltipValue = "";

			// degree
			$this->degree->LinkCustomAttributes = "";
			$this->degree->HrefValue = "";
			$this->degree->TooltipValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";
			$this->image->TooltipValue = "";

			// from_date
			$this->from_date->LinkCustomAttributes = "";
			$this->from_date->HrefValue = "";
			$this->from_date->TooltipValue = "";

			// to_date
			$this->to_date->LinkCustomAttributes = "";
			$this->to_date->HrefValue = "";
			$this->to_date->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id
			// teacher_id

			$this->teacher_id->EditAttrs["class"] = "form-control";
			$this->teacher_id->EditCustomAttributes = "";
			if ($this->teacher_id->getSessionValue() <> "") {
				$this->teacher_id->CurrentValue = $this->teacher_id->getSessionValue();
				$this->teacher_id->OldValue = $this->teacher_id->CurrentValue;
			$this->teacher_id->ViewValue = $this->teacher_id->CurrentValue;
			$this->teacher_id->ViewCustomAttributes = "";
			} else {
			$this->teacher_id->EditValue = ew_HtmlEncode($this->teacher_id->CurrentValue);
			$this->teacher_id->PlaceHolder = ew_RemoveHtml($this->teacher_id->FldCaption());
			}

			// university
			$this->university->EditAttrs["class"] = "form-control";
			$this->university->EditCustomAttributes = "";
			$this->university->EditValue = ew_HtmlEncode($this->university->CurrentValue);
			$this->university->PlaceHolder = ew_RemoveHtml($this->university->FldCaption());

			// degree
			$this->degree->EditAttrs["class"] = "form-control";
			$this->degree->EditCustomAttributes = "";
			$this->degree->EditValue = ew_HtmlEncode($this->degree->CurrentValue);
			$this->degree->PlaceHolder = ew_RemoveHtml($this->degree->FldCaption());

			// image
			$this->image->EditAttrs["class"] = "form-control";
			$this->image->EditCustomAttributes = "";
			$this->image->EditValue = ew_HtmlEncode($this->image->CurrentValue);
			$this->image->PlaceHolder = ew_RemoveHtml($this->image->FldCaption());

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
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// teacher_id
			$this->teacher_id->LinkCustomAttributes = "";
			$this->teacher_id->HrefValue = "";

			// university
			$this->university->LinkCustomAttributes = "";
			$this->university->HrefValue = "";

			// degree
			$this->degree->LinkCustomAttributes = "";
			$this->degree->HrefValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";

			// from_date
			$this->from_date->LinkCustomAttributes = "";
			$this->from_date->HrefValue = "";

			// to_date
			$this->to_date->LinkCustomAttributes = "";
			$this->to_date->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// teacher_id
			$this->teacher_id->EditAttrs["class"] = "form-control";
			$this->teacher_id->EditCustomAttributes = "";
			if ($this->teacher_id->getSessionValue() <> "") {
				$this->teacher_id->CurrentValue = $this->teacher_id->getSessionValue();
				$this->teacher_id->OldValue = $this->teacher_id->CurrentValue;
			$this->teacher_id->ViewValue = $this->teacher_id->CurrentValue;
			$this->teacher_id->ViewCustomAttributes = "";
			} else {
			$this->teacher_id->EditValue = ew_HtmlEncode($this->teacher_id->CurrentValue);
			$this->teacher_id->PlaceHolder = ew_RemoveHtml($this->teacher_id->FldCaption());
			}

			// university
			$this->university->EditAttrs["class"] = "form-control";
			$this->university->EditCustomAttributes = "";
			$this->university->EditValue = ew_HtmlEncode($this->university->CurrentValue);
			$this->university->PlaceHolder = ew_RemoveHtml($this->university->FldCaption());

			// degree
			$this->degree->EditAttrs["class"] = "form-control";
			$this->degree->EditCustomAttributes = "";
			$this->degree->EditValue = ew_HtmlEncode($this->degree->CurrentValue);
			$this->degree->PlaceHolder = ew_RemoveHtml($this->degree->FldCaption());

			// image
			$this->image->EditAttrs["class"] = "form-control";
			$this->image->EditCustomAttributes = "";
			$this->image->EditValue = ew_HtmlEncode($this->image->CurrentValue);
			$this->image->PlaceHolder = ew_RemoveHtml($this->image->FldCaption());

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

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// teacher_id
			$this->teacher_id->LinkCustomAttributes = "";
			$this->teacher_id->HrefValue = "";

			// university
			$this->university->LinkCustomAttributes = "";
			$this->university->HrefValue = "";

			// degree
			$this->degree->LinkCustomAttributes = "";
			$this->degree->HrefValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";

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
		if (!$this->university->FldIsDetailKey && !is_null($this->university->FormValue) && $this->university->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->university->FldCaption(), $this->university->ReqErrMsg));
		}
		if (!$this->degree->FldIsDetailKey && !is_null($this->degree->FormValue) && $this->degree->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->degree->FldCaption(), $this->degree->ReqErrMsg));
		}
		if (!$this->image->FldIsDetailKey && !is_null($this->image->FormValue) && $this->image->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->image->FldCaption(), $this->image->ReqErrMsg));
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
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

			// teacher_id
			$this->teacher_id->SetDbValueDef($rsnew, $this->teacher_id->CurrentValue, 0, $this->teacher_id->ReadOnly);

			// university
			$this->university->SetDbValueDef($rsnew, $this->university->CurrentValue, "", $this->university->ReadOnly);

			// degree
			$this->degree->SetDbValueDef($rsnew, $this->degree->CurrentValue, "", $this->degree->ReadOnly);

			// image
			$this->image->SetDbValueDef($rsnew, $this->image->CurrentValue, "", $this->image->ReadOnly);

			// from_date
			$this->from_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->from_date->CurrentValue, 0), ew_CurrentDate(), $this->from_date->ReadOnly);

			// to_date
			$this->to_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->to_date->CurrentValue, 0), ew_CurrentDate(), $this->to_date->ReadOnly);

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

		// university
		$this->university->SetDbValueDef($rsnew, $this->university->CurrentValue, "", FALSE);

		// degree
		$this->degree->SetDbValueDef($rsnew, $this->degree->CurrentValue, "", FALSE);

		// image
		$this->image->SetDbValueDef($rsnew, $this->image->CurrentValue, "", FALSE);

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

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_teachers_certificates\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_teachers_certificates',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fteachers_certificateslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = FALSE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->ListRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetupStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "teachers") {
			global $teachers;
			if (!isset($teachers)) $teachers = new cteachers;
			$rsmaster = $teachers->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$teachers;
					$teachers->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
					$Doc->Table = &$this;
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
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

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($teachers_certificates_list)) $teachers_certificates_list = new cteachers_certificates_list();

// Page init
$teachers_certificates_list->Page_Init();

// Page main
$teachers_certificates_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_certificates_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($teachers_certificates->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fteachers_certificateslist = new ew_Form("fteachers_certificateslist", "list");
fteachers_certificateslist.FormKeyCountName = '<?php echo $teachers_certificates_list->FormKeyCountName ?>';

// Validate form
fteachers_certificateslist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_certificates->teacher_id->FldCaption(), $teachers_certificates->teacher_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_certificates->teacher_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_university");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_certificates->university->FldCaption(), $teachers_certificates->university->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_degree");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_certificates->degree->FldCaption(), $teachers_certificates->degree->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_image");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_certificates->image->FldCaption(), $teachers_certificates->image->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_from_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_certificates->from_date->FldCaption(), $teachers_certificates->from_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_from_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_certificates->from_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_to_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_certificates->to_date->FldCaption(), $teachers_certificates->to_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_to_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_certificates->to_date->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fteachers_certificateslist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "teacher_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "university", false)) return false;
	if (ew_ValueChanged(fobj, infix, "degree", false)) return false;
	if (ew_ValueChanged(fobj, infix, "image", false)) return false;
	if (ew_ValueChanged(fobj, infix, "from_date", false)) return false;
	if (ew_ValueChanged(fobj, infix, "to_date", false)) return false;
	return true;
}

// Form_CustomValidate event
fteachers_certificateslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachers_certificateslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fteachers_certificateslistsrch = new ew_Form("fteachers_certificateslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($teachers_certificates->Export == "") { ?>
<div class="ewToolbar">
<?php if ($teachers_certificates_list->TotalRecs > 0 && $teachers_certificates_list->ExportOptions->Visible()) { ?>
<?php $teachers_certificates_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($teachers_certificates_list->SearchOptions->Visible()) { ?>
<?php $teachers_certificates_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($teachers_certificates_list->FilterOptions->Visible()) { ?>
<?php $teachers_certificates_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($teachers_certificates->Export == "") || (EW_EXPORT_MASTER_RECORD && $teachers_certificates->Export == "print")) { ?>
<?php
if ($teachers_certificates_list->DbMasterFilter <> "" && $teachers_certificates->getCurrentMasterTable() == "teachers") {
	if ($teachers_certificates_list->MasterRecordExists) {
?>
<?php include_once "teachersmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($teachers_certificates->CurrentAction == "gridadd") {
	$teachers_certificates->CurrentFilter = "0=1";
	$teachers_certificates_list->StartRec = 1;
	$teachers_certificates_list->DisplayRecs = $teachers_certificates->GridAddRowCount;
	$teachers_certificates_list->TotalRecs = $teachers_certificates_list->DisplayRecs;
	$teachers_certificates_list->StopRec = $teachers_certificates_list->DisplayRecs;
} else {
	$bSelectLimit = $teachers_certificates_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($teachers_certificates_list->TotalRecs <= 0)
			$teachers_certificates_list->TotalRecs = $teachers_certificates->ListRecordCount();
	} else {
		if (!$teachers_certificates_list->Recordset && ($teachers_certificates_list->Recordset = $teachers_certificates_list->LoadRecordset()))
			$teachers_certificates_list->TotalRecs = $teachers_certificates_list->Recordset->RecordCount();
	}
	$teachers_certificates_list->StartRec = 1;
	if ($teachers_certificates_list->DisplayRecs <= 0 || ($teachers_certificates->Export <> "" && $teachers_certificates->ExportAll)) // Display all records
		$teachers_certificates_list->DisplayRecs = $teachers_certificates_list->TotalRecs;
	if (!($teachers_certificates->Export <> "" && $teachers_certificates->ExportAll))
		$teachers_certificates_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$teachers_certificates_list->Recordset = $teachers_certificates_list->LoadRecordset($teachers_certificates_list->StartRec-1, $teachers_certificates_list->DisplayRecs);

	// Set no record found message
	if ($teachers_certificates->CurrentAction == "" && $teachers_certificates_list->TotalRecs == 0) {
		if ($teachers_certificates_list->SearchWhere == "0=101")
			$teachers_certificates_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$teachers_certificates_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$teachers_certificates_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($teachers_certificates->Export == "" && $teachers_certificates->CurrentAction == "") { ?>
<form name="fteachers_certificateslistsrch" id="fteachers_certificateslistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($teachers_certificates_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fteachers_certificateslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="teachers_certificates">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($teachers_certificates_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($teachers_certificates_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $teachers_certificates_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($teachers_certificates_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($teachers_certificates_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($teachers_certificates_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($teachers_certificates_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $teachers_certificates_list->ShowPageHeader(); ?>
<?php
$teachers_certificates_list->ShowMessage();
?>
<?php if ($teachers_certificates_list->TotalRecs > 0 || $teachers_certificates->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($teachers_certificates_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> teachers_certificates">
<?php if ($teachers_certificates->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($teachers_certificates->CurrentAction <> "gridadd" && $teachers_certificates->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($teachers_certificates_list->Pager)) $teachers_certificates_list->Pager = new cPrevNextPager($teachers_certificates_list->StartRec, $teachers_certificates_list->DisplayRecs, $teachers_certificates_list->TotalRecs, $teachers_certificates_list->AutoHidePager) ?>
<?php if ($teachers_certificates_list->Pager->RecordCount > 0 && $teachers_certificates_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($teachers_certificates_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $teachers_certificates_list->PageUrl() ?>start=<?php echo $teachers_certificates_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($teachers_certificates_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $teachers_certificates_list->PageUrl() ?>start=<?php echo $teachers_certificates_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $teachers_certificates_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($teachers_certificates_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $teachers_certificates_list->PageUrl() ?>start=<?php echo $teachers_certificates_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($teachers_certificates_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $teachers_certificates_list->PageUrl() ?>start=<?php echo $teachers_certificates_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $teachers_certificates_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($teachers_certificates_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $teachers_certificates_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $teachers_certificates_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $teachers_certificates_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_certificates_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fteachers_certificateslist" id="fteachers_certificateslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($teachers_certificates_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $teachers_certificates_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="teachers_certificates">
<?php if ($teachers_certificates->getCurrentMasterTable() == "teachers" && $teachers_certificates->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="teachers">
<input type="hidden" name="fk_id" value="<?php echo $teachers_certificates->teacher_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_teachers_certificates" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($teachers_certificates_list->TotalRecs > 0 || $teachers_certificates->CurrentAction == "gridedit") { ?>
<table id="tbl_teachers_certificateslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$teachers_certificates_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$teachers_certificates_list->RenderListOptions();

// Render list options (header, left)
$teachers_certificates_list->ListOptions->Render("header", "left");
?>
<?php if ($teachers_certificates->id->Visible) { // id ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->id) == "") { ?>
		<th data-name="id" class="<?php echo $teachers_certificates->id->HeaderCellClass() ?>"><div id="elh_teachers_certificates_id" class="teachers_certificates_id"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $teachers_certificates->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_certificates->SortUrl($teachers_certificates->id) ?>',1);"><div id="elh_teachers_certificates_id" class="teachers_certificates_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->teacher_id->Visible) { // teacher_id ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->teacher_id) == "") { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_certificates->teacher_id->HeaderCellClass() ?>"><div id="elh_teachers_certificates_teacher_id" class="teachers_certificates_teacher_id"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->teacher_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_certificates->teacher_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_certificates->SortUrl($teachers_certificates->teacher_id) ?>',1);"><div id="elh_teachers_certificates_teacher_id" class="teachers_certificates_teacher_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->teacher_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->teacher_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->teacher_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->university->Visible) { // university ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->university) == "") { ?>
		<th data-name="university" class="<?php echo $teachers_certificates->university->HeaderCellClass() ?>"><div id="elh_teachers_certificates_university" class="teachers_certificates_university"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->university->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="university" class="<?php echo $teachers_certificates->university->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_certificates->SortUrl($teachers_certificates->university) ?>',1);"><div id="elh_teachers_certificates_university" class="teachers_certificates_university">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->university->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->university->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->university->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->degree->Visible) { // degree ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->degree) == "") { ?>
		<th data-name="degree" class="<?php echo $teachers_certificates->degree->HeaderCellClass() ?>"><div id="elh_teachers_certificates_degree" class="teachers_certificates_degree"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->degree->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="degree" class="<?php echo $teachers_certificates->degree->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_certificates->SortUrl($teachers_certificates->degree) ?>',1);"><div id="elh_teachers_certificates_degree" class="teachers_certificates_degree">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->degree->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->degree->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->degree->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->image->Visible) { // image ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->image) == "") { ?>
		<th data-name="image" class="<?php echo $teachers_certificates->image->HeaderCellClass() ?>"><div id="elh_teachers_certificates_image" class="teachers_certificates_image"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="image" class="<?php echo $teachers_certificates->image->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_certificates->SortUrl($teachers_certificates->image) ?>',1);"><div id="elh_teachers_certificates_image" class="teachers_certificates_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->image->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->from_date->Visible) { // from_date ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->from_date) == "") { ?>
		<th data-name="from_date" class="<?php echo $teachers_certificates->from_date->HeaderCellClass() ?>"><div id="elh_teachers_certificates_from_date" class="teachers_certificates_from_date"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->from_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="from_date" class="<?php echo $teachers_certificates->from_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_certificates->SortUrl($teachers_certificates->from_date) ?>',1);"><div id="elh_teachers_certificates_from_date" class="teachers_certificates_from_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->from_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->from_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->from_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->to_date->Visible) { // to_date ?>
	<?php if ($teachers_certificates->SortUrl($teachers_certificates->to_date) == "") { ?>
		<th data-name="to_date" class="<?php echo $teachers_certificates->to_date->HeaderCellClass() ?>"><div id="elh_teachers_certificates_to_date" class="teachers_certificates_to_date"><div class="ewTableHeaderCaption"><?php echo $teachers_certificates->to_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="to_date" class="<?php echo $teachers_certificates->to_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_certificates->SortUrl($teachers_certificates->to_date) ?>',1);"><div id="elh_teachers_certificates_to_date" class="teachers_certificates_to_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_certificates->to_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_certificates->to_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_certificates->to_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$teachers_certificates_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($teachers_certificates->ExportAll && $teachers_certificates->Export <> "") {
	$teachers_certificates_list->StopRec = $teachers_certificates_list->TotalRecs;
} else {

	// Set the last record to display
	if ($teachers_certificates_list->TotalRecs > $teachers_certificates_list->StartRec + $teachers_certificates_list->DisplayRecs - 1)
		$teachers_certificates_list->StopRec = $teachers_certificates_list->StartRec + $teachers_certificates_list->DisplayRecs - 1;
	else
		$teachers_certificates_list->StopRec = $teachers_certificates_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($teachers_certificates_list->FormKeyCountName) && ($teachers_certificates->CurrentAction == "gridadd" || $teachers_certificates->CurrentAction == "gridedit" || $teachers_certificates->CurrentAction == "F")) {
		$teachers_certificates_list->KeyCount = $objForm->GetValue($teachers_certificates_list->FormKeyCountName);
		$teachers_certificates_list->StopRec = $teachers_certificates_list->StartRec + $teachers_certificates_list->KeyCount - 1;
	}
}
$teachers_certificates_list->RecCnt = $teachers_certificates_list->StartRec - 1;
if ($teachers_certificates_list->Recordset && !$teachers_certificates_list->Recordset->EOF) {
	$teachers_certificates_list->Recordset->MoveFirst();
	$bSelectLimit = $teachers_certificates_list->UseSelectLimit;
	if (!$bSelectLimit && $teachers_certificates_list->StartRec > 1)
		$teachers_certificates_list->Recordset->Move($teachers_certificates_list->StartRec - 1);
} elseif (!$teachers_certificates->AllowAddDeleteRow && $teachers_certificates_list->StopRec == 0) {
	$teachers_certificates_list->StopRec = $teachers_certificates->GridAddRowCount;
}

// Initialize aggregate
$teachers_certificates->RowType = EW_ROWTYPE_AGGREGATEINIT;
$teachers_certificates->ResetAttrs();
$teachers_certificates_list->RenderRow();
if ($teachers_certificates->CurrentAction == "gridadd")
	$teachers_certificates_list->RowIndex = 0;
if ($teachers_certificates->CurrentAction == "gridedit")
	$teachers_certificates_list->RowIndex = 0;
while ($teachers_certificates_list->RecCnt < $teachers_certificates_list->StopRec) {
	$teachers_certificates_list->RecCnt++;
	if (intval($teachers_certificates_list->RecCnt) >= intval($teachers_certificates_list->StartRec)) {
		$teachers_certificates_list->RowCnt++;
		if ($teachers_certificates->CurrentAction == "gridadd" || $teachers_certificates->CurrentAction == "gridedit" || $teachers_certificates->CurrentAction == "F") {
			$teachers_certificates_list->RowIndex++;
			$objForm->Index = $teachers_certificates_list->RowIndex;
			if ($objForm->HasValue($teachers_certificates_list->FormActionName))
				$teachers_certificates_list->RowAction = strval($objForm->GetValue($teachers_certificates_list->FormActionName));
			elseif ($teachers_certificates->CurrentAction == "gridadd")
				$teachers_certificates_list->RowAction = "insert";
			else
				$teachers_certificates_list->RowAction = "";
		}

		// Set up key count
		$teachers_certificates_list->KeyCount = $teachers_certificates_list->RowIndex;

		// Init row class and style
		$teachers_certificates->ResetAttrs();
		$teachers_certificates->CssClass = "";
		if ($teachers_certificates->CurrentAction == "gridadd") {
			$teachers_certificates_list->LoadRowValues(); // Load default values
		} else {
			$teachers_certificates_list->LoadRowValues($teachers_certificates_list->Recordset); // Load row values
		}
		$teachers_certificates->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($teachers_certificates->CurrentAction == "gridadd") // Grid add
			$teachers_certificates->RowType = EW_ROWTYPE_ADD; // Render add
		if ($teachers_certificates->CurrentAction == "gridadd" && $teachers_certificates->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$teachers_certificates_list->RestoreCurrentRowFormValues($teachers_certificates_list->RowIndex); // Restore form values
		if ($teachers_certificates->CurrentAction == "gridedit") { // Grid edit
			if ($teachers_certificates->EventCancelled) {
				$teachers_certificates_list->RestoreCurrentRowFormValues($teachers_certificates_list->RowIndex); // Restore form values
			}
			if ($teachers_certificates_list->RowAction == "insert")
				$teachers_certificates->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$teachers_certificates->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($teachers_certificates->CurrentAction == "gridedit" && ($teachers_certificates->RowType == EW_ROWTYPE_EDIT || $teachers_certificates->RowType == EW_ROWTYPE_ADD) && $teachers_certificates->EventCancelled) // Update failed
			$teachers_certificates_list->RestoreCurrentRowFormValues($teachers_certificates_list->RowIndex); // Restore form values
		if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) // Edit row
			$teachers_certificates_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$teachers_certificates->RowAttrs = array_merge($teachers_certificates->RowAttrs, array('data-rowindex'=>$teachers_certificates_list->RowCnt, 'id'=>'r' . $teachers_certificates_list->RowCnt . '_teachers_certificates', 'data-rowtype'=>$teachers_certificates->RowType));

		// Render row
		$teachers_certificates_list->RenderRow();

		// Render list options
		$teachers_certificates_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($teachers_certificates_list->RowAction <> "delete" && $teachers_certificates_list->RowAction <> "insertdelete" && !($teachers_certificates_list->RowAction == "insert" && $teachers_certificates->CurrentAction == "F" && $teachers_certificates_list->EmptyRow())) {
?>
	<tr<?php echo $teachers_certificates->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_certificates_list->ListOptions->Render("body", "left", $teachers_certificates_list->RowCnt);
?>
	<?php if ($teachers_certificates->id->Visible) { // id ?>
		<td data-name="id"<?php echo $teachers_certificates->id->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_id" name="o<?php echo $teachers_certificates_list->RowIndex ?>_id" id="o<?php echo $teachers_certificates_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_certificates->id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_id" class="form-group teachers_certificates_id">
<span<?php echo $teachers_certificates->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_id" name="x<?php echo $teachers_certificates_list->RowIndex ?>_id" id="x<?php echo $teachers_certificates_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_certificates->id->CurrentValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_id" class="teachers_certificates_id">
<span<?php echo $teachers_certificates->id->ViewAttributes() ?>>
<?php echo $teachers_certificates->id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_certificates->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id"<?php echo $teachers_certificates->teacher_id->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($teachers_certificates->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<span<?php echo $teachers_certificates->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" name="x<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<input type="text" data-table="teachers_certificates" data-field="x_teacher_id" name="x<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" id="x<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->teacher_id->EditValue ?>"<?php echo $teachers_certificates->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_teacher_id" name="o<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" id="o<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($teachers_certificates->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<span<?php echo $teachers_certificates->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" name="x<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<input type="text" data-table="teachers_certificates" data-field="x_teacher_id" name="x<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" id="x<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->teacher_id->EditValue ?>"<?php echo $teachers_certificates->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_teacher_id" class="teachers_certificates_teacher_id">
<span<?php echo $teachers_certificates->teacher_id->ViewAttributes() ?>>
<?php echo $teachers_certificates->teacher_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_certificates->university->Visible) { // university ?>
		<td data-name="university"<?php echo $teachers_certificates->university->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_university" class="form-group teachers_certificates_university">
<textarea data-table="teachers_certificates" data-field="x_university" name="x<?php echo $teachers_certificates_list->RowIndex ?>_university" id="x<?php echo $teachers_certificates_list->RowIndex ?>_university" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->university->getPlaceHolder()) ?>"<?php echo $teachers_certificates->university->EditAttributes() ?>><?php echo $teachers_certificates->university->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_university" name="o<?php echo $teachers_certificates_list->RowIndex ?>_university" id="o<?php echo $teachers_certificates_list->RowIndex ?>_university" value="<?php echo ew_HtmlEncode($teachers_certificates->university->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_university" class="form-group teachers_certificates_university">
<textarea data-table="teachers_certificates" data-field="x_university" name="x<?php echo $teachers_certificates_list->RowIndex ?>_university" id="x<?php echo $teachers_certificates_list->RowIndex ?>_university" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->university->getPlaceHolder()) ?>"<?php echo $teachers_certificates->university->EditAttributes() ?>><?php echo $teachers_certificates->university->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_university" class="teachers_certificates_university">
<span<?php echo $teachers_certificates->university->ViewAttributes() ?>>
<?php echo $teachers_certificates->university->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_certificates->degree->Visible) { // degree ?>
		<td data-name="degree"<?php echo $teachers_certificates->degree->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_degree" class="form-group teachers_certificates_degree">
<textarea data-table="teachers_certificates" data-field="x_degree" name="x<?php echo $teachers_certificates_list->RowIndex ?>_degree" id="x<?php echo $teachers_certificates_list->RowIndex ?>_degree" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->degree->getPlaceHolder()) ?>"<?php echo $teachers_certificates->degree->EditAttributes() ?>><?php echo $teachers_certificates->degree->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_degree" name="o<?php echo $teachers_certificates_list->RowIndex ?>_degree" id="o<?php echo $teachers_certificates_list->RowIndex ?>_degree" value="<?php echo ew_HtmlEncode($teachers_certificates->degree->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_degree" class="form-group teachers_certificates_degree">
<textarea data-table="teachers_certificates" data-field="x_degree" name="x<?php echo $teachers_certificates_list->RowIndex ?>_degree" id="x<?php echo $teachers_certificates_list->RowIndex ?>_degree" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->degree->getPlaceHolder()) ?>"<?php echo $teachers_certificates->degree->EditAttributes() ?>><?php echo $teachers_certificates->degree->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_degree" class="teachers_certificates_degree">
<span<?php echo $teachers_certificates->degree->ViewAttributes() ?>>
<?php echo $teachers_certificates->degree->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_certificates->image->Visible) { // image ?>
		<td data-name="image"<?php echo $teachers_certificates->image->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_image" class="form-group teachers_certificates_image">
<textarea data-table="teachers_certificates" data-field="x_image" name="x<?php echo $teachers_certificates_list->RowIndex ?>_image" id="x<?php echo $teachers_certificates_list->RowIndex ?>_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->image->getPlaceHolder()) ?>"<?php echo $teachers_certificates->image->EditAttributes() ?>><?php echo $teachers_certificates->image->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_image" name="o<?php echo $teachers_certificates_list->RowIndex ?>_image" id="o<?php echo $teachers_certificates_list->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_certificates->image->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_image" class="form-group teachers_certificates_image">
<textarea data-table="teachers_certificates" data-field="x_image" name="x<?php echo $teachers_certificates_list->RowIndex ?>_image" id="x<?php echo $teachers_certificates_list->RowIndex ?>_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->image->getPlaceHolder()) ?>"<?php echo $teachers_certificates->image->EditAttributes() ?>><?php echo $teachers_certificates->image->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_image" class="teachers_certificates_image">
<span<?php echo $teachers_certificates->image->ViewAttributes() ?>>
<?php echo $teachers_certificates->image->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_certificates->from_date->Visible) { // from_date ?>
		<td data-name="from_date"<?php echo $teachers_certificates->from_date->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_from_date" class="form-group teachers_certificates_from_date">
<input type="text" data-table="teachers_certificates" data-field="x_from_date" name="x<?php echo $teachers_certificates_list->RowIndex ?>_from_date" id="x<?php echo $teachers_certificates_list->RowIndex ?>_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->from_date->EditValue ?>"<?php echo $teachers_certificates->from_date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_from_date" name="o<?php echo $teachers_certificates_list->RowIndex ?>_from_date" id="o<?php echo $teachers_certificates_list->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_certificates->from_date->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_from_date" class="form-group teachers_certificates_from_date">
<input type="text" data-table="teachers_certificates" data-field="x_from_date" name="x<?php echo $teachers_certificates_list->RowIndex ?>_from_date" id="x<?php echo $teachers_certificates_list->RowIndex ?>_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->from_date->EditValue ?>"<?php echo $teachers_certificates->from_date->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_from_date" class="teachers_certificates_from_date">
<span<?php echo $teachers_certificates->from_date->ViewAttributes() ?>>
<?php echo $teachers_certificates->from_date->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_certificates->to_date->Visible) { // to_date ?>
		<td data-name="to_date"<?php echo $teachers_certificates->to_date->CellAttributes() ?>>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_to_date" class="form-group teachers_certificates_to_date">
<input type="text" data-table="teachers_certificates" data-field="x_to_date" name="x<?php echo $teachers_certificates_list->RowIndex ?>_to_date" id="x<?php echo $teachers_certificates_list->RowIndex ?>_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->to_date->EditValue ?>"<?php echo $teachers_certificates->to_date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_to_date" name="o<?php echo $teachers_certificates_list->RowIndex ?>_to_date" id="o<?php echo $teachers_certificates_list->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_certificates->to_date->OldValue) ?>">
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_to_date" class="form-group teachers_certificates_to_date">
<input type="text" data-table="teachers_certificates" data-field="x_to_date" name="x<?php echo $teachers_certificates_list->RowIndex ?>_to_date" id="x<?php echo $teachers_certificates_list->RowIndex ?>_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->to_date->EditValue ?>"<?php echo $teachers_certificates->to_date->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_certificates_list->RowCnt ?>_teachers_certificates_to_date" class="teachers_certificates_to_date">
<span<?php echo $teachers_certificates->to_date->ViewAttributes() ?>>
<?php echo $teachers_certificates->to_date->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_certificates_list->ListOptions->Render("body", "right", $teachers_certificates_list->RowCnt);
?>
	</tr>
<?php if ($teachers_certificates->RowType == EW_ROWTYPE_ADD || $teachers_certificates->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fteachers_certificateslist.UpdateOpts(<?php echo $teachers_certificates_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($teachers_certificates->CurrentAction <> "gridadd")
		if (!$teachers_certificates_list->Recordset->EOF) $teachers_certificates_list->Recordset->MoveNext();
}
?>
<?php
	if ($teachers_certificates->CurrentAction == "gridadd" || $teachers_certificates->CurrentAction == "gridedit") {
		$teachers_certificates_list->RowIndex = '$rowindex$';
		$teachers_certificates_list->LoadRowValues();

		// Set row properties
		$teachers_certificates->ResetAttrs();
		$teachers_certificates->RowAttrs = array_merge($teachers_certificates->RowAttrs, array('data-rowindex'=>$teachers_certificates_list->RowIndex, 'id'=>'r0_teachers_certificates', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($teachers_certificates->RowAttrs["class"], "ewTemplate");
		$teachers_certificates->RowType = EW_ROWTYPE_ADD;

		// Render row
		$teachers_certificates_list->RenderRow();

		// Render list options
		$teachers_certificates_list->RenderListOptions();
		$teachers_certificates_list->StartRowCnt = 0;
?>
	<tr<?php echo $teachers_certificates->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_certificates_list->ListOptions->Render("body", "left", $teachers_certificates_list->RowIndex);
?>
	<?php if ($teachers_certificates->id->Visible) { // id ?>
		<td data-name="id">
<input type="hidden" data-table="teachers_certificates" data-field="x_id" name="o<?php echo $teachers_certificates_list->RowIndex ?>_id" id="o<?php echo $teachers_certificates_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_certificates->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_certificates->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id">
<?php if ($teachers_certificates->teacher_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<span<?php echo $teachers_certificates->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_certificates->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" name="x<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_teachers_certificates_teacher_id" class="form-group teachers_certificates_teacher_id">
<input type="text" data-table="teachers_certificates" data-field="x_teacher_id" name="x<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" id="x<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->teacher_id->EditValue ?>"<?php echo $teachers_certificates->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="teachers_certificates" data-field="x_teacher_id" name="o<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" id="o<?php echo $teachers_certificates_list->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_certificates->teacher_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_certificates->university->Visible) { // university ?>
		<td data-name="university">
<span id="el$rowindex$_teachers_certificates_university" class="form-group teachers_certificates_university">
<textarea data-table="teachers_certificates" data-field="x_university" name="x<?php echo $teachers_certificates_list->RowIndex ?>_university" id="x<?php echo $teachers_certificates_list->RowIndex ?>_university" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->university->getPlaceHolder()) ?>"<?php echo $teachers_certificates->university->EditAttributes() ?>><?php echo $teachers_certificates->university->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_university" name="o<?php echo $teachers_certificates_list->RowIndex ?>_university" id="o<?php echo $teachers_certificates_list->RowIndex ?>_university" value="<?php echo ew_HtmlEncode($teachers_certificates->university->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_certificates->degree->Visible) { // degree ?>
		<td data-name="degree">
<span id="el$rowindex$_teachers_certificates_degree" class="form-group teachers_certificates_degree">
<textarea data-table="teachers_certificates" data-field="x_degree" name="x<?php echo $teachers_certificates_list->RowIndex ?>_degree" id="x<?php echo $teachers_certificates_list->RowIndex ?>_degree" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->degree->getPlaceHolder()) ?>"<?php echo $teachers_certificates->degree->EditAttributes() ?>><?php echo $teachers_certificates->degree->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_degree" name="o<?php echo $teachers_certificates_list->RowIndex ?>_degree" id="o<?php echo $teachers_certificates_list->RowIndex ?>_degree" value="<?php echo ew_HtmlEncode($teachers_certificates->degree->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_certificates->image->Visible) { // image ?>
		<td data-name="image">
<span id="el$rowindex$_teachers_certificates_image" class="form-group teachers_certificates_image">
<textarea data-table="teachers_certificates" data-field="x_image" name="x<?php echo $teachers_certificates_list->RowIndex ?>_image" id="x<?php echo $teachers_certificates_list->RowIndex ?>_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->image->getPlaceHolder()) ?>"<?php echo $teachers_certificates->image->EditAttributes() ?>><?php echo $teachers_certificates->image->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_image" name="o<?php echo $teachers_certificates_list->RowIndex ?>_image" id="o<?php echo $teachers_certificates_list->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_certificates->image->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_certificates->from_date->Visible) { // from_date ?>
		<td data-name="from_date">
<span id="el$rowindex$_teachers_certificates_from_date" class="form-group teachers_certificates_from_date">
<input type="text" data-table="teachers_certificates" data-field="x_from_date" name="x<?php echo $teachers_certificates_list->RowIndex ?>_from_date" id="x<?php echo $teachers_certificates_list->RowIndex ?>_from_date" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->from_date->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->from_date->EditValue ?>"<?php echo $teachers_certificates->from_date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_from_date" name="o<?php echo $teachers_certificates_list->RowIndex ?>_from_date" id="o<?php echo $teachers_certificates_list->RowIndex ?>_from_date" value="<?php echo ew_HtmlEncode($teachers_certificates->from_date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_certificates->to_date->Visible) { // to_date ?>
		<td data-name="to_date">
<span id="el$rowindex$_teachers_certificates_to_date" class="form-group teachers_certificates_to_date">
<input type="text" data-table="teachers_certificates" data-field="x_to_date" name="x<?php echo $teachers_certificates_list->RowIndex ?>_to_date" id="x<?php echo $teachers_certificates_list->RowIndex ?>_to_date" placeholder="<?php echo ew_HtmlEncode($teachers_certificates->to_date->getPlaceHolder()) ?>" value="<?php echo $teachers_certificates->to_date->EditValue ?>"<?php echo $teachers_certificates->to_date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_certificates" data-field="x_to_date" name="o<?php echo $teachers_certificates_list->RowIndex ?>_to_date" id="o<?php echo $teachers_certificates_list->RowIndex ?>_to_date" value="<?php echo ew_HtmlEncode($teachers_certificates->to_date->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_certificates_list->ListOptions->Render("body", "right", $teachers_certificates_list->RowIndex);
?>
<script type="text/javascript">
fteachers_certificateslist.UpdateOpts(<?php echo $teachers_certificates_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($teachers_certificates->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $teachers_certificates_list->FormKeyCountName ?>" id="<?php echo $teachers_certificates_list->FormKeyCountName ?>" value="<?php echo $teachers_certificates_list->KeyCount ?>">
<?php echo $teachers_certificates_list->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_certificates->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $teachers_certificates_list->FormKeyCountName ?>" id="<?php echo $teachers_certificates_list->FormKeyCountName ?>" value="<?php echo $teachers_certificates_list->KeyCount ?>">
<?php echo $teachers_certificates_list->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_certificates->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($teachers_certificates_list->Recordset)
	$teachers_certificates_list->Recordset->Close();
?>
<?php if ($teachers_certificates->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($teachers_certificates->CurrentAction <> "gridadd" && $teachers_certificates->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($teachers_certificates_list->Pager)) $teachers_certificates_list->Pager = new cPrevNextPager($teachers_certificates_list->StartRec, $teachers_certificates_list->DisplayRecs, $teachers_certificates_list->TotalRecs, $teachers_certificates_list->AutoHidePager) ?>
<?php if ($teachers_certificates_list->Pager->RecordCount > 0 && $teachers_certificates_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($teachers_certificates_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $teachers_certificates_list->PageUrl() ?>start=<?php echo $teachers_certificates_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($teachers_certificates_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $teachers_certificates_list->PageUrl() ?>start=<?php echo $teachers_certificates_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $teachers_certificates_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($teachers_certificates_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $teachers_certificates_list->PageUrl() ?>start=<?php echo $teachers_certificates_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($teachers_certificates_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $teachers_certificates_list->PageUrl() ?>start=<?php echo $teachers_certificates_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $teachers_certificates_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($teachers_certificates_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $teachers_certificates_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $teachers_certificates_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $teachers_certificates_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_certificates_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($teachers_certificates_list->TotalRecs == 0 && $teachers_certificates->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_certificates_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($teachers_certificates->Export == "") { ?>
<script type="text/javascript">
fteachers_certificateslistsrch.FilterList = <?php echo $teachers_certificates_list->GetFilterList() ?>;
fteachers_certificateslistsrch.Init();
fteachers_certificateslist.Init();
</script>
<?php } ?>
<?php
$teachers_certificates_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($teachers_certificates->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$teachers_certificates_list->Page_Terminate();
?>
