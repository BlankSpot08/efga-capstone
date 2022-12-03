<?php

namespace PHPMaker2022\efga_expense_system;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class EmpMonthlyExpenseSummary extends EmpMonthlyExpense
{
    use MessagesTrait;

    // Page ID
    public $PageID = "summary";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'Emp Monthly Expense';

    // Page object name
    public $PageObjName = "EmpMonthlyExpenseSummary";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS
    public $ReportTableClass = "";
    public $ReportTableStyle = "";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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

        // Table object (EmpMonthlyExpense)
        if (!isset($GLOBALS["EmpMonthlyExpense"]) || get_class($GLOBALS["EmpMonthlyExpense"]) == PROJECT_NAMESPACE . "EmpMonthlyExpense") {
            $GLOBALS["EmpMonthlyExpense"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'Emp Monthly Expense');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // Export options
        $this->ExportOptions = new ListOptions(["TagClassName" => "ew-export-option"]);

        // Filter options
        $this->FilterOptions = new ListOptions(["TagClassName" => "ew-filter-option"]);
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
        if ($this->isExport() && !$this->isExport("print")) {
            $class = PROJECT_NAMESPACE . Config("REPORT_EXPORT_CLASSES." . $this->Export);
            if (class_exists($class)) {
                $content = $this->getContents();
                $doc = new $class();
                $doc($this, $content);
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection if not in dashboard
        if (!$DashboardReport) {
            CloseConnections();
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

    // Lookup data
    public function lookup($ar = null)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $ar["field"] ?? Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;
        if (in_array($lookup->LinkTable, [$this->ReportSourceTable, $this->TableVar])) {
            $lookup->RenderViewFunc = "renderLookup"; // Set up view renderer
        }
        $lookup->RenderEditFunc = ""; // Set up edit renderer

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

    // Options
    public $HideOptions = false;
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $FilterOptions; // Filter options

    // Records
    public $GroupRecords = [];
    public $DetailRecords = [];
    public $DetailRecordCount = 0;

    // Paging variables
    public $RecordIndex = 0; // Record index
    public $RecordCount = 0; // Record count (start from 1 for each group)
    public $StartGroup = 0; // Start group
    public $StopGroup = 0; // Stop group
    public $TotalGroups = 0; // Total groups
    public $GroupCount = 0; // Group count
    public $GroupCounter = []; // Group counter
    public $DisplayGroups = 3; // Groups per page
    public $GroupRange = 10;
    public $PageSizes = "1,2,3,5,-1"; // Page sizes (comma separated)
    public $PageFirstGroupFilter = "";
    public $UserIDFilter = "";
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = "";
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $DrillDownList = "";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $SearchCommand = false;
    public $ShowHeader;
    public $GroupColumnCount = 0;
    public $SubGroupColumnCount = 0;
    public $DetailColumnCount = 0;
    public $TotalCount;
    public $PageTotalCount;
    public $TopContentClass = "col-sm-12 ew-top";
    public $LeftContentClass = "ew-left";
    public $CenterContentClass = "col-sm-12 ew-center";
    public $RightContentClass = "ew-right";
    public $BottomContentClass = "col-sm-12 ew-bottom";

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $ExportFileName, $Language, $Security, $UserProfile,
            $Security, $DrillDownInPanel, $Breadcrumb,
            $DashboardReport, $CustomExportType, $ReportExportType;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        }
        $ExportFileName = $this->TableVar; // Get export file, used in header

        // Get custom export parameters
        if ($this->isExport() && $custom != "") {
            $this->CustomExport = $this->Export;
            $this->Export = "print";
        }
        $CustomExportType = $this->CustomExport;
        $ExportType = $this->Export; // Get export parameter, used in header
        $ReportExportType = $ExportType; // Report export type, used in header
        $this->CurrentAction = Param("action"); // Set up current action

        // Setup export options
        $this->setupExportOptions();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up table class
        if ($this->isExport("word") || $this->isExport("excel") || $this->isExport("pdf")) {
            $this->ReportTableClass = "ew-table table-bordered table-sm";
        } else {
            $this->ReportTableClass = "table ew-table table-bordered table-sm";
        }

        // Set field visibility for detail fields
        $this->amount->setVisibility();
        $this->receiptNumber->setVisibility();
        $this->note->setVisibility();
        $this->dateClosed->setVisibility();
        $this->validatedBy->setVisibility();
        $this->cash_float->setVisibility();

        // Set up groups per page dynamically
        $this->setupDisplayGroups();

        // Set up Breadcrumb
        if (!$this->isExport() && !$DashboardReport) {
            $this->setupBreadcrumb();
        }

        // Check if search command
        $this->SearchCommand = (Get("cmd", "") == "search");

        // Load custom filters
        $this->pageFilterLoad();

        // Extended filter
        $extendedFilter = "";

        // Restore filter list
        $this->restoreFilterList();

        // Build extended filter
        $extendedFilter = $this->getExtendedFilter();
        AddFilter($this->SearchWhere, $extendedFilter);

        // Call Page Selecting event
        $this->pageSelecting($this->SearchWhere);

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Get sort
        $this->Sort = $this->getSort();

        // Search options
        $this->setupSearchOptions();

        // Update filter
        AddFilter($this->Filter, $this->SearchWhere);

        // Get total group count
        $sql = $this->buildReportSql($this->getSqlSelectGroup(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
        $this->TotalGroups = $this->getRecordCount($sql);
        if ($this->DisplayGroups <= 0 || $this->DrillDown || $DashboardReport) { // Display all groups
            $this->DisplayGroups = $this->TotalGroups;
        }
        $this->StartGroup = 1;

        // Show header
        $this->ShowHeader = ($this->TotalGroups > 0);

        // Set up start position if not export all
        if ($this->ExportAll && $this->isExport()) {
            $this->DisplayGroups = $this->TotalGroups;
        } else {
            $this->setupStartGroup();
        }

        // Set no record found message
        if ($this->TotalGroups == 0) {
            if ($Security->canList()) {
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            } else {
                $this->setWarningMessage(DeniedMessage());
            }
        }

        // Hide export options if export/dashboard report/hide options
        if ($this->isExport() || $DashboardReport || $this->HideOptions) {
            $this->ExportOptions->hideAllOptions();
        }

        // Hide search/filter options if export/drilldown/dashboard report/hide options
        if ($this->isExport() || $this->DrillDown || $DashboardReport || $this->HideOptions) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }

        // Get group records
        if ($this->TotalGroups > 0) {
            $grpSort = UpdateSortFields($this->getSqlOrderByGroup(), $this->Sort, 2); // Get grouping field only
            $sql = $this->buildReportSql($this->getSqlSelectGroup(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderByGroup(), $this->Filter, $grpSort);
            $grpRs = $sql->setFirstResult($this->StartGroup - 1)->setMaxResults($this->DisplayGroups)->execute();
            $this->GroupRecords = $grpRs->fetchAll(); // Get records of first grouping field
            $this->loadGroupRowValues();
            $this->GroupCount = 1;
        }

        // Init detail records
        $this->DetailRecords = [];
        $this->setupFieldCount();

        // Set the last group to display if not export all
        if ($this->ExportAll && $this->isExport()) {
            $this->StopGroup = $this->TotalGroups;
        } else {
            $this->StopGroup = $this->StartGroup + $this->DisplayGroups - 1;
        }

        // Stop group <= total number of groups
        if (intval($this->StopGroup) > intval($this->TotalGroups)) {
            $this->StopGroup = $this->TotalGroups;
        }
        $this->RecordCount = 0;
        $this->RecordIndex = 0;

        // Set up pager
        $this->Pager = new PrevNextPager($this->TableVar, $this->StartGroup, $this->DisplayGroups, $this->TotalGroups, $this->PageSizes, $this->GroupRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

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

    // Load group row values
    public function loadGroupRowValues()
    {
        $cnt = count($this->GroupRecords); // Get record count
        if ($this->GroupCount < $cnt) {
            $this->expCategory->setGroupValue(reset($this->GroupRecords[$this->GroupCount]));
        } else {
            $this->expCategory->setGroupValue("");
        }
    }

    // Load row values
    public function loadRowValues($record)
    {
        $data = [];
        $data["expSubcategory"] = $record['expSubcategory'];
        $data["expCategory"] = $record['expCategory'];
        $data["amount"] = $record['amount'];
        $data["dateTrans"] = $record['dateTrans'];
        $data["receiptNumber"] = $record['receiptNumber'];
        $data["note"] = $record['note'];
        $data["submittedBy"] = $record['submittedBy'];
        $data["dateClosed"] = $record['dateClosed'];
        $data["validatedBy"] = $record['validatedBy'];
        $data["cash_float"] = $record['cash_float'];
        $this->Rows[] = $data;
        $this->expSubcategory->setDbValue($record['expSubcategory']);
        $this->expCategory->setDbValue(GroupValue($this->expCategory, $record['expCategory']));
        $this->amount->setDbValue($record['amount']);
        $this->dateTrans->setDbValue($record['dateTrans']);
        $this->receiptNumber->setDbValue($record['receiptNumber']);
        $this->note->setDbValue($record['note']);
        $this->submittedBy->setDbValue($record['submittedBy']);
        $this->dateClosed->setDbValue($record['dateClosed']);
        $this->validatedBy->setDbValue($record['validatedBy']);
        $this->cash_float->setDbValue($record['cash_float']);
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language, $Language;
        $conn = $this->getConnection();
        if ($this->RowType == ROWTYPE_TOTAL && $this->RowTotalSubType == ROWTOTAL_FOOTER && $this->RowTotalType == ROWTOTAL_PAGE) {
            // Build detail SQL
            $firstGrpFld = &$this->expCategory;
            $firstGrpFld->getDistinctValues($this->GroupRecords);
            $where = DetailFilterSql($firstGrpFld, $this->getSqlFirstGroupField(), $firstGrpFld->DistinctValues, $this->Dbid);
            if ($this->Filter != "") {
                $where = "($this->Filter) AND ($where)";
            }
            $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $where, $this->Sort);
            $rs = $sql->execute();
            $records = $rs ? $rs->fetchAll() : [];
            $this->amount->getSum($records);
            $this->cash_float->getSum($records);
            $this->PageTotalCount = count($records);
        } elseif ($this->RowType == ROWTYPE_TOTAL && $this->RowTotalSubType == ROWTOTAL_FOOTER && $this->RowTotalType == ROWTOTAL_GRAND) { // Get Grand total
            $hasCount = false;
            $hasSummary = false;

            // Get total count from SQL directly
            $sql = $this->buildReportSql($this->getSqlSelectCount(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
            $rstot = $conn->executeQuery($sql);
            if ($rstot && $cnt = $rstot->fetchOne()) {
                $hasCount = true;
            } else {
                $cnt = 0;
            }
            $this->TotalCount = $cnt;

            // Get total from SQL directly
            $sql = $this->buildReportSql($this->getSqlSelectAggregate(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
            $sql = $this->getSqlAggregatePrefix() . $sql . $this->getSqlAggregateSuffix();
            $rsagg = $conn->fetchAssociative($sql);
            if ($rsagg) {
                $this->amount->Count = $this->TotalCount;
                $this->amount->SumValue = $rsagg["sum_amount"];
                $this->receiptNumber->Count = $this->TotalCount;
                $this->note->Count = $this->TotalCount;
                $this->dateClosed->Count = $this->TotalCount;
                $this->validatedBy->Count = $this->TotalCount;
                $this->cash_float->Count = $this->TotalCount;
                $this->cash_float->SumValue = $rsagg["sum_cash_float"];
                $hasSummary = true;
            }

            // Accumulate grand summary from detail records
            if (!$hasCount || !$hasSummary) {
                $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
                $rs = $sql->execute();
                $this->DetailRecords = $rs ? $rs->fetchAll() : [];
                $this->amount->getSum($this->DetailRecords);
                $this->cash_float->getSum($this->DetailRecords);
            }
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // expCategory

        // expSubcategory

        // submittedBy

        // dateTrans

        // amount

        // receiptNumber

        // note

        // dateClosed

        // validatedBy

        // cash_float
        if ($this->RowType == ROWTYPE_SEARCH) {
            // expSubcategory
            if ($this->expSubcategory->UseFilter && !EmptyValue($this->expSubcategory->AdvancedSearch->SearchValue)) {
                if (is_array($this->expSubcategory->AdvancedSearch->SearchValue)) {
                    $this->expSubcategory->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->expSubcategory->AdvancedSearch->SearchValue);
                }
                $this->expSubcategory->EditValue = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->expSubcategory->AdvancedSearch->SearchValue);
            }

            // expCategory
            if ($this->expCategory->UseFilter && !EmptyValue($this->expCategory->AdvancedSearch->SearchValue)) {
                if (is_array($this->expCategory->AdvancedSearch->SearchValue)) {
                    $this->expCategory->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->expCategory->AdvancedSearch->SearchValue);
                }
                $this->expCategory->EditValue = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->expCategory->AdvancedSearch->SearchValue);
            }

            // dateTrans
            if ($this->dateTrans->UseFilter && !EmptyValue($this->dateTrans->AdvancedSearch->SearchValue)) {
                if (is_array($this->dateTrans->AdvancedSearch->SearchValue)) {
                    $this->dateTrans->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->dateTrans->AdvancedSearch->SearchValue);
                }
                $this->dateTrans->EditValue = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->dateTrans->AdvancedSearch->SearchValue);
            }

            // submittedBy
            if ($this->submittedBy->UseFilter && !EmptyValue($this->submittedBy->AdvancedSearch->SearchValue)) {
                if (is_array($this->submittedBy->AdvancedSearch->SearchValue)) {
                    $this->submittedBy->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->submittedBy->AdvancedSearch->SearchValue);
                }
                $this->submittedBy->EditValue = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->submittedBy->AdvancedSearch->SearchValue);
            }

            // dateClosed
            if ($this->dateClosed->UseFilter && !EmptyValue($this->dateClosed->AdvancedSearch->SearchValue)) {
                if (is_array($this->dateClosed->AdvancedSearch->SearchValue)) {
                    $this->dateClosed->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->dateClosed->AdvancedSearch->SearchValue);
                }
                $this->dateClosed->EditValue = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->dateClosed->AdvancedSearch->SearchValue);
            }

            // validatedBy
            if ($this->validatedBy->UseFilter && !EmptyValue($this->validatedBy->AdvancedSearch->SearchValue)) {
                if (is_array($this->validatedBy->AdvancedSearch->SearchValue)) {
                    $this->validatedBy->AdvancedSearch->SearchValue = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->validatedBy->AdvancedSearch->SearchValue);
                }
                $this->validatedBy->EditValue = explode(Config("MULTIPLE_OPTION_SEPARATOR"), $this->validatedBy->AdvancedSearch->SearchValue);
            }
        } elseif ($this->RowType == ROWTYPE_TOTAL && !($this->RowTotalType == ROWTOTAL_GROUP && $this->RowTotalSubType == ROWTOTAL_HEADER)) { // Summary row
            $this->RowAttrs->prependClass(($this->RowTotalType == ROWTOTAL_PAGE || $this->RowTotalType == ROWTOTAL_GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class
            if ($this->RowTotalType == ROWTOTAL_GROUP) {
                $this->RowAttrs["data-group"] = $this->expCategory->groupValue(); // Set up group attribute
            }
            if ($this->RowTotalType == ROWTOTAL_GROUP && $this->RowGroupLevel >= 2) {
                $this->RowAttrs["data-group-2"] = $this->expSubcategory->groupValue(); // Set up group attribute 2
            }
            if ($this->RowTotalType == ROWTOTAL_GROUP && $this->RowGroupLevel >= 3) {
                $this->RowAttrs["data-group-3"] = $this->submittedBy->groupValue(); // Set up group attribute 3
            }
            if ($this->RowTotalType == ROWTOTAL_GROUP && $this->RowGroupLevel >= 4) {
                $this->RowAttrs["data-group-4"] = $this->dateTrans->groupValue(); // Set up group attribute 4
            }

            // expCategory
            $this->expCategory->GroupViewValue = $this->expCategory->groupValue();
            $this->expCategory->CellCssClass = ($this->RowGroupLevel == 1 ? "ew-rpt-grp-summary-1" : "ew-rpt-grp-field-1");
            $this->expCategory->ViewCustomAttributes = "";
            $this->expCategory->GroupViewValue = DisplayGroupValue($this->expCategory, $this->expCategory->GroupViewValue);

            // expSubcategory
            $this->expSubcategory->GroupViewValue = $this->expSubcategory->groupValue();
            $this->expSubcategory->CellCssClass = ($this->RowGroupLevel == 2 ? "ew-rpt-grp-summary-2" : "ew-rpt-grp-field-2");
            $this->expSubcategory->ViewCustomAttributes = "";
            $this->expSubcategory->GroupViewValue = DisplayGroupValue($this->expSubcategory, $this->expSubcategory->GroupViewValue);

            // submittedBy
            $this->submittedBy->GroupViewValue = $this->submittedBy->groupValue();
            $this->submittedBy->CellCssClass = ($this->RowGroupLevel == 3 ? "ew-rpt-grp-summary-3" : "ew-rpt-grp-field-3");
            $this->submittedBy->ViewCustomAttributes = "";
            $this->submittedBy->GroupViewValue = DisplayGroupValue($this->submittedBy, $this->submittedBy->GroupViewValue);

            // dateTrans
            $this->dateTrans->GroupViewValue = $this->dateTrans->groupValue();
            $this->dateTrans->GroupViewValue = FormatDateTime($this->dateTrans->GroupViewValue, $this->dateTrans->formatPattern());
            $this->dateTrans->CellCssClass = ($this->RowGroupLevel == 4 ? "ew-rpt-grp-summary-4" : "ew-rpt-grp-field-4");
            $this->dateTrans->ViewCustomAttributes = "";
            $this->dateTrans->GroupViewValue = DisplayGroupValue($this->dateTrans, $this->dateTrans->GroupViewValue);

            // amount
            $this->amount->SumViewValue = $this->amount->SumValue;
            $this->amount->SumViewValue = FormatNumber($this->amount->SumViewValue, $this->amount->formatPattern());
            $this->amount->ViewCustomAttributes = "";
            $this->amount->CellAttrs["class"] = ($this->RowTotalType == ROWTOTAL_PAGE || $this->RowTotalType == ROWTOTAL_GRAND) ? "ew-rpt-grp-aggregate" : "ew-rpt-grp-summary-" . $this->RowGroupLevel;

            // cash_float
            $this->cash_float->SumViewValue = $this->cash_float->SumValue;
            $this->cash_float->SumViewValue = FormatNumber($this->cash_float->SumViewValue, $this->cash_float->formatPattern());
            $this->cash_float->ViewCustomAttributes = "";
            $this->cash_float->CellAttrs["class"] = ($this->RowTotalType == ROWTOTAL_PAGE || $this->RowTotalType == ROWTOTAL_GRAND) ? "ew-rpt-grp-aggregate" : "ew-rpt-grp-summary-" . $this->RowGroupLevel;

            // expCategory
            $this->expCategory->HrefValue = "";

            // expSubcategory
            $this->expSubcategory->HrefValue = "";

            // submittedBy
            $this->submittedBy->HrefValue = "";

            // dateTrans
            $this->dateTrans->HrefValue = "";

            // amount
            $this->amount->HrefValue = "";

            // receiptNumber
            $this->receiptNumber->HrefValue = "";

            // note
            $this->note->HrefValue = "";

            // dateClosed
            $this->dateClosed->HrefValue = "";

            // validatedBy
            $this->validatedBy->HrefValue = "";

            // cash_float
            $this->cash_float->HrefValue = "";
        } else {
            if ($this->RowTotalType == ROWTOTAL_GROUP && $this->RowTotalSubType == ROWTOTAL_HEADER) {
                $this->RowAttrs["data-group"] = $this->expCategory->groupValue(); // Set up group attribute
                if ($this->RowGroupLevel >= 2) {
                    $this->RowAttrs["data-group-2"] = $this->expSubcategory->groupValue(); // Set up group attribute 2
                }
                if ($this->RowGroupLevel >= 3) {
                    $this->RowAttrs["data-group-3"] = $this->submittedBy->groupValue(); // Set up group attribute 3
                }
                if ($this->RowGroupLevel >= 4) {
                    $this->RowAttrs["data-group-4"] = $this->dateTrans->groupValue(); // Set up group attribute 4
                }
            } else {
                $this->RowAttrs["data-group"] = $this->expCategory->groupValue(); // Set up group attribute
                $this->RowAttrs["data-group-2"] = $this->expSubcategory->groupValue(); // Set up group attribute 2
                $this->RowAttrs["data-group-3"] = $this->submittedBy->groupValue(); // Set up group attribute 3
                $this->RowAttrs["data-group-4"] = $this->dateTrans->groupValue(); // Set up group attribute 4
            }

            // expCategory
            $this->expCategory->GroupViewValue = $this->expCategory->groupValue();
            $this->expCategory->CellCssClass = "ew-rpt-grp-field-1";
            $this->expCategory->ViewCustomAttributes = "";
            $this->expCategory->GroupViewValue = DisplayGroupValue($this->expCategory, $this->expCategory->GroupViewValue);
            if (!$this->expCategory->LevelBreak) {
                $this->expCategory->GroupViewValue = "";
            } else {
                $this->expCategory->LevelBreak = false;
            }

            // expSubcategory
            $this->expSubcategory->GroupViewValue = $this->expSubcategory->groupValue();
            $this->expSubcategory->CellCssClass = "ew-rpt-grp-field-2";
            $this->expSubcategory->ViewCustomAttributes = "";
            $this->expSubcategory->GroupViewValue = DisplayGroupValue($this->expSubcategory, $this->expSubcategory->GroupViewValue);
            if (!$this->expSubcategory->LevelBreak) {
                $this->expSubcategory->GroupViewValue = "";
            } else {
                $this->expSubcategory->LevelBreak = false;
            }

            // submittedBy
            $this->submittedBy->GroupViewValue = $this->submittedBy->groupValue();
            $this->submittedBy->CellCssClass = "ew-rpt-grp-field-3";
            $this->submittedBy->ViewCustomAttributes = "";
            $this->submittedBy->GroupViewValue = DisplayGroupValue($this->submittedBy, $this->submittedBy->GroupViewValue);
            if (!$this->submittedBy->LevelBreak) {
                $this->submittedBy->GroupViewValue = "";
            } else {
                $this->submittedBy->LevelBreak = false;
            }

            // dateTrans
            $this->dateTrans->GroupViewValue = $this->dateTrans->groupValue();
            $this->dateTrans->GroupViewValue = FormatDateTime($this->dateTrans->GroupViewValue, $this->dateTrans->formatPattern());
            $this->dateTrans->CellCssClass = "ew-rpt-grp-field-4";
            $this->dateTrans->ViewCustomAttributes = "";
            $this->dateTrans->GroupViewValue = DisplayGroupValue($this->dateTrans, $this->dateTrans->GroupViewValue);
            if (!$this->dateTrans->LevelBreak) {
                $this->dateTrans->GroupViewValue = "";
            } else {
                $this->dateTrans->LevelBreak = false;
            }

            // amount
            $this->amount->ViewValue = $this->amount->CurrentValue;
            $this->amount->ViewValue = FormatNumber($this->amount->ViewValue, $this->amount->formatPattern());
            $this->amount->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->amount->ViewCustomAttributes = "";

            // receiptNumber
            $this->receiptNumber->ViewValue = $this->receiptNumber->CurrentValue;
            $this->receiptNumber->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->receiptNumber->ViewCustomAttributes = "";

            // note
            $this->note->ViewValue = $this->note->CurrentValue;
            $this->note->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->note->ViewCustomAttributes = "";

            // dateClosed
            $this->dateClosed->ViewValue = $this->dateClosed->CurrentValue;
            $this->dateClosed->ViewValue = FormatDateTime($this->dateClosed->ViewValue, $this->dateClosed->formatPattern());
            $this->dateClosed->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->dateClosed->ViewCustomAttributes = "";

            // validatedBy
            $this->validatedBy->ViewValue = $this->validatedBy->CurrentValue;
            $this->validatedBy->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->validatedBy->ViewCustomAttributes = "";

            // cash_float
            $this->cash_float->ViewValue = $this->cash_float->CurrentValue;
            $this->cash_float->ViewValue = FormatNumber($this->cash_float->ViewValue, $this->cash_float->formatPattern());
            $this->cash_float->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->cash_float->ViewCustomAttributes = "";

            // expCategory
            $this->expCategory->LinkCustomAttributes = "";
            $this->expCategory->HrefValue = "";
            $this->expCategory->TooltipValue = "";

            // expSubcategory
            $this->expSubcategory->LinkCustomAttributes = "";
            $this->expSubcategory->HrefValue = "";
            $this->expSubcategory->TooltipValue = "";

            // submittedBy
            $this->submittedBy->LinkCustomAttributes = "";
            $this->submittedBy->HrefValue = "";
            $this->submittedBy->TooltipValue = "";

            // dateTrans
            $this->dateTrans->LinkCustomAttributes = "";
            $this->dateTrans->HrefValue = "";
            $this->dateTrans->TooltipValue = "";

            // amount
            $this->amount->LinkCustomAttributes = "";
            $this->amount->HrefValue = "";
            $this->amount->TooltipValue = "";

            // receiptNumber
            $this->receiptNumber->LinkCustomAttributes = "";
            $this->receiptNumber->HrefValue = "";
            $this->receiptNumber->TooltipValue = "";

            // note
            $this->note->LinkCustomAttributes = "";
            $this->note->HrefValue = "";
            $this->note->TooltipValue = "";

            // dateClosed
            $this->dateClosed->LinkCustomAttributes = "";
            $this->dateClosed->HrefValue = "";
            $this->dateClosed->TooltipValue = "";

            // validatedBy
            $this->validatedBy->LinkCustomAttributes = "";
            $this->validatedBy->HrefValue = "";
            $this->validatedBy->TooltipValue = "";

            // cash_float
            $this->cash_float->LinkCustomAttributes = "";
            $this->cash_float->HrefValue = "";
            $this->cash_float->TooltipValue = "";
        }

        // Call Cell_Rendered event
        if ($this->RowType == ROWTYPE_TOTAL) {
            // expCategory
            $currentValue = $this->expCategory->GroupViewValue;
            $viewValue = &$this->expCategory->GroupViewValue;
            $viewAttrs = &$this->expCategory->ViewAttrs;
            $cellAttrs = &$this->expCategory->CellAttrs;
            $hrefValue = &$this->expCategory->HrefValue;
            $linkAttrs = &$this->expCategory->LinkAttrs;
            $this->cellRendered($this->expCategory, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // expSubcategory
            $currentValue = $this->expSubcategory->GroupViewValue;
            $viewValue = &$this->expSubcategory->GroupViewValue;
            $viewAttrs = &$this->expSubcategory->ViewAttrs;
            $cellAttrs = &$this->expSubcategory->CellAttrs;
            $hrefValue = &$this->expSubcategory->HrefValue;
            $linkAttrs = &$this->expSubcategory->LinkAttrs;
            $this->cellRendered($this->expSubcategory, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // submittedBy
            $currentValue = $this->submittedBy->GroupViewValue;
            $viewValue = &$this->submittedBy->GroupViewValue;
            $viewAttrs = &$this->submittedBy->ViewAttrs;
            $cellAttrs = &$this->submittedBy->CellAttrs;
            $hrefValue = &$this->submittedBy->HrefValue;
            $linkAttrs = &$this->submittedBy->LinkAttrs;
            $this->cellRendered($this->submittedBy, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // dateTrans
            $currentValue = $this->dateTrans->GroupViewValue;
            $viewValue = &$this->dateTrans->GroupViewValue;
            $viewAttrs = &$this->dateTrans->ViewAttrs;
            $cellAttrs = &$this->dateTrans->CellAttrs;
            $hrefValue = &$this->dateTrans->HrefValue;
            $linkAttrs = &$this->dateTrans->LinkAttrs;
            $this->cellRendered($this->dateTrans, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // amount
            $currentValue = $this->amount->SumValue;
            $viewValue = &$this->amount->SumViewValue;
            $viewAttrs = &$this->amount->ViewAttrs;
            $cellAttrs = &$this->amount->CellAttrs;
            $hrefValue = &$this->amount->HrefValue;
            $linkAttrs = &$this->amount->LinkAttrs;
            $this->cellRendered($this->amount, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cash_float
            $currentValue = $this->cash_float->SumValue;
            $viewValue = &$this->cash_float->SumViewValue;
            $viewAttrs = &$this->cash_float->ViewAttrs;
            $cellAttrs = &$this->cash_float->CellAttrs;
            $hrefValue = &$this->cash_float->HrefValue;
            $linkAttrs = &$this->cash_float->LinkAttrs;
            $this->cellRendered($this->cash_float, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
        } else {
            // expCategory
            $currentValue = $this->expCategory->groupValue();
            $viewValue = &$this->expCategory->GroupViewValue;
            $viewAttrs = &$this->expCategory->ViewAttrs;
            $cellAttrs = &$this->expCategory->CellAttrs;
            $hrefValue = &$this->expCategory->HrefValue;
            $linkAttrs = &$this->expCategory->LinkAttrs;
            $this->cellRendered($this->expCategory, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // expSubcategory
            $currentValue = $this->expSubcategory->groupValue();
            $viewValue = &$this->expSubcategory->GroupViewValue;
            $viewAttrs = &$this->expSubcategory->ViewAttrs;
            $cellAttrs = &$this->expSubcategory->CellAttrs;
            $hrefValue = &$this->expSubcategory->HrefValue;
            $linkAttrs = &$this->expSubcategory->LinkAttrs;
            $this->cellRendered($this->expSubcategory, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // submittedBy
            $currentValue = $this->submittedBy->groupValue();
            $viewValue = &$this->submittedBy->GroupViewValue;
            $viewAttrs = &$this->submittedBy->ViewAttrs;
            $cellAttrs = &$this->submittedBy->CellAttrs;
            $hrefValue = &$this->submittedBy->HrefValue;
            $linkAttrs = &$this->submittedBy->LinkAttrs;
            $this->cellRendered($this->submittedBy, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // dateTrans
            $currentValue = $this->dateTrans->groupValue();
            $viewValue = &$this->dateTrans->GroupViewValue;
            $viewAttrs = &$this->dateTrans->ViewAttrs;
            $cellAttrs = &$this->dateTrans->CellAttrs;
            $hrefValue = &$this->dateTrans->HrefValue;
            $linkAttrs = &$this->dateTrans->LinkAttrs;
            $this->cellRendered($this->dateTrans, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // amount
            $currentValue = $this->amount->CurrentValue;
            $viewValue = &$this->amount->ViewValue;
            $viewAttrs = &$this->amount->ViewAttrs;
            $cellAttrs = &$this->amount->CellAttrs;
            $hrefValue = &$this->amount->HrefValue;
            $linkAttrs = &$this->amount->LinkAttrs;
            $this->cellRendered($this->amount, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // receiptNumber
            $currentValue = $this->receiptNumber->CurrentValue;
            $viewValue = &$this->receiptNumber->ViewValue;
            $viewAttrs = &$this->receiptNumber->ViewAttrs;
            $cellAttrs = &$this->receiptNumber->CellAttrs;
            $hrefValue = &$this->receiptNumber->HrefValue;
            $linkAttrs = &$this->receiptNumber->LinkAttrs;
            $this->cellRendered($this->receiptNumber, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // note
            $currentValue = $this->note->CurrentValue;
            $viewValue = &$this->note->ViewValue;
            $viewAttrs = &$this->note->ViewAttrs;
            $cellAttrs = &$this->note->CellAttrs;
            $hrefValue = &$this->note->HrefValue;
            $linkAttrs = &$this->note->LinkAttrs;
            $this->cellRendered($this->note, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // dateClosed
            $currentValue = $this->dateClosed->CurrentValue;
            $viewValue = &$this->dateClosed->ViewValue;
            $viewAttrs = &$this->dateClosed->ViewAttrs;
            $cellAttrs = &$this->dateClosed->CellAttrs;
            $hrefValue = &$this->dateClosed->HrefValue;
            $linkAttrs = &$this->dateClosed->LinkAttrs;
            $this->cellRendered($this->dateClosed, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // validatedBy
            $currentValue = $this->validatedBy->CurrentValue;
            $viewValue = &$this->validatedBy->ViewValue;
            $viewAttrs = &$this->validatedBy->ViewAttrs;
            $cellAttrs = &$this->validatedBy->CellAttrs;
            $hrefValue = &$this->validatedBy->HrefValue;
            $linkAttrs = &$this->validatedBy->LinkAttrs;
            $this->cellRendered($this->validatedBy, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cash_float
            $currentValue = $this->cash_float->CurrentValue;
            $viewValue = &$this->cash_float->ViewValue;
            $viewAttrs = &$this->cash_float->ViewAttrs;
            $cellAttrs = &$this->cash_float->CellAttrs;
            $hrefValue = &$this->cash_float->HrefValue;
            $linkAttrs = &$this->cash_float->LinkAttrs;
            $this->cellRendered($this->cash_float, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
        }

        // Call Row_Rendered event
        $this->rowRendered();
        $this->setupFieldCount();
    }
    private $groupCounts = [];

    // Get group count
    public function getGroupCount(...$args)
    {
        $key = "";
        foreach ($args as $arg) {
            if ($key != "") {
                $key .= "_";
            }
            $key .= strval($arg);
        }
        if ($key == "") {
            return -1;
        } elseif ($key == "0") { // Number of first level groups
            $i = 1;
            while (isset($this->groupCounts[strval($i)])) {
                $i++;
            }
            return $i - 1;
        }
        return isset($this->groupCounts[$key]) ? $this->groupCounts[$key] : -1;
    }

    // Set group count
    public function setGroupCount($value, ...$args)
    {
        $key = "";
        foreach ($args as $arg) {
            if ($key != "") {
                $key .= "_";
            }
            $key .= strval($arg);
        }
        if ($key == "") {
            return;
        }
        $this->groupCounts[$key] = $value;
    }

    // Setup field count
    protected function setupFieldCount()
    {
        $this->GroupColumnCount = 0;
        $this->SubGroupColumnCount = 0;
        $this->DetailColumnCount = 0;
        if ($this->expCategory->Visible) {
            $this->GroupColumnCount += 1;
        }
        if ($this->expSubcategory->Visible) {
            $this->GroupColumnCount += 1;
            $this->SubGroupColumnCount += 1;
        }
        if ($this->submittedBy->Visible) {
            $this->GroupColumnCount += 1;
            $this->SubGroupColumnCount += 1;
        }
        if ($this->dateTrans->Visible) {
            $this->GroupColumnCount += 1;
            $this->SubGroupColumnCount += 1;
        }
        if ($this->amount->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->receiptNumber->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->note->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->dateClosed->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->validatedBy->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cash_float->Visible) {
            $this->DetailColumnCount += 1;
        }
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        if (SameText($type, "excel")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-excel" title="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToExcel", true)) . '" data-ew-action="export-charts" data-url="' . $exportUrl . '" data-exportid="' . session_id() . '">' . $Language->phrase("ExportToExcel") . '</button>';
        } elseif (SameText($type, "word")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-word" title="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToWord", true)) . '" data-ew-action="export-charts" data-url="' . $exportUrl . '" data-exportid="' . session_id() . '">' . $Language->phrase("ExportToWord") . '</button>';
        } elseif (SameText($type, "pdf")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-pdf" title="' . HtmlEncode($Language->phrase("ExportToPdf", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToPdf", true)) . '" data-ew-action="export-charts" data-url="' . $exportUrl . '" data-exportid="' . session_id() . '">' . $Language->phrase("ExportToPdf") . '</button>';
        } elseif (SameText($type, "email")) {
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-caption="' . HtmlEncode($Language->phrase("ExportToEmail", true)) . '" data-ew-action="email" data-hdr="' . HtmlEncode($Language->phrase("ExportToEmailText")) . '" data-url="' . $exportUrl . '" data-exportid="' . session_id() . '">' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("ExportToPrintText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPrintText")) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = true;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = true;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = false;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = false;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide options for export
        if ($this->isExport()) {
            $this->ExportOptions->hideAllOptions();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions(["TagClassName" => "ew-search-option"]);

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fEmpMonthlyExpensesrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields()
    {
        return $this->expSubcategory->Visible || $this->expCategory->Visible || $this->dateTrans->Visible || $this->submittedBy->Visible || $this->dateClosed->Visible || $this->validatedBy->Visible;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("summary", $this->TableVar, $url, "", $this->TableVar, true);
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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fEmpMonthlyExpensesrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fEmpMonthlyExpensesrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    // Set up starting group
    protected function setupStartGroup()
    {
        // Exit if no groups
        if ($this->DisplayGroups == 0) {
            return;
        }
        $startGrp = Param(Config("TABLE_START_GROUP"));
        $pageNo = Param(Config("TABLE_PAGE_NO"));

        // Check for a 'start' parameter
        if ($startGrp !== null) {
            $this->StartGroup = $startGrp;
            $this->setStartGroup($this->StartGroup);
        } elseif ($pageNo !== null) {
            $pageNo = ParseInteger($pageNo);
            if (is_numeric($pageNo)) {
                $this->StartGroup = ($pageNo - 1) * $this->DisplayGroups + 1;
                if ($this->StartGroup <= 0) {
                    $this->StartGroup = 1;
                } elseif ($this->StartGroup >= intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1) {
                    $this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1;
                }
                $this->setStartGroup($this->StartGroup);
            } else {
                $this->StartGroup = $this->getStartGroup();
            }
        } else {
            $this->StartGroup = $this->getStartGroup();
        }

        // Check if correct start group counter
        if (!is_numeric($this->StartGroup) || $this->StartGroup == "") { // Avoid invalid start group counter
            $this->StartGroup = 1; // Reset start group counter
            $this->setStartGroup($this->StartGroup);
        } elseif (intval($this->StartGroup) > intval($this->TotalGroups)) { // Avoid starting group > total groups
            $this->StartGroup = intval(($this->TotalGroups - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to last page first group
            $this->setStartGroup($this->StartGroup);
        } elseif (($this->StartGroup - 1) % $this->DisplayGroups != 0) {
            $this->StartGroup = intval(($this->StartGroup - 1) / $this->DisplayGroups) * $this->DisplayGroups + 1; // Point to page boundary
            $this->setStartGroup($this->StartGroup);
        }
    }

    // Reset pager
    protected function resetPager()
    {
        // Reset start position (reset command)
        $this->StartGroup = 1;
        $this->setStartGroup($this->StartGroup);
    }

    // Set up number of groups displayed per page
    protected function setupDisplayGroups()
    {
        if (Param(Config("TABLE_GROUP_PER_PAGE")) !== null) {
            $wrk = Param(Config("TABLE_GROUP_PER_PAGE"));
            if (is_numeric($wrk)) {
                $this->DisplayGroups = intval($wrk);
            } else {
                if (strtoupper($wrk) == "ALL") { // Display all groups
                    $this->DisplayGroups = -1;
                } else {
                    $this->DisplayGroups = 3; // Non-numeric, load default
                }
            }
            $this->setGroupPerPage($this->DisplayGroups); // Save to session

            // Reset start position (reset command)
            $this->StartGroup = 1;
            $this->setStartGroup($this->StartGroup);
        } else {
            if ($this->getGroupPerPage() != "") {
                $this->DisplayGroups = $this->getGroupPerPage(); // Restore from session
            } else {
                $this->DisplayGroups = 3; // Load default
            }
        }
    }

    // Get sort parameters based on sort links clicked
    protected function getSort()
    {
        if ($this->DrillDown) {
            return "";
        }
        $resetSort = Param("cmd") === "resetsort";
        $orderBy = Param("order", "");
        $orderType = Param("ordertype", "");

        // Check for a resetsort command
        if ($resetSort) {
            $this->setOrderBy("");
            $this->setStartGroup(1);
            $this->expSubcategory->setSort("");
            $this->expCategory->setSort("");
            $this->amount->setSort("");
            $this->dateTrans->setSort("");
            $this->receiptNumber->setSort("");
            $this->note->setSort("");
            $this->submittedBy->setSort("");
            $this->dateClosed->setSort("");
            $this->validatedBy->setSort("");
            $this->cash_float->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->expSubcategory); // expSubcategory
            $this->updateSort($this->expCategory); // expCategory
            $this->updateSort($this->amount); // amount
            $this->updateSort($this->dateTrans); // dateTrans
            $this->updateSort($this->receiptNumber); // receiptNumber
            $this->updateSort($this->note); // note
            $this->updateSort($this->submittedBy); // submittedBy
            $this->updateSort($this->dateClosed); // dateClosed
            $this->updateSort($this->validatedBy); // validatedBy
            $this->updateSort($this->cash_float); // cash_float
            $sortSql = $this->sortSql();
            $this->setOrderBy($sortSql);
            $this->setStartGroup(1);
        }
        return $this->getOrderBy();
    }

    // Return extended filter
    protected function getExtendedFilter()
    {
        $filter = "";
        if ($this->DrillDown) {
            return "";
        }
        $restoreSession = false;
        $restoreDefault = false;
        // Reset search command
        if (Get("cmd", "") == "reset") {
            // Set default values
            $this->expSubcategory->AdvancedSearch->unsetSession();
            $this->expCategory->AdvancedSearch->unsetSession();
            $this->dateTrans->AdvancedSearch->unsetSession();
            $this->submittedBy->AdvancedSearch->unsetSession();
            $this->dateClosed->AdvancedSearch->unsetSession();
            $this->validatedBy->AdvancedSearch->unsetSession();
            $restoreDefault = true;
        } else {
            $restoreSession = !$this->SearchCommand;

            // Field expSubcategory
            $this->getDropDownValue($this->expSubcategory);

            // Field expCategory
            $this->getDropDownValue($this->expCategory);

            // Field dateTrans
            $this->getDropDownValue($this->dateTrans);

            // Field submittedBy
            $this->getDropDownValue($this->submittedBy);

            // Field dateClosed
            $this->getDropDownValue($this->dateClosed);

            // Field validatedBy
            $this->getDropDownValue($this->validatedBy);
            if (!$this->validateForm()) {
                return $filter;
            }
        }

        // Restore session
        if ($restoreSession) {
            $restoreDefault = true;
            if ($this->expSubcategory->AdvancedSearch->issetSession()) { // Field expSubcategory
                $this->expSubcategory->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->expCategory->AdvancedSearch->issetSession()) { // Field expCategory
                $this->expCategory->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->dateTrans->AdvancedSearch->issetSession()) { // Field dateTrans
                $this->dateTrans->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->submittedBy->AdvancedSearch->issetSession()) { // Field submittedBy
                $this->submittedBy->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->dateClosed->AdvancedSearch->issetSession()) { // Field dateClosed
                $this->dateClosed->AdvancedSearch->load();
                $restoreDefault = false;
            }
            if ($this->validatedBy->AdvancedSearch->issetSession()) { // Field validatedBy
                $this->validatedBy->AdvancedSearch->load();
                $restoreDefault = false;
            }
        }

        // Restore default
        if ($restoreDefault) {
            $this->loadDefaultFilters();
        }

        // Call page filter validated event
        $this->pageFilterValidated();

        // Build SQL and save to session
        $this->buildDropDownFilter($this->expSubcategory, $filter, false, true); // Field expSubcategory
        $this->expSubcategory->AdvancedSearch->save();
        $this->buildDropDownFilter($this->expCategory, $filter, false, true); // Field expCategory
        $this->expCategory->AdvancedSearch->save();
        $this->buildDropDownFilter($this->dateTrans, $filter, false, true); // Field dateTrans
        $this->dateTrans->AdvancedSearch->save();
        $this->buildDropDownFilter($this->submittedBy, $filter, false, true); // Field submittedBy
        $this->submittedBy->AdvancedSearch->save();
        $this->buildDropDownFilter($this->dateClosed, $filter, false, true); // Field dateClosed
        $this->dateClosed->AdvancedSearch->save();
        $this->buildDropDownFilter($this->validatedBy, $filter, false, true); // Field validatedBy
        $this->validatedBy->AdvancedSearch->save();
        return $filter;
    }

    // Build dropdown filter
    protected function buildDropDownFilter(&$fld, &$filterClause, $default = false, $saveFilter = false)
    {
        $fldVal = $default ? $fld->AdvancedSearch->SearchValueDefault : $fld->AdvancedSearch->SearchValue;
        $fldOpr = $default ? $fld->AdvancedSearch->SearchOperatorDefault : $fld->AdvancedSearch->SearchOperator;
        $fldVal2 = $default ? $fld->AdvancedSearch->SearchValue2Default : $fld->AdvancedSearch->SearchValue2;
        if (!EmptyValue($fld->DateFilter)) {
            $fldOpr = $fld->DateFilter;
            $fldVal2 = "";
        } elseif ($fld->UseFilter) {
            $fldOpr = "";
            $fldVal2 = "";
        }
        $sql = "";
        if (is_array($fldVal)) {
            foreach ($fldVal as $val) {
                $wrk = $this->getDropDownFilter($fld, $val, $fldOpr);
                if ($wrk != "") {
                    if ($sql != "") {
                        $sql .= " OR " . $wrk;
                    } else {
                        $sql = $wrk;
                    }
                }
            }
        } else {
            $sql = $this->getDropDownFilter($fld, $fldVal, $fldOpr, $fldVal2);
        }
        if ($sql != "") {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
            AddFilter($filterClause, $sql, $cond);
            if ($saveFilter) {
                $fld->CurrentFilter = $sql;
            }
        }
    }

    // Get dropdown filter
    protected function getDropDownFilter(&$fld, $fldVal, $fldOpr, $fldVal2 = "")
    {
        $fldName = $fld->Name;
        $fldExpression = $fld->Expression;
        $fldDataType = $fld->DataType;
        $isMultiple = $fld->HtmlTag == "CHECKBOX" || $fld->HtmlTag == "SELECT" && $fld->SelectMultiple || $fld->UseFilter;
        $fldVal = strval($fldVal);
        if ($fldOpr == "") {
            $fldOpr = "=";
        }
        $wrk = "";
        if (SameString($fldVal, Config("NULL_VALUE"))) {
            $wrk = $fldExpression . " IS NULL";
        } elseif (SameString($fldVal, Config("NOT_NULL_VALUE"))) {
            $wrk = $fldExpression . " IS NOT NULL";
        } elseif (SameString($fldVal, Config("EMPTY_VALUE"))) {
            $wrk = $fldExpression . " = ''";
        } elseif (SameString($fldVal, Config("ALL_VALUE"))) {
            $wrk = "1 = 1";
        } else {
            if ($fld->GroupSql != "") { // Use grouping SQL for search if exists
                $fldExpression = str_replace("%s", $fldExpression, $fld->GroupSql);
            }
            if (StartsString("@@", $fldVal)) {
                $wrk = $this->getCustomFilter($fld, $fldVal, $this->Dbid);
            } elseif ($isMultiple && IsMultiSearchOperator($fldOpr) && trim($fldVal) != "" && $fldVal != Config("INIT_VALUE")) {
                $wrk = GetMultiSearchSql($fld, $fldOpr, trim($fldVal), $this->Dbid);
            } elseif ($fldOpr == "BETWEEN" && !EmptyValue($fldVal) && $fldVal != Config("INIT_VALUE") && !EmptyValue($fldVal2) && $fldVal2 != Config("INIT_VALUE")) {
                $wrk = $fldExpression ." " . $fldOpr . " " . QuotedValue($fldVal, $fldDataType, $this->Dbid) . " AND " . QuotedValue($fldVal2, $fldDataType, $this->Dbid);
            } else {
                if ($fldVal != "" && $fldVal != Config("INIT_VALUE")) {
                    if ($fldDataType == DATATYPE_DATE && $fldOpr != "") {
                        $wrk = GetDateFilterSql($fld->Expression, $fldOpr, $fldVal, $fldDataType, $this->Dbid);
                    } else {
                        $wrk = GetFilterSql($fldOpr, $fldVal, $fldDataType, $this->Dbid);
                        if ($wrk != "") {
                            $wrk = $fldExpression . $wrk;
                        }
                    }
                }
            }
        }

        // Call Page Filtering event
        if (!StartsString("@@", $fldVal)) {
            $this->pageFiltering($fld, $wrk, "dropdown", $fldOpr, $fldVal, "", "", $fldVal2);
        }
        return $wrk;
    }

    // Get custom filter
    protected function getCustomFilter(&$fld, $fldVal, $dbid = 0)
    {
        $wrk = "";
        if (is_array($fld->AdvancedFilters)) {
            foreach ($fld->AdvancedFilters as $filter) {
                if ($filter->ID == $fldVal && $filter->Enabled) {
                    $fldExpr = $fld->Expression;
                    $fn = $filter->FunctionName;
                    $wrkid = StartsString("@@", $filter->ID) ? substr($filter->ID, 2) : $filter->ID;
                    $fn = $fn != "" && !function_exists($fn) ? PROJECT_NAMESPACE . $fn : $fn;
                    if (function_exists($fn)) {
                        $wrk = $fn($fldExpr, $dbid);
                    } else {
                        $wrk = "";
                    }
                    $this->pageFiltering($fld, $wrk, "custom", $wrkid);
                    break;
                }
            }
        }
        return $wrk;
    }

    // Build extended filter
    protected function buildExtendedFilter(&$fld, &$filterClause, $default = false, $saveFilter = false)
    {
        $wrk = GetExtendedFilter($fld, $default, $this->Dbid);
        if (!$default) {
            $this->pageFiltering($fld, $wrk, "extended", $fld->AdvancedSearch->SearchOperator, $fld->AdvancedSearch->SearchValue, $fld->AdvancedSearch->SearchCondition, $fld->AdvancedSearch->SearchOperator2, $fld->AdvancedSearch->SearchValue2);
        }
        if ($wrk != "") {
            $cond = SameText($this->SearchOption, "OR") ? "OR" : "AND";
            AddFilter($filterClause, $wrk, $cond);
            if ($saveFilter) {
                $fld->CurrentFilter = $wrk;
            }
        }
    }

    // Get drop down value from querystring
    protected function getDropDownValue(&$fld)
    {
        if (IsPost()) {
            return false; // Skip post back
        }
        $res = false;
        $parm = $fld->Param;
        $opr = Get("z_$parm");
        if ($opr !== null) {
            $fld->AdvancedSearch->SearchOperator = $opr;
        }
        $val = Get("x_$parm");
        if ($val !== null) {
            if (is_array($val)) {
                $val = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $val);
            }
            $fld->AdvancedSearch->setSearchValue($val);
            $res = true;
        }
        $val2 = Get("y_$parm");
        if ($val2 !== null) {
            if (is_array($val2)) {
                $val2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $val2);
            }
            $fld->AdvancedSearch->setSearchValue2($val2);
            $res = true;
        }
        return $res;
    }

    // Dropdown filter exist
    protected function dropDownFilterExist(&$fld)
    {
        $wrk = "";
        $this->buildDropDownFilter($fld, $wrk);
        return ($wrk != "");
    }

    // Extended filter exist
    protected function extendedFilterExist(&$fld)
    {
        $extWrk = "";
        $this->buildExtendedFilter($fld, $extWrk);
        return ($extWrk != "");
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Load default value for filters
    protected function loadDefaultFilters()
    {
        // Set up default values for extended filters
    }

    // Show list of filters
    public function showFilterList()
    {
        global $Language;

        // Initialize
        $filterList = "";
        $captionClass = $this->isExport("email") ? "ew-filter-caption-email" : "ew-filter-caption";
        $captionSuffix = $this->isExport("email") ? ": " : "";

        // Show Filters
        if ($filterList != "") {
            $message = "<div id=\"ew-filter-list\" class=\"alert alert-info d-table\"><div id=\"ew-current-filters\">" .
                $Language->phrase("CurrentFilters") . "</div>" . $filterList . "</div>";
            $this->messageShowing($message, "");
            Write($message);
        }
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Return filter list in json
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd", "") != "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter", ""), true);
        return $this->setupFilterList($filter);
    }

    // Setup list of filters
    protected function setupFilterList($filter)
    {
        if (!is_array($filter)) {
            return false;
        }
        return true;
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
        //$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content
    }

    // Load Filters event
    public function pageFilterLoad()
    {
        // Enter your code here
        // Example: Register/Unregister Custom Extended Filter
        //RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
        //RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
        //UnregisterFilter($this-><Field>, 'StartsWithA');
    }

    // Page Selecting event
    public function pageSelecting(&$filter)
    {
        // Enter your code here
    }

    // Page Filter Validated event
    public function pageFilterValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Page Filtering event
    public function pageFiltering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "")
    {
        // Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
        //if ($typ == "dropdown" && $fld->Name == "MyField") // Dropdown filter
        //    $filter = "..."; // Modify the filter
        //if ($typ == "extended" && $fld->Name == "MyField") // Extended filter
        //    $filter = "..."; // Modify the filter
        //if ($typ == "custom" && $opr == "..." && $fld->Name == "MyField") // Custom filter, $opr is the custom filter ID
        //    $filter = "..."; // Modify the filter
    }

    // Cell Rendered event
    public function cellRendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs)
    {
        //$ViewValue = "xxx";
        //$ViewAttrs["class"] = "xxx";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
