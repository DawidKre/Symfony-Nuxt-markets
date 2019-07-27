FROM node:12.4

ENV APP_ROOT /src

# copy both 'package.json' and 'package-lock.json' (if available)
COPY package*.json ./

RUN mkdir ${APP_ROOT}
WORKDIR ${APP_ROOT}
ADD . ${APP_ROOT}

RUN yarn global add @quasar/cli
RUN yarn install
RUN yarn run build

ENV HOST 0.0.0.0
