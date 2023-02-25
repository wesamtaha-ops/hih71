<?php

namespace PHPMaker2023\hih71;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class OrdersGrid extends Orders
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "OrdersGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fordersgrid";
    public $FormActionName = "";
    public $FormBlankRowName = "";
    public $FormKeyCountName = "";

    // CSS class/style
    public $CurrentPageName = "OrdersGrid";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $CopyUrl;
    public $ListUrl;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        return rtrim(UrlFor($route->getName(), $args), "/") . "?";
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer;
        $this->FormActionName = Config("FORM_ROW_ACTION_NAME");
        $this->FormBlankRowName = Config("FORM_BLANK_ROW_NAME");
        $this->FormKeyCountName = Config("FORM_KEY_COUNT_NAME");
        $this->TableVar = 'orders';
        $this->TableName = 'orders';

        // Table CSS class
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

        // CSS class name as context
        $this->ContextClass = CheckClassName($this->TableVar);
        AppendClass($this->TableGridClass, $this->ContextClass);

        // Fixed header table
        if (!$this->UseCustomTemplate) {
            $this->setFixedHeaderTable(Config("USE_FIXED_HEADER_TABLE"), Config("FIXED_HEADER_TABLE_HEIGHT"));
        }

        // Initialize
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (orders)
        if (!isset($GLOBALS["orders"]) || get_class($GLOBALS["orders"]) == PROJECT_NAMESPACE . "orders") {
            $GLOBALS["orders"] = &$this;
        }
        $this->AddUrl = "OrdersAdd";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'orders');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // List options
        $this->ListOptions = new ListOptions(["Tag" => "td", "TableVar" => $this->TableVar]);

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions([
            "TagClassName" => "ew-add-edit-option",
            "UseDropDownButton" => false,
            "DropDownButtonPhrase" => $Language->phrase("ButtonAddEdit"),
            "UseButtonGroup" => true
        ]);
    }

    // Get content from stream
    public function getContents(): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show response for API
                $ar = array_merge($this->getMessages(), $url ? ["url" => GetUrl($url)] : []);
                WriteJson($ar);
            }
            $this->clearMessages(); // Clear messages for API request
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }

    // Lookup data
    public function lookup($ar = null)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $ar["field"] ?? Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;
        $name = $ar["name"] ?? Post("name");
        $isQuery = ContainsString($name, "query_builder_rule");
        if ($isQuery) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }

        // Get lookup parameters
        $lookupType = $ar["ajax"] ?? Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $ar["q"] ?? Param("q") ?? $ar["sv"] ?? Post("sv", "");
            $pageSize = $ar["n"] ?? Param("n") ?? $ar["recperpage"] ?? Post("recperpage", 10);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $ar["q"] ?? Param("q", "");
            $pageSize = $ar["n"] ?? Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $ar["start"] ?? Param("start", -1);
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $ar["page"] ?? Param("page", -1);
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($ar["s"] ?? Post("s", ""));
        $userFilter = Decrypt($ar["f"] ?? Post("f", ""));
        $userOrderBy = Decrypt($ar["o"] ?? Post("o", ""));
        $keys = $ar["keys"] ?? Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $ar["v0"] ?? $ar["lookupValue"] ?? Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $ar["v" . $i] ?? Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, !is_array($ar)); // Use settings from current page
    }

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $ShowOtherOptions = false;
    public $DisplayRecords = 20;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = ""; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $InlineRowCount = 0;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $MultiColumnGridClass = "row-cols-md";
    public $MultiColumnEditClass = "col-12 w-100";
    public $MultiColumnCardClass = "card h-100 ew-card";
    public $MultiColumnListOptionsPosition = "bottom-start";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $UserAction; // User action
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $PageAction;
    public $RecKeys = [];
    public $IsModal = false;
    protected $FilterForModalActions = "";
    private $UseInfiniteScroll = false;

    /**
     * Load recordset from filter
     *
     * @return void
     */
    public function loadRecordsetFromFilter($filter)
    {
        // Set up list options
        $this->setupListOptions();

        // Search options
        $this->setupSearchOptions();

        // Load recordset
        $this->TotalRecords = $this->loadRecordCount($filter);
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords;
        $this->CurrentFilter = $filter;
        $this->Recordset = $this->loadRecordset();

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);
    }

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $UserProfile, $Language, $Security, $CurrentForm, $DashboardReport;

        // Multi column button position
        $this->MultiColumnListOptionsPosition = Config("MULTI_COLUMN_LIST_OPTIONS_POSITION");

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->id->setVisibility();
        $this->student_id->setVisibility();
        $this->teacher_id->setVisibility();
        $this->topic_id->setVisibility();
        $this->date->setVisibility();
        $this->time->setVisibility();
        $this->fees->setVisibility();
        $this->currency_id->setVisibility();
        $this->status->setVisibility();
        $this->meeting_id->setVisibility();
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
        $this->package_id->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Hide fields for add/edit
        if (!$this->UseAjaxActions) {
            $this->hideFieldsForAddEdit();
        }
        // Use inline delete
        if ($this->UseAjaxActions) {
            $this->InlineDelete = true;
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up lookup cache
        $this->setupLookupOptions($this->student_id);
        $this->setupLookupOptions($this->teacher_id);
        $this->setupLookupOptions($this->topic_id);
        $this->setupLookupOptions($this->currency_id);
        $this->setupLookupOptions($this->status);

        // Load default values for add
        $this->loadDefaultValues();

        // Update form name to avoid conflict
        if ($this->IsModal) {
            $this->FormName = "fordersgrid";
        }

        // Set up page action
        $this->PageAction = CurrentPageUrl(false);

        // Set up infinite scroll
        $this->UseInfiniteScroll = ConvertToBool(Param("infinitescroll"));

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = ""; // Filter
        $query = ""; // Query builder

        // Get command
        $this->Command = strtolower(Get("cmd", ""));

        // Set up records per page
        $this->setupDisplayRecords();

        // Handle reset command
        $this->resetCmd();

        // Hide list options
        if ($this->isExport()) {
            $this->ListOptions->hideAllOptions(["sequence"]);
            $this->ListOptions->UseDropDownButton = false; // Disable drop down button
            $this->ListOptions->UseButtonGroup = false; // Disable button group
        } elseif ($this->isGridAdd() || $this->isGridEdit() || $this->isMultiEdit() || $this->isConfirm()) {
            $this->ListOptions->hideAllOptions();
            $this->ListOptions->UseDropDownButton = false; // Disable drop down button
            $this->ListOptions->UseButtonGroup = false; // Disable button group
        }

        // Show grid delete link for grid add / grid edit
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $item = $this->ListOptions["griddelete"];
                if ($item) {
                    $item->Visible = true;
                }
            }
        }

        // Set up sorting order
        $this->setupSortOrder();

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Build filter
        $filter = "";
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        $this->Filter = $filter;
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } elseif (($this->isEdit() || $this->isCopy() || $this->isInlineInserted() || $this->isInlineUpdated()) && $this->UseInfiniteScroll) { // Get current record only
            $this->CurrentFilter = $this->isInlineUpdated() ? $this->getRecordFilter() : $this->getFilterFromRecordKeys();
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->StopRecord = $this->DisplayRecords;
            $this->Recordset = $this->loadRecordset();
        } elseif (
            $this->UseInfiniteScroll && $this->isGridInserted() ||
            $this->UseInfiniteScroll && ($this->isGridEdit() || $this->isGridUpdated()) ||
            $this->isMultiEdit() ||
            $this->UseInfiniteScroll && $this->isMultiUpdated()
        ) { // Get current records only
            $this->CurrentFilter = $this->FilterForModalActions; // Restore filter
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->StopRecord = $this->DisplayRecords;
            $this->Recordset = $this->loadRecordset();
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
        }

        // API list action
        if (IsApi()) {
            if (Route(0) == Config("API_LIST_ACTION")) {
                if (!$this->isExport()) {
                    $rows = $this->getRecordsFromRecordset($this->Recordset);
                    $this->Recordset->close();
                    WriteJson(["success" => true, "action" => Config("API_LIST_ACTION"), $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
                    $this->terminate(true);
                }
                return;
            } elseif ($this->getFailureMessage() != "") {
                WriteJson(["error" => $this->getFailureMessage()]);
                $this->clearFailureMessage();
                $this->terminate(true);
                return;
            }
        }

        // Render other options
        $this->renderOtherOptions();

        // Set up pager
        $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Set ReturnUrl in header if necessary
        if ($returnUrl = Container("flash")->getFirstMessage("Return-Url")) {
            AddHeader("Return-Url", GetUrl($returnUrl));
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Get page number
    public function getPageNumber()
    {
        return ($this->DisplayRecords > 0 && $this->StartRecord > 0) ? ceil($this->StartRecord / $this->DisplayRecords) : 1;
    }

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 20; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to Grid Add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Grid Edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old recordset
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAllAssociative();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            $this->EventCancelled = true;
            return false;
        }
        $this->loadDefaultValues();
        $wrkfilter = "";
        $key = "";

        // Update row index and get row key
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete" && $rowaction != "hide") { // Skip insert then deleted rows / hidden rows for grid edit
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    //} elseif (!$this->validateForm()) { // Already done in validateGridForm
                    //    $gridUpdate = false; // Form error, reset action
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                        if ($gridUpdate) { // Get inserted or updated filter
                            AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                        }
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    $this->EventCancelled = true;
                    break;
                }
            }
        }
        if ($gridUpdate) {
            $this->FilterForModalActions = $wrkfilter;

            // Get new records
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Perform Grid Add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            $this->EventCancelled = true;
            return false;
        }
        $this->loadDefaultValues();

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $key = "";

        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            $rsold = null;
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $rsold = $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success
                $gridInsert = $this->addRow($rsold); // Insert row (already validated by validateGridForm())
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->id->CurrentValue;

                    // Add filter for this record
                    AddFilter($wrkfilter, $this->getRecordFilter(), "OR");
                } else {
                    $this->EventCancelled = true;
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $this->FilterForModalActions = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if ($CurrentForm->hasValue("x_student_id") && $CurrentForm->hasValue("o_student_id") && $this->student_id->CurrentValue != $this->student_id->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_teacher_id") && $CurrentForm->hasValue("o_teacher_id") && $this->teacher_id->CurrentValue != $this->teacher_id->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_topic_id") && $CurrentForm->hasValue("o_topic_id") && $this->topic_id->CurrentValue != $this->topic_id->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_date") && $CurrentForm->hasValue("o_date") && $this->date->CurrentValue != $this->date->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_time") && $CurrentForm->hasValue("o_time") && $this->time->CurrentValue != $this->time->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_fees") && $CurrentForm->hasValue("o_fees") && $this->fees->CurrentValue != $this->fees->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_currency_id") && $CurrentForm->hasValue("o_currency_id") && $this->currency_id->CurrentValue != $this->currency_id->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_status") && $CurrentForm->hasValue("o_status") && $this->status->CurrentValue != $this->status->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_meeting_id") && $CurrentForm->hasValue("o_meeting_id") && $this->meeting_id->CurrentValue != $this->meeting_id->DefaultValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_package_id") && $CurrentForm->hasValue("o_package_id") && $this->package_id->CurrentValue != $this->package_id->DefaultValue) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Load default values for emptyRow checking
        $this->loadDefaultValues();

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete" && $rowaction != "hide") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    $this->EventCancelled = true;
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        $this->id->clearErrorMessage();
        $this->student_id->clearErrorMessage();
        $this->teacher_id->clearErrorMessage();
        $this->topic_id->clearErrorMessage();
        $this->date->clearErrorMessage();
        $this->time->clearErrorMessage();
        $this->fees->clearErrorMessage();
        $this->currency_id->clearErrorMessage();
        $this->status->clearErrorMessage();
        $this->meeting_id->clearErrorMessage();
        $this->package_id->clearErrorMessage();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Load default Sorting Order
        if ($this->Command != "json") {
            $defaultSort = ""; // Set up default sort
            if ($this->getSessionOrderBy() == "" && $defaultSort != "") {
                $this->setSessionOrderBy($defaultSort);
            }
        }

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->setStartRecordNumber(1); // Reset start position
        }

        // Update field sort
        $this->updateFieldSort();
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = true;
            $item->Visible = false; // Default hidden
        }

        // Add group option item ("button")
        $item = &$this->ListOptions->addGroupOption();
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = true;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = true;

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
        $item->OnLeft = true;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = true;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Set up list options (extensions)
    protected function setupListOptionsExt()
    {
            // Set up list options (to be implemented by extensions)
    }

    // Add "hash" parameter to URL
    public function urlAddHash($url, $hash)
    {
        return $this->UseAjaxActions ? $url : UrlAddQuery($url, "hash=" . $hash);
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm, $UserProfile;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
            }
        }
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                if ($this->ModalView && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-table=\"orders\" data-caption=\"" . $viewcaption . "\" data-ew-action=\"modal\" data-action=\"view\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\" data-btn=\"null\">" . $Language->phrase("ViewLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                if ($this->ModalEdit && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"orders\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-action=\"edit\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                if ($this->ModalAdd && !IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-table=\"orders\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("CopyLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }
        } // End View mode
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Render list options (extensions)
    protected function renderListOptionsExt()
    {
        // Render list options (to be implemented by extensions)
        global $Security, $Language;
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $option = $this->OtherOptions["addedit"];
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            if ($this->ModalAdd && !IsMobile()) {
                $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"orders\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-action=\"add\" data-ajax=\"" . ($this->UseAjaxActions ? "true" : "false") . "\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("AddLink") . "</a>";
            } else {
                $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            }
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        }
    }

    // Create new column option
    public function createColumnOption($name)
    {
        $field = $this->Fields[$name] ?? false;
        if ($field && $field->Visible) {
            $item = new ListOption($field->Name);
            $item->Body = '<button class="dropdown-item">' .
                '<div class="form-check ew-dropdown-checkbox">' .
                '<div class="form-check-input ew-dropdown-check-input" data-field="' . $field->Param . '"></div>' .
                '<label class="form-check-label ew-dropdown-check-label">' . $field->caption() . '</label></div></button>';
            return $item;
        }
        return null;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
            if (in_array($this->CurrentMode, ["add", "copy", "edit"]) && !$this->isConfirm()) { // Check add/copy/edit mode
                if ($this->AllowAddDeleteRow) {
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</a>";
                    $item->Visible = $Security->canAdd();
                    $this->ShowOtherOptions = $item->Visible;
                }
            }
            if ($this->CurrentMode == "view") { // Check view mode
                $option = $options["addedit"];
                $item = $option["add"];
                $this->ShowOtherOptions = $item && $item->Visible;
            }
    }

    // Set up Grid
    public function setupGrid()
    {
        global $CurrentForm;
        $this->StartRecord = 1;
        $this->StopRecord = $this->TotalRecords; // Show all records

        // Restore number of post back records
        if ($CurrentForm && ($this->isConfirm() || $this->EventCancelled)) {
            $CurrentForm->Index = -1;
            if ($CurrentForm->hasValue($this->FormKeyCountName) && ($this->isGridAdd() || $this->isGridEdit() || $this->isConfirm())) {
                $this->KeyCount = $CurrentForm->getValue($this->FormKeyCountName);
                $this->StopRecord = $this->StartRecord + $this->KeyCount - 1;
            }
        }
        $this->RecordCount = $this->StartRecord - 1;
        if ($this->Recordset && !$this->Recordset->EOF) {
            // Nothing to do
        } elseif ($this->isGridAdd() && !$this->AllowAddDeleteRow && $this->StopRecord == 0) { // Grid-Add with no records
            $this->StopRecord = $this->GridAddRowCount;
        } elseif ($this->isAdd() && $this->TotalRecords == 0) { // Inline-Add with no records
            $this->StopRecord = 1;
        }

        // Initialize aggregate
        $this->RowType = ROWTYPE_AGGREGATEINIT;
        $this->resetAttributes();
        $this->renderRow();
        if (($this->isGridAdd() || $this->isGridEdit())) { // Render template row first
            $this->RowIndex = '$rowindex$';
        }
    }

    // Set up Row
    public function setupRow()
    {
        global $CurrentForm;
        if ($this->isGridAdd() || $this->isGridEdit()) {
            if ($this->RowIndex === '$rowindex$') { // Render template row first
                $this->loadRowValues();

                // Set row properties
                $this->resetAttributes();
                $this->RowAttrs->merge(["data-rowindex" => $this->RowIndex, "id" => "r0_orders", "data-rowtype" => ROWTYPE_ADD]);
                $this->RowAttrs->appendClass("ew-template");
                // Render row
                $this->RowType = ROWTYPE_ADD;
                $this->renderRow();

                // Render list options
                $this->renderListOptions();

                // Reset record count for template row
                $this->RecordCount--;
                return;
            }
        }
        if ($this->isGridAdd() || $this->isGridEdit() || $this->isConfirm() || $this->isMultiEdit()) {
            $this->RowIndex++;
            $CurrentForm->Index = $this->RowIndex;
            if ($CurrentForm->hasValue($this->FormActionName) && ($this->isConfirm() || $this->EventCancelled)) {
                $this->RowAction = strval($CurrentForm->getValue($this->FormActionName));
            } elseif ($this->isGridAdd()) {
                $this->RowAction = "insert";
            } else {
                $this->RowAction = "";
            }
        }

        // Set up key count
        $this->KeyCount = $this->RowIndex;

        // Init row class and style
        $this->resetAttributes();
        $this->CssClass = "";
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->loadRowValues($this->Recordset); // Load row values
                $this->OldKey = $this->getKey(true); // Get from CurrentValue
            } else {
                $this->loadRowValues(); // Load default values
                $this->OldKey = "";
            }
        } else {
            $this->loadRowValues($this->Recordset); // Load row values
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
        }
        $this->setKey($this->OldKey);
        $this->RowType = ROWTYPE_VIEW; // Render view
        if (($this->isAdd() || $this->isCopy()) && $this->InlineRowCount == 0 || $this->isGridAdd()) { // Add
            $this->RowType = ROWTYPE_ADD; // Render add
        }
        if ($this->isGridAdd() && $this->EventCancelled && !$CurrentForm->hasValue($this->FormBlankRowName)) { // Insert failed
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
        }
        if ($this->isGridEdit()) { // Grid edit
            if ($this->EventCancelled) {
                $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
            }
            if ($this->RowAction == "insert") {
                $this->RowType = ROWTYPE_ADD; // Render add
            } else {
                $this->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($this->isGridEdit() && ($this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_ADD) && $this->EventCancelled) { // Update failed
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
        }
        if ($this->isConfirm()) { // Confirm row
            $this->restoreCurrentRowFormValues($this->RowIndex); // Restore form values
        }

        // Inline Add/Copy row (row 0)
        if ($this->RowType == ROWTYPE_ADD && ($this->isAdd() || $this->isCopy())) {
            $this->InlineRowCount++;
            $this->RecordCount--; // Reset record count for inline add/copy row
            if ($this->TotalRecords == 0) { // Reset stop record if no records
                $this->StopRecord = 0;
            }
        } else {
            // Inline Edit row
            if ($this->RowType == ROWTYPE_EDIT && $this->isEdit()) {
                $this->InlineRowCount++;
            }
            $this->RowCount++; // Increment row count
        }

        // Set up row attributes
        $this->RowAttrs->merge([
            "data-rowindex" => $this->RowCount,
            "data-key" => $this->getKey(true),
            "id" => "r" . $this->RowCount . "_orders",
            "data-rowtype" => $this->RowType,
            "class" => ($this->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($this->isAdd() && $this->RowType == ROWTYPE_ADD || $this->isEdit() && $this->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $this->RowAttrs->appendClass("table-active");
        }

        // Render row
        $this->renderRow();

        // Render list options
        $this->renderListOptions();
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->status->DefaultValue = $this->status->getDefault(); // PHP
        $this->status->OldValue = $this->status->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->id->setFormValue($val);
        }

        // Check field name 'student_id' first before field var 'x_student_id'
        $val = $CurrentForm->hasValue("student_id") ? $CurrentForm->getValue("student_id") : $CurrentForm->getValue("x_student_id");
        if (!$this->student_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->student_id->Visible = false; // Disable update for API request
            } else {
                $this->student_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_student_id")) {
            $this->student_id->setOldValue($CurrentForm->getValue("o_student_id"));
        }

        // Check field name 'teacher_id' first before field var 'x_teacher_id'
        $val = $CurrentForm->hasValue("teacher_id") ? $CurrentForm->getValue("teacher_id") : $CurrentForm->getValue("x_teacher_id");
        if (!$this->teacher_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->teacher_id->Visible = false; // Disable update for API request
            } else {
                $this->teacher_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_teacher_id")) {
            $this->teacher_id->setOldValue($CurrentForm->getValue("o_teacher_id"));
        }

        // Check field name 'topic_id' first before field var 'x_topic_id'
        $val = $CurrentForm->hasValue("topic_id") ? $CurrentForm->getValue("topic_id") : $CurrentForm->getValue("x_topic_id");
        if (!$this->topic_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->topic_id->Visible = false; // Disable update for API request
            } else {
                $this->topic_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_topic_id")) {
            $this->topic_id->setOldValue($CurrentForm->getValue("o_topic_id"));
        }

        // Check field name 'date' first before field var 'x_date'
        $val = $CurrentForm->hasValue("date") ? $CurrentForm->getValue("date") : $CurrentForm->getValue("x_date");
        if (!$this->date->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->date->Visible = false; // Disable update for API request
            } else {
                $this->date->setFormValue($val, true, $validate);
            }
            $this->date->CurrentValue = UnFormatDateTime($this->date->CurrentValue, $this->date->formatPattern());
        }
        if ($CurrentForm->hasValue("o_date")) {
            $this->date->setOldValue($CurrentForm->getValue("o_date"));
        }

        // Check field name 'time' first before field var 'x_time'
        $val = $CurrentForm->hasValue("time") ? $CurrentForm->getValue("time") : $CurrentForm->getValue("x_time");
        if (!$this->time->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->time->Visible = false; // Disable update for API request
            } else {
                $this->time->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_time")) {
            $this->time->setOldValue($CurrentForm->getValue("o_time"));
        }

        // Check field name 'fees' first before field var 'x_fees'
        $val = $CurrentForm->hasValue("fees") ? $CurrentForm->getValue("fees") : $CurrentForm->getValue("x_fees");
        if (!$this->fees->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fees->Visible = false; // Disable update for API request
            } else {
                $this->fees->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_fees")) {
            $this->fees->setOldValue($CurrentForm->getValue("o_fees"));
        }

        // Check field name 'currency_id' first before field var 'x_currency_id'
        $val = $CurrentForm->hasValue("currency_id") ? $CurrentForm->getValue("currency_id") : $CurrentForm->getValue("x_currency_id");
        if (!$this->currency_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->currency_id->Visible = false; // Disable update for API request
            } else {
                $this->currency_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_currency_id")) {
            $this->currency_id->setOldValue($CurrentForm->getValue("o_currency_id"));
        }

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_status")) {
            $this->status->setOldValue($CurrentForm->getValue("o_status"));
        }

        // Check field name 'meeting_id' first before field var 'x_meeting_id'
        $val = $CurrentForm->hasValue("meeting_id") ? $CurrentForm->getValue("meeting_id") : $CurrentForm->getValue("x_meeting_id");
        if (!$this->meeting_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->meeting_id->Visible = false; // Disable update for API request
            } else {
                $this->meeting_id->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_meeting_id")) {
            $this->meeting_id->setOldValue($CurrentForm->getValue("o_meeting_id"));
        }

        // Check field name 'package_id' first before field var 'x_package_id'
        $val = $CurrentForm->hasValue("package_id") ? $CurrentForm->getValue("package_id") : $CurrentForm->getValue("x_package_id");
        if (!$this->package_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->package_id->Visible = false; // Disable update for API request
            } else {
                $this->package_id->setFormValue($val, true, $validate);
            }
        }
        if ($CurrentForm->hasValue("o_package_id")) {
            $this->package_id->setOldValue($CurrentForm->getValue("o_package_id"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id->CurrentValue = $this->id->FormValue;
        }
        $this->student_id->CurrentValue = $this->student_id->FormValue;
        $this->teacher_id->CurrentValue = $this->teacher_id->FormValue;
        $this->topic_id->CurrentValue = $this->topic_id->FormValue;
        $this->date->CurrentValue = $this->date->FormValue;
        $this->date->CurrentValue = UnFormatDateTime($this->date->CurrentValue, $this->date->formatPattern());
        $this->time->CurrentValue = $this->time->FormValue;
        $this->fees->CurrentValue = $this->fees->FormValue;
        $this->currency_id->CurrentValue = $this->currency_id->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->meeting_id->CurrentValue = $this->meeting_id->FormValue;
        $this->package_id->CurrentValue = $this->package_id->FormValue;
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        $rs = new Recordset($result, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    // Load records as associative array
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        return $result->fetchAllAssociative();
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }
        if (!$row) {
            return;
        }

        // Call Row Selected event
        $this->rowSelected($row);
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
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['student_id'] = $this->student_id->DefaultValue;
        $row['teacher_id'] = $this->teacher_id->DefaultValue;
        $row['topic_id'] = $this->topic_id->DefaultValue;
        $row['date'] = $this->date->DefaultValue;
        $row['time'] = $this->time->DefaultValue;
        $row['fees'] = $this->fees->DefaultValue;
        $row['currency_id'] = $this->currency_id->DefaultValue;
        $row['status'] = $this->status->DefaultValue;
        $row['meeting_id'] = $this->meeting_id->DefaultValue;
        $row['created_at'] = $this->created_at->DefaultValue;
        $row['updated_at'] = $this->updated_at->DefaultValue;
        $row['package_id'] = $this->package_id->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        if ($this->OldKey != "") {
            $this->setKey($this->OldKey);
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn);
            if ($rs && ($row = $rs->fields)) {
                $this->loadRowValues($row); // Load row values
                return $row;
            }
        }
        $this->loadRowValues(); // Load default row values
        return null;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

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

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;

            // student_id
            $curVal = strval($this->student_id->CurrentValue);
            if ($curVal != "") {
                $this->student_id->ViewValue = $this->student_id->lookupCacheOption($curVal);
                if ($this->student_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`id`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->student_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->student_id->Lookup->renderViewRow($rswrk[0]);
                        $this->student_id->ViewValue = $this->student_id->displayValue($arwrk);
                    } else {
                        $this->student_id->ViewValue = $this->student_id->CurrentValue;
                    }
                }
            } else {
                $this->student_id->ViewValue = null;
            }

            // teacher_id
            $curVal = strval($this->teacher_id->CurrentValue);
            if ($curVal != "") {
                $this->teacher_id->ViewValue = $this->teacher_id->lookupCacheOption($curVal);
                if ($this->teacher_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`id`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->teacher_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->teacher_id->Lookup->renderViewRow($rswrk[0]);
                        $this->teacher_id->ViewValue = $this->teacher_id->displayValue($arwrk);
                    } else {
                        $this->teacher_id->ViewValue = $this->teacher_id->CurrentValue;
                    }
                }
            } else {
                $this->teacher_id->ViewValue = null;
            }

            // topic_id
            $curVal = strval($this->topic_id->CurrentValue);
            if ($curVal != "") {
                $this->topic_id->ViewValue = $this->topic_id->lookupCacheOption($curVal);
                if ($this->topic_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`id`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->topic_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->topic_id->Lookup->renderViewRow($rswrk[0]);
                        $this->topic_id->ViewValue = $this->topic_id->displayValue($arwrk);
                    } else {
                        $this->topic_id->ViewValue = $this->topic_id->CurrentValue;
                    }
                }
            } else {
                $this->topic_id->ViewValue = null;
            }

            // date
            $this->date->ViewValue = $this->date->CurrentValue;
            $this->date->ViewValue = FormatDateTime($this->date->ViewValue, $this->date->formatPattern());

            // time
            $this->time->ViewValue = $this->time->CurrentValue;

            // fees
            $this->fees->ViewValue = $this->fees->CurrentValue;

            // currency_id
            $curVal = strval($this->currency_id->CurrentValue);
            if ($curVal != "") {
                $this->currency_id->ViewValue = $this->currency_id->lookupCacheOption($curVal);
                if ($this->currency_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`id`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->currency_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->currency_id->Lookup->renderViewRow($rswrk[0]);
                        $this->currency_id->ViewValue = $this->currency_id->displayValue($arwrk);
                    } else {
                        $this->currency_id->ViewValue = $this->currency_id->CurrentValue;
                    }
                }
            } else {
                $this->currency_id->ViewValue = null;
            }

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }

            // meeting_id
            $this->meeting_id->ViewValue = $this->meeting_id->CurrentValue;

            // package_id
            $this->package_id->ViewValue = $this->package_id->CurrentValue;

            // id
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // student_id
            $this->student_id->HrefValue = "";
            $this->student_id->TooltipValue = "";

            // teacher_id
            $this->teacher_id->HrefValue = "";
            $this->teacher_id->TooltipValue = "";

            // topic_id
            $this->topic_id->HrefValue = "";
            $this->topic_id->TooltipValue = "";

            // date
            $this->date->HrefValue = "";
            $this->date->TooltipValue = "";

            // time
            $this->time->HrefValue = "";
            $this->time->TooltipValue = "";

            // fees
            $this->fees->HrefValue = "";
            $this->fees->TooltipValue = "";

            // currency_id
            $this->currency_id->HrefValue = "";
            $this->currency_id->TooltipValue = "";

            // status
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // meeting_id
            $this->meeting_id->HrefValue = "";
            $this->meeting_id->TooltipValue = "";

            // package_id
            $this->package_id->HrefValue = "";
            $this->package_id->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id

            // student_id
            $this->student_id->setupEditAttributes();
            $curVal = trim(strval($this->student_id->CurrentValue));
            if ($curVal != "") {
                $this->student_id->ViewValue = $this->student_id->lookupCacheOption($curVal);
            } else {
                $this->student_id->ViewValue = $this->student_id->Lookup !== null && is_array($this->student_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->student_id->ViewValue !== null) { // Load from cache
                $this->student_id->EditValue = array_values($this->student_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`id`", "=", $this->student_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->student_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->student_id->EditValue = $arwrk;
            }
            $this->student_id->PlaceHolder = RemoveHtml($this->student_id->caption());

            // teacher_id
            $this->teacher_id->setupEditAttributes();
            $curVal = trim(strval($this->teacher_id->CurrentValue));
            if ($curVal != "") {
                $this->teacher_id->ViewValue = $this->teacher_id->lookupCacheOption($curVal);
            } else {
                $this->teacher_id->ViewValue = $this->teacher_id->Lookup !== null && is_array($this->teacher_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->teacher_id->ViewValue !== null) { // Load from cache
                $this->teacher_id->EditValue = array_values($this->teacher_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`id`", "=", $this->teacher_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->teacher_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->teacher_id->EditValue = $arwrk;
            }
            $this->teacher_id->PlaceHolder = RemoveHtml($this->teacher_id->caption());

            // topic_id
            $this->topic_id->setupEditAttributes();
            $curVal = trim(strval($this->topic_id->CurrentValue));
            if ($curVal != "") {
                $this->topic_id->ViewValue = $this->topic_id->lookupCacheOption($curVal);
            } else {
                $this->topic_id->ViewValue = $this->topic_id->Lookup !== null && is_array($this->topic_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->topic_id->ViewValue !== null) { // Load from cache
                $this->topic_id->EditValue = array_values($this->topic_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`id`", "=", $this->topic_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->topic_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->topic_id->EditValue = $arwrk;
            }
            $this->topic_id->PlaceHolder = RemoveHtml($this->topic_id->caption());

            // date
            $this->date->setupEditAttributes();
            $this->date->EditValue = HtmlEncode(FormatDateTime($this->date->CurrentValue, $this->date->formatPattern()));
            $this->date->PlaceHolder = RemoveHtml($this->date->caption());

            // time
            $this->time->setupEditAttributes();
            if (!$this->time->Raw) {
                $this->time->CurrentValue = HtmlDecode($this->time->CurrentValue);
            }
            $this->time->EditValue = HtmlEncode($this->time->CurrentValue);
            $this->time->PlaceHolder = RemoveHtml($this->time->caption());

            // fees
            $this->fees->setupEditAttributes();
            $this->fees->EditValue = HtmlEncode($this->fees->CurrentValue);
            $this->fees->PlaceHolder = RemoveHtml($this->fees->caption());
            if (strval($this->fees->EditValue) != "" && is_numeric($this->fees->EditValue)) {
                $this->fees->EditValue = $this->fees->EditValue;
            }

            // currency_id
            $this->currency_id->setupEditAttributes();
            $curVal = trim(strval($this->currency_id->CurrentValue));
            if ($curVal != "") {
                $this->currency_id->ViewValue = $this->currency_id->lookupCacheOption($curVal);
            } else {
                $this->currency_id->ViewValue = $this->currency_id->Lookup !== null && is_array($this->currency_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->currency_id->ViewValue !== null) { // Load from cache
                $this->currency_id->EditValue = array_values($this->currency_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`id`", "=", $this->currency_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->currency_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->currency_id->EditValue = $arwrk;
            }
            $this->currency_id->PlaceHolder = RemoveHtml($this->currency_id->caption());

            // status
            $this->status->setupEditAttributes();
            $this->status->EditValue = $this->status->options(true);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // meeting_id
            $this->meeting_id->setupEditAttributes();
            if (!$this->meeting_id->Raw) {
                $this->meeting_id->CurrentValue = HtmlDecode($this->meeting_id->CurrentValue);
            }
            $this->meeting_id->EditValue = HtmlEncode($this->meeting_id->CurrentValue);
            $this->meeting_id->PlaceHolder = RemoveHtml($this->meeting_id->caption());

            // package_id
            $this->package_id->setupEditAttributes();
            $this->package_id->EditValue = HtmlEncode($this->package_id->CurrentValue);
            $this->package_id->PlaceHolder = RemoveHtml($this->package_id->caption());
            if (strval($this->package_id->EditValue) != "" && is_numeric($this->package_id->EditValue)) {
                $this->package_id->EditValue = $this->package_id->EditValue;
            }

            // Add refer script

            // id
            $this->id->HrefValue = "";

            // student_id
            $this->student_id->HrefValue = "";

            // teacher_id
            $this->teacher_id->HrefValue = "";

            // topic_id
            $this->topic_id->HrefValue = "";

            // date
            $this->date->HrefValue = "";

            // time
            $this->time->HrefValue = "";

            // fees
            $this->fees->HrefValue = "";

            // currency_id
            $this->currency_id->HrefValue = "";

            // status
            $this->status->HrefValue = "";

            // meeting_id
            $this->meeting_id->HrefValue = "";

            // package_id
            $this->package_id->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditValue = $this->id->CurrentValue;

            // student_id
            $this->student_id->setupEditAttributes();
            $curVal = trim(strval($this->student_id->CurrentValue));
            if ($curVal != "") {
                $this->student_id->ViewValue = $this->student_id->lookupCacheOption($curVal);
            } else {
                $this->student_id->ViewValue = $this->student_id->Lookup !== null && is_array($this->student_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->student_id->ViewValue !== null) { // Load from cache
                $this->student_id->EditValue = array_values($this->student_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`id`", "=", $this->student_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->student_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->student_id->EditValue = $arwrk;
            }
            $this->student_id->PlaceHolder = RemoveHtml($this->student_id->caption());

            // teacher_id
            $this->teacher_id->setupEditAttributes();
            $curVal = trim(strval($this->teacher_id->CurrentValue));
            if ($curVal != "") {
                $this->teacher_id->ViewValue = $this->teacher_id->lookupCacheOption($curVal);
            } else {
                $this->teacher_id->ViewValue = $this->teacher_id->Lookup !== null && is_array($this->teacher_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->teacher_id->ViewValue !== null) { // Load from cache
                $this->teacher_id->EditValue = array_values($this->teacher_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`id`", "=", $this->teacher_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->teacher_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->teacher_id->EditValue = $arwrk;
            }
            $this->teacher_id->PlaceHolder = RemoveHtml($this->teacher_id->caption());

            // topic_id
            $this->topic_id->setupEditAttributes();
            $curVal = trim(strval($this->topic_id->CurrentValue));
            if ($curVal != "") {
                $this->topic_id->ViewValue = $this->topic_id->lookupCacheOption($curVal);
            } else {
                $this->topic_id->ViewValue = $this->topic_id->Lookup !== null && is_array($this->topic_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->topic_id->ViewValue !== null) { // Load from cache
                $this->topic_id->EditValue = array_values($this->topic_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`id`", "=", $this->topic_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->topic_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->topic_id->EditValue = $arwrk;
            }
            $this->topic_id->PlaceHolder = RemoveHtml($this->topic_id->caption());

            // date
            $this->date->setupEditAttributes();
            $this->date->EditValue = HtmlEncode(FormatDateTime($this->date->CurrentValue, $this->date->formatPattern()));
            $this->date->PlaceHolder = RemoveHtml($this->date->caption());

            // time
            $this->time->setupEditAttributes();
            if (!$this->time->Raw) {
                $this->time->CurrentValue = HtmlDecode($this->time->CurrentValue);
            }
            $this->time->EditValue = HtmlEncode($this->time->CurrentValue);
            $this->time->PlaceHolder = RemoveHtml($this->time->caption());

            // fees
            $this->fees->setupEditAttributes();
            $this->fees->EditValue = HtmlEncode($this->fees->CurrentValue);
            $this->fees->PlaceHolder = RemoveHtml($this->fees->caption());
            if (strval($this->fees->EditValue) != "" && is_numeric($this->fees->EditValue)) {
                $this->fees->EditValue = $this->fees->EditValue;
            }

            // currency_id
            $this->currency_id->setupEditAttributes();
            $curVal = trim(strval($this->currency_id->CurrentValue));
            if ($curVal != "") {
                $this->currency_id->ViewValue = $this->currency_id->lookupCacheOption($curVal);
            } else {
                $this->currency_id->ViewValue = $this->currency_id->Lookup !== null && is_array($this->currency_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->currency_id->ViewValue !== null) { // Load from cache
                $this->currency_id->EditValue = array_values($this->currency_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`id`", "=", $this->currency_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->currency_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->currency_id->EditValue = $arwrk;
            }
            $this->currency_id->PlaceHolder = RemoveHtml($this->currency_id->caption());

            // status
            $this->status->setupEditAttributes();
            $this->status->EditValue = $this->status->options(true);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // meeting_id
            $this->meeting_id->setupEditAttributes();
            if (!$this->meeting_id->Raw) {
                $this->meeting_id->CurrentValue = HtmlDecode($this->meeting_id->CurrentValue);
            }
            $this->meeting_id->EditValue = HtmlEncode($this->meeting_id->CurrentValue);
            $this->meeting_id->PlaceHolder = RemoveHtml($this->meeting_id->caption());

            // package_id
            $this->package_id->setupEditAttributes();
            $this->package_id->EditValue = HtmlEncode($this->package_id->CurrentValue);
            $this->package_id->PlaceHolder = RemoveHtml($this->package_id->caption());
            if (strval($this->package_id->EditValue) != "" && is_numeric($this->package_id->EditValue)) {
                $this->package_id->EditValue = $this->package_id->EditValue;
            }

            // Edit refer script

            // id
            $this->id->HrefValue = "";

            // student_id
            $this->student_id->HrefValue = "";

            // teacher_id
            $this->teacher_id->HrefValue = "";

            // topic_id
            $this->topic_id->HrefValue = "";

            // date
            $this->date->HrefValue = "";

            // time
            $this->time->HrefValue = "";

            // fees
            $this->fees->HrefValue = "";

            // currency_id
            $this->currency_id->HrefValue = "";

            // status
            $this->status->HrefValue = "";

            // meeting_id
            $this->meeting_id->HrefValue = "";

            // package_id
            $this->package_id->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language, $Security;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->student_id->Required) {
            if (!$this->student_id->IsDetailKey && EmptyValue($this->student_id->FormValue)) {
                $this->student_id->addErrorMessage(str_replace("%s", $this->student_id->caption(), $this->student_id->RequiredErrorMessage));
            }
        }
        if ($this->teacher_id->Required) {
            if (!$this->teacher_id->IsDetailKey && EmptyValue($this->teacher_id->FormValue)) {
                $this->teacher_id->addErrorMessage(str_replace("%s", $this->teacher_id->caption(), $this->teacher_id->RequiredErrorMessage));
            }
        }
        if ($this->topic_id->Required) {
            if (!$this->topic_id->IsDetailKey && EmptyValue($this->topic_id->FormValue)) {
                $this->topic_id->addErrorMessage(str_replace("%s", $this->topic_id->caption(), $this->topic_id->RequiredErrorMessage));
            }
        }
        if ($this->date->Required) {
            if (!$this->date->IsDetailKey && EmptyValue($this->date->FormValue)) {
                $this->date->addErrorMessage(str_replace("%s", $this->date->caption(), $this->date->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->date->FormValue, $this->date->formatPattern())) {
            $this->date->addErrorMessage($this->date->getErrorMessage(false));
        }
        if ($this->time->Required) {
            if (!$this->time->IsDetailKey && EmptyValue($this->time->FormValue)) {
                $this->time->addErrorMessage(str_replace("%s", $this->time->caption(), $this->time->RequiredErrorMessage));
            }
        }
        if ($this->fees->Required) {
            if (!$this->fees->IsDetailKey && EmptyValue($this->fees->FormValue)) {
                $this->fees->addErrorMessage(str_replace("%s", $this->fees->caption(), $this->fees->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->fees->FormValue)) {
            $this->fees->addErrorMessage($this->fees->getErrorMessage(false));
        }
        if ($this->currency_id->Required) {
            if (!$this->currency_id->IsDetailKey && EmptyValue($this->currency_id->FormValue)) {
                $this->currency_id->addErrorMessage(str_replace("%s", $this->currency_id->caption(), $this->currency_id->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->meeting_id->Required) {
            if (!$this->meeting_id->IsDetailKey && EmptyValue($this->meeting_id->FormValue)) {
                $this->meeting_id->addErrorMessage(str_replace("%s", $this->meeting_id->caption(), $this->meeting_id->RequiredErrorMessage));
            }
        }
        if ($this->package_id->Required) {
            if (!$this->package_id->IsDetailKey && EmptyValue($this->package_id->FormValue)) {
                $this->package_id->addErrorMessage(str_replace("%s", $this->package_id->caption(), $this->package_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->package_id->FormValue)) {
            $this->package_id->addErrorMessage($this->package_id->getErrorMessage(false));
        }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['id'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
                if (!$deleteRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        return $deleteRows;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
        }

        // Set new row
        $rsnew = [];

        // student_id
        $this->student_id->setDbValueDef($rsnew, $this->student_id->CurrentValue, 0, $this->student_id->ReadOnly);

        // teacher_id
        $this->teacher_id->setDbValueDef($rsnew, $this->teacher_id->CurrentValue, 0, $this->teacher_id->ReadOnly);

        // topic_id
        $this->topic_id->setDbValueDef($rsnew, $this->topic_id->CurrentValue, null, $this->topic_id->ReadOnly);

        // date
        $this->date->setDbValueDef($rsnew, UnFormatDateTime($this->date->CurrentValue, $this->date->formatPattern()), null, $this->date->ReadOnly);

        // time
        $this->time->setDbValueDef($rsnew, $this->time->CurrentValue, null, $this->time->ReadOnly);

        // fees
        $this->fees->setDbValueDef($rsnew, $this->fees->CurrentValue, 0, $this->fees->ReadOnly);

        // currency_id
        $this->currency_id->setDbValueDef($rsnew, $this->currency_id->CurrentValue, 0, $this->currency_id->ReadOnly);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, "", $this->status->ReadOnly);

        // meeting_id
        $this->meeting_id->setDbValueDef($rsnew, $this->meeting_id->CurrentValue, null, $this->meeting_id->ReadOnly);

        // package_id
        $this->package_id->setDbValueDef($rsnew, $this->package_id->CurrentValue, null, $this->package_id->ReadOnly);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
                if (!$editRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }
        return $editRow;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session

        // Set new row
        $rsnew = [];

        // student_id
        $this->student_id->setDbValueDef($rsnew, $this->student_id->CurrentValue, 0, false);

        // teacher_id
        $this->teacher_id->setDbValueDef($rsnew, $this->teacher_id->CurrentValue, 0, false);

        // topic_id
        $this->topic_id->setDbValueDef($rsnew, $this->topic_id->CurrentValue, null, false);

        // date
        $this->date->setDbValueDef($rsnew, UnFormatDateTime($this->date->CurrentValue, $this->date->formatPattern()), null, false);

        // time
        $this->time->setDbValueDef($rsnew, $this->time->CurrentValue, null, false);

        // fees
        $this->fees->setDbValueDef($rsnew, $this->fees->CurrentValue, 0, false);

        // currency_id
        $this->currency_id->setDbValueDef($rsnew, $this->currency_id->CurrentValue, 0, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, "", strval($this->status->CurrentValue) == "");

        // meeting_id
        $this->meeting_id->setDbValueDef($rsnew, $this->meeting_id->CurrentValue, null, false);

        // package_id
        $this->package_id->setDbValueDef($rsnew, $this->package_id->CurrentValue, null, false);

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            } elseif (!EmptyValue($this->DbErrorMessage)) { // Show database error
                $this->setFailureMessage($this->DbErrorMessage);
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }
        return $addRow;
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_student_id":
                    break;
                case "x_teacher_id":
                    break;
                case "x_topic_id":
                    break;
                case "x_currency_id":
                    break;
                case "x_status":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0 && count($fld->Lookup->FilterFields) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $key = $row["lf"];
                    if (IsFloatType($fld->Type)) { // Handle float field
                        $key = (float)$key;
                    }
                    $ar[strval($key)] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
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
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"break-after:page;\"></div>"; // Modify page break content
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }
}
