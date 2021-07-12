<?php


namespace App\Controller\admin;


use App\Repository\TagRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminTagController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
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

    /**
     * @Route("/admin/tags/update/{id}", name="admin_tag_update")
     */
    public function updateTag($id, TagRepository $tagRepository, EntityManagerInterface $entityManager)
    {
        //Je fais une querie by 'id' que je stock dans ma variable $tag
        $tag = $tagRepository->find($id);

        // j'utilise les setters de l'entité tag pour renseigner les valeurs des colonnes
        $tag->setTitle('Nouveau Tag');

        //un persist pour une pré-sauvegarde
        $entityManager->persist($tag);
        //un flush pour l'envoi en bdd
        $entityManager->flush();

        return $this->redirectToRoute('admin_tag_List');

    }

}