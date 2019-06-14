<?php

namespace App\Controller;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;

function getArtifact($artifactId){
    $client = new Client();
    $res = $client->request('GET', 'https://agile-team.agencecdigital.com/api/artifacts/'.$artifactId, [
        'headers' => array(
            'X-Auth-AccessKey' => 'tlp-k1-5.d1d0dd5a9b907c5b730caaf616f9715c43fd53cbcbd7cd8191f238d74db588d8'
        )]);
    $a = json_decode($res->getBody());
    $b["Summary"] = $a->values[2]->value;
    $b["Submited_by"] = $a->submitted_by_user->real_name;
    $b["Artifact_Id"] = $a->id;
    $b["Field"] = $a->values[2]->field_id;
    $b["Label"] = $a->values[2]->value;
    return $b;
}

function getAllComment($artifactId){
    $client = new Client();
    $res = $client->request('GET', 'https://agile-team.agencecdigital.com/api/artifacts/'.$artifactId.'/changesets?fields=comments&limit=20', [
        'headers' => array(
            'X-Auth-AccessKey' => 'tlp-k1-5.d1d0dd5a9b907c5b730caaf616f9715c43fd53cbcbd7cd8191f238d74db588d8'
        )]);
    $a = json_decode($res->getBody());
    if (!empty($a)){
        foreach ($a as $key) {
            $b[$key->id] = $key->last_comment->body;
        }
        return($b);
    }
        return null;
}

class ArtifactController extends AbstractController
{
    /**
     * @Route("/artifact", name="artifact")
     */
    public function index(Request $request)
    {
        $a = $request->request->get('form');
        $b = getArtifact($a['Artifacts']); 
        $c = getAllComment($a['Artifacts']);

        $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('create_artifact'))
        ->setMethod('POST')
        ->add('Comment', TextareaType::class, [
            'attr' => ['class' => 'tinymce']])
        ->add('ArtifactId', HiddenType::class, [
                'data' => $b["Artifact_Id"]])
        ->add('FieldID', HiddenType::class, [
            'data' => $b["Field"]])
        ->add('Label', HiddenType::class, [
            'data' => $b["Label"]])
        ->add('save', SubmitType::class, ['label' => 'Submit'])
        ->getForm();

        return $this->render('artifact/index.html.twig', [
            'controller_name' => 'ArtifactController',
            'summary' => $b["Summary"],
            'submited_by' => $b["Submited_by"],
            'artifact_id' => $b["Artifact_Id"],             
            'form' => $form->createView(),
            'comments' => $c,
        ]);
    }
}
