<?php

namespace PHPMaker2022\efga_expense_system;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class SummaryReportSummary extends SummaryReport
{
    use MessagesTrait;

    // Page ID
    public $PageID = "summary";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'Summary Report';

    // Page object name
    public $PageObjName = "SummaryReportSummary";

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

        // Table object (SummaryReport)
        if (!isset($GLOBALS["SummaryReport"]) || get_class($GLOBALS["SummaryReport"]) == PROJECT_NAMESPACE . "SummaryReport") {
            $GLOBALS["SummaryReport"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'Summary Report');
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
        $this->id->setVisibility();
        $this->cashAdvance_id->setVisibility();
        $this->amount->setVisibility();
        $this->dateTrans->setVisibility();
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
        $this->receiptNumber->setVisibility();

        // Set up User ID
        $filter = "";
        $filter = $this->applyUserIDFilters($filter);
        $this->UserIDFilter = $filter;
        $this->Filter = $this->UserIDFilter;

        // Set up groups per page dynamically
        $this->setupDisplayGroups();

        // Set up Breadcrumb
        if (!$this->isExport() && !$DashboardReport) {
            $this->setupBreadcrumb();
        }

        // Load custom filters
        $this->pageFilterLoad();

        // Extended filter
        $extendedFilter = "";

        // No filter
        $this->FilterOptions["savecurrentfilter"]->Visible = false;
        $this->FilterOptions["deletefilter"]->Visible = false;

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

        // Get total count
        $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
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

        // Get current page records
        if ($this->TotalGroups > 0) {
            $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, $this->Sort);
            $rs = $sql->setFirstResult($this->StartGroup - 1)->setMaxResults($this->DisplayGroups)->execute();
            $this->DetailRecords = $rs->fetchAll(); // Get records
            $this->GroupCount = 1;
        }
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
        $this->setGroupCount($this->StopGroup - $this->StartGroup + 1, 1);

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

    // Load row values
    public function loadRowValues($record)
    {
        $data = [];
        $data["id"] = $record['id'];
        $data["cashAdvance_id"] = $record['cashAdvance_id'];
        $data["amount"] = $record['amount'];
        $data["dateTrans"] = $record['dateTrans'];
        $data["note"] = $record['note'];
        $data["submittedBy"] = $record['submittedBy'];
        $data["status"] = $record['status'];
        $data["dateClosed"] = $record['dateClosed'];
        $data["float_status"] = $record['float_status'];
        $data["validatedBy"] = $record['validatedBy'];
        $data["machine_id"] = $record['machine_id'];
        $data["cash_float"] = $record['cash_float'];
        $data["expCategory_id"] = $record['expCategory_id'];
        $data["receiptNumber"] = $record['receiptNumber'];
        $this->Rows[] = $data;
        $this->id->setDbValue($record['id']);
        $this->cashAdvance_id->setDbValue($record['cashAdvance_id']);
        $this->amount->setDbValue($record['amount']);
        $this->dateTrans->setDbValue($record['dateTrans']);
        $this->receipt->Upload->DbValue = $record['receipt'];
        $this->receipt->setDbValue($this->receipt->Upload->DbValue);
        $this->note->setDbValue($record['note']);
        $this->submittedBy->setDbValue($record['submittedBy']);
        $this->status->setDbValue($record['status']);
        $this->dateClosed->setDbValue($record['dateClosed']);
        $this->float_status->setDbValue($record['float_status']);
        $this->validatedBy->setDbValue($record['validatedBy']);
        $this->machine_id->setDbValue($record['machine_id']);
        $this->cash_float->setDbValue($record['cash_float']);
        $this->expCategory_id->setDbValue($record['expCategory_id']);
        $this->receiptNumber->setDbValue($record['receiptNumber']);
    }

