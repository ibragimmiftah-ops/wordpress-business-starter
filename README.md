# WordPress Business Starter

Готовая основа для небольших корпоративных сайтов на WordPress: реальная админка `/wp-admin`, редактирование страниц через Gutenberg, кастомная тема и небольшой core-плагин для бизнес-настроек и заявок.

## Что внутри

- `wp-content/themes/business-starter` — кастомная тема компании.
- `wp-content/plugins/business-starter-core` — настройки компании, shortcode контактов, форма заявки и раздел **Leads** в админке.
- `docker-compose.yml` — локальный WordPress + MariaDB + WP-CLI.
- `scripts/install-wordpress.sh` — установка WordPress и активация стартера.
- `scripts/seed-content.sh` — создание базовых страниц.
- `docs/CLIENT_HANDOFF_CHECKLIST.md` — обязательный чек-лист перед передачей клиенту.
- `docs/REQUIRED_INTEGRATIONS.md` — что обязательно подключить и что ставится только по ситуации.
- `docs/HOSTING_DEPLOYMENT.md` — как развернуть на обычном PHP/MySQL-хостинге.
- `docs/PLUGIN_STACK.md` — рекомендуемые категории плагинов без лишнего дублирования.

## Архитектура

```text
Domain
  ↓ DNS
Hosting (PHP + MySQL)
  ↓
WordPress core
  ├── /wp-admin          ← админка клиента
  ├── database           ← страницы, настройки, пользователи, лиды
  └── wp-content/
      ├── themes/business-starter
      ├── plugins/business-starter-core
      └── uploads/       ← не хранить в Git
```

WordPress core, база данных, `wp-config.php`, uploads и секреты не должны храниться в этом репозитории. Git хранит только ваш кастомный код и документацию.

## Быстрый локальный запуск

1. Скопировать окружение:

```bash
cp .env.example .env
```

2. Обязательно поменять пароли и email в `.env`.

3. Запустить:

```bash
docker compose up -d db wordpress
```

4. Установить WordPress и активировать стартер:

```bash
bash scripts/install-wordpress.sh
```

5. Создать базовые страницы:

```bash
bash scripts/seed-content.sh
```

6. Открыть:

```text
Сайт:    http://localhost:8080
Админка: http://localhost:8080/wp-admin
```

## Что редактирует клиент в админке

### Pages
Клиент меняет тексты, изображения и Gutenberg-блоки обычных страниц.

### Appearance
Меню, логотип и настройки темы зависят от версии WordPress и активных возможностей темы.

### Business
Кастомная страница настроек:

- название компании;
- телефон;
- email;
- WhatsApp URL;
- адрес;
- email для входящих заявок.

### Leads
Заявки с встроенной формы сохраняются в админке и дополнительно отправляются на email через `wp_mail()`. Для production обязательно подключите нормальную SMTP/API-доставку почты.

## Shortcodes

```text
[business_phone]
[business_email]
[business_whatsapp]
[business_address]
[business_contact_form]
```

Их можно вставлять в Gutenberg через блок **Shortcode**.

## Что делать для нового клиента

1. Сделать новый приватный репозиторий из этого starter.
2. Заменить название темы/брендинг при необходимости.
3. Развернуть WordPress на staging.
4. Создать страницы и меню.
5. Загрузить оптимизированные изображения.
6. Настроить Business Settings.
7. Подключить форму, SMTP, SEO, backup, аналитику и Search Console.
8. Проверить mobile/desktop, формы, ссылки, 404, HTTPS и sitemap.
9. Выполнить `docs/CLIENT_HANDOFF_CHECKLIST.md`.
10. Передать клиенту его собственные доступы.

## Production

Docker-файл здесь нужен в первую очередь для локальной разработки. На обычном WordPress-хостинге WordPress и MySQL ставятся средствами хостинга, после чего вы загружаете кастомную тему и плагин из `wp-content/`.

Не коммитьте:

- `.env`;
- `wp-config.php`;
- пароли;
- API keys;
- database dump с реальными данными клиентов;
- `wp-content/uploads` с приватными файлами;
- коммерческие плагины, если лицензия не разрешает распространение.

Подробности: `docs/HOSTING_DEPLOYMENT.md`.
