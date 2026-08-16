FROM nginx:alpine AS development
COPY nginx-dev.conf /etc/nginx/conf.d/default.conf

FROM fholzer/nginx-brotli:latest AS final
COPY nginx-prod.conf /etc/nginx/conf.d/default.conf
