<?php

namespace CanalTP\SamCoreBundle\Controller;

use CanalTP\SamCoreBundle\Entity\Client as ClientEntity;
use CanalTP\SamCoreBundle\Form\Model\ClientModel;
use Symfony\Component\HttpFoundation\Request;
use CanalTP\SamCoreBundle\Form\Type\ClientType;

/**
 * Description of ClientController
 *
 * @author Kévin ZIEMIANSKI <kevin.ziemianski@canaltp.fr>
 */
class ClientController extends AbstractController
{
    public function indexAction()
    {
        $clients = $this->getDoctrine()
            ->getManager()
            ->getRepository('CanalTPSamCoreBundle:Client')
            ->findAll();
        
        return $this->render(
            'CanalTPSamCoreBundle:Client:index.html.twig',
            array(
                'clients' => $clients
            )
        );
    }
    
    public function editAction(Request $request, ClientEntity $client = null)
    {
        $clientModel = $this->getModel($client);
        
        $form = $this->createForm(new ClientType(), $clientModel);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $data = $form->getData();
         
            $client = $this->updateClient($client, $data);
            
            $this->getDoctrine()->getManager()->flush($client);
            $this->addFlashMessage('success', 'client.flash.edit.success');
            
            return $this->redirect($this->generateUrl('sam_client_list'));
        }
        
        return $this->render(
            'CanalTPSamCoreBundle:Client:form.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }
    
    public function newAction(Request $request)
    {
        $form = $this->createForm(new ClientType());
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $data = $form->getData();
         
            $client = $this->updateClient(new ClientEntity(), $data);
            
            $this->getDoctrine()->getManager()->persist($client);
            $this->getDoctrine()->getManager()->flush($client);
            $this->addFlashMessage('success', 'client.flash.creation.success');
            
            return $this->redirect($this->generateUrl('sam_client_list'));
        }
        
        return $this->render(
            'CanalTPSamCoreBundle:Client:form.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    protected function getModel(ClientEntity $client)
    {
        $clientModel = new ClientModel();
        $clientModel->setName($client->getName());
        $clientModel->setNavitiaToken($client->getNavitiaToken());
        
        return $clientModel;
    }
    
    protected function updateClient(ClientEntity $clientToUpdate, ClientModel $clientUpToDate)
    {
        $clientToUpdate->setName($clientUpToDate->getName());
        $clientToUpdate->setNavitiaToken($clientUpToDate->getNavitiaToken());
        $clientToUpdate->setLastModificationDateTime(new \DateTime());
        
        return $clientToUpdate;
    }
}
