# Development environment setup

## hosts file
```
127.0.0.1           yii2api
```

## Apache virtual host
```
<VirtualHost *:80>
    ServerAdmin webmaster@yii2api
    DocumentRoot "D:/data/projects.it/openSource/experiment.github/yii2/api/yii2api/web"
    ServerName yii2api
    ErrorLog "logs/yii2api-error.log"
    CustomLog "logs/yii2api-access.log" common
	<Directory "D:/data/projects.it/openSource/experiment.github/yii2/api/yii2api/web">
                AllowOverride All
                Require all granted
                DirectoryIndex index.php index.html
                Options Indexes MultiViews FollowSymLinks
    </Directory>
</VirtualHost>
```

## Test
```shell
curl -i -H "Accept:application/json" "http://yii2api/api/v1/companies"
```