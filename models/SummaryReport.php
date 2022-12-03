<?php

namespace PHPMaker2022\efga_expense_system;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for Summary Report
 */
class SummaryReport extends ReportTable
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
    public $DailyExpense;

    // Fields
    public $id;
    public $cashAdvance_id;
    public $amount;
    public $dateTrans;
    public $receipt;
    public $note;
    public $submittedBy;
    public $status;
    public $dateClosed;
    public $float_status;
    public $validatedBy;
    public $machine_id;
    public $cash_float;
    public $expCategory_id;
    public $receiptNumber;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'SummaryReport';
        $this->TableName = 'Summary Report';
        $this->TableType = 'REPORT';

        // Update Table
        $this->UpdateTable = "`emp_expense`";
        $this->ReportSourceTable = 'emp_expense'; // Report source table
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

        // id
        $this->id = new ReportField(
            'SummaryReport',
            'Summary Report',
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
        $this->id->SourceTableVar = 'emp_expense';
        $this->Fields['id'] = &$this->id;

        // cashAdvance_id
        $this->cashAdvance_id = new ReportField(
            'SummaryReport',
            'Summary Report',
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
                $this->cashAdvance_id->Lookup = new Lookup('cashAdvance_id', 'cash_advance', false, 'id', ["expCategory_id","expSubcategory_id","submittedBy",""], [], [], [], [], ["expCategory_id"], ["x_expCategory_id"], '', '', "CONCAT(COALESCE(`expCategory_id`, ''),'" . ValueSeparator(1, $this->cashAdvance_id) . "',COALESCE(`expSubcategory_id`,''),'" . ValueSeparator(2, $this->cashAdvance_id) . "',COALESCE(`submittedBy`,''))");
                break;
            default:
                $this->cashAdvance_id->Lookup = new Lookup('cashAdvance_id', 'cash_advance', false, 'id', ["expCategory_id","expSubcategory_id","submittedBy",""], [], [], [], [], ["expCategory_id"], ["x_expCategory_id"], '', '', "CONCAT(COALESCE(`expCategory_id`, ''),'" . ValueSeparator(1, $this->cashAdvance_id) . "',COALESCE(`expSubcategory_id`,''),'" . ValueSeparator(2, $this->cashAdvance_id) . "',COALESCE(`submittedBy`,''))");
                break;
        }
        $this->cashAdvance_id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->cashAdvance_id->SourceTableVar = 'emp_expense';
        $this->Fields['cashAdvance_id'] = &$this->cashAdvance_id;

        // amount
        $this->amount = new ReportField(
            'SummaryReport',
            'Summary Report',
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
        $this->amount->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->amount->SourceTableVar = 'emp_expense';
        $this->Fields['amount'] = &$this->amount;

        // dateTrans
        $this->dateTrans = new ReportField(
            'SummaryReport',
            'Summary Report',
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
        $this->dateTrans->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->dateTrans->SourceTableVar = 'emp_expense';
        $this->Fields['dateTrans'] = &$this->dateTrans;

        // receipt
        $this->receipt = new ReportField(
            'SummaryReport',
            'Summary Report',
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
        $this->receipt->Sortable = false; // Allow sort
        $this->receipt->SourceTableVar = 'emp_expense';
        $this->Fields['receipt'] = &$this->receipt;

        // note
        $this->note = new ReportField(
            'SummaryReport',
            'Summary Report',
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
        $this->note->SourceTableVar = 'emp_expense';
        $this->Fields['note'] = &$this->note;

        // submittedBy
        $this->submittedBy = new ReportField(
            'SummaryReport',
            'Summary Report',
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
        $this->submittedBy->SourceTableVar = 'emp_expense';
        $this->Fields['submittedBy'] = &$this->submittedBy;

        // status
        $this->status = new ReportField(
            'SummaryReport',
            'Summary Report',
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
        switch ($CurrentLanguage) {
            case "en-US":
                $this->status->Lookup = new Lookup('status', 'SummaryReport', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->status->Lookup = new Lookup('status', 'SummaryReport', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->status->OptionCount = 3;
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->status->SourceTableVar = 'emp_expense';
        $this->Fields['status'] = &$this->status;

        // dateClosed
        $this->dateClosed = new ReportField(
            'SummaryReport',
            'Summary Report',
            'x_dateClosed',
            'dateClosed',
            '`dateClosed`',
            CastDateFieldForLike("`dateClosed`", 0, "DB"),
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
        $this->dateClosed->SourceTableVar = 'emp_expense';
        $this->Fields['dateClosed'] = &$this->dateClosed;

        // float_status
        $this->float_status = new ReportField(
            'SummaryReport',
            'Summary Report',
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
        switch ($CurrentLanguage) {
            case "en-US":
                $this->float_status->Lookup = new Lookup('float_status', 'SummaryReport', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->float_status->Lookup = new Lookup('float_status', 'SummaryReport', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->float_status->OptionCount = 3;
        $this->float_status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->float_status->SourceTableVar = 'emp_expense';
        $this->Fields['float_status'] = &$this->float_status;

        // validatedBy
        $this->validatedBy = new ReportField(
            'SummaryReport',
            'Summary Report',
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
        $this->validatedBy->SourceTableVar = 'emp_expense';
        $this->Fields['validatedBy'] = &$this->validatedBy;

        // machine_id
        $this->machine_id = new ReportField(
            'SummaryReport',
            'Summary Report',
            'x_machine_id',
            'machine_id',
            '`machine_id`',
            '`machine_id`',
            3,
            7,
            -1,
            false,
            '`EV__machine_id`',
            true,
            true,
            false,
            'FORMATTED TEXT',
            'SELECT'
        );
        $this->machine_id->InputTextType = "text";
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
        $this->machine_id->SourceTableVar = 'emp_expense';
        $this->Fields['machine_id'] = &$this->machine_id;

        // cash_float
        $this->cash_float = new ReportField(
            'SummaryReport',
            'Summary Report',
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
        $this->cash_float->SourceTableVar = 'emp_expense';
        $this->Fields['cash_float'] = &$this->cash_float;

        // expCategory_id
        $this->expCategory_id = new ReportField(
            'SummaryReport',
            'Summary Report',
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
        $this->expCategory_id->SourceTableVar = 'emp_expense';
        $this->Fields['expCategory_id'] = &$this->expCategory_id;

        // receiptNumber
        $this->receiptNumber = new ReportField(
            'SummaryReport',
            'Summary Report',
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
        $this->receiptNumber->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->receiptNumber->SourceTableVar = 'emp_expense';
        $this->Fields['receiptNumber'] = &$this->receiptNumber;

        // Daily Expense
        $this->DailyExpense = new DbChart($this, 'DailyExpense', 'Daily Expense', 'cashAdvance_id', 'amount', 1004, '', 0, 'SUM', 600, 500);
        $this->DailyExpense->YAxisFormat = ["Number"];
        $this->DailyExpense->YFieldFormat = ["Number"];
        $this->DailyExpense->SortType = 1;
        $this->DailyExpense->SortSequence = "";
        $this->DailyExpense->SqlSelect = $this->getQueryBuilder()->select("`cashAdvance_id`", "''", "SUM(`amount`)");
        $this->DailyExpense->SqlGroupBy = "`cashAdvance_id`";
        $this->DailyExpense->SqlOrderBy = "`cashAdvance_id` ASC";
        $this->DailyExpense->SeriesDateType = "";
        $this->DailyExpense->ID = "SummaryReport_DailyExpense"; // Chart ID
        $this->DailyExpense->setParameters([
            ["type", "1004"],
            ["seriestype", "0"]
        ]); // Chart type / Chart series type
        $this->DailyExpense->setParameters([
            ["caption", $this->DailyExpense->caption()],
            ["xaxisname", $this->DailyExpense->xAxisName()]
        ]); // Chart caption / X axis name
        $this->DailyExpense->setParameter("yaxisname", $this->DailyExpense->yAxisName()); // Y axis name
        $this->DailyExpense->setParameters([
            ["shownames", "1"],
            ["showvalues", "1"],
            ["showhovercap", "1"]
        ]); // Show names / Show values / Show hover
        $this->DailyExpense->setParameter("alpha", "50"); // Chart alpha
        $this->DailyExpense->setParameter("colorpalette", "#5899DA,#E8743B,#19A979,#ED4A7B,#945ECF,#13A4B4,#525DF4,#BF399E,#6C8893,#EE6868,#2F6497"); // Chart color palette

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

    // Summary properties
    private $sqlSelectAggregate = null;
    private $sqlAggregatePrefix = "";
    private $sqlAggregateSuffix = "";
    private $sqlSelectCount = null;

    // Select Aggregate
    public function getSqlSelectAggregate()
    {
        return $this->sqlSelectAggregate ?? $this->getQueryBuilder()->select("*");
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
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        if ($chartVar == "DailyExpense") {
            $this->cashAdvance_id->CurrentValue = $chartRow[0];
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
            $chartRow[0] = is_object($this->cashAdvance_id->ViewValue) ? $this->cashAdvance_id->ViewValue->__toString() : $this->cashAdvance_id->ViewValue;
        }
        return $chartRow;
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
        if ($this->SqlSelect) {
            return $this->SqlSelect;
        }
        $select = $this->getQueryBuilder()->select("*");
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

    public function getSqlSelectList() // Select for List page
    {
        if ($this->SqlSelectList) {
            return $this->SqlSelectList;
        }
        $from = "(SELECT *, (SELECT CONCAT(COALESCE(`machine_category_id`, ''),'" . ValueSeparator(1, $this->machine_id) . "',COALESCE(`brand_id`,''),'" . ValueSeparator(2, $this->machine_id) . "',COALESCE(`model`,'')) FROM `machine` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id` = `Summary Report`.`machine_id` LIMIT 1) AS `EV__machine_id` FROM `emp_expense`)";
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
