#!/usr/bin/env bash
set -euo pipefail

wp() {
  docker compose run --rm wpcli "$@"
}

create_page() {
  local title="$1"
  local slug="$2"
  local content="$3"
  if wp post list --post_type=page --name="$slug" --field=ID | grep -q .; then
    echo "Page exists: $slug"
  else
    wp post create --post_type=page --post_status=publish --post_title="$title" --post_name="$slug" --post_content="$content"
  fi
}

create_page "Home" "home" '<!-- wp:pattern {"slug":"business-starter/hero"} /--><!-- wp:pattern {"slug":"business-starter/services"} /--><!-- wp:pattern {"slug":"business-starter/process"} /--><!-- wp:pattern {"slug":"business-starter/cta"} /-->'
create_page "Services" "services" '<!-- wp:heading --><h2 class="wp-block-heading">Services</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Replace this content with the client services.</p><!-- /wp:paragraph -->'
create_page "About" "about" '<!-- wp:heading --><h2 class="wp-block-heading">About</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Replace with company story, expertise, team and proof.</p><!-- /wp:paragraph -->'
create_page "Projects" "projects" '<!-- wp:heading --><h2 class="wp-block-heading">Projects</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Add case studies and project examples.</p><!-- /wp:paragraph -->'
create_page "Contact" "contact" '<!-- wp:heading --><h2 class="wp-block-heading">Contact</h2><!-- /wp:heading --><!-- wp:shortcode -->[business_contact_form]<!-- /wp:shortcode -->'

HOME_ID="$(wp post list --post_type=page --name=home --field=ID | head -n 1)"
wp option update show_on_front page
wp option update page_on_front "$HOME_ID"

echo "Base pages created. Configure navigation in wp-admin."
