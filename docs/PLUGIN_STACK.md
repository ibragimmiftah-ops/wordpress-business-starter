# Рекомендуемый стек плагинов

Выбирайте **по одному** решению на задачу. Список — ориентир, а не требование установить всё.

## SEO

Выбрать один:

- Rank Math
- Yoast SEO
- The SEO Framework

Нужно: title/meta, canonical, sitemap, robots/noindex controls, Open Graph.

## Forms

В starter уже есть простая форма `[business_contact_form]`, которая сохраняет лиды. Для сложных форм выберите один forms plugin:

- Fluent Forms
- WPForms
- Gravity Forms
- Contact Form 7 — если устраивает более ручная конфигурация

## SMTP / transactional email

Выбрать один слой интеграции:

- FluentSMTP
- WP Mail SMTP
- провайдер/плагин хостинга

Провайдер может быть отдельным: Postmark, Mailgun, SendGrid, Brevo, Amazon SES и т. п.

## Backups

Сначала проверить возможности хостинга. Если они недостаточны:

- UpdraftPlus
- BlogVault
- другой backup/migration tool

## Cache

Сначала узнать web server/hosting stack.

- LiteSpeed Cache — если инфраструктура поддерживает LiteSpeed cache.
- WP Rocket — общий коммерческий вариант.
- Cache/CDN хостинга — часто достаточно.

Не ставить несколько full-page cache решений одновременно.

## Security

По необходимости:

- Wordfence
- Patchstack
- WAF/CDN/hosting security

2FA и обновления важнее механического количества security plugins.

## Redirects

Если SEO plugin не закрывает задачу:

- Redirection

## Analytics

Можно подключить вручную через theme/consent manager либо использовать Site Kit/Tag Manager integration. Аккаунты должны принадлежать клиенту.

## Cookies / consent

Выбор зависит от юрисдикции и реальных трекеров. Не копируйте баннер без проверки того, блокирует ли он требующие согласия scripts до consent.
