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

function AddComment($id, $comment, $field , $value){
    $client = new Client();
    $options= array(
        'headers' => array( 
            'X-Auth-AccessKey' => 'tlp-k1-5.d1d0dd5a9b907c5b730caaf616f9715c43fd53cbcbd7cd8191f238d74db588d8' 
        ),
    'form_params' => 
    array (
        'values' => array (
            array(
                'field_id' => $field,
                'value' => $value
                )
            ),
        'comment' => array(
            "body" => $comment,
            "format" => "Text"
            )
        )
    );

    $res = $client->request('PUT', 'https://agile-team.agencecdigital.com/api/artifacts/'.$id, $options);
    return $res;
};

class CreateArtifactController extends AbstractController
{
    /**
     * @Route("/create/artifact", name="create_artifact")
     */
    public function index(Request $request)
    {
        $a = $request->request->get('form');
        AddComment($a['ArtifactId'],$a['Comment'], $a['FieldID'], $a['Label']);
        return $this->render('create_artifact/index.html.twig');
    }
}
