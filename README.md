## Like ChatGPT


Proje Sail ile dockerize edilmiştir. Aşağıdaki adımları uygulayarak projeyi çalıştırabilirsiniz.

---

#### 1- Projeyi bilgisayarınıza klonlayın.
```
git clone https://github.com/daskafa/like-chatgpt.git
```

#### 2- Projeye ait docker-compose.yaml dosyasının bulunduğu dizine gidin.
```
cd like-chatgpt
```

#### 3- Gerektiği durumda docker-compose.yaml dosyasını düzenleyin.

#### 4- Composer ile gerekli paketleri yükleyin.
```
composer install
```

#### 5- .env dosyasını oluşturun ve belirlediğiniz bilgileri .env'ye ekleyin. (Örneğin veritabanı bilgilerinizi)

#### 6- Docker container'larınızı Sail ile ayağa kaldırın. (Docker'ı kapatıp açmanız gerekebilir)
```
./vendor/bin/sail up -d
```

### 7- App key oluşturun.
```
./vendor/bin/sail php artisan key:generate
```

### 8- Veritabanı tablolarını oluşturun.
```
./vendor/bin/sail php artisan migrate
```

#### 9- Son olarak Command'ları çalıştırın.
```
./vendor/bin/sail php artisan app:create-products 
./vendor/bin/sail php artisan app:create-admin-user
```

#### Testleri çalıştırmak için:
```
./vendor/bin/sail test
```

*Hepsi bu kadar. Teşekkürler.*
