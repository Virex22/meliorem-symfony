```
php bin/console lexik:jwt:generate-keypair
```

dont forget to place the passphrase randomly on .env.local :
```
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=[YourRandomPassphrase]
```