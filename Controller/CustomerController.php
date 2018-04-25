<?php

namespace CanalTP\SamCoreBundle\Controller;

use CanalTP\SamCoreBundle\Exception\CustomerEventException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use CanalTP\SamCoreBundle\Entity\Customer as CustomerEntity;
use CanalTP\SamCoreBundle\Entity\Application as ApplicationEntity;
use CanalTP\SamCoreBundle\Event\SamCoreEvents;
use CanalTP\SamCoreBundle\Event\CustomerEvent;
use CanalTP\SamCoreBundle\Entity\Perimeter;
use CanalTP\SamCoreBundle\Form\Type\CustomerType;
use Doctrine\Common\Collections\Criteria;

/**
 * Description of CustomerController
 *
 * @author Kévin ZIEMIANSKI <kevin.ziemianski@canaltp.fr>
 */
class CustomerController extends AbstractController
{
    // TODO duplicate with  nmm portal controller
    public function listAction()
    {
        $this->checkPermission('BUSINESS_MANAGE_CLIENT');

        $customers = $this->getDoctrine()
            ->getManager()
            ->getRepository('CanalTPSamCoreBundle:Customer')
            ->findAll();

        return $this->render(
            'CanalTPSamCoreBundle:Customer:list.html.twig',
            array(
                'customers' => $customers
            )
        );
    }

    private function dispatchEvent($form, $type)
    {
        $event = new CustomerEvent($form->getData());
        try {
            $this->get('event_dispatcher')->dispatch($type, $event);
        } catch (CustomerEventException $e) {
            $this->addFlashMessage('danger', $e->getMessage());
            return (false);
        }
        return (true);
    }

    // TODO Duplicate with nmm portal controller
    public function editAction(Request $request, CustomerEntity $customer = null)
    {
        $this->checkPermission(array('BUSINESS_MANAGE_CLIENT', 'BUSINESS_CREATE_CLIENT'));

        $coverage = $this->get('sam_navitia')->getCoverages();
        $form = $this->createForm(CustomerType::class, $customer, [
            'init' => [
                'em' => $this->getDoctrine()->getManager(),
                'coverage' => $coverage->regions,
                'navitia' => $this->get('sam_navitia'),
                'applicationsTransformer' => $this->get('sam_core.customer.application.transformer'),
                'applicationsTransformerWithToken' => $this->get('nmm.customer.application.transformer_with_token'),
                'withTyr' => ($this->get('service_container')->getParameter('nmm.tyr.url') != null)
            ]
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $this->dispatchEvent($form, SamCoreEvents::EDIT_CLIENT)) {
            $this->get('sam_core.customer')->save($form->getData());
            $this->addFlashMessage('success', 'customer.flash.edit.success');

            return $this->redirect($this->generateUrl('sam_customer_list'));
        }

        return $this->render(
            'CanalTPSamCoreBundle:Customer:form.html.twig',
            array(
                'title' => 'customer.edit.title',
                'logoPath' => $customer->getWebLogoPath(),
                'form' => $form->createView()
            )
        );
    }

    // TODO duplicate with nmm portal controller
    public function newAction(Request $request)
    {
        $this->checkPermission('BUSINESS_CREATE_CLIENT');

        $coverage = $this->get('sam_navitia')->getCoverages();
        $form = $this->createForm(CustomerType::class, null, [
            'init' => [
                'em' => $this->getDoctrine()->getManager(),
                'coverage' => $coverage->regions,
                'navitia' => $this->get('sam_navitia'),
                'applicationsTransformer' => $this->get('sam_core.customer.application.transformer'),
                'applicationsTransformerWithToken' => $this->get('nmm.customer.application.transformer_with_token'),
                'withTyr' => ($this->get('service_container')->getParameter('nmm.tyr.url') != null)
            ]
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $this->dispatchEvent($form, SamCoreEvents::CREATE_CLIENT)) {
            $this->get('sam_core.customer')->save($form->getData());
            $this->addFlashMessage('success', 'customer.flash.creation.success');

            return $this->redirect($this->generateUrl('sam_customer_list'));
        }

        return $this->render(
            'CanalTPSamCoreBundle:Customer:form.html.twig',
            array(
                'logoPath' => null,
                'title' => 'customer.new.title',
                'form' => $form->createView()
            )
        );
    }

    // TODO: Duplicate in CanalTPMttBundle:Network (controller)
    public function byCoverageAction($externalCoverageId)
    {
        $response = new JsonResponse();
        $navitia = $this->get('sam_navitia');
        $nmmToken = $this->get('service_container')->getParameter('nmm.navitia.token');
        $status = Response::HTTP_FORBIDDEN;

        $navitia->setToken($nmmToken);
        try {
            $networks = $navitia->getNetworks($externalCoverageId);
            asort($networks);
        } catch(\Navitia\Component\Exception\NavitiaException $e) {
            $response->setData(array('status' => $status));
            $response->setStatusCode($status);

            return $response;
        }

        $status = Response::HTTP_OK;
        $response->setData(
            array(
                'status' => $status,
                'networks' => $networks
            )
        );
        $response->setStatusCode($status);

        return $response;
    }

    public function checkAllowedToNetworkAction($externalCoverageId, $externalNetworkId, $token)
    {
        return;
    }
}
