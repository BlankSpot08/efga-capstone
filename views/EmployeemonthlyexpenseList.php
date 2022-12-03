<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmployeemonthlyexpenseList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { employeemonthlyexpense: currentTable } });
var currentForm, currentPageID;
var femployeemonthlyexpenselist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    femployeemonthlyexpenselist = new ew.Form("femployeemonthlyexpenselist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = femployeemonthlyexpenselist;
    femployeemonthlyexpenselist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Dynamic selection lists
    femployeemonthlyexpenselist.lists.expSubcategory = <?= $Page->expSubcategory->toClientList($Page) ?>;
    femployeemonthlyexpenselist.lists.expCategory = <?= $Page->expCategory->toClientList($Page) ?>;
    femployeemonthlyexpenselist.lists.dateTrans = <?= $Page->dateTrans->toClientList($Page) ?>;
    femployeemonthlyexpenselist.lists.submittedBy = <?= $Page->submittedBy->toClientList($Page) ?>;
    femployeemonthlyexpenselist.lists.dateClosed = <?= $Page->dateClosed->toClientList($Page) ?>;
    femployeemonthlyexpenselist.lists.validatedBy = <?= $Page->validatedBy->toClientList($Page) ?>;
    loadjs.done("femployeemonthlyexpenselist");
});
var femployeemonthlyexpensesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    femployeemonthlyexpensesrch = new ew.Form("femployeemonthlyexpensesrch", "list");
    currentSearchForm = femployeemonthlyexpensesrch;

    // Add fields
    var fields = currentTable.fields;
    femployeemonthlyexpensesrch.addFields([
        ["expSubcategory", [], fields.expSubcategory.isInvalid],
        ["expCategory", [], fields.expCategory.isInvalid],
        ["amount", [], fields.amount.isInvalid],
        ["dateTrans", [], fields.dateTrans.isInvalid],
        ["receiptNumber", [], fields.receiptNumber.isInvalid],
        ["note", [], fields.note.isInvalid],
        ["submittedBy", [], fields.submittedBy.isInvalid],
        ["dateClosed", [], fields.dateClosed.isInvalid],
        ["validatedBy", [], fields.validatedBy.isInvalid],
        ["cash_float", [], fields.cash_float.isInvalid]
    ]);

    // Validate form
    femployeemonthlyexpensesrch.validate = function () {
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
    femployeemonthlyexpensesrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    femployeemonthlyexpensesrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    femployeemonthlyexpensesrch.lists.expSubcategory = <?= $Page->expSubcategory->toClientList($Page) ?>;
    femployeemonthlyexpensesrch.lists.expCategory = <?= $Page->expCategory->toClientList($Page) ?>;
    femployeemonthlyexpensesrch.lists.dateTrans = <?= $Page->dateTrans->toClientList($Page) ?>;
    femployeemonthlyexpensesrch.lists.submittedBy = <?= $Page->submittedBy->toClientList($Page) ?>;
    femployeemonthlyexpensesrch.lists.dateClosed = <?= $Page->dateClosed->toClientList($Page) ?>;
    femployeemonthlyexpensesrch.lists.validatedBy = <?= $Page->validatedBy->toClientList($Page) ?>;

    // Filters
    femployeemonthlyexpensesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("femployeemonthlyexpensesrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="femployeemonthlyexpensesrch" id="femployeemonthlyexpensesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="femployeemonthlyexpensesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="employeemonthlyexpense">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
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
            data-select2-id="femployeemonthlyexpensesrch_x_expSubcategory"
            data-table="employeemonthlyexpense"
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
        <div class="invalid-feedback"><?= $Page->expSubcategory->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("femployeemonthlyexpensesrch", function() {
            var options = {
                name: "x_expSubcategory",
                selectId: "femployeemonthlyexpensesrch_x_expSubcategory",
                ajax: { id: "x_expSubcategory", form: "femployeemonthlyexpensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.employeemonthlyexpense.fields.expSubcategory.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->expCategory->Visible) { // expCategory ?>
<?php
if (!$Page->expCategory->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_expCategory" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->expCategory->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_expCategory"
            name="x_expCategory[]"
            class="form-control ew-select<?= $Page->expCategory->isInvalidClass() ?>"
            data-select2-id="femployeemonthlyexpensesrch_x_expCategory"
            data-table="employeemonthlyexpense"
            data-field="x_expCategory"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->expCategory->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->expCategory->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->expCategory->getPlaceHolder()) ?>"
            <?= $Page->expCategory->editAttributes() ?>>
            <?= $Page->expCategory->selectOptionListHtml("x_expCategory", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->expCategory->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("femployeemonthlyexpensesrch", function() {
            var options = {
                name: "x_expCategory",
                selectId: "femployeemonthlyexpensesrch_x_expCategory",
                ajax: { id: "x_expCategory", form: "femployeemonthlyexpensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.employeemonthlyexpense.fields.expCategory.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
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
            data-select2-id="femployeemonthlyexpensesrch_x_dateTrans"
            data-table="employeemonthlyexpense"
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
        <div class="invalid-feedback"><?= $Page->dateTrans->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("femployeemonthlyexpensesrch", function() {
            var options = {
                name: "x_dateTrans",
                selectId: "femployeemonthlyexpensesrch_x_dateTrans",
                ajax: { id: "x_dateTrans", form: "femployeemonthlyexpensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.employeemonthlyexpense.fields.dateTrans.filterOptions);
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
            data-select2-id="femployeemonthlyexpensesrch_x_submittedBy"
            data-table="employeemonthlyexpense"
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
        <div class="invalid-feedback"><?= $Page->submittedBy->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("femployeemonthlyexpensesrch", function() {
            var options = {
                name: "x_submittedBy",
                selectId: "femployeemonthlyexpensesrch_x_submittedBy",
                ajax: { id: "x_submittedBy", form: "femployeemonthlyexpensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.employeemonthlyexpense.fields.submittedBy.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->dateClosed->Visible) { // dateClosed ?>
<?php
if (!$Page->dateClosed->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_dateClosed" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->dateClosed->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_dateClosed"
            name="x_dateClosed[]"
            class="form-control ew-select<?= $Page->dateClosed->isInvalidClass() ?>"
            data-select2-id="femployeemonthlyexpensesrch_x_dateClosed"
            data-table="employeemonthlyexpense"
            data-field="x_dateClosed"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->dateClosed->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->dateClosed->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->dateClosed->getPlaceHolder()) ?>"
            <?= $Page->dateClosed->editAttributes() ?>>
            <?= $Page->dateClosed->selectOptionListHtml("x_dateClosed", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->dateClosed->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("femployeemonthlyexpensesrch", function() {
            var options = {
                name: "x_dateClosed",
                selectId: "femployeemonthlyexpensesrch_x_dateClosed",
                ajax: { id: "x_dateClosed", form: "femployeemonthlyexpensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.employeemonthlyexpense.fields.dateClosed.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
<?php
if (!$Page->validatedBy->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_validatedBy" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->validatedBy->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_validatedBy"
            name="x_validatedBy[]"
            class="form-control ew-select<?= $Page->validatedBy->isInvalidClass() ?>"
            data-select2-id="femployeemonthlyexpensesrch_x_validatedBy"
            data-table="employeemonthlyexpense"
            data-field="x_validatedBy"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->validatedBy->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->validatedBy->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->validatedBy->getPlaceHolder()) ?>"
            <?= $Page->validatedBy->editAttributes() ?>>
            <?= $Page->validatedBy->selectOptionListHtml("x_validatedBy", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->validatedBy->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("femployeemonthlyexpensesrch", function() {
            var options = {
                name: "x_validatedBy",
                selectId: "femployeemonthlyexpensesrch_x_validatedBy",
                ajax: { id: "x_validatedBy", form: "femployeemonthlyexpensesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.employeemonthlyexpense.fields.validatedBy.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
</div><!-- /.row -->
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="femployeemonthlyexpensesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="femployeemonthlyexpensesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="femployeemonthlyexpensesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="femployeemonthlyexpensesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> employeemonthlyexpense">
<form name="femployeemonthlyexpenselist" id="femployeemonthlyexpenselist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employeemonthlyexpense">
<div id="gmp_employeemonthlyexpense" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_employeemonthlyexpenselist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->expSubcategory->Visible) { // expSubcategory ?>
        <th data-name="expSubcategory" class="<?= $Page->expSubcategory->headerCellClass() ?>"><div id="elh_employeemonthlyexpense_expSubcategory" class="employeemonthlyexpense_expSubcategory"><?= $Page->renderFieldHeader($Page->expSubcategory) ?></div></th>
<?php } ?>
<?php if ($Page->expCategory->Visible) { // expCategory ?>
        <th data-name="expCategory" class="<?= $Page->expCategory->headerCellClass() ?>"><div id="elh_employeemonthlyexpense_expCategory" class="employeemonthlyexpense_expCategory"><?= $Page->renderFieldHeader($Page->expCategory) ?></div></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th data-name="amount" class="<?= $Page->amount->headerCellClass() ?>"><div id="elh_employeemonthlyexpense_amount" class="employeemonthlyexpense_amount"><?= $Page->renderFieldHeader($Page->amount) ?></div></th>
<?php } ?>
<?php if ($Page->dateTrans->Visible) { // dateTrans ?>
        <th data-name="dateTrans" class="<?= $Page->dateTrans->headerCellClass() ?>"><div id="elh_employeemonthlyexpense_dateTrans" class="employeemonthlyexpense_dateTrans"><?= $Page->renderFieldHeader($Page->dateTrans) ?></div></th>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
        <th data-name="receiptNumber" class="<?= $Page->receiptNumber->headerCellClass() ?>"><div id="elh_employeemonthlyexpense_receiptNumber" class="employeemonthlyexpense_receiptNumber"><?= $Page->renderFieldHeader($Page->receiptNumber) ?></div></th>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
        <th data-name="note" class="<?= $Page->note->headerCellClass() ?>"><div id="elh_employeemonthlyexpense_note" class="employeemonthlyexpense_note"><?= $Page->renderFieldHeader($Page->note) ?></div></th>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
        <th data-name="submittedBy" class="<?= $Page->submittedBy->headerCellClass() ?>"><div id="elh_employeemonthlyexpense_submittedBy" class="employeemonthlyexpense_submittedBy"><?= $Page->renderFieldHeader($Page->submittedBy) ?></div></th>
<?php } ?>
<?php if ($Page->dateClosed->Visible) { // dateClosed ?>
        <th data-name="dateClosed" class="<?= $Page->dateClosed->headerCellClass() ?>"><div id="elh_employeemonthlyexpense_dateClosed" class="employeemonthlyexpense_dateClosed"><?= $Page->renderFieldHeader($Page->dateClosed) ?></div></th>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
        <th data-name="validatedBy" class="<?= $Page->validatedBy->headerCellClass() ?>"><div id="elh_employeemonthlyexpense_validatedBy" class="employeemonthlyexpense_validatedBy"><?= $Page->renderFieldHeader($Page->validatedBy) ?></div></th>
<?php } ?>
<?php if ($Page->cash_float->Visible) { // cash_float ?>
        <th data-name="cash_float" class="<?= $Page->cash_float->headerCellClass() ?>"><div id="elh_employeemonthlyexpense_cash_float" class="employeemonthlyexpense_cash_float"><?= $Page->renderFieldHeader($Page->cash_float) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif ($Page->isGridAdd() && !$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_employeemonthlyexpense",
            "data-rowtype" => $Page->RowType,
            "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Page->isAdd() && $Page->RowType == ROWTYPE_ADD || $Page->isEdit() && $Page->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Page->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->expSubcategory->Visible) { // expSubcategory ?>
        <td data-name="expSubcategory"<?= $Page->expSubcategory->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employeemonthlyexpense_expSubcategory" class="el_employeemonthlyexpense_expSubcategory">
<span<?= $Page->expSubcategory->viewAttributes() ?>>
<?= $Page->expSubcategory->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->expCategory->Visible) { // expCategory ?>
        <td data-name="expCategory"<?= $Page->expCategory->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employeemonthlyexpense_expCategory" class="el_employeemonthlyexpense_expCategory">
<span<?= $Page->expCategory->viewAttributes() ?>>
<?= $Page->expCategory->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amount->Visible) { // amount ?>
        <td data-name="amount"<?= $Page->amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employeemonthlyexpense_amount" class="el_employeemonthlyexpense_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dateTrans->Visible) { // dateTrans ?>
        <td data-name="dateTrans"<?= $Page->dateTrans->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employeemonthlyexpense_dateTrans" class="el_employeemonthlyexpense_dateTrans">
<span<?= $Page->dateTrans->viewAttributes() ?>>
<?= $Page->dateTrans->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
        <td data-name="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employeemonthlyexpense_receiptNumber" class="el_employeemonthlyexpense_receiptNumber">
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<?= $Page->receiptNumber->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->note->Visible) { // note ?>
        <td data-name="note"<?= $Page->note->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employeemonthlyexpense_note" class="el_employeemonthlyexpense_note">
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->submittedBy->Visible) { // submittedBy ?>
        <td data-name="submittedBy"<?= $Page->submittedBy->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employeemonthlyexpense_submittedBy" class="el_employeemonthlyexpense_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<?= $Page->submittedBy->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dateClosed->Visible) { // dateClosed ?>
        <td data-name="dateClosed"<?= $Page->dateClosed->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employeemonthlyexpense_dateClosed" class="el_employeemonthlyexpense_dateClosed">
<span<?= $Page->dateClosed->viewAttributes() ?>>
<?= $Page->dateClosed->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->validatedBy->Visible) { // validatedBy ?>
        <td data-name="validatedBy"<?= $Page->validatedBy->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employeemonthlyexpense_validatedBy" class="el_employeemonthlyexpense_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<?= $Page->validatedBy->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cash_float->Visible) { // cash_float ?>
        <td data-name="cash_float"<?= $Page->cash_float->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_employeemonthlyexpense_cash_float" class="el_employeemonthlyexpense_cash_float">
<span<?= $Page->cash_float->viewAttributes() ?>>
<?= $Page->cash_float->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("employeemonthlyexpense");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
