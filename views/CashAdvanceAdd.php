<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$CashAdvanceAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cash_advance: currentTable } });
var currentForm, currentPageID;
var fcash_advanceadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fcash_advanceadd = new ew.Form("fcash_advanceadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fcash_advanceadd;

    // Add fields
    var fields = currentTable.fields;
    fcash_advanceadd.addFields([
        ["expCategory_id", [fields.expCategory_id.visible && fields.expCategory_id.required ? ew.Validators.required(fields.expCategory_id.caption) : null], fields.expCategory_id.isInvalid],
        ["expSubcategory_id", [fields.expSubcategory_id.visible && fields.expSubcategory_id.required ? ew.Validators.required(fields.expSubcategory_id.caption) : null], fields.expSubcategory_id.isInvalid],
        ["budget_id", [fields.budget_id.visible && fields.budget_id.required ? ew.Validators.required(fields.budget_id.caption) : null], fields.budget_id.isInvalid],
        ["machine_id", [fields.machine_id.visible && fields.machine_id.required ? ew.Validators.required(fields.machine_id.caption) : null], fields.machine_id.isInvalid],
        ["note", [fields.note.visible && fields.note.required ? ew.Validators.required(fields.note.caption) : null], fields.note.isInvalid]
    ]);

    // Form_CustomValidate
    fcash_advanceadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcash_advanceadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fcash_advanceadd.lists.expCategory_id = <?= $Page->expCategory_id->toClientList($Page) ?>;
    fcash_advanceadd.lists.expSubcategory_id = <?= $Page->expSubcategory_id->toClientList($Page) ?>;
    fcash_advanceadd.lists.budget_id = <?= $Page->budget_id->toClientList($Page) ?>;
    fcash_advanceadd.lists.machine_id = <?= $Page->machine_id->toClientList($Page) ?>;
    loadjs.done("fcash_advanceadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fcash_advanceadd" id="fcash_advanceadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cash_advance">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
    <div id="r_expCategory_id"<?= $Page->expCategory_id->rowAttributes() ?>>
        <label id="elh_cash_advance_expCategory_id" for="x_expCategory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expCategory_id->caption() ?><?= $Page->expCategory_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expCategory_id->cellAttributes() ?>>
<span id="el_cash_advance_expCategory_id">
<?php $Page->expCategory_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_expCategory_id"
        name="x_expCategory_id"
        class="form-select ew-select<?= $Page->expCategory_id->isInvalidClass() ?>"
        data-select2-id="fcash_advanceadd_x_expCategory_id"
        data-table="cash_advance"
        data-field="x_expCategory_id"
        data-value-separator="<?= $Page->expCategory_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->expCategory_id->getPlaceHolder()) ?>"
        <?= $Page->expCategory_id->editAttributes() ?>>
        <?= $Page->expCategory_id->selectOptionListHtml("x_expCategory_id") ?>
    </select>
    <?= $Page->expCategory_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->expCategory_id->getErrorMessage() ?></div>
<?= $Page->expCategory_id->Lookup->getParamTag($Page, "p_x_expCategory_id") ?>
<script>
loadjs.ready("fcash_advanceadd", function() {
    var options = { name: "x_expCategory_id", selectId: "fcash_advanceadd_x_expCategory_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcash_advanceadd.lists.expCategory_id.lookupOptions.length) {
        options.data = { id: "x_expCategory_id", form: "fcash_advanceadd" };
    } else {
        options.ajax = { id: "x_expCategory_id", form: "fcash_advanceadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cash_advance.fields.expCategory_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expSubcategory_id->Visible) { // expSubcategory_id ?>
    <div id="r_expSubcategory_id"<?= $Page->expSubcategory_id->rowAttributes() ?>>
        <label id="elh_cash_advance_expSubcategory_id" for="x_expSubcategory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expSubcategory_id->caption() ?><?= $Page->expSubcategory_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expSubcategory_id->cellAttributes() ?>>
<span id="el_cash_advance_expSubcategory_id">
<?php $Page->expSubcategory_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_expSubcategory_id"
        name="x_expSubcategory_id"
        class="form-select ew-select<?= $Page->expSubcategory_id->isInvalidClass() ?>"
        data-select2-id="fcash_advanceadd_x_expSubcategory_id"
        data-table="cash_advance"
        data-field="x_expSubcategory_id"
        data-value-separator="<?= $Page->expSubcategory_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->expSubcategory_id->getPlaceHolder()) ?>"
        <?= $Page->expSubcategory_id->editAttributes() ?>>
        <?= $Page->expSubcategory_id->selectOptionListHtml("x_expSubcategory_id") ?>
    </select>
    <?= $Page->expSubcategory_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->expSubcategory_id->getErrorMessage() ?></div>
<?= $Page->expSubcategory_id->Lookup->getParamTag($Page, "p_x_expSubcategory_id") ?>
<script>
loadjs.ready("fcash_advanceadd", function() {
    var options = { name: "x_expSubcategory_id", selectId: "fcash_advanceadd_x_expSubcategory_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcash_advanceadd.lists.expSubcategory_id.lookupOptions.length) {
        options.data = { id: "x_expSubcategory_id", form: "fcash_advanceadd" };
    } else {
        options.ajax = { id: "x_expSubcategory_id", form: "fcash_advanceadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cash_advance.fields.expSubcategory_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->budget_id->Visible) { // budget_id ?>
    <div id="r_budget_id"<?= $Page->budget_id->rowAttributes() ?>>
        <label id="elh_cash_advance_budget_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->budget_id->caption() ?><?= $Page->budget_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->budget_id->cellAttributes() ?>>
<span id="el_cash_advance_budget_id">
<template id="tp_x_budget_id">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" data-table="cash_advance" data-field="x_budget_id" name="x_budget_id" id="x_budget_id"<?= $Page->budget_id->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_budget_id" class="ew-item-list"></div>
<selection-list hidden
    id="x_budget_id[]"
    name="x_budget_id[]"
    value="<?= HtmlEncode($Page->budget_id->CurrentValue) ?>"
    data-type="select-multiple"
    data-template="tp_x_budget_id"
    data-bs-target="dsl_x_budget_id"
    data-repeatcolumn="5"
    class="form-control<?= $Page->budget_id->isInvalidClass() ?>"
    data-table="cash_advance"
    data-field="x_budget_id"
    data-value-separator="<?= $Page->budget_id->displayValueSeparatorAttribute() ?>"
    <?= $Page->budget_id->editAttributes() ?>></selection-list>
<?= $Page->budget_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->budget_id->getErrorMessage() ?></div>
<?= $Page->budget_id->Lookup->getParamTag($Page, "p_x_budget_id") ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->machine_id->Visible) { // machine_id ?>
    <div id="r_machine_id"<?= $Page->machine_id->rowAttributes() ?>>
        <label id="elh_cash_advance_machine_id" for="x_machine_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->machine_id->caption() ?><?= $Page->machine_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->machine_id->cellAttributes() ?>>
<span id="el_cash_advance_machine_id">
    <select
        id="x_machine_id"
        name="x_machine_id"
        class="form-select ew-select<?= $Page->machine_id->isInvalidClass() ?>"
        data-select2-id="fcash_advanceadd_x_machine_id"
        data-table="cash_advance"
        data-field="x_machine_id"
        data-value-separator="<?= $Page->machine_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->machine_id->getPlaceHolder()) ?>"
        <?= $Page->machine_id->editAttributes() ?>>
        <?= $Page->machine_id->selectOptionListHtml("x_machine_id") ?>
    </select>
    <?= $Page->machine_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->machine_id->getErrorMessage() ?></div>
<?= $Page->machine_id->Lookup->getParamTag($Page, "p_x_machine_id") ?>
<script>
loadjs.ready("fcash_advanceadd", function() {
    var options = { name: "x_machine_id", selectId: "fcash_advanceadd_x_machine_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcash_advanceadd.lists.machine_id.lookupOptions.length) {
        options.data = { id: "x_machine_id", form: "fcash_advanceadd" };
    } else {
        options.ajax = { id: "x_machine_id", form: "fcash_advanceadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cash_advance.fields.machine_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
    <div id="r_note"<?= $Page->note->rowAttributes() ?>>
        <label id="elh_cash_advance_note" for="x_note" class="<?= $Page->LeftColumnClass ?>"><?= $Page->note->caption() ?><?= $Page->note->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->note->cellAttributes() ?>>
<span id="el_cash_advance_note">
<input type="<?= $Page->note->getInputTextType() ?>" name="x_note" id="x_note" data-table="cash_advance" data-field="x_note" value="<?= $Page->note->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->note->getPlaceHolder()) ?>"<?= $Page->note->editAttributes() ?> aria-describedby="x_note_help">
<?= $Page->note->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->note->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("cash_advance");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    $("#r_machine_id").hide(); 
    $(document).ready(function(){ 
        $("#x_expCategory_id").change(function() {
            var str = $("option:selected", this);
            if (this.value == "3") {
                $("#r_machine_id").show();
            } else {
                $("#r_machine_id").hide(); 
            }
        })
    });
});
</script>
