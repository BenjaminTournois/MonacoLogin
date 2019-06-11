<?php

namespace App\Controller;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;

function getAllTrackerss(){
    $client = new Client();
    $res = $client->request('GET', 'https://agile-team.agencecdigital.com/api/projects/102/trackers', [
        'headers' => array(
            'X-Auth-AccessKey' => 'tlp-k1-5.d1d0dd5a9b907c5b730caaf616f9715c43fd53cbcbd7cd8191f238d74db588d8'
        )]);
    $a = json_decode($res->getBody());
    foreach ($a as $key) {
        $b[$key->label] = $key->id;
    }
    return $b;
};

// function CreateArtifact(){
//     $client = new Client();
//     $options= array(
//         [
//         'headers' => array(
//             'X-Auth-AccessKey' => 'tlp-k1-5.d1d0dd5a9b907c5b730caaf616f9715c43fd53cbcbd7cd8191f238d74db588d8'
//         )],
//         'form_params' => 
//         array (
//             'values' => array (
//                     'field_id' => 1,
//                     'value' => "Label"
//             ),
//         'comment' => array (
//             'body' => 'Deuxième commentaire',
//             //'post_processed_body' => 'string',
//             'format' => 'Text',
//             )
//         )
//     );

//       $res = $client->request('PUT', 'https://agile-team.agencecdigital.com/api/artifacts/17', $options);
// };

class CreateArtifactController extends AbstractController
{
    /**
     * @Route("/create/artifact", name="create_artifact")
     */
    public function index()
    {
        // CreateArtifact();
        $abc = getAllTrackerss();
        $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('artifact'))
        ->setMethod('POST')
        ->add('Tracker', ChoiceType::class, [
            'choices'  => $abc])
        ->add('Summary', TextareaType::class)
        ->add('save', SubmitType::class, ['label' => 'Add'])
        ->getForm();

        return $this->render('create_artifact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
