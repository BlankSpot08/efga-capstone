<?php

namespace PHPMaker2022\efga_expense_system;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class EmpExpenseEdit extends EmpExpense
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'emp_expense';

    // Page object name
    public $PageObjName = "EmpExpenseEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

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
        $args = $route->getArguments();
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        $url = rtrim(UrlFor($route->getName(), $args), "/") . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
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

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return $this->TableVar == $CurrentForm->getValue("t");
            }
            if (Get("t") !== null) {
                return $this->TableVar == Get("t");
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (emp_expense)
        if (!isset($GLOBALS["emp_expense"]) || get_class($GLOBALS["emp_expense"]) == PROJECT_NAMESPACE . "emp_expense") {
            $GLOBALS["emp_expense"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'emp_expense');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
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
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $tbl = Container("emp_expense");
                $doc = new $class($tbl);
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "EmpExpenseView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
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

    // Properties
    public $FormClassName = "ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->cashAdvance_id->setVisibility();
        $this->amount->setVisibility();
        $this->dateTrans->setVisibility();
        $this->receiptNumber->setVisibility();
        $this->receipt->setVisibility();
        $this->note->setVisibility();
        $this->submittedBy->setVisibility();
        $this->status->setVisibility();
        $this->dateClosed->setVisibility();
        $this->float_status->setVisibility();
        $this->validatedBy->setVisibility();
        $this->machine_id->setVisibility();
        $this->cash_float->setVisibility();
        $this->expCategory_id->setVisibility();
        $this->hideFieldsForAddEdit();
        $this->cashAdvance_id->Required = false;
        $this->amount->Required = false;
        $this->status->Required = false;
        $this->float_status->Required = false;
        $this->machine_id->Required = false;

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

        // Set up lookup cache
        $this->setupLookupOptions($this->cashAdvance_id);
        $this->setupLookupOptions($this->status);
        $this->setupLookupOptions($this->float_status);
        $this->setupLookupOptions($this->machine_id);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                    // Load current record
                    $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values

            // Overwrite record, reload hash value
            if ($this->isOverwrite()) {
                $this->loadRowHash();
                $this->CurrentAction = "confirm";
            }
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("EmpExpenseList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "EmpExpenseList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        if ($this->isConfirm()) { // Confirm page
            $this->RowType = ROWTYPE_VIEW; // Render as View
        } else {
            $this->RowType = ROWTYPE_EDIT; // Render as Edit
        }
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
        $this->receipt->Upload->Index = $CurrentForm->Index;
        $this->receipt->Upload->uploadFile();
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }

        // Check field name 'cashAdvance_id' first before field var 'x_cashAdvance_id'
        $val = $CurrentForm->hasValue("cashAdvance_id") ? $CurrentForm->getValue("cashAdvance_id") : $CurrentForm->getValue("x_cashAdvance_id");
        if (!$this->cashAdvance_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cashAdvance_id->Visible = false; // Disable update for API request
            } else {
                $this->cashAdvance_id->setFormValue($val);
            }
        }

        // Check field name 'amount' first before field var 'x_amount'
        $val = $CurrentForm->hasValue("amount") ? $CurrentForm->getValue("amount") : $CurrentForm->getValue("x_amount");
        if (!$this->amount->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->amount->Visible = false; // Disable update for API request
            } else {
                $this->amount->setFormValue($val);
            }
        }

        // Check field name 'dateTrans' first before field var 'x_dateTrans'
        $val = $CurrentForm->hasValue("dateTrans") ? $CurrentForm->getValue("dateTrans") : $CurrentForm->getValue("x_dateTrans");
        if (!$this->dateTrans->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dateTrans->Visible = false; // Disable update for API request
            } else {
                $this->dateTrans->setFormValue($val, true, $validate);
            }
            $this->dateTrans->CurrentValue = UnFormatDateTime($this->dateTrans->CurrentValue, $this->dateTrans->formatPattern());
        }

        // Check field name 'receiptNumber' first before field var 'x_receiptNumber'
        $val = $CurrentForm->hasValue("receiptNumber") ? $CurrentForm->getValue("receiptNumber") : $CurrentForm->getValue("x_receiptNumber");
        if (!$this->receiptNumber->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receiptNumber->Visible = false; // Disable update for API request
            } else {
                $this->receiptNumber->setFormValue($val);
            }
        }

        // Check field name 'note' first before field var 'x_note'
        $val = $CurrentForm->hasValue("note") ? $CurrentForm->getValue("note") : $CurrentForm->getValue("x_note");
        if (!$this->note->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->note->Visible = false; // Disable update for API request
            } else {
                $this->note->setFormValue($val);
            }
        }

        // Check field name 'submittedBy' first before field var 'x_submittedBy'
        $val = $CurrentForm->hasValue("submittedBy") ? $CurrentForm->getValue("submittedBy") : $CurrentForm->getValue("x_submittedBy");
        if (!$this->submittedBy->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->submittedBy->Visible = false; // Disable update for API request
            } else {
                $this->submittedBy->setFormValue($val);
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

        // Check field name 'dateClosed' first before field var 'x_dateClosed'
        $val = $CurrentForm->hasValue("dateClosed") ? $CurrentForm->getValue("dateClosed") : $CurrentForm->getValue("x_dateClosed");
        if (!$this->dateClosed->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dateClosed->Visible = false; // Disable update for API request
            } else {
                $this->dateClosed->setFormValue($val);
            }
            $this->dateClosed->CurrentValue = UnFormatDateTime($this->dateClosed->CurrentValue, $this->dateClosed->formatPattern());
        }

        // Check field name 'float_status' first before field var 'x_float_status'
        $val = $CurrentForm->hasValue("float_status") ? $CurrentForm->getValue("float_status") : $CurrentForm->getValue("x_float_status");
        if (!$this->float_status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->float_status->Visible = false; // Disable update for API request
            } else {
                $this->float_status->setFormValue($val);
            }
        }

        // Check field name 'validatedBy' first before field var 'x_validatedBy'
        $val = $CurrentForm->hasValue("validatedBy") ? $CurrentForm->getValue("validatedBy") : $CurrentForm->getValue("x_validatedBy");
        if (!$this->validatedBy->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->validatedBy->Visible = false; // Disable update for API request
            } else {
                $this->validatedBy->setFormValue($val);
            }
        }

        // Check field name 'machine_id' first before field var 'x_machine_id'
        $val = $CurrentForm->hasValue("machine_id") ? $CurrentForm->getValue("machine_id") : $CurrentForm->getValue("x_machine_id");
        if (!$this->machine_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->machine_id->Visible = false; // Disable update for API request
            } else {
                $this->machine_id->setFormValue($val);
            }
        }

        // Check field name 'cash_float' first before field var 'x_cash_float'
        $val = $CurrentForm->hasValue("cash_float") ? $CurrentForm->getValue("cash_float") : $CurrentForm->getValue("x_cash_float");
        if (!$this->cash_float->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cash_float->Visible = false; // Disable update for API request
            } else {
                $this->cash_float->setFormValue($val);
            }
        }

        // Check field name 'expCategory_id' first before field var 'x_expCategory_id'
        $val = $CurrentForm->hasValue("expCategory_id") ? $CurrentForm->getValue("expCategory_id") : $CurrentForm->getValue("x_expCategory_id");
        if (!$this->expCategory_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->expCategory_id->Visible = false; // Disable update for API request
            } else {
                $this->expCategory_id->setFormValue($val, true, $validate);
            }
        }
        $this->getUploadFiles(); // Get upload files
        if (!$this->isOverwrite()) {
            $this->HashValue = $CurrentForm->getValue("k_hash");
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->cashAdvance_id->CurrentValue = $this->cashAdvance_id->FormValue;
        $this->amount->CurrentValue = $this->amount->FormValue;
        $this->dateTrans->CurrentValue = $this->dateTrans->FormValue;
        $this->dateTrans->CurrentValue = UnFormatDateTime($this->dateTrans->CurrentValue, $this->dateTrans->formatPattern());
        $this->receiptNumber->CurrentValue = $this->receiptNumber->FormValue;
        $this->note->CurrentValue = $this->note->FormValue;
        $this->submittedBy->CurrentValue = $this->submittedBy->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->dateClosed->CurrentValue = $this->dateClosed->FormValue;
        $this->dateClosed->CurrentValue = UnFormatDateTime($this->dateClosed->CurrentValue, $this->dateClosed->formatPattern());
        $this->float_status->CurrentValue = $this->float_status->FormValue;
        $this->validatedBy->CurrentValue = $this->validatedBy->FormValue;
        $this->machine_id->CurrentValue = $this->machine_id->FormValue;
        $this->cash_float->CurrentValue = $this->cash_float->FormValue;
        $this->expCategory_id->CurrentValue = $this->expCategory_id->FormValue;
        if (!$this->isOverwrite()) {
            $this->HashValue = $CurrentForm->getValue("k_hash");
        }
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
            if (!$this->EventCancelled) {
                $this->HashValue = $this->getRowHash($row); // Get hash value for record
            }
        }

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("edit");
            if (!$res) {
                $userIdMsg = DeniedMessage();
                $this->setFailureMessage($userIdMsg);
            }
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
        $this->cashAdvance_id->setDbValue($row['cashAdvance_id']);
        $this->amount->setDbValue($row['amount']);
        $this->dateTrans->setDbValue($row['dateTrans']);
        $this->receiptNumber->setDbValue($row['receiptNumber']);
        $this->receipt->Upload->DbValue = $row['receipt'];
        if (is_resource($this->receipt->Upload->DbValue) && get_resource_type($this->receipt->Upload->DbValue) == "stream") { // Byte array
            $this->receipt->Upload->DbValue = stream_get_contents($this->receipt->Upload->DbValue);
        }
        $this->note->setDbValue($row['note']);
        $this->submittedBy->setDbValue($row['submittedBy']);
        $this->status->setDbValue($row['status']);
        $this->dateClosed->setDbValue($row['dateClosed']);
        $this->float_status->setDbValue($row['float_status']);
        $this->validatedBy->setDbValue($row['validatedBy']);
        $this->machine_id->setDbValue($row['machine_id']);
        if (array_key_exists('EV__machine_id', $row)) {
            $this->machine_id->VirtualValue = $row['EV__machine_id']; // Set up virtual field value
        } else {
            $this->machine_id->VirtualValue = ""; // Clear value
        }
        $this->cash_float->setDbValue($row['cash_float']);
        $this->expCategory_id->setDbValue($row['expCategory_id']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['cashAdvance_id'] = null;
        $row['amount'] = null;
        $row['dateTrans'] = null;
        $row['receiptNumber'] = null;
        $row['receipt'] = null;
        $row['note'] = null;
        $row['submittedBy'] = null;
        $row['status'] = null;
        $row['dateClosed'] = null;
        $row['float_status'] = null;
        $row['validatedBy'] = null;
        $row['machine_id'] = null;
        $row['cash_float'] = null;
        $row['expCategory_id'] = null;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
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

        // cashAdvance_id
        $this->cashAdvance_id->RowCssClass = "row";

        // amount
        $this->amount->RowCssClass = "row";

        // dateTrans
        $this->dateTrans->RowCssClass = "row";

        // receiptNumber
        $this->receiptNumber->RowCssClass = "row";

        // receipt
        $this->receipt->RowCssClass = "row";

        // note
        $this->note->RowCssClass = "row";

        // submittedBy
        $this->submittedBy->RowCssClass = "row";

        // status
        $this->status->RowCssClass = "row";

        // dateClosed
        $this->dateClosed->RowCssClass = "row";

        // float_status
        $this->float_status->RowCssClass = "row";

        // validatedBy
        $this->validatedBy->RowCssClass = "row";

        // machine_id
        $this->machine_id->RowCssClass = "row";

        // cash_float
        $this->cash_float->RowCssClass = "row";

        // expCategory_id
        $this->expCategory_id->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // cashAdvance_id
            $curVal = strval($this->cashAdvance_id->CurrentValue);
            if ($curVal != "") {
                $this->cashAdvance_id->ViewValue = $this->cashAdvance_id->lookupCacheOption($curVal);
                if ($this->cashAdvance_id->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`submittedBy` = '" . CurrentUserName() . "' AND `used` = '0' AND `status` = '1'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->cashAdvance_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->cashAdvance_id->Lookup->renderViewRow($rswrk[0]);
                        $this->cashAdvance_id->ViewValue = $this->cashAdvance_id->displayValue($arwrk);
                    } else {
                        $this->cashAdvance_id->ViewValue = FormatNumber($this->cashAdvance_id->CurrentValue, $this->cashAdvance_id->formatPattern());
                    }
                }
            } else {
                $this->cashAdvance_id->ViewValue = null;
            }
            $this->cashAdvance_id->ViewCustomAttributes = "";

            // amount
            $this->amount->ViewValue = $this->amount->CurrentValue;
            $this->amount->ViewValue = FormatNumber($this->amount->ViewValue, $this->amount->formatPattern());
            $this->amount->ViewCustomAttributes = "";

            // dateTrans
            $this->dateTrans->ViewValue = $this->dateTrans->CurrentValue;
            $this->dateTrans->ViewValue = FormatDateTime($this->dateTrans->ViewValue, $this->dateTrans->formatPattern());
            $this->dateTrans->ViewCustomAttributes = "";

            // receiptNumber
            $this->receiptNumber->ViewValue = $this->receiptNumber->CurrentValue;
            $this->receiptNumber->ViewCustomAttributes = "";

            // receipt
            if (!EmptyValue($this->receipt->Upload->DbValue)) {
                $this->receipt->ImageWidth = 100;
                $this->receipt->ImageHeight = 100;
                $this->receipt->ImageAlt = $this->receipt->alt();
                $this->receipt->ImageCssClass = "ew-image";
                $this->receipt->ViewValue = $this->id->CurrentValue;
                $this->receipt->IsBlobImage = IsImageFile(ContentExtension($this->receipt->Upload->DbValue));
            } else {
                $this->receipt->ViewValue = "";
            }
            $this->receipt->ViewCustomAttributes = "";

            // note
            $this->note->ViewValue = $this->note->CurrentValue;
            $this->note->ViewCustomAttributes = "";

            // submittedBy
            $this->submittedBy->ViewValue = $this->submittedBy->CurrentValue;
            $this->submittedBy->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->ViewCustomAttributes = "";

            // dateClosed
            $this->dateClosed->ViewValue = $this->dateClosed->CurrentValue;
            $this->dateClosed->ViewValue = FormatDateTime($this->dateClosed->ViewValue, $this->dateClosed->formatPattern());
            $this->dateClosed->ViewCustomAttributes = "";

            // float_status
            if (strval($this->float_status->CurrentValue) != "") {
                $this->float_status->ViewValue = $this->float_status->optionCaption($this->float_status->CurrentValue);
            } else {
                $this->float_status->ViewValue = null;
            }
            $this->float_status->ViewCustomAttributes = "";

            // validatedBy
            $this->validatedBy->ViewValue = $this->validatedBy->CurrentValue;
            $this->validatedBy->ViewCustomAttributes = "";

            // machine_id
            if ($this->machine_id->VirtualValue != "") {
                $this->machine_id->ViewValue = $this->machine_id->VirtualValue;
            } else {
                $curVal = strval($this->machine_id->CurrentValue);
                if ($curVal != "") {
                    $this->machine_id->ViewValue = $this->machine_id->lookupCacheOption($curVal);
                    if ($this->machine_id->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->machine_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->machine_id->Lookup->renderViewRow($rswrk[0]);
                            $this->machine_id->ViewValue = $this->machine_id->displayValue($arwrk);
                        } else {
                            $this->machine_id->ViewValue = FormatNumber($this->machine_id->CurrentValue, $this->machine_id->formatPattern());
                        }
                    }
                } else {
                    $this->machine_id->ViewValue = null;
                }
            }
            $this->machine_id->ViewCustomAttributes = "";

            // cash_float
            $this->cash_float->ViewValue = $this->cash_float->CurrentValue;
            $this->cash_float->ViewValue = FormatNumber($this->cash_float->ViewValue, $this->cash_float->formatPattern());
            $this->cash_float->ViewCustomAttributes = "";

            // expCategory_id
            $this->expCategory_id->ViewValue = $this->expCategory_id->CurrentValue;
            $this->expCategory_id->ViewValue = FormatNumber($this->expCategory_id->ViewValue, $this->expCategory_id->formatPattern());
            $this->expCategory_id->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // cashAdvance_id
            $this->cashAdvance_id->LinkCustomAttributes = "";
            $this->cashAdvance_id->HrefValue = "";
            $this->cashAdvance_id->TooltipValue = "";

            // amount
            $this->amount->LinkCustomAttributes = "";
            $this->amount->HrefValue = "";
            $this->amount->TooltipValue = "";

            // dateTrans
            $this->dateTrans->LinkCustomAttributes = "";
            $this->dateTrans->HrefValue = "";

            // receiptNumber
            $this->receiptNumber->LinkCustomAttributes = "";
            $this->receiptNumber->HrefValue = "";

            // receipt
            $this->receipt->LinkCustomAttributes = "";
            if (!empty($this->receipt->Upload->DbValue)) {
                $this->receipt->HrefValue = GetFileUploadUrl($this->receipt, $this->id->CurrentValue);
                $this->receipt->LinkAttrs["target"] = "";
                if ($this->receipt->IsBlobImage && empty($this->receipt->LinkAttrs["target"])) {
                    $this->receipt->LinkAttrs["target"] = "_blank";
                }
                if ($this->isExport()) {
                    $this->receipt->HrefValue = FullUrl($this->receipt->HrefValue, "href");
                }
            } else {
                $this->receipt->HrefValue = "";
            }
            $this->receipt->ExportHrefValue = GetFileUploadUrl($this->receipt, $this->id->CurrentValue);

            // note
            $this->note->LinkCustomAttributes = "";
            $this->note->HrefValue = "";

            // submittedBy
            $this->submittedBy->LinkCustomAttributes = "";
            $this->submittedBy->HrefValue = "";
            $this->submittedBy->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // dateClosed
            $this->dateClosed->LinkCustomAttributes = "";
            $this->dateClosed->HrefValue = "";
            $this->dateClosed->TooltipValue = "";

            // float_status
            $this->float_status->LinkCustomAttributes = "";
            $this->float_status->HrefValue = "";
            $this->float_status->TooltipValue = "";

            // validatedBy
            $this->validatedBy->LinkCustomAttributes = "";
            $this->validatedBy->HrefValue = "";
            $this->validatedBy->TooltipValue = "";

            // machine_id
            $this->machine_id->LinkCustomAttributes = "";
            $this->machine_id->HrefValue = "";
            $this->machine_id->TooltipValue = "";

            // cash_float
            $this->cash_float->LinkCustomAttributes = "";
            $this->cash_float->HrefValue = "";
            $this->cash_float->TooltipValue = "";

            // expCategory_id
            $this->expCategory_id->LinkCustomAttributes = "";
            $this->expCategory_id->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // cashAdvance_id
            $this->cashAdvance_id->setupEditAttributes();
            $this->cashAdvance_id->EditCustomAttributes = "";
            $curVal = strval($this->cashAdvance_id->CurrentValue);
            if ($curVal != "") {
                $this->cashAdvance_id->EditValue = $this->cashAdvance_id->lookupCacheOption($curVal);
                if ($this->cashAdvance_id->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "`submittedBy` = '" . CurrentUserName() . "' AND `used` = '0' AND `status` = '1'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->cashAdvance_id->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->cashAdvance_id->Lookup->renderViewRow($rswrk[0]);
                        $this->cashAdvance_id->EditValue = $this->cashAdvance_id->displayValue($arwrk);
                    } else {
                        $this->cashAdvance_id->EditValue = FormatNumber($this->cashAdvance_id->CurrentValue, $this->cashAdvance_id->formatPattern());
                    }
                }
            } else {
                $this->cashAdvance_id->EditValue = null;
            }
            $this->cashAdvance_id->ViewCustomAttributes = "";

            // amount
            $this->amount->setupEditAttributes();
            $this->amount->EditCustomAttributes = "";
            $this->amount->EditValue = $this->amount->CurrentValue;
            $this->amount->EditValue = FormatNumber($this->amount->EditValue, $this->amount->formatPattern());
            $this->amount->ViewCustomAttributes = "";

            // dateTrans
            $this->dateTrans->setupEditAttributes();
            $this->dateTrans->EditCustomAttributes = "";
            $this->dateTrans->EditValue = HtmlEncode(FormatDateTime($this->dateTrans->CurrentValue, $this->dateTrans->formatPattern()));
            $this->dateTrans->PlaceHolder = RemoveHtml($this->dateTrans->caption());

            // receiptNumber
            $this->receiptNumber->setupEditAttributes();
            $this->receiptNumber->EditCustomAttributes = "";
            if (!$this->receiptNumber->Raw) {
                $this->receiptNumber->CurrentValue = HtmlDecode($this->receiptNumber->CurrentValue);
            }
            $this->receiptNumber->EditValue = HtmlEncode($this->receiptNumber->CurrentValue);
            $this->receiptNumber->PlaceHolder = RemoveHtml($this->receiptNumber->caption());

            // receipt
            $this->receipt->setupEditAttributes();
            $this->receipt->EditCustomAttributes = "";
            if (!EmptyValue($this->receipt->Upload->DbValue)) {
                $this->receipt->ImageWidth = 100;
                $this->receipt->ImageHeight = 100;
                $this->receipt->ImageAlt = $this->receipt->alt();
                $this->receipt->ImageCssClass = "ew-image";
                $this->receipt->EditValue = $this->id->CurrentValue;
                $this->receipt->IsBlobImage = IsImageFile(ContentExtension($this->receipt->Upload->DbValue));
            } else {
                $this->receipt->EditValue = "";
            }
            if ($this->isShow()) {
                RenderUploadField($this->receipt);
            }

            // note
            $this->note->setupEditAttributes();
            $this->note->EditCustomAttributes = "";
            if (!$this->note->Raw) {
                $this->note->CurrentValue = HtmlDecode($this->note->CurrentValue);
            }
            $this->note->EditValue = HtmlEncode($this->note->CurrentValue);
            $this->note->PlaceHolder = RemoveHtml($this->note->caption());

            // submittedBy
            $this->submittedBy->setupEditAttributes();
            $this->submittedBy->EditCustomAttributes = "";
            $this->submittedBy->EditValue = $this->submittedBy->CurrentValue;
            $this->submittedBy->ViewCustomAttributes = "";

            // status
            $this->status->setupEditAttributes();
            $this->status->EditCustomAttributes = "";
            if (strval($this->status->CurrentValue) != "") {
                $this->status->EditValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->EditValue = null;
            }
            $this->status->ViewCustomAttributes = "";

            // dateClosed
            $this->dateClosed->setupEditAttributes();
            $this->dateClosed->EditCustomAttributes = "";
            $this->dateClosed->EditValue = $this->dateClosed->CurrentValue;
            $this->dateClosed->EditValue = FormatDateTime($this->dateClosed->EditValue, $this->dateClosed->formatPattern());
            $this->dateClosed->ViewCustomAttributes = "";

            // float_status
            $this->float_status->setupEditAttributes();
            $this->float_status->EditCustomAttributes = "";
            if (strval($this->float_status->CurrentValue) != "") {
                $this->float_status->EditValue = $this->float_status->optionCaption($this->float_status->CurrentValue);
            } else {
                $this->float_status->EditValue = null;
            }
            $this->float_status->ViewCustomAttributes = "";

            // validatedBy
            $this->validatedBy->setupEditAttributes();
            $this->validatedBy->EditCustomAttributes = "";
            $this->validatedBy->EditValue = $this->validatedBy->CurrentValue;
            $this->validatedBy->ViewCustomAttributes = "";

            // machine_id
            $this->machine_id->setupEditAttributes();
            $this->machine_id->EditCustomAttributes = "";
            if ($this->machine_id->VirtualValue != "") {
                $this->machine_id->EditValue = $this->machine_id->VirtualValue;
            } else {
                $curVal = strval($this->machine_id->CurrentValue);
                if ($curVal != "") {
                    $this->machine_id->EditValue = $this->machine_id->lookupCacheOption($curVal);
                    if ($this->machine_id->EditValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->machine_id->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->machine_id->Lookup->renderViewRow($rswrk[0]);
                            $this->machine_id->EditValue = $this->machine_id->displayValue($arwrk);
                        } else {
                            $this->machine_id->EditValue = FormatNumber($this->machine_id->CurrentValue, $this->machine_id->formatPattern());
                        }
                    }
                } else {
                    $this->machine_id->EditValue = null;
                }
            }
            $this->machine_id->ViewCustomAttributes = "";

            // cash_float
            $this->cash_float->setupEditAttributes();
            $this->cash_float->EditCustomAttributes = "";
            $this->cash_float->EditValue = $this->cash_float->CurrentValue;
            $this->cash_float->EditValue = FormatNumber($this->cash_float->EditValue, $this->cash_float->formatPattern());
            $this->cash_float->ViewCustomAttributes = "";

            // expCategory_id
            $this->expCategory_id->setupEditAttributes();
            $this->expCategory_id->EditCustomAttributes = "";
            $this->expCategory_id->EditValue = HtmlEncode($this->expCategory_id->CurrentValue);
            $this->expCategory_id->PlaceHolder = RemoveHtml($this->expCategory_id->caption());
            if (strval($this->expCategory_id->EditValue) != "" && is_numeric($this->expCategory_id->EditValue)) {
                $this->expCategory_id->EditValue = FormatNumber($this->expCategory_id->EditValue, null);
            }

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // cashAdvance_id
            $this->cashAdvance_id->LinkCustomAttributes = "";
            $this->cashAdvance_id->HrefValue = "";
            $this->cashAdvance_id->TooltipValue = "";

            // amount
            $this->amount->LinkCustomAttributes = "";
            $this->amount->HrefValue = "";
            $this->amount->TooltipValue = "";

            // dateTrans
            $this->dateTrans->LinkCustomAttributes = "";
            $this->dateTrans->HrefValue = "";

            // receiptNumber
            $this->receiptNumber->LinkCustomAttributes = "";
            $this->receiptNumber->HrefValue = "";

            // receipt
            $this->receipt->LinkCustomAttributes = "";
            if (!empty($this->receipt->Upload->DbValue)) {
                $this->receipt->HrefValue = GetFileUploadUrl($this->receipt, $this->id->CurrentValue);
                $this->receipt->LinkAttrs["target"] = "";
                if ($this->receipt->IsBlobImage && empty($this->receipt->LinkAttrs["target"])) {
                    $this->receipt->LinkAttrs["target"] = "_blank";
                }
                if ($this->isExport()) {
                    $this->receipt->HrefValue = FullUrl($this->receipt->HrefValue, "href");
                }
            } else {
                $this->receipt->HrefValue = "";
            }
            $this->receipt->ExportHrefValue = GetFileUploadUrl($this->receipt, $this->id->CurrentValue);

            // note
            $this->note->LinkCustomAttributes = "";
            $this->note->HrefValue = "";

            // submittedBy
            $this->submittedBy->LinkCustomAttributes = "";
            $this->submittedBy->HrefValue = "";
            $this->submittedBy->TooltipValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";
            $this->status->TooltipValue = "";

            // dateClosed
            $this->dateClosed->LinkCustomAttributes = "";
            $this->dateClosed->HrefValue = "";
            $this->dateClosed->TooltipValue = "";

            // float_status
            $this->float_status->LinkCustomAttributes = "";
            $this->float_status->HrefValue = "";
            $this->float_status->TooltipValue = "";

            // validatedBy
            $this->validatedBy->LinkCustomAttributes = "";
            $this->validatedBy->HrefValue = "";
            $this->validatedBy->TooltipValue = "";

            // machine_id
            $this->machine_id->LinkCustomAttributes = "";
            $this->machine_id->HrefValue = "";
            $this->machine_id->TooltipValue = "";

            // cash_float
            $this->cash_float->LinkCustomAttributes = "";
            $this->cash_float->HrefValue = "";
            $this->cash_float->TooltipValue = "";

            // expCategory_id
            $this->expCategory_id->LinkCustomAttributes = "";
            $this->expCategory_id->HrefValue = "";
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
        global $Language;

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
        if ($this->cashAdvance_id->Required) {
            if (!$this->cashAdvance_id->IsDetailKey && EmptyValue($this->cashAdvance_id->FormValue)) {
                $this->cashAdvance_id->addErrorMessage(str_replace("%s", $this->cashAdvance_id->caption(), $this->cashAdvance_id->RequiredErrorMessage));
            }
        }
        if ($this->amount->Required) {
            if (!$this->amount->IsDetailKey && EmptyValue($this->amount->FormValue)) {
                $this->amount->addErrorMessage(str_replace("%s", $this->amount->caption(), $this->amount->RequiredErrorMessage));
            }
        }
        if ($this->dateTrans->Required) {
            if (!$this->dateTrans->IsDetailKey && EmptyValue($this->dateTrans->FormValue)) {
                $this->dateTrans->addErrorMessage(str_replace("%s", $this->dateTrans->caption(), $this->dateTrans->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->dateTrans->FormValue, $this->dateTrans->formatPattern())) {
            $this->dateTrans->addErrorMessage($this->dateTrans->getErrorMessage(false));
        }
        if ($this->receiptNumber->Required) {
            if (!$this->receiptNumber->IsDetailKey && EmptyValue($this->receiptNumber->FormValue)) {
                $this->receiptNumber->addErrorMessage(str_replace("%s", $this->receiptNumber->caption(), $this->receiptNumber->RequiredErrorMessage));
            }
        }
        if ($this->receipt->Required) {
            if ($this->receipt->Upload->FileName == "" && !$this->receipt->Upload->KeepFile) {
                $this->receipt->addErrorMessage(str_replace("%s", $this->receipt->caption(), $this->receipt->RequiredErrorMessage));
            }
        }
        if ($this->note->Required) {
            if (!$this->note->IsDetailKey && EmptyValue($this->note->FormValue)) {
                $this->note->addErrorMessage(str_replace("%s", $this->note->caption(), $this->note->RequiredErrorMessage));
            }
        }
        if ($this->submittedBy->Required) {
            if (!$this->submittedBy->IsDetailKey && EmptyValue($this->submittedBy->FormValue)) {
                $this->submittedBy->addErrorMessage(str_replace("%s", $this->submittedBy->caption(), $this->submittedBy->RequiredErrorMessage));
            }
        }
        if ($this->status->Required) {
            if ($this->status->FormValue == "") {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->dateClosed->Required) {
            if (!$this->dateClosed->IsDetailKey && EmptyValue($this->dateClosed->FormValue)) {
                $this->dateClosed->addErrorMessage(str_replace("%s", $this->dateClosed->caption(), $this->dateClosed->RequiredErrorMessage));
            }
        }
        if ($this->float_status->Required) {
            if ($this->float_status->FormValue == "") {
                $this->float_status->addErrorMessage(str_replace("%s", $this->float_status->caption(), $this->float_status->RequiredErrorMessage));
            }
        }
        if ($this->validatedBy->Required) {
            if (!$this->validatedBy->IsDetailKey && EmptyValue($this->validatedBy->FormValue)) {
                $this->validatedBy->addErrorMessage(str_replace("%s", $this->validatedBy->caption(), $this->validatedBy->RequiredErrorMessage));
            }
        }
        if ($this->machine_id->Required) {
            if (!$this->machine_id->IsDetailKey && EmptyValue($this->machine_id->FormValue)) {
                $this->machine_id->addErrorMessage(str_replace("%s", $this->machine_id->caption(), $this->machine_id->RequiredErrorMessage));
            }
        }
        if ($this->cash_float->Required) {
            if (!$this->cash_float->IsDetailKey && EmptyValue($this->cash_float->FormValue)) {
                $this->cash_float->addErrorMessage(str_replace("%s", $this->cash_float->caption(), $this->cash_float->RequiredErrorMessage));
            }
        }
        if ($this->expCategory_id->Required) {
            if (!$this->expCategory_id->IsDetailKey && EmptyValue($this->expCategory_id->FormValue)) {
                $this->expCategory_id->addErrorMessage(str_replace("%s", $this->expCategory_id->caption(), $this->expCategory_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->expCategory_id->FormValue)) {
            $this->expCategory_id->addErrorMessage($this->expCategory_id->getErrorMessage(false));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        if ($this->receiptNumber->CurrentValue != "") { // Check field with unique index
            $filterChk = "(`receiptNumber` = '" . AdjustSql($this->receiptNumber->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->receiptNumber->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->receiptNumber->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // dateTrans
            $this->dateTrans->setDbValueDef($rsnew, UnFormatDateTime($this->dateTrans->CurrentValue, $this->dateTrans->formatPattern()), null, $this->dateTrans->ReadOnly);

            // receiptNumber
            $this->receiptNumber->setDbValueDef($rsnew, $this->receiptNumber->CurrentValue, null, $this->receiptNumber->ReadOnly);

            // receipt
            if ($this->receipt->Visible && !$this->receipt->ReadOnly && !$this->receipt->Upload->KeepFile) {
                if ($this->receipt->Upload->Value === null) {
                    $rsnew['receipt'] = null;
                } else {
                    $rsnew['receipt'] = $this->receipt->Upload->Value;
                }
            }

            // note
            $this->note->setDbValueDef($rsnew, $this->note->CurrentValue, null, $this->note->ReadOnly);

            // expCategory_id
            $this->expCategory_id->setDbValueDef($rsnew, $this->expCategory_id->CurrentValue, 0, $this->expCategory_id->ReadOnly);

            // Check hash value
            $rowHasConflict = (!IsApi() && $this->getRowHash($rsold) != $this->HashValue);

            // Call Row Update Conflict event
            if ($rowHasConflict) {
                $rowHasConflict = $this->rowUpdateConflict($rsold, $rsnew);
            }
            if ($rowHasConflict) {
                $this->setFailureMessage($Language->phrase("RecordChangedByOtherUser"));
                $this->UpdateConflict = "U";
                return false; // Update Failed
            }

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    $editRow = $this->update($rsnew, "", $rsold);
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
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
            // receipt
            CleanUploadTempPath($this->receipt, $this->receipt->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Load row hash
    protected function loadRowHash()
    {
        $filter = $this->getRecordFilter();

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $row = $conn->fetchAssociative($sql);
        $this->HashValue = $row ? $this->getRowHash($row) : ""; // Get hash value for record
    }

    // Get Row Hash
    public function getRowHash(&$rs)
    {
        if (!$rs) {
            return "";
        }
        $row = ($rs instanceof Recordset) ? $rs->fields : $rs;
        $hash = "";
        $hash .= GetFieldHash($row['dateTrans']); // dateTrans
        $hash .= GetFieldHash($row['receiptNumber']); // receiptNumber
        $hash .= GetFieldHash($row['receipt']); // receipt
        $hash .= GetFieldHash($row['note']); // note
        $hash .= GetFieldHash($row['expCategory_id']); // expCategory_id
        return md5($hash);
    }

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->submittedBy->CurrentValue);
        }
        return true;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("EmpExpenseList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_cashAdvance_id":
                    $lookupFilter = function () {
                        return "`submittedBy` = '" . CurrentUserName() . "' AND `used` = '0' AND `status` = '1'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_status":
                    break;
                case "x_float_status":
                    break;
                case "x_machine_id":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $ar[strval($row["lf"])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            if ($startRec !== null && is_numeric($startRec)) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
