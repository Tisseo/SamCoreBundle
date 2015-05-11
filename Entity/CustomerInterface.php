<?php

namespace CanalTP\SamCoreBundle\Entity;

interface CustomerInterface
{
    public function getId();

    public function getIdentifier();
    public function setIdentifier($identifier);

    public function setName($name);
    public function getName();

    public function getNameCanonical();

    public function setLogoPath($logoPath);
    public function getLogoPath();

    public function setLocked($locked);
    public function getLocked();

    public function getCreated();
    public function getUpdated();

    public function setApplications($applications);
    public function addApplication($application);
    public function removeApplication($application);
    public function getApplications();
    public function getActiveCustomerApplications();

    public function setUsers($users);
    public function addUser($user);
    public function removeUser($user);
    public function getUsers();
}
