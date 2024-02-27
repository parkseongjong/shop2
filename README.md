# 바리바리 마켓

## 그누보드 5.4.x / 이움빌더 4.3.x 기반 온라인 쇼핑몰 프로젝트

#### Requirement
- PHP 7.3 +
- MySQL 8 / MariaDB 10.4 +
- Composer 1.10 +
	- API\composer.json 참조
	
#### 서버 ENVIRONMENT 설정
- Nginx Configure
	<pre>location ~ \.php$ {
    ...
    fastcgi_param WAS_ENV "production";</pre>
- Apache Configure
	<pre>&lt;VirtualHost *:80&gt;
    ...
    SetEnv WAS_ENV production</pre>	
	or
	<pre>echo "export WAS_ENV=production" >> apache2/envvars</pre>
