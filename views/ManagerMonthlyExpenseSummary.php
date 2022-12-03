<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$ManagerMonthlyExpenseSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { ManagerMonthlyExpense: currentTable } });
var currentForm, currentPageID;
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<a id="top"></a>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Content Container -->
<div id="ew-report" class="ew-report container-fluid">
<?php } ?>
<div class="btn-toolbar ew-toolbar">
<?php
if (!$Page->DrillDownInPanel) {
    $Page->ExportOptions->render("body");
    $Page->SearchOptions->render("body");
    $Page->FilterOptions->render("body");
}
?>
</div>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<div class="row">
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Center Container -->
<div id="ew-center" class="<?= $Page->CenterContentClass ?>">
<?php } ?>
<!-- Summary report (begin) -->
<div id="report_summary">
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<?php } ?>
<?php
while ($Page->GroupCount <= count($Page->GroupRecords) && $Page->GroupCount <= $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<?php if ($Page->GroupCount > 1) { ?>
</tbody>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
</div>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?= $Page->PageBreakContent ?>
<?php } ?>
<div class="<?php if (!$Page->isExport("word") && !$Page->isExport("excel")) { ?>card ew-card <?php } ?>ew-grid"<?= $Page->ReportTableStyle ?>>
<!-- Report grid (begin) -->
<div id="gmp_ManagerMonthlyExpense" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="<?= $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->expCategory->Visible) { ?>
    <?php if ($Page->expCategory->ShowGroupHeaderAsRow) { ?>
    <th data-name="expCategory">&nbsp;</th>
    <?php } else { ?>
    <th data-name="expCategory" class="<?= $Page->expCategory->headerCellClass() ?>"><div class="ManagerMonthlyExpense_expCategory"><?= $Page->renderFieldHeader($Page->expCategory) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->date->Visible) { ?>
    <?php if ($Page->date->ShowGroupHeaderAsRow) { ?>
    <th data-name="date">&nbsp;</th>
    <?php } else { ?>
    <th data-name="date" class="<?= $Page->date->headerCellClass() ?>"><div class="ManagerMonthlyExpense_date"><?= $Page->renderFieldHeader($Page->date) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
    <th data-name="amount" class="<?= $Page->amount->headerCellClass() ?>"><div class="ManagerMonthlyExpense_amount"><?= $Page->renderFieldHeader($Page->amount) ?></div></th>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
    <th data-name="receiptNumber" class="<?= $Page->receiptNumber->headerCellClass() ?>"><div class="ManagerMonthlyExpense_receiptNumber"><?= $Page->renderFieldHeader($Page->receiptNumber) ?></div></th>
<?php } ?>
<?php if ($Page->consumption->Visible) { ?>
    <th data-name="consumption" class="<?= $Page->consumption->headerCellClass() ?>"><div class="ManagerMonthlyExpense_consumption"><?= $Page->renderFieldHeader($Page->consumption) ?></div></th>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
    <th data-name="note" class="<?= $Page->note->headerCellClass() ?>"><div class="ManagerMonthlyExpense_note"><?= $Page->renderFieldHeader($Page->note) ?></div></th>
<?php } ?>
    </tr>
</thead>
<tbody>
<?php
        if ($Page->TotalGroups == 0) {
            break; // Show header only
        }
        $Page->ShowHeader = false;
    } // End show header
?>
<?php

    // Build detail SQL
    $where = DetailFilterSql($Page->expCategory, $Page->getSqlFirstGroupField(), $Page->expCategory->groupValue(), $Page->Dbid);
    if ($Page->PageFirstGroupFilter != "") {
        $Page->PageFirstGroupFilter .= " OR ";
    }
    $Page->PageFirstGroupFilter .= $where;
    if ($Page->Filter != "") {
        $where = "($Page->Filter) AND ($where)";
    }
    $sql = $Page->buildReportSql($Page->getSqlSelect(), $Page->getSqlFrom(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $where, $Page->Sort);
    $rs = $sql->execute();
    $Page->DetailRecords = $rs ? $rs->fetchAll() : [];
    $Page->DetailRecordCount = count($Page->DetailRecords);

    // Load detail records
    $Page->expCategory->Records = &$Page->DetailRecords;
    $Page->expCategory->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->expCategory->getCnt($Page->expCategory->Records); // Get record count
?>
<?php if ($Page->expCategory->Visible && $Page->expCategory->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_TOTAL;
        $Page->RowTotalType = ROWTOTAL_GROUP;
        $Page->RowTotalSubType = ROWTOTAL_HEADER;
        $Page->RowGroupLevel = 1;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->expCategory->Visible) { ?>
        <?php $Page->expCategory->CellAttrs->appendClass("ew-rpt-grp-caret"); ?>
        <td data-field="expCategory"<?= $Page->expCategory->cellAttributes(); ?>><i class="ew-group-toggle fas fa-caret-down"></i></td>
        <?php $Page->expCategory->CellAttrs->removeClass("ew-rpt-grp-caret"); ?>
<?php } ?>
        <td data-field="expCategory" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->expCategory->cellAttributes() ?>>
            <span class="ew-summary-caption ManagerMonthlyExpense_expCategory"><?= $Page->renderFieldHeader($Page->expCategory) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->expCategory->viewAttributes() ?>><?= $Page->expCategory->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->expCategory->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->date->getDistinctValues($Page->expCategory->Records);
    $Page->setGroupCount(count($Page->date->DistinctValues), $Page->GroupCounter[1]);
    $Page->GroupCounter[2] = 0; // Init group count index
    foreach ($Page->date->DistinctValues as $date) { // Load records for this distinct value
        $Page->date->setGroupValue($date); // Set group value
        $Page->date->getDistinctRecords($Page->expCategory->Records, $Page->date->groupValue());
        $Page->date->LevelBreak = true; // Set field level break
        $Page->GroupCounter[2]++;
        $Page->date->getCnt($Page->date->Records); // Get record count
        $Page->setGroupCount($Page->date->Count, $Page->GroupCounter[1], $Page->GroupCounter[2]);
?>
<?php if ($Page->date->Visible && $Page->date->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->date->setDbValue($date); // Set current value for date
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_TOTAL;
        $Page->RowTotalType = ROWTOTAL_GROUP;
        $Page->RowTotalSubType = ROWTOTAL_HEADER;
        $Page->RowGroupLevel = 2;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->expCategory->Visible) { ?>
        <td data-field="expCategory"<?= $Page->expCategory->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->date->Visible) { ?>
        <?php $Page->date->CellAttrs->appendClass("ew-rpt-grp-caret"); ?>
        <td data-field="date"<?= $Page->date->cellAttributes(); ?>><i class="ew-group-toggle fas fa-caret-down"></i></td>
        <?php $Page->date->CellAttrs->removeClass("ew-rpt-grp-caret"); ?>
<?php } ?>
        <td data-field="date" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 2) ?>"<?= $Page->date->cellAttributes() ?>>
            <span class="ew-summary-caption ManagerMonthlyExpense_date"><?= $Page->renderFieldHeader($Page->date) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->date->viewAttributes() ?>><?= $Page->date->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->date->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->date->Records as $record) {
            $Page->RecordCount++;
            $Page->RecordIndex++;
            $Page->loadRowValues($record);
?>
<?php
        // Render detail row
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_DETAIL;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->expCategory->Visible) { ?>
    <?php if ($Page->expCategory->ShowGroupHeaderAsRow) { ?>
        <td data-field="expCategory"<?= $Page->expCategory->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="expCategory"<?= $Page->expCategory->cellAttributes() ?>><span<?= $Page->expCategory->viewAttributes() ?>><?= $Page->expCategory->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->date->Visible) { ?>
    <?php if ($Page->date->ShowGroupHeaderAsRow) { ?>
        <td data-field="date"<?= $Page->date->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="date"<?= $Page->date->cellAttributes() ?>><span<?= $Page->date->viewAttributes() ?>><?= $Page->date->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
        <td data-field="amount"<?= $Page->amount->cellAttributes() ?>>
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
        <td data-field="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>>
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<?= $Page->receiptNumber->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->consumption->Visible) { ?>
        <td data-field="consumption"<?= $Page->consumption->cellAttributes() ?>>
<span<?= $Page->consumption->viewAttributes() ?>>
<?= $Page->consumption->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>>
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
    }
    } // End group level 1
?>
<?php

    // Next group
    $Page->loadGroupRowValues();

    // Show header if page break
    if ($Page->isExport()) {
        $Page->ShowHeader = ($Page->ExportPageBreakCount == 0) ? false : ($Page->GroupCount % $Page->ExportPageBreakCount == 0);
    }

    // Page_Breaking server event
    if ($Page->ShowHeader) {
        $Page->pageBreaking($Page->ShowHeader, $Page->PageBreakContent);
    }
    $Page->GroupCount++;
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
<?php
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_TOTAL;
    $Page->RowTotalType = ROWTOTAL_GRAND;
    $Page->RowTotalSubType = ROWTOTAL_FOOTER;
    $Page->RowAttrs["class"] = "ew-rpt-grand-summary";
    $Page->renderRow();
?>
<?php if ($Page->expCategory->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"></td>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
        <td data-field="amount"<?= $Page->amount->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><span<?= $Page->amount->viewAttributes() ?>><?= $Page->amount->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
        <td data-field="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->consumption->Visible) { ?>
        <td data-field="consumption"<?= $Page->consumption->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><span<?= $Page->consumption->viewAttributes() ?>><?= $Page->consumption->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"><?= $Language->phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
        <td data-field="amount"<?= $Page->amount->cellAttributes() ?>>
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
        <td data-field="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->consumption->Visible) { ?>
        <td data-field="consumption"<?= $Page->consumption->cellAttributes() ?>>
<span<?= $Page->consumption->viewAttributes() ?>>
<?= $Page->consumption->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } ?>
</tfoot>
</table>
</div>
<!-- /.ew-grid-middle-panel -->
<!-- Report grid (end) -->
<?php if (!$Page->isExport() && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
<!-- Bottom pager -->
<div class="card-footer ew-grid-lower-panel">
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
</div>
<?php } ?>
</div>
<!-- /.ew-grid -->
<?php } ?>
</div>
<!-- /#report-summary -->
<!-- Summary report (end) -->
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /#ew-center -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.row -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
<!-- Bottom Container -->
<div class="row">
    <div id="ew-bottom" class="<?= $Page->BottomContentClass ?>">
<?php } ?>
<?php
if (!$DashboardReport) {
    // Set up page break
    if (($Page->isExport("print") || $Page->isExport("pdf") || $Page->isExport("email") || $Page->isExport("excel") && Config("USE_PHPEXCEL") || $Page->isExport("word") && Config("USE_PHPWORD")) && $Page->ExportChartPageBreak) {
        // Page_Breaking server event
        $Page->pageBreaking($Page->ExportChartPageBreak, $Page->PageBreakContent);

        // Set up chart page break
        $Page->ManagerExpenseByCategory->PageBreakType = "before"; // Page break type
        $Page->ManagerExpenseByCategory->PageBreak = $Page->ExportChartPageBreak;
        $Page->ManagerExpenseByCategory->PageBreakContent = $Page->PageBreakContent;
    }

    // Set up chart drilldown
    $Page->ManagerExpenseByCategory->DrillDownInPanel = $Page->DrillDownInPanel;
    $Page->ManagerExpenseByCategory->render("ew-chart-bottom");
}
?>
<?php if (!$DashboardReport && !$Page->isExport("email") && !$Page->DrillDown && $Page->ManagerExpenseByCategory->hasData()) { ?>
<?php if (!$Page->isExport()) { ?>
<div class="mb-3"><a class="ew-top-link" data-ew-action="scroll-top"><?= $Language->phrase("Top") ?></a></div>
<?php } ?>
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
    </div>
</div>
<!-- /#ew-bottom -->
<?php } ?>
<?php if ((!$Page->isExport() || $Page->isExport("print")) && !$DashboardReport) { ?>
</div>
<!-- /.ew-report -->
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
