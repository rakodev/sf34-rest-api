<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Offer;
use AppBundle\Service\FormError;
use AppBundle\Form\OfferForm;
use AppBundle\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class OfferController
 * @package AppBundle\Controller
 *
 * @Route(name="offer_")
 */
class OfferController extends Controller
{
    /**
     *
     * Create an offer.
     *
     * Create a new offer.
     *
     * @Route("/offer", name="create", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns created offer detail",
     *     @SWG\Schema(
     *         type="array",
     *          @Model(type=AppBundle\Entity\Offer::class)
     *     )
     * )
     * @SWG\Response(
     *     response="400",
     *     description="Returned on a missing request parameter"
     * )
     * @SWG\Parameter(
     *     name="title",
     *     in="formData",
     *     type="string",
     *     description="Offer title",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="description",
     *     in="formData",
     *     type="string",
     *     description="Offer description",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     type="string",
     *     description="Offer user email",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="image_url",
     *     in="formData",
     *     type="string",
     *     description="Offer image URL",
     *     required=true
     * )
     * @SWG\Tag(name="Offer")
     * @param Request $request
     * @return JsonResponse
     */
    public function postOffer(Request $request)
    {
        $offer = new Offer();
        $form = $this->createForm(OfferForm::class, $offer, ['required' => true]);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            $formError = new FormError($form);
            return new JsonResponse($formError->getErrorDetails(), 400);
        }

        $formData = $form->getData();

        try {
            /** @var OfferRepository $repository */
            $repository = $this->getDoctrine()->getRepository(Offer::class);
            $offer = $repository->createOffer($formData);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 1, 'form' => $formData, 'message' => $e->getPrevious()->getMessage()], 400);
        }

        return new JsonResponse($offer);
    }

    /**
     * List all the offer.
     *
     * Maximum items per request: 20.
     *
     * @Route("/offers", name="list_page", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns offers list",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Offer::class))
     *     )
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="Offer page",
     *     required=false
     * )
     * @SWG\Tag(name="Offer")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOffers(Request $request)
    {
        $page = $request->query->getInt('page', 1);
        /** @var OfferRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Offer::class);
        $offers = $repository->getOffers($page, 20);
        return new JsonResponse($offers);

    }

    /**
     * List an offer.
     *
     * Get an offer details.
     *
     * @Route("/offers/{id}", name="get", requirements={"id" = "\d+"}, methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns an offer detail",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Offer::class))
     *     )
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="Offer id"
     * )
     * @SWG\Tag(name="Offer")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getOffer(int $id)
    {
        /** @var OfferRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Offer::class);
        $offer = $repository->getOffer($id);
        return new JsonResponse($offer);
    }

    /**
     * Update an offer.
     *
     * Update an offer details.
     *
     * @Route("/offer/{id}", name="update", requirements={"id" = "\d+"}, methods={"PUT", "PATCH"})
     * @SWG\Put(
     *     path="/offer/{id}",
     *     summary="Fully update an offer details.",
     *     description="All fields are required",
     *     tags={"Offer"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="string",
     *          description="Offer id",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="title",
     *          in="formData",
     *          type="string",
     *          description="Offer title",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="description",
     *          in="formData",
     *          type="string",
     *          description="Offer description",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="email",
     *          in="formData",
     *          type="string",
     *          description="Offer user email",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="image_url",
     *          in="formData",
     *          type="string",
     *          description="Offer image URL",
     *          required=true,
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Returns updated offer detail. If you use PUT method you need to provide all the fields, is you use PATCH method you can provide only the field you want to update.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=Offer::class))
     *          )
     *      ),
     *      @SWG\Response(
     *          response="400",
     *          description="Returned on a missing request parameter"
     *      ),
     * )
     * @SWG\Patch(
     *     path="/offer/{id}",
     *     summary="Partially update an offer details.",
     *     description="All fields are required",
     *     tags={"Offer"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="string",
     *          description="Offer id",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="title",
     *          in="formData",
     *          type="string",
     *          description="Offer title",
     *          required=false,
     *      ),
     *      @SWG\Parameter(
     *          name="description",
     *          in="formData",
     *          type="string",
     *          description="Offer description",
     *          required=false,
     *      ),
     *      @SWG\Parameter(
     *          name="email",
     *          in="formData",
     *          type="string",
     *          description="Offer user email",
     *          required=false,
     *      ),
     *      @SWG\Parameter(
     *          name="image_url",
     *          in="formData",
     *          type="string",
     *          description="Offer image URL",
     *          required=false,
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Returns updated offer detail. PATCH method you can provide only the field you want to update.",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=Offer::class))
     *          )
     *      ),
     *      @SWG\Response(
     *          response="400",
     *          description="Returned on a missing request parameter"
     *      ),
     * )
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function updateOffer(Request $request, int $id)
    {
        $allFieldRequired = $request->isMethod('put') ? true : false;
        $validationGroups = ($allFieldRequired) ? ['PUT'] : ['PATCH'];
        $params = json_decode($request->getContent(), true);

        /** @var OfferRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Offer::class);
        $offer = $repository->findOneBy(['id' => $id]);

        if (!($offer instanceof Offer)) {
            return new JsonResponse(['error' => 1, 'form' => $params, 'message' => 'Offer with ID: ' . $id . ' is unavailable'], 400);
        }

        $form = $this->createForm(OfferForm::class, $offer, ['required' => $allFieldRequired, 'validation_groups' => $validationGroups]);
        $form->submit($params, $allFieldRequired);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $formError = new FormError($form);
            return new JsonResponse($formError->getErrorDetails(), 400);
        }

        $formData = $form->getData();

        try {
            /** @var OfferRepository $repository */
            $repository = $this->getDoctrine()->getRepository(Offer::class);
            $offer = $repository->updateOffer($formData);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 1, 'form' => $offer, 'message' => $e->getPrevious()->getMessage()], 400);
        }

        return new JsonResponse($offer);
    }

    /**
     * Delete an offer.
     *
     * Delete an offer.
     *
     * @Route("/offer/{id}", name="delete", requirements={"id" = "\d+"}, methods={"DELETE"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns true on success or false on fail",
     *     @SWG\Schema(
     *         type="boolean"
     *     )
     * )
     * @SWG\Response(
     *     response="400",
     *     description="Returned if we can't delete the offer or if it's already deleted"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="Offer id"
     * )
     * @SWG\Tag(name="Offer")
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteOffer(int $id)
    {
        /** @var OfferRepository $repository */
        $repository = $this->getDoctrine()->getRepository(Offer::class);
        $isDeleted = $repository->deleteOffer($id);
        return new JsonResponse([], ($isDeleted) ? 200 : 400);

    }
}