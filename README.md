## Fenix Case


Proje Sail ile dockerize edilmiştir. Aşağıdaki adımları uygulayarak projeyi çalıştırabilirsiniz.

---

#### 1- Projeyi bilgisayarınıza klonlayın.
```
git clone git@github.com:daskafa/fenix-case.git
```

#### 2- Projeye ait docker-compose.yaml dosyasının bulunduğu dizine gidin.
```
cd fenix-case
```

#### 3- Gerektiği durumda docker-compose.yaml dosyasını düzenleyin.
#### 4- Docker container'larınızı Sail ile ayağa kaldırın.
```
./vendor/bin/sail up -d
```

#### 5- .env dosyasını oluşturun ve docker-compose.yaml dosyasında belirlediğiniz bilgileri dosyasınıza ekleyin. (Örneğin veritabanı bilgilerinizi)

#### 6- Composer ile gerekli paketleri yükleyin.
```
composer install
```

### 7- Veritabanı tablolarını oluşturun.
```
./vendor/bin/sail php artisan migrate
```

#### 8- Son olarak Command'ları çalıştırın.
```
./vendor/bin/sail php artisan app:create-products 
./vendor/bin/sail php artisan app:create-admin-user
```

*Hepsi bu kadar. Teşekkürler.*
