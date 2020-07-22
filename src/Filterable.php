<?php

namespace AsemAlalami\LaravelAdvancedFilter;

use AsemAlalami\LaravelAdvancedFilter\Exceptions\OperatorNotFound;
use AsemAlalami\LaravelAdvancedFilter\Operators\Operator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Trait Filterable
 * @package AsemAlalami\LaravelAdvancedFilter
 *
 * @method Builder|$this filter(Request|array $request = null, Filter $filter = null)
 * @see Filterable::scopeFilter
 */
trait Filterable
{
    protected $operatorAliases = [];

    /**
     * Bind operators
     *
     * @return $this
     * @throws OperatorNotFound
     */
    private function bindOperators()
    {
        $operators = config('advanced_filter.operators', []);

        foreach ($operators ?: [] as $operator => $aliases) {
            $operatorClass = $this->getOperatorsNamespace() . $operator; // operator class path

            try {
                /** @var Operator $operator */
                $operator = new $operatorClass;
                $operator->setAliases(Arr::wrap($aliases));

                $this->bindOperator($operator);
            } catch (\Error $exception) {
                throw new OperatorNotFound($operator);
            }
        }

        return $this;
    }

    private function bindOperator(Operator $operator)
    {
        Builder::macro(Operator::getFunction($operator->name), function (...$parameters) use ($operator) {
            array_unshift($parameters, $this);

            return $operator->apply(...$parameters);
        });

        foreach ($operator->aliases as $alias) {
            $this->operatorAliases[$alias] = $operator->name;
        }
    }

    private function getOperatorsNamespace()
    {
        return __NAMESPACE__ . '\\Operators\\';
    }

    public function initializeFilterable()
    {
        $this->bindOperators();
    }
}
