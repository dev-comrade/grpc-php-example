### Bad metadata value given error example

### Steps to reproduce:

1. Start docker container
```bash
docker run --rm -ti -v $PWD:/var/www gashpen/examples:php8.2 bash
```

2. Install requirements(**inside docker**):
```bash
./init.sh
```

3. After execution init.sh GRPC server was started on port 50052. Then start examples:
```bash
# Service said : Hello Alex
php correct.php
# Fatal error: Uncaught InvalidArgumentException: Bad metadata value given
php incorrect.php
```