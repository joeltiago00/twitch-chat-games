<?php

namespace Game\DTO;

use ReflectionClass;
use ReflectionProperty;

abstract class BaseDTO
{
    final public function toArray(bool $withNullAttributes = false): array
    {
        $reflection = new ReflectionClass($this);

        $properties = $reflection->getProperties();

        return $withNullAttributes
            ? $this->getWithNullAttributes($properties)
            : $this->getWithoutNullAttributes($properties);
    }

    /**
     * @param ReflectionProperty[] $properties
     * @return array
     */
    private function getWithNullAttributes(array $properties): array
    {
        $list = [];

        foreach ($properties as $property) {
            $propertyValue = $property->getValue($this);

            if (is_object($propertyValue))
                $propertyValue = $propertyValue->toArray(true);

            $list[camelCaseToSnakeCase($property->name)] = $propertyValue;
        }

        return $list;
    }

    /**
     * @param ReflectionProperty[] $properties
     * @return array
     */
    private function getWithoutNullAttributes(array $properties): array
    {
        $list = [];

        foreach ($properties as $property) {
            $propertyValue = $property->getValue($this);

            if (empty($propertyValue))
                continue;

            if (is_object($propertyValue))
                $propertyValue = $propertyValue->toArray();

            $list[camelCaseToSnakeCase($property->name)] = $propertyValue;
        }

        return $list;
    }
}
