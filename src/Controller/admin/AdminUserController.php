<?php


namespace App\Controller\admin;



use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{



    /**
     * @Route("/admin/user/insert", name="admin_user_Insert")
     */
    public function insertUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = new user();

        //on génère le formulaire en utilisant le gabarit + une instance de l'entité user
        $userForm = $this->createForm(UserType::class, $user);


        //On lie le formulaire aux données de POST(aux données envoyées au post)
        $userForm->handleRequest($request);


        //Si le formulaire est bien rempli et bien valide (tous les champs complet) alors
        //j'utilise la méthode persit & flush de l'entityManager pour flush en Bd.
        if ($userForm->isSubmitted() && $userForm->isValid()) {
//            on récupère le role que l'on hardcode en admin_user pour le moment
            $user->setRoles(['ADMIN_USER']);

            $plainPassword = $userForm->get('password')->getData();
            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

                $entityManager->persist($user);
                $entityManager->flush();
            $this->addFlash('success', 'Votre compte a bien était créé');

            //Je redirige vers la page user_list
            return $this->redirectToRoute('admin_article_List');
        }
        return $this->render('admin/admin_user_insert.html.twig', [
            'userForm' => $userForm->createView()
        ]);
    }
}




