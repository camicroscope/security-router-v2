FROM node:8
RUN npm install -g nodemon
RUN mkdir /root/src
COPY . /root/src
WORKDIR /root/src
RUN npm install
EXPOSE 4010
CMD nodemon router.js -w ./
