# laravel8x.homestaed.test

### 목표: 일타삼피 (한개의 프로젝트로 3개의 공부를 한다.)   
1. laravel 8.x 학습  
2. vue 학습  
3. flutter app api 개발

### 버전  
- php: 7.4
- node: v12.19.0
- mysql: 5.7

### 주요 패키지  
- [sanctum](https://laravel.kr/docs/8.x/sanctum)
- [fractal](https://packagist.org/packages/league/fractal)  
- [laravel/ui](https://github.com/laravel/ui)

### 설치  
```sh
# php package install
composer install

# laravel key generate
artisan key:generate

# env
cp .env.example .env

# database migration
artisan migrate

# storage link
artisan storage:link

# node pacekage install
npm install
```

### 사용  
```sh
# database query log (debug mode) .env APP_DEBUG == true
tail -f storage/logs/laravel.log

# seed
artisan db:seed

# table refresh
artisan migrate:refresh

# table refresh + seeding
artisan migrate:refresh --seed

# 프론트엔드 변경 감지
npm run watch
```