<?php

namespace PHPMaker2023\hih71;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class UsersAdd extends Users
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "UsersAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "UsersAdd";

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
        $this->TableVar = 'users';
        $this->TableName = 'users';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

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

        // Set up detail parameters
        $this->setupDetailParms();

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
                    $this->terminate("UsersList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    if ($this->getCurrentDetailTable() != "") { // Master/detail add
                        $returnUrl = $this->getDetailUrl();
                    } else {
                        $returnUrl = $this->getReturnUrl();
                    }
                    if (GetPageName($returnUrl) == "UsersList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "UsersView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "UsersList") {
                            Container("flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "UsersList"; // Return list page content
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

                    // Set up detail parameters
                    $this->setupDetailParms();
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
        $this->image->Upload->Index = $CurrentForm->Index;
        $this->image->Upload->uploadFile();
        $this->image->CurrentValue = $this->image->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->gender->DefaultValue = $this->gender->getDefault(); // PHP
        $this->gender->OldValue = $this->gender->DefaultValue;
        $this->type->DefaultValue = $this->type->getDefault(); // PHP
        $this->type->OldValue = $this->type->DefaultValue;
        $this->is_verified->DefaultValue = $this->is_verified->getDefault(); // PHP
        $this->is_verified->OldValue = $this->is_verified->DefaultValue;
        $this->is_approved->DefaultValue = $this->is_approved->getDefault(); // PHP
        $this->is_approved->OldValue = $this->is_approved->DefaultValue;
        $this->is_blocked->DefaultValue = $this->is_blocked->getDefault(); // PHP
        $this->is_blocked->OldValue = $this->is_blocked->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'name' first before field var 'x_name'
        $val = $CurrentForm->hasValue("name") ? $CurrentForm->getValue("name") : $CurrentForm->getValue("x_name");
        if (!$this->name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->name->Visible = false; // Disable update for API request
            } else {
                $this->name->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }

        // Check field name 'password' first before field var 'x__password'
        $val = $CurrentForm->hasValue("password") ? $CurrentForm->getValue("password") : $CurrentForm->getValue("x__password");
        if (!$this->_password->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_password->Visible = false; // Disable update for API request
            } else {
                $this->_password->setFormValue($val);
            }
        }

        // Check field name 'phone' first before field var 'x_phone'
        $val = $CurrentForm->hasValue("phone") ? $CurrentForm->getValue("phone") : $CurrentForm->getValue("x_phone");
        if (!$this->phone->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->phone->Visible = false; // Disable update for API request
            } else {
                $this->phone->setFormValue($val);
            }
        }

        // Check field name 'gender' first before field var 'x_gender'
        $val = $CurrentForm->hasValue("gender") ? $CurrentForm->getValue("gender") : $CurrentForm->getValue("x_gender");
        if (!$this->gender->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->gender->Visible = false; // Disable update for API request
            } else {
                $this->gender->setFormValue($val);
            }
        }

        // Check field name 'birthday' first before field var 'x_birthday'
        $val = $CurrentForm->hasValue("birthday") ? $CurrentForm->getValue("birthday") : $CurrentForm->getValue("x_birthday");
        if (!$this->birthday->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->birthday->Visible = false; // Disable update for API request
            } else {
                $this->birthday->setFormValue($val, true, $validate);
            }
            $this->birthday->CurrentValue = UnFormatDateTime($this->birthday->CurrentValue, $this->birthday->formatPattern());
        }

        // Check field name 'country_id' first before field var 'x_country_id'
        $val = $CurrentForm->hasValue("country_id") ? $CurrentForm->getValue("country_id") : $CurrentForm->getValue("x_country_id");
        if (!$this->country_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->country_id->Visible = false; // Disable update for API request
            } else {
                $this->country_id->setFormValue($val);
            }
        }

        // Check field name 'city' first before field var 'x_city'
        $val = $CurrentForm->hasValue("city") ? $CurrentForm->getValue("city") : $CurrentForm->getValue("x_city");
        if (!$this->city->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->city->Visible = false; // Disable update for API request
            } else {
                $this->city->setFormValue($val);
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

        // Check field name 'type' first before field var 'x_type'
        $val = $CurrentForm->hasValue("type") ? $CurrentForm->getValue("type") : $CurrentForm->getValue("x_type");
        if (!$this->type->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->type->Visible = false; // Disable update for API request
            } else {
                $this->type->setFormValue($val);
            }
        }

        // Check field name 'is_verified' first before field var 'x_is_verified'
        $val = $CurrentForm->hasValue("is_verified") ? $CurrentForm->getValue("is_verified") : $CurrentForm->getValue("x_is_verified");
        if (!$this->is_verified->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->is_verified->Visible = false; // Disable update for API request
            } else {
                $this->is_verified->setFormValue($val);
            }
        }

        // Check field name 'is_approved' first before field var 'x_is_approved'
        $val = $CurrentForm->hasValue("is_approved") ? $CurrentForm->getValue("is_approved") : $CurrentForm->getValue("x_is_approved");
        if (!$this->is_approved->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->is_approved->Visible = false; // Disable update for API request
            } else {
                $this->is_approved->setFormValue($val);
            }
        }

        // Check field name 'is_blocked' first before field var 'x_is_blocked'
        $val = $CurrentForm->hasValue("is_blocked") ? $CurrentForm->getValue("is_blocked") : $CurrentForm->getValue("x_is_blocked");
        if (!$this->is_blocked->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->is_blocked->Visible = false; // Disable update for API request
            } else {
                $this->is_blocked->setFormValue($val);
            }
        }

        // Check field name 'otp' first before field var 'x_otp'
        $val = $CurrentForm->hasValue("otp") ? $CurrentForm->getValue("otp") : $CurrentForm->getValue("x_otp");
        if (!$this->otp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->otp->Visible = false; // Disable update for API request
            } else {
                $this->otp->setFormValue($val);
            }
        }

        // Check field name 'slug' first before field var 'x_slug'
        $val = $CurrentForm->hasValue("slug") ? $CurrentForm->getValue("slug") : $CurrentForm->getValue("x_slug");
        if (!$this->slug->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->slug->Visible = false; // Disable update for API request
            } else {
                $this->slug->setFormValue($val);
            }
        }

        // Check field name 'remember_token' first before field var 'x_remember_token'
        $val = $CurrentForm->hasValue("remember_token") ? $CurrentForm->getValue("remember_token") : $CurrentForm->getValue("x_remember_token");
        if (!$this->remember_token->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->remember_token->Visible = false; // Disable update for API request
            } else {
                $this->remember_token->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
		$this->image->OldUploadPath = $this->image->getUploadPath(); // PHP
		$this->image->UploadPath = $this->image->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->name->CurrentValue = $this->name->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->_password->CurrentValue = $this->_password->FormValue;
        $this->phone->CurrentValue = $this->phone->FormValue;
        $this->gender->CurrentValue = $this->gender->FormValue;
        $this->birthday->CurrentValue = $this->birthday->FormValue;
        $this->birthday->CurrentValue = UnFormatDateTime($this->birthday->CurrentValue, $this->birthday->formatPattern());
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
        $this->name->setDbValue($row['name']);
        $this->_email->setDbValue($row['email']);
        $this->email_verified_at->setDbValue($row['email_verified_at']);
        $this->_password->setDbValue($row['password']);
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
    protected function newRow()
    {
        $row = [];
        $row['id'] = $this->id->DefaultValue;
        $row['name'] = $this->name->DefaultValue;
        $row['email'] = $this->_email->DefaultValue;
        $row['email_verified_at'] = $this->email_verified_at->DefaultValue;
        $row['password'] = $this->_password->DefaultValue;
        $row['phone'] = $this->phone->DefaultValue;
        $row['gender'] = $this->gender->DefaultValue;
        $row['birthday'] = $this->birthday->DefaultValue;
        $row['image'] = $this->image->DefaultValue;
        $row['country_id'] = $this->country_id->DefaultValue;
        $row['city'] = $this->city->DefaultValue;
        $row['currency_id'] = $this->currency_id->DefaultValue;
        $row['type'] = $this->type->DefaultValue;
        $row['is_verified'] = $this->is_verified->DefaultValue;
        $row['is_approved'] = $this->is_approved->DefaultValue;
        $row['is_blocked'] = $this->is_blocked->DefaultValue;
        $row['otp'] = $this->otp->DefaultValue;
        $row['slug'] = $this->slug->DefaultValue;
        $row['remember_token'] = $this->remember_token->DefaultValue;
        $row['created_at'] = $this->created_at->DefaultValue;
        $row['updated_at'] = $this->updated_at->DefaultValue;
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

            // name
            $this->name->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // password
            $this->_password->HrefValue = "";

            // phone
            $this->phone->HrefValue = "";

            // gender
            $this->gender->HrefValue = "";

            // birthday
            $this->birthday->HrefValue = "";

            // image
            $this->image->HrefValue = "";
            $this->image->ExportHrefValue = $this->image->UploadPath . $this->image->Upload->DbValue;

            // country_id
            $this->country_id->HrefValue = "";

            // city
            $this->city->HrefValue = "";

            // currency_id
            $this->currency_id->HrefValue = "";

            // type
            $this->type->HrefValue = "";

            // is_verified
            $this->is_verified->HrefValue = "";

            // is_approved
            $this->is_approved->HrefValue = "";

            // is_blocked
            $this->is_blocked->HrefValue = "";

            // otp
            $this->otp->HrefValue = "";

            // slug
            $this->slug->HrefValue = "";

            // remember_token
            $this->remember_token->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // name
            $this->name->setupEditAttributes();
            if (!$this->name->Raw) {
                $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
            }
            $this->name->EditValue = HtmlEncode($this->name->CurrentValue);
            $this->name->PlaceHolder = RemoveHtml($this->name->caption());

            // email
            $this->_email->setupEditAttributes();
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // password
            $this->_password->setupEditAttributes();
            if (!$this->_password->Raw) {
                $this->_password->CurrentValue = HtmlDecode($this->_password->CurrentValue);
            }
            $this->_password->EditValue = HtmlEncode($this->_password->CurrentValue);
            $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

            // phone
            $this->phone->setupEditAttributes();
            if (!$this->phone->Raw) {
                $this->phone->CurrentValue = HtmlDecode($this->phone->CurrentValue);
            }
            $this->phone->EditValue = HtmlEncode($this->phone->CurrentValue);
            $this->phone->PlaceHolder = RemoveHtml($this->phone->caption());

            // gender
            $this->gender->setupEditAttributes();
            $this->gender->EditValue = $this->gender->options(true);
            $this->gender->PlaceHolder = RemoveHtml($this->gender->caption());

            // birthday
            $this->birthday->setupEditAttributes();
            $this->birthday->EditValue = HtmlEncode(FormatDateTime($this->birthday->CurrentValue, $this->birthday->formatPattern()));
            $this->birthday->PlaceHolder = RemoveHtml($this->birthday->caption());

            // image
            $this->image->setupEditAttributes();
            $this->image->UploadPath = $this->image->getUploadPath(); // PHP
            if (!EmptyValue($this->image->Upload->DbValue)) {
                $this->image->EditValue = $this->image->Upload->DbValue;
            } else {
                $this->image->EditValue = "";
            }
            if (!EmptyValue($this->image->CurrentValue)) {
                $this->image->Upload->FileName = $this->image->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->image);
            }

            // country_id
            $this->country_id->setupEditAttributes();
            $curVal = trim(strval($this->country_id->CurrentValue));
            if ($curVal != "") {
                $this->country_id->ViewValue = $this->country_id->lookupCacheOption($curVal);
            } else {
                $this->country_id->ViewValue = $this->country_id->Lookup !== null && is_array($this->country_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->country_id->ViewValue !== null) { // Load from cache
                $this->country_id->EditValue = array_values($this->country_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`id`", "=", $this->country_id->CurrentValue, DATATYPE_NUMBER, "");
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
                $this->city->CurrentValue = HtmlDecode($this->city->CurrentValue);
            }
            $this->city->EditValue = HtmlEncode($this->city->CurrentValue);
            $this->city->PlaceHolder = RemoveHtml($this->city->caption());

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
                $this->otp->CurrentValue = HtmlDecode($this->otp->CurrentValue);
            }
            $this->otp->EditValue = HtmlEncode($this->otp->CurrentValue);
            $this->otp->PlaceHolder = RemoveHtml($this->otp->caption());

            // slug
            $this->slug->setupEditAttributes();
            if (!$this->slug->Raw) {
                $this->slug->CurrentValue = HtmlDecode($this->slug->CurrentValue);
            }
            $this->slug->EditValue = HtmlEncode($this->slug->CurrentValue);
            $this->slug->PlaceHolder = RemoveHtml($this->slug->caption());

            // remember_token
            $this->remember_token->setupEditAttributes();
            if (!$this->remember_token->Raw) {
                $this->remember_token->CurrentValue = HtmlDecode($this->remember_token->CurrentValue);
            }
            $this->remember_token->EditValue = HtmlEncode($this->remember_token->CurrentValue);
            $this->remember_token->PlaceHolder = RemoveHtml($this->remember_token->caption());

            // Add refer script

            // name
            $this->name->HrefValue = "";

            // email
            $this->_email->HrefValue = "";

            // password
            $this->_password->HrefValue = "";

            // phone
            $this->phone->HrefValue = "";

            // gender
            $this->gender->HrefValue = "";

            // birthday
            $this->birthday->HrefValue = "";

            // image
            $this->image->HrefValue = "";
            $this->image->ExportHrefValue = $this->image->UploadPath . $this->image->Upload->DbValue;

            // country_id
            $this->country_id->HrefValue = "";

            // city
            $this->city->HrefValue = "";

            // currency_id
            $this->currency_id->HrefValue = "";

            // type
            $this->type->HrefValue = "";

            // is_verified
            $this->is_verified->HrefValue = "";

            // is_approved
            $this->is_approved->HrefValue = "";

            // is_blocked
            $this->is_blocked->HrefValue = "";

            // otp
            $this->otp->HrefValue = "";

            // slug
            $this->slug->HrefValue = "";

            // remember_token
            $this->remember_token->HrefValue = "";
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
        if ($this->name->Required) {
            if (!$this->name->IsDetailKey && EmptyValue($this->name->FormValue)) {
                $this->name->addErrorMessage(str_replace("%s", $this->name->caption(), $this->name->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if ($this->_password->Required) {
            if (!$this->_password->IsDetailKey && EmptyValue($this->_password->FormValue)) {
                $this->_password->addErrorMessage(str_replace("%s", $this->_password->caption(), $this->_password->RequiredErrorMessage));
            }
        }
        if ($this->phone->Required) {
            if (!$this->phone->IsDetailKey && EmptyValue($this->phone->FormValue)) {
                $this->phone->addErrorMessage(str_replace("%s", $this->phone->caption(), $this->phone->RequiredErrorMessage));
            }
        }
        if ($this->gender->Required) {
            if (!$this->gender->IsDetailKey && EmptyValue($this->gender->FormValue)) {
                $this->gender->addErrorMessage(str_replace("%s", $this->gender->caption(), $this->gender->RequiredErrorMessage));
            }
        }
        if ($this->birthday->Required) {
            if (!$this->birthday->IsDetailKey && EmptyValue($this->birthday->FormValue)) {
                $this->birthday->addErrorMessage(str_replace("%s", $this->birthday->caption(), $this->birthday->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->birthday->FormValue, $this->birthday->formatPattern())) {
            $this->birthday->addErrorMessage($this->birthday->getErrorMessage(false));
        }
        if ($this->image->Required) {
            if ($this->image->Upload->FileName == "" && !$this->image->Upload->KeepFile) {
                $this->image->addErrorMessage(str_replace("%s", $this->image->caption(), $this->image->RequiredErrorMessage));
            }
        }
        if ($this->country_id->Required) {
            if (!$this->country_id->IsDetailKey && EmptyValue($this->country_id->FormValue)) {
                $this->country_id->addErrorMessage(str_replace("%s", $this->country_id->caption(), $this->country_id->RequiredErrorMessage));
            }
        }
        if ($this->city->Required) {
            if (!$this->city->IsDetailKey && EmptyValue($this->city->FormValue)) {
                $this->city->addErrorMessage(str_replace("%s", $this->city->caption(), $this->city->RequiredErrorMessage));
            }
        }
        if ($this->currency_id->Required) {
            if (!$this->currency_id->IsDetailKey && EmptyValue($this->currency_id->FormValue)) {
                $this->currency_id->addErrorMessage(str_replace("%s", $this->currency_id->caption(), $this->currency_id->RequiredErrorMessage));
            }
        }
        if ($this->type->Required) {
            if ($this->type->FormValue == "") {
                $this->type->addErrorMessage(str_replace("%s", $this->type->caption(), $this->type->RequiredErrorMessage));
            }
        }
        if ($this->is_verified->Required) {
            if ($this->is_verified->FormValue == "") {
                $this->is_verified->addErrorMessage(str_replace("%s", $this->is_verified->caption(), $this->is_verified->RequiredErrorMessage));
            }
        }
        if ($this->is_approved->Required) {
            if ($this->is_approved->FormValue == "") {
                $this->is_approved->addErrorMessage(str_replace("%s", $this->is_approved->caption(), $this->is_approved->RequiredErrorMessage));
            }
        }
        if ($this->is_blocked->Required) {
            if ($this->is_blocked->FormValue == "") {
                $this->is_blocked->addErrorMessage(str_replace("%s", $this->is_blocked->caption(), $this->is_blocked->RequiredErrorMessage));
            }
        }
        if ($this->otp->Required) {
            if (!$this->otp->IsDetailKey && EmptyValue($this->otp->FormValue)) {
                $this->otp->addErrorMessage(str_replace("%s", $this->otp->caption(), $this->otp->RequiredErrorMessage));
            }
        }
        if ($this->slug->Required) {
            if (!$this->slug->IsDetailKey && EmptyValue($this->slug->FormValue)) {
                $this->slug->addErrorMessage(str_replace("%s", $this->slug->caption(), $this->slug->RequiredErrorMessage));
            }
        }
        if ($this->remember_token->Required) {
            if (!$this->remember_token->IsDetailKey && EmptyValue($this->remember_token->FormValue)) {
                $this->remember_token->addErrorMessage(str_replace("%s", $this->remember_token->caption(), $this->remember_token->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("TransfersGrid");
        if (in_array("transfers", $detailTblVar) && $detailPage->DetailAdd) {
            $validateForm = $validateForm && $detailPage->validateGridForm();
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

        // name
        $this->name->setDbValueDef($rsnew, $this->name->CurrentValue, "", false);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, "", false);

        // password
        $this->_password->setDbValueDef($rsnew, $this->_password->CurrentValue, "", false);

        // phone
        $this->phone->setDbValueDef($rsnew, $this->phone->CurrentValue, null, false);

        // gender
        $this->gender->setDbValueDef($rsnew, $this->gender->CurrentValue, "", strval($this->gender->CurrentValue) == "");

        // birthday
        $this->birthday->setDbValueDef($rsnew, UnFormatDateTime($this->birthday->CurrentValue, $this->birthday->formatPattern()), null, false);

        // image
        if ($this->image->Visible && !$this->image->Upload->KeepFile) {
            $this->image->Upload->DbValue = ""; // No need to delete old file
            if ($this->image->Upload->FileName == "") {
                $rsnew['image'] = null;
            } else {
                $rsnew['image'] = $this->image->Upload->FileName;
            }
        }

        // country_id
        $this->country_id->setDbValueDef($rsnew, $this->country_id->CurrentValue, null, false);

        // city
        $this->city->setDbValueDef($rsnew, $this->city->CurrentValue, null, false);

        // currency_id
        $this->currency_id->setDbValueDef($rsnew, $this->currency_id->CurrentValue, null, false);

        // type
        $this->type->setDbValueDef($rsnew, $this->type->CurrentValue, "", strval($this->type->CurrentValue) == "");

        // is_verified
        $this->is_verified->setDbValueDef($rsnew, strval($this->is_verified->CurrentValue) == "1" ? "1" : "0", 0, strval($this->is_verified->CurrentValue) == "");

        // is_approved
        $this->is_approved->setDbValueDef($rsnew, strval($this->is_approved->CurrentValue) == "1" ? "1" : "0", 0, strval($this->is_approved->CurrentValue) == "");

        // is_blocked
        $this->is_blocked->setDbValueDef($rsnew, strval($this->is_blocked->CurrentValue) == "1" ? "1" : "0", 0, strval($this->is_blocked->CurrentValue) == "");

        // otp
        $this->otp->setDbValueDef($rsnew, $this->otp->CurrentValue, "", false);

        // slug
        $this->slug->setDbValueDef($rsnew, $this->slug->CurrentValue, null, false);

        // remember_token
        $this->remember_token->setDbValueDef($rsnew, $this->remember_token->CurrentValue, null, false);
        if ($this->image->Visible && !$this->image->Upload->KeepFile) {
            $this->image->UploadPath = $this->image->getUploadPath(); // PHP
            $oldFiles = EmptyValue($this->image->Upload->DbValue) ? [] : [$this->image->htmlDecode($this->image->Upload->DbValue)];
            if (!EmptyValue($this->image->Upload->FileName)) {
                $newFiles = [$this->image->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->image, $this->image->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->image->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->image->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->image->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->image->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->image->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->image->setDbValueDef($rsnew, $this->image->Upload->FileName, null, false);
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);
        if ($this->_email->CurrentValue != "") { // Check field with unique index
            $filter = "(`email` = '" . AdjustSql($this->_email->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->_email->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->_email->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        if ($this->otp->CurrentValue != "") { // Check field with unique index
            $filter = "(`otp` = '" . AdjustSql($this->otp->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->otp->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->otp->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "" && $this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Load db values from old row
        $this->loadDbValues($rsold);
        $this->image->OldUploadPath = $this->image->getUploadPath(); // PHP
        $this->image->UploadPath = $this->image->OldUploadPath;

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->image->Visible && !$this->image->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->image->Upload->DbValue) ? [] : [$this->image->htmlDecode($this->image->Upload->DbValue)];
                    if (!EmptyValue($this->image->Upload->FileName)) {
                        $newFiles = [$this->image->Upload->FileName];
                        $newFiles2 = [$this->image->htmlDecode($rsnew['image'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->image, $this->image->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->image->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadError7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->image->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
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

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("TransfersGrid");
            if (in_array("transfers", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->user_id->setSessionValue($this->id->CurrentValue); // Set master key
                $addRow = $detailPage->gridInsert();
                if (!$addRow) {
                $detailPage->user_id->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                if ($this->UseTransaction) { // Commit transaction
                    $conn->commit();
                }
            } else {
                if ($this->UseTransaction) { // Rollback transaction
                    $conn->rollback();
                }
            }
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

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("transfers", $detailTblVar)) {
                $detailPageObj = Container("TransfersGrid");
                if ($detailPageObj->DetailAdd) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->user_id->IsDetailKey = true;
                    $detailPageObj->user_id->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->user_id->setSessionValue($detailPageObj->user_id->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("UsersList"), "", $this->TableVar, true);
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
