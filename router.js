// intended to be used (at least) as an exposed docker container
const express = require('express')
const rp = require('request-promise');
const app = express();
const fs = require("fs")
const getUrlParam = require("./getUrlParam")
const passport = require("passport")

app.use(passport.initialize());
app.use(express.json());

const User = require("./User.js")

var Strategy = require('passport-openidconnect').Strategy;

passport.use(new Strategy({
    clientID: process.env.CLIENT_ID,
    clientSecret: process.env.CLIENT_SECRET,
    authorizationURL: 'https://login0.myauth0.com/i/oauth2/authorize',
    tokenURL: 'https://login0.myauth0.com/oauth/token',
    callbackURL: 'http://localhost:3000/callback'
  },
  function(token, tokenSecret, profile, cb) {
    return cb(null, profile);
}));

let RESOLVER_CACHE = {}



let loading_config
try {
    loading_config = JSON.parse(fs.readFileSync("routes.json"));
} catch (e) {
    loading_config = JSON.parse(fs.readFileSync("routes.json.example"));
}
const config = loading_config;

// Sessions
// CACHE Resolvers
// CACHE Keys, put in session

// route for user - get username given auth header
// route for login - get header given good login

// this method takes in the original url and config to resolve which url to ask for
async function resolve(url, config) {
    let service = url.split("/")[1]
    let type = url.split("/")[2]
    let method = url.split("/")[3]
    let outUrl = ""
        // check if exists first
    let serviceList = config.services
    let hasMethod = serviceList.hasOwnProperty(service) && serviceList[service].hasOwnProperty(type) && serviceList[service][type].hasOwnProperty(method);
    if (hasMethod) {
        outUrl += serviceList[service]["_base"] || ""
        if (!(typeof serviceList[service][type][method] === 'string' || serviceList[service][type][method] instanceof String)) {
            outUrl += await useResolver(method, serviceList[service][type][method])
        } else {
            outUrl += serviceList[service][type][method] || ""
        }
    } else {
        // if not exists, go to base
        outUrl = config["root"] + "/" + url.split("/").slice(1).join("/")
    }
    return outUrl
}

// in cases where a resolver, rather than a string, is used for a method, use this to lookup w/o cache
async function useResolver(method, rule) {
    var rule_check = JSON.stringify([method,rule])
    if(RESOLVER_CACHE.hasOwnProperty(rule_check)){
      return RESOLVER_CACHE[rule_check]
    } else {
      var INvar = method;
      var beforeVar = "";
      var afterVar = "";
      // get input variable
      if (rule.before) {
          if (!(typeof rule.before === 'string' || rule.before instanceof String)) {
              // for unity, treat as list
              rule.before = [rule.before]
          }
          let activeKeys = rule.before.filter(x => INvar.indexOf(x) >= 0)
          INvar = INvar.split(activeKeys[0])[0]
              // keep the rest of the things surrounding the invar
          beforeVar = method.split(activeKeys[0]).slice(1).join(activeKeys[0])
      }
      if (rule.after) {
          if (!(typeof rule.after === 'string' || rule.after instanceof String)) {
              // for unity, treat as list
              rule.after = [rule.after]
          }
          let activeKeys = rule.after.filter(x => INvar.indexOf(x) >= 0)
          INvar = INvar.split(activeKeys[0])[1]
              // keep the rest of the things surrounding the invar
          afterVar = method.split(activeKeys[0]).slice(0, -1).join(activeKeys[0])
      }
      // TODO ask cache for this invar
      var OUTvar = await rp({
          uri: rule.url.split("{IN}").join(INvar),
          json: true
      })
      if (rule.field) {
          OUTvar = OUTvar[rule.field]
      }
      // substitute all OUT and IN
      var result = rule.destination.split("{OUT}").join(beforeVar + OUTvar + afterVar).split("{IN}").join(INvar);
      RESOLVER_CACHE[rule_check] = result
      return result
    }

}

// User/security routes



app.use("/", function(req, res) {
        // check for authentication specific
        if (url.split("/")[1]=="_auth"){
          if (url.split("/")[2]=="login"){
            passport.authenticate('openidconnect'));
          }
          if (url.split("/")[2]=="callback"){
            passport.authenticate('openidconnect', { failureRedirect: '/_auth/login' }),
              function(req, res) {
                if(req.user){
                  res.statys(200).send(req.user)
                } else {
                  res.status(400).send(error)
                }
            });
          }
        }
        // normal behavior
        let urlProm = resolve(req.originalUrl, config)
        urlProm.then(url => {
          console.log(url)
          options = {
              uri: url,
              encoding: null,
              method: req.method,
              resolveWithFullResponse: true
          }
          if (req.method != "GET") {
              options.body = req.body;
              options.json = true;
          }
          var resource = rp(options);
          resource.then(response => {
              res.set(response.headers)
              res.header("Access-Control-Allow-Origin", "*");
              res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
              res.send(response.body)
          });
          resource.catch(e => {
              res.header("Access-Control-Allow-Origin", "*");
              res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
              res.status(500).send(e)
          })
        })
        urlProm.catch(e => {
          res.header("Access-Control-Allow-Origin", "*");
          res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
          res.status(500).send(e)
        })
    })

app.listen(4010, () => console.log('listening on 4010'))
