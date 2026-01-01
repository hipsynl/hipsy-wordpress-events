#!/bin/bash
set -e

echo "Waiting for WordPress files to be ready..."

# Wait for wp-config.php to exist
while [ ! -f /var/www/html/wp-config.php ]; do
  echo "Waiting for wp-config.php..."
  sleep 2
done

echo "WordPress configuration file found. Waiting for database connection..."

# Wait for database to be accessible using PHP connection test
DB_HOST="${WORDPRESS_DB_HOST:-db}"
DB_USER="${WORDPRESS_DB_USER:-wordpress}"
DB_PASSWORD="${WORDPRESS_DB_PASSWORD:-wordpress}"
DB_NAME="${WORDPRESS_DB_NAME:-wordpress}"

# Test database connection using PHP
until php -r "
\$conn = @mysqli_connect('$DB_HOST', '$DB_USER', '$DB_PASSWORD', '$DB_NAME');
if (\$conn) {
    mysqli_close(\$conn);
    exit(0);
}
exit(1);
" 2>/dev/null; do
  echo "Waiting for database connection..."
  sleep 2
done

echo "Database connection established."

# Check if WordPress is already installed
if wp core is-installed --allow-root --path=/var/www/html 2>/dev/null; then
  echo "WordPress is already installed. Skipping installation."
  exit 0
fi

# Install WordPress
echo "Installing WordPress..."
wp core install \
  --url="${WORDPRESS_URL:-http://localhost:8080}" \
  --title="${WORDPRESS_TITLE:-Hipsy Events Development}" \
  --admin_user="${WORDPRESS_ADMIN_USER:-admin}" \
  --admin_password="${WORDPRESS_ADMIN_PASSWORD:-admin}" \
  --admin_email="${WORDPRESS_ADMIN_EMAIL:-admin@example.com}" \
  --allow-root \
  --path=/var/www/html

echo ""
echo "=========================================="
echo "WordPress installed successfully!"
echo "=========================================="
echo "Admin username: ${WORDPRESS_ADMIN_USER:-admin}"
echo "Admin password: ${WORDPRESS_ADMIN_PASSWORD:-admin}"
echo "Login URL: ${WORDPRESS_URL:-http://localhost:8080}/wp-admin"
echo "=========================================="

