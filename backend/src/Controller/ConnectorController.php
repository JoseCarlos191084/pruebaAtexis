<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ConnectorType;
use Symfony\Component\HttpClient\HttpClient;


class ConnectorController extends AbstractController
{
    #[Route('/connector', name: 'app_connector')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ConnectorType::class);

        $form->handleRequest($request);
        $dataAirport = "" ;

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
        
            $airport = $data['airport'];
            $begin = $data['begin']->getTimestamp();
            $end = $data['end']->getTimestamp();
           
            $response = $this->getInfoFly($airport, $begin,$end);
        }

        return $this->render('connector/index.html.twig', [
            'form' => $form->createView(),
            'dataAirport' => $dataAirport
        ]);
    }

    public function getInfoFly($airport,$begin,$end): array{
        
        try {

            $httpClient = HttpClient::create();
  
            $response = $httpClient->request('GET', 'https://opensky-network.org/api/flights/arrival', [

                'query' => [
                    'airport' => $airport,
                    'begin' => $begin,
                    'end' => $end,
                ],
            ]);
        
            $content = $response->getContent();
        
            $content = $content->toArray();

            return $content;

        } catch (\Exception $e) {

            $exception = [
                'exception' => $e->getMessage()
            ];

            return $exception;
        }
    }
}
