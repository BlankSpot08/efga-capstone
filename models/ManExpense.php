<?php

namespace PHPMaker2022\efga_expense_system;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for man_expense
 */
class ManExpense extends DbTable
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
    public $expCategory;
    public $expSubcategory;
    public $amount;
    public $receipt;
    public $receiptNumber;
    public $date;
    public $dateFrom;
    public $dateTo;
    public $consumption;
    public $note;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'man_expense';
        $this->TableName = 'man_expense';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`man_expense`";
        $this->Dbid = 'DB';
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
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField(
            'man_expense',
            'man_expense',
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

        // expCategory
        $this->expCategory = new DbField(
            'man_expense',
            'man_expense',
            'x_expCategory',
            'expCategory',
            '`expCategory`',
            '`expCategory`',
            3,
            7,
            -1,
            false,
            '`expCategory`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->expCategory->InputTextType = "text";
        $this->expCategory->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->expCategory->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->expCategory->UseFilter = true; // Table header filter
        switch ($CurrentLanguage) {
            case "en-US":
                $this->expCategory->Lookup = new Lookup('expCategory', 'man_expense_category', true, 'id', ["expCategory","","",""], [], ["x_expSubcategory"], [], [], [], [], '', '', "`expCategory`");
                break;
            default:
                $this->expCategory->Lookup = new Lookup('expCategory', 'man_expense_category', true, 'id', ["expCategory","","",""], [], ["x_expSubcategory"], [], [], [], [], '', '', "`expCategory`");
                break;
        }
        $this->expCategory->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['expCategory'] = &$this->expCategory;

        // expSubcategory
        $this->expSubcategory = new DbField(
            'man_expense',
            'man_expense',
            'x_expSubcategory',
            'expSubcategory',
            '`expSubcategory`',
            '`expSubcategory`',
            3,
            7,
            -1,
            false,
            '`expSubcategory`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->expSubcategory->InputTextType = "text";
        $this->expSubcategory->Required = true; // Required field
        $this->expSubcategory->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->expSubcategory->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->expSubcategory->UseFilter = true; // Table header filter
        switch ($CurrentLanguage) {
            case "en-US":
                $this->expSubcategory->Lookup = new Lookup('expSubcategory', 'man_expense_subcategory', true, 'id', ["expSubcategory","","",""], ["x_expCategory"], [], ["expCategory"], ["x_expCategory"], [], [], '', '', "`expSubcategory`");
                break;
            default:
                $this->expSubcategory->Lookup = new Lookup('expSubcategory', 'man_expense_subcategory', true, 'id', ["expSubcategory","","",""], ["x_expCategory"], [], ["expCategory"], ["x_expCategory"], [], [], '', '', "`expSubcategory`");
                break;
        }
        $this->expSubcategory->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['expSubcategory'] = &$this->expSubcategory;

        // amount
        $this->amount = new DbField(
            'man_expense',
            'man_expense',
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

        // receipt
        $this->receipt = new DbField(
            'man_expense',
            'man_expense',
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

        // receiptNumber
        $this->receiptNumber = new DbField(
            'man_expense',
            'man_expense',
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
        $this->receiptNumber->Nullable = false; // NOT NULL field
        $this->receiptNumber->Required = true; // Required field
        $this->Fields['receiptNumber'] = &$this->receiptNumber;

        // date
        $this->date = new DbField(
            'man_expense',
            'man_expense',
            'x_date',
            'date',
            '`date`',
            CastDateFieldForLike("`date`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`date`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->date->InputTextType = "text";
        $this->date->Required = true; // Required field
        $this->date->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['date'] = &$this->date;

        // dateFrom
        $this->dateFrom = new DbField(
            'man_expense',
            'man_expense',
            'x_dateFrom',
            'dateFrom',
            '`dateFrom`',
            CastDateFieldForLike("`dateFrom`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`dateFrom`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->dateFrom->InputTextType = "text";
        $this->dateFrom->Required = true; // Required field
        $this->dateFrom->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['dateFrom'] = &$this->dateFrom;

        // dateTo
        $this->dateTo = new DbField(
            'man_expense',
            'man_expense',
            'x_dateTo',
            'dateTo',
            '`dateTo`',
            CastDateFieldForLike("`dateTo`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`dateTo`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->dateTo->InputTextType = "text";
        $this->dateTo->Required = true; // Required field
        $this->dateTo->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['dateTo'] = &$this->dateTo;

        // consumption
        $this->consumption = new DbField(
            'man_expense',
            'man_expense',
            'x_consumption',
            'consumption',
            '`consumption`',
            '`consumption`',
            3,
            11,
            -1,
            false,
            '`consumption`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->consumption->InputTextType = "text";
        $this->consumption->Required = true; // Required field
        $this->consumption->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['consumption'] = &$this->consumption;

        // note
        $this->note = new DbField(
            'man_expense',
            'man_expense',
            'x_note',
            'note',
            '`note`',
            '`note`',
            200,
            50,
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`man_expense`";
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
        $this->expCategory->DbValue = $row['expCategory'];
        $this->expSubcategory->DbValue = $row['expSubcategory'];
        $this->amount->DbValue = $row['amount'];
        $this->receipt->Upload->DbValue = $row['receipt'];
        $this->receiptNumber->DbValue = $row['receiptNumber'];
        $this->date->DbValue = $row['date'];
        $this->dateFrom->DbValue = $row['dateFrom'];
        $this->dateTo->DbValue = $row['dateTo'];
        $this->consumption->DbValue = $row['consumption'];
        $this->note->DbValue = $row['note'];
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
        return $_SESSION[$name] ?? GetUrl("ManExpenseList");
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
        if ($pageName == "ManExpenseView") {
            return $Language->phrase("View");
        } elseif ($pageName == "ManExpenseEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "ManExpenseAdd") {
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
                return "ManExpenseView";
            case Config("API_ADD_ACTION"):
                return "ManExpenseAdd";
            case Config("API_EDIT_ACTION"):
                return "ManExpenseEdit";
            case Config("API_DELETE_ACTION"):
                return "ManExpenseDelete";
            case Config("API_LIST_ACTION"):
                return "ManExpenseList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "ManExpenseList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("ManExpenseView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("ManExpenseView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "ManExpenseAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "ManExpenseAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("ManExpenseEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("ManExpenseAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("ManExpenseDelete", $this->getUrlParm());
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
        $this->expCategory->setDbValue($row['expCategory']);
        $this->expSubcategory->setDbValue($row['expSubcategory']);
        $this->amount->setDbValue($row['amount']);
        $this->receipt->Upload->DbValue = $row['receipt'];
        $this->receiptNumber->setDbValue($row['receiptNumber']);
        $this->date->setDbValue($row['date']);
        $this->dateFrom->setDbValue($row['dateFrom']);
        $this->dateTo->setDbValue($row['dateTo']);
        $this->consumption->setDbValue($row['consumption']);
        $this->note->setDbValue($row['note']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // expCategory

        // expSubcategory

        // amount

        // receipt

        // receiptNumber

        // date

        // dateFrom

        // dateTo

        // consumption

        // note

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

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // expCategory
        $this->expCategory->LinkCustomAttributes = "";
        $this->expCategory->HrefValue = "";
        $this->expCategory->TooltipValue = "";

        // expSubcategory
        $this->expSubcategory->LinkCustomAttributes = "";
        $this->expSubcategory->HrefValue = "";
        $this->expSubcategory->TooltipValue = "";

        // amount
        $this->amount->LinkCustomAttributes = "";
        $this->amount->HrefValue = "";
        $this->amount->TooltipValue = "";

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
            $this->receipt->LinkAttrs["data-rel"] = "man_expense_x_receipt";
            $this->receipt->LinkAttrs->appendClass("ew-lightbox");
        }

        // receiptNumber
        $this->receiptNumber->LinkCustomAttributes = "";
        $this->receiptNumber->HrefValue = "";
        $this->receiptNumber->TooltipValue = "";

        // date
        $this->date->LinkCustomAttributes = "";
        $this->date->HrefValue = "";
        $this->date->TooltipValue = "";

        // dateFrom
        $this->dateFrom->LinkCustomAttributes = "";
        $this->dateFrom->HrefValue = "";
        $this->dateFrom->TooltipValue = "";

        // dateTo
        $this->dateTo->LinkCustomAttributes = "";
        $this->dateTo->HrefValue = "";
        $this->dateTo->TooltipValue = "";

        // consumption
        $this->consumption->LinkCustomAttributes = "";
        $this->consumption->HrefValue = "";
        $this->consumption->TooltipValue = "";

        // note
        $this->note->LinkCustomAttributes = "";
        $this->note->HrefValue = "";
        $this->note->TooltipValue = "";

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
            $filterWrk = "";
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
            $filterWrk = "";
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
        $this->amount->EditValue = $this->amount->CurrentValue;
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

        // receiptNumber
        $this->receiptNumber->setupEditAttributes();
        $this->receiptNumber->EditCustomAttributes = "";
        if (!$this->receiptNumber->Raw) {
            $this->receiptNumber->CurrentValue = HtmlDecode($this->receiptNumber->CurrentValue);
        }
        $this->receiptNumber->EditValue = $this->receiptNumber->CurrentValue;
        $this->receiptNumber->PlaceHolder = RemoveHtml($this->receiptNumber->caption());

        // date
        $this->date->setupEditAttributes();
        $this->date->EditCustomAttributes = "";
        $this->date->EditValue = FormatDateTime($this->date->CurrentValue, $this->date->formatPattern());
        $this->date->PlaceHolder = RemoveHtml($this->date->caption());

        // dateFrom
        $this->dateFrom->setupEditAttributes();
        $this->dateFrom->EditCustomAttributes = "";
        $this->dateFrom->EditValue = FormatDateTime($this->dateFrom->CurrentValue, $this->dateFrom->formatPattern());
        $this->dateFrom->PlaceHolder = RemoveHtml($this->dateFrom->caption());

        // dateTo
        $this->dateTo->setupEditAttributes();
        $this->dateTo->EditCustomAttributes = "";
        $this->dateTo->EditValue = FormatDateTime($this->dateTo->CurrentValue, $this->dateTo->formatPattern());
        $this->dateTo->PlaceHolder = RemoveHtml($this->dateTo->caption());

        // consumption
        $this->consumption->setupEditAttributes();
        $this->consumption->EditCustomAttributes = "";
        $this->consumption->EditValue = $this->consumption->CurrentValue;
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
        $this->note->EditValue = $this->note->CurrentValue;
        $this->note->PlaceHolder = RemoveHtml($this->note->caption());

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
                    $doc->exportCaption($this->expCategory);
                    $doc->exportCaption($this->expSubcategory);
                    $doc->exportCaption($this->amount);
                    $doc->exportCaption($this->receipt);
                    $doc->exportCaption($this->receiptNumber);
                    $doc->exportCaption($this->date);
                    $doc->exportCaption($this->dateFrom);
                    $doc->exportCaption($this->dateTo);
                    $doc->exportCaption($this->consumption);
                    $doc->exportCaption($this->note);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->expCategory);
                    $doc->exportCaption($this->expSubcategory);
                    $doc->exportCaption($this->amount);
                    $doc->exportCaption($this->receiptNumber);
                    $doc->exportCaption($this->date);
                    $doc->exportCaption($this->dateFrom);
                    $doc->exportCaption($this->dateTo);
                    $doc->exportCaption($this->consumption);
                    $doc->exportCaption($this->note);
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
                        $doc->exportField($this->expCategory);
                        $doc->exportField($this->expSubcategory);
                        $doc->exportField($this->amount);
                        $doc->exportField($this->receipt);
                        $doc->exportField($this->receiptNumber);
                        $doc->exportField($this->date);
                        $doc->exportField($this->dateFrom);
                        $doc->exportField($this->dateTo);
                        $doc->exportField($this->consumption);
                        $doc->exportField($this->note);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->expCategory);
                        $doc->exportField($this->expSubcategory);
                        $doc->exportField($this->amount);
                        $doc->exportField($this->receiptNumber);
                        $doc->exportField($this->date);
                        $doc->exportField($this->dateFrom);
                        $doc->exportField($this->dateTo);
                        $doc->exportField($this->consumption);
                        $doc->exportField($this->note);
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
        settingDateManExp($rsnew['dateFrom'], $rsnew['expCategory'], $rsnew['id']);
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
