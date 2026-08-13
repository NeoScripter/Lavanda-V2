FROM node:24-alpine AS base
WORKDIR /app
RUN corepack enable && corepack prepare pnpm@latest --activate
COPY package.json pnpm-lock.yaml ./
RUN --mount=type=cache,target=/root/.local/share/pnpm/store pnpm install
COPY . .

FROM base AS development
EXPOSE 9002
CMD ["pnpm", "run", "dev", "--host", "0.0.0.0", "--port", "9002"]

FROM base AS final
RUN pnpm run build
EXPOSE 9002
CMD ["pnpm", "run", "preview", "--host", "0.0.0.0", "--port", "9002"]
