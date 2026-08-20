# Развёртывание на обычном WordPress-хостинге

Подходит для SpaceWeb, Timeweb, cPanel/Plesk-хостинга и любого сервера с поддерживаемыми PHP + MySQL/MariaDB.

## Вариант A — новый сайт

1. Клиент создаёт/оплачивает hosting account.
2. Подключается домен и DNS.
3. В панели хостинга устанавливается чистый WordPress.
4. В WordPress создаётся отдельный admin для разработчика.
5. На staging загружается `business-starter` в:

```text
wp-content/themes/business-starter
```

6. Загружается plugin:

```text
wp-content/plugins/business-starter-core
```

7. В `/wp-admin` активируются тема и plugin.
8. Создаются страницы Home / Services / About / Projects / Contact.
9. В Settings → Reading Home назначается статической главной.
10. В Business заполняются контакты компании.
11. Подключается production SMTP/API mail delivery.
12. Подключаются SEO, backup, analytics/Search Console и остальные нужные функции.
13. Выполняется тест на staging.
14. Только после этого staging переносится/переключается на production.

## Вариант B — перенос готового сайта

Для WordPress недостаточно скопировать один HTML-файл. Нужно перенести:

```text
WordPress files
+ wp-content/uploads
+ database
+ environment/configuration
```

Практические способы:

- migration plugin;
- backup/restore средствами хостинга;
- вручную: files + DB dump + search/replace URLs + wp-config;
- WP-CLI для более технического workflow.

Всегда делать backup перед миграцией.

## Git и production

Рекомендуемая схема:

```text
GitHub private repo
  ↓
custom theme + custom plugin only
  ↓
staging
  ↓ test
production
```

Не хранить WordPress core в Git без специальной причины. Не хранить production database и uploads с персональными данными в обычном code repository.

## wp-config.php

На production проверьте как минимум:

```php
define('WP_DEBUG', false);
define('DISALLOW_FILE_EDIT', true);
```

DB credentials и secret salts остаются вне Git.

## SSL

Сертификат обычно выпускается в панели хостинга/через Let's Encrypt. После выпуска:

- WordPress Address и Site Address должны использовать `https://`;
- HTTP должен редиректить на HTTPS;
- убрать mixed-content URL;
- проверить формы, webhook и callback URL после смены протокола.

## Передача клиенту

Не отдавайте только ZIP или HTML. Для проекта «под ключ» клиент должен получить работающий production и владение ключевыми аккаунтами:

```text
Domain/DNS
Hosting
WordPress admin
Git/source code
Analytics/Search Console
Forms/CRM/email services
Licenses
Backup responsibility
```

Затем пройти `CLIENT_HANDOFF_CHECKLIST.md`.
