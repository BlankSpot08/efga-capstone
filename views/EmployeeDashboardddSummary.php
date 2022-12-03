<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmployeeDashboardddSummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { EmployeeDashboarddd: currentTable } });
var currentForm, currentPageID;
var fEmployeeDashboardddsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fEmployeeDashboardddsrch = new ew.Form("fEmployeeDashboardddsrch", "summary");
    currentSearchForm = fEmployeeDashboardddsrch;
    currentPageID = ew.PAGE_ID = "summary";

    // Add fields
    var fields = currentTable.fields;
    fEmployeeDashboardddsrch.addFields([
        ["cashAdvance_id", [], fields.cashAdvance_id.isInvalid],
        ["amount", [], fields.amount.isInvalid],
        ["dateTrans", [], fields.dateTrans.isInvalid],
        ["receiptNumber", [], fields.receiptNumber.isInvalid],
        ["note", [], fields.note.isInvalid],
        ["status", [], fields.status.isInvalid],
        ["dateClosed", [], fields.dateClosed.isInvalid],
        ["float_status", [], fields.float_status.isInvalid],
        ["cash_float", [], fields.cash_float.isInvalid]
    ]);

    // Validate form
    fEmployeeDashboardddsrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm();

        // Validate fields
        if (!this.validateFields())
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fEmployeeDashboardddsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fEmployeeDashboardddsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fEmployeeDashboardddsrch.lists.dateTrans = <?= $Page->dateTrans->toClientList($Page) ?>;
    fEmployeeDashboardddsrch.lists.submittedBy = <?= $Page->submittedBy->toClientList($Page) ?>;

    // Filters
    fEmployeeDashboardddsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fEmployeeDashboardddsrch");
});
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
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
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
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fEmployeeDashboardddsrch" id="fEmployeeDashboardddsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fEmployeeDashboardddsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="EmployeeDashboarddd">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->dateTrans->Visible) { // dateTrans ?>
<?php
if (!$Page->dateTrans->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_dateTrans" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->dateTrans->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_dateTrans"
            name="x_dateTrans[]"
            class="form-control ew-select<?= $Page->dateTrans->isInvalidClass() ?>"
            data-select2-id="fEmployeeDashboardddsrch_x_dateTrans"
            data-table="EmployeeDashboarddd"
            data-field="x_dateTrans"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->dateTrans->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->dateTrans->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->dateTrans->getPlaceHolder()) ?>"
            <?= $Page->dateTrans->editAttributes() ?>>
            <?= $Page->dateTrans->selectOptionListHtml("x_dateTrans", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->dateTrans->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fEmployeeDashboardddsrch", function() {
            var options = {
                name: "x_dateTrans",
                selectId: "fEmployeeDashboardddsrch_x_dateTrans",
                ajax: { id: "x_dateTrans", form: "fEmployeeDashboardddsrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.EmployeeDashboarddd.fields.dateTrans.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
<?php
if (!$Page->submittedBy->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_submittedBy" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->submittedBy->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_submittedBy"
            name="x_submittedBy[]"
            class="form-control ew-select<?= $Page->submittedBy->isInvalidClass() ?>"
            data-select2-id="fEmployeeDashboardddsrch_x_submittedBy"
            data-table="EmployeeDashboarddd"
            data-field="x_submittedBy"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->submittedBy->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->submittedBy->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->submittedBy->getPlaceHolder()) ?>"
            <?= $Page->submittedBy->editAttributes() ?>>
            <?= $Page->submittedBy->selectOptionListHtml("x_submittedBy", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->submittedBy->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fEmployeeDashboardddsrch", function() {
            var options = {
                name: "x_submittedBy",
                selectId: "fEmployeeDashboardddsrch_x_submittedBy",
                ajax: { id: "x_submittedBy", form: "fEmployeeDashboardddsrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.EmployeeDashboarddd.fields.submittedBy.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->SearchColumnCount > 0) { ?>
   <div class="col-sm-auto mb-3">
       <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
   </div>
<?php } ?>
</div><!-- /.row -->
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
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
<div id="gmp_EmployeeDashboarddd" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="<?= $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->cashAdvance_id->Visible) { ?>
    <th data-name="cashAdvance_id" class="<?= $Page->cashAdvance_id->headerCellClass() ?>"><div class="EmployeeDashboarddd_cashAdvance_id"><?= $Page->renderFieldHeader($Page->cashAdvance_id) ?></div></th>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
    <th data-name="amount" class="<?= $Page->amount->headerCellClass() ?>"><div class="EmployeeDashboarddd_amount"><?= $Page->renderFieldHeader($Page->amount) ?></div></th>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { ?>
    <th data-name="dateTrans" class="<?= $Page->dateTrans->headerCellClass() ?>"><div class="EmployeeDashboarddd_dateTrans"><?= $Page->renderFieldHeader($Page->dateTrans) ?></div></th>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
    <th data-name="receiptNumber" class="<?= $Page->receiptNumber->headerCellClass() ?>"><div class="EmployeeDashboarddd_receiptNumber"><?= $Page->renderFieldHeader($Page->receiptNumber) ?></div></th>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
    <th data-name="note" class="<?= $Page->note->headerCellClass() ?>"><div class="EmployeeDashboarddd_note"><?= $Page->renderFieldHeader($Page->note) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { ?>
    <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div class="EmployeeDashboarddd_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { ?>
    <th data-name="dateClosed" class="<?= $Page->dateClosed->headerCellClass() ?>"><div class="EmployeeDashboarddd_dateClosed"><?= $Page->renderFieldHeader($Page->dateClosed) ?></div></th>
<?php } ?>
<?php if ($Page->float_status->Visible) { ?>
    <th data-name="float_status" class="<?= $Page->float_status->headerCellClass() ?>"><div class="EmployeeDashboarddd_float_status"><?= $Page->renderFieldHeader($Page->float_status) ?></div></th>
<?php } ?>
<?php if ($Page->cash_float->Visible) { ?>
    <th data-name="cash_float" class="<?= $Page->cash_float->headerCellClass() ?>"><div class="EmployeeDashboarddd_cash_float"><?= $Page->renderFieldHeader($Page->cash_float) ?></div></th>
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
<?php if ($Page->receiptNumber->Visible) { ?>
        <td data-field="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>>
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<?= $Page->receiptNumber->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>>
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
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
<?php if ($Page->cash_float->Visible) { ?>
        <td data-field="cash_float"<?= $Page->cash_float->cellAttributes() ?>>
<span<?= $Page->cash_float->viewAttributes() ?>>
<?= $Page->cash_float->getViewValue() ?></span>
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
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"></td>
<?php } ?>
<?php if ($Page->cashAdvance_id->Visible) { ?>
        <td data-field="cashAdvance_id"<?= $Page->cashAdvance_id->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
        <td data-field="amount"<?= $Page->amount->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><span<?= $Page->amount->viewAttributes() ?>><?= $Page->amount->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { ?>
        <td data-field="dateTrans"<?= $Page->dateTrans->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
        <td data-field="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->status->Visible) { ?>
        <td data-field="status"<?= $Page->status->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { ?>
        <td data-field="dateClosed"<?= $Page->dateClosed->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->float_status->Visible) { ?>
        <td data-field="float_status"<?= $Page->float_status->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cash_float->Visible) { ?>
        <td data-field="cash_float"<?= $Page->cash_float->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><span<?= $Page->cash_float->viewAttributes() ?>><?= $Page->cash_float->SumViewValue ?></span></span></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->cashAdvance_id->Visible) { ?>
        <td data-field="cashAdvance_id"<?= $Page->cashAdvance_id->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
        <td data-field="amount"<?= $Page->amount->cellAttributes() ?>><span class="ew-aggregate"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateColon") ?>
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { ?>
        <td data-field="dateTrans"<?= $Page->dateTrans->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
        <td data-field="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->status->Visible) { ?>
        <td data-field="status"<?= $Page->status->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { ?>
        <td data-field="dateClosed"<?= $Page->dateClosed->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->float_status->Visible) { ?>
        <td data-field="float_status"<?= $Page->float_status->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->cash_float->Visible) { ?>
        <td data-field="cash_float"<?= $Page->cash_float->cellAttributes() ?>><span class="ew-aggregate"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateColon") ?>
<span<?= $Page->cash_float->viewAttributes() ?>>
<?= $Page->cash_float->SumViewValue ?></span>
</td>
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
