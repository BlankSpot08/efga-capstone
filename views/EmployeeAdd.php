<?php

namespace PHPMaker2022\efga_expense_system;

// Page object
$EmployeeAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { employee: currentTable } });
var currentForm, currentPageID;
var femployeeadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    femployeeadd = new ew.Form("femployeeadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = femployeeadd;

    // Add fields
    var fields = currentTable.fields;
    femployeeadd.addFields([
        ["employee_id", [fields.employee_id.visible && fields.employee_id.required ? ew.Validators.required(fields.employee_id.caption) : null, ew.Validators.integer], fields.employee_id.isInvalid],
        ["lastname", [fields.lastname.visible && fields.lastname.required ? ew.Validators.required(fields.lastname.caption) : null], fields.lastname.isInvalid],
        ["firstname", [fields.firstname.visible && fields.firstname.required ? ew.Validators.required(fields.firstname.caption) : null], fields.firstname.isInvalid],
        ["middlename", [fields.middlename.visible && fields.middlename.required ? ew.Validators.required(fields.middlename.caption) : null], fields.middlename.isInvalid],
        ["dateOfBirth", [fields.dateOfBirth.visible && fields.dateOfBirth.required ? ew.Validators.required(fields.dateOfBirth.caption) : null, ew.Validators.datetime(fields.dateOfBirth.clientFormatPattern)], fields.dateOfBirth.isInvalid],
        ["picture", [fields.picture.visible && fields.picture.required ? ew.Validators.fileRequired(fields.picture.caption) : null], fields.picture.isInvalid],
        ["address", [fields.address.visible && fields.address.required ? ew.Validators.required(fields.address.caption) : null], fields.address.isInvalid],
        ["contactNo", [fields.contactNo.visible && fields.contactNo.required ? ew.Validators.required(fields.contactNo.caption) : null], fields.contactNo.isInvalid],
        ["officeDepartment", [fields.officeDepartment.visible && fields.officeDepartment.required ? ew.Validators.required(fields.officeDepartment.caption) : null], fields.officeDepartment.isInvalid],
        ["empPosition", [fields.empPosition.visible && fields.empPosition.required ? ew.Validators.required(fields.empPosition.caption) : null], fields.empPosition.isInvalid]
    ]);

    // Form_CustomValidate
    femployeeadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    femployeeadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    femployeeadd.lists.officeDepartment = <?= $Page->officeDepartment->toClientList($Page) ?>;
    femployeeadd.lists.empPosition = <?= $Page->empPosition->toClientList($Page) ?>;
    loadjs.done("femployeeadd");
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
<form name="femployeeadd" id="femployeeadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="employee">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->employee_id->Visible) { // employee_id ?>
    <div id="r_employee_id"<?= $Page->employee_id->rowAttributes() ?>>
        <label id="elh_employee_employee_id" for="x_employee_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->employee_id->caption() ?><?= $Page->employee_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->employee_id->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_employee_employee_id">
<input type="<?= $Page->employee_id->getInputTextType() ?>" name="x_employee_id" id="x_employee_id" data-table="employee" data-field="x_employee_id" value="<?= $Page->employee_id->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->employee_id->getPlaceHolder()) ?>"<?= $Page->employee_id->editAttributes() ?> aria-describedby="x_employee_id_help">
<?= $Page->employee_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->employee_id->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_employee_employee_id">
<span<?= $Page->employee_id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->employee_id->getDisplayValue($Page->employee_id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="employee" data-field="x_employee_id" data-hidden="1" name="x_employee_id" id="x_employee_id" value="<?= HtmlEncode($Page->employee_id->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
    <div id="r_lastname"<?= $Page->lastname->rowAttributes() ?>>
        <label id="elh_employee_lastname" for="x_lastname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lastname->caption() ?><?= $Page->lastname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->lastname->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_employee_lastname">
<input type="<?= $Page->lastname->getInputTextType() ?>" name="x_lastname" id="x_lastname" data-table="employee" data-field="x_lastname" value="<?= $Page->lastname->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->lastname->getPlaceHolder()) ?>"<?= $Page->lastname->editAttributes() ?> aria-describedby="x_lastname_help">
<?= $Page->lastname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lastname->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_employee_lastname">
<span<?= $Page->lastname->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->lastname->getDisplayValue($Page->lastname->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="employee" data-field="x_lastname" data-hidden="1" name="x_lastname" id="x_lastname" value="<?= HtmlEncode($Page->lastname->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->firstname->Visible) { // firstname ?>
    <div id="r_firstname"<?= $Page->firstname->rowAttributes() ?>>
        <label id="elh_employee_firstname" for="x_firstname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->firstname->caption() ?><?= $Page->firstname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->firstname->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_employee_firstname">
<input type="<?= $Page->firstname->getInputTextType() ?>" name="x_firstname" id="x_firstname" data-table="employee" data-field="x_firstname" value="<?= $Page->firstname->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->firstname->getPlaceHolder()) ?>"<?= $Page->firstname->editAttributes() ?> aria-describedby="x_firstname_help">
<?= $Page->firstname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->firstname->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_employee_firstname">
<span<?= $Page->firstname->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->firstname->getDisplayValue($Page->firstname->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="employee" data-field="x_firstname" data-hidden="1" name="x_firstname" id="x_firstname" value="<?= HtmlEncode($Page->firstname->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
    <div id="r_middlename"<?= $Page->middlename->rowAttributes() ?>>
        <label id="elh_employee_middlename" for="x_middlename" class="<?= $Page->LeftColumnClass ?>"><?= $Page->middlename->caption() ?><?= $Page->middlename->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->middlename->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_employee_middlename">
<input type="<?= $Page->middlename->getInputTextType() ?>" name="x_middlename" id="x_middlename" data-table="employee" data-field="x_middlename" value="<?= $Page->middlename->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->middlename->getPlaceHolder()) ?>"<?= $Page->middlename->editAttributes() ?> aria-describedby="x_middlename_help">
<?= $Page->middlename->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->middlename->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_employee_middlename">
<span<?= $Page->middlename->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->middlename->getDisplayValue($Page->middlename->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="employee" data-field="x_middlename" data-hidden="1" name="x_middlename" id="x_middlename" value="<?= HtmlEncode($Page->middlename->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dateOfBirth->Visible) { // dateOfBirth ?>
    <div id="r_dateOfBirth"<?= $Page->dateOfBirth->rowAttributes() ?>>
        <label id="elh_employee_dateOfBirth" for="x_dateOfBirth" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dateOfBirth->caption() ?><?= $Page->dateOfBirth->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->dateOfBirth->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_employee_dateOfBirth">
<input type="<?= $Page->dateOfBirth->getInputTextType() ?>" name="x_dateOfBirth" id="x_dateOfBirth" data-table="employee" data-field="x_dateOfBirth" value="<?= $Page->dateOfBirth->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateOfBirth->getPlaceHolder()) ?>"<?= $Page->dateOfBirth->editAttributes() ?> aria-describedby="x_dateOfBirth_help">
<?= $Page->dateOfBirth->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dateOfBirth->getErrorMessage() ?></div>
<?php if (!$Page->dateOfBirth->ReadOnly && !$Page->dateOfBirth->Disabled && !isset($Page->dateOfBirth->EditAttrs["readonly"]) && !isset($Page->dateOfBirth->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["femployeeadd", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
        localization: {
            locale: ew.LANGUAGE_ID,
            numberingSystem: ew.getNumberingSystem()
        },
        display: {
            format,
            components: {
                hours: !!format.match(/h/i),
                minutes: !!format.match(/m/),
                seconds: !!format.match(/s/i)
            },
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("femployeeadd", "x_dateOfBirth", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el_employee_dateOfBirth">
<span<?= $Page->dateOfBirth->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->dateOfBirth->getDisplayValue($Page->dateOfBirth->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="employee" data-field="x_dateOfBirth" data-hidden="1" name="x_dateOfBirth" id="x_dateOfBirth" value="<?= HtmlEncode($Page->dateOfBirth->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->picture->Visible) { // picture ?>
    <div id="r_picture"<?= $Page->picture->rowAttributes() ?>>
        <label id="elh_employee_picture" class="<?= $Page->LeftColumnClass ?>"><?= $Page->picture->caption() ?><?= $Page->picture->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->picture->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_employee_picture">
<div id="fd_x_picture" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->picture->title() ?>" data-table="employee" data-field="x_picture" name="x_picture" id="x_picture" lang="<?= CurrentLanguageID() ?>"<?= $Page->picture->editAttributes() ?> aria-describedby="x_picture_help"<?= ($Page->picture->ReadOnly || $Page->picture->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->picture->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->picture->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_picture" id= "fn_x_picture" value="<?= $Page->picture->Upload->FileName ?>">
<input type="hidden" name="fa_x_picture" id= "fa_x_picture" value="0">
<input type="hidden" name="fs_x_picture" id= "fs_x_picture" value="0">
<input type="hidden" name="fx_x_picture" id= "fx_x_picture" value="<?= $Page->picture->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_picture" id= "fm_x_picture" value="<?= $Page->picture->UploadMaxFileSize ?>">
<table id="ft_x_picture" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el_employee_picture">
<div id="fd_x_picture">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Page->picture->title() ?>" data-table="employee" data-field="x_picture" name="x_picture" id="x_picture" lang="<?= CurrentLanguageID() ?>"<?= $Page->picture->editAttributes() ?> aria-describedby="x_picture_help">
</div>
<?= $Page->picture->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->picture->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_picture" id= "fn_x_picture" value="<?= $Page->picture->Upload->FileName ?>">
<input type="hidden" name="fa_x_picture" id= "fa_x_picture" value="0">
<input type="hidden" name="fs_x_picture" id= "fs_x_picture" value="0">
<input type="hidden" name="fx_x_picture" id= "fx_x_picture" value="<?= $Page->picture->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_picture" id= "fm_x_picture" value="<?= $Page->picture->UploadMaxFileSize ?>">
<table id="ft_x_picture" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
    <div id="r_address"<?= $Page->address->rowAttributes() ?>>
        <label id="elh_employee_address" for="x_address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->address->caption() ?><?= $Page->address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->address->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_employee_address">
<textarea data-table="employee" data-field="x_address" name="x_address" id="x_address" cols="5" rows="4" placeholder="<?= HtmlEncode($Page->address->getPlaceHolder()) ?>"<?= $Page->address->editAttributes() ?> aria-describedby="x_address_help"><?= $Page->address->EditValue ?></textarea>
<?= $Page->address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->address->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_employee_address">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->ViewValue ?></span>
</span>
<input type="hidden" data-table="employee" data-field="x_address" data-hidden="1" name="x_address" id="x_address" value="<?= HtmlEncode($Page->address->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contactNo->Visible) { // contactNo ?>
    <div id="r_contactNo"<?= $Page->contactNo->rowAttributes() ?>>
        <label id="elh_employee_contactNo" for="x_contactNo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->contactNo->caption() ?><?= $Page->contactNo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->contactNo->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_employee_contactNo">
<input type="<?= $Page->contactNo->getInputTextType() ?>" name="x_contactNo" id="x_contactNo" data-table="employee" data-field="x_contactNo" value="<?= $Page->contactNo->EditValue ?>" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->contactNo->getPlaceHolder()) ?>"<?= $Page->contactNo->editAttributes() ?> aria-describedby="x_contactNo_help">
<?= $Page->contactNo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contactNo->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_employee_contactNo">
<span<?= $Page->contactNo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->contactNo->getDisplayValue($Page->contactNo->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="employee" data-field="x_contactNo" data-hidden="1" name="x_contactNo" id="x_contactNo" value="<?= HtmlEncode($Page->contactNo->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->officeDepartment->Visible) { // officeDepartment ?>
    <div id="r_officeDepartment"<?= $Page->officeDepartment->rowAttributes() ?>>
        <label id="elh_employee_officeDepartment" for="x_officeDepartment" class="<?= $Page->LeftColumnClass ?>"><?= $Page->officeDepartment->caption() ?><?= $Page->officeDepartment->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->officeDepartment->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_employee_officeDepartment">
<?php $Page->officeDepartment->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_officeDepartment"
        name="x_officeDepartment"
        class="form-select ew-select<?= $Page->officeDepartment->isInvalidClass() ?>"
        data-select2-id="femployeeadd_x_officeDepartment"
        data-table="employee"
        data-field="x_officeDepartment"
        data-value-separator="<?= $Page->officeDepartment->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->officeDepartment->getPlaceHolder()) ?>"
        <?= $Page->officeDepartment->editAttributes() ?>>
        <?= $Page->officeDepartment->selectOptionListHtml("x_officeDepartment") ?>
    </select>
    <?= $Page->officeDepartment->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->officeDepartment->getErrorMessage() ?></div>
<?= $Page->officeDepartment->Lookup->getParamTag($Page, "p_x_officeDepartment") ?>
<script>
loadjs.ready("femployeeadd", function() {
    var options = { name: "x_officeDepartment", selectId: "femployeeadd_x_officeDepartment" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (femployeeadd.lists.officeDepartment.lookupOptions.length) {
        options.data = { id: "x_officeDepartment", form: "femployeeadd" };
    } else {
        options.ajax = { id: "x_officeDepartment", form: "femployeeadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.employee.fields.officeDepartment.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_employee_officeDepartment">
<span<?= $Page->officeDepartment->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->officeDepartment->getDisplayValue($Page->officeDepartment->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="employee" data-field="x_officeDepartment" data-hidden="1" name="x_officeDepartment" id="x_officeDepartment" value="<?= HtmlEncode($Page->officeDepartment->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->empPosition->Visible) { // empPosition ?>
    <div id="r_empPosition"<?= $Page->empPosition->rowAttributes() ?>>
        <label id="elh_employee_empPosition" for="x_empPosition" class="<?= $Page->LeftColumnClass ?>"><?= $Page->empPosition->caption() ?><?= $Page->empPosition->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->empPosition->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_employee_empPosition">
    <select
        id="x_empPosition"
        name="x_empPosition"
        class="form-select ew-select<?= $Page->empPosition->isInvalidClass() ?>"
        data-select2-id="femployeeadd_x_empPosition"
        data-table="employee"
        data-field="x_empPosition"
        data-value-separator="<?= $Page->empPosition->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->empPosition->getPlaceHolder()) ?>"
        <?= $Page->empPosition->editAttributes() ?>>
        <?= $Page->empPosition->selectOptionListHtml("x_empPosition") ?>
    </select>
    <?= $Page->empPosition->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->empPosition->getErrorMessage() ?></div>
<?= $Page->empPosition->Lookup->getParamTag($Page, "p_x_empPosition") ?>
<script>
loadjs.ready("femployeeadd", function() {
    var options = { name: "x_empPosition", selectId: "femployeeadd_x_empPosition" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (femployeeadd.lists.empPosition.lookupOptions.length) {
        options.data = { id: "x_empPosition", form: "femployeeadd" };
    } else {
        options.ajax = { id: "x_empPosition", form: "femployeeadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.employee.fields.empPosition.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el_employee_empPosition">
<span<?= $Page->empPosition->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->empPosition->getDisplayValue($Page->empPosition->ViewValue) ?></span></span>
</span>
<input type="hidden" data-table="employee" data-field="x_empPosition" data-hidden="1" name="x_empPosition" id="x_empPosition" value="<?= HtmlEncode($Page->empPosition->FormValue) ?>">
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
    ew.addEventHandlers("employee");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
