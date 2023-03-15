# Project Name :- magento2
## Objective of project 
1. Install any version of magento in your local device.
2. Create a new module to add custom fields(priority(int), vendor_name(varchar)) in product
3. Programmatically show those 2 newly added fields on frontend.

## Technology Used and Their version and their links
1. Xampp  v8.1.12 https://bit.ly/3ZPIoK5
2. Composer v2 https://getcomposer.org/Composer-Setup.exe
3. Mogento  v2.4.4 
4. Elastic Search v7.16.3 https://bit.ly/3JG3Ifo

## Steps to install Project in Local Device(Windows)
1. Install Xampp start(Apache, Mysql)
2. unzip archived file elastic search at the  to c:\\xampp\htdocs
3. Go to c:\\xampp\htdocs\elasticSearch7.16.3\bin select "elasticsearch.bat"  and RUN as administrator
4. verify it on chrome http://localhost:9200
5.clone this repo using command 
> git clone 
6. open xampp server on Apache section click on config button select php.ini
```
search for :- 
;extension=gd
;extension=intl
;extension=soap
;extension=xsl
;extension=sockets
;extension=sodium

 and remove ; from above lines 
 ```
 ```
Again search for :- 
max_execution_time=
max_input_time=
memory_limit=

and replace with below code

max_execution_time=18000
max_input_time=1800
memory_limit=4G
```
7. Add below code to  c:\\xampp\apache\conf\extra\httpd-vhosts.conf 
```
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/magento2/pub"
    ServerName shopping.magento.com
</VirtualHost>
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs"
    ServerName localhost
</VirtualHost>
```
8. Add below code to C:\\Windows\System32\drivers\etc\hosts 
``` 
127.0.0.1  shopping.magento.com 
```
9. Restart xampp server start(Apache,Mysql)
10. install composer in project directory
```
composer install
```
11. Replace  validateURLScheme function with below function in project directory vendor\magento\framework\Image\Adapter\Gd2.php 
```
private function validateURLScheme(string $filename) : bool
{
          $allowed_schemes = ['ftp', 'ftps', 'http', 'https'];
          $url = parse_url($filename);
          if ($url && isset($url['scheme']) && !in_array($url['scheme'], $allowed_schemes) && !file_exists($filename)) {
              return false;
          }

          return true;   
}
```
12. Open project directory in terminal (this is not an official project so below command contains all the values in readme file)
```
php bin/magento setup:install --base-url="http://shopping.magento.com/" --db-host="localhost" --db-name="db_magento2" --db-user="root" --db-password="" --admin-firstname="admin" --admin-lastname="admin" --admin-email="user@example.com" --admin-user="admin" --admin-password="Admin@123456" --language="en_US" --currency="USD" --timezone="America/Chicago" --use-rewrites="1" --backend-frontname="admin" --search-engine=elasticsearch7 --elasticsearch-host="localhost" --elasticsearch-port=9200
```
You can change according to your preference

* –base-url: http://shopping.magento.com/
* –db-name: your database name 
* –db-password: your database password 

12. Go to ```C:\xampp\htdocs\magento2\vendor\magento\framework\View\Element\Template\File``` Edit ```Validator.php``` find ```strpos($realPath, $directory)``` replace with
```
strpos($path, $directory)
```
13. Open up ```app/etc/di.xml``` in the editor,
– Find the path 
```
“Magento\Framework\App\View\Asset\MaterializationStrategy\Symlink” and replace to “Magento\Framework\App\View\Asset\MaterializationStrategy\Copy”
```
14.  To upgrade the database and deploy static view files run
```
php bin/magento indexer:reindex
php bin/magento setup:upgrade
```
15. >php bin/magento setup:static-content:deploy -f
16. >php bin/magento cache:flush
## Database Changes
1. search for the table ```setup_module``` and there you will be fine ```Products_CustomFields```
[![db.png](https://i.postimg.cc/BnJJPrZk/db.png)](https://postimg.cc/WhYBQfkw)
2.serch for the table ```catalog_product_entity_custom_field``` new table with two custom field priority(int), vendor_name(varchar) linked with product
[![table.png](https://i.postimg.cc/vBVJNhH5/table.png)](https://postimg.cc/S2m1XW9K)
3. Add product through admin pannel http://shopping.magento.com/admin
``` 
    username: admin
    pasword: Admin@123456
```
4. Add data to ```catalog_product_entity_custom_field``` through db directly 
5. go to http://shopping.magento.com/ 
[![home.png](https://i.postimg.cc/7ZzSbT6m/home.png)](https://postimg.cc/5XxXRy8C)
```click on product card ```
[![details.png](https://i.postimg.cc/PJNwHC9b/details.png)](https://postimg.cc/gLFJq2Yr)

```
**** In this repo custom field is created by model and shown in frontend page ****
```