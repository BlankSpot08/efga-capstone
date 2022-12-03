<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$MachineAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { machine: currentTable } });
var currentForm, currentPageID;
var fmachineadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fmachineadd = new ew.Form("fmachineadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fmachineadd;

    // Add fields
    var fields = currentTable.fields;
    fmachineadd.addFields([
        ["machine_category_id", [fields.machine_category_id.visible && fields.machine_category_id.required ? ew.Validators.required(fields.machine_category_id.caption) : null], fields.machine_category_id.isInvalid],
        ["brand_id", [fields.brand_id.visible && fields.brand_id.required ? ew.Validators.required(fields.brand_id.caption) : null], fields.brand_id.isInvalid],
        ["model", [fields.model.visible && fields.model.required ? ew.Validators.required(fields.model.caption) : null], fields.model.isInvalid],
        ["photo", [fields.photo.visible && fields.photo.required ? ew.Validators.fileRequired(fields.photo.caption) : null], fields.photo.isInvalid]
    ]);

    // Form_CustomValidate
    fmachineadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmachineadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fmachineadd.lists.machine_category_id = <?= $Page->machine_category_id->toClientList($Page) ?>;
    fmachineadd.lists.brand_id = <?= $Page->brand_id->toClientList($Page) ?>;
    loadjs.done("fmachineadd");
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
<form name="fmachineadd" id="fmachineadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="machine">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->machine_category_id->Visible) { // machine_category_id ?>
    <div id="r_machine_category_id"<?= $Page->machine_category_id->rowAttributes() ?>>
        <label id="elh_machine_machine_category_id" for="x_machine_category_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->machine_category_id->caption() ?><?= $Page->machine_category_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->machine_category_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_machine_machine_category_id">
    <select
        id="x_machine_category_id"
        name="x_machine_category_id"
        class="form-select ew-select<?= $Page->machine_category_id->isInvalidClass() ?>"
        data-select2-id="fmachineadd_x_machine_category_id"
        data-table="machine"
        data-field="x_machine_category_id"
        data-value-separator="<?= $Page->machine_category_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->machine_category_id->getPlaceHolder()) ?>"
        <?= $Page->machine_category_id->editAttributes() ?>>
        <?= $Page->machine_category_id->selectOptionListHtml("x_machine_category_id") ?>
    </select>
    <?= $Page->machine_category_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->machine_category_id->getErrorMessage() ?></div>
<?= $Page->machine_category_id->Lookup->getParamTag($Page, "p_x_machine_category_id") ?>
<script>
loadjs.ready("fmachineadd", function() {
    var options = { name: "x_machine_category_id", selectId: "fmachineadd_x_machine_category_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fmachineadd.lists.machine_category_id.lookupOptions.length) {
        options.data = { id: "x_machine_category_id", form: "fmachineadd" };
    } else {
        options.ajax = { id: "x_machine_category_id", form: "fmachineadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.machine.fields.machine_category_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_machine_machine_category_id">
<span<?= $Page->machine_category_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->machine_category_id->getDisplayValue($Page->machine_category_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="machine" data-field="x_machine_category_id" data-hidden="1" name="x_machine_category_id" id="x_machine_category_id" value="<?= HtmlEncode($Page->machine_category_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->brand_id->Visible) { // brand_id ?>
    <div id="r_brand_id"<?= $Page->brand_id->rowAttributes() ?>>
        <label id="elh_machine_brand_id" for="x_brand_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->brand_id->caption() ?><?= $Page->brand_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->brand_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_machine_brand_id">
    <select
        id="x_brand_id"
        name="x_brand_id"
        class="form-select ew-select<?= $Page->brand_id->isInvalidClass() ?>"
        data-select2-id="fmachineadd_x_brand_id"
        data-table="machine"
        data-field="x_brand_id"
        data-value-separator="<?= $Page->brand_id->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->brand_id->getPlaceHolder()) ?>"
        <?= $Page->brand_id->editAttributes() ?>>
        <?= $Page->brand_id->selectOptionListHtml("x_brand_id") ?>
    </select>
    <?= $Page->brand_id->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->brand_id->getErrorMessage() ?></div>
<?= $Page->brand_id->Lookup->getParamTag($Page, "p_x_brand_id") ?>
<script>
loadjs.ready("fmachineadd", function() {
    var options = { name: "x_brand_id", selectId: "fmachineadd_x_brand_id" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fmachineadd.lists.brand_id.lookupOptions.length) {
        options.data = { id: "x_brand_id", form: "fmachineadd" };
    } else {
        options.ajax = { id: "x_brand_id", form: "fmachineadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.machine.fields.brand_id.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_machine_brand_id">
<span<?= $Page->brand_id->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->brand_id->getDisplayValue($Page->brand_id->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="machine" data-field="x_brand_id" data-hidden="1" name="x_brand_id" id="x_brand_id" value="<?= HtmlEncode($Page->brand_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->model->Visible) { // model ?>
    <div id="r_model"<?= $Page->model->rowAttributes() ?>>
        <label id="elh_machine_model" for="x_model" class="<?= $Page->LeftColumnClass ?>"><?= $Page->model->caption() ?><?= $Page->model->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->model->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_machine_model">
<input type="<?= $Page->model->getInputTextType() ?>" name="x_model" id="x_model" data-table="machine" data-field="x_model" value="<?= $Page->model->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->model->getPlaceHolder()) ?>"<?= $Page->model->editAttributes() ?> aria-describedby="x_model_help">
<?= $Page->model->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->model->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_machine_model">
<span<?= $Page->model->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->model->getDisplayValue($Page->model->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="machine" data-field="x_model" data-hidden="1" name="x_model" id="x_model" value="<?= HtmlEncode($Page->model->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
    <div id="r_photo"<?= $Page->photo->rowAttributes() ?>>
        <label id="elh_machine_photo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->photo->caption() ?><?= $Page->photo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->photo->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_machine_photo">
<div id="fd_x_photo" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->photo->title() ?>" data-table="machine" data-field="x_photo" name="x_photo" id="x_photo" lang="<?= CurrentLanguageID() ?>"<?= $Page->photo->editAttributes() ?> aria-describedby="x_photo_help"<?= ($Page->photo->ReadOnly || $Page->photo->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->photo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_photo" id= "fn_x_photo" value="<?= $Page->photo->Upload->FileName ?>">
<input type="hidden" name="fa_x_photo" id= "fa_x_photo" value="0">
<input type="hidden" name="fs_x_photo" id= "fs_x_photo" value="0">
<input type="hidden" name="fx_x_photo" id= "fx_x_photo" value="<?= $Page->photo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_photo" id= "fm_x_photo" value="<?= $Page->photo->UploadMaxFileSize ?>">
<table id="ft_x_photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el_machine_photo">
<div id="fd_x_photo">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Page->photo->title() ?>" data-table="machine" data-field="x_photo" name="x_photo" id="x_photo" lang="<?= CurrentLanguageID() ?>"<?= $Page->photo->editAttributes() ?> aria-describedby="x_photo_help">
</div>
<?= $Page->photo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_photo" id= "fn_x_photo" value="<?= $Page->photo->Upload->FileName ?>">
<input type="hidden" name="fa_x_photo" id= "fa_x_photo" value="0">
<input type="hidden" name="fs_x_photo" id= "fs_x_photo" value="0">
<input type="hidden" name="fx_x_photo" id= "fx_x_photo" value="<?= $Page->photo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_photo" id= "fm_x_photo" value="<?= $Page->photo->UploadMaxFileSize ?>">
<table id="ft_x_photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("machine");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
