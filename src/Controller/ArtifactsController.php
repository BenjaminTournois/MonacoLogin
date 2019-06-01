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



function getAllArtifacts($id){
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

class ArtifactsController extends AbstractController
{
    /**
     * @Route("/artifacts", name="artifacts")
     */
    public function index(Request $request)
    {

    $a = $request->request->get('form');
    $b = getAllArtifacts($a['Trackers']);
    $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('artifact'))
        ->setMethod('POST')
        ->add('Artifacts', ChoiceType::class, [
            'choices'  => $b])
        ->add('save', SubmitType::class, ['label' => 'Select'])
        ->getForm();
    
        return $this->render('artifacts/index.html.twig',[
            'form' => $form->createView(),
            'b' => $b
        ]);
    }
}
