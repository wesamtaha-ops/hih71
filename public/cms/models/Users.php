<?php

namespace PHPMaker2023\hih71;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for users
 */
class Users extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $DbErrorMessage = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Ajax / Modal
    public $UseAjaxActions = false;
    public $ModalSearch = true;
    public $ModalView = false;
    public $ModalAdd = false;
    public $ModalEdit = false;
    public $ModalUpdate = false;
    public $InlineDelete = false;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;

    // Fields
    public $id;
    public $name;
    public $_email;
    public $email_verified_at;
    public $_password;
    public $phone;
    public $gender;
    public $birthday;
    public $image;
    public $country_id;
    public $city;
    public $currency_id;
    public $type;
    public $is_verified;
    public $is_approved;
    public $is_blocked;
    public $otp;
    public $slug;
    public $remember_token;
    public $created_at;
    public $updated_at;
    public $rate;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("language");
        $this->TableVar = "users";
        $this->TableName = 'users';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "`users`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)

        // PDF
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)

        // PhpSpreadsheet
        $this->ExportExcelPageOrientation = null; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = null; // Page size (PhpSpreadsheet only)

        // PHPWord
        $this->ExportWordPageOrientation = ""; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = ""; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // id
        $this->id = new DbField(
            $this, // Table
            'x_id', // Variable name
            'id', // Name
            '`id`', // Expression
            '`id`', // Basic search expression
            19, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->id->InputTextType = "text";
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['id'] = &$this->id;

        // name
        $this->name = new DbField(
            $this, // Table
            'x_name', // Variable name
            'name', // Name
            '`name`', // Expression
            '`name`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`name`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->name->InputTextType = "text";
        $this->name->Nullable = false; // NOT NULL field
        $this->name->Required = true; // Required field
        $this->name->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['name'] = &$this->name;

        // email
        $this->_email = new DbField(
            $this, // Table
            'x__email', // Variable name
            'email', // Name
            '`email`', // Expression
            '`email`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`email`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->_email->InputTextType = "text";
        $this->_email->Nullable = false; // NOT NULL field
        $this->_email->Required = true; // Required field
        $this->_email->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['email'] = &$this->_email;

        // email_verified_at
        $this->email_verified_at = new DbField(
            $this, // Table
            'x_email_verified_at', // Variable name
            'email_verified_at', // Name
            '`email_verified_at`', // Expression
            CastDateFieldForLike("`email_verified_at`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`email_verified_at`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->email_verified_at->InputTextType = "text";
        $this->email_verified_at->Sortable = false; // Allow sort
        $this->email_verified_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->email_verified_at->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['email_verified_at'] = &$this->email_verified_at;

        // password
        $this->_password = new DbField(
            $this, // Table
            'x__password', // Variable name
            'password', // Name
            '`password`', // Expression
            '`password`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`password`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->_password->InputTextType = "text";
        $this->_password->Nullable = false; // NOT NULL field
        $this->_password->Required = true; // Required field
        $this->_password->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['password'] = &$this->_password;

        // phone
        $this->phone = new DbField(
            $this, // Table
            'x_phone', // Variable name
            'phone', // Name
            '`phone`', // Expression
            '`phone`', // Basic search expression
            201, // Type
            300, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`phone`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->phone->InputTextType = "text";
        $this->phone->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['phone'] = &$this->phone;

        // gender
        $this->gender = new DbField(
            $this, // Table
            'x_gender', // Variable name
            'gender', // Name
            '`gender`', // Expression
            '`gender`', // Basic search expression
            202, // Type
            6, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`gender`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->gender->addMethod("getDefault", fn() => "male");
        $this->gender->InputTextType = "text";
        $this->gender->Nullable = false; // NOT NULL field
        $this->gender->Required = true; // Required field
        $this->gender->setSelectMultiple(false); // Select one
        $this->gender->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->gender->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->gender->Lookup = new Lookup('gender', 'users', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
        $this->gender->OptionCount = 2;
        $this->gender->SearchOperators = ["=", "<>"];
        $this->Fields['gender'] = &$this->gender;

        // birthday
        $this->birthday = new DbField(
            $this, // Table
            'x_birthday', // Variable name
            'birthday', // Name
            '`birthday`', // Expression
            CastDateFieldForLike("`birthday`", 0, "DB"), // Basic search expression
            133, // Type
            10, // Size
            0, // Date/Time format
            false, // Is upload field
            '`birthday`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->birthday->InputTextType = "text";
        $this->birthday->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->birthday->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['birthday'] = &$this->birthday;

        // image
        $this->image = new DbField(
            $this, // Table
            'x_image', // Variable name
            'image', // Name
            '`image`', // Expression
            '`image`', // Basic search expression
            201, // Type
            65535, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`image`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'IMAGE', // View Tag
            'FILE' // Edit Tag
        );
        $this->image->addMethod("getUploadPath", fn() => "../images");
        $this->image->InputTextType = "text";
        $this->image->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['image'] = &$this->image;

        // country_id
        $this->country_id = new DbField(
            $this, // Table
            'x_country_id', // Variable name
            'country_id', // Name
            '`country_id`', // Expression
            '`country_id`', // Basic search expression
            19, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`country_id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->country_id->InputTextType = "text";
        $this->country_id->setSelectMultiple(false); // Select one
        $this->country_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->country_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->country_id->Lookup = new Lookup('country_id', 'countries', false, 'id', ["name_ar","name_en","",""], '', '', [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name_ar`, ''),'" . ValueSeparator(1, $this->country_id) . "',COALESCE(`name_en`,''))");
        $this->country_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->country_id->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['country_id'] = &$this->country_id;

        // city
        $this->city = new DbField(
            $this, // Table
            'x_city', // Variable name
            'city', // Name
            '`city`', // Expression
            '`city`', // Basic search expression
            201, // Type
            300, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`city`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->city->InputTextType = "text";
        $this->city->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['city'] = &$this->city;

        // currency_id
        $this->currency_id = new DbField(
            $this, // Table
            'x_currency_id', // Variable name
            'currency_id', // Name
            '`currency_id`', // Expression
            '`currency_id`', // Basic search expression
            19, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`currency_id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->currency_id->InputTextType = "text";
        $this->currency_id->setSelectMultiple(false); // Select one
        $this->currency_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->currency_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->currency_id->Lookup = new Lookup('currency_id', 'currencies', false, 'id', ["name_ar","name_en","",""], '', '', [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`name_ar`, ''),'" . ValueSeparator(1, $this->currency_id) . "',COALESCE(`name_en`,''))");
        $this->currency_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->currency_id->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['currency_id'] = &$this->currency_id;

        // type
        $this->type = new DbField(
            $this, // Table
            'x_type', // Variable name
            'type', // Name
            '`type`', // Expression
            '`type`', // Basic search expression
            202, // Type
            7, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`type`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->type->addMethod("getDefault", fn() => "student");
        $this->type->InputTextType = "text";
        $this->type->Nullable = false; // NOT NULL field
        $this->type->Required = true; // Required field
        $this->type->Lookup = new Lookup('type', 'users', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
        $this->type->OptionCount = 3;
        $this->type->SearchOperators = ["=", "<>"];
        $this->Fields['type'] = &$this->type;

        // is_verified
        $this->is_verified = new DbField(
            $this, // Table
            'x_is_verified', // Variable name
            'is_verified', // Name
            '`is_verified`', // Expression
            '`is_verified`', // Basic search expression
            16, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`is_verified`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->is_verified->addMethod("getDefault", fn() => 0);
        $this->is_verified->InputTextType = "text";
        $this->is_verified->Nullable = false; // NOT NULL field
        $this->is_verified->Required = true; // Required field
        $this->is_verified->DataType = DATATYPE_BOOLEAN;
        $this->is_verified->Lookup = new Lookup('is_verified', 'users', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
        $this->is_verified->OptionCount = 2;
        $this->is_verified->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->is_verified->SearchOperators = ["=", "<>"];
        $this->Fields['is_verified'] = &$this->is_verified;

        // is_approved
        $this->is_approved = new DbField(
            $this, // Table
            'x_is_approved', // Variable name
            'is_approved', // Name
            '`is_approved`', // Expression
            '`is_approved`', // Basic search expression
            16, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`is_approved`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->is_approved->addMethod("getDefault", fn() => 0);
        $this->is_approved->InputTextType = "text";
        $this->is_approved->Nullable = false; // NOT NULL field
        $this->is_approved->Required = true; // Required field
        $this->is_approved->DataType = DATATYPE_BOOLEAN;
        $this->is_approved->Lookup = new Lookup('is_approved', 'users', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
        $this->is_approved->OptionCount = 2;
        $this->is_approved->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->is_approved->SearchOperators = ["=", "<>"];
        $this->Fields['is_approved'] = &$this->is_approved;

        // is_blocked
        $this->is_blocked = new DbField(
            $this, // Table
            'x_is_blocked', // Variable name
            'is_blocked', // Name
            '`is_blocked`', // Expression
            '`is_blocked`', // Basic search expression
            16, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`is_blocked`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->is_blocked->addMethod("getDefault", fn() => 0);
        $this->is_blocked->InputTextType = "text";
        $this->is_blocked->Nullable = false; // NOT NULL field
        $this->is_blocked->Required = true; // Required field
        $this->is_blocked->DataType = DATATYPE_BOOLEAN;
        $this->is_blocked->Lookup = new Lookup('is_blocked', 'users', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
        $this->is_blocked->OptionCount = 2;
        $this->is_blocked->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->is_blocked->SearchOperators = ["=", "<>"];
        $this->Fields['is_blocked'] = &$this->is_blocked;

        // otp
        $this->otp = new DbField(
            $this, // Table
            'x_otp', // Variable name
            'otp', // Name
            '`otp`', // Expression
            '`otp`', // Basic search expression
            201, // Type
            300, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`otp`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->otp->InputTextType = "text";
        $this->otp->Nullable = false; // NOT NULL field
        $this->otp->Required = true; // Required field
        $this->otp->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['otp'] = &$this->otp;

        // slug
        $this->slug = new DbField(
            $this, // Table
            'x_slug', // Variable name
            'slug', // Name
            '`slug`', // Expression
            '`slug`', // Basic search expression
            201, // Type
            300, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`slug`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->slug->InputTextType = "text";
        $this->slug->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['slug'] = &$this->slug;

        // remember_token
        $this->remember_token = new DbField(
            $this, // Table
            'x_remember_token', // Variable name
            'remember_token', // Name
            '`remember_token`', // Expression
            '`remember_token`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`remember_token`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->remember_token->InputTextType = "text";
        $this->remember_token->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['remember_token'] = &$this->remember_token;

        // created_at
        $this->created_at = new DbField(
            $this, // Table
            'x_created_at', // Variable name
            'created_at', // Name
            '`created_at`', // Expression
            CastDateFieldForLike("`created_at`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`created_at`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->created_at->InputTextType = "text";
        $this->created_at->Sortable = false; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField(
            $this, // Table
            'x_updated_at', // Variable name
            'updated_at', // Name
            '`updated_at`', // Expression
            CastDateFieldForLike("`updated_at`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`updated_at`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->updated_at->InputTextType = "text";
        $this->updated_at->Sortable = false; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->updated_at->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['updated_at'] = &$this->updated_at;

        // rate
        $this->rate = new DbField(
            $this, // Table
            'x_rate', // Variable name
            'rate', // Name
            '`rate`', // Expression
            '`rate`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`rate`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->rate->addMethod("getDefault", fn() => 0);
        $this->rate->InputTextType = "text";
        $this->rate->Nullable = false; // NOT NULL field
        $this->rate->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->rate->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['rate'] = &$this->rate;

        // Add Doctrine Cache
        $this->Cache = new ArrayCache();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);

        // Call Table Load event
        $this->tableLoad();
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        }
    }

    // Update field sort
    public function updateFieldSort()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        $flds = GetSortFields($orderBy);
        foreach ($this->Fields as $field) {
            $fldSort = "";
            foreach ($flds as $fld) {
                if ($fld[0] == $field->Expression || $fld[0] == $field->VirtualExpression) {
                    $fldSort = $fld[1];
                }
            }
            $field->setSort($fldSort);
        }
    }

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")) ?? "";
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "transfers") {
            $detailUrl = Container("transfers")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "UsersList";
        }
        return $detailUrl;
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`users`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter, $id = "")
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            case "lookup":
                return (($allow & 256) == 256);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlwrk);
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->getSqlAsQueryBuilder($where, $orderBy)->getSQL();
    }

    // Get QueryBuilder
    public function getSqlAsQueryBuilder($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        );
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        try {
            $success = $this->insertSql($rs)->execute();
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        if ($success) {
            // Get insert id if necessary
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        try {
            $success = $this->updateSql($rs, $where, $curfilter)->execute();
            $success = ($success > 0) ? $success : true;
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }

        // Return auto increment field
        if ($success) {
            if (!isset($rs['id']) && !EmptyValue($this->id->CurrentValue)) {
                $rs['id'] = $this->id->CurrentValue;
            }
        }
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            try {
                $success = $this->deleteSql($rs, $where, $curfilter)->execute();
                $this->DbErrorMessage = "";
            } catch (\Exception $e) {
                $success = false;
                $this->DbErrorMessage = $e->getMessage();
            }
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->id->DbValue = $row['id'];
        $this->name->DbValue = $row['name'];
        $this->_email->DbValue = $row['email'];
        $this->email_verified_at->DbValue = $row['email_verified_at'];
        $this->_password->DbValue = $row['password'];
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
        $this->rate->DbValue = $row['rate'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $this->image->OldUploadPath = $this->image->getUploadPath(); // PHP
        $oldFiles = EmptyValue($row['image']) ? [] : [$row['image']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->image->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->image->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = !EmptyValue($this->id->OldValue) && !$current ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("UsersList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "UsersView") {
            return $Language->phrase("View");
        } elseif ($pageName == "UsersEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "UsersAdd") {
            return $Language->phrase("Add");
        }
        return "";
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "UsersView";
            case Config("API_ADD_ACTION"):
                return "UsersAdd";
            case Config("API_EDIT_ACTION"):
                return "UsersEdit";
            case Config("API_DELETE_ACTION"):
                return "UsersDelete";
            case Config("API_LIST_ACTION"):
                return "UsersList";
            default:
                return "";
        }
    }

    // Current URL
    public function getCurrentUrl($parm = "")
    {
        $url = CurrentPageUrl(false);
        if ($parm != "") {
            $url = $this->keyUrl($url, $parm);
        } else {
            $url = $this->keyUrl($url, Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // List URL
    public function getListUrl()
    {
        return "UsersList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("UsersView", $parm);
        } else {
            $url = $this->keyUrl("UsersView", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "UsersAdd?" . $parm;
        } else {
            $url = "UsersAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("UsersEdit", $parm);
        } else {
            $url = $this->keyUrl("UsersEdit", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("UsersList", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("UsersAdd", $parm);
        } else {
            $url = $this->keyUrl("UsersAdd", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("UsersList", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("UsersDelete");
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"id\":" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language, $Page;
        $sortUrl = "";
        $attrs = "";
        if ($fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-ew-action="sort" data-ajax="' . ($this->UseAjaxActions ? "true" : "false") . '" data-sort-url="' . $sortUrl . '" data-sort-type="1"';
            if ($this->ContextClass) { // Add context
                $attrs .= ' data-context="' . HtmlEncode($this->ContextClass) . '"';
            }
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") . '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort();
            if ($DashboardReport) {
                $urlParm .= "&amp;dashboard=true";
            }
            return $this->addMasterUrl($this->CurrentPageName . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from records
    public function getFilterFromRecords($rows)
    {
        $keyFilter = "";
        foreach ($rows as $row) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            $keyFilter .= "(" . $this->getRecordFilter($row) . ")";
        }
        return $keyFilter;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->name->setDbValue($row['name']);
        $this->_email->setDbValue($row['email']);
        $this->email_verified_at->setDbValue($row['email_verified_at']);
        $this->_password->setDbValue($row['password']);
        $this->phone->setDbValue($row['phone']);
        $this->gender->setDbValue($row['gender']);
        $this->birthday->setDbValue($row['birthday']);
        $this->image->Upload->DbValue = $row['image'];
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
        $this->rate->setDbValue($row['rate']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "UsersList";
        $listClass = PROJECT_NAMESPACE . $listPage;
        $page = new $listClass();
        $page->loadRecordsetFromFilter($filter);
        $view = Container("view");
        $template = $listPage . ".php"; // View
        $GLOBALS["Title"] ??= $page->Title; // Title
        try {
            $Response = $view->render($Response, $template, $GLOBALS);
        } finally {
            $page->terminate(); // Terminate page and clean up
        }
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // name

        // email

        // email_verified_at
        $this->email_verified_at->CellCssStyle = "white-space: nowrap;";

        // password
        $this->_password->CellCssStyle = "white-space: nowrap;";

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

        // rate

        // id
        $this->id->ViewValue = $this->id->CurrentValue;

        // name
        $this->name->ViewValue = $this->name->CurrentValue;

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;

        // email_verified_at
        $this->email_verified_at->ViewValue = $this->email_verified_at->CurrentValue;
        $this->email_verified_at->ViewValue = FormatDateTime($this->email_verified_at->ViewValue, $this->email_verified_at->formatPattern());

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

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, $this->created_at->formatPattern());

        // updated_at
        $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
        $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, $this->updated_at->formatPattern());

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

        // email_verified_at
        $this->email_verified_at->HrefValue = "";
        $this->email_verified_at->TooltipValue = "";

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

        // created_at
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // updated_at
        $this->updated_at->HrefValue = "";
        $this->updated_at->TooltipValue = "";

        // rate
        $this->rate->HrefValue = "";
        $this->rate->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // id
        $this->id->setupEditAttributes();
        $this->id->EditValue = $this->id->CurrentValue;

        // name
        $this->name->setupEditAttributes();
        if (!$this->name->Raw) {
            $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
        }
        $this->name->EditValue = $this->name->CurrentValue;
        $this->name->PlaceHolder = RemoveHtml($this->name->caption());

        // email
        $this->_email->setupEditAttributes();
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // email_verified_at
        $this->email_verified_at->setupEditAttributes();
        $this->email_verified_at->EditValue = FormatDateTime($this->email_verified_at->CurrentValue, $this->email_verified_at->formatPattern());
        $this->email_verified_at->PlaceHolder = RemoveHtml($this->email_verified_at->caption());

        // password
        $this->_password->setupEditAttributes();
        if (!$this->_password->Raw) {
            $this->_password->CurrentValue = HtmlDecode($this->_password->CurrentValue);
        }
        $this->_password->EditValue = $this->_password->CurrentValue;
        $this->_password->PlaceHolder = RemoveHtml($this->_password->caption());

        // phone
        $this->phone->setupEditAttributes();
        if (!$this->phone->Raw) {
            $this->phone->CurrentValue = HtmlDecode($this->phone->CurrentValue);
        }
        $this->phone->EditValue = $this->phone->CurrentValue;
        $this->phone->PlaceHolder = RemoveHtml($this->phone->caption());

        // gender
        $this->gender->setupEditAttributes();
        $this->gender->EditValue = $this->gender->options(true);
        $this->gender->PlaceHolder = RemoveHtml($this->gender->caption());

        // birthday
        $this->birthday->setupEditAttributes();
        $this->birthday->EditValue = FormatDateTime($this->birthday->CurrentValue, $this->birthday->formatPattern());
        $this->birthday->PlaceHolder = RemoveHtml($this->birthday->caption());

        // image
        $this->image->setupEditAttributes();
        $this->image->UploadPath = $this->image->getUploadPath(); // PHP
        if (!EmptyValue($this->image->Upload->DbValue)) {
            $this->image->ImageWidth = 100;
            $this->image->ImageHeight = 0;
            $this->image->ImageAlt = $this->image->alt();
            $this->image->ImageCssClass = "ew-image";
            $this->image->EditValue = $this->image->Upload->DbValue;
        } else {
            $this->image->EditValue = "";
        }
        if (!EmptyValue($this->image->CurrentValue)) {
            $this->image->Upload->FileName = $this->image->CurrentValue;
        }

        // country_id
        $this->country_id->setupEditAttributes();
        $this->country_id->PlaceHolder = RemoveHtml($this->country_id->caption());

        // city
        $this->city->setupEditAttributes();
        if (!$this->city->Raw) {
            $this->city->CurrentValue = HtmlDecode($this->city->CurrentValue);
        }
        $this->city->EditValue = $this->city->CurrentValue;
        $this->city->PlaceHolder = RemoveHtml($this->city->caption());

        // currency_id
        $this->currency_id->setupEditAttributes();
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
        $this->otp->EditValue = $this->otp->CurrentValue;
        $this->otp->PlaceHolder = RemoveHtml($this->otp->caption());

        // slug
        $this->slug->setupEditAttributes();
        if (!$this->slug->Raw) {
            $this->slug->CurrentValue = HtmlDecode($this->slug->CurrentValue);
        }
        $this->slug->EditValue = $this->slug->CurrentValue;
        $this->slug->PlaceHolder = RemoveHtml($this->slug->caption());

        // remember_token
        $this->remember_token->setupEditAttributes();
        if (!$this->remember_token->Raw) {
            $this->remember_token->CurrentValue = HtmlDecode($this->remember_token->CurrentValue);
        }
        $this->remember_token->EditValue = $this->remember_token->CurrentValue;
        $this->remember_token->PlaceHolder = RemoveHtml($this->remember_token->caption());

        // created_at
        $this->created_at->setupEditAttributes();
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, $this->created_at->formatPattern());
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // updated_at
        $this->updated_at->setupEditAttributes();
        $this->updated_at->EditValue = FormatDateTime($this->updated_at->CurrentValue, $this->updated_at->formatPattern());
        $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

        // rate
        $this->rate->setupEditAttributes();
        $this->rate->EditValue = $this->rate->CurrentValue;
        $this->rate->PlaceHolder = RemoveHtml($this->rate->caption());
        if (strval($this->rate->EditValue) != "" && is_numeric($this->rate->EditValue)) {
            $this->rate->EditValue = FormatNumber($this->rate->EditValue, null);
        }

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->phone);
                    $doc->exportCaption($this->gender);
                    $doc->exportCaption($this->birthday);
                    $doc->exportCaption($this->image);
                    $doc->exportCaption($this->country_id);
                    $doc->exportCaption($this->city);
                    $doc->exportCaption($this->currency_id);
                    $doc->exportCaption($this->type);
                    $doc->exportCaption($this->is_verified);
                    $doc->exportCaption($this->is_approved);
                    $doc->exportCaption($this->is_blocked);
                    $doc->exportCaption($this->otp);
                    $doc->exportCaption($this->slug);
                    $doc->exportCaption($this->remember_token);
                    $doc->exportCaption($this->rate);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->name);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->phone);
                    $doc->exportCaption($this->gender);
                    $doc->exportCaption($this->birthday);
                    $doc->exportCaption($this->image);
                    $doc->exportCaption($this->country_id);
                    $doc->exportCaption($this->city);
                    $doc->exportCaption($this->currency_id);
                    $doc->exportCaption($this->type);
                    $doc->exportCaption($this->is_verified);
                    $doc->exportCaption($this->is_approved);
                    $doc->exportCaption($this->is_blocked);
                    $doc->exportCaption($this->otp);
                    $doc->exportCaption($this->slug);
                    $doc->exportCaption($this->remember_token);
                    $doc->exportCaption($this->rate);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->id);
                        $doc->exportField($this->name);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->phone);
                        $doc->exportField($this->gender);
                        $doc->exportField($this->birthday);
                        $doc->exportField($this->image);
                        $doc->exportField($this->country_id);
                        $doc->exportField($this->city);
                        $doc->exportField($this->currency_id);
                        $doc->exportField($this->type);
                        $doc->exportField($this->is_verified);
                        $doc->exportField($this->is_approved);
                        $doc->exportField($this->is_blocked);
                        $doc->exportField($this->otp);
                        $doc->exportField($this->slug);
                        $doc->exportField($this->remember_token);
                        $doc->exportField($this->rate);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->name);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->phone);
                        $doc->exportField($this->gender);
                        $doc->exportField($this->birthday);
                        $doc->exportField($this->image);
                        $doc->exportField($this->country_id);
                        $doc->exportField($this->city);
                        $doc->exportField($this->currency_id);
                        $doc->exportField($this->type);
                        $doc->exportField($this->is_verified);
                        $doc->exportField($this->is_approved);
                        $doc->exportField($this->is_blocked);
                        $doc->exportField($this->otp);
                        $doc->exportField($this->slug);
                        $doc->exportField($this->remember_token);
                        $doc->exportField($this->rate);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($doc, $row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'image') {
            $fldName = "image";
            $fileNameFld = "image";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssociative($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $ext = strtolower($pathinfo["extension"] ?? "");
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment" . ($DownloadFileName ? "; filename=\"" . $DownloadFileName . "\"" : ""));
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    if ($fld->hasMethod("getUploadPath")) { // Check field level upload path
                        $fld->UploadPath = $fld->getUploadPath();
                    }
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Table level events

    // Table Load event
    public function tableLoad()
    {
        // Enter your code here
    }

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
