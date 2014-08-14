<?php

namespace CanalTP\SamCoreBundle\Controller;

use CanalTP\SamCoreBundle\Entity\Client as ClientEntity;
use CanalTP\SamCoreBundle\Entity\Perimeter;
use Symfony\Component\HttpFoundation\Request;
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

        $form = $this->createForm(new ClientType(), $client);

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
        $form = $this->createForm(new ClientType());

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
}
