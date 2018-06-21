<?php
use GraphQL\Type\Definition\CustomScalarType;

$scalars = [];

$emailRegex = '"^[a-zA-Z0-9.!#$%&\'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$"';
$scalars['csEmail'] = new CustomScalarType([
    'name' => 'csEmail',
    'serialize' => function($value) {
        return $value;
    },
    'parseValue' => function($value) use ($emailRegex) {
        if (preg_match($emailRegex, $value) !== 1) {
            throw new Error("Cannot represent following value as email: " . \GraphQL\Utils\Utils::printSafeJson($value));
        }
        return $value;
    },
    'parseLiteral' => function($valueNode) use ($emailRegex) {
        // Note: throwing GraphQL\Error\Error vs \UnexpectedValueException to benefit from GraphQL
        // error location in query:
        if (!$valueNode instanceof \GraphQL\Language\AST\StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
        }
        if (preg_match($emailRegex, $valueNode->value) !== 1) {
            return null;
        }
        return $valueNode->value;
    },
]);

return $scalars;