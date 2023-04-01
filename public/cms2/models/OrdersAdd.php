<?php

namespace PHPMaker2023\hih71;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class OrdersAdd extends Orders
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "OrdersAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "OrdersAdd";

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
        $this->TableVar = 'orders';
        $this->TableName = 'orders';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (orders)
        if (!isset($GLOBALS["orders"]) || get_class($GLOBALS["orders"]) == PROJECT_NAMESPACE . "orders") {
            $GLOBALS["orders"] = &$this;
        }

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
                    $result["view"] = $pageName == "OrdersView"; // If View page, no primary button
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
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $CopyRecord;

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
        $this->id->Visible = false;
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

        // Set up lookup cache
        $this->setupLookupOptions($this->student_id);
        $this->setupLookupOptions($this->teacher_id);
        $this->setupLookupOptions($this->topic_id);
        $this->setupLookupOptions($this->currency_id);
        $this->setupLookupOptions($this->status);

        // Load default values for add
        $this->loadDefaultValues();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action", "") !== "") {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
                $this->setKey($this->OldKey); // Set up record key
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record or default values
        $rsold = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$rsold) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("OrdersList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "OrdersList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "OrdersView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "OrdersList") {
                            Container("flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "OrdersList"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->IsModal && $this->UseAjaxActions) { // Return JSON error message
                    WriteJson([ "success" => false, "error" => $this->getFailureMessage() ]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
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
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'student_id' first before field var 'x_student_id'
        $val = $CurrentForm->hasValue("student_id") ? $CurrentForm->getValue("student_id") : $CurrentForm->getValue("x_student_id");
        if (!$this->student_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->student_id->Visible = false; // Disable update for API request
            } else {
                $this->student_id->setFormValue($val);
            }
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

        // Check field name 'topic_id' first before field var 'x_topic_id'
        $val = $CurrentForm->hasValue("topic_id") ? $CurrentForm->getValue("topic_id") : $CurrentForm->getValue("x_topic_id");
        if (!$this->topic_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->topic_id->Visible = false; // Disable update for API request
            } else {
                $this->topic_id->setFormValue($val);
            }
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

        // Check field name 'time' first before field var 'x_time'
        $val = $CurrentForm->hasValue("time") ? $CurrentForm->getValue("time") : $CurrentForm->getValue("x_time");
        if (!$this->time->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->time->Visible = false; // Disable update for API request
            } else {
                $this->time->setFormValue($val);
            }
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

        // Check field name 'currency_id' first before field var 'x_currency_id'
        $val = $CurrentForm->hasValue("currency_id") ? $CurrentForm->getValue("currency_id") : $CurrentForm->getValue("x_currency_id");
        if (!$this->currency_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->currency_id->Visible = false; // Disable update for API request
            } else {
                $this->currency_id->setFormValue($val);
            }
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

        // Check field name 'meeting_id' first before field var 'x_meeting_id'
        $val = $CurrentForm->hasValue("meeting_id") ? $CurrentForm->getValue("meeting_id") : $CurrentForm->getValue("x_meeting_id");
        if (!$this->meeting_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->meeting_id->Visible = false; // Disable update for API request
            } else {
                $this->meeting_id->setFormValue($val);
            }
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

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id
        $this->id->RowCssClass = "row";

        // student_id
        $this->student_id->RowCssClass = "row";

        // teacher_id
        $this->teacher_id->RowCssClass = "row";

        // topic_id
        $this->topic_id->RowCssClass = "row";

        // date
        $this->date->RowCssClass = "row";

        // time
        $this->time->RowCssClass = "row";

        // fees
        $this->fees->RowCssClass = "row";

        // currency_id
        $this->currency_id->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // meeting_id
        $this->meeting_id->RowCssClass = "row";

        // created_at
        $this->created_at->RowCssClass = "row";

        // updated_at
        $this->updated_at->RowCssClass = "row";

        // package_id
        $this->package_id->RowCssClass = "row";

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
            $this->fees->ViewValue = FormatNumber($this->fees->ViewValue, $this->fees->formatPattern());

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
        } elseif ($this->RowType == ROWTYPE_ADD) {
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
                $this->fees->EditValue = FormatNumber($this->fees->EditValue, null);
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
        if (!CheckNumber($this->fees->FormValue)) {
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

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

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("OrdersList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
}
