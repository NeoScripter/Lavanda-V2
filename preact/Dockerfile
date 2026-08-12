FROM node:24-alpine AS dev
WORKDIR /app
RUN corepack enable && corepack prepare pnpm@latest --activate
COPY package.json pnpm-lock.yaml ./
RUN --mount=type=cache,target=/root/.local/share/pnpm/store pnpm install
COPY . .
EXPOSE 9002
CMD ["pnpm", "run", "dev"]
