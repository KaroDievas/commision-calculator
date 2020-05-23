# commission-calculator

## Requirements
- docker

## Running 
- docker-compose up
- docker exec -it commision-calculator sh
- phpunit tests (for unit tests)
- php src/app.php data/input.txt (for app running)


## Possible improvements
- getFixedAmountByExchangeRateAndCurrencyAndAmount function can be simplified
- it's possible to add custom logging solution, for example in real application logging is quite important to have trace what happen just in case