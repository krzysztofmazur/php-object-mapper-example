<?php

require_once "vendor/autoload.php";

use Doctrine\Instantiator\Instantiator;
use KrzysztofMazur\ObjectMapper\Intergration\DoctrineInstantiatorAdapter;
use KrzysztofMazur\ObjectMapper\Mapping\FieldFactory;
use KrzysztofMazur\ObjectMapper\Mapping\FieldsMatchmaker;
use KrzysztofMazur\ObjectMapper\Mapping\MappingRepository;
use KrzysztofMazur\ObjectMapper\Mapping\PropertyNameConverter;
use KrzysztofMazur\ObjectMapper\ObjectMapperBuilder;

$propertyConverter = new PropertyNameConverter();
$matchmaker = new FieldsMatchmaker($propertyConverter);
$instantiator = new DoctrineInstantiatorAdapter(new Instantiator());
$repository = new MappingRepository(
    [
        [
            'from' => SourceObject::class,
            'to' => TargetObject::class,
            'auto' => true,
            'fields' => [],
        ],
    ],
    new FieldFactory($instantiator),
    $matchmaker
);

$mapper = ObjectMapperBuilder::getInstance()
    ->setInitializer($instantiator)
    ->setRepository($repository)
    ->build();

$source = new SourceObject();
$source->setHeight(6);
$source->setWidth(7);

$target = $mapper->map($source, TargetObject::class);

var_dump($target);
