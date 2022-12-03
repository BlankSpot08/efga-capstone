<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$SummaryReportSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { SummaryReport: currentTable } });
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
while ($Page->RecordCount < count($Page->DetailRecords) && $Page->RecordCount < $Page->DisplayGroups) {
?>
<?php
    // Show header
    if ($Page->ShowHeader) {
?>
<div class="<?php if (!$Page->isExport("word") && !$Page->isExport("excel")) { ?>card ew-card <?php } ?>ew-grid"<?= $Page->ReportTableStyle ?>>
<!-- Report grid (begin) -->
<div id="gmp_SummaryReport" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="<?= $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { ?>
    <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div class="SummaryReport_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->cashAdvance_id->Visible) { ?>
    <th data-name="cashAdvance_id" class="<?= $Page->cashAdvance_id->headerCellClass() ?>"><div class="SummaryReport_cashAdvance_id"><?= $Page->renderFieldHeader($Page->cashAdvance_id) ?></div></th>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
    <th data-name="amount" class="<?= $Page->amount->headerCellClass() ?>"><div class="SummaryReport_amount"><?= $Page->renderFieldHeader($Page->amount) ?></div></th>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { ?>
    <th data-name="dateTrans" class="<?= $Page->dateTrans->headerCellClass() ?>"><div class="SummaryReport_dateTrans"><?= $Page->renderFieldHeader($Page->dateTrans) ?></div></th>
<?php } ?>
<?php if ($Page->receipt->Visible) { ?>
    <th data-name="receipt" class="<?= $Page->receipt->headerCellClass() ?>"><div class="SummaryReport_receipt"><?= $Page->renderFieldHeader($Page->receipt) ?></div></th>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
    <th data-name="note" class="<?= $Page->note->headerCellClass() ?>"><div class="SummaryReport_note"><?= $Page->renderFieldHeader($Page->note) ?></div></th>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { ?>
    <th data-name="submittedBy" class="<?= $Page->submittedBy->headerCellClass() ?>"><div class="SummaryReport_submittedBy"><?= $Page->renderFieldHeader($Page->submittedBy) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { ?>
    <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div class="SummaryReport_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { ?>
    <th data-name="dateClosed" class="<?= $Page->dateClosed->headerCellClass() ?>"><div class="SummaryReport_dateClosed"><?= $Page->renderFieldHeader($Page->dateClosed) ?></div></th>
<?php } ?>
<?php if ($Page->float_status->Visible) { ?>
    <th data-name="float_status" class="<?= $Page->float_status->headerCellClass() ?>"><div class="SummaryReport_float_status"><?= $Page->renderFieldHeader($Page->float_status) ?></div></th>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { ?>
    <th data-name="validatedBy" class="<?= $Page->validatedBy->headerCellClass() ?>"><div class="SummaryReport_validatedBy"><?= $Page->renderFieldHeader($Page->validatedBy) ?></div></th>
<?php } ?>
<?php if ($Page->machine_id->Visible) { ?>
    <th data-name="machine_id" class="<?= $Page->machine_id->headerCellClass() ?>"><div class="SummaryReport_machine_id"><?= $Page->renderFieldHeader($Page->machine_id) ?></div></th>
<?php } ?>
<?php if ($Page->cash_float->Visible) { ?>
    <th data-name="cash_float" class="<?= $Page->cash_float->headerCellClass() ?>"><div class="SummaryReport_cash_float"><?= $Page->renderFieldHeader($Page->cash_float) ?></div></th>
<?php } ?>
<?php if ($Page->expCategory_id->Visible) { ?>
    <th data-name="expCategory_id" class="<?= $Page->expCategory_id->headerCellClass() ?>"><div class="SummaryReport_expCategory_id"><?= $Page->renderFieldHeader($Page->expCategory_id) ?></div></th>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
    <th data-name="receiptNumber" class="<?= $Page->receiptNumber->headerCellClass() ?>"><div class="SummaryReport_receiptNumber"><?= $Page->renderFieldHeader($Page->receiptNumber) ?></div></th>
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
    $Page->loadRowValues($Page->DetailRecords[$Page->RecordCount]);
    $Page->RecordCount++;
    $Page->RecordIndex++;
?>
<?php
        // Render detail row
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_DETAIL;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->id->Visible) { ?>
        <td data-field="id"<?= $Page->id->cellAttributes() ?>>
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cashAdvance_id->Visible) { ?>
        <td data-field="cashAdvance_id"<?= $Page->cashAdvance_id->cellAttributes() ?>>
<span<?= $Page->cashAdvance_id->viewAttributes() ?>>
<?= $Page->cashAdvance_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
        <td data-field="amount"<?= $Page->amount->cellAttributes() ?>>
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { ?>
        <td data-field="dateTrans"<?= $Page->dateTrans->cellAttributes() ?>>
<span<?= $Page->dateTrans->viewAttributes() ?>>
<?= $Page->dateTrans->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->receipt->Visible) { ?>
        <td data-field="receipt"<?= $Page->receipt->cellAttributes() ?>>
<span>
<?= GetFileViewTag($Page->receipt, $Page->receipt->getViewValue(), false) ?>
</span>
</td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>>
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { ?>
        <td data-field="submittedBy"<?= $Page->submittedBy->cellAttributes() ?>>
<span<?= $Page->submittedBy->viewAttributes() ?>>
<?= $Page->submittedBy->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { ?>
        <td data-field="status"<?= $Page->status->cellAttributes() ?>>
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { ?>
        <td data-field="dateClosed"<?= $Page->dateClosed->cellAttributes() ?>>
<span<?= $Page->dateClosed->viewAttributes() ?>>
<?= $Page->dateClosed->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->float_status->Visible) { ?>
        <td data-field="float_status"<?= $Page->float_status->cellAttributes() ?>>
<span<?= $Page->float_status->viewAttributes() ?>>
<?= $Page->float_status->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { ?>
        <td data-field="validatedBy"<?= $Page->validatedBy->cellAttributes() ?>>
<span<?= $Page->validatedBy->viewAttributes() ?>>
<?= $Page->validatedBy->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->machine_id->Visible) { ?>
        <td data-field="machine_id"<?= $Page->machine_id->cellAttributes() ?>>
<span<?= $Page->machine_id->viewAttributes() ?>>
<?= $Page->machine_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cash_float->Visible) { ?>
        <td data-field="cash_float"<?= $Page->cash_float->cellAttributes() ?>>
<span<?= $Page->cash_float->viewAttributes() ?>>
<?= $Page->cash_float->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->expCategory_id->Visible) { ?>
        <td data-field="expCategory_id"<?= $Page->expCategory_id->cellAttributes() ?>>
<span<?= $Page->expCategory_id->viewAttributes() ?>>
<?= $Page->expCategory_id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
        <td data-field="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>>
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<?= $Page->receiptNumber->getViewValue() ?></span>
</td>
<?php } ?>
    </tr>
<?php
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
<?php if ($Page->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
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
        $Page->DailyExpense->PageBreakType = "before"; // Page break type
        $Page->DailyExpense->PageBreak = $Page->ExportChartPageBreak;
        $Page->DailyExpense->PageBreakContent = $Page->PageBreakContent;
    }

    // Set up chart drilldown
    $Page->DailyExpense->DrillDownInPanel = $Page->DrillDownInPanel;
    $Page->DailyExpense->render("ew-chart-bottom");
}
?>
<?php if (!$DashboardReport && !$Page->isExport("email") && !$Page->DrillDown && $Page->DailyExpense->hasData()) { ?>
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
