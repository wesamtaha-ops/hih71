<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "teachers_packagesinfo.php" ?>
<?php include_once "teachersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$teachers_packages_list = NULL; // Initialize page object first

class cteachers_packages_list extends cteachers_packages {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'teachers_packages';

	// Page object name
	var $PageObjName = 'teachers_packages_list';

	// Grid form hidden field names
	var $FormName = 'fteachers_packageslist';
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

		// Table object (teachers_packages)
		if (!isset($GLOBALS["teachers_packages"]) || get_class($GLOBALS["teachers_packages"]) == "cteachers_packages") {
			$GLOBALS["teachers_packages"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["teachers_packages"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "teachers_packagesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "teachers_packagesdelete.php";
		$this->MultiUpdateUrl = "teachers_packagesupdate.php";

		// Table object (teachers)
		if (!isset($GLOBALS['teachers'])) $GLOBALS['teachers'] = new cteachers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'teachers_packages', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fteachers_packageslistsrch";

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
		$this->title_en->SetVisibility();
		$this->title_ar->SetVisibility();
		$this->description_en->SetVisibility();
		$this->description_ar->SetVisibility();
		$this->image->SetVisibility();
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
		global $EW_EXPORT, $teachers_packages;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($teachers_packages);
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
		if ($objForm->HasValue("x_title_en") && $objForm->HasValue("o_title_en") && $this->title_en->CurrentValue <> $this->title_en->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_title_ar") && $objForm->HasValue("o_title_ar") && $this->title_ar->CurrentValue <> $this->title_ar->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_description_en") && $objForm->HasValue("o_description_en") && $this->description_en->CurrentValue <> $this->description_en->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_description_ar") && $objForm->HasValue("o_description_ar") && $this->description_ar->CurrentValue <> $this->description_ar->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_image") && $objForm->HasValue("o_image") && $this->image->CurrentValue <> $this->image->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_fees") && $objForm->HasValue("o_fees") && $this->fees->CurrentValue <> $this->fees->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_currency_id") && $objForm->HasValue("o_currency_id") && $this->currency_id->CurrentValue <> $this->currency_id->OldValue)
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
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJson(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->teacher_id->AdvancedSearch->ToJson(), ","); // Field teacher_id
		$sFilterList = ew_Concat($sFilterList, $this->title_en->AdvancedSearch->ToJson(), ","); // Field title_en
		$sFilterList = ew_Concat($sFilterList, $this->title_ar->AdvancedSearch->ToJson(), ","); // Field title_ar
		$sFilterList = ew_Concat($sFilterList, $this->description_en->AdvancedSearch->ToJson(), ","); // Field description_en
		$sFilterList = ew_Concat($sFilterList, $this->description_ar->AdvancedSearch->ToJson(), ","); // Field description_ar
		$sFilterList = ew_Concat($sFilterList, $this->image->AdvancedSearch->ToJson(), ","); // Field image
		$sFilterList = ew_Concat($sFilterList, $this->fees->AdvancedSearch->ToJson(), ","); // Field fees
		$sFilterList = ew_Concat($sFilterList, $this->currency_id->AdvancedSearch->ToJson(), ","); // Field currency_id
		$sFilterList = ew_Concat($sFilterList, $this->created_at->AdvancedSearch->ToJson(), ","); // Field created_at
		$sFilterList = ew_Concat($sFilterList, $this->updated_at->AdvancedSearch->ToJson(), ","); // Field updated_at
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fteachers_packageslistsrch", $filters);

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

		// Field title_en
		$this->title_en->AdvancedSearch->SearchValue = @$filter["x_title_en"];
		$this->title_en->AdvancedSearch->SearchOperator = @$filter["z_title_en"];
		$this->title_en->AdvancedSearch->SearchCondition = @$filter["v_title_en"];
		$this->title_en->AdvancedSearch->SearchValue2 = @$filter["y_title_en"];
		$this->title_en->AdvancedSearch->SearchOperator2 = @$filter["w_title_en"];
		$this->title_en->AdvancedSearch->Save();

		// Field title_ar
		$this->title_ar->AdvancedSearch->SearchValue = @$filter["x_title_ar"];
		$this->title_ar->AdvancedSearch->SearchOperator = @$filter["z_title_ar"];
		$this->title_ar->AdvancedSearch->SearchCondition = @$filter["v_title_ar"];
		$this->title_ar->AdvancedSearch->SearchValue2 = @$filter["y_title_ar"];
		$this->title_ar->AdvancedSearch->SearchOperator2 = @$filter["w_title_ar"];
		$this->title_ar->AdvancedSearch->Save();

		// Field description_en
		$this->description_en->AdvancedSearch->SearchValue = @$filter["x_description_en"];
		$this->description_en->AdvancedSearch->SearchOperator = @$filter["z_description_en"];
		$this->description_en->AdvancedSearch->SearchCondition = @$filter["v_description_en"];
		$this->description_en->AdvancedSearch->SearchValue2 = @$filter["y_description_en"];
		$this->description_en->AdvancedSearch->SearchOperator2 = @$filter["w_description_en"];
		$this->description_en->AdvancedSearch->Save();

		// Field description_ar
		$this->description_ar->AdvancedSearch->SearchValue = @$filter["x_description_ar"];
		$this->description_ar->AdvancedSearch->SearchOperator = @$filter["z_description_ar"];
		$this->description_ar->AdvancedSearch->SearchCondition = @$filter["v_description_ar"];
		$this->description_ar->AdvancedSearch->SearchValue2 = @$filter["y_description_ar"];
		$this->description_ar->AdvancedSearch->SearchOperator2 = @$filter["w_description_ar"];
		$this->description_ar->AdvancedSearch->Save();

