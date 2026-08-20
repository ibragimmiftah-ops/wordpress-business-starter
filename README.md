# WordPress Business Starter

Production-oriented WordPress starter for small and medium business websites.

This repository contains:

- a custom WordPress theme;
- a companion core plugin;
- a business settings admin screen;
- a lightweight leads inbox in WordPress;
- a contact-form shortcode;
- Gutenberg patterns for common business sections;
- Docker-based local development;
- installation and seed scripts;
- deployment, plugin, integration and client-handoff documentation.

## What this starter is for

Use this repository as a repeatable base for brochure sites, local-service businesses, construction companies, agencies, consultants and other lead-generation websites.

The starter deliberately keeps WordPress core, uploads and secrets out of Git. Track only the custom theme, custom plugin and project documentation.

## Architecture

```text
Browser
  ↓
WordPress / PHP
  ├── Business Starter theme
  ├── Business Starter Core plugin
  └── MySQL / MariaDB
        ↓
/wp-admin
```

The real WordPress administration panel remains available at `/wp-admin`. The companion plugin adds a **Business** settings page and a **Leads** section.

## Repository structure

```text
wordpress-business-starter/
├── .env.example
├── .gitignore
├── docker-compose.yml
├── docs/
│   ├── CLIENT_HANDOFF_CHECKLIST.md
│   ├── HOSTING_DEPLOYMENT.md
│   ├── PLUGIN_STACK.md
│   └── REQUIRED_INTEGRATIONS.md
├── scripts/
│   ├── install-wordpress.sh
│   └── seed-content.sh
└── wp-content/
    ├── plugins/
    │   └── business-starter-core/
    └── themes/
        └── business-starter/
```

## Local development

### Requirements

- Docker + Docker Compose
- optional: WP-CLI if you are not using the included container workflow

### 1. Configure environment

```bash
cp .env.example .env
```

Edit `.env` and use development-only credentials.

### 2. Start WordPress

```bash
docker compose up -d
```

Open `http://localhost:8080`.

### 3. Install WordPress

You can finish the browser installer manually or run:

```bash
bash scripts/install-wordpress.sh
```

The script reads configuration from `.env`.

### 4. Seed starter pages

```bash
bash scripts/seed-content.sh
```

This creates a basic page structure and assigns a front page.

## WordPress admin

After installation:

```text
http://localhost:8080/wp-admin
```

The admin panel is WordPress itself. This starter does not replace WordPress with a custom admin application.

### Business settings

Activate **Business Starter Core** and open:

```text
WordPress Admin → Business
```

Configure:

- company phone;
- company email;
- WhatsApp URL;
- physical address;
- lead-notification email.

Available shortcodes:

```text
[business_phone]
[business_email]
[business_whatsapp]
[business_address]
[business_contact_form]
```

The contact form saves submissions as private **Lead** records in WordPress and sends an email notification using `wp_mail()`.

For production, configure an SMTP/API mail provider. Do not rely on default PHP mail delivery.

## Theme

Activate:

```text
Appearance → Themes → Business Starter
```

The theme includes:

- responsive header and navigation;
- page, single and archive templates;
- 404 page;
- accessible skip link;
- Gutenberg block patterns;
- global design tokens in `theme.json`;
- lightweight CSS and JavaScript;
- WordPress-managed title tag, logo and menus.

## Gutenberg patterns

Starter patterns include:

- Hero;
- Services;
- Process;
- CTA.

They can be inserted from the WordPress block editor and then customized for each client.

## Recommended production workflow

```text
Local / staging
  ↓
Git repository
  ↓
Production hosting
  ↓
Domain + DNS
  ↓
HTTPS
  ↓
SMTP / forms
  ↓
SEO + Search Console + analytics
  ↓
Backup + security checks
  ↓
Client handoff
```

Do not store production database passwords, SMTP passwords, API tokens, private keys or WordPress salts in the repository.

## Mandatory production items

Before handoff, at minimum verify:

1. domain and DNS ownership;
2. HTTPS with automatic certificate renewal;
3. working WordPress administrator account owned by the client;
4. tested contact forms;
5. reliable SMTP/API email delivery;
6. backups with a tested restore path;
7. SEO titles, indexing settings and XML sitemap;
8. Google Search Console or the client's chosen search-console equivalent;
9. analytics if required by the client;
10. privacy/cookie requirements appropriate to the business and jurisdiction;
11. software updates, strong passwords and least-privilege user roles;
12. mobile, desktop, form, link and 404 testing;
13. complete ownership/access transfer.

See [Client handoff checklist](docs/CLIENT_HANDOFF_CHECKLIST.md) for the detailed checklist.

## Plugin policy

Do not install plugins merely because they are popular. Every plugin adds maintenance and security surface area.

Typical categories:

- SEO: Rank Math **or** Yoast, not both;
- forms: use the built-in starter form for simple leads or one dedicated forms plugin;
- mail: SMTP/API delivery plugin or provider integration;
- backup: use the host's reliable backups or one backup solution;
- caching: choose a solution that matches the hosting stack;
- security: add dedicated security tooling when the hosting/security model requires it;
- redirects: useful during migrations and URL changes;
- spam protection: enable when public forms receive abuse.

See [Plugin stack](docs/PLUGIN_STACK.md).

## Production deployment

This repository is not a full copy of WordPress core. On production hosting:

1. install a fresh supported WordPress version;
2. connect the production database;
3. deploy this repository's custom `wp-content/themes/business-starter` and `wp-content/plugins/business-starter-core`;
4. activate the theme and plugin;
5. migrate/import the client's content when needed;
6. configure all production-only secrets in the host/server, not in Git;
7. run the full handoff checklist.

See [Hosting deployment](docs/HOSTING_DEPLOYMENT.md).

## Updates

Keep WordPress core, plugins and themes updated, but test updates on staging or ensure a verified rollback/backup exists before production changes.

## License

Starter project code: MIT. WordPress itself and third-party plugins/themes retain their own licenses.
