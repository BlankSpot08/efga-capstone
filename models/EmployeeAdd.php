<?php

namespace PHPMaker2022\efga_expense_system;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class EmployeeAdd extends Employee
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'employee';

    // Page object name
    public $PageObjName = "EmployeeAdd";

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

        // Table object (employee)
        if (!isset($GLOBALS["employee"]) || get_class($GLOBALS["employee"]) == PROJECT_NAMESPACE . "employee") {
            $GLOBALS["employee"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'employee');
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
                $tbl = Container("employee");
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
                    if ($pageName == "EmployeeView") {
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
        $this->employee_id->setVisibility();
        $this->lastname->setVisibility();
        $this->firstname->setVisibility();
        $this->middlename->setVisibility();
        $this->dateOfBirth->setVisibility();
        $this->picture->setVisibility();
        $this->address->setVisibility();
        $this->contactNo->setVisibility();
        $this->officeDepartment->setVisibility();
        $this->empPosition->setVisibility();
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
        $this->setupLookupOptions($this->officeDepartment);
        $this->setupLookupOptions($this->empPosition);

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
                    $this->terminate("EmployeeList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "EmployeeList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "EmployeeView") {
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
        $this->picture->Upload->Index = $CurrentForm->Index;
        $this->picture->Upload->uploadFile();
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->employee_id->CurrentValue = null;
        $this->employee_id->OldValue = $this->employee_id->CurrentValue;
        $this->lastname->CurrentValue = null;
        $this->lastname->OldValue = $this->lastname->CurrentValue;
        $this->firstname->CurrentValue = null;
        $this->firstname->OldValue = $this->firstname->CurrentValue;
        $this->middlename->CurrentValue = null;
        $this->middlename->OldValue = $this->middlename->CurrentValue;
        $this->dateOfBirth->CurrentValue = null;
        $this->dateOfBirth->OldValue = $this->dateOfBirth->CurrentValue;
        $this->picture->Upload->DbValue = null;
        $this->picture->OldValue = $this->picture->Upload->DbValue;
        $this->address->CurrentValue = null;
        $this->address->OldValue = $this->address->CurrentValue;
        $this->contactNo->CurrentValue = null;
        $this->contactNo->OldValue = $this->contactNo->CurrentValue;
        $this->officeDepartment->CurrentValue = null;
        $this->officeDepartment->OldValue = $this->officeDepartment->CurrentValue;
        $this->empPosition->CurrentValue = null;
        $this->empPosition->OldValue = $this->empPosition->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'employee_id' first before field var 'x_employee_id'
        $val = $CurrentForm->hasValue("employee_id") ? $CurrentForm->getValue("employee_id") : $CurrentForm->getValue("x_employee_id");
        if (!$this->employee_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->employee_id->Visible = false; // Disable update for API request
            } else {
                $this->employee_id->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'lastname' first before field var 'x_lastname'
        $val = $CurrentForm->hasValue("lastname") ? $CurrentForm->getValue("lastname") : $CurrentForm->getValue("x_lastname");
        if (!$this->lastname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lastname->Visible = false; // Disable update for API request
            } else {
                $this->lastname->setFormValue($val);
            }
        }

        // Check field name 'firstname' first before field var 'x_firstname'
        $val = $CurrentForm->hasValue("firstname") ? $CurrentForm->getValue("firstname") : $CurrentForm->getValue("x_firstname");
        if (!$this->firstname->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->firstname->Visible = false; // Disable update for API request
            } else {
                $this->firstname->setFormValue($val);
            }
        }

        // Check field name 'middlename' first before field var 'x_middlename'
        $val = $CurrentForm->hasValue("middlename") ? $CurrentForm->getValue("middlename") : $CurrentForm->getValue("x_middlename");
        if (!$this->middlename->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->middlename->Visible = false; // Disable update for API request
            } else {
                $this->middlename->setFormValue($val);
            }
        }

        // Check field name 'dateOfBirth' first before field var 'x_dateOfBirth'
        $val = $CurrentForm->hasValue("dateOfBirth") ? $CurrentForm->getValue("dateOfBirth") : $CurrentForm->getValue("x_dateOfBirth");
        if (!$this->dateOfBirth->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dateOfBirth->Visible = false; // Disable update for API request
            } else {
                $this->dateOfBirth->setFormValue($val, true, $validate);
            }
            $this->dateOfBirth->CurrentValue = UnFormatDateTime($this->dateOfBirth->CurrentValue, $this->dateOfBirth->formatPattern());
        }

        // Check field name 'address' first before field var 'x_address'
        $val = $CurrentForm->hasValue("address") ? $CurrentForm->getValue("address") : $CurrentForm->getValue("x_address");
        if (!$this->address->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->address->Visible = false; // Disable update for API request
            } else {
                $this->address->setFormValue($val);
            }
        }

        // Check field name 'contactNo' first before field var 'x_contactNo'
        $val = $CurrentForm->hasValue("contactNo") ? $CurrentForm->getValue("contactNo") : $CurrentForm->getValue("x_contactNo");
        if (!$this->contactNo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->contactNo->Visible = false; // Disable update for API request
            } else {
                $this->contactNo->setFormValue($val);
            }
        }

        // Check field name 'officeDepartment' first before field var 'x_officeDepartment'
        $val = $CurrentForm->hasValue("officeDepartment") ? $CurrentForm->getValue("officeDepartment") : $CurrentForm->getValue("x_officeDepartment");
        if (!$this->officeDepartment->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->officeDepartment->Visible = false; // Disable update for API request
            } else {
                $this->officeDepartment->setFormValue($val);
            }
        }

        // Check field name 'empPosition' first before field var 'x_empPosition'
        $val = $CurrentForm->hasValue("empPosition") ? $CurrentForm->getValue("empPosition") : $CurrentForm->getValue("x_empPosition");
        if (!$this->empPosition->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->empPosition->Visible = false; // Disable update for API request
            } else {
                $this->empPosition->setFormValue($val);
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
        $this->employee_id->CurrentValue = $this->employee_id->FormValue;
        $this->lastname->CurrentValue = $this->lastname->FormValue;
        $this->firstname->CurrentValue = $this->firstname->FormValue;
        $this->middlename->CurrentValue = $this->middlename->FormValue;
        $this->dateOfBirth->CurrentValue = $this->dateOfBirth->FormValue;
        $this->dateOfBirth->CurrentValue = UnFormatDateTime($this->dateOfBirth->CurrentValue, $this->dateOfBirth->formatPattern());
        $this->address->CurrentValue = $this->address->FormValue;
        $this->contactNo->CurrentValue = $this->contactNo->FormValue;
        $this->officeDepartment->CurrentValue = $this->officeDepartment->FormValue;
        $this->empPosition->CurrentValue = $this->empPosition->FormValue;
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
        $this->employee_id->setDbValue($row['employee_id']);
        $this->lastname->setDbValue($row['lastname']);
        $this->firstname->setDbValue($row['firstname']);
        $this->middlename->setDbValue($row['middlename']);
        $this->dateOfBirth->setDbValue($row['dateOfBirth']);
        $this->picture->Upload->DbValue = $row['picture'];
        if (is_resource($this->picture->Upload->DbValue) && get_resource_type($this->picture->Upload->DbValue) == "stream") { // Byte array
            $this->picture->Upload->DbValue = stream_get_contents($this->picture->Upload->DbValue);
        }
        $this->address->setDbValue($row['address']);
        $this->contactNo->setDbValue($row['contactNo']);
        $this->officeDepartment->setDbValue($row['officeDepartment']);
        if (array_key_exists('EV__officeDepartment', $row)) {
            $this->officeDepartment->VirtualValue = $row['EV__officeDepartment']; // Set up virtual field value
        } else {
            $this->officeDepartment->VirtualValue = ""; // Clear value
        }
        $this->empPosition->setDbValue($row['empPosition']);
        if (array_key_exists('EV__empPosition', $row)) {
            $this->empPosition->VirtualValue = $row['EV__empPosition']; // Set up virtual field value
        } else {
            $this->empPosition->VirtualValue = ""; // Clear value
        }
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['employee_id'] = $this->employee_id->CurrentValue;
        $row['lastname'] = $this->lastname->CurrentValue;
        $row['firstname'] = $this->firstname->CurrentValue;
        $row['middlename'] = $this->middlename->CurrentValue;
        $row['dateOfBirth'] = $this->dateOfBirth->CurrentValue;
        $row['picture'] = $this->picture->Upload->DbValue;
        $row['address'] = $this->address->CurrentValue;
        $row['contactNo'] = $this->contactNo->CurrentValue;
        $row['officeDepartment'] = $this->officeDepartment->CurrentValue;
        $row['empPosition'] = $this->empPosition->CurrentValue;
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

        // employee_id
        $this->employee_id->RowCssClass = "row";

        // lastname
        $this->lastname->RowCssClass = "row";

        // firstname
        $this->firstname->RowCssClass = "row";

        // middlename
        $this->middlename->RowCssClass = "row";

        // dateOfBirth
        $this->dateOfBirth->RowCssClass = "row";

        // picture
        $this->picture->RowCssClass = "row";

        // address
        $this->address->RowCssClass = "row";

        // contactNo
        $this->contactNo->RowCssClass = "row";

        // officeDepartment
        $this->officeDepartment->RowCssClass = "row";

        // empPosition
        $this->empPosition->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // employee_id
            $this->employee_id->ViewValue = $this->employee_id->CurrentValue;
            $this->employee_id->ViewValue = FormatNumber($this->employee_id->ViewValue, $this->employee_id->formatPattern());
            $this->employee_id->ViewCustomAttributes = "";

            // lastname
            $this->lastname->ViewValue = $this->lastname->CurrentValue;
            $this->lastname->ViewCustomAttributes = "";

            // firstname
            $this->firstname->ViewValue = $this->firstname->CurrentValue;
            $this->firstname->ViewCustomAttributes = "";

            // middlename
            $this->middlename->ViewValue = $this->middlename->CurrentValue;
            $this->middlename->ViewCustomAttributes = "";

            // dateOfBirth
            $this->dateOfBirth->ViewValue = $this->dateOfBirth->CurrentValue;
            $this->dateOfBirth->ViewValue = FormatDateTime($this->dateOfBirth->ViewValue, $this->dateOfBirth->formatPattern());
            $this->dateOfBirth->ViewCustomAttributes = "";

            // picture
            if (!EmptyValue($this->picture->Upload->DbValue)) {
                $this->picture->ImageWidth = 100;
                $this->picture->ImageHeight = 100;
                $this->picture->ImageAlt = $this->picture->alt();
                $this->picture->ImageCssClass = "ew-image";
                $this->picture->ViewValue = $this->id->CurrentValue;
                $this->picture->IsBlobImage = IsImageFile(ContentExtension($this->picture->Upload->DbValue));
            } else {
                $this->picture->ViewValue = "";
            }
            $this->picture->ViewCustomAttributes = "";

            // address
            $this->address->ViewValue = $this->address->CurrentValue;
            $this->address->ViewCustomAttributes = "";

            // contactNo
            $this->contactNo->ViewValue = $this->contactNo->CurrentValue;
            $this->contactNo->ViewCustomAttributes = "";

            // officeDepartment
            if ($this->officeDepartment->VirtualValue != "") {
                $this->officeDepartment->ViewValue = $this->officeDepartment->VirtualValue;
            } else {
                $curVal = strval($this->officeDepartment->CurrentValue);
                if ($curVal != "") {
                    $this->officeDepartment->ViewValue = $this->officeDepartment->lookupCacheOption($curVal);
                    if ($this->officeDepartment->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->officeDepartment->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->officeDepartment->Lookup->renderViewRow($rswrk[0]);
                            $this->officeDepartment->ViewValue = $this->officeDepartment->displayValue($arwrk);
                        } else {
                            $this->officeDepartment->ViewValue = FormatNumber($this->officeDepartment->CurrentValue, $this->officeDepartment->formatPattern());
                        }
                    }
                } else {
                    $this->officeDepartment->ViewValue = null;
                }
            }
            $this->officeDepartment->ViewCustomAttributes = "";

            // empPosition
            if ($this->empPosition->VirtualValue != "") {
                $this->empPosition->ViewValue = $this->empPosition->VirtualValue;
            } else {
                $curVal = strval($this->empPosition->CurrentValue);
                if ($curVal != "") {
                    $this->empPosition->ViewValue = $this->empPosition->lookupCacheOption($curVal);
                    if ($this->empPosition->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->empPosition->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->empPosition->Lookup->renderViewRow($rswrk[0]);
                            $this->empPosition->ViewValue = $this->empPosition->displayValue($arwrk);
                        } else {
                            $this->empPosition->ViewValue = FormatNumber($this->empPosition->CurrentValue, $this->empPosition->formatPattern());
                        }
                    }
                } else {
                    $this->empPosition->ViewValue = null;
                }
            }
            $this->empPosition->ViewCustomAttributes = "";

            // employee_id
            $this->employee_id->LinkCustomAttributes = "";
            $this->employee_id->HrefValue = "";

            // lastname
            $this->lastname->LinkCustomAttributes = "";
            $this->lastname->HrefValue = "";

            // firstname
            $this->firstname->LinkCustomAttributes = "";
            $this->firstname->HrefValue = "";

            // middlename
            $this->middlename->LinkCustomAttributes = "";
            $this->middlename->HrefValue = "";

            // dateOfBirth
            $this->dateOfBirth->LinkCustomAttributes = "";
            $this->dateOfBirth->HrefValue = "";

            // picture
            $this->picture->LinkCustomAttributes = "";
            if (!empty($this->picture->Upload->DbValue)) {
                $this->picture->HrefValue = GetFileUploadUrl($this->picture, $this->id->CurrentValue);
                $this->picture->LinkAttrs["target"] = "";
                if ($this->picture->IsBlobImage && empty($this->picture->LinkAttrs["target"])) {
                    $this->picture->LinkAttrs["target"] = "_blank";
                }
                if ($this->isExport()) {
                    $this->picture->HrefValue = FullUrl($this->picture->HrefValue, "href");
                }
            } else {
                $this->picture->HrefValue = "";
            }
            $this->picture->ExportHrefValue = GetFileUploadUrl($this->picture, $this->id->CurrentValue);

            // address
            $this->address->LinkCustomAttributes = "";
            $this->address->HrefValue = "";

            // contactNo
            $this->contactNo->LinkCustomAttributes = "";
            $this->contactNo->HrefValue = "";

            // officeDepartment
            $this->officeDepartment->LinkCustomAttributes = "";
            $this->officeDepartment->HrefValue = "";

            // empPosition
            $this->empPosition->LinkCustomAttributes = "";
            $this->empPosition->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // employee_id
            $this->employee_id->setupEditAttributes();
            $this->employee_id->EditCustomAttributes = "";
            $this->employee_id->EditValue = HtmlEncode($this->employee_id->CurrentValue);
            $this->employee_id->PlaceHolder = RemoveHtml($this->employee_id->caption());
            if (strval($this->employee_id->EditValue) != "" && is_numeric($this->employee_id->EditValue)) {
                $this->employee_id->EditValue = FormatNumber($this->employee_id->EditValue, null);
            }

            // lastname
            $this->lastname->setupEditAttributes();
            $this->lastname->EditCustomAttributes = "";
            if (!$this->lastname->Raw) {
                $this->lastname->CurrentValue = HtmlDecode($this->lastname->CurrentValue);
            }
            $this->lastname->EditValue = HtmlEncode($this->lastname->CurrentValue);
            $this->lastname->PlaceHolder = RemoveHtml($this->lastname->caption());

            // firstname
            $this->firstname->setupEditAttributes();
            $this->firstname->EditCustomAttributes = "";
            if (!$this->firstname->Raw) {
                $this->firstname->CurrentValue = HtmlDecode($this->firstname->CurrentValue);
            }
            $this->firstname->EditValue = HtmlEncode($this->firstname->CurrentValue);
            $this->firstname->PlaceHolder = RemoveHtml($this->firstname->caption());

            // middlename
            $this->middlename->setupEditAttributes();
            $this->middlename->EditCustomAttributes = "";
            if (!$this->middlename->Raw) {
                $this->middlename->CurrentValue = HtmlDecode($this->middlename->CurrentValue);
            }
            $this->middlename->EditValue = HtmlEncode($this->middlename->CurrentValue);
            $this->middlename->PlaceHolder = RemoveHtml($this->middlename->caption());

            // dateOfBirth
            $this->dateOfBirth->setupEditAttributes();
            $this->dateOfBirth->EditCustomAttributes = "";
            $this->dateOfBirth->EditValue = HtmlEncode(FormatDateTime($this->dateOfBirth->CurrentValue, $this->dateOfBirth->formatPattern()));
            $this->dateOfBirth->PlaceHolder = RemoveHtml($this->dateOfBirth->caption());

            // picture
            $this->picture->setupEditAttributes();
            $this->picture->EditCustomAttributes = "";
            if (!EmptyValue($this->picture->Upload->DbValue)) {
                $this->picture->ImageWidth = 100;
                $this->picture->ImageHeight = 100;
                $this->picture->ImageAlt = $this->picture->alt();
                $this->picture->ImageCssClass = "ew-image";
                $this->picture->EditValue = $this->id->CurrentValue;
                $this->picture->IsBlobImage = IsImageFile(ContentExtension($this->picture->Upload->DbValue));
            } else {
                $this->picture->EditValue = "";
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->picture);
            }

            // address
            $this->address->setupEditAttributes();
            $this->address->EditCustomAttributes = "";
            $this->address->EditValue = HtmlEncode($this->address->CurrentValue);
            $this->address->PlaceHolder = RemoveHtml($this->address->caption());

            // contactNo
            $this->contactNo->setupEditAttributes();
            $this->contactNo->EditCustomAttributes = "";
            if (!$this->contactNo->Raw) {
                $this->contactNo->CurrentValue = HtmlDecode($this->contactNo->CurrentValue);
            }
            $this->contactNo->EditValue = HtmlEncode($this->contactNo->CurrentValue);
            $this->contactNo->PlaceHolder = RemoveHtml($this->contactNo->caption());

            // officeDepartment
            $this->officeDepartment->setupEditAttributes();
            $this->officeDepartment->EditCustomAttributes = "";
            $curVal = trim(strval($this->officeDepartment->CurrentValue));
            if ($curVal != "") {
                $this->officeDepartment->ViewValue = $this->officeDepartment->lookupCacheOption($curVal);
            } else {
                $this->officeDepartment->ViewValue = $this->officeDepartment->Lookup !== null && is_array($this->officeDepartment->lookupOptions()) ? $curVal : null;
            }
            if ($this->officeDepartment->ViewValue !== null) { // Load from cache
                $this->officeDepartment->EditValue = array_values($this->officeDepartment->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->officeDepartment->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->officeDepartment->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->officeDepartment->EditValue = $arwrk;
            }
            $this->officeDepartment->PlaceHolder = RemoveHtml($this->officeDepartment->caption());

            // empPosition
            $this->empPosition->setupEditAttributes();
            $this->empPosition->EditCustomAttributes = "";
            $curVal = trim(strval($this->empPosition->CurrentValue));
            if ($curVal != "") {
                $this->empPosition->ViewValue = $this->empPosition->lookupCacheOption($curVal);
            } else {
                $this->empPosition->ViewValue = $this->empPosition->Lookup !== null && is_array($this->empPosition->lookupOptions()) ? $curVal : null;
            }
            if ($this->empPosition->ViewValue !== null) { // Load from cache
                $this->empPosition->EditValue = array_values($this->empPosition->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->empPosition->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->empPosition->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->empPosition->EditValue = $arwrk;
            }
            $this->empPosition->PlaceHolder = RemoveHtml($this->empPosition->caption());

            // Add refer script

            // employee_id
            $this->employee_id->LinkCustomAttributes = "";
            $this->employee_id->HrefValue = "";

            // lastname
            $this->lastname->LinkCustomAttributes = "";
            $this->lastname->HrefValue = "";

            // firstname
            $this->firstname->LinkCustomAttributes = "";
            $this->firstname->HrefValue = "";

            // middlename
            $this->middlename->LinkCustomAttributes = "";
            $this->middlename->HrefValue = "";

            // dateOfBirth
            $this->dateOfBirth->LinkCustomAttributes = "";
            $this->dateOfBirth->HrefValue = "";

            // picture
            $this->picture->LinkCustomAttributes = "";
            if (!empty($this->picture->Upload->DbValue)) {
                $this->picture->HrefValue = GetFileUploadUrl($this->picture, $this->id->CurrentValue);
                $this->picture->LinkAttrs["target"] = "";
                if ($this->picture->IsBlobImage && empty($this->picture->LinkAttrs["target"])) {
                    $this->picture->LinkAttrs["target"] = "_blank";
                }
                if ($this->isExport()) {
                    $this->picture->HrefValue = FullUrl($this->picture->HrefValue, "href");
                }
            } else {
                $this->picture->HrefValue = "";
            }
            $this->picture->ExportHrefValue = GetFileUploadUrl($this->picture, $this->id->CurrentValue);

            // address
            $this->address->LinkCustomAttributes = "";
            $this->address->HrefValue = "";

            // contactNo
            $this->contactNo->LinkCustomAttributes = "";
            $this->contactNo->HrefValue = "";

            // officeDepartment
            $this->officeDepartment->LinkCustomAttributes = "";
            $this->officeDepartment->HrefValue = "";

            // empPosition
            $this->empPosition->LinkCustomAttributes = "";
            $this->empPosition->HrefValue = "";
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
        if ($this->employee_id->Required) {
            if (!$this->employee_id->IsDetailKey && EmptyValue($this->employee_id->FormValue)) {
                $this->employee_id->addErrorMessage(str_replace("%s", $this->employee_id->caption(), $this->employee_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->employee_id->FormValue)) {
            $this->employee_id->addErrorMessage($this->employee_id->getErrorMessage(false));
        }
        if ($this->lastname->Required) {
            if (!$this->lastname->IsDetailKey && EmptyValue($this->lastname->FormValue)) {
                $this->lastname->addErrorMessage(str_replace("%s", $this->lastname->caption(), $this->lastname->RequiredErrorMessage));
            }
        }
        if ($this->firstname->Required) {
            if (!$this->firstname->IsDetailKey && EmptyValue($this->firstname->FormValue)) {
                $this->firstname->addErrorMessage(str_replace("%s", $this->firstname->caption(), $this->firstname->RequiredErrorMessage));
            }
        }
        if ($this->middlename->Required) {
            if (!$this->middlename->IsDetailKey && EmptyValue($this->middlename->FormValue)) {
                $this->middlename->addErrorMessage(str_replace("%s", $this->middlename->caption(), $this->middlename->RequiredErrorMessage));
            }
        }
        if ($this->dateOfBirth->Required) {
            if (!$this->dateOfBirth->IsDetailKey && EmptyValue($this->dateOfBirth->FormValue)) {
                $this->dateOfBirth->addErrorMessage(str_replace("%s", $this->dateOfBirth->caption(), $this->dateOfBirth->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->dateOfBirth->FormValue, $this->dateOfBirth->formatPattern())) {
            $this->dateOfBirth->addErrorMessage($this->dateOfBirth->getErrorMessage(false));
        }
        if ($this->picture->Required) {
            if ($this->picture->Upload->FileName == "" && !$this->picture->Upload->KeepFile) {
                $this->picture->addErrorMessage(str_replace("%s", $this->picture->caption(), $this->picture->RequiredErrorMessage));
            }
        }
        if ($this->address->Required) {
            if (!$this->address->IsDetailKey && EmptyValue($this->address->FormValue)) {
                $this->address->addErrorMessage(str_replace("%s", $this->address->caption(), $this->address->RequiredErrorMessage));
            }
        }
        if ($this->contactNo->Required) {
            if (!$this->contactNo->IsDetailKey && EmptyValue($this->contactNo->FormValue)) {
                $this->contactNo->addErrorMessage(str_replace("%s", $this->contactNo->caption(), $this->contactNo->RequiredErrorMessage));
            }
        }
        if ($this->officeDepartment->Required) {
            if (!$this->officeDepartment->IsDetailKey && EmptyValue($this->officeDepartment->FormValue)) {
                $this->officeDepartment->addErrorMessage(str_replace("%s", $this->officeDepartment->caption(), $this->officeDepartment->RequiredErrorMessage));
            }
        }
        if ($this->empPosition->Required) {
            if (!$this->empPosition->IsDetailKey && EmptyValue($this->empPosition->FormValue)) {
                $this->empPosition->addErrorMessage(str_replace("%s", $this->empPosition->caption(), $this->empPosition->RequiredErrorMessage));
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
        if ($this->employee_id->CurrentValue != "") { // Check field with unique index
            $filter = "(`employee_id` = " . AdjustSql($this->employee_id->CurrentValue, $this->Dbid) . ")";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->employee_id->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->employee_id->CurrentValue, $idxErrMsg);
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

        // employee_id
        $this->employee_id->setDbValueDef($rsnew, $this->employee_id->CurrentValue, null, false);

        // lastname
        $this->lastname->setDbValueDef($rsnew, $this->lastname->CurrentValue, null, false);

        // firstname
        $this->firstname->setDbValueDef($rsnew, $this->firstname->CurrentValue, null, false);

        // middlename
        $this->middlename->setDbValueDef($rsnew, $this->middlename->CurrentValue, null, false);

        // dateOfBirth
        $this->dateOfBirth->setDbValueDef($rsnew, UnFormatDateTime($this->dateOfBirth->CurrentValue, $this->dateOfBirth->formatPattern()), null, false);

        // picture
        if ($this->picture->Visible && !$this->picture->Upload->KeepFile) {
            if ($this->picture->Upload->Value === null) {
                $rsnew['picture'] = null;
            } else {
                $rsnew['picture'] = $this->picture->Upload->Value;
            }
        }

        // address
        $this->address->setDbValueDef($rsnew, $this->address->CurrentValue, null, false);

        // contactNo
        $this->contactNo->setDbValueDef($rsnew, $this->contactNo->CurrentValue, null, false);

        // officeDepartment
        $this->officeDepartment->setDbValueDef($rsnew, $this->officeDepartment->CurrentValue, null, false);

        // empPosition
        $this->empPosition->setDbValueDef($rsnew, $this->empPosition->CurrentValue, null, false);

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
            // picture
            CleanUploadTempPath($this->picture, $this->picture->Upload->Index);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("EmployeeList"), "", $this->TableVar, true);
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
                case "x_officeDepartment":
                    break;
                case "x_empPosition":
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
