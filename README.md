# Todo List App

Proje, Laravel 11 ile geliştirilmiştir. 

Projede, birden fazla kaynaktan veri alınabildiği, bu verilerin farklı yapılara göre maplendiği senaryolar yer almaktadır. Tüm bu verilerin alınıp işlenmesi sürecinde, SOLID prensiplerine uygun bir şekilde geliştirme yapılmıştır. Repository Pattern kullanılarak, veritabanı işlemleri ayrı bir katmanda yönetilmiştir. İş mantığı Service Layer üzerinden yönetilmiştir. Ve veriler DTO (Data Transfer Object) yapısına uygun bir şekilde işlenmiştir.

# Notlar
- Verilerin çekildiği örnek veri setlerinde, iki farklı API'da aynı ID'ler yer aldığı için, bu bölümü daha efektif kullanmak adına, ID'lerin başına "mock1", "mock2" gibi prefixler eklenmiştir ve bunlar name alanına kaydedilmiştir.
- Verilerin çekileceği adresler config/api.php içerisine tanımlanmış, aynı bölümde test süreçlerinin rahat yönetimini sağlamak için bir mock adresi de belirtilmiştir. Yeni bir API yapısı eklendiğinde, ilgili dosyaya eklenmesi ve veri setine uygun bir DTO oluşturulması yeterli olacaktır.
- Ön yüzde toplam tamamlanacak süre hesaplanmıştır. Bu hesaplama, projenin başlangıç saatinden bitiş saatine kadar geçecek toplam süreyi temsil etmektedir, harcanacak toplam iş gücünü temsil etmemektedir. Bir hafta 45 saat olarak hesaplanarak, ona göre bir hafta verisi de verilmiştir.
- Uygulamaya herhangi bir authorization süreci eklenmemiştir. Bu nedenle, uygulamayı kullanabilmek için herhangi bir giriş yapmanıza gerek yoktur.
- Veri çekim süreci, komut sonrası bir Queue süreciyle de hazırlanabilir. Bu sayede, veri çekim süreci daha hızlı ve daha güvenilir bir şekilde gerçekleştirilebilir. Bu süreç, veri çekim işleminin daha uzun sürdüğü durumlarda tercih edilebilir. Projeyi karmaşıklaştırmamak adına herhangi bir Queue süreci eklenmemiştir.

## Uygulamanın Kurulumu
Uygulama dockerize edilmiştir ve docker-compose.yml dosyası ile birlikte çalıştırılabilir. Uygulamayı çalıştırmak için aşağıdaki adımları takip edebilirsiniz.

1. **Projeyi klonlayın:**

    ```
    git clone
    cd todo-list-app
    ```
2. **.env dosyasını oluşturun:**
    ```
    cp .env.example .env
    ```
3. **Docker Container'ları ayağa kaldırın:**

    ```
    docker-compose up --build
    ```
4. **Docker Container'ına bağlanın:**

    ```
    docker exec -it laravel_app bash
    ```
5. **Composer ve npm bağımlılıklarını yükleyin:**

    ```
    composer install
    npm install
    ```
6. **Veritabanı tablolarını oluşturun:**

    ```
    php artisan migrate
    ```
7. **Veritabanı tablolarını doldurun:**

    ```
    php artisan db:seed
    ```
8. **Key generate edin:**

    ```
    php artisan key:generate
    ```   

9. **Uygulamayı çalıştırın:**

    ```
    docker-compose up
    ```
10. **Uygulamaya erişin:**

    ```
    http://localhost:8080
    ```
11. **Verileri çekin:**

    ```
    php artisan todo:fetch-data
    ```
