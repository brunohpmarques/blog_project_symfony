<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/version", name="version", methods={"GET"})
     */
    public function getVersion()
    {
        return $this->json([
            "apiVersion" => "0.0.1"
        ]);
    }
}
