<?php

namespace PhpJunior\PricingEngine\Services;

use PhpJunior\PricingEngine\Data\RuleData;
use PhpJunior\PricingEngine\Handlers\CalculatePriceHandler;
use PhpJunior\PricingEngine\Handlers\CalculatePriceQuery;
use PhpJunior\PricingEngine\Repositories\PricingRuleRepository;

class PricingEngine
{
    public function __construct(
        private readonly PricingRuleRepository $repository,
        private readonly ?string $id = null
    ) {
    }

    /**
     * @param string|null $id
     * @return self
     */
    public static function make(?string $id = null): self
    {
        return new self(app(PricingRuleRepository::class), $id);
    }

    /**
     * @param int $basePrice
     * @param array $context
     * @return array
     * @throws \Exception
     */
    public static function calculatePrice(int $basePrice, array $context = []): array
    {
        return app(CalculatePriceHandler::class)->handle(new CalculatePriceQuery(
            basePrice: $basePrice,
            context: $context
        ));
    }

    /**
     * @return array
     */
    public function getAllPricingRules(): array
    {
        return $this->repository->findAllActive();
    }

    /**
     * @return bool
     */
    public function deletePricingRule(): bool
    {
        return $this->repository->delete($this->id);
    }

    /**
     * @param string $name
     * @param int $priority
     * @param array $conditions
     * @param array $actions
     * @return mixed
     */
    public function savePricingRule(string $name, int $priority, array $conditions, array $actions): mixed
    {
        $rule = new RuleData(
            id: $this->id,
            name: $name,
            priority: $priority,
            conditions: $conditions,
            actions: $actions
        );
        return $this->repository->save($rule);
    }
}
