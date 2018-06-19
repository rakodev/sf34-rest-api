<?php

namespace AppBundle\Controller;


use AppBundle\Form\OfferForm;
use AppBundle\FormModel\Offer;
use AppBundle\Service\OfferApi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OfferController
 * @package AppBundle\Controller
 *
 * @Route("/offer", name="offer_")
 */
class OfferController extends Controller
{
    /**
     * @Route("/list/", name="list", methods={"GET"})
     * @param OfferApi $offerApi
     * @return Response
     * @throws \Exception
     */
    public function list(OfferApi $offerApi)
    {
        $offers = $offerApi->getList();

        return $this->render('@App/Offer/list.twig', ['offers' => $offers]);
    }

    /**
     * @Route("/detail/{id}/", name="detail", requirements={"id" = "\d+"}, methods={"GET"})
     * @param OfferApi $offerApi
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function detail(OfferApi $offerApi, int $id)
    {
        $data = $offerApi->getOne($id);
        $offer = new Offer();
        $offer->setData($data);
        $form = $this->createForm(OfferForm::class, $offer, [
            'action' => $this->generateUrl('offer_update', ['id' => $id])
        ]);
        return $this->render('@App/Offer/detail.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create/", name="create", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function create(Request $request, OfferApi $offerApi)
    {
        $offer = new Offer();

        $form = $this->createForm(OfferForm::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $offerCreated = $offerApi->post($data);
            if(!empty($offerCreated['id'])) {
                $this->addFlash(
                    'success',
                    'This offer has been created successfully'
                );
                return $this->redirectToRoute('offer_detail', ['id' => $offerCreated['id']]);
            }
            $this->addFlash(
                'error',
                implode(', ' , $offerCreated['validation_errors'])
            );
        }

        // render the form if it is the first request or if the validation failed
        return $this->render('@App/Offer/createForm.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update/{id}/", name="update", requirements={"id" = "\d+"}, methods={"POST"})
     * @param Request $request
     * @param OfferApi $offerApi
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function update(Request $request, OfferApi $offerApi, int $id)
    {
        $offer = new Offer();

        $form = $this->createForm(OfferForm::class, $offer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $offerUpdated = $offerApi->update($id, (array) $data);
            if(!empty($offerUpdated['id'])) {
                $this->addFlash(
                    'success',
                    'This offer has been updated successfully'
                );
                return $this->redirectToRoute('offer_detail', ['id' => $offerUpdated['id']]);
            }
            $this->addFlash(
                'error',
                implode(', ' , $offerUpdated['validation_errors'])
            );
        }
        // Redirect to the offer detail
        return $this->redirectToRoute('offer_detail', ['id' => $id]);
    }

    /**
     * @Route("/delete/{id}/", name="delete", requirements={"id" = "\d+"}, methods={"GET"})
     * @param OfferApi $offerApi
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function delete(OfferApi $offerApi, int $id)
    {
        $offerApi->delete($id);
        $this->addFlash(
            'success',
            'The number '.$id.' has been deleted successfully'
        );
        // Redirect to the offer list
        return $this->redirectToRoute('offer_list');
    }
}