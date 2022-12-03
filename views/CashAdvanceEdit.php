<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$CashAdvanceEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { cash_advance: currentTable } });
var currentForm, currentPageID;
var fcash_advanceedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fcash_advanceedit = new ew.Form("fcash_advanceedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fcash_advanceedit;

    // Add fields
    var fields = currentTable.fields;
    fcash_advanceedit.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["expCategory_id", [fields.expCategory_id.visible && fields.expCategory_id.required ? ew.Validators.required(fields.expCategory_id.caption) : null], fields.expCategory_id.isInvalid],
        ["expSubcategory_id", [fields.expSubcategory_id.visible && fields.expSubcategory_id.required ? ew.Validators.required(fields.expSubcategory_id.caption) : null], fields.expSubcategory_id.isInvalid],
        ["budget_id", [fields.budget_id.visible && fields.budget_id.required ? ew.Validators.required(fields.budget_id.caption) : null], fields.budget_id.isInvalid],
        ["machine_id", [fields.machine_id.visible && fields.machine_id.required ? ew.Validators.required(fields.machine_id.caption) : null], fields.machine_id.isInvalid],
        ["dateReceived", [fields.dateReceived.visible && fields.dateReceived.required ? ew.Validators.required(fields.dateReceived.caption) : null], fields.dateReceived.isInvalid],
        ["submittedBy", [fields.submittedBy.visible && fields.submittedBy.required ? ew.Validators.required(fields.submittedBy.caption) : null], fields.submittedBy.isInvalid],
        ["note", [fields.note.visible && fields.note.required ? ew.Validators.required(fields.note.caption) : null], fields.note.isInvalid],
        ["status", [fields.status.visible && fields.status.required ? ew.Validators.required(fields.status.caption) : null], fields.status.isInvalid],
        ["validatedBy", [fields.validatedBy.visible && fields.validatedBy.required ? ew.Validators.required(fields.validatedBy.caption) : null], fields.validatedBy.isInvalid]
    ]);

    // Form_CustomValidate
    fcash_advanceedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fcash_advanceedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fcash_advanceedit.lists.expCategory_id = <?= $Page->expCategory_id->toClientList($Page) ?>;
    fcash_advanceedit.lists.expSubcategory_id = <?= $Page->expSubcategory_id->toClientList($Page) ?>;
    fcash_advanceedit.lists.machine_id = <?= $Page->machine_id->toClientList($Page) ?>;
    loadjs.done("fcash_advanceedit");
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
<form name="fcash_advanceedit" id="fcash_advanceedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="cash_advance">
<input type="hidden" name="k_hash" id="k_hash" value="<?= $Page->HashValue ?>">
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<input type="hidden" name="conflict" id="conflict" value="1">
<?php } ?>
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label id="elh_cash_advance_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expCategory_id->Visible) { // expCategory_id ?>
    <div id="r_expCategory_id"<?= $Page->expCategory_id->rowAttributes() ?>>
        <label id="elh_cash_advance_expCategory_id" for="x_expCategory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expCategory_id->caption() ?><?= $Page->expCategory_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expCategory_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_expCategory_id">
