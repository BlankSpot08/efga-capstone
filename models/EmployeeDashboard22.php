<?php

namespace PHPMaker2022\efga_expense_system;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for Employee Dashboard
 */
class EmployeeDashboard22 extends DbTable
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

    // Export
    public $ExportDoc;

    // Fields
    public $id;
    public $cashAdvance_id;
    public $amount;
    public $dateTrans;
    public $receiptNumber;
    public $receipt;
    public $note;
    public $submittedBy;
    public $status;
    public $dateClosed;
    public $float_status;
    public $cash_float;
    public $validatedBy;
    public $machine_id;
    public $expCategory_id;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'EmployeeDashboard22';
        $this->TableName = 'Employee Dashboard';
        $this->TableType = 'LINKTABLE';

        // Update Table
        $this->UpdateTable = "`emp_expense`";
        $this->Dbid = 'capstone1';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordVersion = 12; // Word version (PHPWord only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = "A4"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
            'x_id',
            'id',
            '`id`',
            '`id`',
            3,
            7,
            -1,
            false,
            '`id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->id->InputTextType = "text";
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['id'] = &$this->id;

        // cashAdvance_id
        $this->cashAdvance_id = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
            'x_cashAdvance_id',
            'cashAdvance_id',
            '`cashAdvance_id`',
            '`cashAdvance_id`',
            3,
            7,
            -1,
            false,
            '`cashAdvance_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->cashAdvance_id->InputTextType = "text";
        $this->cashAdvance_id->Required = true; // Required field
        $this->cashAdvance_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->cashAdvance_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->cashAdvance_id->Lookup = new Lookup('cashAdvance_id', 'cash_advance', false, 'id', ["expCategory_id","expSubcategory_id","budget_id",""], [], [], [], [], ["expCategory_id"], ["x_expCategory_id"], '', '', "CONCAT(COALESCE(`expCategory_id`, ''),'" . ValueSeparator(1, $this->cashAdvance_id) . "',COALESCE(`expSubcategory_id`,''),'" . ValueSeparator(2, $this->cashAdvance_id) . "',COALESCE(`budget_id`,''))");
                break;
            default:
                $this->cashAdvance_id->Lookup = new Lookup('cashAdvance_id', 'cash_advance', false, 'id', ["expCategory_id","expSubcategory_id","budget_id",""], [], [], [], [], ["expCategory_id"], ["x_expCategory_id"], '', '', "CONCAT(COALESCE(`expCategory_id`, ''),'" . ValueSeparator(1, $this->cashAdvance_id) . "',COALESCE(`expSubcategory_id`,''),'" . ValueSeparator(2, $this->cashAdvance_id) . "',COALESCE(`budget_id`,''))");
                break;
        }
        $this->cashAdvance_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cashAdvance_id'] = &$this->cashAdvance_id;

        // amount
        $this->amount = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
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
        $this->Fields['amount'] = &$this->amount;

        // dateTrans
        $this->dateTrans = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
            'x_dateTrans',
            'dateTrans',
            '`dateTrans`',
            CastDateFieldForLike("`dateTrans`", 0, "capstone1"),
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
        $this->dateTrans->UseFilter = true; // Table header filter
        switch ($CurrentLanguage) {
            case "en-US":
                $this->dateTrans->Lookup = new Lookup('dateTrans', 'EmployeeDashboard22', true, 'dateTrans', ["dateTrans","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->dateTrans->Lookup = new Lookup('dateTrans', 'EmployeeDashboard22', true, 'dateTrans', ["dateTrans","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->dateTrans->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['dateTrans'] = &$this->dateTrans;

        // receiptNumber
        $this->receiptNumber = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
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
        $this->Fields['receiptNumber'] = &$this->receiptNumber;

        // receipt
        $this->receipt = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
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
        $this->Fields['receipt'] = &$this->receipt;

        // note
        $this->note = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
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
        $this->Fields['note'] = &$this->note;

        // submittedBy
        $this->submittedBy = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
            'x_submittedBy',
            'submittedBy',
            '`submittedBy`',
            '`submittedBy`',
            200,
            50,
            -1,
            false,
            '`submittedBy`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->submittedBy->InputTextType = "text";
        $this->submittedBy->UseFilter = true; // Table header filter
        switch ($CurrentLanguage) {
            case "en-US":
                $this->submittedBy->Lookup = new Lookup('submittedBy', 'EmployeeDashboard22', true, 'submittedBy', ["submittedBy","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->submittedBy->Lookup = new Lookup('submittedBy', 'EmployeeDashboard22', true, 'submittedBy', ["submittedBy","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Fields['submittedBy'] = &$this->submittedBy;

        // status
        $this->status = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
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
                $this->status->Lookup = new Lookup('status', 'EmployeeDashboard22', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->status->Lookup = new Lookup('status', 'EmployeeDashboard22', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->status->OptionCount = 3;
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['status'] = &$this->status;

        // dateClosed
        $this->dateClosed = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
            'x_dateClosed',
            'dateClosed',
            '`dateClosed`',
            CastDateFieldForLike("`dateClosed`", 0, "capstone1"),
            133,
            10,
            0,
            false,
            '`dateClosed`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->dateClosed->InputTextType = "text";
        $this->dateClosed->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['dateClosed'] = &$this->dateClosed;

        // float_status
        $this->float_status = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
            'x_float_status',
            'float_status',
            '`float_status`',
            '`float_status`',
            3,
            7,
            -1,
            false,
            '`float_status`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->float_status->InputTextType = "text";
        $this->float_status->Required = true; // Required field
        switch ($CurrentLanguage) {
            case "en-US":
                $this->float_status->Lookup = new Lookup('float_status', 'EmployeeDashboard22', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->float_status->Lookup = new Lookup('float_status', 'EmployeeDashboard22', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->float_status->OptionCount = 3;
        $this->float_status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['float_status'] = &$this->float_status;

        // cash_float
        $this->cash_float = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
            'x_cash_float',
            'cash_float',
            '`cash_float`',
            '`cash_float`',
            3,
            7,
            -1,
            false,
            '`cash_float`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->cash_float->InputTextType = "text";
        $this->cash_float->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['cash_float'] = &$this->cash_float;

        // validatedBy
        $this->validatedBy = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
            'x_validatedBy',
            'validatedBy',
            '`validatedBy`',
            '`validatedBy`',
            200,
            50,
            -1,
            false,
            '`validatedBy`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->validatedBy->InputTextType = "text";
        $this->Fields['validatedBy'] = &$this->validatedBy;

        // machine_id
        $this->machine_id = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
            'x_machine_id',
            'machine_id',
            '`machine_id`',
            '`machine_id`',
            3,
            7,
            -1,
            false,
            '`machine_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->machine_id->InputTextType = "text";
        $this->machine_id->Required = true; // Required field
        $this->machine_id->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->machine_id->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->machine_id->Lookup = new Lookup('machine_id', 'machine', false, 'id', ["machine_category_id","brand_id","model",""], [], [], [], [], [], [], '`id` ASC', '', "CONCAT(COALESCE(`machine_category_id`, ''),'" . ValueSeparator(1, $this->machine_id) . "',COALESCE(`brand_id`,''),'" . ValueSeparator(2, $this->machine_id) . "',COALESCE(`model`,''))");
                break;
            default:
                $this->machine_id->Lookup = new Lookup('machine_id', 'machine', false, 'id', ["machine_category_id","brand_id","model",""], [], [], [], [], [], [], '`id` ASC', '', "CONCAT(COALESCE(`machine_category_id`, ''),'" . ValueSeparator(1, $this->machine_id) . "',COALESCE(`brand_id`,''),'" . ValueSeparator(2, $this->machine_id) . "',COALESCE(`model`,''))");
                break;
        }
        $this->machine_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['machine_id'] = &$this->machine_id;

        // expCategory_id
        $this->expCategory_id = new DbField(
            'EmployeeDashboard22',
            'Employee Dashboard',
            'x_expCategory_id',
            'expCategory_id',
            '`expCategory_id`',
            '`expCategory_id`',
            3,
            7,
            -1,
            false,
            '`expCategory_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->expCategory_id->InputTextType = "text";
        $this->expCategory_id->Nullable = false; // NOT NULL field
        $this->expCategory_id->Required = true; // Required field
        $this->expCategory_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['expCategory_id'] = &$this->expCategory_id;

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
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`emp_expense`";
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
        $this->DefaultFilter = "`submittedBy` = '" . CurrentUserName() . "' AND `status` = '1'";
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
        global $Security;
        // Add User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $filter = $this->addUserIDFilter($filter, $id);
        }
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
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
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
        $success = $this->insertSql($rs)->execute();
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
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
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
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
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
        $this->cashAdvance_id->DbValue = $row['cashAdvance_id'];
        $this->amount->DbValue = $row['amount'];
        $this->dateTrans->DbValue = $row['dateTrans'];
        $this->receiptNumber->DbValue = $row['receiptNumber'];
        $this->receipt->Upload->DbValue = $row['receipt'];
        $this->note->DbValue = $row['note'];
        $this->submittedBy->DbValue = $row['submittedBy'];
        $this->status->DbValue = $row['status'];
        $this->dateClosed->DbValue = $row['dateClosed'];
        $this->float_status->DbValue = $row['float_status'];
        $this->cash_float->DbValue = $row['cash_float'];
        $this->validatedBy->DbValue = $row['validatedBy'];
        $this->machine_id->DbValue = $row['machine_id'];
        $this->expCategory_id->DbValue = $row['expCategory_id'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
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
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
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
        return $_SESSION[$name] ?? GetUrl("EmployeeDashboard22List");
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
        if ($pageName == "EmployeeDashboard22View") {
            return $Language->phrase("View");
        } elseif ($pageName == "EmployeeDashboard22Edit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "EmployeeDashboard22Add") {
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
                return "EmployeeDashboard22View";
            case Config("API_ADD_ACTION"):
                return "EmployeeDashboard22Add";
            case Config("API_EDIT_ACTION"):
                return "EmployeeDashboard22Edit";
            case Config("API_DELETE_ACTION"):
                return "EmployeeDashboard22Delete";
            case Config("API_LIST_ACTION"):
                return "EmployeeDashboard22List";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "EmployeeDashboard22List";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("EmployeeDashboard22View", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("EmployeeDashboard22View", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "EmployeeDashboard22Add?" . $this->getUrlParm($parm);
        } else {
            $url = "EmployeeDashboard22Add";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("EmployeeDashboard22Edit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("EmployeeDashboard22Add", $this->getUrlParm($parm));
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
        return $this->keyUrl("EmployeeDashboard22Delete", $this->getUrlParm());
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
        if (
            $this->CurrentAction || $this->isExport() ||
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
        $this->cashAdvance_id->setDbValue($row['cashAdvance_id']);
        $this->amount->setDbValue($row['amount']);
        $this->dateTrans->setDbValue($row['dateTrans']);
        $this->receiptNumber->setDbValue($row['receiptNumber']);
        $this->receipt->Upload->DbValue = $row['receipt'];
        $this->note->setDbValue($row['note']);
        $this->submittedBy->setDbValue($row['submittedBy']);
        $this->status->setDbValue($row['status']);
        $this->dateClosed->setDbValue($row['dateClosed']);
        $this->float_status->setDbValue($row['float_status']);
        $this->cash_float->setDbValue($row['cash_float']);
        $this->validatedBy->setDbValue($row['validatedBy']);
        $this->machine_id->setDbValue($row['machine_id']);
        $this->expCategory_id->setDbValue($row['expCategory_id']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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

        // cash_float

        // validatedBy

        // machine_id

        // expCategory_id

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

        // cash_float
        $this->cash_float->ViewValue = $this->cash_float->CurrentValue;
        $this->cash_float->ViewValue = FormatNumber($this->cash_float->ViewValue, $this->cash_float->formatPattern());
        $this->cash_float->ViewCustomAttributes = "";

        // validatedBy
        $this->validatedBy->ViewValue = $this->validatedBy->CurrentValue;
        $this->validatedBy->ViewCustomAttributes = "";

        // machine_id
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
        $this->machine_id->ViewCustomAttributes = "";

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
            $this->receipt->LinkAttrs["data-rel"] = "EmployeeDashboard22_x_receipt";
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

        // cash_float
        $this->cash_float->LinkCustomAttributes = "";
        $this->cash_float->HrefValue = "";
        $this->cash_float->TooltipValue = "";

        // validatedBy
        $this->validatedBy->LinkCustomAttributes = "";
        $this->validatedBy->HrefValue = "";
        $this->validatedBy->TooltipValue = "";

        // machine_id
        $this->machine_id->LinkCustomAttributes = "";
        $this->machine_id->HrefValue = "";
        $this->machine_id->TooltipValue = "";

        // expCategory_id
        $this->expCategory_id->LinkCustomAttributes = "";
        $this->expCategory_id->HrefValue = "";
        $this->expCategory_id->TooltipValue = "";

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
        $this->dateTrans->EditValue = FormatDateTime($this->dateTrans->CurrentValue, $this->dateTrans->formatPattern());
        $this->dateTrans->PlaceHolder = RemoveHtml($this->dateTrans->caption());

        // receiptNumber
        $this->receiptNumber->setupEditAttributes();
        $this->receiptNumber->EditCustomAttributes = "";
        if (!$this->receiptNumber->Raw) {
            $this->receiptNumber->CurrentValue = HtmlDecode($this->receiptNumber->CurrentValue);
        }
        $this->receiptNumber->EditValue = $this->receiptNumber->CurrentValue;
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

        // note
        $this->note->setupEditAttributes();
        $this->note->EditCustomAttributes = "";
        if (!$this->note->Raw) {
            $this->note->CurrentValue = HtmlDecode($this->note->CurrentValue);
        }
        $this->note->EditValue = $this->note->CurrentValue;
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

        // cash_float
        $this->cash_float->setupEditAttributes();
        $this->cash_float->EditCustomAttributes = "";
        $this->cash_float->EditValue = $this->cash_float->CurrentValue;
        $this->cash_float->EditValue = FormatNumber($this->cash_float->EditValue, $this->cash_float->formatPattern());
        $this->cash_float->ViewCustomAttributes = "";

        // validatedBy
        $this->validatedBy->setupEditAttributes();
        $this->validatedBy->EditCustomAttributes = "";
        $this->validatedBy->EditValue = $this->validatedBy->CurrentValue;
        $this->validatedBy->ViewCustomAttributes = "";

        // machine_id
        $this->machine_id->setupEditAttributes();
        $this->machine_id->EditCustomAttributes = "";
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
        $this->machine_id->ViewCustomAttributes = "";

        // expCategory_id
        $this->expCategory_id->setupEditAttributes();
        $this->expCategory_id->EditCustomAttributes = "";
        $this->expCategory_id->EditValue = $this->expCategory_id->CurrentValue;
        $this->expCategory_id->PlaceHolder = RemoveHtml($this->expCategory_id->caption());
        if (strval($this->expCategory_id->EditValue) != "" && is_numeric($this->expCategory_id->EditValue)) {
            $this->expCategory_id->EditValue = FormatNumber($this->expCategory_id->EditValue, null);
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
                    $doc->exportCaption($this->cashAdvance_id);
                    $doc->exportCaption($this->amount);
                    $doc->exportCaption($this->dateTrans);
                    $doc->exportCaption($this->receiptNumber);
                    $doc->exportCaption($this->receipt);
                    $doc->exportCaption($this->note);
                    $doc->exportCaption($this->submittedBy);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->dateClosed);
                    $doc->exportCaption($this->float_status);
                    $doc->exportCaption($this->cash_float);
                    $doc->exportCaption($this->validatedBy);
                    $doc->exportCaption($this->machine_id);
                    $doc->exportCaption($this->expCategory_id);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->cashAdvance_id);
                    $doc->exportCaption($this->amount);
                    $doc->exportCaption($this->dateTrans);
                    $doc->exportCaption($this->receiptNumber);
                    $doc->exportCaption($this->note);
                    $doc->exportCaption($this->submittedBy);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->dateClosed);
                    $doc->exportCaption($this->float_status);
                    $doc->exportCaption($this->cash_float);
                    $doc->exportCaption($this->validatedBy);
                    $doc->exportCaption($this->machine_id);
                    $doc->exportCaption($this->expCategory_id);
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
                        $doc->exportField($this->cashAdvance_id);
                        $doc->exportField($this->amount);
                        $doc->exportField($this->dateTrans);
                        $doc->exportField($this->receiptNumber);
                        $doc->exportField($this->receipt);
                        $doc->exportField($this->note);
                        $doc->exportField($this->submittedBy);
                        $doc->exportField($this->status);
                        $doc->exportField($this->dateClosed);
                        $doc->exportField($this->float_status);
                        $doc->exportField($this->cash_float);
                        $doc->exportField($this->validatedBy);
                        $doc->exportField($this->machine_id);
                        $doc->exportField($this->expCategory_id);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->cashAdvance_id);
                        $doc->exportField($this->amount);
                        $doc->exportField($this->dateTrans);
                        $doc->exportField($this->receiptNumber);
                        $doc->exportField($this->note);
                        $doc->exportField($this->submittedBy);
                        $doc->exportField($this->status);
                        $doc->exportField($this->dateClosed);
                        $doc->exportField($this->float_status);
                        $doc->exportField($this->cash_float);
                        $doc->exportField($this->validatedBy);
                        $doc->exportField($this->machine_id);
                        $doc->exportField($this->expCategory_id);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Add User ID filter
    public function addUserIDFilter($filter = "", $id = "")
    {
        global $Security;
        $filterWrk = "";
        if ($id == "")
            $id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
        if (!$this->userIDAllow($id) && !$Security->isAdmin()) {
            $filterWrk = $Security->userIdList();
            if ($filterWrk != "") {
                $filterWrk = '`submittedBy` IN (' . $filterWrk . ')';
            }
        }

        // Call User ID Filtering event
        $this->userIdFiltering($filterWrk);
        AddFilter($filter, $filterWrk);
        return $filter;
    }

    // User ID subquery
    public function getUserIDSubquery(&$fld, &$masterfld)
    {
        global $UserTable;
        $wrk = "";
        $sql = "SELECT " . $masterfld->Expression . " FROM `emp_expense`";
        $filter = $this->addUserIDFilter("");
        if ($filter != "") {
            $sql .= " WHERE " . $filter;
        }

        // List all values
        $conn = Conn($UserTable->Dbid);
        $config = $conn->getConfiguration();
        $config->setResultCacheImpl($this->Cache);
        if ($rs = $conn->executeCacheQuery($sql, [], [], $this->CacheProfile)->fetchAllNumeric()) {
            foreach ($rs as $row) {
                if ($wrk != "") {
                    $wrk .= ",";
                }
                $wrk .= QuotedValue($row[0], $masterfld->DataType, Config("USER_TABLE_DBID"));
            }
        }
        if ($wrk != "") {
            $wrk = $fld->Expression . " IN (" . $wrk . ")";
        } else { // No User ID value found
            $wrk = "0=1";
        }
        return $wrk;
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

    // Table level events

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
