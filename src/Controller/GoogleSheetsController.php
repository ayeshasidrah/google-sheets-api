<?php

namespace App\Controller;

use Google_Client;
use Google_Service_Sheets;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GoogleSheetsController extends AbstractController
{
    /**
     * @Route("/api/google-sheets", name="google_sheets")
     */
    public function index()
    {
        // Load the credentials from the JSON file
        $client = new Google_Client();
        $client->setAuthConfig(__DIR__ . '/../../credentials.json');
        $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);

        // Create a Sheets service
        $service = new Google_Service_Sheets($client);

        // Retrieve data from the Google Sheet
        $spreadsheetId = '1Qa1DraC5aQGIKzR23KRDkMWaWzYlmjTKxa5ZMgCkjmM';
        $range = 'Sheet1!A1:B5';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        // Return the data as JSON
        return new JsonResponse($values);
    }
}
