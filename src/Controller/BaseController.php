<?php

namespace App\Controller;

use App\Component\Constant\ModelType;
use App\Component\Serializer\CustomSerializer;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends FOSRestController
{
    /**
     * @param Request $request
     * @param $modelType
     * @return Response
     */
    public function getAllAction(Request $request, $modelType)
    {
//        $this->denyAccessUnlessGranted('ROLE_USER');

        if($modelType === ModelType::LIEU) {
            $suffixe = 'x';
        }
        else {
            $suffixe = 's';
        }

        return $this->createApiResponse(
            $this->getHandler()->getConceptsCollection($request, $modelType),
            200,
            $this->getHandler()->generateUrl('get_'.$modelType.$suffixe, [], $request->query->get('page', 1))
        );
    }

    /**
     * @param $id
     * @param $modelType
     * @return Response
     */
    public function getAction($id, $modelType)
    {
            $io = $this->getHandler()->getEntity($id, $modelType);

        return $this->createApiResponse(
            $io,
            200,
            $this->getHandler()->generateSimpleUrl('get_'.$modelType, [$modelType.'Id' => $id])
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @param $modelType
     * @return Response
     */
    public function putAction(Request $request,$id, $modelType)
    {
        $data = $this->getData($request);
        $io = $this->getHandler()->putEntity($id, $data, $modelType);

        return $this->createApiResponse(
            $io,
            202,
            $this->getHandler()->generateSimpleUrl('get_'.$modelType, [$modelType.'Id' => $io->getId()])
        );
    }

    /**
     * @param $request
     * @param $modelType
     * @return JsonResponse|Response
     */
    public function postAction($request, $modelType)
    {
        $data = $this->getData($request);

        $classname = 'App\Component\IO\\'.ucfirst($modelType).'IO';
        $io = new $classname();

        $formType = 'App\Form\\'.ucfirst($modelType).'Type';

        $form = $this->createForm($formType, $io);
        $form->submit($data);

        if(!$form->isValid()) {
            return $this->createValidationErrorResponse($form);
        }

        $io = $this->getHandler()->postEntity($data, $modelType);

        return $this->createApiResponse(
            $io,
            200,
            $this->getHandler()->generateSimpleUrl('get_'.$modelType, [$modelType.'Id' => $io->getId()])
        );
    }

    /**
     * @param $id
     * @param $modelType
     * @return mixed
     */
    public function deleteAction($id, $modelType)
    {
        return $this->getHandler()->deleteEntity($id, $modelType);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return json_decode($request->getContent(), true);
    }

    /**
     * @param $data
     * @param int $statusCode
     * @param null $url
     * @return Response
     */
    public function createApiResponse($data, $statusCode = 200, $url = null)
    {
        $response = new Response($this->getSerializer()->serialize($data));
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($statusCode);

        if (isset($url)) {
            $response->headers->set('Location', $url);
        }

        return $response;
    }

    /**
     * @return CustomSerializer
     */
    public function getSerializer()
    {
        return new CustomSerializer();
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    protected function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }

    /**
     * @param FormInterface $form
     * @return JsonResponse
     */
    protected function createValidationErrorResponse(FormInterface $form)
    {
        $errors = $this->getErrorsFromForm($form);

        $data = [
            'type' => 'validation_error',
            'title' => 'There was a validation error',
            'errors' => $errors
        ];
        return new JsonResponse($data, 400);
    }

}
