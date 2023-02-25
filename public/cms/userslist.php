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

$users_list = NULL; // Initialize page object first

class cusers_list extends cusers {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_list';

	// Grid form hidden field names
	var $FormName = 'fuserslist';
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

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == "cusers") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "usersadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "usersdelete.php";
		$this->MultiUpdateUrl = "usersupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fuserslistsrch";

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
		$this->name->SetVisibility();
		$this->_email->SetVisibility();
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
		if ($objForm->HasValue("x_name") && $objForm->HasValue("o_name") && $this->name->CurrentValue <> $this->name->OldValue)
			return FALSE;
		if ($objForm->HasValue("x__email") && $objForm->HasValue("o__email") && $this->_email->CurrentValue <> $this->_email->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_phone") && $objForm->HasValue("o_phone") && $this->phone->CurrentValue <> $this->phone->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_gender") && $objForm->HasValue("o_gender") && $this->gender->CurrentValue <> $this->gender->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_birthday") && $objForm->HasValue("o_birthday") && $this->birthday->CurrentValue <> $this->birthday->OldValue)
			return FALSE;
		if (!ew_Empty($this->image->Upload->Value))
			return FALSE;
		if ($objForm->HasValue("x_country_id") && $objForm->HasValue("o_country_id") && $this->country_id->CurrentValue <> $this->country_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_city") && $objForm->HasValue("o_city") && $this->city->CurrentValue <> $this->city->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_currency_id") && $objForm->HasValue("o_currency_id") && $this->currency_id->CurrentValue <> $this->currency_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_type") && $objForm->HasValue("o_type") && $this->type->CurrentValue <> $this->type->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_is_verified") && $objForm->HasValue("o_is_verified") && $this->is_verified->CurrentValue <> $this->is_verified->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_is_approved") && $objForm->HasValue("o_is_approved") && $this->is_approved->CurrentValue <> $this->is_approved->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_is_blocked") && $objForm->HasValue("o_is_blocked") && $this->is_blocked->CurrentValue <> $this->is_blocked->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_otp") && $objForm->HasValue("o_otp") && $this->otp->CurrentValue <> $this->otp->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_slug") && $objForm->HasValue("o_slug") && $this->slug->CurrentValue <> $this->slug->OldValue)
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
		$sFilterList = ew_Concat($sFilterList, $this->name->AdvancedSearch->ToJson(), ","); // Field name
		$sFilterList = ew_Concat($sFilterList, $this->_email->AdvancedSearch->ToJson(), ","); // Field email
		$sFilterList = ew_Concat($sFilterList, $this->password->AdvancedSearch->ToJson(), ","); // Field password
		$sFilterList = ew_Concat($sFilterList, $this->phone->AdvancedSearch->ToJson(), ","); // Field phone
		$sFilterList = ew_Concat($sFilterList, $this->gender->AdvancedSearch->ToJson(), ","); // Field gender
		$sFilterList = ew_Concat($sFilterList, $this->birthday->AdvancedSearch->ToJson(), ","); // Field birthday
		$sFilterList = ew_Concat($sFilterList, $this->image->AdvancedSearch->ToJson(), ","); // Field image
		$sFilterList = ew_Concat($sFilterList, $this->country_id->AdvancedSearch->ToJson(), ","); // Field country_id
		$sFilterList = ew_Concat($sFilterList, $this->city->AdvancedSearch->ToJson(), ","); // Field city
		$sFilterList = ew_Concat($sFilterList, $this->currency_id->AdvancedSearch->ToJson(), ","); // Field currency_id
		$sFilterList = ew_Concat($sFilterList, $this->type->AdvancedSearch->ToJson(), ","); // Field type
		$sFilterList = ew_Concat($sFilterList, $this->is_verified->AdvancedSearch->ToJson(), ","); // Field is_verified
		$sFilterList = ew_Concat($sFilterList, $this->is_approved->AdvancedSearch->ToJson(), ","); // Field is_approved
		$sFilterList = ew_Concat($sFilterList, $this->is_blocked->AdvancedSearch->ToJson(), ","); // Field is_blocked
		$sFilterList = ew_Concat($sFilterList, $this->otp->AdvancedSearch->ToJson(), ","); // Field otp
		$sFilterList = ew_Concat($sFilterList, $this->slug->AdvancedSearch->ToJson(), ","); // Field slug
		$sFilterList = ew_Concat($sFilterList, $this->remember_token->AdvancedSearch->ToJson(), ","); // Field remember_token
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fuserslistsrch", $filters);

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

		// Field name
		$this->name->AdvancedSearch->SearchValue = @$filter["x_name"];
		$this->name->AdvancedSearch->SearchOperator = @$filter["z_name"];
		$this->name->AdvancedSearch->SearchCondition = @$filter["v_name"];
		$this->name->AdvancedSearch->SearchValue2 = @$filter["y_name"];
		$this->name->AdvancedSearch->SearchOperator2 = @$filter["w_name"];
		$this->name->AdvancedSearch->Save();

		// Field email
		$this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
		$this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
		$this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
		$this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
		$this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
		$this->_email->AdvancedSearch->Save();

		// Field password
		$this->password->AdvancedSearch->SearchValue = @$filter["x_password"];
		$this->password->AdvancedSearch->SearchOperator = @$filter["z_password"];
		$this->password->AdvancedSearch->SearchCondition = @$filter["v_password"];
		$this->password->AdvancedSearch->SearchValue2 = @$filter["y_password"];
		$this->password->AdvancedSearch->SearchOperator2 = @$filter["w_password"];
		$this->password->AdvancedSearch->Save();

		// Field phone
		$this->phone->AdvancedSearch->SearchValue = @$filter["x_phone"];
		$this->phone->AdvancedSearch->SearchOperator = @$filter["z_phone"];
		$this->phone->AdvancedSearch->SearchCondition = @$filter["v_phone"];
		$this->phone->AdvancedSearch->SearchValue2 = @$filter["y_phone"];
		$this->phone->AdvancedSearch->SearchOperator2 = @$filter["w_phone"];
		$this->phone->AdvancedSearch->Save();

		// Field gender
		$this->gender->AdvancedSearch->SearchValue = @$filter["x_gender"];
		$this->gender->AdvancedSearch->SearchOperator = @$filter["z_gender"];
		$this->gender->AdvancedSearch->SearchCondition = @$filter["v_gender"];
		$this->gender->AdvancedSearch->SearchValue2 = @$filter["y_gender"];
		$this->gender->AdvancedSearch->SearchOperator2 = @$filter["w_gender"];
		$this->gender->AdvancedSearch->Save();

		// Field birthday
		$this->birthday->AdvancedSearch->SearchValue = @$filter["x_birthday"];
		$this->birthday->AdvancedSearch->SearchOperator = @$filter["z_birthday"];
		$this->birthday->AdvancedSearch->SearchCondition = @$filter["v_birthday"];
		$this->birthday->AdvancedSearch->SearchValue2 = @$filter["y_birthday"];
		$this->birthday->AdvancedSearch->SearchOperator2 = @$filter["w_birthday"];
		$this->birthday->AdvancedSearch->Save();

		// Field image
		$this->image->AdvancedSearch->SearchValue = @$filter["x_image"];
		$this->image->AdvancedSearch->SearchOperator = @$filter["z_image"];
		$this->image->AdvancedSearch->SearchCondition = @$filter["v_image"];
		$this->image->AdvancedSearch->SearchValue2 = @$filter["y_image"];
		$this->image->AdvancedSearch->SearchOperator2 = @$filter["w_image"];
		$this->image->AdvancedSearch->Save();

		// Field country_id
		$this->country_id->AdvancedSearch->SearchValue = @$filter["x_country_id"];
		$this->country_id->AdvancedSearch->SearchOperator = @$filter["z_country_id"];
		$this->country_id->AdvancedSearch->SearchCondition = @$filter["v_country_id"];
		$this->country_id->AdvancedSearch->SearchValue2 = @$filter["y_country_id"];
		$this->country_id->AdvancedSearch->SearchOperator2 = @$filter["w_country_id"];
		$this->country_id->AdvancedSearch->Save();

		// Field city
		$this->city->AdvancedSearch->SearchValue = @$filter["x_city"];
		$this->city->AdvancedSearch->SearchOperator = @$filter["z_city"];
		$this->city->AdvancedSearch->SearchCondition = @$filter["v_city"];
		$this->city->AdvancedSearch->SearchValue2 = @$filter["y_city"];
		$this->city->AdvancedSearch->SearchOperator2 = @$filter["w_city"];
		$this->city->AdvancedSearch->Save();

		// Field currency_id
		$this->currency_id->AdvancedSearch->SearchValue = @$filter["x_currency_id"];
		$this->currency_id->AdvancedSearch->SearchOperator = @$filter["z_currency_id"];
		$this->currency_id->AdvancedSearch->SearchCondition = @$filter["v_currency_id"];
		$this->currency_id->AdvancedSearch->SearchValue2 = @$filter["y_currency_id"];
		$this->currency_id->AdvancedSearch->SearchOperator2 = @$filter["w_currency_id"];
		$this->currency_id->AdvancedSearch->Save();

		// Field type
		$this->type->AdvancedSearch->SearchValue = @$filter["x_type"];
		$this->type->AdvancedSearch->SearchOperator = @$filter["z_type"];
		$this->type->AdvancedSearch->SearchCondition = @$filter["v_type"];
		$this->type->AdvancedSearch->SearchValue2 = @$filter["y_type"];
		$this->type->AdvancedSearch->SearchOperator2 = @$filter["w_type"];
		$this->type->AdvancedSearch->Save();

		// Field is_verified
		$this->is_verified->AdvancedSearch->SearchValue = @$filter["x_is_verified"];
		$this->is_verified->AdvancedSearch->SearchOperator = @$filter["z_is_verified"];
		$this->is_verified->AdvancedSearch->SearchCondition = @$filter["v_is_verified"];
		$this->is_verified->AdvancedSearch->SearchValue2 = @$filter["y_is_verified"];
		$this->is_verified->AdvancedSearch->SearchOperator2 = @$filter["w_is_verified"];
		$this->is_verified->AdvancedSearch->Save();

		// Field is_approved
		$this->is_approved->AdvancedSearch->SearchValue = @$filter["x_is_approved"];
		$this->is_approved->AdvancedSearch->SearchOperator = @$filter["z_is_approved"];
		$this->is_approved->AdvancedSearch->SearchCondition = @$filter["v_is_approved"];
		$this->is_approved->AdvancedSearch->SearchValue2 = @$filter["y_is_approved"];
		$this->is_approved->AdvancedSearch->SearchOperator2 = @$filter["w_is_approved"];
		$this->is_approved->AdvancedSearch->Save();

		// Field is_blocked
		$this->is_blocked->AdvancedSearch->SearchValue = @$filter["x_is_blocked"];
		$this->is_blocked->AdvancedSearch->SearchOperator = @$filter["z_is_blocked"];
		$this->is_blocked->AdvancedSearch->SearchCondition = @$filter["v_is_blocked"];
		$this->is_blocked->AdvancedSearch->SearchValue2 = @$filter["y_is_blocked"];
		$this->is_blocked->AdvancedSearch->SearchOperator2 = @$filter["w_is_blocked"];
		$this->is_blocked->AdvancedSearch->Save();

		// Field otp
		$this->otp->AdvancedSearch->SearchValue = @$filter["x_otp"];
		$this->otp->AdvancedSearch->SearchOperator = @$filter["z_otp"];
		$this->otp->AdvancedSearch->SearchCondition = @$filter["v_otp"];
		$this->otp->AdvancedSearch->SearchValue2 = @$filter["y_otp"];
		$this->otp->AdvancedSearch->SearchOperator2 = @$filter["w_otp"];
		$this->otp->AdvancedSearch->Save();

		// Field slug
		$this->slug->AdvancedSearch->SearchValue = @$filter["x_slug"];
		$this->slug->AdvancedSearch->SearchOperator = @$filter["z_slug"];
		$this->slug->AdvancedSearch->SearchCondition = @$filter["v_slug"];
		$this->slug->AdvancedSearch->SearchValue2 = @$filter["y_slug"];
		$this->slug->AdvancedSearch->SearchOperator2 = @$filter["w_slug"];
		$this->slug->AdvancedSearch->Save();

		// Field remember_token
		$this->remember_token->AdvancedSearch->SearchValue = @$filter["x_remember_token"];
		$this->remember_token->AdvancedSearch->SearchOperator = @$filter["z_remember_token"];
		$this->remember_token->AdvancedSearch->SearchCondition = @$filter["v_remember_token"];
		$this->remember_token->AdvancedSearch->SearchValue2 = @$filter["y_remember_token"];
		$this->remember_token->AdvancedSearch->SearchOperator2 = @$filter["w_remember_token"];
		$this->remember_token->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->id, $Default, FALSE); // id
		$this->BuildSearchSql($sWhere, $this->name, $Default, FALSE); // name
		$this->BuildSearchSql($sWhere, $this->_email, $Default, FALSE); // email
		$this->BuildSearchSql($sWhere, $this->password, $Default, FALSE); // password
		$this->BuildSearchSql($sWhere, $this->phone, $Default, FALSE); // phone
		$this->BuildSearchSql($sWhere, $this->gender, $Default, FALSE); // gender
		$this->BuildSearchSql($sWhere, $this->birthday, $Default, FALSE); // birthday
		$this->BuildSearchSql($sWhere, $this->image, $Default, FALSE); // image
		$this->BuildSearchSql($sWhere, $this->country_id, $Default, FALSE); // country_id
		$this->BuildSearchSql($sWhere, $this->city, $Default, FALSE); // city
		$this->BuildSearchSql($sWhere, $this->currency_id, $Default, FALSE); // currency_id
		$this->BuildSearchSql($sWhere, $this->type, $Default, FALSE); // type
		$this->BuildSearchSql($sWhere, $this->is_verified, $Default, FALSE); // is_verified
		$this->BuildSearchSql($sWhere, $this->is_approved, $Default, FALSE); // is_approved
		$this->BuildSearchSql($sWhere, $this->is_blocked, $Default, FALSE); // is_blocked
		$this->BuildSearchSql($sWhere, $this->otp, $Default, FALSE); // otp
		$this->BuildSearchSql($sWhere, $this->slug, $Default, FALSE); // slug
		$this->BuildSearchSql($sWhere, $this->remember_token, $Default, FALSE); // remember_token

		// Set up search parm
		if (!$Default && $sWhere <> "" && in_array($this->Command, array("", "reset", "resetall"))) {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->id->AdvancedSearch->Save(); // id
			$this->name->AdvancedSearch->Save(); // name
			$this->_email->AdvancedSearch->Save(); // email
			$this->password->AdvancedSearch->Save(); // password
			$this->phone->AdvancedSearch->Save(); // phone
			$this->gender->AdvancedSearch->Save(); // gender
			$this->birthday->AdvancedSearch->Save(); // birthday
			$this->image->AdvancedSearch->Save(); // image
			$this->country_id->AdvancedSearch->Save(); // country_id
			$this->city->AdvancedSearch->Save(); // city
			$this->currency_id->AdvancedSearch->Save(); // currency_id
			$this->type->AdvancedSearch->Save(); // type
			$this->is_verified->AdvancedSearch->Save(); // is_verified
			$this->is_approved->AdvancedSearch->Save(); // is_approved
			$this->is_blocked->AdvancedSearch->Save(); // is_blocked
			$this->otp->AdvancedSearch->Save(); // otp
			$this->slug->AdvancedSearch->Save(); // slug
			$this->remember_token->AdvancedSearch->Save(); // remember_token
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
		$this->BuildBasicSearchSQL($sWhere, $this->name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->_email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->password, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->phone, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->image, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->city, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->otp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->slug, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->remember_token, $arKeywords, $type);
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
		if ($this->name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->_email->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->password->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->phone->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->gender->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->birthday->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->image->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->country_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->city->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->currency_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->type->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->is_verified->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->is_approved->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->is_blocked->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->otp->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->slug->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->remember_token->AdvancedSearch->IssetSession())
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
		$this->name->AdvancedSearch->UnsetSession();
		$this->_email->AdvancedSearch->UnsetSession();
		$this->password->AdvancedSearch->UnsetSession();
		$this->phone->AdvancedSearch->UnsetSession();
		$this->gender->AdvancedSearch->UnsetSession();
		$this->birthday->AdvancedSearch->UnsetSession();
		$this->image->AdvancedSearch->UnsetSession();
		$this->country_id->AdvancedSearch->UnsetSession();
		$this->city->AdvancedSearch->UnsetSession();
		$this->currency_id->AdvancedSearch->UnsetSession();
		$this->type->AdvancedSearch->UnsetSession();
		$this->is_verified->AdvancedSearch->UnsetSession();
		$this->is_approved->AdvancedSearch->UnsetSession();
		$this->is_blocked->AdvancedSearch->UnsetSession();
		$this->otp->AdvancedSearch->UnsetSession();
		$this->slug->AdvancedSearch->UnsetSession();
		$this->remember_token->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->id->AdvancedSearch->Load();
		$this->name->AdvancedSearch->Load();
		$this->_email->AdvancedSearch->Load();
		$this->password->AdvancedSearch->Load();
		$this->phone->AdvancedSearch->Load();
		$this->gender->AdvancedSearch->Load();
		$this->birthday->AdvancedSearch->Load();
		$this->image->AdvancedSearch->Load();
		$this->country_id->AdvancedSearch->Load();
		$this->city->AdvancedSearch->Load();
		$this->currency_id->AdvancedSearch->Load();
		$this->type->AdvancedSearch->Load();
		$this->is_verified->AdvancedSearch->Load();
		$this->is_approved->AdvancedSearch->Load();
		$this->is_blocked->AdvancedSearch->Load();
		$this->otp->AdvancedSearch->Load();
		$this->slug->AdvancedSearch->Load();
		$this->remember_token->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id); // id
			$this->UpdateSort($this->name); // name
			$this->UpdateSort($this->_email); // email
			$this->UpdateSort($this->phone); // phone
			$this->UpdateSort($this->gender); // gender
			$this->UpdateSort($this->birthday); // birthday
			$this->UpdateSort($this->image); // image
			$this->UpdateSort($this->country_id); // country_id
			$this->UpdateSort($this->city); // city
			$this->UpdateSort($this->currency_id); // currency_id
			$this->UpdateSort($this->type); // type
			$this->UpdateSort($this->is_verified); // is_verified
			$this->UpdateSort($this->is_approved); // is_approved
			$this->UpdateSort($this->is_blocked); // is_blocked
			$this->UpdateSort($this->otp); // otp
			$this->UpdateSort($this->slug); // slug
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
				$this->name->setSort("");
				$this->_email->setSort("");
				$this->phone->setSort("");
				$this->gender->setSort("");
				$this->birthday->setSort("");
				$this->image->setSort("");
				$this->country_id->setSort("");
				$this->city->setSort("");
				$this->currency_id->setSort("");
				$this->type->setSort("");
				$this->is_verified->setSort("");
				$this->is_approved->setSort("");
				$this->is_blocked->setSort("");
				$this->otp->setSort("");
				$this->slug->setSort("");
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

		// "detail_transfers"
		$item = &$this->ListOptions->Add("detail_transfers");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->IsLoggedIn() && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["transfers_grid"])) $GLOBALS["transfers_grid"] = new ctransfers_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssClass = "text-nowrap";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = TRUE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("transfers");
		$this->DetailPages = $pages;

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
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_transfers"
		$oListOpt = &$this->ListOptions->Items["detail_transfers"];
		if ($Security->IsLoggedIn()) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("transfers", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("transferslist.php?" . EW_TABLE_SHOW_MASTER . "=users&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["transfers_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$caption = $Language->Phrase("MasterDetailViewLink");
				$url = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=transfers");
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "transfers";
			}
			if ($GLOBALS["transfers_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=transfers");
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "transfers";
			}
			if ($GLOBALS["transfers_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
				$caption = $Language->Phrase("MasterDetailCopyLink");
				$url = $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=transfers");
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "transfers";
			}
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
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_transfers");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=transfers");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["transfers"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["transfers"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "transfers";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink);
			$caption = $Language->Phrase("AddMasterDetailLink");
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
			$item->Visible = ($DetailTableLink <> "" && $Security->IsLoggedIn());

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detailadd_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->IsLoggedIn());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fuserslist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fuserslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fuserslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fuserslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fuserslistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->image->Upload->Index = $objForm->Index;
		$this->image->Upload->UploadFile();
		$this->image->CurrentValue = $this->image->Upload->FileName;
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
		$this->gender->OldValue = $this->gender->CurrentValue;
		$this->birthday->CurrentValue = NULL;
		$this->birthday->OldValue = $this->birthday->CurrentValue;
		$this->image->Upload->DbValue = NULL;
		$this->image->OldValue = $this->image->Upload->DbValue;
		$this->country_id->CurrentValue = NULL;
		$this->country_id->OldValue = $this->country_id->CurrentValue;
		$this->city->CurrentValue = NULL;
		$this->city->OldValue = $this->city->CurrentValue;
		$this->currency_id->CurrentValue = NULL;
		$this->currency_id->OldValue = $this->currency_id->CurrentValue;
		$this->type->CurrentValue = "student";
		$this->type->OldValue = $this->type->CurrentValue;
		$this->is_verified->CurrentValue = 0;
		$this->is_verified->OldValue = $this->is_verified->CurrentValue;
		$this->is_approved->CurrentValue = 0;
		$this->is_approved->OldValue = $this->is_approved->CurrentValue;
		$this->is_blocked->CurrentValue = 0;
		$this->is_blocked->OldValue = $this->is_blocked->CurrentValue;
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

		// name
		$this->name->AdvancedSearch->SearchValue = @$_GET["x_name"];
		if ($this->name->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->name->AdvancedSearch->SearchOperator = @$_GET["z_name"];

		// email
		$this->_email->AdvancedSearch->SearchValue = @$_GET["x__email"];
		if ($this->_email->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->_email->AdvancedSearch->SearchOperator = @$_GET["z__email"];

		// password
		$this->password->AdvancedSearch->SearchValue = @$_GET["x_password"];
		if ($this->password->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->password->AdvancedSearch->SearchOperator = @$_GET["z_password"];

		// phone
		$this->phone->AdvancedSearch->SearchValue = @$_GET["x_phone"];
		if ($this->phone->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->phone->AdvancedSearch->SearchOperator = @$_GET["z_phone"];

		// gender
		$this->gender->AdvancedSearch->SearchValue = @$_GET["x_gender"];
		if ($this->gender->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->gender->AdvancedSearch->SearchOperator = @$_GET["z_gender"];

		// birthday
		$this->birthday->AdvancedSearch->SearchValue = @$_GET["x_birthday"];
		if ($this->birthday->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->birthday->AdvancedSearch->SearchOperator = @$_GET["z_birthday"];

		// image
		$this->image->AdvancedSearch->SearchValue = @$_GET["x_image"];
		if ($this->image->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->image->AdvancedSearch->SearchOperator = @$_GET["z_image"];

		// country_id
		$this->country_id->AdvancedSearch->SearchValue = @$_GET["x_country_id"];
		if ($this->country_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->country_id->AdvancedSearch->SearchOperator = @$_GET["z_country_id"];

		// city
		$this->city->AdvancedSearch->SearchValue = @$_GET["x_city"];
		if ($this->city->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->city->AdvancedSearch->SearchOperator = @$_GET["z_city"];

		// currency_id
		$this->currency_id->AdvancedSearch->SearchValue = @$_GET["x_currency_id"];
		if ($this->currency_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->currency_id->AdvancedSearch->SearchOperator = @$_GET["z_currency_id"];

		// type
		$this->type->AdvancedSearch->SearchValue = @$_GET["x_type"];
		if ($this->type->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->type->AdvancedSearch->SearchOperator = @$_GET["z_type"];

		// is_verified
		$this->is_verified->AdvancedSearch->SearchValue = @$_GET["x_is_verified"];
		if ($this->is_verified->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->is_verified->AdvancedSearch->SearchOperator = @$_GET["z_is_verified"];

		// is_approved
		$this->is_approved->AdvancedSearch->SearchValue = @$_GET["x_is_approved"];
		if ($this->is_approved->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->is_approved->AdvancedSearch->SearchOperator = @$_GET["z_is_approved"];

		// is_blocked
		$this->is_blocked->AdvancedSearch->SearchValue = @$_GET["x_is_blocked"];
		if ($this->is_blocked->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->is_blocked->AdvancedSearch->SearchOperator = @$_GET["z_is_blocked"];

		// otp
		$this->otp->AdvancedSearch->SearchValue = @$_GET["x_otp"];
		if ($this->otp->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->otp->AdvancedSearch->SearchOperator = @$_GET["z_otp"];

		// slug
		$this->slug->AdvancedSearch->SearchValue = @$_GET["x_slug"];
		if ($this->slug->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->slug->AdvancedSearch->SearchOperator = @$_GET["z_slug"];

		// remember_token
		$this->remember_token->AdvancedSearch->SearchValue = @$_GET["x_remember_token"];
		if ($this->remember_token->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->remember_token->AdvancedSearch->SearchOperator = @$_GET["z_remember_token"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		$this->name->setOldValue($objForm->GetValue("o_name"));
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		$this->_email->setOldValue($objForm->GetValue("o__email"));
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		$this->phone->setOldValue($objForm->GetValue("o_phone"));
		if (!$this->gender->FldIsDetailKey) {
			$this->gender->setFormValue($objForm->GetValue("x_gender"));
		}
		$this->gender->setOldValue($objForm->GetValue("o_gender"));
		if (!$this->birthday->FldIsDetailKey) {
			$this->birthday->setFormValue($objForm->GetValue("x_birthday"));
			$this->birthday->CurrentValue = ew_UnFormatDateTime($this->birthday->CurrentValue, 0);
		}
		$this->birthday->setOldValue($objForm->GetValue("o_birthday"));
		if (!$this->country_id->FldIsDetailKey) {
			$this->country_id->setFormValue($objForm->GetValue("x_country_id"));
		}
		$this->country_id->setOldValue($objForm->GetValue("o_country_id"));
		if (!$this->city->FldIsDetailKey) {
			$this->city->setFormValue($objForm->GetValue("x_city"));
		}
		$this->city->setOldValue($objForm->GetValue("o_city"));
		if (!$this->currency_id->FldIsDetailKey) {
			$this->currency_id->setFormValue($objForm->GetValue("x_currency_id"));
		}
		$this->currency_id->setOldValue($objForm->GetValue("o_currency_id"));
		if (!$this->type->FldIsDetailKey) {
			$this->type->setFormValue($objForm->GetValue("x_type"));
		}
		$this->type->setOldValue($objForm->GetValue("o_type"));
		if (!$this->is_verified->FldIsDetailKey) {
			$this->is_verified->setFormValue($objForm->GetValue("x_is_verified"));
		}
		$this->is_verified->setOldValue($objForm->GetValue("o_is_verified"));
		if (!$this->is_approved->FldIsDetailKey) {
			$this->is_approved->setFormValue($objForm->GetValue("x_is_approved"));
		}
		$this->is_approved->setOldValue($objForm->GetValue("o_is_approved"));
		if (!$this->is_blocked->FldIsDetailKey) {
			$this->is_blocked->setFormValue($objForm->GetValue("x_is_blocked"));
		}
		$this->is_blocked->setOldValue($objForm->GetValue("o_is_blocked"));
		if (!$this->otp->FldIsDetailKey) {
			$this->otp->setFormValue($objForm->GetValue("x_otp"));
		}
		$this->otp->setOldValue($objForm->GetValue("o_otp"));
		if (!$this->slug->FldIsDetailKey) {
			$this->slug->setFormValue($objForm->GetValue("x_slug"));
		}
		$this->slug->setOldValue($objForm->GetValue("o_slug"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->name->CurrentValue = $this->name->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->gender->CurrentValue = $this->gender->FormValue;
		$this->birthday->CurrentValue = $this->birthday->FormValue;
		$this->birthday->CurrentValue = ew_UnFormatDateTime($this->birthday->CurrentValue, 0);
		$this->country_id->CurrentValue = $this->country_id->FormValue;
		$this->city->CurrentValue = $this->city->FormValue;
		$this->currency_id->CurrentValue = $this->currency_id->FormValue;
		$this->type->CurrentValue = $this->type->FormValue;
		$this->is_verified->CurrentValue = $this->is_verified->FormValue;
		$this->is_approved->CurrentValue = $this->is_approved->FormValue;
		$this->is_blocked->CurrentValue = $this->is_blocked->FormValue;
		$this->otp->CurrentValue = $this->otp->FormValue;
		$this->slug->CurrentValue = $this->slug->FormValue;
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
		$this->image->Upload->DbValue = $row['image'];
		$this->image->setDbValue($this->image->Upload->DbValue);
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
		$row['image'] = $this->image->Upload->DbValue;
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
		$this->image->Upload->DbValue = $row['image'];
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
		// name
		// email
		// email_verified_at

		$this->email_verified_at->CellCssStyle = "white-space: nowrap;";

		// password
		$this->password->CellCssStyle = "white-space: nowrap;";

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

		$this->created_at->CellCssStyle = "white-space: nowrap;";

		// updated_at
		$this->updated_at->CellCssStyle = "white-space: nowrap;";
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
		$this->image->UploadPath = "../images";
		if (!ew_Empty($this->image->Upload->DbValue)) {
			$this->image->ViewValue = $this->image->Upload->DbValue;
		} else {
			$this->image->ViewValue = "";
		}
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
			$this->image->HrefValue2 = $this->image->UploadPath . $this->image->Upload->DbValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id
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
			$this->image->UploadPath = "../images";
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->EditValue = $this->image->Upload->DbValue;
			} else {
				$this->image->EditValue = "";
			}
			if (!ew_Empty($this->image->CurrentValue))
					if ($this->RowIndex == '$rowindex$')
						$this->image->Upload->FileName = "";
					else
						$this->image->Upload->FileName = $this->image->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->image, $this->RowIndex);

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

			// Add refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

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
			$this->image->HrefValue2 = $this->image->UploadPath . $this->image->Upload->DbValue;

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
			$this->image->UploadPath = "../images";
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->EditValue = $this->image->Upload->DbValue;
			} else {
				$this->image->EditValue = "";
			}
			if (!ew_Empty($this->image->CurrentValue))
					if ($this->RowIndex == '$rowindex$')
						$this->image->Upload->FileName = "";
					else
						$this->image->Upload->FileName = $this->image->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->image, $this->RowIndex);

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
			$this->image->HrefValue2 = $this->image->UploadPath . $this->image->Upload->DbValue;

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = ew_HtmlEncode($this->id->AdvancedSearch->SearchValue);
			$this->id->PlaceHolder = ew_RemoveHtml($this->id->FldCaption());

			// name
			$this->name->EditAttrs["class"] = "form-control";
			$this->name->EditCustomAttributes = "";
			$this->name->EditValue = ew_HtmlEncode($this->name->AdvancedSearch->SearchValue);
			$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->AdvancedSearch->SearchValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// phone
			$this->phone->EditAttrs["class"] = "form-control";
			$this->phone->EditCustomAttributes = "";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->AdvancedSearch->SearchValue);
			$this->phone->PlaceHolder = ew_RemoveHtml($this->phone->FldCaption());

			// gender
			$this->gender->EditAttrs["class"] = "form-control";
			$this->gender->EditCustomAttributes = "";
			$this->gender->EditValue = $this->gender->Options(TRUE);

			// birthday
			$this->birthday->EditAttrs["class"] = "form-control";
			$this->birthday->EditCustomAttributes = "";
			$this->birthday->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->birthday->AdvancedSearch->SearchValue, 0), 8));
			$this->birthday->PlaceHolder = ew_RemoveHtml($this->birthday->FldCaption());

			// image
			$this->image->EditAttrs["class"] = "form-control";
			$this->image->EditCustomAttributes = "";
			$this->image->EditValue = ew_HtmlEncode($this->image->AdvancedSearch->SearchValue);
			$this->image->PlaceHolder = ew_RemoveHtml($this->image->FldCaption());

			// country_id
			$this->country_id->EditAttrs["class"] = "form-control";
			$this->country_id->EditCustomAttributes = "";

			// city
			$this->city->EditAttrs["class"] = "form-control";
			$this->city->EditCustomAttributes = "";
			$this->city->EditValue = ew_HtmlEncode($this->city->AdvancedSearch->SearchValue);
			$this->city->PlaceHolder = ew_RemoveHtml($this->city->FldCaption());

			// currency_id
			$this->currency_id->EditAttrs["class"] = "form-control";
			$this->currency_id->EditCustomAttributes = "";

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
			$this->otp->EditValue = ew_HtmlEncode($this->otp->AdvancedSearch->SearchValue);
			$this->otp->PlaceHolder = ew_RemoveHtml($this->otp->FldCaption());

			// slug
			$this->slug->EditAttrs["class"] = "form-control";
			$this->slug->EditCustomAttributes = "";
			$this->slug->EditValue = ew_HtmlEncode($this->slug->AdvancedSearch->SearchValue);
			$this->slug->PlaceHolder = ew_RemoveHtml($this->slug->FldCaption());
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
		if (!$this->name->FldIsDetailKey && !is_null($this->name->FormValue) && $this->name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->name->FldCaption(), $this->name->ReqErrMsg));
		}
		if (!$this->_email->FldIsDetailKey && !is_null($this->_email->FormValue) && $this->_email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_email->FldCaption(), $this->_email->ReqErrMsg));
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
				$this->image->OldUploadPath = "../images";
				$OldFiles = ew_Empty($row['image']) ? array() : array($row['image']);
				$OldFileCount = count($OldFiles);
				for ($i = 0; $i < $OldFileCount; $i++) {
					if (file_exists($this->image->OldPhysicalUploadPath() . $OldFiles[$i]))
						@unlink($this->image->OldPhysicalUploadPath() . $OldFiles[$i]);
				}
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

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$this->image->OldUploadPath = "../images";
			$this->image->UploadPath = $this->image->OldUploadPath;
			$rsnew = array();

			// name
			$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, "", $this->name->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", $this->_email->ReadOnly);

			// phone
			$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, $this->phone->ReadOnly);

			// gender
			$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, "", $this->gender->ReadOnly);

			// birthday
			$this->birthday->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->birthday->CurrentValue, 0), NULL, $this->birthday->ReadOnly);

			// image
			if ($this->image->Visible && !$this->image->ReadOnly && !$this->image->Upload->KeepFile) {
				$this->image->Upload->DbValue = $rsold['image']; // Get original value
				if ($this->image->Upload->FileName == "") {
					$rsnew['image'] = NULL;
				} else {
					$rsnew['image'] = $this->image->Upload->FileName;
				}
			}

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
			if ($this->image->Visible && !$this->image->Upload->KeepFile) {
				$this->image->UploadPath = "../images";
				$OldFiles = ew_Empty($this->image->Upload->DbValue) ? array() : array($this->image->Upload->DbValue);
				if (!ew_Empty($this->image->Upload->FileName)) {
					$NewFiles = array($this->image->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->image->Upload->Index < 0) ? $this->image->FldVar : substr($this->image->FldVar, 0, 1) . $this->image->Upload->Index . substr($this->image->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file)) {
								$OldFileFound = FALSE;
								$OldFileCount = count($OldFiles);
								for ($j = 0; $j < $OldFileCount; $j++) {
									$file1 = $OldFiles[$j];
									if ($file1 == $file) { // Old file found, no need to delete anymore
										unset($OldFiles[$j]);
										$OldFileFound = TRUE;
										break;
									}
								}
								if ($OldFileFound) // No need to check if file exists further
									continue;
								$file1 = ew_UploadFileNameEx($this->image->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file1) || file_exists($this->image->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->image->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file, ew_UploadTempPath($fldvar, $this->image->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->image->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->image->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->image->SetDbValueDef($rsnew, $this->image->Upload->FileName, NULL, $this->image->ReadOnly);
				}
			}

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
					if ($this->image->Visible && !$this->image->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->image->Upload->DbValue) ? array() : array($this->image->Upload->DbValue);
						if (!ew_Empty($this->image->Upload->FileName)) {
							$NewFiles = array($this->image->Upload->FileName);
							$NewFiles2 = array($rsnew['image']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->image->Upload->Index < 0) ? $this->image->FldVar : substr($this->image->FldVar, 0, 1) . $this->image->Upload->Index . substr($this->image->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->image->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->image->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
											$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
											return FALSE;
										}
									}
								}
							}
						} else {
							$NewFiles = array();
						}
						$OldFileCount = count($OldFiles);
						for ($i = 0; $i < $OldFileCount; $i++) {
							if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
								@unlink($this->image->OldPhysicalUploadPath() . $OldFiles[$i]);
						}
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

		// image
		ew_CleanUploadTempPath($this->image, $this->image->Upload->Index);
		return $EditRow;
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

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
			$this->image->OldUploadPath = "../images";
			$this->image->UploadPath = $this->image->OldUploadPath;
		}
		$rsnew = array();

		// name
		$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, "", FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", FALSE);

		// phone
		$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, FALSE);

		// gender
		$this->gender->SetDbValueDef($rsnew, $this->gender->CurrentValue, "", strval($this->gender->CurrentValue) == "");

		// birthday
		$this->birthday->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->birthday->CurrentValue, 0), NULL, FALSE);

		// image
		if ($this->image->Visible && !$this->image->Upload->KeepFile) {
			$this->image->Upload->DbValue = ""; // No need to delete old file
			if ($this->image->Upload->FileName == "") {
				$rsnew['image'] = NULL;
			} else {
				$rsnew['image'] = $this->image->Upload->FileName;
			}
		}

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
		if ($this->image->Visible && !$this->image->Upload->KeepFile) {
			$this->image->UploadPath = "../images";
			$OldFiles = ew_Empty($this->image->Upload->DbValue) ? array() : array($this->image->Upload->DbValue);
			if (!ew_Empty($this->image->Upload->FileName)) {
				$NewFiles = array($this->image->Upload->FileName);
				$NewFileCount = count($NewFiles);
				for ($i = 0; $i < $NewFileCount; $i++) {
					$fldvar = ($this->image->Upload->Index < 0) ? $this->image->FldVar : substr($this->image->FldVar, 0, 1) . $this->image->Upload->Index . substr($this->image->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file)) {
							$OldFileFound = FALSE;
							$OldFileCount = count($OldFiles);
							for ($j = 0; $j < $OldFileCount; $j++) {
								$file1 = $OldFiles[$j];
								if ($file1 == $file) { // Old file found, no need to delete anymore
									unset($OldFiles[$j]);
									$OldFileFound = TRUE;
									break;
								}
							}
							if ($OldFileFound) // No need to check if file exists further
								continue;
							$file1 = ew_UploadFileNameEx($this->image->PhysicalUploadPath(), $file); // Get new file name
							if ($file1 <> $file) { // Rename temp file
								while (file_exists(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file1) || file_exists($this->image->PhysicalUploadPath() . $file1)) // Make sure no file name clash
									$file1 = ew_UniqueFilename($this->image->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
								rename(ew_UploadTempPath($fldvar, $this->image->TblVar) . $file, ew_UploadTempPath($fldvar, $this->image->TblVar) . $file1);
								$NewFiles[$i] = $file1;
							}
						}
					}
				}
				$this->image->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
				$this->image->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$this->image->SetDbValueDef($rsnew, $this->image->Upload->FileName, NULL, FALSE);
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if ($this->image->Visible && !$this->image->Upload->KeepFile) {
					$OldFiles = ew_Empty($this->image->Upload->DbValue) ? array() : array($this->image->Upload->DbValue);
					if (!ew_Empty($this->image->Upload->FileName)) {
						$NewFiles = array($this->image->Upload->FileName);
						$NewFiles2 = array($rsnew['image']);
						$NewFileCount = count($NewFiles);
						for ($i = 0; $i < $NewFileCount; $i++) {
							$fldvar = ($this->image->Upload->Index < 0) ? $this->image->FldVar : substr($this->image->FldVar, 0, 1) . $this->image->Upload->Index . substr($this->image->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->image->TblVar) . $NewFiles[$i];
								if (file_exists($file)) {
									if (@$NewFiles2[$i] <> "") // Use correct file name
										$NewFiles[$i] = $NewFiles2[$i];
									if (!$this->image->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
										$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
										return FALSE;
									}
								}
							}
						}
					} else {
						$NewFiles = array();
					}
					$OldFileCount = count($OldFiles);
					for ($i = 0; $i < $OldFileCount; $i++) {
						if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
							@unlink($this->image->OldPhysicalUploadPath() . $OldFiles[$i]);
					}
				}
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

		// image
		ew_CleanUploadTempPath($this->image, $this->image->Upload->Index);
		return $AddRow;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->id->AdvancedSearch->Load();
		$this->name->AdvancedSearch->Load();
		$this->_email->AdvancedSearch->Load();
		$this->password->AdvancedSearch->Load();
		$this->phone->AdvancedSearch->Load();
		$this->gender->AdvancedSearch->Load();
		$this->birthday->AdvancedSearch->Load();
		$this->image->AdvancedSearch->Load();
		$this->country_id->AdvancedSearch->Load();
		$this->city->AdvancedSearch->Load();
		$this->currency_id->AdvancedSearch->Load();
		$this->type->AdvancedSearch->Load();
		$this->is_verified->AdvancedSearch->Load();
		$this->is_approved->AdvancedSearch->Load();
		$this->is_blocked->AdvancedSearch->Load();
		$this->otp->AdvancedSearch->Load();
		$this->slug->AdvancedSearch->Load();
		$this->remember_token->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_users\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_users',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fuserslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($users_list)) $users_list = new cusers_list();

// Page init
$users_list->Page_Init();

// Page main
$users_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($users->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fuserslist = new ew_Form("fuserslist", "list");
fuserslist.FormKeyCountName = '<?php echo $users_list->FormKeyCountName ?>';

// Validate form
fuserslist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->name->FldCaption(), $users->name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $users->_email->FldCaption(), $users->_email->ReqErrMsg)) ?>");
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
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fuserslist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "_email", false)) return false;
	if (ew_ValueChanged(fobj, infix, "phone", false)) return false;
	if (ew_ValueChanged(fobj, infix, "gender", false)) return false;
	if (ew_ValueChanged(fobj, infix, "birthday", false)) return false;
	if (ew_ValueChanged(fobj, infix, "image", false)) return false;
	if (ew_ValueChanged(fobj, infix, "country_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "city", false)) return false;
	if (ew_ValueChanged(fobj, infix, "currency_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "type", false)) return false;
	if (ew_ValueChanged(fobj, infix, "is_verified", false)) return false;
	if (ew_ValueChanged(fobj, infix, "is_approved", false)) return false;
	if (ew_ValueChanged(fobj, infix, "is_blocked", false)) return false;
	if (ew_ValueChanged(fobj, infix, "otp", false)) return false;
	if (ew_ValueChanged(fobj, infix, "slug", false)) return false;
	return true;
}

// Form_CustomValidate event
fuserslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fuserslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fuserslist.Lists["x_gender"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuserslist.Lists["x_gender"].Options = <?php echo json_encode($users_list->gender->Options()) ?>;
fuserslist.Lists["x_country_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name_ar","x_name_en","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"countries"};
fuserslist.Lists["x_country_id"].Data = "<?php echo $users_list->country_id->LookupFilterQuery(FALSE, "list") ?>";
fuserslist.Lists["x_currency_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name_ar","x_name_en","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"currencies"};
fuserslist.Lists["x_currency_id"].Data = "<?php echo $users_list->currency_id->LookupFilterQuery(FALSE, "list") ?>";
fuserslist.Lists["x_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuserslist.Lists["x_type"].Options = <?php echo json_encode($users_list->type->Options()) ?>;
fuserslist.Lists["x_is_verified"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuserslist.Lists["x_is_verified"].Options = <?php echo json_encode($users_list->is_verified->Options()) ?>;
fuserslist.Lists["x_is_approved"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuserslist.Lists["x_is_approved"].Options = <?php echo json_encode($users_list->is_approved->Options()) ?>;
fuserslist.Lists["x_is_blocked"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuserslist.Lists["x_is_blocked"].Options = <?php echo json_encode($users_list->is_blocked->Options()) ?>;

// Form object for search
var CurrentSearchForm = fuserslistsrch = new ew_Form("fuserslistsrch");

// Validate function for search
fuserslistsrch.Validate = function(fobj) {
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
fuserslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fuserslistsrch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fuserslistsrch.Lists["x_gender"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuserslistsrch.Lists["x_gender"].Options = <?php echo json_encode($users_list->gender->Options()) ?>;
fuserslistsrch.Lists["x_type"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fuserslistsrch.Lists["x_type"].Options = <?php echo json_encode($users_list->type->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($users->Export == "") { ?>
<div class="ewToolbar">
<?php if ($users_list->TotalRecs > 0 && $users_list->ExportOptions->Visible()) { ?>
<?php $users_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($users_list->SearchOptions->Visible()) { ?>
<?php $users_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($users_list->FilterOptions->Visible()) { ?>
<?php $users_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($users->CurrentAction == "gridadd") {
	$users->CurrentFilter = "0=1";
	$users_list->StartRec = 1;
	$users_list->DisplayRecs = $users->GridAddRowCount;
	$users_list->TotalRecs = $users_list->DisplayRecs;
	$users_list->StopRec = $users_list->DisplayRecs;
} else {
	$bSelectLimit = $users_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($users_list->TotalRecs <= 0)
			$users_list->TotalRecs = $users->ListRecordCount();
	} else {
		if (!$users_list->Recordset && ($users_list->Recordset = $users_list->LoadRecordset()))
			$users_list->TotalRecs = $users_list->Recordset->RecordCount();
	}
	$users_list->StartRec = 1;
	if ($users_list->DisplayRecs <= 0 || ($users->Export <> "" && $users->ExportAll)) // Display all records
		$users_list->DisplayRecs = $users_list->TotalRecs;
	if (!($users->Export <> "" && $users->ExportAll))
		$users_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$users_list->Recordset = $users_list->LoadRecordset($users_list->StartRec-1, $users_list->DisplayRecs);

	// Set no record found message
	if ($users->CurrentAction == "" && $users_list->TotalRecs == 0) {
		if ($users_list->SearchWhere == "0=101")
			$users_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$users_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$users_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($users->Export == "" && $users->CurrentAction == "") { ?>
<form name="fuserslistsrch" id="fuserslistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($users_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fuserslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="users">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$users_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$users->RowType = EW_ROWTYPE_SEARCH;

// Render row
$users->ResetAttrs();
$users_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($users->gender->Visible) { // gender ?>
	<div id="xsc_gender" class="ewCell form-group">
		<label for="x_gender" class="ewSearchCaption ewLabel"><?php echo $users->gender->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_gender" id="z_gender" value="="></span>
		<span class="ewSearchField">
<select data-table="users" data-field="x_gender" data-value-separator="<?php echo $users->gender->DisplayValueSeparatorAttribute() ?>" id="x_gender" name="x_gender"<?php echo $users->gender->EditAttributes() ?>>
<?php echo $users->gender->SelectOptionListHtml("x_gender") ?>
</select>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($users->type->Visible) { // type ?>
	<div id="xsc_type" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $users->type->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_type" id="z_type" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_type" class="ewTemplate"><input type="radio" data-table="users" data-field="x_type" data-value-separator="<?php echo $users->type->DisplayValueSeparatorAttribute() ?>" name="x_type" id="x_type" value="{value}"<?php echo $users->type->EditAttributes() ?>></div>
<div id="dsl_x_type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->type->RadioButtonListHtml(FALSE, "x_type") ?>
</div></div>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($users_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($users_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $users_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($users_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($users_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($users_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($users_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $users_list->ShowPageHeader(); ?>
<?php
$users_list->ShowMessage();
?>
<?php if ($users_list->TotalRecs > 0 || $users->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($users_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> users">
<?php if ($users->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($users->CurrentAction <> "gridadd" && $users->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($users_list->Pager)) $users_list->Pager = new cPrevNextPager($users_list->StartRec, $users_list->DisplayRecs, $users_list->TotalRecs, $users_list->AutoHidePager) ?>
<?php if ($users_list->Pager->RecordCount > 0 && $users_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($users_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($users_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $users_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($users_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($users_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($users_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $users_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $users_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $users_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($users_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fuserslist" id="fuserslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($users_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $users_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<div id="gmp_users" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($users_list->TotalRecs > 0 || $users->CurrentAction == "gridedit") { ?>
<table id="tbl_userslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$users_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$users_list->RenderListOptions();

// Render list options (header, left)
$users_list->ListOptions->Render("header", "left");
?>
<?php if ($users->id->Visible) { // id ?>
	<?php if ($users->SortUrl($users->id) == "") { ?>
		<th data-name="id" class="<?php echo $users->id->HeaderCellClass() ?>"><div id="elh_users_id" class="users_id"><div class="ewTableHeaderCaption"><?php echo $users->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $users->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->id) ?>',1);"><div id="elh_users_id" class="users_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
	<?php if ($users->SortUrl($users->name) == "") { ?>
		<th data-name="name" class="<?php echo $users->name->HeaderCellClass() ?>"><div id="elh_users_name" class="users_name"><div class="ewTableHeaderCaption"><?php echo $users->name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="name" class="<?php echo $users->name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->name) ?>',1);"><div id="elh_users_name" class="users_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->_email->Visible) { // email ?>
	<?php if ($users->SortUrl($users->_email) == "") { ?>
		<th data-name="_email" class="<?php echo $users->_email->HeaderCellClass() ?>"><div id="elh_users__email" class="users__email"><div class="ewTableHeaderCaption"><?php echo $users->_email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_email" class="<?php echo $users->_email->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->_email) ?>',1);"><div id="elh_users__email" class="users__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->_email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->phone->Visible) { // phone ?>
	<?php if ($users->SortUrl($users->phone) == "") { ?>
		<th data-name="phone" class="<?php echo $users->phone->HeaderCellClass() ?>"><div id="elh_users_phone" class="users_phone"><div class="ewTableHeaderCaption"><?php echo $users->phone->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="phone" class="<?php echo $users->phone->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->phone) ?>',1);"><div id="elh_users_phone" class="users_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->gender->Visible) { // gender ?>
	<?php if ($users->SortUrl($users->gender) == "") { ?>
		<th data-name="gender" class="<?php echo $users->gender->HeaderCellClass() ?>"><div id="elh_users_gender" class="users_gender"><div class="ewTableHeaderCaption"><?php echo $users->gender->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="gender" class="<?php echo $users->gender->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->gender) ?>',1);"><div id="elh_users_gender" class="users_gender">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->gender->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->gender->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->gender->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->birthday->Visible) { // birthday ?>
	<?php if ($users->SortUrl($users->birthday) == "") { ?>
		<th data-name="birthday" class="<?php echo $users->birthday->HeaderCellClass() ?>"><div id="elh_users_birthday" class="users_birthday"><div class="ewTableHeaderCaption"><?php echo $users->birthday->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="birthday" class="<?php echo $users->birthday->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->birthday) ?>',1);"><div id="elh_users_birthday" class="users_birthday">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->birthday->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->birthday->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->birthday->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->image->Visible) { // image ?>
	<?php if ($users->SortUrl($users->image) == "") { ?>
		<th data-name="image" class="<?php echo $users->image->HeaderCellClass() ?>"><div id="elh_users_image" class="users_image"><div class="ewTableHeaderCaption"><?php echo $users->image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="image" class="<?php echo $users->image->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->image) ?>',1);"><div id="elh_users_image" class="users_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->image->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->country_id->Visible) { // country_id ?>
	<?php if ($users->SortUrl($users->country_id) == "") { ?>
		<th data-name="country_id" class="<?php echo $users->country_id->HeaderCellClass() ?>"><div id="elh_users_country_id" class="users_country_id"><div class="ewTableHeaderCaption"><?php echo $users->country_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="country_id" class="<?php echo $users->country_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->country_id) ?>',1);"><div id="elh_users_country_id" class="users_country_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->country_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->country_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->country_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->city->Visible) { // city ?>
	<?php if ($users->SortUrl($users->city) == "") { ?>
		<th data-name="city" class="<?php echo $users->city->HeaderCellClass() ?>"><div id="elh_users_city" class="users_city"><div class="ewTableHeaderCaption"><?php echo $users->city->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="city" class="<?php echo $users->city->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->city) ?>',1);"><div id="elh_users_city" class="users_city">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->city->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->city->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->city->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->currency_id->Visible) { // currency_id ?>
	<?php if ($users->SortUrl($users->currency_id) == "") { ?>
		<th data-name="currency_id" class="<?php echo $users->currency_id->HeaderCellClass() ?>"><div id="elh_users_currency_id" class="users_currency_id"><div class="ewTableHeaderCaption"><?php echo $users->currency_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency_id" class="<?php echo $users->currency_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->currency_id) ?>',1);"><div id="elh_users_currency_id" class="users_currency_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->currency_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->currency_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->currency_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->type->Visible) { // type ?>
	<?php if ($users->SortUrl($users->type) == "") { ?>
		<th data-name="type" class="<?php echo $users->type->HeaderCellClass() ?>"><div id="elh_users_type" class="users_type"><div class="ewTableHeaderCaption"><?php echo $users->type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="type" class="<?php echo $users->type->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->type) ?>',1);"><div id="elh_users_type" class="users_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->is_verified->Visible) { // is_verified ?>
	<?php if ($users->SortUrl($users->is_verified) == "") { ?>
		<th data-name="is_verified" class="<?php echo $users->is_verified->HeaderCellClass() ?>"><div id="elh_users_is_verified" class="users_is_verified"><div class="ewTableHeaderCaption"><?php echo $users->is_verified->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="is_verified" class="<?php echo $users->is_verified->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->is_verified) ?>',1);"><div id="elh_users_is_verified" class="users_is_verified">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->is_verified->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->is_verified->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->is_verified->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->is_approved->Visible) { // is_approved ?>
	<?php if ($users->SortUrl($users->is_approved) == "") { ?>
		<th data-name="is_approved" class="<?php echo $users->is_approved->HeaderCellClass() ?>"><div id="elh_users_is_approved" class="users_is_approved"><div class="ewTableHeaderCaption"><?php echo $users->is_approved->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="is_approved" class="<?php echo $users->is_approved->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->is_approved) ?>',1);"><div id="elh_users_is_approved" class="users_is_approved">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->is_approved->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->is_approved->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->is_approved->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->is_blocked->Visible) { // is_blocked ?>
	<?php if ($users->SortUrl($users->is_blocked) == "") { ?>
		<th data-name="is_blocked" class="<?php echo $users->is_blocked->HeaderCellClass() ?>"><div id="elh_users_is_blocked" class="users_is_blocked"><div class="ewTableHeaderCaption"><?php echo $users->is_blocked->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="is_blocked" class="<?php echo $users->is_blocked->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->is_blocked) ?>',1);"><div id="elh_users_is_blocked" class="users_is_blocked">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->is_blocked->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->is_blocked->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->is_blocked->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->otp->Visible) { // otp ?>
	<?php if ($users->SortUrl($users->otp) == "") { ?>
		<th data-name="otp" class="<?php echo $users->otp->HeaderCellClass() ?>"><div id="elh_users_otp" class="users_otp"><div class="ewTableHeaderCaption"><?php echo $users->otp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="otp" class="<?php echo $users->otp->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->otp) ?>',1);"><div id="elh_users_otp" class="users_otp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->otp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->otp->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->otp->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($users->slug->Visible) { // slug ?>
	<?php if ($users->SortUrl($users->slug) == "") { ?>
		<th data-name="slug" class="<?php echo $users->slug->HeaderCellClass() ?>"><div id="elh_users_slug" class="users_slug"><div class="ewTableHeaderCaption"><?php echo $users->slug->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="slug" class="<?php echo $users->slug->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->slug) ?>',1);"><div id="elh_users_slug" class="users_slug">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->slug->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->slug->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->slug->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$users_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($users->ExportAll && $users->Export <> "") {
	$users_list->StopRec = $users_list->TotalRecs;
} else {

	// Set the last record to display
	if ($users_list->TotalRecs > $users_list->StartRec + $users_list->DisplayRecs - 1)
		$users_list->StopRec = $users_list->StartRec + $users_list->DisplayRecs - 1;
	else
		$users_list->StopRec = $users_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($users_list->FormKeyCountName) && ($users->CurrentAction == "gridadd" || $users->CurrentAction == "gridedit" || $users->CurrentAction == "F")) {
		$users_list->KeyCount = $objForm->GetValue($users_list->FormKeyCountName);
		$users_list->StopRec = $users_list->StartRec + $users_list->KeyCount - 1;
	}
}
$users_list->RecCnt = $users_list->StartRec - 1;
if ($users_list->Recordset && !$users_list->Recordset->EOF) {
	$users_list->Recordset->MoveFirst();
	$bSelectLimit = $users_list->UseSelectLimit;
	if (!$bSelectLimit && $users_list->StartRec > 1)
		$users_list->Recordset->Move($users_list->StartRec - 1);
} elseif (!$users->AllowAddDeleteRow && $users_list->StopRec == 0) {
	$users_list->StopRec = $users->GridAddRowCount;
}

// Initialize aggregate
$users->RowType = EW_ROWTYPE_AGGREGATEINIT;
$users->ResetAttrs();
$users_list->RenderRow();
if ($users->CurrentAction == "gridadd")
	$users_list->RowIndex = 0;
if ($users->CurrentAction == "gridedit")
	$users_list->RowIndex = 0;
while ($users_list->RecCnt < $users_list->StopRec) {
	$users_list->RecCnt++;
	if (intval($users_list->RecCnt) >= intval($users_list->StartRec)) {
		$users_list->RowCnt++;
		if ($users->CurrentAction == "gridadd" || $users->CurrentAction == "gridedit" || $users->CurrentAction == "F") {
			$users_list->RowIndex++;
			$objForm->Index = $users_list->RowIndex;
			if ($objForm->HasValue($users_list->FormActionName))
				$users_list->RowAction = strval($objForm->GetValue($users_list->FormActionName));
			elseif ($users->CurrentAction == "gridadd")
				$users_list->RowAction = "insert";
			else
				$users_list->RowAction = "";
		}

		// Set up key count
		$users_list->KeyCount = $users_list->RowIndex;

		// Init row class and style
		$users->ResetAttrs();
		$users->CssClass = "";
		if ($users->CurrentAction == "gridadd") {
			$users_list->LoadRowValues(); // Load default values
		} else {
			$users_list->LoadRowValues($users_list->Recordset); // Load row values
		}
		$users->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($users->CurrentAction == "gridadd") // Grid add
			$users->RowType = EW_ROWTYPE_ADD; // Render add
		if ($users->CurrentAction == "gridadd" && $users->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$users_list->RestoreCurrentRowFormValues($users_list->RowIndex); // Restore form values
		if ($users->CurrentAction == "gridedit") { // Grid edit
			if ($users->EventCancelled) {
				$users_list->RestoreCurrentRowFormValues($users_list->RowIndex); // Restore form values
			}
			if ($users_list->RowAction == "insert")
				$users->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$users->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($users->CurrentAction == "gridedit" && ($users->RowType == EW_ROWTYPE_EDIT || $users->RowType == EW_ROWTYPE_ADD) && $users->EventCancelled) // Update failed
			$users_list->RestoreCurrentRowFormValues($users_list->RowIndex); // Restore form values
		if ($users->RowType == EW_ROWTYPE_EDIT) // Edit row
			$users_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$users->RowAttrs = array_merge($users->RowAttrs, array('data-rowindex'=>$users_list->RowCnt, 'id'=>'r' . $users_list->RowCnt . '_users', 'data-rowtype'=>$users->RowType));

		// Render row
		$users_list->RenderRow();

		// Render list options
		$users_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($users_list->RowAction <> "delete" && $users_list->RowAction <> "insertdelete" && !($users_list->RowAction == "insert" && $users->CurrentAction == "F" && $users_list->EmptyRow())) {
?>
	<tr<?php echo $users->RowAttributes() ?>>
<?php

// Render list options (body, left)
$users_list->ListOptions->Render("body", "left", $users_list->RowCnt);
?>
	<?php if ($users->id->Visible) { // id ?>
		<td data-name="id"<?php echo $users->id->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="users" data-field="x_id" name="o<?php echo $users_list->RowIndex ?>_id" id="o<?php echo $users_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($users->id->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_id" class="form-group users_id">
<span<?php echo $users->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $users->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="users" data-field="x_id" name="x<?php echo $users_list->RowIndex ?>_id" id="x<?php echo $users_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($users->id->CurrentValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_id" class="users_id">
<span<?php echo $users->id->ViewAttributes() ?>>
<?php echo $users->id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->name->Visible) { // name ?>
		<td data-name="name"<?php echo $users->name->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_name" class="form-group users_name">
<input type="text" data-table="users" data-field="x_name" name="x<?php echo $users_list->RowIndex ?>_name" id="x<?php echo $users_list->RowIndex ?>_name" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($users->name->getPlaceHolder()) ?>" value="<?php echo $users->name->EditValue ?>"<?php echo $users->name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_name" name="o<?php echo $users_list->RowIndex ?>_name" id="o<?php echo $users_list->RowIndex ?>_name" value="<?php echo ew_HtmlEncode($users->name->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_name" class="form-group users_name">
<input type="text" data-table="users" data-field="x_name" name="x<?php echo $users_list->RowIndex ?>_name" id="x<?php echo $users_list->RowIndex ?>_name" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($users->name->getPlaceHolder()) ?>" value="<?php echo $users->name->EditValue ?>"<?php echo $users->name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_name" class="users_name">
<span<?php echo $users->name->ViewAttributes() ?>>
<?php echo $users->name->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->_email->Visible) { // email ?>
		<td data-name="_email"<?php echo $users->_email->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users__email" class="form-group users__email">
<input type="text" data-table="users" data-field="x__email" name="x<?php echo $users_list->RowIndex ?>__email" id="x<?php echo $users_list->RowIndex ?>__email" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($users->_email->getPlaceHolder()) ?>" value="<?php echo $users->_email->EditValue ?>"<?php echo $users->_email->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x__email" name="o<?php echo $users_list->RowIndex ?>__email" id="o<?php echo $users_list->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($users->_email->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users__email" class="form-group users__email">
<input type="text" data-table="users" data-field="x__email" name="x<?php echo $users_list->RowIndex ?>__email" id="x<?php echo $users_list->RowIndex ?>__email" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($users->_email->getPlaceHolder()) ?>" value="<?php echo $users->_email->EditValue ?>"<?php echo $users->_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users__email" class="users__email">
<span<?php echo $users->_email->ViewAttributes() ?>>
<?php echo $users->_email->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->phone->Visible) { // phone ?>
		<td data-name="phone"<?php echo $users->phone->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_phone" class="form-group users_phone">
<input type="text" data-table="users" data-field="x_phone" name="x<?php echo $users_list->RowIndex ?>_phone" id="x<?php echo $users_list->RowIndex ?>_phone" placeholder="<?php echo ew_HtmlEncode($users->phone->getPlaceHolder()) ?>" value="<?php echo $users->phone->EditValue ?>"<?php echo $users->phone->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_phone" name="o<?php echo $users_list->RowIndex ?>_phone" id="o<?php echo $users_list->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($users->phone->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_phone" class="form-group users_phone">
<input type="text" data-table="users" data-field="x_phone" name="x<?php echo $users_list->RowIndex ?>_phone" id="x<?php echo $users_list->RowIndex ?>_phone" placeholder="<?php echo ew_HtmlEncode($users->phone->getPlaceHolder()) ?>" value="<?php echo $users->phone->EditValue ?>"<?php echo $users->phone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_phone" class="users_phone">
<span<?php echo $users->phone->ViewAttributes() ?>>
<?php echo $users->phone->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->gender->Visible) { // gender ?>
		<td data-name="gender"<?php echo $users->gender->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_gender" class="form-group users_gender">
<select data-table="users" data-field="x_gender" data-value-separator="<?php echo $users->gender->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $users_list->RowIndex ?>_gender" name="x<?php echo $users_list->RowIndex ?>_gender"<?php echo $users->gender->EditAttributes() ?>>
<?php echo $users->gender->SelectOptionListHtml("x<?php echo $users_list->RowIndex ?>_gender") ?>
</select>
</span>
<input type="hidden" data-table="users" data-field="x_gender" name="o<?php echo $users_list->RowIndex ?>_gender" id="o<?php echo $users_list->RowIndex ?>_gender" value="<?php echo ew_HtmlEncode($users->gender->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_gender" class="form-group users_gender">
<select data-table="users" data-field="x_gender" data-value-separator="<?php echo $users->gender->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $users_list->RowIndex ?>_gender" name="x<?php echo $users_list->RowIndex ?>_gender"<?php echo $users->gender->EditAttributes() ?>>
<?php echo $users->gender->SelectOptionListHtml("x<?php echo $users_list->RowIndex ?>_gender") ?>
</select>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_gender" class="users_gender">
<span<?php echo $users->gender->ViewAttributes() ?>>
<?php echo $users->gender->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->birthday->Visible) { // birthday ?>
		<td data-name="birthday"<?php echo $users->birthday->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_birthday" class="form-group users_birthday">
<input type="text" data-table="users" data-field="x_birthday" name="x<?php echo $users_list->RowIndex ?>_birthday" id="x<?php echo $users_list->RowIndex ?>_birthday" placeholder="<?php echo ew_HtmlEncode($users->birthday->getPlaceHolder()) ?>" value="<?php echo $users->birthday->EditValue ?>"<?php echo $users->birthday->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_birthday" name="o<?php echo $users_list->RowIndex ?>_birthday" id="o<?php echo $users_list->RowIndex ?>_birthday" value="<?php echo ew_HtmlEncode($users->birthday->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_birthday" class="form-group users_birthday">
<input type="text" data-table="users" data-field="x_birthday" name="x<?php echo $users_list->RowIndex ?>_birthday" id="x<?php echo $users_list->RowIndex ?>_birthday" placeholder="<?php echo ew_HtmlEncode($users->birthday->getPlaceHolder()) ?>" value="<?php echo $users->birthday->EditValue ?>"<?php echo $users->birthday->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_birthday" class="users_birthday">
<span<?php echo $users->birthday->ViewAttributes() ?>>
<?php echo $users->birthday->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->image->Visible) { // image ?>
		<td data-name="image"<?php echo $users->image->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_image" class="form-group users_image">
<div id="fd_x<?php echo $users_list->RowIndex ?>_image">
<span title="<?php echo $users->image->FldTitle() ? $users->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($users->image->ReadOnly || $users->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="users" data-field="x_image" name="x<?php echo $users_list->RowIndex ?>_image" id="x<?php echo $users_list->RowIndex ?>_image"<?php echo $users->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $users_list->RowIndex ?>_image" id= "fn_x<?php echo $users_list->RowIndex ?>_image" value="<?php echo $users->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $users_list->RowIndex ?>_image" id= "fa_x<?php echo $users_list->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $users_list->RowIndex ?>_image" id= "fs_x<?php echo $users_list->RowIndex ?>_image" value="65535">
<input type="hidden" name="fx_x<?php echo $users_list->RowIndex ?>_image" id= "fx_x<?php echo $users_list->RowIndex ?>_image" value="<?php echo $users->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $users_list->RowIndex ?>_image" id= "fm_x<?php echo $users_list->RowIndex ?>_image" value="<?php echo $users->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $users_list->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="users" data-field="x_image" name="o<?php echo $users_list->RowIndex ?>_image" id="o<?php echo $users_list->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($users->image->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_image" class="form-group users_image">
<div id="fd_x<?php echo $users_list->RowIndex ?>_image">
<span title="<?php echo $users->image->FldTitle() ? $users->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($users->image->ReadOnly || $users->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="users" data-field="x_image" name="x<?php echo $users_list->RowIndex ?>_image" id="x<?php echo $users_list->RowIndex ?>_image"<?php echo $users->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $users_list->RowIndex ?>_image" id= "fn_x<?php echo $users_list->RowIndex ?>_image" value="<?php echo $users->image->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $users_list->RowIndex ?>_image"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $users_list->RowIndex ?>_image" id= "fa_x<?php echo $users_list->RowIndex ?>_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $users_list->RowIndex ?>_image" id= "fa_x<?php echo $users_list->RowIndex ?>_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $users_list->RowIndex ?>_image" id= "fs_x<?php echo $users_list->RowIndex ?>_image" value="65535">
<input type="hidden" name="fx_x<?php echo $users_list->RowIndex ?>_image" id= "fx_x<?php echo $users_list->RowIndex ?>_image" value="<?php echo $users->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $users_list->RowIndex ?>_image" id= "fm_x<?php echo $users_list->RowIndex ?>_image" value="<?php echo $users->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $users_list->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_image" class="users_image">
<span<?php echo $users->image->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($users->image, $users->image->ListViewValue()) ?>
</span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->country_id->Visible) { // country_id ?>
		<td data-name="country_id"<?php echo $users->country_id->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_country_id" class="form-group users_country_id">
<select data-table="users" data-field="x_country_id" data-value-separator="<?php echo $users->country_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $users_list->RowIndex ?>_country_id" name="x<?php echo $users_list->RowIndex ?>_country_id"<?php echo $users->country_id->EditAttributes() ?>>
<?php echo $users->country_id->SelectOptionListHtml("x<?php echo $users_list->RowIndex ?>_country_id") ?>
</select>
</span>
<input type="hidden" data-table="users" data-field="x_country_id" name="o<?php echo $users_list->RowIndex ?>_country_id" id="o<?php echo $users_list->RowIndex ?>_country_id" value="<?php echo ew_HtmlEncode($users->country_id->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_country_id" class="form-group users_country_id">
<select data-table="users" data-field="x_country_id" data-value-separator="<?php echo $users->country_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $users_list->RowIndex ?>_country_id" name="x<?php echo $users_list->RowIndex ?>_country_id"<?php echo $users->country_id->EditAttributes() ?>>
<?php echo $users->country_id->SelectOptionListHtml("x<?php echo $users_list->RowIndex ?>_country_id") ?>
</select>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_country_id" class="users_country_id">
<span<?php echo $users->country_id->ViewAttributes() ?>>
<?php echo $users->country_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->city->Visible) { // city ?>
		<td data-name="city"<?php echo $users->city->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_city" class="form-group users_city">
<input type="text" data-table="users" data-field="x_city" name="x<?php echo $users_list->RowIndex ?>_city" id="x<?php echo $users_list->RowIndex ?>_city" placeholder="<?php echo ew_HtmlEncode($users->city->getPlaceHolder()) ?>" value="<?php echo $users->city->EditValue ?>"<?php echo $users->city->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_city" name="o<?php echo $users_list->RowIndex ?>_city" id="o<?php echo $users_list->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($users->city->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_city" class="form-group users_city">
<input type="text" data-table="users" data-field="x_city" name="x<?php echo $users_list->RowIndex ?>_city" id="x<?php echo $users_list->RowIndex ?>_city" placeholder="<?php echo ew_HtmlEncode($users->city->getPlaceHolder()) ?>" value="<?php echo $users->city->EditValue ?>"<?php echo $users->city->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_city" class="users_city">
<span<?php echo $users->city->ViewAttributes() ?>>
<?php echo $users->city->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id"<?php echo $users->currency_id->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_currency_id" class="form-group users_currency_id">
<select data-table="users" data-field="x_currency_id" data-value-separator="<?php echo $users->currency_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $users_list->RowIndex ?>_currency_id" name="x<?php echo $users_list->RowIndex ?>_currency_id"<?php echo $users->currency_id->EditAttributes() ?>>
<?php echo $users->currency_id->SelectOptionListHtml("x<?php echo $users_list->RowIndex ?>_currency_id") ?>
</select>
</span>
<input type="hidden" data-table="users" data-field="x_currency_id" name="o<?php echo $users_list->RowIndex ?>_currency_id" id="o<?php echo $users_list->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($users->currency_id->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_currency_id" class="form-group users_currency_id">
<select data-table="users" data-field="x_currency_id" data-value-separator="<?php echo $users->currency_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $users_list->RowIndex ?>_currency_id" name="x<?php echo $users_list->RowIndex ?>_currency_id"<?php echo $users->currency_id->EditAttributes() ?>>
<?php echo $users->currency_id->SelectOptionListHtml("x<?php echo $users_list->RowIndex ?>_currency_id") ?>
</select>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_currency_id" class="users_currency_id">
<span<?php echo $users->currency_id->ViewAttributes() ?>>
<?php echo $users->currency_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->type->Visible) { // type ?>
		<td data-name="type"<?php echo $users->type->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_type" class="form-group users_type">
<div id="tp_x<?php echo $users_list->RowIndex ?>_type" class="ewTemplate"><input type="radio" data-table="users" data-field="x_type" data-value-separator="<?php echo $users->type->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $users_list->RowIndex ?>_type" id="x<?php echo $users_list->RowIndex ?>_type" value="{value}"<?php echo $users->type->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $users_list->RowIndex ?>_type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->type->RadioButtonListHtml(FALSE, "x{$users_list->RowIndex}_type") ?>
</div></div>
</span>
<input type="hidden" data-table="users" data-field="x_type" name="o<?php echo $users_list->RowIndex ?>_type" id="o<?php echo $users_list->RowIndex ?>_type" value="<?php echo ew_HtmlEncode($users->type->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_type" class="form-group users_type">
<div id="tp_x<?php echo $users_list->RowIndex ?>_type" class="ewTemplate"><input type="radio" data-table="users" data-field="x_type" data-value-separator="<?php echo $users->type->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $users_list->RowIndex ?>_type" id="x<?php echo $users_list->RowIndex ?>_type" value="{value}"<?php echo $users->type->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $users_list->RowIndex ?>_type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->type->RadioButtonListHtml(FALSE, "x{$users_list->RowIndex}_type") ?>
</div></div>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_type" class="users_type">
<span<?php echo $users->type->ViewAttributes() ?>>
<?php echo $users->type->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->is_verified->Visible) { // is_verified ?>
		<td data-name="is_verified"<?php echo $users->is_verified->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_is_verified" class="form-group users_is_verified">
<div id="tp_x<?php echo $users_list->RowIndex ?>_is_verified" class="ewTemplate"><input type="radio" data-table="users" data-field="x_is_verified" data-value-separator="<?php echo $users->is_verified->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $users_list->RowIndex ?>_is_verified" id="x<?php echo $users_list->RowIndex ?>_is_verified" value="{value}"<?php echo $users->is_verified->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $users_list->RowIndex ?>_is_verified" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->is_verified->RadioButtonListHtml(FALSE, "x{$users_list->RowIndex}_is_verified") ?>
</div></div>
</span>
<input type="hidden" data-table="users" data-field="x_is_verified" name="o<?php echo $users_list->RowIndex ?>_is_verified" id="o<?php echo $users_list->RowIndex ?>_is_verified" value="<?php echo ew_HtmlEncode($users->is_verified->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_is_verified" class="form-group users_is_verified">
<div id="tp_x<?php echo $users_list->RowIndex ?>_is_verified" class="ewTemplate"><input type="radio" data-table="users" data-field="x_is_verified" data-value-separator="<?php echo $users->is_verified->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $users_list->RowIndex ?>_is_verified" id="x<?php echo $users_list->RowIndex ?>_is_verified" value="{value}"<?php echo $users->is_verified->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $users_list->RowIndex ?>_is_verified" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->is_verified->RadioButtonListHtml(FALSE, "x{$users_list->RowIndex}_is_verified") ?>
</div></div>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_is_verified" class="users_is_verified">
<span<?php echo $users->is_verified->ViewAttributes() ?>>
<?php echo $users->is_verified->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->is_approved->Visible) { // is_approved ?>
		<td data-name="is_approved"<?php echo $users->is_approved->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_is_approved" class="form-group users_is_approved">
<div id="tp_x<?php echo $users_list->RowIndex ?>_is_approved" class="ewTemplate"><input type="radio" data-table="users" data-field="x_is_approved" data-value-separator="<?php echo $users->is_approved->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $users_list->RowIndex ?>_is_approved" id="x<?php echo $users_list->RowIndex ?>_is_approved" value="{value}"<?php echo $users->is_approved->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $users_list->RowIndex ?>_is_approved" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->is_approved->RadioButtonListHtml(FALSE, "x{$users_list->RowIndex}_is_approved") ?>
</div></div>
</span>
<input type="hidden" data-table="users" data-field="x_is_approved" name="o<?php echo $users_list->RowIndex ?>_is_approved" id="o<?php echo $users_list->RowIndex ?>_is_approved" value="<?php echo ew_HtmlEncode($users->is_approved->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_is_approved" class="form-group users_is_approved">
<div id="tp_x<?php echo $users_list->RowIndex ?>_is_approved" class="ewTemplate"><input type="radio" data-table="users" data-field="x_is_approved" data-value-separator="<?php echo $users->is_approved->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $users_list->RowIndex ?>_is_approved" id="x<?php echo $users_list->RowIndex ?>_is_approved" value="{value}"<?php echo $users->is_approved->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $users_list->RowIndex ?>_is_approved" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->is_approved->RadioButtonListHtml(FALSE, "x{$users_list->RowIndex}_is_approved") ?>
</div></div>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_is_approved" class="users_is_approved">
<span<?php echo $users->is_approved->ViewAttributes() ?>>
<?php echo $users->is_approved->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->is_blocked->Visible) { // is_blocked ?>
		<td data-name="is_blocked"<?php echo $users->is_blocked->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_is_blocked" class="form-group users_is_blocked">
<div id="tp_x<?php echo $users_list->RowIndex ?>_is_blocked" class="ewTemplate"><input type="radio" data-table="users" data-field="x_is_blocked" data-value-separator="<?php echo $users->is_blocked->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $users_list->RowIndex ?>_is_blocked" id="x<?php echo $users_list->RowIndex ?>_is_blocked" value="{value}"<?php echo $users->is_blocked->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $users_list->RowIndex ?>_is_blocked" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->is_blocked->RadioButtonListHtml(FALSE, "x{$users_list->RowIndex}_is_blocked") ?>
</div></div>
</span>
<input type="hidden" data-table="users" data-field="x_is_blocked" name="o<?php echo $users_list->RowIndex ?>_is_blocked" id="o<?php echo $users_list->RowIndex ?>_is_blocked" value="<?php echo ew_HtmlEncode($users->is_blocked->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_is_blocked" class="form-group users_is_blocked">
<div id="tp_x<?php echo $users_list->RowIndex ?>_is_blocked" class="ewTemplate"><input type="radio" data-table="users" data-field="x_is_blocked" data-value-separator="<?php echo $users->is_blocked->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $users_list->RowIndex ?>_is_blocked" id="x<?php echo $users_list->RowIndex ?>_is_blocked" value="{value}"<?php echo $users->is_blocked->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $users_list->RowIndex ?>_is_blocked" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->is_blocked->RadioButtonListHtml(FALSE, "x{$users_list->RowIndex}_is_blocked") ?>
</div></div>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_is_blocked" class="users_is_blocked">
<span<?php echo $users->is_blocked->ViewAttributes() ?>>
<?php echo $users->is_blocked->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->otp->Visible) { // otp ?>
		<td data-name="otp"<?php echo $users->otp->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_otp" class="form-group users_otp">
<input type="text" data-table="users" data-field="x_otp" name="x<?php echo $users_list->RowIndex ?>_otp" id="x<?php echo $users_list->RowIndex ?>_otp" placeholder="<?php echo ew_HtmlEncode($users->otp->getPlaceHolder()) ?>" value="<?php echo $users->otp->EditValue ?>"<?php echo $users->otp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_otp" name="o<?php echo $users_list->RowIndex ?>_otp" id="o<?php echo $users_list->RowIndex ?>_otp" value="<?php echo ew_HtmlEncode($users->otp->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_otp" class="form-group users_otp">
<input type="text" data-table="users" data-field="x_otp" name="x<?php echo $users_list->RowIndex ?>_otp" id="x<?php echo $users_list->RowIndex ?>_otp" placeholder="<?php echo ew_HtmlEncode($users->otp->getPlaceHolder()) ?>" value="<?php echo $users->otp->EditValue ?>"<?php echo $users->otp->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_otp" class="users_otp">
<span<?php echo $users->otp->ViewAttributes() ?>>
<?php echo $users->otp->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($users->slug->Visible) { // slug ?>
		<td data-name="slug"<?php echo $users->slug->CellAttributes() ?>>
<?php if ($users->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_slug" class="form-group users_slug">
<input type="text" data-table="users" data-field="x_slug" name="x<?php echo $users_list->RowIndex ?>_slug" id="x<?php echo $users_list->RowIndex ?>_slug" placeholder="<?php echo ew_HtmlEncode($users->slug->getPlaceHolder()) ?>" value="<?php echo $users->slug->EditValue ?>"<?php echo $users->slug->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_slug" name="o<?php echo $users_list->RowIndex ?>_slug" id="o<?php echo $users_list->RowIndex ?>_slug" value="<?php echo ew_HtmlEncode($users->slug->OldValue) ?>">
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_slug" class="form-group users_slug">
<input type="text" data-table="users" data-field="x_slug" name="x<?php echo $users_list->RowIndex ?>_slug" id="x<?php echo $users_list->RowIndex ?>_slug" placeholder="<?php echo ew_HtmlEncode($users->slug->getPlaceHolder()) ?>" value="<?php echo $users->slug->EditValue ?>"<?php echo $users->slug->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($users->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $users_list->RowCnt ?>_users_slug" class="users_slug">
<span<?php echo $users->slug->ViewAttributes() ?>>
<?php echo $users->slug->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$users_list->ListOptions->Render("body", "right", $users_list->RowCnt);
?>
	</tr>
<?php if ($users->RowType == EW_ROWTYPE_ADD || $users->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fuserslist.UpdateOpts(<?php echo $users_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($users->CurrentAction <> "gridadd")
		if (!$users_list->Recordset->EOF) $users_list->Recordset->MoveNext();
}
?>
<?php
	if ($users->CurrentAction == "gridadd" || $users->CurrentAction == "gridedit") {
		$users_list->RowIndex = '$rowindex$';
		$users_list->LoadRowValues();

		// Set row properties
		$users->ResetAttrs();
		$users->RowAttrs = array_merge($users->RowAttrs, array('data-rowindex'=>$users_list->RowIndex, 'id'=>'r0_users', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($users->RowAttrs["class"], "ewTemplate");
		$users->RowType = EW_ROWTYPE_ADD;

		// Render row
		$users_list->RenderRow();

		// Render list options
		$users_list->RenderListOptions();
		$users_list->StartRowCnt = 0;
?>
	<tr<?php echo $users->RowAttributes() ?>>
<?php

// Render list options (body, left)
$users_list->ListOptions->Render("body", "left", $users_list->RowIndex);
?>
	<?php if ($users->id->Visible) { // id ?>
		<td data-name="id">
<input type="hidden" data-table="users" data-field="x_id" name="o<?php echo $users_list->RowIndex ?>_id" id="o<?php echo $users_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($users->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->name->Visible) { // name ?>
		<td data-name="name">
<span id="el$rowindex$_users_name" class="form-group users_name">
<input type="text" data-table="users" data-field="x_name" name="x<?php echo $users_list->RowIndex ?>_name" id="x<?php echo $users_list->RowIndex ?>_name" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($users->name->getPlaceHolder()) ?>" value="<?php echo $users->name->EditValue ?>"<?php echo $users->name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_name" name="o<?php echo $users_list->RowIndex ?>_name" id="o<?php echo $users_list->RowIndex ?>_name" value="<?php echo ew_HtmlEncode($users->name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->_email->Visible) { // email ?>
		<td data-name="_email">
<span id="el$rowindex$_users__email" class="form-group users__email">
<input type="text" data-table="users" data-field="x__email" name="x<?php echo $users_list->RowIndex ?>__email" id="x<?php echo $users_list->RowIndex ?>__email" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($users->_email->getPlaceHolder()) ?>" value="<?php echo $users->_email->EditValue ?>"<?php echo $users->_email->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x__email" name="o<?php echo $users_list->RowIndex ?>__email" id="o<?php echo $users_list->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($users->_email->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->phone->Visible) { // phone ?>
		<td data-name="phone">
<span id="el$rowindex$_users_phone" class="form-group users_phone">
<input type="text" data-table="users" data-field="x_phone" name="x<?php echo $users_list->RowIndex ?>_phone" id="x<?php echo $users_list->RowIndex ?>_phone" placeholder="<?php echo ew_HtmlEncode($users->phone->getPlaceHolder()) ?>" value="<?php echo $users->phone->EditValue ?>"<?php echo $users->phone->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_phone" name="o<?php echo $users_list->RowIndex ?>_phone" id="o<?php echo $users_list->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($users->phone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->gender->Visible) { // gender ?>
		<td data-name="gender">
<span id="el$rowindex$_users_gender" class="form-group users_gender">
<select data-table="users" data-field="x_gender" data-value-separator="<?php echo $users->gender->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $users_list->RowIndex ?>_gender" name="x<?php echo $users_list->RowIndex ?>_gender"<?php echo $users->gender->EditAttributes() ?>>
<?php echo $users->gender->SelectOptionListHtml("x<?php echo $users_list->RowIndex ?>_gender") ?>
</select>
</span>
<input type="hidden" data-table="users" data-field="x_gender" name="o<?php echo $users_list->RowIndex ?>_gender" id="o<?php echo $users_list->RowIndex ?>_gender" value="<?php echo ew_HtmlEncode($users->gender->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->birthday->Visible) { // birthday ?>
		<td data-name="birthday">
<span id="el$rowindex$_users_birthday" class="form-group users_birthday">
<input type="text" data-table="users" data-field="x_birthday" name="x<?php echo $users_list->RowIndex ?>_birthday" id="x<?php echo $users_list->RowIndex ?>_birthday" placeholder="<?php echo ew_HtmlEncode($users->birthday->getPlaceHolder()) ?>" value="<?php echo $users->birthday->EditValue ?>"<?php echo $users->birthday->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_birthday" name="o<?php echo $users_list->RowIndex ?>_birthday" id="o<?php echo $users_list->RowIndex ?>_birthday" value="<?php echo ew_HtmlEncode($users->birthday->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->image->Visible) { // image ?>
		<td data-name="image">
<span id="el$rowindex$_users_image" class="form-group users_image">
<div id="fd_x<?php echo $users_list->RowIndex ?>_image">
<span title="<?php echo $users->image->FldTitle() ? $users->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($users->image->ReadOnly || $users->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="users" data-field="x_image" name="x<?php echo $users_list->RowIndex ?>_image" id="x<?php echo $users_list->RowIndex ?>_image"<?php echo $users->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $users_list->RowIndex ?>_image" id= "fn_x<?php echo $users_list->RowIndex ?>_image" value="<?php echo $users->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $users_list->RowIndex ?>_image" id= "fa_x<?php echo $users_list->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $users_list->RowIndex ?>_image" id= "fs_x<?php echo $users_list->RowIndex ?>_image" value="65535">
<input type="hidden" name="fx_x<?php echo $users_list->RowIndex ?>_image" id= "fx_x<?php echo $users_list->RowIndex ?>_image" value="<?php echo $users->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $users_list->RowIndex ?>_image" id= "fm_x<?php echo $users_list->RowIndex ?>_image" value="<?php echo $users->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $users_list->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="users" data-field="x_image" name="o<?php echo $users_list->RowIndex ?>_image" id="o<?php echo $users_list->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($users->image->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->country_id->Visible) { // country_id ?>
		<td data-name="country_id">
<span id="el$rowindex$_users_country_id" class="form-group users_country_id">
<select data-table="users" data-field="x_country_id" data-value-separator="<?php echo $users->country_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $users_list->RowIndex ?>_country_id" name="x<?php echo $users_list->RowIndex ?>_country_id"<?php echo $users->country_id->EditAttributes() ?>>
<?php echo $users->country_id->SelectOptionListHtml("x<?php echo $users_list->RowIndex ?>_country_id") ?>
</select>
</span>
<input type="hidden" data-table="users" data-field="x_country_id" name="o<?php echo $users_list->RowIndex ?>_country_id" id="o<?php echo $users_list->RowIndex ?>_country_id" value="<?php echo ew_HtmlEncode($users->country_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->city->Visible) { // city ?>
		<td data-name="city">
<span id="el$rowindex$_users_city" class="form-group users_city">
<input type="text" data-table="users" data-field="x_city" name="x<?php echo $users_list->RowIndex ?>_city" id="x<?php echo $users_list->RowIndex ?>_city" placeholder="<?php echo ew_HtmlEncode($users->city->getPlaceHolder()) ?>" value="<?php echo $users->city->EditValue ?>"<?php echo $users->city->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_city" name="o<?php echo $users_list->RowIndex ?>_city" id="o<?php echo $users_list->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($users->city->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id">
<span id="el$rowindex$_users_currency_id" class="form-group users_currency_id">
<select data-table="users" data-field="x_currency_id" data-value-separator="<?php echo $users->currency_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $users_list->RowIndex ?>_currency_id" name="x<?php echo $users_list->RowIndex ?>_currency_id"<?php echo $users->currency_id->EditAttributes() ?>>
<?php echo $users->currency_id->SelectOptionListHtml("x<?php echo $users_list->RowIndex ?>_currency_id") ?>
</select>
</span>
<input type="hidden" data-table="users" data-field="x_currency_id" name="o<?php echo $users_list->RowIndex ?>_currency_id" id="o<?php echo $users_list->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($users->currency_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->type->Visible) { // type ?>
		<td data-name="type">
<span id="el$rowindex$_users_type" class="form-group users_type">
<div id="tp_x<?php echo $users_list->RowIndex ?>_type" class="ewTemplate"><input type="radio" data-table="users" data-field="x_type" data-value-separator="<?php echo $users->type->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $users_list->RowIndex ?>_type" id="x<?php echo $users_list->RowIndex ?>_type" value="{value}"<?php echo $users->type->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $users_list->RowIndex ?>_type" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->type->RadioButtonListHtml(FALSE, "x{$users_list->RowIndex}_type") ?>
</div></div>
</span>
<input type="hidden" data-table="users" data-field="x_type" name="o<?php echo $users_list->RowIndex ?>_type" id="o<?php echo $users_list->RowIndex ?>_type" value="<?php echo ew_HtmlEncode($users->type->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->is_verified->Visible) { // is_verified ?>
		<td data-name="is_verified">
<span id="el$rowindex$_users_is_verified" class="form-group users_is_verified">
<div id="tp_x<?php echo $users_list->RowIndex ?>_is_verified" class="ewTemplate"><input type="radio" data-table="users" data-field="x_is_verified" data-value-separator="<?php echo $users->is_verified->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $users_list->RowIndex ?>_is_verified" id="x<?php echo $users_list->RowIndex ?>_is_verified" value="{value}"<?php echo $users->is_verified->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $users_list->RowIndex ?>_is_verified" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->is_verified->RadioButtonListHtml(FALSE, "x{$users_list->RowIndex}_is_verified") ?>
</div></div>
</span>
<input type="hidden" data-table="users" data-field="x_is_verified" name="o<?php echo $users_list->RowIndex ?>_is_verified" id="o<?php echo $users_list->RowIndex ?>_is_verified" value="<?php echo ew_HtmlEncode($users->is_verified->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->is_approved->Visible) { // is_approved ?>
		<td data-name="is_approved">
<span id="el$rowindex$_users_is_approved" class="form-group users_is_approved">
<div id="tp_x<?php echo $users_list->RowIndex ?>_is_approved" class="ewTemplate"><input type="radio" data-table="users" data-field="x_is_approved" data-value-separator="<?php echo $users->is_approved->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $users_list->RowIndex ?>_is_approved" id="x<?php echo $users_list->RowIndex ?>_is_approved" value="{value}"<?php echo $users->is_approved->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $users_list->RowIndex ?>_is_approved" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->is_approved->RadioButtonListHtml(FALSE, "x{$users_list->RowIndex}_is_approved") ?>
</div></div>
</span>
<input type="hidden" data-table="users" data-field="x_is_approved" name="o<?php echo $users_list->RowIndex ?>_is_approved" id="o<?php echo $users_list->RowIndex ?>_is_approved" value="<?php echo ew_HtmlEncode($users->is_approved->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->is_blocked->Visible) { // is_blocked ?>
		<td data-name="is_blocked">
<span id="el$rowindex$_users_is_blocked" class="form-group users_is_blocked">
<div id="tp_x<?php echo $users_list->RowIndex ?>_is_blocked" class="ewTemplate"><input type="radio" data-table="users" data-field="x_is_blocked" data-value-separator="<?php echo $users->is_blocked->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $users_list->RowIndex ?>_is_blocked" id="x<?php echo $users_list->RowIndex ?>_is_blocked" value="{value}"<?php echo $users->is_blocked->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $users_list->RowIndex ?>_is_blocked" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $users->is_blocked->RadioButtonListHtml(FALSE, "x{$users_list->RowIndex}_is_blocked") ?>
</div></div>
</span>
<input type="hidden" data-table="users" data-field="x_is_blocked" name="o<?php echo $users_list->RowIndex ?>_is_blocked" id="o<?php echo $users_list->RowIndex ?>_is_blocked" value="<?php echo ew_HtmlEncode($users->is_blocked->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->otp->Visible) { // otp ?>
		<td data-name="otp">
<span id="el$rowindex$_users_otp" class="form-group users_otp">
<input type="text" data-table="users" data-field="x_otp" name="x<?php echo $users_list->RowIndex ?>_otp" id="x<?php echo $users_list->RowIndex ?>_otp" placeholder="<?php echo ew_HtmlEncode($users->otp->getPlaceHolder()) ?>" value="<?php echo $users->otp->EditValue ?>"<?php echo $users->otp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_otp" name="o<?php echo $users_list->RowIndex ?>_otp" id="o<?php echo $users_list->RowIndex ?>_otp" value="<?php echo ew_HtmlEncode($users->otp->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($users->slug->Visible) { // slug ?>
		<td data-name="slug">
<span id="el$rowindex$_users_slug" class="form-group users_slug">
<input type="text" data-table="users" data-field="x_slug" name="x<?php echo $users_list->RowIndex ?>_slug" id="x<?php echo $users_list->RowIndex ?>_slug" placeholder="<?php echo ew_HtmlEncode($users->slug->getPlaceHolder()) ?>" value="<?php echo $users->slug->EditValue ?>"<?php echo $users->slug->EditAttributes() ?>>
</span>
<input type="hidden" data-table="users" data-field="x_slug" name="o<?php echo $users_list->RowIndex ?>_slug" id="o<?php echo $users_list->RowIndex ?>_slug" value="<?php echo ew_HtmlEncode($users->slug->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$users_list->ListOptions->Render("body", "right", $users_list->RowIndex);
?>
<script type="text/javascript">
fuserslist.UpdateOpts(<?php echo $users_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($users->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $users_list->FormKeyCountName ?>" id="<?php echo $users_list->FormKeyCountName ?>" value="<?php echo $users_list->KeyCount ?>">
<?php echo $users_list->MultiSelectKey ?>
<?php } ?>
<?php if ($users->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $users_list->FormKeyCountName ?>" id="<?php echo $users_list->FormKeyCountName ?>" value="<?php echo $users_list->KeyCount ?>">
<?php echo $users_list->MultiSelectKey ?>
<?php } ?>
<?php if ($users->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($users_list->Recordset)
	$users_list->Recordset->Close();
?>
<?php if ($users->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($users->CurrentAction <> "gridadd" && $users->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($users_list->Pager)) $users_list->Pager = new cPrevNextPager($users_list->StartRec, $users_list->DisplayRecs, $users_list->TotalRecs, $users_list->AutoHidePager) ?>
<?php if ($users_list->Pager->RecordCount > 0 && $users_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($users_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($users_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $users_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($users_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($users_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($users_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $users_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $users_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $users_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($users_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($users_list->TotalRecs == 0 && $users->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($users_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($users->Export == "") { ?>
<script type="text/javascript">
fuserslistsrch.FilterList = <?php echo $users_list->GetFilterList() ?>;
fuserslistsrch.Init();
fuserslist.Init();
</script>
<?php } ?>
<?php
$users_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($users->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$users_list->Page_Terminate();
?>
