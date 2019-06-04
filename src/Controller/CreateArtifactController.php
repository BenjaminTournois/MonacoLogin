<?php

namespace App\Controller;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;

function CreateArtifact($id, $idd, $iddd){
    $client = new Client();
    $res = $client->request('GET', 'https://agile-team.agencecdigital.com/api/trackers/'.$id.'/artifacts', [
        'auth' => ['benjamin', 'tournois']]);

    $a = json_decode($res->getBody());
    if (!empty($a)){
        foreach ($a as $key) {
            $b[$key->title] = $key->id;
        }
        return $b;
    }
        return null;
};

class CreateArtifactController extends AbstractController
{
    /**
     * @Route("/create/artifact", name="create_artifact")
     */
    public function index()
    {
        return $this->render('create_artifact/index.html.twig', [
            'controller_name' => 'CreateArtifactController',
        ]);
    }
}
