<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use App\Component\Handler\FictionHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class FictionController extends BaseController
{
    /**
     * @var string
     */
    public $modelType = ModelType::FICTION;


    /**
     * List all fictions.
     *
     *
     * @Rest\Get("/fictions", name="get_fictions")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns all fictions"
     * )
     * @SWG\Tag(name="fictions")
     */
    public function getFictions(Request $request): Response
    {
        return $this->createApiResponse(
            $this->getHandler($this->modelType)->getConceptsCollection($request, $this->modelType),
            200,
            $this->getHandler($this->modelType)->generateUrl('get_fictions', [], $request->query->get('page', 1))
        );
    }

    /**
     * @Rest\Get("fictions/{fictionId}", name="get_fiction")
     */
    public function getFiction($fictionId): Response
    {
        return $this->getAction($fictionId, $this->modelType);
    }

    /**
     * @Rest\Post("fictions", name="post_fiction")
     */
    public function postFiction(Request $request)
    {
        return $this->postAction($request, $this->modelType);
    }

    /**
     * @Rest\Put("fictions/{fictionId}", name="put_fiction")
     */
    public function putFiction(Request $request, $fictionId)
    {
        return $this->putAction($request, $fictionId, $this->modelType);
    }

    /**
     * @Rest\Delete("/fictions/{fictionId}",name="delete_fiction")
     */
    public function deleteFiction($fictionId)
    {
        return $this->deleteAction($fictionId, $this->modelType);
    }
}