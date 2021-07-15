<?php


namespace App\Controller\admin;


use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminTagController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    //READ
    /**
     * @Route("/admin/tags", name="admin_tag_List")
     */
    public function tagList(TagRepository $tagRepository)
    {
        $tags = $tagRepository->findAll();

        return $this->render('admin/admin_tag_list.html.twig', [
            'tags'=>$tags
        ]);
    }

    /**
     * @Route("/admin/tags/delete/{id}", name="admin_tag_Delete")
     */
    public function deleteTag($id, TagRepository $TagRepository, EntityManagerInterface $entityManager)
    {
        $tag = $TagRepository->find($id);

        //une methode de la classe entityManager 'remove' qui prend la place de persist pour supprimer l'tag en bdd
        $entityManager->remove($tag);
        $entityManager->flush();

        return $this->redirectToRoute('admin_tag_List');
    }

    //Update
    /**
     * @Route("/admin/tags/update/{id}", name="admin_tag_update")
     */
    public function updateTag($id, TagRepository $tagRepository, EntityManagerInterface $entityManager)
    {
        //Je fais une querie by 'id' que je stock dans ma variable $tag
        $tag = $tagRepository->find($id);
        $tag = $this->createForm(TagType::class, $tag);

        // j'utilise les setters de l'entité tag pour renseigner les valeurs des colonnes(version hardcodée:
//        $tag->setTitle('Nouveau Tag');

        //un persist pour une pré-sauvegarde
        $entityManager->persist($tag);
        //un flush pour l'envoi en bdd
        $entityManager->flush();

        return $this->redirectToRoute('admin_tag_List');

    }

    //CREATE
    /**
     * @Route("/admin/tag/insert", name="admin_tag_Insert")
     */
    public function insertTag(Request $request, EntityManagerInterface $entityManager)
    {
        $tag = new Tag();

        //on génère le formulaire en utilisant le gabarit + une instance de l'entité Tag
        $tagForm = $this->createForm(TagType::class, $tag);

        //On lie le formulaire aux données de POST(aux données envoyées au post)
        $tagForm->handleRequest($request);


        //Si le formulaire est bien rempli et bien valide (tous les champs complet) alors
        //j'utilise la méthode persit & flush de l'entityManager pour flush en Bd.
        if ($tagForm->isSubmitted() && $tagForm->isValid()){
            $entityManager->persist($tag);
            $entityManager->flush();
            //Je redirige vers la page tag_list
            return $this->redirectToRoute('admin_tag_List');

        }

        return $this->render('admin/admin_tag_insert.html.twig', [
            'tagForm' => $tagForm->createView()
            //clef => variable
        ]);
    }


}