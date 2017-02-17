<?php

require_once "vendor/autoload.php";

use Doctrine\Instantiator\Instantiator;
use KrzysztofMazur\ObjectMapper\Builder\ObjectMapperBuilder;
use KrzysztofMazur\ObjectMapper\Integration\DoctrineInstantiatorAdapter;
use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldFactory;
use KrzysztofMazur\ObjectMapper\Mapping\Field\FieldsMatchmaker;
use KrzysztofMazur\ObjectMapper\Mapping\MappingRepository;
use KrzysztofMazur\ObjectMapper\Util\PropertyNameConverter;

$matchmaker = new FieldsMatchmaker(new PropertyNameConverter());
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

$mapper = ObjectMapperBuilder::create()
    ->setInitializer($instantiator)
    ->setRepository($repository)
    ->build();

$source = new SourceObject();
$source->setHeight(6);
$source->setWidth(7);

$target = $mapper->map($source, TargetObject::class);

var_dump($target);
