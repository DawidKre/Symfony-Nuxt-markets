FROM node:12.4

ENV APP_ROOT /src

# copy both 'package.json' and 'package-lock.json' (if available)
COPY package*.json ./

RUN mkdir ${APP_ROOT}
WORKDIR ${APP_ROOT}
ADD . ${APP_ROOT}

RUN yarn install
RUN yarn global add nuxt
RUN yarn run build

ENV HOST 0.0.0.0
