<?php
require_once __DIR__ . '/vendor/autoload.php';

$inputData = json_decode($argv[1]);

$retriever = new \JsonSchema\Uri\UriRetriever;
$jsonSchemaPath = __DIR__ . '/schema/';

$schema = $retriever->retrieve('file://' . $jsonSchemaPath . '211.json');

$resolver = new \JsonSchema\RefResolver($retriever);
$resolver->resolve($schema, 'file://' . $jsonSchemaPath);

$validator = new \JsonSchema\Validator();
$validator->check($inputData, $schema);

echo 'Input '. json_encode($inputData) . PHP_EOL;
$status = $validator->isValid();
echo 'Validation status (Validator::isValid): '; var_export($status); echo PHP_EOL;
if (!$validator->isValid()) {
    echo 'Errors: ' . PHP_EOL;
    echo json_encode($validator->getErrors(), JSON_PRETTY_PRINT);
    echo PHP_EOL;
}
