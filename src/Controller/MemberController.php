<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;


function getAllTrackers(){
    $client = new Client();
    $res = $client->request('GET', 'https://agile-team.agencecdigital.com/api/projects/102/trackers', [
        'auth' => ['benjamin', 'tournois']]);
    $a = json_decode($res->getBody());
    foreach ($a as $key) {
        $b[$key->label] = $key->id;
    }
    return $b;
};

/** @Route("/member") */
class MemberController extends Controller {

    /**
     * @Route("/")
     */
    public function index(Request $request) {
        $abc = getAllTrackers();
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('artifacts'))
            ->setMethod('POST')
            ->add('Trackers', ChoiceType::class, [
                'choices'  => $abc])
            ->add('save', SubmitType::class, ['label' => 'Select'])
            ->getForm();
            
        return $this->render('member/index.html.twig', [
            'form' => $form->createView() 
        ]);
        //['mainNavMember'=>true, 'title'=>'Espace Membre']);
    }

}