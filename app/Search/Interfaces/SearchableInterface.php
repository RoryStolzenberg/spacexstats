<?php
namespace SpaceXStats\Search\Interfaces;

interface SearchableInterface
{
    public function getIndexType();

    public function getId();

    public function index();

    public function getMapping();
}