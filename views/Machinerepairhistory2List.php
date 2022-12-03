<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$Machinerepairhistory2List = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { machinerepairhistory2: currentTable } });
var currentForm, currentPageID;
var fmachinerepairhistory2list;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmachinerepairhistory2list = new ew.Form("fmachinerepairhistory2list", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fmachinerepairhistory2list;
    fmachinerepairhistory2list.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Dynamic selection lists
    fmachinerepairhistory2list.lists.dateTrans = <?= $Page->dateTrans->toClientList($Page) ?>;
    fmachinerepairhistory2list.lists.machine_category = <?= $Page->machine_category->toClientList($Page) ?>;
    fmachinerepairhistory2list.lists.brand = <?= $Page->brand->toClientList($Page) ?>;
    fmachinerepairhistory2list.lists.model = <?= $Page->model->toClientList($Page) ?>;
    fmachinerepairhistory2list.lists.expSubcategory = <?= $Page->expSubcategory->toClientList($Page) ?>;
    loadjs.done("fmachinerepairhistory2list");
});
var fmachinerepairhistory2srch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fmachinerepairhistory2srch = new ew.Form("fmachinerepairhistory2srch", "list");
    currentSearchForm = fmachinerepairhistory2srch;

    // Add fields
    var fields = currentTable.fields;
    fmachinerepairhistory2srch.addFields([
        ["dateTrans", [], fields.dateTrans.isInvalid],
        ["amount", [], fields.amount.isInvalid],
        ["machine_category", [], fields.machine_category.isInvalid],
        ["brand", [], fields.brand.isInvalid],
        ["model", [], fields.model.isInvalid],
        ["note", [], fields.note.isInvalid],
        ["receiptNumber", [], fields.receiptNumber.isInvalid],
        ["receipt", [], fields.receipt.isInvalid],
        ["expSubcategory", [], fields.expSubcategory.isInvalid]
    ]);

    // Validate form
    fmachinerepairhistory2srch.validate = function () {
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
    fmachinerepairhistory2srch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmachinerepairhistory2srch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fmachinerepairhistory2srch.lists.dateTrans = <?= $Page->dateTrans->toClientList($Page) ?>;
    fmachinerepairhistory2srch.lists.machine_category = <?= $Page->machine_category->toClientList($Page) ?>;
    fmachinerepairhistory2srch.lists.brand = <?= $Page->brand->toClientList($Page) ?>;
    fmachinerepairhistory2srch.lists.model = <?= $Page->model->toClientList($Page) ?>;
    fmachinerepairhistory2srch.lists.expSubcategory = <?= $Page->expSubcategory->toClientList($Page) ?>;

    // Filters
    fmachinerepairhistory2srch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fmachinerepairhistory2srch");
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
<form name="fmachinerepairhistory2srch" id="fmachinerepairhistory2srch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fmachinerepairhistory2srch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="machinerepairhistory2">
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
            data-select2-id="fmachinerepairhistory2srch_x_dateTrans"
            data-table="machinerepairhistory2"
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
        loadjs.ready("fmachinerepairhistory2srch", function() {
            var options = {
                name: "x_dateTrans",
                selectId: "fmachinerepairhistory2srch_x_dateTrans",
                ajax: { id: "x_dateTrans", form: "fmachinerepairhistory2srch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.machinerepairhistory2.fields.dateTrans.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
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
            data-select2-id="fmachinerepairhistory2srch_x_machine_category"
            data-table="machinerepairhistory2"
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
        <div class="invalid-feedback"><?= $Page->machine_category->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fmachinerepairhistory2srch", function() {
            var options = {
                name: "x_machine_category",
                selectId: "fmachinerepairhistory2srch_x_machine_category",
                ajax: { id: "x_machine_category", form: "fmachinerepairhistory2srch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.machinerepairhistory2.fields.machine_category.filterOptions);
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
            data-select2-id="fmachinerepairhistory2srch_x_brand"
            data-table="machinerepairhistory2"
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
        <div class="invalid-feedback"><?= $Page->brand->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fmachinerepairhistory2srch", function() {
            var options = {
                name: "x_brand",
                selectId: "fmachinerepairhistory2srch_x_brand",
                ajax: { id: "x_brand", form: "fmachinerepairhistory2srch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.machinerepairhistory2.fields.brand.filterOptions);
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
            data-select2-id="fmachinerepairhistory2srch_x_model"
            data-table="machinerepairhistory2"
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
        <div class="invalid-feedback"><?= $Page->model->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fmachinerepairhistory2srch", function() {
            var options = {
                name: "x_model",
                selectId: "fmachinerepairhistory2srch_x_model",
                ajax: { id: "x_model", form: "fmachinerepairhistory2srch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.machinerepairhistory2.fields.model.filterOptions);
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
            data-select2-id="fmachinerepairhistory2srch_x_expSubcategory"
            data-table="machinerepairhistory2"
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
        loadjs.ready("fmachinerepairhistory2srch", function() {
            var options = {
                name: "x_expSubcategory",
                selectId: "fmachinerepairhistory2srch_x_expSubcategory",
                ajax: { id: "x_expSubcategory", form: "fmachinerepairhistory2srch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.machinerepairhistory2.fields.expSubcategory.filterOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fmachinerepairhistory2srch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fmachinerepairhistory2srch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fmachinerepairhistory2srch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fmachinerepairhistory2srch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> machinerepairhistory2">
<form name="fmachinerepairhistory2list" id="fmachinerepairhistory2list" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="machinerepairhistory2">
<div id="gmp_machinerepairhistory2" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_machinerepairhistory2list" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->dateTrans->Visible) { // dateTrans ?>
        <th data-name="dateTrans" class="<?= $Page->dateTrans->headerCellClass() ?>"><div id="elh_machinerepairhistory2_dateTrans" class="machinerepairhistory2_dateTrans"><?= $Page->renderFieldHeader($Page->dateTrans) ?></div></th>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <th data-name="amount" class="<?= $Page->amount->headerCellClass() ?>"><div id="elh_machinerepairhistory2_amount" class="machinerepairhistory2_amount"><?= $Page->renderFieldHeader($Page->amount) ?></div></th>
<?php } ?>
<?php if ($Page->machine_category->Visible) { // machine_category ?>
        <th data-name="machine_category" class="<?= $Page->machine_category->headerCellClass() ?>"><div id="elh_machinerepairhistory2_machine_category" class="machinerepairhistory2_machine_category"><?= $Page->renderFieldHeader($Page->machine_category) ?></div></th>
<?php } ?>
<?php if ($Page->brand->Visible) { // brand ?>
        <th data-name="brand" class="<?= $Page->brand->headerCellClass() ?>"><div id="elh_machinerepairhistory2_brand" class="machinerepairhistory2_brand"><?= $Page->renderFieldHeader($Page->brand) ?></div></th>
<?php } ?>
<?php if ($Page->model->Visible) { // model ?>
        <th data-name="model" class="<?= $Page->model->headerCellClass() ?>"><div id="elh_machinerepairhistory2_model" class="machinerepairhistory2_model"><?= $Page->renderFieldHeader($Page->model) ?></div></th>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
        <th data-name="note" class="<?= $Page->note->headerCellClass() ?>"><div id="elh_machinerepairhistory2_note" class="machinerepairhistory2_note"><?= $Page->renderFieldHeader($Page->note) ?></div></th>
<?php } ?>
<?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
        <th data-name="receiptNumber" class="<?= $Page->receiptNumber->headerCellClass() ?>"><div id="elh_machinerepairhistory2_receiptNumber" class="machinerepairhistory2_receiptNumber"><?= $Page->renderFieldHeader($Page->receiptNumber) ?></div></th>
<?php } ?>
<?php if ($Page->receipt->Visible) { // receipt ?>
        <th data-name="receipt" class="<?= $Page->receipt->headerCellClass() ?>"><div id="elh_machinerepairhistory2_receipt" class="machinerepairhistory2_receipt"><?= $Page->renderFieldHeader($Page->receipt) ?></div></th>
<?php } ?>
<?php if ($Page->expSubcategory->Visible) { // expSubcategory ?>
        <th data-name="expSubcategory" class="<?= $Page->expSubcategory->headerCellClass() ?>"><div id="elh_machinerepairhistory2_expSubcategory" class="machinerepairhistory2_expSubcategory"><?= $Page->renderFieldHeader($Page->expSubcategory) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_machinerepairhistory2",
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
    <?php if ($Page->dateTrans->Visible) { // dateTrans ?>
        <td data-name="dateTrans"<?= $Page->dateTrans->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machinerepairhistory2_dateTrans" class="el_machinerepairhistory2_dateTrans">
<span<?= $Page->dateTrans->viewAttributes() ?>>
<?= $Page->dateTrans->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amount->Visible) { // amount ?>
        <td data-name="amount"<?= $Page->amount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machinerepairhistory2_amount" class="el_machinerepairhistory2_amount">
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->machine_category->Visible) { // machine_category ?>
        <td data-name="machine_category"<?= $Page->machine_category->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machinerepairhistory2_machine_category" class="el_machinerepairhistory2_machine_category">
<span<?= $Page->machine_category->viewAttributes() ?>>
<?= $Page->machine_category->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->brand->Visible) { // brand ?>
        <td data-name="brand"<?= $Page->brand->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machinerepairhistory2_brand" class="el_machinerepairhistory2_brand">
<span<?= $Page->brand->viewAttributes() ?>>
<?= $Page->brand->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->model->Visible) { // model ?>
        <td data-name="model"<?= $Page->model->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machinerepairhistory2_model" class="el_machinerepairhistory2_model">
<span<?= $Page->model->viewAttributes() ?>>
<?= $Page->model->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->note->Visible) { // note ?>
        <td data-name="note"<?= $Page->note->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machinerepairhistory2_note" class="el_machinerepairhistory2_note">
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receiptNumber->Visible) { // receiptNumber ?>
        <td data-name="receiptNumber"<?= $Page->receiptNumber->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machinerepairhistory2_receiptNumber" class="el_machinerepairhistory2_receiptNumber">
<span<?= $Page->receiptNumber->viewAttributes() ?>>
<?= $Page->receiptNumber->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->receipt->Visible) { // receipt ?>
        <td data-name="receipt"<?= $Page->receipt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machinerepairhistory2_receipt" class="el_machinerepairhistory2_receipt">
<span>
<?= GetFileViewTag($Page->receipt, $Page->receipt->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->expSubcategory->Visible) { // expSubcategory ?>
        <td data-name="expSubcategory"<?= $Page->expSubcategory->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_machinerepairhistory2_expSubcategory" class="el_machinerepairhistory2_expSubcategory">
<span<?= $Page->expSubcategory->viewAttributes() ?>>
<?= $Page->expSubcategory->getViewValue() ?></span>
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
    ew.addEventHandlers("machinerepairhistory2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
