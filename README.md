# readme-generator-api
## ER図
![](./er.png)
## API仕様書

## 環境構築
```bash
make build
make up
cd src
cp .env.example .env
make in # 失敗したらdocker compose run api bash
# コンテナの中で実行
composer install
php artisan key:generate
```