<?php

namespace PHPMaker2022\efga_expense_system;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = 0)
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DATATYPE_DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DATATYPE_DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = 0)
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions
// Database Connecting event
function Database_Connecting(&$info)
{
    // Example:
    // var_dump($info);
    //if ($info["id"] == "DB" && IsLocal()) { // Testing on local PC
    //    $info["host"] = "locahost";
    //    $info["user"] = "root";
    //    $info["pass"] = "";
    //}

    // if (!IsLocal()) {
    // }
    $info["host"] = "localhost";
    $info["user"] = "admin";
    $info["pass"] = "bh2236";
    $info["db"] = "capstone";
}

// Database Connected event
function Database_Connected(&$conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

function MenuItem_Adding($item)
{
    //var_dump($item);
    // Return false if menu item not allowed
    return true;
}

function Menu_Rendering($menu)
{
    // Change menu items here
}

function Menu_Rendered($menu)
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

// Page Rendering event
function Page_Rendering()
{
    //Log("Page Rendering");
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// API Action event
function Api_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}

function calculateCashFloat($cashAdvance_id, $emp_exp_id, $amount) {
    $budget_money = ExecuteScalar("SELECT amount from cash_advance WHERE id = '$cashAdvance_id'");
    $calculation = $budget_money - $amount;
    $mysqlupdate = ExecuteStatement("UPDATE emp_expense SET cash_float = '$calculation' WHERE id = '$emp_exp_id'");
}

function getCashAdvanceAmount($budget_id, $cashAdvance_id) {
    $budget_money = ExecuteScalar("SELECT amount from budget WHERE id = '$budget_id'");
    $mysqlupdate = ExecuteStatement("UPDATE cash_advance SET amount = '$budget_money' WHERE id = '$cashAdvance_id'");
}

function settingEmployeeExpenseUsed($cashAdvance_id) {
    $mysqlupdate = ExecuteStatement("UPDATE cash_advance SET used = 1 WHERE id = '$cashAdvance_id'");
}

function settingEmployeeCategoryId($emp_exp_id, $cashAdvance_id) {
    $category = ExecuteScalar("SELECT expCategory_id FROM cash_advance WHERE id = '$cashAdvance_id'");
    $mysqlupdate = ExecuteStatement("UPDATE emp_expense SET expCategory_id = '$category' WHERE id = '$emp_exp_id'");
}

function settingRepairCount($machine_id) {
    if ($machine_id != null || $machine_id == 0) {
        $current_repairCount = ExecuteScalar("SELECT repairCount from machine WHERE id = '$machine_id'");
        $current_repairCount = $current_repairCount + 1;
        $mysqlupdate = ExecuteStatement("UPDATE machine SET repairCount = '$current_repairCount' WHERE id = '$machine_id'");
    }
}

function settingDateManExp($dateFrom, $category, $manExpenseCategory_id) {
    if($category == "3"){
        $mysqlupdate = ExecuteStatement("UPDATE man_expense SET date = '$dateFrom' WHERE id = '$manExpenseCategory_id'");
    }
}
