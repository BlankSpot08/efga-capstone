<?php

namespace PHPMaker2022\efga_expense_system;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class EmpExpenseGrid extends EmpExpense
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'emp_expense';

    // Page object name
    public $PageObjName = "EmpExpenseGrid";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "femp_expensegrid";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
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
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (emp_expense)
        if (!isset($GLOBALS["emp_expense"]) || get_class($GLOBALS["emp_expense"]) == PROJECT_NAMESPACE . "emp_expense") {
            $GLOBALS["emp_expense"] = &$this;
        }
        $this->AddUrl = "EmpExpenseAdd";

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
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

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
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
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
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Multi column button position
        $this->MultiColumnListOptionsPosition = Config("MULTI_COLUMN_LIST_OPTIONS_POSITION");

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
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

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Set up lookup cache
        $this->setupLookupOptions($this->cashAdvance_id);
        $this->setupLookupOptions($this->status);
        $this->setupLookupOptions($this->float_status);
        $this->setupLookupOptions($this->machine_id);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
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
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }

        // Restore master/detail filter from session
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Restore master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Restore detail filter from session
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->DbMasterFilter != "" && $this->getCurrentMasterTable() == "machine") {
            $masterTbl = Container("machine");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetchAssociative();
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("MachineList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
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
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->TableVar, $this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

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
            return false;
        }
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
            if ($rowaction != "insertdelete") { // Skip insert then deleted rows
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
                                // Overwrite record, just reload hash value
                                if ($this->isGridOverwrite()) {
                                    $this->loadRowHash();
                                }
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    break;
                }
            }
        }
        if ($gridUpdate) {
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
            return false;
        }

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
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success

                // Validate form // Already done in validateGridForm
                //if (!$this->validateForm()) {
                //    $gridInsert = false; // Form error, reset action
                //} else {
                    $gridInsert = $this->addRow($this->OldRecordset); // Insert this row
                //}
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->id->CurrentValue;

                    // Add filter for this record
                    $filter = $this->getRecordFilter();
                    if ($wrkfilter != "") {
                        $wrkfilter .= " OR ";
                    }
                    $wrkfilter .= $filter;
                } else {
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
        if ($CurrentForm->hasValue("x_cashAdvance_id") && $CurrentForm->hasValue("o_cashAdvance_id") && $this->cashAdvance_id->CurrentValue != $this->cashAdvance_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_amount") && $CurrentForm->hasValue("o_amount") && $this->amount->CurrentValue != $this->amount->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_dateTrans") && $CurrentForm->hasValue("o_dateTrans") && $this->dateTrans->CurrentValue != $this->dateTrans->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_receiptNumber") && $CurrentForm->hasValue("o_receiptNumber") && $this->receiptNumber->CurrentValue != $this->receiptNumber->OldValue) {
            return false;
        }
        if (!EmptyValue($this->receipt->Upload->Value)) {
            return false;
        }
        if ($CurrentForm->hasValue("x_note") && $CurrentForm->hasValue("o_note") && $this->note->CurrentValue != $this->note->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_submittedBy") && $CurrentForm->hasValue("o_submittedBy") && $this->submittedBy->CurrentValue != $this->submittedBy->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_status") && $CurrentForm->hasValue("o_status") && $this->status->CurrentValue != $this->status->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_dateClosed") && $CurrentForm->hasValue("o_dateClosed") && $this->dateClosed->CurrentValue != $this->dateClosed->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_float_status") && $CurrentForm->hasValue("o_float_status") && $this->float_status->CurrentValue != $this->float_status->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_validatedBy") && $CurrentForm->hasValue("o_validatedBy") && $this->validatedBy->CurrentValue != $this->validatedBy->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_machine_id") && $CurrentForm->hasValue("o_machine_id") && $this->machine_id->CurrentValue != $this->machine_id->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_cash_float") && $CurrentForm->hasValue("o_cash_float") && $this->cash_float->CurrentValue != $this->cash_float->OldValue) {
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

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
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
        $this->cashAdvance_id->clearErrorMessage();
        $this->amount->clearErrorMessage();
        $this->dateTrans->clearErrorMessage();
        $this->receiptNumber->clearErrorMessage();
        $this->receipt->clearErrorMessage();
        $this->note->clearErrorMessage();
        $this->submittedBy->clearErrorMessage();
        $this->status->clearErrorMessage();
        $this->dateClosed->clearErrorMessage();
        $this->float_status->clearErrorMessage();
        $this->validatedBy->clearErrorMessage();
        $this->machine_id->clearErrorMessage();
        $this->cash_float->clearErrorMessage();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($useDefaultSort) {
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->machine_id->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->setSessionOrderByList($orderBy);
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
            $item->OnLeft = false;
            $item->Visible = false; // Default hidden
        }

        // Add group option item ("button")
        $item = &$this->ListOptions->addGroupOption();
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = false;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
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
                if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView() && $this->showOptionLink("view")) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit() && $this->showOptionLink("edit")) {
                if (IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"emp_expense\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\" data-btn=\"SaveBtn\">" . $Language->phrase("EditLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }
        } // End View mode
        if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex) && $this->RowAction != "delete") {
            $this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_hash\" id=\"k" . $this->RowIndex . "_hash\" value=\"" . $this->HashValue . "\">";
        }
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
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
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
        $this->receipt->Upload->Index = $this->RowIndex;
        $this->note->CurrentValue = null;
        $this->note->OldValue = $this->note->CurrentValue;
        $this->submittedBy->CurrentValue = CurrentUserID();
        $this->submittedBy->OldValue = $this->submittedBy->CurrentValue;
        $this->status->CurrentValue = 0;
        $this->status->OldValue = $this->status->CurrentValue;
        $this->dateClosed->CurrentValue = null;
        $this->dateClosed->OldValue = $this->dateClosed->CurrentValue;
        $this->float_status->CurrentValue = 0;
        $this->float_status->OldValue = $this->float_status->CurrentValue;
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
        $CurrentForm->FormName = $this->FormName;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
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
        if ($CurrentForm->hasValue("o_cashAdvance_id")) {
            $this->cashAdvance_id->setOldValue($CurrentForm->getValue("o_cashAdvance_id"));
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
        if ($CurrentForm->hasValue("o_amount")) {
            $this->amount->setOldValue($CurrentForm->getValue("o_amount"));
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
        if ($CurrentForm->hasValue("o_dateTrans")) {
            $this->dateTrans->setOldValue($CurrentForm->getValue("o_dateTrans"));
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
        if ($CurrentForm->hasValue("o_receiptNumber")) {
            $this->receiptNumber->setOldValue($CurrentForm->getValue("o_receiptNumber"));
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
        if ($CurrentForm->hasValue("o_note")) {
            $this->note->setOldValue($CurrentForm->getValue("o_note"));
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
        if ($CurrentForm->hasValue("o_submittedBy")) {
            $this->submittedBy->setOldValue($CurrentForm->getValue("o_submittedBy"));
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
        if ($CurrentForm->hasValue("o_dateClosed")) {
            $this->dateClosed->setOldValue($CurrentForm->getValue("o_dateClosed"));
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
        if ($CurrentForm->hasValue("o_float_status")) {
            $this->float_status->setOldValue($CurrentForm->getValue("o_float_status"));
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
        if ($CurrentForm->hasValue("o_validatedBy")) {
            $this->validatedBy->setOldValue($CurrentForm->getValue("o_validatedBy"));
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
        if ($CurrentForm->hasValue("o_machine_id")) {
            $this->machine_id->setOldValue($CurrentForm->getValue("o_machine_id"));
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
        if ($CurrentForm->hasValue("o_cash_float")) {
            $this->cash_float->setOldValue($CurrentForm->getValue("o_cash_float"));
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
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id->CurrentValue = $this->id->FormValue;
        }
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
        if (!$this->isOverwrite()) {
            $this->HashValue = $CurrentForm->getValue("k_hash");
        }
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
        return $result->fetchAll(FetchMode::ASSOCIATIVE);
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
        $this->receipt->Upload->Index = $this->RowIndex;
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // cashAdvance_id

        // amount

        // dateTrans

        // receiptNumber

        // receipt

        // note

        // submittedBy

        // status

        // dateClosed

        // float_status

        // validatedBy

        // machine_id

        // cash_float

        // expCategory_id

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
            $this->id->TooltipValue = "";

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
            $this->dateTrans->TooltipValue = "";

            // receiptNumber
            $this->receiptNumber->LinkCustomAttributes = "";
            $this->receiptNumber->HrefValue = "";
            $this->receiptNumber->TooltipValue = "";

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
            $this->receipt->TooltipValue = "";
            if ($this->receipt->UseColorbox) {
                if (EmptyValue($this->receipt->TooltipValue)) {
                    $this->receipt->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->receipt->LinkAttrs["data-rel"] = "emp_expense_x" . $this->RowCount . "_receipt";
                $this->receipt->LinkAttrs->appendClass("ew-lightbox");
            }

            // note
            $this->note->LinkCustomAttributes = "";
            $this->note->HrefValue = "";
            $this->note->TooltipValue = "";

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
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id

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
                $this->amount->OldValue = $this->amount->EditValue;
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
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->receipt, $this->RowIndex);
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
            if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("grid")) { // Non system admin
                $this->submittedBy->CurrentValue = CurrentUserID();
                $this->submittedBy->EditValue = $this->submittedBy->CurrentValue;
                $this->submittedBy->ViewCustomAttributes = "";
            } else {
                if (!$this->submittedBy->Raw) {
                    $this->submittedBy->CurrentValue = HtmlDecode($this->submittedBy->CurrentValue);
                }
                $this->submittedBy->EditValue = HtmlEncode($this->submittedBy->CurrentValue);
                $this->submittedBy->PlaceHolder = RemoveHtml($this->submittedBy->caption());
            }

            // status
            $this->status->EditCustomAttributes = "";
            $this->status->EditValue = $this->status->options(false);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // dateClosed
            $this->dateClosed->setupEditAttributes();
            $this->dateClosed->EditCustomAttributes = "";
            $this->dateClosed->EditValue = HtmlEncode(FormatDateTime($this->dateClosed->CurrentValue, $this->dateClosed->formatPattern()));
            $this->dateClosed->PlaceHolder = RemoveHtml($this->dateClosed->caption());

            // float_status
            $this->float_status->EditCustomAttributes = "";
            $this->float_status->EditValue = $this->float_status->options(false);
            $this->float_status->PlaceHolder = RemoveHtml($this->float_status->caption());

            // validatedBy
            $this->validatedBy->setupEditAttributes();
            $this->validatedBy->EditCustomAttributes = "";
            if (!$this->validatedBy->Raw) {
                $this->validatedBy->CurrentValue = HtmlDecode($this->validatedBy->CurrentValue);
            }
            $this->validatedBy->EditValue = HtmlEncode($this->validatedBy->CurrentValue);
            $this->validatedBy->PlaceHolder = RemoveHtml($this->validatedBy->caption());

            // machine_id
            $this->machine_id->setupEditAttributes();
            $this->machine_id->EditCustomAttributes = "";
            if ($this->machine_id->getSessionValue() != "") {
                $this->machine_id->CurrentValue = GetForeignKeyValue($this->machine_id->getSessionValue());
                $this->machine_id->OldValue = $this->machine_id->CurrentValue;
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
            } else {
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
            }

            // cash_float
            $this->cash_float->setupEditAttributes();
            $this->cash_float->EditCustomAttributes = "";
            $this->cash_float->EditValue = HtmlEncode($this->cash_float->CurrentValue);
            $this->cash_float->PlaceHolder = RemoveHtml($this->cash_float->caption());
            if (strval($this->cash_float->EditValue) != "" && is_numeric($this->cash_float->EditValue)) {
                $this->cash_float->EditValue = FormatNumber($this->cash_float->EditValue, null);
                $this->cash_float->OldValue = $this->cash_float->EditValue;
            }

            // Add refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

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

            // submittedBy
            $this->submittedBy->LinkCustomAttributes = "";
            $this->submittedBy->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // dateClosed
            $this->dateClosed->LinkCustomAttributes = "";
            $this->dateClosed->HrefValue = "";

            // float_status
            $this->float_status->LinkCustomAttributes = "";
            $this->float_status->HrefValue = "";

            // validatedBy
            $this->validatedBy->LinkCustomAttributes = "";
            $this->validatedBy->HrefValue = "";

            // machine_id
            $this->machine_id->LinkCustomAttributes = "";
            $this->machine_id->HrefValue = "";

            // cash_float
            $this->cash_float->LinkCustomAttributes = "";
            $this->cash_float->HrefValue = "";
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
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->receipt, $this->RowIndex);
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
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
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

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
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
        return md5($hash);
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

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "machine") {
            $this->machine_id->CurrentValue = $this->machine_id->getSessionValue();
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

        // submittedBy
        $this->submittedBy->setDbValueDef($rsnew, $this->submittedBy->CurrentValue, null, false);

        // status
        $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, strval($this->status->CurrentValue) == "");

        // dateClosed
        $this->dateClosed->setDbValueDef($rsnew, UnFormatDateTime($this->dateClosed->CurrentValue, $this->dateClosed->formatPattern()), null, false);

        // float_status
        $this->float_status->setDbValueDef($rsnew, $this->float_status->CurrentValue, null, strval($this->float_status->CurrentValue) == "");

        // validatedBy
        $this->validatedBy->setDbValueDef($rsnew, $this->validatedBy->CurrentValue, null, false);

        // machine_id
        $this->machine_id->setDbValueDef($rsnew, $this->machine_id->CurrentValue, null, false);

        // cash_float
        $this->cash_float->setDbValueDef($rsnew, $this->cash_float->CurrentValue, null, false);

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

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "machine") {
            $masterTbl = Container("machine");
            $this->machine_id->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
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
