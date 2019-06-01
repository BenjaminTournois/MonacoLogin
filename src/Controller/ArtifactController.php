<?php

namespace App\Controller;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

function getArtifact($artifactId){
    $client = new Client();
    $res = $client->request('GET', 'https://agile-team.agencecdigital.com/api/artifacts/'.$artifactId, [
        'auth' => ['benjamin', 'tournois']]);
    $a = json_decode($res->getBody());
    $b["Summary"] = $a->values[2]->value;
    $b["Submited_by"] = $a->submitted_by_user->real_name;
    $b["Artifact_Id"] = $a->id;
    return $b;
}

class ArtifactController extends AbstractController
{
    /**
     * @Route("/artifact", name="artifact")
     */
    public function index(Request $request)
    {
        $a = $request->request->get('form');
        $b = getArtifact($a['Artifact']);    
        
        return $this->render('artifact/index.html.twig', [
            'controller_name' => 'ArtifactController',
            'summary' => $b["Summary"],
            'submited_by' => $b["Submited_by"],
            'artifact_id' => $b["Artifact_Id"]
        ]);
    }
}
