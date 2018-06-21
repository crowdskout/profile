<?php
use GraphQL\GraphQL;
use GraphQL\Utils\BuildSchema;

/**
 * Run this file to explore the schema using ChromeiQL
 * To run this file do the following:
 *
 * php -S localhost:8000 graphql.php
 *
 * Then, open ChromeiQL and set the url to http://localhost:8000
 */

require "vendor/autoload.php";

$scalars = require('php/scalars.php');
$typeConfigDecorator = function($typeConfig, $typeDefinitionNode) use ($scalars, &$names) {
    if (isset($scalars[$typeConfig['name']])) {
        return $scalars[$typeConfig['name']]->config;
    }
    /** @var \GraphQL\Language\AST\ObjectTypeDefinitionNode $typeDefinitionNode */
    return $typeConfig;
};

chdir('schema');
$schema = implode("\n", array_map('file_get_contents', array_slice(scandir('.'), 2))); // build schema string from files
$schema = BuildSchema::build($schema, $typeConfigDecorator); // build schema

// get input
$input = json_decode(file_get_contents('php://input'), true);
$query = $input['query'];
$variableValues = $input['variables'] ?? null;

try {
    $rootValue = ['prefix' => 'You said: '];
    $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
    $output = $result->toArray();
} catch (\Exception $e) {
    $output = [
        'type' => get_class($e),
        'errors' => [
            [
                'message' => $e->getMessage()
            ]
        ]
    ];
}
header('Content-Type: application/json');
echo json_encode($output);
