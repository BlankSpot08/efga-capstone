<?php

namespace PHPMaker2022\efga_expense_system;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * ExpenseYesterday controller
 */
class ExpenseYesterdayController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ExpenseYesterdaySummary");
    }
}
