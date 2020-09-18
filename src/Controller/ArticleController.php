<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/articles", name="articles_")
 */
class ArticleController extends AbstractController
{

    private function toUserDto($user)
    {
        $dto['id'] = $user->getId();
        $dto['name'] = $user->getName();
        $dto['email'] = $user->getEmail();

        return $dto;
    }

    private function toCategoryDto($category)
    {
        $dto['id'] = $category->getId();
        $dto['name'] = $category->getName();

        return $dto;
    }

    private function toArticleDto($article)
    {
        if(is_null($article)){
            return null;
        }

        $dto['id'] = $article->getId();
        $dto['title'] = $article->getTitle();
        $dto['content'] = $article->getContent();
        $dto['image'] = $article->getImage();
        $dto['createdAt'] = $article->getCreatedAt();
        $dto['updatedAt'] = $article->getUpdatedAt();
        $dto['author'] = $this->toUserDto($article->getAuthor());
        $dto['category'] = $this->toCategoryDto($article->getCategory());

        return $dto;
    }

    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function list()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        $articlesDto = array();
        foreach ($articles as $article){
            array_push($articlesDto, $this->toArticleDto($article));
        }

        return $this->json($articlesDto);
    }

    /**
     * @Route("/{articleId}", name="get", methods={"GET"})
     */
    public function detail($articleId)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($articleId);

        $articleDto = $this->toArticleDto($article);

        return $this->json($articleDto);
    }

    /**
     * @Route("", name="create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $author = $this->getDoctrine()->getRepository(User::class)->find($data['authorId']);
        $category = $this->getDoctrine()->getRepository(Category::class)->find($data['categoryId']);

        $article = new Article();
        $article->setTitle($data['title']);
        $article->setContent($data['content']);
        $article->setImage($data['image']);
        $article->setCreatedAt(new \DateTime());
        $article->setUpdatedAt($article->getCreatedAt());
        $article->setAuthor($author);
        $article->setCategory($category);

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($article);
        $doctrine->flush();

        return $this->json($this->toArticleDto($article));
    }
}
