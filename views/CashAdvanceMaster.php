<?php

namespace PHPMaker2022\efga_expense_system;

// Table
$cash_advance = Container("cash_advance");
?>
<?php if ($cash_advance->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_cash_advancemaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($cash_advance->id->Visible) { // id ?>
        <tr id="r_id"<?= $cash_advance->id->rowAttributes() ?>>
            <td class="<?= $cash_advance->TableLeftColumnClass ?>"><?= $cash_advance->id->caption() ?></td>
            <td<?= $cash_advance->id->cellAttributes() ?>>
<span id="el_cash_advance_id">
<span<?= $cash_advance->id->viewAttributes() ?>>
<?= $cash_advance->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cash_advance->expCategory_id->Visible) { // expCategory_id ?>
        <tr id="r_expCategory_id"<?= $cash_advance->expCategory_id->rowAttributes() ?>>
            <td class="<?= $cash_advance->TableLeftColumnClass ?>"><?= $cash_advance->expCategory_id->caption() ?></td>
            <td<?= $cash_advance->expCategory_id->cellAttributes() ?>>
<span id="el_cash_advance_expCategory_id">
<span<?= $cash_advance->expCategory_id->viewAttributes() ?>>
<?= $cash_advance->expCategory_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cash_advance->expSubcategory_id->Visible) { // expSubcategory_id ?>
        <tr id="r_expSubcategory_id"<?= $cash_advance->expSubcategory_id->rowAttributes() ?>>
            <td class="<?= $cash_advance->TableLeftColumnClass ?>"><?= $cash_advance->expSubcategory_id->caption() ?></td>
            <td<?= $cash_advance->expSubcategory_id->cellAttributes() ?>>
<span id="el_cash_advance_expSubcategory_id">
<span<?= $cash_advance->expSubcategory_id->viewAttributes() ?>>
<?= $cash_advance->expSubcategory_id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cash_advance->dateReceived->Visible) { // dateReceived ?>
        <tr id="r_dateReceived"<?= $cash_advance->dateReceived->rowAttributes() ?>>
            <td class="<?= $cash_advance->TableLeftColumnClass ?>"><?= $cash_advance->dateReceived->caption() ?></td>
            <td<?= $cash_advance->dateReceived->cellAttributes() ?>>
<span id="el_cash_advance_dateReceived">
<span<?= $cash_advance->dateReceived->viewAttributes() ?>>
<?= $cash_advance->dateReceived->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cash_advance->submittedBy->Visible) { // submittedBy ?>
        <tr id="r_submittedBy"<?= $cash_advance->submittedBy->rowAttributes() ?>>
            <td class="<?= $cash_advance->TableLeftColumnClass ?>"><?= $cash_advance->submittedBy->caption() ?></td>
            <td<?= $cash_advance->submittedBy->cellAttributes() ?>>
<span id="el_cash_advance_submittedBy">
<span<?= $cash_advance->submittedBy->viewAttributes() ?>>
<?= $cash_advance->submittedBy->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cash_advance->note->Visible) { // note ?>
        <tr id="r_note"<?= $cash_advance->note->rowAttributes() ?>>
            <td class="<?= $cash_advance->TableLeftColumnClass ?>"><?= $cash_advance->note->caption() ?></td>
            <td<?= $cash_advance->note->cellAttributes() ?>>
<span id="el_cash_advance_note">
<span<?= $cash_advance->note->viewAttributes() ?>>
<?= $cash_advance->note->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cash_advance->status->Visible) { // status ?>
        <tr id="r_status"<?= $cash_advance->status->rowAttributes() ?>>
            <td class="<?= $cash_advance->TableLeftColumnClass ?>"><?= $cash_advance->status->caption() ?></td>
            <td<?= $cash_advance->status->cellAttributes() ?>>
<span id="el_cash_advance_status">
<span<?= $cash_advance->status->viewAttributes() ?>>
<?= $cash_advance->status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cash_advance->validatedBy->Visible) { // validatedBy ?>
        <tr id="r_validatedBy"<?= $cash_advance->validatedBy->rowAttributes() ?>>
            <td class="<?= $cash_advance->TableLeftColumnClass ?>"><?= $cash_advance->validatedBy->caption() ?></td>
            <td<?= $cash_advance->validatedBy->cellAttributes() ?>>
<span id="el_cash_advance_validatedBy">
<span<?= $cash_advance->validatedBy->viewAttributes() ?>>
<?= $cash_advance->validatedBy->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($cash_advance->amount->Visible) { // amount ?>
        <tr id="r_amount"<?= $cash_advance->amount->rowAttributes() ?>>
            <td class="<?= $cash_advance->TableLeftColumnClass ?>"><?= $cash_advance->amount->caption() ?></td>
            <td<?= $cash_advance->amount->cellAttributes() ?>>
<span id="el_cash_advance_amount">
<span<?= $cash_advance->amount->viewAttributes() ?>>
<?= $cash_advance->amount->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
