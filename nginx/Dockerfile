FROM nginx:alpine AS base

FROM base AS development
COPY nginx-dev.conf /etc/nginx/conf.d/default.conf

FROM base AS final
COPY nginx-prod.conf /etc/nginx/conf.d/default.conf
