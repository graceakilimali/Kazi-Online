<?php

namespace App\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use JsonSerializable;
use ReflectionClass;

abstract class BaseData implements Arrayable, JsonSerializable, Responsable
{
    /**
     * Create an instance from an Eloquent model, array, or mixed input.
     */
    public static function from(mixed $payload): static
    {
        if (is_array($payload)) {
            return static::fromArray($payload);
        }

        if (is_object($payload) && method_exists(static::class, 'fromModel')) {
            return static::fromModel($payload);
        }

        if (is_object($payload)) {
            return static::fromArray((array) $payload);
        }

        return new static();
    }

    /**
     * Create a typed Data collection or transform a paginator.
     */
    public static function collect(mixed $items): mixed
    {
        if ($items instanceof LengthAwarePaginator) {
            return $items->through(fn ($item) => static::from($item));
        }

        if ($items instanceof Collection) {
            return $items->map(fn ($item) => static::from($item));
        }

        if (is_array($items)) {
            return array_map(fn ($item) => static::from($item), $items);
        }

        return $items;
    }

    /**
     * Create from array matching constructor property names.
     */
    public static function fromArray(array $data): static
    {
        $reflection = new ReflectionClass(static::class);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new static();
        }

        $args = [];
        foreach ($constructor->getParameters() as $parameter) {
            $name = $parameter->getName();
            if (array_key_exists($name, $data)) {
                $args[$name] = $data[$name];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $args[$name] = $parameter->getDefaultValue();
            } else {
                $args[$name] = null;
            }
        }

        return $reflection->newInstanceArgs($args);
    }

    /**
     * Convert instance properties to array.
     */
    public function toArray(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();
        $array = [];

        foreach ($properties as $property) {
            $name = $property->getName();
            $value = $property->getValue($this);

            if ($value instanceof Arrayable) {
                $array[$name] = $value->toArray();
            } elseif (is_array($value)) {
                $array[$name] = array_map(fn ($v) => $v instanceof Arrayable ? $v->toArray() : $v, $value);
            } else {
                $array[$name] = $value;
            }
        }

        return $array;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray());
    }
}
