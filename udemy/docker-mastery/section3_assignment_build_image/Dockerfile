FROM node:6-alpine

LABEL version="0.0.1"
LABEL node_version="6.0"
LABEL description="Udemy docker mastery assignment of dockeraized node app"

# Prepare to run application
RUN apk update && apk upgrade && apk add --update bash tini

# Preare application
#
# Create app directory
RUN mkdir -p /usr/src/app
# And copy all application files
COPY ./ /usr/src/app
# Set working directory of image
WORKDIR /usr/src/app
# Install app dependencies
RUN npm install
# Clean installation
RUN rm -rf /tmp/* && npm cache clean --force

# Open port 3000 on machine where running container with image
EXPOSE 3000

# Run application
CMD [ "tini", "--", "node", "./bin/www" ]
