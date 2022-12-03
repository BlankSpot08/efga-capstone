<?php

namespace PHPMaker2022\efga_expense_system;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for employee
 */
class Employee extends DbTable
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
    public $employee_id;
    public $lastname;
    public $firstname;
    public $middlename;
    public $dateOfBirth;
    public $picture;
    public $address;
    public $contactNo;
    public $officeDepartment;
    public $empPosition;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'employee';
        $this->TableName = 'employee';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`employee`";
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
            'employee',
            'employee',
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

        // employee_id
        $this->employee_id = new DbField(
            'employee',
            'employee',
            'x_employee_id',
            'employee_id',
            '`employee_id`',
            '`employee_id`',
            3,
            7,
            -1,
            false,
            '`employee_id`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->employee_id->InputTextType = "text";
        $this->employee_id->Required = true; // Required field
        $this->employee_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['employee_id'] = &$this->employee_id;

        // lastname
        $this->lastname = new DbField(
            'employee',
            'employee',
            'x_lastname',
            'lastname',
            '`lastname`',
            '`lastname`',
            200,
            20,
            -1,
            false,
            '`lastname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->lastname->InputTextType = "text";
        $this->lastname->Required = true; // Required field
        $this->Fields['lastname'] = &$this->lastname;

        // firstname
        $this->firstname = new DbField(
            'employee',
            'employee',
            'x_firstname',
            'firstname',
            '`firstname`',
            '`firstname`',
            200,
            20,
            -1,
            false,
            '`firstname`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->firstname->InputTextType = "text";
        $this->firstname->Required = true; // Required field
        $this->Fields['firstname'] = &$this->firstname;

        // middlename
        $this->middlename = new DbField(
            'employee',
            'employee',
            'x_middlename',
            'middlename',
            '`middlename`',
            '`middlename`',
            200,
            20,
            -1,
            false,
            '`middlename`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->middlename->InputTextType = "text";
        $this->Fields['middlename'] = &$this->middlename;

        // dateOfBirth
        $this->dateOfBirth = new DbField(
            'employee',
            'employee',
            'x_dateOfBirth',
            'dateOfBirth',
            '`dateOfBirth`',
            CastDateFieldForLike("`dateOfBirth`", 0, "DB"),
            133,
            10,
            0,
            false,
            '`dateOfBirth`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->dateOfBirth->InputTextType = "text";
        $this->dateOfBirth->Required = true; // Required field
        $this->dateOfBirth->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['dateOfBirth'] = &$this->dateOfBirth;

        // picture
        $this->picture = new DbField(
            'employee',
            'employee',
            'x_picture',
            'picture',
            '`picture`',
            '`picture`',
            205,
            0,
            -1,
            true,
            '`picture`',
            false,
            false,
            false,
            'IMAGE',
            'FILE'
        );
        $this->picture->InputTextType = "text";
        $this->picture->Required = true; // Required field
        $this->picture->Sortable = false; // Allow sort
        $this->Fields['picture'] = &$this->picture;

        // address
        $this->address = new DbField(
            'employee',
            'employee',
            'x_address',
            'address',
            '`address`',
            '`address`',
            200,
            100,
            -1,
            false,
            '`address`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->address->InputTextType = "text";
        $this->address->Required = true; // Required field
        $this->Fields['address'] = &$this->address;

        // contactNo
        $this->contactNo = new DbField(
            'employee',
            'employee',
            'x_contactNo',
            'contactNo',
            '`contactNo`',
            '`contactNo`',
            200,
            20,
            -1,
            false,
            '`contactNo`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->contactNo->InputTextType = "text";
        $this->contactNo->Required = true; // Required field
        $this->Fields['contactNo'] = &$this->contactNo;

        // officeDepartment
        $this->officeDepartment = new DbField(
            'employee',
            'employee',
            'x_officeDepartment',
            'officeDepartment',
            '`officeDepartment`',
            '`officeDepartment`',
            3,
            7,
            -1,
            false,
            '`EV__officeDepartment`',
            true,
            true,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->officeDepartment->InputTextType = "text";
        $this->officeDepartment->Required = true; // Required field
        $this->officeDepartment->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->officeDepartment->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->officeDepartment->Lookup = new Lookup('officeDepartment', 'office_department', false, 'id', ["officeDepartment","","",""], [], ["x_empPosition"], [], [], [], [], '`id` ASC', '', "`officeDepartment`");
                break;
            default:
                $this->officeDepartment->Lookup = new Lookup('officeDepartment', 'office_department', false, 'id', ["officeDepartment","","",""], [], ["x_empPosition"], [], [], [], [], '`id` ASC', '', "`officeDepartment`");
                break;
        }
        $this->officeDepartment->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['officeDepartment'] = &$this->officeDepartment;

        // empPosition
        $this->empPosition = new DbField(
            'employee',
            'employee',
            'x_empPosition',
            'empPosition',
            '`empPosition`',
            '`empPosition`',
            3,
            7,
            -1,
            false,
            '`EV__empPosition`',
            true,
            true,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->empPosition->InputTextType = "text";
        $this->empPosition->Required = true; // Required field
        $this->empPosition->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->empPosition->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->empPosition->Lookup = new Lookup('empPosition', 'employee_position', false, 'id', ["position","","",""], ["x_officeDepartment"], [], ["officeDepartment"], ["x_officeDepartment"], [], [], '`id` ASC', '', "`position`");
                break;
            default:
                $this->empPosition->Lookup = new Lookup('empPosition', 'employee_position', false, 'id', ["position","","",""], ["x_officeDepartment"], [], ["officeDepartment"], ["x_officeDepartment"], [], [], '`id` ASC', '', "`position`");
                break;
        }
        $this->empPosition->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['empPosition'] = &$this->empPosition;

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
            $sortFieldList = ($fld->VirtualExpression != "") ? $fld->VirtualExpression : $sortField;
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortFieldList . " " . $curSort : "";
            $this->setSessionOrderByList($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Session ORDER BY for List page
    public function getSessionOrderByList()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST"));
    }

    public function setSessionOrderByList($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST")] = $v;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`employee`";
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

    public function getSqlSelectList() // Select for List page
    {
        if ($this->SqlSelectList) {
            return $this->SqlSelectList;
        }
        $from = "(SELECT *, (SELECT `officeDepartment` FROM `office_department` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `employee`.`officeDepartment` LIMIT 1) AS `EV__officeDepartment`, (SELECT `position` FROM `employee_position` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `employee`.`empPosition` LIMIT 1) AS `EV__empPosition` FROM `employee`)";
        return $from . " `TMP_TABLE`";
    }

    public function sqlSelectList() // For backward compatibility
    {
        return $this->getSqlSelectList();
    }

    public function setSqlSelectList($v)
    {
        $this->SqlSelectList = $v;
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
        if ($this->useVirtualFields()) {
            $select = "*";
            $from = $this->getSqlSelectList();
            $sort = $this->UseSessionForListSql ? $this->getSessionOrderByList() : "";
        } else {
            $select = $this->getSqlSelect();
            $from = $this->getSqlFrom();
            $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        }
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
        $sort = ($this->useVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Check if virtual fields is used in SQL
    protected function useVirtualFields()
    {
        $where = $this->UseSessionForListSql ? $this->getSessionWhere() : $this->CurrentFilter;
        $orderBy = $this->UseSessionForListSql ? $this->getSessionOrderByList() : "";
        if ($where != "") {
            $where = " " . str_replace(["(", ")"], ["", ""], $where) . " ";
        }
        if ($orderBy != "") {
            $orderBy = " " . str_replace(["(", ")"], ["", ""], $orderBy) . " ";
        }
        if (ContainsString($orderBy, " " . $this->officeDepartment->VirtualExpression . " ")) {
            return true;
        }
        if (ContainsString($orderBy, " " . $this->empPosition->VirtualExpression . " ")) {
            return true;
        }
        return false;
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
        if ($this->useVirtualFields()) {
            $sql = $this->buildSelectSql("*", $this->getSqlSelectList(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        } else {
            $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        }
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
        $this->employee_id->DbValue = $row['employee_id'];
        $this->lastname->DbValue = $row['lastname'];
        $this->firstname->DbValue = $row['firstname'];
        $this->middlename->DbValue = $row['middlename'];
        $this->dateOfBirth->DbValue = $row['dateOfBirth'];
        $this->picture->Upload->DbValue = $row['picture'];
        $this->address->DbValue = $row['address'];
        $this->contactNo->DbValue = $row['contactNo'];
        $this->officeDepartment->DbValue = $row['officeDepartment'];
        $this->empPosition->DbValue = $row['empPosition'];
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
        return $_SESSION[$name] ?? GetUrl("EmployeeList");
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
        if ($pageName == "EmployeeView") {
            return $Language->phrase("View");
        } elseif ($pageName == "EmployeeEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "EmployeeAdd") {
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
                return "EmployeeView";
            case Config("API_ADD_ACTION"):
                return "EmployeeAdd";
            case Config("API_EDIT_ACTION"):
                return "EmployeeEdit";
            case Config("API_DELETE_ACTION"):
                return "EmployeeDelete";
            case Config("API_LIST_ACTION"):
                return "EmployeeList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "EmployeeList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("EmployeeView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("EmployeeView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "EmployeeAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "EmployeeAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("EmployeeEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("EmployeeAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("EmployeeDelete", $this->getUrlParm());
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
        $this->employee_id->setDbValue($row['employee_id']);
        $this->lastname->setDbValue($row['lastname']);
        $this->firstname->setDbValue($row['firstname']);
        $this->middlename->setDbValue($row['middlename']);
        $this->dateOfBirth->setDbValue($row['dateOfBirth']);
        $this->picture->Upload->DbValue = $row['picture'];
        $this->address->setDbValue($row['address']);
        $this->contactNo->setDbValue($row['contactNo']);
        $this->officeDepartment->setDbValue($row['officeDepartment']);
        $this->empPosition->setDbValue($row['empPosition']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // employee_id

        // lastname

        // firstname

        // middlename

        // dateOfBirth

        // picture

        // address

        // contactNo

        // officeDepartment

        // empPosition

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

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // employee_id
        $this->employee_id->LinkCustomAttributes = "";
        $this->employee_id->HrefValue = "";
        $this->employee_id->TooltipValue = "";

        // lastname
        $this->lastname->LinkCustomAttributes = "";
        $this->lastname->HrefValue = "";
        $this->lastname->TooltipValue = "";

        // firstname
        $this->firstname->LinkCustomAttributes = "";
        $this->firstname->HrefValue = "";
        $this->firstname->TooltipValue = "";

        // middlename
        $this->middlename->LinkCustomAttributes = "";
        $this->middlename->HrefValue = "";
        $this->middlename->TooltipValue = "";

        // dateOfBirth
        $this->dateOfBirth->LinkCustomAttributes = "";
        $this->dateOfBirth->HrefValue = "";
        $this->dateOfBirth->TooltipValue = "";

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
        $this->picture->TooltipValue = "";
        if ($this->picture->UseColorbox) {
            if (EmptyValue($this->picture->TooltipValue)) {
                $this->picture->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->picture->LinkAttrs["data-rel"] = "employee_x_picture";
            $this->picture->LinkAttrs->appendClass("ew-lightbox");
        }

        // address
        $this->address->LinkCustomAttributes = "";
        $this->address->HrefValue = "";
        $this->address->TooltipValue = "";

        // contactNo
        $this->contactNo->LinkCustomAttributes = "";
        $this->contactNo->HrefValue = "";
        $this->contactNo->TooltipValue = "";

        // officeDepartment
        $this->officeDepartment->LinkCustomAttributes = "";
        $this->officeDepartment->HrefValue = "";
        $this->officeDepartment->TooltipValue = "";

        // empPosition
        $this->empPosition->LinkCustomAttributes = "";
        $this->empPosition->HrefValue = "";
        $this->empPosition->TooltipValue = "";

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

        // employee_id
        $this->employee_id->setupEditAttributes();
        $this->employee_id->EditCustomAttributes = "";
        $this->employee_id->EditValue = $this->employee_id->CurrentValue;
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
        $this->lastname->EditValue = $this->lastname->CurrentValue;
        $this->lastname->PlaceHolder = RemoveHtml($this->lastname->caption());

        // firstname
        $this->firstname->setupEditAttributes();
        $this->firstname->EditCustomAttributes = "";
        if (!$this->firstname->Raw) {
            $this->firstname->CurrentValue = HtmlDecode($this->firstname->CurrentValue);
        }
        $this->firstname->EditValue = $this->firstname->CurrentValue;
        $this->firstname->PlaceHolder = RemoveHtml($this->firstname->caption());

        // middlename
        $this->middlename->setupEditAttributes();
        $this->middlename->EditCustomAttributes = "";
        if (!$this->middlename->Raw) {
            $this->middlename->CurrentValue = HtmlDecode($this->middlename->CurrentValue);
        }
        $this->middlename->EditValue = $this->middlename->CurrentValue;
        $this->middlename->PlaceHolder = RemoveHtml($this->middlename->caption());

        // dateOfBirth
        $this->dateOfBirth->setupEditAttributes();
        $this->dateOfBirth->EditCustomAttributes = "";
        $this->dateOfBirth->EditValue = FormatDateTime($this->dateOfBirth->CurrentValue, $this->dateOfBirth->formatPattern());
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

        // address
        $this->address->setupEditAttributes();
        $this->address->EditCustomAttributes = "";
        $this->address->EditValue = $this->address->CurrentValue;
        $this->address->PlaceHolder = RemoveHtml($this->address->caption());

        // contactNo
        $this->contactNo->setupEditAttributes();
        $this->contactNo->EditCustomAttributes = "";
        if (!$this->contactNo->Raw) {
            $this->contactNo->CurrentValue = HtmlDecode($this->contactNo->CurrentValue);
        }
        $this->contactNo->EditValue = $this->contactNo->CurrentValue;
        $this->contactNo->PlaceHolder = RemoveHtml($this->contactNo->caption());

        // officeDepartment
        $this->officeDepartment->setupEditAttributes();
        $this->officeDepartment->EditCustomAttributes = "";
        $this->officeDepartment->PlaceHolder = RemoveHtml($this->officeDepartment->caption());

        // empPosition
        $this->empPosition->setupEditAttributes();
        $this->empPosition->EditCustomAttributes = "";
        $this->empPosition->PlaceHolder = RemoveHtml($this->empPosition->caption());

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
                    $doc->exportCaption($this->employee_id);
                    $doc->exportCaption($this->lastname);
                    $doc->exportCaption($this->firstname);
                    $doc->exportCaption($this->middlename);
                    $doc->exportCaption($this->dateOfBirth);
                    $doc->exportCaption($this->picture);
                    $doc->exportCaption($this->address);
                    $doc->exportCaption($this->contactNo);
                    $doc->exportCaption($this->officeDepartment);
                    $doc->exportCaption($this->empPosition);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->employee_id);
                    $doc->exportCaption($this->lastname);
                    $doc->exportCaption($this->firstname);
                    $doc->exportCaption($this->middlename);
                    $doc->exportCaption($this->dateOfBirth);
                    $doc->exportCaption($this->address);
                    $doc->exportCaption($this->contactNo);
                    $doc->exportCaption($this->officeDepartment);
                    $doc->exportCaption($this->empPosition);
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
                        $doc->exportField($this->employee_id);
                        $doc->exportField($this->lastname);
                        $doc->exportField($this->firstname);
                        $doc->exportField($this->middlename);
                        $doc->exportField($this->dateOfBirth);
                        $doc->exportField($this->picture);
                        $doc->exportField($this->address);
                        $doc->exportField($this->contactNo);
                        $doc->exportField($this->officeDepartment);
                        $doc->exportField($this->empPosition);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->employee_id);
                        $doc->exportField($this->lastname);
                        $doc->exportField($this->firstname);
                        $doc->exportField($this->middlename);
                        $doc->exportField($this->dateOfBirth);
                        $doc->exportField($this->address);
                        $doc->exportField($this->contactNo);
                        $doc->exportField($this->officeDepartment);
                        $doc->exportField($this->empPosition);
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
        if ($fldparm == 'picture') {
            $fldName = "picture";
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
