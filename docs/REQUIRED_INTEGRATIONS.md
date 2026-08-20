# Что обязательно подключать к WordPress-сайту

Не существует списка из 15 «обязательных плагинов». Обязательны **функции**. Иногда их даёт хостинг/CDN, иногда WordPress-плагин, иногда внешний сервис.

## Практически для каждого коммерческого сайта

| Функция | Обязательно | Чем закрыть |
|---|---:|---|
| HTTPS/SSL | Да | Let's Encrypt/хостинг/CDN. Плагин обычно не нужен. |
| Резервные копии | Да | Backup хостинга или UpdraftPlus/аналог. |
| Надёжная доставка форм | Да, если есть формы | SMTP/API provider + WP Mail SMTP/FluentSMTP/аналог. |
| SEO metadata + sitemap | Да для индексируемого сайта | Rank Math **или** Yoast **или** другой один SEO-плагин. |
| Защита формы от спама | Обычно | Turnstile/reCAPTCHA/honeypot/anti-spam provider. |
| Аналитика | Для большинства бизнес-сайтов | GA4/Matomo/другая аналитика. Аккаунт клиента. |
| Search Console | Для поискового трафика | Google Search Console, ownership клиента. |
| Мониторинг обновлений | Да организационно | Хостинг/maintenance plan/ответственный человек. |
| Сильные admin credentials | Да | Password manager + 2FA по возможности. |

## Подключается по ситуации

### Cache/performance

Нужен механизм кеширования, но это не обязательно отдельный plugin. Если хостинг уже даёт full-page cache/CDN, второй cache plugin может мешать.

Примеры: LiteSpeed Cache на совместимом LiteSpeed-сервере, WP Rocket, cache хостинга, Cloudflare.

### Security plugin

Wordfence/аналог полезен для части проектов, но не заменяет обновления, backups, 2FA, HTTPS и нормальный хостинг. Не ставь несколько security suites одновременно.

### Cookie consent

Нужен, если применимое законодательство и используемые трекеры требуют согласия. Конкретная настройка зависит от юрисдикции клиента и набора скриптов.

### CRM / Google Sheets / AI agent

Для lead-generation сайта полезно:

```text
Form
  ↓
Webhook/API
  ↓
CRM / n8n / Make / AI agent
  ↓
Sales manager
```

Но email-уведомление лучше не считать единственным источником правды: сохраняй lead в WordPress/CRM или другой системе.

### Uptime monitoring

Желательно для сайтов, от которых идут продажи. Внешний монитор может проверять production каждые несколько минут и уведомлять при падении.

## Минимальный production stack для небольшого бизнеса

```text
WordPress
+ кастомная тема
+ Business Starter Core
+ ОДИН SEO plugin
+ ОДИН forms plugin ИЛИ встроенная starter-форма
+ SMTP/API mail delivery
+ backup
+ spam protection
+ analytics
+ Search Console
+ HTTPS
```

Security/cache/cookie/CRM добавляются по требованиям инфраструктуры и проекта.

## Что нельзя делать

- Не ставить Yoast + Rank Math одновременно.
- Не ставить несколько cache-плагинов без понимания цепочки кеша.
- Не хранить SMTP/API credentials в Git.
- Не использовать `admin/admin` и повторяющиеся пароли.
- Не считать наличие backup достаточным без понимания восстановления.
- Не передавать клиенту сайт, не отправив тестовую заявку с production.
