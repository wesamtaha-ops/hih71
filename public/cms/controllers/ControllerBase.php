<?php

namespace PHPMaker2023\hih71;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;

/**
 * Controller base class
 */
class ControllerBase
{
    protected $container;

    // Constructor
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    // Run page
    protected function runPage(Request $request, Response $response, array $args, string $pageName, string $viewName = null, bool $useLayout = true): Response
    {
        global $RouteValues;

        // Route values
        // Note: $RouteValues[0] set up in PermissionMiddleWare
        $RouteValues = array_merge($RouteValues, $args, array_values($args));

        // Generate new CSRF token
        GenerateCsrf();

        // Create page
        $pageClass = PROJECT_NAMESPACE . $pageName;
        if (class_exists($pageClass)) {
            // Set up response object
            $GLOBALS["Response"] = &$response; // Note: global $Response does not work

            // Create page object
            $page = new $pageClass();
            $GLOBALS["Page"] = &$page;

            // Write header
            $cache = ($page->PageID != "preview") ? Config("CACHE") : false; // No cache for preview
            WriteHeader($cache);

            // Run the page
            $page->run();

            // Render page if not terminated
            if (!$page->isTerminated()) {
                $view = $this->container->get("view");
                if (
                    !$page->UseLayout || // No layout
                    property_exists($page, "IsModal") && $page->IsModal || // Modal
                    $request->getParam(Config("PAGE_LAYOUT")) !== null // Multi-Column List page
                ) { // Partial view
                    $useLayout = false;
                }
                if ($request->getParam("export") !== null && $request->getParam("custom") !== null) { // Export custom template
                    $useLayout = true; // Require scripts
                }
                if ($useLayout) {
                    $view->setLayout("layout.php");
                }

                // Render view with $GLOBALS
                $page->RenderingView = true;
                $template = ($page->View ?? $viewName ?? $pageName) . ".php"; // View
                $GLOBALS["Title"] ??= $page->Title; // Title
                try {
                    $response = $view->render($response, $template, $GLOBALS);
                } finally {
                    $page->RenderingView = false;
                    $page->terminate(); // Terminate page and clean up
                }
            }

            // Clean up temp folder if not add/edit/export
            if (
                property_exists($page, "TableName") && // Table/Report class
                !in_array($page->PageID, ["add", "register", "edit", "update"]) && // Not add/register/edit/update page
                !($page->PageID == "list" && $page->isAddOrEdit()) && // Not list page add/edit
                !(property_exists($page, "Export") && $page->Export != "" && $page->Export != "print" && $page->UseCustomTemplate) // Not export custom template
            ) {
                CleanUploadTempPaths(session_id());
            }
            return $response;
        }

        // Page not found
        throw new HttpNotFoundException($request);
    }

    // Run chart
    protected function runChart(Request $request, Response $response, array $args, string $pageName, string $chartVar): Response
    {
        global $RouteValues;

        // Route values
        // Note:
        // - $RouteValues[0] set up in PermissionMiddleWare
        // - $chartVar in Route(1)
        $RouteValues = array_merge($RouteValues, [$chartVar], $args, array_values($args));

        // Generate new CSRF token
        GenerateCsrf();

        // Create page
        $pageClass = PROJECT_NAMESPACE . $pageName;
        if (class_exists($pageClass)) {
            // Set up response object
            $GLOBALS["Response"] = &$response; // Note: global $Response does not work

            // Create page object
            $page = new $pageClass();
            $GLOBALS["Page"] = &$page;

            // Write header
            $cache = Config("CACHE"); // No cache for preview
            WriteHeader($cache);

            // Run the page
            $page->run();

            // Render chart
            if (property_exists($page, $chartVar)) {
                $chart = $page->$chartVar;

                // Output chart
                try {
                    $chartClass = ($chart->PageBreakType == "before") ? "ew-chart-bottom" : "ew-chart-top";
                    $chartWidth = $request->getQueryParam("width");
                    $chartHeight = $request->getQueryParam("height");
                    $html = $chart->render($chartClass, $chartWidth, $chartHeight);
                    Write($html);
                } finally {
                    $page->terminate(); // Terminate page and clean up
                }
            }
            return $response;
        }

        // Page not found
        throw new HttpNotFoundException($request);
    }
}
