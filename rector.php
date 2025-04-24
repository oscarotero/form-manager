<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\Class_\AddTestsVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\Class_\MergeDateTimePropertyTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\Class_\PropertyTypeFromStrictSetterGetterRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedStrictParamTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeBasedOnPHPUnitDataProviderRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeFromPropertyTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnArrayDocblockBasedOnArrayMapRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddTypeFromResourceDocblockRector;
use Rector\TypeDeclaration\Rector\ClassMethod\BoolReturnTypeFromBooleanConstReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\BoolReturnTypeFromBooleanStrictReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\NumericReturnTypeFromStrictReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\NumericReturnTypeFromStrictScalarReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByMethodCallTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByParentCallTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnNullableTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnCastRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnDirectArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictConstantReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNativeCallRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNewArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictParamRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedPropertyRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);


//    $rectorConfig->sets([SetList::PHP_84]);
    $rectorConfig->sets([SetList::PHP_72, SetList::TYPE_DECLARATION]);

        $rectorConfig->importNames();

    $rectorConfig->rules([
        ReturnTypeFromStrictNativeCallRector::class,
        ReturnTypeFromStrictNewArrayRector::class,
        AddReturnArrayDocblockBasedOnArrayMapRector::class,
        ReturnTypeFromStrictTypedPropertyRector::class,
        AddTestsVoidReturnTypeWhereNoReturnRector::class,
        AddMethodCallBasedStrictParamTypeRector::class,
        AddParamTypeBasedOnPHPUnitDataProviderRector::class,
        AddParamTypeDeclarationRector::class,
        AddParamTypeFromPropertyTypeRector::class,
        AddReturnTypeDeclarationRector::class,
        ReturnTypeFromStrictParamRector::class,
        AddTypeFromResourceDocblockRector::class,
        BoolReturnTypeFromBooleanConstReturnsRector::class,
        BoolReturnTypeFromBooleanStrictReturnsRector::class,
        DeclareStrictTypesRector::class,
        MergeDateTimePropertyTypeDeclarationRector::class,
        NumericReturnTypeFromStrictReturnsRector::class,
        NumericReturnTypeFromStrictScalarReturnsRector::class,
        ParamTypeByMethodCallTypeRector::class,
        ParamTypeByParentCallTypeRector::class,
        PropertyTypeFromStrictSetterGetterRector::class,
        ReturnNullableTypeRector::class,
        ReturnTypeFromReturnCastRector::class,
        ReturnTypeFromReturnDirectArrayRector::class,
        ReturnTypeFromStrictConstantReturnRector::class,
    ]);
};

//
//$rectorConfig=  RectorConfig::configure()
//    ->withPaths([
//        __DIR__ . '/config',
//        __DIR__ . '/middlewares',
//        __DIR__ . '/src',
//        __DIR__ . '/tests',
//    ])
//    // uncomment to reach your current PHP version
//    // ->withPhpSets()
//    ->withTypeCoverageLevel(0)
//    ->withDeadCodeLevel(0)
//    ->withCodeQualityLevel(0);
//
//$rectorConfig->withSets([SetList::PHP_82]);
//
////$rectorConfig->importNames();
////$rectorConfig->paths([__DIR__ . '/src', __DIR__ . '/tests']);
