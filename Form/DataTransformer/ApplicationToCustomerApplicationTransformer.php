<?php

namespace CanalTP\SamCoreBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use CanalTP\SamCoreBundle\Entity\CustomerApplication;
use CanalTP\SamCoreBundle\Entity\Customer;
use CanalTP\SamCoreBundle\Entity\Application;
use CanalTP\NmmPortalBundle\Services\NavitiaTokenManager;

class ApplicationToCustomerApplicationTransformer implements DataTransformerInterface
{
    private $om;
    private $navitiaTokenManager;
    private $customerApplicationRepository;

    public function __construct(ObjectManager $om, NavitiaTokenManager $navitiaTokenManager)
    {
        $this->om = $om;
        $this->navitiaTokenManager = $navitiaTokenManager;
        $this->customerApplicationRepository = $om->getRepository('CanalTPSamCoreBundle:Customer');
    }

    private function createCustomerApplicationRelation(Customer $customer, Application $application)
    {
        $customerApplication = new CustomerApplication();

        $customerApplication->setCustomer($customer);
        $customerApplication->setApplication($application);
        $customerApplication->setToken(
            $this->navitiaTokenManager->generateToken()
        );
        $customerApplication->setIsActive(true);
        return ($customerApplication);
    }

    public function transform($customer)
    {
        if ($customer === null) {
            return ($customer);
        }
        $applications = new ArrayCollection();

        foreach ($customer->getActiveCustomerApplications() as $customerApplication) {
            $customerApplication->setIsActive(false);
            $applications->add($customerApplication->getApplication());
        }
        $customer->setApplications($applications);
        return $customer;
    }

    public function reverseTransform($customer)
    {
        if (!$customer) {
            return $customer;
        }
        $customerApplications = new ArrayCollection();

        $this->navitiaTokenManager->initUser($customer->getNameCanonical(), $customer->getEmail());
        $this->navitiaTokenManager->initInstanceAndAuthorizations($customer->getPerimeters());
        // TODO: clear all tokens
        // if ($customer->getId() && $customer == ...)
        // TODO: Delete token
        // $this->navitiaTokenManager->generateToken()
        foreach ($customer->getApplications() as $application) {
            $customerApplications->add(
                $this->createCustomerApplicationRelation(
                    $customer,
                    $application
                )
            );
        }
        $customer->setApplications($customerApplications);
        return $customer;
    }
}
