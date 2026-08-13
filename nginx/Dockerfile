FROM nginx:alpine AS base
COPY nginx.conf /etc/nginx/conf.d/default.conf

FROM base AS development

FROM base AS final
# COPY php/public /var/www/html/public
