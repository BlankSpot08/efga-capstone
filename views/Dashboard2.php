<?php

namespace PHPMaker2022\efga_expense_system;

// Dashboard Page object
$Dashboard2 = $Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { Dashboard2: currentTable } });
var currentForm, currentPageID;
var fDashboard2dashboard;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fDashboard2dashboard = new ew.Form("fDashboard2dashboard", "dashboard");
    currentPageID = ew.PAGE_ID = "dashboard";
    currentForm = fDashboard2dashboard;
    loadjs.done("fDashboard2dashboard");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<!-- Content Container -->
<div id="ew-report" class="ew-report">
<div class="btn-toolbar ew-toolbar"></div>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<!-- Dashboard Container -->
<div id="ew-dashboard" class="container-fluid ew-dashboard">
<div class="row">
<div class="<?= $Dashboard2->ItemClassNames[0] ?>" style=' min-width: 300px; min-height: 270px;'>
<div id="Item1" class="card">
<div class="card-header">
    <h3 class="card-title"><?= $Language->chartPhrase("ExpenseToday", "ExpenseToday", "ChartCaption") ?></h3>
    <div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button></div>
</div>
<div class="card-body">
<?php
$ExpenseToday = Container("ExpenseToday");
$ExpenseToday->ExpenseToday->Width = 250;
$ExpenseToday->ExpenseToday->Height = 250;
$ExpenseToday->ExpenseToday->setParameter("clickurl", "ExpenseToday"); // Add click URL
$ExpenseToday->ExpenseToday->DrillDownUrl = ""; // No drill down for dashboard
$ExpenseToday->ExpenseToday->render("ew-chart-top");
?>
</div>
</div>
</div>
<div class="<?= $Dashboard2->ItemClassNames[1] ?>" style=' min-width: 300px; min-height: 270px;'>
<div id="Item2" class="card">
<div class="card-header">
    <h3 class="card-title"><?= $Language->chartPhrase("ExpenseYesterday", "ExpenseYesterday", "ChartCaption") ?></h3>
    <div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button></div>
</div>
<div class="card-body">
<?php
$ExpenseYesterday = Container("ExpenseYesterday");
$ExpenseYesterday->ExpenseYesterday->Width = 250;
$ExpenseYesterday->ExpenseYesterday->Height = 250;
$ExpenseYesterday->ExpenseYesterday->setParameter("clickurl", "ExpenseYesterday"); // Add click URL
$ExpenseYesterday->ExpenseYesterday->DrillDownUrl = ""; // No drill down for dashboard
$ExpenseYesterday->ExpenseYesterday->render("ew-chart-top");
?>
</div>
</div>
</div>
<div class="<?= $Dashboard2->ItemClassNames[2] ?>" style=' min-width: 300px; min-height: 270px;'>
<div id="Item3" class="card">
<div class="card-header">
    <h3 class="card-title"><?= $Language->chartPhrase("ExpenseWeekly", "ExpenseWeekly", "ChartCaption") ?></h3>
    <div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button></div>
</div>
<div class="card-body">
<?php
$ExpenseWeekly = Container("ExpenseWeekly");
$ExpenseWeekly->ExpenseWeekly->Width = 250;
$ExpenseWeekly->ExpenseWeekly->Height = 250;
$ExpenseWeekly->ExpenseWeekly->setParameter("clickurl", "ExpenseWeekly"); // Add click URL
$ExpenseWeekly->ExpenseWeekly->DrillDownUrl = ""; // No drill down for dashboard
$ExpenseWeekly->ExpenseWeekly->render("ew-chart-top");
?>
</div>
</div>
</div>
<div class="<?= $Dashboard2->ItemClassNames[3] ?>" style=' min-width: 300px; min-height: 270px;'>
<div id="Item4" class="card">
<div class="card-header">
    <h3 class="card-title"><?= $Language->chartPhrase("ExpenseMonthly", "ExpenseMonthly", "ChartCaption") ?></h3>
    <div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button></div>
