<?php

namespace PHPMaker2022\efga_expense_system;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class ManExpenseAdd extends ManExpense
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'man_expense';

    // Page object name
    public $PageObjName = "ManExpenseAdd";

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

        // Table object (man_expense)
        if (!isset($GLOBALS["man_expense"]) || get_class($GLOBALS["man_expense"]) == PROJECT_NAMESPACE . "man_expense") {
            $GLOBALS["man_expense"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'man_expense');
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
                $tbl = Container("man_expense");
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
                    if ($pageName == "ManExpenseView") {
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
        $this->expCategory->setVisibility();
        $this->expSubcategory->setVisibility();
        $this->amount->setVisibility();
        $this->receipt->setVisibility();
        $this->receiptNumber->setVisibility();
        $this->date->setVisibility();
        $this->dateFrom->setVisibility();
        $this->dateTo->setVisibility();
        $this->consumption->setVisibility();
        $this->note->setVisibility();
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
        $this->setupLookupOptions($this->expCategory);
        $this->setupLookupOptions($this->expSubcategory);

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
                    $this->terminate("ManExpenseList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "ManExpenseList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "ManExpenseView") {
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
        $this->receipt->Upload->Index = $CurrentForm->Index;
        $this->receipt->Upload->uploadFile();
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->expCategory->CurrentValue = null;
        $this->expCategory->OldValue = $this->expCategory->CurrentValue;
        $this->expSubcategory->CurrentValue = null;
        $this->expSubcategory->OldValue = $this->expSubcategory->CurrentValue;
        $this->amount->CurrentValue = null;
        $this->amount->OldValue = $this->amount->CurrentValue;
        $this->receipt->Upload->DbValue = null;
        $this->receipt->OldValue = $this->receipt->Upload->DbValue;
        $this->receiptNumber->CurrentValue = null;
        $this->receiptNumber->OldValue = $this->receiptNumber->CurrentValue;
        $this->date->CurrentValue = null;
        $this->date->OldValue = $this->date->CurrentValue;
        $this->dateFrom->CurrentValue = null;
        $this->dateFrom->OldValue = $this->dateFrom->CurrentValue;
        $this->dateTo->CurrentValue = null;
        $this->dateTo->OldValue = $this->dateTo->CurrentValue;
        $this->consumption->CurrentValue = null;
        $this->consumption->OldValue = $this->consumption->CurrentValue;
        $this->note->CurrentValue = null;
        $this->note->OldValue = $this->note->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'expCategory' first before field var 'x_expCategory'
        $val = $CurrentForm->hasValue("expCategory") ? $CurrentForm->getValue("expCategory") : $CurrentForm->getValue("x_expCategory");
        if (!$this->expCategory->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->expCategory->Visible = false; // Disable update for API request
            } else {
                $this->expCategory->setFormValue($val);
            }
        }

        // Check field name 'expSubcategory' first before field var 'x_expSubcategory'
        $val = $CurrentForm->hasValue("expSubcategory") ? $CurrentForm->getValue("expSubcategory") : $CurrentForm->getValue("x_expSubcategory");
        if (!$this->expSubcategory->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->expSubcategory->Visible = false; // Disable update for API request
            } else {
                $this->expSubcategory->setFormValue($val);
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

        // Check field name 'receiptNumber' first before field var 'x_receiptNumber'
        $val = $CurrentForm->hasValue("receiptNumber") ? $CurrentForm->getValue("receiptNumber") : $CurrentForm->getValue("x_receiptNumber");
        if (!$this->receiptNumber->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->receiptNumber->Visible = false; // Disable update for API request
            } else {
                $this->receiptNumber->setFormValue($val);
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

        // Check field name 'dateFrom' first before field var 'x_dateFrom'
        $val = $CurrentForm->hasValue("dateFrom") ? $CurrentForm->getValue("dateFrom") : $CurrentForm->getValue("x_dateFrom");
        if (!$this->dateFrom->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dateFrom->Visible = false; // Disable update for API request
            } else {
                $this->dateFrom->setFormValue($val, true, $validate);
            }
            $this->dateFrom->CurrentValue = UnFormatDateTime($this->dateFrom->CurrentValue, $this->dateFrom->formatPattern());
        }

        // Check field name 'dateTo' first before field var 'x_dateTo'
        $val = $CurrentForm->hasValue("dateTo") ? $CurrentForm->getValue("dateTo") : $CurrentForm->getValue("x_dateTo");
        if (!$this->dateTo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dateTo->Visible = false; // Disable update for API request
            } else {
                $this->dateTo->setFormValue($val, true, $validate);
            }
            $this->dateTo->CurrentValue = UnFormatDateTime($this->dateTo->CurrentValue, $this->dateTo->formatPattern());
        }

        // Check field name 'consumption' first before field var 'x_consumption'
        $val = $CurrentForm->hasValue("consumption") ? $CurrentForm->getValue("consumption") : $CurrentForm->getValue("x_consumption");
        if (!$this->consumption->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->consumption->Visible = false; // Disable update for API request
            } else {
                $this->consumption->setFormValue($val, true, $validate);
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

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->expCategory->CurrentValue = $this->expCategory->FormValue;
        $this->expSubcategory->CurrentValue = $this->expSubcategory->FormValue;
        $this->amount->CurrentValue = $this->amount->FormValue;
        $this->receiptNumber->CurrentValue = $this->receiptNumber->FormValue;
        $this->date->CurrentValue = $this->date->FormValue;
        $this->date->CurrentValue = UnFormatDateTime($this->date->CurrentValue, $this->date->formatPattern());
        $this->dateFrom->CurrentValue = $this->dateFrom->FormValue;
        $this->dateFrom->CurrentValue = UnFormatDateTime($this->dateFrom->CurrentValue, $this->dateFrom->formatPattern());
        $this->dateTo->CurrentValue = $this->dateTo->FormValue;
        $this->dateTo->CurrentValue = UnFormatDateTime($this->dateTo->CurrentValue, $this->dateTo->formatPattern());
        $this->consumption->CurrentValue = $this->consumption->FormValue;
        $this->note->CurrentValue = $this->note->FormValue;
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
        $this->expCategory->setDbValue($row['expCategory']);
        $this->expSubcategory->setDbValue($row['expSubcategory']);
        $this->amount->setDbValue($row['amount']);
        $this->receipt->Upload->DbValue = $row['receipt'];
        if (is_resource($this->receipt->Upload->DbValue) && get_resource_type($this->receipt->Upload->DbValue) == "stream") { // Byte array
            $this->receipt->Upload->DbValue = stream_get_contents($this->receipt->Upload->DbValue);
        }
        $this->receiptNumber->setDbValue($row['receiptNumber']);
        $this->date->setDbValue($row['date']);
        $this->dateFrom->setDbValue($row['dateFrom']);
        $this->dateTo->setDbValue($row['dateTo']);
        $this->consumption->setDbValue($row['consumption']);
        $this->note->setDbValue($row['note']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['expCategory'] = $this->expCategory->CurrentValue;
        $row['expSubcategory'] = $this->expSubcategory->CurrentValue;
        $row['amount'] = $this->amount->CurrentValue;
        $row['receipt'] = $this->receipt->Upload->DbValue;
        $row['receiptNumber'] = $this->receiptNumber->CurrentValue;
        $row['date'] = $this->date->CurrentValue;
        $row['dateFrom'] = $this->dateFrom->CurrentValue;
        $row['dateTo'] = $this->dateTo->CurrentValue;
        $row['consumption'] = $this->consumption->CurrentValue;
        $row['note'] = $this->note->CurrentValue;
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

        // expCategory
        $this->expCategory->RowCssClass = "row";

        // expSubcategory
        $this->expSubcategory->RowCssClass = "row";

        // amount
        $this->amount->RowCssClass = "row";

        // receipt
        $this->receipt->RowCssClass = "row";

        // receiptNumber
        $this->receiptNumber->RowCssClass = "row";

        // date
        $this->date->RowCssClass = "row";

        // dateFrom
        $this->dateFrom->RowCssClass = "row";

        // dateTo
        $this->dateTo->RowCssClass = "row";

        // consumption
        $this->consumption->RowCssClass = "row";

        // note
        $this->note->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // expCategory
            $curVal = strval($this->expCategory->CurrentValue);
            if ($curVal != "") {
                $this->expCategory->ViewValue = $this->expCategory->lookupCacheOption($curVal);
                if ($this->expCategory->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->expCategory->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->expCategory->Lookup->renderViewRow($rswrk[0]);
                        $this->expCategory->ViewValue = $this->expCategory->displayValue($arwrk);
                    } else {
                        $this->expCategory->ViewValue = FormatNumber($this->expCategory->CurrentValue, $this->expCategory->formatPattern());
                    }
                }
            } else {
                $this->expCategory->ViewValue = null;
            }
            $this->expCategory->ViewCustomAttributes = "";

            // expSubcategory
            $curVal = strval($this->expSubcategory->CurrentValue);
            if ($curVal != "") {
                $this->expSubcategory->ViewValue = $this->expSubcategory->lookupCacheOption($curVal);
                if ($this->expSubcategory->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->expSubcategory->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->expSubcategory->Lookup->renderViewRow($rswrk[0]);
                        $this->expSubcategory->ViewValue = $this->expSubcategory->displayValue($arwrk);
                    } else {
                        $this->expSubcategory->ViewValue = FormatNumber($this->expSubcategory->CurrentValue, $this->expSubcategory->formatPattern());
                    }
                }
            } else {
                $this->expSubcategory->ViewValue = null;
            }
            $this->expSubcategory->ViewCustomAttributes = "";

            // amount
            $this->amount->ViewValue = $this->amount->CurrentValue;
            $this->amount->ViewValue = FormatNumber($this->amount->ViewValue, $this->amount->formatPattern());
            $this->amount->ViewCustomAttributes = "";

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

            // receiptNumber
            $this->receiptNumber->ViewValue = $this->receiptNumber->CurrentValue;
            $this->receiptNumber->ViewCustomAttributes = "";

            // date
            $this->date->ViewValue = $this->date->CurrentValue;
            $this->date->ViewValue = FormatDateTime($this->date->ViewValue, $this->date->formatPattern());
            $this->date->ViewCustomAttributes = "";

            // dateFrom
            $this->dateFrom->ViewValue = $this->dateFrom->CurrentValue;
            $this->dateFrom->ViewValue = FormatDateTime($this->dateFrom->ViewValue, $this->dateFrom->formatPattern());
            $this->dateFrom->ViewCustomAttributes = "";

            // dateTo
            $this->dateTo->ViewValue = $this->dateTo->CurrentValue;
            $this->dateTo->ViewValue = FormatDateTime($this->dateTo->ViewValue, $this->dateTo->formatPattern());
            $this->dateTo->ViewCustomAttributes = "";

            // consumption
            $this->consumption->ViewValue = $this->consumption->CurrentValue;
            $this->consumption->ViewValue = FormatNumber($this->consumption->ViewValue, $this->consumption->formatPattern());
            $this->consumption->ViewCustomAttributes = "";

            // note
            $this->note->ViewValue = $this->note->CurrentValue;
            $this->note->ViewCustomAttributes = "";

            // expCategory
            $this->expCategory->LinkCustomAttributes = "";
            $this->expCategory->HrefValue = "";

            // expSubcategory
            $this->expSubcategory->LinkCustomAttributes = "";
            $this->expSubcategory->HrefValue = "";

            // amount
            $this->amount->LinkCustomAttributes = "";
            $this->amount->HrefValue = "";

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

            // receiptNumber
            $this->receiptNumber->LinkCustomAttributes = "";
            $this->receiptNumber->HrefValue = "";

            // date
            $this->date->LinkCustomAttributes = "";
            $this->date->HrefValue = "";

            // dateFrom
            $this->dateFrom->LinkCustomAttributes = "";
            $this->dateFrom->HrefValue = "";

            // dateTo
            $this->dateTo->LinkCustomAttributes = "";
            $this->dateTo->HrefValue = "";

            // consumption
            $this->consumption->LinkCustomAttributes = "";
            $this->consumption->HrefValue = "";

            // note
            $this->note->LinkCustomAttributes = "";
            $this->note->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // expCategory
            $this->expCategory->setupEditAttributes();
            $this->expCategory->EditCustomAttributes = "";
            $curVal = trim(strval($this->expCategory->CurrentValue));
            if ($curVal != "") {
                $this->expCategory->ViewValue = $this->expCategory->lookupCacheOption($curVal);
            } else {
                $this->expCategory->ViewValue = $this->expCategory->Lookup !== null && is_array($this->expCategory->lookupOptions()) ? $curVal : null;
            }
            if ($this->expCategory->ViewValue !== null) { // Load from cache
                $this->expCategory->EditValue = array_values($this->expCategory->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->expCategory->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->expCategory->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->expCategory->EditValue = $arwrk;
            }
            $this->expCategory->PlaceHolder = RemoveHtml($this->expCategory->caption());

            // expSubcategory
            $this->expSubcategory->setupEditAttributes();
            $this->expSubcategory->EditCustomAttributes = "";
            $curVal = trim(strval($this->expSubcategory->CurrentValue));
            if ($curVal != "") {
                $this->expSubcategory->ViewValue = $this->expSubcategory->lookupCacheOption($curVal);
            } else {
                $this->expSubcategory->ViewValue = $this->expSubcategory->Lookup !== null && is_array($this->expSubcategory->lookupOptions()) ? $curVal : null;
            }
            if ($this->expSubcategory->ViewValue !== null) { // Load from cache
                $this->expSubcategory->EditValue = array_values($this->expSubcategory->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->expSubcategory->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->expSubcategory->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->expSubcategory->EditValue = $arwrk;
            }
            $this->expSubcategory->PlaceHolder = RemoveHtml($this->expSubcategory->caption());

            // amount
            $this->amount->setupEditAttributes();
            $this->amount->EditCustomAttributes = "";
            $this->amount->EditValue = HtmlEncode($this->amount->CurrentValue);
            $this->amount->PlaceHolder = RemoveHtml($this->amount->caption());
            if (strval($this->amount->EditValue) != "" && is_numeric($this->amount->EditValue)) {
                $this->amount->EditValue = FormatNumber($this->amount->EditValue, null);
            }

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

            // receiptNumber
            $this->receiptNumber->setupEditAttributes();
            $this->receiptNumber->EditCustomAttributes = "";
            if (!$this->receiptNumber->Raw) {
                $this->receiptNumber->CurrentValue = HtmlDecode($this->receiptNumber->CurrentValue);
            }
            $this->receiptNumber->EditValue = HtmlEncode($this->receiptNumber->CurrentValue);
            $this->receiptNumber->PlaceHolder = RemoveHtml($this->receiptNumber->caption());

            // date
            $this->date->setupEditAttributes();
            $this->date->EditCustomAttributes = "";
            $this->date->EditValue = HtmlEncode(FormatDateTime($this->date->CurrentValue, $this->date->formatPattern()));
            $this->date->PlaceHolder = RemoveHtml($this->date->caption());

            // dateFrom
            $this->dateFrom->setupEditAttributes();
            $this->dateFrom->EditCustomAttributes = "";
            $this->dateFrom->EditValue = HtmlEncode(FormatDateTime($this->dateFrom->CurrentValue, $this->dateFrom->formatPattern()));
            $this->dateFrom->PlaceHolder = RemoveHtml($this->dateFrom->caption());

            // dateTo
            $this->dateTo->setupEditAttributes();
            $this->dateTo->EditCustomAttributes = "";
            $this->dateTo->EditValue = HtmlEncode(FormatDateTime($this->dateTo->CurrentValue, $this->dateTo->formatPattern()));
            $this->dateTo->PlaceHolder = RemoveHtml($this->dateTo->caption());

            // consumption
            $this->consumption->setupEditAttributes();
            $this->consumption->EditCustomAttributes = "";
            $this->consumption->EditValue = HtmlEncode($this->consumption->CurrentValue);
            $this->consumption->PlaceHolder = RemoveHtml($this->consumption->caption());
            if (strval($this->consumption->EditValue) != "" && is_numeric($this->consumption->EditValue)) {
                $this->consumption->EditValue = FormatNumber($this->consumption->EditValue, null);
            }

            // note
            $this->note->setupEditAttributes();
            $this->note->EditCustomAttributes = "";
            if (!$this->note->Raw) {
                $this->note->CurrentValue = HtmlDecode($this->note->CurrentValue);
            }
            $this->note->EditValue = HtmlEncode($this->note->CurrentValue);
            $this->note->PlaceHolder = RemoveHtml($this->note->caption());

            // Add refer script

            // expCategory
            $this->expCategory->LinkCustomAttributes = "";
            $this->expCategory->HrefValue = "";

            // expSubcategory
            $this->expSubcategory->LinkCustomAttributes = "";
            $this->expSubcategory->HrefValue = "";

            // amount
            $this->amount->LinkCustomAttributes = "";
            $this->amount->HrefValue = "";

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

            // receiptNumber
            $this->receiptNumber->LinkCustomAttributes = "";
            $this->receiptNumber->HrefValue = "";

            // date
            $this->date->LinkCustomAttributes = "";
            $this->date->HrefValue = "";

            // dateFrom
            $this->dateFrom->LinkCustomAttributes = "";
            $this->dateFrom->HrefValue = "";

            // dateTo
            $this->dateTo->LinkCustomAttributes = "";
            $this->dateTo->HrefValue = "";

            // consumption
            $this->consumption->LinkCustomAttributes = "";
            $this->consumption->HrefValue = "";

            // note
            $this->note->LinkCustomAttributes = "";
            $this->note->HrefValue = "";
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
        if ($this->expCategory->Required) {
            if (!$this->expCategory->IsDetailKey && EmptyValue($this->expCategory->FormValue)) {
                $this->expCategory->addErrorMessage(str_replace("%s", $this->expCategory->caption(), $this->expCategory->RequiredErrorMessage));
            }
        }
        if ($this->expSubcategory->Required) {
            if (!$this->expSubcategory->IsDetailKey && EmptyValue($this->expSubcategory->FormValue)) {
                $this->expSubcategory->addErrorMessage(str_replace("%s", $this->expSubcategory->caption(), $this->expSubcategory->RequiredErrorMessage));
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
        if ($this->receipt->Required) {
            if ($this->receipt->Upload->FileName == "" && !$this->receipt->Upload->KeepFile) {
                $this->receipt->addErrorMessage(str_replace("%s", $this->receipt->caption(), $this->receipt->RequiredErrorMessage));
            }
        }
        if ($this->receiptNumber->Required) {
            if (!$this->receiptNumber->IsDetailKey && EmptyValue($this->receiptNumber->FormValue)) {
                $this->receiptNumber->addErrorMessage(str_replace("%s", $this->receiptNumber->caption(), $this->receiptNumber->RequiredErrorMessage));
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
        if ($this->dateFrom->Required) {
            if (!$this->dateFrom->IsDetailKey && EmptyValue($this->dateFrom->FormValue)) {
                $this->dateFrom->addErrorMessage(str_replace("%s", $this->dateFrom->caption(), $this->dateFrom->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->dateFrom->FormValue, $this->dateFrom->formatPattern())) {
            $this->dateFrom->addErrorMessage($this->dateFrom->getErrorMessage(false));
        }
        if ($this->dateTo->Required) {
            if (!$this->dateTo->IsDetailKey && EmptyValue($this->dateTo->FormValue)) {
                $this->dateTo->addErrorMessage(str_replace("%s", $this->dateTo->caption(), $this->dateTo->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->dateTo->FormValue, $this->dateTo->formatPattern())) {
            $this->dateTo->addErrorMessage($this->dateTo->getErrorMessage(false));
        }
        if ($this->consumption->Required) {
            if (!$this->consumption->IsDetailKey && EmptyValue($this->consumption->FormValue)) {
                $this->consumption->addErrorMessage(str_replace("%s", $this->consumption->caption(), $this->consumption->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->consumption->FormValue)) {
            $this->consumption->addErrorMessage($this->consumption->getErrorMessage(false));
        }
        if ($this->note->Required) {
            if (!$this->note->IsDetailKey && EmptyValue($this->note->FormValue)) {
                $this->note->addErrorMessage(str_replace("%s", $this->note->caption(), $this->note->RequiredErrorMessage));
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

        // expCategory
        $this->expCategory->setDbValueDef($rsnew, $this->expCategory->CurrentValue, null, false);

        // expSubcategory
        $this->expSubcategory->setDbValueDef($rsnew, $this->expSubcategory->CurrentValue, null, false);

        // amount
        $this->amount->setDbValueDef($rsnew, $this->amount->CurrentValue, null, false);

        // receipt
        if ($this->receipt->Visible && !$this->receipt->Upload->KeepFile) {
            if ($this->receipt->Upload->Value === null) {
                $rsnew['receipt'] = null;
            } else {
                $rsnew['receipt'] = $this->receipt->Upload->Value;
            }
        }

        // receiptNumber
        $this->receiptNumber->setDbValueDef($rsnew, $this->receiptNumber->CurrentValue, "", false);

        // date
        $this->date->setDbValueDef($rsnew, UnFormatDateTime($this->date->CurrentValue, $this->date->formatPattern()), null, false);

        // dateFrom
        $this->dateFrom->setDbValueDef($rsnew, UnFormatDateTime($this->dateFrom->CurrentValue, $this->dateFrom->formatPattern()), null, false);

        // dateTo
        $this->dateTo->setDbValueDef($rsnew, UnFormatDateTime($this->dateTo->CurrentValue, $this->dateTo->formatPattern()), null, false);

        // consumption
        $this->consumption->setDbValueDef($rsnew, $this->consumption->CurrentValue, null, false);

        // note
        $this->note->setDbValueDef($rsnew, $this->note->CurrentValue, null, false);

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("ManExpenseList"), "", $this->TableVar, true);
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
                case "x_expCategory":
                    break;
                case "x_expSubcategory":
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
