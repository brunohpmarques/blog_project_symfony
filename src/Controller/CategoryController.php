<?php
namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/categories", name="categories_")
 */
class CategoryController extends AbstractController
{
    private function toDto($category)
    {
        if(is_null($category)){
            return null;
        }

        $dto['id'] = $category->getId();
        $dto['name'] = $category->getName();

        return $dto;
    }

    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function list()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        $categoriesDto = array();
        foreach ($categories as $category){
            array_push($categoriesDto, $this->toDto($category));
        }

        return $this->json($categoriesDto);
    }

    /**
     * @Route("/{categoryId}", name="get", methods={"GET"})
     */
    public function detail($categoryId)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($categoryId);

        $categoryDto = $this->toDto($category);

        return $this->json($categoryDto);
    }

    /**
     * @Route("", name="create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $category = new Category();
        $category->setName($data['name']);

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($category);
        $doctrine->flush();

        return $this->json($this->toDto($category));
    }
}
