# ACME Basket System

This is a PHP implementation of an e-commerce basket system that handles products, discounts, and delivery costs
calculations.

## Getting Started

Run the following command to build the Docker image for the API:

```bash
docker build -t acme-api:latest .
```

Run the following command to start docker containers:

```bash
docker compose up -d
```

### Basket Service

The `BasketService` is the main entry point to the application. It:

- Handles adding items to the basket;
- Orchestrates the calculation of total costs including discounts and delivery.

The `DeliveryCalculator` is responsible for calculating delivery costs based on the total basket value.
The `DeliveryCalculator` implements strategy pattern.
This will allow for easy addition of new delivery strategies in the future.

The `DiscountCalculator` is responsible for calculating discounts based on delivery strategies.
The `DiscountCalculator` implements strategy pattern. 
This will allow for easy addition of new discount strategies in the future.

The `ProductCatalog` is responsible for storing products and find by code.

The entities `Product`, `Basket', and `BasketItem` are used to represent the products and the basket with added items.
Instantiation of each entity validates data in constructor.

When a product is added to the basket, all validations are performed.
Also, basket service is responsible for calculating delivery costs and discounts.

I used PHP 8.3. I applied SOLID principles, design patterns, and TDD approach.

Unit tests assure that delivery and discount strategies are working correctly.
