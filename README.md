# profile

1. Download and install ChromeiQL
2. `composer install`
3. `php -S localhost:8000 graphql.php`
4. In ChromeiQL set http://localhost:8000 as the endpoint
5. Currently, only the documentation work on the right side

Send profile input
```
curl http://localhost:8000 -d '{"query": "mutation { profiles(params: {id: 1, Names:[{id: 123, source: 10, FirstName: \"Dan\"}]} ) }" }'
```