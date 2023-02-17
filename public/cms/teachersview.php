<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "teachersinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "teachers_certificatesgridcls.php" ?>
<?php include_once "teachers_coursesgridcls.php" ?>
<?php include_once "teachers_experiencesgridcls.php" ?>
<?php include_once "teachers_levelsgridcls.php" ?>
<?php include_once "teachers_packagesgridcls.php" ?>
<?php include_once "teachers_topicsgridcls.php" ?>
<?php include_once "teachers_trainsgridcls.php" ?>
<?php include_once "ordersgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$teachers_view = NULL; // Initialize page object first

class cteachers_view extends cteachers {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{D43A73A4-5F37-4161-A00D-2E65107145C9}';

	// Table name
	var $TableName = 'teachers';

	// Page object name
	var $PageObjName = 'teachers_view';

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

		// Table object (teachers)
		if (!isset($GLOBALS["teachers"]) || get_class($GLOBALS["teachers"]) == "cteachers") {
			$GLOBALS["teachers"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["teachers"];
		}
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'teachers', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("teacherslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->user_id->SetVisibility();
		$this->timezone->SetVisibility();
		$this->teacher_language->SetVisibility();
		$this->video->SetVisibility();
		$this->heading_ar->SetVisibility();
		$this->description_ar->SetVisibility();
		$this->heading_en->SetVisibility();
		$this->description_en->SetVisibility();
		$this->allow_express->SetVisibility();
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

		// Create Token
		$this->CreateToken();
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
		global $EW_EXPORT, $teachers;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($teachers);
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "teachersview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up master/detail parameters
		$this->SetupMasterParms();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("teacherslist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetupStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->id->CurrentValue) == strval($this->Recordset->fields('id'))) {
								$this->setStartRecordNumber($this->StartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->StartRec++;
								$this->Recordset->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "teacherslist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}
		} else {
			$sReturnUrl = "teacherslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();

		// Set up detail parameters
		$this->SetupDetailParms();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->IsLoggedIn());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->IsLoggedIn());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->CopyUrl) . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->IsLoggedIn());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddQuery($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->IsLoggedIn());
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_teachers_certificates"
		$item = &$option->Add("detail_teachers_certificates");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("teachers_certificates", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("teachers_certificateslist.php?" . EW_TABLE_SHOW_MASTER . "=teachers&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["teachers_certificates_grid"] && $GLOBALS["teachers_certificates_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=teachers_certificates")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "teachers_certificates";
		}
		if ($GLOBALS["teachers_certificates_grid"] && $GLOBALS["teachers_certificates_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=teachers_certificates")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "teachers_certificates";
		}
		if ($GLOBALS["teachers_certificates_grid"] && $GLOBALS["teachers_certificates_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=teachers_certificates")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "teachers_certificates";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "teachers_certificates";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_teachers_courses"
		$item = &$option->Add("detail_teachers_courses");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("teachers_courses", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("teachers_courseslist.php?" . EW_TABLE_SHOW_MASTER . "=teachers&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["teachers_courses_grid"] && $GLOBALS["teachers_courses_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=teachers_courses")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "teachers_courses";
		}
		if ($GLOBALS["teachers_courses_grid"] && $GLOBALS["teachers_courses_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=teachers_courses")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "teachers_courses";
		}
		if ($GLOBALS["teachers_courses_grid"] && $GLOBALS["teachers_courses_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=teachers_courses")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "teachers_courses";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "teachers_courses";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_teachers_experiences"
		$item = &$option->Add("detail_teachers_experiences");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("teachers_experiences", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("teachers_experienceslist.php?" . EW_TABLE_SHOW_MASTER . "=teachers&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["teachers_experiences_grid"] && $GLOBALS["teachers_experiences_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=teachers_experiences")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "teachers_experiences";
		}
		if ($GLOBALS["teachers_experiences_grid"] && $GLOBALS["teachers_experiences_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=teachers_experiences")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "teachers_experiences";
		}
		if ($GLOBALS["teachers_experiences_grid"] && $GLOBALS["teachers_experiences_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=teachers_experiences")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "teachers_experiences";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "teachers_experiences";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_teachers_levels"
		$item = &$option->Add("detail_teachers_levels");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("teachers_levels", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("teachers_levelslist.php?" . EW_TABLE_SHOW_MASTER . "=teachers&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["teachers_levels_grid"] && $GLOBALS["teachers_levels_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=teachers_levels")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "teachers_levels";
		}
		if ($GLOBALS["teachers_levels_grid"] && $GLOBALS["teachers_levels_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=teachers_levels")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "teachers_levels";
		}
		if ($GLOBALS["teachers_levels_grid"] && $GLOBALS["teachers_levels_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=teachers_levels")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "teachers_levels";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "teachers_levels";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_teachers_packages"
		$item = &$option->Add("detail_teachers_packages");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("teachers_packages", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("teachers_packageslist.php?" . EW_TABLE_SHOW_MASTER . "=teachers&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["teachers_packages_grid"] && $GLOBALS["teachers_packages_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=teachers_packages")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "teachers_packages";
		}
		if ($GLOBALS["teachers_packages_grid"] && $GLOBALS["teachers_packages_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=teachers_packages")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "teachers_packages";
		}
		if ($GLOBALS["teachers_packages_grid"] && $GLOBALS["teachers_packages_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=teachers_packages")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "teachers_packages";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "teachers_packages";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_teachers_topics"
		$item = &$option->Add("detail_teachers_topics");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("teachers_topics", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("teachers_topicslist.php?" . EW_TABLE_SHOW_MASTER . "=teachers&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["teachers_topics_grid"] && $GLOBALS["teachers_topics_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=teachers_topics")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "teachers_topics";
		}
		if ($GLOBALS["teachers_topics_grid"] && $GLOBALS["teachers_topics_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=teachers_topics")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "teachers_topics";
		}
		if ($GLOBALS["teachers_topics_grid"] && $GLOBALS["teachers_topics_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=teachers_topics")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "teachers_topics";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "teachers_topics";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_teachers_trains"
		$item = &$option->Add("detail_teachers_trains");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("teachers_trains", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("teachers_trainslist.php?" . EW_TABLE_SHOW_MASTER . "=teachers&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["teachers_trains_grid"] && $GLOBALS["teachers_trains_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=teachers_trains")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "teachers_trains";
		}
		if ($GLOBALS["teachers_trains_grid"] && $GLOBALS["teachers_trains_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=teachers_trains")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "teachers_trains";
		}
		if ($GLOBALS["teachers_trains_grid"] && $GLOBALS["teachers_trains_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=teachers_trains")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "teachers_trains";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "teachers_trains";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_orders"
		$item = &$option->Add("detail_orders");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("orders", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("orderslist.php?" . EW_TABLE_SHOW_MASTER . "=teachers&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["orders_grid"] && $GLOBALS["orders_grid"]->DetailView && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=orders")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "orders";
		}
		if ($GLOBALS["orders_grid"] && $GLOBALS["orders_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=orders")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "orders";
		}
		if ($GLOBALS["orders_grid"] && $GLOBALS["orders_grid"]->DetailAdd && $Security->IsLoggedIn() && $Security->IsLoggedIn()) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=orders")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "orders";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->IsLoggedIn();
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "orders";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// Multiple details
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
			$oListOpt = &$option->Add("details");
			$oListOpt->Body = $body;
		}

		// Set up detail default
		$option = &$options["detail"];
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$option->UseImageAndText = TRUE;
		$ar = explode(",", $DetailTableLink);
		$cnt = count($ar);
		$option->UseDropDownButton = ($cnt > 1);
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		$this->user_id->setDbValue($row['user_id']);
		$this->timezone->setDbValue($row['timezone']);
		$this->teacher_language->setDbValue($row['teacher_language']);
		$this->video->setDbValue($row['video']);
		$this->heading_ar->setDbValue($row['heading_ar']);
		$this->description_ar->setDbValue($row['description_ar']);
		$this->heading_en->setDbValue($row['heading_en']);
		$this->description_en->setDbValue($row['description_en']);
		$this->allow_express->setDbValue($row['allow_express']);
		$this->fees->setDbValue($row['fees']);
		$this->currency_id->setDbValue($row['currency_id']);
		$this->created_at->setDbValue($row['created_at']);
		$this->updated_at->setDbValue($row['updated_at']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['user_id'] = NULL;
		$row['timezone'] = NULL;
		$row['teacher_language'] = NULL;
		$row['video'] = NULL;
		$row['heading_ar'] = NULL;
		$row['description_ar'] = NULL;
		$row['heading_en'] = NULL;
		$row['description_en'] = NULL;
		$row['allow_express'] = NULL;
		$row['fees'] = NULL;
		$row['currency_id'] = NULL;
		$row['created_at'] = NULL;
		$row['updated_at'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->user_id->DbValue = $row['user_id'];
		$this->timezone->DbValue = $row['timezone'];
		$this->teacher_language->DbValue = $row['teacher_language'];
		$this->video->DbValue = $row['video'];
		$this->heading_ar->DbValue = $row['heading_ar'];
		$this->description_ar->DbValue = $row['description_ar'];
		$this->heading_en->DbValue = $row['heading_en'];
		$this->description_en->DbValue = $row['description_en'];
		$this->allow_express->DbValue = $row['allow_express'];
		$this->fees->DbValue = $row['fees'];
		$this->currency_id->DbValue = $row['currency_id'];
		$this->created_at->DbValue = $row['created_at'];
		$this->updated_at->DbValue = $row['updated_at'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// user_id
		// timezone
		// teacher_language
		// video
		// heading_ar
		// description_ar
		// heading_en
		// description_en
		// allow_express
		// fees
		// currency_id
		// created_at
		// updated_at

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// user_id
		$this->user_id->ViewValue = $this->user_id->CurrentValue;
		$this->user_id->ViewCustomAttributes = "";

		// timezone
		$this->timezone->ViewValue = $this->timezone->CurrentValue;
		$this->timezone->ViewCustomAttributes = "";

		// teacher_language
		$this->teacher_language->ViewValue = $this->teacher_language->CurrentValue;
		$this->teacher_language->ViewCustomAttributes = "";

		// video
		$this->video->ViewValue = $this->video->CurrentValue;
		$this->video->ViewCustomAttributes = "";

		// heading_ar
		$this->heading_ar->ViewValue = $this->heading_ar->CurrentValue;
		$this->heading_ar->ViewCustomAttributes = "";

		// description_ar
		$this->description_ar->ViewValue = $this->description_ar->CurrentValue;
		$this->description_ar->ViewCustomAttributes = "";

		// heading_en
		$this->heading_en->ViewValue = $this->heading_en->CurrentValue;
		$this->heading_en->ViewCustomAttributes = "";

		// description_en
		$this->description_en->ViewValue = $this->description_en->CurrentValue;
		$this->description_en->ViewCustomAttributes = "";

		// allow_express
		$this->allow_express->ViewValue = $this->allow_express->CurrentValue;
		$this->allow_express->ViewCustomAttributes = "";

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

			// user_id
			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";
			$this->user_id->TooltipValue = "";

			// timezone
			$this->timezone->LinkCustomAttributes = "";
			$this->timezone->HrefValue = "";
			$this->timezone->TooltipValue = "";

			// teacher_language
			$this->teacher_language->LinkCustomAttributes = "";
			$this->teacher_language->HrefValue = "";
			$this->teacher_language->TooltipValue = "";

			// video
			$this->video->LinkCustomAttributes = "";
			$this->video->HrefValue = "";
			$this->video->TooltipValue = "";

			// heading_ar
			$this->heading_ar->LinkCustomAttributes = "";
			$this->heading_ar->HrefValue = "";
			$this->heading_ar->TooltipValue = "";

			// description_ar
			$this->description_ar->LinkCustomAttributes = "";
			$this->description_ar->HrefValue = "";
			$this->description_ar->TooltipValue = "";

			// heading_en
			$this->heading_en->LinkCustomAttributes = "";
			$this->heading_en->HrefValue = "";
			$this->heading_en->TooltipValue = "";

			// description_en
			$this->description_en->LinkCustomAttributes = "";
			$this->description_en->HrefValue = "";
			$this->description_en->TooltipValue = "";

			// allow_express
			$this->allow_express->LinkCustomAttributes = "";
			$this->allow_express->HrefValue = "";
			$this->allow_express->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

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

	// Set up detail parms based on QueryString
	function SetupDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("teachers_certificates", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_certificates_grid"]))
					$GLOBALS["teachers_certificates_grid"] = new cteachers_certificates_grid;
				if ($GLOBALS["teachers_certificates_grid"]->DetailView) {
					$GLOBALS["teachers_certificates_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["teachers_certificates_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_certificates_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_certificates_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_certificates_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_certificates_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_certificates_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("teachers_courses", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_courses_grid"]))
					$GLOBALS["teachers_courses_grid"] = new cteachers_courses_grid;
				if ($GLOBALS["teachers_courses_grid"]->DetailView) {
					$GLOBALS["teachers_courses_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["teachers_courses_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_courses_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_courses_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_courses_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_courses_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_courses_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("teachers_experiences", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_experiences_grid"]))
					$GLOBALS["teachers_experiences_grid"] = new cteachers_experiences_grid;
				if ($GLOBALS["teachers_experiences_grid"]->DetailView) {
					$GLOBALS["teachers_experiences_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["teachers_experiences_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_experiences_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_experiences_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_experiences_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_experiences_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_experiences_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("teachers_levels", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_levels_grid"]))
					$GLOBALS["teachers_levels_grid"] = new cteachers_levels_grid;
				if ($GLOBALS["teachers_levels_grid"]->DetailView) {
					$GLOBALS["teachers_levels_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["teachers_levels_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_levels_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_levels_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_levels_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_levels_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_levels_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("teachers_packages", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_packages_grid"]))
					$GLOBALS["teachers_packages_grid"] = new cteachers_packages_grid;
				if ($GLOBALS["teachers_packages_grid"]->DetailView) {
					$GLOBALS["teachers_packages_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["teachers_packages_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_packages_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_packages_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_packages_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_packages_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_packages_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("teachers_topics", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_topics_grid"]))
					$GLOBALS["teachers_topics_grid"] = new cteachers_topics_grid;
				if ($GLOBALS["teachers_topics_grid"]->DetailView) {
					$GLOBALS["teachers_topics_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["teachers_topics_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_topics_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_topics_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_topics_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_topics_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_topics_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("teachers_trains", $DetailTblVar)) {
				if (!isset($GLOBALS["teachers_trains_grid"]))
					$GLOBALS["teachers_trains_grid"] = new cteachers_trains_grid;
				if ($GLOBALS["teachers_trains_grid"]->DetailView) {
					$GLOBALS["teachers_trains_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["teachers_trains_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["teachers_trains_grid"]->setStartRecordNumber(1);
					$GLOBALS["teachers_trains_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["teachers_trains_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["teachers_trains_grid"]->teacher_id->setSessionValue($GLOBALS["teachers_trains_grid"]->teacher_id->CurrentValue);
				}
			}
			if (in_array("orders", $DetailTblVar)) {
				if (!isset($GLOBALS["orders_grid"]))
					$GLOBALS["orders_grid"] = new corders_grid;
				if ($GLOBALS["orders_grid"]->DetailView) {
					$GLOBALS["orders_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["orders_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["orders_grid"]->setStartRecordNumber(1);
					$GLOBALS["orders_grid"]->teacher_id->FldIsDetailKey = TRUE;
					$GLOBALS["orders_grid"]->teacher_id->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["orders_grid"]->teacher_id->setSessionValue($GLOBALS["orders_grid"]->teacher_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("teacherslist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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
if (!isset($teachers_view)) $teachers_view = new cteachers_view();

// Page init
$teachers_view->Page_Init();

// Page main
$teachers_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$teachers_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fteachersview = new ew_Form("fteachersview", "view");

// Form_CustomValidate event
fteachersview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fteachersview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $teachers_view->ExportOptions->Render("body") ?>
<?php
	foreach ($teachers_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $teachers_view->ShowPageHeader(); ?>
<?php
$teachers_view->ShowMessage();
?>
<?php if (!$teachers_view->IsModal) { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($teachers_view->Pager)) $teachers_view->Pager = new cPrevNextPager($teachers_view->StartRec, $teachers_view->DisplayRecs, $teachers_view->TotalRecs, $teachers_view->AutoHidePager) ?>
<?php if ($teachers_view->Pager->RecordCount > 0 && $teachers_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($teachers_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $teachers_view->PageUrl() ?>start=<?php echo $teachers_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($teachers_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $teachers_view->PageUrl() ?>start=<?php echo $teachers_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $teachers_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($teachers_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $teachers_view->PageUrl() ?>start=<?php echo $teachers_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($teachers_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $teachers_view->PageUrl() ?>start=<?php echo $teachers_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $teachers_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fteachersview" id="fteachersview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($teachers_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $teachers_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="teachers">
<input type="hidden" name="modal" value="<?php echo intval($teachers_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($teachers->id->Visible) { // id ?>
	<tr id="r_id">
		<td class="col-sm-2"><span id="elh_teachers_id"><?php echo $teachers->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $teachers->id->CellAttributes() ?>>
<span id="el_teachers_id">
<span<?php echo $teachers->id->ViewAttributes() ?>>
<?php echo $teachers->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->user_id->Visible) { // user_id ?>
	<tr id="r_user_id">
		<td class="col-sm-2"><span id="elh_teachers_user_id"><?php echo $teachers->user_id->FldCaption() ?></span></td>
		<td data-name="user_id"<?php echo $teachers->user_id->CellAttributes() ?>>
<span id="el_teachers_user_id">
<span<?php echo $teachers->user_id->ViewAttributes() ?>>
<?php echo $teachers->user_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->timezone->Visible) { // timezone ?>
	<tr id="r_timezone">
		<td class="col-sm-2"><span id="elh_teachers_timezone"><?php echo $teachers->timezone->FldCaption() ?></span></td>
		<td data-name="timezone"<?php echo $teachers->timezone->CellAttributes() ?>>
<span id="el_teachers_timezone">
<span<?php echo $teachers->timezone->ViewAttributes() ?>>
<?php echo $teachers->timezone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->teacher_language->Visible) { // teacher_language ?>
	<tr id="r_teacher_language">
		<td class="col-sm-2"><span id="elh_teachers_teacher_language"><?php echo $teachers->teacher_language->FldCaption() ?></span></td>
		<td data-name="teacher_language"<?php echo $teachers->teacher_language->CellAttributes() ?>>
<span id="el_teachers_teacher_language">
<span<?php echo $teachers->teacher_language->ViewAttributes() ?>>
<?php echo $teachers->teacher_language->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->video->Visible) { // video ?>
	<tr id="r_video">
		<td class="col-sm-2"><span id="elh_teachers_video"><?php echo $teachers->video->FldCaption() ?></span></td>
		<td data-name="video"<?php echo $teachers->video->CellAttributes() ?>>
<span id="el_teachers_video">
<span<?php echo $teachers->video->ViewAttributes() ?>>
<?php echo $teachers->video->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->heading_ar->Visible) { // heading_ar ?>
	<tr id="r_heading_ar">
		<td class="col-sm-2"><span id="elh_teachers_heading_ar"><?php echo $teachers->heading_ar->FldCaption() ?></span></td>
		<td data-name="heading_ar"<?php echo $teachers->heading_ar->CellAttributes() ?>>
<span id="el_teachers_heading_ar">
<span<?php echo $teachers->heading_ar->ViewAttributes() ?>>
<?php echo $teachers->heading_ar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->description_ar->Visible) { // description_ar ?>
	<tr id="r_description_ar">
		<td class="col-sm-2"><span id="elh_teachers_description_ar"><?php echo $teachers->description_ar->FldCaption() ?></span></td>
		<td data-name="description_ar"<?php echo $teachers->description_ar->CellAttributes() ?>>
<span id="el_teachers_description_ar">
<span<?php echo $teachers->description_ar->ViewAttributes() ?>>
<?php echo $teachers->description_ar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->heading_en->Visible) { // heading_en ?>
	<tr id="r_heading_en">
		<td class="col-sm-2"><span id="elh_teachers_heading_en"><?php echo $teachers->heading_en->FldCaption() ?></span></td>
		<td data-name="heading_en"<?php echo $teachers->heading_en->CellAttributes() ?>>
<span id="el_teachers_heading_en">
<span<?php echo $teachers->heading_en->ViewAttributes() ?>>
<?php echo $teachers->heading_en->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->description_en->Visible) { // description_en ?>
	<tr id="r_description_en">
		<td class="col-sm-2"><span id="elh_teachers_description_en"><?php echo $teachers->description_en->FldCaption() ?></span></td>
		<td data-name="description_en"<?php echo $teachers->description_en->CellAttributes() ?>>
<span id="el_teachers_description_en">
<span<?php echo $teachers->description_en->ViewAttributes() ?>>
<?php echo $teachers->description_en->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->allow_express->Visible) { // allow_express ?>
	<tr id="r_allow_express">
		<td class="col-sm-2"><span id="elh_teachers_allow_express"><?php echo $teachers->allow_express->FldCaption() ?></span></td>
		<td data-name="allow_express"<?php echo $teachers->allow_express->CellAttributes() ?>>
<span id="el_teachers_allow_express">
<span<?php echo $teachers->allow_express->ViewAttributes() ?>>
<?php echo $teachers->allow_express->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->fees->Visible) { // fees ?>
	<tr id="r_fees">
		<td class="col-sm-2"><span id="elh_teachers_fees"><?php echo $teachers->fees->FldCaption() ?></span></td>
		<td data-name="fees"<?php echo $teachers->fees->CellAttributes() ?>>
<span id="el_teachers_fees">
<span<?php echo $teachers->fees->ViewAttributes() ?>>
<?php echo $teachers->fees->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->currency_id->Visible) { // currency_id ?>
	<tr id="r_currency_id">
		<td class="col-sm-2"><span id="elh_teachers_currency_id"><?php echo $teachers->currency_id->FldCaption() ?></span></td>
		<td data-name="currency_id"<?php echo $teachers->currency_id->CellAttributes() ?>>
<span id="el_teachers_currency_id">
<span<?php echo $teachers->currency_id->ViewAttributes() ?>>
<?php echo $teachers->currency_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->created_at->Visible) { // created_at ?>
	<tr id="r_created_at">
		<td class="col-sm-2"><span id="elh_teachers_created_at"><?php echo $teachers->created_at->FldCaption() ?></span></td>
		<td data-name="created_at"<?php echo $teachers->created_at->CellAttributes() ?>>
<span id="el_teachers_created_at">
<span<?php echo $teachers->created_at->ViewAttributes() ?>>
<?php echo $teachers->created_at->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($teachers->updated_at->Visible) { // updated_at ?>
	<tr id="r_updated_at">
		<td class="col-sm-2"><span id="elh_teachers_updated_at"><?php echo $teachers->updated_at->FldCaption() ?></span></td>
		<td data-name="updated_at"<?php echo $teachers->updated_at->CellAttributes() ?>>
<span id="el_teachers_updated_at">
<span<?php echo $teachers->updated_at->ViewAttributes() ?>>
<?php echo $teachers->updated_at->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$teachers_view->IsModal) { ?>
<?php if (!isset($teachers_view->Pager)) $teachers_view->Pager = new cPrevNextPager($teachers_view->StartRec, $teachers_view->DisplayRecs, $teachers_view->TotalRecs, $teachers_view->AutoHidePager) ?>
<?php if ($teachers_view->Pager->RecordCount > 0 && $teachers_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($teachers_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $teachers_view->PageUrl() ?>start=<?php echo $teachers_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($teachers_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $teachers_view->PageUrl() ?>start=<?php echo $teachers_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $teachers_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($teachers_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $teachers_view->PageUrl() ?>start=<?php echo $teachers_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($teachers_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $teachers_view->PageUrl() ?>start=<?php echo $teachers_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $teachers_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
<?php
	if (in_array("teachers_certificates", explode(",", $teachers->getCurrentDetailTable())) && $teachers_certificates->DetailView) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_certificates", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_certificatesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("teachers_courses", explode(",", $teachers->getCurrentDetailTable())) && $teachers_courses->DetailView) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_courses", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_coursesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("teachers_experiences", explode(",", $teachers->getCurrentDetailTable())) && $teachers_experiences->DetailView) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_experiences", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_experiencesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("teachers_levels", explode(",", $teachers->getCurrentDetailTable())) && $teachers_levels->DetailView) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_levels", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_levelsgrid.php" ?>
<?php } ?>
<?php
	if (in_array("teachers_packages", explode(",", $teachers->getCurrentDetailTable())) && $teachers_packages->DetailView) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_packages", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_packagesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("teachers_topics", explode(",", $teachers->getCurrentDetailTable())) && $teachers_topics->DetailView) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_topics", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_topicsgrid.php" ?>
<?php } ?>
<?php
	if (in_array("teachers_trains", explode(",", $teachers->getCurrentDetailTable())) && $teachers_trains->DetailView) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("teachers_trains", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "teachers_trainsgrid.php" ?>
<?php } ?>
<?php
	if (in_array("orders", explode(",", $teachers->getCurrentDetailTable())) && $orders->DetailView) {
?>
<?php if ($teachers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("orders", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "ordersgrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fteachersview.Init();
</script>
<?php
$teachers_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$teachers_view->Page_Terminate();
?>
