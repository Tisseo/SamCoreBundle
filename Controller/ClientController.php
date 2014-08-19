<?php

namespace CanalTP\SamCoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use CanalTP\SamCoreBundle\Entity\Client as ClientEntity;
use CanalTP\SamCoreBundle\Entity\Perimeter;
use CanalTP\SamCoreBundle\Form\Type\ClientType;

/**
 * Description of ClientController
 *
 * @author Kévin ZIEMIANSKI <kevin.ziemianski@canaltp.fr>
 */
class ClientController extends AbstractController
{
    public function listAction()
    {
        $this->isGranted('BUSINESS_MANAGE_CLIENT');

        $clients = $this->getDoctrine()
            ->getManager()
            ->getRepository('CanalTPSamCoreBundle:Client')
            ->findAll();

        return $this->render(
            'CanalTPSamCoreBundle:Client:list.html.twig',
            array(
                'clients' => $clients
            )
        );
    }

    public function editAction(Request $request, ClientEntity $client = null)
    {
        $this->isGranted(array('BUSINESS_MANAGE_CLIENT', 'BUSINESS_CREATE_CLIENT'));

        $coverage = $this->get('sam_navitia')->getCoverages();
        $form = $this->createForm(new ClientType($coverage->regions, $this->get('sam_navitia')), $client);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('sam_core.client')->save($form->getData());
            $this->addFlashMessage('success', 'client.flash.edit.success');

            return $this->redirect($this->generateUrl('sam_client_list'));
        }

        return $this->render(
            'CanalTPSamCoreBundle:Client:form.html.twig',
            array(
                'title' => 'client.edit.title',
                'logoPath' => $client->getWebLogoPath(),
                'form' => $form->createView()
            )
        );
    }

    public function newAction(Request $request)
    {
        $this->isGranted('BUSINESS_CREATE_CLIENT');

        $coverage = $this->get('sam_navitia')->getCoverages();
        $form = $this->createForm(new ClientType($coverage->regions, $this->get('sam_navitia')));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('sam_core.client')->save($form->getData());
            $this->addFlashMessage('success', 'client.flash.creation.success');

            return $this->redirect($this->generateUrl('sam_client_list'));
        }

        return $this->render(
            'CanalTPSamCoreBundle:Client:form.html.twig',
            array(
                'logoPath' => null,
                'title' => 'client.new.title',
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
        $response = new JsonResponse();
        $navitia = $this->get('sam_navitia');
        $status = Response::HTTP_FORBIDDEN;

        $navitia->setToken($token);
        try {
            $networks = $navitia->getNetworks($externalCoverageId);
        } catch(\Navitia\Component\Exception\NavitiaException $e) {
            $response->setData(array('status' => $status));
            $response->setStatusCode($status);
            
            return $response;
        }

        if (isset($networks[$externalNetworkId])) {
            $status = Response::HTTP_OK;
        }
        
        $response->setData(array('status' => $status));
        $response->setStatusCode($status);

        return $response;
    }
}