		// Field image
		$this->image->AdvancedSearch->SearchValue = @$filter["x_image"];
		$this->image->AdvancedSearch->SearchOperator = @$filter["z_image"];
		$this->image->AdvancedSearch->SearchCondition = @$filter["v_image"];
		$this->image->AdvancedSearch->SearchValue2 = @$filter["y_image"];
		$this->image->AdvancedSearch->SearchOperator2 = @$filter["w_image"];
		$this->image->AdvancedSearch->Save();

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
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->title_en, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->title_ar, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->description_en, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->description_ar, $arKeywords, $type);
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
			$this->UpdateSort($this->title_en); // title_en
			$this->UpdateSort($this->title_ar); // title_ar
			$this->UpdateSort($this->description_en); // description_en
			$this->UpdateSort($this->description_ar); // description_ar
			$this->UpdateSort($this->image); // image
			$this->UpdateSort($this->fees); // fees
			$this->UpdateSort($this->currency_id); // currency_id
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
				$this->teacher_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id->setSort("");
				$this->teacher_id->setSort("");
				$this->title_en->setSort("");
				$this->title_ar->setSort("");
				$this->description_en->setSort("");
				$this->description_ar->setSort("");
				$this->image->setSort("");
				$this->fees->setSort("");
				$this->currency_id->setSort("");
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fteachers_packageslist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fteachers_packageslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fteachers_packageslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fteachers_packageslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fteachers_packageslistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->title_en->CurrentValue = NULL;
		$this->title_en->OldValue = $this->title_en->CurrentValue;
		$this->title_ar->CurrentValue = NULL;
		$this->title_ar->OldValue = $this->title_ar->CurrentValue;
		$this->description_en->CurrentValue = NULL;
		$this->description_en->OldValue = $this->description_en->CurrentValue;
		$this->description_ar->CurrentValue = NULL;
		$this->description_ar->OldValue = $this->description_ar->CurrentValue;
		$this->image->CurrentValue = NULL;
		$this->image->OldValue = $this->image->CurrentValue;
		$this->fees->CurrentValue = NULL;
		$this->fees->OldValue = $this->fees->CurrentValue;
		$this->currency_id->CurrentValue = NULL;
		$this->currency_id->OldValue = $this->currency_id->CurrentValue;
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
		if (!$this->title_en->FldIsDetailKey) {
			$this->title_en->setFormValue($objForm->GetValue("x_title_en"));
		}
		$this->title_en->setOldValue($objForm->GetValue("o_title_en"));
		if (!$this->title_ar->FldIsDetailKey) {
			$this->title_ar->setFormValue($objForm->GetValue("x_title_ar"));
		}
		$this->title_ar->setOldValue($objForm->GetValue("o_title_ar"));
		if (!$this->description_en->FldIsDetailKey) {
			$this->description_en->setFormValue($objForm->GetValue("x_description_en"));
		}
		$this->description_en->setOldValue($objForm->GetValue("o_description_en"));
		if (!$this->description_ar->FldIsDetailKey) {
			$this->description_ar->setFormValue($objForm->GetValue("x_description_ar"));
		}
		$this->description_ar->setOldValue($objForm->GetValue("o_description_ar"));
		if (!$this->image->FldIsDetailKey) {
			$this->image->setFormValue($objForm->GetValue("x_image"));
		}
		$this->image->setOldValue($objForm->GetValue("o_image"));
		if (!$this->fees->FldIsDetailKey) {
			$this->fees->setFormValue($objForm->GetValue("x_fees"));
		}
		$this->fees->setOldValue($objForm->GetValue("o_fees"));
		if (!$this->currency_id->FldIsDetailKey) {
			$this->currency_id->setFormValue($objForm->GetValue("x_currency_id"));
		}
		$this->currency_id->setOldValue($objForm->GetValue("o_currency_id"));
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->teacher_id->CurrentValue = $this->teacher_id->FormValue;
		$this->title_en->CurrentValue = $this->title_en->FormValue;
		$this->title_ar->CurrentValue = $this->title_ar->FormValue;
		$this->description_en->CurrentValue = $this->description_en->FormValue;
		$this->description_ar->CurrentValue = $this->description_ar->FormValue;
		$this->image->CurrentValue = $this->image->FormValue;
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
		$this->teacher_id->setDbValue($row['teacher_id']);
		$this->title_en->setDbValue($row['title_en']);
		$this->title_ar->setDbValue($row['title_ar']);
		$this->description_en->setDbValue($row['description_en']);
		$this->description_ar->setDbValue($row['description_ar']);
		$this->image->setDbValue($row['image']);
		$this->fees->setDbValue($row['fees']);
		$this->currency_id->setDbValue($row['currency_id']);
		$this->created_at->setDbValue($row['created_at']);
		$this->updated_at->setDbValue($row['updated_at']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['id'] = $this->id->CurrentValue;
		$row['teacher_id'] = $this->teacher_id->CurrentValue;
		$row['title_en'] = $this->title_en->CurrentValue;
		$row['title_ar'] = $this->title_ar->CurrentValue;
		$row['description_en'] = $this->description_en->CurrentValue;
		$row['description_ar'] = $this->description_ar->CurrentValue;
		$row['image'] = $this->image->CurrentValue;
		$row['fees'] = $this->fees->CurrentValue;
		$row['currency_id'] = $this->currency_id->CurrentValue;
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
		$this->teacher_id->DbValue = $row['teacher_id'];
		$this->title_en->DbValue = $row['title_en'];
		$this->title_ar->DbValue = $row['title_ar'];
		$this->description_en->DbValue = $row['description_en'];
		$this->description_ar->DbValue = $row['description_ar'];
		$this->image->DbValue = $row['image'];
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
		// title_en
		// title_ar
		// description_en
		// description_ar
		// image
		// fees
		// currency_id
		// created_at
		// updated_at

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// teacher_id
		$this->teacher_id->ViewValue = $this->teacher_id->CurrentValue;
		$this->teacher_id->ViewCustomAttributes = "";

		// title_en
		$this->title_en->ViewValue = $this->title_en->CurrentValue;
		$this->title_en->ViewCustomAttributes = "";

		// title_ar
		$this->title_ar->ViewValue = $this->title_ar->CurrentValue;
		$this->title_ar->ViewCustomAttributes = "";

		// description_en
		$this->description_en->ViewValue = $this->description_en->CurrentValue;
		$this->description_en->ViewCustomAttributes = "";

		// description_ar
		$this->description_ar->ViewValue = $this->description_ar->CurrentValue;
		$this->description_ar->ViewCustomAttributes = "";

		// image
		$this->image->ViewValue = $this->image->CurrentValue;
		$this->image->ViewCustomAttributes = "";

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

			// teacher_id
			$this->teacher_id->LinkCustomAttributes = "";
			$this->teacher_id->HrefValue = "";
			$this->teacher_id->TooltipValue = "";

			// title_en
			$this->title_en->LinkCustomAttributes = "";
			$this->title_en->HrefValue = "";
			$this->title_en->TooltipValue = "";

			// title_ar
			$this->title_ar->LinkCustomAttributes = "";
			$this->title_ar->HrefValue = "";
			$this->title_ar->TooltipValue = "";

			// description_en
			$this->description_en->LinkCustomAttributes = "";
			$this->description_en->HrefValue = "";
			$this->description_en->TooltipValue = "";

			// description_ar
			$this->description_ar->LinkCustomAttributes = "";
			$this->description_ar->HrefValue = "";
			$this->description_ar->TooltipValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";
			$this->image->TooltipValue = "";

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

			// title_en
			$this->title_en->EditAttrs["class"] = "form-control";
			$this->title_en->EditCustomAttributes = "";
			$this->title_en->EditValue = ew_HtmlEncode($this->title_en->CurrentValue);
			$this->title_en->PlaceHolder = ew_RemoveHtml($this->title_en->FldCaption());

			// title_ar
			$this->title_ar->EditAttrs["class"] = "form-control";
			$this->title_ar->EditCustomAttributes = "";
			$this->title_ar->EditValue = ew_HtmlEncode($this->title_ar->CurrentValue);
			$this->title_ar->PlaceHolder = ew_RemoveHtml($this->title_ar->FldCaption());

			// description_en
			$this->description_en->EditAttrs["class"] = "form-control";
			$this->description_en->EditCustomAttributes = "";
			$this->description_en->EditValue = ew_HtmlEncode($this->description_en->CurrentValue);
			$this->description_en->PlaceHolder = ew_RemoveHtml($this->description_en->FldCaption());

			// description_ar
			$this->description_ar->EditAttrs["class"] = "form-control";
			$this->description_ar->EditCustomAttributes = "";
			$this->description_ar->EditValue = ew_HtmlEncode($this->description_ar->CurrentValue);
			$this->description_ar->PlaceHolder = ew_RemoveHtml($this->description_ar->FldCaption());

			// image
			$this->image->EditAttrs["class"] = "form-control";
			$this->image->EditCustomAttributes = "";
			$this->image->EditValue = ew_HtmlEncode($this->image->CurrentValue);
			$this->image->PlaceHolder = ew_RemoveHtml($this->image->FldCaption());

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

			// Add refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// teacher_id
			$this->teacher_id->LinkCustomAttributes = "";
			$this->teacher_id->HrefValue = "";

			// title_en
			$this->title_en->LinkCustomAttributes = "";
			$this->title_en->HrefValue = "";

			// title_ar
			$this->title_ar->LinkCustomAttributes = "";
			$this->title_ar->HrefValue = "";

			// description_en
			$this->description_en->LinkCustomAttributes = "";
			$this->description_en->HrefValue = "";

			// description_ar
			$this->description_ar->LinkCustomAttributes = "";
			$this->description_ar->HrefValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";

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

			// title_en
			$this->title_en->EditAttrs["class"] = "form-control";
			$this->title_en->EditCustomAttributes = "";
			$this->title_en->EditValue = ew_HtmlEncode($this->title_en->CurrentValue);
			$this->title_en->PlaceHolder = ew_RemoveHtml($this->title_en->FldCaption());

			// title_ar
			$this->title_ar->EditAttrs["class"] = "form-control";
			$this->title_ar->EditCustomAttributes = "";
			$this->title_ar->EditValue = ew_HtmlEncode($this->title_ar->CurrentValue);
			$this->title_ar->PlaceHolder = ew_RemoveHtml($this->title_ar->FldCaption());

			// description_en
			$this->description_en->EditAttrs["class"] = "form-control";
			$this->description_en->EditCustomAttributes = "";
			$this->description_en->EditValue = ew_HtmlEncode($this->description_en->CurrentValue);
			$this->description_en->PlaceHolder = ew_RemoveHtml($this->description_en->FldCaption());

			// description_ar
			$this->description_ar->EditAttrs["class"] = "form-control";
			$this->description_ar->EditCustomAttributes = "";
			$this->description_ar->EditValue = ew_HtmlEncode($this->description_ar->CurrentValue);
			$this->description_ar->PlaceHolder = ew_RemoveHtml($this->description_ar->FldCaption());

			// image
			$this->image->EditAttrs["class"] = "form-control";
			$this->image->EditCustomAttributes = "";
			$this->image->EditValue = ew_HtmlEncode($this->image->CurrentValue);
			$this->image->PlaceHolder = ew_RemoveHtml($this->image->FldCaption());

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

			// teacher_id
			$this->teacher_id->LinkCustomAttributes = "";
			$this->teacher_id->HrefValue = "";

			// title_en
			$this->title_en->LinkCustomAttributes = "";
			$this->title_en->HrefValue = "";

			// title_ar
			$this->title_ar->LinkCustomAttributes = "";
			$this->title_ar->HrefValue = "";

			// description_en
			$this->description_en->LinkCustomAttributes = "";
			$this->description_en->HrefValue = "";

			// description_ar
			$this->description_ar->LinkCustomAttributes = "";
			$this->description_ar->HrefValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";

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
		if (!$this->teacher_id->FldIsDetailKey && !is_null($this->teacher_id->FormValue) && $this->teacher_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->teacher_id->FldCaption(), $this->teacher_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->teacher_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->teacher_id->FldErrMsg());
		}
		if (!$this->title_en->FldIsDetailKey && !is_null($this->title_en->FormValue) && $this->title_en->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->title_en->FldCaption(), $this->title_en->ReqErrMsg));
		}
		if (!$this->title_ar->FldIsDetailKey && !is_null($this->title_ar->FormValue) && $this->title_ar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->title_ar->FldCaption(), $this->title_ar->ReqErrMsg));
		}
		if (!$this->description_en->FldIsDetailKey && !is_null($this->description_en->FormValue) && $this->description_en->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->description_en->FldCaption(), $this->description_en->ReqErrMsg));
		}
		if (!$this->description_ar->FldIsDetailKey && !is_null($this->description_ar->FormValue) && $this->description_ar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->description_ar->FldCaption(), $this->description_ar->ReqErrMsg));
		}
		if (!$this->image->FldIsDetailKey && !is_null($this->image->FormValue) && $this->image->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->image->FldCaption(), $this->image->ReqErrMsg));
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

			// title_en
			$this->title_en->SetDbValueDef($rsnew, $this->title_en->CurrentValue, "", $this->title_en->ReadOnly);

			// title_ar
			$this->title_ar->SetDbValueDef($rsnew, $this->title_ar->CurrentValue, "", $this->title_ar->ReadOnly);

			// description_en
			$this->description_en->SetDbValueDef($rsnew, $this->description_en->CurrentValue, "", $this->description_en->ReadOnly);

			// description_ar
			$this->description_ar->SetDbValueDef($rsnew, $this->description_ar->CurrentValue, "", $this->description_ar->ReadOnly);

			// image
			$this->image->SetDbValueDef($rsnew, $this->image->CurrentValue, "", $this->image->ReadOnly);

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

		// title_en
		$this->title_en->SetDbValueDef($rsnew, $this->title_en->CurrentValue, "", FALSE);

		// title_ar
		$this->title_ar->SetDbValueDef($rsnew, $this->title_ar->CurrentValue, "", FALSE);

		// description_en
		$this->description_en->SetDbValueDef($rsnew, $this->description_en->CurrentValue, "", FALSE);

		// description_ar
		$this->description_ar->SetDbValueDef($rsnew, $this->description_ar->CurrentValue, "", FALSE);

		// image
		$this->image->SetDbValueDef($rsnew, $this->image->CurrentValue, "", FALSE);

		// fees
		$this->fees->SetDbValueDef($rsnew, $this->fees->CurrentValue, 0, FALSE);

		// currency_id
		$this->currency_id->SetDbValueDef($rsnew, $this->currency_id->CurrentValue, 0, FALSE);

		// created_at
		$this->created_at->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->created_at->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// updated_at
		$this->updated_at->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->updated_at->CurrentValue, 0), NULL, FALSE);

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
		$item->Body = "<button id=\"emf_teachers_packages\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_teachers_packages',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fteachers_packageslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($teachers_packages_list)) $teachers_packages_list = new cteachers_packages_list();

