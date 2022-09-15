generate certificate 
```
php bin/console lexik:jwt:generate-keypair
```

dont forget to place the passphrase randomly on .env.local :
```
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=[YourRandomPassphrase]
```

dont forget the allow access origin :
```
allow_origin: ['API_FRONT']
```

launch test with html coverage
```
./vendor/bin/phpunit --coverage-html ./coverage
```

launch phpstan
```
./vendor/bin/phpstan analyse src/
```
