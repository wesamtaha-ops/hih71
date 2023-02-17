<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "studentsinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "ordersgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$students_list = NULL; // Initialize page object first

class cstudents_list extends cstudents {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'students';

	// Page object name
	var $PageObjName = 'students_list';

	// Grid form hidden field names
	var $FormName = 'fstudentslist';
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

		// Table object (students)
		if (!isset($GLOBALS["students"]) || get_class($GLOBALS["students"]) == "cstudents") {
			$GLOBALS["students"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["students"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "studentsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "studentsdelete.php";
		$this->MultiUpdateUrl = "studentsupdate.php";

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'students', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fstudentslistsrch";

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
		$this->user_id->SetVisibility();
		$this->is_parent->SetVisibility();
		$this->level_id->SetVisibility();
		$this->study_year->SetVisibility();
		$this->language_id->SetVisibility();
		$this->langauge_level_id->SetVisibility();
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
		global $EW_EXPORT, $students;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($students);
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

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

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
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
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

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "users") {
			global $users;
			$rsmaster = $users->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("userslist.php"); // Return to master page
			} else {
				$users->LoadListRowValues($rsmaster);
				$users->RowType = EW_ROWTYPE_MASTER; // Master row
				$users->RenderListRow();
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
		if (count($arrKeyFlds) >= 0) {
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
		if ($objForm->HasValue("x_user_id") && $objForm->HasValue("o_user_id") && $this->user_id->CurrentValue <> $this->user_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_is_parent") && $objForm->HasValue("o_is_parent") && $this->is_parent->CurrentValue <> $this->is_parent->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_level_id") && $objForm->HasValue("o_level_id") && $this->level_id->CurrentValue <> $this->level_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_study_year") && $objForm->HasValue("o_study_year") && $this->study_year->CurrentValue <> $this->study_year->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_language_id") && $objForm->HasValue("o_language_id") && $this->language_id->CurrentValue <> $this->language_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_langauge_level_id") && $objForm->HasValue("o_langauge_level_id") && $this->langauge_level_id->CurrentValue <> $this->langauge_level_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_created_at") && $objForm->HasValue("o_created_at") && $this->created_at->CurrentValue <> $this->created_at->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_updated_at") && $objForm->HasValue("o_updated_at") && $this->updated_at->CurrentValue <> $this->updated_at->OldValue)
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
		$sFilterList = ew_Concat($sFilterList, $this->user_id->AdvancedSearch->ToJson(), ","); // Field user_id
		$sFilterList = ew_Concat($sFilterList, $this->is_parent->AdvancedSearch->ToJson(), ","); // Field is_parent
		$sFilterList = ew_Concat($sFilterList, $this->level_id->AdvancedSearch->ToJson(), ","); // Field level_id
		$sFilterList = ew_Concat($sFilterList, $this->study_year->AdvancedSearch->ToJson(), ","); // Field study_year
		$sFilterList = ew_Concat($sFilterList, $this->language_id->AdvancedSearch->ToJson(), ","); // Field language_id
		$sFilterList = ew_Concat($sFilterList, $this->langauge_level_id->AdvancedSearch->ToJson(), ","); // Field langauge_level_id
		$sFilterList = ew_Concat($sFilterList, $this->created_at->AdvancedSearch->ToJson(), ","); // Field created_at
		$sFilterList = ew_Concat($sFilterList, $this->updated_at->AdvancedSearch->ToJson(), ","); // Field updated_at
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fstudentslistsrch", $filters);

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

		// Field user_id
		$this->user_id->AdvancedSearch->SearchValue = @$filter["x_user_id"];
		$this->user_id->AdvancedSearch->SearchOperator = @$filter["z_user_id"];
		$this->user_id->AdvancedSearch->SearchCondition = @$filter["v_user_id"];
		$this->user_id->AdvancedSearch->SearchValue2 = @$filter["y_user_id"];
		$this->user_id->AdvancedSearch->SearchOperator2 = @$filter["w_user_id"];
		$this->user_id->AdvancedSearch->Save();

		// Field is_parent
		$this->is_parent->AdvancedSearch->SearchValue = @$filter["x_is_parent"];
		$this->is_parent->AdvancedSearch->SearchOperator = @$filter["z_is_parent"];
		$this->is_parent->AdvancedSearch->SearchCondition = @$filter["v_is_parent"];
		$this->is_parent->AdvancedSearch->SearchValue2 = @$filter["y_is_parent"];
		$this->is_parent->AdvancedSearch->SearchOperator2 = @$filter["w_is_parent"];
		$this->is_parent->AdvancedSearch->Save();

		// Field level_id
		$this->level_id->AdvancedSearch->SearchValue = @$filter["x_level_id"];
		$this->level_id->AdvancedSearch->SearchOperator = @$filter["z_level_id"];
		$this->level_id->AdvancedSearch->SearchCondition = @$filter["v_level_id"];
		$this->level_id->AdvancedSearch->SearchValue2 = @$filter["y_level_id"];
		$this->level_id->AdvancedSearch->SearchOperator2 = @$filter["w_level_id"];
		$this->level_id->AdvancedSearch->Save();

		// Field study_year
		$this->study_year->AdvancedSearch->SearchValue = @$filter["x_study_year"];
		$this->study_year->AdvancedSearch->SearchOperator = @$filter["z_study_year"];
		$this->study_year->AdvancedSearch->SearchCondition = @$filter["v_study_year"];
		$this->study_year->AdvancedSearch->SearchValue2 = @$filter["y_study_year"];
		$this->study_year->AdvancedSearch->SearchOperator2 = @$filter["w_study_year"];
		$this->study_year->AdvancedSearch->Save();

		// Field language_id
		$this->language_id->AdvancedSearch->SearchValue = @$filter["x_language_id"];
		$this->language_id->AdvancedSearch->SearchOperator = @$filter["z_language_id"];
		$this->language_id->AdvancedSearch->SearchCondition = @$filter["v_language_id"];
		$this->language_id->AdvancedSearch->SearchValue2 = @$filter["y_language_id"];
		$this->language_id->AdvancedSearch->SearchOperator2 = @$filter["w_language_id"];
		$this->language_id->AdvancedSearch->Save();

		// Field langauge_level_id
		$this->langauge_level_id->AdvancedSearch->SearchValue = @$filter["x_langauge_level_id"];
		$this->langauge_level_id->AdvancedSearch->SearchOperator = @$filter["z_langauge_level_id"];
		$this->langauge_level_id->AdvancedSearch->SearchCondition = @$filter["v_langauge_level_id"];
		$this->langauge_level_id->AdvancedSearch->SearchValue2 = @$filter["y_langauge_level_id"];
		$this->langauge_level_id->AdvancedSearch->SearchOperator2 = @$filter["w_langauge_level_id"];
		$this->langauge_level_id->AdvancedSearch->Save();

		// Field created_at
		$this->created_at->AdvancedSearch->SearchValue = @$filter["x_created_at"];
		$this->created_at->AdvancedSearch->SearchOperator = @$filter["z_created_at"];
		$this->created_at->AdvancedSearch->SearchCondition = @$filter["v_created_at"];
		$this->created_at->AdvancedSearch->SearchValue2 = @$filter["y_created_at"];
		$this->created_at->AdvancedSearch->SearchOperator2 = @$filter["w_created_at"];
		$this->created_at->AdvancedSearch->Save();

		// Field updated_at
		$this->updated_at->AdvancedSearch->SearchValue = @$filter["x_updated_at"];
		$this->updated_at->AdvancedSearch->SearchOperator = @$filter["z_updated_at"];
		$this->updated_at->AdvancedSearch->SearchCondition = @$filter["v_updated_at"];
		$this->updated_at->AdvancedSearch->SearchValue2 = @$filter["y_updated_at"];
		$this->updated_at->AdvancedSearch->SearchOperator2 = @$filter["w_updated_at"];
		$this->updated_at->AdvancedSearch->Save();
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->user_id, $Default, FALSE); // user_id
		$this->BuildSearchSql($sWhere, $this->is_parent, $Default, FALSE); // is_parent
		$this->BuildSearchSql($sWhere, $this->level_id, $Default, FALSE); // level_id
		$this->BuildSearchSql($sWhere, $this->study_year, $Default, FALSE); // study_year
		$this->BuildSearchSql($sWhere, $this->language_id, $Default, FALSE); // language_id
		$this->BuildSearchSql($sWhere, $this->langauge_level_id, $Default, FALSE); // langauge_level_id
		$this->BuildSearchSql($sWhere, $this->created_at, $Default, FALSE); // created_at
		$this->BuildSearchSql($sWhere, $this->updated_at, $Default, FALSE); // updated_at

		// Set up search parm
		if (!$Default && $sWhere <> "" && in_array($this->Command, array("", "reset", "resetall"))) {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->user_id->AdvancedSearch->Save(); // user_id
			$this->is_parent->AdvancedSearch->Save(); // is_parent
			$this->level_id->AdvancedSearch->Save(); // level_id
			$this->study_year->AdvancedSearch->Save(); // study_year
			$this->language_id->AdvancedSearch->Save(); // language_id
			$this->langauge_level_id->AdvancedSearch->Save(); // langauge_level_id
			$this->created_at->AdvancedSearch->Save(); // created_at
			$this->updated_at->AdvancedSearch->Save(); // updated_at
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = $Fld->FldParm();
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1)
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Check if search parm exists
	function CheckSearchParms() {
		if ($this->user_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->is_parent->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->level_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->study_year->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->language_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->langauge_level_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->created_at->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->updated_at->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->user_id->AdvancedSearch->UnsetSession();
		$this->is_parent->AdvancedSearch->UnsetSession();
		$this->level_id->AdvancedSearch->UnsetSession();
		$this->study_year->AdvancedSearch->UnsetSession();
		$this->language_id->AdvancedSearch->UnsetSession();
		$this->langauge_level_id->AdvancedSearch->UnsetSession();
		$this->created_at->AdvancedSearch->UnsetSession();
		$this->updated_at->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore advanced search values
		$this->user_id->AdvancedSearch->Load();
		$this->is_parent->AdvancedSearch->Load();
		$this->level_id->AdvancedSearch->Load();
		$this->study_year->AdvancedSearch->Load();
		$this->language_id->AdvancedSearch->Load();
		$this->langauge_level_id->AdvancedSearch->Load();
		$this->created_at->AdvancedSearch->Load();
		$this->updated_at->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->user_id); // user_id
			$this->UpdateSort($this->is_parent); // is_parent
			$this->UpdateSort($this->level_id); // level_id
			$this->UpdateSort($this->study_year); // study_year
			$this->UpdateSort($this->language_id); // language_id
			$this->UpdateSort($this->langauge_level_id); // langauge_level_id
			$this->UpdateSort($this->created_at); // created_at
			$this->UpdateSort($this->updated_at); // updated_at
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
				$this->user_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->user_id->setSort("");
				$this->is_parent->setSort("");
				$this->level_id->setSort("");
				$this->study_year->setSort("");
				$this->language_id->setSort("");
				$this->langauge_level_id->setSort("");
				$this->created_at->setSort("");
				$this->updated_at->setSort("");
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

		// "detail_orders"
		$item = &$this->ListOptions->Add("detail_orders");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["orders_grid"])) $GLOBALS["orders_grid"] = new corders_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssClass = "text-nowrap";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = FALSE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("orders");
		$this->DetailPages = $pages;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
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
				if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
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
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_orders"
		$oListOpt = &$this->ListOptions->Items["detail_orders"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("orders", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("orderslist.php?" . EW_TABLE_SHOW_MASTER . "=students&fk_user_id=" . urlencode(strval($this->user_id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->IsLoggedIn());
		$option = $options["action"];

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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fstudentslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fstudentslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fstudentslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
					$item->Visible = FALSE;
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fstudentslistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->user_id->CurrentValue = NULL;
		$this->user_id->OldValue = $this->user_id->CurrentValue;
		$this->is_parent->CurrentValue = 0;
		$this->is_parent->OldValue = $this->is_parent->CurrentValue;
		$this->level_id->CurrentValue = NULL;
		$this->level_id->OldValue = $this->level_id->CurrentValue;
		$this->study_year->CurrentValue = NULL;
		$this->study_year->OldValue = $this->study_year->CurrentValue;
		$this->language_id->CurrentValue = NULL;
		$this->language_id->OldValue = $this->language_id->CurrentValue;
		$this->langauge_level_id->CurrentValue = NULL;
		$this->langauge_level_id->OldValue = $this->langauge_level_id->CurrentValue;
		$this->created_at->CurrentValue = NULL;
		$this->created_at->OldValue = $this->created_at->CurrentValue;
		$this->updated_at->CurrentValue = NULL;
		$this->updated_at->OldValue = $this->updated_at->CurrentValue;
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// user_id

		$this->user_id->AdvancedSearch->SearchValue = @$_GET["x_user_id"];
		if ($this->user_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->user_id->AdvancedSearch->SearchOperator = @$_GET["z_user_id"];

		// is_parent
		$this->is_parent->AdvancedSearch->SearchValue = @$_GET["x_is_parent"];
		if ($this->is_parent->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->is_parent->AdvancedSearch->SearchOperator = @$_GET["z_is_parent"];

		// level_id
		$this->level_id->AdvancedSearch->SearchValue = @$_GET["x_level_id"];
		if ($this->level_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->level_id->AdvancedSearch->SearchOperator = @$_GET["z_level_id"];

		// study_year
		$this->study_year->AdvancedSearch->SearchValue = @$_GET["x_study_year"];
		if ($this->study_year->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->study_year->AdvancedSearch->SearchOperator = @$_GET["z_study_year"];

		// language_id
		$this->language_id->AdvancedSearch->SearchValue = @$_GET["x_language_id"];
		if ($this->language_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->language_id->AdvancedSearch->SearchOperator = @$_GET["z_language_id"];

		// langauge_level_id
		$this->langauge_level_id->AdvancedSearch->SearchValue = @$_GET["x_langauge_level_id"];
		if ($this->langauge_level_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->langauge_level_id->AdvancedSearch->SearchOperator = @$_GET["z_langauge_level_id"];

		// created_at
		$this->created_at->AdvancedSearch->SearchValue = @$_GET["x_created_at"];
		if ($this->created_at->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->created_at->AdvancedSearch->SearchOperator = @$_GET["z_created_at"];

		// updated_at
		$this->updated_at->AdvancedSearch->SearchValue = @$_GET["x_updated_at"];
		if ($this->updated_at->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->updated_at->AdvancedSearch->SearchOperator = @$_GET["z_updated_at"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->user_id->FldIsDetailKey) {
			$this->user_id->setFormValue($objForm->GetValue("x_user_id"));
		}
		$this->user_id->setOldValue($objForm->GetValue("o_user_id"));
		if (!$this->is_parent->FldIsDetailKey) {
			$this->is_parent->setFormValue($objForm->GetValue("x_is_parent"));
		}
		$this->is_parent->setOldValue($objForm->GetValue("o_is_parent"));
		if (!$this->level_id->FldIsDetailKey) {
			$this->level_id->setFormValue($objForm->GetValue("x_level_id"));
		}
		$this->level_id->setOldValue($objForm->GetValue("o_level_id"));
		if (!$this->study_year->FldIsDetailKey) {
			$this->study_year->setFormValue($objForm->GetValue("x_study_year"));
		}
		$this->study_year->setOldValue($objForm->GetValue("o_study_year"));
		if (!$this->language_id->FldIsDetailKey) {
			$this->language_id->setFormValue($objForm->GetValue("x_language_id"));
		}
		$this->language_id->setOldValue($objForm->GetValue("o_language_id"));
		if (!$this->langauge_level_id->FldIsDetailKey) {
			$this->langauge_level_id->setFormValue($objForm->GetValue("x_langauge_level_id"));
		}
		$this->langauge_level_id->setOldValue($objForm->GetValue("o_langauge_level_id"));
		if (!$this->created_at->FldIsDetailKey) {
			$this->created_at->setFormValue($objForm->GetValue("x_created_at"));
			$this->created_at->CurrentValue = ew_UnFormatDateTime($this->created_at->CurrentValue, 0);
		}
		$this->created_at->setOldValue($objForm->GetValue("o_created_at"));
		if (!$this->updated_at->FldIsDetailKey) {
			$this->updated_at->setFormValue($objForm->GetValue("x_updated_at"));
			$this->updated_at->CurrentValue = ew_UnFormatDateTime($this->updated_at->CurrentValue, 0);
		}
		$this->updated_at->setOldValue($objForm->GetValue("o_updated_at"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->user_id->CurrentValue = $this->user_id->FormValue;
		$this->is_parent->CurrentValue = $this->is_parent->FormValue;
		$this->level_id->CurrentValue = $this->level_id->FormValue;
		$this->study_year->CurrentValue = $this->study_year->FormValue;
		$this->language_id->CurrentValue = $this->language_id->FormValue;
		$this->langauge_level_id->CurrentValue = $this->langauge_level_id->FormValue;
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
		$this->user_id->setDbValue($row['user_id']);
		$this->is_parent->setDbValue($row['is_parent']);
		$this->level_id->setDbValue($row['level_id']);
		$this->study_year->setDbValue($row['study_year']);
		$this->language_id->setDbValue($row['language_id']);
		$this->langauge_level_id->setDbValue($row['langauge_level_id']);
		$this->created_at->setDbValue($row['created_at']);
		$this->updated_at->setDbValue($row['updated_at']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['user_id'] = $this->user_id->CurrentValue;
		$row['is_parent'] = $this->is_parent->CurrentValue;
		$row['level_id'] = $this->level_id->CurrentValue;
		$row['study_year'] = $this->study_year->CurrentValue;
		$row['language_id'] = $this->language_id->CurrentValue;
		$row['langauge_level_id'] = $this->langauge_level_id->CurrentValue;
		$row['created_at'] = $this->created_at->CurrentValue;
		$row['updated_at'] = $this->updated_at->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->user_id->DbValue = $row['user_id'];
		$this->is_parent->DbValue = $row['is_parent'];
		$this->level_id->DbValue = $row['level_id'];
		$this->study_year->DbValue = $row['study_year'];
		$this->language_id->DbValue = $row['language_id'];
		$this->langauge_level_id->DbValue = $row['langauge_level_id'];
		$this->created_at->DbValue = $row['created_at'];
		$this->updated_at->DbValue = $row['updated_at'];
	}

	// Load old record
	function LoadOldRecord() {
		return FALSE;
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
		// user_id
		// is_parent
		// level_id
		// study_year
		// language_id
		// langauge_level_id
		// created_at
		// updated_at

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// user_id
		$this->user_id->ViewValue = $this->user_id->CurrentValue;
		$this->user_id->ViewCustomAttributes = "";

		// is_parent
		$this->is_parent->ViewValue = $this->is_parent->CurrentValue;
		$this->is_parent->ViewCustomAttributes = "";

		// level_id
		$this->level_id->ViewValue = $this->level_id->CurrentValue;
		$this->level_id->ViewCustomAttributes = "";

		// study_year
		if (strval($this->study_year->CurrentValue) <> "") {
			$this->study_year->ViewValue = $this->study_year->OptionCaption($this->study_year->CurrentValue);
		} else {
			$this->study_year->ViewValue = NULL;
		}
		$this->study_year->ViewCustomAttributes = "";

		// language_id
		$this->language_id->ViewValue = $this->language_id->CurrentValue;
		$this->language_id->ViewCustomAttributes = "";

		// langauge_level_id
		$this->langauge_level_id->ViewValue = $this->langauge_level_id->CurrentValue;
		$this->langauge_level_id->ViewCustomAttributes = "";

		// created_at
		$this->created_at->ViewValue = $this->created_at->CurrentValue;
		$this->created_at->ViewValue = ew_FormatDateTime($this->created_at->ViewValue, 0);
		$this->created_at->ViewCustomAttributes = "";

		// updated_at
		$this->updated_at->ViewValue = $this->updated_at->CurrentValue;
		$this->updated_at->ViewValue = ew_FormatDateTime($this->updated_at->ViewValue, 0);
		$this->updated_at->ViewCustomAttributes = "";

			// user_id
			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";
			$this->user_id->TooltipValue = "";

			// is_parent
			$this->is_parent->LinkCustomAttributes = "";
			$this->is_parent->HrefValue = "";
			$this->is_parent->TooltipValue = "";

			// level_id
			$this->level_id->LinkCustomAttributes = "";
			$this->level_id->HrefValue = "";
			$this->level_id->TooltipValue = "";

			// study_year
			$this->study_year->LinkCustomAttributes = "";
			$this->study_year->HrefValue = "";
			$this->study_year->TooltipValue = "";

			// language_id
			$this->language_id->LinkCustomAttributes = "";
			$this->language_id->HrefValue = "";
			$this->language_id->TooltipValue = "";

			// langauge_level_id
			$this->langauge_level_id->LinkCustomAttributes = "";
			$this->langauge_level_id->HrefValue = "";
			$this->langauge_level_id->TooltipValue = "";

			// created_at
			$this->created_at->LinkCustomAttributes = "";
			$this->created_at->HrefValue = "";
			$this->created_at->TooltipValue = "";

			// updated_at
			$this->updated_at->LinkCustomAttributes = "";
			$this->updated_at->HrefValue = "";
			$this->updated_at->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// user_id
			$this->user_id->EditAttrs["class"] = "form-control";
			$this->user_id->EditCustomAttributes = "";
			if ($this->user_id->getSessionValue() <> "") {
				$this->user_id->CurrentValue = $this->user_id->getSessionValue();
				$this->user_id->OldValue = $this->user_id->CurrentValue;
			$this->user_id->ViewValue = $this->user_id->CurrentValue;
			$this->user_id->ViewCustomAttributes = "";
			} else {
			$this->user_id->EditValue = ew_HtmlEncode($this->user_id->CurrentValue);
			$this->user_id->PlaceHolder = ew_RemoveHtml($this->user_id->FldCaption());
			}

			// is_parent
			$this->is_parent->EditAttrs["class"] = "form-control";
			$this->is_parent->EditCustomAttributes = "";
			$this->is_parent->EditValue = ew_HtmlEncode($this->is_parent->CurrentValue);
			$this->is_parent->PlaceHolder = ew_RemoveHtml($this->is_parent->FldCaption());

			// level_id
			$this->level_id->EditAttrs["class"] = "form-control";
			$this->level_id->EditCustomAttributes = "";
			$this->level_id->EditValue = ew_HtmlEncode($this->level_id->CurrentValue);
			$this->level_id->PlaceHolder = ew_RemoveHtml($this->level_id->FldCaption());

			// study_year
			$this->study_year->EditCustomAttributes = "";
			$this->study_year->EditValue = $this->study_year->Options(FALSE);

			// language_id
			$this->language_id->EditAttrs["class"] = "form-control";
			$this->language_id->EditCustomAttributes = "";
			$this->language_id->EditValue = ew_HtmlEncode($this->language_id->CurrentValue);
			$this->language_id->PlaceHolder = ew_RemoveHtml($this->language_id->FldCaption());

			// langauge_level_id
			$this->langauge_level_id->EditAttrs["class"] = "form-control";
			$this->langauge_level_id->EditCustomAttributes = "";
			$this->langauge_level_id->EditValue = ew_HtmlEncode($this->langauge_level_id->CurrentValue);
			$this->langauge_level_id->PlaceHolder = ew_RemoveHtml($this->langauge_level_id->FldCaption());

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

			// Add refer script
			// user_id

			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";

			// is_parent
			$this->is_parent->LinkCustomAttributes = "";
			$this->is_parent->HrefValue = "";

			// level_id
			$this->level_id->LinkCustomAttributes = "";
			$this->level_id->HrefValue = "";

			// study_year
			$this->study_year->LinkCustomAttributes = "";
			$this->study_year->HrefValue = "";

			// language_id
			$this->language_id->LinkCustomAttributes = "";
			$this->language_id->HrefValue = "";

			// langauge_level_id
			$this->langauge_level_id->LinkCustomAttributes = "";
			$this->langauge_level_id->HrefValue = "";

			// created_at
			$this->created_at->LinkCustomAttributes = "";
			$this->created_at->HrefValue = "";

			// updated_at
			$this->updated_at->LinkCustomAttributes = "";
			$this->updated_at->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// user_id
			$this->user_id->EditAttrs["class"] = "form-control";
			$this->user_id->EditCustomAttributes = "";
			$this->user_id->EditValue = ew_HtmlEncode($this->user_id->AdvancedSearch->SearchValue);
			$this->user_id->PlaceHolder = ew_RemoveHtml($this->user_id->FldCaption());

			// is_parent
			$this->is_parent->EditAttrs["class"] = "form-control";
			$this->is_parent->EditCustomAttributes = "";
			$this->is_parent->EditValue = ew_HtmlEncode($this->is_parent->AdvancedSearch->SearchValue);
			$this->is_parent->PlaceHolder = ew_RemoveHtml($this->is_parent->FldCaption());

			// level_id
			$this->level_id->EditAttrs["class"] = "form-control";
			$this->level_id->EditCustomAttributes = "";
			$this->level_id->EditValue = ew_HtmlEncode($this->level_id->AdvancedSearch->SearchValue);
			$this->level_id->PlaceHolder = ew_RemoveHtml($this->level_id->FldCaption());

			// study_year
			$this->study_year->EditCustomAttributes = "";
			$this->study_year->EditValue = $this->study_year->Options(FALSE);

			// language_id
			$this->language_id->EditAttrs["class"] = "form-control";
			$this->language_id->EditCustomAttributes = "";
			$this->language_id->EditValue = ew_HtmlEncode($this->language_id->AdvancedSearch->SearchValue);
			$this->language_id->PlaceHolder = ew_RemoveHtml($this->language_id->FldCaption());

			// langauge_level_id
			$this->langauge_level_id->EditAttrs["class"] = "form-control";
			$this->langauge_level_id->EditCustomAttributes = "";
			$this->langauge_level_id->EditValue = ew_HtmlEncode($this->langauge_level_id->AdvancedSearch->SearchValue);
			$this->langauge_level_id->PlaceHolder = ew_RemoveHtml($this->langauge_level_id->FldCaption());

			// created_at
			$this->created_at->EditAttrs["class"] = "form-control";
			$this->created_at->EditCustomAttributes = "";
			$this->created_at->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->created_at->AdvancedSearch->SearchValue, 0), 8));
			$this->created_at->PlaceHolder = ew_RemoveHtml($this->created_at->FldCaption());

			// updated_at
			$this->updated_at->EditAttrs["class"] = "form-control";
			$this->updated_at->EditCustomAttributes = "";
			$this->updated_at->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->updated_at->AdvancedSearch->SearchValue, 0), 8));
			$this->updated_at->PlaceHolder = ew_RemoveHtml($this->updated_at->FldCaption());
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
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
		if (!$this->is_parent->FldIsDetailKey && !is_null($this->is_parent->FormValue) && $this->is_parent->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->is_parent->FldCaption(), $this->is_parent->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->is_parent->FormValue)) {
			ew_AddMessage($gsFormError, $this->is_parent->FldErrMsg());
		}
		if (!ew_CheckInteger($this->level_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->level_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->language_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->language_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->langauge_level_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->langauge_level_id->FldErrMsg());
		}
		if (!$this->created_at->FldIsDetailKey && !is_null($this->created_at->FormValue) && $this->created_at->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->created_at->FldCaption(), $this->created_at->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->created_at->FormValue)) {
			ew_AddMessage($gsFormError, $this->created_at->FldErrMsg());
		}
		if (!$this->updated_at->FldIsDetailKey && !is_null($this->updated_at->FormValue) && $this->updated_at->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->updated_at->FldCaption(), $this->updated_at->ReqErrMsg));
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// user_id
		$this->user_id->SetDbValueDef($rsnew, $this->user_id->CurrentValue, 0, FALSE);

		// is_parent
		$this->is_parent->SetDbValueDef($rsnew, $this->is_parent->CurrentValue, 0, strval($this->is_parent->CurrentValue) == "");

		// level_id
		$this->level_id->SetDbValueDef($rsnew, $this->level_id->CurrentValue, NULL, FALSE);

		// study_year
		$this->study_year->SetDbValueDef($rsnew, $this->study_year->CurrentValue, NULL, FALSE);

		// language_id
		$this->language_id->SetDbValueDef($rsnew, $this->language_id->CurrentValue, NULL, FALSE);

		// langauge_level_id
		$this->langauge_level_id->SetDbValueDef($rsnew, $this->langauge_level_id->CurrentValue, NULL, FALSE);

		// created_at
		$this->created_at->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->created_at->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// updated_at
		$this->updated_at->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->updated_at->CurrentValue, 0), ew_CurrentDate(), FALSE);

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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->user_id->AdvancedSearch->Load();
		$this->is_parent->AdvancedSearch->Load();
		$this->level_id->AdvancedSearch->Load();
		$this->study_year->AdvancedSearch->Load();
		$this->language_id->AdvancedSearch->Load();
		$this->langauge_level_id->AdvancedSearch->Load();
		$this->created_at->AdvancedSearch->Load();
		$this->updated_at->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_students\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_students',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fstudentslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "users") {
			global $users;
			if (!isset($users)) $users = new cusers;
			$rsmaster = $users->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$users;
					$users->ExportDocument($Doc, $rsmaster, 1, 1);
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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
			}
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
			}
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
if (!isset($students_list)) $students_list = new cstudents_list();

// Page init
$students_list->Page_Init();

// Page main
$students_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$students_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($students->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fstudentslist = new ew_Form("fstudentslist", "list");
fstudentslist.FormKeyCountName = '<?php echo $students_list->FormKeyCountName ?>';

// Validate form
fstudentslist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_user_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $students->user_id->FldCaption(), $students->user_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_user_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->user_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_is_parent");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $students->is_parent->FldCaption(), $students->is_parent->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_is_parent");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->is_parent->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_level_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->level_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_language_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->language_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_langauge_level_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->langauge_level_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $students->created_at->FldCaption(), $students->created_at->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->created_at->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_updated_at");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $students->updated_at->FldCaption(), $students->updated_at->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_updated_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($students->updated_at->FldErrMsg()) ?>");

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
fstudentslist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "user_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "is_parent", false)) return false;
	if (ew_ValueChanged(fobj, infix, "level_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "study_year", false)) return false;
	if (ew_ValueChanged(fobj, infix, "language_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "langauge_level_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "created_at", false)) return false;
	if (ew_ValueChanged(fobj, infix, "updated_at", false)) return false;
	return true;
}

// Form_CustomValidate event
fstudentslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fstudentslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fstudentslist.Lists["x_study_year"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fstudentslist.Lists["x_study_year"].Options = <?php echo json_encode($students_list->study_year->Options()) ?>;

// Form object for search
var CurrentSearchForm = fstudentslistsrch = new ew_Form("fstudentslistsrch");

// Validate function for search
fstudentslistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fstudentslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fstudentslistsrch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fstudentslistsrch.Lists["x_study_year"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fstudentslistsrch.Lists["x_study_year"].Options = <?php echo json_encode($students_list->study_year->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($students->Export == "") { ?>
<div class="ewToolbar">
<?php if ($students_list->TotalRecs > 0 && $students_list->ExportOptions->Visible()) { ?>
<?php $students_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($students_list->SearchOptions->Visible()) { ?>
<?php $students_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($students_list->FilterOptions->Visible()) { ?>
<?php $students_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($students->Export == "") || (EW_EXPORT_MASTER_RECORD && $students->Export == "print")) { ?>
<?php
if ($students_list->DbMasterFilter <> "" && $students->getCurrentMasterTable() == "users") {
	if ($students_list->MasterRecordExists) {
?>
<?php include_once "usersmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($students->CurrentAction == "gridadd") {
	$students->CurrentFilter = "0=1";
	$students_list->StartRec = 1;
	$students_list->DisplayRecs = $students->GridAddRowCount;
	$students_list->TotalRecs = $students_list->DisplayRecs;
	$students_list->StopRec = $students_list->DisplayRecs;
} else {
	$bSelectLimit = $students_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($students_list->TotalRecs <= 0)
			$students_list->TotalRecs = $students->ListRecordCount();
	} else {
		if (!$students_list->Recordset && ($students_list->Recordset = $students_list->LoadRecordset()))
			$students_list->TotalRecs = $students_list->Recordset->RecordCount();
	}
	$students_list->StartRec = 1;
	if ($students_list->DisplayRecs <= 0 || ($students->Export <> "" && $students->ExportAll)) // Display all records
		$students_list->DisplayRecs = $students_list->TotalRecs;
	if (!($students->Export <> "" && $students->ExportAll))
		$students_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$students_list->Recordset = $students_list->LoadRecordset($students_list->StartRec-1, $students_list->DisplayRecs);

	// Set no record found message
	if ($students->CurrentAction == "" && $students_list->TotalRecs == 0) {
		if ($students_list->SearchWhere == "0=101")
			$students_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$students_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$students_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($students->Export == "" && $students->CurrentAction == "") { ?>
<form name="fstudentslistsrch" id="fstudentslistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($students_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fstudentslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="students">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$students_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$students->RowType = EW_ROWTYPE_SEARCH;

// Render row
$students->ResetAttrs();
$students_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($students->study_year->Visible) { // study_year ?>
	<div id="xsc_study_year" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $students->study_year->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_study_year" id="z_study_year" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_study_year" class="ewTemplate"><input type="radio" data-table="students" data-field="x_study_year" data-value-separator="<?php echo $students->study_year->DisplayValueSeparatorAttribute() ?>" name="x_study_year" id="x_study_year" value="{value}"<?php echo $students->study_year->EditAttributes() ?>></div>
<div id="dsl_x_study_year" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $students->study_year->RadioButtonListHtml(FALSE, "x_study_year") ?>
</div></div>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $students_list->ShowPageHeader(); ?>
<?php
$students_list->ShowMessage();
?>
<?php if ($students_list->TotalRecs > 0 || $students->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($students_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> students">
<?php if ($students->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($students->CurrentAction <> "gridadd" && $students->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($students_list->Pager)) $students_list->Pager = new cPrevNextPager($students_list->StartRec, $students_list->DisplayRecs, $students_list->TotalRecs, $students_list->AutoHidePager) ?>
<?php if ($students_list->Pager->RecordCount > 0 && $students_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($students_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $students_list->PageUrl() ?>start=<?php echo $students_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($students_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $students_list->PageUrl() ?>start=<?php echo $students_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $students_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($students_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $students_list->PageUrl() ?>start=<?php echo $students_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($students_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $students_list->PageUrl() ?>start=<?php echo $students_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $students_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($students_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $students_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $students_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $students_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($students_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fstudentslist" id="fstudentslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($students_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $students_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="students">
<?php if ($students->getCurrentMasterTable() == "users" && $students->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="users">
<input type="hidden" name="fk_id" value="<?php echo $students->user_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_students" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($students_list->TotalRecs > 0 || $students->CurrentAction == "gridedit") { ?>
<table id="tbl_studentslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$students_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$students_list->RenderListOptions();

// Render list options (header, left)
$students_list->ListOptions->Render("header", "left");
?>
<?php if ($students->user_id->Visible) { // user_id ?>
	<?php if ($students->SortUrl($students->user_id) == "") { ?>
		<th data-name="user_id" class="<?php echo $students->user_id->HeaderCellClass() ?>"><div id="elh_students_user_id" class="students_user_id"><div class="ewTableHeaderCaption"><?php echo $students->user_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user_id" class="<?php echo $students->user_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $students->SortUrl($students->user_id) ?>',1);"><div id="elh_students_user_id" class="students_user_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->user_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->user_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->user_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->is_parent->Visible) { // is_parent ?>
	<?php if ($students->SortUrl($students->is_parent) == "") { ?>
		<th data-name="is_parent" class="<?php echo $students->is_parent->HeaderCellClass() ?>"><div id="elh_students_is_parent" class="students_is_parent"><div class="ewTableHeaderCaption"><?php echo $students->is_parent->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="is_parent" class="<?php echo $students->is_parent->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $students->SortUrl($students->is_parent) ?>',1);"><div id="elh_students_is_parent" class="students_is_parent">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->is_parent->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->is_parent->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->is_parent->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->level_id->Visible) { // level_id ?>
	<?php if ($students->SortUrl($students->level_id) == "") { ?>
		<th data-name="level_id" class="<?php echo $students->level_id->HeaderCellClass() ?>"><div id="elh_students_level_id" class="students_level_id"><div class="ewTableHeaderCaption"><?php echo $students->level_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="level_id" class="<?php echo $students->level_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $students->SortUrl($students->level_id) ?>',1);"><div id="elh_students_level_id" class="students_level_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->level_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->level_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->level_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->study_year->Visible) { // study_year ?>
	<?php if ($students->SortUrl($students->study_year) == "") { ?>
		<th data-name="study_year" class="<?php echo $students->study_year->HeaderCellClass() ?>"><div id="elh_students_study_year" class="students_study_year"><div class="ewTableHeaderCaption"><?php echo $students->study_year->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="study_year" class="<?php echo $students->study_year->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $students->SortUrl($students->study_year) ?>',1);"><div id="elh_students_study_year" class="students_study_year">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->study_year->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->study_year->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->study_year->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->language_id->Visible) { // language_id ?>
	<?php if ($students->SortUrl($students->language_id) == "") { ?>
		<th data-name="language_id" class="<?php echo $students->language_id->HeaderCellClass() ?>"><div id="elh_students_language_id" class="students_language_id"><div class="ewTableHeaderCaption"><?php echo $students->language_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="language_id" class="<?php echo $students->language_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $students->SortUrl($students->language_id) ?>',1);"><div id="elh_students_language_id" class="students_language_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->language_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->language_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->language_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->langauge_level_id->Visible) { // langauge_level_id ?>
	<?php if ($students->SortUrl($students->langauge_level_id) == "") { ?>
		<th data-name="langauge_level_id" class="<?php echo $students->langauge_level_id->HeaderCellClass() ?>"><div id="elh_students_langauge_level_id" class="students_langauge_level_id"><div class="ewTableHeaderCaption"><?php echo $students->langauge_level_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="langauge_level_id" class="<?php echo $students->langauge_level_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $students->SortUrl($students->langauge_level_id) ?>',1);"><div id="elh_students_langauge_level_id" class="students_langauge_level_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->langauge_level_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->langauge_level_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->langauge_level_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->created_at->Visible) { // created_at ?>
	<?php if ($students->SortUrl($students->created_at) == "") { ?>
		<th data-name="created_at" class="<?php echo $students->created_at->HeaderCellClass() ?>"><div id="elh_students_created_at" class="students_created_at"><div class="ewTableHeaderCaption"><?php echo $students->created_at->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="created_at" class="<?php echo $students->created_at->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $students->SortUrl($students->created_at) ?>',1);"><div id="elh_students_created_at" class="students_created_at">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->created_at->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->created_at->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->created_at->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($students->updated_at->Visible) { // updated_at ?>
	<?php if ($students->SortUrl($students->updated_at) == "") { ?>
		<th data-name="updated_at" class="<?php echo $students->updated_at->HeaderCellClass() ?>"><div id="elh_students_updated_at" class="students_updated_at"><div class="ewTableHeaderCaption"><?php echo $students->updated_at->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="updated_at" class="<?php echo $students->updated_at->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $students->SortUrl($students->updated_at) ?>',1);"><div id="elh_students_updated_at" class="students_updated_at">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $students->updated_at->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($students->updated_at->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($students->updated_at->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$students_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($students->ExportAll && $students->Export <> "") {
	$students_list->StopRec = $students_list->TotalRecs;
} else {

	// Set the last record to display
	if ($students_list->TotalRecs > $students_list->StartRec + $students_list->DisplayRecs - 1)
		$students_list->StopRec = $students_list->StartRec + $students_list->DisplayRecs - 1;
	else
		$students_list->StopRec = $students_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($students_list->FormKeyCountName) && ($students->CurrentAction == "gridadd" || $students->CurrentAction == "gridedit" || $students->CurrentAction == "F")) {
		$students_list->KeyCount = $objForm->GetValue($students_list->FormKeyCountName);
		$students_list->StopRec = $students_list->StartRec + $students_list->KeyCount - 1;
	}
}
$students_list->RecCnt = $students_list->StartRec - 1;
if ($students_list->Recordset && !$students_list->Recordset->EOF) {
	$students_list->Recordset->MoveFirst();
	$bSelectLimit = $students_list->UseSelectLimit;
	if (!$bSelectLimit && $students_list->StartRec > 1)
		$students_list->Recordset->Move($students_list->StartRec - 1);
} elseif (!$students->AllowAddDeleteRow && $students_list->StopRec == 0) {
	$students_list->StopRec = $students->GridAddRowCount;
}

// Initialize aggregate
$students->RowType = EW_ROWTYPE_AGGREGATEINIT;
$students->ResetAttrs();
$students_list->RenderRow();
if ($students->CurrentAction == "gridadd")
	$students_list->RowIndex = 0;
while ($students_list->RecCnt < $students_list->StopRec) {
	$students_list->RecCnt++;
	if (intval($students_list->RecCnt) >= intval($students_list->StartRec)) {
		$students_list->RowCnt++;
		if ($students->CurrentAction == "gridadd" || $students->CurrentAction == "gridedit" || $students->CurrentAction == "F") {
			$students_list->RowIndex++;
			$objForm->Index = $students_list->RowIndex;
			if ($objForm->HasValue($students_list->FormActionName))
				$students_list->RowAction = strval($objForm->GetValue($students_list->FormActionName));
			elseif ($students->CurrentAction == "gridadd")
				$students_list->RowAction = "insert";
			else
				$students_list->RowAction = "";
		}

		// Set up key count
		$students_list->KeyCount = $students_list->RowIndex;

		// Init row class and style
		$students->ResetAttrs();
		$students->CssClass = "";
		if ($students->CurrentAction == "gridadd") {
			$students_list->LoadRowValues(); // Load default values
		} else {
			$students_list->LoadRowValues($students_list->Recordset); // Load row values
		}
		$students->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($students->CurrentAction == "gridadd") // Grid add
			$students->RowType = EW_ROWTYPE_ADD; // Render add
		if ($students->CurrentAction == "gridadd" && $students->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$students_list->RestoreCurrentRowFormValues($students_list->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$students->RowAttrs = array_merge($students->RowAttrs, array('data-rowindex'=>$students_list->RowCnt, 'id'=>'r' . $students_list->RowCnt . '_students', 'data-rowtype'=>$students->RowType));

		// Render row
		$students_list->RenderRow();

		// Render list options
		$students_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($students_list->RowAction <> "delete" && $students_list->RowAction <> "insertdelete" && !($students_list->RowAction == "insert" && $students->CurrentAction == "F" && $students_list->EmptyRow())) {
?>
	<tr<?php echo $students->RowAttributes() ?>>
<?php

// Render list options (body, left)
$students_list->ListOptions->Render("body", "left", $students_list->RowCnt);
?>
	<?php if ($students->user_id->Visible) { // user_id ?>
		<td data-name="user_id"<?php echo $students->user_id->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($students->user_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_user_id" class="form-group students_user_id">
<span<?php echo $students->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $students_list->RowIndex ?>_user_id" name="x<?php echo $students_list->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_user_id" class="form-group students_user_id">
<input type="text" data-table="students" data-field="x_user_id" name="x<?php echo $students_list->RowIndex ?>_user_id" id="x<?php echo $students_list->RowIndex ?>_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->user_id->getPlaceHolder()) ?>" value="<?php echo $students->user_id->EditValue ?>"<?php echo $students->user_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="students" data-field="x_user_id" name="o<?php echo $students_list->RowIndex ?>_user_id" id="o<?php echo $students_list->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_user_id" class="students_user_id">
<span<?php echo $students->user_id->ViewAttributes() ?>>
<?php echo $students->user_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->is_parent->Visible) { // is_parent ?>
		<td data-name="is_parent"<?php echo $students->is_parent->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_is_parent" class="form-group students_is_parent">
<input type="text" data-table="students" data-field="x_is_parent" name="x<?php echo $students_list->RowIndex ?>_is_parent" id="x<?php echo $students_list->RowIndex ?>_is_parent" size="30" placeholder="<?php echo ew_HtmlEncode($students->is_parent->getPlaceHolder()) ?>" value="<?php echo $students->is_parent->EditValue ?>"<?php echo $students->is_parent->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_is_parent" name="o<?php echo $students_list->RowIndex ?>_is_parent" id="o<?php echo $students_list->RowIndex ?>_is_parent" value="<?php echo ew_HtmlEncode($students->is_parent->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_is_parent" class="students_is_parent">
<span<?php echo $students->is_parent->ViewAttributes() ?>>
<?php echo $students->is_parent->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->level_id->Visible) { // level_id ?>
		<td data-name="level_id"<?php echo $students->level_id->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_level_id" class="form-group students_level_id">
<input type="text" data-table="students" data-field="x_level_id" name="x<?php echo $students_list->RowIndex ?>_level_id" id="x<?php echo $students_list->RowIndex ?>_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->level_id->getPlaceHolder()) ?>" value="<?php echo $students->level_id->EditValue ?>"<?php echo $students->level_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_level_id" name="o<?php echo $students_list->RowIndex ?>_level_id" id="o<?php echo $students_list->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($students->level_id->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_level_id" class="students_level_id">
<span<?php echo $students->level_id->ViewAttributes() ?>>
<?php echo $students->level_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->study_year->Visible) { // study_year ?>
		<td data-name="study_year"<?php echo $students->study_year->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_study_year" class="form-group students_study_year">
<div id="tp_x<?php echo $students_list->RowIndex ?>_study_year" class="ewTemplate"><input type="radio" data-table="students" data-field="x_study_year" data-value-separator="<?php echo $students->study_year->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $students_list->RowIndex ?>_study_year" id="x<?php echo $students_list->RowIndex ?>_study_year" value="{value}"<?php echo $students->study_year->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $students_list->RowIndex ?>_study_year" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $students->study_year->RadioButtonListHtml(FALSE, "x{$students_list->RowIndex}_study_year") ?>
</div></div>
</span>
<input type="hidden" data-table="students" data-field="x_study_year" name="o<?php echo $students_list->RowIndex ?>_study_year" id="o<?php echo $students_list->RowIndex ?>_study_year" value="<?php echo ew_HtmlEncode($students->study_year->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_study_year" class="students_study_year">
<span<?php echo $students->study_year->ViewAttributes() ?>>
<?php echo $students->study_year->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->language_id->Visible) { // language_id ?>
		<td data-name="language_id"<?php echo $students->language_id->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_language_id" class="form-group students_language_id">
<input type="text" data-table="students" data-field="x_language_id" name="x<?php echo $students_list->RowIndex ?>_language_id" id="x<?php echo $students_list->RowIndex ?>_language_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->language_id->getPlaceHolder()) ?>" value="<?php echo $students->language_id->EditValue ?>"<?php echo $students->language_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_language_id" name="o<?php echo $students_list->RowIndex ?>_language_id" id="o<?php echo $students_list->RowIndex ?>_language_id" value="<?php echo ew_HtmlEncode($students->language_id->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_language_id" class="students_language_id">
<span<?php echo $students->language_id->ViewAttributes() ?>>
<?php echo $students->language_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->langauge_level_id->Visible) { // langauge_level_id ?>
		<td data-name="langauge_level_id"<?php echo $students->langauge_level_id->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_langauge_level_id" class="form-group students_langauge_level_id">
<input type="text" data-table="students" data-field="x_langauge_level_id" name="x<?php echo $students_list->RowIndex ?>_langauge_level_id" id="x<?php echo $students_list->RowIndex ?>_langauge_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->langauge_level_id->getPlaceHolder()) ?>" value="<?php echo $students->langauge_level_id->EditValue ?>"<?php echo $students->langauge_level_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_langauge_level_id" name="o<?php echo $students_list->RowIndex ?>_langauge_level_id" id="o<?php echo $students_list->RowIndex ?>_langauge_level_id" value="<?php echo ew_HtmlEncode($students->langauge_level_id->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_langauge_level_id" class="students_langauge_level_id">
<span<?php echo $students->langauge_level_id->ViewAttributes() ?>>
<?php echo $students->langauge_level_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->created_at->Visible) { // created_at ?>
		<td data-name="created_at"<?php echo $students->created_at->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_created_at" class="form-group students_created_at">
<input type="text" data-table="students" data-field="x_created_at" name="x<?php echo $students_list->RowIndex ?>_created_at" id="x<?php echo $students_list->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($students->created_at->getPlaceHolder()) ?>" value="<?php echo $students->created_at->EditValue ?>"<?php echo $students->created_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_created_at" name="o<?php echo $students_list->RowIndex ?>_created_at" id="o<?php echo $students_list->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($students->created_at->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_created_at" class="students_created_at">
<span<?php echo $students->created_at->ViewAttributes() ?>>
<?php echo $students->created_at->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($students->updated_at->Visible) { // updated_at ?>
		<td data-name="updated_at"<?php echo $students->updated_at->CellAttributes() ?>>
<?php if ($students->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_updated_at" class="form-group students_updated_at">
<input type="text" data-table="students" data-field="x_updated_at" name="x<?php echo $students_list->RowIndex ?>_updated_at" id="x<?php echo $students_list->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($students->updated_at->getPlaceHolder()) ?>" value="<?php echo $students->updated_at->EditValue ?>"<?php echo $students->updated_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_updated_at" name="o<?php echo $students_list->RowIndex ?>_updated_at" id="o<?php echo $students_list->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($students->updated_at->OldValue) ?>">
<?php } ?>
<?php if ($students->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $students_list->RowCnt ?>_students_updated_at" class="students_updated_at">
<span<?php echo $students->updated_at->ViewAttributes() ?>>
<?php echo $students->updated_at->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$students_list->ListOptions->Render("body", "right", $students_list->RowCnt);
?>
	</tr>
<?php if ($students->RowType == EW_ROWTYPE_ADD || $students->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fstudentslist.UpdateOpts(<?php echo $students_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($students->CurrentAction <> "gridadd")
		if (!$students_list->Recordset->EOF) $students_list->Recordset->MoveNext();
}
?>
<?php
	if ($students->CurrentAction == "gridadd" || $students->CurrentAction == "gridedit") {
		$students_list->RowIndex = '$rowindex$';
		$students_list->LoadRowValues();

		// Set row properties
		$students->ResetAttrs();
		$students->RowAttrs = array_merge($students->RowAttrs, array('data-rowindex'=>$students_list->RowIndex, 'id'=>'r0_students', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($students->RowAttrs["class"], "ewTemplate");
		$students->RowType = EW_ROWTYPE_ADD;

		// Render row
		$students_list->RenderRow();

		// Render list options
		$students_list->RenderListOptions();
		$students_list->StartRowCnt = 0;
?>
	<tr<?php echo $students->RowAttributes() ?>>
<?php

// Render list options (body, left)
$students_list->ListOptions->Render("body", "left", $students_list->RowIndex);
?>
	<?php if ($students->user_id->Visible) { // user_id ?>
		<td data-name="user_id">
<?php if ($students->user_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_students_user_id" class="form-group students_user_id">
<span<?php echo $students->user_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $students->user_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $students_list->RowIndex ?>_user_id" name="x<?php echo $students_list->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_students_user_id" class="form-group students_user_id">
<input type="text" data-table="students" data-field="x_user_id" name="x<?php echo $students_list->RowIndex ?>_user_id" id="x<?php echo $students_list->RowIndex ?>_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->user_id->getPlaceHolder()) ?>" value="<?php echo $students->user_id->EditValue ?>"<?php echo $students->user_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="students" data-field="x_user_id" name="o<?php echo $students_list->RowIndex ?>_user_id" id="o<?php echo $students_list->RowIndex ?>_user_id" value="<?php echo ew_HtmlEncode($students->user_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->is_parent->Visible) { // is_parent ?>
		<td data-name="is_parent">
<span id="el$rowindex$_students_is_parent" class="form-group students_is_parent">
<input type="text" data-table="students" data-field="x_is_parent" name="x<?php echo $students_list->RowIndex ?>_is_parent" id="x<?php echo $students_list->RowIndex ?>_is_parent" size="30" placeholder="<?php echo ew_HtmlEncode($students->is_parent->getPlaceHolder()) ?>" value="<?php echo $students->is_parent->EditValue ?>"<?php echo $students->is_parent->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_is_parent" name="o<?php echo $students_list->RowIndex ?>_is_parent" id="o<?php echo $students_list->RowIndex ?>_is_parent" value="<?php echo ew_HtmlEncode($students->is_parent->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->level_id->Visible) { // level_id ?>
		<td data-name="level_id">
<span id="el$rowindex$_students_level_id" class="form-group students_level_id">
<input type="text" data-table="students" data-field="x_level_id" name="x<?php echo $students_list->RowIndex ?>_level_id" id="x<?php echo $students_list->RowIndex ?>_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->level_id->getPlaceHolder()) ?>" value="<?php echo $students->level_id->EditValue ?>"<?php echo $students->level_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_level_id" name="o<?php echo $students_list->RowIndex ?>_level_id" id="o<?php echo $students_list->RowIndex ?>_level_id" value="<?php echo ew_HtmlEncode($students->level_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->study_year->Visible) { // study_year ?>
		<td data-name="study_year">
<span id="el$rowindex$_students_study_year" class="form-group students_study_year">
<div id="tp_x<?php echo $students_list->RowIndex ?>_study_year" class="ewTemplate"><input type="radio" data-table="students" data-field="x_study_year" data-value-separator="<?php echo $students->study_year->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $students_list->RowIndex ?>_study_year" id="x<?php echo $students_list->RowIndex ?>_study_year" value="{value}"<?php echo $students->study_year->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $students_list->RowIndex ?>_study_year" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $students->study_year->RadioButtonListHtml(FALSE, "x{$students_list->RowIndex}_study_year") ?>
</div></div>
</span>
<input type="hidden" data-table="students" data-field="x_study_year" name="o<?php echo $students_list->RowIndex ?>_study_year" id="o<?php echo $students_list->RowIndex ?>_study_year" value="<?php echo ew_HtmlEncode($students->study_year->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->language_id->Visible) { // language_id ?>
		<td data-name="language_id">
<span id="el$rowindex$_students_language_id" class="form-group students_language_id">
<input type="text" data-table="students" data-field="x_language_id" name="x<?php echo $students_list->RowIndex ?>_language_id" id="x<?php echo $students_list->RowIndex ?>_language_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->language_id->getPlaceHolder()) ?>" value="<?php echo $students->language_id->EditValue ?>"<?php echo $students->language_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_language_id" name="o<?php echo $students_list->RowIndex ?>_language_id" id="o<?php echo $students_list->RowIndex ?>_language_id" value="<?php echo ew_HtmlEncode($students->language_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->langauge_level_id->Visible) { // langauge_level_id ?>
		<td data-name="langauge_level_id">
<span id="el$rowindex$_students_langauge_level_id" class="form-group students_langauge_level_id">
<input type="text" data-table="students" data-field="x_langauge_level_id" name="x<?php echo $students_list->RowIndex ?>_langauge_level_id" id="x<?php echo $students_list->RowIndex ?>_langauge_level_id" size="30" placeholder="<?php echo ew_HtmlEncode($students->langauge_level_id->getPlaceHolder()) ?>" value="<?php echo $students->langauge_level_id->EditValue ?>"<?php echo $students->langauge_level_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_langauge_level_id" name="o<?php echo $students_list->RowIndex ?>_langauge_level_id" id="o<?php echo $students_list->RowIndex ?>_langauge_level_id" value="<?php echo ew_HtmlEncode($students->langauge_level_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->created_at->Visible) { // created_at ?>
		<td data-name="created_at">
<span id="el$rowindex$_students_created_at" class="form-group students_created_at">
<input type="text" data-table="students" data-field="x_created_at" name="x<?php echo $students_list->RowIndex ?>_created_at" id="x<?php echo $students_list->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($students->created_at->getPlaceHolder()) ?>" value="<?php echo $students->created_at->EditValue ?>"<?php echo $students->created_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_created_at" name="o<?php echo $students_list->RowIndex ?>_created_at" id="o<?php echo $students_list->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($students->created_at->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($students->updated_at->Visible) { // updated_at ?>
		<td data-name="updated_at">
<span id="el$rowindex$_students_updated_at" class="form-group students_updated_at">
<input type="text" data-table="students" data-field="x_updated_at" name="x<?php echo $students_list->RowIndex ?>_updated_at" id="x<?php echo $students_list->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($students->updated_at->getPlaceHolder()) ?>" value="<?php echo $students->updated_at->EditValue ?>"<?php echo $students->updated_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="students" data-field="x_updated_at" name="o<?php echo $students_list->RowIndex ?>_updated_at" id="o<?php echo $students_list->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($students->updated_at->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$students_list->ListOptions->Render("body", "right", $students_list->RowIndex);
?>
<script type="text/javascript">
fstudentslist.UpdateOpts(<?php echo $students_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($students->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $students_list->FormKeyCountName ?>" id="<?php echo $students_list->FormKeyCountName ?>" value="<?php echo $students_list->KeyCount ?>">
<?php echo $students_list->MultiSelectKey ?>
<?php } ?>
<?php if ($students->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($students_list->Recordset)
	$students_list->Recordset->Close();
?>
<?php if ($students->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($students->CurrentAction <> "gridadd" && $students->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($students_list->Pager)) $students_list->Pager = new cPrevNextPager($students_list->StartRec, $students_list->DisplayRecs, $students_list->TotalRecs, $students_list->AutoHidePager) ?>
<?php if ($students_list->Pager->RecordCount > 0 && $students_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($students_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $students_list->PageUrl() ?>start=<?php echo $students_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($students_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $students_list->PageUrl() ?>start=<?php echo $students_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $students_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($students_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $students_list->PageUrl() ?>start=<?php echo $students_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($students_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $students_list->PageUrl() ?>start=<?php echo $students_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $students_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($students_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $students_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $students_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $students_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($students_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($students_list->TotalRecs == 0 && $students->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($students_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($students->Export == "") { ?>
<script type="text/javascript">
fstudentslistsrch.FilterList = <?php echo $students_list->GetFilterList() ?>;
fstudentslistsrch.Init();
fstudentslist.Init();
</script>
<?php } ?>
<?php
$students_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($students->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$students_list->Page_Terminate();
?>