// Page init
$teachers_packages_list->Page_Init();

// Page main
$teachers_packages_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_packages_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($teachers_packages->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fteachers_packageslist = new ew_Form("fteachers_packageslist", "list");
fteachers_packageslist.FormKeyCountName = '<?php echo $teachers_packages_list->FormKeyCountName ?>';

// Validate form
fteachers_packageslist.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->teacher_id->FldCaption(), $teachers_packages->teacher_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_teacher_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_packages->teacher_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_title_en");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->title_en->FldCaption(), $teachers_packages->title_en->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_title_ar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->title_ar->FldCaption(), $teachers_packages->title_ar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_description_en");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->description_en->FldCaption(), $teachers_packages->description_en->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_description_ar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->description_ar->FldCaption(), $teachers_packages->description_ar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_image");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->image->FldCaption(), $teachers_packages->image->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fees");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->fees->FldCaption(), $teachers_packages->fees->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fees");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_packages->fees->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->currency_id->FldCaption(), $teachers_packages->currency_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_currency_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_packages->currency_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $teachers_packages->created_at->FldCaption(), $teachers_packages->created_at->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_packages->created_at->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_updated_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($teachers_packages->updated_at->FldErrMsg()) ?>");

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
fteachers_packageslist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "teacher_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "title_en", false)) return false;
	if (ew_ValueChanged(fobj, infix, "title_ar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "description_en", false)) return false;
	if (ew_ValueChanged(fobj, infix, "description_ar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "image", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fees", false)) return false;
	if (ew_ValueChanged(fobj, infix, "currency_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "created_at", false)) return false;
	if (ew_ValueChanged(fobj, infix, "updated_at", false)) return false;
	return true;
}

// Form_CustomValidate event
fteachers_packageslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachers_packageslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fteachers_packageslistsrch = new ew_Form("fteachers_packageslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($teachers_packages->Export == "") { ?>
<div class="ewToolbar">
<?php if ($teachers_packages_list->TotalRecs > 0 && $teachers_packages_list->ExportOptions->Visible()) { ?>
<?php $teachers_packages_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($teachers_packages_list->SearchOptions->Visible()) { ?>
<?php $teachers_packages_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($teachers_packages_list->FilterOptions->Visible()) { ?>
<?php $teachers_packages_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($teachers_packages->Export == "") || (EW_EXPORT_MASTER_RECORD && $teachers_packages->Export == "print")) { ?>
<?php
if ($teachers_packages_list->DbMasterFilter <> "" && $teachers_packages->getCurrentMasterTable() == "teachers") {
	if ($teachers_packages_list->MasterRecordExists) {
?>
<?php include_once "teachersmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($teachers_packages->CurrentAction == "gridadd") {
	$teachers_packages->CurrentFilter = "0=1";
	$teachers_packages_list->StartRec = 1;
	$teachers_packages_list->DisplayRecs = $teachers_packages->GridAddRowCount;
	$teachers_packages_list->TotalRecs = $teachers_packages_list->DisplayRecs;
	$teachers_packages_list->StopRec = $teachers_packages_list->DisplayRecs;
} else {
	$bSelectLimit = $teachers_packages_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($teachers_packages_list->TotalRecs <= 0)
			$teachers_packages_list->TotalRecs = $teachers_packages->ListRecordCount();
	} else {
		if (!$teachers_packages_list->Recordset && ($teachers_packages_list->Recordset = $teachers_packages_list->LoadRecordset()))
			$teachers_packages_list->TotalRecs = $teachers_packages_list->Recordset->RecordCount();
	}
	$teachers_packages_list->StartRec = 1;
	if ($teachers_packages_list->DisplayRecs <= 0 || ($teachers_packages->Export <> "" && $teachers_packages->ExportAll)) // Display all records
		$teachers_packages_list->DisplayRecs = $teachers_packages_list->TotalRecs;
	if (!($teachers_packages->Export <> "" && $teachers_packages->ExportAll))
		$teachers_packages_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$teachers_packages_list->Recordset = $teachers_packages_list->LoadRecordset($teachers_packages_list->StartRec-1, $teachers_packages_list->DisplayRecs);

	// Set no record found message
	if ($teachers_packages->CurrentAction == "" && $teachers_packages_list->TotalRecs == 0) {
		if ($teachers_packages_list->SearchWhere == "0=101")
			$teachers_packages_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$teachers_packages_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$teachers_packages_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($teachers_packages->Export == "" && $teachers_packages->CurrentAction == "") { ?>
<form name="fteachers_packageslistsrch" id="fteachers_packageslistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($teachers_packages_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fteachers_packageslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="teachers_packages">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($teachers_packages_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($teachers_packages_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $teachers_packages_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($teachers_packages_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($teachers_packages_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($teachers_packages_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($teachers_packages_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $teachers_packages_list->ShowPageHeader(); ?>
<?php
$teachers_packages_list->ShowMessage();
?>
<?php if ($teachers_packages_list->TotalRecs > 0 || $teachers_packages->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($teachers_packages_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> teachers_packages">
<?php if ($teachers_packages->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($teachers_packages->CurrentAction <> "gridadd" && $teachers_packages->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($teachers_packages_list->Pager)) $teachers_packages_list->Pager = new cPrevNextPager($teachers_packages_list->StartRec, $teachers_packages_list->DisplayRecs, $teachers_packages_list->TotalRecs, $teachers_packages_list->AutoHidePager) ?>
<?php if ($teachers_packages_list->Pager->RecordCount > 0 && $teachers_packages_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($teachers_packages_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $teachers_packages_list->PageUrl() ?>start=<?php echo $teachers_packages_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($teachers_packages_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $teachers_packages_list->PageUrl() ?>start=<?php echo $teachers_packages_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $teachers_packages_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($teachers_packages_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $teachers_packages_list->PageUrl() ?>start=<?php echo $teachers_packages_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($teachers_packages_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $teachers_packages_list->PageUrl() ?>start=<?php echo $teachers_packages_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $teachers_packages_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($teachers_packages_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $teachers_packages_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $teachers_packages_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $teachers_packages_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_packages_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fteachers_packageslist" id="fteachers_packageslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($teachers_packages_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $teachers_packages_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="teachers_packages">
<?php if ($teachers_packages->getCurrentMasterTable() == "teachers" && $teachers_packages->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="teachers">
<input type="hidden" name="fk_id" value="<?php echo $teachers_packages->teacher_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_teachers_packages" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($teachers_packages_list->TotalRecs > 0 || $teachers_packages->CurrentAction == "gridedit") { ?>
<table id="tbl_teachers_packageslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$teachers_packages_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$teachers_packages_list->RenderListOptions();

// Render list options (header, left)
$teachers_packages_list->ListOptions->Render("header", "left");
?>
<?php if ($teachers_packages->id->Visible) { // id ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->id) == "") { ?>
		<th data-name="id" class="<?php echo $teachers_packages->id->HeaderCellClass() ?>"><div id="elh_teachers_packages_id" class="teachers_packages_id"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id" class="<?php echo $teachers_packages->id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_packages->SortUrl($teachers_packages->id) ?>',1);"><div id="elh_teachers_packages_id" class="teachers_packages_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->teacher_id->Visible) { // teacher_id ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->teacher_id) == "") { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_packages->teacher_id->HeaderCellClass() ?>"><div id="elh_teachers_packages_teacher_id" class="teachers_packages_teacher_id"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->teacher_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="teacher_id" class="<?php echo $teachers_packages->teacher_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_packages->SortUrl($teachers_packages->teacher_id) ?>',1);"><div id="elh_teachers_packages_teacher_id" class="teachers_packages_teacher_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->teacher_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->teacher_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->teacher_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->title_en->Visible) { // title_en ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->title_en) == "") { ?>
		<th data-name="title_en" class="<?php echo $teachers_packages->title_en->HeaderCellClass() ?>"><div id="elh_teachers_packages_title_en" class="teachers_packages_title_en"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->title_en->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title_en" class="<?php echo $teachers_packages->title_en->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_packages->SortUrl($teachers_packages->title_en) ?>',1);"><div id="elh_teachers_packages_title_en" class="teachers_packages_title_en">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->title_en->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->title_en->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->title_en->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->title_ar->Visible) { // title_ar ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->title_ar) == "") { ?>
		<th data-name="title_ar" class="<?php echo $teachers_packages->title_ar->HeaderCellClass() ?>"><div id="elh_teachers_packages_title_ar" class="teachers_packages_title_ar"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->title_ar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title_ar" class="<?php echo $teachers_packages->title_ar->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_packages->SortUrl($teachers_packages->title_ar) ?>',1);"><div id="elh_teachers_packages_title_ar" class="teachers_packages_title_ar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->title_ar->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->title_ar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->title_ar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->description_en->Visible) { // description_en ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->description_en) == "") { ?>
		<th data-name="description_en" class="<?php echo $teachers_packages->description_en->HeaderCellClass() ?>"><div id="elh_teachers_packages_description_en" class="teachers_packages_description_en"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->description_en->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description_en" class="<?php echo $teachers_packages->description_en->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_packages->SortUrl($teachers_packages->description_en) ?>',1);"><div id="elh_teachers_packages_description_en" class="teachers_packages_description_en">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->description_en->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->description_en->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->description_en->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->description_ar->Visible) { // description_ar ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->description_ar) == "") { ?>
		<th data-name="description_ar" class="<?php echo $teachers_packages->description_ar->HeaderCellClass() ?>"><div id="elh_teachers_packages_description_ar" class="teachers_packages_description_ar"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->description_ar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description_ar" class="<?php echo $teachers_packages->description_ar->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_packages->SortUrl($teachers_packages->description_ar) ?>',1);"><div id="elh_teachers_packages_description_ar" class="teachers_packages_description_ar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->description_ar->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->description_ar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->description_ar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->image->Visible) { // image ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->image) == "") { ?>
		<th data-name="image" class="<?php echo $teachers_packages->image->HeaderCellClass() ?>"><div id="elh_teachers_packages_image" class="teachers_packages_image"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="image" class="<?php echo $teachers_packages->image->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_packages->SortUrl($teachers_packages->image) ?>',1);"><div id="elh_teachers_packages_image" class="teachers_packages_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->image->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->fees->Visible) { // fees ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->fees) == "") { ?>
		<th data-name="fees" class="<?php echo $teachers_packages->fees->HeaderCellClass() ?>"><div id="elh_teachers_packages_fees" class="teachers_packages_fees"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->fees->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fees" class="<?php echo $teachers_packages->fees->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_packages->SortUrl($teachers_packages->fees) ?>',1);"><div id="elh_teachers_packages_fees" class="teachers_packages_fees">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->fees->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->fees->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->fees->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->currency_id->Visible) { // currency_id ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->currency_id) == "") { ?>
		<th data-name="currency_id" class="<?php echo $teachers_packages->currency_id->HeaderCellClass() ?>"><div id="elh_teachers_packages_currency_id" class="teachers_packages_currency_id"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->currency_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency_id" class="<?php echo $teachers_packages->currency_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_packages->SortUrl($teachers_packages->currency_id) ?>',1);"><div id="elh_teachers_packages_currency_id" class="teachers_packages_currency_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->currency_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->currency_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->currency_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->created_at->Visible) { // created_at ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->created_at) == "") { ?>
		<th data-name="created_at" class="<?php echo $teachers_packages->created_at->HeaderCellClass() ?>"><div id="elh_teachers_packages_created_at" class="teachers_packages_created_at"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->created_at->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="created_at" class="<?php echo $teachers_packages->created_at->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_packages->SortUrl($teachers_packages->created_at) ?>',1);"><div id="elh_teachers_packages_created_at" class="teachers_packages_created_at">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->created_at->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->created_at->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->created_at->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($teachers_packages->updated_at->Visible) { // updated_at ?>
	<?php if ($teachers_packages->SortUrl($teachers_packages->updated_at) == "") { ?>
		<th data-name="updated_at" class="<?php echo $teachers_packages->updated_at->HeaderCellClass() ?>"><div id="elh_teachers_packages_updated_at" class="teachers_packages_updated_at"><div class="ewTableHeaderCaption"><?php echo $teachers_packages->updated_at->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="updated_at" class="<?php echo $teachers_packages->updated_at->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $teachers_packages->SortUrl($teachers_packages->updated_at) ?>',1);"><div id="elh_teachers_packages_updated_at" class="teachers_packages_updated_at">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $teachers_packages->updated_at->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($teachers_packages->updated_at->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($teachers_packages->updated_at->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$teachers_packages_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($teachers_packages->ExportAll && $teachers_packages->Export <> "") {
	$teachers_packages_list->StopRec = $teachers_packages_list->TotalRecs;
} else {

	// Set the last record to display
	if ($teachers_packages_list->TotalRecs > $teachers_packages_list->StartRec + $teachers_packages_list->DisplayRecs - 1)
		$teachers_packages_list->StopRec = $teachers_packages_list->StartRec + $teachers_packages_list->DisplayRecs - 1;
	else
		$teachers_packages_list->StopRec = $teachers_packages_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($teachers_packages_list->FormKeyCountName) && ($teachers_packages->CurrentAction == "gridadd" || $teachers_packages->CurrentAction == "gridedit" || $teachers_packages->CurrentAction == "F")) {
		$teachers_packages_list->KeyCount = $objForm->GetValue($teachers_packages_list->FormKeyCountName);
		$teachers_packages_list->StopRec = $teachers_packages_list->StartRec + $teachers_packages_list->KeyCount - 1;
	}
}
$teachers_packages_list->RecCnt = $teachers_packages_list->StartRec - 1;
if ($teachers_packages_list->Recordset && !$teachers_packages_list->Recordset->EOF) {
	$teachers_packages_list->Recordset->MoveFirst();
	$bSelectLimit = $teachers_packages_list->UseSelectLimit;
	if (!$bSelectLimit && $teachers_packages_list->StartRec > 1)
		$teachers_packages_list->Recordset->Move($teachers_packages_list->StartRec - 1);
} elseif (!$teachers_packages->AllowAddDeleteRow && $teachers_packages_list->StopRec == 0) {
	$teachers_packages_list->StopRec = $teachers_packages->GridAddRowCount;
}

// Initialize aggregate
$teachers_packages->RowType = EW_ROWTYPE_AGGREGATEINIT;
$teachers_packages->ResetAttrs();
$teachers_packages_list->RenderRow();
if ($teachers_packages->CurrentAction == "gridadd")
	$teachers_packages_list->RowIndex = 0;
if ($teachers_packages->CurrentAction == "gridedit")
	$teachers_packages_list->RowIndex = 0;
while ($teachers_packages_list->RecCnt < $teachers_packages_list->StopRec) {
	$teachers_packages_list->RecCnt++;
	if (intval($teachers_packages_list->RecCnt) >= intval($teachers_packages_list->StartRec)) {
		$teachers_packages_list->RowCnt++;
		if ($teachers_packages->CurrentAction == "gridadd" || $teachers_packages->CurrentAction == "gridedit" || $teachers_packages->CurrentAction == "F") {
			$teachers_packages_list->RowIndex++;
			$objForm->Index = $teachers_packages_list->RowIndex;
			if ($objForm->HasValue($teachers_packages_list->FormActionName))
				$teachers_packages_list->RowAction = strval($objForm->GetValue($teachers_packages_list->FormActionName));
			elseif ($teachers_packages->CurrentAction == "gridadd")
				$teachers_packages_list->RowAction = "insert";
			else
				$teachers_packages_list->RowAction = "";
		}

		// Set up key count
		$teachers_packages_list->KeyCount = $teachers_packages_list->RowIndex;

		// Init row class and style
		$teachers_packages->ResetAttrs();
		$teachers_packages->CssClass = "";
		if ($teachers_packages->CurrentAction == "gridadd") {
			$teachers_packages_list->LoadRowValues(); // Load default values
		} else {
			$teachers_packages_list->LoadRowValues($teachers_packages_list->Recordset); // Load row values
		}
		$teachers_packages->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($teachers_packages->CurrentAction == "gridadd") // Grid add
			$teachers_packages->RowType = EW_ROWTYPE_ADD; // Render add
		if ($teachers_packages->CurrentAction == "gridadd" && $teachers_packages->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$teachers_packages_list->RestoreCurrentRowFormValues($teachers_packages_list->RowIndex); // Restore form values
		if ($teachers_packages->CurrentAction == "gridedit") { // Grid edit
			if ($teachers_packages->EventCancelled) {
				$teachers_packages_list->RestoreCurrentRowFormValues($teachers_packages_list->RowIndex); // Restore form values
			}
			if ($teachers_packages_list->RowAction == "insert")
				$teachers_packages->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$teachers_packages->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($teachers_packages->CurrentAction == "gridedit" && ($teachers_packages->RowType == EW_ROWTYPE_EDIT || $teachers_packages->RowType == EW_ROWTYPE_ADD) && $teachers_packages->EventCancelled) // Update failed
			$teachers_packages_list->RestoreCurrentRowFormValues($teachers_packages_list->RowIndex); // Restore form values
		if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) // Edit row
			$teachers_packages_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$teachers_packages->RowAttrs = array_merge($teachers_packages->RowAttrs, array('data-rowindex'=>$teachers_packages_list->RowCnt, 'id'=>'r' . $teachers_packages_list->RowCnt . '_teachers_packages', 'data-rowtype'=>$teachers_packages->RowType));

		// Render row
		$teachers_packages_list->RenderRow();

		// Render list options
		$teachers_packages_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($teachers_packages_list->RowAction <> "delete" && $teachers_packages_list->RowAction <> "insertdelete" && !($teachers_packages_list->RowAction == "insert" && $teachers_packages->CurrentAction == "F" && $teachers_packages_list->EmptyRow())) {
?>
	<tr<?php echo $teachers_packages->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_packages_list->ListOptions->Render("body", "left", $teachers_packages_list->RowCnt);
?>
	<?php if ($teachers_packages->id->Visible) { // id ?>
		<td data-name="id"<?php echo $teachers_packages->id->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="teachers_packages" data-field="x_id" name="o<?php echo $teachers_packages_list->RowIndex ?>_id" id="o<?php echo $teachers_packages_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_packages->id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_id" class="form-group teachers_packages_id">
<span<?php echo $teachers_packages->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_id" name="x<?php echo $teachers_packages_list->RowIndex ?>_id" id="x<?php echo $teachers_packages_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_packages->id->CurrentValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_id" class="teachers_packages_id">
<span<?php echo $teachers_packages->id->ViewAttributes() ?>>
<?php echo $teachers_packages->id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id"<?php echo $teachers_packages->teacher_id->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($teachers_packages->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<span<?php echo $teachers_packages->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" name="x<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<input type="text" data-table="teachers_packages" data-field="x_teacher_id" name="x<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" id="x<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->teacher_id->EditValue ?>"<?php echo $teachers_packages->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" name="o<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" id="o<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($teachers_packages->teacher_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<span<?php echo $teachers_packages->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" name="x<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<input type="text" data-table="teachers_packages" data-field="x_teacher_id" name="x<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" id="x<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->teacher_id->EditValue ?>"<?php echo $teachers_packages->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_teacher_id" class="teachers_packages_teacher_id">
<span<?php echo $teachers_packages->teacher_id->ViewAttributes() ?>>
<?php echo $teachers_packages->teacher_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->title_en->Visible) { // title_en ?>
		<td data-name="title_en"<?php echo $teachers_packages->title_en->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_title_en" class="form-group teachers_packages_title_en">
<textarea data-table="teachers_packages" data-field="x_title_en" name="x<?php echo $teachers_packages_list->RowIndex ?>_title_en" id="x<?php echo $teachers_packages_list->RowIndex ?>_title_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->title_en->getPlaceHolder()) ?>"<?php echo $teachers_packages->title_en->EditAttributes() ?>><?php echo $teachers_packages->title_en->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" name="o<?php echo $teachers_packages_list->RowIndex ?>_title_en" id="o<?php echo $teachers_packages_list->RowIndex ?>_title_en" value="<?php echo ew_HtmlEncode($teachers_packages->title_en->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_title_en" class="form-group teachers_packages_title_en">
<textarea data-table="teachers_packages" data-field="x_title_en" name="x<?php echo $teachers_packages_list->RowIndex ?>_title_en" id="x<?php echo $teachers_packages_list->RowIndex ?>_title_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->title_en->getPlaceHolder()) ?>"<?php echo $teachers_packages->title_en->EditAttributes() ?>><?php echo $teachers_packages->title_en->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_title_en" class="teachers_packages_title_en">
<span<?php echo $teachers_packages->title_en->ViewAttributes() ?>>
<?php echo $teachers_packages->title_en->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->title_ar->Visible) { // title_ar ?>
		<td data-name="title_ar"<?php echo $teachers_packages->title_ar->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_title_ar" class="form-group teachers_packages_title_ar">
<textarea data-table="teachers_packages" data-field="x_title_ar" name="x<?php echo $teachers_packages_list->RowIndex ?>_title_ar" id="x<?php echo $teachers_packages_list->RowIndex ?>_title_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->title_ar->getPlaceHolder()) ?>"<?php echo $teachers_packages->title_ar->EditAttributes() ?>><?php echo $teachers_packages->title_ar->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" name="o<?php echo $teachers_packages_list->RowIndex ?>_title_ar" id="o<?php echo $teachers_packages_list->RowIndex ?>_title_ar" value="<?php echo ew_HtmlEncode($teachers_packages->title_ar->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_title_ar" class="form-group teachers_packages_title_ar">
<textarea data-table="teachers_packages" data-field="x_title_ar" name="x<?php echo $teachers_packages_list->RowIndex ?>_title_ar" id="x<?php echo $teachers_packages_list->RowIndex ?>_title_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->title_ar->getPlaceHolder()) ?>"<?php echo $teachers_packages->title_ar->EditAttributes() ?>><?php echo $teachers_packages->title_ar->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_title_ar" class="teachers_packages_title_ar">
<span<?php echo $teachers_packages->title_ar->ViewAttributes() ?>>
<?php echo $teachers_packages->title_ar->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->description_en->Visible) { // description_en ?>
		<td data-name="description_en"<?php echo $teachers_packages->description_en->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_description_en" class="form-group teachers_packages_description_en">
<textarea data-table="teachers_packages" data-field="x_description_en" name="x<?php echo $teachers_packages_list->RowIndex ?>_description_en" id="x<?php echo $teachers_packages_list->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->description_en->getPlaceHolder()) ?>"<?php echo $teachers_packages->description_en->EditAttributes() ?>><?php echo $teachers_packages->description_en->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" name="o<?php echo $teachers_packages_list->RowIndex ?>_description_en" id="o<?php echo $teachers_packages_list->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers_packages->description_en->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_description_en" class="form-group teachers_packages_description_en">
<textarea data-table="teachers_packages" data-field="x_description_en" name="x<?php echo $teachers_packages_list->RowIndex ?>_description_en" id="x<?php echo $teachers_packages_list->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->description_en->getPlaceHolder()) ?>"<?php echo $teachers_packages->description_en->EditAttributes() ?>><?php echo $teachers_packages->description_en->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_description_en" class="teachers_packages_description_en">
<span<?php echo $teachers_packages->description_en->ViewAttributes() ?>>
<?php echo $teachers_packages->description_en->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->description_ar->Visible) { // description_ar ?>
		<td data-name="description_ar"<?php echo $teachers_packages->description_ar->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_description_ar" class="form-group teachers_packages_description_ar">
<textarea data-table="teachers_packages" data-field="x_description_ar" name="x<?php echo $teachers_packages_list->RowIndex ?>_description_ar" id="x<?php echo $teachers_packages_list->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->description_ar->getPlaceHolder()) ?>"<?php echo $teachers_packages->description_ar->EditAttributes() ?>><?php echo $teachers_packages->description_ar->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" name="o<?php echo $teachers_packages_list->RowIndex ?>_description_ar" id="o<?php echo $teachers_packages_list->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers_packages->description_ar->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_description_ar" class="form-group teachers_packages_description_ar">
<textarea data-table="teachers_packages" data-field="x_description_ar" name="x<?php echo $teachers_packages_list->RowIndex ?>_description_ar" id="x<?php echo $teachers_packages_list->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->description_ar->getPlaceHolder()) ?>"<?php echo $teachers_packages->description_ar->EditAttributes() ?>><?php echo $teachers_packages->description_ar->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_description_ar" class="teachers_packages_description_ar">
<span<?php echo $teachers_packages->description_ar->ViewAttributes() ?>>
<?php echo $teachers_packages->description_ar->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->image->Visible) { // image ?>
		<td data-name="image"<?php echo $teachers_packages->image->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_image" class="form-group teachers_packages_image">
<textarea data-table="teachers_packages" data-field="x_image" name="x<?php echo $teachers_packages_list->RowIndex ?>_image" id="x<?php echo $teachers_packages_list->RowIndex ?>_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->image->getPlaceHolder()) ?>"<?php echo $teachers_packages->image->EditAttributes() ?>><?php echo $teachers_packages->image->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_image" name="o<?php echo $teachers_packages_list->RowIndex ?>_image" id="o<?php echo $teachers_packages_list->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_packages->image->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_image" class="form-group teachers_packages_image">
<textarea data-table="teachers_packages" data-field="x_image" name="x<?php echo $teachers_packages_list->RowIndex ?>_image" id="x<?php echo $teachers_packages_list->RowIndex ?>_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->image->getPlaceHolder()) ?>"<?php echo $teachers_packages->image->EditAttributes() ?>><?php echo $teachers_packages->image->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_image" class="teachers_packages_image">
<span<?php echo $teachers_packages->image->ViewAttributes() ?>>
<?php echo $teachers_packages->image->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->fees->Visible) { // fees ?>
		<td data-name="fees"<?php echo $teachers_packages->fees->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_fees" class="form-group teachers_packages_fees">
<input type="text" data-table="teachers_packages" data-field="x_fees" name="x<?php echo $teachers_packages_list->RowIndex ?>_fees" id="x<?php echo $teachers_packages_list->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->fees->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->fees->EditValue ?>"<?php echo $teachers_packages->fees->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_fees" name="o<?php echo $teachers_packages_list->RowIndex ?>_fees" id="o<?php echo $teachers_packages_list->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers_packages->fees->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_fees" class="form-group teachers_packages_fees">
<input type="text" data-table="teachers_packages" data-field="x_fees" name="x<?php echo $teachers_packages_list->RowIndex ?>_fees" id="x<?php echo $teachers_packages_list->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->fees->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->fees->EditValue ?>"<?php echo $teachers_packages->fees->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_fees" class="teachers_packages_fees">
<span<?php echo $teachers_packages->fees->ViewAttributes() ?>>
<?php echo $teachers_packages->fees->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id"<?php echo $teachers_packages->currency_id->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_currency_id" class="form-group teachers_packages_currency_id">
<input type="text" data-table="teachers_packages" data-field="x_currency_id" name="x<?php echo $teachers_packages_list->RowIndex ?>_currency_id" id="x<?php echo $teachers_packages_list->RowIndex ?>_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->currency_id->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->currency_id->EditValue ?>"<?php echo $teachers_packages->currency_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" name="o<?php echo $teachers_packages_list->RowIndex ?>_currency_id" id="o<?php echo $teachers_packages_list->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers_packages->currency_id->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_currency_id" class="form-group teachers_packages_currency_id">
<input type="text" data-table="teachers_packages" data-field="x_currency_id" name="x<?php echo $teachers_packages_list->RowIndex ?>_currency_id" id="x<?php echo $teachers_packages_list->RowIndex ?>_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->currency_id->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->currency_id->EditValue ?>"<?php echo $teachers_packages->currency_id->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_currency_id" class="teachers_packages_currency_id">
<span<?php echo $teachers_packages->currency_id->ViewAttributes() ?>>
<?php echo $teachers_packages->currency_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->created_at->Visible) { // created_at ?>
		<td data-name="created_at"<?php echo $teachers_packages->created_at->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_created_at" class="form-group teachers_packages_created_at">
<input type="text" data-table="teachers_packages" data-field="x_created_at" name="x<?php echo $teachers_packages_list->RowIndex ?>_created_at" id="x<?php echo $teachers_packages_list->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($teachers_packages->created_at->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->created_at->EditValue ?>"<?php echo $teachers_packages->created_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" name="o<?php echo $teachers_packages_list->RowIndex ?>_created_at" id="o<?php echo $teachers_packages_list->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers_packages->created_at->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_created_at" class="form-group teachers_packages_created_at">
<input type="text" data-table="teachers_packages" data-field="x_created_at" name="x<?php echo $teachers_packages_list->RowIndex ?>_created_at" id="x<?php echo $teachers_packages_list->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($teachers_packages->created_at->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->created_at->EditValue ?>"<?php echo $teachers_packages->created_at->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_created_at" class="teachers_packages_created_at">
<span<?php echo $teachers_packages->created_at->ViewAttributes() ?>>
<?php echo $teachers_packages->created_at->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($teachers_packages->updated_at->Visible) { // updated_at ?>
		<td data-name="updated_at"<?php echo $teachers_packages->updated_at->CellAttributes() ?>>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_updated_at" class="form-group teachers_packages_updated_at">
<input type="text" data-table="teachers_packages" data-field="x_updated_at" name="x<?php echo $teachers_packages_list->RowIndex ?>_updated_at" id="x<?php echo $teachers_packages_list->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($teachers_packages->updated_at->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->updated_at->EditValue ?>"<?php echo $teachers_packages->updated_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_updated_at" name="o<?php echo $teachers_packages_list->RowIndex ?>_updated_at" id="o<?php echo $teachers_packages_list->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers_packages->updated_at->OldValue) ?>">
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_updated_at" class="form-group teachers_packages_updated_at">
<input type="text" data-table="teachers_packages" data-field="x_updated_at" name="x<?php echo $teachers_packages_list->RowIndex ?>_updated_at" id="x<?php echo $teachers_packages_list->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($teachers_packages->updated_at->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->updated_at->EditValue ?>"<?php echo $teachers_packages->updated_at->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $teachers_packages_list->RowCnt ?>_teachers_packages_updated_at" class="teachers_packages_updated_at">
<span<?php echo $teachers_packages->updated_at->ViewAttributes() ?>>
<?php echo $teachers_packages->updated_at->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_packages_list->ListOptions->Render("body", "right", $teachers_packages_list->RowCnt);
?>
	</tr>
<?php if ($teachers_packages->RowType == EW_ROWTYPE_ADD || $teachers_packages->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fteachers_packageslist.UpdateOpts(<?php echo $teachers_packages_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($teachers_packages->CurrentAction <> "gridadd")
		if (!$teachers_packages_list->Recordset->EOF) $teachers_packages_list->Recordset->MoveNext();
}
?>
<?php
	if ($teachers_packages->CurrentAction == "gridadd" || $teachers_packages->CurrentAction == "gridedit") {
		$teachers_packages_list->RowIndex = '$rowindex$';
		$teachers_packages_list->LoadRowValues();

		// Set row properties
		$teachers_packages->ResetAttrs();
		$teachers_packages->RowAttrs = array_merge($teachers_packages->RowAttrs, array('data-rowindex'=>$teachers_packages_list->RowIndex, 'id'=>'r0_teachers_packages', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($teachers_packages->RowAttrs["class"], "ewTemplate");
		$teachers_packages->RowType = EW_ROWTYPE_ADD;

		// Render row
		$teachers_packages_list->RenderRow();

		// Render list options
		$teachers_packages_list->RenderListOptions();
		$teachers_packages_list->StartRowCnt = 0;
?>
	<tr<?php echo $teachers_packages->RowAttributes() ?>>
<?php

// Render list options (body, left)
$teachers_packages_list->ListOptions->Render("body", "left", $teachers_packages_list->RowIndex);
?>
	<?php if ($teachers_packages->id->Visible) { // id ?>
		<td data-name="id">
<input type="hidden" data-table="teachers_packages" data-field="x_id" name="o<?php echo $teachers_packages_list->RowIndex ?>_id" id="o<?php echo $teachers_packages_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($teachers_packages->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->teacher_id->Visible) { // teacher_id ?>
		<td data-name="teacher_id">
<?php if ($teachers_packages->teacher_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<span<?php echo $teachers_packages->teacher_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $teachers_packages->teacher_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" name="x<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_teachers_packages_teacher_id" class="form-group teachers_packages_teacher_id">
<input type="text" data-table="teachers_packages" data-field="x_teacher_id" name="x<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" id="x<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->teacher_id->EditValue ?>"<?php echo $teachers_packages->teacher_id->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="teachers_packages" data-field="x_teacher_id" name="o<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" id="o<?php echo $teachers_packages_list->RowIndex ?>_teacher_id" value="<?php echo ew_HtmlEncode($teachers_packages->teacher_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->title_en->Visible) { // title_en ?>
		<td data-name="title_en">
<span id="el$rowindex$_teachers_packages_title_en" class="form-group teachers_packages_title_en">
<textarea data-table="teachers_packages" data-field="x_title_en" name="x<?php echo $teachers_packages_list->RowIndex ?>_title_en" id="x<?php echo $teachers_packages_list->RowIndex ?>_title_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->title_en->getPlaceHolder()) ?>"<?php echo $teachers_packages->title_en->EditAttributes() ?>><?php echo $teachers_packages->title_en->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_title_en" name="o<?php echo $teachers_packages_list->RowIndex ?>_title_en" id="o<?php echo $teachers_packages_list->RowIndex ?>_title_en" value="<?php echo ew_HtmlEncode($teachers_packages->title_en->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->title_ar->Visible) { // title_ar ?>
		<td data-name="title_ar">
<span id="el$rowindex$_teachers_packages_title_ar" class="form-group teachers_packages_title_ar">
<textarea data-table="teachers_packages" data-field="x_title_ar" name="x<?php echo $teachers_packages_list->RowIndex ?>_title_ar" id="x<?php echo $teachers_packages_list->RowIndex ?>_title_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->title_ar->getPlaceHolder()) ?>"<?php echo $teachers_packages->title_ar->EditAttributes() ?>><?php echo $teachers_packages->title_ar->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_title_ar" name="o<?php echo $teachers_packages_list->RowIndex ?>_title_ar" id="o<?php echo $teachers_packages_list->RowIndex ?>_title_ar" value="<?php echo ew_HtmlEncode($teachers_packages->title_ar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->description_en->Visible) { // description_en ?>
		<td data-name="description_en">
<span id="el$rowindex$_teachers_packages_description_en" class="form-group teachers_packages_description_en">
<textarea data-table="teachers_packages" data-field="x_description_en" name="x<?php echo $teachers_packages_list->RowIndex ?>_description_en" id="x<?php echo $teachers_packages_list->RowIndex ?>_description_en" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->description_en->getPlaceHolder()) ?>"<?php echo $teachers_packages->description_en->EditAttributes() ?>><?php echo $teachers_packages->description_en->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_description_en" name="o<?php echo $teachers_packages_list->RowIndex ?>_description_en" id="o<?php echo $teachers_packages_list->RowIndex ?>_description_en" value="<?php echo ew_HtmlEncode($teachers_packages->description_en->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->description_ar->Visible) { // description_ar ?>
		<td data-name="description_ar">
<span id="el$rowindex$_teachers_packages_description_ar" class="form-group teachers_packages_description_ar">
<textarea data-table="teachers_packages" data-field="x_description_ar" name="x<?php echo $teachers_packages_list->RowIndex ?>_description_ar" id="x<?php echo $teachers_packages_list->RowIndex ?>_description_ar" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->description_ar->getPlaceHolder()) ?>"<?php echo $teachers_packages->description_ar->EditAttributes() ?>><?php echo $teachers_packages->description_ar->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_description_ar" name="o<?php echo $teachers_packages_list->RowIndex ?>_description_ar" id="o<?php echo $teachers_packages_list->RowIndex ?>_description_ar" value="<?php echo ew_HtmlEncode($teachers_packages->description_ar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->image->Visible) { // image ?>
		<td data-name="image">
<span id="el$rowindex$_teachers_packages_image" class="form-group teachers_packages_image">
<textarea data-table="teachers_packages" data-field="x_image" name="x<?php echo $teachers_packages_list->RowIndex ?>_image" id="x<?php echo $teachers_packages_list->RowIndex ?>_image" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($teachers_packages->image->getPlaceHolder()) ?>"<?php echo $teachers_packages->image->EditAttributes() ?>><?php echo $teachers_packages->image->EditValue ?></textarea>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_image" name="o<?php echo $teachers_packages_list->RowIndex ?>_image" id="o<?php echo $teachers_packages_list->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($teachers_packages->image->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->fees->Visible) { // fees ?>
		<td data-name="fees">
<span id="el$rowindex$_teachers_packages_fees" class="form-group teachers_packages_fees">
<input type="text" data-table="teachers_packages" data-field="x_fees" name="x<?php echo $teachers_packages_list->RowIndex ?>_fees" id="x<?php echo $teachers_packages_list->RowIndex ?>_fees" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->fees->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->fees->EditValue ?>"<?php echo $teachers_packages->fees->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_fees" name="o<?php echo $teachers_packages_list->RowIndex ?>_fees" id="o<?php echo $teachers_packages_list->RowIndex ?>_fees" value="<?php echo ew_HtmlEncode($teachers_packages->fees->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->currency_id->Visible) { // currency_id ?>
		<td data-name="currency_id">
<span id="el$rowindex$_teachers_packages_currency_id" class="form-group teachers_packages_currency_id">
<input type="text" data-table="teachers_packages" data-field="x_currency_id" name="x<?php echo $teachers_packages_list->RowIndex ?>_currency_id" id="x<?php echo $teachers_packages_list->RowIndex ?>_currency_id" size="30" placeholder="<?php echo ew_HtmlEncode($teachers_packages->currency_id->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->currency_id->EditValue ?>"<?php echo $teachers_packages->currency_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_currency_id" name="o<?php echo $teachers_packages_list->RowIndex ?>_currency_id" id="o<?php echo $teachers_packages_list->RowIndex ?>_currency_id" value="<?php echo ew_HtmlEncode($teachers_packages->currency_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->created_at->Visible) { // created_at ?>
		<td data-name="created_at">
<span id="el$rowindex$_teachers_packages_created_at" class="form-group teachers_packages_created_at">
<input type="text" data-table="teachers_packages" data-field="x_created_at" name="x<?php echo $teachers_packages_list->RowIndex ?>_created_at" id="x<?php echo $teachers_packages_list->RowIndex ?>_created_at" placeholder="<?php echo ew_HtmlEncode($teachers_packages->created_at->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->created_at->EditValue ?>"<?php echo $teachers_packages->created_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_created_at" name="o<?php echo $teachers_packages_list->RowIndex ?>_created_at" id="o<?php echo $teachers_packages_list->RowIndex ?>_created_at" value="<?php echo ew_HtmlEncode($teachers_packages->created_at->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($teachers_packages->updated_at->Visible) { // updated_at ?>
		<td data-name="updated_at">
<span id="el$rowindex$_teachers_packages_updated_at" class="form-group teachers_packages_updated_at">
<input type="text" data-table="teachers_packages" data-field="x_updated_at" name="x<?php echo $teachers_packages_list->RowIndex ?>_updated_at" id="x<?php echo $teachers_packages_list->RowIndex ?>_updated_at" placeholder="<?php echo ew_HtmlEncode($teachers_packages->updated_at->getPlaceHolder()) ?>" value="<?php echo $teachers_packages->updated_at->EditValue ?>"<?php echo $teachers_packages->updated_at->EditAttributes() ?>>
</span>
<input type="hidden" data-table="teachers_packages" data-field="x_updated_at" name="o<?php echo $teachers_packages_list->RowIndex ?>_updated_at" id="o<?php echo $teachers_packages_list->RowIndex ?>_updated_at" value="<?php echo ew_HtmlEncode($teachers_packages->updated_at->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$teachers_packages_list->ListOptions->Render("body", "right", $teachers_packages_list->RowIndex);
?>
<script type="text/javascript">
fteachers_packageslist.UpdateOpts(<?php echo $teachers_packages_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($teachers_packages->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $teachers_packages_list->FormKeyCountName ?>" id="<?php echo $teachers_packages_list->FormKeyCountName ?>" value="<?php echo $teachers_packages_list->KeyCount ?>">
<?php echo $teachers_packages_list->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_packages->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $teachers_packages_list->FormKeyCountName ?>" id="<?php echo $teachers_packages_list->FormKeyCountName ?>" value="<?php echo $teachers_packages_list->KeyCount ?>">
<?php echo $teachers_packages_list->MultiSelectKey ?>
<?php } ?>
<?php if ($teachers_packages->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($teachers_packages_list->Recordset)
	$teachers_packages_list->Recordset->Close();
?>
<?php if ($teachers_packages->Export == "") { ?>
<div class="box-footer ewGridLowerPanel">
<?php if ($teachers_packages->CurrentAction <> "gridadd" && $teachers_packages->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($teachers_packages_list->Pager)) $teachers_packages_list->Pager = new cPrevNextPager($teachers_packages_list->StartRec, $teachers_packages_list->DisplayRecs, $teachers_packages_list->TotalRecs, $teachers_packages_list->AutoHidePager) ?>
<?php if ($teachers_packages_list->Pager->RecordCount > 0 && $teachers_packages_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($teachers_packages_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $teachers_packages_list->PageUrl() ?>start=<?php echo $teachers_packages_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($teachers_packages_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $teachers_packages_list->PageUrl() ?>start=<?php echo $teachers_packages_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $teachers_packages_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($teachers_packages_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $teachers_packages_list->PageUrl() ?>start=<?php echo $teachers_packages_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($teachers_packages_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $teachers_packages_list->PageUrl() ?>start=<?php echo $teachers_packages_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $teachers_packages_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($teachers_packages_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $teachers_packages_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $teachers_packages_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $teachers_packages_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_packages_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($teachers_packages_list->TotalRecs == 0 && $teachers_packages->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($teachers_packages_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($teachers_packages->Export == "") { ?>
<script type="text/javascript">
fteachers_packageslistsrch.FilterList = <?php echo $teachers_packages_list->GetFilterList() ?>;
fteachers_packageslistsrch.Init();
fteachers_packageslist.Init();
</script>
<?php } ?>
<?php
$teachers_packages_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($teachers_packages->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$teachers_packages_list->Page_Terminate();
?>
