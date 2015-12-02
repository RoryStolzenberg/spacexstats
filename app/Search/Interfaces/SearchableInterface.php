<?php
namespace SpaceXStats\Search\Interfaces;

interface SearchableInterface
{
    public function getIndexName();

    public function getId();

    public function index();
}