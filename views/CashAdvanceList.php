<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$CashAdvanceList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cash_advance: currentTable } });
var currentForm, currentPageID;
var fcash_advancelist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fcash_advancelist = new ew.Form("fcash_advancelist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fcash_advancelist;
    fcash_advancelist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Dynamic selection lists
    fcash_advancelist.lists.expCategory_id = <?= $Page->expCategory_id->toClientList($Page) ?>;
    fcash_advancelist.lists.expSubcategory_id = <?= $Page->expSubcategory_id->toClientList($Page) ?>;
    fcash_advancelist.lists.submittedBy = <?= $Page->submittedBy->toClientList($Page) ?>;
    fcash_advancelist.lists.status = <?= $Page->status->toClientList($Page) ?>;
    loadjs.done("fcash_advancelist");
});
var fcash_advancesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fcash_advancesrch = new ew.Form("fcash_advancesrch", "list");
    currentSearchForm = fcash_advancesrch;

    // Add fields
    var fields = currentTable.fields;
    fcash_advancesrch.addFields([
        ["id", [], fields.id.isInvalid],
        ["expCategory_id", [], fields.expCategory_id.isInvalid],
        ["expSubcategory_id", [], fields.expSubcategory_id.isInvalid],
        ["dateReceived", [], fields.dateReceived.isInvalid],
        ["submittedBy", [], fields.submittedBy.isInvalid],
        ["note", [], fields.note.isInvalid],
        ["status", [], fields.status.isInvalid],
        ["validatedBy", [], fields.validatedBy.isInvalid]
    ]);

    // Validate form
    fcash_advancesrch.validate = function () {
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
    fcash_advancesrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcash_advancesrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fcash_advancesrch.lists.expCategory_id = <?= $Page->expCategory_id->toClientList($Page) ?>;
    fcash_advancesrch.lists.expSubcategory_id = <?= $Page->expSubcategory_id->toClientList($Page) ?>;
    fcash_advancesrch.lists.submittedBy = <?= $Page->submittedBy->toClientList($Page) ?>;

    // Filters
    fcash_advancesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fcash_advancesrch");
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
<form name="fcash_advancesrch" id="fcash_advancesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fcash_advancesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cash_advance">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
<?php
if (!$Page->expCategory_id->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_expCategory_id" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->expCategory_id->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_expCategory_id"
            name="x_expCategory_id[]"
            class="form-control ew-select<?= $Page->expCategory_id->isInvalidClass() ?>"
            data-select2-id="fcash_advancesrch_x_expCategory_id"
            data-table="cash_advance"
            data-field="x_expCategory_id"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->expCategory_id->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->expCategory_id->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->expCategory_id->getPlaceHolder()) ?>"
            <?= $Page->expCategory_id->editAttributes() ?>>
            <?= $Page->expCategory_id->selectOptionListHtml("x_expCategory_id", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->expCategory_id->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fcash_advancesrch", function() {
            var options = {
                name: "x_expCategory_id",
                selectId: "fcash_advancesrch_x_expCategory_id",
                ajax: { id: "x_expCategory_id", form: "fcash_advancesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.cash_advance.fields.expCategory_id.filterOptions);
            ew.createFilter(options);
        });
        </script>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->expSubcategory_id->Visible) { // expSubcategory_id ?>
<?php
if (!$Page->expSubcategory_id->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_expSubcategory_id" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->expSubcategory_id->UseFilter ? " ew-filter-field" : "" ?>">
        <select
            id="x_expSubcategory_id"
            name="x_expSubcategory_id[]"
            class="form-control ew-select<?= $Page->expSubcategory_id->isInvalidClass() ?>"
            data-select2-id="fcash_advancesrch_x_expSubcategory_id"
            data-table="cash_advance"
            data-field="x_expSubcategory_id"
            data-caption="<?= HtmlEncode(RemoveHtml($Page->expSubcategory_id->caption())) ?>"
            data-filter="true"
            multiple
            size="1"
            data-value-separator="<?= $Page->expSubcategory_id->displayValueSeparatorAttribute() ?>"
            data-placeholder="<?= HtmlEncode($Page->expSubcategory_id->getPlaceHolder()) ?>"
            <?= $Page->expSubcategory_id->editAttributes() ?>>
            <?= $Page->expSubcategory_id->selectOptionListHtml("x_expSubcategory_id", true) ?>
        </select>
        <div class="invalid-feedback"><?= $Page->expSubcategory_id->getErrorMessage(false) ?></div>
        <script>
        loadjs.ready("fcash_advancesrch", function() {
            var options = {
                name: "x_expSubcategory_id",
                selectId: "fcash_advancesrch_x_expSubcategory_id",
                ajax: { id: "x_expSubcategory_id", form: "fcash_advancesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.cash_advance.fields.expSubcategory_id.filterOptions);
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
            data-select2-id="fcash_advancesrch_x_submittedBy"
            data-table="cash_advance"
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
        loadjs.ready("fcash_advancesrch", function() {
            var options = {
                name: "x_submittedBy",
                selectId: "fcash_advancesrch_x_submittedBy",
                ajax: { id: "x_submittedBy", form: "fcash_advancesrch", limit: ew.FILTER_PAGE_SIZE, data: { ajax: "filter" } }
            };
            options = Object.assign({}, ew.filterOptions, options, ew.vars.tables.cash_advance.fields.submittedBy.filterOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fcash_advancesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fcash_advancesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fcash_advancesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fcash_advancesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> cash_advance">
<form name="fcash_advancelist" id="fcash_advancelist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cash_advance">
<div id="gmp_cash_advance" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_cash_advancelist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_cash_advance_id" class="cash_advance_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
        <th data-name="expCategory_id" class="<?= $Page->expCategory_id->headerCellClass() ?>"><div id="elh_cash_advance_expCategory_id" class="cash_advance_expCategory_id"><?= $Page->renderFieldHeader($Page->expCategory_id) ?></div></th>
<?php } ?>
<?php if ($Page->expSubcategory_id->Visible) { // expSubcategory_id ?>
        <th data-name="expSubcategory_id" class="<?= $Page->expSubcategory_id->headerCellClass() ?>"><div id="elh_cash_advance_expSubcategory_id" class="cash_advance_expSubcategory_id"><?= $Page->renderFieldHeader($Page->expSubcategory_id) ?></div></th>
<?php } ?>
<?php if ($Page->dateReceived->Visible) { // dateReceived ?>
        <th data-name="dateReceived" class="<?= $Page->dateReceived->headerCellClass() ?>"><div id="elh_cash_advance_dateReceived" class="cash_advance_dateReceived"><?= $Page->renderFieldHeader($Page->dateReceived) ?></div></th>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
        <th data-name="submittedBy" class="<?= $Page->submittedBy->headerCellClass() ?>"><div id="elh_cash_advance_submittedBy" class="cash_advance_submittedBy"><?= $Page->renderFieldHeader($Page->submittedBy) ?></div></th>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
        <th data-name="note" class="<?= $Page->note->headerCellClass() ?>"><div id="elh_cash_advance_note" class="cash_advance_note"><?= $Page->renderFieldHeader($Page->note) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_cash_advance_status" class="cash_advance_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
        <th data-name="validatedBy" class="<?= $Page->validatedBy->headerCellClass() ?>"><div id="elh_cash_advance_validatedBy" class="cash_advance_validatedBy"><?= $Page->renderFieldHeader($Page->validatedBy) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_cash_advance",
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
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_id" class="el_cash_advance_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
        <td data-name="expCategory_id"<?= $Page->expCategory_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_expCategory_id" class="el_cash_advance_expCategory_id">
<span<?= $Page->expCategory_id->viewAttributes() ?>>
<?= $Page->expCategory_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->expSubcategory_id->Visible) { // expSubcategory_id ?>
        <td data-name="expSubcategory_id"<?= $Page->expSubcategory_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_expSubcategory_id" class="el_cash_advance_expSubcategory_id">
<span<?= $Page->expSubcategory_id->viewAttributes() ?>>
<?= $Page->expSubcategory_id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dateReceived->Visible) { // dateReceived ?>
        <td data-name="dateReceived"<?= $Page->dateReceived->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_dateReceived" class="el_cash_advance_dateReceived">
<span<?= $Page->dateReceived->viewAttributes() ?>>
<?= $Page->dateReceived->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->submittedBy->Visible) { // submittedBy ?>
        <td data-name="submittedBy"<?= $Page->submittedBy->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_submittedBy" class="el_cash_advance_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<?= $Page->submittedBy->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->note->Visible) { // note ?>
        <td data-name="note"<?= $Page->note->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_note" class="el_cash_advance_note">
<span<?= $Page->note->viewAttributes() ?>>
<?= $Page->note->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_status" class="el_cash_advance_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->validatedBy->Visible) { // validatedBy ?>
        <td data-name="validatedBy"<?= $Page->validatedBy->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_cash_advance_validatedBy" class="el_cash_advance_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<?= $Page->validatedBy->getViewValue() ?></span>
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
    ew.addEventHandlers("cash_advance");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