</div>
<div class="card-body">
<?php
$ExpenseMonthly = Container("ExpenseMonthly");
$ExpenseMonthly->ExpenseMonthly->Width = 250;
$ExpenseMonthly->ExpenseMonthly->Height = 250;
$ExpenseMonthly->ExpenseMonthly->setParameter("clickurl", "ExpenseMonthly"); // Add click URL
$ExpenseMonthly->ExpenseMonthly->DrillDownUrl = ""; // No drill down for dashboard
$ExpenseMonthly->ExpenseMonthly->render("ew-chart-top");
?>
</div>
</div>
</div>
<div class="<?= $Dashboard2->ItemClassNames[4] ?>" style=' min-width: 600px; min-height: 520px;'>
<div id="Item5" class="card">
<div class="card-header">
    <h3 class="card-title"><?= $Language->chartPhrase("EmpMonthlyExpense", "EmployeeExpenseByCategory", "ChartCaption") ?></h3>
    <div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button></div>
</div>
<div class="card-body">
<?php
$EmpMonthlyExpense = Container("EmpMonthlyExpense");
$EmpMonthlyExpense->EmployeeExpenseByCategory->Width = 550;
$EmpMonthlyExpense->EmployeeExpenseByCategory->Height = 500;
$EmpMonthlyExpense->EmployeeExpenseByCategory->setParameter("clickurl", "EmpMonthlyExpense"); // Add click URL
$EmpMonthlyExpense->EmployeeExpenseByCategory->DrillDownUrl = ""; // No drill down for dashboard
$EmpMonthlyExpense->EmployeeExpenseByCategory->render("ew-chart-top");
?>
</div>
</div>
</div>
<div class="<?= $Dashboard2->ItemClassNames[5] ?>" style=' min-width: 600px; min-height: 520px;'>
<div id="Item6" class="card">
<div class="card-header">
    <h3 class="card-title"><?= $Language->chartPhrase("ManagerMonthlyExpense", "ManagerExpenseByCategory", "ChartCaption") ?></h3>
    <div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button></div>
</div>
<div class="card-body">
<?php
$ManagerMonthlyExpense = Container("ManagerMonthlyExpense");
$ManagerMonthlyExpense->ManagerExpenseByCategory->Width = 550;
$ManagerMonthlyExpense->ManagerExpenseByCategory->Height = 500;
$ManagerMonthlyExpense->ManagerExpenseByCategory->setParameter("clickurl", "ManagerMonthlyExpense"); // Add click URL
$ManagerMonthlyExpense->ManagerExpenseByCategory->DrillDownUrl = ""; // No drill down for dashboard
$ManagerMonthlyExpense->ManagerExpenseByCategory->render("ew-chart-top");
?>
</div>
</div>
</div>
<div class="<?= $Dashboard2->ItemClassNames[6] ?>" style=' min-width: 1200px; min-height: 520px;'>
<div id="Item7" class="card">
<div class="card-header">
    <h3 class="card-title"><?= $Language->chartPhrase("UtilitiesExpense", "UtilitiesExpense", "ChartCaption") ?></h3>
    <div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button></div>
</div>
<div class="card-body">
<?php
$UtilitiesExpense = Container("UtilitiesExpense");
$UtilitiesExpense->UtilitiesExpense->Width = 1150;
$UtilitiesExpense->UtilitiesExpense->Height = 500;
$UtilitiesExpense->UtilitiesExpense->setParameter("clickurl", "UtilitiesExpense"); // Add click URL
$UtilitiesExpense->UtilitiesExpense->DrillDownUrl = ""; // No drill down for dashboard
$UtilitiesExpense->UtilitiesExpense->render("ew-chart-top");
?>
</div>
</div>
</div>
</div>
</div>
<!-- /.ew-dashboard -->
</div>
<!-- /.ew-report -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
