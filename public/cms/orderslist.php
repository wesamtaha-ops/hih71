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

$orders_list = NULL; // Initialize page object first

class corders_list extends corders {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'orders';

	// Page object name
	var $PageObjName = 'orders_list';

	// Grid form hidden field names
	var $FormName = 'forderslist';
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

		// Table object (orders)
		if (!isset($GLOBALS["orders"]) || get_class($GLOBALS["orders"]) == "corders") {
			$GLOBALS["orders"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["orders"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "ordersadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "ordersdelete.php";
		$this->MultiUpdateUrl = "ordersupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption forderslistsrch";

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
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

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

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

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

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();

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
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

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
		if ($objForm->HasValue("x_student_id") && $objForm->HasValue("o_student_id") && $this->student_id->CurrentValue <> $this->student_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_teacher_id") && $objForm->HasValue("o_teacher_id") && $this->teacher_id->CurrentValue <> $this->teacher_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_topic_id") && $objForm->HasValue("o_topic_id") && $this->topic_id->CurrentValue <> $this->topic_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_date") && $objForm->HasValue("o_date") && $this->date->CurrentValue <> $this->date->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_time") && $objForm->HasValue("o_time") && $this->time->CurrentValue <> $this->time->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_fees") && $objForm->HasValue("o_fees") && $this->fees->CurrentValue <> $this->fees->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_currency_id") && $objForm->HasValue("o_currency_id") && $this->currency_id->CurrentValue <> $this->currency_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_status") && $objForm->HasValue("o_status") && $this->status->CurrentValue <> $this->status->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_meeting_id") && $objForm->HasValue("o_meeting_id") && $this->meeting_id->CurrentValue <> $this->meeting_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_package_id") && $objForm->HasValue("o_package_id") && $this->package_id->CurrentValue <> $this->package_id->OldValue)
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
		$sFilterList = ew_Concat($sFilterList, $this->student_id->AdvancedSearch->ToJson(), ","); // Field student_id
		$sFilterList = ew_Concat($sFilterList, $this->teacher_id->AdvancedSearch->ToJson(), ","); // Field teacher_id
		$sFilterList = ew_Concat($sFilterList, $this->topic_id->AdvancedSearch->ToJson(), ","); // Field topic_id
		$sFilterList = ew_Concat($sFilterList, $this->date->AdvancedSearch->ToJson(), ","); // Field date
		$sFilterList = ew_Concat($sFilterList, $this->time->AdvancedSearch->ToJson(), ","); // Field time
		$sFilterList = ew_Concat($sFilterList, $this->fees->AdvancedSearch->ToJson(), ","); // Field fees
		$sFilterList = ew_Concat($sFilterList, $this->currency_id->AdvancedSearch->ToJson(), ","); // Field currency_id
		$sFilterList = ew_Concat($sFilterList, $this->status->AdvancedSearch->ToJson(), ","); // Field status
		$sFilterList = ew_Concat($sFilterList, $this->meeting_id->AdvancedSearch->ToJson(), ","); // Field meeting_id
		$sFilterList = ew_Concat($sFilterList, $this->package_id->AdvancedSearch->ToJson(), ","); // Field package_id
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "forderslistsrch", $filters);

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

		// Field student_id
		$this->student_id->AdvancedSearch->SearchValue = @$filter["x_student_id"];
		$this->student_id->AdvancedSearch->SearchOperator = @$filter["z_student_id"];
		$this->student_id->AdvancedSearch->SearchCondition = @$filter["v_student_id"];
		$this->student_id->AdvancedSearch->SearchValue2 = @$filter["y_student_id"];
		$this->student_id->AdvancedSearch->SearchOperator2 = @$filter["w_student_id"];
		$this->student_id->AdvancedSearch->Save();

		// Field teacher_id
		$this->teacher_id->AdvancedSearch->SearchValue = @$filter["x_teacher_id"];
		$this->teacher_id->AdvancedSearch->SearchOperator = @$filter["z_teacher_id"];
		$this->teacher_id->AdvancedSearch->SearchCondition = @$filter["v_teacher_id"];
		$this->teacher_id->AdvancedSearch->SearchValue2 = @$filter["y_teacher_id"];
		$this->teacher_id->AdvancedSearch->SearchOperator2 = @$filter["w_teacher_id"];
		$this->teacher_id->AdvancedSearch->Save();

		// Field topic_id
		$this->topic_id->AdvancedSearch->SearchValue = @$filter["x_topic_id"];
		$this->topic_id->AdvancedSearch->SearchOperator = @$filter["z_topic_id"];
		$this->topic_id->AdvancedSearch->SearchCondition = @$filter["v_topic_id"];
		$this->topic_id->AdvancedSearch->SearchValue2 = @$filter["y_topic_id"];
		$this->topic_id->AdvancedSearch->SearchOperator2 = @$filter["w_topic_id"];
		$this->topic_id->AdvancedSearch->Save();

		// Field date
		$this->date->AdvancedSearch->SearchValue = @$filter["x_date"];
		$this->date->AdvancedSearch->SearchOperator = @$filter["z_date"];
		$this->date->AdvancedSearch->SearchCondition = @$filter["v_date"];
		$this->date->AdvancedSearch->SearchValue2 = @$filter["y_date"];
		$this->date->AdvancedSearch->SearchOperator2 = @$filter["w_date"];
		$this->date->AdvancedSearch->Save();

		// Field time
		$this->time->AdvancedSearch->SearchValue = @$filter["x_time"];
		$this->time->AdvancedSearch->SearchOperator = @$filter["z_time"];
		$this->time->AdvancedSearch->SearchCondition = @$filter["v_time"];
		$this->time->AdvancedSearch->SearchValue2 = @$filter["y_time"];
		$this->time->AdvancedSearch->SearchOperator2 = @$filter["w_time"];
		$this->time->AdvancedSearch->Save();

		// Field fees
		$this->fees->AdvancedSearch->SearchValue = @$filter["x_fees"];
		$this->fees->AdvancedSearch->SearchOperator = @$filter["z_fees"];
		$this->fees->AdvancedSearch->SearchCondition = @$filter["v_fees"];
		$this->fees->AdvancedSearch->SearchValue2 = @$filter["y_fees"];
		$this->fees->AdvancedSearch->SearchOperator2 = @$filter["w_fees"];
		$this->fees->AdvancedSearch->Save();

		// Field currency_id
		$this->currency_id->AdvancedSearch->SearchValue = @$filter["x_currency_id"];
		$this->currency_id->AdvancedSearch->SearchOperator = @$filter["z_currency_id"];
		$this->currency_id->AdvancedSearch->SearchCondition = @$filter["v_currency_id"];
		$this->currency_id->AdvancedSearch->SearchValue2 = @$filter["y_currency_id"];
		$this->currency_id->AdvancedSearch->SearchOperator2 = @$filter["w_currency_id"];
		$this->currency_id->AdvancedSearch->Save();

		// Field status
		$this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
		$this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
		$this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
		$this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
		$this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
		$this->status->AdvancedSearch->Save();

		// Field meeting_id
		$this->meeting_id->AdvancedSearch->SearchValue = @$filter["x_meeting_id"];
		$this->meeting_id->AdvancedSearch->SearchOperator = @$filter["z_meeting_id"];
		$this->meeting_id->AdvancedSearch->SearchCondition = @$filter["v_meeting_id"];
		$this->meeting_id->AdvancedSearch->SearchValue2 = @$filter["y_meeting_id"];
		$this->meeting_id->AdvancedSearch->SearchOperator2 = @$filter["w_meeting_id"];
		$this->meeting_id->AdvancedSearch->Save();

		// Field package_id
		$this->package_id->AdvancedSearch->SearchValue = @$filter["x_package_id"];
		$this->package_id->AdvancedSearch->SearchOperator = @$filter["z_package_id"];
		$this->package_id->AdvancedSearch->SearchCondition = @$filter["v_package_id"];
		$this->package_id->AdvancedSearch->SearchValue2 = @$filter["y_package_id"];
		$this->package_id->AdvancedSearch->SearchOperator2 = @$filter["w_package_id"];
		$this->package_id->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->id, $Default, FALSE); // id
		$this->BuildSearchSql($sWhere, $this->student_id, $Default, FALSE); // student_id
		$this->BuildSearchSql($sWhere, $this->teacher_id, $Default, FALSE); // teacher_id
		$this->BuildSearchSql($sWhere, $this->topic_id, $Default, FALSE); // topic_id
		$this->BuildSearchSql($sWhere, $this->date, $Default, FALSE); // date
		$this->BuildSearchSql($sWhere, $this->time, $Default, FALSE); // time
		$this->BuildSearchSql($sWhere, $this->fees, $Default, FALSE); // fees
		$this->BuildSearchSql($sWhere, $this->currency_id, $Default, FALSE); // currency_id
		$this->BuildSearchSql($sWhere, $this->status, $Default, FALSE); // status
		$this->BuildSearchSql($sWhere, $this->meeting_id, $Default, FALSE); // meeting_id
		$this->BuildSearchSql($sWhere, $this->package_id, $Default, FALSE); // package_id

		// Set up search parm
		if (!$Default && $sWhere <> "" && in_array($this->Command, array("", "reset", "resetall"))) {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->id->AdvancedSearch->Save(); // id
			$this->student_id->AdvancedSearch->Save(); // student_id
			$this->teacher_id->AdvancedSearch->Save(); // teacher_id
			$this->topic_id->AdvancedSearch->Save(); // topic_id
			$this->date->AdvancedSearch->Save(); // date
			$this->time->AdvancedSearch->Save(); // time
			$this->fees->AdvancedSearch->Save(); // fees
			$this->currency_id->AdvancedSearch->Save(); // currency_id
			$this->status->AdvancedSearch->Save(); // status
			$this->meeting_id->AdvancedSearch->Save(); // meeting_id
			$this->package_id->AdvancedSearch->Save(); // package_id
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

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->time, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->meeting_id, $arKeywords, $type);
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
		if ($this->id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->student_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->teacher_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->topic_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->time->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fees->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->currency_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->status->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->meeting_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->package_id->AdvancedSearch->IssetSession())
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

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->id->AdvancedSearch->UnsetSession();
		$this->student_id->AdvancedSearch->UnsetSession();
		$this->teacher_id->AdvancedSearch->UnsetSession();
		$this->topic_id->AdvancedSearch->UnsetSession();
		$this->date->AdvancedSearch->UnsetSession();
		$this->time->AdvancedSearch->UnsetSession();
		$this->fees->AdvancedSearch->UnsetSession();
		$this->currency_id->AdvancedSearch->UnsetSession();
		$this->status->AdvancedSearch->UnsetSession();
		$this->meeting_id->AdvancedSearch->UnsetSession();
		$this->package_id->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->id->AdvancedSearch->Load();
		$this->student_id->AdvancedSearch->Load();
		$this->teacher_id->AdvancedSearch->Load();
		$this->topic_id->AdvancedSearch->Load();
		$this->date->AdvancedSearch->Load();
		$this->time->AdvancedSearch->Load();
		$this->fees->AdvancedSearch->Load();
		$this->currency_id->AdvancedSearch->Load();
		$this->status->AdvancedSearch->Load();
		$this->meeting_id->AdvancedSearch->Load();
		$this->package_id->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id); // id
			$this->UpdateSort($this->student_id); // student_id
			$this->UpdateSort($this->teacher_id); // teacher_id
			$this->UpdateSort($this->topic_id); // topic_id
			$this->UpdateSort($this->date); // date
			$this->UpdateSort($this->time); // time
			$this->UpdateSort($this->fees); // fees
			$this->UpdateSort($this->currency_id); // currency_id
			$this->UpdateSort($this->status); // status
			$this->UpdateSort($this->meeting_id); // meeting_id
			$this->UpdateSort($this->package_id); // package_id
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

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id->setSort("");
				$this->student_id->setSort("");
				$this->teacher_id->setSort("");
				$this->topic_id->setSort("");
				$this->date->setSort("");
				$this->time->setSort("");
				$this->fees->setSort("");
				$this->currency_id->setSort("");
				$this->status->setSort("");
				$this->meeting_id->setSort("");
				$this->package_id->setSort("");
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
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.forderslist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"forderslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"forderslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.forderslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"forderslistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->status->OldValue = $this->status->CurrentValue;
		$this->meeting_id->CurrentValue = NULL;
		$this->meeting_id->OldValue = $this->meeting_id->CurrentValue;
		$this->created_at->CurrentValue = NULL;
		$this->created_at->OldValue = $this->created_at->CurrentValue;
		$this->updated_at->CurrentValue = NULL;
		$this->updated_at->OldValue = $this->updated_at->CurrentValue;
		$this->package_id->CurrentValue = NULL;
		$this->package_id->OldValue = $this->package_id->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// id

		$this->id->AdvancedSearch->SearchValue = @$_GET["x_id"];
		if ($this->id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->id->AdvancedSearch->SearchOperator = @$_GET["z_id"];

		// student_id
		$this->student_id->AdvancedSearch->SearchValue = @$_GET["x_student_id"];
		if ($this->student_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->student_id->AdvancedSearch->SearchOperator = @$_GET["z_student_id"];

		// teacher_id
		$this->teacher_id->AdvancedSearch->SearchValue = @$_GET["x_teacher_id"];
		if ($this->teacher_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->teacher_id->AdvancedSearch->SearchOperator = @$_GET["z_teacher_id"];

		// topic_id
		$this->topic_id->AdvancedSearch->SearchValue = @$_GET["x_topic_id"];
		if ($this->topic_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->topic_id->AdvancedSearch->SearchOperator = @$_GET["z_topic_id"];

		// date
		$this->date->AdvancedSearch->SearchValue = @$_GET["x_date"];
		if ($this->date->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->date->AdvancedSearch->SearchOperator = @$_GET["z_date"];

		// time
		$this->time->AdvancedSearch->SearchValue = @$_GET["x_time"];
		if ($this->time->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->time->AdvancedSearch->SearchOperator = @$_GET["z_time"];

		// fees
		$this->fees->AdvancedSearch->SearchValue = @$_GET["x_fees"];
		if ($this->fees->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->fees->AdvancedSearch->SearchOperator = @$_GET["z_fees"];

		// currency_id
		$this->currency_id->AdvancedSearch->SearchValue = @$_GET["x_currency_id"];
		if ($this->currency_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->currency_id->AdvancedSearch->SearchOperator = @$_GET["z_currency_id"];

		// status
		$this->status->AdvancedSearch->SearchValue = @$_GET["x_status"];
		if ($this->status->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->status->AdvancedSearch->SearchOperator = @$_GET["z_status"];

		// meeting_id
		$this->meeting_id->AdvancedSearch->SearchValue = @$_GET["x_meeting_id"];
		if ($this->meeting_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->meeting_id->AdvancedSearch->SearchOperator = @$_GET["z_meeting_id"];

		// package_id
		$this->package_id->AdvancedSearch->SearchValue = @$_GET["x_package_id"];
		if ($this->package_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->package_id->AdvancedSearch->SearchOperator = @$_GET["z_package_id"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->student_id->FldIsDetailKey) {
			$this->student_id->setFormValue($objForm->GetValue("x_student_id"));
		}
		$this->student_id->setOldValue($objForm->GetValue("o_student_id"));
		if (!$this->teacher_id->FldIsDetailKey) {
			$this->teacher_id->setFormValue($objForm->GetValue("x_teacher_id"));
		}
		$this->teacher_id->setOldValue($objForm->GetValue("o_teacher_id"));
		if (!$this->topic_id->FldIsDetailKey) {
			$this->topic_id->setFormValue($objForm->GetValue("x_topic_id"));
		}
		$this->topic_id->setOldValue($objForm->GetValue("o_topic_id"));
		if (!$this->date->FldIsDetailKey) {
			$this->date->setFormValue($objForm->GetValue("x_date"));
			$this->date->CurrentValue = ew_UnFormatDateTime($this->date->CurrentValue, 0);
		}
		$this->date->setOldValue($objForm->GetValue("o_date"));
		if (!$this->time->FldIsDetailKey) {
			$this->time->setFormValue($objForm->GetValue("x_time"));
		}
		$this->time->setOldValue($objForm->GetValue("o_time"));
		if (!$this->fees->FldIsDetailKey) {
			$this->fees->setFormValue($objForm->GetValue("x_fees"));
		}
		$this->fees->setOldValue($objForm->GetValue("o_fees"));
		if (!$this->currency_id->FldIsDetailKey) {
			$this->currency_id->setFormValue($objForm->GetValue("x_currency_id"));
		}
		$this->currency_id->setOldValue($objForm->GetValue("o_currency_id"));
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		$this->status->setOldValue($objForm->GetValue("o_status"));
		if (!$this->meeting_id->FldIsDetailKey) {
			$this->meeting_id->setFormValue($objForm->GetValue("x_meeting_id"));
		}
		$this->meeting_id->setOldValue($objForm->GetValue("o_meeting_id"));
		if (!$this->package_id->FldIsDetailKey) {
			$this->package_id->setFormValue($objForm->GetValue("x_package_id"));
		}
		$this->package_id->setOldValue($objForm->GetValue("o_package_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
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
		$this->package_id->CurrentValue = $this->package_id->FormValue;
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

		$this->created_at->CellCssStyle = "white-space: nowrap;";

		// updated_at
		$this->updated_at->CellCssStyle = "white-space: nowrap;";

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

			// package_id
			$this->package_id->LinkCustomAttributes = "";
			$this->package_id->HrefValue = "";
			$this->package_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id
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

			// package_id
			$this->package_id->LinkCustomAttributes = "";
			$this->package_id->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

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

			// package_id
			$this->package_id->LinkCustomAttributes = "";
			$this->package_id->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = ew_HtmlEncode($this->id->AdvancedSearch->SearchValue);
			$this->id->PlaceHolder = ew_RemoveHtml($this->id->FldCaption());

			// student_id
			$this->student_id->EditAttrs["class"] = "form-control";
			$this->student_id->EditCustomAttributes = "";

			// teacher_id
			$this->teacher_id->EditAttrs["class"] = "form-control";
			$this->teacher_id->EditCustomAttributes = "";

			// topic_id
			$this->topic_id->EditAttrs["class"] = "form-control";
			$this->topic_id->EditCustomAttributes = "";

			// date
			$this->date->EditAttrs["class"] = "form-control";
			$this->date->EditCustomAttributes = "";
			$this->date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->date->AdvancedSearch->SearchValue, 0), 8));
			$this->date->PlaceHolder = ew_RemoveHtml($this->date->FldCaption());

			// time
			$this->time->EditAttrs["class"] = "form-control";
			$this->time->EditCustomAttributes = "";
			$this->time->EditValue = ew_HtmlEncode($this->time->AdvancedSearch->SearchValue);
			$this->time->PlaceHolder = ew_RemoveHtml($this->time->FldCaption());

			// fees
			$this->fees->EditAttrs["class"] = "form-control";
			$this->fees->EditCustomAttributes = "";
			$this->fees->EditValue = ew_HtmlEncode($this->fees->AdvancedSearch->SearchValue);
			$this->fees->PlaceHolder = ew_RemoveHtml($this->fees->FldCaption());

			// currency_id
			$this->currency_id->EditAttrs["class"] = "form-control";
			$this->currency_id->EditCustomAttributes = "";

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(TRUE);

			// meeting_id
			$this->meeting_id->EditAttrs["class"] = "form-control";
			$this->meeting_id->EditCustomAttributes = "";
			$this->meeting_id->EditValue = ew_HtmlEncode($this->meeting_id->AdvancedSearch->SearchValue);
			$this->meeting_id->PlaceHolder = ew_RemoveHtml($this->meeting_id->FldCaption());

			// package_id
			$this->package_id->EditAttrs["class"] = "form-control";
			$this->package_id->EditCustomAttributes = "";
			$this->package_id->EditValue = ew_HtmlEncode($this->package_id->AdvancedSearch->SearchValue);
			$this->package_id->PlaceHolder = ew_RemoveHtml($this->package_id->FldCaption());
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

			// package_id
			$this->package_id->SetDbValueDef($rsnew, $this->package_id->CurrentValue, NULL, $this->package_id->ReadOnly);

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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->id->AdvancedSearch->Load();
		$this->student_id->AdvancedSearch->Load();
		$this->teacher_id->AdvancedSearch->Load();
		$this->topic_id->AdvancedSearch->Load();
		$this->date->AdvancedSearch->Load();
		$this->time->AdvancedSearch->Load();
		$this->fees->AdvancedSearch->Load();
		$this->currency_id->AdvancedSearch->Load();
		$this->status->AdvancedSearch->Load();
		$this->meeting_id->AdvancedSearch->Load();
		$this->package_id->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_orders\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_orders',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.forderslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($orders_list)) $orders_list = new corders_list();

// Page init
$orders_list->Page_Init();

// Page main
$orders_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$orders_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($orders->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = forderslist = new ew_Form("forderslist", "list");
forderslist.FormKeyCountName = '<?php echo $orders_list->FormKeyCountName ?>';

// Validate form
forderslist.Validate = function() {
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
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
forderslist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "student_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "teacher_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "topic_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "date", false)) return false;
	if (ew_ValueChanged(fobj, infix, "time", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fees", false)) return false;
	if (ew_ValueChanged(fobj, infix, "currency_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "meeting_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "package_id", false)) return false;
	return true;
}

// Form_CustomValidate event
forderslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
forderslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
forderslist.Lists["x_student_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"users"};
forderslist.Lists["x_student_id"].Data = "<?php echo $orders_list->student_id->LookupFilterQuery(FALSE, "list") ?>";
forderslist.Lists["x_teacher_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"users"};
forderslist.Lists["x_teacher_id"].Data = "<?php echo $orders_list->teacher_id->LookupFilterQuery(FALSE, "list") ?>";
forderslist.Lists["x_topic_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name_ar","x_name_en","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"topics"};
forderslist.Lists["x_topic_id"].Data = "<?php echo $orders_list->topic_id->LookupFilterQuery(FALSE, "list") ?>";
forderslist.Lists["x_currency_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name_ar","x_name_en","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"currencies"};
forderslist.Lists["x_currency_id"].Data = "<?php echo $orders_list->currency_id->LookupFilterQuery(FALSE, "list") ?>";
forderslist.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
forderslist.Lists["x_status"].Options = <?php echo json_encode($orders_list->status->Options()) ?>;

// Form object for search
var CurrentSearchForm = forderslistsrch = new ew_Form("forderslistsrch");

// Validate function for search
forderslistsrch.Validate = function(fobj) {
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
forderslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
forderslistsrch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
forderslistsrch.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
forderslistsrch.Lists["x_status"].Options = <?php echo json_encode($orders_list->status->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($orders->Export == "") { ?>
<div class="ewToolbar">
<?php if ($orders_list->TotalRecs > 0 && $orders_list->ExportOptions->Visible()) { ?>
<?php $orders_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($orders_list->SearchOptions->Visible()) { ?>
<?php $orders_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($orders_list->FilterOptions->Visible()) { ?>
<?php $orders_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($orders->CurrentAction == "gridadd") {
	$orders->CurrentFilter = "0=1";
	$orders_list->StartRec = 1;
	$orders_list->DisplayRecs = $orders->GridAddRowCount;
	$orders_list->TotalRecs = $orders_list->DisplayRecs;
	$orders_list->StopRec = $orders_list->DisplayRecs;
} else {
	$bSelectLimit = $orders_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($orders_list->TotalRecs <= 0)
			$orders_list->TotalRecs = $orders->ListRecordCount();
	} else {
		if (!$orders_list->Recordset && ($orders_list->Recordset = $orders_list->LoadRecordset()))
			$orders_list->TotalRecs = $orders_list->Recordset->RecordCount();
	}
	$orders_list->StartRec = 1;
	if ($orders_list->DisplayRecs <= 0 || ($orders->Export <> "" && $orders->ExportAll)) // Display all records
		$orders_list->DisplayRecs = $orders_list->TotalRecs;
	if (!($orders->Export <> "" && $orders->ExportAll))
		$orders_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$orders_list->Recordset = $orders_list->LoadRecordset($orders_list->StartRec-1, $orders_list->DisplayRecs);

	// Set no record found message
	if ($orders->CurrentAction == "" && $orders_list->TotalRecs == 0) {
		if ($orders_list->SearchWhere == "0=101")
			$orders_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$orders_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$orders_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($orders->Export == "" && $orders->CurrentAction == "") { ?>
<form name="forderslistsrch" id="forderslistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($orders_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="forderslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="orders">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$orders_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$orders->RowType = EW_ROWTYPE_SEARCH;

// Render row
$orders->ResetAttrs();
$orders_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($orders->status->Visible) { // status ?>
	<div id="xsc_status" class="ewCell form-group">
		<label for="x_status" class="ewSearchCaption ewLabel"><?php echo $orders->status->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_status" id="z_status" value="="></span>
		<span class="ewSearchField">
<select data-table="orders" data-field="x_status" data-value-separator="<?php echo $orders->status->DisplayValueSeparatorAttribute() ?>" id="x_status" name="x_status"<?php echo $orders->status->EditAttributes() ?>>
<?php echo $orders->status->SelectOptionListHtml("x_status") ?>
</select>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($orders_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($orders_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $orders_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($orders_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($orders_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($orders_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($orders_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $orders_list->ShowPageHeader(); ?>
<?php
$orders_list->ShowMessage();
?>
<?php if ($orders_list->TotalRecs > 0 || $orders->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($orders_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> orders">
<?php if ($orders->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($orders->CurrentAction <> "gridadd" && $orders->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($orders_list->Pager)) $orders_list->Pager = new cPrevNextPager($orders_list->StartRec, $orders_list->DisplayRecs, $orders_list->TotalRecs, $orders_list->AutoHidePager) ?>
<?php if ($orders_list->Pager->RecordCount > 0 && $orders_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($orders_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($orders_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $orders_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($orders_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($orders_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $orders_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($orders_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $orders_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $orders_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $orders_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($orders_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="forderslist" id="forderslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($orders_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $orders_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="orders">
<div id="gmp_orders" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($orders_list->TotalRecs > 0 || $orders->CurrentAction == "gridedit") { ?>
<table id="tbl_orderslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$orders_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$orders_list->RenderListOptions();

// Render list options (header, left)
$orders_list->ListOptions->Render("header", "left");
?>
<?php if ($orders->id->Visible) { // id ?>
	<?php if ($orders->SortUrl($orders->id) == "") { ?>
		<th data-name="id" class="<?php echo $orders->id->HeaderCellClass() ?>"><div id="elh_orders_id" class="orders_id"><div class="ewTableHeaderCaption"><?php echo $orders->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $orders->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->id) ?>',1);"><div id="elh_orders_id" class="orders_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->student_id->Visible) { // student_id ?>
	<?php if ($orders->SortUrl($orders->student_id) == "") { ?>
		<th data-name="student_id" class="<?php echo $orders->student_id->HeaderCellClass() ?>"><div id="elh_orders_student_id" class="orders_student_id"><div class="ewTableHeaderCaption"><?php echo $orders->student_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="student_id" class="<?php echo $orders->student_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->student_id) ?>',1);"><div id="elh_orders_student_id" class="orders_student_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->student_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->student_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->student_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->teacher_id->Visible) { // teacher_id ?>
	<?php if ($orders->SortUrl($orders->teacher_id) == "") { ?>
		<th data-name="teacher_id" class="<?php echo $orders->teacher_id->HeaderCellClass() ?>"><div id="elh_orders_teacher_id" class="orders_teacher_id"><div class="ewTableHeaderCaption"><?php echo $orders->teacher_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="teacher_id" class="<?php echo $orders->teacher_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->teacher_id) ?>',1);"><div id="elh_orders_teacher_id" class="orders_teacher_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->teacher_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->teacher_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->teacher_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->topic_id->Visible) { // topic_id ?>
	<?php if ($orders->SortUrl($orders->topic_id) == "") { ?>
		<th data-name="topic_id" class="<?php echo $orders->topic_id->HeaderCellClass() ?>"><div id="elh_orders_topic_id" class="orders_topic_id"><div class="ewTableHeaderCaption"><?php echo $orders->topic_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="topic_id" class="<?php echo $orders->topic_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->topic_id) ?>',1);"><div id="elh_orders_topic_id" class="orders_topic_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->topic_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->topic_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->topic_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->date->Visible) { // date ?>
	<?php if ($orders->SortUrl($orders->date) == "") { ?>
		<th data-name="date" class="<?php echo $orders->date->HeaderCellClass() ?>"><div id="elh_orders_date" class="orders_date"><div class="ewTableHeaderCaption"><?php echo $orders->date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date" class="<?php echo $orders->date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->date) ?>',1);"><div id="elh_orders_date" class="orders_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->time->Visible) { // time ?>
	<?php if ($orders->SortUrl($orders->time) == "") { ?>
		<th data-name="time" class="<?php echo $orders->time->HeaderCellClass() ?>"><div id="elh_orders_time" class="orders_time"><div class="ewTableHeaderCaption"><?php echo $orders->time->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="time" class="<?php echo $orders->time->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->time) ?>',1);"><div id="elh_orders_time" class="orders_time">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->time->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($orders->time->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->time->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->fees->Visible) { // fees ?>
	<?php if ($orders->SortUrl($orders->fees) == "") { ?>
		<th data-name="fees" class="<?php echo $orders->fees->HeaderCellClass() ?>"><div id="elh_orders_fees" class="orders_fees"><div class="ewTableHeaderCaption"><?php echo $orders->fees->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fees" class="<?php echo $orders->fees->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->fees) ?>',1);"><div id="elh_orders_fees" class="orders_fees">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->fees->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->fees->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->fees->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->currency_id->Visible) { // currency_id ?>
	<?php if ($orders->SortUrl($orders->currency_id) == "") { ?>
		<th data-name="currency_id" class="<?php echo $orders->currency_id->HeaderCellClass() ?>"><div id="elh_orders_currency_id" class="orders_currency_id"><div class="ewTableHeaderCaption"><?php echo $orders->currency_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency_id" class="<?php echo $orders->currency_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->currency_id) ?>',1);"><div id="elh_orders_currency_id" class="orders_currency_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->currency_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->currency_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->currency_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->status->Visible) { // status ?>
	<?php if ($orders->SortUrl($orders->status) == "") { ?>
		<th data-name="status" class="<?php echo $orders->status->HeaderCellClass() ?>"><div id="elh_orders_status" class="orders_status"><div class="ewTableHeaderCaption"><?php echo $orders->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $orders->status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->status) ?>',1);"><div id="elh_orders_status" class="orders_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->meeting_id->Visible) { // meeting_id ?>
	<?php if ($orders->SortUrl($orders->meeting_id) == "") { ?>
		<th data-name="meeting_id" class="<?php echo $orders->meeting_id->HeaderCellClass() ?>"><div id="elh_orders_meeting_id" class="orders_meeting_id"><div class="ewTableHeaderCaption"><?php echo $orders->meeting_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="meeting_id" class="<?php echo $orders->meeting_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->meeting_id) ?>',1);"><div id="elh_orders_meeting_id" class="orders_meeting_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->meeting_id->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($orders->meeting_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->meeting_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->package_id->Visible) { // package_id ?>
	<?php if ($orders->SortUrl($orders->package_id) == "") { ?>
		<th data-name="package_id" class="<?php echo $orders->package_id->HeaderCellClass() ?>"><div id="elh_orders_package_id" class="orders_package_id"><div class="ewTableHeaderCaption"><?php echo $orders->package_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="package_id" class="<?php echo $orders->package_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->package_id) ?>',1);"><div id="elh_orders_package_id" class="orders_package_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->package_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->package_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->package_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$orders_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($orders->ExportAll && $orders->Export <> "") {
	$orders_list->StopRec = $orders_list->TotalRecs;
} else {

	// Set the last record to display
	if ($orders_list->TotalRecs > $orders_list->StartRec + $orders_list->DisplayRecs - 1)
		$orders_list->StopRec = $orders_list->StartRec + $orders_list->DisplayRecs - 1;
	else
		$orders_list->StopRec = $orders_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($orders_list->FormKeyCountName) && ($orders->CurrentAction == "gridadd" || $orders->CurrentAction == "gridedit" || $orders->CurrentAction == "F")) {
		$orders_list->KeyCount = $objForm->GetValue($orders_list->FormKeyCountName);
		$orders_list->StopRec = $orders_list->StartRec + $orders_list->KeyCount - 1;
	}
}
$orders_list->RecCnt = $orders_list->StartRec - 1;
if ($orders_list->Recordset && !$orders_list->Recordset->EOF) {
	$orders_list->Recordset->MoveFirst();
	$bSelectLimit = $orders_list->UseSelectLimit;
	if (!$bSelectLimit && $orders_list->StartRec > 1)
		$orders_list->Recordset->Move($orders_list->StartRec - 1);
} elseif (!$orders->AllowAddDeleteRow && $orders_list->StopRec == 0) {
	$orders_list->StopRec = $orders->GridAddRowCount;
}

// Initialize aggregate
$orders->RowType = EW_ROWTYPE_AGGREGATEINIT;
$orders->ResetAttrs();
$orders_list->RenderRow();
if ($orders->CurrentAction == "gridadd")
	$orders_list->RowIndex = 0;
if ($orders->CurrentAction == "gridedit")
	$orders_list->RowIndex = 0;
while ($orders_list->RecCnt < $orders_list->StopRec) {
	$orders_list->RecCnt++;
	if (intval($orders_list->RecCnt) >= intval($orders_list->StartRec)) {
		$orders_list->RowCnt++;
		if ($orders->CurrentAction == "gridadd" || $orders->CurrentAction == "gridedit" || $orders->CurrentAction == "F") {
			$orders_list->RowIndex++;
			$objForm->Index = $orders_list->RowIndex;
			if ($objForm->HasValue($orders_list->FormActionName))
				$orders_list->RowAction = strval($objForm->GetValue($orders_list->FormActionName));
			elseif ($orders->CurrentAction == "gridadd")
				$orders_list->RowAction = "insert";
			else
				$orders_list->RowAction = "";
		}

		// Set up key count
		$orders_list->KeyCount = $orders_list->RowIndex;

		// Init row class and style
		$orders->ResetAttrs();
		$orders->CssClass = "";
		if ($orders->CurrentAction == "gridadd") {
			$orders_list->LoadRowValues(); // Load default values
		} else {
			$orders_list->LoadRowValues($orders_list->Recordset); // Load row values
		}
		$orders->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($orders->CurrentAction == "gridadd") // Grid add
			$orders->RowType = EW_ROWTYPE_ADD; // Render add
		if ($orders->CurrentAction == "gridadd" && $orders->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$orders_list->RestoreCurrentRowFormValues($orders_list->RowIndex); // Restore form values
		if ($orders->CurrentAction == "gridedit") { // Grid edit
			if ($orders->EventCancelled) {
				$orders_list->RestoreCurrentRowFormValues($orders_list->RowIndex); // Restore form values
			}
			if ($orders_list->RowAction == "insert")
				$orders->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$orders->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($orders->CurrentAction == "gridedit" && ($orders->RowType == EW_ROWTYPE_EDIT || $orders->RowType == EW_ROWTYPE_ADD) && $orders->EventCancelled) // Update failed
			$orders_list->RestoreCurrentRowFormValues($orders_list->RowIndex); // Restore form values
		if ($orders->RowType == EW_ROWTYPE_EDIT) // Edit row
			$orders_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$orders->RowAttrs = array_merge($orders->RowAttrs, array('data-rowindex'=>$orders_list->RowCnt, 'id'=>'r' . $orders_list->RowCnt . '_orders', 'data-rowtype'=>$orders->RowType));

		// Render row
		$orders_list->RenderRow();

		// Render list options
		$orders_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($orders_list->RowAction <> "delete" && $orders_list->RowAction <> "insertdelete" && !($orders_list->RowAction == "insert" && $orders->CurrentAction == "F" && $orders_list->EmptyRow())) {
?>
	<tr<?php echo $orders->RowAttributes() ?>>
<?php

// Render list options (body, left)
$orders_list->ListOptions->Render("body", "left", $orders_list->RowCnt);
?>
	<?php if ($orders->id->Visible) { // id ?>
		<td data-name="id"<?php echo $orders->id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="orders" data-field="x_id" name="o<?php echo $orders_list->RowIndex ?>_id" id="o<?php echo $orders_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($orders->id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_id" class="form-group orders_id">
<span<?php echo $orders->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_id" name="x<?php echo $orders_list->RowIndex ?>_id" id="x<?php echo $orders_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($orders->id->CurrentValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_id" class="orders_id">
<span<?php echo $orders->id->ViewAttributes() ?>>
<?php echo $orders->id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->student_id->Visible) { // student_id ?>
		<td data-name="student_id"<?php echo $orders->student_id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_student_id" class="form-group orders_student_id">
<select data-table="orders" data-field="x_student_id" data-value-separator="<?php echo $orders->student_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_student_id" name="x<?php echo $orders_list->RowIndex ?>_student_id"<?php echo $orders->student_id->EditAttributes() ?>>
<?php echo $orders->student_id->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_student_id") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_student_id" name="o<?php echo $orders_list->RowIndex ?>_student_id" id="o<?php echo $orders_list->RowIndex ?>_student_id" value="<?php echo ew_HtmlEncode($orders->student_id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_student_id" class="form-group orders_student_id">
<select data-table="orders" data-field="x_student_id" data-value-separator="<?php echo $orders->student_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_student_id" name="x<?php echo $orders_list->RowIndex ?>_student_id"<?php echo $orders->student_id->EditAttributes() ?>>
<?php echo $orders->student_id->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_student_id") ?>
</select>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_student_id" class="orders_student_id">
<span<?php echo $orders->student_id->ViewAttributes() ?>>
<?php echo $orders->student_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id"<?php echo $orders->teacher_id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_teacher_id" class="form-group orders_teacher_id">
<select data-table="orders" data-field="x_teacher_id" data-value-separator="<?php echo $orders->teacher_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_teacher_id" name="x<?php echo $orders_list->RowIndex ?>_teacher_id"<?php echo $orders->teacher_id->EditAttributes() ?>>
<?php echo $orders->teacher_id->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_teacher_id") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_teacher_id" name="o<?php echo $orders_list->RowIndex ?>_teacher_id" id="o<?php echo $orders_list->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($orders->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_teacher_id" class="form-group orders_teacher_id">
<select data-table="orders" data-field="x_teacher_id" data-value-separator="<?php echo $orders->teacher_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_teacher_id" name="x<?php echo $orders_list->RowIndex ?>_teacher_id"<?php echo $orders->teacher_id->EditAttributes() ?>>
<?php echo $orders->teacher_id->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_teacher_id") ?>
</select>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_teacher_id" class="orders_teacher_id">
<span<?php echo $orders->teacher_id->ViewAttributes() ?>>
<?php echo $orders->teacher_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->topic_id->Visible) { // topic_id ?>
		<td data-name="topic_id"<?php echo $orders->topic_id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_topic_id" class="form-group orders_topic_id">
<select data-table="orders" data-field="x_topic_id" data-value-separator="<?php echo $orders->topic_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_topic_id" name="x<?php echo $orders_list->RowIndex ?>_topic_id"<?php echo $orders->topic_id->EditAttributes() ?>>
<?php echo $orders->topic_id->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_topic_id") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_topic_id" name="o<?php echo $orders_list->RowIndex ?>_topic_id" id="o<?php echo $orders_list->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($orders->topic_id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_topic_id" class="form-group orders_topic_id">
<select data-table="orders" data-field="x_topic_id" data-value-separator="<?php echo $orders->topic_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_topic_id" name="x<?php echo $orders_list->RowIndex ?>_topic_id"<?php echo $orders->topic_id->EditAttributes() ?>>
<?php echo $orders->topic_id->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_topic_id") ?>
</select>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_topic_id" class="orders_topic_id">
<span<?php echo $orders->topic_id->ViewAttributes() ?>>
<?php echo $orders->topic_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->date->Visible) { // date ?>
		<td data-name="date"<?php echo $orders->date->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_date" class="form-group orders_date">
<input type="text" data-table="orders" data-field="x_date" name="x<?php echo $orders_list->RowIndex ?>_date" id="x<?php echo $orders_list->RowIndex ?>_date" placeholder="<?php echo ew_HtmlEncode($orders->date->getPlaceHolder()) ?>" value="<?php echo $orders->date->EditValue ?>"<?php echo $orders->date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_date" name="o<?php echo $orders_list->RowIndex ?>_date" id="o<?php echo $orders_list->RowIndex ?>_date" value="<?php echo ew_HtmlEncode($orders->date->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_date" class="form-group orders_date">
<input type="text" data-table="orders" data-field="x_date" name="x<?php echo $orders_list->RowIndex ?>_date" id="x<?php echo $orders_list->RowIndex ?>_date" placeholder="<?php echo ew_HtmlEncode($orders->date->getPlaceHolder()) ?>" value="<?php echo $orders->date->EditValue ?>"<?php echo $orders->date->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_date" class="orders_date">
<span<?php echo $orders->date->ViewAttributes() ?>>
<?php echo $orders->date->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->time->Visible) { // time ?>
		<td data-name="time"<?php echo $orders->time->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_time" class="form-group orders_time">
<input type="text" data-table="orders" data-field="x_time" name="x<?php echo $orders_list->RowIndex ?>_time" id="x<?php echo $orders_list->RowIndex ?>_time" placeholder="<?php echo ew_HtmlEncode($orders->time->getPlaceHolder()) ?>" value="<?php echo $orders->time->EditValue ?>"<?php echo $orders->time->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_time" name="o<?php echo $orders_list->RowIndex ?>_time" id="o<?php echo $orders_list->RowIndex ?>_time" value="<?php echo ew_HtmlEncode($orders->time->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_time" class="form-group orders_time">
<input type="text" data-table="orders" data-field="x_time" name="x<?php echo $orders_list->RowIndex ?>_time" id="x<?php echo $orders_list->RowIndex ?>_time" placeholder="<?php echo ew_HtmlEncode($orders->time->getPlaceHolder()) ?>" value="<?php echo $orders->time->EditValue ?>"<?php echo $orders->time->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_time" class="orders_time">
<span<?php echo $orders->time->ViewAttributes() ?>>
<?php echo $orders->time->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->fees->Visible) { // fees ?>
		<td data-name="fees"<?php echo $orders->fees->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_fees" class="form-group orders_fees">
<input type="text" data-table="orders" data-field="x_fees" name="x<?php echo $orders_list->RowIndex ?>_fees" id="x<?php echo $orders_list->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($orders->fees->getPlaceHolder()) ?>" value="<?php echo $orders->fees->EditValue ?>"<?php echo $orders->fees->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_fees" name="o<?php echo $orders_list->RowIndex ?>_fees" id="o<?php echo $orders_list->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($orders->fees->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_fees" class="form-group orders_fees">
<input type="text" data-table="orders" data-field="x_fees" name="x<?php echo $orders_list->RowIndex ?>_fees" id="x<?php echo $orders_list->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($orders->fees->getPlaceHolder()) ?>" value="<?php echo $orders->fees->EditValue ?>"<?php echo $orders->fees->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_fees" class="orders_fees">
<span<?php echo $orders->fees->ViewAttributes() ?>>
<?php echo $orders->fees->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id"<?php echo $orders->currency_id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_currency_id" class="form-group orders_currency_id">
<select data-table="orders" data-field="x_currency_id" data-value-separator="<?php echo $orders->currency_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_currency_id" name="x<?php echo $orders_list->RowIndex ?>_currency_id"<?php echo $orders->currency_id->EditAttributes() ?>>
<?php echo $orders->currency_id->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_currency_id") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_currency_id" name="o<?php echo $orders_list->RowIndex ?>_currency_id" id="o<?php echo $orders_list->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($orders->currency_id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_currency_id" class="form-group orders_currency_id">
<select data-table="orders" data-field="x_currency_id" data-value-separator="<?php echo $orders->currency_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_currency_id" name="x<?php echo $orders_list->RowIndex ?>_currency_id"<?php echo $orders->currency_id->EditAttributes() ?>>
<?php echo $orders->currency_id->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_currency_id") ?>
</select>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_currency_id" class="orders_currency_id">
<span<?php echo $orders->currency_id->ViewAttributes() ?>>
<?php echo $orders->currency_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->status->Visible) { // status ?>
		<td data-name="status"<?php echo $orders->status->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_status" class="form-group orders_status">
<select data-table="orders" data-field="x_status" data-value-separator="<?php echo $orders->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_status" name="x<?php echo $orders_list->RowIndex ?>_status"<?php echo $orders->status->EditAttributes() ?>>
<?php echo $orders->status->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_status") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_status" name="o<?php echo $orders_list->RowIndex ?>_status" id="o<?php echo $orders_list->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($orders->status->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_status" class="form-group orders_status">
<select data-table="orders" data-field="x_status" data-value-separator="<?php echo $orders->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_status" name="x<?php echo $orders_list->RowIndex ?>_status"<?php echo $orders->status->EditAttributes() ?>>
<?php echo $orders->status->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_status") ?>
</select>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_status" class="orders_status">
<span<?php echo $orders->status->ViewAttributes() ?>>
<?php echo $orders->status->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->meeting_id->Visible) { // meeting_id ?>
		<td data-name="meeting_id"<?php echo $orders->meeting_id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_meeting_id" class="form-group orders_meeting_id">
<input type="text" data-table="orders" data-field="x_meeting_id" name="x<?php echo $orders_list->RowIndex ?>_meeting_id" id="x<?php echo $orders_list->RowIndex ?>_meeting_id" placeholder="<?php echo ew_HtmlEncode($orders->meeting_id->getPlaceHolder()) ?>" value="<?php echo $orders->meeting_id->EditValue ?>"<?php echo $orders->meeting_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_meeting_id" name="o<?php echo $orders_list->RowIndex ?>_meeting_id" id="o<?php echo $orders_list->RowIndex ?>_meeting_id" value="<?php echo ew_HtmlEncode($orders->meeting_id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_meeting_id" class="form-group orders_meeting_id">
<input type="text" data-table="orders" data-field="x_meeting_id" name="x<?php echo $orders_list->RowIndex ?>_meeting_id" id="x<?php echo $orders_list->RowIndex ?>_meeting_id" placeholder="<?php echo ew_HtmlEncode($orders->meeting_id->getPlaceHolder()) ?>" value="<?php echo $orders->meeting_id->EditValue ?>"<?php echo $orders->meeting_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_meeting_id" class="orders_meeting_id">
<span<?php echo $orders->meeting_id->ViewAttributes() ?>>
<?php echo $orders->meeting_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orders->package_id->Visible) { // package_id ?>
		<td data-name="package_id"<?php echo $orders->package_id->CellAttributes() ?>>
<?php if ($orders->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_package_id" class="form-group orders_package_id">
<input type="text" data-table="orders" data-field="x_package_id" name="x<?php echo $orders_list->RowIndex ?>_package_id" id="x<?php echo $orders_list->RowIndex ?>_package_id" size="30" placeholder="<?php echo ew_HtmlEncode($orders->package_id->getPlaceHolder()) ?>" value="<?php echo $orders->package_id->EditValue ?>"<?php echo $orders->package_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_package_id" name="o<?php echo $orders_list->RowIndex ?>_package_id" id="o<?php echo $orders_list->RowIndex ?>_package_id" value="<?php echo ew_HtmlEncode($orders->package_id->OldValue) ?>">
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_package_id" class="form-group orders_package_id">
<input type="text" data-table="orders" data-field="x_package_id" name="x<?php echo $orders_list->RowIndex ?>_package_id" id="x<?php echo $orders_list->RowIndex ?>_package_id" size="30" placeholder="<?php echo ew_HtmlEncode($orders->package_id->getPlaceHolder()) ?>" value="<?php echo $orders->package_id->EditValue ?>"<?php echo $orders->package_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($orders->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_package_id" class="orders_package_id">
<span<?php echo $orders->package_id->ViewAttributes() ?>>
<?php echo $orders->package_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$orders_list->ListOptions->Render("body", "right", $orders_list->RowCnt);
?>
	</tr>
<?php if ($orders->RowType == EW_ROWTYPE_ADD || $orders->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
forderslist.UpdateOpts(<?php echo $orders_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($orders->CurrentAction <> "gridadd")
		if (!$orders_list->Recordset->EOF) $orders_list->Recordset->MoveNext();
}
?>
<?php
	if ($orders->CurrentAction == "gridadd" || $orders->CurrentAction == "gridedit") {
		$orders_list->RowIndex = '$rowindex$';
		$orders_list->LoadRowValues();

		// Set row properties
		$orders->ResetAttrs();
		$orders->RowAttrs = array_merge($orders->RowAttrs, array('data-rowindex'=>$orders_list->RowIndex, 'id'=>'r0_orders', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($orders->RowAttrs["class"], "ewTemplate");
		$orders->RowType = EW_ROWTYPE_ADD;

		// Render row
		$orders_list->RenderRow();

		// Render list options
		$orders_list->RenderListOptions();
		$orders_list->StartRowCnt = 0;
?>
	<tr<?php echo $orders->RowAttributes() ?>>
<?php

// Render list options (body, left)
$orders_list->ListOptions->Render("body", "left", $orders_list->RowIndex);
?>
	<?php if ($orders->id->Visible) { // id ?>
		<td data-name="id">
<input type="hidden" data-table="orders" data-field="x_id" name="o<?php echo $orders_list->RowIndex ?>_id" id="o<?php echo $orders_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($orders->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->student_id->Visible) { // student_id ?>
		<td data-name="student_id">
<span id="el$rowindex$_orders_student_id" class="form-group orders_student_id">
<select data-table="orders" data-field="x_student_id" data-value-separator="<?php echo $orders->student_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_student_id" name="x<?php echo $orders_list->RowIndex ?>_student_id"<?php echo $orders->student_id->EditAttributes() ?>>
<?php echo $orders->student_id->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_student_id") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_student_id" name="o<?php echo $orders_list->RowIndex ?>_student_id" id="o<?php echo $orders_list->RowIndex ?>_student_id" value="<?php echo ew_HtmlEncode($orders->student_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id">
<span id="el$rowindex$_orders_teacher_id" class="form-group orders_teacher_id">
<select data-table="orders" data-field="x_teacher_id" data-value-separator="<?php echo $orders->teacher_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_teacher_id" name="x<?php echo $orders_list->RowIndex ?>_teacher_id"<?php echo $orders->teacher_id->EditAttributes() ?>>
<?php echo $orders->teacher_id->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_teacher_id") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_teacher_id" name="o<?php echo $orders_list->RowIndex ?>_teacher_id" id="o<?php echo $orders_list->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($orders->teacher_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->topic_id->Visible) { // topic_id ?>
		<td data-name="topic_id">
<span id="el$rowindex$_orders_topic_id" class="form-group orders_topic_id">
<select data-table="orders" data-field="x_topic_id" data-value-separator="<?php echo $orders->topic_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_topic_id" name="x<?php echo $orders_list->RowIndex ?>_topic_id"<?php echo $orders->topic_id->EditAttributes() ?>>
<?php echo $orders->topic_id->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_topic_id") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_topic_id" name="o<?php echo $orders_list->RowIndex ?>_topic_id" id="o<?php echo $orders_list->RowIndex ?>_topic_id" value="<?php echo ew_HtmlEncode($orders->topic_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->date->Visible) { // date ?>
		<td data-name="date">
<span id="el$rowindex$_orders_date" class="form-group orders_date">
<input type="text" data-table="orders" data-field="x_date" name="x<?php echo $orders_list->RowIndex ?>_date" id="x<?php echo $orders_list->RowIndex ?>_date" placeholder="<?php echo ew_HtmlEncode($orders->date->getPlaceHolder()) ?>" value="<?php echo $orders->date->EditValue ?>"<?php echo $orders->date->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_date" name="o<?php echo $orders_list->RowIndex ?>_date" id="o<?php echo $orders_list->RowIndex ?>_date" value="<?php echo ew_HtmlEncode($orders->date->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->time->Visible) { // time ?>
		<td data-name="time">
<span id="el$rowindex$_orders_time" class="form-group orders_time">
<input type="text" data-table="orders" data-field="x_time" name="x<?php echo $orders_list->RowIndex ?>_time" id="x<?php echo $orders_list->RowIndex ?>_time" placeholder="<?php echo ew_HtmlEncode($orders->time->getPlaceHolder()) ?>" value="<?php echo $orders->time->EditValue ?>"<?php echo $orders->time->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_time" name="o<?php echo $orders_list->RowIndex ?>_time" id="o<?php echo $orders_list->RowIndex ?>_time" value="<?php echo ew_HtmlEncode($orders->time->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->fees->Visible) { // fees ?>
		<td data-name="fees">
<span id="el$rowindex$_orders_fees" class="form-group orders_fees">
<input type="text" data-table="orders" data-field="x_fees" name="x<?php echo $orders_list->RowIndex ?>_fees" id="x<?php echo $orders_list->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($orders->fees->getPlaceHolder()) ?>" value="<?php echo $orders->fees->EditValue ?>"<?php echo $orders->fees->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_fees" name="o<?php echo $orders_list->RowIndex ?>_fees" id="o<?php echo $orders_list->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($orders->fees->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id">
<span id="el$rowindex$_orders_currency_id" class="form-group orders_currency_id">
<select data-table="orders" data-field="x_currency_id" data-value-separator="<?php echo $orders->currency_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_currency_id" name="x<?php echo $orders_list->RowIndex ?>_currency_id"<?php echo $orders->currency_id->EditAttributes() ?>>
<?php echo $orders->currency_id->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_currency_id") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_currency_id" name="o<?php echo $orders_list->RowIndex ?>_currency_id" id="o<?php echo $orders_list->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($orders->currency_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->status->Visible) { // status ?>
		<td data-name="status">
<span id="el$rowindex$_orders_status" class="form-group orders_status">
<select data-table="orders" data-field="x_status" data-value-separator="<?php echo $orders->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orders_list->RowIndex ?>_status" name="x<?php echo $orders_list->RowIndex ?>_status"<?php echo $orders->status->EditAttributes() ?>>
<?php echo $orders->status->SelectOptionListHtml("x<?php echo $orders_list->RowIndex ?>_status") ?>
</select>
</span>
<input type="hidden" data-table="orders" data-field="x_status" name="o<?php echo $orders_list->RowIndex ?>_status" id="o<?php echo $orders_list->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($orders->status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->meeting_id->Visible) { // meeting_id ?>
		<td data-name="meeting_id">
<span id="el$rowindex$_orders_meeting_id" class="form-group orders_meeting_id">
<input type="text" data-table="orders" data-field="x_meeting_id" name="x<?php echo $orders_list->RowIndex ?>_meeting_id" id="x<?php echo $orders_list->RowIndex ?>_meeting_id" placeholder="<?php echo ew_HtmlEncode($orders->meeting_id->getPlaceHolder()) ?>" value="<?php echo $orders->meeting_id->EditValue ?>"<?php echo $orders->meeting_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_meeting_id" name="o<?php echo $orders_list->RowIndex ?>_meeting_id" id="o<?php echo $orders_list->RowIndex ?>_meeting_id" value="<?php echo ew_HtmlEncode($orders->meeting_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orders->package_id->Visible) { // package_id ?>
		<td data-name="package_id">
<span id="el$rowindex$_orders_package_id" class="form-group orders_package_id">
<input type="text" data-table="orders" data-field="x_package_id" name="x<?php echo $orders_list->RowIndex ?>_package_id" id="x<?php echo $orders_list->RowIndex ?>_package_id" size="30" placeholder="<?php echo ew_HtmlEncode($orders->package_id->getPlaceHolder()) ?>" value="<?php echo $orders->package_id->EditValue ?>"<?php echo $orders->package_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orders" data-field="x_package_id" name="o<?php echo $orders_list->RowIndex ?>_package_id" id="o<?php echo $orders_list->RowIndex ?>_package_id" value="<?php echo ew_HtmlEncode($orders->package_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$orders_list->ListOptions->Render("body", "right", $orders_list->RowIndex);
?>
<script type="text/javascript">
forderslist.UpdateOpts(<?php echo $orders_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($orders->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $orders_list->FormKeyCountName ?>" id="<?php echo $orders_list->FormKeyCountName ?>" value="<?php echo $orders_list->KeyCount ?>">
<?php echo $orders_list->MultiSelectKey ?>
<?php } ?>
<?php if ($orders->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $orders_list->FormKeyCountName ?>" id="<?php echo $orders_list->FormKeyCountName ?>" value="<?php echo $orders_list->KeyCount ?>">
<?php echo $orders_list->MultiSelectKey ?>
<?php } ?>
<?php if ($orders->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($orders_list->Recordset)
	$orders_list->Recordset->Close();
?>
<?php if ($orders->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($orders->CurrentAction <> "gridadd" && $orders->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($orders_list->Pager)) $orders_list->Pager = new cPrevNextPager($orders_list->StartRec, $orders_list->DisplayRecs, $orders_list->TotalRecs, $orders_list->AutoHidePager) ?>
<?php if ($orders_list->Pager->RecordCount > 0 && $orders_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($orders_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($orders_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $orders_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($orders_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($orders_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $orders_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($orders_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $orders_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $orders_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $orders_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($orders_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($orders_list->TotalRecs == 0 && $orders->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($orders_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($orders->Export == "") { ?>
<script type="text/javascript">
forderslistsrch.FilterList = <?php echo $orders_list->GetFilterList() ?>;
forderslistsrch.Init();
forderslist.Init();
</script>
<?php } ?>
<?php
$orders_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($orders->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$orders_list->Page_Terminate();
?>
