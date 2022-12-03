<?php

namespace PHPMaker2022\efga_expense_system;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class EmpExpenseAdd extends EmpExpense
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'emp_expense';

    // Page object name
    public $PageObjName = "EmpExpenseAdd";

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
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

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
        $this->id->Visible = false;
        $this->cashAdvance_id->setVisibility();
        $this->amount->setVisibility();
        $this->dateTrans->setVisibility();
        $this->receiptNumber->setVisibility();
        $this->receipt->setVisibility();
        $this->note->setVisibility();
        $this->submittedBy->Visible = false;
        $this->status->Visible = false;
        $this->dateClosed->Visible = false;
        $this->float_status->Visible = false;
        $this->validatedBy->Visible = false;
        $this->machine_id->setVisibility();
        $this->cash_float->Visible = false;
        $this->expCategory_id->Visible = false;
        $this->hideFieldsForAddEdit();

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
        $this->FormClassName = "ew-form ew-add-form";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
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
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

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
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("EmpExpenseList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "EmpExpenseList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "EmpExpenseView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
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
        if ($this->isConfirm()) { // Confirm page
            $this->RowType = ROWTYPE_VIEW; // Render view type
        } else {
            $this->RowType = ROWTYPE_ADD; // Render add type
        }

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
        $this->receipt->Upload->Index = $CurrentForm->Index;
        $this->receipt->Upload->uploadFile();
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->cashAdvance_id->CurrentValue = null;
        $this->cashAdvance_id->OldValue = $this->cashAdvance_id->CurrentValue;
        $this->amount->CurrentValue = null;
        $this->amount->OldValue = $this->amount->CurrentValue;
        $this->dateTrans->CurrentValue = null;
        $this->dateTrans->OldValue = $this->dateTrans->CurrentValue;
        $this->receiptNumber->CurrentValue = null;
        $this->receiptNumber->OldValue = $this->receiptNumber->CurrentValue;
        $this->receipt->Upload->DbValue = null;
        $this->receipt->OldValue = $this->receipt->Upload->DbValue;
        $this->note->CurrentValue = null;
        $this->note->OldValue = $this->note->CurrentValue;
        $this->submittedBy->CurrentValue = CurrentUserID();
        $this->status->CurrentValue = 0;
        $this->dateClosed->CurrentValue = null;
        $this->dateClosed->OldValue = $this->dateClosed->CurrentValue;
        $this->float_status->CurrentValue = 0;
        $this->validatedBy->CurrentValue = null;
        $this->validatedBy->OldValue = $this->validatedBy->CurrentValue;
        $this->machine_id->CurrentValue = null;
        $this->machine_id->OldValue = $this->machine_id->CurrentValue;
        $this->cash_float->CurrentValue = null;
        $this->cash_float->OldValue = $this->cash_float->CurrentValue;
        $this->expCategory_id->CurrentValue = null;
        $this->expCategory_id->OldValue = $this->expCategory_id->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

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
                $this->amount->setFormValue($val, true, $validate);
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

        // Check field name 'machine_id' first before field var 'x_machine_id'
        $val = $CurrentForm->hasValue("machine_id") ? $CurrentForm->getValue("machine_id") : $CurrentForm->getValue("x_machine_id");
        if (!$this->machine_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->machine_id->Visible = false; // Disable update for API request
            } else {
                $this->machine_id->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->cashAdvance_id->CurrentValue = $this->cashAdvance_id->FormValue;
        $this->amount->CurrentValue = $this->amount->FormValue;
        $this->dateTrans->CurrentValue = $this->dateTrans->FormValue;
        $this->dateTrans->CurrentValue = UnFormatDateTime($this->dateTrans->CurrentValue, $this->dateTrans->formatPattern());
        $this->receiptNumber->CurrentValue = $this->receiptNumber->FormValue;
        $this->note->CurrentValue = $this->note->FormValue;
        $this->machine_id->CurrentValue = $this->machine_id->FormValue;
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

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("add");
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
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['cashAdvance_id'] = $this->cashAdvance_id->CurrentValue;
        $row['amount'] = $this->amount->CurrentValue;
        $row['dateTrans'] = $this->dateTrans->CurrentValue;
        $row['receiptNumber'] = $this->receiptNumber->CurrentValue;
        $row['receipt'] = $this->receipt->Upload->DbValue;
        $row['note'] = $this->note->CurrentValue;
        $row['submittedBy'] = $this->submittedBy->CurrentValue;
        $row['status'] = $this->status->CurrentValue;
        $row['dateClosed'] = $this->dateClosed->CurrentValue;
        $row['float_status'] = $this->float_status->CurrentValue;
        $row['validatedBy'] = $this->validatedBy->CurrentValue;
        $row['machine_id'] = $this->machine_id->CurrentValue;
        $row['cash_float'] = $this->cash_float->CurrentValue;
        $row['expCategory_id'] = $this->expCategory_id->CurrentValue;
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

            // machine_id
            $this->machine_id->LinkCustomAttributes = "";
            $this->machine_id->HrefValue = "";
            $this->machine_id->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // cashAdvance_id
            $this->cashAdvance_id->setupEditAttributes();
            $this->cashAdvance_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->cashAdvance_id->CurrentValue));
            if ($curVal != "") {
                $this->cashAdvance_id->ViewValue = $this->cashAdvance_id->lookupCacheOption($curVal);
            } else {
                $this->cashAdvance_id->ViewValue = $this->cashAdvance_id->Lookup !== null && is_array($this->cashAdvance_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->cashAdvance_id->ViewValue !== null) { // Load from cache
                $this->cashAdvance_id->EditValue = array_values($this->cashAdvance_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->cashAdvance_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "`submittedBy` = '" . CurrentUserName() . "' AND `used` = '0' AND `status` = '1'";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->cashAdvance_id->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->cashAdvance_id->Lookup->renderViewRow($row);
                }
                $this->cashAdvance_id->EditValue = $arwrk;
            }
            $this->cashAdvance_id->PlaceHolder = RemoveHtml($this->cashAdvance_id->caption());

            // amount
            $this->amount->setupEditAttributes();
            $this->amount->EditCustomAttributes = "";
            $this->amount->EditValue = HtmlEncode($this->amount->CurrentValue);
            $this->amount->PlaceHolder = RemoveHtml($this->amount->caption());
            if (strval($this->amount->EditValue) != "" && is_numeric($this->amount->EditValue)) {
                $this->amount->EditValue = FormatNumber($this->amount->EditValue, null);
            }

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
            if ($this->isShow() || $this->isCopy()) {
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

            // machine_id
            $this->machine_id->setupEditAttributes();
            $this->machine_id->EditCustomAttributes = "";
            $curVal = trim(strval($this->machine_id->CurrentValue));
            if ($curVal != "") {
                $this->machine_id->ViewValue = $this->machine_id->lookupCacheOption($curVal);
            } else {
                $this->machine_id->ViewValue = $this->machine_id->Lookup !== null && is_array($this->machine_id->lookupOptions()) ? $curVal : null;
            }
            if ($this->machine_id->ViewValue !== null) { // Load from cache
                $this->machine_id->EditValue = array_values($this->machine_id->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->machine_id->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->machine_id->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                foreach ($arwrk as &$row) {
                    $row = $this->machine_id->Lookup->renderViewRow($row);
                }
                $this->machine_id->EditValue = $arwrk;
            }
            $this->machine_id->PlaceHolder = RemoveHtml($this->machine_id->caption());

            // Add refer script

            // cashAdvance_id
            $this->cashAdvance_id->LinkCustomAttributes = "";
            $this->cashAdvance_id->HrefValue = "";

            // amount
            $this->amount->LinkCustomAttributes = "";
            $this->amount->HrefValue = "";

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

            // machine_id
            $this->machine_id->LinkCustomAttributes = "";
            $this->machine_id->HrefValue = "";
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
        if (!CheckInteger($this->amount->FormValue)) {
            $this->amount->addErrorMessage($this->amount->getErrorMessage(false));
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
        if ($this->machine_id->Required) {
            if (!$this->machine_id->IsDetailKey && EmptyValue($this->machine_id->FormValue)) {
                $this->machine_id->addErrorMessage(str_replace("%s", $this->machine_id->caption(), $this->machine_id->RequiredErrorMessage));
            }
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

        // Check if valid User ID
        $validUser = false;
        if ($Security->currentUserID() != "" && !EmptyValue($this->submittedBy->CurrentValue) && !$Security->isAdmin()) { // Non system admin
            $validUser = $Security->isValidUserID($this->submittedBy->CurrentValue);
            if (!$validUser) {
                $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
                $userIdMsg = str_replace("%u", $this->submittedBy->CurrentValue, $userIdMsg);
                $this->setFailureMessage($userIdMsg);
                return false;
            }
        }
        if ($this->receiptNumber->CurrentValue != "") { // Check field with unique index
            $filter = "(`receiptNumber` = '" . AdjustSql($this->receiptNumber->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->receiptNumber->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->receiptNumber->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // cashAdvance_id
        $this->cashAdvance_id->setDbValueDef($rsnew, $this->cashAdvance_id->CurrentValue, null, false);

        // amount
        $this->amount->setDbValueDef($rsnew, $this->amount->CurrentValue, null, false);

        // dateTrans
        $this->dateTrans->setDbValueDef($rsnew, UnFormatDateTime($this->dateTrans->CurrentValue, $this->dateTrans->formatPattern()), null, false);

        // receiptNumber
        $this->receiptNumber->setDbValueDef($rsnew, $this->receiptNumber->CurrentValue, null, false);

        // receipt
        if ($this->receipt->Visible && !$this->receipt->Upload->KeepFile) {
            if ($this->receipt->Upload->Value === null) {
                $rsnew['receipt'] = null;
            } else {
                $rsnew['receipt'] = $this->receipt->Upload->Value;
            }
        }

        // note
        $this->note->setDbValueDef($rsnew, $this->note->CurrentValue, null, false);

        // machine_id
        $this->machine_id->setDbValueDef($rsnew, $this->machine_id->CurrentValue, null, false);

        // submittedBy
        if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin
            $rsnew['submittedBy'] = CurrentUserID();
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
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

        // Clean upload path if any
        if ($addRow) {
            // receipt
            CleanUploadTempPath($this->receipt, $this->receipt->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
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
