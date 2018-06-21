# profile

1. Download and install ChromeiQL
2. `composer install`
3. `php -S localhost:8000 graphql.php`
4. In ChromeiQL set http://localhost:8000 as the endpoint
5. Click on Docs in the top right to explore the ProfileQuery data model. Only the documentation works currently.

Send profile input
```
curl http://localhost:8000 -d '{"query": "mutation { profiles(params: {id: 1, Names:[{id: 123, source: 10, FirstName: \"Dan\"}]} ) }" }'
```

View errors for an invalid input
```
curl http://localhost:8000 -d '{"query": "mutation { profiles(params: {id: 1, Names:[{idd: 123, source: 10, FirstName: \"Dan\"}], EmailAddresses:[{id:22, source: 11, EmailAddress: \"dancrowdskoutcom\"}]} ) }" }'
```