<?php $Page->expCategory_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_expCategory_id"
        name="x_expCategory_id"
        class="form-select ew-select<?= $Page->expCategory_id->isInvalidClass() ?>"
        data-select2-id="fcash_advanceedit_x_expCategory_id"
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
loadjs.ready("fcash_advanceedit", function() {
    var options = { name: "x_expCategory_id", selectId: "fcash_advanceedit_x_expCategory_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcash_advanceedit.lists.expCategory_id.lookupOptions.length) {
        options.data = { id: "x_expCategory_id", form: "fcash_advanceedit" };
    } else {
        options.ajax = { id: "x_expCategory_id", form: "fcash_advanceedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cash_advance.fields.expCategory_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_cash_advance_expCategory_id">
<span<?= $Page->expCategory_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expCategory_id->getDisplayValue($Page->expCategory_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_expCategory_id" data-hidden="1" name="x_expCategory_id" id="x_expCategory_id" value="<?= HtmlEncode($Page->expCategory_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expSubcategory_id->Visible) { // expSubcategory_id ?>
    <div id="r_expSubcategory_id"<?= $Page->expSubcategory_id->rowAttributes() ?>>
        <label id="elh_cash_advance_expSubcategory_id" for="x_expSubcategory_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expSubcategory_id->caption() ?><?= $Page->expSubcategory_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->expSubcategory_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_expSubcategory_id">
<?php $Page->expSubcategory_id->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_expSubcategory_id"
        name="x_expSubcategory_id"
        class="form-select ew-select<?= $Page->expSubcategory_id->isInvalidClass() ?>"
        data-select2-id="fcash_advanceedit_x_expSubcategory_id"
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
loadjs.ready("fcash_advanceedit", function() {
    var options = { name: "x_expSubcategory_id", selectId: "fcash_advanceedit_x_expSubcategory_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcash_advanceedit.lists.expSubcategory_id.lookupOptions.length) {
        options.data = { id: "x_expSubcategory_id", form: "fcash_advanceedit" };
    } else {
        options.ajax = { id: "x_expSubcategory_id", form: "fcash_advanceedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cash_advance.fields.expSubcategory_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_cash_advance_expSubcategory_id">
<span<?= $Page->expSubcategory_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->expSubcategory_id->getDisplayValue($Page->expSubcategory_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_expSubcategory_id" data-hidden="1" name="x_expSubcategory_id" id="x_expSubcategory_id" value="<?= HtmlEncode($Page->expSubcategory_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->budget_id->Visible) { // budget_id ?>
    <div id="r_budget_id"<?= $Page->budget_id->rowAttributes() ?>>
        <label id="elh_cash_advance_budget_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->budget_id->caption() ?><?= $Page->budget_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->budget_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_budget_id">
<span<?= $Page->budget_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->budget_id->getDisplayValue($Page->budget_id->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_budget_id" data-hidden="1" name="x_budget_id" id="x_budget_id" value="<?= HtmlEncode($Page->budget_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_budget_id">
<span<?= $Page->budget_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->budget_id->getDisplayValue($Page->budget_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_budget_id" data-hidden="1" name="x_budget_id" id="x_budget_id" value="<?= HtmlEncode($Page->budget_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->machine_id->Visible) { // machine_id ?>
    <div id="r_machine_id"<?= $Page->machine_id->rowAttributes() ?>>
        <label id="elh_cash_advance_machine_id" for="x_machine_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->machine_id->caption() ?><?= $Page->machine_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->machine_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_machine_id">
    <select
        id="x_machine_id"
        name="x_machine_id"
        class="form-select ew-select<?= $Page->machine_id->isInvalidClass() ?>"
        data-select2-id="fcash_advanceedit_x_machine_id"
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
loadjs.ready("fcash_advanceedit", function() {
    var options = { name: "x_machine_id", selectId: "fcash_advanceedit_x_machine_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fcash_advanceedit.lists.machine_id.lookupOptions.length) {
        options.data = { id: "x_machine_id", form: "fcash_advanceedit" };
    } else {
        options.ajax = { id: "x_machine_id", form: "fcash_advanceedit", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.cash_advance.fields.machine_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_cash_advance_machine_id">
<span<?= $Page->machine_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->machine_id->getDisplayValue($Page->machine_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_machine_id" data-hidden="1" name="x_machine_id" id="x_machine_id" value="<?= HtmlEncode($Page->machine_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateReceived->Visible) { // dateReceived ?>
    <div id="r_dateReceived"<?= $Page->dateReceived->rowAttributes() ?>>
        <label id="elh_cash_advance_dateReceived" for="x_dateReceived" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateReceived->caption() ?><?= $Page->dateReceived->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateReceived->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_dateReceived">
<span<?= $Page->dateReceived->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateReceived->getDisplayValue($Page->dateReceived->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_dateReceived" data-hidden="1" name="x_dateReceived" id="x_dateReceived" value="<?= HtmlEncode($Page->dateReceived->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_dateReceived">
<span<?= $Page->dateReceived->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateReceived->getDisplayValue($Page->dateReceived->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_dateReceived" data-hidden="1" name="x_dateReceived" id="x_dateReceived" value="<?= HtmlEncode($Page->dateReceived->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->submittedBy->Visible) { // submittedBy ?>
    <div id="r_submittedBy"<?= $Page->submittedBy->rowAttributes() ?>>
        <label id="elh_cash_advance_submittedBy" for="x_submittedBy" class="<?= $Page->LeftColumnClass ?>"><?= $Page->submittedBy->caption() ?><?= $Page->submittedBy->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->submittedBy->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->submittedBy->getDisplayValue($Page->submittedBy->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_submittedBy" data-hidden="1" name="x_submittedBy" id="x_submittedBy" value="<?= HtmlEncode($Page->submittedBy->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_submittedBy">
<span<?= $Page->submittedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->submittedBy->getDisplayValue($Page->submittedBy->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_submittedBy" data-hidden="1" name="x_submittedBy" id="x_submittedBy" value="<?= HtmlEncode($Page->submittedBy->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->note->Visible) { // note ?>
    <div id="r_note"<?= $Page->note->rowAttributes() ?>>
        <label id="elh_cash_advance_note" for="x_note" class="<?= $Page->LeftColumnClass ?>"><?= $Page->note->caption() ?><?= $Page->note->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->note->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_note">
<input type="<?= $Page->note->getInputTextType() ?>" name="x_note" id="x_note" data-table="cash_advance" data-field="x_note" value="<?= $Page->note->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->note->getPlaceHolder()) ?>"<?= $Page->note->editAttributes() ?> aria-describedby="x_note_help">
<?= $Page->note->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->note->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_cash_advance_note">
<span<?= $Page->note->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->note->getDisplayValue($Page->note->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_note" data-hidden="1" name="x_note" id="x_note" value="<?= HtmlEncode($Page->note->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <div id="r_status"<?= $Page->status->rowAttributes() ?>>
        <label id="elh_cash_advance_status" class="<?= $Page->LeftColumnClass ?>"><?= $Page->status->caption() ?><?= $Page->status->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->status->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_status">
<span<?= $Page->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->status->getDisplayValue($Page->status->EditValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_status" data-hidden="1" name="x_status" id="x_status" value="<?= HtmlEncode($Page->status->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_status">
<span<?= $Page->status->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->status->getDisplayValue($Page->status->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_status" data-hidden="1" name="x_status" id="x_status" value="<?= HtmlEncode($Page->status->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->validatedBy->Visible) { // validatedBy ?>
    <div id="r_validatedBy"<?= $Page->validatedBy->rowAttributes() ?>>
        <label id="elh_cash_advance_validatedBy" for="x_validatedBy" class="<?= $Page->LeftColumnClass ?>"><?= $Page->validatedBy->caption() ?><?= $Page->validatedBy->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->validatedBy->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_cash_advance_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->validatedBy->getDisplayValue($Page->validatedBy->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_validatedBy" data-hidden="1" name="x_validatedBy" id="x_validatedBy" value="<?= HtmlEncode($Page->validatedBy->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cash_advance_validatedBy">
<span<?= $Page->validatedBy->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->validatedBy->getDisplayValue($Page->validatedBy->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="cash_advance" data-field="x_validatedBy" data-hidden="1" name="x_validatedBy" id="x_validatedBy" value="<?= HtmlEncode($Page->validatedBy->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if ($Page->UpdateConflict == "U") { // Record already updated by other user ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" data-ew-action="set-action" data-value="overwrite"><?= $Language->phrase("OverwriteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-reload" id="btn-reload" type="submit" data-ew-action="set-action" data-value="show"><?= $Language->phrase("ReloadBtn") ?></button>
<?php } else { ?>
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
<?php } ?>
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
    if ($("#x_expCategory_id").value() == "3") {
        $("#r_machine_id").show();
    }
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
