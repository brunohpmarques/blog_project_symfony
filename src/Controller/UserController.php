<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/users", name="users_")
 */
class UserController extends AbstractController
{
    private function toDto($user)
    {
        if(is_null($user)){
            return null;
        }

        $dto['id'] = $user->getId();
        $dto['name'] = $user->getName();
        $dto['email'] = $user->getEmail();

        return $dto;
    }

    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function list()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $usersDto = array();
        foreach ($users as $user){
            array_push($usersDto, $this->toDto($user));
        }

        return $this->json($usersDto);
    }

    /**
     * @Route("/{userId}", name="get", methods={"GET"})
     */
    public function detail($userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($userId);

        $userDto = $this->toDto($user);

        return $this->json($userDto);
    }

    /**
     * @Route("", name="create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword(md5($data['password'])); //TODO change to other encrypt

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($user);
        $doctrine->flush();

        return $this->json($this->toDto($user));
    }
}
