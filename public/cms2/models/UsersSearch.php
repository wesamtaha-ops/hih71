<?php

namespace PHPMaker2023\hih71;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class UsersSearch extends Users
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "UsersSearch";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "UsersSearch";

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
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'users';
        $this->TableName = 'users';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-search-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (users)
        if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == PROJECT_NAMESPACE . "users") {
            $GLOBALS["users"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'users');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
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

        // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

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

            // Handle modal response (Assume return to modal for simplicity)
            if ($this->IsModal) { // Show as modal
                $result = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page => View page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = $pageName == "UsersView"; // If View page, no primary button
                } else { // List page
                    // $result["list"] = $this->PageID == "search"; // Refresh List page if current page is Search page
                    $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                    $this->clearFailureMessage();
                }
                WriteJson($result);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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
                $this->image->OldUploadPath = $this->image->getUploadPath(); // PHP
                $this->image->UploadPath = $this->image->OldUploadPath;
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
    public $FormClassName = "ew-form ew-search-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $UserProfile, $Language, $Security, $CurrentForm, $SkipHeaderFooter;

        // Is modal
        $this->IsModal = ConvertToBool(Param("modal"));
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->name->setVisibility();
        $this->_email->setVisibility();
        $this->email_verified_at->Visible = false;
        $this->_password->setVisibility();
        $this->phone->setVisibility();
        $this->gender->setVisibility();
        $this->birthday->setVisibility();
        $this->image->setVisibility();
        $this->country_id->setVisibility();
        $this->city->setVisibility();
        $this->currency_id->setVisibility();
        $this->type->setVisibility();
        $this->is_verified->setVisibility();
        $this->is_approved->setVisibility();
        $this->is_blocked->setVisibility();
        $this->otp->setVisibility();
        $this->slug->setVisibility();
        $this->remember_token->setVisibility();
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
        $this->rate->setVisibility();

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

        // Set up lookup cache
        $this->setupLookupOptions($this->gender);
        $this->setupLookupOptions($this->country_id);
        $this->setupLookupOptions($this->currency_id);
        $this->setupLookupOptions($this->type);
        $this->setupLookupOptions($this->is_verified);
        $this->setupLookupOptions($this->is_approved);
        $this->setupLookupOptions($this->is_blocked);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;

        // Get action
        $this->CurrentAction = Post("action");
        if ($this->isSearch()) {
            // Build search string for advanced search, remove blank field
            $this->loadSearchValues(); // Get search values
            $srchStr = $this->validateSearch() ? $this->buildAdvancedSearch() : "";
            if ($srchStr != "") {
                $srchStr = "UsersList" . "?" . $srchStr;
                // Do not return Json for UseAjaxActions
                if ($this->IsModal && $this->UseAjaxActions) {
                    $this->IsModal = false;
                }
                $this->terminate($srchStr); // Go to list page
                return;
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Render row for search
        $this->RowType = ROWTYPE_SEARCH;
        $this->resetAttributes();
        $this->renderRow();

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

    // Build advanced search
    protected function buildAdvancedSearch()
    {
        $srchUrl = "";
        $this->buildSearchUrl($srchUrl, $this->id); // id
        $this->buildSearchUrl($srchUrl, $this->name); // name
        $this->buildSearchUrl($srchUrl, $this->_email); // email
        $this->buildSearchUrl($srchUrl, $this->_password); // password
        $this->buildSearchUrl($srchUrl, $this->phone); // phone
        $this->buildSearchUrl($srchUrl, $this->gender); // gender
        $this->buildSearchUrl($srchUrl, $this->birthday); // birthday
        $this->buildSearchUrl($srchUrl, $this->image); // image
        $this->buildSearchUrl($srchUrl, $this->country_id); // country_id
        $this->buildSearchUrl($srchUrl, $this->city); // city
        $this->buildSearchUrl($srchUrl, $this->currency_id); // currency_id
        $this->buildSearchUrl($srchUrl, $this->type); // type
        $this->buildSearchUrl($srchUrl, $this->is_verified); // is_verified
        $this->buildSearchUrl($srchUrl, $this->is_approved); // is_approved
        $this->buildSearchUrl($srchUrl, $this->is_blocked); // is_blocked
        $this->buildSearchUrl($srchUrl, $this->otp); // otp
        $this->buildSearchUrl($srchUrl, $this->slug); // slug
        $this->buildSearchUrl($srchUrl, $this->remember_token); // remember_token
        $this->buildSearchUrl($srchUrl, $this->rate); // rate
        if ($srchUrl != "") {
            $srchUrl .= "&";
        }
        $srchUrl .= "cmd=search";
        return $srchUrl;
    }

    // Build search URL
    protected function buildSearchUrl(&$url, $fld, $oprOnly = false)
    {
        global $CurrentForm;
        $wrk = "";
        $fldParm = $fld->Param;
        [
            "value" => $fldVal,
            "operator" => $fldOpr,
            "condition" => $fldCond,
            "value2" => $fldVal2,
            "operator2" => $fldOpr2
        ] = $CurrentForm->getSearchValues($fldParm);
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldDataType = $fld->DataType;
        $value = ConvertSearchValue($fldVal, $fldOpr, $fld); // For testing if numeric only
        $value2 = ConvertSearchValue($fldVal2, $fldOpr2, $fld); // For testing if numeric only
        $fldOpr = ConvertSearchOperator($fldOpr, $fld, $value);
        $fldOpr2 = ConvertSearchOperator($fldOpr2, $fld, $value2);
        if (in_array($fldOpr, ["BETWEEN", "NOT BETWEEN"])) {
            $isValidValue = $fldDataType != DATATYPE_NUMBER || $fld->VirtualSearch || IsNumericSearchValue($value, $fldOpr, $fld) && IsNumericSearchValue($value2, $fldOpr2, $fld);
            if ($fldVal != "" && $fldVal2 != "" && $isValidValue) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) . "&y_" . $fldParm . "=" . urlencode($fldVal2) . "&z_" . $fldParm . "=" . urlencode($fldOpr);
            }
        } else {
            $isValidValue = $fldDataType != DATATYPE_NUMBER || $fld->VirtualSearch || IsNumericSearchValue($value, $fldOpr, $fld);
            if ($fldVal != "" && $isValidValue && IsValidOperator($fldOpr)) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) . "&z_" . $fldParm . "=" . urlencode($fldOpr);
            } elseif (in_array($fldOpr, ["IS NULL", "IS NOT NULL", "IS EMPTY", "IS NOT EMPTY"]) || ($fldOpr != "" && $oprOnly && IsValidOperator($fldOpr))) {
                $wrk = "z_" . $fldParm . "=" . urlencode($fldOpr);
            }
            $isValidValue = $fldDataType != DATATYPE_NUMBER || $fld->VirtualSearch || IsNumericSearchValue($value2, $fldOpr2, $fld);
            if ($fldVal2 != "" && $isValidValue && IsValidOperator($fldOpr2)) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "y_" . $fldParm . "=" . urlencode($fldVal2) . "&w_" . $fldParm . "=" . urlencode($fldOpr2);
            } elseif (in_array($fldOpr2, ["IS NULL", "IS NOT NULL", "IS EMPTY", "IS NOT EMPTY"]) || ($fldOpr2 != "" && $oprOnly && IsValidOperator($fldOpr2))) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "w_" . $fldParm . "=" . urlencode($fldOpr2);
            }
        }
        if ($wrk != "") {
            if ($url != "") {
                $url .= "&";
            }
            $url .= $wrk;
        }
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // id
        if ($this->id->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // name
        if ($this->name->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // email
        if ($this->_email->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // password
        if ($this->_password->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // phone
        if ($this->phone->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // gender
        if ($this->gender->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // birthday
        if ($this->birthday->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // image
        if ($this->image->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // country_id
        if ($this->country_id->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // city
        if ($this->city->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // currency_id
        if ($this->currency_id->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // type
        if ($this->type->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // is_verified
        if ($this->is_verified->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // is_approved
        if ($this->is_approved->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // is_blocked
        if ($this->is_blocked->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // otp
        if ($this->otp->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // slug
        if ($this->slug->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // remember_token
        if ($this->remember_token->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // rate
        if ($this->rate->AdvancedSearch->get()) {
            $hasValue = true;
        }
        return $hasValue;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id
        $this->id->RowCssClass = "row";

        // name
        $this->name->RowCssClass = "row";

        // email
        $this->_email->RowCssClass = "row";

        // email_verified_at
        $this->email_verified_at->RowCssClass = "row";

        // password
        $this->_password->RowCssClass = "row";

        // phone
        $this->phone->RowCssClass = "row";

        // gender
        $this->gender->RowCssClass = "row";

        // birthday
        $this->birthday->RowCssClass = "row";

        // image
        $this->image->RowCssClass = "row";

        // country_id
        $this->country_id->RowCssClass = "row";

        // city
        $this->city->RowCssClass = "row";

        // currency_id
        $this->currency_id->RowCssClass = "row";

        // type
        $this->type->RowCssClass = "row";

        // is_verified
        $this->is_verified->RowCssClass = "row";

        // is_approved
        $this->is_approved->RowCssClass = "row";

        // is_blocked
        $this->is_blocked->RowCssClass = "row";

        // otp
        $this->otp->RowCssClass = "row";

        // slug
        $this->slug->RowCssClass = "row";

        // remember_token
        $this->remember_token->RowCssClass = "row";

        // created_at
        $this->created_at->RowCssClass = "row";

        // updated_at
        $this->updated_at->RowCssClass = "row";

        // rate
        $this->rate->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;

            // name
            $this->name->ViewValue = $this->name->CurrentValue;

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;

            // password
            $this->_password->ViewValue = $this->_password->CurrentValue;

            // phone
            $this->phone->ViewValue = $this->phone->CurrentValue;

            // gender
            if (strval($this->gender->CurrentValue) != "") {
                $this->gender->ViewValue = $this->gender->optionCaption($this->gender->CurrentValue);
            } else {
                $this->gender->ViewValue = null;
            }

            // birthday
            $this->birthday->ViewValue = $this->birthday->CurrentValue;
            $this->birthday->ViewValue = FormatDateTime($this->birthday->ViewValue, $this->birthday->formatPattern());

            // image
            $this->image->UploadPath = $this->image->getUploadPath(); // PHP
            if (!EmptyValue($this->image->Upload->DbValue)) {
                $this->image->ImageWidth = 100;
                $this->image->ImageHeight = 0;
                $this->image->ImageAlt = $this->image->alt();
                $this->image->ImageCssClass = "ew-image";
                $this->image->ViewValue = $this->image->Upload->DbValue;
            } else {
                $this->image->ViewValue = "";
            }

            // country_id
            $curVal = strval($this->country_id->CurrentValue);
            if ($curVal != "") {
                $this->country_id->ViewValue = $this->country_id->lookupCacheOption($curVal);
                if ($this->country_id->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`id`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->country_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->country_id->Lookup->renderViewRow($rswrk[0]);
                        $this->country_id->ViewValue = $this->country_id->displayValue($arwrk);
                    } else {
                        $this->country_id->ViewValue = $this->country_id->CurrentValue;
                    }
                }
            } else {
                $this->country_id->ViewValue = null;
            }

            // city
            $this->city->ViewValue = $this->city->CurrentValue;

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

            // type
            if (strval($this->type->CurrentValue) != "") {
                $this->type->ViewValue = $this->type->optionCaption($this->type->CurrentValue);
            } else {
                $this->type->ViewValue = null;
            }

            // is_verified
            if (ConvertToBool($this->is_verified->CurrentValue)) {
                $this->is_verified->ViewValue = $this->is_verified->tagCaption(2) != "" ? $this->is_verified->tagCaption(2) : "yes";
            } else {
                $this->is_verified->ViewValue = $this->is_verified->tagCaption(1) != "" ? $this->is_verified->tagCaption(1) : "no";
            }

            // is_approved
            if (ConvertToBool($this->is_approved->CurrentValue)) {
                $this->is_approved->ViewValue = $this->is_approved->tagCaption(2) != "" ? $this->is_approved->tagCaption(2) : "yes";
            } else {
                $this->is_approved->ViewValue = $this->is_approved->tagCaption(1) != "" ? $this->is_approved->tagCaption(1) : "no";
            }

            // is_blocked
            if (ConvertToBool($this->is_blocked->CurrentValue)) {
                $this->is_blocked->ViewValue = $this->is_blocked->tagCaption(2) != "" ? $this->is_blocked->tagCaption(2) : "yes";
            } else {
                $this->is_blocked->ViewValue = $this->is_blocked->tagCaption(1) != "" ? $this->is_blocked->tagCaption(1) : "no";
            }

            // otp
            $this->otp->ViewValue = $this->otp->CurrentValue;

            // slug
            $this->slug->ViewValue = $this->slug->CurrentValue;

            // remember_token
            $this->remember_token->ViewValue = $this->remember_token->CurrentValue;

            // rate
            $this->rate->ViewValue = $this->rate->CurrentValue;
            $this->rate->ViewValue = FormatNumber($this->rate->ViewValue, $this->rate->formatPattern());

            // id
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // name
            $this->name->HrefValue = "";
            $this->name->TooltipValue = "";

            // email
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";

            // password
            $this->_password->HrefValue = "";
            $this->_password->TooltipValue = "";

            // phone
            $this->phone->HrefValue = "";
            $this->phone->TooltipValue = "";

            // gender
            $this->gender->HrefValue = "";
            $this->gender->TooltipValue = "";

            // birthday
            $this->birthday->HrefValue = "";
            $this->birthday->TooltipValue = "";

            // image
            $this->image->UploadPath = $this->image->getUploadPath(); // PHP
            if (!EmptyValue($this->image->Upload->DbValue)) {
                $this->image->HrefValue = GetFileUploadUrl($this->image, $this->image->htmlDecode($this->image->Upload->DbValue)); // Add prefix/suffix
                $this->image->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->image->HrefValue = FullUrl($this->image->HrefValue, "href");
                }
            } else {
                $this->image->HrefValue = "";
            }
            $this->image->ExportHrefValue = $this->image->UploadPath . $this->image->Upload->DbValue;
            $this->image->TooltipValue = "";
            if ($this->image->UseColorbox) {
                if (EmptyValue($this->image->TooltipValue)) {
                    $this->image->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->image->LinkAttrs["data-rel"] = "users_x_image";
                $this->image->LinkAttrs->appendClass("ew-lightbox");
            }

            // country_id
            $this->country_id->HrefValue = "";
            $this->country_id->TooltipValue = "";

            // city
            $this->city->HrefValue = "";
            $this->city->TooltipValue = "";

            // currency_id
            $this->currency_id->HrefValue = "";
            $this->currency_id->TooltipValue = "";

            // type
            $this->type->HrefValue = "";
            $this->type->TooltipValue = "";

            // is_verified
            $this->is_verified->HrefValue = "";
            $this->is_verified->TooltipValue = "";

            // is_approved
            $this->is_approved->HrefValue = "";
            $this->is_approved->TooltipValue = "";

            // is_blocked
            $this->is_blocked->HrefValue = "";
            $this->is_blocked->TooltipValue = "";

            // otp
            $this->otp->HrefValue = "";
            $this->otp->TooltipValue = "";

            // slug
            $this->slug->HrefValue = "";
            $this->slug->TooltipValue = "";

            // remember_token
            $this->remember_token->HrefValue = "";
            $this->remember_token->TooltipValue = "";

            // rate
            $this->rate->HrefValue = "";
            $this->rate->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditValue = HtmlEncode($this->id->AdvancedSearch->SearchValue);
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // name
            $this->name->setupEditAttributes();
            if (!$this->name->Raw) {
                $this->name->AdvancedSearch->SearchValue = HtmlDecode($this->name->AdvancedSearch->SearchValue);
            }
            $this->name->EditValue = HtmlEncode($this->name->AdvancedSearch->SearchValue);
            $this->name->PlaceHolder = RemoveHtml($this->name->caption());

            // email
            $this->_email->setupEditAttributes();
            if (!$this->_email->Raw) {
                $this->_email->AdvancedSearch->SearchValue = HtmlDecode($this->_email->AdvancedSearch->SearchValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->AdvancedSearch->SearchValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // password
            $this->_password->setupEditAttributes();
            if (!$this->_password->Raw) {
                $this->_password->AdvancedSearch->SearchValue = HtmlDecode($this->_password->AdvancedSearch->SearchValue);
            }
            $this->_password->EditValue = HtmlEncode($this->_password->AdvancedSearch->SearchValue);
            $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

            // phone
            $this->phone->setupEditAttributes();
            if (!$this->phone->Raw) {
                $this->phone->AdvancedSearch->SearchValue = HtmlDecode($this->phone->AdvancedSearch->SearchValue);
            }
            $this->phone->EditValue = HtmlEncode($this->phone->AdvancedSearch->SearchValue);
            $this->phone->PlaceHolder = RemoveHtml($this->phone->caption());

            // gender
            $this->gender->setupEditAttributes();
            $this->gender->EditValue = $this->gender->options(true);
            $this->gender->PlaceHolder = RemoveHtml($this->gender->caption());

            // birthday
            $this->birthday->setupEditAttributes();
            $this->birthday->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->birthday->AdvancedSearch->SearchValue, $this->birthday->formatPattern()), $this->birthday->formatPattern()));
            $this->birthday->PlaceHolder = RemoveHtml($this->birthday->caption());

            // image
            $this->image->setupEditAttributes();
            if (!$this->image->Raw) {
                $this->image->AdvancedSearch->SearchValue = HtmlDecode($this->image->AdvancedSearch->SearchValue);
            }
            $this->image->EditValue = HtmlEncode($this->image->AdvancedSearch->SearchValue);
            $this->image->PlaceHolder = RemoveHtml($this->image->caption());

            // country_id
            $this->country_id->setupEditAttributes();
            $curVal = trim(strval($this->country_id->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->country_id->AdvancedSearch->ViewValue = $this->country_id->lookupCacheOption($curVal);
            } else {
                $this->country_id->AdvancedSearch->ViewValue = $this->country_id->Lookup !== null && is_array($this->country_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->country_id->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->country_id->EditValue = array_values($this->country_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`id`", "=", $this->country_id->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->country_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->country_id->EditValue = $arwrk;
            }
            $this->country_id->PlaceHolder = RemoveHtml($this->country_id->caption());

            // city
            $this->city->setupEditAttributes();
            if (!$this->city->Raw) {
                $this->city->AdvancedSearch->SearchValue = HtmlDecode($this->city->AdvancedSearch->SearchValue);
            }
            $this->city->EditValue = HtmlEncode($this->city->AdvancedSearch->SearchValue);
            $this->city->PlaceHolder = RemoveHtml($this->city->caption());

            // currency_id
            $this->currency_id->setupEditAttributes();
            $curVal = trim(strval($this->currency_id->AdvancedSearch->SearchValue));
            if ($curVal != "") {
                $this->currency_id->AdvancedSearch->ViewValue = $this->currency_id->lookupCacheOption($curVal);
            } else {
                $this->currency_id->AdvancedSearch->ViewValue = $this->currency_id->Lookup !== null && is_array($this->currency_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->currency_id->AdvancedSearch->ViewValue !== null) { // Load from cache
                $this->currency_id->EditValue = array_values($this->currency_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`id`", "=", $this->currency_id->AdvancedSearch->SearchValue, DATATYPE_NUMBER, "");
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

            // type
            $this->type->EditValue = $this->type->options(false);
            $this->type->PlaceHolder = RemoveHtml($this->type->caption());

            // is_verified
            $this->is_verified->EditValue = $this->is_verified->options(false);
            $this->is_verified->PlaceHolder = RemoveHtml($this->is_verified->caption());

            // is_approved
            $this->is_approved->EditValue = $this->is_approved->options(false);
            $this->is_approved->PlaceHolder = RemoveHtml($this->is_approved->caption());

            // is_blocked
            $this->is_blocked->EditValue = $this->is_blocked->options(false);
            $this->is_blocked->PlaceHolder = RemoveHtml($this->is_blocked->caption());

            // otp
            $this->otp->setupEditAttributes();
            if (!$this->otp->Raw) {
                $this->otp->AdvancedSearch->SearchValue = HtmlDecode($this->otp->AdvancedSearch->SearchValue);
            }
            $this->otp->EditValue = HtmlEncode($this->otp->AdvancedSearch->SearchValue);
            $this->otp->PlaceHolder = RemoveHtml($this->otp->caption());

            // slug
            $this->slug->setupEditAttributes();
            if (!$this->slug->Raw) {
                $this->slug->AdvancedSearch->SearchValue = HtmlDecode($this->slug->AdvancedSearch->SearchValue);
            }
            $this->slug->EditValue = HtmlEncode($this->slug->AdvancedSearch->SearchValue);
            $this->slug->PlaceHolder = RemoveHtml($this->slug->caption());

            // remember_token
            $this->remember_token->setupEditAttributes();
            if (!$this->remember_token->Raw) {
                $this->remember_token->AdvancedSearch->SearchValue = HtmlDecode($this->remember_token->AdvancedSearch->SearchValue);
            }
            $this->remember_token->EditValue = HtmlEncode($this->remember_token->AdvancedSearch->SearchValue);
            $this->remember_token->PlaceHolder = RemoveHtml($this->remember_token->caption());

            // rate
            $this->rate->setupEditAttributes();
            $this->rate->EditValue = HtmlEncode($this->rate->AdvancedSearch->SearchValue);
            $this->rate->PlaceHolder = RemoveHtml($this->rate->caption());
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if (!CheckInteger($this->id->AdvancedSearch->SearchValue)) {
            $this->id->addErrorMessage($this->id->getErrorMessage(false));
        }
        if (!CheckDate($this->birthday->AdvancedSearch->SearchValue, $this->birthday->formatPattern())) {
            $this->birthday->addErrorMessage($this->birthday->getErrorMessage(false));
        }
        if (!CheckInteger($this->rate->AdvancedSearch->SearchValue)) {
            $this->rate->addErrorMessage($this->rate->getErrorMessage(false));
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->id->AdvancedSearch->load();
        $this->name->AdvancedSearch->load();
        $this->_email->AdvancedSearch->load();
        $this->_password->AdvancedSearch->load();
        $this->phone->AdvancedSearch->load();
        $this->gender->AdvancedSearch->load();
        $this->birthday->AdvancedSearch->load();
        $this->image->AdvancedSearch->load();
        $this->country_id->AdvancedSearch->load();
        $this->city->AdvancedSearch->load();
        $this->currency_id->AdvancedSearch->load();
        $this->type->AdvancedSearch->load();
        $this->is_verified->AdvancedSearch->load();
        $this->is_approved->AdvancedSearch->load();
        $this->is_blocked->AdvancedSearch->load();
        $this->otp->AdvancedSearch->load();
        $this->slug->AdvancedSearch->load();
        $this->remember_token->AdvancedSearch->load();
        $this->rate->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("UsersList"), "", $this->TableVar, true);
        $pageId = "search";
        $Breadcrumb->add("search", $pageId, $url);
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
                case "x_gender":
                    break;
                case "x_country_id":
                    break;
                case "x_currency_id":
                    break;
                case "x_type":
                    break;
                case "x_is_verified":
                    break;
                case "x_is_approved":
                    break;
                case "x_is_blocked":
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
}
