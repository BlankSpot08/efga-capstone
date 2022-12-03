<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$MachineRepairHistorySummary = &$Page;
?>
<?php if (!$Page->isExport() && !$Page->DrillDown && !$DashboardReport) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { MachineRepairHistory: currentTable } });
var currentForm, currentPageID;
var fMachineRepairHistorysrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fMachineRepairHistorysrch = new ew.Form("fMachineRepairHistorysrch", "summary");
    currentSearchForm = fMachineRepairHistorysrch;
    currentPageID = ew.PAGE_ID = "summary";

    // Add fields
    var fields = currentTable.fields;
    fMachineRepairHistorysrch.addFields([
        ["dateTrans", [], fields.dateTrans.isInvalid],
        ["amount", [], fields.amount.isInvalid],
        ["machine_category", [], fields.machine_category.isInvalid],
        ["brand", [], fields.brand.isInvalid],
        ["model", [], fields.model.isInvalid],
        ["note", [], fields.note.isInvalid],
        ["receiptNumber", [], fields.receiptNumber.isInvalid],
        ["expSubcategory", [], fields.expSubcategory.isInvalid]
    ]);

    // Validate form
    fMachineRepairHistorysrch.validate = function () {
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
    fMachineRepairHistorysrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fMachineRepairHistorysrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fMachineRepairHistorysrch.lists.machine_category = <?= $Page->machine_category->toClientList($Page) ?>;
    fMachineRepairHistorysrch.lists.brand = <?= $Page->brand->toClientList($Page) ?>;
    fMachineRepairHistorysrch.lists.model = <?= $Page->model->toClientList($Page) ?>;
    fMachineRepairHistorysrch.lists.expSubcategory = <?= $Page->expSubcategory->toClientList($Page) ?>;

    // Filters
    fMachineRepairHistorysrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fMachineRepairHistorysrch");
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
<form name="fMachineRepairHistorysrch" id="fMachineRepairHistorysrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fMachineRepairHistorysrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="MachineRepairHistory">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->machine_category->Visible) { // machine_category ?>
<?php
if (!$Page->machine_category->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_machine_category" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->machine_category->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_machine_category"
            name="x_machine_category[]"
            class="form-control ew-select<?= $Page->machine_category->isInvalidClass() ?>"
            data-select2-id="fMachineRepairHistorysrch_x_machine_category"
            data-table="MachineRepairHistory"
            data-field="x_machine_category"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->machine_category->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->machine_category->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->machine_category->getPlaceHolder()) ?>"
            <?= $Page->machine_category->editAttributes() ?>>
            <?= $Page->machine_category->selectOptionListHtml("x_machine_category", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->machine_category->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fMachineRepairHistorysrch", function() {
            var options = {
                name: "x_machine_category",
                selectId: "fMachineRepairHistorysrch_x_machine_category",
                ajax: { id: "x_machine_category", form: "fMachineRepairHistorysrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.MachineRepairHistory.fields.machine_category.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->brand->Visible) { // brand ?>
<?php
if (!$Page->brand->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_brand" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->brand->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_brand"
            name="x_brand[]"
            class="form-control ew-select<?= $Page->brand->isInvalidClass() ?>"
            data-select2-id="fMachineRepairHistorysrch_x_brand"
            data-table="MachineRepairHistory"
            data-field="x_brand"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->brand->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->brand->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->brand->getPlaceHolder()) ?>"
            <?= $Page->brand->editAttributes() ?>>
            <?= $Page->brand->selectOptionListHtml("x_brand", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->brand->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fMachineRepairHistorysrch", function() {
            var options = {
                name: "x_brand",
                selectId: "fMachineRepairHistorysrch_x_brand",
                ajax: { id: "x_brand", form: "fMachineRepairHistorysrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.MachineRepairHistory.fields.brand.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->model->Visible) { // model ?>
<?php
if (!$Page->model->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_model" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->model->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_model"
            name="x_model[]"
            class="form-control ew-select<?= $Page->model->isInvalidClass() ?>"
            data-select2-id="fMachineRepairHistorysrch_x_model"
            data-table="MachineRepairHistory"
            data-field="x_model"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->model->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->model->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->model->getPlaceHolder()) ?>"
            <?= $Page->model->editAttributes() ?>>
            <?= $Page->model->selectOptionListHtml("x_model", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->model->getErrorMessage() ?></div>
        <?= $Page->model->Lookup->getParamTag($Page, "p_x_model") ?>
        <script>
        loadjs.ready("fMachineRepairHistorysrch", function() {
            var options = {
                name: "x_model",
                selectId: "fMachineRepairHistorysrch_x_model",
                ajax: { id: "x_model", form: "fMachineRepairHistorysrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.MachineRepairHistory.fields.model.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { // expSubcategory ?>
<?php
if (!$Page->expSubcategory->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_expSubcategory" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->expSubcategory->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_expSubcategory"
            name="x_expSubcategory[]"
            class="form-control ew-select<?= $Page->expSubcategory->isInvalidClass() ?>"
            data-select2-id="fMachineRepairHistorysrch_x_expSubcategory"
            data-table="MachineRepairHistory"
            data-field="x_expSubcategory"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->expSubcategory->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->expSubcategory->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->expSubcategory->getPlaceHolder()) ?>"
            <?= $Page->expSubcategory->editAttributes() ?>>
            <?= $Page->expSubcategory->selectOptionListHtml("x_expSubcategory", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->expSubcategory->getErrorMessage() ?></div>
        <script>
        loadjs.ready("fMachineRepairHistorysrch", function() {
            var options = {
                name: "x_expSubcategory",
                selectId: "fMachineRepairHistorysrch_x_expSubcategory",
                ajax: { id: "x_expSubcategory", form: "fMachineRepairHistorysrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.MachineRepairHistory.fields.expSubcategory.filterOptions);
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
<div id="gmp_MachineRepairHistory" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="<?= $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
    <tr class="ew-table-header">
<?php if ($Page->expSubcategory->Visible) { ?>
    <?php if ($Page->expSubcategory->ShowGroupHeaderAsRow) { ?>
    <th data-name="expSubcategory">&nbsp;</th>
    <?php } else { ?>
    <th data-name="expSubcategory" class="<?= $Page->expSubcategory->headerCellClass() ?>"><div class="MachineRepairHistory_expSubcategory"><?= $Page->renderFieldHeader($Page->expSubcategory) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->machine_category->Visible) { ?>
    <?php if ($Page->machine_category->ShowGroupHeaderAsRow) { ?>
    <th data-name="machine_category">&nbsp;</th>
    <?php } else { ?>
    <th data-name="machine_category" class="<?= $Page->machine_category->headerCellClass() ?>"><div class="MachineRepairHistory_machine_category"><?= $Page->renderFieldHeader($Page->machine_category) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->brand->Visible) { ?>
    <?php if ($Page->brand->ShowGroupHeaderAsRow) { ?>
    <th data-name="brand">&nbsp;</th>
    <?php } else { ?>
    <th data-name="brand" class="<?= $Page->brand->headerCellClass() ?>"><div class="MachineRepairHistory_brand"><?= $Page->renderFieldHeader($Page->brand) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->model->Visible) { ?>
    <?php if ($Page->model->ShowGroupHeaderAsRow) { ?>
    <th data-name="model">&nbsp;</th>
    <?php } else { ?>
    <th data-name="model" class="<?= $Page->model->headerCellClass() ?>"><div class="MachineRepairHistory_model"><?= $Page->renderFieldHeader($Page->model) ?></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { ?>
    <th data-name="dateTrans" class="<?= $Page->dateTrans->headerCellClass() ?>"><div class="MachineRepairHistory_dateTrans"><?= $Page->renderFieldHeader($Page->dateTrans) ?></div></th>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
    <th data-name="amount" class="<?= $Page->amount->headerCellClass() ?>"><div class="MachineRepairHistory_amount"><?= $Page->renderFieldHeader($Page->amount) ?></div></th>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
    <th data-name="note" class="<?= $Page->note->headerCellClass() ?>"><div class="MachineRepairHistory_note"><?= $Page->renderFieldHeader($Page->note) ?></div></th>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
    <th data-name="receiptNumber" class="<?= $Page->receiptNumber->headerCellClass() ?>"><div class="MachineRepairHistory_receiptNumber"><?= $Page->renderFieldHeader($Page->receiptNumber) ?></div></th>
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
    $where = DetailFilterSql($Page->expSubcategory, $Page->getSqlFirstGroupField(), $Page->expSubcategory->groupValue(), $Page->Dbid);
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
    $Page->expSubcategory->Records = &$Page->DetailRecords;
    $Page->expSubcategory->LevelBreak = true; // Set field level break
        $Page->GroupCounter[1] = $Page->GroupCount;
        $Page->expSubcategory->getCnt($Page->expSubcategory->Records); // Get record count
?>
<?php if ($Page->expSubcategory->Visible && $Page->expSubcategory->ShowGroupHeaderAsRow) { ?>
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
<?php if ($Page->expSubcategory->Visible) { ?>
        <?php $Page->expSubcategory->CellAttrs->appendClass("ew-rpt-grp-caret"); ?>
        <td data-field="expSubcategory"<?= $Page->expSubcategory->cellAttributes(); ?>><i class="ew-group-toggle fas fa-caret-down"></i></td>
        <?php $Page->expSubcategory->CellAttrs->removeClass("ew-rpt-grp-caret"); ?>
<?php } ?>
        <td data-field="expSubcategory" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 1) ?>"<?= $Page->expSubcategory->cellAttributes() ?>>
            <span class="ew-summary-caption MachineRepairHistory_expSubcategory"><?= $Page->renderFieldHeader($Page->expSubcategory) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->expSubcategory->viewAttributes() ?>><?= $Page->expSubcategory->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->expSubcategory->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->machine_category->getDistinctValues($Page->expSubcategory->Records);
    $Page->setGroupCount(count($Page->machine_category->DistinctValues), $Page->GroupCounter[1]);
    $Page->GroupCounter[2] = 0; // Init group count index
    foreach ($Page->machine_category->DistinctValues as $machine_category) { // Load records for this distinct value
        $Page->machine_category->setGroupValue($machine_category); // Set group value
        $Page->machine_category->getDistinctRecords($Page->expSubcategory->Records, $Page->machine_category->groupValue());
        $Page->machine_category->LevelBreak = true; // Set field level break
        $Page->GroupCounter[2]++;
        $Page->machine_category->getCnt($Page->machine_category->Records); // Get record count
?>
<?php if ($Page->machine_category->Visible && $Page->machine_category->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->machine_category->setDbValue($machine_category); // Set current value for machine_category
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_TOTAL;
        $Page->RowTotalType = ROWTOTAL_GROUP;
        $Page->RowTotalSubType = ROWTOTAL_HEADER;
        $Page->RowGroupLevel = 2;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->expSubcategory->Visible) { ?>
        <td data-field="expSubcategory"<?= $Page->expSubcategory->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->machine_category->Visible) { ?>
        <?php $Page->machine_category->CellAttrs->appendClass("ew-rpt-grp-caret"); ?>
        <td data-field="machine_category"<?= $Page->machine_category->cellAttributes(); ?>><i class="ew-group-toggle fas fa-caret-down"></i></td>
        <?php $Page->machine_category->CellAttrs->removeClass("ew-rpt-grp-caret"); ?>
<?php } ?>
        <td data-field="machine_category" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 2) ?>"<?= $Page->machine_category->cellAttributes() ?>>
            <span class="ew-summary-caption MachineRepairHistory_machine_category"><?= $Page->renderFieldHeader($Page->machine_category) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->machine_category->viewAttributes() ?>><?= $Page->machine_category->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->machine_category->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->brand->getDistinctValues($Page->machine_category->Records);
    $Page->setGroupCount(count($Page->brand->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2]);
    $Page->GroupCounter[3] = 0; // Init group count index
    foreach ($Page->brand->DistinctValues as $brand) { // Load records for this distinct value
        $Page->brand->setGroupValue($brand); // Set group value
        $Page->brand->getDistinctRecords($Page->machine_category->Records, $Page->brand->groupValue());
        $Page->brand->LevelBreak = true; // Set field level break
        $Page->GroupCounter[3]++;
        $Page->brand->getCnt($Page->brand->Records); // Get record count
?>
<?php if ($Page->brand->Visible && $Page->brand->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->brand->setDbValue($brand); // Set current value for brand
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_TOTAL;
        $Page->RowTotalType = ROWTOTAL_GROUP;
        $Page->RowTotalSubType = ROWTOTAL_HEADER;
        $Page->RowGroupLevel = 3;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->expSubcategory->Visible) { ?>
        <td data-field="expSubcategory"<?= $Page->expSubcategory->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->machine_category->Visible) { ?>
        <td data-field="machine_category"<?= $Page->machine_category->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->brand->Visible) { ?>
        <?php $Page->brand->CellAttrs->appendClass("ew-rpt-grp-caret"); ?>
        <td data-field="brand"<?= $Page->brand->cellAttributes(); ?>><i class="ew-group-toggle fas fa-caret-down"></i></td>
        <?php $Page->brand->CellAttrs->removeClass("ew-rpt-grp-caret"); ?>
<?php } ?>
        <td data-field="brand" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 3) ?>"<?= $Page->brand->cellAttributes() ?>>
            <span class="ew-summary-caption MachineRepairHistory_brand"><?= $Page->renderFieldHeader($Page->brand) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->brand->viewAttributes() ?>><?= $Page->brand->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->brand->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
    $Page->model->getDistinctValues($Page->brand->Records);
    $Page->setGroupCount(count($Page->model->DistinctValues), $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3]);
    $Page->GroupCounter[4] = 0; // Init group count index
    foreach ($Page->model->DistinctValues as $model) { // Load records for this distinct value
        $Page->model->setGroupValue($model); // Set group value
        $Page->model->getDistinctRecords($Page->brand->Records, $Page->model->groupValue());
        $Page->model->LevelBreak = true; // Set field level break
        $Page->GroupCounter[4]++;
        $Page->model->getCnt($Page->model->Records); // Get record count
        $Page->setGroupCount($Page->model->Count, $Page->GroupCounter[1], $Page->GroupCounter[2], $Page->GroupCounter[3], $Page->GroupCounter[4]);
?>
<?php if ($Page->model->Visible && $Page->model->ShowGroupHeaderAsRow) { ?>
<?php
        // Render header row
        $Page->model->setDbValue($model); // Set current value for model
        $Page->resetAttributes();
        $Page->RowType = ROWTYPE_TOTAL;
        $Page->RowTotalType = ROWTOTAL_GROUP;
        $Page->RowTotalSubType = ROWTOTAL_HEADER;
        $Page->RowGroupLevel = 4;
        $Page->renderRow();
?>
    <tr<?= $Page->rowAttributes(); ?>>
<?php if ($Page->expSubcategory->Visible) { ?>
        <td data-field="expSubcategory"<?= $Page->expSubcategory->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->machine_category->Visible) { ?>
        <td data-field="machine_category"<?= $Page->machine_category->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->brand->Visible) { ?>
        <td data-field="brand"<?= $Page->brand->cellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->model->Visible) { ?>
        <?php $Page->model->CellAttrs->appendClass("ew-rpt-grp-caret"); ?>
        <td data-field="model"<?= $Page->model->cellAttributes(); ?>><i class="ew-group-toggle fas fa-caret-down"></i></td>
        <?php $Page->model->CellAttrs->removeClass("ew-rpt-grp-caret"); ?>
<?php } ?>
        <td data-field="model" colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount - 4) ?>"<?= $Page->model->cellAttributes() ?>>
            <span class="ew-summary-caption MachineRepairHistory_model"><?= $Page->renderFieldHeader($Page->model) ?></span><?= $Language->phrase("SummaryColon") ?><span<?= $Page->model->viewAttributes() ?>><?= $Page->model->GroupViewValue ?></span>
            <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->model->Count, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span>
        </td>
    </tr>
<?php } ?>
<?php
        $Page->RecordCount = 0; // Reset record count
        foreach ($Page->model->Records as $record) {
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
<?php if ($Page->expSubcategory->Visible) { ?>
    <?php if ($Page->expSubcategory->ShowGroupHeaderAsRow) { ?>
        <td data-field="expSubcategory"<?= $Page->expSubcategory->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="expSubcategory"<?= $Page->expSubcategory->cellAttributes() ?>><span<?= $Page->expSubcategory->viewAttributes() ?>><?= $Page->expSubcategory->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->machine_category->Visible) { ?>
    <?php if ($Page->machine_category->ShowGroupHeaderAsRow) { ?>
        <td data-field="machine_category"<?= $Page->machine_category->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="machine_category"<?= $Page->machine_category->cellAttributes() ?>><span<?= $Page->machine_category->viewAttributes() ?>><?= $Page->machine_category->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->brand->Visible) { ?>
    <?php if ($Page->brand->ShowGroupHeaderAsRow) { ?>
        <td data-field="brand"<?= $Page->brand->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="brand"<?= $Page->brand->cellAttributes() ?>><span<?= $Page->brand->viewAttributes() ?>><?= $Page->brand->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->model->Visible) { ?>
    <?php if ($Page->model->ShowGroupHeaderAsRow) { ?>
        <td data-field="model"<?= $Page->model->cellAttributes() ?>></td>
    <?php } else { ?>
        <td data-field="model"<?= $Page->model->cellAttributes() ?>><span<?= $Page->model->viewAttributes() ?>><?= $Page->model->GroupViewValue ?></span></td>
    <?php } ?>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { ?>
        <td data-field="dateTrans"<?= $Page->dateTrans->cellAttributes() ?>>
<span<?= $Page->dateTrans->viewAttributes() ?>>
<?= $Page->dateTrans->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
        <td data-field="amount"<?= $Page->amount->cellAttributes() ?>>
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>>
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
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
    }
    } // End group level 3
    } // End group level 2
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
<?php if ($Page->expSubcategory->ShowCompactSummaryFooter) { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<span class="ew-aggregate-caption"><?= $Language->phrase("RptCnt") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?></span>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"></td>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { ?>
        <td data-field="dateTrans"<?= $Page->dateTrans->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
        <td data-field="amount"<?= $Page->amount->cellAttributes() ?>><span class="ew-aggregate-caption"><?= $Language->phrase("RptSum") ?></span><?= $Language->phrase("AggregateEqual") ?><span class="ew-aggregate-value"><span<?= $Page->amount->viewAttributes() ?>><?= $Page->amount->SumViewValue ?></span></span></td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
        <td data-field="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>></td>
<?php } ?>
    </tr>
<?php } else { ?>
    <tr<?= $Page->rowAttributes() ?>><td colspan="<?= ($Page->GroupColumnCount + $Page->DetailColumnCount) ?>"><?= $Language->phrase("RptGrandSummary") ?> <span class="ew-summary-count">(<?= FormatNumber($Page->TotalCount, Config("DEFAULT_NUMBER_FORMAT")) ?><?= $Language->phrase("RptDtlRec") ?>)</span></td></tr>
    <tr<?= $Page->rowAttributes() ?>>
<?php if ($Page->GroupColumnCount > 0) { ?>
        <td colspan="<?= $Page->GroupColumnCount ?>" class="ew-rpt-grp-aggregate"><?= $Language->phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { ?>
        <td data-field="dateTrans"<?= $Page->dateTrans->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->amount->Visible) { ?>
        <td data-field="amount"<?= $Page->amount->cellAttributes() ?>>
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->SumViewValue ?></span>
</td>
<?php } ?>
<?php if ($Page->note->Visible) { ?>
        <td data-field="note"<?= $Page->note->cellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { ?>
        <td data-field="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>></td>
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