    // Render row
    public function renderRow()
    {
        global $Security, $Language, $Language;
        $conn = $this->getConnection();
        if ($this->RowType == ROWTYPE_TOTAL && $this->RowTotalSubType == ROWTOTAL_FOOTER && $this->RowTotalType == ROWTOTAL_PAGE) { // Get Page total
            $records = &$this->DetailRecords;
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
            $hasSummary = true;

            // Accumulate grand summary from detail records
            if (!$hasCount || !$hasSummary) {
                $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
                $rs = $sql->execute();
                $this->DetailRecords = $rs ? $rs->fetchAll() : [];
            }
        }

        // Call Row_Rendering event
        $this->rowRendering();

        // id

        // cashAdvance_id

        // amount

        // dateTrans

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

        // receiptNumber
        if ($this->RowType == ROWTYPE_SEARCH) { // Search row
        } elseif ($this->RowType == ROWTYPE_TOTAL && !($this->RowTotalType == ROWTOTAL_GROUP && $this->RowTotalSubType == ROWTOTAL_HEADER)) { // Summary row
            $this->RowAttrs->prependClass(($this->RowTotalType == ROWTOTAL_PAGE || $this->RowTotalType == ROWTOTAL_GRAND) ? "ew-rpt-grp-aggregate" : ""); // Set up row class

            // id
            $this->id->HrefValue = "";

            // cashAdvance_id
            $this->cashAdvance_id->HrefValue = "";

            // amount
            $this->amount->HrefValue = "";

            // dateTrans
            $this->dateTrans->HrefValue = "";

            // receipt
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
            $this->note->HrefValue = "";

            // submittedBy
            $this->submittedBy->HrefValue = "";

            // status
            $this->status->HrefValue = "";

            // dateClosed
            $this->dateClosed->HrefValue = "";

            // float_status
            $this->float_status->HrefValue = "";

            // validatedBy
            $this->validatedBy->HrefValue = "";

            // machine_id
            $this->machine_id->HrefValue = "";

            // cash_float
            $this->cash_float->HrefValue = "";

            // expCategory_id
            $this->expCategory_id->HrefValue = "";

            // receiptNumber
            $this->receiptNumber->HrefValue = "";
        } else {
            if ($this->RowTotalType == ROWTOTAL_GROUP && $this->RowTotalSubType == ROWTOTAL_HEADER) {
            } else {
            }

            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
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
            $this->cashAdvance_id->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->cashAdvance_id->ViewCustomAttributes = "";

            // amount
            $this->amount->ViewValue = $this->amount->CurrentValue;
            $this->amount->ViewValue = FormatNumber($this->amount->ViewValue, $this->amount->formatPattern());
            $this->amount->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->amount->ViewCustomAttributes = "";

            // dateTrans
            $this->dateTrans->ViewValue = $this->dateTrans->CurrentValue;
            $this->dateTrans->ViewValue = FormatDateTime($this->dateTrans->ViewValue, $this->dateTrans->formatPattern());
            $this->dateTrans->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->dateTrans->ViewCustomAttributes = "";

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
            $this->receipt->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->receipt->ViewCustomAttributes = "";

            // note
            $this->note->ViewValue = $this->note->CurrentValue;
            $this->note->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->note->ViewCustomAttributes = "";

            // submittedBy
            $this->submittedBy->ViewValue = $this->submittedBy->CurrentValue;
            $this->submittedBy->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->submittedBy->ViewCustomAttributes = "";

            // status
            if (strval($this->status->CurrentValue) != "") {
                $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
            } else {
                $this->status->ViewValue = null;
            }
            $this->status->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->status->ViewCustomAttributes = "";

            // dateClosed
            $this->dateClosed->ViewValue = $this->dateClosed->CurrentValue;
            $this->dateClosed->ViewValue = FormatDateTime($this->dateClosed->ViewValue, $this->dateClosed->formatPattern());
            $this->dateClosed->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->dateClosed->ViewCustomAttributes = "";

            // float_status
            if (strval($this->float_status->CurrentValue) != "") {
                $this->float_status->ViewValue = $this->float_status->optionCaption($this->float_status->CurrentValue);
            } else {
                $this->float_status->ViewValue = null;
            }
            $this->float_status->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->float_status->ViewCustomAttributes = "";

            // validatedBy
            $this->validatedBy->ViewValue = $this->validatedBy->CurrentValue;
            $this->validatedBy->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
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
            $this->machine_id->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->machine_id->ViewCustomAttributes = "";

            // cash_float
            $this->cash_float->ViewValue = $this->cash_float->CurrentValue;
            $this->cash_float->ViewValue = FormatNumber($this->cash_float->ViewValue, $this->cash_float->formatPattern());
            $this->cash_float->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->cash_float->ViewCustomAttributes = "";

            // expCategory_id
            $this->expCategory_id->ViewValue = $this->expCategory_id->CurrentValue;
            $this->expCategory_id->ViewValue = FormatNumber($this->expCategory_id->ViewValue, $this->expCategory_id->formatPattern());
            $this->expCategory_id->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->expCategory_id->ViewCustomAttributes = "";

            // receiptNumber
            $this->receiptNumber->ViewValue = $this->receiptNumber->CurrentValue;
            $this->receiptNumber->CellCssClass = ($this->RecordCount % 2 != 1 ? "ew-table-alt-row" : "");
            $this->receiptNumber->ViewCustomAttributes = "";

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
                $this->receipt->LinkAttrs["data-rel"] = "SummaryReport_x_receipt";
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

            // expCategory_id
            $this->expCategory_id->LinkCustomAttributes = "";
            $this->expCategory_id->HrefValue = "";
            $this->expCategory_id->TooltipValue = "";

            // receiptNumber
            $this->receiptNumber->LinkCustomAttributes = "";
            $this->receiptNumber->HrefValue = "";
            $this->receiptNumber->TooltipValue = "";
        }

        // Call Cell_Rendered event
        if ($this->RowType == ROWTYPE_TOTAL) { // Summary row
        } else {
            // id
            $currentValue = $this->id->CurrentValue;
            $viewValue = &$this->id->ViewValue;
            $viewAttrs = &$this->id->ViewAttrs;
            $cellAttrs = &$this->id->CellAttrs;
            $hrefValue = &$this->id->HrefValue;
            $linkAttrs = &$this->id->LinkAttrs;
            $this->cellRendered($this->id, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cashAdvance_id
            $currentValue = $this->cashAdvance_id->CurrentValue;
            $viewValue = &$this->cashAdvance_id->ViewValue;
            $viewAttrs = &$this->cashAdvance_id->ViewAttrs;
            $cellAttrs = &$this->cashAdvance_id->CellAttrs;
            $hrefValue = &$this->cashAdvance_id->HrefValue;
            $linkAttrs = &$this->cashAdvance_id->LinkAttrs;
            $this->cellRendered($this->cashAdvance_id, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // amount
            $currentValue = $this->amount->CurrentValue;
            $viewValue = &$this->amount->ViewValue;
            $viewAttrs = &$this->amount->ViewAttrs;
            $cellAttrs = &$this->amount->CellAttrs;
            $hrefValue = &$this->amount->HrefValue;
            $linkAttrs = &$this->amount->LinkAttrs;
            $this->cellRendered($this->amount, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // dateTrans
            $currentValue = $this->dateTrans->CurrentValue;
            $viewValue = &$this->dateTrans->ViewValue;
            $viewAttrs = &$this->dateTrans->ViewAttrs;
            $cellAttrs = &$this->dateTrans->CellAttrs;
            $hrefValue = &$this->dateTrans->HrefValue;
            $linkAttrs = &$this->dateTrans->LinkAttrs;
            $this->cellRendered($this->dateTrans, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // receipt
            $currentValue = $this->receipt->CurrentValue;
            $viewValue = &$this->receipt->ViewValue;
            $viewAttrs = &$this->receipt->ViewAttrs;
            $cellAttrs = &$this->receipt->CellAttrs;
            $hrefValue = &$this->receipt->HrefValue;
            $linkAttrs = &$this->receipt->LinkAttrs;
            $this->cellRendered($this->receipt, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // note
            $currentValue = $this->note->CurrentValue;
            $viewValue = &$this->note->ViewValue;
            $viewAttrs = &$this->note->ViewAttrs;
            $cellAttrs = &$this->note->CellAttrs;
            $hrefValue = &$this->note->HrefValue;
            $linkAttrs = &$this->note->LinkAttrs;
            $this->cellRendered($this->note, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // submittedBy
            $currentValue = $this->submittedBy->CurrentValue;
            $viewValue = &$this->submittedBy->ViewValue;
            $viewAttrs = &$this->submittedBy->ViewAttrs;
            $cellAttrs = &$this->submittedBy->CellAttrs;
            $hrefValue = &$this->submittedBy->HrefValue;
            $linkAttrs = &$this->submittedBy->LinkAttrs;
            $this->cellRendered($this->submittedBy, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // status
            $currentValue = $this->status->CurrentValue;
            $viewValue = &$this->status->ViewValue;
            $viewAttrs = &$this->status->ViewAttrs;
            $cellAttrs = &$this->status->CellAttrs;
            $hrefValue = &$this->status->HrefValue;
            $linkAttrs = &$this->status->LinkAttrs;
            $this->cellRendered($this->status, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // dateClosed
            $currentValue = $this->dateClosed->CurrentValue;
            $viewValue = &$this->dateClosed->ViewValue;
            $viewAttrs = &$this->dateClosed->ViewAttrs;
            $cellAttrs = &$this->dateClosed->CellAttrs;
            $hrefValue = &$this->dateClosed->HrefValue;
            $linkAttrs = &$this->dateClosed->LinkAttrs;
            $this->cellRendered($this->dateClosed, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // float_status
            $currentValue = $this->float_status->CurrentValue;
            $viewValue = &$this->float_status->ViewValue;
            $viewAttrs = &$this->float_status->ViewAttrs;
            $cellAttrs = &$this->float_status->CellAttrs;
            $hrefValue = &$this->float_status->HrefValue;
            $linkAttrs = &$this->float_status->LinkAttrs;
            $this->cellRendered($this->float_status, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // validatedBy
            $currentValue = $this->validatedBy->CurrentValue;
            $viewValue = &$this->validatedBy->ViewValue;
            $viewAttrs = &$this->validatedBy->ViewAttrs;
            $cellAttrs = &$this->validatedBy->CellAttrs;
            $hrefValue = &$this->validatedBy->HrefValue;
            $linkAttrs = &$this->validatedBy->LinkAttrs;
            $this->cellRendered($this->validatedBy, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // machine_id
            $currentValue = $this->machine_id->CurrentValue;
            $viewValue = &$this->machine_id->ViewValue;
            $viewAttrs = &$this->machine_id->ViewAttrs;
            $cellAttrs = &$this->machine_id->CellAttrs;
            $hrefValue = &$this->machine_id->HrefValue;
            $linkAttrs = &$this->machine_id->LinkAttrs;
            $this->cellRendered($this->machine_id, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // cash_float
            $currentValue = $this->cash_float->CurrentValue;
            $viewValue = &$this->cash_float->ViewValue;
            $viewAttrs = &$this->cash_float->ViewAttrs;
            $cellAttrs = &$this->cash_float->CellAttrs;
            $hrefValue = &$this->cash_float->HrefValue;
            $linkAttrs = &$this->cash_float->LinkAttrs;
            $this->cellRendered($this->cash_float, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // expCategory_id
            $currentValue = $this->expCategory_id->CurrentValue;
            $viewValue = &$this->expCategory_id->ViewValue;
            $viewAttrs = &$this->expCategory_id->ViewAttrs;
            $cellAttrs = &$this->expCategory_id->CellAttrs;
            $hrefValue = &$this->expCategory_id->HrefValue;
            $linkAttrs = &$this->expCategory_id->LinkAttrs;
            $this->cellRendered($this->expCategory_id, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);

            // receiptNumber
            $currentValue = $this->receiptNumber->CurrentValue;
            $viewValue = &$this->receiptNumber->ViewValue;
            $viewAttrs = &$this->receiptNumber->ViewAttrs;
            $cellAttrs = &$this->receiptNumber->CellAttrs;
            $hrefValue = &$this->receiptNumber->HrefValue;
            $linkAttrs = &$this->receiptNumber->LinkAttrs;
            $this->cellRendered($this->receiptNumber, $currentValue, $viewValue, $viewAttrs, $cellAttrs, $hrefValue, $linkAttrs);
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
        if ($this->id->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cashAdvance_id->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->amount->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->dateTrans->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->receipt->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->note->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->submittedBy->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->status->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->dateClosed->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->float_status->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->validatedBy->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->machine_id->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->cash_float->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->expCategory_id->Visible) {
            $this->DetailColumnCount += 1;
        }
        if ($this->receiptNumber->Visible) {
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
        return false;
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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fSummaryReportsrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = false;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fSummaryReportsrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = false;
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
            $this->id->setSort("");
            $this->cashAdvance_id->setSort("");
            $this->amount->setSort("");
            $this->dateTrans->setSort("");
            $this->receipt->setSort("");
            $this->note->setSort("");
            $this->submittedBy->setSort("");
            $this->status->setSort("");
            $this->dateClosed->setSort("");
            $this->float_status->setSort("");
            $this->validatedBy->setSort("");
            $this->machine_id->setSort("");
            $this->cash_float->setSort("");
            $this->expCategory_id->setSort("");
            $this->receiptNumber->setSort("");

        // Check for an Order parameter
        } elseif ($orderBy != "") {
            $this->CurrentOrder = $orderBy;
            $this->CurrentOrderType = $orderType;
            $this->updateSort($this->id); // id
            $this->updateSort($this->cashAdvance_id); // cashAdvance_id
            $this->updateSort($this->amount); // amount
            $this->updateSort($this->dateTrans); // dateTrans
            $this->updateSort($this->receipt); // receipt
            $this->updateSort($this->note); // note
            $this->updateSort($this->submittedBy); // submittedBy
            $this->updateSort($this->status); // status
            $this->updateSort($this->dateClosed); // dateClosed
            $this->updateSort($this->float_status); // float_status
            $this->updateSort($this->validatedBy); // validatedBy
            $this->updateSort($this->machine_id); // machine_id
            $this->updateSort($this->cash_float); // cash_float
            $this->updateSort($this->expCategory_id); // expCategory_id
            $this->updateSort($this->receiptNumber); // receiptNumber
            $sortSql = $this->sortSql();
            $this->setOrderBy($sortSql);
            $this->setStartGroup(1);
        }
        return $this->getOrderBy();
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
