FROM nginx:alpine AS base
COPY nginx.conf /etc/nginx/conf.d/default.conf

FROM base AS development
# COPY nginx-dev.conf /etc/proxy/conf.d/default.conf

FROM base AS final
# COPY nginx-prod.conf /etc/proxy/conf.d/default.conf
