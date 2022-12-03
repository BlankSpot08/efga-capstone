<?php

namespace PHPMaker2022\efga_expense_system;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for Machine Repair History
 */
class MachineRepairHistory extends ReportTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";
    public $ShowGroupHeaderAsRow = false;
    public $ShowCompactSummaryFooter = true;

    // Export
    public $ExportDoc;

    // Fields
    public $dateTrans;
    public $amount;
    public $machine_category;
    public $brand;
    public $model;
    public $note;
    public $receiptNumber;
    public $receipt;
    public $expSubcategory;
    public $status;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'MachineRepairHistory';
        $this->TableName = 'Machine Repair History';
        $this->TableType = 'REPORT';

        // Update Table
        $this->UpdateTable = "`machinerepairhistory`";
        $this->ReportSourceTable = 'machinerepairhistory2'; // Report source table
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (report only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordVersion = 12; // Word version (PHPWord only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = "A4"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions

        // dateTrans
        $this->dateTrans = new ReportField(
            'MachineRepairHistory',
            'Machine Repair History',
            'x_dateTrans',
            'dateTrans',
            '`dateTrans`',
            CastDateFieldForLike("`dateTrans`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`dateTrans`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->dateTrans->InputTextType = "text";
        $this->dateTrans->Required = true; // Required field
        $this->dateTrans->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dateTrans->SourceTableVar = 'machinerepairhistory2';
        $this->Fields['dateTrans'] = &$this->dateTrans;

        // amount
        $this->amount = new ReportField(
            'MachineRepairHistory',
            'Machine Repair History',
            'x_amount',
            'amount',
            '`amount`',
            '`amount`',
            3,
            7,
            -1,
            false,
            '`amount`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->amount->InputTextType = "text";
        $this->amount->Required = true; // Required field
        $this->amount->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->amount->SourceTableVar = 'machinerepairhistory2';
        $this->Fields['amount'] = &$this->amount;

        // machine_category
        $this->machine_category = new ReportField(
            'MachineRepairHistory',
            'Machine Repair History',
            'x_machine_category',
            'machine_category',
            '`machine_category`',
            '`machine_category`',
            200,
            50,
            -1,
            false,
            '`machine_category`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->machine_category->InputTextType = "text";
        $this->machine_category->GroupingFieldId = 2;
        $this->machine_category->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
        $this->machine_category->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
        $this->machine_category->GroupByType = "";
        $this->machine_category->GroupInterval = "0";
        $this->machine_category->GroupSql = "";
        $this->machine_category->Required = true; // Required field
        $this->machine_category->UseFilter = true; // Table header filter
        switch ($CurrentLanguage) {
            case "en-US":
                $this->machine_category->Lookup = new Lookup('machine_category', 'MachineRepairHistory', true, 'machine_category', ["machine_category","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->machine_category->Lookup = new Lookup('machine_category', 'MachineRepairHistory', true, 'machine_category', ["machine_category","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->machine_category->SourceTableVar = 'machinerepairhistory2';
        $this->Fields['machine_category'] = &$this->machine_category;

        // brand
        $this->brand = new ReportField(
            'MachineRepairHistory',
            'Machine Repair History',
            'x_brand',
            'brand',
            '`brand`',
            '`brand`',
            200,
            50,
            -1,
            false,
            '`brand`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->brand->InputTextType = "text";
        $this->brand->GroupingFieldId = 3;
        $this->brand->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
        $this->brand->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
        $this->brand->GroupByType = "";
        $this->brand->GroupInterval = "0";
        $this->brand->GroupSql = "";
        $this->brand->Required = true; // Required field
        $this->brand->UseFilter = true; // Table header filter
        switch ($CurrentLanguage) {
            case "en-US":
                $this->brand->Lookup = new Lookup('brand', 'MachineRepairHistory', true, 'brand', ["brand","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->brand->Lookup = new Lookup('brand', 'MachineRepairHistory', true, 'brand', ["brand","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->brand->SourceTableVar = 'machinerepairhistory2';
        $this->Fields['brand'] = &$this->brand;

        // model
        $this->model = new ReportField(
            'MachineRepairHistory',
            'Machine Repair History',
            'x_model',
            'model',
            '`model`',
            '`model`',
            200,
            100,
            -1,
            false,
            '`model`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->model->InputTextType = "text";
        $this->model->GroupingFieldId = 4;
        $this->model->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
        $this->model->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
        $this->model->GroupByType = "";
        $this->model->GroupInterval = "0";
        $this->model->GroupSql = "";
        $this->model->Required = true; // Required field
        $this->model->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->model->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->model->UseFilter = true; // Table header filter
        switch ($CurrentLanguage) {
            case "en-US":
                $this->model->Lookup = new Lookup('model', 'machine', true, 'id', ["model","","",""], [], [], [], [], [], [], '', '', "`model`");
                break;
            default:
                $this->model->Lookup = new Lookup('model', 'machine', true, 'id', ["model","","",""], [], [], [], [], [], [], '', '', "`model`");
                break;
        }
        $this->model->AdvancedSearch->SearchValueDefault = Config("INIT_VALUE");
        $this->model->SourceTableVar = 'machinerepairhistory2';
        $this->Fields['model'] = &$this->model;

        // note
        $this->note = new ReportField(
            'MachineRepairHistory',
            'Machine Repair History',
            'x_note',
            'note',
            '`note`',
            '`note`',
            200,
            200,
            -1,
            false,
            '`note`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->note->InputTextType = "text";
        $this->note->SourceTableVar = 'machinerepairhistory2';
        $this->Fields['note'] = &$this->note;

        // receiptNumber
        $this->receiptNumber = new ReportField(
            'MachineRepairHistory',
            'Machine Repair History',
            'x_receiptNumber',
            'receiptNumber',
            '`receiptNumber`',
            '`receiptNumber`',
            200,
            100,
            -1,
            false,
            '`receiptNumber`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->receiptNumber->InputTextType = "text";
        $this->receiptNumber->Required = true; // Required field
        $this->receiptNumber->SourceTableVar = 'machinerepairhistory2';
        $this->Fields['receiptNumber'] = &$this->receiptNumber;

        // receipt
        $this->receipt = new ReportField(
            'MachineRepairHistory',
            'Machine Repair History',
            'x_receipt',
            'receipt',
            '`receipt`',
            '`receipt`',
            205,
            0,
            -1,
            true,
            '`receipt`',
            false,
            false,
            false,
            'IMAGE',
            'FILE'
        );
        $this->receipt->InputTextType = "text";
        $this->receipt->Required = true; // Required field
        $this->receipt->Sortable = false; // Allow sort
        $this->receipt->SourceTableVar = 'machinerepairhistory2';
        $this->Fields['receipt'] = &$this->receipt;

        // expSubcategory
        $this->expSubcategory = new ReportField(
            'MachineRepairHistory',
            'Machine Repair History',
            'x_expSubcategory',
            'expSubcategory',
            '`expSubcategory`',
            '`expSubcategory`',
            200,
            50,
            -1,
            false,
            '`expSubcategory`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->expSubcategory->InputTextType = "text";
        $this->expSubcategory->GroupingFieldId = 1;
        $this->expSubcategory->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
        $this->expSubcategory->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
        $this->expSubcategory->GroupByType = "";
        $this->expSubcategory->GroupInterval = "0";
        $this->expSubcategory->GroupSql = "";
        $this->expSubcategory->Required = true; // Required field
        $this->expSubcategory->UseFilter = true; // Table header filter
        switch ($CurrentLanguage) {
            case "en-US":
                $this->expSubcategory->Lookup = new Lookup('expSubcategory', 'MachineRepairHistory', true, 'expSubcategory', ["expSubcategory","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->expSubcategory->Lookup = new Lookup('expSubcategory', 'MachineRepairHistory', true, 'expSubcategory', ["expSubcategory","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->expSubcategory->SourceTableVar = 'machinerepairhistory2';
        $this->Fields['expSubcategory'] = &$this->expSubcategory;

        // status
        $this->status = new ReportField(
            'MachineRepairHistory',
            'Machine Repair History',
            'x_status',
            'status',
            '`status`',
            '`status`',
            3,
            7,
            -1,
            false,
            '`status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->status->InputTextType = "text";
        $this->status->Required = true; // Required field
        switch ($CurrentLanguage) {
            case "en-US":
                $this->status->Lookup = new Lookup('status', 'MachineRepairHistory', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->status->Lookup = new Lookup('status', 'MachineRepairHistory', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->status->OptionCount = 3;
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->status->SourceTableVar = 'machinerepairhistory2';
        $this->Fields['status'] = &$this->status;

        // Add Doctrine Cache
        $this->Cache = new ArrayCache();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Single column sort
    protected function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($fld->GroupingFieldId == 0) {
                $this->setDetailOrderBy($curOrderBy); // Save to Session
            }
        } else {
            if ($fld->GroupingFieldId == 0) {
                $fld->setSort("");
            }
        }
    }

    // Get Sort SQL
    protected function sortSql()
    {
        $dtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
        $argrps = [];
        foreach ($this->Fields as $fld) {
            if (in_array($fld->getSort(), ["ASC", "DESC"])) {
                $fldsql = $fld->Expression;
                if ($fld->GroupingFieldId > 0) {
                    if ($fld->GroupSql != "") {
                        $argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->GroupSql) . " " . $fld->getSort();
                    } else {
                        $argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
                    }
                }
            }
        }
        $sortSql = "";
        foreach ($argrps as $grp) {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $grp;
        }
        if ($dtlSortSql != "") {
            if ($sortSql != "") {
                $sortSql .= ", ";
            }
            $sortSql .= $dtlSortSql;
        }
        return $sortSql;
    }

    // Table Level Group SQL
    private $sqlFirstGroupField = "";
    private $sqlSelectGroup = null;
    private $sqlOrderByGroup = "";

    // First Group Field
    public function getSqlFirstGroupField($alias = false)
    {
        if ($this->sqlFirstGroupField != "") {
            return $this->sqlFirstGroupField;
        }
        $firstGroupField = &$this->expSubcategory;
        $expr = $firstGroupField->Expression;
        if ($firstGroupField->GroupSql != "") {
            $expr = str_replace("%s", $firstGroupField->Expression, $firstGroupField->GroupSql);
            if ($alias) {
                $expr .= " AS " . QuotedName($firstGroupField->getGroupName(), $this->Dbid);
            }
        }
        return $expr;
    }

    public function setSqlFirstGroupField($v)
    {
        $this->sqlFirstGroupField = $v;
    }

    // Select Group
    public function getSqlSelectGroup()
    {
        return $this->sqlSelectGroup ?? $this->getQueryBuilder()->select($this->getSqlFirstGroupField(true))->distinct();
    }

    public function setSqlSelectGroup($v)
    {
        $this->sqlSelectGroup = $v;
    }

    // Order By Group
    public function getSqlOrderByGroup()
    {
        if ($this->sqlOrderByGroup != "") {
            return $this->sqlOrderByGroup;
        }
        return $this->getSqlFirstGroupField() . " ASC";
    }

    public function setSqlOrderByGroup($v)
    {
        $this->sqlOrderByGroup = $v;
    }

    // Summary properties
    private $sqlSelectAggregate = null;
    private $sqlAggregatePrefix = "";
    private $sqlAggregateSuffix = "";
    private $sqlSelectCount = null;

    // Select Aggregate
    public function getSqlSelectAggregate()
    {
        return $this->sqlSelectAggregate ?? $this->getQueryBuilder()->select("SUM(`amount`) AS `sum_amount`");
    }

    public function setSqlSelectAggregate($v)
    {
        $this->sqlSelectAggregate = $v;
    }

    // Aggregate Prefix
    public function getSqlAggregatePrefix()
    {
        return ($this->sqlAggregatePrefix != "") ? $this->sqlAggregatePrefix : "";
    }

    public function setSqlAggregatePrefix($v)
    {
        $this->sqlAggregatePrefix = $v;
    }

    // Aggregate Suffix
    public function getSqlAggregateSuffix()
    {
        return ($this->sqlAggregateSuffix != "") ? $this->sqlAggregateSuffix : "";
    }

    public function setSqlAggregateSuffix($v)
    {
        $this->sqlAggregateSuffix = $v;
    }

    // Select Count
    public function getSqlSelectCount()
    {
        return $this->sqlSelectCount ?? $this->getQueryBuilder()->select("COUNT(*)");
    }

    public function setSqlSelectCount($v)
    {
        $this->sqlSelectCount = $v;
    }

    // Render for lookup
    public function renderLookup()
    {
        $this->machine_category->ViewValue = $this->machine_category->CurrentValue;
        $this->model->ViewValue = GetDropDownDisplayValue($this->model->CurrentValue, "", 0);
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`machinerepairhistory`";
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
        if ($this->SqlSelect) {
            return $this->SqlSelect;
        }
        $select = $this->getQueryBuilder()->select("*");
        $groupField = &$this->expSubcategory;
        if ($groupField->GroupSql != "") {
            $expr = str_replace("%s", $groupField->Expression, $groupField->GroupSql) . " AS " . QuotedName($groupField->getGroupName(), $this->Dbid);
            $select->addSelect($expr);
        }
        $groupField = &$this->machine_category;
        if ($groupField->GroupSql != "") {
            $expr = str_replace("%s", $groupField->Expression, $groupField->GroupSql) . " AS " . QuotedName($groupField->getGroupName(), $this->Dbid);
            $select->addSelect($expr);
        }
        $groupField = &$this->brand;
        if ($groupField->GroupSql != "") {
            $expr = str_replace("%s", $groupField->Expression, $groupField->GroupSql) . " AS " . QuotedName($groupField->getGroupName(), $this->Dbid);
            $select->addSelect($expr);
        }
        $groupField = &$this->model;
        if ($groupField->GroupSql != "") {
            $expr = str_replace("%s", $groupField->Expression, $groupField->GroupSql) . " AS " . QuotedName($groupField->getGroupName(), $this->Dbid);
            $select->addSelect($expr);
        }
        return $select;
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
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
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

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 0) {
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
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
        return $_SESSION[$name] ?? GetUrl("");
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
        if ($pageName == "") {
            return $Language->phrase("View");
        } elseif ($pageName == "") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "";
            case Config("API_ADD_ACTION"):
                return "";
            case Config("API_EDIT_ACTION"):
                return "";
            case Config("API_DELETE_ACTION"):
                return "";
            case Config("API_LIST_ACTION"):
                return "";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "?" . $this->getUrlParm($parm);
        } else {
            $url = "";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-sort-url="' . $sortUrl . '" data-sort-type="1"';
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
            $this->DrillDown || $DashboardReport ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
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
            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                $ar[] = $key;
            }
        }
        return $ar;
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

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'receipt') {
            $fldName = "receipt";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 0) {
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $sql = $this->buildReportSql($this->getSqlSelect(), $this->getSqlFrom(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $filter, "");
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
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
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
